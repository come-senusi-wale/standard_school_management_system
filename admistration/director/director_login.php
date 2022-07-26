<?php
    session_start();

    if(isset($_SESSION['director_id_code']))
    {
        header("location: director_home.php");
    }
    

    $error ='';

    if (isset($_GET['process'])) {
        
        $error = $_GET['process'];
    }
    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>director login</title>
    <link rel="stylesheet" href="css/director_login_css.css">

    <style>
        form p{
            font-family: sans-serif;
            font-size: 15px;
            margin-bottom: 30px;
            color: tomato;
            text-align: center;
        }
    </style>
</head>
<body>
    <div id="form_container">
        
        <div class="form_element">
            <form action="action_php/director_login_action.php" method="POST">
                <p><?php echo $error; ?></p>
                <h2>director form</h2>
                <input type="email" id="email" placeholder="Enter Email" required name="email">

                <input type="password" id="pwd" placeholder="Enter Password" required name="password">
                <input type="submit" name="submit" id="reg_btn" value="submit">

                <div id="forgot">
                    <a href="director_forgot_password.php">forgot password?</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>