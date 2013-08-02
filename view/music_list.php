<?php
/******************************************************************************
******************************************************************************/

require_once(DOC_ROOT . '/utility/FormControls.inc.php');
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html" />
	<meta name="" content="" />

	<title>Media List</title>
    <link type="text/css" rel="stylesheet" href="css/Jstyles.css"/>
</head>

<body>
    <form action="/index.php?section=music&action=search" method="POST" id="searchFilter">
        <table>
            <tr>
                <td>
                    <label for="songtitle" class="stitle">Song Title</label>
                </td>
                <td>
                    <input type="text" id="songtitle" name="songTitle" value="<?php echo($songTitle); ?>" />
                </td>
                <td>
                    <label for="albumtitle" class="atitle">Album Title</label>
                </td>
                <td>
                    <input type="text" id="albumtitle" name="albumTitle" value="<?php echo($albumTitle); ?>" />
                </td>
            </tr>
        </div>
        <div>
            <tr>
                <td>
                    <label for="artist" class="art">Artist</label>
                </td>
                <td>
                    <input type="text" id="artist" name="artist" value="<?php echo($artist); ?>" />
                </td>
                <td>
                    <label for="genre" class="art">genre</label>
                </td>
                <td>
                    <?php echo( FormControls::createSelect($genres, $genreId, 'genreId', 'genre_mediaType_id', 'genreDisplayLabel', '', 'genreId') ) ?>  
                </td>
            </tr>
	    <tr>
		<td colspan="4">
			<input type="submit" name="submit" value="Search" />
			<input type="reset" name="reset" value="Clear Filter"
		</td>
	    </tr>
        </table>
    </form>	
	
    <table>
	<tr>
		<th>Song Title</th>
		<th>Album Title</th>
		<th>Genre</th>
		<th colspan="3"></th>
	</tr>
	<?php while($musics && $musics->num_rows && $row = $musics->fetch_assoc()){ ?>
	<tr>
		<td><?php echo($row['songTitle']); ?></td>
		<td><?php echo($row['albumTitle']); ?></td>
		<td><?php echo($row['genreDisplayLabel']); ?></td>
		<td><a href="/index.php?section=music&action=view">View</a></td>
		<td><a href="/index.php?section=music&action=editForm1&musicId=<?php echo($row['musicId']); ?>">Edit</a></td>
		<td><a href="/index.php?section=music&action=deleteForm&musicId=<?php echo($row['musicId']); ?>">Delete</a></td>
		
	</tr>
	<?php } ?>
    </table>
</body>
</html>