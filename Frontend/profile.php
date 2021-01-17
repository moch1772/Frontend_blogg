<?php
session_start();
include_once 'getservice.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="profile.css">
    <title>Document</title>
</head>
<body>
    <div class="content">
        <div class="background">
            <div class="foreground">
                <div class="billboard">
                    <div class="block"></div>
                    <button onclick="back()" class="back"><img src="../icon/585e473bcb11b227491c3381.png" class="goBack"></button>
                </div>
                <div class="title"><h1>Profile</h1></div>
                
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
                <div class="msearch">
                    <form action="search.php" method="POST">
                        <input type="text" id="search" name="search" placeholder="Search"></form>
                    </form>
                </div>
            </div>
            <div class="background2">
                <?php


                    echo '<div class="profile">
                        <div class="name">Username: '.$_SESSION['username'].'</div>
                        <div class="password">Password: ';
                        for ($i=0;$i<strlen($_SESSION['password']);$i++)
                        {
                            echo "*";
                        }
                        echo '</div>';
                    
                    //Your bloggs
                    $url= "http://wider.ntigskovde.se/api/pages/read_service.php?API=".$_SESSION['API'];
                    $output = file_get_contents($url);
                    $redservis=json_decode($output,true);

                    $count=0;
                    if($redservis==NULL){
                        header('Location:login.php');
                    }
                    foreach($redservis as $t){
                        $count +=count($t);
                    }

                    $serv=array();
                    for ($i=0; $i < $count; $i++) { 
                        
                    //$serv=$redservis['data'][$i]['serviceID'];
                    
                    if($redservis['data'][$i]['serviceType']==3){
                        array_push($serv,$redservis['data'][$i]['serviceID']);
                    }
                }
                $serv=array_unique($serv);
                foreach($serv as $i){
                    $servTitle=serviceTitle($_SESSION['API'],$i);
                    if(isset($servTitle[1])){
                        if($servTitle[0]!='ceID":null,"serviceTitle":null,"serviceDate":null,"serviceType":null,"publis' && $servTitle[1]==$_SESSION['userID']){
                            echo "<div class='bloggs'>Bloggs:</div>
                            <form action='blogg.php?service=$i' method='post'>
                                    <button class='button'>$servTitle[0]</button>
                                </form></div>";
                        }
                    }}
                
                    

                ?>
            </div>
        </div>
    </div>
<script src="javascript/profile.js"></script>
</body>
</html>