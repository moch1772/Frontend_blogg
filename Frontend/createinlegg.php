<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/createinlegg.css">
    <title>Document</title>
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
                //$API=$_SESSION['API'];
                //$userID=$_SESSION['userID'];
                $username=$_SESSION['username'];
                if(isset($_GET['service'])){
                    $serviceID=$_GET['service'];
                    }else{
                        header('location:home.php');
                    }
                $font="Arial,sans-serif";
                //$fontarr=array()
                $bold="bold";

                
                    echo"<form class='form' action='createinlegg.php?service=$serviceID' method='post' enctype='multipart/form-data'>

                <input type='hidden' name='font' value='$font'>
                <input type='button' class='add' value='Add text box' onclick='newpost(pp)'>

                <div id='pp'>
                <input type='text' class='postTitle' name='postTitle' placeholder='Page title'><br><br>
                <input type='text' class='title' name='subtitle[]' placeholder='Post title'>
                <input type='file' name='image[]' accept='image/x-png,image/gif,image/jpeg'><br>
                <textarea type='text' name='subtext[]' placeholder='Post text'></textarea>
                </div>
                <input type='radio' id='picLeft' name='picControl' value='picLeft'>
                <label class='img' for='picLeft'>Image to the left</label><br>
                <input type='radio' id='picRight' name='picControl' value='picRight'>
                <label class='img' for='picRight'>Image to the right</label><br>
                <input type='radio' id='textLeft' name='picControl' value='textLeft' checked='checked'>
                <label class='img' for='textLeft'>No image text aligned to the left</label>
                <br>
                <input type='radio' id='textRight' name='picControl' value='textRight'>
                <label class='img' for='textRight'>No image text aligned to the right</label>
                <br>
                <input type='submit' name='submit' value='Submit'>
                </form>";
                if(isset($_POST['submit'])){
                    $postTitle=$_POST['subtitle'];
                    $postText=$_POST['subtext'];
                    $metaTag=generateRandomString();
                    $pageTitle="smothe";
                    $style=$_POST['picControl'];
                    $imageArray=array();

                    $API=$_SESSION['API'];
                    $countfiles = count($_FILES['image']['name']);
                
                            // Looping all files
                        for($i=0;$i<$countfiles;$i++){
                    //die();

                    if(isset($_FILES['image']['name'][$i])){
                    $image=$_FILES['image']['name'][$i];

                    
                    if($style=='picLeft' || $style=='picRight'){
                        if($style=='picLeft'){
                            $target_dir = "../img/left/";
                        }else{
                            $target_dir = "../img/right/";
                        }
                    
                        $imgName=basename($_FILES["image"]["name"][$i]);
                        $target_file = $target_dir . basename($_FILES["image"]["name"][$i]);
                        $uploadOk = 1;
                        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                        // Kollar om filen redan finns
                        if ($uploadOk==1 && file_exists($target_file)) {
                            echo "Sorry, file already exists.<br>";
                            //$uploadOk = 0;
                        }
                        
                        if ($uploadOk==1 && $_FILES["image"]["size"][$i] > 50000000) {
                            echo "Sorry, your file is too large.<br>";
                            $uploadOk = 0;
                        }
                        // Kollar om $uploadOk är 0 eller inte
                        if ($uploadOk == 0) {
                            echo "Sorry, your file was not uploaded.";
                            //die;
                            //header('Location: ' . $_SERVER['HTTP_REFERER']);
                            // Laddar upp filen
                        } else {
                            if (move_uploaded_file($_FILES["image"]["tmp_name"][$i], $target_file)) {
                                echo "The file ". basename( $_FILES["image"]["name"][$i]). " has been uploaded.<br>";
                            }
                        }
                    }
                    
                    

                    if($style=='picLeft'){
                        array_push($imageArray,"../img/left/".$image);
                    }
                    if($style=='picRight'){
                        array_push($imageArray,"../img/right/".$image);
                    }
                    
                    if($style=='textLeft'){
                        array_push($imageArray,"../img/left");
                    }
                    if($style=='textRight'){
                        array_push($imageArray,"../img/right");
                    }
                    }
                    }
                    $count=0;
                    foreach ($postTitle as $po) {
                        $count++;
                    }
                    $ch=curl_init();
                    $arr=json_encode(array("serviceID"=>$serviceID,"metaTag"=>$metaTag,"pageTitle"=>$pageTitle));
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
                    cretPost($API,$count,$imageArray,$postText,$postTitle,$pageID,$username);
                    
                    header('location:blogg.php?service='.$serviceID);}
                        

                    

                ?>
            </div>
        </div>
    </div>
<script src="javascript/createinlegg.js"></script>
    
</body>
</html>