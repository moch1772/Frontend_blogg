
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
            <div class="billboard">
                <div class="block"></div>
                <button onclick="back()" class="back"><img src="../icon/585e473bcb11b227491c3381.png" class="goBack"></button>
            </div>
            <div class="title"><h1>';
            $serviceTitle=serviceTitle($API,$serviceID);

            if($serviceTitle[0]=='ceID":null,"serviceTitle":null,"serviceDate":null,"serviceType":null,"publis'){
                header('location:home.php');
            }
            echo $serviceTitle[0];
            echo'</h1></div>';
            ?>
            
            <div class="menu">
            <a href="home.php" title="Home" class="mLButton">
                <div class="mText">
                    <img src="../icon/69524.png" class="img">
                </div>
            </a>
            <a href="profile.php" title="Profile" class="mRButton">
                <div class="mText">
                    <img src="../icon/64495.png" class="img">
                </div>
            </a>
        </div>
        <div class="background2">
            <div class="hiddenbox"></div>
            <a href="createinlegg.php?service=<?php echo $serviceID ?>" title="New post" class="creblog">
                <img src="../icon/create-new-2081842-1747337.png" class="createimg">
            </a>
        <?php

            servicePage($API,$serviceID,$name);
            echo'</div></div></div></div>';
        ?>
<script src="javascript/blogg.js"></script>
</body>
</html>