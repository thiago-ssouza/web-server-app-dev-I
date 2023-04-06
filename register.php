
<!-- 
Ronald Mercado H.
Web Server Applications
21 March 2023
LaSalle College
Web Server Project - Registration Form
-->

<?php
require_once "functions.php";
require_once "registerController.php";


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
<?php require_once "navBar.php"; ?>
    <div class="content p-5">
        <h2 class="content__heading">Sign Up</h2>
        <?php
        if (isset($_SESSION['mensaje'])) {
            echo '<div class="alert alert-danger">' . $_SESSION['mensaje'] . "</div>";
            unset($_SESSION['mensaje']);
        }
        ?>
        <p  class="content__desc"> Please fill this form to create an account.</p>
        
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post"; >

            <div class="form-group">
                <label  class="content__desc">Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>

            <div class="form-group">
                <label  class="content__desc">Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>

            <div class="form-group">
                <label  class="content__desc">Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>

            <div class="form-group">
                <label  class="content__desc">First Name</label>
                <input type="text" name="firstname" class="form-control <?php echo (!empty($firstname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $firstname; ?>">
                <span class="invalid-feedback"><?php echo $firstname_err; ?></span>
            </div>

            <div class="form-group">
                <label  class="content__desc">Last Name</label>
                <input type="text" name="lastname" class="form-control <?php echo (!empty($lastname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $lastname; ?>">
                <span class="invalid-feedback"><?php echo $lastname_err; ?></span>
            </div>

            <div class="form-group">
                <input type="submit" class="game_btn btn-primary" value="Create" name = "send">                
            </div>
            <p  class="content__desc">Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>
    <?php require_once "footer.php";?>
</body>
</html>