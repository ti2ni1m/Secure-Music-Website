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
    <title>24/7 Music Search Page</title>
    <!-- The files of the styles css is the main Cascade file whilst the other css files are from the bootstrap website to enhance the UI design of the web page-->
    <link rel="stylesheet" href="css/styles.css">
    <!-- The file below is an external link of the validation of the search bar in JavaScript-->
    <script src="javascript/validate.js"></script>
</head>

<body>
<?php include('_header.php');
?>
    <main>
        <div class='search-form'>
            <?php 
            //Initial search variable
            $search = '';
            ?>
            <!--A form to search for albums, artists and songs-->
            <form action = "<?php echo $_SERVER['PHP_SELF']; ?>" method ="post" onsubmit="return validateForm(this);">
                <div class='input-box'>
                    <label for='search' id='search-label'>Search: </label>
                    <input type='text' name='search' id='search' value= '<?php echo $search; ?>'>
                    <br>
                    <span class="error-message" id="search-error">Search is required!!!</span>
                </div>
                <div class='input-box'>
                    <input type='submit' value='Search' name='submit'>
                </div>
            </form>
        </div>
        <div class ='search-result'>
            <?php
            //Connecting to the database
            require_once("conn.php");

            //Handling the search query if it works
            if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
                $search = isset($_POST['search']) ? htmlspecialchars(trim($_POST['search'])) : '';
            
                //Sanitising and getting the query and then executing it 
                $searchquery = "SELECT * FROM track WHERE track_title LIKE '%$search%'
                                OR artist_id IN (SELECT artist_id FROM artist WHERE artist_name LIKE '%$search%')
                                OR album_id IN (SELECT album_id FROM album WHERE album_name LIKE '%$search%')
                                OR track_id IN (SELECT track_id FROM track WHERE track_title LIKE '%$search%')";
                
                $searchresult = $connection->query($searchquery);
            
                //Search result is here if the search works successfully
                if($searchresult->num_rows > 0) {
                    echo '<div class=summary>';
                    echo '<h2>Search Results for "' . $search . '"</h2>';
            
                    $albums = [];
                    $artists = [];
                    $songs = [];
            
                    //A loop to show the results of the albums, artists and songs when searching from either these 3
                    while($rows = $searchresult->fetch_assoc()) {
                        $albums[$rows['album_id']] = getAlbumName($connection, $rows['album_id']);
                        $artists[$rows['artist_id']] = array(
                            'name' => getArtistName($connection, $rows['artist_id']),
                            'thumbnail' => getArtistThumbnail($connection, $rows['artist_id'])
                        );
                        $songs[$rows['track_id']] = $rows['track_title'];
                    }
            
                    echo '<div class="search-category">';
                    echo '<h3>Albums</h3>';
                    echo '<table width=100% border=1px style=border-color:white>';
                    echo '<th>Album Name</th>';
                    echo '<th>Artist Name</th>';
                    echo '<th></th>';
                    echo '<th>Details</th>';
                    foreach ($albums as $albumId => $albumName) {
                        echo '<tr class="search-result">';
                        echo '<td><h4><a href="play.php?album_id=' . $albumId . '">' . $albumName . '</a></h4></td>';
                        echo '<td>Artist: ' . getAlbumArtistName($connection, $albumId) . '</td>';
                        echo '<td><img src="' . getAlbumThumbnail($connection, $albumId) . '" width="106" height="106" alt="AlbumThumbnail"></td>';
                        echo '<td><a href="play.php?album_id=' . $albumId . '">View Album</a></td>';
                        echo '</tr>';
                    }
                    echo '</table>';
                    echo '</div>';
            
                    echo '<div class="search-category">';
                    echo '<h3>Artists</h3>';
                    echo '<table width=100% border=1px style=border-color:white>';
                    echo '<th>Artist Name</th>';
                    echo '<th></th>';
                    echo '<th>Details</th>';
                    foreach ($artists as $artistId => $artistName) {
                        echo '<tr class="search-result">';
                        echo '<td><h4><a href="play.php?artist_id=' . $artistId . '">' . $artistName['name'] . '</a></h4></td>';
                        echo '<td><img src="' . $artistName['thumbnail'] . '" width="106" height="106" alt="ArtistThumbnail"></td>';
                        echo '<td><a href="play.php?artist_id=' . $artistId . '">View Artist</a></td>';
                        echo '</tr>';
                    }
                    echo '</table>';
                    echo '</div>';
            
                    echo '<div class="search-category">';
                    echo '<h3>Songs</h3>';
                    echo '<table width=100% border=1px style=border-color:white>';
                    echo '<th>Song Name</th>';
                    echo '<th>Artist Name</th>';
                    echo '<th></th>';
                    echo '<th>Details</th>';
                    foreach ($songs as $trackId => $trackTitle) {
                        echo '<tr class="search-result">';
                        echo '<td><h4><a href="play.php?track_id=' . $trackId . '">' . $trackTitle . '</a></h4></td>';
                        echo '<td>Artist: ' . $artistName['name'] . '</td>';
                        echo '<td><img src="' . getTrackThumbnail($connection, $albumId, $artistId) . '" width="106" height="106" alt="Thumbnail"></td>';
                        echo '<td><a href="play.php?track_id=' . $trackId . '">Play Song</a></td>';
                        echo '</tr>';
                    }
                    echo '</table>';
                    echo '</div>';
            
                    echo '</div>';
                } else {
                    echo '<p>No such records found!</p>';
                }
            }


            //A function to show the name of the album
            function getAlbumName($connection, $albumId) {
                $albumquery = "SELECT album_name FROM album WHERE album_id = $albumId";
                $albumresult = $connection->query($albumquery);

                if($albumresult && $albumresult->num_rows > 0) {
                    $row = $albumresult->fetch_assoc();
                    return $row['album_name'];
                } else {
                    return "No Album";
                }
            }

            //A function to show the Artists' names with their respective albums
            function getAlbumArtistName($connection, $albumId) {
                $albumartistquery = "SELECT artist.artist_name FROM album 
                JOIN artist ON artist.artist_id = album.artist_id WHERE album.album_id = $albumId";
                $albumartistresult = $connection->query($albumartistquery);

                if($albumartistresult && $albumartistresult->num_rows > 0) {
                    $row = $albumartistresult->fetch_assoc();
                    return $row['artist_name'];
                } else {
                    return "No Artist";
                }
            
            }

            //A function to show the name of the Artist
            function getArtistName($connection, $artistId) {
                $artistquery = "SELECT artist_name FROM artist WHERE artist_id = $artistId";
                $artistresult = $connection->query($artistquery);

                if($artistresult && $artistresult->num_rows > 0) {
                    $row = $artistresult->fetch_assoc();
                    return $row['artist_name'];
                } else {
                    return "No Artist";
                }
            }

            //A function to show the thumbnail image of the album
            function getAlbumThumbnail($connection, $albumId) {
                $albumthumbquery = "SELECT thumbnail FROM album WHERE album_id = $albumId";
                $albumthumbresult = $connection->query($albumthumbquery);

                if($albumthumbresult && $albumthumbresult->num_rows > 0) {
                    $row = $albumthumbresult->fetch_assoc();
                    $file = $row['thumbnail'];
                    return "/twa/thumbs/albums/$file";
                }
            }

            //A function to join the tables of album, artist and tracks to match the songs of their respective albums
            function getTrackThumbnail($connection, $albumId, $artistId) {
                $trackthumbquery = "SELECT album.thumbnail FROM track 
                JOIN album ON track.album_id = album.album_id 
                JOIN artist ON track.artist_id = artist.artist_id
                WHERE track.album_id = $albumId AND track.artist_id = $artistId";
                $trackthumbresult = $connection->query($trackthumbquery);

                if($trackthumbresult && $trackthumbresult->num_rows > 0) {
                    $row = $trackthumbresult->fetch_assoc();
                    $file = $row['thumbnail'];
                    return "/twa/thumbs/albums/$file";
                }
            }

            //A function to show the thumbnail image of the artist
            function getArtistThumbnail($connection, $artistId) {
                $artistthumbquery = "SELECT thumbnail FROM artist WHERE artist_id = $artistId";
                $artistthumbresult = $connection->query($artistthumbquery);

                if($artistthumbresult && $artistthumbresult->num_rows > 0) {
                    $row = $artistthumbresult->fetch_assoc();
                    $file = $row['thumbnail'];
                    return "/twa/thumbs/artists/$file";
                }
            }
            ?>
        </div>
    </main>
</body>
</html>