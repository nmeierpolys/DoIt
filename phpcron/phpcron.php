<?php

/*ROBODOC** PHPCRON/phpcron_readme
# 
# NAME
# phpcron
# DESCRIPTION
# This is the scheduling engine and command line utility. 
# It can be controlled by phpcron_admin.php
# AUTHOR
# David C. Druffner
# ddruff@gemini1consulting.com
# COPYRIGHT
# COPYRIGHT 2001 (C) David C. Druffner
# ddruff@gemini1consulting.com
# This script is released under a modified BSD License.
# See php phpcron.php -license and LICENSE.txt in download package 
# for full license details
# CREATION DATE
# October 25, 2001
# MODIFICATION HISTORY  
# October 25, 2001 - first beta release, version 0.5b.
# BUGS
# Can't startup phpcron or execute most system calls in Windows, 
# although stop and other functions work
# Other Bugs can be reported via the online manual:
# http://www.gemini1consulting.com/tekhelp/online_manuals/phpcron/
# NOTES
# This script can be controlled by Phpcron Admin (phpcron_admin.php), 
# a based interface.
# 
# The current manual for Phpcron and Phpcron Admin is located at 
# http://www.gemini1consulting.com/tekhelp/online_manuals/phpcron/
# The Home Page is:
# http://phpcron.sourceforge.net/
# Download from the Source Forge Project Page:
# http://www.sourceforge.net/projects/phpcron/
#
# In-Line Documentation:
# A slightly modified version of ROBODOC is used to
# generate documentation for   this code. I have modified the headers.c file in
# the Robodoc source code to  et  the variable header_markers to equal only
# /*ROBODOC* as the start of a  header  marker - this avoids confusion with other
# strings and comments in PHP  code.   Robodoc is available at
# http://www.xs4all.nl/~rfsber/Robo/robodoc.html
*ROBODOC_END*/



/******************* End Notes  - Start Code ****************/

/*Initialize Some Variables and Constants*/

  //define constant pointing to current directory

/*ROBODOC*d phpcron/CURRENT_DIRECTORY
# NAME
#
# CURRENT_DIRECTORY
# DESCRIPTION
# Constant which holds the path of the current directory.
*ROBODOC_END*/

define ("CURRENT_DIRECTORY",addslashes(realpath(dirname(__FILE__))));

/*ROBODOC*v phpcron/phpcron_directory
# NAME
# phpcron_directory - path that holds include files
# DESCRIPTION
# This is the directory  that holds the include files.  Must be able to be
# written to by process  running this script. By default this is null thus
# pointing to the same  directory as this script .
*ROBODOC_END*/



$phpcron_directory="./";

/*ROBODOC*v phpcron/$start_time
# NAME
# $start_time - formatted string hold time script started
# DESCRIPTION
# String containing time script started.
*ROBODOC_END*/


$start_time= date("m/d/Y").":".date("h:i:s:A");


