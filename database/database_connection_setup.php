<?php

function createMysqlSetup($databaseConnectionFileSetup) {
    $databaseSetup = array();
    require_once $databaseConnectionFileSetup;
    $databaseSetup['hostName'] = $hostName;
    $databaseSetup['database'] = $database;
    $databaseSetup['userName'] = $userName;
    $databaseSetup['password'] = $password;
    return $databaseSetup;
}

function createDatabaseConnectionSetup() {
    if ($_SERVER['SERVER_ADDR'] == "::1" || $_SERVER['SERVER_ADDR'] == "127.0.0.1") {
        return createMysqlSetup('../database/localhost.php');
    }
    return createMysqlSetup('../database/onlinehost.php');
}


?>