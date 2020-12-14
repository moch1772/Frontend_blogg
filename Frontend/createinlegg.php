<?php
//session_start();
//$API=$_SESSION['API'];
$serviceID=2;
$font="Arial,sans-serif";
//$fontarr=array()
$bold="bold";

  
    echo"<form action='createinlegg.php' method='post' enctype='multipart/form-data'>

<input type='hidden' name='font' value='$font'>
<input type='button' value='add text box' onclick='newpost(pp)'>
<div id='pp'>
<input type='file' name='image' accept='image/x-png,image/gif,image/jpeg'><input type='text' name='subtitle[]'><input type='text' name='subtext[]'>
</div>

<input type='submit' name='submit'>
</form>";
if(isset($_POST['submit'])){
    $postTitle=$_POST['subtitle'];
    $postText=$_POST['subtext'];
    $image=$_FILES['image']['name'];
    $pageID=2;
    $username="karl";
    $API="RRmjdNWZuAeDqhEPrCWT";
    
    $target_dir = "../img/";
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
    die();
    //header('Location: ' . $_SERVER['HTTP_REFERER']);
  // Laddar upp filen
  } else {
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
      echo "The file ". basename( $_FILES["image"]["name"]). " has been uploaded.<br>";
    }
}
      

    print_r($_FILES);
    echo "<br>";
    echo "image name <br>";
    echo $image;
    echo "<br>";
    $image=array("../img/".$image);
    print_r($image);
    $count=0;
    foreach ($postTitle as $po) {
        $count++;
    }
    $ch=curl_init();
    $arr=json_encode(array("API"=>$API,"serviceID"=>$serviceID));
    $url="http://wider.ntigskovde.se/api/pages/create_page.php";
    curl_setopt($ch, CURLOPT_URL, $url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    curl_setopt($ch, CURLOPT_POST, 1);

    curl_setopt($ch, CURLOPT_POSTFIELDS, $arr);

    $output = curl_exec($ch);
    echo $output;
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
