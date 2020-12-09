
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
include "getservice.php";
$API=$_SESSION['API'];
$serviceID=2;
//$pageTitle="nog";
// sertchPage($API,$serviceID,$pageTitle);
    echo'<div class="content">
    <div class="foreground">
            <div class="billboard"></div>
            <div class="title"><h1>';
            serviceTitle($API,$serviceID);
            echo'</h1></div>
            
            <div class="menu">
            <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ&ab_channel=RickAstleyVEVO" class="mLButton">
                <div class="mText">
                    Home
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

            ';
    servicePage($API,$serviceID);
    echo'</div></div>';
    ?>
   
</body>
</html>