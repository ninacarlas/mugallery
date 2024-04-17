<?php 

require_once("../login/classes/Login.php");

$login = new Login();

if ($login->isUserLoggedIn() == true) {
	include("../includes/header.php");
	echo "<p> Logged in as " .  $_SESSION['user_name'] . "- ID is ". $_SESSION['user_id'] . "</p>";

	$author_id = $_SESSION['user_id'];

} else {
	header("Location:../login/index.php");
}


include("../includes/mysql_connect.php");


	$pageid = $_GET['id'];

	if(!is_numeric($pageid)){
		header("Location: edit.php");
	}

	
	//DELETE RECORD FROM DB
	mysqli_query($con, "DELETE FROM communitygallery WHERE id = '$pageid'") or die(mysqli_error($con));

	// GO BACK TO EDIT
	header("Location: edit.php");
 ?>