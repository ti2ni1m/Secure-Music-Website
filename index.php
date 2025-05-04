<?php
//I certify that all the works are on this page and others is my on work. Manan Bhatia 22035587

//Session starts to access the session variable
session_start();

//Checking if the user is logged in
$logged = isset($_SESSION['who']);

//Retrieving the username and membership category
if($logged) {
    $username = $_SESSION['who'];
    $categorymember = isset($_SESSION['category']) ? $_SESSION['category'] : 'Unknown';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>24/7 Music Homepage</title>
    <!-- The files of the styles css is the main Cascade file whilst the other css files are from the bootstrap website to enhance the UI design of the web page-->
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <!--Displaying a separate header page so that the other files can have the same header-->
<?php include('_header.php');
?>
    <main>
            <?php
            //Displaying a welcome page for both logged in and guest members.
            if($logged) {
                echo '<p>Welcome to Music 24/7 ' . $username . ', Your membership is ' . $categorymember . '.</p>';
            } else {
                echo '<p>Welcome to Music 24/7, please Login to search for your songs and see your playslist.</p>';
            }
            ?>

        <?php
        //When logged in shows 2 forms, 1 for playlist, either to create a new one or view it,and another one for search to search a song, album or artist
        if($logged) {
            echo "<a href = 'playlist.php'>Playlist</a>";
            echo "<a href = 'search.php'>Search</a>";
        } else { ?>
        <p><a class = 'homelink' href = "login.php">Login</a>
        <a class = 'homelink' href = "search.php">Search</a></p>
        <?php 
            }
        ?>
    </main>

</body>
</html>