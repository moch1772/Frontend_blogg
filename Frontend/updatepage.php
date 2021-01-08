<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
include "getservice.php";
$pageID=6;

$API="RRmjdNWZuAeDqhEPrCWT";
$url = "http://wider.ntigskovde.se/api/pages/read_post_page.php?API=$API&pageID=$pageID";
        
$outupt = file_get_contents($url);
$redPost=json_decode($outupt,true);
var_dump($redPost);
timeout($redPost);

if(isset($redPost['message'])){
    //header('location:index.php');
}
$cont=countt($redPost);
function countt($jcode){
    $count=0;
foreach($jcode as $j){
   $count +=count($j);
}
return $count;
}
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
    $count=countt($postTi);
    cretPost($API,$count,$image,$postTe,$postTi,$pageID,$username); 
    deltallPost($API,$count,$poID);
}
echo"<form action='updatepage.php' method='post'>";
for ($s=0; $s < $cont; $s++) { 
  
   $postID=$redPost['posts'][$s]['postID'];
   $postTitel=$redPost['posts'][$s]['postTitle'];
   $postText=$redPost['posts'][$s]['pText'];
   $username=$redPost['posts'][$s]['username'];
   $image=$redPost['posts'][$s]['imageURL'];
   
   echo"<input type='text' name='title[]' value='$postTitel'>
   <input type='text' name='text[]' value='$postText'>
   <input type='hidden' name='postID[]' value='$postID'>
   <input type='submit' name='delete' value='$postID' placeholder='delete'>";

  
}
echo"<div id='pp'></div>
<input type='submit' name='submit' value='submit'>
<input type='button' value='add text box' onclick='newpost(pp)'>
</form>";


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
    nys.innerHTML ="<input type='text' name='title[]'><input type='text' name='text[]'>";
    document.getElementById("pp").appendChild(nys);
}
</script>
</body>
</html>