<?php
	require_once('../model/db.php');
	require_once('../functionlib.php'); 
	if(!isUserIPAllowed($safeIPs)) { 
		echo 'User IP is disallowed.';
		return; 
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DoIt Admin Interface</title>
</head>

<body>
<?php
$rootURL = "index.php";
echo "<h2>DoIt Admin Interface</h2>" . "\n";

echo "<a href='". $rootURL . "?action=allGoals'>Show all goals</a><br>" . "\n";

echo "<a href='". $rootURL . "?action=allUsers'>Show all users</a><br>" . "\n";

echo "<a href='". $rootURL . "?action=editGoal'>Edit goal</a><br>" . "\n";

echo "<a href='". $rootURL . "?action=editUser'>Edit user</a><br>" . "\n";

switch ($_GET["action"]){
	case "allGoals":
		include("allGoals.php");
		break;
	case "allUsers":
		include("allUsers.php");
		break;
	case "editGoal":
		include("editGoal.php");
		break;
	case "editUser":
		include("editUser.php");
		break;
	case "deleteUser":
		include("deleteUser.php");
		break;
}
?>
</body>
</html>