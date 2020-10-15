<?php
require_once '../database/database_wrapper.php';

class Notes {
    private $databaseWrapper, $fields, $fieldsArray;

    function __construct() {
        $this->databaseWrapper = new DatabaseWrapper();
        $this->fields = ['userid', 'notetext'];
        $this->fieldsArray = array();
    }
    
    function getNotes() {
        $resultArray = $this->databaseWrapper->selectAll("notesview");
        $responseObject = array("notes" => $resultArray);
        return $responseObject;
    }

    function insertNote($userid, $notetext) {
        $response = $this->databaseWrapper->insertNote($userid, $notetext);
        return $response;
    }

}

?>
