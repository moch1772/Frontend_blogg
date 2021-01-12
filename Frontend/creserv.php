<?php
include "getservice.php";
session_start();
$API=$_SESSION['API'];

echo'<form action="creserv.php" method="post">
<input type="text" name="serviceTitle" requierd placeholder="Title">
<input type="hidden" name="serviceType" value="1">
<input type="hidden" name="userID" value="1">
<label for="publish">Publish:</label> 
<input type="radio" name="publish" value="1" placeholder="privet">
<label for="publish">Don´t publish:</label>
<input type="radio" name="publish" value="0" placeholder="public">
<input type="submit" name="submit">
</form>';

if (isset($_POST['submit'])) {
    $userID=$_POST['userID'];
    $serviceTitle=$_POST['serviceTitle'];
    $serviceType=$_POST['serviceType'];
    $publish=$_POST['publish'];
    $ch=curl_init();
    $arr= json_encode(array("userID"=>$userID,"serviceType"=>$serviceType,"publish"=>$publish,"serviceTitle"=>$serviceTitle));
    $url="http://wider.ntigskovde.se/api/pages/create_service.php?API=$API";
    curl_setopt($ch, CURLOPT_URL, $url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    curl_setopt($ch, CURLOPT_POST, 1);

    curl_setopt($ch, CURLOPT_POSTFIELDS, $arr);

    $output = curl_exec($ch);
    timeout($output);
    echo$output;
    header("Location:home.php");
}
?>