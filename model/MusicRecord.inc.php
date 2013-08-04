<?php
/**
 * MusicRecord
 * 
 * @author Alex Mikhail
 * @copyright 2013
 */

//TODO: create MediaRecord class

class MusicRecord {
    //private member data
    private $musicId = 0;
    private $mediaId = 0;
    private $mediaTypeId = 1;
    private $genre_mediaType_id = 0;
    private $fileType_mediaType_id = 0;
    private $quality_mediaType_id = 0;
    private $filePath = '';
    private $oldFilePath = '';              //for edits only; used to retreive previous filepath, when new file is uploaded during edit music process
    private $fileSize = 0;                  //in bytes
    private $playLength = 0;                //in seconds
    private $songTitle = '';
    private $albumTitle = '';
    private $artist = '';
    private $year = '';
    
    //for read-only accessor methods
    private $genreDisplayLabel = '';
    private $fileTypeDisplayLabel = '';
    private $qualityDisplayLabel = '';
    
    private $db = NULL;
    private $isError = false;
    private $errMsg = '';
    
    //constructor
    function __construct(){
        //initialize
        $this->db = new Database();
    }
    
    public static function loadMusic($musicId){
        $db = new Database();
        
        //input validation
        if(!isset($musicId) || !strlen($musicId)){
            die('musicId is a required parameter for MusicRecord->loadMusic'); //required parameter
        }
        
        $sqlStmt = 'SELECT mu.musicId AS musicId, ';
        $sqlStmt .= 'me.mediaId AS mediaId, ';
        $sqlStmt .= 'me.mediaTypeId AS mediaTypeId, ';
        $sqlStmt .= 'me.filePath AS filePath, ';
        $sqlStmt .= 'me.fileSize AS fileSize, ';
        $sqlStmt .= 'me.playLength AS playLength, ';
        $sqlStmt .= 'mu.songTitle AS songTitle, ';
        $sqlStmt .= 'mu.albumTitle AS albumTitle, ';
        $sqlStmt .= 'mu.artist AS artist, ';
        $sqlStmt .= 'me.fileType_mediaType_id AS fileType_mediaType_id, ';
        $sqlStmt .= 'ft.fileTypeDisplayLabel AS fileTypeDisplayLabel, ';
        $sqlStmt .= 'me.genre_mediaType_id AS genre_mediaType_id, ';
        $sqlStmt .= 'g.genreDisplayLabel AS genreDisplayLabel, ';
        $sqlStmt .= 'me.quality_mediaType_id AS quality_mediaType_id, ';
        $sqlStmt .= 'q.qualityDisplayLabel AS qualityDisplayLabel ';
        $sqlStmt .= 'FROM music mu ';
        $sqlStmt .= 'INNER JOIN media me ON mu.mediaId=me.mediaId ';
        $sqlStmt .= 'INNER JOIN fileType_mediaType ft_mt ON me.fileType_mediaType_id=ft_mt.fileType_mediaType_id ' ;
        $sqlStmt .= 'INNER JOIN genre_mediaType g_mt ON me.genre_mediaType_id=g_mt.genre_mediaType_id ';
        $sqlStmt .= 'INNER JOIN quality_mediaType q_mt ON me.quality_mediaType_id=q_mt.quality_mediaType_id ';
        $sqlStmt .= 'INNER JOIN filetype ft ON ft_mt.fileTypeId=ft.fileTypeId ';
        $sqlStmt .= 'INNER JOIN genre g ON g_mt.genreId=g.genreId ';
        $sqlStmt .= 'INNER JOIN quality q ON q_mt.qualityId=q.qualityId ';
        $sqlStmt .= 'WHERE 1=1';
        if(strlen($musicId)){
            $sqlStmt .= ' AND mu.musicId = ' . $musicId;
        }
        
        $rs = $db->executeSelect($sqlStmt);
        
        if($rs->num_rows > 0){
            $row = $rs->fetch_array();
            $music = new MusicRecord();
            $music->setMusicId($row["musicId"]);
            $music->setMediaId($row["mediaId"]);
            $music->setMediaTypeId($row["mediaTypeId"]);
            $music->setFileType_mediaType_id($row["fileType_mediaType_id"]);
            $music->setGenre_mediaType_id($row["genre_mediaType_id"]);
            $music->setQuality_mediaType_id($row["quality_mediaType_id"]);
            $music->setFilePath($row["filePath"]);
            $music->setOldFilePath($row["filePath"]);
            $music->setFileSize($row["fileSize"]);
            $music->setPlayLength($row["playLength"]);
            $music->setSongTitle($row["songTitle"]);
            $music->setAlbumTitle($row["albumTitle"]);
            $music->setArtist($row["artist"]);
            $music->setGenreDisplayLabel($row["genreDisplayLabel"]);
            $music->setFileTypeDisplayLabel($row["fileTypeDisplayLabel"]);
            $music->setQualityDisplayLabel($row["qualityDisplayLabel"]);
        }else{
            return NULL; //FAIL; unable to retrieve music record
        }
        
        $rs->close();
        
        return $music;
    }
    
