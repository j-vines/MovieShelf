<?php
/*  MovieShelf
	Jack Vines
	2020 - 2021
*/

/* Collection compare page contains information about two user's collections as well as calculation of similarity
	of two collections 
	*/


	include("common_header.php");
	include("scripts/db_connect.php");
	//create film info modal box
	echo("<div id='filmInfo' class='modalBox'>
			<div id='filmInfoContent' class='modalBoxContent'>
			<div class='modalHeader'>
				<button id='close' onClick='closeFilmInfo()'>Close</button>
				<h2><span id='collectionCompareTitle'></span> (<span id='collectionCompareYear'></span>)</h2>
				</div>
				<img id='collectionComparePoster' src=''>
				<div id='recommendButton'></div>
			<div id='recommendForm'>
			</div>
			</div></div>");

	compare_collections($con);

	function compare_collections($con) {
		
		
		$user_id = $_COOKIE["user"];
		$other_user_id =  $_GET["compare_userid"];
		$other_user_name = $_GET["compare_username"];
		
		$stats = get_stats($con, $user_id, $other_user_id);
		
		echo("<div class='mainContent'>");
		//Your half of stats
		echo("<div class='statsDisplay'>");
		echo("<h2>Your Collection </h2>");
		echo($stats->your_count . " total films <br>");
		echo($stats->dvd_num . " DVDs <br>"
			 . $stats->bluray_num . " Blu-rays <br>"
			 . $stats->uhd_num . " 4K Blu-rays </div>");
		
		//Their half of stats
		echo("<div class='statsDisplay'>");
		echo("<h2>" . $other_user_name . "'s Collection </h2>");
		echo($stats->other_count . " total films <br>");
		echo($stats->other_dvd_num . " DVDs <br>"
			 . $stats->other_bluray_num . " Blu-rays <br>"
			 . $stats->other_uhd_num . " 4K Blu-rays </div>");
		
		//shared stats
		echo("<div class='statsSection'><h2>");
		if ($stats->share_count == 1) {
			echo("You and " . $other_user_name . " share 1 film");
		} 
		else if ($stats->share_count == 0) {
			echo("You do not share any films with " . $other_user_name);
		}
		else {
			echo("You and " . $other_user_name . " share " . $stats->share_count . " films");
		}
		
		if($stats->similarity < 40) {
			echo("<br>Your collections are <span class='shareLow'>" . $stats->similarity . "%</span> similar");
		} else if($stats->similarity < 70) {
			echo("<br>Your collections are <span class='shareMed'>" . $stats->similarity . "%</span> similar");
		} else {
			echo("<br>Your collections are <span class='shareHigh'>" . $stats->similarity . "%</span> similar");
		}
		
		echo("</h2></div>");

		
		//show form for viewing different views of shared collections
		echo("<form id='compareSelect' autocomplete='off' action='collection_compare.php' method='get'>
				<input name='compare_userid' type='hidden' value='".$other_user_id."'>
				<input name='compare_username' type='hidden' value='".$other_user_name."'>
			 	<label for='compareView'>View: </label>
					<select id='compareView' name='compareView' onchange='this.form.submit()'>");
		
		if(isset($_GET["compareView"])) {
			if($_GET["compareView"] == 'all') {
				echo("<option value='all' selected> All </option>
					<option value='shared'> Shared </option>
					<option value='yours'> Yours </option>
					<option value='theirs'> Theirs </option>");
			}
			else if($_GET["compareView"] == 'shared') {
				echo("<option value='all'> All </option>
					<option value='shared' selected> Shared </option>
					<option value='yours'> Yours </option>
					<option value='theirs'> Theirs </option>");
			}
			else if($_GET["compareView"] == 'yours') {
				echo("<option value='all'> All </option>
					<option value='shared'> Shared </option>
					<option value='yours' selected> Yours </option>
					<option value='theirs'> Theirs </option>");
			}
			else if($_GET["compareView"] == 'theirs') {
				echo("<option value='all'> All </option>
					<option value='shared'> Shared </option>
					<option value='yours'> Yours </option>
					<option value='theirs' selected> Theirs </option>");
			}
		} else {
			echo("<option value='all'> All </option>
				<option value='shared'> Shared </option>
				<option value='yours'> Yours </option>
				<option value='theirs'> Theirs </option>");
		}
					
		echo("</select></form><br>");
		
		// decide which view to display
		if(isset($_GET["compareView"])) {
			if($_GET["compareView"] == 'all') {
				show_all_films($con, $user_id, $other_user_id, $other_user_name);
			}
			else if($_GET["compareView"] == 'shared') {
				show_shared_films($con, $user_id, $other_user_id, $other_user_name);
			}
			else if($_GET["compareView"] == 'yours') {
				show_your_films($con, $user_id, $other_user_id, $other_user_name);
			}
			else if($_GET["compareView"] == 'theirs') {
				show_their_films($con, $user_id, $other_user_id, $other_user_name);
			}
		} else {
			show_all_films($con, $user_id, $other_user_id, $other_user_name);
		}
		
		
		
		//get films users share + count

		//get films visiting user has that visited user does not + count

		//get films visited user has the visiting user does not + count

		//calculate correlation of collections

		echo("<script> collectionCompareInit(); </script>");
		include("scripts/db_close.php");
		echo("</div>");
		include("common_footer.php");
	}

	/* Show posters of films in both of your collections */
	function show_all_films($con, $user_id, $other_user_id, $other_user_name) {
		$poster_select = "SELECT film_user, tmdb_id, poster_path, title, release_year FROM film 
							WHERE film_user = ".$user_id." OR film_user = ".$other_user_id." 
							GROUP BY tmdb_id;";
		if($poster_result = mysqli_query($con, $poster_select)) {
			if(mysqli_num_rows($poster_result) > 0){
				display_posters($con, $poster_result, $user_id, $other_user_id, $other_user_name);
			}
		} else {
			echo("Posters could not be retrieved");
			echo mysqli_error($con);
			echo("<br>".$poster_select);
		}
	}

	/* Show posters of films shared by two users */
	function show_shared_films($con, $user_id, $other_user_id, $other_user_name) {
		$poster_select = "SELECT film_user, tmdb_id, poster_path, title, release_year FROM film 
							WHERE film_user = ".$user_id." AND tmdb_id IN (
							SELECT tmdb_id FROM drawertl_jvines.film WHERE film_user = ".$other_user_id.")
							GROUP BY tmdb_id;";
		if($poster_result = mysqli_query($con, $poster_select)) {
			if(mysqli_num_rows($poster_result) > 0){
				display_posters($con, $poster_result, $user_id, $other_user_id, $other_user_name);
			}
		} else {
			echo("Posters could not be retrieved");
			echo mysqli_error($con);
			echo("<br>".$poster_select);
		}
	}

	/* Show posters of films you own that other user does not */
	function show_your_films($con, $user_id, $other_user_id, $other_user_name) {
		$poster_select = "SELECT film_user, tmdb_id, poster_path, title, release_year FROM film 
							WHERE film_user = ".$user_id." AND tmdb_id NOT IN (
							SELECT tmdb_id FROM drawertl_jvines.film WHERE film_user = ".$other_user_id.")
							GROUP BY tmdb_id;";
		if($poster_result = mysqli_query($con, $poster_select)) {
			if(mysqli_num_rows($poster_result) > 0){
				display_posters($con, $poster_result, $user_id, $other_user_id, $other_user_name);
			}
		} else {
			echo("Posters could not be retrieved");
			echo mysqli_error($con);
			echo("<br>".$poster_select);
		}
	}
	
	/* Show posters of films other user owns that you do not */
	function show_their_films($con, $user_id, $other_user_id, $other_user_name) {
		$poster_select = "SELECT film_user, tmdb_id, poster_path, title, release_year FROM film 
							WHERE film_user = ".$other_user_id." AND tmdb_id NOT IN (
							SELECT tmdb_id FROM drawertl_jvines.film WHERE film_user = ".$user_id.")
							GROUP BY tmdb_id;";
		if($poster_result = mysqli_query($con, $poster_select)) {
			if(mysqli_num_rows($poster_result) > 0){
				display_posters($con, $poster_result, $user_id, $other_user_id, $other_user_name);
			}
		} else {
			echo("Posters could not be retrieved");
			echo mysqli_error($con);
			echo("<br>".$poster_select);
		}
	}

	/* Display movie posters in table format */
	function display_posters($con, $poster_result, $user_id, $other_user_id, $other_user_name) {
		
		$poster_count = 0;
		echo("<table class='collectionTable'><tr>");
		
		while($poster = mysqli_fetch_array($poster_result)) {
			$moreInfo = new stdClass();
			
			$moreInfo->shared = false;
			$moreInfo->recommend = false;
			//determine whether your film is owned by the other user
			if($poster["film_user"] == $user_id) {
				$share_count = "SELECT COUNT(*) FROM film 
								WHERE film_user = ".$other_user_id." AND tmdb_id = ".$poster["tmdb_id"].";";
				if($share_result = mysqli_query($con, $share_count)) {
					$share_num = mysqli_fetch_array($share_result)[0];
					if($share_num > 0) {
						$moreInfo->shared = true;
					} else {
						$moreInfo->recommend = true;
					}
				} else {
					echo("Count could not be performed");
					echo mysqli_error($con);
				}
			}
			
			//store film info to be displayed in modal box
			
			$moreInfo->tmdbId = $poster["tmdb_id"];
			$moreInfo->title = $poster["title"];
			$moreInfo->releaseYear = $poster["release_year"];
			$moreInfo->posterPath = $poster["poster_path"];
			$moreInfo->userId = $user_id;
			$moreInfo->otherUserId = $other_user_id;
			$moreInfo->otherUsername = $other_user_name;
			
			echo("<script> storeFilmInfo(".json_encode($moreInfo)."); </script>");
			
			//Display posters in table
			if($poster_count % 6 == 0) echo("</tr><tr>"); //every six films, create new row

			echo("<td class='collectionTableColumn'>");
			echo("<div id='".$poster["tmdb_id"]."'class='collectionPosterContainer'>");
			
			echo("<img class='collectionPoster' src='".$poster["poster_path"]."'>");
			echo("<div class='collectionTitle'><div class='posterText'>"
					.$poster["title"]."<br>(".$poster["release_year"].")");		
			
			echo("</div></div></div></td>");
			$poster_count += 1;
		}
		echo("</tr></table><br><br><br>");
	}

	/* Get supplementary information to display above visually represented films */
	function get_stats($con, $user_id, $other_user_id) {
		$dvd = 4;
		$bluray = 5;
		$uhd = 6;
		$other = 7;
		$compare_stats = new stdClass();
		
		//get count of shared films
		$share_count = "SELECT COUNT(*) FROM film 
							WHERE film_user = ".$user_id." AND tmdb_id IN (
							SELECT tmdb_id FROM film WHERE film_user = ".$other_user_id.");";
		if($share_result = mysqli_query($con, $share_count)) {
			$compare_stats->share_count = mysqli_fetch_array($share_result)[0];
		} else {
			echo("Count could not be performed");
			echo mysqli_error($con);
		}
		
		//get counts for each user's collection
		$title_count = "SELECT COUNT(*) FROM film WHERE film_user = ".$user_id.";";
			if($count_result = mysqli_query($con, $title_count)) {
				$compare_stats->your_count = mysqli_fetch_array($count_result)[0];
			} else {
				echo("Count could not be performed");
				echo mysqli_error($con);
			}

		$title_count = "SELECT COUNT(*) FROM film WHERE film_user = ".$other_user_id.";";
			if($count_result = mysqli_query($con, $title_count)) {
				$compare_stats->other_count = mysqli_fetch_array($count_result)[0];
			} else {
				echo("Count could not be performed");
				echo mysqli_error($con);
			}

		//get # of dvds for each user
		$dvd_count = "SELECT COUNT(*) FROM film WHERE film_user = ".$user_id." AND film_format = ".$dvd.";";
			if($count_result = mysqli_query($con, $dvd_count)) {
				$compare_stats->dvd_num = mysqli_fetch_array($count_result)[0];
			} else {
				echo("Count could not be performed");
				echo mysqli_error($con);
			}

		$dvd_count = "SELECT COUNT(*) FROM film WHERE film_user = ".$other_user_id." AND film_format = ".$dvd.";";
			if($count_result = mysqli_query($con, $dvd_count)) {
				$compare_stats->other_dvd_num = mysqli_fetch_array($count_result)[0];
			} else {
				echo("Count could not be performed");
				echo mysqli_error($con);
			}

		//get # of blurays for each user
		$bluray_count = "SELECT COUNT(*) FROM film WHERE film_user = ".$user_id." AND film_format = ".$bluray.";";
			if($count_result = mysqli_query($con, $bluray_count)) {
				$compare_stats->bluray_num = mysqli_fetch_array($count_result)[0];
			} else {
				echo("Count could not be performed");
				echo mysqli_error($con);
			}

		$bluray_count = "SELECT COUNT(*) FROM film WHERE film_user = ".$other_user_id." AND film_format = ".$bluray.";";
			if($count_result = mysqli_query($con, $bluray_count)) {
				$compare_stats->other_bluray_num = mysqli_fetch_array($count_result)[0];
			} else {
				echo("Count could not be performed");
				echo mysqli_error($con);
			}

		//get # of 4ks for each user
		$uhd_count = "SELECT COUNT(*) FROM film WHERE film_user = ".$user_id." AND film_format = ".$uhd.";";
			if($count_result = mysqli_query($con, $uhd_count)) {
				$compare_stats->uhd_num = mysqli_fetch_array($count_result)[0];
			} else {
				echo("Count could not be performed");
				echo mysqli_error($con);
			}

		$uhd_count = "SELECT COUNT(*) FROM film WHERE film_user = ".$other_user_id." AND film_format = ".$uhd.";";
			if($count_result = mysqli_query($con, $uhd_count)) {
				$compare_stats->other_uhd_num = mysqli_fetch_array($count_result)[0];
			} else {
				echo("Count could not be performed");
				echo mysqli_error($con);
			}
		
		//get percentage of similarity
		$similarity = 100 * (2 * $compare_stats->share_count / ($compare_stats->your_count + $compare_stats->other_count));
		$compare_stats->similarity = round($similarity);
		
		return $compare_stats;
	}

	function send_recommendation($con) {
		
		
	}

?>