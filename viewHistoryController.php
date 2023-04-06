<!-- 
Ronald Mercado H.
Web Server Applications
1 April 2023
LaSalle College
Web Server Project - Registration Form - Process
-->
<?php
require_once "DBMainV3.php";
require_once "functions.php";

class History extends ManipulateDB {
 
    public function getHistory(){

        if($this->connectToDBMS() === TRUE){
            if ($this->connectToDB() === TRUE){

                $stmt = $this->connection->prepare($this->sqlCode()['history']);
                if ($this->executeSql($this->sqlCode()['history'])){                    
                    if ($this->sqlExec !== null && $this->sqlExec->num_rows > 0){
                        
                        echo "<table class='tabla-score'>";
                        echo "<tr><th>SCORE TIME</th><th>ID</th><th>NAME</th><th>LAST NAME</th><th>RESULT</th><th>USED LIVES</th></tr>";
                        while ($fila = mysqli_fetch_assoc($this->sqlExec)) {
                            
                            echo "<tr><td>" . $fila["scoreTime"] . "</td><td>" . $fila["id"] . "</td><td>" . $fila["fName"] . "</td><td>" . $fila["lName"] . "</td><td>" . $fila["result"] . "</td><td>" . $fila["livesUsed"] . "</td></tr>";
                        }

                        echo "</table>";

                    } else{
                        $_SESSION['mensaje'] = "There are no players in the game history."; 
                    }
                } else{
                    die($this->messages()['link']['tryAgain']);
                    $_SESSION['mensaje'] = "There was an error, please try again."; 
                }
            } else{
                die($this->messages()['link']['tryAgain']);
                $_SESSION['mensaje'] = "There was an error with the connection, please try again."; 
            }
        } else{
            die($this->messages()['link']['tryAgain']);
            $_SESSION['mensaje'] = "There was an error with the connection, please try again."; 
        }
    }  
}
$newHistory = new History();
$newHistory->getHistory();
?>
