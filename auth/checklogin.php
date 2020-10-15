<?php
require_once '../auth/login.php';

$login = new Login();
$response = Login::failResponse();
if (Login::userIsLogged() && !Login::postFieldsAreSet()) {
    $response = $login->checkLogin();
} else {
    $response = $login->checkCredentials();
}
echo json_encode($response);

?>