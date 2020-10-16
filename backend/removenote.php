<?php
require_once '../busyness/notes.php';

function removeNote() {
    $notes = new Notes();
    $response = $notes->removeNote($_POST['userid'],$_POST['noteid']);
    return $response;
}

print_r(removeNote());

?>