
<!-- 
Ronald Mercado H.
Web Server Applications
10 April 2023
LaSalle College
Web Server Project - Registration Form - Process
-->
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include config and functions files
require_once ("functions.php");
require_once ("DBMainV3.php");

class Register extends ManipulateDB {
 
      // Constructor     
      public function __construct($fName, $lName, $userName, $password) {
        parent::__construct();
        $this->firstname = $fName;
        $this->lastname = $lName;
        $this->username = $userName;            
        $this->password = $password;
    }
    
    public function registerPlayer() {
        // Check database connection
        if (!$this->connectToDBMS()) {
            $_SESSION['mensaje'] = "There was an error connecting to the database, please try again.";
            return;
        }
    
        if (!$this->connectToDB()) {
            $_SESSION['mensaje'] = "There was an error connecting to the database, please try again.";
            return;
        }
    
        $sqlResult = $this->executeSql($this->sqlCode()['userNameExist']);
        if (!$sqlResult) {
            $_SESSION['mensaje'] = "There was an error executing the SQL query, please try again.";
            return;
        }
    
        if ($this->sqlExec !== null && $this->sqlExec->num_rows > 0) {
            $_SESSION['mensaje'] = "Player already exists, please choose a different username.";
            return;
        }
    
        // Register player
        $stmt = $this->connection->prepare($this->sqlCode()['register']);
        if (!$stmt) {
            $this->lastErrMsg = $this->connection->error;
            $_SESSION['mensaje'] = "There was an error preparing the SQL statement, please try again.";
            return;
        }
    
        $stmt->bind_param("sss", $this->firstname, $this->lastname, $this->username);
        if (!$stmt->execute()) {
            $_SESSION['mensaje'] = "There was an error executing the SQL statement, please try again.";
            return;
        }
    
        $this->registrationOrder = mysqli_insert_id($this->connection);
        $stmt2 = $this->connection->prepare($this->sqlCode()['insertPassword']);
        if (!$stmt2) {
            $this->lastErrMsg = $this->connection->error;
            $_SESSION['mensaje'] = "There was an error preparing the SQL statement, please try again.";
            return;
        }
    
        $stmt2->bind_param("ss", $this->password, $this->registrationOrder);
        if (!$stmt2->execute()) {
            $_SESSION['mensaje'] = "There was an error executing the SQL statement, please try again.";
            return;
        }
        $_SESSION['mensaje'] = "Player sussccesfuly inserted.";
        
        // Close prepared statements
        $stmt->close();
        $stmt2->close();
    }
}

// Proccess components
$username = $password = $confirm_password = $firstname = $lastname =  "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    // validations
    $firstname = firstnameValidation($_POST['firstname']);    
    $lastname = lastnameValidation($_POST['lastname']); 
    $userName = usernameValidation($_POST['username']);    
    $password = passwordValidation($_POST['password']);    
    $confirm_password = confirmPasswordValidation($_POST['password'], $_POST['confirm_password']);

    // hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // run verification errors
    $error = errorValidation();
      
    if ($error == true) {
        $_SESSION['mensaje'] = "There was an error, please try again";
    }else{
        // sussccesfuly validations, new instance created
        $newPlayer = new Register($firstname, $lastname, $userName, $hashed_password);        
        $newPlayer->registerPlayer();        
    }
}
?>