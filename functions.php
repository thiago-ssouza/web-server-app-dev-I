<?php

// Define variables and initialize with empty values


// *****************************  Registration Functions **************************************

$username_err = $password_err = $confirm_password_err = $firstname_err = $lastname_err = "";

// username validation
function usernameValidation($username){
    global $username_err;

    if(empty($username)){        
        $username_err = "Please enter a username !";
    } 
    elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($username))){
        $username_err = "Username can only contain letters, numbers, and underscores.";
    }else{
        return strtolower(trim($username));
    }
}

// password validation
function passwordValidation($password){    
    
    global $password_err;
    // Validate password
    if(empty(trim($password))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($password)) < 6){
        $password_err = "Password must have at least 6 characters.";
    }else{
        return $password;
    }    
    
}

// Validate confirm password
function confirmPasswordValidation($password , $confirm_password){

    global $confirm_password_err;    
    
    if(empty(trim($confirm_password))){
        
        $confirm_password_err = "Please confirm password.";     
    } 
    else if (($confirm_password != $password)) {
      
        $confirm_password_err = "Sorry, you entered 2 different passwords.";
               
    }else{
        return $confirm_password;
    }
    
}

// firstname validation
function firstnameValidation($firstname){
    global $firstname_err;

    if(empty(trim($firstname))){        
        $firstname_err = "Please enter a first name.";
    }else{
        return $firstname;
    }
    
}

// lastname validation
function lastnameValidation($lastname){
    
    global $lastname_err;

    if(empty(trim($lastname))){        
        $lastname_err = "Please enter a last name.";
    }else{
        return $lastname;
    }
    
}

// validation no errors
function errorValidation(){
    
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($firstname_err) && empty($lastname_err))
        return true;
    else
        return false;
   
}

// ************************* Login functions ****************************************

// Declare and initializing variable with empty values
$login_err = "";

/// Validate no username and password error
function validateNoError(){
    
    if(empty($username_err) && empty($password_err))
        return true;
    else
        return false;
}


// ************************* Add below other functions ****************************************

function validatePasswordModify(){
    
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err))
        return true;
    else
        return false;
}

// ************************* Game functions ****************************************

// Declare and initializing variable with empty values
$playerWon = $submitPressed = FALSE;
$answer = $resultLevel = $resultLevelMsg = $answer_err = $instructions = $gameNumLetterString = $gameNumLetterStringSorted = "";
$answerArr = $gameNumLetterArr = $gameNumLetterArrSorted = array();

$gameLevel; // > values assigned depending on level game

define('MAX_NUMBER', 100);
define('MIN_NUMBER', 0);
define('TOTAL_GAME_NUM_CHAR_ARRAY', 6);
define('TOTAL_ANSWER_ARRAY_LEVEL_1_2_3_4', 6);
define('TOTAL_ANSWER_ARRAY_LEVEL_5_6', 2);
define('ASCII_A_LOWER', 97);
define('ASCII_Z_LOWER', 122);
define('TOTAL_LIVES', 6);
define('TOTAL_LEVELS', 6);
define('TOTAL_LETTERS', 'abcdefghijklmnopqrstuvwxyz' );

function generateArrayNumbers() {
    $arrNum = [];

    for($i = 0 ; $i < TOTAL_GAME_NUM_CHAR_ARRAY ; $i++){
        
        $numAux = 0; // variable were asking for initialization

        do {
            $numAux = rand(MIN_NUMBER,MAX_NUMBER);
        } while(in_array($numAux, $arrNum, TRUE));
        
        $arrNum[$i] = $numAux;
    }

    return $arrNum;

}

function generateArrayLetters() {
    $arrLetters = [];

    for($i = 0 ; $i < TOTAL_GAME_NUM_CHAR_ARRAY ; $i++){
        
        do {
            $charAux = chr(rand(ASCII_A_LOWER,ASCII_Z_LOWER));
        } while(in_array($charAux, $arrLetters, TRUE));
         $arrLetters[$i] = $charAux;
    }
    return $arrLetters;
}

