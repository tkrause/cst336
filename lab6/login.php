<?php 
    session_start();
?>

<!DOCTYPE html>
<head>
    <title>Admin Login</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
        <form method="POST" action="loginProcess.php">
            Username: <input type='text' name='username'/><br>
            Password: <input type='password' name='password'/><br>

            <input type="submit" name="submitForm" value="Login!"/>
        <br><br>
        <?php
            if($_SESSION['incorrect']) {
                echo "<p class='text-danger lead' id='error'>";
                echo "<strong>Incorrect Username or Password!</strong></p>";
            }
        ?>
    </div>
</form> 
</body>
   

