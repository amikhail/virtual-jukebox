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
    private $musicRS = NULL;
    
    private $mediaId = 0;
    private $mediaTypeId = 0;
    private $genre_mediaType_id = 0;
    private $fileType_mediaType_id = 0;
    private $quality_mediaType_id = 0;
    private $musicId = 0;
    private $fileName = '';
    private $fileSize = 0;                  //in bytes
    private $playLength = 0;                //in seconds
    private $songTitle = '';
    private $albumTitle = '';
    private $artist = '';
    
    //constructor
    function __construct(){
        //initialize
    }
        
    //destructor
    function __destruct(){
        //clean-up
    }
}
?>