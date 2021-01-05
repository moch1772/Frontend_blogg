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
                <div class='box'>
                    <?php
                    echo'<form action="blogg.php" method="get">
                    
                    </form>';
                    $url= "http://wider.ntigskovde.se/api/pages/read_service.php?API=$API";
                    $output = file_get_contents($url);
                    $redservis=json_decode($output,true);

                    $count=0;
                    foreach($redservis as $t){
                        $count +=count($t);
                    }
                    
                    for ($i=0; $i < $count; $i++) { 
                        
                    $serv=$redservis['data'][$i]['serviceID'];

                    if ($serv==$redservis['data'][0]['serviceID'] && $i>=1) {
                    break;
                    }
                    if(checkType($API,$serv)==true){
                    $servTitle=serviceTitle($API,$serv);

                    echo "<form action='http://localhost:8080/t4/bull/kalender/Frontend_blogg/Frontend/blogg.php?service=$serv' method='post'>
                            <button class='button'>$servTitle</button>
                        </form>";
                    }}
                    ?>
                    <div class="hidden"></div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>