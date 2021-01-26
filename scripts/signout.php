<?php
	session_start();
	unset($_COOKIE["user"]);
 	setcookie("user", "", time()-3600, "/"); //unset the user cookie
	header("Location: ".$_SERVER['SERVER_NAME']."~jvines/MovieShelf/"."index.php"); //redirect back to index
?>