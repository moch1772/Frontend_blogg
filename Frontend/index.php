
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
include "getservice.php";
$API="K1F0W7hPsYr8Iu698pf5";
$serviceID=2;

    echo'<div class="content">
    <div class="foreground">
            <div class="billboard"></div>
            <div class="title"><h1>serviceTitel</h1></div>
            
            <div class="menu">
                <div class="mLButton">
                    <div class="mText">
                    home
                    </div>
                </div>
                <div class="mRButton">
                    <div class="mText">
                        profile
                    </div>
                </div>
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