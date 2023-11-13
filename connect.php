<?php
$serverName = "localhost";
$username = "root";
$password = null;
$databaseName = "userdb"; // Name of your database

// Create a database connection
$connection = new mysqli($serverName, $username, $password, $databaseName);

// Check the connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// You are now connected to the database

// You can use $connection to perform database operations


?>