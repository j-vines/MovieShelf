<?php 
	include "common_header.php";
	include "scripts/get_display_name.php";
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
			include "scripts/db_connect.php";
			
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
				<button id="close" onClick="closeShelfOptions()">Close</button><br><br><br>
				<button onClick="showAddShelf()" id="addButton">Create New Shelf</button><br><br>
				<div id="addShelf" class='addShelf'>
					<form action="scripts/shelf_edit.php" method="post">
						<input type="hidden" name="create" id="create" value="create">
						<table>
							<tr>
								<td align="right">
									<label for="shelfName">Name of Shelf:</label>
								</td>
								<td align="left">
									<input type="text" id="shelfName" name="shelfName"><br>
								</td>
							</tr>
							<tr>
								<td align="right">
									<label for="shelfDesc">Description:</label>
								</td>
								<td align="left">
									<input type="text" id="shelfDesc" name="shelfDesc"><br>
								</td>
							</tr>
						</table>
						<input type="submit" value="Create">
					</form>
					<button onClick="cancelOp()">Cancel</button><br><br>
				</div>
				<button onClick="showDeleteShelf()" id="deleteButton">Delete Shelf</button><br><br>
				<div id="deleteShelf" class='deleteShelf'>
					<?php
					include("scripts/db_connect.php");
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
							echo("</select><input type='submit' value='Delete'></form>");
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
					<button onClick="cancelOp()">Cancel</button><br><br>
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
