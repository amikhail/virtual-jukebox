<?php
/**
 * MusicGateway
 * 
 * @author Alex Mikhail
 * @copyright 2013
 */

//TODO: create MediaGateway class

class MusicGateway {
    //private member data
    private $db = NULL;
    
    //constructor
    function __construct(){
        //initialize
        $this->db = new Database();
    }
    
    function getMusic($songTitle='', $albumTitle='', $artist='', $genreIdList='', $musicIdList=''){
        
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
        if(strlen($songTitle)){
            $sqlStmt .= " AND mu.songTitle LIKE '%" . $this->db->escapeString($songTitle) . "%'";
        }
        if(strlen($albumTitle)){
            $sqlStmt .= " AND mu.albumTitle LIKE '%" . $this->db->escapeString($albumTitle) . "%'";
        }
        if(strlen($artist)){
           $sqlStmt .= " AND mu.albumTitle LIKE '%" . $this->db->escapeString($artist) . "%'";
        }
        if(strlen($genreIdList)){
            $sqlStmt .= ' AND me.genre_mediaType_id IN (' . $this->db->escapeString($genreIdList) . ')';
        }
        if(strlen($musicIdList)){
            $sqlStmt .= ' AND me.musicId IN (' . $this->db->escapeString($musicIdList) . ')';
        }
        
        $rs = $this->db->executeSelect($sqlStmt);
        return $rs;
    }
        
    //destructor
    function __destruct(){
        //clean-up
    }
}
?>