<?php
/**
 * index.php
 * 
 * @author Alex Mikhail
 * @copyright 2013
 * 
 * section = subsystem (controller) you want to use
 * action = page/function in system you want to perform
 * debug -> add this query string parameter if you want to display debug info
 * 
 * Example:
 * http://jukebox.net/index.php?section=music&action=search&debug=1
 * calls MusicController->search() w/ debug info at end of page
 */ 
define('DOC_ROOT', $_SERVER['DOCUMENT_ROOT']);

//include config parameters
require_once(DOC_ROOT . '/utility/Config.inc.php'); 

//include controller files
require_once(DOC_ROOT . '/controller/MusicController.php');

//session management initialization
session_start();

//initialize controllers
$musicCtlr = new MusicController();

//pull section + action vars from HTTP request
$GLOBALS['section'] = '';   //default section
if(isset($_REQUEST['section'])){
    $GLOBALS['section'] = $_REQUEST['section'];
}

$GLOBALS['action'] = '';   //default action
if(isset($_REQUEST['action'])){
    $GLOBALS['action'] = $_REQUEST['action'];    
}

switch($GLOBALS['section']){
    case 'music': $musicCtlr->$GLOBALS['action'](); break;
}

//display debug info
if(isset($_REQUEST['debug'])){
    debug();
}

function debug(){
    echo('Section: ' . $_GLOBALS['section'] . '<br/>');
    echo('Action: ' . $_GLOBALS['action'] . '<br/>');
    $musicCtlr->debug();
    echo('<br/>');
}
?>