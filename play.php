<?php
//I certify that all the works are on this page and others is my on work. Manan Bhatia 22035587

//Session starts to access the session variable
session_start();

//To check if the user is logged in and to retrieve the username and membership category
$logged = isset($_SESSION['who']);
if($logged) {
    $username = $_SESSION['who'];
    $categorymember = isset($_SESSION['category']) ? $_SESSION['category'] : 'Unknown';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>24/7 Music Play Page</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
<?php include('_header.php');
?>
    <main>
        <?php
        //connecting the database
        require_once('conn.php');

        //Displays the details of the albums, artists, tracks and playlists
        if(isset($_GET['album_id'])) {
            $albumId = intval($_GET['album_id']);
            showAlbum($connection, $albumId);
        }

        if(isset($_GET['artist_id'])) {
            $artistId = intval($_GET['artist_id']);
            showArtist($connection, $artistId);
        }

        if(isset($_GET['track_id'])) {
            $trackId = intval($_GET['track_id']);
            showTrack($connection, $trackId);
        }

        if(isset($_GET['playlist_id'])) {
            $playlistId = intval($_GET['playlist_id']);
            showPlaylistname($connection, $playlistId);
            showPlaylist($connection, $playlistId);
        }
        
        else {
            echo "<p>To play a song, please <a href='search.php'>search</a> album, artist or track or play one from your <a href='playlist.php'>playlist</a>.</p>";
        }
        //The full function of the details with the query and the given information for the selected album, artist, track and playlist
        function showArtist($connection, $artistId) {
            //A query to get the given detail for the respective artist
            $artistquery = "SELECT artist_name, thumbnail FROM artist WHERE artist_id = $artistId";
            $artistresult = $connection->query($artistquery);

            if($artistresult && $artistresult->num_rows > 0 ) {
                $artistrow = $artistresult->fetch_assoc();
                echo "<h2>{$artistrow['artist_name']}</h2>";
                if(!empty($artistrow['thumbnail'])) {
                    echo "<img src='/twa/thumbs/artists/{$artistrow['thumbnail']}' alt='ArtThumb'>";
                }

                //A query to get the details for the albums by the artist
                $albumquery = "SELECT album_id, album_name, album_date, thumbnail FROM album WHERE artist_id = $artistId";
                $albumresult = $connection->query($albumquery);

                if($albumresult && $albumresult->num_rows > 0) {
                    echo "<h3>Albums made by {$artistrow['artist_name']}: </h3>";
                    //A table of all the albums by the artist that was selected from the search page
                    echo '<table width=100% border=1px style=border-color:white>';
                    echo '<th>Album Name</th>';
                    echo '<th>Year Released</th>';
                    echo '<th></th>';
                    while($albumrow = $albumresult->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td><a href='play.php?album_id={$albumrow['album_id']}'>{$albumrow['album_name']}</a></td>";
                        echo "<td>Year: {$albumrow['album_date']}</td>";
                        if(!empty($albumrow['thumbnail'])) {
                            echo "<td><img src='/twa/thumbs/albums/{$albumrow['thumbnail']}' alt='AlbThumb'></td>";
                        }
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "No albums found for {$artistrow['artist_name']}";
                }
            } else {
                echo "No Artist was found";
            }
        }

        function showAlbum($connection, $albumId) {
            //A query to get the given detail for the respective album
            $albumsquery = "SELECT album.album_name, album.thumbnail, artist.artist_name FROM album
            INNER JOIN artist ON album.artist_id = artist.artist_id WHERE album.album_id = $albumId";
            $albumsresult = $connection->query($albumsquery);

            if($albumsresult && $albumsresult->num_rows > 0) {
                $albumsrow = $albumsresult->fetch_assoc();
                echo "<h2>{$albumsrow['album_name']}</h2>";
                echo "<p>{$albumsrow['artist_name']}</p>";
                echo "<img src='/twa/thumbs/albums/{$albumsrow['thumbnail']}' alt='AlbThumb'>";
                

                //A query to get the details for the songs by the ablums
                $trackquery = "SELECT track_id, track_title, track_length FROM track WHERE album_id = $albumId";
                $trackresult = $connection->query($trackquery);

                if($trackresult && $trackresult->num_rows > 0) {
                    echo "<h3>The songs in album {$albumsrow['album_name']}: </h3>";
                    //A table of all the songs by the album which was selected from the search page or from the artist
                    echo "<table width=100% border=1px style=border-color:white>";
                    echo "<th>Songs</th>";
                    echo "<th>Song Length</th>";
                    while($trackrow = $trackresult->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td><a href='play.php?track_id={$trackrow['track_id']}'>{$trackrow['track_title']}</a></td>";
                        echo "<td><span style='color: white;'>{$trackrow['track_length']}</span></td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "No song found in album {$albumsrow['album_row']}";
                }
            } else {
                echo "No such Album was found.";
            }
        }

        function showPlaylistname($connection, $playlistId) {
            //A query to get the details for the playlist name
            $playlistnamequery = "SELECT playlist_name FROM memberplaylist WHERE playlist_id = $playlistId";
            $playlistnameresult = $connection->query($playlistnamequery);

            if($playlistnameresult && $playlistnameresult->num_rows > 0 ) {
                $playlistnamerow = $playlistnameresult->fetch_assoc();
                echo "<h2>{$playlistnamerow['playlist_name']}</h2>";

            }
        }

        function showPlaylist($connection, $playlistId) {
            //A query to get the deatails of all the songs of the selected playlist
            $playlistquery = "SELECT track.*, memberplaylist.*, artist.* 
            FROM playlist INNER JOIN memberplaylist ON playlist.playlist_id = memberplaylist.playlist_id
            INNER JOIN track ON playlist.track_id = track.track_id 
            INNER JOIN artist ON track.artist_id = artist.artist_id WHERE memberplaylist.playlist_id = $playlistId";
            $playlistresult = $connection->query($playlistquery);

            if($playlistresult && $playlistresult->num_rows > 0 ) {
                //A list of all the songs by the specific playlist
                echo "<table width=100% border=1px style=border-color:white;>";
                echo "<th>Songs</th>";
                echo "<th>Song Length</th>";
                echo "<th>Artist</th>";
                while($playlistrow = $playlistresult->fetch_assoc()) {
                    //echo $playlistrow;
                    echo "<tr>";
                    echo "<td><a href='play.php?track_id={$playlistrow['track_id']}'>{$playlistrow['track_title']}</a></td>";
                    echo "<td><span style='color: white;'>{$playlistrow['track_length']}</span></td>";
                    echo "<td><span style='color: white;'>{$playlistrow['artist_name']}</span></td>";
                    echo "</tr>";
                }
                echo "</table>";

            }
        }

        function showTrack($connection, $trackId) {
            //A query to get the given details for the respective song
            $tracksquery = "SELECT track.track_title, track.track_length, track.spotify_track, album.album_name 
            FROM track INNER JOIN album ON track.album_id = album.album_id WHERE track.track_id = $trackId";
            $tracksresult = $connection->query($tracksquery);
            if($tracksresult && $tracksresult->num_rows > 0) {
                $tracksrow = $tracksresult->fetch_assoc();
                //A detail of the selected song with the name of it, length of the song and an iframe of the song which linked to spotify
                echo "<h2>{$tracksrow['track_title']}</h2>";
                echo "<p>Album: {$tracksrow['album_name']}</p>";
                echo "<p>Length of the song: {$tracksrow['track_length']}</p>";
                echo "<iframe src='https://open.spotify.com/embed/track/{$tracksrow['spotify_track']}'
                    width='380' height='380' frameborder='0'
                    allowtransparency='true' allow='encrypted-media'>
                   </iframe>";
                
                //Displaying the selection of the playlist of the user if logged in
                if(isset($_SESSION['who'])) {
                    $memberId = $_SESSION['userid']; 
                ?>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <label for="playlist_select">Select Playlist:</label>
                        <select id="playlist_select" name="playlist_select" required>
                    <?php 
                        require_once('conn.php');
                        // Retrieving the playlists to the logged-in member, if not logged in, then it is not shown
                        $query = "SELECT playlist_id, playlist_name FROM memberplaylist WHERE member_id = $memberId";
                        $result = $connection->query($query);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<option value='{$row['playlist_id']}'>{$row['playlist_name']}</option>";
                            }
                        } else {
                            echo "<option value=''>No playlists found</option>";
                        }
                    ?>
                        </select>
                        <input type="hidden" name="trackid" id="trackid" value="<?php echo $trackId ?>">
                        <input type="submit" value="Add to Playlist" name="add_to_playlist">
                    </form>
                    
        <?php
                }
            } else {
                echo "No Song is here";
            }
        }

        //To check if the form is able to add the song to the playlist, if it works, then the query inserts a new id into the playlist and the database table
        if(isset($_POST["add_to_playlist"])) {
            $playId = $_POST["playlist_select"];
            $trackId = $_POST["trackid"];
            $playquery = "INSERT INTO playlist (playlist_id, track_id) VALUES ('$playId', '$trackId')";
            if($connection->query($playquery) === TRUE) {
                echo "<p>Song has been successfully added to the playlist</p>";
            } else {
                echo "Error: " . $playquery . "<br>" . $connection->error;
            }
        }

        ?>
    </main>
</body>
</html>
