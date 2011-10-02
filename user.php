<?php
require_once("config.php");
class User
{
	public $dbhost;
	public $dbuser;
	public $dbpass;
	public $dbdatabase;
	public $usertable;
	
	public $id = 0;
	public $nameFirst;
	public $nameLast;
	public $userName;
	public $password;
	public $email;
	public $dateAdded;
	public $iconPath;
	public $status;
	public $token;
	public $isAdmin;
	
	function display($includeAdmin = FALSE){
		
		if(strcmp($this->iconPath,""))
		{
			$imgPath=$this->iconPath;
		} else {
			$imgPath=$GLOBALS['userIconDefault'];
		}
		
		echo "<table><tr><td valign='top'><img width='" . $GLOBALS['userIconWidth'] ."' src='". $imgPath ."'></td>\n";
		echo "<td>";
		if($includeAdmin){
			echo "ID: ". $this->id . "<br>\n";
		}
		echo "Name: ". $this->nameFirst . " " . $this->nameLast . "\n";
		echo "<br>Screen Name: ". $this->userName . "\n";
		if($includeAdmin){
			echo "<br>Password: ". $this->password . "\n";
		}
		echo "<br>Email: ". $this->email . "\n";
		if($includeAdmin){
			echo "<br>Date Added: ". $this->dateAdded . "\n";
			echo "<br>Status: ". $this->status . "\n";
			echo "<br>Token: ". $this->token . "\n";
			echo "<br>Admin: ". $this->isAdmin . "\n";
		}
		echo "</td></tr></table>";
	}
	
	function displaySummary($showEditLinks = NULL){
		
		if(strcmp($this->iconPath,""))
		{
			$imgPath=$this->iconPath;
		} else {
			$imgPath=$GLOBALS['userIconDefault'];
		}
		
		echo "<table><tr><td valign='top'><img height='30px' width='30px' src='". $imgPath ."'></td>\n";
		echo "<td>" . $this->nameFirst . " " . $this->nameLast . "</td>\n";
		if($showEditLinks)
		{
			echo "<td>" . " <a href='index.php?act=editUser&userID=" . $this->id . "'>(edit)</a></td>\n";
			echo "<td>" . " | <a href='index.php?act=deleteUser&userID=" . $this->id . "'>(delete)</a></td>\n";
		}
		echo "</tr></table>";
	}
	
	//Helper for passing through the list of arguments to constructors
	public function __call($name, $arg){
        return call_user_func_array(array($this, $name), $arg);
    }
	
	//base constructor splits to several based on number of arguments
	function __construct(){
		$this->dbuser = $GLOBALS["dbuser"];
		$this->dbhost = $GLOBALS["dbhost"];
		$this->dbpass = $GLOBALS["dbpass"];
		$this->dbdatabase = $GLOBALS["dbdatabase"];
		$this->usertable = $GLOBALS["usertable"];
		
		$num = func_num_args();
		$args = func_get_args();
		if($num == 0){
			$this->setDataNull();
		}
		else{
			$this->__call('__setDataRes', $args);
		}		
	}
	
	//Empty constructor logic
	function setDataNull(){
		$this->id = NULL;
		$this->nameFirst = NULL;
		$this->nameLast = NULL;
		$this->userName = NULL;
		$this->password = NULL;
		$this->email = NULL;
		$this->dateAdded = NULL;
		$this->iconPath = NULL;
		$this->status = NULL;
		$this->token = NULL;
		$this->isAdmin = NULL;
	}
	
	//Populated constructor logic
	//function setDataRes($res){

		//foreach ($res as $element){
    	//$this->$element = $res->$element;
		//}
		
		//$this->id = $res->id;
		//$this->nameFirst = $res->nameFirst;
		//$this->nameLast = $res->nameLast;
		//$this->userName = $res->userName;
		//$this->password = NULL;
		//$this->icon = $res->icon;
		//$this->email = $res->email;
		//$this->dateAdded = $res->dateAdded;
		//$this->status = $res->status;
		//$this->token = $res->token;
	//}
	function buildFromDB($where)
	{		
		if(!(strcmp($where,""))) { return -1; }
		$query = "SELECT * FROM ". $this->usertable . " " . $where;
		
		$sqlresult = mysql_query($query);
		
		if(mysql_num_rows($sqlresult) == 0){ return -1; }
		
		$this->setData($sqlresult,0);	
		return 1;
	}
	
	function buildFromDBByScreenName($screenName)
	{
		$where="WHERE userName='". $screenName ."'";
		return $this->buildFromDB($where);
	}
	
