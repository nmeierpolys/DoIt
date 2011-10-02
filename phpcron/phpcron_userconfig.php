<?php

/*
 NOTE: IN order for this to work all paths (even if you are using this in dos) must have forward
 slashes - do NOT use backslashes. In addition, this file should ONLY contain variable assignments -
no other commands.
 */
$phpcrontab_filename="/home/david/phpcrontab.conf";	// for dos use forward slashes only
$debug=false;	//make this true to see debug messages
$slow_debug_scroll=2;	// increase to slow/decrease to speed  rate of scrolling debug messages during perpetu
$log_result=true;	//make this true to keep a log of phpcrontab execution
$log_result_file="/home/httpd/html/phpcron.log";	// Path to log file. 
$mail_success=true;	//make this true to mail the user a notification that a phpcrontab command has been executed 
$admin_email_address="david@localhost.localdomain";	// email address for above messages 
$mail_errors=true;	//make this true to mail the user an error message regarding the failure of a scheduled phpcron 
$error_email_address="david@localhost.localdomain";	//change this to the email address which will accept error messages if $mail_erro
$system_name="localhost";	//Unique name of system on which the phpscript is used. You can name it whatever you want, but I suggest the host name - Used to identify emailed notifications 
$suppress_output=false;	//suppress all non-fatal error messages and other output (including debugging). This overides the debug switch
$daemon_mode=false;/* should never turn this on in a virtual server environment OR if there is any 
possibility that more than one user would invoke phpcron.php in this way */

?>
