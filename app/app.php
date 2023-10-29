<?php
header('Access-Control-Allow-Origin: *');
header('Access-Conrol-Allow-Method: POST');
header('Content-Type: application/json; Charset=UTF-8');

require 'classes/ErrorHandler.php';
require '../classes/crud_actions.php';
require '../auth/classes/auth.php';
require 'classes/RequestController.php';

ini_set('display_errors', 'On');
set_exception_handler("ErrorHandler::handleException");

$parts = explode("/", $_SERVER['REQUEST_URI']);

$method = $_SERVER['REQUEST_METHOD'];
$resource = $parts[4];
$id = $parts[5] ?? null;

$validPathArray = ['settings', 'reportuser', 'notifications', 'connections'];

// check is user is authenticated
// $headers = getallheaders();
// $json_web_token = $headers['Authorization'] ?? die(json_encode(['status' => 0, 'message' => 'Authorization header is missing!']));
// $token_data = $auth->jwt_decode($json_web_token);
// if (!$token_data) {
//     http_response_code(500);
//     echo json_encode(['status' => 0, 'message' => 'Expired token!']);
//     die();
// }

if (!in_array($resource, $validPathArray)) {
    http_response_code(404);
    echo json_encode([
        'status' => 0,
        'message' => 'page not found'
    ]);
    exit;
}

$requestController = new RequestController($method, $resource, $id);
$requestController->processRequest();