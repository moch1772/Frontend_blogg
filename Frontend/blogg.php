
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>Document</title>
</head>
<body>
<?php
session_start();
$name=$_SESSION['username'];
include "getservice.php";

$API=$_SESSION['API'];
if(isset($_GET['service'])){
    $serviceID=$_GET['service'];
    }else{
        header('location:home.php');
    }  
//$pageTitle="nog";
// sertchPage($API,$serviceID,$pageTitle);
    echo'<div class="content">
    <div class="background">
        <div class="foreground">
            <div class="billboard"></div>
            <div class="title"><h1>';
            $serviceTitle=serviceTitle($API,$serviceID);
            if($serviceTitle=='ceID":null,"serviceTitle":null,"serviceDate":null,"serviceType":null,"publis'){
                header('location:home.php');
            }
            echo $serviceTitle;
            echo'</h1></div>';
            ?>
            
            <div class="menu">
            <a href="home.php" class="mLButton">
                <div class="mText">
                    Home
                </div>
            </a>
            <a href="createinlegg.php?service=<?php echo $serviceID ?>" class="mLButton">
                <div class="mText">
                    create Post
                </div>
            </a>
            <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ&ab_channel=RickAstleyVEVO" class="mRButton">
                <div class="mText">
                    Profile
                </div>
            </a>
            <div class="msearch">
                <form action="search.php" method="POST">
                    <input type="text" id="search" name="search" placeholder="Search"></form>
                </form>
            </div>
        </div>
        <div class="background2">
    <?php

        servicePage($API,$serviceID,$name);
        echo'</div></div></div></div>';
    ?>
</body>
</html>