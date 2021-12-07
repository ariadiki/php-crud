<?php
    require("database.php");
    $db = new database();
    $mysqli = new mysqli();
    session_start();
    if(isset($_SESSION['email'])) //check if session is open
    {
        header('location:home.php');
    }
    else{
        $mysqli = $db->connect();
        if($mysqli->connect_errno)   //check connection
        {
            echo "Failed to connect to Database:".$mysqli->connect_error;
        }
        else 
        {
            if(isset($_POST['submit'])) //onclick submit
            {
                $email = $_POST['email'];
                $password = md5($_POST['password']);  
                $res = $db->check($mysqli,$email,$password); //check email and password correct
                $row= mysqli_fetch_array($res);
                if(!empty($row)){
                    $_SESSION['id'] = $row['ID'];
                    $_SESSION['name'] = $row['Name'];
                    $_SESSION['email'] = $row['Email'];
                    header('location:home.php');
                }else{
                    echo '<script>alert("incorrect email or password !")</script>';
                    header('Refresh:0; url=index.php');
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Login Page</title>
</head>
<body>
<div class="login-page">
    
    <div class="form">
    <h1>Login Page</h1></br></br>
    <form class="login-form" action="" method="POST">
        <label><b>Email</b></label></br>
        <input type="email" placeholder="Enter your email" name="email" required></br></br>
        <label><b>Password</b></label></br>
        <input type="password" placeholder="Enter your Password" name="password" required></br></br>
        <button type="submit" name="submit">Login</button></br></br>
        <b class="message">you don't have an account! <a href="register.php">Sign Up</a></b>
    </div>
</div>
</body>
</html>