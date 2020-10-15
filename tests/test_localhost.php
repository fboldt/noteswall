<?php
require_once '../database/localhost.php';

function test_localhost() {
    $mysqlConnection = DBMSConnection();
    print_r($mysqlConnection);
}
// test();
?>