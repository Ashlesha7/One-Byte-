<?php /*
session_start();
require "admin/includes/functions.php";
require "admin/includes/db.php";
$msg = "";

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $guest = preg_replace("#[^0-9]#", "", $_POST['guest']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $phone = preg_replace("#[^0-9]#", "", $_POST['phone']);
    $date_res = htmlentities($_POST['date_res'], ENT_QUOTES, 'UTF-8');
    $time = htmlentities($_POST['time'], ENT_QUOTES, 'UTF-8');
    $suggestions = htmlentities($_POST['suggestions'], ENT_QUOTES, 'UTF-8');
    $table_id = isset($_POST['selected_table']) ? intval($_POST['selected_table']) : 0;

    if($guest && $email && $phone && $date_res && $time && $suggestions && $table_id) {
		$query = $db->prepare("SELECT * FROM reservation WHERE table_id = ? AND date_res = ? AND time = ?");
        $query->bind_param("iss", $table_id, $date_res, $time);
        $query->execute();
        $result = $query->get_result();

        if($result->num_rows > 0) {
            $msg = "<p style='padding: 15px; color: red; background: #ffeeee; font-weight: bold; font-size: 13px; border-radius: 4px; text-align: center;'>This table is not available for the chosen time and date.</p>";
        } else {
            $stmt = $db->prepare("INSERT INTO reservation (no_of_guest, email, phone, date_res, time, suggestions, table_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("isssssi", $guest, $email, $phone, $date_res, $time, $suggestions, $table_id);

            if($stmt->execute()) {
                $ins_id = $db->insert_id;
                $reserve_code = "UNIQUE_$ins_id".substr($phone, 3, 8);
                $msg = "<p style='padding: 15px; color: green; background: #eeffee; font-weight: bold; font-size: 13px; border-radius: 4px; text-align: center;'>Reservation placed successfully. Your reservation code is $reserve_code. Please Note that reservation expires after one hour</p>";
            } else {
                $msg = "<p style='padding: 15px; color: red; background: #ffeeee; font-weight: bold; font-size: 13px; border-radius: 4px; text-align: center;'>Could not place reservation. Please try again</p>";
            }
            $stmt->close();
        }
        $query->close();
    } else {
        $msg = "<p style='padding: 15px; color: red; background: #ffeeee; font-weight: bold; font-size: 13px; border-radius: 4px; text-align: center;'>Incomplete form data or Invalid data type</p>";
    }
}
?>*/

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require "admin/includes/db.php";


$msg = "";


// Check user authentication

