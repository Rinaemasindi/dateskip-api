<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Method: POST');
header('Content-Type: application/json; Charset=UTF-8');

require '../classes/crud_actions.php';
require_once '../controllers/helpers/date_time.php';

$obj = new CRUD();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'status' => 0,
        'message' => 'Access Denied'
    ]);

    die();
}

// $register_data = json_decode(file_get_contents("php://input", true));

$username = htmlentities($_POST["username"]);
$email = htmlentities($_POST["email"]);
$phone = htmlentities($_POST["phone"]);
$gender = htmlentities($_POST["gender"]);
$age = htmlentities($_POST["age"]);
$location = htmlentities($_POST["location"]);
$profile_picture = htmlentities($_POST["profilePicture"]);
$bio = htmlentities($_POST["bio"]);
$password = htmlentities($_POST["password"]); // enicodex.2023
$new_password = password_hash($password, PASSWORD_DEFAULT); //htmlentities();

if (empty($username) || empty($email) || empty($password) || empty($phone)|| empty($gender) || empty($age)) {
    echo json_encode([
        'status' => 0,
        'message' => "One or more field is Empty! \n Please Fill in all Fields and Try Again!"
    ]);

    die();
}



$user_data = $obj->userExists($email, true);
$result = $obj->getResult();

if ($user_data || $result[0]['user_exists']) {
    http_response_code(500);
    echo json_encode([
        'status' => 0,
        'message' => 'User already Exists!',
    ]);

    die();
}

$obj->insert('Users', [
    'Phone' => $phone,
    'Username' => $username,
    'ProfilePicture ' => $profile_picture ,
    'Gender' => $gender,
    'Bio' => $bio,
    'Age' => $age,
    'Location' => $location,
    'Email' => $email,
    'Password' => $new_password,
    'RegistrationDate' => $datetime->format_str('Y-m-d H:i:s')
]);
$result = $obj->getResult();

if ($result[1]['insert'] !== 1) {
    http_response_code(500);
    echo json_encode([
        'status' => 0,
        'message' => 'Something went wrong, Server Problem!',
    ]);
    die();
}

if (isset($_COOKIE['jwt_token'])) {
    unset($_COOKIE['jwt_token']);
    unset($_COOKIE['user_role']);
}

http_response_code(200);
echo json_encode([
    'status' => 1,
    'message' => 'User Registered Successfully!',
]);
