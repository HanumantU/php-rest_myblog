<?php 

//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization,X-Requested-With');

include_once('../../config/Database.php');
include_once('../../models/Category.php');

//instantiate db & connect
$database = new Database();
$db = $database->connect();

//instatiate blog category object
$category = new Category($db);

//getting posted data
$data = json_decode(file_get_contents("php://input"));

$category->name = $data->name;

//creating post
if($category->create()) {
    echo json_encode(
        array('message' => 'Post Created')
    );
}else{
    echo json_encode(
        array('message' => 'Post Not Created')
    );
}
