<?php
require_once '../database/database_wrapper.php';

session_start();

class Login {
    private $databaseWrapper;
    private $username;
    private $password;

    function __construct() {
        $this->databaseWrapper = new DatabaseWrapper();
        $this->username = "";
        $this->password = "";
    }

    static function postFieldsAreSet() {
        return isset($_POST['username']) && isset($_POST['password']);
    }

    private function sanitizeString($string) {
        return $this->databaseWrapper->sanitizeString($string);
    }

    private function sanitizePostFields() {
        $this->username = $this->sanitizeString($_POST['username']);
        $this->password = $this->sanitizeString($_POST['password']);
    }

    static function failResponse() {
        $response = array();
        $response['userid'] = 0;
        $response['username'] = "";
        return $response;
    }

    private function loginFieldsAreSet() {
        return !empty($this->username) && !empty($this->password);
    }

    private function fetchUserFromDataset() {
        return $this->databaseWrapper->fetchUser($this->username, $this->password);
    }

    function checkCredentials() {
        $response = Self::failResponse();
        if (Self::postFieldsAreSet()) {
            $this->sanitizePostFields();
            if ($this->loginFieldsAreSet()) {
                $result = $this->fetchUserFromDataset();
                if (sizeof($result) > 0) {
                    $userObj = $result[0];
                    $_SESSION['userid'] = $response['userid'] = $userObj['id'];
                    $_SESSION['username'] = $response['username'] = $userObj['username'];
                }
            }
        }
        if ($response['userid'] == 0 || $response['username'] == "") {
            Self::destroy_session();
        }
        return $response;
    }

    static function sessionFieldsAreSet() {
        return isset($_SESSION['userid']) && isset($_SESSION['username']);
    }

    static function sessionFieldsAreValid() {
        return ($_SESSION['userid'] > 0) && ($_SESSION['username'] != "");
    }

    static function userIsLogged() {
        return Self::sessionFieldsAreSet() && Self::sessionFieldsAreValid();
    }

    function checkLogin() {
        $response = Self::failResponse();
        $response['userid'] = $_SESSION['userid'];
        $response['username'] = $_SESSION['username'];
        return $response;
    }

    static function destroy_session() {
        $_SESSION=array();
        if (session_id != "" || isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time()-2592000, '/');
        }
        session_destroy();
    }
}

?>