<?php
session_start();
$responseObject = array();
$responseObject['userid'] = "0";
$responseObject['username'] = "";
if (isset($_SESSION['userid']) && isset($_SESSION['username'])) {
    $responseObject['userid'] = $_SESSION['userid'];
    $responseObject['username'] = $_SESSION['username'];
}
echo json_encode($responseObject);
?>
