<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
session_start();
include "getservice.php";
$pageID=$_POST['edit'];

$API=$_SESSION['API'];

$url = "http://wider.ntigskovde.se/api/pages/read_post_page.php?API=$API&pageID=$pageID";
        
$outupt = file_get_contents($url);
$redPost=json_decode($outupt,true);
var_dump($redPost);
timeout($redPost);

if(isset($redPost['message'])){
    //header('location:index.php');
}
$cont=countt($redPost);


echo"<form action='updatepage.php' method='post' enctype='multipart/form-data'>";
for ($s=0; $s < $cont; $s++) { 
  
   $postID=$redPost['posts'][$s]['postID'];
   $postTitel=$redPost['posts'][$s]['postTitle'];
   $postText=$redPost['posts'][$s]['pText'];
   $username=$redPost['posts'][$s]['username'];
   $img=$redPost['posts'][$s]['imageURL'];
   
   echo"<input type='text' name='title[]' value='$postTitel'>
   <input type='text' name='text[]' value='$postText'>
   <input type='hidden' name='postID[]' value='$postID'>
   <input type='hidden' name='img[]' value='$img'>
   <input type='file' name='image[]' accept='image/x-png,image/gif,image/jpeg'>
   <img src='$img' class='img'>
 
   <input type='submit' name='delete' value='$postID' placeholder='delete'>";
}
echo"<div id='pp'></div>
<input type='radio' id='picLeft' name='picControl' value='picLeft'>
<label for='picLeft'>Image to the left</label><br>
<input type='radio' id='picRight' name='picControl' value='picRight'>
<label for='picRight'>Image to the right</label><br>
<input type='radio' id='textLeft' name='picControl' value='textLeft' checked='checked'>
<label for='textLeft'>No image text aligned to the left</label>
<br>
<input type='radio' id='textRight' name='picControl' value='textRight'>
<label for='textRight'>No image text aligned to the right</label>
<br>
<input type='submit' name='submit' value='submit'>
<input type='button' value='add text box' onclick='newpost(pp)'>
</form>";
if (array_key_exists('delete',$_POST)){
   
    $poID=$_POST['delete'];
    echo"sås";
    deltPost($API,$poID);
}
if (array_key_exists('submit',$_POST)) {
    echo "fun";
    $postTe=$_POST['text'];
    $postTi=$_POST['title'];
    $poID=$_POST['postID'];
    //$img=$_POST['img'];
    $style=$_POST['picControl'];
    $count=countt($postTi);
    $imageArray=array();

    if(isset($_FILES['image']['name'])){
    $countfiles = count($_FILES['image']['name']);
    }
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
                if (isset($img)) {
                       unlink($img);
                }
                if($style=='picLeft'){
                    array_push($imageArray,"../img/left/".$image);
                }
                if($style=='picRight'){
                    array_push($imageArray,"../img/right/".$image);
                }
            }
        }
    }
    $igg=$redPost['posts'][$i]['imageURL'];
    
    
    if(isset($igg)){
            array_push($imageArray,$igg);
              
    }
    if($style=='textLeft'){
        array_push($imageArray,"../img/left");
    }
    if($style=='textRight'){
        array_push($imageArray,"../img/right");
    }
    
    }
    
    
        cretPost($API,$count,$imageArray,$postTe,$postTi,$pageID,$username); 
        deltallPost($API,$count,$poID);
}}

function deltPost($API,$postID){
    
    $ch=curl_init();
        $arry=json_encode(array("postID"=>$postID));
$url = "http://wider.ntigskovde.se/api/pages/delete_post.php?API=$API";
        
curl_setopt($ch, CURLOPT_URL, $url);
 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

curl_setopt($ch, CURLOPT_POST, 1);

curl_setopt($ch, CURLOPT_POSTFIELDS, $arry);

$output = curl_exec($ch);
timeout($output);
}

function deltallPost($API,$count,$postID){
    for ($s=0; $s < $count; $s++) { 
        $ch=curl_init();
        $arry=json_encode(array("postID"=>$postID[$s]));
$url = "http://wider.ntigskovde.se/api/pages/delete_post.php?API=$API";
        
curl_setopt($ch, CURLOPT_URL, $url);
 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

curl_setopt($ch, CURLOPT_POST, 1);

curl_setopt($ch, CURLOPT_POSTFIELDS, $arry);

$output = curl_exec($ch);
timeout($output);
    }
}
?>
<script type="text/JavaScript">

function newpost(tt){
    var nys = document.createElement('div');
    nys.innerHTML ="<input type='text' name='title[]'><input type='text' name='text[]'><input type='file' name='image[]' accept='image/x-png,image/gif,image/jpeg'>";
    document.getElementById("pp").appendChild(nys);
}
</script>
</body>
</html>