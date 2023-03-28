<!-- 
Thiago Soares de Souza
Web Server Applications
26 March 2023
LaSalle College
Web Server Project - Game 4 Form
-->

<?php

require_once "game4Controller.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Game Leve 4</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!--<link rel="stylesheet" href="./css/style.css">-->
</head>
<body>
    <?php
        //require_once "header.php";
        require_once "navBar.php";
    ?>
    <div class="wrapper p-5">
        <h2>Game Level 4: <?php echo $instructions; ?></h2>
        <p>Please <?php echo $instructions; ?> (from 100 to 0).</p>
        <p>** put ',' between the numbers (Example: 5,4,3,2,1,0).</p>

        <?php 

        if(!empty($answer_err)){
            echo '<div class="alert alert-danger">' . $answer_err . '</div>';
        }        
        ?>

        <form name="sign-in" action="game4.php" method="post">
            <div class="form-group">
                <label for="answer">Answer</label>
                <input type="text" name="answer" id="answer" class="form-control <?php echo (!empty($answer_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $answer; ?>" placeholder="<?php echo $answer_placeholder; ?>">
                <span class="invalid-feedback"><?php echo $answer_err; ?></span>
                <label for="">Game Numbers</label>
                <input type="text" name="game_num_letters" class="form-control read-only" readonly value="<?php echo $gameNumLetterString; ?>">

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
            <div class="form-group">
                <?php
                    if (!$submitPressed || !empty($answer_err)) {
                        echo <<<_NOTSUBMIT
                            <input type="submit" class="btn btn-primary" value="Submit Answer" name="send">
                            <input type="submit" class="btn btn-primary" value="Sign-Out" name="sign-out" >
                        _NOTSUBMIT;
                    } else {

                        if(count($_SESSION['gainedLevels']) == TOTAL_LEVELS || $_SESSION['livesUsed'] > TOTAL_LIVES) { 
                            echo <<<_WON_GAMEOVER
                            <input type="submit" class="btn btn-primary" value="Home Page" name="home_page" >
                            <input type="submit" class="btn btn-primary" value="Play Again" name="play_again" >
                            <input type="submit" class="btn btn-primary" value="Sign-Out" name="sign-out" >
                            _WON_GAMEOVER;
                        } else {
                            echo <<<_SUBMIT
                            <input type="submit" class="btn btn-primary" value="Sign-Out" name="sign-out" >
                            <input type="submit" class="btn btn-primary" value="Stop this Session" name="stop_session" >
                            _SUBMIT;

                            if (!$playerWon) {
                                echo <<<_NOTWON
                                <input type="submit" class="btn btn-primary" value="Try Again this Level" name="try_again" >
                                _NOTWON;
                            } else {
                                echo <<<_WON
                                <input type="submit" class="btn btn-primary" value="Go the Next Level" name="next_level">   
                                _WON;
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