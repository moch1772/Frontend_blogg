<?php
session_start();
include "getservice.php";
echo'<form action="login.php" method="post">
<input type="text" name="uname">
<input type="password" name="paword">
<input type="submit" value="login">
</form>';

if (isset($_POST['uname'])) {
    $API=logIn($_POST['uname'],$_POST['paword']); 
    if($API=="nono"){
        echo $API;
    }else {
        $_SESSION['API']=$API;
        header("location:index.php");
    }
}



?>