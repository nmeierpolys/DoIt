<?php
	require_once('db.php');
	require_once('goal.php');

	if(beforeRunFunctions()) { exit; }
	
	//Check safelist
	//if(!isUserIPAllowed($safeIPs)) { return; }
	$outData = array("name" => "",'description' => "",'dueDate' => "",'iconPath' => "",'isPublic' => "");
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		$outData = getGoalFormData($formIsValid);
		if($formIsValid)
		{
			if(isset($_SESSION["loggedInUser"])){
				$loggedInUser = $_SESSION["loggedInUser"];
				if($loggedInUser->id <> 0){
					$loggedInUserID = $loggedInUser->id;
				}
			}
			$newGoal = new Goal;
			$newGoal->name=$outData['name'];
			$newGoal->description=$outData['description'];
			$newGoal->dueDate=date( 'Y-m-d H:i:s', strtotime($outData['dueDate']));
			$newGoal->createdDate=date('c');
			$newGoal->iconPath=$outData['iconPath'];
			$newGoal->isPublic=$outData['isPublic'];
			$newGoal->source="";
			$newGoal->status="";
			$newGoal->userID=$loggedInUserID;
			$newGoal->display();
			$db = new DB();
			$db->open();
			$newGoal->insertGoal();
			$db->close();
			$loggedInUser->getUserGoals();
			exit;
		}
	}
	elseif(isset($_SESSION["goalID"]))
	{
		$db = new DB();
		$db->open();
		$existingGoal = new Goal;
		$existingGoal->buildFromDBByID($_SESSION["goalID"]);
		$outData["name"] = $existingGoal->name;
		$outData["description"] = $existingGoal->description;
		$outData["dueDate"] = $existingGoal->dueDate;
		$outData["iconPath"] = $existingGoal->iconPath;
		$outData["isPublic"] = $existingGoal->isPublic;
		$db->close();
	}
	
?>

<?php
echo '
<!---Form layout and entry HTML goes here--->
<script>
	$(function() {
		$( "#dueDate" ).datepicker();
	});
</script>
<center>
<form id="submitGoalEdit" name="submitGoalEdit" enctype="multipart/form-data" method="post" action="' . $_SESSION["landingPage"] . '">
<table>
  <tr>
    <th align="left" scope="row">Name</th>
    <td align="left"><input name="name" type="text" id="name" value="' . $outData["name"] . '" size="45" /></td>
  </tr>
  <tr>
    <th align="left" scope="row">Description</th>
    <td align="left"><input name="description" type="text" id="description" value="' . $outData["description"] . '" size="45" /></td>
  </tr>
  <tr>
    <th align="left" scope="row">Due Date</th>
    <td align="left"><input name="dueDate" type="text" id="dueDate" size="45" value="' . $outData["dueDate"] . '"/></td>
  </tr>
  <tr>
  	<td colspan=2><div id="datepicker"></div></td>
  </tr>
  <tr>
    <th align="left" scope="row">Icon Path</th>
    <td align="left"><input name="iconPath" type="file" id="iconPath" size="45" /><br>' . $outData["iconPath"] . '</td>
  </tr>
  <tr>
	<th align="left" scope="row">Make Public?</th>
	<td><input type="checkbox" name="isPublic" value="1" ';
	if(isset($outData["isPublic"])){
		if($outData["isPublic"]){
		echo 'checked="true"';
		}
	}
	echo '"/></td>
  </tr>  
  <tr>
    <th></th>
    <td align="center"><button name="submit">Submit</button></td>
  </tr>
</table>
</form>
</center>';
?>