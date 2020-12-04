<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/post.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate comment object
$post = new post($db);

//Get serviceID from URL
$post->pageID = isset($_GET['pageID']) ? $_GET['pageID'] : die();
$result = $post->read_page_post();

//Get row count
$num = $result->rowCount();

//Check if any comment
if($num > 0){
    //Comment array
    $post_arr = array();
    $post_arr['posts'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $post_item = array(
            'postID' => $postID,
            'postTitle' => $postTitle,
            'username' => $username,
            'pText' => $pText,
            'imageURL' => $imageURL,
            'pageID' => $pageID,
            'postDate'=>$postDate
        );

        //Push to "data"
        array_push($post_arr['posts'], $post_item);
    }
    //Turn to JSON and output
    echo json_encode($post_arr);
    /* how to get all post ID
    for($i=0;$i<$num;$i++){
    echo json_encode($post_arr['data'][$i]['postID']);
    }*/

}else{
//No posts
echo json_encode(
    array('message' => 'No posts Found')
);
}