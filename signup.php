<?php
	session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Welcome to MovieShelf!</title>
<link rel="stylesheet" href="css/signup_styles.css">
</head>

<body>
	<div class = "sign-in">
		<h2>Sign up for MovieShelf!</h2>
		<form action="create_account.php" method="post">
			<p>
				<label for="email">Email:</label>
				<input type="text" id="email" name="email" 
				   pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Enter a valid email.">
			</p>
			<p>
				<label for="username">Username:</label>
  				<input type="text" id="username" name="username" 
				   pattern="^(?=.{8,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$" title="Enter a valid username.">
			</p>
			<p>
				<label for="password">Password:</label>
  				<input type="text" id="password" name="password" 
				   pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Enter a valid password.">
			</p>
			
			
  			<input type="submit" value="Submit">
		</form>
	</div>
</body>
</html>