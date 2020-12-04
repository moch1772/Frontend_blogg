<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Comment.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate comment object
$comment = new Comment($db);
$comment->pageID = isset($_GET['pageID']) ? $_GET['pageID'] : die();
$result = $comment->read_page_comment();

if(!empty($result)){
    echo json_encode($result);
}else{
    echo json_encode(
        array('message' => 'No Comments Found')
    );
}




?>