<?php
	/*  MovieShelf
		Jack Vines
		2020 - 2021
	*/

	/* Establish connection with the database, included before any operations that access info in database */

	$db_name = "drawertl_jvines";

	$con = mysqli_connect("138.68.228.126", "drawertl_jvines", "gLR0kvm2BueH", $db_name);
	if (! $con) {
    	echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    	die('Could not connect: ' . mysqli_error($con));
	}
	
	
?>