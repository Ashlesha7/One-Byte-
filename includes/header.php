<?php 

// notifications.php
require "admin/includes/functions.php";
require "admin/includes/db.php";

// error_reporting(E_ALL);
// 	ini_set('display_errors', 1);
	

	// require "admin/includes/db.php";

// Check user authentication


if (!isset($_SESSION['user_id'])) {
	header("Location: Login Signup/api/index.php");
    exit;
}
$user_id = $_SESSION['user_id'];
$status = "pending";
// Fetch notifications from the database
$query = $db->prepare("SELECT * FROM reservation WHERE user_id = ? AND status != ? ORDER BY date_res DESC LIMIT 5");
$query->bind_param("is", $user_id, $status);
$query->execute();
$result = $query->get_result();
$notifications = [];

while ($row = $result->fetch_assoc()) {
    $notifications[] = [
        'id' => $row['reserve_id'],
        'message' => $row['message'],
		'date_res' => $row['date_res'],
        'status' => $row['status'],
		"user_id" => $row['user_id'],
    ];
}

?>


<header>
	
	<div class="nav_toggle" onclick="toggle_class();">
		
		<span class="toggle_icon"></span>
		
	</div>
	
	<div onclick="remove_class()">
	
	<div class="main_nav">
		
		<h2>One Byte</h2>
		
		<ul class="default_links">
			
			<li><a href="index.php">Home</a></li>
			<li><a href="menu.php">Menu</a></li>
			<li><a href="reservation.php">Reservation</a></li>
			<li><a href="gallery.php">Gallery</a></li>
			<li><a href="basket.php">Order</a></li>
			<ul class="notification-drop">
    <li class="item">
      <i class="fa fa-bell-o notification-bell" aria-hidden="true"></i> <span class="btn__badge pulse-button "><?php echo  count($notifications); ?> </span>     
      <ul>
	  <?php foreach ($notifications as $notification): ?>
    <li><a href='notifications.php?id=<?php echo $notification['id']; ?>'><?php echo $notification['message']; ?></a></li>
<?php endforeach; ?>
      </ul>
    </li>
  </ul>

			
		</ul>
		
		<p class="clear"></p>
		
	</div>
	
	<p class="clear"></p>
	
	</div>
	
</header>

<div class="responive_nav">
	
	<div class="nav_section_img">
		
		<div class="nav_section_div">
			
			<h3>One Byte</h3>
			
		</div>
		
	</div>
	
	<div class="nav_section">
		
		<ul>
			
			<li><a href="index.php"><span class="home">Home</span></a></li>
			<li><a href="menu.php"><span class="menu">Menu</span></a></li>
			<li><a href="reservation.php"><span class="reserve">Book Table</span></a></li>
			<li><a href="gallery.php"><span class="gallery">Gallery</span></a></li>
			<li><a href="basket.php"><span class="order">Order</span></a></li>
			<li><a href="notifications.php"><span class="order">Notification</span></a></li>
			
			
		</ul>
		
	</div>
	
</div>

<script>
	$(document).ready(function() {
  $(".notification-drop .item").on('click',function() {
    $(this).find('ul').toggle();
  });
});
</script>