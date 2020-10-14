<?php
require_once '../busyness/notes.php';

function insertNote() {
    $notes = new Notes();
    $response = $notes->insertNote();
    return $response;
}

print_r(insertNote());
// header("Location: ../");

?>
