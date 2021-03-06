<?php
/*  MovieShelf
	Jack Vines
	2020 - 2021
*/

/* Header included on every page across site */
	session_start();
	$login_message_content = "";
	//CHECK IF USER COOKIE IS SET. IF NOT, DISPLAY LOGIN BUTTON, IF SO, DISPLAY WELCOME MESSAGE AND SIGN IN BUTTON
	if(isset($_COOKIE["user"])) {
		include "scripts/get_display_name.php";
		$login_message_content = "<div id='welcomeMessage'>Welcome, ".$display_name."!</div>"
									."<form action='signout.php' method='post'>
    									<input type='submit' name='signout' id='signout' value='Sign Out'><br>
										</form>";
	} else {
		$login_message_content = "<button class = 'button' type='button' onClick='displayForm()'>Log In</button>";
	}
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="css/header_styles.css">
<script src="scripts/cookieFunctions.js"></script>
<script src="scripts/loginFunctions.js"></script>
<script src="scripts/collectionFunctions.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
	
<body onLoad="init()">
	<!-- modal box that displays sign up form -->
	<div id="createAccount" class="modalBox"> 
		<div id="createAccountContent" class="modalBoxContent">
			<button id="close" onClick="closeCreateAccount()">Close</button>
			<h1>Create a <img src="images/ms_logo_alt.png" alt="MovieShelf" width="35%"> Account</h1>
			
			<form autocomplete="off" action="create_account.php" method="post">
				<table class="signupForm">
					<tr>
						<td align="right">
							<label for="email">Email:</label>
						</td>
						<td align="left">
							<input type="text" id="email" name="email" 
				  			 pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Enter a valid email."><br>
						</td>
					</tr>
					<tr>
						<td align="right">
							<label for="username">Username:</label>
						</td>
						<td align="left">
							<input type="text" id="username_signup" name="username" 
				   			pattern="^(?=.{8,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$" title="Enter a valid username."><br>
						</td>
					</tr>
					<tr>
						<td align="right">
							<label for="password">Password:</label>
						</td>
						<td align="left">
							<input type="password" id="password_signup" name="password" 
				   			pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Enter a valid password."
							autocomplete="new-password">
							<input type="checkbox" onclick="togglePassword()">Show Password<br>
						</td>
					</tr>
				</table>
				<?php
					//if last sign up failed, display error message
					if(isset($_COOKIE["signup_error"])) {
						echo("<p class='error'>".$_COOKIE["signup_error"]."</p><br>");
					}
				?>
			
  				<input type="submit" value="Sign Up"><br>
			</form>
    		
		</div>
		
	</div>
	
	<div class = "header">
		<!-- Div stores either login button, or, when user is logged in, a welcome message and sign out button -->
		<div class = "loginMessage" id = "loginMessage">
			<!--<button class = "button" type="button" onClick="displayForm()">Log In</button>-->
			<?php
				//if last login failed, display login error message
				if(isset($_COOKIE["login_error"])) {
					echo("<p class='error'>".$_COOKIE["login_error"]."</p>");
				}
			?>
			<?php echo($login_message_content); ?>
		</div>
		
		<div class = "loginForm" id = "loginForm">
			<form action = "login.php" method = "post">
				<label for="username">Username:</label>
  				<input type="text" id="username_login" name="username" 
				  pattern="^(?=.{8,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$" title="Enter a valid username.">
				<br>
				<label for="password">Password:</label>
  				<input autocomplete="off" type="password" id="password_login" name="password" 
				  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Enter a valid password.">
				<br>
				<input type="checkbox" onclick="togglePassword()">Show Password
				<br>
				
				<input class="button" type="submit" value="Log In">
				<button class="button" type="button" onClick="hideForm()">Cancel</button><br><br>
			
				Don't have an account? <button class="smallButton" type="button" onClick="openCreateAccount()">Create one!</button>
			</form>
				
		</div>
		
		<div class = "logo">
			<a href = "index.php"><img alt="Logo not found" src="images/ms_logo_white.png" width="20%"></a>
		</div>
		
	</div>
	
	<div class = "links">
		<?php
			if(isset($_COOKIE["user"])) { //only give profile and activity options if user is logged in
				include("scripts/db_connect.php");
				
				//count posts + recommendations for number displayed next to activity
				$activity_count = 0;
				
				$rec_count = "SELECT COUNT(*) FROM recommendation WHERE user_to = ".$_COOKIE["user"]." AND opened = 0;";
				if($count_result = mysqli_query($con, $rec_count)) {
					$activity_count += mysqli_fetch_array($count_result)[0];
				} else {
					echo("Count could not be performed");
					echo mysqli_error($con);
				}
				
				//display profile specific links
				echo("<a href = 'profile.php'> PROFILE </a>");
				if($activity_count == 0) {
					echo("<a href = 'activity.php'> ACTIVITY </a>");
				} else {
					echo("<a href = 'activity.php'> ACTIVITY <span class='notification'>(".$activity_count.")</span></a>");
				}
				include("scripts/db_close.php");
			}
		?>
			<a href = "people.php"> PEOPLE </a>
			<a href = "films.php"> FILMS </a>
	</div>
</body>
	
</html>
