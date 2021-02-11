<?php
	include("scripts/db_connect.php");
	
	$collectionUser;
	//check if user is viewing another person's collection, if so, display that user's collection
	if(isset($_POST['userid'])) {
		$collectionUser = $_POST['userid'];
	} else {
		$collectionUser = $_COOKIE["user"];
	}
	
	//get/display collection count
	$title_count = "SELECT COUNT(*) FROM film WHERE film_user = ".$collectionUser.";";
	if($count_result = mysqli_query($con, $title_count)) {
		$count = mysqli_fetch_array($count_result)[0];
	} else {
		echo("Count could not be performed");
		echo mysqli_error($con);
		echo("<br>".$title_count);
	}
	
	echo("<h2>Collection (".$count." titles)</h2><br>");
	
	//display shelf options

	//get/display posters
	$poster_select = "SELECT idfilm, poster_path, title, release_year, film_format FROM film WHERE film_user = ".$collectionUser.";";
	if($poster_result = mysqli_query($con, $poster_select)) {
		if(mysqli_num_rows($poster_result) > 0){
			echo("<table class='collectionTable'><tr>");
			$poster_count = 0;
			while($poster = mysqli_fetch_array($poster_result)) {
				//get format name
				$format_select = "SELECT name FROM format WHERE idformat = ".$poster["film_format"].";";
				if($format_result = mysqli_query($con, $format_select)) {
					$format = mysqli_fetch_array($format_result)[0];
				} else {
					echo("Format could not be retrieved");
					echo mysqli_error($con);
				}
				
				if($poster_count % 6 == 0) echo("</tr><tr>"); //every six films, create new row

				echo("<td class='collectionTableColumn'>");
				echo("<div class='collectionPosterContainer'>");
				echo("<img class='collectionPoster' src='".$poster["poster_path"]."'>");
				echo("<div class='collectionTitle'><div class='posterText'>"
					 .$poster["title"]."<br>(".$poster["release_year"].")<br><br>".$format."<br><br><br>");
					 
				//place remove button if viewing personal collection
				if(!(isset($_POST['userid']))) {
					echo("</div><div class='removeButton'><form action='scripts/remove_film.php' method='post'>"
						. "<input type='hidden' name='filmId' value='".$poster["idfilm"]."'>"
						. "<input id='remove' type='submit' value='Remove'></form></div></div></div>");
				} else {
					echo("</div></div></div>");
				}
			
				echo("</td>");
				$poster_count += 1;
			}
			
			echo("</tr></table><br><br><br>");
			
		}
		
		
		
	} else {
		echo("Posters could not be retrieved");
		echo mysqli_error($con);
		echo("<br>".$poster_select);
	}


	include("scripts/db_close.php");
?>