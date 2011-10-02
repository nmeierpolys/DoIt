<?php
	require_once('db.php');
	require_once('user.php');
	
	if(beforeRunFunctions()) { exit; }
	
	//Check safelist
	//if(!isUserIPAllowed($safeIPs)) { return; }
	
	$outData = array("firstName" => "","lastName" => "","password" => "","userName" => "","email" => "","iconPath" => "");
	
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		$outData = getUserFormData($formIsValid);
		if($formIsValid)
		{
			
			
			$newUser = new User;
			$newUser->nameFirst=$outData['firstName'];
			$newUser->nameLast=$outData['lastName'];
			$newUser->password=$outData['password'];
			$newUser->screenName=$outData['userName'];
			$newUser->email=$outData['email'];
			$newUser->iconPath=$outData['iconPath'];
			$newUser->token="";
			$newUser->dateAdded=date('c');
			$newUser->status="";
			$newUser->isAdmin=$outData['isAdmin'];
			
			$_SESSION["loggedInUser"] = $newUser;			
			
			$db = new DB();
			$db->open();
			$newUser->insertUser();
			$db->close();
			
			echo '<meta http-equiv="Refresh" content="0; URL=index.php?act=users">';
			
			exit;
		}
	}
	elseif(isset($_SESSION["userID"]))
	{
		$db = new DB();
		$db->open();
		$existingUser = new User;
		$existingUser->buildFromDBByID($_SESSION["userID"]);
		$outData["firstName"] = $existingUser->nameFirst;
		$outData["lastName"] = $existingUser->nameLast;
		$outData["password"] = $existingUser->password;
		$outData["userName"] = $existingUser->userName;
		$outData["email"] = $existingUser->email;
		$outData["iconPath"] = $existingUser->iconPath;
		$outData["isAdmin"] = $existingUser->isAdmin;
		$db->close();
	}
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>

<?php
echo '
<!---Form layout and entry HTML goes here--->
<center>
<h3>Register, damn it.</h3>
<form id="submitUserEdit" enctype="multipart/form-data" name="submitUserEdit" method="post" action="' . $_SESSION["landingPage"] . '">
<table>
  <tr>
    <th align="left" scope="row">First Name</th>
    <td align="left"><input name="firstName" type="text" id="firstName" value="' . $outData["firstName"] . '" size="40" /></td>
  </tr>
  <tr>
    <th align="left" scope="row">Last Name</th>
    <td align="left"><input name="lastName" type="text" id="lastName" value="' . $outData["lastName"] . '" size="40" /></td>
  </tr>
  <tr>
    <th align="left" scope="row">Username</th>
    <td align="left"><input name="userName" type="text" id="userName" value="' . $outData["userName"] . '" size="40" /></td>
  </tr>
  <tr>
    <th align="left" scope="row">Password</th>

    <td align="left"><input name="password" type="password" id="password" value="' . $outData["password"] . '" size="40" /></td>
  </tr>
  <tr>
    <th align="left" scope="row">Email</th>
    <td align="left"><input name="email" type="text" id="email" value="' . $outData["email"] . '" size="40" /></td>
  </tr>
  <tr>
    <th align="left" scope="row">Icon Path</th>
    <td align="left"><input name="iconPath" type="file" id="iconPath" size="40" /><br>' . $outData["iconPath"] . '</td>
  </tr>
  <tr>
    <th></th>
    <td align="center"><button name="submit">Submit</button></td>
  </tr>
</table>
</form>
</center>

</body>
</html>';
?>