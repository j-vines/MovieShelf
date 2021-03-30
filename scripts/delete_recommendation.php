<?php
	include("db_connect.php");

	$update = "DELETE FROM recommendation WHERE idrecommendation = ".$_POST["idrecommendation"].";";
	if(!($result = mysqli_query($con, $update))) {
		echo("Delete could not be performed");
		echo mysqli_error($con);
	}

	include("db_close.php");
?>