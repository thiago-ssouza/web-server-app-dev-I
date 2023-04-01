<?php

//require_once "DBMain.php";
require_once "DBMainV3.php";
require_once "functions.php";

session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    if(!(in_array(TOTAL_LEVELS, $_SESSION['gainedLevels']))){
        header("location: game" . ( ($_SESSION['gainedLevels'][count($_SESSION['gainedLevels'])-1]) + 1) . ".php");
    } else{
        header("location: game" . ( ($_SESSION['gainedLevels'][count($_SESSION['gainedLevels'])-1])) . ".php");
    }
    exit;
    // header("location: game1.php");
    // exit;
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