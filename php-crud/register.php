<?php
    require("database.php");
    $db = new database();
    $mysqli = new mysqli();

    $mysqli = $db->connect(); //connect to database

    if($mysqli->connect_errno)   //check connection
    {
        echo "Failed to connect to Database:".$mysqli->connect_error;
    }
    else 
    {
        if(isset($_POST['submit']))
        {
            //read text fields
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = md5($_POST['password']);
            
            $query = mysqli_query($mysqli,"SELECT * FROM users WHERE Email = '$email'");
            $row = mysqli_fetch_array($query);

            //check if email exist
            if(empty($row)){
                $res = $db->create($mysqli,$name,$email,$password);
                if($res)
                {
                    echo '<script>alert("You are Signed Up Successfully")</script>';
                    header('Refresh:0; url=index.php');
                }
                else{
                    echo '<script>alert("Query Error !")</script>';
                    header('Refresh:0; url=register.php');
                }
            }else{
                echo '<script>alert("Email exist")</script>';
                header('Refresh:0; url=index.php');
            }    
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Register Page</title>
</head>
<body>
<div class="login-page">
        <div class="form">
        <h1>Register Page</h1></br></br>
            <form class="login-form" action="register.php" method="POST">
            <label><b>Name</b></label></br>
            <input type="text" placeholder="Enter your name" name="name" required></br></br>
            <label><b>Email</b></label></br>
            <input type="email" placeholder="Enter your email" name="email" required></br></br>
            <label><b>Password</b></label></br>
            <input type="password" placeholder="Enter your password" name="password" required></br></br>
            <button type="submit" name="submit" >Sign Up</button></br></br>
            <b class="message">already have an account? <a href="index.php">Login</a></b>
            </form>
        </div>
    </div>
</body>
</html>