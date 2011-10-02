<?php
	require_once('../db.php');
	require_once('../functionlib.php');
	
	startSession();
	
	//Check admin
	$db = new DB;
	$db->open();
	$loggedIn = $db->getUserLoggedIn("admin","stevenrocks");
	if($loggedIn)
	{
		header("location: ../index.php"); 
		
		if($_POST["username"] == $adminUser)
		{
			$_SESSION["isUserAdmin"]=TRUE;
		}		
	}
?>