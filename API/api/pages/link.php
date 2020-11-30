<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: text/html; charset=utf-8');

include_once '../../config/Database.php';
include_once '../../models/linkpost.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate link object
$link = new Link($db);
$result = $link->read_text();

//Get row count
$num = $result->rowCount();

//Check if any link
if($num > 0){

        while($row = $result->fetch(PDO::FETCH_BOTH)){
            echo '<a href="search_single_service.php?serviceTitle=' . 
            $row['pText'] . '">' . 
            $row['pText'] . '</a>';
            echo '<br>';
        }

}else{
//No link
echo json_encode(
    array('message' => 'No links Found')
);
}


?>