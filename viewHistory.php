


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <script src="./js/jquery-3.6.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="./js/script.js"></script>
    <title>Document</title>
</head>
<body>
    <?php


        /// **********************DRAFT************************************* ///



        require_once "DBMainV3.php";

/*
        $newCon = new ManipulateDB();
        
        if connectToDBMS() == true{
            print("hello");
        }

*/
        
        
        $conn = mysqli_connect("localhost", "root","", "kidsGames");
        
        
        if (!$conn) {
            die("Error al conectar a la base de datos: " . mysqli_connect_error());
        }
        
        
        $sql = "SELECT scoreTime, id, fName, lName, result, livesUsed FROM history";
        
        
        $resultado = mysqli_query($conn, $sql);
        
        
        if (mysqli_num_rows($resultado) > 0) {
            
            echo "<table>";
            echo "<tr><th>scoreTime</th><th>id</th><th>fName</th><th>lName</th><th>result</th><th>livesUsed</th></tr>";
            while($fila = mysqli_fetch_assoc($resultado)) {
                echo "<tr><td>" . $fila["scoreTime"] . "</td><td>" . $fila["id"] . "</td><td>" . $fila["fName"] . "</td><td>" . $fila["lName"] . "</td><td>" . $fila["result"] . "</td><td>" . $fila["livesUsed"] . "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "No se encontraron resultados.";
        }



        /// **********************DRAFT************************************* ///
        
       
        mysqli_close($conn);
        ?>
        
</body>
</html>

    
    
