<?php
	include("db_connect.php");

	$update = "UPDATE recommendation SET opened = 1 WHERE idrecommendation = ".$_POST["idrecommendation"].";";
	if(!($result = mysqli_query($con, $update))) {
		echo("Update could not be performed");
		echo mysqli_error($con);
	}

	include("db_close.php");
?>