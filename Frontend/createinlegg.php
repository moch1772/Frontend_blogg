<?php
//session_start();
//$API=$_SESSION['API'];
$serviceID=2;
$font="Arial,sans-serif";
//$fontarr=array()
$bold="bold";

  
    echo"<form action='createinlegg.php' method='post'>

<input type='hidden' name='font' value='$font'>
<input type='button' value='add text box' onclick='newpost(pp)'>
<div id='pp'>
<input type='text' name='image[]'><input type='text' name='subtitle[]'><input type='text' name='subtext[]'>
</div>

<input type='submit' name='submit'>
</form>";
if(isset($_POST['submit'])){
    $postTitle=$_POST['subtitle'];
    $postText=$_POST['subtext'];
    $image=$_POST['image'];
    $pageID=2;
    $username="karl";
    $API="RRmjdNWZuAeDqhEPrCWT";

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
    nys.innerHTML ="<input type='text' name='image[]'><input type='text' name='subtitle[]'><input type='text' name='subtext[]'>";
    document.getElementById("pp").appendChild(nys);
}


</script>
