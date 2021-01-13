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
            <div class='foreground'></div>
                    <div class="menu">
                    <a href="home.php" class="mLButton">
                        <div class="mText">
                            Home
                        </div>
                    </a>
                    <a href="creserv.php" class="mLButton">
                        <div class="mText">
                            Create Blogg
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
            <div class='box'>
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
                    if($servTitle!='ceID":null,"serviceTitle":null,"serviceDate":null,"serviceType":null,"publis'){
                    echo "<form action='blogg.php?service=$i' method='post'>
                            <button class='button'>$servTitle</button>
                        </form>";
                    }
                }
                    ?>
                    <div class="hidden"></div>
            </div>
        </div>
    </div>
</body>
</html>