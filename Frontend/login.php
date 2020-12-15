<?php
session_start();
include "getservice.php";
echo'<form action="login.php" method="post">
<input type="text" name="username" required>
<input type="password" name="paword" required>
<input type="submit" name="submit" value="login">
</form>';

if (isset($_POST['submit'])) {
    $username=$_POST['username'];
    $password=$_POST['paword'];
    $API=logIn($username,$password); 
    if($API=="nono"){
        echo $API;
    }else {
        $_SESSION['API']=$API;
        $_SESSION['username']=$username;
        $_SESSION['password']=$password;

        header("location:home.php");
    }
}



?>