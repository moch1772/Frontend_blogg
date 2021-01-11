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
                <div class="billboard"></div>
                <div class="title"><h1>Profile</h1></div>
                
                <div class="menu">
                <a href="home.php" class="mLButton">
                    <div class="mText">
                        <img src="../icon/69524.png" class="img">
                    </div>
                </a>
                <a href="profile.php" class="mRButton">
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
                        <div class="name">Username</div>
                        <div class="password">Password *******</div>
                    </div>';

                ?>
            </div>
        </div>
    </div>
</body>
</html>