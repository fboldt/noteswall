<?php
require_once '../database/database_wrapper.php';

function formHasField($fieldName) {
    return isset($_POST[$fieldName]) && !empty($_POST[$fieldName]);
}

function getFields() {
    $fields = ['username', 'message'];
    $fieldsArray = array();
    foreach ($fields as $field) {
        if (formHasField($field)) {
            $fieldsArray[$field] = $_POST[$field];
        }
    }
    return $fieldsArray;
}

function makeInsertQuery() {
    $queryArray = array();
    $queryArray['entity'] = 'notes';
    $queryArray['fields'] = getFields();
    return $queryArray;
}

function insertNotes() {
    $databaseWrapper = new DatabaseWrapper();
    $queryArray = makeInsertQuery();
    $response = $databaseWrapper->insert($queryArray);
    return $response;
}

print_r(insertNotes());
header("Location: ../");

?>
