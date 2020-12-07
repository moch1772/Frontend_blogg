<?php


function servicePage($API,$serviceID){
$url = "http://sko.te4-ntig.se/wider/api/pages/read_page_service.php?API=$API&serviceID=$serviceID";

                       
$output = file_get_contents($url);
    $tt=json_decode($output,true);

    $count=0;
    foreach($tt as $t){
        $count +=count($t);
    }
    
     for ($i=0; $i < $count; $i++) { 
         $pageID=$tt['pages'][$i]['pageID'];
         
         $ul = "http://sko.te4-ntig.se/wider/api/pages/read_post_page.php?API=$API&pageID=$pageID";
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
            
        
        echo"<div class='postTitle'><h2>$postTitel</h2></div>
            <div class='text'>$postText</div>
            <div class='img'><h2>Bild</h2></div>";
           
         }
        }
        
        
     
            
    }
?>