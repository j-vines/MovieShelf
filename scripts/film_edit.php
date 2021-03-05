<?php
	/* Functions for adding films, removing films, and editing information about specific films in the database */
	include("db_connect.php");
	
	if(isset($_POST["rating"])) {
		edit_rating($_POST["rating"], $con);
	}
	
	/* Modify the rating of a film in the database */
	function edit_rating($rating, $con) {
		$rating_update = "UPDATE film SET rating = ".$_POST["rating"]." WHERE idfilm = ".$_POST["ratingId"].";";
		if($update_result = mysqli_query($con, $rating_update)) {
			
		} else {
			echo("Rating could not be updated.");
			echo mysqli_error($con);
			echo($rating_update);
		}
	 }  
	 
	include("db_close.php");
	header("Location: ../profile.php");
?>