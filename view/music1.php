<?php
/******************************************************************************
required MusicRecord object (as $music)
******************************************************************************/

require_once(DOC_ROOT . '/utility/FormControls.inc.php');
?>

<html>
    <head></head>
    <body>
        <div id="step1">
            <form id="step1form" action="/index.php?section=music&action=createProcess1" method="POST" enctype="multipart/form-data">
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
                        <td colspan="3" style="align: right;"><input type="submit" value="Upload File" id="section1submit" /></td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>