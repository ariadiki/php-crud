<?php
require("database.php");
    $db = new database();
    $mysqli = new mysqli();
    $mysqli = $db->connect();
    session_start();
    if($_SESSION['id'] == $_GET['id'])
    {
        echo '<script>alert("You cant delete yourself")</script>';
    }
    else{
        $res= $db->delete($mysqli,$_GET['id']);
        if($res){
        echo '<script>alert("User is deleted !")</script>';
        }else{
            echo '<script>alert("Delete Failed !")</script>';
        }
    }
    header('Refresh:0; url=home.php');
?>