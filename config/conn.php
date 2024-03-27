<?php

	$conn = mysqli_connect("localhost","root","admin#123","onlineShopping");

	if(!$conn){

		die("Error in connection: %s\n".mysqli_connect_error($conn));
		
	}
?>	

