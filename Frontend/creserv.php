<?php
include "getservice.php";
session_start();
$API=$_SESSION['API'];

echo'<form action="creserv.php" method="post">
<input type="text" name="serviceTitle" requierd placeholder="Title">
<input type="hidden" name="userID" value="1">
<label for="publish">Publish:</label> 
<input type="radio" name="publish" value="1" checked>
<label for="publish">Don´t publish:</label>
<input type="radio" name="publish" value="0"><br>
<label for="post">Ingress</label><br>
<input type="text" name="postTitle" requierd placeholder="Title">
<input type="text" name="postText" requierd placeholder="Text">
<input type="submit" name="submit">
</form>';

if (isset($_POST['submit'])) {
    $userID=$_POST['userID'];
    $serviceTitle=$_POST['serviceTitle'];
    $username=$_SESSION['username'];
    $postTitle=array($_POST['postTitle']);
    $postText=array($_POST['postText']);
    $image=array("Ingress");

    $publish=$_POST['publish'];
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