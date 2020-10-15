<?php

class DatabaseConnection {
    public $DBMSConnection;

    function __construct() {
        $this->loadDBMSFileSetup();
        $this->DBMSConnection = DBMSConnection();
    }

    function __destruct() {
        $this->DBMSConnection->close();
    }

    private function loadDBMSFileSetup() {
        if ($_SERVER['SERVER_ADDR'] == "::1" || $_SERVER['SERVER_ADDR'] == "127.0.0.1") {
            require_once '../database/localhost.php';
        } else {
            require_once '../database/onlinehost.php';
        }
    }

    function query($query) {
        return $this->DBMSConnection->query($query);
    }

    function real_escape_string($var) {
        return $this->DBMSConnection->real_escape_string($var);
    }

}

?>
