<?php
 /*
// get database connection
include_once '../config/database.php';
 
// instantiate user object
include_once '../objects/user.php';
 
$database = new Database();
$db = $database->getConnection();
 
$user = new User($db);
 
// set user property values
$user->username = $_POST['username'];
$user->password = base64_encode($_POST['password']);
$user->created = date('Y-m-d H:i:s');
 
// create the user
if($user->signup()){
    $user_arr=array(
        "status" => true,
        "message" => "Successfully Signup!",
        "id" => $user->id,
        "username" => $user->username
    );
}
else{
    $user_arr=array(
        "status" => false,
        "message" => "Username already exists!"
    );
}
print_r(json_encode($user_arr));
?>*/





/*
// Include necessary files and initialize database connection
include_once '../config/database.php';
include_once '../objects/user.php';
 
$database = new Database();
$db = $database->getConnection();
 
$user = new User($db);
 
// Set user property values
$user->username = $_POST['username'];
$user->password = base64_encode($_POST['password']);
$user->created = date('Y-m-d H:i:s');
 
// Create the user
if ($user->signup()) {
    // If signup is successful, redirect to the reservation page
    header("Location: ../../../index.php");

    exit; // Ensure no further code execution after redirection
} else {
    // If signup fails, return JSON response
    $user_arr = array(
        "status" => false,
        "message" => "Username already exists!"
    );
    print_r(json_encode($user_arr));
}
?>*/

// Include necessary files and initialize database connection
include_once '../config/database.php';
include_once '../objects/user.php';

$database = new Database();
$db = $database->getConnection();

// Create a new User object
$user = new User($db);

// Set user property values
$user->username = $_POST['username'];

// Set the password as plain text
$user->password = $_POST['password'];

// Set the created date
$user->created = date('Y-m-d H:i:s');

// Create the user
if ($user->signup()) {
    // If signup is successful, redirect to the reservation page
    header("Location: ../../../index.php");
    exit; // Ensure no further code execution after redirection
} else {
    // If signup fails, return JSON response
    $user_arr = array(
        "status" => false,
        "message" => "Username already exists!"
    );
    print_r(json_encode($user_arr));
}
?>
