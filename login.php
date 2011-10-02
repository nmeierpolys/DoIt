<?php
	exit;
	require_once('db.php');
	require_once('functionlib.php');
	
	startSession();
	
	if(isset($_POST["username"]) && isset($_POST["password"])){		
		//Check admin
		$db = new DB;
		$db->open();
		$loggedIn = $db->getUserLoggedIn($_POST["username"],$_POST["password"]);
		if($loggedIn)
		{
			if(isset($_SESSION["landingPage"]))
			{
				header("location: " . $_SESSION["landingPage"]); 
			}
			
			if($_POST["username"] == $adminUser)
			{
				$_SESSION["isUserAdmin"]=TRUE;
			}
		}
	}
	$showprompt=0;
	if(!isset($_SESSION["loggedInUser"])){
	  $showprompt=1;
	}
	if($showprompt){				  
?>
<button name="button" onClick="popup_show('popup', 'popup_drag', 'popup_exit', 'screen-center',         0,   0);" />

<!-- ***** Form ************************************************************ -->

<!-- ***** Popup Window **************************************************** -->



<div class="sample_popup"     id="test" style="display: none;">

<div class="menu_form_header" id="popup_drag">
&nbsp;&nbsp;&nbsp;Login
</div>

<div class="menu_form_body">
<form action="login.php" method="post">
<table>
  <tr><th>Username:</th><td><input class="field" type="text"     onfocus="select();" name="username" /></td></tr>
  <tr><th>Password:</th><td><input class="field" type="password" onFocus="select();" name="password" /></td></tr>
  <tr><th>         </th><td><input class="btn"   type="submit"   value="Submit" /></td></tr>
</table>
</form>
</div>
</div>
<?php
}
?>