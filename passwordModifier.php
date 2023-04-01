
<?php

//require_once "functions.php";
require_once "passwordModPost.php";
?>

<!-- -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <!-- <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style> -->
</head>
<body>
    <?php require"navBar.php" ?>
    <div class="content p-5">

        <h2 class="content__heading">Password Modifier</h2>
        <p  class="content__desc">Please fill in this form to modify your account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

            <div class="form-group">
                <label class="content__desc">Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"> <?php echo $username_err; ?> </span>
            </div>

            <div class="form-group">
                <label class="content__desc">New Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?> </span>
            </div>

            <div class="form-group">
                <label class="content__desc">Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"> <?php echo $confirm_password_err; ?> </span>
            </div>


            <div class="form-group">
                <input type="submit" class="game_btn btn-primary" value="Modify">                
            </div>
            <p class="content__desc">Already have an account? <a href="./login.php">Login here</a>.</p>
        </form>
    </div>    

    <?php require"footer.php" ?>
</body>
</html>