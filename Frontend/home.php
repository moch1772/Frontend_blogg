<?php
session_start();
$API=$_SESSION['API'];
    
    include "getservice.php"
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="home.css">
    <title>Document</title>
</head>
<body>
    <div class="content">
        <div class="background">
            <div class='foreground'>
                <div class="hidden"></div>
                <a href="login.php" title="Logout" class="logout">
                    <img src="../icon/Icons8-Windows-8-User-Interface-Logout.ico" class="logimg">
                </a>
            </div>
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
                            <input type="text" id="search" name="search" placeholder="Search"></input>
                        </form>
                    </div>
                </div>
            <div class='box'>
                <div class="hiddenbox"></div>
                <a href="creserv.php" title="New blog" class="creserv">
                    <img src="../icon/create-new-2081842-1747337.png" class="createimg">
                </a>
                    <?php
                    echo'<form action="blogg.php" method="get">
                    
                    </form>';
                    $url= "http://wider.ntigskovde.se/api/pages/read_service.php?API=$API";
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
                    $servTitle=serviceTitle($API,$i);
                    if($servTitle[0]!='ceID":null,"serviceTitle":null,"serviceDate":null,"serviceType":null,"publis'){
                    echo "<form action='blogg.php?service=$i' method='post'>
                            <button class='button'>$servTitle[0]</button>
                        </form>";
                    }
                }
                    ?>
                    <div class="hidden2"></div>
            </div>
        </div>
    </div>
</body>
</html>