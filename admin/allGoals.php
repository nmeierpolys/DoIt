<?php 
require_once("../db.php");

	session_start();
	
	getUserLoggedIn();
	
	if(!isset($_SESSION["loggedInUser"])){
		exit;
	}
?>
<h2>All Goals</h2>

<?php
	$db = new DB();
	$db->open();
	$summary=1;
	
	if(isset($_GET["showAll"])){
		if($_GET["showAll"]==1){
			$summary=0;
		}
	}
	$db->getAllGoals($summary,"WHERE userID=7");
	$db->close();
?>