<?php
require_once '../busyness/notes.php';

function insertNote() {
    $notes = new Notes();
    $response = $notes->insertNote($_POST['userid'],$_POST['notetext']);
    return $response;
}

print_r(insertNote());

?>
