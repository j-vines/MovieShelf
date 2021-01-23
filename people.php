<?php 
	include "common_header.php";
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Search for Members</title>
</head>

<body>
	<div class="searchBar">
	<form autocomplete="off" action="people.php" method="post">
		
		<label for="username">Search for MovieShelf members:</label>
  		<input type="text" id="search" name="search">
		<input type="submit" value="Search">
	
	</form>
	</div>
	
	<?php
	if (isset($_POST['search'])) {
		require "people_search.php";
		
		if(mysqli_num_rows($user_search_result) > 0){
			while($results = mysqli_fetch_array($user_search_result)) {
				
				echo("<form action='user_profile.php' method='post'><input type='hidden' name='userid' value='".$results["iduser"]."'><input type='submit' value='".$results["display_name"]."'></form><br>");
			}
		} else {
			echo "No results found";
		}
	}
	
	?>
	
	
	<div class="searchResults">
	
	
	</div>
	
	
</body>
</html>