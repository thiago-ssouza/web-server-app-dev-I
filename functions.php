<?php

require_once "config.php";




// *****************************  Registration Functions **************************************

// username validation
function usernameValidation($username){

    if(empty(trim($username))){
        $username_err = "Please enter a username.";
    } 
    elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($username))){
        $username_err = "Username can only contain letters, numbers, and underscores.";
    }
    return $username;
}

// password validation
function passwordValidation($password){    
    // Validate password
    if(empty(trim($password))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($password)) < 6){
        $password_err = "Password must have atleast 6 characters.";
    }    
    return $password;
}

// Validate confirm password
function confirmPasswordValidation($password , $confirm_password){

    if(empty(trim($confirm_password))){
        
        $confirm_password_err = "Please confirm password.";     
    } 
    else{       
        $confirm_password = trim($confirm_password);
        
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Sorry, you entered 2 different passwords.";
        }        
    }
    return $confirm_password;
}

// validation no errors
function errorValidation(){
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err))
        return true;
}



// ************************* Add below other functions ****************************************



?>