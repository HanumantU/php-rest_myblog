<?php

//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../../config/Database.php');
include_once('../../models/Category.php');

//instantiate db & connect
$database = new Database();
$db = $database->connect();

//instatiate blog category object
$category = new Category($db);

//getting id from url
$category->id = isset($_GET['id']) ? $_GET['id'] : die();

$category->read_single();

$post_arr = array(
    'id' => $category->id,
    'name' => $category->name
);

//building JSON
print_r(json_encode($post_arr));
