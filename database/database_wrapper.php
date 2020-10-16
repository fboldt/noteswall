<?php
require_once '../database/database_connection.php';

class DatabaseWrapper {
  
  private $databaseConnection;

  function __construct() {
    $this->databaseConnection = new DatabaseConnection();
  }

  function sanitizeString($var) {
    $var = strip_tags($var);
    $var = htmlentities($var);
    if (get_magic_quotes_gpc()) {
      $var = stripslashes($var);
    }
    return $this->databaseConnection->real_escape_string($var);
  }

  static function queryResultToPhpArray($queryResult) {
    $phparray = array();
    while ($row = $queryResult->fetch_array(MYSQLI_ASSOC)) {
      array_push($phparray, $row);
    }
    return $phparray;
  }
  
  function fetchUser($username, $password) {
    $query = "SELECT * FROM users WHERE password='$password' AND username='$username'";
    $queryResult = $this->databaseConnection->query($query);
    $phpArrayResult = self::queryResultToPhpArray($queryResult);
    return $phpArrayResult;  
  }

  function insertUser($username, $password) {
    $query = "INSERT INTO users (username, password) VALUES ('$username','$password')";
    $result = $this->databaseConnection->query($query);
    return $result;
  }
 
  function selectAll($table) {
    $query = "SELECT * FROM $table";
    $queryResult = $this->databaseConnection->query($query);
    $phpArrayResult = self::queryResultToPhpArray($queryResult);
    return $phpArrayResult;
  }

  function getNote($noteid) {
    $query = "SELECT * FROM notes WHERE id='$noteid'";
    $queryResult = $this->databaseConnection->query($query);
    $phpArrayResult = self::queryResultToPhpArray($queryResult);
    return $phpArrayResult[0];  
  }
 
  function insertNote($userid, $notetext) {
    $query = "INSERT INTO notes (userid, notetext) VALUES ($userid,'$notetext')";
    $result = $this->databaseConnection->query($query);
    return $result;
  }

  function removeNote($noteid) {
    $query = "DELETE FROM notes WHERE id='$noteid'";
    $result = $this->databaseConnection->query($query);
    return $result;  
  }

}

?>
