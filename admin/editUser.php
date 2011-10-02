<?php 
require_once("../model/db.php");
require_once("../model/user.php");
?>

<h2>Edit User</h2>

<?php
	$userID = $_GET["userID"];
	if($userID == NULL)
	{
		echo "Invalid user ID: " . $userID;
		return;
	}
	$db = new DB();
	$db->open();
	
	$user = new User;
	$user->buildFromDBByID($userID);
	$user->printUserForm("userEdit","index.php?action=editUser&userID=$userID");
	
	$db->close();
?>
