<?php
//I certify that all the works are on this page and others is my on work. Manan Bhatia 22035587

//A separate file called nocache to not allow duplication of the data in the login
require_once("nocache.php");

//Hacing a variable to initialise an error message
$errorMsg = '';
//Checking if the user is logged in
$logged = isset($_SESSION['who']);
//To check if the username and password form is submitted with a validation
if(isset($_POST['submit'])) {
     if(empty($_POST['username']) || empty($_POST['password'])) {
        $errorMsg = 'Both username and password is required';
     } else {
        //Adding the connection of the database
        require_once("conn.php");

        //Santising bothe the username and password
        $username = $connection->escape_string($_POST['username']);
        $password = $connection->escape_string($_POST['password']);
        //Hashing the password
        $hashedPassword = hash('sha256', $password);
        //SQL query to check user credentials
        $query = "SELECT * FROM membership WHERE username = '$username' AND password = '$hashedPassword'";
        //Executing the result of the query
        $result = $connection->query($query);

        //If found, session starts which then fetches the user data. Next is the setting of the session for the users to login in other pages.
        if($result->num_rows > 0) {
            session_start();
            $user = $result->fetch_assoc();
            $_SESSION['who'] = $user['username'];
            $_SESSION['category'] = $user['category'];
            $_SESSION['userid'] = $user['member_id'];
            $_SESSION['firstname'] = $user['firstname'];
            $_SESSION['lastname'] = $user['surname'];

        } else {
            //If user is not found, then error message is displayed
            $errorMsg = "Incorrect username or password";
        }
        //If successful in logging in, page is redirected to the home page
        if(isset($_SESSION['who']) && isset( $_SESSION['category'])) {

            header('Location: search.php');
            }
     }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>24/7 Music Login</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
<?php include('_header.php');
?>
    <main>
        <p>To access your playlist, please login.</p>
        <div class="login-form">
            <form method = "post" action="<?php  echo $_SERVER['PHP_SELF']; ?>">
            <p class = "loginvalid"><?php echo $errorMsg;?></p>
                <div class="input-box">
                    <label for="username">Username:</label>
                    <input type="text" name="username" maxlength="50" id="username">
                </div>
                <div class="input-box">
                    <label for="password">Password:</label>
                    <input type="password" name="password" maxlength="20" id="password">
                </div>
                <div class="input-box">
                    <input type="submit" value="Login" name="submit">
                </div>
            </form>
            <h2><a href='#'>Sign Up</a></h2>
        </div>
    </main>
</body>
</html>