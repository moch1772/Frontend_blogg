<?php
//session_start();
//$API=$_SESSION['API'];
//$username=$_SESSION['username'];
$serviceID=1;
$font="Arial,sans-serif";
//$fontarr=array()
$bold="bold";

  
    echo"<form action='createinlegg.php' method='post' enctype='multipart/form-data'>

<input type='hidden' name='font' value='$font'>
<input type='button' value='add text box' onclick='newpost(pp)'>

<div id='pp'>
<input type='text' name='postTitle' placeholder='page title'>
<input type='text' name='subtitle[]' placeholder='post title'>
<input type='text' name='subtext[]' placeholder='post text'>
<input type='file' name='image' accept='image/x-png,image/gif,image/jpeg'>
</div>
<input type='radio' id='picLeft' name='picControl' value='picLeft'>
<label for='picLeft'>Image to the left</label><br>
<input type='radio' id='picRight' name='picControl' value='picRight'>
<label for='picRight'>Image to the right</label><br>
<input type='radio' id='textLeft' name='picControl' value='textLeft' checked='checked'>
<label for='textLeft'>No image text alaignd to the left</label>
<br>
<input type='radio' id='textRight' name='picControl' value='textRight'>
<label for='textRight'>No image text alaignd to the right</label>
<br>
<input type='submit' name='submit' value='submit'>
</form>";
if(isset($_POST['submit'])){
    $postTitle=$_POST['subtitle'];
    $postText=$_POST['subtext'];
    $metaTag="hugo";
    $pageTitle="smothe";
    $style=$_POST['picControl'];

    $username="karl";
    $API="RRmjdNWZuAeDqhEPrCWT";
    
    if(isset($_FILES['image']['name'])){
    $image=$_FILES['image']['name'];

    
    if($style=='picLeft' || $style=='picRight'){
        if($style=='picLeft'){
            $target_dir = "../img/left";
        }else{
            $target_dir = "../img/right";
        }
    
        $imgName=basename($_FILES["image"]["name"]);
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Kollar om filen redan finns
        if ($uploadOk==1 && file_exists($target_file)) {
            echo "Sorry, file already exists.<br>";
            $uploadOk = 0;
        }
        
        if ($uploadOk==1 && $_FILES["image"]["size"] > 5000000) {
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
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                echo "The file ". basename( $_FILES["image"]["name"]). " has been uploaded.<br>";
            }
        }
    }
}
    if($style=='picLeft'){
        $image=array("../img/left".$image);
    }
    if($style=='picRight'){
        $image=array("../img/right".$image);
    }
    if($style=='textLeft'){
        $image=array("../img/left");
    }
    if($style=='textRight'){
        $image=array("../img/right");
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
       for ($i=0; $i < $count; $i++) { 
    
    $arry=json_encode(array("imageURL"=>$image[$i],"pText"=>$postText[$i],"postTitle"=>$postTitle[$i],"pageID"=>$pageID,"username"=>$username));
        $url="http://wider.ntigskovde.se/api/pages/create_post.php?API=$API";
        
        curl_setopt($ch, CURLOPT_URL, $url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    curl_setopt($ch, CURLOPT_POST, 1);

    curl_setopt($ch, CURLOPT_POSTFIELDS, $arry);

    $output = curl_exec($ch);
    echo $output;
       }   
}


?>
<script type="text/JavaScript">
function newpost(tt){
    var nys = document.createElement('div');
    nys.innerHTML ="<input type='file' name='image' accept='image/x-png,image/gif,image/jpeg'><input type='text' name='subtitle[]'><input type='text' name='subtext[]'>";
    document.getElementById("pp").appendChild(nys);
}


</script>
