<?php
/*  MovieShelf
	Jack Vines
	2020 - 2021
*/

/* Activity page displays new posts from followed users and recommendations received from other users */
	include("common_header.php");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Activity</title>
<script src="scripts/activityFunctions.js"></script>
</head>

<body>
	<div class='mainContent'>
		<div id='buttons'>
			<?php
				include("scripts/db_connect.php");
			
				$post_count = 0;
				$recommendation_count = 0;
				
				
			
				$rec_count = "SELECT COUNT(*) FROM recommendation WHERE user_to = ".$_COOKIE["user"]." AND opened = 0;";
				if($count_result = mysqli_query($con, $rec_count)) {
					$recommendation_count = mysqli_fetch_array($count_result)[0];
				} else {
					echo("Count could not be performed");
					echo mysqli_error($con);
				}
			
				echo("<button id='postButton' class='activityToggle' onClick='showPosts()'>NEW POSTS</button>");
			
				if($recommendation_count == 0) {
					echo("<button id='recButton' class='activityToggle' onClick='showRecommendations()'>NO RECOMMENDATIONS</button>");
				} 
				else if($recommendation_count == 1) {
					echo("<button id='recButton' class='activityToggle' onClick='showRecommendations()'><span class='notification'>".$recommendation_count."</span> RECOMMENDATION</button>");
				} else {
					echo("<button id='recButton' class='activityToggle' onClick='showRecommendations()'><span class='notification'>".$recommendation_count."</span> RECOMMENDATIONS</button>");
				}
			
			
			?>
			
			
		</div>
		<div id='recommendations'>
			<?php
				$rec_select = "SELECT idrecommendation, user_from, film_title, film_poster_path, film_release_year, sent_time, message, opened FROM recommendation WHERE user_to = " . $_COOKIE["user"] . ";";
				if(!($rec_result = mysqli_query($con, $rec_select))) {
					echo("Recommendations could not be retrieved");
					echo mysqli_error($con);
				} else {
					if(mysqli_num_rows($rec_result) > 0){
						$rec_num = 0;
						$new_rec_num = 0;
						while($rec = mysqli_fetch_array($rec_result)) {
							//get name of user who sent recommendation
							$name_select = "SELECT display_name FROM user WHERE iduser = ".$rec["user_from"].";";
							if(!($name_result = mysqli_query($con, $name_select))) {
								echo("From name could not be retrieved");
								echo mysqli_error($con);
							} else {
								$from_name = mysqli_fetch_array($name_result)[0];
							}
							echo("<button id='openRec".$rec_num."' onClick='openRec(".$rec_num.", ".$rec["idrecommendation"].")' class='recommendationShow'>");
							if($rec["opened"] == 0) {
								echo("<span id='openedLabel".$rec_num."' class='openedLabel'>NEW</span>");
								$new_rec_num++;
							}
							echo("Sent: " .$rec["sent_time"]."<br>");
							echo("From: " . $from_name . " - " . $rec["film_title"] . " (" . $rec["film_release_year"] . ")" );
							echo("</button>");
							
							echo("<div id='rec".$rec_num."' class='recommendation'>");
							echo("<h2><a class='profileLink' href='user_profile.php?userid=".$rec["user_from"]."'>" . $from_name . "</a> recommends " .  $rec["film_title"] . " (" . $rec["film_release_year"] . ")</h2>");
							echo("<img id='recPoster' src='".$rec["film_poster_path"]."'></img><br>");
							echo("<br>Message: " . $rec["message"] . "<br><br> <button onClick='closeRec(".$rec_num.")'>Close</button>");
							echo("<br><br><button onClick='deleteRec(".$rec_num.", ".$rec["idrecommendation"].")'>Delete</button>");
							
								
							echo("</div>");
							
							$rec_num += 1;
							
						}
						echo("<script> storeRecNum(".$new_rec_num."); </script>");
					}
				}
			
			
			
			?>
			
		
		</div>
		<div id='posts'>
			<br>
			Retrieving updates...
		</div>
	</div>
	<script> initGetPosts(); </script>
	
</body>
</html>
<?php
	include("common_footer.php");
?>
