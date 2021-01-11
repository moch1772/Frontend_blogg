<?php
session_start();
include_once "getservice.php";
$API=$_SESSION['API'];

//hämtar service ID and puts it in an array
if(isset($_POST['search'])){
    $pages=array();
    $search=$_POST['search'];
    $ul = "http://wider.ntigskovde.se/api/pages/read_service.php?API=$API";
    $output = file_get_contents($ul);
    $tttt=json_decode($output,true);
    $counter=0;
    $sID=array();
    $printArray=array();

    foreach($tttt['data'] as $tt){
        $counter++;
    }
    //print_r($tttt['data'][0]);
    for($i=0;$i<$counter;$i++){
        //get by service title
        $serviceID=$tttt['data'][$i]['serviceID'];
        array_push($sID,$tttt['data'][$i]['serviceID']);
        $ch=curl_init();
            $url= "http://wider.ntigskovde.se/api/pages/read_single_service.php?API=$API&serviceID=".$serviceID;
            $service=file_get_contents($url);
            curl_setopt($ch, CURLOPT_URL, $url);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            
            $service = curl_exec($ch);
            $service = ltrim($service, ',');
            $service=json_decode($service,true);
            if(isset($service['serviceTitle'])){
                if (stripos($service['serviceTitle'], $search) !== false) {
                    array_push($printArray,$service['serviceID']);
                }
            }
            //get service ID based on postTitle and pText
            //print_r($printArray);
        
    }
    array_push($printArray,'P');
    $sID = array_unique($sID);
    $sID = array_values($sID);
    for($i=0;$i<count($sID);$i++){
        $url= "http://wider.ntigskovde.se/api/pages/read_page_service.php?API=$API&serviceID=".$sID[$i];
            $service=file_get_contents($url);
            curl_setopt($ch, CURLOPT_URL, $url);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            
            $service = curl_exec($ch);
            $service = ltrim($service, ',');
            $service=json_decode($service,true);
            foreach($service as $page){
                if(isset($page[0]['pageID'])){
                if(count($page)>1){
                foreach($page as $pageID){
                    $temp=array($pageID['pageID'],$pageID['serviceID']);
                    array_push($pages,$temp);
                }
                }else{
                    $temp=array($page[0]['pageID'],$page[0]['serviceID']);
                    array_push($pages,$temp);
                }
            }
            }
    }
    foreach($pages as $pagePost){
        $url= "http://wider.ntigskovde.se/api/pages/read_post_page.php?API=$API&pageID=".$pagePost[0];
            $services=file_get_contents($url);
            curl_setopt($ch, CURLOPT_URL, $url);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $services = curl_exec($ch);
            $services= json_decode($services,true);
            /*print_r($services['posts']);
            echo "<br>";
            echo "<br>";*/
            foreach($services as $service){
                if(gettype($service)=="array"){
                    foreach($service as $post){
                    if(isset($post['postTitle']) || isset($post['pText'])){
                        if (stripos($post['postTitle'], $search) !== false || stripos($post['pText'], $search) !== false) {
                            array_push($printArray,$pagePost[1]);
                        }
                    }
                }
            }
            }
    }
    
    $printArray = array_unique($printArray);
    $printArray = array_values($printArray);
    
    for($i=0;$i<count($printArray);$i++)
    {
        if($printArray[$i]!="P"){
            if(!checkType($API,$printArray[$i])){
                unset($printArray[$i]);
            }
        }
    }
    if(count($printArray)==1){
        $printArray=array("S");
    }
    if($printArray[count($printArray)-1]=="P"){
        array_pop($printArray);
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>Document</title>
</head>
<body>
<?php
//include "getservice.php";
//$pageTitle="nog";
//sertchPage($API,$serviceID,$pageTitle);
    echo'<div class="content">
    <div class="foreground">
            <div class="billboard"></div>
            <div class="title"><h1>';
            echo "You are searching for $search";
            echo'</h1></div>
            
            <div class="menu">
            <a href="home.php" class="mLButton">
                <div class="mText">
                    Home
                </div>
            </a>
            <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ&ab_channel=RickAstleyVEVO" class="mRButton">
                <div class="mText">
                    Profile
                </div>
            </a>
            <div class="msearch">
                    <form action="search.php" method="POST">
                        <input type="text" id="search" name="search" placeholder="Search"></form>
                    </form>
            </div>
        </div>
            ';
        if(count($printArray)>1 && $printArray[0]!="P"){
            echo'
                <div class="middleBox">
                <div class="middleBoxTitle">
                Bloggs with '.$search.' in the name   
                </div>
                </div>
                <br>
                <br>
                <br>';
        }
        foreach($printArray as $serviceID){
            if($serviceID=="P"){
                echo'
                <div class="middleBox">
            <div class="middleBoxTitle">
                    Bloggs that talk about '.$search.'   
                </div>
                </div>
                <br>
                <br>
                <br>
                ';
            }
            if($serviceID!="P" && $serviceID!="S"){
                $url= "http://wider.ntigskovde.se/api/pages/read_single_service.php?API=$API&serviceID=".$serviceID;
                curl_setopt($ch, CURLOPT_URL, $url);

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                
                $service = curl_exec($ch);
                $service = ltrim($service, ',');
                $service=json_decode($service,true);   
                echo'<a class="link" href="blogg.php?service='.$serviceID.'">
                <div class="searchBox">
                <div class="searchTitle">'.
                        $service["serviceTitle"]   
                    .'</div>
                    <div class="searchDate">
                    '.
                    $service["serviceDate"]   
                    .'
                    </div>
                    <div class="searchText">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                    </div>';
                echo "</div>
                </a>
                <br>";
            }
            if($serviceID=="S"){
                echo'
                <div class="middleBox">
                <div class="middleBoxTitle">
                    There is no blogg that is named or talks about '.$search.'   
                </div>
                </div>
                <br>
                <br>
                <br>
                ';         
            } 
    }
       
    ?>
   
</body>
</html>