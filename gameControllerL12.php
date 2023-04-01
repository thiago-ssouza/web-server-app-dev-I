<?php
    require_once "DBMainV3.php";
    require_once "functions.php";

    session_start();

    if(!isset($_SESSION['loggedin']) && !$_SESSION['loggedin'] === true) {
        session_dest();
    }
    
    if (strpos($_SERVER['SCRIPT_FILENAME'], 'game1.php') !== false) {
        $gameLevel = 1;
    } else {
        $gameLevel = 2;
    } 

    $answer_placeholder = "Enter your answer";
    $dbMain = new ManipulateDB(); 
    $playerWon = FALSE;
    $submitPressed = FALSE;   

    getInstructions();

    if($gameLevel == 2){
        checkPlayerCanAccessLevelOrRedirectPlayer();
    }

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        
        if( isset($_POST['sign-out']) ) {
            session_dest();
        }        

        if( isset($_POST['stop_session']) ) {
            if($_SESSION['livesUsed'] >= TOTAL_LIVES) {
                $_SESSION['result'] = 'failure';
            }
            setData($dbMain);
            $dbMain->insertScore();        
            session_dest();            
        }

        // if(isset($_POST["next_level"])) {
            
        //     if ($_SERVER['PHP_SELF'] == "/game1.php") {
                               
        //         header("Location: game2.php");
        //         exit;
        //     }else{
        //         header("location: game3.php");
        //         exit;
        //     }
        // }

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

        // if(isset($_POST["play_again"])) {  // Play again is when the user win or lose, so the session need to be reseted and goes to game 1
        //     //resetLivesAndDateTimeSession();

        //     if ($_SERVER['PHP_SELF'] == "/game2.php") {                
        //         header("Location: game2.php");
        //         exit;
        //     }else{
        //         header("location: game1.php");
        //         exit;
        //     }
        // }

        if(isset($_POST["home_page"])) {
            resetLivesAndDateTimeSession();
            header("location: index.php");
            exit;
        }

        if($_SESSION['livesUsed'] > TOTAL_LIVES) {
            
            session_dest();
        }

        // game Start
        if(isset($_POST['send'])){
            
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