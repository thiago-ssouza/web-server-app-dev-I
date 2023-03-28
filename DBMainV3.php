<?php

define('HOST','localhost');
define('USER','root');
define('PASS','');
define('DBNAME','kidsGames');

class ManipulateDB
{   
    //Declare the properties
    public $firstname, $lastname, $username, $registrationOrder,$newPassword, $password, $login_err, $scoreTime, $result, $livesUsed;
    
    // Changed to protected to get acces from register class >> before was private $connection;
    protected $connection; 
    protected $sqlExec, $lastErrMsg;

    //Declare the method constructor
    public function __construct(){

    }

    public function getSqlExec() {
        return $this->sqlExec;
    }

    //Declare the method to save the messages
    protected function messages(){
        //Error messages 
        $m['dbms'] = "<p>Connection to MySQL failed!<br/>$this->lastErrMsg</p>";
        $m['db'] = "<p>Connection to the DB failed!<br/>$this->lastErrMsg</p>";
        $m['creatDb'] = "<p>Creation of the DB failed!<br/>$this->lastErrMsg</p>";
        $m['creatTab'] = "<p>Creation of the Table failed!<br/>$this->lastErrMsg</p>";
        $m['insertTab'] = "<p>Data insertion to the Table failed!<br/>$this->lastErrMsg</p>";
        $m['selectTab'] = "<p>Data selection from the Table failed!<br/>$this->lastErrMsg</p>";
        $m['desTab'] = "<p>Table structure description failed!<br/>$this->lastErrMsg</p>";
        // Added
        $m['userExist'] = "<p>User name already exist<br/>$this->lastErrMsg</p>";
        $m['userNotExist'] = "<p>User name NOT exist<br/>$this->lastErrMsg</p>";
        $m['invalidUsernamePass'] = "Invalid username or password.";
        
        //Try again messages
        $b['tryAgain'] = "<a href=\"index.php\"><input type=\"submit\" value=\"Try again!\"></a>";
        //Group messages by category 
        $msg['error'] = $m;
        $msg['link'] = $b;
        return $msg;
    }

    //Declare the method to save the SQL Code to be executed
    //protected function sqlCode(){
    protected function sqlCode(){
        //Create queries

        //$name = DBNAME;

        $sqlCode['creatDb'] = "CREATE DATABASE IF NOT EXISTS " . DBNAME;

        $sqlCode['creatTabs'] = 
        "CREATE TABLE IF NOT EXISTS player( 
            fName VARCHAR(50) NOT NULL, 
            lName VARCHAR(50) NOT NULL, 
            userName VARCHAR(20) NOT NULL UNIQUE,
            registrationTime DATETIME NOT NULL,
            id VARCHAR(200) GENERATED ALWAYS AS (CONCAT(UPPER(LEFT(fName,2)),UPPER(LEFT(lName,2)),UPPER(LEFT(userName,3)),CAST(registrationTime AS SIGNED))),
            registrationOrder INTEGER AUTO_INCREMENT,
            PRIMARY KEY (registrationOrder)
        )CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci; 
        
        CREATE TABLE IF NOT EXISTS authenticator(   
            passCode VARCHAR(255) NOT NULL,
            registrationOrder INTEGER, 
            FOREIGN KEY (registrationOrder) REFERENCES player(registrationOrder)
        )CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci; 
        
        CREATE TABLE IF NOT EXISTS score( 
            scoreTime DATETIME NOT NULL, 
            result ENUM('success', 'failure', 'incomplete'),
            livesUsed INTEGER NOT NULL,
            registrationOrder INTEGER, 
            FOREIGN KEY (registrationOrder) REFERENCES player(registrationOrder)
        )CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci; 
        
        CREATE VIEW history AS
            SELECT s.scoreTime, p.id, p.fName, p.lName, s.result, s.livesUsed 
            FROM player p, score s
            WHERE p.registrationOrder = s.registrationOrder;
        ";

        $sqlCode['selectTab'] = "SELECT * FROM player;";

        $sqlCode['descTab'] = "DESC player;";

