<?php
//I certify that all the works are on this page and others is my on work. Manan Bhatia 22035587
$logged = isset($_SESSION['who']);

if($logged) {
    $username = $_SESSION['who'];
    $categorymember = isset($_SESSION['category']) ? $_SESSION['category'] : 'Unknown';
    $firstname = $_SESSION['firstname'];
    $lastname = $_SESSION['lastname'];
}
?>
    <header>
        <div class="title">
        <a class="navbar-brand" href="index.php"><img src="images/title.png" width = "200px" alt="Title Image" border="0"></a>
            <?php
            if($logged) {
                echo '<div class="welcome">'. $firstname . ' ' .  $lastname . ' ( ' . $username .' - '.$categorymember.' plan)'. '</div>';
            } ?> 
        </div>
        <nav class="navbar">
            <div id="main-navigation">
                <ul class="navbar-nav">
                    <li class="nav-item"><a href="index.php" class="navigation-link" >Home</a></li>
                    <li class="nav-item"><a href="search.php" class="navigation-link" >Search</a></li>
                    <li class="nav-item"><a href="play.php" class="navigation-link" >Play</a></li>
                    <?php 
                    if($logged) {
                        echo '<li class="nav-item"><a href="playlist.php" class="navigation-link">Playlist</a></li>';
                        echo '<li class="nav-item"><a href="logout.php" class="navigation-link">Logout</a></li>';
                    } else {
                        echo '<li class="nav-item"><a href="login.php" class="navigation-link">Login</a></li>';
                    }
                    ?>
                </ul>
            </div>
        </nav>    
    </header>

