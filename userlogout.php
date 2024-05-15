<?php 
	
	session_start();
	
	session_destroy();
	
	header("location: Login Signup/api/index.php");
	
?>