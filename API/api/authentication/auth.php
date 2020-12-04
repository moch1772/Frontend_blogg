<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    
    include_once '../../config/Database.php';
    include_once '../../models/user.php';
    
    $database = new Database();
    $db = $database->connect();

    $data = json_decode(file_get_contents("php://input"));

    $user = array(
        "userID" => $data->userID,
        "firstName" => $data->firstName,
        "middleName" => $data->middleName,
        "lastName" => $data->lastName,
        "username" => $data->username,
        "password" => $data->password
    );

    $auth = new Auth($db);

    $check = $auth->auth($user);

    echo $check;
?>