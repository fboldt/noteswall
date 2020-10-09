<?php
require_once '../database/database_wrapper.php';

function makeNotesQuery() {
    $queryArray = array(
        'entity' => 'notes',
        'orderby' => 'notetime',
        'desc' => 'desc'
    );
    return $queryArray;
}

function getNotes() {
    $databaseWrapper = new DatabaseWrapper();
    $queryArray = makeNotesQuery();
    $resultArray = $databaseWrapper->select($queryArray);
    $responseObject = array("notes" => $resultArray);
    return json_encode($responseObject);
}

print_r(getNotes());

?>
