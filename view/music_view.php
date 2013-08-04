<html>
<head></head>
<body>

<span class="">Song Title:</span> <?php echo($music->getSongTitle()); ?><br/>
<span class="">Album Title:</span> <?php echo($music->getAlbumTitle()); ?><br/>
<span class="">Artist:</span> <?php echo($music->getArtist()); ?><br/>
<span class="">Genre:</span> <?php echo($music->getGenre()); ?><br/>
<span class="">Year:</span> <?php echo($music->getYear()); ?><br/>
<span class="">File Type:</span> <?php echo($music->getFileType()); ?><br/>
<span class="">Play Length:</span> <?php echo($music->getPlayLength()); ?><br/>
<span class="">File Size:</span> ~<?php echo(Round($music->getFileSize() / 1024, 0)); ?> KB<br/>
<span class="">File Name:</span> <?php echo($music->getFileName()); ?><br/>
<span class="">Quality:</span> <?php echo($music->getQuality()); ?><br/>

</body>
</html>