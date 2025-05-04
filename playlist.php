<?php
//I certify that all the works are on this page and others is my on work. Manan Bhatia 22035587

//A separate file called nocache to not allow duplication of the data in the login
require_once('nocache.php');
//Session starts to access the session variable
session_start();

//To check if the user is logged in and to retrieve the username and membership category
$logged = isset($_SESSION['who']);
if($logged) {
    $username = $_SESSION['who'];
    $categorymember = isset($_SESSION['category']) ? $_SESSION['category'] : 'Unknown';
}

//Redirects the page out if user is not logged in
if(!$_SESSION["who"]) {
    header("location: logout.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>24/7 Music Playlist</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
<?php include('_header.php');
?>
    <main>
        <!-- A form to create a new playlist --> 
        <h2>Create New Playlist</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="playlist_name">Playlist Name: </label>
            <input type = "text" id="playlist_name" name="playlist_name" placeholder="Enter the name of your playlist" required>
            <input type="submit" value="Create Playlist" name="submit">
        </form>

        <?php
        //To check if the form is able to create a playlist, if it works then the query inserts a new id into the memberplaylist
        $memberId = $_SESSION['userid'];
        if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
            $playlistname = trim($_POST['playlist_name']);
            if(!preg_match("/^[a-zA-Z0-9 ]*$/", $playlistname)) {
                echo "<p>Playlist name needs to be in alphanumeric characters and spaces.</p>";
            } else {
                require_once("conn.php");
                //$query = $connection->prepare("INSERT INTO memberplaylist (member_id, playlist_name) VALUES ($memberId, $playlistname)");
                //$query->bind_param($memberId);
                //$query->bind_param($playlistname);
                //if($query->execute()) {
                //    echo "<p>Playlist has been created</p>";
                //} 
                $query = "INSERT INTO memberplaylist (member_id, playlist_name) VALUES ('$memberId', '$playlistname')";
                if ($connection->query($query) === TRUE) {
                    echo "<p>New record created successfully</p>";
                  } else {
                    echo "Error: " . $query . "<br>" . $connection->error;
                  }
                  
                  //$connection->close();

            }
        }
        ?>

        <h2>Add Song to Playlist</h2>
        <!-- Form to add a song to a playlist -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label for="playlist_select">Select Playlist:</label>
                <select id="playlist_select" name="playlist_select" required>
                <?php 
                require_once('conn.php');
            // Retrieving the playlists where the logged-in members can see their playlists
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
                <label for="track_id">Track ID:</label>
                <input type="text" id="track_id" name="track_id" placeholder="Enter Track ID" required>
                <input type="submit" value="Add to Playlist" name="add_to_playlist">
        </form>

        <?php
        if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_to_playlist"])) {
            $playlistId = $_POST["playlist_select"];
            $trackId = $_POST["track_id"];
            $playlistquery = "INSERT INTO playlist (playlist_id, track_id) VALUES ('$playlistId', '$trackId')";
            if($connection->query($playlistquery) === TRUE) {
                echo "<p>Song has been successfully added to the playlist</p>";
            } else {
                echo "Error: " . $playlistquery . "<br>" . $connection->error;
            }
        }
        ?>

        <h2>Your Playlist</h2>
        <table width=100% border=1px style=border-color:white;>
        <th>List of Playlist</th>
            <?php 
            require_once("conn.php");
            //Able to view the list of playlists from the logged in members
            $query = "SELECT * FROM memberplaylist JOIN membership ON membership.member_id = memberplaylist.member_id WHERE memberplaylist.member_id = $memberId";
            $result = $connection->query($query);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td><a href='play.php?playlist_id={$row['playlist_id']}'>{$row['playlist_name']}</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<p>No playlist found</p>";
            }
            ?>
        </table>
    </main>
</body>
</html>