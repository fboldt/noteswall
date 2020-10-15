<?php 

function DBMSConnection() {    
    $hostName = 'localhost';
    $database = 'noteswall';
    $userName = 'francisco';
    $password = 'francisco';
    $mysqlConnection = new mysqli($hostName, $userName, $password, $database);
    return $mysqlConnection;
}

?>