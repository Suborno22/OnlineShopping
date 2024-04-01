<?php

	$conn = mysqli_connect("localhost","root","password");

	if(!$conn){

		die("Error in connection: %s\n".mysqli_connect_error($conn));
		
	}

	$db_selected = mysqli_select_db($conn, "OnlineShopping");

	if(!$db_selected){
		die('Cannot use this db: '.mysqli_error($conn));
	}

?>	