	function buildFromDBByID($id)
	{
		$where="WHERE id='". $id ."'";
		return $this->buildFromDB($where);
	
	}
	function setData($sqlresult,$row)
	{
		$this->id = mysql_result($sqlresult,$row,"id");
		$this->nameFirst = mysql_result($sqlresult,$row,"NameFirst");
		$this->nameLast = mysql_result($sqlresult,$row,"NameLast");
		$this->userName = mysql_result($sqlresult,$row,"userName");
		$this->password = mysql_result($sqlresult,$row,"password");
		$this->email = mysql_result($sqlresult,$row,"email");
		$this->dateAdded = mysql_result($sqlresult,$row,"dateAdded");
		$this->iconPath = mysql_result($sqlresult,$row,"iconPath");
		$this->status = mysql_result($sqlresult,$row,"status");
		$this->token = mysql_result($sqlresult,$row,"token");
		$this->isAdmin = mysql_result($sqlresult,$row,"isAdmin");
	}
	
	function insertUser()
	{
		if(!isset($_SESSION["userID"]))
		{
			//Insert
			$query = "INSERT INTO ". $this->usertable . " VALUES ('".
			$this->id ."','".
			$this->nameFirst ."','".
			$this->nameLast ."','". 
			$this->screenName ."','".
			$this->password ."','".
			$this->email ."','".
			date( 'Y-m-d H:i:s', strtotime($this->dateAdded)) ."','".
			$this->iconPath ."','".
			$this->status ."','".
			$this->token ."','".
			$this->isAdmin ."')";
			mysql_query($query);
		}
		else
		{
			//Update
			$query = "UPDATE " . $this->usertable . " SET nameFirst='" . $this->nameFirst . "'," .
			" nameLast='" . $this->nameLast . "'," .
			" userName='" . $this->screenName . "'," .
			" email='" . $this->email . "'," .
			" password='" . $this->password . "'," .
			" iconPath='" . $this->iconPath . "'," .
			" isAdmin='" . $this->isAdmin . "'" .
			" WHERE id='" . $_SESSION["userID"] ."'";
			mysql_query($query);
		}
	}
	function getUserGoals($limit = NULL)
	{
		$where = "WHERE userID = '" . $this->id . "'";
		if($limit <> NULL)
		{
			$where = $where . " LIMIT " . $limit;
		}
		$db = new DB();
		$db->open();
		$db->getAllGoals(1,$where);
		$db->close();
	}
	
	function printUserForm($formID, $destinationURL)
	{
		echo '
		<!---Form layout and entry HTML goes here--->
		<center>
		<form id="' . $formID . '" name="' . $formID . '" method="post" action="' . $destinationURL . '">
		<table width="401" height="400" border="0">
		  <tr>
			<th width="154" align="left" scope="row">ID</th>
			<td width="237" align="left"><input name="userID" type="text" id="userID" value="' . $this->id . '" size="40" />
			</td>
		  </tr>
		  <tr>
			<th align="left" scope="row">First Name</th>
			<td align="left"><input name="firstName" type="text" id="firstName" value="' . $this->nameFirst . '" size="40" /></td>
		  </tr>
		  <tr>
			<th align="left" scope="row">Last Name</th>
			<td align="left"><input name="lastName" type="text" id="lastName" value="' . $this->nameLast . '" size="40" /></td>
		  </tr>
		  <tr>
			<th align="left" scope="row">Username</th>
			<td align="left"><input name="userName" type="text" id="userName" value="' . $this->userName . '" size="40" /></td>
		  </tr>
		  <tr>
			<th align="left" scope="row">Password</th>
		
			<td align="left"><input name="password" type="text" id="password" value="' . $this->password . '" size="40" /></td>
		  </tr>
		  <tr>
			<th align="left" scope="row">Email</th>
			<td align="left"><input name="email" type="text" id="email" value="' . $this->email . '" size="40" /></td>
		  </tr>
		  <tr>
			<th align="left" scope="row">Date Added</th>
			<td align="left"><input name="dateAdded" type="text" id="dateAdded" value="' . $this->dateAdded . '" size="40" /></td>
		  </tr>
		  <tr>
			<th align="left" scope="row">Icon Path</th>
			<td align="left"><input name="iconPath" type="text" id="iconPath" value="' . $this->iconPath . '" size="40" /></td>
		  </tr>
		  <tr>
			<th align="left" scope="row">Status</th>
			<td align="left"><input name="status" type="text" id="status" value="' . $this->status . '" size="40" /></td>
		  </tr>
		  <tr>
			<th align="left" scope="row">Token</th>
			<td align="left"><input name="token" type="text" id="token" value="' . $this->token . '" size="40" /></td>
		  </tr>
		  <tr>
			<th align="left" scope="row">Admin?</th>
			<td><input type="checkbox" name="isAdmin" value="1" /></td>
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
	}
}
?>
