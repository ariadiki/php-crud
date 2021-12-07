<?php
    require("database.php");
    $db = new database();
    $mysqli = new mysqli();
    $mysqli = $db->connect();
    if(isset($_POST['submit']))
    {
        $email= $_POST['email'];
        $pass = md5($_POST['password']);
        $query = mysqli_query($mysqli,"SELECT * FROM users WHERE Email = '$email'");
        $row = mysqli_fetch_array($query);
        if(empty($row)){
            $res= $db->create($mysqli,$_POST['name'],$_POST['email'],$pass);
            if($res){
            echo '<script>alert("User is Created !")</script>';
            }else{
                echo '<script>alert("Failed to create user")</script>';
            }
            
        }else{
            echo '<script>alert("Email Exist !")</script>';
        }
        header('Refresh:0; url=home.php');
    }
?>