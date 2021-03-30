<?php 
	include "common_header.php";
	include "scripts/get_display_name.php";
	include "scripts/db_connect.php";
	
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Profile</title>
<link rel="stylesheet" href="css/profile_styles.css">
</head>
<body>
	<div class="mainContent">
		<?php
			//Title of user's profile
			echo("<h2 class='profileTitle'>".$display_name."'s Profile</h2>");
		
			//Get follower count
			$follow_count = "SELECT COUNT(*) FROM following WHERE followed_user = ".$_COOKIE["user"].";";
			if($count_result = mysqli_query($con, $follow_count)) {
				$followers = mysqli_fetch_array($count_result)[0];
			} else {
				echo("Count could not be performed");
				echo mysqli_error($con);
			}
		
			//Get following count
			$follow_count = "SELECT COUNT(*) FROM following WHERE following_user = ".$_COOKIE["user"].";";
			if($count_result = mysqli_query($con, $follow_count)) {
				$following = mysqli_fetch_array($count_result)[0];
			} else {
				echo("Count could not be performed");
				echo mysqli_error($con);
			}
		
			if($followers == 1) {
				echo("1 follower, ");
			} else {
				echo($followers . " followers, ");
			}
			
			echo($following . " following<br><br>");
			

		
		
		?>
		<!-- Links to form for editing user profile -->
		<button onClick="location.href='edit_profile.php'">Edit Profile</button>
		<div class="personalInfo">
		<div class="profilePic">
			<?php
			//look for profile picture -- if not found, put default pic
			
			?>
			<img width=80% src="images/default.png" alt="No profile picture found."> <!-- find profile picture in image_uploads -->
		</div>
		
		<div class="profileBio">
			<?php
			//look for bio -- if not found, fill with default text
			
			$bio_search = "SELECT bio FROM user WHERE iduser ='".$_COOKIE["user"]."';";
			if($bio_search_result = mysqli_query($con, $bio_search)) {
				$bio = mysqli_fetch_array($bio_search_result)[0];
			} else {
				echo("No result.");
				echo mysqli_error($con);
			}
			
			if($bio == null) { //user has not defined a bio
				echo("<p>You have not written a bio.");
			} else {
				echo("<p>".$bio."<p>");
			}
			?>
		</div>
		</div>
		<!-- Modal box that contains options for adding and deleting shelves -->
		<div class="modalBox" id="shelfOptions">
			<div class="modalBoxContent" id="shelfOptionsContent">
				<button id="close" onClick="closeShelfOptions()">Close</button>
				<button onClick="showAddShelf()" id="addShelfButton">CREATE NEW SHELF</button>
				<div id="addShelf" class='addShelf'>
					<h2>Creating a new shelf</h2>
					<form action="scripts/shelf_edit.php" autocomplete="off" method="post">
						<input type="hidden" name="create" id="create" value="create">
						<table class="addShelfForm">
							<tr>
								<td align="right">
									<label for="shelfName">Name of Shelf:</label>
								</td>
								<td align="left">
									<input type="text" id="shelfName" name="shelfName">
								</td>
							</tr>
							<tr>
								<td align="right">
									<label for="shelfDesc">Description:</label>
								</td>
								<td align="left">
									<textarea maxlength="150" rows = "3" id="shelfDesc" name = "shelfDesc"></textarea>
								</td>
							</tr>
						</table>
						<input class="submitButton" type="submit" value="Create">
					</form>
					<button class="cancelButton" onClick="cancelOp()">Cancel</button>
				</div>
				<button onClick="showDeleteShelf()" id="deleteShelfButton">DELETE SHELF</button>
				<div id="deleteShelf" class='deleteShelf'>
				<h2>Deleting a shelf</h2>
					<?php
					//include("scripts/db_connect.php");
					//show drop down of existing lists
					$shelf_select = "SELECT idshelf, `name` FROM shelf WHERE shelf_user = ".$_COOKIE["user"].";";
					if($shelf_result = mysqli_query($con, $shelf_select)) {
						if(mysqli_num_rows($shelf_result) > 0){
							echo("<form id='shelfDelete' autocomplete='off' action='scripts/shelf_edit.php' method='post'>"
								. "<input type='hidden' name='delete' id='delete' value='delete'>"
								. "<label for='shelf'>Shelf: </label>"
								. "<select id='shelf' name='shelf'>");
							while($shelf = mysqli_fetch_array($shelf_result)) {
								echo("<option value='".$shelf["idshelf"]."'>".$shelf["name"]."</option>");
							}
							echo("</select><input class='submitButton' type='submit' value='Delete'></form>");
						} else {
							echo("You have no shelves");
						}
					}
					else {
						echo("Shelves could not be retrieved");
						echo mysqli_error($con);
					}
					include("scripts/db_close.php");
					?>
					<button class="cancelButton" onClick="cancelOp()">Cancel</button>
				</div>
			</div>
		</div>
		<?php 
			include "scripts/displayCollection.php";
			
			displayCollection();
		
		?>
		
	</div>
	
</body>
</html>
<?php include "common_footer.php"; ?>
