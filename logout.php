<?php
//I certify that all the works are on this page and others is my on work. Manan Bhatia 22035587

//A separate file called nocache to not allow duplication of the data in the login
require_once('nocache.php');
//Session starts to access the session variable and then destroys the data 
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>24/7 Music Logout</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <header>
        <div class="title">
            <h1>24/7 Music</h1>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="search.php">Search</a></li>
                <li><a href="play.php">Play</a></li>
                <li><a href="playlist.php">Playlist</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </nav>    
    </header>
    <main>
        <?php
        //At first I decided to put up a message like this however, I decided to add a header to redirect it back to the search page when logging out
        echo '<p> You have successfully logged out. <a href="index.php">Return to Home Page</a></p>';
        header("location: search.php");
        ?>
    </main>
</body>
</html>