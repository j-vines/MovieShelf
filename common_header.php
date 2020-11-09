<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Welcome to MovieShelf!</title>
<link rel="stylesheet" href="css/header_styles.css">
<script src="scripts/loginMessage.js"></script>
</head>
	
<body onLoad="init()">
	<div class = "loginMessage" id = "loginMessage">
		<button class = "loginButton" type="button" onClick="displayForm()">Log In</button>
	</div>
	<div class = "loginForm" id = "loginForm">
		<form>
			<label for="username">Username:</label>
  			<input type="text" id="username" name="username" 
				  pattern="^(?=.{8,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$" title="Enter a valid username.">
			<label for="password">Password:</label>
  			<input type="text" id="password" name="password" 
				  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Enter a valid password.">
			<input type="submit" value="Submit">
			<button type="button" onClick="hideForm()">Cancel</button><br>
			
			<a href="signup.php">Create an Account</a>
		</form>
	</div>
	<div class = "header">
		<div class = "logo">
			<a href = "index.php">MovieShelf</a>
		</div>
		
		<div class = "links">
			<a href = "profile.php"> Profile </a>
			<a href = "#activity"> Activity </a>
			<a href = "#people"> People </a>
			<a href = "#films"> Films </a>
		</div>
	</div>
</body>
	
</html>
