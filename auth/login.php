<?php
header('Content-Type: application/json; Charset=UTF-8');
header("Access-Control-Allow-Origin: http://localhost:4200");
header("Access-Control-Allow-Methods: POST"); // Specify the allowed HTTP methods (e.g., POST)
header("Access-Control-Allow-Headers: Authorization, Content-Type"); // Include the Authorization header

error_log("Request received"); // Log that the request was received
ini_set('display_errors', "on");
error_reporting(E_ALL);

require '../classes/crud_actions.php';
include '../auth/classes/auth.php';
include './classes/LoginGateway.php';

$obj = new CRUD();
$loginGateway = new LoginGateway();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'status' => 0,
        'message' => 'Access Denied',
    ]);

    unset($_COOKIE['jwt_token']);

    die();
}

// $data = json_decode(file_get_contents("php://input"), true);

$username = $_POST['username'] ?? ''; 
$email = $_POST['email'] ?? '';
$password = $_POST['password']; 

if (!$loginGateway->userExists($email)) {
    http_response_code(200);
    echo json_encode([
        'status' => 0,
        'message' => 'User does not Exists!'
    ]);
    die();
}

$obj->select('Users', '*', null, "Email='$email'", null, null);

$data = $obj->userExists($email, true);

// user login token time-left to expire
$exp_login_token_time = $datetime->set_expire_time(60);
$login_token_time_to_exp = $exp_login_token_time['time'];
$login_token_time_tostr = $exp_login_token_time['time_to_str'];

# Only when debugging: echo $login_token_time_tostr;

$id = $data['UserID'] ?? '';
$username = $data['Username'] ?? '';
$email = $data['Email'] ?? '';
$Phone = $data['Phone'] ?? '';
$user_password = $data['Password'] ?? '';

if (!password_verify($password, $user_password)) {
    echo json_encode([
        'status' => 0,
        'message' => 'Invalid Credentials',
    ]);
    exit();
}

$payload = [
    'iss' => 'localhost',
    'aud' => 'localhost',
    'exp' => $login_token_time_to_exp, // 30min
    'data' => [
        'id' => $id,
        'username' => $username,
        'email' => $email,
    ]
];


$json_web_token = $auth->jwt_encode($payload, 'HS256');

$cookie_params = [
    'expires' => $login_token_time_to_exp,
    'path' => '/',
    'secure' => true,
    // 'httponly' => true,
    'samesite' => 'Strict'
];

echo json_encode([
    'status' => 1,
    'user' => [
        'id'=>$id,
        'username' => $username
    ],
    'jwt' => $json_web_token, // only if you want to manipulate token in front_end 
    'message' => 'Login Successfully!',
]);

if (isset($_COOKIE['jwt_token']) && !empty($_COOKIE['jwt_token'])) exit();

setcookie('jwt_token', $json_web_token, $cookie_params);

