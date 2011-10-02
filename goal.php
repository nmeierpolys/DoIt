<?php

class Goal
{
	
	public $dbhost;
	public $dbuser;
	public $dbpass;
	public $dbdatabase;
	public $goaltable;
	
	public $id;
	public $name;
	public $description;
	public $createdDate;
	public $dueDate;
	public $iconPath;
	public $isPublic;
	public $source;
	public $status;
	public $userID;
	
	//base constructor <will> splits to several based on number of arguments
	function __construct(){
		$this->dbuser = $GLOBALS["dbuser"];
		$this->dbhost = $GLOBALS["dbhost"];
		$this->dbpass = $GLOBALS["dbpass"];
		$this->dbdatabase = $GLOBALS["dbdatabase"];
		$this->goaltable = $GLOBALS["goaltable"];
		
		$num = func_num_args();
		$args = func_get_args();
		if($num == 0){
			$this->setDataNull();
		}
		else{
			$this->__call('__setDataRes', $args);
		}		
	}
	
	function display($includeAdmin = NULL){
		
		if(strcmp($this->iconPath,""))
		{
			$imgPath=$this->iconPath;
		} else {
			$imgPath=$GLOBALS['goalIconDefault2'];
		}
		
		echo "<div class='goal'>\n";
		echo "<table>\n";
		echo "<tr>\n";
		echo "<td valign='top'>\n";
		echo "<img height='40px' width='40px' src='". $imgPath ."'>\n";
		echo "</td>\n";
		echo "<td>";
		if($includeAdmin){
			echo "ID: ". $this->id . "<br>\n";
		}
		echo "Name: ". $this->name . "\n";
		echo "<br>Description: ". $this->description . "\n";
		echo "<br>Created Date: ". $this->createdDate . "\n";
		echo "<br>Due Date: ". $this->dueDate . "\n";
		echo "<br>Is Public: ";
		if($this->isPublic) 
		{ 
			echo "Yes";
		}
		else 
		{ 
			echo "No";
		}
		echo "\n";
		if($includeAdmin){
			echo "<br>Source: ". $this->source . "\n";
			echo "<br>Status: ". $this->status . "\n";
			echo "<br>User ID: ". $this->userID . "\n";
		}
		echo "</td></tr></table>\n";
		echo "</div>\n";
	}
	
	function displaySummary($showEditLinks = NULL){
		
		if(strcmp($this->iconPath,""))
		{

			$imgPath=$this->iconPath;
		} else {
			$imgPath=$GLOBALS['goalIconDefault2'];
		}
		echo "<div class='goal'>\n";
		echo "<table>\n";
			echo "<tr>\n";
				echo "<td valign='top'>\n";
					echo "<img height='40px' width='40px' src='". $imgPath ."'>\n";
				echo "</td>\n";
				echo "<td>\n";
					echo $this->id . ". " .  $this->name;
				echo "</td>\n";
				if($showEditLinks)
				{
					echo "<td>" . " <a href='" . $_SESSION["landingPageBase"] . "?act=editGoal&goalID=" . $this->id . "'>(edit)</a></td>\n";
					echo "<td>" . " | <a href='" . $_SESSION["landingPageBase"] . "?act=deleteGoal&goalID=" . $this->id . "'>(delete)</a></td>\n";
				}
			echo "</tr>\n";
		echo "</table>\n";
		echo "</div>\n";
	}
	
	//Helper for passing through the list of arguments to constructors
	//public function __call($name, $arg){
    //    return call_user_func_array(array($this, $name), $arg);
    //}
	
	//Empty constructor logic
	function setDataNull(){
		$this->id = NULL;
		$this->name = NULL;
		$this->description = NULL;
		$this->createdDate = NULL;
		$this->dueDate = NULL;
		$this->iconPath = NULL;
		$this->isPublic = NULL;
		$this->source = NULL;
		$this->status = NULL;
		$this->userID = NULL;
	}
	
	function insertGoal()
	{
		//Test if record exists already
		//		$query = "SELECT id FROM ". $this->goaltable . " WHERE id='". $this->id .'"';
		//		echo $query;
		//		$sqlresult = mysql_query($query);
		//		if(mysql_num_rows($sqlresult) == 0)
		if(!isset($_SESSION["goalID"]))
		{
			//Insert
			$query = "INSERT INTO ". $this->goaltable . " VALUES ('".
			$this->id ."','".
			$this->name ."','".
			$this->description ."','". 
			date( 'Y-m-d H:i:s', strtotime($this->createdDate)) ."','".
			date( 'Y-m-d H:i:s', strtotime($this->dueDate)) ."','".
			$this->iconPath ."','".
			$this->isPublic ."','".
			$this->source ."','".
			$this->status ."','".
			$this->userID ."')";
			mysql_query($query);
		}
		else
		{
			//Update
			$query = "UPDATE " . $this->goaltable . " SET name='" . $this->name . "'," .
			" description='" . $this->description . "'," .
			" dueDate='" . $this->dueDate . "'," .
			" iconPath='" . $this->iconPath . "'," .
			" isPublic='" . $this->isPublic . "'" .
			" WHERE id='" . $_SESSION["goalID"] ."'";
			mysql_query($query);
		}
	}
	
	
	function buildFromDB($where)
	{		
		if(!(strcmp($where,""))) { return -1; }
		$query = "SELECT * FROM ". $this->goaltable . " " . $where;
	
		$sqlresult = mysql_query($query);
		
		if(mysql_num_rows($sqlresult) == 0){ return -1; }
		
		$this->setData($sqlresult,0);	
		
		return 1;
	}
	
	function buildFromDBByID($id)
	{
		$where="WHERE id='". $id ."'";
		return $this->buildFromDB($where);
	}
	
	//Populated constructor logic
	function setData($sqlresult,$row){
		$this->id = mysql_result($sqlresult,$row,"id");
		$this->name = mysql_result($sqlresult,$row,"name");
		$this->description = mysql_result($sqlresult,$row,"description");
		$this->createdDate = mysql_result($sqlresult,$row,"createdDate");
		$phpDate = strtotime( mysql_result($sqlresult,$row,"dueDate") );		
		$this->dueDate = date( 'm/d/y', $phpDate);
		$this->iconPath = mysql_result($sqlresult,$row,"iconPath");
		$this->isPublic = mysql_result($sqlresult,$row,"isPublic");
		$this->source = mysql_result($sqlresult,$row,"source");
		$this->status = mysql_result($sqlresult,$row,"status");
		$this->userID = mysql_result($sqlresult,$row,"userID");
	}
}
?>
