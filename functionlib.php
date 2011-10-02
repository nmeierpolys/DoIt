<?php

	function validateElement($label,$displayName,&$errMsg,&$value)
	{
		unset($value);
		unset($errMsg);
		
		//UserID
		$value = htmlentities($_POST[$label]);
		if(is_numeric($value) && ($value > 0)){
			return TRUE;
		} else {
			$errArrMsg = $displayName . "must be an integer greater than 0";
			return FALSE;
		}
	}
	function showUsers()
	{
		$db = new DB();
		$db->open();
		$db->getAllUsers(1);
		$db->close();
	}
	function showUserGoals()
	{
		$thisUser = new User();
		$thisUser = $_SESSION["loggedInUser"];
		$thisUser->getUserGoals();
	}
	function showAllGoals()
	{
		if(!isset($_SESSION["isUserAdmin"])){
			echo 'Must be an admin to do this.';
			return;	
		}
			
		$db = new DB();
		$db->open();
		$db->getAllGoals(1);
		$db->close();
	}
	function showNewUser()
	{
		unset($_SESSION["userID"]);
		include('editUser.php');
	}
	function showNewGoal()
	{
		unset($_SESSION["goalID"]);
		include('editGoal.php');
	}
	function deleteGoal()
	{
		$db = new DB();
		$db->open();
		if(isset($_GET["goalID"]))
		{
			$db->deleteGoalByID($_GET["goalID"]);
			echo "Goal " . $_GET["goalID"] . " deleted.";
		}
		else
		{
			echo "Invalid Goal";
		}
		$db->getAllGoals(1);
		$db->close();
	}
	function editExistingGoal()
	{
		if(isset($_GET["goalID"]))
		{
			$_SESSION["goalID"]=$_GET["goalID"];
			include('editGoal.php');
			unset($_SESSION["goalID"]);
		}
		else
		{
			echo "Invalid Goal";
		}
	}
	function deleteUser()
	{
		$db = new DB();
		$db->open();
		if(isset($_GET["userID"]))
		{
			$db->deleteUserByID($_GET["userID"]);
			echo "User " . $_GET["userID"] . " deleted.";
		}
		else
		{
			echo "Invalid User";
		}
		$db->getAllUsers(1);
		$db->close();
	}
	function showPublicGoals()
	{
		$db = new DB();
		$db->open();
		$db->getPublicGoals(1);
		$db->close();
	}
	function editExistingUser()
	{
		if(isset($_GET["userID"]))
		{
			$_SESSION["userID"]=$_GET["userID"];
			include('editUser.php');
			unset($_SESSION["userID"]);
		}
		else
		{
			echo "Invalid User";
		}
	}
	function showLinks()
	{
		echo "Choose a link:<br>\n";
		echo "<a href='index.php'>Home</a><br>\n";
		echo "<a href='index.php?act=goals'>My Goals</a><br>\n";
		echo "<a href='index.php?act=newGoal'>Add a Goal</a><br>\n";
		echo "<a href='index.php?act=showPublicGoals'>Public Goals</a><br>\n";
		echo "<a href='index.php?act=about'>About</a><br>\n";
	}
	function showMenuLinks()
	{
		echo "<a href='index.php'>Home</a> |\n";
		echo "<a href='index.php?act=goals'>My Goals</a> |\n";
		echo "<a href='index.php?act=newGoal'>Add a Goal</a> |\n";
		echo "<a href='index.php?act=showPublicGoals'>Public Goals</a> |\n";
		echo "<a href='index.php?act=about'>About</a>\n";
	}
	function showContent()
	{
		if(!isset($_GET['act'])){
			echo "Welcome!";  //showLinks();
			//showIpsumLorem();
			return;
		}
		

		
		if(!isset($_SESSION['loggedInUser'])){
			//not requiring security
			switch($_GET['act']){
				case 'newUser':
					showNewUser();
					break;
				case 'contact';
					showContactInfo();
					break;
				case 'links':
					showLinks();
					break;
				case 'about':
					showAbout();
					break;
				case 'showPublicGoals':
					showPublicGoals();
					break;
				default:
					echo "Welcome - Please log in to do stuff.";
			}
		} else {
			//requiring security
			switch($_GET['act']){
				case 'users':
					showUsers();
					break;
				case 'goals':
					showUserGoals();
					break;
				case 'allGoals':
					showAllGoals();
					break;
				case 'showPublicGoals':
					showPublicGoals();
					break;
				case 'newGoal':
					showNewGoal();
					break;
				case 'editGoal':
					editExistingGoal();
					break;
				case 'deleteGoal':
					deleteGoal();
					break;
				case 'editUser':
					editExistingUser();
					break;
				case 'newUser':
					showNewUser();
					break;
				case 'deleteUser':
					deleteUser();
					break;
				case 'links':
					showLinks();
					break;
				case 'home':
					showLinks();
					break;
				case 'contact';
					showContactInfo();
					break;
				case 'links':
					showLinks();
					break;
				case 'about':
					showAbout();
					break;
				case 'dbadmin':
					dbAdmin();
					break;
				case 'login':
					break;
				default:
					echo "Welcome - Please log in to do stuff.";
					//showIpsumLorem();
			}
		}
	}
	function showContactInfo()
	{
		echo "You can't contact us.  <br><br>If you have questions, concerns, or comments, please refrain from notifying us in any way.  If however you'd like to contribute gifts, be they monetary or in the form of physical goodies, please go right on ahead.";	
	}
	function showAbout()
	{
		echo "<p>This is an awesome site for holding yourself accountable and getting things done.</p>";
		echo "<p>Bottom line?  It's time to get off your lazy ass and <i>do something</i>.  And we're here to help.</p>";
	}
	function showIpsumLorem()
	{
		echo $GLOBALS['ipsumLoremText'];
	}
	function showBanner()
	{
		echo '<img src="' . $GLOBALS['bannerPath'] . '" width="100%" height="' . $GLOBALS['bannerHeight'] . '"px">';
	}
	function showTopToolbar()
	{
		showMenuLinks();
	}
	function showFooter()
	{
		
	}
	function showTitle()
	{
		echo '<img src="' . $GLOBALS['titleImagePath'] . '">';
	}
	function showOuterFooter()
	{
		echo '&copy; 2011 Endious Corporation - ' . '<a href="index.php?act=contact">Contact Us</a>';
	}
	function showLeftBar()
	{ 
		if(isset($_GET['act'])){
			if($_GET['act'] == 'logout'){
				clearSession();
				echo '<meta http-equiv="Refresh" content="0; URL=index.php">';
			}
		}
		
		showUserLoginWidget();
		echo "<br>";
		showLinks();
	}
	function registerFormShow()
	{
		
	}
	function registerFormProcess()
	{
		
	}
	function clearSession()
	{
		unset($_SESSION["loggedInUser"]);
		session_destroy();
	}
	function showRightBar()
	{
		if(!isset($_SESSION["isUserAdmin"])){
			return;
		} else if(!$_SESSION["isUserAdmin"]){
			return;
		}
		
		echo "<div id='rightMargin'><center>";
		echo "<a href='index.php?act=users'>All Users</a><br>\n";
		echo "<a href='index.php?act=allGoals'>All Goals</a><br>\n";
		echo "<a href='index.php?act=dbadmin'>DB Admin</a><br>\n";
		echo "<br>-<br>\n";
		echo "<a href='index.php?act=dbadmin&query=Select * from User'>User Query</a><br>\n";
		echo "<a href='index.php?act=dbadmin&query=Select * from Goal'>Goal Query</a><br>\n";
		echo "</center></div>";
	}
	function showUserLoginWidget()
	{
		if(isset($_SESSION["loggedInUser"])){
			echo "Logged in as: ";
			$_SESSION["loggedInUser"]->displaySummary();
			echo "<a href='index.php?act=logout'>Log out</a><br>\n";
		} else {
			echo '<a id="loginButton" href=\'#\' onclick="popup_show(\'popup\', \'popup_drag\', \'popup_exit\', \'screen-center\', 0, 0);">Log In</a><br>';
			echo '<a href="index.php?act=newUser">Register</a><br>';
		}
	}

	function getUserFormData(&$isValidForm){
		
		//Validate input
		$isValidForm = TRUE;

		$errArr = array();
		
		//First Name
		$label = "firstName";
		$value = htmlentities($_POST[$label]);
		if(strlen($value) == 0){
			$errArr[] = "First Name is required";
			$isValidForm = FALSE;
			$validData[$label]="";
		} else {
			$validData[$label] = $value;
		}
		
		//Last Name
		$label = "lastName";
		$value = htmlentities($_POST[$label]);
		if(strlen($value) == 0){
			$errArr[] = "Last Name is required";
			$isValidForm = FALSE;
			$validData[$label]="";
		} else {
			$validData[$label] = $value;
		}
		
		//Username
		$label = "userName";
		$value = htmlentities($_POST[$label]);
		if(strlen($value) == 0){
			$errArr[] = "User Name is required";
			$isValidForm = FALSE;
			$validData[$label]="";
		} else {
			$validData[$label] = $value;
		}
		
		//Password
		$label = "password";
		$value = htmlentities($_POST[$label]);
		if(!isValidPassword($value,$errMsg)) {
			$isValidForm = FALSE;
			$errArr[] = &$errMsg;
			$validData[$label]="";
		} else {
			$validData[$label] = $value;
		}
		
		//Email
		$label = "email";
		$value = htmlentities($_POST[$label]);
		if(strlen($value) == 0){
			$errArr[] = "Email is required";
			$isValidForm = FALSE;
			$validData[$label]="";
		} else {
			$validData[$label] = $value;
		}
		
		//Icon Path
		$label = "iconPath";
		
		if ($_FILES[$label]["error"] > 0)
		{
			$validData[$label]="";
			$errArr[] = $_FILES[$label]["error"];
		} else {
			$target = "uploads/"; 
 			$target = $target . basename( $_FILES['iconPath']['name']) ; 
 			move_uploaded_file($_FILES['iconPath']['tmp_name'], $target);
			$validData[$label] = $target;
		}
		
		//Is Admin
		$label = "isAdmin";
		if(isset($_POST[$label])){
			$validData[$label] = htmlentities($_POST[$label]);
		} else {
			$validData[$label] = "";
		}
		
		if(!$isValidForm){
			echo "Validation error: ";
			
			foreach($errArr as $i => $errStr){
				echo "<br>" . $errStr . "\n";
			}
		} else {
			echo "User added.<br>\n";
		}
		return $validData;
	}
	
	function isValidPassword($testPass,&$errMsg){
		$errArr = array();
		$passLen = strlen($testPass);
		$output = TRUE;
		if(($passLen < 5) || ($passLen > 15)){
			$output = FALSE;
			$errArr[] = "Password must be between 5 and 15 characters";
		} 
		if(!preg_match("`[A-Z]`",$testPass)) {
			$output = FALSE;
			$errArr[] = "Password must have a capital letter";
		} 
		if(!preg_match("`[0-9]`",$testPass)) {
			$output = FALSE;
			$errArr[] = "Password must have a number";
		} 
		
		if(count($errArr)>0)
		{
			foreach($errArr as $i => $value)
			{
				$errMsg .= $value . ", "; 
			}
		} else {
			$errMsg = "";
		}
		return $output;
	}
	
	function getGoalFormData(&$isValidForm){
		
		//Validate input
		$isValidForm = TRUE;
		
		$errArr = array();
		
		//Name
		$label = "name";
		$value = htmlentities($_POST[$label]);
		if(strlen($value) == 0){
			$errArr[] = "Name is required";
			$isValidForm = FALSE;
			$validData[$label]="";
		} else {
			$validData[$label] = $value;
		}
		
		//Description
		$label = "description";
		$value = htmlentities($_POST[$label]);
		if(strlen($value) == 0){
			$errArr[] = "Description is required";
			$isValidForm = FALSE;
			$validData[$label]="";
		} else {
			$validData[$label] = $value;
		}
		
		//Due Date
		$label = "dueDate";
		$value = htmlentities($_POST[$label]);
		if(strlen($value) == 0){
			$errArr[] = "Due date is required";
			$isValidForm = FALSE;
			$validData[$label]="";
		} else {
			$validData[$label] = $value;
		}
		
		//Icon Path
		$label = "iconPath";
		if (!isset($_FILES[$label])){
			$validData[$label]="";
			$errArr[] = "File path not set";					
		} else if ($_FILES[$label]["error"] > 0){
			$validData[$label]="";
			$errArr[] = $_FILES[$label]["error"];
		} else {
			$target = "uploads/"; 
			$target = $target . basename( $_FILES['iconPath']['name']) ; 
			move_uploaded_file($_FILES['iconPath']['tmp_name'], $target);
			$validData[$label] = $target;
		}
		
		//Is Public
		$label = "isPublic";
		if(isset($_POST[$label])){
			$validData[$label] = htmlentities($_POST[$label]);
		} else {
			$validData[$label] = "";
		}
			
		if(!$isValidForm){
			echo "Validation error: ";
			
			foreach($errArr as $i => $errStr){
				echo "<br>" . $errStr . "\n";
			}
		} 
		return $validData;
	}
	function getUserLoggedIn()
	{	
		if(!isUserIPAllowed($GLOBALS['safeIPs'])) 
		{ 
			if(isset($_POST["username"]) && isset($_POST["password"])){		
				//Check admin
				$db = new DB;
				$db->open();
				$loggedIn = $db->getUserLoggedIn($_POST["username"],$_POST["password"]);
				if($loggedIn)
				{
					if($_POST["username"] == $GLOBALS["adminUser"])
					{
						$_SESSION["isUserAdmin"]=TRUE;
					}
				} else {
					$_SESSION["popLogin"] = TRUE;
				}
			}
			
			if(!isset($_SESSION["loggedInUser"])){
				echo '
				<!-- ***** Form ************************************************************ -->
				<!-- ***** Popup Window **************************************************** -->
				
				<div class="sample_popup" id="popup" style="display: none;">
				
				<div class="menu_form_header" id="popup_drag">
				&nbsp;&nbsp;&nbsp;Log in here
				</div>
				
				<div class="menu_form_body">
				<form action="index.php" method="post">
				<table>
				  <tr><th>Username:</th><td><input class="field" type="text" onfocus="select();" name="username" /></td></tr>
				  <tr><th>Password:</th><td><input class="field" type="password" onFocus="select();" name="password" /></td></tr>
				  <tr><th>         </th><td><input class="btn" type="submit" value="Submit" /></td></tr>
				</table>
				Or <a href="index.php?act=newUser">register here</a>
				</form>
				</div>
				</div>';
			}
		}	
	}
	
	function dbAdmin()
	{
		if(!isset($_SESSION["isUserAdmin"]))
		{
			echo "Must be logged in as an admin";
			exit;
		}
		
		$query = "";
		if($_SERVER['REQUEST_METHOD'] == "GET")
		{
			if(isset($_GET["query"]))
			{
				$query=$_GET["query"];
			}
		}
		//Form submitted - validate and handle entered data
		if($_SERVER['REQUEST_METHOD'] == "POST")
		{
			if(isset($_POST["query"]))
			{
				$query=$_POST["query"];
			}
		}
		echo '<form name="sqlEntry" method="post" action="">
			<table>
			<tr>
			<td width="10%" valign="top">SQL to execute:</td>
			<td><textarea name="query" id="query" cols="85" rows="5">' . $query . '</textarea></td>
			</tr>
			<tr>
			<td></td>
			<td><input type="submit" name="submit" id="submit" value="Submit"></td>
			</tr>
			</table>
			</form>';
	
		if($query != "")
		{
			echo '<div id="dbadmin">';
			//execute code
			echo "<b>Result: </b><br>\n";
			$db = new DB();
			$db->open();
			$db->executeCommand($query);
			$db->close();
			echo '</div>';
		}
	}
	
	function isUserIPAllowed($safeList)
	{	
		return 0;
		$ipOkay=FALSE;
		$userIP=$_SERVER["REMOTE_ADDR"];
		foreach($safeList as $i => $ipAddr) {
			if(!strcmp($userIP,$ipAddr)){
				$ipOkay=TRUE;
			}
		}
		if(!$ipOkay){
			if(isset($_SESSION["loggedInUser"]))
			{
				$ipOkay=TRUE;	
			}
		} 
		else
		{
			$_SESSION["isUserAdmin"]=TRUE;
			$_SESSION["loggedInUser"]= new User;
		}
		return $ipOkay;
	}
	function startSession()
	{
		if (!defined("SESSIONSTARTED")) {
    		session_start();
			define("SESSIONSTARTED", 1);
  		}
	}
	function saveFile($path)
	{
		
	}
	
	function beforeRunFunctions()
	{
		startSession();
		
		$_SESSION["landingPage"]=$_SERVER["REQUEST_URI"];
		$_SESSION["landingPageBase"]=$_SERVER["PHP_SELF"];
	
		getUserLoggedIn();
		
		if(!isset($_SESSION["loggedInUser"]))
		{
			return 0;
		}
		
		//Good to do this for testing - probably should be done more formally later.
		
		return 0;
	}
?>