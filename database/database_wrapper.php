<?php

class DatabaseWrapper {
  
  private  $databaseConnection;

  function __construct(){
    $hostName = 'localhost';
    $database = 'noteswall';
    $useName = 'francisco';
    $password = 'francisco';
    $this->$databaseConnection = new mysqli($hostName, $useName, $password, $database);
  }

  function __destruct() {
    $this->$databaseConnection->close();
  }

  function sanitizeString($var) {
    $var = strip_tags($var);
    $var = htmlentities($var);
    if (get_magic_quotes_gpc()) {
      $var = stripslashes($var);
    }
    return $this->$databaseConnection->real_escape_string($var);
  }

  static function queryResultToPhpArray($queryResult) {
    $phparray = array();
    while ($row = $queryResult->fetch_array(MYSQLI_ASSOC)) {
      array_push($phparray, $row);
    }
    return $phparray;
  }

  private function executeQuery($treatedQuery) {
    $entity = $treatedQuery['entity'];
    $criteria = $treatedQuery['criteria'];
    $orderby = $treatedQuery['orderby'];
    $desc = $treatedQuery['desc'];
    $query = "SELECT * FROM $entity WHERE $criteria ORDER BY $orderby $desc";
    $queryResult = $this->$databaseConnection->query($query);
    return $queryResult;
  }

  private function treatQuery($queryArray) {
    $queryTreater = new QueryTreater($queryArray);
    $treatedQuery = $queryTreater->getTreatedQuery();
    return $treatedQuery;
  }

  function select($queryArray) {
    $treatedQuery = $this->treatQuery($queryArray);
    $queryResult = $this->executeQuery($treatedQuery);
    $phpArrayResult = self::queryResultToPhpArray($queryResult);
    return $phpArrayResult;
  }

  function treatInsertQuery($queryArray) {
    $treatedInsertQuery = array();
    $treatedInsertQuery['table'] = $queryArray['entity'];
    $treatedInsertQuery['fields'] = "";
    $treatedInsertQuery['values'] = "";
    foreach ($queryArray['fields'] as $field => $value){
      if (!empty($treatedInsertQuery['fields'])) {
        $treatedInsertQuery['fields'] .= ',';
      }
      $treatedInsertQuery['fields'] .= $field;
      if (!empty($treatedInsertQuery['values'])) {
        $treatedInsertQuery['values'] .= ',';
      }
      $treatedInsertQuery['values'] .= "'" . $value . "'";
    }
    return $treatedInsertQuery;
  }

  function insert($queryArray) {
    $treatedInsertQuery = $this->treatInsertQuery($queryArray);
    $table =  $treatedInsertQuery['table'];
    $fields = $treatedInsertQuery['fields'];
    $values = $treatedInsertQuery['values'];
    $query = "INSERT INTO $table ($fields) VALUES ($values)";
    $result = $this->$databaseConnection->query($query);
    return $result;
  }

}


class QueryTreater {

  private $queryArray;

  function __construct($queryArray) {
    $this->queryArray = $queryArray;
  }

  function hasField($field) {
    return isset($this->queryArray[$field]) && !empty($this->queryArray[$field]);
  }

  function getValidFieldValue($field) {
    if ($this->hasField($field)) {
      return $this->queryArray[$field];
    }
    return '1';
  }

  function getTreatedQuery() {
    $treatedQuery = array();
    $fields = ['entity', 'criteria', 'orderby', 'desc'];
    foreach ($fields as $field) {
      $treatedQuery[$field] = $this->getValidFieldValue($field);
    }
    if ($treatedQuery['desc']!='desc' && $treatedQuery['desc']!='asc') {
      $treatedQuery['desc'] = 'asc';
    }
    return $treatedQuery;
  }

}

?>
