<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Service.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate post object
$service = new Service($db);

//Get serviceID from URL
$service->serviceID = isset($_GET['serviceID']) ? $_GET['serviceID'] : die();

//Get post
$service->read_single_service();

//Create array
$service_arr = array(
    'serviceID' => $service->serviceID,
    'serviceTitle' => $service->serviceTitle,
    'serviceDate' => $service->serviceDate,
    'serviceType' => $service->serviceType,
    'publish' => $service->publish,
);

//Make JSON
print_r(json_encode($service_arr));

?>