function getStringWithCommaFromArray($arrayNumLetter){
    $strResult = '';
    for($i = 0 ; $i < count($arrayNumLetter) ; $i++){
        if($i == (count($arrayNumLetter) - 1)){
            $strResult = $strResult . $arrayNumLetter[$i];
            break;
        }
        $strResult = $strResult . $arrayNumLetter[$i] . ',';
    }
    return $strResult;
}
function generateNumbersLetters() {
    global $gameLevel;
    global $gameNumLetterArr;
    global $gameNumLetterString;
    switch ($gameLevel) {
        case 1:
        case 2:
            $gameNumLetterArr = generateArrayLetters();
            $gameNumLetterString = getStringWithCommaFromArray($gameNumLetterArr);
            break;
        case 3:
        case 4:
            $gameNumLetterArr = generateArrayNumbers();
            $gameNumLetterString = getStringWithCommaFromArray($gameNumLetterArr);
            break;
        case 5:
            $gameNumLetterArr = generateArrayLetters();
            $gameNumLetterString = getStringWithCommaFromArray($gameNumLetterArr);
            break;
        case 6:
            $gameNumLetterArr = generateArrayNumbers();
            $gameNumLetterString = getStringWithCommaFromArray($gameNumLetterArr);
            break;
    }
}
function isAnswerArrayOfNumbers() {
    
    global $answerArr;
    
    foreach($answerArr as $element) {
        if(!is_numeric($element)){
            return false;
        }
    }
    return true;
}
function isAnswerArrayOfLetters() {
    
    global $answerArr;
    
    foreach($answerArr as $element) {
        if(!ctype_alpha($element)){
            return false;
        }
    }
    return true;
}
function getStringNumbersOrLetters(){
    global $gameLevel;
    if($gameLevel == 3 || $gameLevel == 4 || $gameLevel == 6) {
        return 'numbers';
    }else {
        return 'letters';
    }
}
function validateEntryAnswer(){
    
    global $answer_err;
    global $answer;
    global $answerArr;
    global $gameLevel;
    $numbersOrLetters = getStringNumbersOrLetters();
    $answer = strtolower($answer);
    if(empty($answer)){        
        $answer_err = "Please enter a valid answer!";
        return false;
    }
    if($answer[strlen($answer) - 1] == ','){
        $answer = substr($answer, 0, strlen($answer) - 1);
    }
    $answerArr = explode(',', $answer);
    if($gameLevel == 1 || $gameLevel == 2 || $gameLevel == 3 || $gameLevel == 4) {
        if(count($answerArr) != TOTAL_ANSWER_ARRAY_LEVEL_1_2_3_4){
            $answer_err = "Please enter " . TOTAL_ANSWER_ARRAY_LEVEL_1_2_3_4 . " " . $numbersOrLetters . " between ',' (comma)!";
            return false;
        }
    }else {
        if(count($answerArr) != TOTAL_ANSWER_ARRAY_LEVEL_5_6){
            $answer_err = "Please enter " . TOTAL_ANSWER_ARRAY_LEVEL_5_6 . " " . $numbersOrLetters . " between ',' (comma)!";
            return false;
        }
    }
    if($gameLevel == 3 || $gameLevel == 4 || $gameLevel == 6) {
        if(!isAnswerArrayOfNumbers()){
            $answer_err = "Please enter only " . $numbersOrLetters . " between ',' (comma) !";
            return false;
        }
    }else {
        if(!isAnswerArrayOfLetters()){
            $answer_err = "Please enter only " . $numbersOrLetters . " between ',' (comma) !";
            return false;
        }
    }
    return true;
}
function compareArrayNumbersLetters() {
    global $gameLevel;
    global $gameNumLetterArrSorted;
    global $answerArr;
    global $resultLevel;
    global $instructions;
    $numbersOrLetters = getStringNumbersOrLetters();
    $ascendingOrDescending = (strpos($instructions, "ascending")) ? "ascending" : "descending";
    
    $arrIntersec = array_intersect($gameNumLetterArrSorted, $answerArr);
    if(empty($arrIntersec)){
        $resultLevel = "Incorrect - All your " . $numbersOrLetters . " are different than ours";
    } else {
        if(count($arrIntersec) == TOTAL_ANSWER_ARRAY_LEVEL_1_2_3_4) {
            if($gameNumLetterArrSorted === $answerArr){
                $resultLevel = "Correct - Your " . $numbersOrLetters . " have been correctly ordered in " . $ascendingOrDescending . " order";
            }else{
                $resultLevel = "Incorrect - Your " . $numbersOrLetters . " have not been correctly ordered in " . $ascendingOrDescending . " order";
            }           
        }else {
            $resultLevel = "Incorrect - Some of your " . $numbersOrLetters . " are different than ours";
        }
    }
}
function checkMinMaxNumber() {
    global $gameLevel;
    global $gameNumLetterArr;
    global $answerArr;
    global $resultLevel;
    $numbersOrLetters = getStringNumbersOrLetters();
    $arrIntersec = array_intersect($gameNumLetterArr, $answerArr);
    $gameArr =array();
    foreach($gameNumLetterArr as $n){
        $gameArr[] = intval($n);
    }
    $ansArr = array();
    foreach($answerArr as $n){
        $ansArr[] = intval($n);
    }

    if(empty($arrIntersec)){
        $resultLevel = "Incorrect - All your " . $numbersOrLetters . " are different than ours";
    } else {
        if(count($arrIntersec) == TOTAL_ANSWER_ARRAY_LEVEL_5_6) {
            if(min($gameArr) == $ansArr[0]&& max($gameArr) === $ansArr[1]){
                $resultLevel = "Correct - Your " . $numbersOrLetters . " is the correct minimum and maximum numbers";
            }else{
                $resultLevel = "Incorrect - Your " . $numbersOrLetters . " is not the correct minimum and maximum numbers";
            }    
        }else {
            $resultLevel = "Incorrect - Some of your " . $numbersOrLetters . " are different than ours";
        }
    }
}
function checkFirstLastLetter(){
    global $gameLevel;
    global $gameNumLetterArr;
    global $gameNumLetterArrSorted;
    global $answerArr;
    global $resultLevel;
    $numbersOrLetters = getStringNumbersOrLetters();
    $arrIntersec = array_intersect($gameNumLetterArrSorted, $answerArr);

    if(empty($arrIntersec)){
        $resultLevel = "Incorrect - All your " . $numbersOrLetters . " are different than ours";
    } else {
        if(count($arrIntersec) == TOTAL_ANSWER_ARRAY_LEVEL_5_6) {
            if($gameNumLetterArrSorted[0] == $answerArr[0]&& $gameNumLetterArrSorted[TOTAL_GAME_NUM_CHAR_ARRAY-1] === $answerArr[1]){
                $resultLevel = "Correct - Your " . $numbersOrLetters . " is the correct first and last letters";
            }else{
                $resultLevel = "Incorrect - Your " . $numbersOrLetters . " is not the correct first and last letters";
            }    
        }else {
            $resultLevel = "Incorrect - Some of your " . $numbersOrLetters . " are different than ours";
        }
    }
}
function validateCorrectAnswer() {
    global $gameLevel;
    global $gameNumLetterArr;
    global $gameNumLetterArrSorted;
    global $gameNumLetterStringSorted;
    $gameNumLetterArrSorted = $gameNumLetterArr;
    switch ($gameLevel) {
        case 1:
            sort($gameNumLetterArrSorted);

            $gameNumLetterStringSorted = getStringWithCommaFromArray($gameNumLetterArrSorted);

            compareArrayNumbersLetters();
            break;
        case 2:
            rsort($gameNumLetterArrSorted);

            $gameNumLetterStringSorted = getStringWithCommaFromArray($gameNumLetterArrSorted);

            compareArrayNumbersLetters();
            break;
        case 3:
            // call here the function to validate the game3
            
            sort($gameNumLetterArrSorted);

            $gameNumLetterStringSorted = getStringWithCommaFromArray($gameNumLetterArrSorted);

            compareArrayNumbersLetters();

            break;
        case 4:
            // call here the function to validate the game4

            rsort($gameNumLetterArrSorted);

            $gameNumLetterStringSorted = getStringWithCommaFromArray($gameNumLetterArrSorted);

            compareArrayNumbersLetters();

            break;
        case 5:
            // call here the function to validate the game5

            sort($gameNumLetterArrSorted);
            $gameNumLetterStringSorted = getStringWithCommaFromArray($gameNumLetterArrSorted);


            checkFirstLastLetter();

            break;
        case 6:
            // call here the function to validate the game6
            $gameNumLetterStringSorted = getStringWithCommaFromArray($gameNumLetterArrSorted);

            checkMinMaxNumber();
            break;
    }

}

