<?php
require_once '../busyness/login.php';

$login = new Login();
$response = Login::failResponse();
if (Login::userIsLogged() && !Login::postFieldsAreSet()) {
    $response = $login->checkLogin();
} else {
    $response = $login->checkCredentials();
}
echo json_encode($response);

?>