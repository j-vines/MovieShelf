<?php
	include("db_connect.php");
	
	$rating_update = "UPDATE film SET rating = ".$_POST["rating"]." WHERE idfilm = ".$_POST["ratingId"].";";
	if($update_result = mysqli_query($con, $rating_update)) {
			
	} else {
		echo("Rating could not be updated.");
		echo mysqli_error($con);
		echo($rating_update);
	}
	

	include("db_close.php");

?>