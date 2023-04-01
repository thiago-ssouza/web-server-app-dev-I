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

$playerWon = FALSE;
$submitPressed = FALSE;
$gameLevel = 5;
getInstructions();

checkPlayerCanAccessLevelOrRedirectPlayer();

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
        setData($dbMain);

        $dbMain->insertScore();
        
        session_destroy();
        header("location: login.php");
        exit;
    }

    if(isset($_POST["previous_level"])) {
        header("location: game" . ($gameLevel-1) . ".php");
        exit;
    }

    if(isset($_POST["next_level"])) {
        header("location: game" . ($gameLevel+1) . ".php");
        exit;
    }

    if(isset($_POST["play_again"])) {
        resetLivesAndDateTimeSession();
        header("location: game1.php");
        exit;
    }

    if(isset($_POST["home_page"])) {
        resetLivesAndDateTimeSession();
        header("location: index.php");
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

                }
            }else {
                if(!(in_array($gameLevel, $_SESSION['gainedLevels'], true))) {
                    if($_SESSION['livesUsed'] >= TOTAL_LIVES) {
                        $_SESSION['result'] = 'failure';

                        setData($dbMain);

                        $resultLevelMsg = $resultLevelMsg . '<br/><br/>Well Played. Try again later!! You have used all the ' . TOTAL_LIVES . ' lives!';

                        $dbMain->insertScore();

                    }
                    $_SESSION['livesUsed'] = $_SESSION['livesUsed'] + 1;
                }

            }
        }

    }else {
        generateNumbersLetters();
        if($_SESSION['livesUsed'] > TOTAL_LIVES) {
            
            session_dest();
        }
    }

} else {
    generateNumbersLetters();
    if($_SESSION['livesUsed'] > TOTAL_LIVES) {
        
        session_dest();
    }


}

?>
