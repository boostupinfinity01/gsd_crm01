<?php
	date_default_timezone_set("Asia/Kolkata");
    session_start();
    error_reporting(0);

	require_once('libs/class.validations.php');
    require_once('libs/string_func.php');


	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "gsd_crm";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} else{
		// echo "connection connect Successfully";
	}
	
	//$conn->close();

?>