<?php
	require_once('db.php');
	require_once('functionlib.php');
	startSession();	
	if(isset($_SESSION["popLogin"])){
		echo '<script> popup_show(); </script>';	
	}
		
?>

<?php 
	include('header.php'); 
	if(beforeRunFunctions()) { exit; };
?>

<body>
	<a id="loginButton" href="#">Log In</a>
	<div id="test"></div>
</body>
</html>
	