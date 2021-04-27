<?php 

/*  MovieShelf
	Jack Vines
	2020 - 2021
*/

/* Film search page contains search bar for searching TMDb API for films */

	include "common_header.php";
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="css/film_styles.css">
<script src="scripts/filmFunctions.js"></script>
<title>Search for Films</title>
</head>

<body>
	<div class="mainContent">
	<div class="searchBar">
	<form id="filmSearch" autocomplete="off">
		
		<label for="film_name">Find a Film:</label>
  		<input type="text" id="search" name="search">
		<input type="button" value="Search" onclick="filmSearch()">
	
	</form>
	</div>
	<div id="addFilm" class="modalBox"> <!-- modal box that displays film information -->
		<div id="addFilmContent" class="modalBoxContent">
			<div class="modalHeader">
			<button id='close' onClick='closeAddFilm()'>Close</button><br>
			<h2 id="addFilmContentTitle"></h2>
			</div>
			<form id='collectionAdd' autocomplete='off' action='add_film.php' method='post'>
			<input type='hidden' id='filmId' name='filmId' value=''> <!--pass api film id to database-->
			<input type='hidden' id='posterPath' name='posterPath' value=''><!-- pass poster path to database-->
			<input type='hidden' id='title' name='title' value=''> <!--pass film title to database-->
			<input type='hidden' id='releaseDate' name='releaseDate' value=''>
			<input type='hidden' id='userId' name='userId' value=''> <!--pass userid to add script-->
			
			<label for='rating'>Rate this release: </label>
			<div class='starRating'>
			<input type='radio' name='rating' id='5stars' value='5'>
			<label for='5stars'>&#9733;</label>
			<input type='radio' name='rating' id='4stars' value='4'>
			<label for='4stars'>&#9733;</label>
			<input type='radio' name='rating' id='3stars' value='3'>
			<label for='3stars'>&#9733;</label>
			<input type='radio' name='rating' id='2stars' value='2'>
			<label for='2stars'>&#9733;</label>
			<input type='radio' name='rating' id='1star' value='1'>
			<label for='1star'>&#9733;</label>
			</div>
			
			<br><br>
			<label for='format'>Format: </label>
			<select id='format' name='format'>
   			<option value='4'>DVD</option> <!-- 4 - id for dvd in db -->
			<option value='5'>Blu-ray</option> <!-- 5 - id for bluray in db-->
			<option value='6'>4k UHD</option> <!-- 6 - id for 4k in db -->
			<option value='7'>Other</option>
  			</select>
			<br><br>
			
			<?php
				include("scripts/db_connect.php");
				$shelf_select = "SELECT idshelf, `name` FROM shelf WHERE shelf_user = ".$_COOKIE["user"].";";
				if($shelf_result = mysqli_query($con, $shelf_select)) {
					if(mysqli_num_rows($shelf_result) > 0){
						echo("<label for='shelf'>Shelf: </label>"
							. "<select id='shelf' name='shelf'>"
							. "<option value='0'>No shelf selected</option>");
						while($shelf = mysqli_fetch_array($shelf_result)) {
							echo("<option value='".$shelf["idshelf"]."'>".$shelf["name"]."</option>");
						}
						echo("</select>");
					} else {
						echo("You don't have any shelves to add to");
					}
				}
				else {
					echo("Shelves could not be retrieved");
					echo mysqli_error($con);
				}
				include("scripts/db_close.php");
			?>
			<br><br>
			<input type='submit' class='addFilmSubmit' value='Add'>
			
			</form><br><br>
    		
		</div>
		
	</div>
	<div id="searchResults"> <!-- displays buttons for each film found in search -->
	
	</div>
	</div>
	
</body>
</html>
<?php include "common_footer.php"; ?>