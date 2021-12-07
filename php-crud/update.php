<?php
    require("database.php");
    $db = new database();
    $mysqli = new mysqli();
    $mysqli = $db->connect();
    if(isset($_POST['submit']))
    {
        $pass = md5($_POST['password']);
        $res= $db->update($mysqli,$_POST['id'],$_POST['name'],$_POST['email'],$pass);
        if($res){
        echo '<script>alert("User is Updated !")</script>';
        }else{
            echo '<script>alert("Failed to update user")</script>';
        }
        header('Refresh:0; url=home.php');
    }
?>