<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Welcome to MovieShelf!</title>
<link rel="stylesheet" href="css/header_styles.css">
<script src="scripts/loginMessage.js"></script>
</head>
	
<body onLoad="init()">
	
	<div class = "header">
		<div class = "loginMessage" id = "loginMessage">
			<button class = "button" type="button" onClick="displayForm()">Log In</button>
		</div>
		
		<div class = "loginForm" id = "loginForm">
			<form>
				<label for="username">Username:</label>
  				<input type="text" id="username" name="username" 
				  pattern="^(?=.{8,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$" title="Enter a valid username.">
				<br>
				<label for="password">Password:</label>
  				<input type="text" id="password" name="password" 
				  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Enter a valid password.">
				<br>
				<input class="button" type="submit" value="Log In">
				<button class="button" type="button" onClick="hideForm()">Cancel</button><br>
			
				<a href="signup.php">Create an Account</a>
			</form>
		</div>
		
		<div class = "logo">
			<a href = "index.php">MovieShelf</a>
		</div>
		
	</div>
	
	<div class = "links">
			<a href = "profile.php"> PROFILE </a>
			<a href = "#activity"> ACTIVITY </a>
			<a href = "#people"> PEOPLE </a>
			<a href = "#films"> FILMS </a>
		</div>
</body>
	
</html>
