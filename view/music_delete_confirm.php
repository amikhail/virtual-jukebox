<html>
    <head></head>
    <body>
        Do you wish to delete the following music?<br/>
        File Name: <?php echo($music->getFileName()); ?><br/>
        Song Title: <?php echo($music->getSongTitle()); ?><br/>
        Album Title: <?php echo($music->getAlbumTitle()); ?><br/>
        <a href="/index.php?section=music&action=delete&musicId=<?php echo($musicId); ?>">Yes</a> <a href="/index.php?section=music&action=search">No</a><br/>
    </body>
</html>