        $sqlCode['insertMockDataToTABs']=
        "INSERT INTO player(fName, lName, userName, registrationTime)
        VALUES('Patrick','Saint-Louis', 'sonic12345', now()); 
        INSERT INTO player(fName, lName, userName, registrationTime)
        VALUES('Marie','Jourdain', 'asterix2023', now());
        INSERT INTO player(fName, lName, userName, registrationTime)
        VALUES('Jonathan','David', 'pokemon527', now());
        INSERT INTO player(fName, lName, userName, registrationTime)
        VALUES('Thiago','Souza', 'tss12345', now());
        INSERT INTO authenticator(passCode, registrationOrder)
        VALUES('\$2y\$10\$fxMTc4KD4mZlj03wc4grTuVLssP0ZKxeqfcfvxVx2xnrrKF.CKsk.', 1);
        INSERT INTO authenticator(passCode, registrationOrder)
        VALUES('\$2y\$10\$AH/612QosAUyKIy5s4lEBuGdNAhnw.PbHYfIuLNK2aHQXWRMIF6fi', 2);
        INSERT INTO authenticator(passCode, registrationOrder)
        VALUES('\$2y\$10\$rSNEZ5wd8YyRRlNCmwfb2uUvkffrAMdmLkcm5s.b7WAgiGy8UoA1i', 3);
        INSERT INTO authenticator(passCode, registrationOrder)
        VALUES('\$2y\$10$6G0dZjvsyRQ6sB99NWs7u.ZGFY9eMaI2JM62qFtHr3n28MTRKhc5K', 4);
        INSERT INTO score(scoreTime, result , livesUsed, registrationOrder)
        VALUES(now(), 'success', 4, 1);
        INSERT INTO score(scoreTime, result , livesUsed, registrationOrder)
        VALUES(now(), 'failure', 6, 2);
        INSERT INTO score(scoreTime, result , livesUsed, registrationOrder)
        VALUES(now(), 'incomplete', 5, 3);
        INSERT INTO score(scoreTime, result , livesUsed, registrationOrder)
        VALUES(now(), 'success', 2, 4);
        
        ";

        //$sqlCode['checkPlayerExist'] = "SELECT * FROM player where registrationOrder=$this->registrationOrder;";
        
        $sqlCode['checkPlayerCredentials'] = "SELECT id, userName, passCode, fName, lName, player.registrationOrder FROM player JOIN authenticator ON player.registrationOrder = authenticator.registrationOrder WHERE username = '$this->username';"; 
        //$sqlCode['checkPlayerExist'] = "SELECT id, userName, passCode FROM player JOIN authenticator ON player.registrationOrder = authenticator.registrationOrder WHERE username = 'tss12345';"; 
        
        // added (ronald)
        $sqlCode['userNameExist'] = "SELECT * FROM player where userName = '$this->username';";
        // added (ronald)
        $sqlCode['register'] = "INSERT INTO player(fName, lName, userName, registrationTime) 
        VALUES (?, ?, ?, now())";
        // added (ronald)
        $sqlCode['insertPassword'] = "INSERT INTO authenticator(passCode,registrationOrder)
        VALUES(?, ?)";            

        $sqlCode['changePassword']="UPDATE authenticator SET passCode = $this->newPassword where registrationOrder= $this->registrationOrder";
            
        $sqlCode['checkPasswordExists']="SELECT passCode FROM authenticator where registrationOrder= $this->registrationOrder";

        $sqlCode['insertScore']= "INSERT INTO score(scoreTime, result , livesUsed, registrationOrder)
        VALUES('$this->scoreTime', '$this->result', $this->livesUsed, $this->registrationOrder)";
                  
        /*
        $sqlCode['register']="INSERT INTO player(fName, lName, userName, registrationTime) 
        VALUES($this->firstname, $this->lastname, $this->username, date());";

        $sqlCode['insertPassword'] = "INSERT INTO authenticator(passCode,registrationOrder)
        VALUES('$this->newPassword', $this->registrationOrder)";

        $sqlCode['insertPassword']="INSERT INTO authenticator(passCode,registrationOrder)
        VALUES($this->newPassword, $this->registrationOrder);";
        */
                
