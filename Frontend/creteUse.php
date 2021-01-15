<?php
session_start();
include_once 'getservice.php';
$userID=$_SESSION['userID'];
$API=$_SESSION['API'];

if (isset($_POST['submit'])){
    $username=$_POST['username'];
    $password=$_POST['password'];
    $firstN=$_POST['firstN'];
    $lastN=$_POST['lastN'];
    $middleN=$_POST['middleN'];
    $admin=0;
    var_dump(strpos($username,"<"));
    for($i=1;$i<16;$i++){
        if(5>=$i){
            echo $i;
            $check='<';
            echo '<br>';}
        if(10>=$i && $i>5){
            echo $i;
            $check='/';
            echo $check;
            echo '<br>';}
        if(15>=$i && $i>10){
            echo $i;
            $check='>';
            echo '<br>';}
        if(strpos($username,$check)!=false||strpos($password,$check)!=false||strpos($firstN,$check)!=false||strpos($middleN,$check)!=false||strpos($lastN,$check)!=false){
            header('Location:creteUse.php');
        }
        
    }
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
//var_dump($redUser);
//readUser($API,$userID);
header('Location:home.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/register.css">
    <title>Document</title>
</head>
<body>

<?php
include "getservice.php";
echo'<div class="content"> 
            <div class="foreground">
                <div class="text">Please fill in all information to create an account<br>
                Note: you may not use these symbols:<>/</div>

                <div class="box">
                    <div class="hidden"></div>';
                    
echo"<form action='creteUse.php' method='post'>
<input class='input' type='text' name='username' placeholder='username' required>
<input class='input' type='password' name='password' placeholder='password' required><br>
<input class='input' type='text' name='firstN' placeholder='firstname' required>
<input class='input' type='text' name='middleN' placeholder='middlename' required><br>
<input class='input' type='text' name='lastN' placeholder='lastname' required><br>
<input class='button' type='submit' name='submit' value='submit'>
</form>";
echo "</div>
</div>
</div>";

function readUser($API,$userID){
$url = "http://wider.ntigskovde.se/api/user/read_single_user.php?API=$API&userID=$userID";
        
$outupt = file_get_contents($url);
$redUser=json_decode($outupt,true);
//var_dump($redUser);
}
?>