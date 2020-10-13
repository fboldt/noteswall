<?php
require_once '../database/database_connection_setup.php';

class DatabaseSetup {
  
  private  $databaseConnection;

  function __construct(){
    $databaseConnectionSetup = createDatabaseConnectionSetup();
    $hostName = $databaseConnectionSetup['hostName'];
    $database = $databaseConnectionSetup['database'];
    $userName = $databaseConnectionSetup['userName'];
    $password = $databaseConnectionSetup['password'];
    $this->$databaseConnection = new mysqli($hostName, $userName, $password, $database);
  }

  function __destruct() {
    $this->$databaseConnection->close();
  }

  function clearDataset() {
      $this->dropTableNotes();
  }

  private function dropTableNotes() {
      $query = "DROP TABLE notes";
      $this->$databaseConnection->query($query);
  }

  function insertExamples() {
    $this->insertNotesExamples();
  }

  function createTables() {
    $this->createTableNotes();
  }

  private function createTableNotes() {
    $query = "CREATE TABLE IF NOT EXISTS notes ( 
        id INT NOT NULL AUTO_INCREMENT, 
        PRIMARY KEY (id), 
        username VARCHAR(16) NOT NULL, 
        notetext VARCHAR(128) NOT NULL,
        notetime DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
    )";
    $this->$databaseConnection->query($query);
  }

  private function insertNotesExamples() {
    $query = "INSERT INTO notes (username, notetext) VALUES ('admin', 'initial note!')";
    $this->$databaseConnection->query($query);
  }

}

$databaseSetup = new DatabaseSetup();
$databaseSetup->clearDataset();
$databaseSetup->createTables();
$databaseSetup->insertExamples();

?>