<?php
/* 
This is the 'connection file'
This file handles the connection between program and a database server
Using PDO (PHP Data Objects) for all database processing

Note: Should be on your .gitIgnore list!
Note: Do NOT upload to your host, make a version specific to your host account

Opens, and holds open, a doorway between your PHP processor and Database server
*/

$servername = "localhost";  //generally the same for local and hosting accounts
$username = "root";     //database username different on Local vs hosting account
$password = "";     //database password different on Local vs hosting account
$databasename = "wdv341";         //will differ between local and host account

try {
    //make a new PDO object called $conn. This is the "connection object"
    $conn = new PDO("mysql:host=$servername;dbname=$databasename", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully";
} 
catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>