<?php
require_once '../auth/login.php';

$login = new Login();
$response = Login::failResponse();
if (Login::postFieldsAreSet()) {
    $response = $login->insertUser();
}
echo json_encode($response);

?>