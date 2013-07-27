<?php

/**
 * @author 
 * @copyright 2013
 */

echo(phpversion() . '<br/>');

//$DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];
define('DOC_ROOT', $_SERVER['DOCUMENT_ROOT']);

require_once(DOC_ROOT . '/utility/Database.inc.php');
require_once(DOC_ROOT . '/model/GenreGateway.inc.php');
require_once(DOC_ROOT . '/model/QualityGateway.inc.php');
require_once(DOC_ROOT . '/model/FileTypeGateway.inc.php');

$db = new Database();

$rs = $db->executeSelect('SELECT * FROM mediaType');
while(!$db->isError() && $rs->num_rows && $row = $rs->fetch_assoc()){
     printf ("ID: %d Name: %s<br/>\n", $row["mediaTypeId"], $row["mediaTypeName"]);
}

$db->debug();

//get genres
$genreList = new GenreGateway();
$rs = $genreList->getGenres();
while($rs && $rs->num_rows && $row = $rs->fetch_assoc()){
    printf ("ID: %d Name: %s<br/>\n", $row["genre_mediaTypeId"], $row["genreName"]);
}

$genreList->debug();

//get qualities
$qualityList = new QualityGateway();
$rs = $qualityList->getQualities();
while($rs && $rs->num_rows && $row = $rs->fetch_assoc()){
    printf ("ID: %d Name: %s<br/>\n", $row["quality_mediaTypeId"], $row["qualityName"]);
}

$qualityList->debug();

//get genres
$fileTypeList = new FileTypeGateway();
$rs = $fileTypeList->getFileTypes();
while($rs && $rs->num_rows && $row = $rs->fetch_assoc()){
    printf ("ID: %d Name: %s<br/>\n", $row["fileType_mediaTypeId"], $row["fileTypeName"]);
}

$fileTypeList->debug();
?>