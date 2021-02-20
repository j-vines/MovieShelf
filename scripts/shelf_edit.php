<?php
	include("db_connect.php");

	if(isset($_POST["create"])) {
		createShelf($con, $_POST["shelfName"], $_POST["shelfDesc"]);
	}
	if(isset($_POST["delete"])) {
		deleteShelf($con, $_POST["shelf"]);
	}

	
	/* Create shelf with provided name and description */
	function createShelf($con, $shelfName, $shelfDesc) {
		$shelf_insert = "INSERT INTO shelf (shelf_user, `name`, `desc`) VALUES (".$_COOKIE["user"].", '".$shelfName."', '".$shelfDesc."');";
		if(!($shelf_insert_result = mysqli_query($con, $shelf_insert))) {
			echo("Shelf could not be created.");
			echo mysqli_error($con);
		}
	}

	/* Delete shelf with provided ID */
	function deleteShelf($con, $shelf) {
		//first delete entries in filmshelf table
		$shelf_delete = "DELETE FROM filmshelf WHERE filmshelf_shelf = ".$shelf.";";
		if(!($shelf_delete_result = mysqli_query($con, $shelf_delete))) {
			echo("Shelf entries in filmshelf could not be deleted.");
			echo mysqli_error($con);
		}
		
		//now delete from shelf table
		$shelf_delete = "DELETE FROM shelf WHERE idshelf = ".$shelf.";";
		if(!($shelf_delete_result = mysqli_query($con, $shelf_delete))) {
			echo("Shelf could not be deleted.");
			echo mysqli_error($con);
		}
	}

	include("db_close.php");
	header("Location: ../profile.php");
	
?>