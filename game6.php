<!--class3b.php-->
<!DOCTYPE html>
<html>  
  <head>
    <title>Level 6</title>
    <style>
      .form{color:blue;}
      .formhandling{color:red;}
      .display-name{color:green;}
      table, tr, td {
  border: 1px solid black;
}
    </style>
  </head>
  <body>
    <?php		
        if(session_status()=== PHP_SESSION_NONE){
            // echo "Redirecting to login page";
            header("Refresh:10 ;location: login.php");
            
        }
        

       
//work
if(!isset($_POST['send'])){
    session_start();
        $_SESSION['arr'] =array();
        if(count($_SESSION['arr'])===0){
            $array = array();

            for($i = 0;$i<6;$i++){
                generateRandomNums($array);
            }
            $_SESSION['arr']= $array;
        }


            echo "<h1>Enter minimum and maximum numbers</h1><BR>";
            echo "<h3>Here are six different number find the minimum and maximum numbers in them</h3>";
      //       To add
            echo "<table style=\"width:250px\">";
            echo "<tr>";
              foreach($_SESSION['arr'] as $num){
                  echo "<td>".$num."</td>";
              }
            echo "</tr>";
            echo"</table>";
              echo "<br>";
              echo "<br>";
      
      
            //Form 
            echo "<form id=\"form1\" method=\"post\" action=\"game6.php\" >"; //Beginning form tag
                // Form fields to input data
                echo "<label>Enter the  minimum number</label>"; 
                echo "<br />";
      
                echo "<input id=\"inputRows\" type=\"number\" name=\"minNum\" required=\"required\">"; 
                echo "<br />";
                echo "<br />";
      
                echo "<label>Enter the  maximum number</label>"; 
                echo "<br />";
                
                echo "<input id=\"inputRows\" type=\"number\" name=\"maxNum\" required=\"required\">"; 
                echo "<br />";
                echo "<br />";

                echo "<input type=\"hidden\" name=\"arr\" value=\"".implode(" ",$_SESSION['arr'])."\">"; 

      
                // Submit button to send form data		
                echo "<input id=\"submitbutton1\" type=\"submit\" name=\"send\" value=\"SEND IT\" />"; 
                echo "<br />";
      
                echo "<br />";
      
            echo "</form>"; 
            }
        if(isset($_POST['send'])){
            $min = $_POST['minNum'];
            $max = $_POST['maxNum'];
            $arr = $_SESSION['arr'];
            if(getError())
                checkNums();
                
        }
    function generateRandomNums(&$arr){
        $temp = rand(0,100);
        if(in_array($temp,$arr)){
            generateRandomNums($arr);
        }
        else{
            array_push($arr,$temp);
        }
    }

    function getError(){
        global $min;
        global $max;
        global $arr;

        if(!in_array($min,$arr)and !in_array($max,$arr) ){
            echo "Both the number you entered is not in the array";
            return false;
        }
        elseif (!in_array($min,$arr) || !in_array($max,$arr)) {
            echo "One of the number you entered is not in the array";
            return false;
        }
        else{
            echo "Both the number you entered is in the array";
            return true;
        }

    }

    function checkNums(){
        global $min;
        global $max;
        global $arr;

        if($max === max($arr) && $min === min($arr)){
            echo "Both the maximum and minimum you entered is right";
            return true;
        }
        elseif ($max !== max($arr) && $min === min($arr)) {
            echo "The minimum you entered is right";
            return false;

        }
        elseif ($max === max($arr) && $min !== min($arr)) {
            echo "The maximum you entered is right";
            return false;

        }
        else{
            echo "Both the maximum and minimum you entered is wrong";
            return false;

        }
    }



    ?>
  </body>
</html>

