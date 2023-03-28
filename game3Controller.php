<?php

//require_once "DBMain.php";
require_once "DBMainV3.php";
require_once "functions.php";

session_start();

if(!isset($_SESSION['loggedin']) && !$_SESSION['loggedin'] === true) {
    session_destroy();
    header("location: login.php");
    exit;
}

$answer_placeholder = "Enter your answer";

$dbMain = new ManipulateDB();
$dbMain->username = "";
$dbMain->firstname = "";
$dbMain->lastname = "";
$dbMain->registrationOrder = "";
$dbMain->scoreTime = "";
$dbMain->result = "";
$dbMain->livesUsed = "";

$playerWon = FALSE;
$submitPressed = FALSE;
$gameLevel = 3;
getInstructions();



if($_SERVER["REQUEST_METHOD"] == "POST") {

    if( isset($_POST['sign-out']) ) {
        session_destroy();
        header("location: login.php");
        exit;
    }

    if( isset($_POST['stop_session']) ) {
        if($_SESSION['livesUsed'] > TOTAL_LIVES) {
            $_SESSION['result'] = 'failure';
        }

        $dbMain->username = $_SESSION['username'];
        $dbMain->firstname = $_SESSION['fName'];
        $dbMain->lastname = $_SESSION['lName'];
        $dbMain->registrationOrder = $_SESSION['registrationOrder'];    
        $dbMain->scoreTime = date('Y-m-d H:i:s');
        $dbMain->result = $_SESSION['result'];
        $dbMain->livesUsed = $_SESSION['livesUsed'];

        $dbMain->insertScore();
        
        session_destroy();
        header("location: login.php");
        exit;
    }

    if(isset($_POST["next_level"])) {
        header("location: game4.php");
        exit;
    }

    if(isset($_POST["play_again"])) {
        resetLivesAndDateTimeSession();
        header("location: game1.php");
        exit;
    }

    if(isset($_POST["home_page"])) {
        resetLivesAndDateTimeSession();
        header("location: login.php");
        exit;
    }

    if($_SESSION['livesUsed'] > TOTAL_LIVES) {
        session_destroy();
        header("location: login.php");
        exit;
    }

    if(isset($_POST['send'])) {

        $submitPressed = TRUE;
        $answer = strtolower(trim($_POST['answer']));
        $gameNumLetterString = $_POST['game_num_letters'];
        $gameNumLetterArr = explode(',', $gameNumLetterString);

        if(validateEntryAnswer()) {

            validateCorrectAnswer();

            getResultLevelMsg();

            if(strpos($resultLevelMsg, "Correct")){
                $playerWon = true;

                if(!(in_array($gameLevel, $_SESSION['gainedLevels'], true))) {
                    
                    array_push($_SESSION['gainedLevels'], $gameLevel);

                    echo count($_SESSION['gainedLevels']);

                    if(count($_SESSION['gainedLevels']) == TOTAL_LEVELS){
                        
                        $_SESSION['result'] = 'success';

                        $dbMain->username = $_SESSION['username'];
                        $dbMain->firstname = $_SESSION['fName'];
                        $dbMain->lastname = $_SESSION['lName'];
                        $dbMain->registrationOrder = $_SESSION['registrationOrder'];
                        $dbMain->scoreTime = date('Y-m-d H:i:s');
                        $dbMain->result = $_SESSION['result'];
                        $dbMain->livesUsed = $_SESSION['livesUsed'];

                        $resultLevelMsg = $resultLevelMsg . '<br/><br/>Congratulations!! You have won all the ' . TOTAL_LEVELS . ' levels!';

                        $dbMain->insertScore();

                        //$dbMain->scoreTime = date('Y-m-d H:i:s', (strtotime($_SESSION['startTime']) - strtotime(date('Y-m-d H:i:s'))));
                        
                        // $datetime1 = new DateTime('2009-10-11 12:12:00');
                        // $datetime2 = new DateTime('2009-10-13 10:12:00');
                        //$interval = $datetime1->diff($datetime2);
                        //echo $interval->format('%Y-%m-%d %H:%i:%s');

                        // $datetime1 = new DateTime($_SESSION['startTime']);
                        // $datetime2 = new DateTime(date('Y-m-d H:i:s'));
                        // $interval = $datetime1->diff($datetime2);

                        // $tstamp = strtotime($_SESSION['startTime']) - strtotime($interval->format('%Y-%m-%d %H:%i:%s'));
                        
                        //$dbMain->scoreTime = date_diff($_SESSION['startTime'] - date('Y-m-d H:i:s'));
                        // $dbMain->scoreTime = $interval->format('%Y-%m-%d %H:%i:%s');
                        //$dbMain->scoreTime = date('Y-m-d H:i:s',$tstamp);
                        //$diff = date_diff($datetime1, $datetime2);

                        // echo $dbMain->username;
                        // echo "<br/>";
                        // echo $dbMain->firstname;
                        // echo "<br/>";
                        // echo $dbMain->lastname;
                        // echo "<br/>";
                        // echo $dbMain->registrationOrder;
                        // echo "<br/>";
                        // echo $_SESSION['startTime'];
                        // echo "<br/>";
                        // echo $dbMain->scoreTime;
                        // echo "<br/>";
                        // echo $dbMain->result;
                        // echo "<br/>";
                        // echo $dbMain->livesUsed;
                        // echo "<br/>";

                    }
                }
            }else {

                if($_SESSION['livesUsed'] >= TOTAL_LIVES) {
                    $_SESSION['result'] = 'failure';

                    $dbMain->username = $_SESSION['username'];
                    $dbMain->firstname = $_SESSION['fName'];
                    $dbMain->lastname = $_SESSION['lName'];
                    $dbMain->registrationOrder = $_SESSION['registrationOrder'];    
                    $dbMain->scoreTime = date('Y-m-d H:i:s');
                    $dbMain->result = $_SESSION['result'];
                    $dbMain->livesUsed = $_SESSION['livesUsed'];

                    $resultLevelMsg = $resultLevelMsg . '<br/><br/>Well Played. Try again later!! You have used all the ' . TOTAL_LIVES . ' lives!';

                    $dbMain->insertScore();

                    $_SESSION['livesUsed'] = $_SESSION['livesUsed'] + 1;

                    // $datetime1 = new DateTime($_SESSION['startTime']);
                    // $datetime2 = new DateTime(date('Y-m-d H:i:s'));
                    // $interval = $datetime1->diff($datetime2);
    
                    // $tstamp = strtotime($_SESSION['startTime']) - strtotime($interval->format('%Y-%m-%d %H:%i:%s'));
                    
                    // $dbMain->scoreTime = date('Y-m-d H:i:s',$tstamp);
                    //$diff = date_diff($datetime1, $datetime2);
                    
    
                    // echo $dbMain->username;
                    // echo "<br/>";
                    // echo $dbMain->firstname;
                    // echo "<br/>";
                    // echo $dbMain->lastname;
                    // echo "<br/>";
                    // echo $dbMain->registrationOrder;
                    // echo "<br/>";
                    // echo $_SESSION['startTime'];
                    // echo "<br/>";
                    // echo $dbMain->scoreTime;
                    // echo "<br/>";
                    // echo $dbMain->result;
                    // echo "<br/>";
                    // echo $dbMain->livesUsed;
                    // echo "<br/>";

                } else {
                    $_SESSION['livesUsed'] = $_SESSION['livesUsed'] + 1;
                }

            }
        }

    }else {
        generateNumbersLetters();
    }

} else {
    generateNumbersLetters();


}

?>