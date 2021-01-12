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

    return $serTitle;

    if(isset($serTitle)){
        return $serTitle;
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
                if($i==0 && $s==0){
                    echo"<div class='ingress' style='font-weight:bold;'>
                    <div class='postTitle'><h2>$postTitel</h2></div>
                    <div class='text'>$postText</div>
                    </div>";
                }else{
                    if(stripos($imageURL,"../img/left/")!==false){
                    echo"<div class='post'>
                    <div class='column'>
                    <div class='postTitle'><h2>$postTitel</h2></div>
                    <img src='../icon/25360.png' class='icon'>
                    <img src='$imageURL' class='img'>
                    <div class='text'>$postText</div>
                    </div>
                    </div>";}
                    elseif(stripos($imageURL,"../img/right/")!==false){
                        echo"<div class='post2'>
                        <div class='column'>
                        <div class='postTitle'><h2>$postTitel</h2></div>
                        <img src='../icon/25360.png' class='icon'>
                        <img src='$imageURL' class='img'>
                        <div class='text'>$postText</div>
                        </div>
                        </div>";
                    }
                    elseif(stripos($imageURL,"../img/left")!==false){
                        echo"<div class='post3'>
                        <div class='column'>
                        <div class='postTitle'><h2>$postTitel</h2></div>
                        <img src='../icon/25360.png' class='icon'>
                        <div class='text'>$postText</div>
                        </div>
                        </div>";
                    }
                    elseif(stripos($imageURL,"../img/right")!==false){
                        echo"<div class='post4'>
                        <div class='column'>
                        <div class='postTitle'><h2>$postTitel</h2></div>
                        <img src='../icon/25360.png' class='icon'>
                        <div class='text'>$postText</div>
                        </div>
                        </div>";
                    }
                    else{
                        echo"<div class='post'>
                        <div class='column'>
                        <div class='postTitle'><h2>$postTitel</h2></div>
                        <img src='../icon/25360.png' class='icon'>
                        <img src='$imageURL' class='img'>
                        <div class='text'>$postText</div>
                        </div>
                        </div>";
                    }
                }
                
            }
            if($username==$name){
            
                echo "<form action='blogg.php?service=$serviceID' method='post'>
                <input type='submit' name='del' value='$pageID' placeholder='delete'>
                </form>";
                if(isset($_POST['del'])){
                    deletePage($API,$_POST['del']);
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
        if($service['serviceType']==1)
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