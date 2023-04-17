<!-- 
Thiago Soares de Souza
Web Server Applications
12 March 2023
LaSalle College
Web Server Project - Login Form
-->

<?php

require_once "loginController.php";

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
        //require_once "header.php";
        require_once "navBar.php";
    ?>
    <!-- <div class="wrapper p-5 login_body"> -->
    <div class="content p-5">
    <article class="content__container">
        <h2 class="content__heading">Login</h2>
        <p class="content__desc">Please fill in your credentials to login.</p>

        <?php 
        if(!empty($dbMain->login_err)){
            echo '<div class="alert alert-danger">' . $dbMain->login_err . '</div>';
        }        
        ?>

        <!-- <form action="--><?php //echo htmlspecialchars($_SERVER["PHP_SELF"]); ?><!--" method="post"> -->
        <form name="sign-in" action="login.php" method="post">
            <div class="form-group">
                <label class="content__desc">Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $dbMain->username; ?>" placeholder="<?php echo $username_placeholder; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label class="content__desc">Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" placeholder="<?php echo $password_placeholder; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="game_btn btn-primary" value="Connect" name="connect">   
                <input type="submit" class="game_btn btn-primary" value="Sign-Up" name="sign-up" onclick="sign-in.action='register.php'" >
            </div>
            <?php 
            if(!empty($dbMain->login_err)){
                echo '<p class="content__desc">Forgotten? Please, <a href="passwordModifier.php">change your password!!!</a></p>';
            }        
            ?>
        </form>
    </article>
    </div>

    <?php
        require_once "footer.php";
    ?>
</body>
</html>