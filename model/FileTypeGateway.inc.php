<?php
/**
 * FileTypeGateway
 * 
 * @author Alex Mikhail
 * @copyright 2013
 */

require_once(DOC_ROOT . '/utility/Database.inc.php');

class FileTypeGateway {
    //private member data
    private $db = NULL;
    private $rs = NULL;
    
    //constructor
    function __construct(){
        //initialize
        $this->db = new Database();
    }
    
    //get all a result set of fileTypes
    //with optional input to limit by media type
    function getFileTypes($mediaTypeId=''){
        $sqlStmt = 'SELECT * FROM fileType_mediaType ftmt ';
        $sqlStmt .= 'INNER JOIN fileType ft ON ft.fileTypeId=ftmt.fileTypeId ';
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