        //Return an array of queries
        return $sqlCode;
    }

    //Declare the method to connect to the DBMS
    protected function connectToDBMS()
    {
        //Attempt to connect to MySQL using MySQLi
        $con = new mysqli(HOST, USER, PASS);
        //If connection to the MySQL failed save the system error message 
        if ($con->connect_error) {
            $this->lastErrMsg = mysqli_connect_error();
            return FALSE;
        } else {
            $this->connection = $con;
            return TRUE;
        }
    }

    //Declare the method to connect to the DB
    protected function connectToDB()
    {
        //If connection to the Database failed save the system error message 
        if (mysqli_select_db($this->connection, DBNAME) === FALSE) {
            $this->lastErrMsg = $this->connection->error;
            return FALSE;
        } else {
            return TRUE;
        }
    }

    //Declare the method to execute the SQL Code 
    //protected function executeSql($code)
    protected function executeSql($code)
    {
        //Execute the query
        $invokeQuery = $this->connection->query($code);
        //If data insertion to the table failed save the system error message  
        if ($invokeQuery === FALSE) {
            $this->lastErrMsg = $this->connection->error;
            return FALSE;
        } else
            $this->sqlExec = $invokeQuery;
        return TRUE;
    }

    protected function executeSqlMultiQuery($code)
    {
        //Execute the query

        $invokeQuery = $this->connection->multi_query($code);
        //If data insertion to the table failed save the system error message  
        if ($invokeQuery === FALSE) {
            $this->lastErrMsg = $this->connection->error;
            return FALSE;
        } else
            $this->sqlExec = $invokeQuery;
        return TRUE;
    }


    //Declare the method to disconnect from the DBMS
    public function __destruct()
    {
        //Close automatically the connection from MySQL when it is opened at the end          
        if ($this->connection == TRUE) {
            $this->connection->close();
        }
    }

    public function createDBandTAB()
    {
        //1-Connect to the DBMS
        if ($this->connectToDBMS() === TRUE) {
            //2-Create the DB if it does not exist yet
            $check = $this->executeSql($this->sqlCode()['creatDb']);
            $err = $this->messages()['error']['creatDb'];
            $find = 'database exists';
            if (($check === TRUE) || ($check === FALSE && strpos($err, $find) !== FALSE)) {
                //3-Connect to the DB
                if ($this->connectToDB() === TRUE) {
                    //4-Create the Table if it does not exist yet
                    //echo $this->sqlCode()['creatTabs'];
                    $check = $this->executeSqlMultiQuery($this->sqlCode()['creatTabs']);
                    $err = $this->messages()['error']['creatTab'];
                    $find = 'already exists';
                    //Cannot Create the Table even if it does not exist yet
                    if (($check === FALSE && strpos($err, $find) === FALSE)) {
                        echo $this->messages()['link']['tryAgain'];
                        die($this->messages()['error']['creatTab']);
                    }
                }
                //Cannot Connect to the DB
                else {
                    echo $this->messages()['link']['tryAgain'];
                    die($this->messages()['error']['db']);
                }
            }
            //Cannot Create the DB even if it does not exist yet 
            else {
                echo $this->messages()['link']['tryAgain'];
                die($this->messages()['error']['creatDb']);
            }
        }
        //Cannot Connect to the DBMS
        else {
            die($this->messages()['error']['dbms']);
        }
    }

    public function insertMockDataToTABs()
    {
        //1-Connect to the DBMS
        if ($this->connectToDBMS() === TRUE) {
                //2-Connect to the DB
                if ($this->connectToDB() === TRUE) {
                    //3-Check that the Table exists 
                    if ($this->executeSql($this->sqlCode()['descTab']) === TRUE) {
                        //4-Insert data to the Table
                        //Cannot Insert data to the Table
                        if ($this->executeSqlMultiQuery($this->sqlCode()['insertMockDataToTABs']) === FALSE) {
                            echo $this->messages()['link']['tryAgain'];
                            die($this->messages()['error']['insertTab']);
                        }
                    }
                    //Cannot Check that the Table exists
                    else{
                        echo $this->messages()['link']['tryAgain'];
                        die($this->messages()['error']['desTab']);
                    }
                }
                //Cannot Connect to the DB
                else {
                    echo $this->messages()['link']['tryAgain'];
                    die($this->messages()['error']['insertTab']);
                }        
        }
        //Cannot Connect to the DBMS
        else {
            die($this->messages()['error']['dbms']);
        }
    }

    //Declare the method to display selected data 
    public function displaySelectData(){
        //Calculate the number of rows available
        $number_of_rows = $this->sqlExec->num_rows;
        //Use a loop to display the rows one by one
        echo "<table>";
        echo "<tr><td>fName</td><td>lName</td><td>userName</td><td>registrationTime</td><td>id</td><td>registrationOrder</td></tr>";
        for ($j = 0; $j < $number_of_rows; ++$j) {
            echo "<tr>";
            //Assign the records of each row to an associative array
            $each_row = $this->sqlExec->fetch_array(MYSQLI_ASSOC);
            //Display each the record corresponding to each column
            foreach ($each_row as $item)
                echo "<td>" . $item . "</td>";
            echo "</tr>";
        }   
        echo "</table>";
    }

    public function displaySelectDataFindUser(){
        //Calculate the number of rows available
        $number_of_rows = $this->sqlExec->num_rows;
        //Use a loop to display the rows one by one
        echo "<table>";
        echo "<tr><td>id</td><td>userName</td><td>passCode</td></tr>";
        for ($j = 0; $j < $number_of_rows; ++$j) {
            echo "<tr>";
            //Assign the records of each row to an associative array
            $each_row = $this->sqlExec->fetch_array(MYSQLI_ASSOC);
            //Display each the record corresponding to each column
            foreach ($each_row as $item)
                echo "<td>" . $item . "</td>";
            echo "</tr>";
        }   
        echo "</table>";
    }

    public function selectFromTAB()
    {
        //1-Connect to the DBMS
        if ($this->connectToDBMS() === TRUE) {
                //2-Connect to the DB
                if ($this->connectToDB() === TRUE) {
                    //3-Check that the Table exists 
                    if ($this->executeSql($this->sqlCode()['descTab']) === TRUE) {
                        //4-Select data From the Table
                        if ($this->executeSql($this->sqlCode()['selectTab']) === TRUE) {
                            $this->displaySelectData();
                        }
                        //Cannot Select data From the Table
                        else{
                            echo $this->messages()['link']['tryAgain'];
                            die($this->messages()['error']['selectTab']);
                        }
                    }
                    //Cannot Check that the Table exists
                    else{
                        echo $this->messages()['link']['tryAgain'];
                        die($this->messages()['error']['desTab']);
                    }
                }
                //Cannot Connect to the DB
                else {
                    echo $this->messages()['link']['tryAgain'];
                    die($this->messages()['error']['insertTab']);
                }        
        }
        //Cannot Connect to the DBMS
        else {
            die($this->messages()['error']['dbms']);
        }
    }

    public function selectFromTABPlayerAuthenByUsername()
    {
        //1-Connect to the DBMS
        if ($this->connectToDBMS() === TRUE) {
                //2-Connect to the DB
                if ($this->connectToDB() === TRUE) {
                    //3-Check that the Table exists 
                    if ($this->executeSql($this->sqlCode()['descTab']) === TRUE) {
                        //4-Select data From the Table
                        if ($this->executeSql($this->sqlCode()['checkPlayerExist']) === TRUE) {
                            $this->displaySelectDataFindUser();
                        }
                        //Cannot Select data From the Table
                        else{
                            echo $this->messages()['link']['tryAgain'];
                            die($this->messages()['error']['selectTab']);
                        }
                    }
                    //Cannot Check that the Table exists
                    else{
                        echo $this->messages()['link']['tryAgain'];
                        die($this->messages()['error']['desTab']);
                    }
                }
                //Cannot Connect to the DB
                else {
                    echo $this->messages()['link']['tryAgain'];
                    die($this->messages()['error']['insertTab']);
                }        
        }
        //Cannot Connect to the DBMS
        else {
            die($this->messages()['error']['dbms']);
        }
    }

    public function loginPlayer()
    {
        //1-Connect to the DBMS
        if ($this->connectToDBMS() === TRUE) {

                //2-Connect to the DB
                if ($this->connectToDB() === TRUE) {
                    
                    if(validateNoError()){
                            
                        if ($this->executeSql($this->sqlCode()['checkPlayerCredentials']) === TRUE) {

                            $number_of_rows = $this->sqlExec->num_rows;

                            if($number_of_rows == 1){
                                $each_row = $this->sqlExec->fetch_array(MYSQLI_ASSOC);
                                
                                ///way to print every
                                // foreach ($each_row as $item){
                                //     echo "<p>" . $item . "</p>";
                                // }

                                $id = $each_row['id'];
                                $username = $each_row['userName'];
                                $hashed_password = $each_row['passCode'];
                                $fName = $each_row['fName'];
                                $lName = $each_row['lName'];
                                $registrationOrder = $each_row['registrationOrder'];

                                if(password_verify($this->password, $hashed_password)){

                                    // After confirming the password, we start a new session
                                    session_start();
                                    
                                    // Creatting $_SESSION variables
                                    $_SESSION['loggedin'] = true;
                                    $_SESSION['id'] = $id;
                                    $_SESSION['username'] = $username;
                                    $_SESSION['fName'] = $fName;
                                    $_SESSION['lName'] = $lName;
                                    $_SESSION['registrationOrder'] = $registrationOrder;
                                    $_SESSION['livesUsed'] = 1;
                                    $_SESSION['startTime'] = date('Y-m-d H:i:s');
                                    $_SESSION['gainedLevels'] = [];
                                    $_SESSION['gameOver'] = false;
                                    $_SESSION['result'] = 'incomplete';                                                       
                                    
                                    // Redirect user to welcome page
                                    header("location: game1.php");
                                }
                                else{
                                    // $this->login_err = "Invalid username or password.";
                                    $this->login_err = $this->messages()['error']['invalidUsernamePass'];
                                }


                            } else{
                                //$this->login_err = "Invalid username or password.";
                                $this->login_err = $this->messages()['error']['invalidUsernamePass'];
                            }
                        }
                        //Cannot Select data From the Table
                        else{
                            $this->login_err = "Oops! Something went wrong. Please try again later.";
                        }
                    }
                    // $username_err or $ password_err already filled
                    
                }
                //Cannot Connect to the DB
                else {
                    die($this->messages()['error']['db']);
                }        
        }
        //Cannot Connect to the DBMS
        else {
            die($this->messages()['error']['dbms']);
        }
    }

    public function changePassword(){
        if ($this->connectToDBMS() === TRUE) {

            //2-Connect to the DB
            if ($this->connectToDB() === TRUE) {
                
                if(validateNoError()){
                        
                    if ($this->executeSql($this->sqlCode()['userNameExist']) === TRUE) {
                        

                        $number_of_rows = $this->sqlExec->num_rows;

                        if($number_of_rows == 1){
                            $each_row = $this->sqlExec->fetch_array(MYSQLI_ASSOC);

                            $this->registrationOrder = $each_row['registrationOrder'];

                            if ($this->executeSql($this->sqlCode()['changePassword']) === false){
                                echo $this->messages()['link']['tryAgain'];
                                die($this->messages()['error']['insertTab']);
                            }
                            else{
                                echo "Redirecting to login page";
                                header("Refresh:10 ;location: login.php");
                            }


                        } else{
                            die($this->messages()['error']['userNotExist']);
                        }
                    }
                    //Cannot Select data From the Table
                    else{
                        die($this->messages()['error']['userNotExist']);
                    }
                }
                //if error - already shown
                
                
            }
            //Cannot Connect to the DB
            else {
                die($this->messages()['error']['db']);
            }        
    }
    //Cannot Connect to the DBMS
    else {
        die($this->messages()['error']['dbms']);
    }
    }

    public function insertScore()
    {
        //1-Connect to the DBMS
        if ($this->connectToDBMS() === TRUE) {
                //2-Connect to the DB
                if ($this->connectToDB() === TRUE) {
                    //3-Check that the Table exists 
                    if ($this->executeSql($this->sqlCode()['descTab']) === TRUE) {
                        //4-Insert data to the Table
                        //Cannot Insert data to the Table
                        if ($this->executeSql($this->sqlCode()['insertScore']) === FALSE) {
                            echo $this->messages()['link']['tryAgain'];
                            die($this->messages()['error']['insertTab']);
                        }
                    }
                    //Cannot Check that the Table exists
                    else{
                        echo $this->messages()['link']['tryAgain'];
                        die($this->messages()['error']['desTab']);
                    }
                }
                //Cannot Connect to the DB
                else {
                    echo $this->messages()['link']['tryAgain'];
                    die($this->messages()['error']['insertTab']);
                }        
        }
        //Cannot Connect to the DBMS
        else {
            die($this->messages()['error']['dbms']);
        }
    }

}