    public static function deleteMusic($musicId){
        $db = new Database();
        
        //input validation
        if(!isset($musicId) || !strlen($musicId)){
            die('musicId is a required parameter for MusicRecord->loadMusic'); //required parameter
        }
        
        $music = MusicRecord::loadMusic($musicId);
        
        $mediaId = 0;
        if($music != NULL){
            $mediaId = $music->getMediaId();
        }
        
        $db->startTransaction();
        
        $deleteStmt = 'DELETE FROM music WHERE musicId=' . $db->escapeString($musicId);
        $result1 = $db->executeStmt($deleteStmt);
        
        if(!$result1){
            $db->rollbackTransaction();
            return false;
        }
        
        $deleteStmt = 'DELETE FROM media WHERE mediaId=' . $db->escapeString($mediaId);
        $result2 = $db->executeStmt($deleteStmt);
        
        $db->commitTransaction();
        
        return ($result1 && $result2);
    }
    
    function save(){
        if($this->musicId != 0){
            return $this->update();
        }else{
            return $this->create();
        }
    }
    
    function create(){
        $this->db = new Database();
        
        $this->db->startTransaction();
        
        $insertStmt = "INSERT INTO media(mediaTypeId, filePath, fileSize, playLength, ";
        $insertStmt .= "fileType_mediaType_id, genre_mediaType_id, quality_mediaType_id) ";
        $insertStmt .= "VALUES(" . $this->db->escapeString($this->mediaTypeId) . ",";
        $insertStmt .= "'" . $this->db->escapeString($this->filePath) . "',";
        $insertStmt .= $this->db->escapeString($this->fileSize) . ",";
        $insertStmt .= $this->db->escapeString($this->playLength) . ",";
        $insertStmt .= $this->db->escapeString($this->fileType_mediaType_id) . ",";
        $insertStmt .= $this->db->escapeString($this->genre_mediaType_id) . ",";
        $insertStmt .= $this->db->escapeString($this->quality_mediaType_id) . ")";
        $result1 = $this->db->executeStmt($insertStmt);
            
        if(!$result1){
            $this->isError = true;
            $this->errMsg = $this->db->getErrorMsg();
         
            echo('errMsg: ' . $this->errMsg);
         
            $this->db->rollbackTransaction();
            return false;
        }
        
        $this->mediaId = $this->db->getLastInsertId();
        
        $insertStmt = "INSERT INTO music(mediaId, songTitle, albumTitle, artist) ";
        $insertStmt .= "VALUES(" . $this->db->escapeString($this->mediaId) . ",";
        $insertStmt .= "'" . $this->db->escapeString($this->songTitle) . "',";
        $insertStmt .= "'" . $this->db->escapeString($this->albumTitle) . "',";
        $insertStmt .= "'" . $this->db->escapeString($this->artist) . "')";
        $result2 = $this->db->executeStmt($insertStmt);
        
        if(!$result2){
            $this->isError = true;
            $this->errMsg = $this->db->getErrorMsg();
         
            echo('errMsg: ' . $this->errMsg);
         
            $this->db->rollbackTransaction();
            return false;
        }else{
            $this->musicId = $this->db->getLastInsertId();
            $this->db->commitTransaction();
        }  
        
        return ($result1 && $result2);
    }
  
