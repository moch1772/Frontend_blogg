<?php
include "getservice.php";
echo"<form action='creteUse.php' method='post'>
<input type='text' name='username' placeholder='username' required>
<input type='password' name='password' placeholder='password' required>
<input type='text' name='firstN' placeholder='firstname' required>
<input type='text' name='middleN' placeholder='middlename' required>
<input type='text' name='lastN' placeholder='lastname' required>
<input type='submit' name='submit' value='submit'>
</form>";

$userID=17;
session_start();
$API=$_SESSION['API'];

if (isset($_POST['submit'])){
    $username=$_POST['username'];
    $password=$_POST['password'];
    $firstN=$_POST['firstN'];
    $lastN=$_POST['lastN'];
    $middleN=$_POST['middleN'];
    $admin=0;
$ch=curl_init();
 $arry=json_encode(array("username"=>$username,"password"=>$password,"firstName"=>$firstN,"middleName"=>$middleN,"lastName"=>$lastN,"admin"=>$admin));
$url = "http://wider.ntigskovde.se/api/user/create_user.php?API=$API";
 
curl_setopt($ch, CURLOPT_URL, $url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

curl_setopt($ch, CURLOPT_POST, 1);

curl_setopt($ch, CURLOPT_POSTFIELDS, $arry);

$output = curl_exec($ch);
timeout($output);
}
$url = "http://wider.ntigskovde.se/api/user/read_user.php?API=$API";
        
$outupt = file_get_contents($url);
$redUser=json_decode($outupt,true);
var_dump($redUser);
readUser($API,$userID);
function readUser($API,$userID){
$url = "http://wider.ntigskovde.se/api/user/read_single_user.php?API=$API&userID=$userID";
        
$outupt = file_get_contents($url);
$redUser=json_decode($outupt,true);
var_dump($redUser);
}
?>