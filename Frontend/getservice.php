<?php
function serviceTitle($API,$serviceID){
    $ch=curl_init();

    //$url= "http://sko.te4-ntig.se/wider/api/pages/read_single_service.php?API=$API&serviceID=$serviceID";
    $url= "http://wider.ntigskovde.se/api/pages/read_single_service.php?API=$API&serviceID=$serviceID";

    curl_setopt($ch, CURLOPT_URL, $url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    
    $output = curl_exec($ch);
    $s=strpos($output,'","serviceD');
    $d=strpos($output,'Title":"');
    $d+=8;
    $p=$s-$d;
    
    $serTitle=substr($output,$d,$p);
    echo$serTitle;
    
}
function servicePage($API,$serviceID){
   
    //sends reqest via url
//$url = "http://sko.te4-ntig.se/wider/api/pages/read_page_service.php?API=$API&serviceID=$serviceID";
 $url = "http://wider.ntigskovde.se/api/pages/read_page_service.php?API=$API&serviceID=$serviceID";

    
    $output = file_get_contents($url);
    $tt=json_decode($output,true);
    
    
    //calculatess length of output array
    $count=0;
    foreach($tt as $t){
        $count +=count($t);
    }
    
     for ($i=0; $i < $count; $i++) { 
         $pageID=$tt['pages'][$i]['pageID'];
         //$pageTitle=$tt['pages'][$i]['pageTitle'];
         
         //$ul = "http://sko.te4-ntig.se/wider/api/pages/read_post_page.php?API=$API&pageID=$pageID"; 
         $ul = "http://wider.ntigskovde.se/api/pages/read_post_page.php?API=$API&pageID=$pageID";
        
         $outpt = file_get_contents($ul);
         $redPost=json_decode($outpt,true);

        $cont=0;
        foreach($redPost as $red){
            $cont +=count($red);
        }
         for ($s=0; $s < $cont; $s++) { 
           
            $postID=$redPost['posts'][$s]['postID'];
            $postTitel=$redPost['posts'][$s]['postTitle'];
            $postText=$redPost['posts'][$s]['pText'];
            $imageURL=$redPost['posts'][$s]['imageURL'];
            
        
        echo"<div class='post'>
            <div class='postTitle'><h2>$postTitel</h2></div>
            <img src='../img/360.jpg' class='img'>
            <div class='text'>$postText</div>
            <img src='../icon/25360.png' class='icon'>
            </div>";
           
         }
        }
        
        
     
            
    }
    function readComment($API,$pageID){
        //$ulc = "http://sko.te4-ntig.se/wider/api/comment/read_page_comment.php?API=$API&pageID=$pageID";
        $ulc = "http://wider.ntigskovde.se/api/comment/read_page_comment.php?API=$API&pageID=$pageID";
        
        $como= file_get_contents($ulc);
       $redComment=json_decode($como,true);

       $count=0;
       foreach($redComment as $red){
           $count +=count($red);
       }
       for ($i=0; $i < $count; $i++) { 
        $comment=$redComment['comment'][$i]['cText'];
        echo $comment;
       }
       
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