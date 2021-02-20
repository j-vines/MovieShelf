<?php 
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
			<button id="close" onClick="closeAddFilm()">Close</button>
			
    		
		</div>
		
	</div>
	<div id="searchResults"> <!-- displays buttons for each film found in search -->
	
	</div>
	</div>
	
</body>
</html>
<?php include "common_footer.php"; ?>