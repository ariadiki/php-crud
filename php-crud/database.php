<?php
class database{
    
    //connect to database
    function connect()
    {
        $hostdb="localhost";
        $userdb="root";
        $passdb="";
        $dbname="system";
        return mysqli_connect($hostdb,$userdb,$passdb,$dbname);
    }

    //encrypt password
    function passhash($password)
    {
        return password_hash($password,PASSWORD_DEFAULT);
    }

    //create user
    function create($con,$name,$email,$password)
    {
        $query = mysqli_query($con,"INSERT INTO users (`Name`, `Email`, `Password`) VALUES ('$name','$email','$password')");
        if(!$query){
            return false;
        }
        return true;
    }
   
    //check user information
    function check($con,$email,$password)
    {
        $query = mysqli_query($con,"SELECT * FROM users WHERE `Email` = '$email' and `Password`='$password'");
        if(!$query){
            die ("Error in query");
        }
       return $query;
    }

    //read users from database
    function read($con){
        $query = mysqli_query($con,"SELECT * FROM users");
        if(!$query){
            die ("Error in query");
        }
       return $query;
    }

    //update users data
    function update($con,$id,$name,$email,$password)
    {
        $query = mysqli_query($con,"UPDATE users SET `Name`='$name',`Email`='$email',`Password`='$password' WHERE `ID`=$id");
        if(!$query){
            return false;
        }
        return true;
    }
    
    //delete user from database
    function delete($con,$id)
    {
        $query = mysqli_query($con,"DELETE FROM `users` WHERE `ID`=$id");
        if(!$query){
            return false;
        }
        return true;
    }

    //search users 
    function search($con,$sh)
    {
        return mysqli_query($con,"SELECT * FROM `users` WHERE `Name`like'%$sh%' or `Email`like'%$sh%'");
    }
}
?>