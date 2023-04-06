<!-- 
Thiago Soares de Souza
Web Server Applications
26 March 2023
LaSalle College
Web Server Project - Game 3 Form
-->

<?php

require_once "game3Controller.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Game Leve <?php echo $gameLevel; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <script src="./js/jquery-3.6.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="./js/script.js"></script>
</head>
<body>
    <?php
        //require_once "header.php";
        require_once "navBar.php";
    ?>
    <div class="content p-5">
    <article class="content__container">
        <h2 class="content__heading is-valid"><span>Game Level <?php echo $gameLevel . ":"; ?></span> <?php echo $instructions; ?></h2>        
        <<!--<h5 class="content__desc">Player: <?php //echo (isset($_SESSION['loggedin'])) ? $_SESSION['fName'] . " " . $_SESSION['lName'] . " | Current Live: " : "" ;?> <?php //echo (isset($_SESSION['loggedin']) && $_SESSION['livesUsed'] <= TOTAL_LIVES) ? (7 - $_SESSION['livesUsed']) : (7 - $_SESSION['livesUsed']) ;?></h5>-->
        <h5 class="content__desc">Player: <?php echo (isset($_SESSION['loggedin'])) ? $_SESSION['fName'] . " " . $_SESSION['lName'] . " | Current Lives: " . ((TOTAL_LIVES + 1) - $_SESSION['livesUsed']) : "" ;?></h5>
        <span class="valid-feedback"><?php echo (isset($_SESSION['loggedin']) && (in_array(($gameLevel), $_SESSION['gainedLevels'], true))) ? 'You Have Already Won This Level (Any mistake will not decrease the number of lives)' : '';?></span>
        <p class="content__desc">Please <?php echo $instructions; ?> (from 0 to 100).</p>
        <p class="content__desc">** put ',' between the numbers (Example: 0,1,2,3,4,5).</p>
        </article>
        <?php 

        if(!empty($answer_err)){
            echo '<div class="alert alert-danger">' . $answer_err . '</div>';
        }        
        ?>

        <form name="sign-in" action="game3.php" method="post">
            <div class="form-group">
                <label class="content__desc"for="game_num_letters">Game <?php echo ($gameLevel == 3 || $gameLevel == 4 || $gameLevel == 6) ? 'Numbers' : 'Letters'; ?></label>
                <input type="text" name="game_num_letters" id="game_num_letters" class="form-control read-only" readonly value="<?php echo $gameNumLetterString; ?>">
                
                <label class="content__desc"for="<?php echo ($gameLevel == 3 || $gameLevel == 4 || $gameLevel == 6) ? 'answer_num' : 'answer_let'; ?>">Answer</label>
                <input type="text" name="answer" id="<?php echo ($gameLevel == 3 || $gameLevel == 4 || $gameLevel == 6) ? 'answer_num' : 'answer_let'; ?>" autocomplete="off" class="form-control content__desc <?php echo (!empty($answer_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $answer; ?>" placeholder="<?php echo $answer_placeholder; ?>">
                <span class="invalid-feedback"><?php echo $answer_err; ?></span>

                <?php 
                if(!empty($resultLevelMsg)){
                    if(strpos($resultLevelMsg, "Correct") || strpos($resultLevelMsg, "Congratulations")){
                        echo '<div class="alert alert-success">' . $resultLevelMsg . '</div>';
                    }else {
                        echo '<div class="alert alert-danger">' . $resultLevelMsg . '</div>';
                    }
                }
                ?>

            </div>    
            <div class="form-group game_wrap">
            <?php
                    if (!$submitPressed || !empty($answer_err)) {
                        echo <<<_NOTSUBMIT
                            <input type="submit" class="game_btn btn btn-primary" value="Previous Level" name="previous_level">
                            <input type="submit" class="game_btn btn btn-primary" value="Submit Answer" name="send">
                            <input type="submit" class="game_btn btn btn-primary" value="Sign-Out" name="sign-out">

                        _NOTSUBMIT;
                        if(isset($_SESSION['loggedin']) && (in_array(($gameLevel), $_SESSION['gainedLevels'], true))) {
                            echo '<input type="submit" class="game_btn btn btn-primary" value="Next Level" name="next_level">';
                        }
                    } else {

                        if($_SESSION['livesUsed'] > TOTAL_LIVES) {
                            echo <<<_GAMEOVER
                            <input type="submit" class="game_btn btn btn-primary" value="Home Page" name="home_page">
                            <input type="submit" class="game_btn btn btn-primary" value="Play Again" name="play_again">
                            <input type="submit" class="game_btn btn btn-primary" value="Sign-Out" name="sign-out">

                            _GAMEOVER;
                        } else {
                            echo <<<_SUBMIT
                            <input type="submit" class="game_btn btn btn-primary" value="Previous Level" name="previous_level">
                            <input type="submit" class="game_btn btn btn-primary" value="Sign-Out" name="sign-out">
                            <input type="submit" class="game_btn btn btn-primary" value="Stop this Session" name="stop_session">

                            _SUBMIT;

                            if (!$playerWon || (in_array(($gameLevel), $_SESSION['gainedLevels'], true))) {
                                echo <<<_NOTWON
                                <input type="submit" class="game_btn btn btn-primary" value="Try Again this Level" name="try_again">

                                _NOTWON;
                            } 

                            if(isset($_SESSION['loggedin']) && (in_array(($gameLevel), $_SESSION['gainedLevels'], true))) {
                                echo '<input type="submit" class="game_btn btn btn-primary" value="Next Level" name="next_level">';
                            }

                        }
                        
                    }
                ?>
            </div>
        </form>
    </div>

    <?php
        require_once "footer.php";
    ?>
</body>
</html>