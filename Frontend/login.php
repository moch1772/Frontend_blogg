<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>Document</title>
</head>
<body>

    <?php
    session_start();
    $_SESSION = array();
    include "getservice.php";
    echo'<div class="content"> 
            <div class="foreground">
                <div class="text">Please type in your username and password in the inputfields below.</br>
                If you do not have an account press the register button to create one.</div>
                <div class="box">
                    <div class="hidden"></div>
                    <form class="form" action="login.php" method="post">
                        <input class="input" type="text" name="username" placeholder="Username" required>
                        <input class="input" type="password" name="paword" placeholder="Password"  required>
                        <input class="button" type="submit" name="submit" value="Sign in">
                    </form>
                    
                    <a href="creteUse.php"><button class="button2">Register</button></a>
                    
                </div>
            </div>
        </div>';

    if (isset($_POST['submit'])) {
        $username=$_POST['username'];
        $password=$_POST['paword'];
        $API=logIn($username,$password); 
        if($API=="nono"){
            echo $API;
        }else {
            $userID=getuserID($API,$username);
            $_SESSION['API']=$API;
            $_SESSION['username']=$username;
            $_SESSION['password']=$password;
            $_SESSION['userID']=$userID;

            header("location:home.php");
        }
    }



    ?>

</body>
</html>