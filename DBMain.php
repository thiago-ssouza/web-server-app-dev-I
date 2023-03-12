<?php
define('HOST','localhost');
define('USER','root');
define('PASS','');
define('DBNAME','users');
define('TABNAME','employees');
class ManipulateDB
{
   
    //Declare the properties
    private $firstname, $lastname, $username,$registrationOrder,$newPassword;
    private $connection; 
    protected $sqlExec, $lastErrMsg;

    //Declare the method constructor
    public function __construct($fn, $ln)
    {
        $this->firstname = $fn;
        $this->lastname = $ln;
    }

    //Declare the method to save the messages
    protected function messages()
    {
        //Error messages 
        $m['dbms'] = "<p>Connection to MySQL failed!<br/>$this->lastErrMsg</p>";
        $m['db'] = "<p>Connection to the DB failed!<br/>$this->lastErrMsg</p>";
        $m['creatDb'] = "<p>Creation of the DB failed!<br/>$this->lastErrMsg</p>";
        $m['creatTab'] = "<p>Creation of the Table failed!<br/>$this->lastErrMsg</p>";
        $m['insertTab'] = "<p>Data insertion to the Table failed!<br/>$this->lastErrMsg</p>";
        $m['selectTab'] = "<p>Data selection from the Table failed!<br/>$this->lastErrMsg</p>";
        $m['desTab'] = "<p>Table structure description failed!<br/>$this->lastErrMsg</p>";
        //Try again messages
        $b['tryAgain'] = "<a href=\"index.php\"><input type=\"submit\" value=\"Try again!\"></a>";
        //Group messages by category 
        $msg['error'] = $m;
        $msg['link'] = $b;
        return $msg;
    }

    //Declare the method to save the SQL Code to be executed
    protected function sqlCode()
    {
        $dbName = DBNAME;
        //Create queries
        $sqlCode['creatDb'] = "CREATE DATABASE IF NOT EXISTS $dbName;";
        $sqlCode['creatTab'] = "CREATE TABLE player( 
            fName VARCHAR(50) NOT NULL, 
            lName VARCHAR(50) NOT NULL, 
            userName VARCHAR(20) NOT NULL UNIQUE,
            registrationTime DATETIME NOT NULL,
            id VARCHAR(200) GENERATED ALWAYS AS (CONCAT(UPPER(LEFT(fName,2)),UPPER(LEFT(lName,2)),UPPER(LEFT(userName,3)),CAST(registrationTime AS SIGNED))),
            registrationOrder INTEGER AUTO_INCREMENT,
            PRIMARY KEY (registrationOrder)
        )CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci; 
        
        CREATE TABLE authenticator(   
            passCode VARCHAR(255) NOT NULL,
            registrationOrder INTEGER, 
            FOREIGN KEY (registrationOrder) REFERENCES player(registrationOrder)
        )CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci; 
        
        CREATE TABLE score( 
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

--Insert into the tables (including php variables)


--select from the view

        --SAMPLE DATA TO TEST INSERT MANUALLY ------------------------
        INSERT INTO player(fName, lName, userName, registrationTime)
        VALUES('Patrick','Saint-Louis', 'sonic12345', now()); 
        INSERT INTO player(fName, lName, userName, registrationTime)
        VALUES('Marie','Jourdain', 'asterix2023', now());
        INSERT INTO player(fName, lName, userName, registrationTime)
        VALUES('Jonathan','David', 'pokemon527', now()); 
        --------------------------------------------------

        --SAMPLE DATA TO TEST INSERT MANUALLY ------------------------
        INSERT INTO authenticator(passCode, registrationOrder)
        VALUES('$2y$10\$fxMTc4KD4mZlj03wc4grTuVLssP0ZKxeqfcfvxVx2xnrrKF.CKsk.', 1);

        INSERT INTO authenticator(passCode, registrationOrder)
        VALUES('$2y$10\$AH/612QosAUyKIy5s4lEBuGdNAhnw.PbHYfIuLNK2aHQXWRMIF6fi', 2);

        INSERT INTO authenticator(passCode, registrationOrder)
        VALUES('$2y$10\$rSNEZ5wd8YyRRlNCmwfb2uUvkffrAMdmLkcm5s.b7WAgiGy8UoA1i', 3);
        --------------------------------------------------

        --SAMPLE DATA TO TEST INSERT MANUALLY ------------------------
        INSERT INTO score(scoreTime, result , livesUsed, registrationOrder)
        VALUES(now(), 'success', 4, 1);

        INSERT INTO score(scoreTime, result , livesUsed, registrationOrder)
        VALUES(now(), 'failure', 6, 2);

        INSERT INTO score(scoreTime, result , livesUsed, registrationOrder)
        VALUES(now(), 'incomplete', 5, 3);";


        $sqlCode['checkPlayerExist'] = "SELECT * FROM player where registrationOrder=$this->registrationOrder;";

        $sqlCode['register']="INSERT INTO player(fName, lName, userName, registrationTime)
        VALUES($this->firstname, $this->lastname, $this->username, date());";

        $sqlCode['insertPassword']="INSERT INTO authenticator(passCode,registrationOrder)
        VALUES($this->newPassword, $this->registrationOrder);";

        $sqlCode['changePassword']="UPDATE authenticator SET passCode = $this->newPassword where registrationOrder= $this->registrationOrder";
            
        $sqlCode['checkPassword']="SELECT passCode FROM authenticator where registrationOrder= $this->registrationOrder";
        
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

    //Declare the method to display selected data 
    protected function displaySelectData(){
        //Calculate the number of rows available
        $number_of_rows = $this->sqlExec->num_rows;
        //Use a loop to display the rows one by one
        echo "<table>";
        echo "<tr><td>ID</td><td>First Name</td><td>Last Name</td><td>Email</td></tr>";
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
    

    //Declare the method to disconnect from the DBMS
    public function __destruct()
    {
        //Close automatically the connection from MySQL when it is opened at the end          
        if ($this->connection == TRUE) {
            $this->connection->close();
        }
    }
}