/****** Include Files ********
Make sure these files are in the same directory as this script and that the directory is
readable/writeable */

  if (file_exists($phpcron_directory."phpcron_userconfig.php")) {
    $userconfig_used=true;
    include($phpcron_directory."phpcron_userconfig.php");

  } else {
    sendOutput("Error - No Configuration File - Using default parameters or if provided, those set by user at command line.<br>");
    /* Default parameters if external configuration file cannot be found - can be overriden by command line options */
    
/*ROBODOC*v phpcron/$phpcrontab_filename
# NAME
# $phpcrontab_filename - name of phpcrontab.conf file
# DESCRIPTION
# String - Name of phpcrontab.conf file.
*ROBODOC_END*/

$phpcrontab_filename="phpcrontab.conf"; 
   
    
/*ROBODOC*v phpcron/$debug
# NAME
# $debug - controls debug messages
# DESCRIPTION
# Boolean - true to see debug messages
*ROBODOC_END*/
  
$debug=false; //make this true to see debug messages
    
/*ROBODOC*v phpcron/$slow_debug_scroll
# NAME
# $slow_debug_scroll - controlls scroll of debug messages
# DESCRIPTION
# Int - increase to slow scroll of debug messages
*ROBODOC_END*/
    
$slow_debug_scroll=2; 

/*ROBODOC*v phpcron/$log_result
# NAME
# $log_result - controls logging
# DESCRIPTION
# Boolean - true to log of execution of commands in phpcrontab.conf
*ROBODOC_END*/

$log_result=false;   


/*ROBODOC*v phpcron/$log_result_file
# NAME
# $log_result_files - path to log file
# DESCRIPTION
# String - path to log file
# NOTES
# For Dos, use forward slash only, not double escape
*ROBODOC_END*/

$log_result_file="";     

/*ROBODOC*v phpcron/$mail_success
# NAME
# $mail_success - controls email notificatio
# DESCRIPTION
# Boolean - set to true to mail user a notification that 
# commands in phpcrontab.conf has been executed successfully
*ROBODOC_END*/

$mail_success=false;      

/*ROBODOC*v phpcron/$admin_email_address
# NAME
# $admin_email_address - address to email phpcron messages to
# DESCRIPTION
# String - contains email address of administrator
*ROBODOC_END*/

$admin_email_address="";     

/*ROBODOC*v phpcron/$mail_errors
# NAME
# $mail_errors - controls mailing of error messages
# DESCRIPTION
# Boolean - set to true to mail the user an error message
# regarding the failure of a scheduled phpcron command.
# NOTES
# This does not work for Windows/Dos 
*ROBODOC_END*/

$mail_errors=false;      

/*ROBODOC*v phpcron/$error_email_address
# NAME
# $error_email_address- email address to send error messages to
# DESCRIPTION
# String - address receiving mail sent if $mail_errors 
# set to true to mail the user an error message
*ROBODOC_END*/

$error_email_address="";      
  
/*ROBODOC*v phpcron/$system_name
# NAME
# $system_name- unique name of system which phpcron.php is running
# DESCRIPTION
# String - Unique name of system on which the phpscript is used. You can name
# it whatever you want, but I suggest the host name - Used to identify system in 
# email messages
*ROBODOC_END*/
    
$system_name="localhost";   

/*ROBODOC*v phpcron/$suppress_output
# NAME
# $suppress_output- true to suppress all but non-fatal error messages
# DESCRIPTION
# Boolean - Suppress all non-fatal error messages and other output (including
#debugging messages). This overides $debug
*ROBODOC_END*/

$suppress_output=false;     

/*ROBODOC*v phpcron/$daemon_mode
# NAME
# $daemon_mode- set to true to run as a daemon
# DESCRIPTION
# Boolean - when this is set to true, phpcron.php runs in a 
# continuously as a daemon.
*ROBODOC_END*/

$daemon_mode=false;      //run once only - non-daemon mode

  }

/******************************* End Includes*********************/

/******************************* Begin Functions*********************/


