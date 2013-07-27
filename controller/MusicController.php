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

class MusicController {
    //private member data
    
    //constructor
    function __construct(){
        //initialize
    }
    
    public function search(){
        $genres = new GenreGateway();
        $rsGenres = $genres->getGenres();
                
        require_once(DOC_ROOT . '/view/music_list_view.php');
    }
    
    public function create(){
        $genres = new MusicRecord();
                
        require_once(DOC_ROOT . '/view/music_view.php');
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