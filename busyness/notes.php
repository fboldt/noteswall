<?php
require_once '../database/database_wrapper.php';
require_once '../auth/login.php';

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
        $response = NULL;
        if (Login::loggedUserId() == $userid) {
            $response = $this->databaseWrapper->insertNote($userid, $notetext);
        }
        return $response;
    }

    function getNote($noteid) {
        return $this->databaseWrapper->getNote($noteid);
    }

    function removeNote($userid, $noteid) {
        $response = NULL;
        if ((Login::loggedUserId() == $userid) && 
            ($userid == $this->getNote($noteid)['userid'])) {
            $response = $this->databaseWrapper->removeNote($noteid);
        }
        return $response;
    }

}

?>