    function update(){
        $this->db = new Database();
        
        $this->db->startTransaction();
        
        $updateStmt = "UPDATE media ";
        $updateStmt .= " SET mediaTypeId=" . $this->db->escapeString($this->mediaTypeId) . ",";
        $updateStmt .= " filePath='" . $this->db->escapeString($this->filePath) . "',";
        $updateStmt .= " fileSize=" . $this->db->escapeString($this->fileSize) . ",";
        $updateStmt .= " playLength=" .$this->db->escapeString($this->playLength) . ",";
        $updateStmt .= " fileType_mediaType_id=" .$this->db->escapeString($this->fileType_mediaType_id) . ",";
        $updateStmt .= " genre_mediaType_id=" .$this->db->escapeString($this->genre_mediaType_id) . ",";
        $updateStmt .= " quality_mediaType_id=" .$this->db->escapeString($this->quality_mediaType_id);
        $updateStmt .= " WHERE mediaId =" . $this->db->escapeString($this->mediaId);
        $result1 = $this->db->executeStmt($updateStmt);
        
        if(!$result1){
            $this->isError = true;
            $this->errMsg = $this->db->getErrorMsg();
         
            echo('errMsg: ' . $this->errMsg);
         
            $this->db->rollbackTransaction();
            return false;
        }
        
        $updateStmt = "UPDATE music ";
        $updateStmt .= " SET mediaId=" . $this->db->escapeString($this->mediaId) . ",";
        $updateStmt .= " songTitle='" . $this->db->escapeString($this->songTitle) . "',";
        $updateStmt .= " albumTitle='" . $this->db->escapeString($this->albumTitle) . "',";
        $updateStmt .= " artist='" . $this->db->escapeString($this->artist) . "'";
        $updateStmt .= " WHERE musicId =" . $this->db->escapeString($this->musicId);
        $result2 = $this->db->executeStmt($updateStmt);
        
        if(!$result2){
            $this->isError = true;
            $this->errMsg = $this->db->getErrorMsg();
         
            echo('errMsg: ' . $this->errMsg);
         
            $this->db->rollbackTransaction();
            return false;
        }else{
            $this->db->commitTransaction();
        }
        
        return ($result1 && $result2);
    }
    
    function validate(){
        return true;
    }
    
    //BEGIN accessor methods
    function setMusicId($musicId){
        $this->musicId = $musicId;
    }
    function getMusicId(){
        return $this->musicId;
    }
    
    function setMediaId($mediaId){
        $this->mediaId = $mediaId;
    }
    function getMediaId(){
        return $this->mediaId;
    }
    
    function setMediaTypeId($mediaTypeId){
        $this->mediaTypeId = $mediaTypeId;
    }
    function getMediaTypeId(){
        return $this->mediaTypeId;
    }
    
    function setGenre_mediaType_id($genre_mediaType_id){
        $this->genre_mediaType_id = $genre_mediaType_id;
    }
    function getGenre_mediaType_id(){
        return $this->genre_mediaType_id;
    }
    
    //read-only property, set through lookup id
    private function setGenreDisplayLabel($genreDisplayLabel){
        $this->genreDisplayLabel = $genreDisplayLabel;
    }
    function getGenre(){
        return $this->genreDisplayLabel;
    }
    
    function setFileType_mediaType_id($fileType_mediaType_id){
        $this->fileType_mediaType_id = $fileType_mediaType_id;
    }
    function getFileType_mediaType_id(){
        return $this->fileType_mediaType_id;
    }
    
    
    //read-only property, set through lookup id
    private function setFileTypeDisplayLabel($fileTypeDisplayLabel){
        $this->fileTypeDisplayLabel = $fileTypeDisplayLabel;
    }
    function getFileType(){
        return $this->fileTypeDisplayLabel;
    }
    
    function setQuality_mediaType_id($quality_mediaType_id){
        $this->quality_mediaType_id = $quality_mediaType_id;
    }
    function getQuality_mediaType_id(){
        return $this->quality_mediaType_id;
    }
    
    //read-only property, set through lookup id
    private function setQualityDisplayLabel($qualityDisplayLabel){
        $this->qualityDisplayLabel = $qualityDisplayLabel;
    }
    function getQuality(){
        return $this->qualityDisplayLabel;
    }
    
    function setFilePath($filePath){
        $this->filePath = $filePath;
    }
    function getFilePath(){
        return $this->filePath;
    }
    
    private function setOldFilePath($oldFilePath){
        $this->oldFilePath = $oldFilePath;
    }
    function getFilePath(){
        return $this->oldFilePath;
    }
    
    function setFileSize($fileSize){
        $this->fileSize = $fileSize;
    }
    function getFileSize(){
        return $this->fileSize;
    }
    
    function setPlayLength($playLength){
        $this->playLength = $playLength;
    }
    function getPlayLength(){
        return $this->playLength;
    }
    
    function setSongTitle($songTitle){
        $this->songTitle = $songTitle;
    }
    function getSongTitle(){
        return $this->songTitle;
    }
    
    function setAlbumTitle($albumTitle){
        $this->albumTitle = $albumTitle;
    }
    function getAlbumTitle(){
        return $this->albumTitle;
    }
    
    function setArtist($artist){
        $this->artist = $artist;
    }
    function getArtist(){
        return $this->artist;
    }
    
    function setYear($year){
        $this->year = $year;
    }
    function getYear(){
        return $this->year;
    }
    
    //read-only property, derived from filePath
    function getFileName(){
        $filePathParts = explode(OS_DIR_SEPERATOR, $this->filePath);
        $arrLen = count($filePathParts);
        return $filePathParts[$arrLen-1];

    }
    //END accessor methods
        
    //destructor
    function __destruct(){
        //clean-up
    }
}
?>