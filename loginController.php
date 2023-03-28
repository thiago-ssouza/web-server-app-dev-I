<?php

//require_once "DBMain.php";
require_once "DBMainV3.php";
require_once "functions.php";

session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: game1.php");
    exit;
}

$username_placeholder = "Enter your username";
$password_placeholder = "Enter your password";
$dbMain = new ManipulateDB();
$dbMain->username = "";
$dbMain->password = "";
$dbMain->login_err = "";


if($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_POST["sign-up"])) {
        header("location: register.php");
        exit;
    }

    $dbMain->username = usernameValidation(strtolower(trim($_POST["username"])));

    $dbMain->password = passwordValidation(trim($_POST["password"]));

    $dbMain->loginPlayer();

}

?>