<?php 
require_once("../model/db.php");
?>
<h2>All Users</h2>
<?php
	$db = new DB();
	$db->open();
	
	$summary=1;
	
	if(isset($_GET["showAll"])){
		if($_GET["showAll"]==1){
			$summary=0;
		}
	}
	$db->getAllUsers($summary);
	$db->close();
?>