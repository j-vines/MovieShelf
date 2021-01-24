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
	<div class="mainContent">
	<div class="searchBar">
	<form id="userSearch" autocomplete="off" action="people.php" method="post">
		
		<label for="username">Find MovieShelf members:</label>
  		<input type="text" id="search" name="search">
		<input type="submit" value="Search">
	
	</form>
	</div>
	
	<?php
	if (isset($_POST['search'])) {
		require "people_search.php";
		
		if(mysqli_num_rows($user_search_result) > 0){
			$user_count = 0; //incremented total of users found in search
			while($results = mysqli_fetch_array($user_search_result)) {
				
				echo("<form action='user_profile.php' method='post'><input type='hidden' name='userid' value='".$results["iduser"]."'><input type='submit' value='".$results["display_name"]." - ".$results["username"]."'></form><br>");
				$user_count += 1;
			}
		} else {
			echo "No results found";
		}
	}
	
	?>
	
	
	<div class="searchResults">
	
	
	</div>
		<?php
			//display total of users found
			if($user_count != null) {
				if($user_count > 1) {
					echo("Found ".$user_count." members.");
				} else {
					echo("Found ".$user_count." member.");
				}
				
			}
		?>
	</div>
	
</body>
</html>