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
            <div class="background2">
                <?php

                    echo '<div class="profile">
                        <div class="name">Username</div>
                        </div class="password">password *******</div>
                    </div>';

                ?>
            </div>
        </div>
    </div>
</body>
</html>