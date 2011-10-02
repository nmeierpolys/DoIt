
function isValidPassword($testPass,&$errMsg){
    $passLen = strlen($testPass);
    $output = FALSE;
    if(($passLen < 5) || ($passLen > 15)){
        $errMsg = "Password must be between 5 and 15 characters";
    } elseif(!preg_match("`[A-Z]`",$testPass)) {
        $errMsg = "Password must have a capital letter";
    } elseif(!preg_match("`[0-9]`",$testPass)) {
        $errMsg = "Password must have a number";
    } else {
        $output = TRUE;
    }
    return $output;
}

function isUserIPAllowed($safeList)
{	
	$userIP=$_SERVER["REMOTE_ADDR"];
	foreach($safeList as $i => $ipAddr) {
		if(!strcmp($userIP,$ipAddr)){
			$ipOkay=TRUE;
		}
	}
	return $ipOkay;
}