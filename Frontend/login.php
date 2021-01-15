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
                <div class="text">Vänligen skriv in ditt användarnamn och lösenord i rutorna nedanför</div>
                <div class="box">
                    <div class="hidden"></div>
                    <form class="form" action="login.php" method="post">
                        <input class="input" type="text" name="username" placeholder="Användarnamn" required>
                        <input class="input" type="password" name="paword" placeholder="Lösenord"  required>
                        <input class="button" type="submit" name="submit" value="Logga in">
                    </form>
                    <form action="login.php" method="post">
                    <input class="button2" type="submit" name="submit" value="Register">
                    </form>
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