<?php

    require('DBMainV3.php')

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <?php
        require_once "navBar.php";
    ?>
    <div class="wrapper p-5">
        <?php
        $db = new ManipulateDB();

        $db->createDBandTAB();
        //$db->insertMockDataToTABs();

        header("location: login.php");

        
        ?>
    </div>

    <?php
        require_once "footer.php";
    ?>
</body>
</html>