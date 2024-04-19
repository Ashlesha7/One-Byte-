<?php 
    // Start session to use session variables
    session_start();

    // Include database connection and functions files
    require "includes/db.php";
    require "includes/functions.php";

    // Redirect to food_list.php if user is already logged in
    if(isset($_SESSION['user'])) {
        header("location: food_list.php");
    }

    // Check if the form is submitted via POST
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        // Check if the submit button is pressed
        if(isset($_POST['submit'])) {
            
            // Sanitize and store the username to prevent SQL injection
            $user = escape($_POST['username']);
            // Store password directly (note: consider using password hashing for better security)
            $pass = $_POST['password'];

            // Check if username and password are not empty
            if($user != "" && $pass != "") {
                
                // SQL query to verify login credentials from the 'admin' table
                $verify = $db->query("SELECT * FROM admin WHERE username='$user' AND password='$pass' LIMIT 1");
                
                // Check if the credentials are correct and fetch the user details
                if($verify->num_rows) {
                    
                    $row = $verify->fetch_assoc();
                    
                    // Set the user session and redirect to food_list.php
                    $_SESSION['user'] = $row['username'];
                    header("location: food_list.php");
                    
                } else {
                    
                    // Alert message for invalid login credentials
                    echo "<script>alert('Invalid login credentials. Please try again')</script>";
                    
                }
                
            } else {
                
                // Alert message for empty fields
                echo "<script>alert('Some fields are empty. All fields required!')</script>";
                
            }
            
        }
        
    }
    
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="assets/img/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>One Byte</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <!-- Bootstrap core CSS     -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Light Bootstrap Table core CSS    -->
    <link href="assets/css/light-bootstrap-dashboard.css" rel="stylesheet"/>

    <!--     Fonts and icons     -->
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
</head>
<body>

<div class="login_wrapper">
    
    <div class="login_holder">
            
        <form method="post" action="index.php">
            
            <div class="header">
                <h4 style="border-bottom: 1px solid #FF5722;" class="title">Login Form</h4>
            </div>
            
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" placeholder="Enter Username" autofocus>
            </div>
            
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter your password">
            </div>
            
            <input type="submit" name="submit" value="Login" class="btn btn-info btn-fill pull-right" style="background: #FF5722; border-color: #FF5722;" />
            <div class="clearfix"></div>
            
        </form>
        
    </div>
    
</div>

</body>
</html>
