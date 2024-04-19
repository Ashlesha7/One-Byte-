<?php 
    // Start a new session or resume the existing one
    session_start();
    
    // Include external PHP files for functions and database connection
    require "admin/includes/functions.php";
    require "admin/includes/db.php";
    
    // Variable to store messages to be displayed to the user
    $msg = "";
    
    // Check if the form was submitted using the POST method
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        // Check if the 'submit' button was clicked
        if(isset($_POST['submit'])) {
            
            // Sanitize and validate input data
            $guest = preg_replace("#[^0-9]#", "", $_POST['guest']); // Only allow digits
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL); // Validate email
            $phone = preg_replace("#[^0-9]#", "", $_POST['phone']); // Only allow digits
            $date_res = htmlentities($_POST['date_res'], ENT_QUOTES, 'UTF-8'); // Convert characters to HTML entities
            $time = htmlentities($_POST['time'], ENT_QUOTES, 'UTF-8'); // Convert characters to HTML entities
            $suggestions = htmlentities($_POST['suggestions'], ENT_QUOTES, 'UTF-8'); // Convert characters to HTML entities
            
            // Check if all fields are filled
            if($guest != "" && $email && $phone != "" && $date_res != "" && $time != "" && $suggestions != "") {
                
                // Check if a reservation already exists with the same details
                $check = $db->query("SELECT * FROM reservation WHERE no_of_guest='".$guest."' AND email='".$email."' AND phone='".$phone."' AND date_res='".$date_res."' AND time='".$time."' LIMIT 1");
                
                if($check->num_rows) {
                    
                    // Display error message if a duplicate reservation is found
                    $msg = "<p style='padding: 15px; color: red; background: #ffeeee; font-weight: bold; font-size: 13px; border-radius: 4px; text-align: center;'>You have already placed a reservation with the same information</p>";
                    
                }else{
                    
                    // Insert the new reservation into the database
                    $insert = $db->query("INSERT INTO reservation(no_of_guest, email, phone, date_res, time, suggestions) VALUES('".$guest."', '".$email."', '".$phone."', '".$date_res."', '".$time."', '".$suggestions."')");
                    
                    if($insert) {
                        
                        // Successful insertion message with a unique reservation code
                        $ins_id = $db->insert_id;
                        $reserve_code = "UNIQUE_$ins_id".substr($phone, 3, 8);
                        $msg = "<p style='padding: 15px; color: green; background: #eeffee; font-weight: bold; font-size: 13px; border-radius: 4px; text-align: center;'>Reservation placed successfully. Your reservation code is $reserve_code. Please Note that reservation expires after one hour</p>";
                        
                    }else{
                        
                        // Error message if the insertion fails
                        $msg = "<p style='padding: 15px; color: red; background: #ffeeee; font-weight: bold; font-size: 13px; border-radius: 4px; text-align: center;'>Could not place reservation. Please try again</p>";
                        
                    }
                    
                }
                
            }else{
                
                // Error message for incomplete or invalid form data
                $msg = "<p style='padding: 15px; color: red; background: #ffeeee; font-weight: bold; font-size: 13px; border-radius: 4px; text-align: center;'>Incomplete form data or Invalid data type</p>";
                
                // Output the contents of the POST array for debugging
                print_r($_POST);
                
            }
            
        }
        
    }
    
?>

<!Doctype html>

<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <title>One Byte</title>
    <link rel="stylesheet" href="css/main.css" />
    <script src="js/jquery.min.js" ></script>
    <script src="js/myscript.js"></script>
</head>

<body>
    <!-- Include header from external file -->
    <?php require "includes/header.php"; ?>

    <!-- Parallax section -->
    <div class="parallax" onclick="remove_class()">
        <div class="parallax_head">
            <h2>Reserve</h2>
            <h3>Table Space</h3>
        </div>
    </div>

    <!-- Main content section -->
    <div class="content" onclick="remove_class()">
        <div class="inner_content">
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="hr_book_form">
                <h2 class="form_head"><span class="book_icon">BOOK A TABLE</span></h2>
                <p class="form_slg">We offer you the best reservation services</p>
                
                <!-- Display the message to the user -->
                <?php echo "<br/>".$msg; ?>
                
                <!-- Form for guest information -->
                <div class="left">
                    <div class="form_group">
                        <label>No of Guest</label>
                        <input type="number" placeholder="How many guests" min="1" name="guest" id="guest" required>
                    </div>
                    
                    <div class="form_group">
                        <label>Email</label>
                        <input type="email" name="email" placeholder="Enter your email" required>
                    </div>
                    
                    <div class="form_group">
                        <label>Phone Number</label>
                        <input type="text" name="phone" placeholder="Enter your phone number" required>
                    </div>
                    
                    <div class="form_group">
                        <label>Date</label>
                        <input type="date" name="date_res" placeholder="Select date for booking" required>
                    </div>
                    
                    <div class="form_group">
                        <label>Time</label>
                        <input type="time" name="time" placeholder="Select time for booking" required>
                    </div>
                </div>
                
                <!-- Form for additional suggestions -->
                <div class="left">
                    <div class="form_group">
                        <label>Suggestions <small><b>(E.g No of Plates, How you want the setup to be)</b></small></label>
                        <textarea name="suggestions" placeholder="your suggestions" required></textarea>
                    </div>
                    
                    <div class="form_group">
                        <input type="submit" class="submit" name="submit" value="MAKE YOUR BOOKING" />
                    </div>
                </div>
                
                <p class="clear"></p>
            </form>
        </div>
    </div>

    <!-- Additional contact information section -->
    <div class="content" onclick="remove_class()">
        <div class="inner_content">
            <div class="contact">
                <div class="left">
                    <h3>LOCATION</h3>
                    <p>Naxal, Kathmandu</p>
                </div>
                
                <div class="left">
                    <h3>CONTACT</h3>
                    <p>08054645432, 07086898709</p>
                    <p>Website@gmail.com</p>
                </div>
                
                <p class="left"></p>
                
                <div class="icon_holder">
                    <a href="#"><img src="image/icons/Facebook.png" alt="Facebook icon" /></a>
                    <a href="#"><img src="image/icons/Google+.png" alt="Google+ icon" /></a>
                    <a href="#"><img src="image/icons/Twitter.png" alt="Twitter icon" /></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer section with parallax effect -->
    <div class="footer_parallax" onclick="remove_class()">
        <div class="on_footer_parallax">
            <p>&copy; <?php echo strftime("%Y", time()); ?> <span>MyRestaurant</span>. All Rights Reserved</p>
        </div>
    </div>
</body>
</html>
