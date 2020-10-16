<!DOCTYPE html>
<html>

<head>
    <title>DB Setup</title>
</head>

<body>

<pre>
<?php
require_once '../database/database_connection.php';

class DatabaseSetup {
  
  private  $databaseConnection;

  function __construct(){
    $this->$databaseConnection = new DatabaseConnection();
  }

  private function execute($query) {
    echo $query;
    echo "\n";
    $result = $this->$databaseConnection->query($query);
    print_r($result);
    echo "\n";
  }

  function reset() {
    $this->clearDataset();
    $this->createTables();
    $this->insertExamples();
    $this->createViews();
  }

  private function clearDataset() {
      $query = "DROP TABLE notes";
      $this->execute($query);
      $query = "DROP TABLE users";
      $this->execute($query);
      $query = "DROP VIEW notesview";
      $this->execute($query);
  }

  private function createTables() {
    $this->createTableUsers();
    $this->createTableNotes();
  }

  private function createTableUsers() {
    $query = "CREATE TABLE IF NOT EXISTS users ( 
        id INT NOT NULL AUTO_INCREMENT, 
        PRIMARY KEY (id), 
        username VARCHAR(16) NOT NULL UNIQUE, 
        password VARCHAR(128) NOT NULL
    )";
    $this->execute($query);
    $query = "DESCRIBE users";
    $this->execute($query);
  }

  private function createTableNotes() {
    $query = "CREATE TABLE IF NOT EXISTS notes ( 
        id INT NOT NULL AUTO_INCREMENT, 
        PRIMARY KEY (id), 
        userid INT NOT NULL, 
        FOREIGN KEY (userid) REFERENCES users(id),
        notetext VARCHAR(128) NOT NULL,
        notetime DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
    )";
    $this->execute($query);
    $query = "DESCRIBE notes";
    $this->execute($query);
  }

  private function insertExamples() {
    $query = "INSERT INTO users (username, password) VALUES ('someuser', '123123')";
    $this->execute($query);
    $query = "INSERT INTO notes (userid, notetext) VALUES (1,'Very first note of all.')";
    $this->execute($query);
  }

  private function createViews() {
    $query = "CREATE VIEW notesview AS
    SELECT users.id AS userid, users.username, notes.id AS noteid, notes.notetext, notes.notetime
    FROM notes INNER JOIN users ON users.id = notes.userid";
    $this->execute($query);
  }

}

$databaseSetup = new DatabaseSetup();
$databaseSetup->reset();

?>
</pre>

</body>

</html>
