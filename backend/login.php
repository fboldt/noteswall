<?php
require_once '../database/database_wrapper.php';
$databaseWrapper = new DatabaseWrapper();

session_start();

$username = $password = "";

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $databaseWrapper->sanitizeString($_POST['username']);
    $password = $databaseWrapper->sanitizeString($_POST['password']);
    if (!empty($username) && !empty($password)) {
        $table = "users";
        $criteria = "username='$username' AND password='$password'";
        $loginQuery = makeLoginQuery($username, $password);
        $result = $databaseWrapper->select($loginQuery);
        if (sizeof($result) == 0) {
            $loginFailed = array();
            $loginFailed['userid'] = 0;
            $loginFailed['username'] = "";
            print(json_encode($loginFailed));
        } else {
            $userObj = $result[0];
            $loginSuccessful = array();
            $_SESSION['userid'] = $loginSuccessful['userid'] = $userObj['id'];
            $_SESSION['username'] = $loginSuccessful['username'] = $userObj['username'];
            print_r(json_encode($loginSuccessful));
            
        }
    }
}
header("Location: ../");

function makeLoginQuery($username, $password) {
    $queryArray = array();
    $queryArray["entity"] = "users";
    $queryArray["criteria"] = "password = '$password' AND username = '$username'";
    return $queryArray;
}

?>