function getInstructions() {

    global $gameLevel;
    global $instructions;

    switch ($gameLevel) {
        case 1:
            // Game Level 1: Order letters in ascending order
            $instructions = 'Order these letters in ascending order';
            break;
        case 2:
            // Game Level 2: Order letters in descending order
            $instructions = 'Order these letters in descending order';
            break;
        case 3:
            //Game Level 3: Order numbers in ascending order
            $instructions = 'order these numbers in ascending order';
            break;
        case 4:
            //Game Level 4: Order numbers in descending order
            $instructions = 'order these numbers in descending order';
            break;
        case 5:
            // Game Level 5: identify first and last letters from a set of letters
            $instructions = 'identify first and last letters from a set of letter';
            break;
        case 6:
            // Game Level 6: identify the minimum and the maximum numbers from a set of numbers
            $instructions = 'identify the minimum and the maximum numbers from a set of numbers';
            break;
    }

}

function getResultLevelMsg() {
    
    global $resultLevel;
    global $gameNumLetterStringSorted;
    global $answer;
    global $resultLevelMsg;
    global $instructions;
    
    $numbersOrLetters = getStringNumbersOrLetters();

    $resultLevelMsg = "Game " . $numbersOrLetters . ": " . $gameNumLetterStringSorted .
    "<br/>Instructions: " . ucfirst($instructions) .
    "<br/>Your " . $numbersOrLetters . ": " . $answer .
    "<br/>Result: " . $resultLevel;

}


