<!-- 
Ronald Mercado H.
Web Server Applications
27 March 2023
LaSalle College
Web Server Project - Game Level 1 
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>History Game</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <script src="./js/jquery-3.6.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="./js/script.js"></script>
    
</head>
<body>    
    <?php require_once "functions.php";?>    
    <?php require_once "navBar.php";?>    
    <table class="tabla-score">
        <thead>
            <tr>
                <th>SCORE TIME</th>
                <th>ID</th>
                <th>NAME</th>
                <th>LAST NAME</th>
                <th>RESULT</th>
                <th>USED LIVES</th>
            </tr>
        </thead>
        <tbody>
            <?php require_once "viewHistoryController.php";?>            
        </tbody>
    </table>

    <?php require_once "footer.php";?>
</body>
</html>
