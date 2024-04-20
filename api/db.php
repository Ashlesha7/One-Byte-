<?php 
	
	// Establishing a connection to the database
	$db = new mysqli("localhost", "root", "", "onebyte");
	
	// Checking for connection errors
	if($db->connect_errno) {
		// If there's a connection error, display a message to the user
		echo " Connection Error";
	}
	
?>