$user_id = $_SESSION['user_id'];


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $guest = preg_replace("#[^0-9]#", "", $_POST['guest']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $phone = preg_replace("#[^0-9]#", "", $_POST['phone']);
    $date_res = htmlentities($_POST['date_res'], ENT_QUOTES, 'UTF-8');
    $time = htmlentities($_POST['time'], ENT_QUOTES, 'UTF-8');
    $suggestions = htmlentities($_POST['suggestions'], ENT_QUOTES, 'UTF-8');
    $table_id = isset($_POST['selected_table']) ? intval($_POST['selected_table']) : 0;

    if ($guest && $email && $phone && $date_res && $time && $suggestions && $table_id) {
        // Check if the table is available for the chosen date, time, and within the last 2 minutes
        $interval = 120; // 120 seconds = 2 minutes
        $currentDateTime = date('Y-m-d H:i:s');
         $query = $db->prepare("SELECT COUNT(*) FROM reservation WHERE table_id = ? AND date_res = ? AND time = ? AND TIMESTAMP(CONCAT(date_res, ' ', time)) >= TIMESTAMP(?, '-$interval seconds')");
        $query->bind_param("isss", $table_id, $date_res, $time, $currentDateTime);


        $query->execute();
        $query->bind_result($reservation_count);
        $query->fetch();
        $query->close();

        if ($reservation_count > 0) {
            // Table is not available for the chosen time and date or has been reserved in the last 2 minutes
            $msg = "<p style='padding: 15px; color: red; background: #ffeeee; font-weight: bold; font-size: 13px; border-radius: 4px; text-align: center;'>This table is not available for the chosen time and date.</p>";
        } else {
            // Table is available, proceed with the reservation
            $stmt = $db->prepare(
                "INSERT INTO reservation (no_of_guest, email, phone, date_res, time, suggestions, table_id, user_id
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("isssssii", $guest, $email, $phone, $date_res, $time, $suggestions, $table_id, $user_id);

            if ($stmt->execute()) {
                $ins_id = $db->insert_id;
                $reserve_code = "UNIQUE_$ins_id" . substr($phone, 3, 8);
                $msg = "<p style='padding: 15px; color: green; background: #eeffee; font-weight: bold; font-size: 13px; border-radius: 4px; text-align: center;'>Reservation placed successfully. Your reservation code is $reserve_code. Please Note that reservation expires after one hour</p>";
            } else {
                $msg = "<p style='padding: 15px; color: red; background: #ffeeee; font-weight: bold; font-size: 13px; border-radius: 4px; text-align: center;'>Could not place reservation. Please try again</p>";
            }
            $stmt->close();
        }
    } else {
        $msg = "<p style='padding: 15px; color: red; background: #ffeeee; font-weight: bold; font-size: 13px; border-radius: 4px; text-align: center;'>Incomplete form data or Invalid data type</p>";
    }
}
?>
<!Doctype html>

<html lang="en">

<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<meta name="description" content="" />

<meta name="keywords" content="" />

<head>
    
<title>One Byte</title>

<link rel="stylesheet" href="css/main.css" />

<script src="js/jquery.min.js" ></script>

<script src="js/myscript.js"></script>

<script>
    function remove_class() {
        // Remove any class or perform any action you intend
        // For example:
        // document.getElementById('someElement').classList.remove('someClass');
    }
</script>
    
</head>

<body>
    
<?php require "includes/header.php"; ?>


<div class="parallax" onclick="remove_class()">
    
    <div class="parallax_head">
        
        <h2>Reserve</h2>
        <h3>Table Space</h3>
        
    </div>
    
</div>

<div class="content" onclick="remove_class()">
    
    <div class="inner_content">
        
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="hr_book_form">
            
            <h2 class="form_head"><span class="book_icon">BOOK A TABLE</span></h2>
            <p class="form_slg">We offer you the best reservation services</p>
            
            <?php echo "<br/>".$msg; ?>
            <div class="form_group">
                    <label>Select a Table (click to select)</label>
                    <div id="table_grid" class="table_grid">
                        <!-- Example table layout -->
                        <div class="table" data-table-id="1">Table 1</div>
                        <div class="table" data-table-id="2">Table 2</div>
                        <!-- Additional tables should be added here -->
                    </div>
                    <input type="hidden" name="selected_table" id="selected_table" value="">
                </div>
            
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

<div class="content" onclick="remove_class()">
    
    <div class="inner_content">
    
        <div class="contact">
            
            <div class="left">
                
                <h3>LOCATION</h3>
                <p>Naxal,  Kathmandu</p>
                
                
            </div>
            
            <div class="left">
                
                <h3>CONTACT</h3>
                <p>08054645432, 07086898709</p>
                <p>Website@gmail.com</p>
                
            </div>
            
            <p class="left"></p>
            
            <div class="icon_holder">
                
                <a href="#"><img src="image/icons/Facebook.png" alt="image/icons/Facebook.png" /></a>
                <a href="#"><img src="image/icons/Google+.png" alt="image/icons/Google+.png"  /></a>
                <a href="#"><img src="image/icons/Twitter.png" alt="image/icons/Twitter.png"  /></a>
                
            </div>
            
        </div>
        
    </div>
    
</div>

<div class="footer_parallax" onclick="remove_class()">
    
    <div class="on_footer_parallax">  
        <p>&copy; <?php echo strftime("%Y", time()); ?> <span>MyRestaurant</span>. All Rights Reserved</p>
    </div>   
</div>
<script>
$(document).ready(function() {
    // Event listener for table selection
    $('.table').click(function() {
        // Get the table ID from the data attribute
        var tableId = $(this).data('table-id');
        // Update the hidden input field with the selected table ID
        $('#selected_table').val(tableId);
        console.log('Table clicked. ID:', tableId); // Add this line for debugging
    });
});
</script>  
</body>
</html>