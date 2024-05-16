<?php  
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require "admin/includes/db.php";	
// Check user authentication

$user_id = $_SESSION['user_id'];

// Fetch notifications from the database
$query = $db->prepare("SELECT * FROM notifications WHERE user_id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
$notifications = [];

while ($row = $result->fetch_assoc()) {
    $notifications[] = [
        'id' => $row['notification_id'],
        'message' => $row['message']
    ];
} ?>

<!Doctype html>

<html lang="en">

<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<meta name="description" content="" />

<meta name="keywords" content="" />

<head>
	
<title>MOne Byte</title>

<link rel="stylesheet" href="css/main.css" />

<link rel="stylesheet" href="css/lightbox.min.css" />

<script src="js/jquery.min.js" ></script>

<script src="js/myscript.js"></script>
	
</head>

<body>
	
<?php require "includes/header.php"; ?>

<div class="parallax" onclick="remove_class()">
	
	<div class="parallax_head">
		
		<h2>Our</h2>
		<h3>Services</h3>
		
	</div>
	
</div>

<div class="content" onclick="remove_class()">
	
	<div class="inner_content on_parallax">
		
		<h2><span class="fresh">Services</span></h2>
		
		<div class="parallax_content">
			
			<div class="multicol">
				
				<div class="image_display">
				
					<a href="image/Spaghetti.jpg" data-lightbox="image-1"><img src="image/Spaghetti.jpg" alt="image/Spaghetti.jpg" width="100%" /></a>
					
				</div>
				
				<div class="image_display">
					
					<a href="image/dish.jpg" data-lightbox="image-2"><img src="image/dish.jpg" alt="image/dish.jpg" width="100%" /></a>
					
				</div>
				
				<div class="image_display">
					
					<a href="image/dish_4.jpg" data-lightbox="image-3"><img src="image/dish_4.jpg" alt="image/dish_4.jpg" width="100%" />
					
				</div>
				
				<div class="image_display">
					
					<a href="image/glasses.jpg" data-lightbox="image-4"><img src="image/glasses.jpg" alt="image/glasses.jpg" width="100%" /></a>
					
				</div>
				
				<div class="image_display">
					
					<a href="image/dish_5.jpg" data-lightbox="image-5"><img src="image/dish_5.jpg" alt="image/dish_5.jpg" width="100%" /></a>
					
				</div>
                    
                <div class="image_display">
					
					<a href="image/glassess.jpg" data-lightbox="image-6"><img src="image/glassess.jpg" alt="image/glassess.jpg" width="100%" /></a>
					
				</div>
                    
                <div class="image_display">
					
					<a href="image/dish_7.jpg" data-lightbox="image-7"><img src="image/dish_7.jpg" alt="image/dish_7.jpg" width="100%" /></a>
					
				</div>
				<div class="image_display">
					
					<a href="image/Burger.jpg" data-lightbox="image-8"><img src="image/Burger.jpg" alt="image/Burger.jpg" width="100%" /></a>
					
				</div>
				<div class="image_display">
					
					<a href="image/Pasta.jpg" data-lightbox="image-9"><img src="image/Pasta.jpg" alt="image/Pasta.jpg" width="100%" /></a>
					
				</div>
				<div class="image_display">
					
					<a href="image/Pasta.jpg" data-lightbox="image-9"><img src="image/Pasta.jpg" alt="image/Pasta.jpg" width="100%" /></a>
					
				</div>
				<div class="image_display">
					
					<a href="image/Vegan Carbonara.jpg" data-lightbox="image-10"><img src="image/Vegan Carbonara.jpg" alt="image/Vegan Carbonara.jpg" width="100%" /></a>
					
				</div>
				
			</div>
			
			<p class="clear"></p>
			
		</div>
		
	</div>
	
</div>

<div class="footer_parallax" onclick="remove_class()">
	
	<div class="on_footer_parallax">
		
		<p>&copy; <?php echo strftime("%Y", time()); ?> <span>MyRestaurant</span>. All Rights Reserved</p>
		
	</div>
	
</div>
	
</body>

</html>

<script src="js/lightbox.min.js" ></script>