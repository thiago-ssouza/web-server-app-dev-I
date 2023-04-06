
<?php

require_once "functions.php";
require_once "DBMainV3.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$username = $password = $confirm_password = $firstname = $lastname =  "";



if($_SERVER["REQUEST_METHOD"] == "POST"){


    $username = $_POST['username'];    
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
   
    
    // validations
    $username = usernameValidation($username);   
    $password = passwordValidation($password);    
    $confirm_password = confirmPasswordValidation($password, $confirm_password);    
    $errorValidation = validatePasswordModify();

    if($errorValidation){
        $dbMain = new ManipulateDB();
        $dbMain->username = $username;
        $dbMain->newPassword = password_hash($confirm_password, PASSWORD_DEFAULT);
        //$dbMain->newPassword = $password;
        $dbMain->changePassword();
    }
    

}

?>