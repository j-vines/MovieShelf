<?php 
	include "common_header.php";
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Search for Films</title>
</head>

<body>
	<div class="mainContent">
	<div class="searchBar">
	<form id="filmSearch" autocomplete="off" action="films.php" method="post">
		
		<label for="film_name">Find a Film:</label>
  		<input type="text" id="search" name="search">
		<input type="submit" value="Search">
	
	</form>
	</div>
	
	<?php
	if (isset($_POST['search'])) {
		require "film_search.php";
		
		if($film_search_result) { //if no error resulted from search
			if(mysqli_num_rows($film_search_result) > 0){
				$film_count = 0; //incremented total of films found in search
				while($results = mysqli_fetch_array($film_search_result)) {
				
					/*echo("<form action='user_profile.php' method='post'><input type='hidden' name='userid' value='".$results["iduser"]."'><input type='submit' value='".$results["display_name"]." - ".$results["username"]."'></form><br>");*/
					$film_count += 1;
				}
			} else {
				echo "No results found. Add your film to the database <a href='add_film.php'>here</a>";
			}
		}
		
	}
	
	?>
	
	
	<div class="searchResults">
	
	
	</div>
		<?php
			//display total of users found
			if($film_count != null) {
				if($film_count > 1) {
					echo("Found ".$film_count." films");
				} else {
					echo("Found ".$film_count." films");
				}
				echo("<br>Can't find the movie you're looking for? Add it to the database <a href='add_film.php'>here</a>");
			}
		?>
	</div>
	
</body>
</html>