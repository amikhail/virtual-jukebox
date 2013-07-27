<?php
/**
 * GenreGateway
 * 
 * @author Alex Mikhail
 * @copyright 2013
 */

require_once(DOC_ROOT . '/utility/Database.inc.php');

class GenreGateway {
    //private member data
    private $db = NULL;
    private $rs = NULL;
    
    //constructor
    function __construct(){
        //initialize
        $this->db = new Database();
    }
    
    //get all a result set of genres
    //with optional input to limit by media type
    function getGenres($mediaTypeId=''){
        $sqlStmt = 'SELECT * FROM genre_mediaType gmt ';
        $sqlStmt .= 'INNER JOIN grenre g ON g.genreId=gmt.genreId ';
        $sqlStmt .= 'WHERE 1=1 ';        
        if(strlen($mediaTypeId)){
            $sqlStmt .= 'AND mediaTypeId = ' . $mediaTypeId;
        }
        
        $this->rs = $this->db->executeSelect($sqlStmt);
        return $this->rs;
    }
    
    //dumps class instance to screen
    public function debug(){
        var_dump($this);
    }
        
    //destructor
    function __destruct(){
        //clean-up
        unset($this->db);
    }
}
?>