if (file_exists($phpcron_directory."phpcron_commonlib.php")) {
 include($phpcron_directory."phpcron_commonlib.php");    //import common library functions
} else {

  stopThisProcess("FATAL ERROR: Cannot find common library file phpcron_commonlib.php. Please make sure
  that it exists in the same directory as phpcron.php.<br>");
}



/*ROBODOC*f phpcron/stopThisProcess
# NAME
# stopThisProcess
# SYNOPSIS
# boolean stopThisProcess(string $stop_message)
# FUNCTION
# Gracefully stops this script. Time stamps the log file,
# deletes phpcron_psinfo file and exits.
# INPUTS
# string $stop_message - Message to be output to 
# screen
# SOURCE
*/


function stopThisProcess($stop_message) {
//Graceful Stop

global $log_result;
global $log_result_file;
global $pid;
global $phpcron_off;
global $phpcron_psinfo_file;
global $daemon_mode;
/* Only do this if this process is running as a daemon.
Don't want to log start/stops if only running once */
sendOutput($stop_message."\r\n", true);

if($daemon_mode) {

  $stop_time= date("m/d/Y").":".date("h:i:s:A");

  if ($log_result) {
  $stop_message="
***********************************************************
PHPCRON (DAEMON) $pid Stopped $stop_time

Final Output Message:
".strip_tags($stop_message)."
***********************************************************
";

  appendToFile("$stop_message", $log_result_file);
  }

  deleteFile($phpcron_off);

}

deleteFile($phpcron_psinfo_file);
deleteFile("$TEMP_DIR/".basename($phpcron_psinfo_file));



exit;

}

/*ROBODOC_END*/



/*ROBODOC*f phpcron/killOtherPhpcron
# NAME
# killOtherPhpcron
# SYNOPSIS
# boolean killOtherPhpcron(void)
# FUNCTION
# Kills any other phpcron daemons that may be running.
# This is a non-nice termination and is only used
# when stopOtherPhpcron doesn't work. It actually
# kills the process and does not properly 
# timestamp logs, etc.
# NOTES
# See stopOtherPhpcron
# RESULT
# Returns true on success, false on failure.
# BUGS
# Probably lots due to not testing on any other system.
# Ps command may be different for other systems. 
# Kill process won't work on Windows systems.
# SOURCE
*/

function killOtherPhpcron() {

        /* Abort Phpcron daemons - not nice*/
        //First try to stop nicely
	if(stopOtherPhpcron()){
	
	return true;
	}
	
      
	exec("ps -C php O p |grep 'phpcron.php.(*['--daemon'|'-D'].*'$|cut -d' ' -f1-4",$output,$result_code);

        $i=0;
        //loop through processes and kill them
        while($i<=count($output[$i])-1) { //-1 is don't kill this process
	//Get rid of any spaces and make sure only have one element
	$output[$i]=trim($output[$i]);
	$output_array=explode(" ", $output[$i]);
	$output[$i]=$output_array[0];

        //sendOutput("Output: Killing Phpcron daemon process $output[$i]\r\n");
	
        exec("kill -9 $output[$i]",$killoutput, $result_code);
        if ($result_code) {
        //sendOutput("Error: Can't Kill process $output[$i]\r\n");
        return false;
        }

   	$i++;
        }

        return !isotherPhpcrond();

}

/*ROBODOC_END*/

/******************************* End Functions*********************/

/* Check PHP Version */
$phpversion_required="4.0.1";
if (!checkPhpVersion($phpversion_required)){
$phpversion_installed=phpversion();

stopThisProcess("\r\nSorry, your server is running PHP version $phpversion_installed. 
This script requires at least PHP version $phpversion_required or higher.
The latest PHP version is available for download at http://www.php.net. <br>\r\n");

}


/****************** Initialize Variables **********************/



$phpcrontab_filename=addslashes($phpcrontab_filename);
$fatal_error=false;


/*ROBODOC*v phpcron/$pid
NAME
$pid - unix process id of this process
DESCRIPTION
String - holding unix process id of this process
*ROBODOC_END*/


$pid=getmypid();

/*ROBODOC*v phpcron/$cl_help
# NAME
# $cl_help - command line help string
# DESCRIPTION
# String - holds command line help
# SOURCE
*/


$cl_help="
--abort
-a

	-Aborts a currently running phpcron daemon - Not Nice. Only use if 
	--quit fails
	
--phpcrontab PHPCRONTAB_CONF_FILE
-c PHPCRONTAB_CONF_FILE

	 -Sets the path for configuration file named as PHPCRONTAB_CONF_FILE
	 
--daemon
-D
	-Daemon Mode - Run until process is killed
	
--daemon-off
-d 	

	-Daemon Off/Run Once - Parse the phpcrontab file once and stop 
	(original default)
	

--email-errors EMAIL_ADDRESS
-E EMAIL_ADDRESS

	Email Errors on - Email failure message if scheduled program fails to
 	execute
	
--email-errors-off
-e	
	-Mail Errors Stop - Turn off email of errors (original default)
	
--help
-h 
-? 

	-Prints this help
	
--logging LOGFILE
-L LOGFILE

	-Turn logging on and set the path to the log file
	
--logging-off
-l	
	-Stops logging (original default)
	
--mail-notification EMAIL_ADDRESS
-M EMAIL_ADDRESS
	
	-Turn the mail notification feature on 
	
--mail-notification-off
-m
	- Turn the mail notification feature off (original default)
	
	
--name SYSTEM_NAME
-n
	-Set the system same used in mail messages


-r [DUMP_FILE]

	- Redirect All Output to DUMP_FILE (default file: phpcron_output)
	
--suppress
-S
	-Suppress all messages to screen except fatal errors

--suppress-off
-s
	-Stop Suppression of output (original default, opposite of -S)
	
--slow-debug SECONDS
-sd SECONDS

	-Slow Debug Scroll - SECONDS is integer by which debug messages are 
	slowed.	Increase to slow debug messages when verbosity is turned on

--quit
-q
	-Stops gracefully all currently running phpcron deamons

--verbose
-v

	-Turn debugging messages on
	
--verbose-off

	-Turn debugging messsages off (original default)
	
	
NOTE: The actual defaults may be different from the \"original default\" setting
if the user configuration options have been changed in the script or if a user
configuration file is being used.
For more information, see the manual that is packaged with the script.

";

/*ROBODOC_END*/
/*******Begin Main Script Execution *****************/


/* This is critical, otherwise php engine will end script if in daemon mode for exceeding maximum
time limit set in php.ini */


set_time_limit(0);





/******************Begin Parsing Command Line Parameters *******************/

/* Get Command Line Parameters if any. This requires that php.ini has argc_argv set to on.
Start with second element since first one is the name of the script.*/

$i=1;
 $arguments=implode(" ", $argv);


while ($argv[$i]) {


  switch ($argv[$i]) {


      case "--abort":
      case "-a":
      /* Abort Phpcron daemons - not nice, use only if -stop does not work */

      if(!isOtherPhpcrond()){
        stopThisProcess("\r\nNo phpcron daemon is currently running - no process to kill\r\n<br>");
      }
     
 

      if(killOtherPhpcron()) {
        sendOutput( "All Phpcron Daemons have been Killed.\r\n", true);
        exit;
      } else {

        sendOutput( "Unable to kill Phpcron Daemons.\r\n", true);
        exit;
      }
      exit;


      break 1;

   

    case "-c":

       //Specify the phpcrontab file
      $i++;
        $phpcrontab_filename=addslashes($argv[$i]); //advance counter


      break 1;



   case "--daemon":
   case "-D":

      /* Run in "Daemon Mode" - Run in continuous loop until
      killed - this should ONLY be done if this process will not be
      invoked twice on the same computer*/

      $daemon_mode=true;
      break 1;

   case "--daemon-off":
   case "-d":

      //Daemon Mode Off - Turn Perpetual Loop Off and Run Only Once (default)
       $daemon_mode=false;
       break 1;


   case "-?":
   case "-h":
   case "--help":

      //Print Help
      sendOutput($cl_help, true);
        exit;  /* Exit Script. */


      case "--license":

    
     //Print License text
     sendOutput($license, true);
     exit;  /* Exit Script. */

      
     break 1; 

    case "-L":
    case "-logging":

     //Turn Logging On and set log file
    
      $i++;
      $log_result_file=$argv[$i]; //get next parameter and check to see if valid directory


    //if in dos/windows add escape the backslashes
      if(MS_WINDOWS) { 
            $log_result_file=addslashes($log_result_file);
          }


      $log_result=true;


        break 1;


   case "--logging-off":
   case "-l":

      //Turn Logging off
      $log_result=false;
        break 1; 
	
    case "-email-errors":
    case "-E":

      //Get email address and turn mail errors on
      $i++;
      $error_email_address=$argv[$i];

      $mail_errors=true;
      break 1;  

   case "--email-errors-off":
   case "-e":

      //Turn Mail Errors off
      $mail_errors=false;
      break 1;  

    case "--mail-notification":
    case "-M":

       //Get email address and turn mail notification on
      $i++;
      $admin_email_address=$argv[$i];
      $mail_success=true;
      break 1;  

   case "--mail-notification-off":
   case "-m":
      //Turn Mail Notification off
      $mail_success=false;
      break 1; 
   
   case "--name":
   case "-n":
    $i++;
    $system_name=$argv[$i]; //set system name to next argument and iterate counter
    break 1;  

  
   
      
   case "--options":
   case "-o":

    /*Just display the options chosen and exit. This is only meant to be run by the phpcrond
    wrapper to display the options before this script is reexecuted without output. See the phpcrond
    shell script. */

        $display_options=true;
        break 1;
	
	
    case "--quit":
    case "-q":

    /* Stop all existing Phpcron daemons gracefully */
      if(!isOtherPhpcrond()){
      stopThisProcess("\r\nNo phpcron daemon is currently running - no process to stop\r\n<br>");
      }
      if(stopOtherPhpcron()) {
        sendOutput( "All Phpcron Daemons have been stopped.\r\n", true);
        exit;
      } else {

        sendOutput( "Unable to stop Phpcron Daemons. Use -abort switch to kill the processes.", true);
        exit;
      }


      break 1;	

   case "--redirect-to-file":
   case "-r":

    //Redirect all output to File
  
  
   
/*ROBODOC*v phpcron/$redirect_output
# NAME
# $redirect_output - if true, directs output to specified file
# DESCRIPTION
# Redirects all output to specified file
*ROBODOC_END*/
  
  /*ROBODOC*v phpcron/$redirect_file
# NAME
# $redirect_file - name of output file
# DESCRIPTION
# File output is redirected to if -r flag used.
*ROBODOC_END*/
  
  
     $redirect_output=true;

     /*If the next argument does not begin w/a dash then assume next argument is file name */

    if($argv[$i+1] and (!preg_match("/^\-.*$/",$argv[$i+1]))) {

    $i++;


      if(isPathBad($argv[$i])) {
        $redirect_file="phpcron_output";
        $error_message="\r\nCannot save redirected output to $argv[$i]. Check filename and permssions.\r\nSaving to ".formatPath("phpcron_output")."\r\n";
        echo $error_message;
        


      } else {
        $redirect_file=$argv[$i];
      }


    } else {
    $redirect_file="phpcron_output";

    }

    if (file_exists($redirect_file)) { //get rid of old output file
      deleteFile($redirect_file);
    }

     break 1;


   case "--suppress":
   case "-S":
   

      //Suppress All Output
      $suppress_output=true;
       break 1;  
       
   case "--suppress-off":
   case "-s":

      //Stop Suppression of Output (opposite of -s)
      $suppress_output=false;
      break 1;  

   case "--slow-debug":
   case "-sd":

      //Slows Debug Scroll
      $i++;
      $slow_debug_scroll=$argv[$i];
      break 1;  

    case "--verbose":
    case "-V":

      //Turn debug messages on
      $debug=true;
        break 1;  /* Exit only the switch. */
	
   case "--verbose-off":
   case "-v":

      //Turn debugging messages off
      $debug=false;
        break 1;  /* Exit only the switch. */



    default:
     $option_errors .= "ERROR: \"$argv[$i]\" is an Invalid Parameter - type -h for help information\r\n";
     $fatal_error=true;
     
     
  

    } //end of switch

$i++;
} //end of while


/******************End of Parsing Command Line Parameters *******************/

//Prevent daemon mode when run from browser to prevent overloading server

 if ($viewed_by_browser) {
    $daemon_mode=false;
   }




/* Check to See if Another Instance is Running, If so, terminate */

if(isOtherPhpcrond() and $daemon_mode) {
stopThisProcess("\r\nSorry, another instance of the phpcrond daemon is running. No more than one instance
can run at a time.\r\nProgram Terminated.\r\n");

}




/******Screen Formatting for Paths******/

$crontab_stripped=formatPath($phpcrontab_filename);

$logresult_stripped=formatPath($log_result_file);
$base_logresult_stripped=formatPath($log_result_file);
$dir_logresult_stripped=formatPath(dirname($log_result_file));

/*****End Screen Formatting*****?

/********* Begin Validation of Options*/


  //Check Existence of $phpcrontab_filename
  if (!is_readable($phpcrontab_filename)) {
    $option_errors= "ERROR: Phpcrontab configuration file $crontab_stripped cannot be read. Please create and/or check permissions and try again. See the readme.txt file for more information.\r\n\n<br>";
    $fatal_error=true;
    }


  //Make Sure That given file name is Not a parameter

      if(preg_match("/^-.*$/",basename($log_result_file))) {
  
      $option_errors.="ERROR: Make sure -l has a valid file name as an additional parameter\r\n";

      }
  //Check validity of $log_result_file directory

       $path_errors=isPathbad($log_result_file);

    /*Extract directory name from file name and check to see whether we can use it */
    
      if($path_errors["directory"]) {
           $ps_info=getProcessInfo();
  

           $option_errors .=
           "ERROR: Invalid Log Path - Make sure that $base_logresult_stripped is a valid file name and $dir_logresult_stripped exists and allows the user to read and write to it. \r\n\t<br>";


      $fatal_error=true; //cause program to exit
       }

  //Check Validity of Notification Email Address

      if(!is_email($admin_email_address)) { 
          $option_errors .= "\ERROR: Invalid Email Address for Mail Notification\r\n<br>";
        $mail_success=false;
        $fatal_error=true;
      }

  //Check Validity of Error Email Address

      if(!is_email($error_email_address)) { 
          $option_errors .= "\ERROR: $error_email_address is an Invalid Email Address\r\n<br>";
        $fatal_error=true;
        
      }

  //Check Validity of Scroll Delay Value
   if(!preg_match("/[0-9]{1,6}/",$slow_debug_scroll)) {
         $option_errors .="ERROR: Debug message $slow_debug_scroll delay (-sd option) must be between 0 and 999,999\r\n<br>";
        $fatal_error=true;
   }



/***** End Validation of Options*****/

/************* Log Start Message to Log File if Running in Daemon Mode*************/

if ($daemon_mode) {


appendToFile("
****************************************************************
PHPCRON Daemon Process $pid Started $start_time
****************************************************************
", $log_result_file);

} 
/*****Begin Build of Option Feedback ***/


if ($userconfig_used) {

$option_feedback .= "\tUser Configuration File: ".formatPath($phpcron_directory."phpcron_userconfig.php")."\r\n<br>";
}

$option_feedback .="\tUsing Crontabfile: $crontab_stripped\r\n<br>";

if($debug)
  {$option_feedback .= "\tDebug Mode: ON\r\n<br>".
  "\tDebug Message Delay: $slow_debug_scroll seconds\r\n<br>";}
  else {$option_feedback .= "\tDebug Mode: OFF\r\n<br>";
  }
if($log_result)  {
      $option_feedback .= "\tLogging: ON"." to: ".$logresult_stripped."\r\n<br>";

    }
  else {$option_feedback .= "\tLogging: OFF\r\n<br>";
  }
if($mail_errors) 
  {$option_feedback .= "\tMail Errors: ON"." to: $error_email_address\r\n<br>";} 
  else {$option_feedback .= "\tMail Errors: OFF\r\n<br>";
  }
if($mail_success) 
  {$option_feedback .= "\tMail Notification: ON"." to: $admin_email_address\r\n<br>";} 
  else {$option_feedback .= "\tMail Notification: OFF\r\n<br>";
  }    
if($daemon_mode)
  {$option_feedback .= "\tDaemon Mode: ON - Run Continously until stopped by user\r\n<br>"; }
  else {$option_feedback .= "\tDaemon Mode: OFF - Run Once\r\n<br>";
  }
if($suppress_output)  {
  $option_feedback .= "\tSuppression: ON\r\n<br>";
  } else {
    $option_feedback .= "\tSuppression: OFF\r\n<br>";
  }
$option_feedback .="\tSystem Name is: $system_name\r\n<br>";

if($redirect_output) {

  echo "\r\nRedirecting Output to: ".formatPath($redirect_file)."\r\n<br>";
}


/*************End Build of Feedback on Options *******/

/* Write phpcron_psinfo_file containing process info. This serves to communicate info to
PHPCron Admin and tells it whether this script is running.*/



$path_errors=isPathBad($phpcron_psinfo_file, true);
if ($path_errors["directory"] or $path_errors["file"]["write"]) {

  $output="Error:  Cannot write to $phpcron_psinfo_file. The following errors were encountered.:<br>\r\n";

  while ( list($file_or_dir, $error_messages) = each($path_errors)) {

              while (list($each_message)  = each($error_messages)) {
                $output.= $path_errors[$file_or_dir][$each_message]."<br>\r\n";
              }
  }

  stopPhpcron("\r\nERROR: PHPCRON must be able to create $phpcron_psinfo_file, please fix the problem, and try again.<br><br>\r\n\r\n");





}  else {


  if(!MS_WINDOWS) {

  /* Get process info and store in file */

  $ps_info=getProcessInfo();  //get owner and id of process
  $ps_info_string=implode("\r\n",$ps_info);
  }  else {


  $ps_info_string="PHPCRON RUNNING";
  }

  $save_results=saveFile($ps_info_string,$phpcron_psinfo_file);

  
  if(is_writeable("$TEMP_DIR/".basename($phpcron_psinfo_file))) {

  //write it to the tmp directory also if can

  saveFile($ps_info_string,"$TEMP_DIR/".basename($phpcron_psinfo_file));



  }


  if(!$save_results[0]) { //if not a successful save get error messages

   $index=1;
   $output="";
    while($save_results[$index]) {
    $output.=$save_results[$index];
    $index++;
    }


    $output=implode("\r\n",$save_results).
"PHPCRON must be able to open ".formatPath($phpcron_psinfo_file)." in order for PHPCRON Admin
to control PHPCRON's execution. You will need to fix, and try again for PHPCRON Admin to work properly.<br><br>\r\n\r\n";

    sendOutput($output,true);
    sleep(5);
    $output="";
      }
    
}


     
     deleteFile($phpcron_off); //delete this if it exists since it would be from previous run;

 

/*Output initial messages*/



$output_message="
PHPCRON v. 0.1b (BETA)\r\nCopyright (C) David Druffner ddruff@gemini1consulting.com<br>
Released 10/7/2001 under the modified BSD license.<br>
For Help type \"php phpcron.php -?\" at command prompt.<br>

Invoked $start_time<br>
";

    if(!$viewed_by_browser and !$display_options) {

        if (!MS_WINDOWS) {
        $output_message .= "To terminate type \"kill -9 $pid\" at command prompt\n\n<br>";
        } else {
        $output_message .= "To terminate type CTRL-C\r\n\n<br><br>";

         }
    }
    $output_message.="<br><strong>Options Set:</strong> \r\n<br>$option_feedback\r\n<br>";


    sendOutput($output_message, true);



      if($fatal_error) {

        $output="<br><strong>FATAL ERROR(S)</strong>:\r\n\n<br>".
        $option_errors.
        "\r\nProgram Terminated.\r\n<br>";
        stopThisProcess($output);

        }
      if ($display_options) {
        exit; //display option feedback and exit - when done in phpcrond shell script used to display info before executing phpcron in background

      }


if ($suppress_output) {  //error reporting set to fatal errors only
  error_reporting(E_ERROR);
  }

if ($viewed_by_browser) {

  echo "<h4><bold>Warning:</bold> You are running PHPCRON in a browser.
  When run this way, daemon mode cannot be invoked as it can overload the server.</h4> <br>\n";


}

if(MS_WINDOWS) {

  $output_message= "NOTE: You are running this script in windows/dos.  Please note that the error logging and notification features will not work under windows/dos but all other features are available.\r\n<br>";
  sendOutput($output_message);
  }


if ($debug) {

   sendOutput("\r\n<hr><br><h3>Debugging Information:</h3><br>");

    if (!MS_WINDOWS) { //show pid info if not in windows

      $current_user=get_current_user();
      $ps_info=getProcessInfo();

      $output_message= "The current owner of the script is $current_user.\r\n<br>".
      "The pid is: $pid\r\n<br>".
      "The owner of the process is: $ps_info[owner]\r\n<br>".
      "The process information is: $ps_info[all]\r\n<br>";
      sendOutput($output_message);


      }

}


do { //eternal loop - need to physically break into program. This does not loop if it is run in a browser to prevent overloading the server (and you must kill the httpd process if it does loop).
      $ps_info=getProcessInfo();
     

   /* Check if file named "phpcron_off" exists. If it does, then kill this process - this allows PHPCRON
  Admin to kill it in dos and unix*/

   if (file_exists($phpcron_off)) {
   

   stopThisProcess("<BR>\r\nPHPCRON DAEMON $pid STOPPED BY USER.");
   
   }

  /*Check for existence of phpcron_psinfo_file. If it was erased, write it again. To make sure
  the file contains current info, PHPCRON Admin deletes it when checking to see if PHPCRON is on. */

  if (!file_exists($phpcron_psinfo_file) or !file_exists("$TEMP_DIR/".basename($phpcron_psinfo_file))) {

  if (!MS_WINDOWS) {
    /* Get owner and id of process */
    $ps_info=getProcessInfo();
    $ps_info_string=implode("\r\n",$ps_info);
  } else {
  $ps_info_string="PHPCRON is running";
  }
  saveFile($ps_info_string, "$TEMP_DIR/".basename($phpcron_psinfo_file));
  $save_results=saveFile($ps_info_string,$phpcron_psinfo_file);

        if(!$save_results[0]) { //this would be unsuccessful save
        $error_messages="";
        $index=1;
        while($save_results[$index]) {
          $error_messages.=$save_results[$index];
          $index++;
        }
        $element=0;
        stopThisProcess("
        $error_messages
        Error:  Cannot write to $phpcron_psinfo_file.
        PHPCron must be able to create $phpcron_psinfo_file.
        Please fix and try again. Program Terminated.");

      }
    
  }



  /* Parse time and compare against schedule in PHPCRON tab file */
  $readable_timestamp= date("m/d/Y").":".date("h:i:s:A");
  //(formatted timestamp to match phpcrontab format above)
  $timestamp= trim(date("i H d m w")); 
   // read conf file into an array, with each line being an element in the array
  $phpcronconf_array=file($phpcrontab_filename); 
  $line_number=0;
       // loop through the array containing the lines of the phpcrontab.conf file
          while ($line=$phpcronconf_array[$line_number]) {   
                   $time_matchpattern=""; // initialize to null
             $unix_message="";
             $line=preg_replace("/#.*$/","",$line); // get rid of commented out sections and lines

                   if(!preg_match ("/^\s*$/", $line)) {// if line is a blank line then ignore line

                    if ($debug) {
                $ln=$line_number+1;
               sleep($slow_debug_scroll); //delay to allow read of debugging messages
                      $output_message= "<br>\n\nProcessing PHPCRONTAB line #$ln: "." $line\r\n<br>";
               sendOutput($output_message);
                    }
              // parse line into a 6 element array (0-5), 5 time parameters (minute, hour, day of month, month, day of week) + command string
                    $line = explode(" ", $line,6); 
               // pop off the command text from the $line array
                    $command_text=array_pop($line); 
              //put time schedule parameters into a string
                    $time_matchpattern = implode(" ", $line); 
               //trim extra spaces from beginning and end of command string
                    $command_text=trim ($command_text);
              //trim time parameters
                    $time_matchpattern=trim($time_matchpattern);  

                    if ($debug) {
                        $output_message="Time Match Pattern: $time_matchpattern\r\n<br>".
                        "Time Stamp is: $timestamp\r\n<br>".
                        "Command is: \"$command_text\"\r\n<br>";
                sendOutput($output_message);

                    }
                //If pattern matches and command hasn't been executed at this time before, then execute the command
                        if (parseCronTimeParams($time_matchpattern) and ($cron_command_executed[$line_number] != $timestamp)) { 
                          if ($debug) {

                      $output_message= "There's a match. Now executing "."\"$command_text\"". " at $timestamp \r\n<br>";
                       sendOutput($output_message);

                      }

                  /* Execute command and get error return value; - the return value seems 
            only valid for unix, couldn't get it to work properly for dos */
	    
             system($command_text, $error_return_value);  
                  if ($debug) {
              $output_message= "\nThe return error value of the command is $error_return_value\r\n<br>";
               sendOutput($output_message);
              }

          /* If there is an error in executing the cron command: - but only works for non-windows 
          systeems (couldn't figure out how to get dos error codes to work correctly - anyone??) */

                   if (($error_return_value) and (!MS_WINDOWS) ) { 

                    // then log a generic error message if this parameter is set to true
                              if ($log_result) { 

                                  if ($debug) {
                                         $output_message="<br>Error in executing command \"$command_text\", logging ..<br>";
                             sendOutput($output_message);
                                  }

                                  $error_message ="$readable_timestamp PHPCRON PID#$pid ERROR: The command \"$command_text\" has failed. Return value: $error_return_value\r\n\n";
                                  appendToFile($error_message,$log_result_file);

                       if($php_errormsg) {
                         $output_message= "ERROR: Log File $log_result_file Could Not be Written to. Check File Permissions and Path\r\n<br>";
                         sendOutput($output_message);
                        }

                              }

                              if ($mail_errors) { //email error, @ suppresses error message (if mail server not up won't get error)

                                  @mail($error_email_address, "$readable_timestamp: PHPCron Error Message from $system_name", $error_message, "From: $system_name\nX-Mailer: PHP/" . phpversion());
                       if($php_errormsg) {
                         $output_message="PHPCRON Error Mail Message Could Not Be Sent: $php_errormsg. Make sure you have a mail server installed and running.\r\n<br>";
                         sendOutput($output_message);
                        }
                              }


                         }
                 if (!MS_WINDOWS and !$error_return_value) {
                       $unix_message="without errors.";
                 }
                  /* In non-windows os email a message if the command is successfully executed. 
                  In dos/windows email if it is executed, regardless of errors */

                         if ($mail_success and ((!MS_WINDOWS and !$error_return_value) or (MS_WINDOWS))) {

                                  @mail($admin_email_address, "$readable_timestamp: PHPCron PID#$pid Exec Message from  $system_name", "\"$command_text\" has been executed $unix_message", "From: $system_name\nX-Mailer: PHP/" . phpversion());
                        if($php_errormsg) {
                         $output_message= "PHPCRON Notification Mail Could Not Be Sent: $php_errormsg. Make sure you have a mail server installed and running.\r\n<br>";
                         sendOutput($output_message);

                        }



                       if ($log_result) { // then log a result message if this parameter is set to true


                       $error_message ="$readable_timestamp PHPCRON PID#$pid: The command \"$command_text\" has been executed $unix_message. Return value: $error_return_value\r\n\n";
                       appendToFile($error_message,$log_result_file);

                       if($php_errormsg) {
                         $output_message= "ERROR: Log File $log_result_file Could Not be Written to. Check File Permissions and Path\r\n<br>";
                         sendOutput($output_message);
                       }

                      }

                }     
		
		

                       if ($log_result) { // then log a result message if this parameter is set to true


                       $error_message ="$readable_timestamp PHPCRON PID#$pid: The command \"$command_text\" has been executed $unix_message. Return value: $error_return_value\r\n\n";
                       appendToFile($error_message,$log_result_file);

                       if($php_errormsg) {
                         $output_message= "ERROR: Log File $log_result_file Could Not be Written to. Check File Permissions and Path\r\n<br>";
                         sendOutput($output_message);
                       }

                      }
		
		                                                   

                  // flag to keep track of whether command has been executed at this time
                          $cron_command_executed[$line_number]=$timestamp; 

                        }
                    }

                  $line_number++;

} //end of while loop parsing configuration file


// this allows you to view the output for debugging purposes if in  perpetual loop
 if ($debug and $daemon_mode) {

    sleep($slow_debug_scroll);
 }




} while($daemon_mode); // end of perpetual do loop








