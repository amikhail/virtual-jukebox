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

class MusicController {
    //private member data
    
    //constructor
    function __construct(){
        //initialize
    }
    
    public function search(){
        $genres = new GenreGateway();
        $rsGenres = $genres->getGenres();
                
        require_once(DOC_ROOT . '/view/music_list.php');
    }
    
    public function create(){
        //get dropdown values from lookup tables
        $g = new GenreGateway();
        $ft = new FileTypeGateway();
        $q = new QualityGateway();
               
        $genres = $g->getGenres();
        $fileTypes = $ft->getFileTypes();
        $qualities = $q->getQualities();
        
        //STEP 3: save music record
        if( isset($_REQUEST['section2complete']) && isset($_SESSION['musicRecord']) ){
          
            if($_SESSION['musicRecord']->validate()){
                $_SESSION['musicRecord']->save();
                unset($_SESSION['musicRecord']);
            }else{
                header( 'Location: index.php?section=music&action=create&section1complete=1' ) ;
            }
        
        //STEP 2: enter music meta-data
        }elseif( isset($_REQUEST['section1complete']) && isset($_SESSION['musicRecord']) ){
        
            $music =& $_SESSION['musicRecord'];
            require_once(DOC_ROOT . '/view/music.php');
           
        //STEP 1: upload music file
        }else{
            $_SESSION['musicRecord'] = new MusicRecord();
            
            $music =& $_SESSION['musicRecord'];
            require_once(DOC_ROOT . '/view/music.php');
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