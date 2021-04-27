<?php
	/*  MovieShelf
		Jack Vines
		2020 - 2021
	*/

	/* Functions used in displaying your or another user's collection */

	/* Displays films present in provided shelf. If no shelf provided, displays entire collection */
	function displayCollection() {
		include("db_connect.php");
		$collectionUser;
		$collectionUsername;
		$visiting; //specifies whether user is visting another profile or not
		//check if user is viewing another person's collection, if so, display that user's collection
		if(isset($_GET['userid']) || isset($_POST['userid'])) {
			if(isset($_GET['userid'])) {
				$collectionUser = $_GET['userid'];
			} else {
				$collectionUser = $_POST['userid'];
			}
			
			$visiting = true;
			
			$name_select = "SELECT display_name FROM user WHERE iduser = ".$collectionUser.";";
			if($name_result = mysqli_query($con, $name_select)) {
				$collectionUsername = mysqli_fetch_array($name_result)[0];
			} else {
				echo("User's display name could not be retreived");
				echo mysqli_error($con);
			}
		} else {
			$collectionUser = $_COOKIE["user"];
			$visiting = false;
		}
		
		
		
		//create film info modal box
		echo("
			<div id='filmInfo' class='modalBox'>
				<div id='filmInfoContent' class='modalBoxContent'>
				<div class='modalHeader'>
					<button id='close' onClick='closeFilmInfo()'>Close</button>");
		if($visiting) {
			echo("<h2>".$collectionUsername." owns <span id='moreInfoTitle'></span> (<span id='moreInfoYear'></span>) on <span id='moreInfoFormat'>");
		} else {
			echo("<h2>You own <span id='moreInfoTitle'></span> (<span id='moreInfoYear'></span>) on <span id='moreInfoFormat'>");
		}
		
		
		
		echo("</span></h2></div>");
		if($visiting) { //disable star buttons if you are viewing another user's profile
			echo("<div class='starRating'>"
			. "<input type='radio' name='rating' id='5stars' value='5' disabled>"
			. "<label for='5stars'>&#9733;</label>"
			. "<input type='radio' name='rating' id='4stars' value='4' disabled>"
			. "<label for='4stars'>&#9733;</label>"
			. "<input type='radio' name='rating' id='3stars' value='3' disabled>"
			. "<label for='3stars'>&#9733;</label>"
			. "<input type='radio' name='rating' id='2stars' value='2' disabled>"
			. "<label for='2stars'>&#9733;</label>"
			. "<input type='radio' name='rating' id='1star' value='1' disabled>"
			. "<label for='1star'>&#9733;</label>"
			. "</div><br>");
		} else {
			echo("<form id='moreInfoRating'>"
			. "<input type='hidden' id='ratingId' name='ratingId' value=''>"
			. "<div class='starRating'>"
			. "<input type='radio' name='rating' id='5stars' value='5'>"
			. "<label for='5stars'>&#9733;</label>"
			. "<input type='radio' name='rating' id='4stars' value='4'>"
			. "<label for='4stars'>&#9733;</label>"
			. "<input type='radio' name='rating' id='3stars' value='3'>"
			. "<label for='3stars'>&#9733;</label>"
			. "<input type='radio' name='rating' id='2stars' value='2'>"
			. "<label for='2stars'>&#9733;</label>"
			. "<input type='radio' name='rating' id='1star' value='1'>"
			. "<label for='1star'>&#9733;</label></form>"
			. "</div>");
		}
		
		
		echo("<img id='moreInfoPoster'></img>
				<div id='moreInfoReviewText'></div>");
		if(!$visiting) {
			echo("<button id='moreInfoReviewButton'></button>");
			echo("<div id='moreInfoReviewForm'>
					<textarea maxlength='250' rows='5' cols='40' id='reviewTextArea' name='reviewTextArea'></textarea><br><br>
					<button id='postReviewButton'>Post Review</button><br><br>
					<button id='cancelReviewButton'>Cancel</button></div>");
		}
				
		echo("<h3><span id='moreInfoShelves'></span></h3>");
		
		if(!$visiting) {
			echo("<div id='moreInfoAddForm'></div>");
			echo("<div id='moreInfoDeleteForm'></div>");
			//place remove button if viewing personal collection
			echo("<div><button id='removeFilm'>Remove</button></div>");
		}
		echo("</div></div>");
		

		//get/display collection count
		$title_count = "SELECT COUNT(*) FROM film WHERE film_user = ".$collectionUser.";";
		if($count_result = mysqli_query($con, $title_count)) {
			$count = mysqli_fetch_array($count_result)[0];
		} else {
			echo("Count could not be performed");
			echo mysqli_error($con);
			echo("<br>".$title_count);
		}
		
		if($count > 0) {
			if($visiting) {
				echo("<div class='collectionHeading'><div id='collectionHeadingTitle'>
					<a id='compareLink' href='collection_compare.php?compare_userid=".$collectionUser."&compare_username=".$collectionUsername."'> Collection (".$count." titles)</a>");
				echo("<p id='compareToolTip'> Compare your collection to ".$collectionUsername."'s to see how your taste in
					film coorelates.</p></div>");
			} else {
				echo("<div class='collectionHeading'><h2>Collection (".$count." titles)</h2>");
			}
			
		} else {
			if($visiting) echo("<div class='collectionHeading'><h2>".$collectionUsername." has not started a collection</h2></div><br>");
			else echo("<div class='collectionHeading'><h2>You have not started a collection</h2></div><br>");
		}
		
		
		//display shelf options
		//get shelf options
		$shelf_select = "SELECT idshelf, `name` FROM shelf WHERE shelf_user = ".$collectionUser.";";
		if($shelf_result = mysqli_query($con, $shelf_select)) {
			if(mysqli_num_rows($shelf_result) > 0){
				if(isset($_GET['userid']) || isset($_POST['userid'])) {
					echo("<form id='shelfSelect' autocomplete='off' action='user_profile.php' method='get'>" //if user is viewing other's collection, change form action
						."<input name='userid' type='hidden' value='".$collectionUser."'>"); //and persist $_GET[userid]
				} else {
					echo("<form id='shelfSelect' autocomplete='off' action='profile.php' method='get'>");
				}
				echo("<label for='shelf'>Shelf: </label>"
					. "<select id='shelf_display' name='shelf' onchange='this.form.submit()'>");
				echo("<option value='0'>Show all films</option>");
				while($shelf = mysqli_fetch_array($shelf_result)) {
					
					if(isset($_GET['shelf'])) { //if you're viewing this shelf, make it default selected value
						if($_GET['shelf'] == $shelf['idshelf']) { 
							echo("<option selected value='".$shelf["idshelf"]."'>".$shelf["name"]."</option>");
						} else {
							echo("<option value='".$shelf["idshelf"]."'>".$shelf["name"]."</option>");
						}
					} else {
						echo("<option value='".$shelf["idshelf"]."'>".$shelf["name"]."</option>");
					}
				}
				echo("</select></form></div>");
			} else {
				if(!$visiting) {
					echo("You have no shelves</div>");
				}
			}
		}
		else {
			echo("Shelves could not be retrieved");
			echo mysqli_error($con);
		}
		
		//if personal profile, show edit shelves button
		if(!$visiting) {
			echo("<button class='smallButton' onClick='showShelfOptions()'>Edit Shelves</button>");
		}
		
		if(isset($_GET['shelf'])) {
			if($_GET['shelf'] == 0) { //user chose "display all films"
				displayAll($collectionUser, $visiting, $con);
			}
			else {
				displayShelf($_GET['shelf'], $collectionUser, $visiting, $con);
			}
		} else {
			displayAll($collectionUser, $visiting, $con); //user has not chosen a shelf
		}
		//initialize collectionFunctions.js
		echo("<script> collectionInit(); </script>");
		include("db_close.php");
	}

	/* Display all posters resturned from mysql queries */
	function showPosters($poster_result, $visiting, $con) {
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
			
			//get review text
			$review_select = "SELECT review_text FROM review WHERE review_film = ".$poster["idfilm"].";";
			if($review_result = mysqli_query($con, $review_select)) {
				$review = mysqli_fetch_array($review_result)[0];
			} else {
				echo("review could not be retrieved");
				echo mysqli_error($con);
			}

			if($poster_count % 6 == 0) echo("</tr><tr>"); //every six films, create new row

			$something = getShelves($poster["idfilm"], $con);

			echo("<td class='collectionTableColumn'>");
			echo("<div id='".$poster["idfilm"]."'class='collectionPosterContainer'>");
			
			//store info needed to be displayed on more info screen in json object that will be stored in javascript
			$moreInfo = new stdClass();
			$moreInfo->id = $poster["idfilm"];
			$moreInfo->title = $poster["title"];
			$moreInfo->rating = $poster["rating"];
			$moreInfo->format = $format;
			$moreInfo->review = $review;
			$moreInfo->releaseYear = $poster["release_year"];
			$moreInfo->posterPath = $poster["poster_path"];
			$moreInfo->shelvesIn = getShelves($poster["idfilm"], $con);
			$moreInfo->shelvesOut = getShelvesNotIn($poster["idfilm"], $con);
			
			echo("<script> storeFilmInfo(".json_encode($moreInfo)."); </script>");
			
			
			echo("<img class='collectionPoster' src='".$poster["poster_path"]."'>");
			echo("<div class='collectionTitle'><div class='posterText'>"
					.$poster["title"]."<br>(".$poster["release_year"].")<br><br>".$format."<br><br><br>");
			echo("</div></div></div></td>");
			$poster_count += 1;
		}
		echo("</tr></table></div><br><br><br>");
	}

	/* Returns id and names of shelves that a given film is NOT present in */
	function getShelvesNotIn($filmId, $con) {
		$shelf_array = array();
		
		$shelf_select = "SELECT idshelf, `name` FROM shelf "
						. "WHERE shelf_user = ".$_COOKIE["user"]." AND idshelf NOT IN "
						. "(SELECT filmshelf_shelf FROM filmshelf WHERE filmshelf_film = ".$filmId.") "
						. "group by idshelf;";

		if($shelf_result = mysqli_query($con, $shelf_select)) {
			while($shelf = mysqli_fetch_array($shelf_result)) {
				$shelf_string = $shelf["idshelf"] .":". $shelf["name"]; //create array of strings w/ format "id:name"
				array_push($shelf_array, $shelf_string);
			}
			
		} else {
			echo("Shelves could not be retrieved for given film");
			echo mysqli_error($con);
		}
		return json_encode($shelf_array);
	}	

	/* Returns id and names of shelves that a given film is present in */
	function getShelves($filmId, $con) {
		$shelf_array = array();
		
		$shelf_select = "SELECT idshelf, `name` FROM shelf "
						."JOIN filmshelf "
						."ON idshelf = filmshelf_shelf AND filmshelf_film = ".$filmId.";";
		if($shelf_result = mysqli_query($con, $shelf_select)) {
			while($shelf = mysqli_fetch_array($shelf_result)) {
				$shelf_string = $shelf["idshelf"] .":". $shelf["name"]; //create array of strings w/ format "id:name"
				array_push($shelf_array, $shelf_string);
			}
			
		} else {
			echo("Shelves could not be retrieved for given film");
			echo mysqli_error($con);
		}
		return json_encode($shelf_array);
	}

	/* Displays all films in specified shelf */
	function displayShelf($shelf, $visiting, $collectionUser, $con) {
		echo("<script> setCurrShelf(".$shelf."); </script>");
		//display name and description of shelf
		$shelf_info_select = "SELECT `name`, `desc` FROM shelf WHERE idshelf = ".$shelf.";";
		if($shelf_info_result = mysqli_query($con, $shelf_info_select)) {
			$shelf_info = mysqli_fetch_array($shelf_info_result);
			echo("<h3>".$shelf_info["name"]."</h3>");
			echo("<p>".$shelf_info["desc"]."</p>");
		} else {
			echo("Shelf name and description could not be retrieved");
			echo mysqli_error($con);
		}
		
		$poster_select = "SELECT idfilm, poster_path, title, release_year, film_format, rating "
   		."FROM film "
   		."JOIN filmshelf "
   		."ON film.idfilm = filmshelf_film AND filmshelf_shelf = ".$shelf.";";
		
		
		if($poster_result = mysqli_query($con, $poster_select)) {
			if(mysqli_num_rows($poster_result) > 0){
				showPosters($poster_result, $visiting, $con);
			} else {
				echo("<p>This shelf is empty.</p><br><br>");
			}
		} else {
			echo("Posters could not be retrieved");
			echo mysqli_error($con);
			echo("<br>".$poster_select);
		}
	}
	
	
	//display shelf options

	/* Displays all films in a user's collection */
	function displayAll($collectionUser, $visiting, $con) {
		echo("<script> setCurrShelf(0); </script>");
		//get/display posters
		$poster_select = "SELECT idfilm, poster_path, title, release_year, film_format, rating FROM film WHERE film_user = ".$collectionUser.";";
		if($poster_result = mysqli_query($con, $poster_select)) {
			if(mysqli_num_rows($poster_result) > 0){
				showPosters($poster_result, $visiting, $con);
			}
		} else {
			echo("Posters could not be retrieved");
			echo mysqli_error($con);
			echo("<br>".$poster_select);
		}
		
	}
	
?>