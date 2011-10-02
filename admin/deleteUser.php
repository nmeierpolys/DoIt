<?php 
require_once("../db.php");
require_once("../user.php");
?>

<h2>Delete User</h2>

<?php
	$userID = $_GET["userID"];
	if($userID == NULL)
	{
		echo "Invalid user ID: " . $userID;
		return;
	}
	$db = new DB();
	$db->open();
	if(FALSE)
	{
		$db->deleteUserByID($userID);	
		echo "User " . $userID . " deleted successfully.";
	} else {
		echo "User " . $userID . " not deleted.";
	}
	$db->close();
?>
