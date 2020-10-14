<?php
require_once '../database/database_wrapper.php';

class Notes {
    private $databaseWrapper, $fields, $fieldsArray;

    function __construct() {
        $this->databaseWrapper = new DatabaseWrapper();
        $this->fields = ['userid', 'notetext'];
        $this->fieldsArray = array();
    }
    
    static function makeNotesQuery() {
        $queryArray = array();
        $queryArray['entity'] = 'notesview';
        $queryArray['orderby'] = 'notetime';
        $queryArray['desc'] = 'desc';
        return $queryArray;
    }

    function getNotes() {
        $queryArray = Self::makeNotesQuery();
        $resultArray = $this->databaseWrapper->select($queryArray);
        $responseObject = array("notes" => $resultArray);
        return $responseObject;
    }


    static function formHasField($fieldName) {
        return isset($_POST[$fieldName]) && !empty($_POST[$fieldName]);
    }

    function getFields() {
        foreach ($this->fields as $field) {
            if (Self::formHasField($field)) {
                $this->fieldsArray[$field] = $_POST[$field];
            }
        }
    }

    function makeInsertQuery() {
        $queryArray = array();
        $queryArray['entity'] = 'notes';
        $queryArray['fields'] = $this->fieldsArray;
        return $queryArray;
    }

    function insertNote($userid, $notetext) {
        $response = $this->databaseWrapper->insertNote($userid, $notetext);
        return $response;
    }

}

?>
