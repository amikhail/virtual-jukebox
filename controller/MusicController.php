<?php
/**
 * MusicController
 * 
 * @author Alex Mikhail
 * @copyright 2013
 */

require_once(DOC_ROOT . '/model/GenreGateway.inc.php');
require_once(DOC_ROOT . '/model/QualityGateway.inc.php');
require_once(DOC_ROOT . '/model/FileTypeGateway.inc.php');
require_once(DOC_ROOT . '/model/MusicRecord.inc.php');
require_once(DOC_ROOT . '/model/MusicGateway.inc.php');

class MusicController {
    //private member data
    
    //constructor
    function __construct(){
        //initialize
    }
    
    public function search(){
        $albumTitle = (isset($_REQUEST['albumTitle']))? $_REQUEST['albumTitle'] : '' ;
        $songTitle = (isset($_REQUEST['songTitle']))? $_REQUEST['songTitle'] : '' ;
        $artist = (isset($_REQUEST['artist']))? $_REQUEST['artist'] : '' ;
        $genreId = (isset($_REQUEST['genreId']))? $_REQUEST['genreId'] : '' ;
        
        $g = new GenreGateway();
        $genres = $g->getGenres();
        
        $m = new MusicGateway();
        $musics = $m->getMusic($songTitle, $albumTitle, $artist, $genreId);
        require_once(DOC_ROOT . '/view/music_list.php');
    }
    
    public function view(){
        $musicId = (isset($_REQUEST['musicId']))? $_REQUEST['musicId'] : 0 ;
        
        $music = new MusicRecord();
        $music->loadRecord($musicId);
    }
    
    //STEP 1 begin: select music file upload
    public function createForm1(){
        //get dropdown values from lookup tables
        $g = new GenreGateway();
        $ft = new FileTypeGateway();
        $q = new QualityGateway();
               
        $genres = $g->getGenres();
        $fileTypes = $ft->getFileTypes();
        $qualities = $q->getQualities();
        
        $_SESSION['musicRecord'] = new MusicRecord();
        $music =& $_SESSION['musicRecord'];
        require_once(DOC_ROOT . '/view/music1.php');
    }
    
    //STEP 1 end: process music file upload
    //process file via AJAX call and returns meta-data in JSON
    public function createProcess1(){
        $error = false;
        $errMsg = '';
        
        if( !isset($_SESSION['musicRecord']) ){ 
            $errMsg = urlencode('There was an internal application error, please try uploading the file again.');
            $error = true; //FAIL; music record not found in session
        }elseif( !isset($_FILES["musicFile"]) ){
            $errMsg = urlencode('The music file failed to upload.  Please try again.');
            $error = true; //FAIL
        }elseif( $_FILES["musicFile"]["error"] == UPLOAD_ERR_INI_SIZE || $_FILES["musicFile"]["error"] == UPLOAD_ERR_FORM_SIZE ){
            $errMsg = urlencode('The file was too large.  Please try again.');
            $error = true; //FAIL
        }elseif( $_FILES["musicFile"]["error"] == UPLOAD_ERR_PARTIAL ){
            $errMsg = urlencode('The file upload was interrupted before completion.  Please try again.');
            $error = true; //FAIL
        }elseif( $_FILES["musicFile"]["error"] == UPLOAD_ERR_NO_FILE ){
            $errMsg = urlencode('No file was uploaded.  Please try again.');
            $error = true; //FAIL
        }elseif( $_FILES["musicFile"]["error"] == UPLOAD_ERR_NO_TMP_DIR ){
            $errMsg = urlencode('The folder that temporarily holds file uploads was not found.  Please contact your systems administrator for help.');
            $error = true; //FAIL
        }elseif( $_FILES["musicFile"]["error"] == UPLOAD_ERR_CANT_WRITE ){
            $errMsg = urlencode('The application does not have write permissions to the upload folder.  Please contact your systems administrator for help.');
            $error = true; //FAIL
        }elseif( $_FILES["musicFile"]["error"] == UPLOAD_ERR_EXTENSION ){
            $errMsg = urlencode('Another php extension conflicted with the file upload.  Please contact your systems administrator for help.');
            $error = true; //FAIL
        }elseif( $_FILES["musicFile"]["error"] != UPLOAD_ERR_OK ){
            $errMsg = urlencode('The music file failed to upload.  Please try again.');
            $error = true; //FAIL
        }
        
        if(!$error){
            //move upload file to upload directory
            $fullFilePath = MUSIC_UPLOAD_DIR . $_FILES["musicFile"]["name"];        
            $moveResult = move_uploaded_file($_FILES["musicFile"]["tmp_name"], $fullFilePath);
            $fileSize = $_FILES["musicFile"]["size"];
            
            if(!$moveResult){
                $errMsg = urlencode('Unable to save the music file to the upload directory.  Please try again.');
                $error = true; //FAIL; upload file move failed
            }
        }
    
        if(!$error){
            $_SESSION['musicRecord']->setFilePath($fullFilePath);
            $_SESSION['musicRecord']->setFileSize($fileSize);
            
            //TODO: extract and set meta-data
            
            header( 'Location: index.php?section=music&action=createForm2' ); //SUCCESS
        }else{
            header( 'Location: index.php?section=music&action=createForm1&errMsg=' . $errMsg ); //FAIL
        }    
    }
    
    //STEP 2 begin: enter meta-data
    public function createForm2(){
        //get dropdown values from lookup tables
        $g = new GenreGateway();
        $ft = new FileTypeGateway();
        $q = new QualityGateway();
        
        $genres = $g->getGenres();
        $fileTypes = $ft->getFileTypes();
        $qualities = $q->getQualities();
        
        if(!isset($_SESSION['musicRecord']) ){
            $errMsg = urlencode('There was an internal application error, please try uploading the file again.');
            header( 'Location: index.php?section=music&action=createForm1&errMsg=' . $errMsg );
        }else{
            $music =& $_SESSION['musicRecord'];
            require_once(DOC_ROOT . '/view/music2.php');
        }
    }
    
    //STEP 2 end: save meta-data
    public function createProcess2(){
        
        if( !isset($_SESSION['musicRecord']) ){ 
            $errMsg = urlencode('There was an internal application error, please try uploading the file again.');
            header( 'Location: index.php?section=music&action=createForm1' );
            return; //FAIL; music record not found in session
        }
        
        $_SESSION['musicRecord']->setSongTitle($_REQUEST["songTitle"]);
        $_SESSION['musicRecord']->setAlbumTitle($_REQUEST["albumTitle"]);
        $_SESSION['musicRecord']->setArtist($_REQUEST["artist"]);
        $_SESSION['musicRecord']->setGenre_mediaType_id($_REQUEST["genreId"]);
        $_SESSION['musicRecord']->setYear($_REQUEST["year"]);
        $_SESSION['musicRecord']->setFileType_mediaType_id($_REQUEST["fileTypeId"]);
        $_SESSION['musicRecord']->setPlayLength($_REQUEST["playLength"]);
        $_SESSION['musicRecord']->setQuality_mediaType_id($_REQUEST["qualityId"]);
        
        if($_SESSION['musicRecord']->validate()){
            $saveResult = $_SESSION['musicRecord']->save();
            echo('saveResult: ' . $saveResult);
            //unset($_SESSION['musicRecord']);
            //header( 'Location: index.php?section=music&action=search' ); //SUCCESS
        }else{
            header( 'Location: index.php?section=music&action=createForm2' ); //FAIL; did not validate
        }
    }
    
    //dumps class instance to screen
    public function debug(){
        var_dump($this);
    }
        
    //destructor
    function __destruct(){
        //clean-up
    }
}
?>