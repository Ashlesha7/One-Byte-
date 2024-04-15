<?php
/*
// Include database and object files
include_once '../config/database.php';
include_once '../objects/user.php';

// Get database connection
$database = new Database();
$db = $database->getConnection();

// Prepare user object
$user = new User($db);

// Set username and password from POST data
$username = isset($_POST['username']) ? $_POST['username'] : die();
$password = isset($_POST['password']) ? $_POST['password'] : die();

// Set user properties
$user->username = $username;

// Attempt to login
if ($user->login($password)) {
    // Login successful, redirect to index.php
    header("Location:signup.php");
    exit; // Ensure no further code execution after redirection
} else {
    // Login failed, return JSON response
    $user_arr = array(
        "status" => false,
        "message" => "Invalid Username or Password!"
    );
    echo json_encode($user_arr); // Print JSON response
}
?>*/


// Include database and object files
include_once '../config/database.php';
include_once '../objects/user.php';

var_dump($_POST);
// Get database connection
$database = new Database();
$db = $database->getConnection();

// Prepare user object
$user = new User($db);

// Check if username and password are provided
if (isset($_POST['username']) && isset($_POST['password'])) {
    // Set username and password from POST data
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);


    // Set user properties
    $user->username = $username;

    // Attempt to login
    if ($user->login($password)) {
        // Login successful, redirect to index.php
        header("Location: signup.php");
        exit; // Ensure no further code execution after redirection
    } else {
        // Login failed, return JSON response
        $user_arr = array(
            "status" => false,
            "message" => "Invalid Username or Password!"
        );
        echo json_encode($user_arr); // Print JSON response
    }
} else {
    // Username or password not provided, return JSON response
    $user_arr = array(
        "status" => false,
        "message" => "Username or Password not provided!"
    );
    echo json_encode($user_arr); // Print JSON response
}

?>

