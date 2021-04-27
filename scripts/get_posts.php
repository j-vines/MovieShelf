<?php
	/*  MovieShelf
		Jack Vines
		2020 - 2021
	*/

	/* Retrieve posts (new acquisitions/reviews) from database (within last 10 days) from users that signed in user follows */

	include("db_connect.php");

	$post_array = [];

	/* Retrieve most recent updates from followed users */
	$select = "SELECT * FROM film WHERE film_user IN (SELECT followed_user
				FROM following 
    			WHERE following_user = ".$_COOKIE["user"].")
				AND DATE(acquired) > DATE_SUB(CURDATE(), INTERVAL 10 DAY);";
	if(!($result = mysqli_query($con, $select))) {
		echo("Film acquisitions could not be retrieved.");
		echo mysqli_error($con);
	}
	
	$index = 0;
	
	//add film acquisitions to post array
	while($post = mysqli_fetch_array($result)) {
		
		$post_object = new stdClass();
		$post_object->type = "acquisition";
		$post_object->name = get_user_name($con, $post["film_user"]);
		$post_object->filmName = $post["title"];
		$post_object->filmReleaseYear = $post["release_year"];
		$post_object->dateAcquired = $post["acquired"];
		$post_object->posterPath = $post["poster_path"];
		$post_object->timeShared = $post["time_shared"];
		$post_object->userid = $post["film_user"];
		$post_object->format = get_format_name($con, $post["film_format"]);
		
		$post_array[$index] = json_encode($post_object);
		
		$index++;
	}

	/* Retrieve most recent reviews from followed users */
	$select = "SELECT * FROM review
				WHERE review_film IN (
					SELECT idfilm FROM film
        			WHERE film_user IN (
						SELECT followed_user
						FROM following 
						WHERE following_user = ".$_COOKIE["user"]."
        			)
    			)
    			AND DATE(posted_date) > DATE_SUB(CURDATE(), INTERVAL 10 DAY);";
	if(!($result = mysqli_query($con, $select))) {
		echo("Film reviews could not be retrieved.");
		echo mysqli_error($con);
	}
	

	while($post = mysqli_fetch_array($result)) {
		
		//get info about movie review is about
		$film_select = "SELECT * FROM film WHERE idfilm = ".$post["review_film"].";";
		if($film_result = mysqli_query($con, $film_select)) {
			$film_info = mysqli_fetch_array($film_result);
		} else {
			echo("Film info could not be retrieved.");
			echo mysqli_error($con);
		}
		
		$post_object = new stdClass();
		$post_object->type = "review";
		$post_object->name = get_user_name($con, $film_info["film_user"]);
		$post_object->filmName = $film_info["title"];
		$post_object->filmReleaseYear = $film_info["release_year"];
		$post_object->reviewText = $post["review_text"];
		$post_object->posterPath = $film_info["poster_path"];
		$post_object->timeShared = $post["time_shared"];
		$post_object->userid = $film_info["film_user"];
		$post_object->format = get_format_name($con, $film_info["film_format"]);
		
		$post_array[$index] = json_encode($post_object);
		
		$index++;
	}

	echo(json_encode($post_array)); //output array of post objects

	include("db_close.php");

	
	//get the display name of a user to be displayed along with a post
	function get_user_name($con, $id) {
		$select = "SELECT display_name FROM user WHERE iduser = ".$id.";";
		if($result = mysqli_query($con, $select)) {
			return mysqli_fetch_array($result)[0];
			
		} else {
			echo("Film acquisitions could not be retrieved.");
			echo mysqli_error($con);
		}
	}
	
	//get the name of a format
	function get_format_name($con, $format_id) {
		$select = "SELECT name FROM format WHERE idformat = ".$format_id.";";
		if($result = mysqli_query($con, $select)) {
			return mysqli_fetch_array($result)[0];
			
		} else {
			echo("Format name could not be retrieved.");
			echo mysqli_error($con);
		}
	}
?>