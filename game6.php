<?php

require "game6Controller.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Game Leve 6</title>
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
        <h2 class="content__heading is-valid"> <span>Game Level <?php echo $gameLevel . ":"; ?></span>: <?php echo $instructions; ?></h2>
        <h5 class="content__desc">Player: <?php echo (isset($_SESSION['loggedin'])) ? $_SESSION['fName'] . " " . $_SESSION['lName'] . " | Current Live: " : "" ;?> <?php echo (isset($_SESSION['loggedin']) && $_SESSION['livesUsed'] <= TOTAL_LIVES) ? $_SESSION['livesUsed'] : ($_SESSION['livesUsed'] - 1) ;?></h5>
        <span class="valid-feedback"><?php echo (isset($_SESSION['loggedin']) && (in_array(($gameLevel), $_SESSION['gainedLevels'], true))) ? 'You Have Already Won This Level (Any mistake will not increase the used lives)' : '';?></span>
        <p class="content__desc">Please <?php echo $instructions; ?> (from 100 to 0).</p>
        <p class="content__desc">** put ',' between the numbers (Example: 5,4,3,2,1,0).</p>
        <p class="content__desc">** put the minimum number before the maximum number (Example: 11,23).</p>
        </article>

        <?php 

        if(!empty($answer_err)){
            echo '<div class="alert alert-danger">' . $answer_err . '</div>';
        }        
        ?>

        <form name="sign-in" action="game6.php" method="post">
            <div class="form-group">
                <label class="content__desc" for="game_num_letters">Game <?php echo ($gameLevel == 3 || $gameLevel == 4 || $gameLevel == 6) ? 'Numbers' : 'Letters'; ?></label>
                <input type="text" name="game_num_letters" id="game_num_letters" class="form-control read-only" readonly value="<?php echo $gameNumLetterString; ?>">
                
                <label class="content__desc" for="<?php echo ($gameLevel == 3 || $gameLevel == 4 || $gameLevel == 6) ? 'answer_num' : 'answer_let'; ?>">Answer</label>
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
                    } else {

                        if(count($_SESSION['gainedLevels']) == TOTAL_LEVELS || $_SESSION['livesUsed'] > TOTAL_LIVES) {
                            echo <<<_WON_GAMEOVER
                            <input type="submit" class="game_btn btn btn-primary" value="Home Page" name="home_page">
                            <input type="submit" class="game_btn btn btn-primary" value="Play Again" name="play_again">
                            <input type="submit" class="game_btn btn btn-primary" value="Sign-Out" name="sign-out">

                            _WON_GAMEOVER;
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