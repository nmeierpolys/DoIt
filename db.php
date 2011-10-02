<?php
require_once('config.php');
require_once('user.php');
require_once("goal.php");
require_once('functionlib.php');

class DB
{
	function __construct(){
		$this->dbuser = $GLOBALS["dbuser"];
		$this->dbhost = $GLOBALS["dbhost"];
		$this->dbpass = $GLOBALS["dbpass"];
		$this->dbdatabase = $GLOBALS["dbdatabase"];
		$this->usertable = $GLOBALS["usertable"];
		$this->goaltable = $GLOBALS["goaltable"];
	}
	
	//GENERAL DB OPERATIONS
	function open(){
		//open db connection
		mysql_connect($this->dbhost,$this->dbuser,$this->dbpass);
		
		//select db
		@mysql_select_db($this->dbdatabase) or die( "Unable to select database");
	}
	function close(){
		//close db connection
		mysql_close();
	}
	function query($querystr = ''){
	//user query
	if($querystr != '')
		{
			return mysql_query($querystr);
		}else{
			return "error: no query";
		}
	}
	
	//Generic command execution
	function executeCommand($query)
	{
		$sqlresult = mysql_query($query);	
		
		$row=mysql_fetch_array($sqlresult,MYSQL_ASSOC);
		echo "<table border=1>\n<tr>\n";
		
		foreach($row as $key => $value)
		{
			echo "<th>" . $key . "</th>\n";
		}
		echo "</tr>\n";
		mysql_data_seek ($sqlresult, 0);
		while($row=mysql_fetch_array($sqlresult,MYSQL_ASSOC)){
			echo "<tr>\n";
			foreach($row as $key => $value)
			{
				echo "<td>" . $value . "</td>\n";
			}
			echo "</tr>\n";
		}
		echo "</table>";
	}
	//USER OPERATIONS
	function getAllUsers($viewType = null)
	{
		$query = "SELECT * FROM ". $this->usertable . " WHERE 1";
		$sqlresult = mysql_query($query);

		//display results
		$resultsize = mysql_num_rows($sqlresult);
		$i=0;

		while($i<$resultsize){
			$id = mysql_result($sqlresult,$i,"id");
			$username = mysql_result($sqlresult,$i,"id");
			$user= new User;
			if($user->buildFromDBByID(intval($id)) == -1) { break; };
			
			switch ($viewType){
				case 1:
					$user->displaySummary(TRUE);
					break;
				default:
					$user->display();
					echo "<hr>";
			}
			$i++;
		}
	}
	function userList($filter = null)
	{
		$query = "SELECT * FROM ". $this->usertable . " WHERE 1";
		$sqlresult = mysql_query($query);

		//display results
		$resultsize = mysql_num_rows($sqlresult);
		$i=0;
		echo '<select>' . '\n';
		while($i<$resultsize){
			$id = mysql_result($sqlresult,$i,"id");
			$userName = mysql_result($sqlresult,$i,"userName");
			$i++;
			
			echo '<option value="' . $id . '">' . $userName . '</option>\n';
			
		}	
		echo '</select>' . "\n";
	}
	
	
	//GOAL OPERATIONS
	function getAllGoals($viewType = null,$where = null)
	{
		if($where == null)
		{
			$where = "WHERE 1";
		}
		
		$query = "SELECT * FROM ". $this->goaltable . " " . $where;
		$sqlresult = mysql_query($query);
		if (!$sqlresult) {
    		die('Invalid query: ' . mysql_error());
		}
		//display results
		$resultsize = mysql_num_rows($sqlresult);
		$i=0;
		if($resultsize == 0){
			echo "You haven't made any goals yet.<br>\n";
			echo "<a href='index.php?act=newGoal'>Get on it</a>\n";
		}
		while($i<$resultsize){
			$id = mysql_result($sqlresult,$i,"id");
			$goal= new Goal;
			if($goal->buildFromDBByID(intval($id)) == -1) { break; };
			
			switch ($viewType){
				case 1:
					$goal->displaySummary(isset($_SESSION["isUserAdmin"]));
					break;
				default:
					$goal->display();
					echo "<hr>";
			}
			$i++;
		}
	}
	function getPublicGoals($viewType = null)
	{
		$where = "WHERE isPublic = 1";
		$this->getAllGoals($viewType,$where);
	}
	
	function getUserLoggedIn($username,$password)
	{
		$query = "SELECT * FROM ". $this->usertable . " WHERE userName='". $username ."' AND password='". $password ."'";
		$sqlresult = mysql_query($query);
		if(mysql_num_rows($sqlresult) != 0) // true if >0 results
		{
			$loggedInUser = new User;
			$loggedInUserId = mysql_result($sqlresult,0,"id");
			$loggedInUser->buildFromDBByID($loggedInUserId);
			$_SESSION["loggedInUser"]=$loggedInUser;
			return true;
		}else{
			return false;
		}
	}
	function deleteAllUsers()
	{
		$query = "DELETE FROM ". $this->usertable ." WHERE 1";
		mysql_query($query);
	}
	function deleteUserByID($id)
	{
		$query = "DELETE FROM ". $this->usertable ." WHERE id='". $id ."'";
		mysql_query($query);
	}
	function deleteUserByScreenName($userscreen_name)
	{
		$query = "DELETE FROM ". $this->usertable ." WHERE userscreen_name='". $userscreen_name ."'";
		mysql_query($query);
	}	
	function deleteGoalByID($id)
	{
		$query = "DELETE FROM ". $this->goaltable ." WHERE id='". $id ."'";
		mysql_query($query);
	}
}


