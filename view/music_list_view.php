<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html" />
	<meta name="Muzz" content="" />

	<title>Media List</title>
    <link type="text/css" rel="stylesheet" href="css/Jstyles.css"/>
</head>

<body>
    <form action="/controller/music_list_controller.php" method="post" id="searchFilter">
        <table>
            <tr>
                <td>
                    <label for="songtitle" class="stitle">Song Title</label>
                </td>
                <td>
                    <input type="text" id="songtitle" name="songtitle" />
                </td>
                <td>
                    <label for="albumtitle" class="atitle">Album Title</label>
                </td>
                <td>
                    <input type="text" id="albumtitle" name="albumtitle" />
                </td>
            </tr>
        </div>
        <div>
            <tr>
                <td>
                    <label for="artist" class="art">Artist</label>
                </td>
                <td>
                    <input type="text" id="artist" name="artist" />
                </td>
                <td>
                    <label for="genre" class="art">genre</label>
                </td>
                <td>
                    <select name="genreId" id="genreId">
                        <?php
                        while($rsGenres && $rsGenres->num_rows && $row = $rsGenres->fetch_assoc()){
                            echo('<option value=' . $row["genre_mediaTypeId"] . '>'.$row["genreName"].'</option>');
                        }
                        ?>
                    </select>
                </td>
            </tr>
        </table>
    </form>

</body>
</html>