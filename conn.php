<?php
//Connecting to the given database server
$connection = new mysqli('localhost', 'twa091', 'twa0915j', '247music091');
//If connection was successful
if ($connection->connect_error) {
    //Print out an error message if it does not connect
 echo $connection->connect_error;
}
?>