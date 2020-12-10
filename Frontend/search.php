<?php
$API="RRmjdNWZuAeDqhEPrCWT";
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
/*    print_r($tttt);
    echo "<br>";*/
    foreach($tttt['data'] as $tt){
        //print_r($tt);
        //echo "<br>";
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
    $sID = array_unique($sID);
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
            $service=file_get_contents($url);
            curl_setopt($ch, CURLOPT_URL, $url);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $service = curl_exec($ch);
            $service= json_decode($service,true);
            if(isset($service['posts'])){
                if(isset($service['posts'][0]['postTitle']) || isset($service['posts'][0]['pText'])){
                    if (stripos($service['posts'][0]['postTitle'], $search) !== false || stripos($service['posts'][0]['pText'], $search) !== false) {
                        array_push($printArray,$pagePost[1]);
                    }
                }
            }
    }
    
    $printArray = array_unique($printArray);
    //print_r($printArray);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="test.css">
    <title>Document</title>
</head>
<body>
<?php
include "getservice.php";
$API="RRmjdNWZuAeDqhEPrCWT";
$serviceID=2;
//$pageTitle="nog";
//sertchPage($API,$serviceID,$pageTitle);
    echo'<div class="content">
    <div class="foreground">
            <div class="billboard"></div>
            <div class="title"><h1>';
            echo "you are searching for $search";
            echo'</h1></div>
            
            <div class="menu">
            <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ&ab_channel=RickAstleyVEVO" class="mLButton">
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
        foreach($printArray as $serviceID){
            $url= "http://wider.ntigskovde.se/api/pages/read_single_service.php?API=$API&serviceID=".$serviceID;
            curl_setopt($ch, CURLOPT_URL, $url);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            
            $service = curl_exec($ch);
            $service = ltrim($service, ',');
            $service=json_decode($service,true);   
            echo'<a class="link" href="https://www.w3schools.com/css/tryit.asp?filename=trycss_font-size_px">
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
            //print_r($service);
            echo "</div>
            </a>
            <br>";
        }        
    ?>
   
</body>
</html>