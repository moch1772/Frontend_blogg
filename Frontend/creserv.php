<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/create.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
    <div class="content">
        <div class="background">
            <div class="foreground">
                <div class="billboard">
                    <div class="block"></div>
                    <button onclick="back()" class="back"><img src="../icon/585e473bcb11b227491c3381.png" class="goBack"></button>
                    <h1><div class="resTitle" id="resTitle"></div></h1>
                </div>
                
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
                include "getservice.php";
                session_start();
                $API=$_SESSION['API'];

                echo'<form action="creserv.php" method="post">
                <input class="title" type="text" id="title" name="serviceTitle" requierd placeholder="Title"><br>
                <input type="hidden" name="userID" value="1"><br>
                <label class="ingress" for="post">Description:</label><h2><div class="resIngress" id="resIngress"></div></h2><br>
                <br>
                <textarea type="text" name="postText" requierd placeholder="Text"></textarea><br>
                <p class="note">Type a description about what your blog will be about</p>
                <input class="submit" type="submit" name="submit">
                </form>';

                if (isset($_POST['submit'])) {
                    $serviceTitle=$_POST['serviceTitle']."¤".$_SESSION['userID'];
                    $userID=$_POST['userID'];
                    $username=$_SESSION['username'];
                    $postTitle=array("Ingress");
                    $postText=array($_POST['postText']);
                    $image=array("Ingress");
                
                    $publish=1;
                    $ch=curl_init();
                    $arr= json_encode(array("userID"=>$userID,"serviceType"=>3,"publish"=>$publish,"serviceTitle"=>$serviceTitle));
                    $url="http://wider.ntigskovde.se/api/pages/create_service.php?API=$API";
                    curl_setopt($ch, CURLOPT_URL, $url);
                
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                
                    curl_setopt($ch, CURLOPT_POST, 1);
                
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $arr);
                
                    $output = curl_exec($ch);
                    timeout($output);
                    echo$output;
                
                
                
                
                
                
                
                                //Create Ingress
                                    //Create page for ingress
                                $serviceID=getServiceID($API);
                                $metaTag=generateRandomString();
                                $ch=curl_init();
                                $arr=json_encode(array("serviceID"=>$serviceID,"metaTag"=>$metaTag,"pageTitle"=>"Ingress"));
                                $url="http://wider.ntigskovde.se/api/pages/create_page.php?API=$API";
                                curl_setopt($ch, CURLOPT_URL, $url);
                            
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                            
                                curl_setopt($ch, CURLOPT_POST, 1);
                            
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $arr);
                            
                                $output = curl_exec($ch);
                                echo $output;
                                timeout($output);
                                $url= "http://wider.ntigskovde.se/api/pages/read_page_service.php?API=$API&serviceID=$serviceID";
                                $output = file_get_contents($url);
                                $tt=json_decode($output,true);
                                $con=0;
                            
                                foreach ($tt as $t) {
                                    $con+=count($t);
                                }
                                
                                for ($i=0; $i < $con; $i++) { 
                                    $pp=$tt['pages'][$i]['metaTag'];
                                    
                                    if($metaTag==$pp){
                                    $pageID=$tt['pages'][$i]['pageID'];
                                    break;
                                    }
                                }
                                
                                echo $pageID;
                                $count=1;
                                echo $image;
                                echo "<br>";
                                echo $postText;
                                echo "<br>";
                                echo $postTitle;
                                echo "<br>";
                                echo $pageID;
                                echo "<br>";
                                echo $username;
                                cretPost($API,$count,$image,$postText,$postTitle,$pageID,$username);
                                echo $serviceID;
                                header("Location:blogg.php?service=$serviceID");
                                   }
                
                
                
                
                function getServiceID($API){
                    $url= "http://wider.ntigskovde.se/api/pages/read_service.php?API=$API";
                                    $output = file_get_contents($url);
                                    $redservis=json_decode($output,true);
                                    
                                    $count=0;
                                    foreach($redservis as $t){
                                        $count +=count($t);
                                    }
                
                                    $serv=array();
                                for ($i=0; $i < $count; $i++) { 
                                        
                                    //$serv=$redservis['data'][$i]['serviceID'];
                                    array_push($serv,$redservis['data'][$i]['serviceID']);
                                }
                                $serv=array_unique($serv);
                                print_r($serv);
                                return end($serv);
                            }
                
                ?>
            </div>
        </div>
    </div>
<script src="javascript/create.js"></script>
</body>
</html>