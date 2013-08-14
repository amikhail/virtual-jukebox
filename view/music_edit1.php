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
            <?php if($edit){ ?>
                <a href="/index.php?section=music&action=editForm1&musicId=<?php echo($music->getMusicId()); ?>">Go back to updating the form metadata.</a>
            <?php } ?>
            
            <?php if($edit){ ?>
                <form id="uploadForm" action="/index.php?section=music&action=editProcess2" method="POST" enctype="multipart/form-data">
            <?php } else { ?>
                <form id="uploadForm" action="/index.php?section=music&action=createProcess1" method="POST" enctype="multipart/form-data">
            <?php } ?>
            
                <table border="0">
                    <tr>
                        <?php if($edit){ ?>
                            <td>2.</td>
                            <td colspan="2">Upload a new music file.</td>
                        <?php } else { ?>
                            <td>1.</td>
                            <td colspan="2">Upload the music file.</td>
                        <?php } ?>
                    </tr>
                    <?php if($edit){ ?>
                        <tr>
                            <td>&nbsp;</td>
                            <td>The current music file is:</td>
                            <td><?php echo($music->getFileName()); ?></td>
                        </tr>    
                    <?php } ?>
                    <tr>
                        <td>&nbsp;</td>
                        <td><input type="file" name="musicFile" /></td>
                        <td></td>
                    </tr>
                    
                    <?php if($edit){ ?>
                        <input type="hidden" name="musicId" value="<?php echo($music->getMusicId()) ?>" />
                    <?php } ?>
                    
                    <tr>
                        <td colspan="3" style="align: right;"><input type="submit" value="Upload File" id="section1submit" /></td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>