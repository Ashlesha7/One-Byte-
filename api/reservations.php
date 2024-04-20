<?php 
	// Start the session to manage user authentication
	session_start();
	// Include necessary functions and database connection file
	require "includes/functions.php";
	require "includes/db.php";
	// Redirect user to logout page if not logged in
	if(!isset($_SESSION['user'])) {
        header("location: logout.php");
    }
	
	// Initialize variables
	$result = "";
	$pagenum = "";
	$per_page = 20;
	
	// Count total rows in the reservation table for pagination
	$count = $db->query("SELECT * FROM reservation");
	
	// Calculate total number of pages needed for pagination
	$pages = ceil((mysqli_num_rows($count)) / $per_page);
	
	// Determine current page number
	if(isset($_GET['page'])) {
		$page = $_GET['page'];
	}else{
		$page = 1;
	}
					
	// Calculate the starting point for the records to be fetched based on pagination
	$start = ($page - 1) * $per_page;
	
	// Fetch reservation records based on pagination limits
	$reserve = $db->query("SELECT * FROM reservation LIMIT $start, $per_page");
	
	// Generate HTML table to display reservation records or message if no records found
	if($reserve->num_rows) {
		$result = "<table class='table table-hover'>
					<thead>
						<th>S/N</th>
						<th>No of Guests</th>
						<th>Email</th>
						<th>Phone</th>
						<th>Date</th>
						<th>Time</th>
						<th>Suggestions</th>
						<th>Action</th>
					</thead>
					<tbody>";
		
		$x = 1;
		
		while($row = $reserve->fetch_assoc()) {
			// Fetch reservation details
			$reserve_id = $row['reserve_id'];
			$no_of_guest = $row['no_of_guest'];
			$email = $row['email'];
			$phone = $row['phone'];
			$date_res = $row['date_res'];
			$time = $row['time'];
			$suggestions = $row['suggestions'];
			
			// Add reservation details to table rows
			$result .=  "<tr>
							<td>$x</td>
							<td>$no_of_guest</td>
							<td>$email</td>
							<td>$phone</td>
							<td>$date_res</td>
							<td>$time</td>
							<td>$suggestions</td>
							<td><a href='reservations.php?delete=".$reserve_id."' onclick='return check();'><i class='pe-7s-close-circle'></i></a></td>
						</tr>";
			$x++;
		}
		
		$result .= "</tbody>
					</table>";
		
	}else{
		// Display message if no reservation records found
		$result = "<p style='color:red; padding: 10px; background: #ffeeee;'>No Table reservations available yet</p>";
	}
	
	// Handle deletion of reservation record
	if(isset($_GET['delete'])) {
		$delete = preg_replace("#[^0-9]#", "", $_GET['delete']);
		if($delete != "") {
			$sql = $db->query("DELETE FROM reservation WHERE reserve_id='".$delete."'");
			// Display success or failure message after deletion
			if($sql) {
				echo "<script>alert('Successfully deleted')</script>";
			}else{
				echo "<script>alert('Operation Unsuccessful. Please try again')</script>";
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
	<title>Unique Restaurant</title>
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
	<script>
		// JavaScript function to confirm deletion
		function check() {
			return confirm("Are you sure you want to delete this record");
		}
	</script>
</head>
<body>
<div class="wrapper">
    <div class="sidebar" data-color="#000" data-image="assets/img/sidebar-5.jpg">
    	<?php require "includes/side_wrapper.php"; ?>
    <div class="main-panel">
        <nav class="navbar navbar-default navbar-fixed" style="background: #FF5722;">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar" style="background: #fff;"></span>
                        <span class="icon-bar" style="background: #fff;"></span>
                        <span class="icon-bar" style="background: #fff;"></span>
                    </button>
                    <a class="navbar-brand" href="#" style="color: #fff;">TABLE RESERVATIONS</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="logout.php" style="color: #fff;">
                                Log out
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Reservation List</h4>
                            </div>
                            <div class="content table-responsive table-full-width">
								<!-- Display reservation records or message -->
								<?php echo $result; ?>
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="container-fluid">
                <p class="copyright pull-right">
                    &copy; 2016 <a href="index.php" style="color: #FF5722;">Unique Restaurant</a>
                </p>
            </div>
        </footer>
    </div>
</div>
<!--   Core JS Files   -->
<script src="assets/js/jquery-1.10.2.js" type="text/javascript"></script>
<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
<!--  Checkbox, Radio & Switch Plugins -->
<script src="assets/js/bootstrap-checkbox-radio-switch.js"></script>
<!--  Charts Plugin -->
<script src="assets/js/chartist.min.js"></script>
<!--  Notifications Plugin    -->
<script src="assets/js/bootstrap-notify.js"></script>
</body>
</html>

