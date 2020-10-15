<?php
require_once '../database/database_wrapper.php';
function test_database_wrapper() {
    $databaserWrapper = new DatabaseWrapper();
    print_r($databaserWrapper->selectAll("notesview"));
}
?>