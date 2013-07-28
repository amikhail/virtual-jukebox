<?php
/******************************************************************************
required MusicRecord object (as $music)
******************************************************************************/

require_once(DOC_ROOT . '/utility/FormControls.inc.php');
?>

<html>
    <head></head>
    <body>
        <div id="section1">
            <form id="section1form">
                <table border="1">
                    <tr>
                        <td>1.</td>
                        <td colspan="2">Upload the music file.</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td><input type="file" name="musicFile" /></td>
                        <td></td>
                    </tr>
                    
                    <input type="hidden" name="section1complete" value="1" />
                    
                    <tr>
                        <td colspan="3" style="align: right;"><input type="button" value="Upload File" id="section1submit" /></td>
                    </tr>
                </table>
            </form>
        </div>
        
        <div id="section2">
            <form id="section1form">
                <table border="1">
                    <tr>
                        <td>2.</td>
                        <td colspan="2">Enter the music metadata.</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>Song Title</td>
                        <td><input type="text" name="songTitle" value="<?php echo($music->getSongTitle()) ?>" /></td>                        
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>Album Title</td>
                        <td><input type="text" name="albumTitle" value="<?php echo($music->getAlbumTitle()) ?>" /></td>                        
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>Artist</td>
                        <td><input type="text" name="artist" value="<?php echo($music->getArtist()) ?>" /></td>                        
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>Genre</td>
                        <td><?php echo( FormControls::createSelect($genres, $music->getGenre_mediaType_id(), 'genreId', 'genre_mediaType_id', 'genreDisplayLabel', '', 'genreId') ) ?></td>                        
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>Year</td>
                        <td><input type="text" name="year" value="<?php echo($music->getYear()) ?>" /></td>                        
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>File Type</td>
                        <td><?php echo( FormControls::createSelect($fileTypes, $music->getFileType_mediaType_id(), 'fileTypeId', 'fileType_mediaType_id', 'fileTypeDisplayLabel', '', 'fileTypeId') ) ?></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>Play Length</td>
                        <td><input type="text" name="playLength" value="<?php echo($music->getPlayLength()) ?>" /></td>                        
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>File Size</td>
                        <td><input type="text" name="fileSize" value="<?php echo($music->getFileSize()) ?>" /></td>                        
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>File Name</td>
                        <td><input type="text" name="fileName" value="<?php echo($music->getFileName()) ?>" readonly /></td>                        
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>Quality</td>
                        <td><?php echo( FormControls::createSelect($qualities, $music->getQuality_mediaType_id(), 'qualityId', 'quality_mediaType_id', 'qualityDisplayLabel', '', 'qualityId') ) ?></td>                        
                    </tr>
                    
                    <input type="hidden" name="section2complete" value="1" />
                    
                    <tr>
                        <td colspan="3" style="align: right;"><input type="button" value="Save Music" id="section2submit" /></td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>