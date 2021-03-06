<?php
function serviceTitle($API,$serviceID){
    $ch=curl_init();

    //$url= "http://sko.te4-ntig.se/wider/api/pages/read_single_service.php?API=$API&serviceID=$serviceID";
    $url= "http://wider.ntigskovde.se/api/pages/read_single_service.php?API=$API&serviceID=$serviceID";

    curl_setopt($ch, CURLOPT_URL, $url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    
    $output = curl_exec($ch);
    timeout($output);
    $s=strpos($output,'","serviceD');
    $d=strpos($output,'Title":"');
    $d+=8;
    $p=$s-$d;
    
    $serTitle=substr($output,$d,$p);

    $dd = str_replace(array("\u00f6","\u00e4","\u00e5"),array("ö","ä","å"),$serTitle);
    $dd=explode('\u00a4',$dd);

    if(isset($dd)){
        return $dd;
    }

    
}
function timeout($output){
    if ($output=="tiemaout") {
        header("location:login.php");
    }
}
function servicePage($API,$serviceID,$name){
   
    //sends reqest via url
//$url = "http://sko.te4-ntig.se/wider/api/pages/read_page_service.php?API=$API&serviceID=$serviceID";
 $url = "http://wider.ntigskovde.se/api/pages/read_page_service.php?API=$API&serviceID=$serviceID";

    
    $output = file_get_contents($url);

    timeout($output);
    $tt=json_decode($output,true);
    $count=0;
    //calculatess length of output array
    
   
    foreach($tt as $t){
        if($t!="No pages Found"){
        $count +=count($t);}
    }
    
    if($count>0){
        for ($i=0; $i < $count; $i++) { 
            $pageID=$tt['pages'][$i]['pageID'];
            // $pageTitle=$tt['pages'][$i]['pageTitle'];
            
            //$ul = "http://sko.te4-ntig.se/wider/api/pages/read_post_page.php?API=$API&pageID=$pageID"; 
            $ul = "http://wider.ntigskovde.se/api/pages/read_post_page.php?API=$API&pageID=$pageID";
            
            $outpt = file_get_contents($ul);
            $redPost=json_decode($outpt,true);
            $cont=0;
            if(!isset($redPost['message'])){
            foreach($redPost as $red){
                $cont +=count($red);
            }
            for ($s=0; $s < $cont; $s++) { 
            
                $postID=$redPost['posts'][$s]['postID'];
                $postTitel=$redPost['posts'][$s]['postTitle'];
                $postText=$redPost['posts'][$s]['pText'];
                $username=$redPost['posts'][$s]['username'];
                $imageURL=$redPost['posts'][$s]['imageURL'];
                if($i==0 && $s==0 && $postTitel="Ingress"){
                    echo"<div class='ingress' style='font-weight:bold;'>
                    <div class='ingTitle'><h2>Description</h2></div>
                    <div class='ingText'>$postText</div>
                    </div>";
                }else{
                    if(stripos($imageURL,"../img/left/")!==false){
                    echo"<div class='post'>
                    <div class='column'>
                    <div class='postTitle'><h2>$postTitel</h2></div>
                    <div class='text'>$postText</div>
                    <img src='$imageURL' class='img'>
                    </div>
                    </div>";}
                    elseif(stripos($imageURL,"../img/right/")!==false){
                        echo"<div class='post2'>
                        <div class='column'>
                        <div class='postTitle'><h2>$postTitel</h2></div>
                        <img src='../icon/25360.png' class='icon'>
                        <div class='text'>$postText</div>
                        </div>
                        </div>";
                    }
                    elseif(stripos($imageURL,"../img/left")!==false){
                        echo"<div class='post3'>
                        <div class='column'>
                        <div class='postTitle'><h2>$postTitel</h2></div>
                        <div class='text'>$postText</div>
                        </div>
                        </div>";
                    }
                    elseif(stripos($imageURL,"../img/right")!==false){
                        echo"<div class='post4'>
                        <div class='column'>
                        <div class='postTitle'><h2>$postTitel</h2></div>
                        <div class='text'>$postText</div>
                        </div>
                        </div>";
                    }
                    else{
                        echo"<div class='post'>
                        <div class='column'>
                        <div class='postTitle'><h2>$postTitel</h2></div>
                        <img src='$imageURL' class='img'>
                        <div class='text'>$postText</div>
                        </div>
                        </div>";
                    }
                }
                
            }
            if($username==$name && $postTitel!="Ingress"){
            
                echo "<form action='blogg.php?service=$serviceID' method='post'>
                <input type='hidden' name='de' value='$pageID'>
                <input class='delet' type='submit' name='del' value='Delete'>
                </form>
                <form action='updatepage.php?service=$serviceID' method='post'>
                <input type='hidden' name='edit' value='$pageID'>
                <input class='edit' type='submit' name='ed' value='Edit'>
                </form>";
                if(isset($_POST['del'])){
                    deletePage($API,$_POST['de']);
                }
            }
            }
        }
    }else{
        echo"<div class='ingress' style='font-weight:bold;'>There are no post on this page
                    </div>";
        echo "";
    }
        
        
     
            
    }
    function readComment($API,$pageID){
        //$ulc = "http://sko.te4-ntig.se/wider/api/comment/read_page_comment.php?API=$API&pageID=$pageID";
        $ulc = "http://wider.ntigskovde.se/api/comment/read_page_comment.php?API=$API&pageID=$pageID";
        
        $output= file_get_contents($ulc);
        timeout($output);
       $redComment=json_decode($output,true);

       $count=0;
       foreach($redComment as $red){
           $count +=count($red);
       }
       for ($i=0; $i < $count; $i++) { 
        $comment=$redComment['comment'][$i]['cText'];
        echo $comment;
       }
       
    }
    function logIn($uname,$paword){
        $arry=json_encode(array("username"=>$uname,"password"=>$paword));
        $ch=curl_init();
        $url="http://wider.ntigskovde.se/api/user/authenticate_user.php";
        
        curl_setopt($ch, CURLOPT_URL, $url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    curl_setopt($ch, CURLOPT_POST, 1);

    curl_setopt($ch, CURLOPT_POSTFIELDS, $arry);

    $output = curl_exec($ch);

     return $output;
    }
    function checkType($API,$serviceID)
    {   $ch=curl_init();
        
        $url= "http://wider.ntigskovde.se/api/pages/read_single_service.php?API=$API&serviceID=".$serviceID;
        $service=file_get_contents($url);
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            
        $service = curl_exec($ch);
        $service = ltrim($service, ',');
        $service=json_decode($service,true);
        if($service['serviceType']==3)
        {
            return true;
        }else{
            return false;
        }
    }
    function deletePage($API,$pageID){
        
        $ch=curl_init();
        $arry=json_encode(array("pageID"=>$pageID));
        $url="http://wider.ntigskovde.se/api/pages/delete_page.php?API=$API";
        
        curl_setopt($ch, CURLOPT_URL, $url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $arry);

    $output = curl_exec($ch);
    }
    function cretPost($API,$count,$image,$postText,$postTitle,$pageID,$username){
        $ch=curl_init();
        for ($i=0; $i < $count; $i++) { 
     
     $arry=json_encode(array("imageURL"=>$image[$i],"pText"=>$postText[$i],"postTitle"=>$postTitle[$i],"pageID"=>$pageID,"username"=>$username));
         $url="http://wider.ntigskovde.se/api/pages/create_post.php?API=$API";
         
         curl_setopt($ch, CURLOPT_URL, $url);
 
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 
     curl_setopt($ch, CURLOPT_POST, 1);
 
     curl_setopt($ch, CURLOPT_POSTFIELDS, $arry);
 
     $output = curl_exec($ch);
        }
        }
        // reads all users
        function getuserID($API,$username){
            $url = "http://wider.ntigskovde.se/api/user/read_user.php?API=$API";
        
$output = file_get_contents($url);
$redUser=json_decode($output,true);
$count=countt($redUser);
for ($i=0; $i <$count ; $i++) { 
    $userID=$redUser['data'][$i]['userID'];
    $uname=$redUser['data'][$i]['username'];
    if ($uname==$username) {
    return $userID;
    break;
    }
}
        }
function countt($jcode){
    $count=0;
foreach($jcode as $j){
   $count +=count($j);
}
return $count;
}
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

        
    /*function sertchPage($API,$serviceID,$pageTitle){
        //$url = "http://sko.te4-ntig.se/wider/api/pages/read_page_service.php?API=$API&serviceID=$serviceID";
        $url = "http://wider.ntigskovde.se/api/pages/read_page_service.php?API=$API&serviceID=$serviceID";


        $output = file_get_contents($url);                 
        $tt=json_decode($output,true);

        $count=0;
    foreach($tt as $t){
        $count +=count($t);
    }
echo$tt;
        $pageT=$tt['pages'][]['pageTitle'=>$pageTitle];
        echo$pageT;

    }*/
?>