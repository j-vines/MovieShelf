<?php
	include "scripts/db_connect.php";
	$film_search = "SELECT idfilm, title, `release` FROM film WHERE title LIKE '% ".$_GET["search"]."' OR title LIKE '".$_GET["search"]." %' OR title LIKE '".$_GET["search"]."%';";
	if($film_search_result = mysqli_query($con, $film_search)) {
		//search was successful
	} else {
		echo("No result.");
		echo mysqli_error($con);
	}
	include "scripts/db_close.php";
?>