<?php

    require('DBMainV3.php');


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>


    <link rel="stylesheet" href="./css/style.css">
   

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php
       require_once "navBar.php";
    ?>

    <div class="hero" id="home">
            <div class="hero__container">
                <h1 class="hero__heading">Web developement <span>Final Project</span></h1>
                <p class="hero__desc">Login to play</p>
                <button class="main__btn"><a href="login.php">Login</a></button>
            </div>

            <?php
        $db = new ManipulateDB();

        $db->createDBandTAB();
        //$db->insertMockDataToTABs();

        //header("location: login.php");

        
        ?>
        </div>

   

    <?php
       require_once "footer.php";
    ?>
</body>
</html>