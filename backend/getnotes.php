<?php
require_once '../busyness/notes.php';

function getNotes() {
    $notes = new Notes();
    $response = $notes->getNotes();
    return json_encode($response);
}

print_r(getNotes());

?>
