
<!-- 
Ronald Mercado H.
Web Server Applications
21 March 2023
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

    public function registerPlayer(){

        if($this->connectToDBMS() === TRUE){
            if ($this->connectToDB() === TRUE){
                
                if ($this->executeSql($this->sqlCode()['userNameExist'])){
                    
                    if($this->sqlExec !== null && $this->sqlExec->num_rows > 0){
                        
                        $_SESSION['mensaje'] = "Player already exist, try another username";
                    
                    } else{
                        $stmt = $this->connection->prepare($this->sqlCode()['register']);
                        if ($stmt) {
                        // Link placeholder values ​​to actual values
                        $stmt->bind_param("sss", $this->firstname, $this->lastname, $this->username);
                        $stmt->execute(); 
                        $result = $stmt->get_result();
                        $stmt->close();
                    } else {                        
                        $this->lastErrMsg = $this->connection->error;
                        return FALSE;
                    }

                    $this->registrationOrder = mysqli_insert_id($this->connection);
                    $stmt2 = $this->connection->prepare($this->sqlCode()['insertPassword']);

                    if ($stmt2) {                        
                        $stmt2->bind_param("ss", $this->password, $this->registrationOrder);
                        $stmt2->execute();
                        $result = $stmt2->get_result();
                        $stmt2->close();
                    } else {
                        $this->lastErrMsg = $this->connection->error;
                        return FALSE;
                    }

                    $_SESSION['mensaje'] = "Player sussccesfuly inserted";
                }  
                    
                }else{  
                    die($this->messages()['link']['tryAgain']);
                    $_SESSION['mensaje'] = "there was an error, try again";                    
                }
            }else{
                
                die($this->messages()['link']['tryAgain']);
                $_SESSION['mensaje'] = "there was an error, try again";   
            }
        }else{
            die($this->messages()['link']['tryAgain']);
            $_SESSION['mensaje'] = "there was an error, try again";   
        }
    }
}

// Proccess components
$username = $password = $confirm_password = $firstname = $lastname =  "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    // validations
    $userName = usernameValidation($_POST['username']);   
    $password = passwordValidation($_POST['password']);    
    $confirm_password = confirmPasswordValidation($_POST['password'], $_POST['confirm_password']);    
    $firstname = firstnameValidation($_POST['firstname']);    
    $lastname = lastnameValidation($_POST['lastname']);
    $errorValidation = errorValidation();
    // new instance
    $newPlayer = new Register($firstname, $lastname, $userName, $password);
    $newPlayer->registerPlayer();
}
?>