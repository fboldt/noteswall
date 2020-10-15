<?php
require_once '../database/database_connection.php';

function test_database_connection() {
    $databaseConnection = new DatabaseConnection();
    print_r($databaseConnection);
    print_r($databaseConnection->query("SHOW TABLES"));
}

?>