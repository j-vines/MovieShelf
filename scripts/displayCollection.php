<?php

	/* Displays films present in provided shelf. If no shelf provided, displays entire collection */
	function displayCollection() {
		include("db_connect.php");
		$collectionUser;
		$collectionUsername;
		$visiting; //specifies whether user is visting another profile or not
		//check if user is viewing another person's collection, if so, display that user's collection
		if(isset($_GET['userid'])) {
			$collectionUser = $_GET['userid'];
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
					<button id='close' onClick='closeFilmInfo()'>Close</button>");
		if($visiting) {
			echo("<h2>".$collectionUsername." owns <span id='moreInfoTitle'></span> (<span id='moreInfoYear'></span>) on <span id='moreInfoFormat'>");
		} else {
			echo("<h2>You own <span id='moreInfoTitle'></span> (<span id='moreInfoYear'></span>) on <span id='moreInfoFormat'>");
		}
		echo("</span></h2>
					<img id='moreInfoPoster'></img>
					<h3><span id='moreInfoShelves'></span></h3>");
		
		if(!$visiting) {
			//Display form for adding to shelves
			$shelf_select = "SELECT idshelf, `name` FROM shelf WHERE shelf_user = ".$collectionUser.";";
			if($shelf_result = mysqli_query($con, $shelf_select)) {
				if(mysqli_num_rows($shelf_result) > 0){
					echo("<form id='filmShelfAdd' autocomplete='off' action='scripts/shelf_edit.php' method='post'>");

					echo("<label for='shelf'>Add to shelf: </label>"
						. "<input type='hidden' value='' name='addFilm' id='addFilm'>" //this value gets set differently for each film
						. "<select id='shelf' name='shelf' onchange='this.form.submit()'>"
						. "<option>No shelf selected</option>");
					while($shelf = mysqli_fetch_array($shelf_result)) {
						echo("<option value='".$shelf["idshelf"]."'>".$shelf["name"]."</option>");
					}
					echo("</select></form>");
				}
			}
			else {
				echo("Shelves could not be retrieved");
				echo mysqli_error($con);
			}
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
		
		echo("<div class='collectionHeading'><h2>Collection (".$count." titles)</h2><br>");
		//display shelf options
		//get shelf options
		$shelf_select = "SELECT idshelf, `name` FROM shelf WHERE shelf_user = ".$collectionUser.";";
		if($shelf_result = mysqli_query($con, $shelf_select)) {
			if(mysqli_num_rows($shelf_result) > 0){
				if(isset($_GET['userid'])) {
					echo("<form id='shelfSelect' autocomplete='off' action='user_profile.php' method='get'>" //if user is viewing other's collection, change form action
						."<input name='userid' type='hidden' value='".$_GET['userid']."'>"); //and persist $_GET[userid]
				} else {
					echo("<form id='shelfSelect' autocomplete='off' action='profile.php' method='get'>");
				}
				echo("<label for='shelf'>Shelf: </label>"
					. "<select id='shelf' name='shelf' onchange='this.form.submit()'>"
					. "<option>No shelf selected</option>"
					. "<option value='0'>Show all films</option>");
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
				} else {
					echo("User has no shelves</div>");
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
				displayAll($collectionUser, $con);
			}
			else {
				displayShelf($_GET['shelf'], $collectionUser, $con);
			}
		} else {
			displayAll($collectionUser, $con); //user has not chosen a shelf
		}
		include("db_close.php");
	}

	/* Display all posters resturned from mysql queries */
	function showPosters($poster_result, $con) {
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

			$something = getShelves($poster["idfilm"], $con);

			echo("<td class='collectionTableColumn'>");
			echo("<div class='collectionPosterContainer' onclick='showFilmInfo(\"".$poster["idfilm"]."\", \"".$poster["title"]."\", \"".$format."\", \"".$poster["release_year"]."\", \"".$poster["poster_path"]."\", ".getShelves($poster["idfilm"], $con).")'>"); //(filmid, title, format, releaseYear, posterPath, shelvesArray)
			echo("<img class='collectionPoster' src='".$poster["poster_path"]."'>");
			echo("<div class='collectionTitle'><div class='posterText'>"
					.$poster["title"]."<br>(".$poster["release_year"].")<br><br>".$format."<br><br><br>");

			//place remove button if viewing personal collection
			if(!$visiting) {
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
	function displayShelf($shelf, $collectionUser, $con) {
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
		
		$poster_select = "SELECT idfilm, poster_path, title, release_year, film_format "
   		."FROM film "
   		."JOIN filmshelf "
   		."ON film.idfilm = filmshelf_film AND filmshelf_shelf = ".$shelf.";";
		
		
		if($poster_result = mysqli_query($con, $poster_select)) {
			if(mysqli_num_rows($poster_result) > 0){
				showPosters($poster_result, $con);
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
	function displayAll($collectionUser, $con) {
		
		//get/display posters
		$poster_select = "SELECT idfilm, poster_path, title, release_year, film_format FROM film WHERE film_user = ".$collectionUser.";";
		if($poster_result = mysqli_query($con, $poster_select)) {
			if(mysqli_num_rows($poster_result) > 0){
				showPosters($poster_result, $con);
			}
		} else {
			echo("Posters could not be retrieved");
			echo mysqli_error($con);
			echo("<br>".$poster_select);
		}
		
	}
	
?>