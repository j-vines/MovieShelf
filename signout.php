<?php
/*  MovieShelf
	Jack Vines
	2020 - 2021
*/

/* Sign out of account by unsetting user cookie */
	session_start();
	unset($_COOKIE["user"]);
 	setcookie("user", "", time()-3600, "/"); //unset the user cookie
	header("Location: index.php"); //redirect back to index
?>