function resetLivesAndDateTimeSession(){
    $_SESSION['livesUsed'] = 1;
    $_SESSION['startTime'] = date('Y-m-d H:i:s');
    $_SESSION['gainedLevels'] = [];
    $_SESSION['gameOver'] = false;
    $_SESSION['result'] = 'incomplete';    
}



// *********************** Aditional functions *********************** //

function setData($dbMain) {
    $dbMain->username = $_SESSION['username'];
    $dbMain->firstname = $_SESSION['fName'];
    $dbMain->lastname = $_SESSION['lName'];
    $dbMain->registrationOrder = $_SESSION['registrationOrder'];    
    $dbMain->scoreTime = date('Y-m-d H:i:s');
    $dbMain->result = $_SESSION['result'];
    $dbMain->livesUsed = $_SESSION['livesUsed'];
}

function session_dest(){
    session_destroy();
    header("location: login.php");
    exit;
}

function checkPlayerCanAccessLevelOrRedirectPlayer() {
    
    global $gameLevel;
    
    if(isset($_SESSION['loggedin']) && !(in_array(($gameLevel-1), $_SESSION['gainedLevels'], true))) {
        if(!(in_array(TOTAL_LEVELS, $_SESSION['gainedLevels']))){
            header("location: game" . ( ($_SESSION['gainedLevels'][count($_SESSION['gainedLevels'])-1]) + 1) . ".php");
        } else{
            header("location: game" . ( ($_SESSION['gainedLevels'][count($_SESSION['gainedLevels'])-1])) . ".php");
        }
        exit;
    }
}


?>