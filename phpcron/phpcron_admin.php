<?php

/*ROBODOC** PHPCRON/phpcron_admin_readme
# 
# NAME
# phpcron_admin
# AUTHOR
# David C. Druffner
# ddruff@gemini1consulting.com
# DESCRIPTION
# This is the browser based interface to phpcron.php.
# COPYRIGHT
# COPYRIGHT 2001 (C) David C. Druffner
# ddruff@gemini1consulting.com
# This script is released under a modified BSD License.
# See php phpcron.php -license and LICENSE.txt in download package 
# for full license details
# BUGS
# Can't startup phpcron or execute most system calls in Windows, 
# although stop and other functions work
# Other Bugs can be reported via the online manual:
# http://www.gemini1consulting.com/tekhelp/online_manuals/phpcron/
# NOTES
# This is the browser based interface to phpcron.php.
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

/*********** Version Check Before Anything Else *************/
$version_installed=phpversion();
$version_required="4.0.1";
$version_required=explode(".", $version_required);

if (!ereg( "[[$version_required[0]-9]\.[$version_required[1]-9]\.[$version_required[2]-9].*", $version_installed )){

echo "
<HTML>
<head>
<title>
ERROR: Requires At Least Version $version_required
</title>
</head>
<body>
<h2>
Sorry, Phpcron_admin requires at least PHP Version 4.0.1, your server is running $version_installed
</h2>
</body>
</html>
";
exit;
}



/*ROBODOC*d phpcron_admin/CURRENT_DIRECTORY
# 
# NAME
# CURRENT_DIRECTORY - constant giving path for current directory
# 
# DESCRIPTION
# Constant containing path for directory of script being executed.  This is
# mainly used to expand directories when paths are sent to the screen and the
# a path  otherwise would have no directory name since it is in the current
# directory. See formatPath
# 
#  
*ROBODOC_END*/

define ("CURRENT_DIRECTORY",addslashes(realpath(dirname(__FILE__))));

 /*****Begin User Setting ***************************

/*ROBODOC*v phpcron_admin/$phpcron_directory
# NAME  
# $phpcron_directory - path to directory holding phpcron.php  
# DESCRIPTION        
# This is the only variable you need to set after  installing.   Its value is the
# directory in which you put phpcron.php and all supporting  scripts  (other than
# this script, phpcron_admin.php) in the  installation  package,  including
# phpcron_commonlib.php,phpcron_userconfig.php,  and   phpcrontab.conf.
*ROBODOC_END*/


$phpcron_directory=CURRENT_DIRECTORY."/"; //make sure put end slash



/*ROBODOC*v phpcron_admin/$phpcron_output
# NAME  
# $phpcron_output - name and path of output file
# DESCRIPTION        
# This is the file which all output is redirected when the
# -r flag is used. See $cl_help
*ROBODOC_END*/




$phpcron_output_file=$phpcron_directory."phpcron_output";


/*ROBODOC*v phpcron_admin/$secure
# NAME  
# $secure - set to implement some security features
# DESCRIPTION        
# Make this true to turn on some security features. The
# only thing this does now is turn off the "save as"
# text box on the edit screens
*ROBODOC_END*/



$secure=true;




//$phpcron_directory="/home/httpd/html/phpcron/"; //make sure put end slash

/****** End User Settings *******/
/***Initialize Some Variables and Constants ****/

/*ROBODOC*v phpcron_admin/$user_config_file
# NAME
# $user_config_file - contains path and filename of user configuration
# file
*ROBODOC_END*/



$user_config_file=$phpcron_directory."phpcron_userconfig.php";



if($download_log) {

     include($user_config_file);
     include_once($phpcron_directory."phpcron_commonlib.php");    //import common library function
  
  $download_file_name="phpcron_logfile_".date("m-d-y_H.i").".txt";    
  if(!downloadFile($log_result_file, $download_file_name)) {
  $error_messages.="Error: Unable to Download Log File $download_file_name";
  } else {
  exit;  
  }
}






 header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");    // Date in the past
 header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
                                                       // always modified
 header ("Cache-Control: no-cache, must-revalidate");  // HTTP/1.1
 header ("Pragma: no-cache");                          // HTTP/1.0

 ?>


<html>
<head>

<style type="text/css">

.ahem {
  display: none;
}


.notes {

   background-color: white;
   font-size: 12px;
   font-family: Sans-Serif;



}


.errorMsg {
background-color : white;
color: red;
font-weight: 700;
font-size: 16px;
}

.menuBar {
   background-color : #9999CC;
    border-style : inset;
    border-width : 2px;
    border-color : white;
   font-size: 14px;
   color: black;

  }

A:link {color: blue;
text-decoration: none}

A:visited {color: blue;
text-decoration: none}

A:active {color: blue;
text-decoration: none}

A:hover {color: blue;
text-decoration: underline;
}

 BODY {
   background-color: white;
   font-size: 12px;
     margin-left: 0.5in;
   margin-right: 0.5in;
}


INPUT{

background-color: silver;
color: black;
font-weight: 300;
font-family: Verdana, Courier New;
}


INPUT.title{

background-color: #9999cc;
color: black;
font-weight: 300;
font-family: Verdana, Courier New;
}

INPUT.COLOR{
cursor: text;
background-color: white;
color: black;
font-weight: 300;
font-family: Verdana, Courier New;
}

TEXTAREA {
cursor: text;
background-color: white;
color: black;
font-weight: 300;
font-size: 12px;

}

TEXTAREA.FULLEDIT {
cursor: text;
background-color: white;
color: black;
font-weight: 300;
font-size: 14px;

}



</style>

<?php

/*style definitions (gets around a css table bug in NS 4.75 that won't display named styles in TD's)*/

//style definitions for control panel

$status_off="\"background-color : red; color: white; font-weight: 700; font-size: 15px; \"";

$status_on="\"background-color : green; color: white; font-weight: 700; font-size: 15px; \"";

$status_venabled="\"background-color : yellow; color: black; font-weight: 700; font-size: 15px; \"";


$cp_left_col="\"background-color : #ccccff; border-style : inset; border-width : 2px; border-color : White;\"";

$cp_right_col="\"background-color : Silver;  border-style : inset; border-width : 2px; border-color : White;\"";

$cp_title="\" background-color : #9999cc; border-style : inset; border-width : 2px; border-color : White; font-size: 16px;\"";

$cp_row_title ="\" background-color : #9999cc; border-style : inset; border-width : 2px; border-color : White;font-size: 16px;\"";

//style definitions for edit phpcrontabfile

$edit_table_title="\"font-weight: bold; background-color : #9999cc; border-style : inset; border-width : 2px; border-color : #9999cc; font-size: 16px;\"";
$edit_table_title_no_border="\"font-weight: bold; background-color : #9999cc;font-size: 16px;\"";
$edit_tab_by_form="\" background-color : silver; border-style : inset; border-width : 2px; border-color : White;font-size: 12px;\"";

//style definitions for full edit
$full_edit_title="\"font-weight: bold; background-color : #9999cc; border-style : inset; border-width : 2px; border-color : #9999cc; font-size: 16px;\"";



?>

<title>

<?php

/***********Start Includes *****************************************************/


  if (file_exists($user_config_file)) {
    include($user_config_file);

  } else {
    echo pageTitle("Fatal Error - No User Configuration File");
   echo menuBar();
    echoErrorMessages("Fatal Error: Cannot continue - user configuration file $user_config_file does
    not exist.  Please edit phpcron_admin.php to make sure \$phpcron_directory is set properly.<br>");
    exit;
  }


  if (file_exists($phpcron_directory."phpcron_commonlib.php") ) {
   include($phpcron_directory."phpcron_commonlib.php");    //import common library functions
  } else {
  echo pageTitle("Fatal Error - No Library File");
   echo menuBar();
  echoErrorMessages("Fatal Error: Cannot continue - cannot find common library file phpcron_commonlib.php.
  Please edit phpcron_admin.php to make sure \$phpcron_directory is set properly.<br><br>");
  exit;

  }


/***********End Includes *****************************************************/


/*********** Variables for Edit_UC_by_Form and Save_UC*************************/

/*ROBODOC*v phpcron_admin/$left_mlc_ch
# NAME
# $left_mlc_ch - contains beginning characters marking beginning of multiline
#                comment 
*ROBODOC_END*/

      /*These are used for Save_UC_Form and Edit_UC_by_Form */

$left_mlc_ch="/*"; //beginning characters for multiline comment

/*ROBODOC*v phpcron_admin/$right_mlc_ch
# 
# NAME
# $right_mlc_ch - contains end characters of multiline comment for userconfig parse
# 
*ROBODOC_END*/

$right_mlc_ch="*/"; //ending characters for right multiline comment

/*ROBODOC*v phpcron_admin/$sc_ch
# 
# NAME
# $sc_ch - contains start characters for single line comments, used in userconfig parse
# 
*ROBODOC_END*/

$sc_ch="//"; //single comment character //

/*ROBODOC*v phpcron_admin/$uc_contents
# 
# NAME
# $uc_contents - contents of $user_config_file
# NOTES 
# See cpPhpcron, parseUserConfig, rebuildUserCfg
*ROBODOC_END*/

$uc_contents = addslashes(implode ("", file ($user_config_file)));

/*ROBODOC*v phpcron_admin/$uc_contents_length
# 
# NAME
# $uc_contents_length - length of $uc_contents
*ROBODOC_END*/

$uc_contents_length=strlen($uc_contents);

/*********** End Definitions for Delimiter Characters for Comments **************/





  $phpcrontab_filename=addslashes($phpcrontab_filename);
  $param_headings_printed=false;

      /*If new tab file name is specified by calling script then set to new name
      Save old filename in case new one is bad or if need to display edited contents */
      $old_tabfilename=$phpcrontab_filename;
      if(trim($new_tabfilename)) {
        $phpcrontab_filename=$new_tabfilename;
      } elseif ($current_tabfilename) {
      $phpcrontab_filename=stripslashes($current_tabfilename);
      }
?>


<?php

/*ROBODOC*v phpcron_admin/$admin_subpage
# 
# NAME
# $admin_subpage - main url variable which determines which page to display
*ROBODOC_END*/


  switch ($admin_subpage) {



    case "Edit_Tab_By_Form":      //allow structured editing
       echo pageTitle("PHPCRON Admin - Change Options");
      echo menuBar();
        editTabByForm($phpcrontab_filename);
      echo menuBar();
        break;

    case "Save_Edtab":  //save edits from Edtab

     /* Build Tab contents */
     $new_tab_contents=buildNewtab($max_line_number, $phpcrontab_filename, $ct_param,
                $commands, $side_line_comments, $top_line_comments, $bottom_line_comments);    /* Validate Form, if there are errors, don't save */

    if($tab_errors=isTabFormBad($ct_param, $commands)) {
        $error_messages.=$tab_errors;
      $tab_validation_error=true;
      $tab_save_error=true; //This allows current data to be kept
    } else {

        /* Check for Existence of File and Verify want to Overwrite */

        if (file_exists($phpcrontab_filename) and !$overwrite) {
          $error_messages.="Unable to save - file already exists. If you would like to save over ".formatPath($phpcrontab_filename).",
        check the Save Over box.<br>";
        $tab_save_error=true;

        } else {

           /* Save File */

    

          $save_results=saveFile($new_tab_contents, $phpcrontab_filename);

            if(isset($save_results[0])) { //this would be successful save

          $error_messages.=$save_results[0];
          } else {
	   
            $index=1;
            while($save_results[$index]) {
            $error_messages.=$save_results[$index];
            $index++;
            }

	   
	
	    
	    
            $element=0;
            $tab_save_error=true;
            $error_messages.="Error: Cannot save file, please fix and try again.<br>";
          }

        }

      }

       if ($tab_validation_error) {
       
      $error_messages.= "
        <script language=\"javascript\" type=\"text/javascript\">
        <!--
        document.write(\"<p><h3>Please Press the RE-Edit Button, Fix the Errors, and Re-Submit. <br>Thank you. <br><br><input type=submit value='Re-Edit' onClick='window.history.back()'</h3>\");
        -->
        </script>
          <NOSCRIPT>
        <br>
        <br>
        <p>
        <h3>Please Press the Back Button On Your Browser, Fix the Errors, and Re-Submit.<br> Thank you.<h3>
        </NOSCRIPT>        
        ";
      }
         echo pageTitle("PHPCRON Admin - Schedule by Form");
      echo menuBar();
      if($error_messages) {echoErrorMessages($error_messages);}
      
      editTabByForm($phpcrontab_filename);
      
      echo menuBar();
    
    
        break;

    case "Edit_Tab_Full":      //allow full editing
    $error_messages="";

    if($current_filename) {   // this is only true if there is a file being saved

      if($new_filename){ //if this is a "save as" then save with new file name
      $save_filename=$new_filename;
      } else {
      $save_filename=$current_filename;
      }

      if (file_exists($save_filename) and !$overwrite) {
        $error_messages.="Unable to save - file already exists. If you would like to save over ".formatPath($save_filename).",
      check the Save Over box.<br>";
      $fe_save_error=true;

      } else {

        /* Save File */
      
        $save_results=saveFile($modified_contents, $save_filename);

          if($save_results[0]) { //this would be successful save
      
        $error_messages.=$save_results[0];
        } else {
          $index=1;
          while($save_results[$index]) {
          $error_messages.=$save_results[$index];
          $index++;
          }
          $element=0;
          $fe_save_error=true;
        }
        }

      }

    //echo to screen

    echo pageTitle("PHPCRON Admin - Schedule Programs (Advanced)");
    echo menuBar();
    if($error_messages) {
        echoErrorMessages($error_messages);
    }
    fullEditBox($phpcrontab_filename, "Schedule Programs - Advanced");
     echo menuBar();


    $error_messages="";
    break;


    case "Edit_UC_Full":  //allow direct editing/saving of entire file

       $error_messages="";

    if($current_filename) {   // this is only true if there is a file being saved


      if($new_filename){ //if this is a "save as" then save with new file name
      $save_filename=$new_filename;
      } else {
      $save_filename=$current_filename;
      }


      if (file_exists($save_filename) and !$overwrite) {
        $error_messages.="Unable to save - file already exists.
      If you would like to save over ".formatPath($save_filename).",
      check the Save Over box.<br>";
      $fe_save_error=true;

      } else {

        /* Save File */
        $modified_contents=stripslashes($modified_contents);

        if($parse_errors=isBadPHP($modified_contents, $save_filename)) {

          $error_messages.="
          $parse_errors
          <br>
          Please fix and save again."; //don't save the file and report the error
          $fe_save_error=true;
  
        }   else { //save the file
  

  
                $save_results=saveFile($modified_contents, $save_filename);
      
                  if($save_results[0]) { //this would be successful save        
                $error_messages.=$save_results[0];
                } else {
                  $index=2;
                  while($save_results[$index]) {
                  $error_messages.=$save_results[$index];
                  $index++;
                  }
                  $element=0;
                  $fe_save_error=true;
                }
  
        }
       }
    }

    //echo to screen

    echo pageTitle("PHPCRON Admin - Change Options (Advanced)");
    echo menuBar();
    if($error_messages) {
        echoErrorMessages($error_messages);
    }
    fullEditBox($user_config_file, "Change Options - Advanced");
     echo menuBar();

    break;


    case "Control_Panel":
       cpPhpcron ($phpcron_command);
    
        break;

   default :

       cpPhpcron ($phpcron_command);
        break;
}
echo "</body>
    </html>";

/*****Begin Functions **/

/********Housekeeping Functions **************/


/*ROBODOC*f phpcron_admin/clearLogFile
# NAME
# clearLogFile - clears the log file
# SYNOPSIS
# boolean  clearLogFile(string $log_result_file);
# INPUTS
# $log_result_file   - file which phpcron.php logs all execution results to
# FUNCTION
# Deletes the log file and stamps it with the time
# that it was cleared.
# RESULT
# Returns true if cleared, false if was not able to be cleared.
# SOURCE
*/

function clearLogFile($log_result_file) {
/* Clears Log file, returns false on success, true and error messages on failure */

$clear_time= date("m/d/Y").":".date("h:i:s:A");
if(!deleteFile($log_result_file)) {
$error_messages="Cannot delete $log_result_file - Check path and permissions.<br>";
} else {

$clear_message="
***********************************************************
PHPCRON Log File Cleared on $clear_time

***********************************************************
";

//append to log file and  get error messages, not success message
$append_results=appendToFile($clear_message,$log_result_file);
$append_results[0]="";
if(trim($append_results)) {
$error_messages.=implode(" ",$append_results);
}


}
return $error_messages; //if there are errors, this will return true, if not, false

}

/*ROBODOC_END*/

/***Validation Functions */

/*ROBODOC*f phpcron_admin/isBadPhp
# NAME
# isBadPhp - checks to see if there are any parse errors in a PHP file
# SYNOPSIS
# mixed  isBadPhp(string $file_contents, string $file_name)
# FUNCTION
# This functions checks $file_contents to see if it has any PHP errors in it 
# (syntax or otherwise) and returns those errors. It does so by saving a
# temporary  file with file_contents  to the web server document root directory
# and then   opening a url to it. 
# 
# This should only be used on files that don't have any output - since it
# assumes  that any  output is an error (i.e., mainly intended to check if the
# syntax of  the included  user configuration file is ok.)
 
# INPUTS
# $file_contents - contains contents of $file_name file to be checked for errors
# 
# $file_name     - contains full path of an existing file, the contents of which
# are $file_contents
# 
# PURPOSE
# The primary purpose of this function is to make sure that the user 
# configuration file does not have an error in it before it is saved  if it is
# being edited through phpcron_admin. This could happen  if the user mistakenly
# enters erroneous statements - especially  in the free style edit mode. Since
# the userconfiguration file  is included both in phpcron_admin.php and
# phpcron.php  this could have disasterous results unless syntax errors, etc. 
# are anticipated.
# 
# RESULT
# It returns the PHP error messages, if none, returns false.  
# 
# NOTES
# 
# This requires the web server to have read/write permissions to the
# web server's root document directory.
# 
# SOURCE
*/


function isBadPHP($file_contents, $file_name) {


global $DOCUMENT_ROOT;
global $SERVER_NAME;
global $phpcron_directory;


$file_name=$DOCUMENT_ROOT."/".basename($file_name).".tmp.php"; //add temporary extension
$save_results=saveFile(trim($file_contents), $file_name);

if(!$save_results[0]) { //if not a successful save
$save_results=implode("",$save_results);
$error_messages.="Save results: $save_results";


$index=2;
 /* $error_messages.="
  Error: Cannot save $file_name, verify permissions allow writing to file.<br>
  Error: Cannot save temporary file - verify permissions allow writing to ".formatPath($phpcron_directory)."<br>";
  */
  while(isset($save_results[$index])) {
  $error_messages.=$save_results[$index];
  $index++;
  }

  return $error_messages;
}

$handle = fopen ("http://$SERVER_NAME/".basename($file_name), "r");

while (!feof($handle)) {
$contents.=fread($handle,4096);

}

fclose($handle);
$contents=trim(strip_tags($contents));
//get rid of reference to temporary file name
$contents=str_replace ("in ".formatPath($file_name),"", $contents);
deleteFile($file_name);

/*If the output from the open has any characters in it at
   all we are assuming there are errors*/

if ($contents) {
  return "The following PHP errors are in your file<br>\r\n".$contents;
} else {
  return false;
}



} //end of function

/*ROBODOC_END*/


/*ROBODOC*f phpcron_admin/isTabFormBad
# NAME
# isTabFormBad - validates phpcrontab.conf created by editTabByForm function
# SYNOPSIS
# boolean isTabFormBad (array $ct_param, array $commands)
# FUNCTION
# This functions checks $ct_param and $commands which are generated by
# editTabByForm  they conform with proper crontab format. 
# INPUTS
# $ct_params - 2 dimensional array which contains scheduling parameters for 
# 	      phpcrontab.conf.
# 
# $commands   - array which contains scheduled phpcrontab commands. 
# RESULT
# It returns true if there is a validation error, false if the phpcrontab
# contents are valid.
# NOTES
# See editTabByForm.
# SOURCE
*/

function isTabFormBad($ct_param, $commands) {
/* Validate parameters in Chron Tab Form Submitted from Structured Edit */

$command_number=0;

          /* Cycle through each parameter */
             while (list($first, $second) = each($ct_param)) {
              $command_number++;
              while (list($each_second) = each($second)) {

                      $test_value=trim($ct_param[$first][$each_second]);
                     $commands[$first]=trim($commands[$first]);

                     /* If it's an asterisk than it's ok - continue to next value */

                     if ($test_value =="*") {
                       continue;
                     }
              }


                     /* If either there are any parameters for this line or
                     there are commands for this line than validate each parameter
                     for correct format */

                     //test if either a time parameter or commands are entered
                     $test_whole_string=trim(implode(" ",$ct_param[$first]));
		     
		     if ($test_whole_string or $commands[$first]) {

                     $error_messages.=isCronTimeParamsBad($test_whole_string, $command_number);
		     }
                      
    
                   
                   
            }
            
            /* If there are time parameters and no commands than give error */
            if (trim(implode("",$ct_param[$first])) and !$commands[$first])  {
  
            $error_messages.="Error in Command #$command_number: The commands field is empty<br>";
  
            }

          
          if ($error_messages) {
            return "<h3>Cannot save because of validation errors - please fix and try again:</h3>
                  $error_messages";
          } else {
            return false;
          }

}
/*ROBODOC_END*/

/* Layout Functions */

 
 /*ROBODOC*f phpcron_admin/echoErrorMessages
# NAME
# isTabFormBad - validates phpcrontab.conf created by editTabByForm function
# SYNOPSIS
# void echoErrorMessages (string $error_message)
# FUNCTION
# Formats and highlight $error_message string and outputs to screen.
# INPUTS
# string $error_message - string containing error message (can also be a non-error 
# 		         message to user) 
# RESULT
# Echoes to screen a formatted string containing HTML and highligted 
# $error_message. 
# SOURCE
*/

function echoErrorMessages($error_message) {
   echo "
    <hr>
    <!--**********Begin Error Messages**************-->
    <table border=\"0\" width=\"100%\" summary=\"Error Messages\">
    <tr>
      <td >
      <span class=\"errorMsg\">$error_message</span>
      </td>
     </tr>
     </table>

    <hr>
    <!--**********End Error Messages**************-->
    ";
}
/*ROBODOC_END*/

/*ROBODOC*f phpcron_admin/menuBar
# NAME 
# menuBar
# SYNOPSIS
# string menuBar(void)
# FUNCTION
# Contains the HTML for the main navigational menu bar
# INPUTS
# RESULT
# Returns a formatted string containing HTML for the menu bar.
# SOURCE
*/

function menuBar() {
global $PHP_SELF;


  //Print Horizontal Menu Bar
$output="
  <!--**********Begin Menu Bar**************-->
  <table border=\"0\" cellspacing=\"0\" cellpadding=\"1\" align=\"center\" width=\"700px\" class=\"menuBar\" bgcolor=\"#9999CC\" summary=\"Menu Bar\">
  <tr>
    <td align=\"center\" width=\"25%\">
      <a href=\"$PHP_SELF?admin_subpage=Control_Panel\" title=\"Turn ON/OFF, Set Options\">Control Panel</a>
    </td>
    <td>
    |
    </td>
    <td align=\"center\" width=\"25%\">
      <a href=\"$PHP_SELF?admin_subpage=Edit_UC_Full\" title=\"Directly Edit Options\">Set Options (Advanced)</a>
    </td>
    <td>
    |
    </td>
    <td align=\"center\" width=\"25%\">
      <a href=\"$PHP_SELF"."?admin_subpage=Edit_Tab_By_Form\" title=\"Form Edit of Phpcrontab\">Edit Schedule (Basic)</a>
    </td>
    <td>
    |
    </td>
    <td align=\"center\" width=\"25%\">
      <a href=\"$PHP_SELF?admin_subpage=Edit_Tab_Full\" title=\"Directly Edit Phpcrontab\">Edit Schedule (Advanced)<br></a>
    </td>
  </tr>
  
  </table>
  <!--**********End Menu Bar**************-->
  ";

return $output;
    

} 

/*ROBODOC_END*/

  
/*ROBODOC*f phpcron_admin/pageTitle
# NAME 
# pageTitle
# SYNOPSIS
# string pageTitle(string $title)
# FUNCTION
# Completes the header for the HTML page inserting the page title, ending title
# and head ta and creating the opening body tag
# INPUTS
# $title - string containing the title of the HTML page
# RESULT
# Returns a formatted string containing HTML for the end of the <head> and 
#  beginning of the body tag
# SOURCE
*/

function pageTitle($title) {
  return "
  $title
  </title>
  </head>
  <body>
  
<!--Begin Note for Non Compliant Browsers |*-->

      <p class=\"ahem\" > 
    <font size=2px> 
    <strong> 
    <em>
          For a better viewing experience, either turn your CSS stylesheets
        on in your browser, or if your browser does not support stylesheets, 
      <a href=\"http://www.webstandards.org/upgrade/\"
        title=\"Download a browser that complies with Web standards.\">download </a> a
        browser that complies with web standards. Some browsers disable stylesheets when
        JavaScript is disabled. 
    </em>
    </strong>    
    </font>
      </p>

      <NOSCRIPT>
          <p class=type1>  <font size=2px> <strong> <em> Either you have JavaScript
       turned off in your browser or your browser does not
           support JavaScript. Although this site supports non-JavaScript browsers,
           for better functionality you may want to <a href=\"http://www.webstandards.org/upgrade/\"
          title=\"Download a browser that complies with Web standards.\">download </a>
       a JavaScript enabled browser.
          </em> 
       </strong>
       </font>
          </p><br/>
       </NOSCRIPT>

<!--End Note for Non Compliant Browsers *|-->
    ";
}

/*ROBODOC_END*/

/*  Primary Processing Functions for Editing, Parsing, Configuration Files etc.*/

/*ROBODOC*f phpcron_admin/buildNewtab
# NAME
# buildNewtab
# SYNOPSIS
# string buildNewtab(int $max_line_number, string $phpcrontab_filename, array
# $ct_param, array $commands, array $side_line_comments);
# 
# FUNCTION
# Takes information from editTabByForm and creates new file contents to be 
# saved over phpcrontab.conf
# INPUTS
# int $max_line_number 		- max number of lines in file
# string $phpcrontab_filename   - filename of phpcrontab.conf
# array $ct_param 		- array containing scheduling parameters
# array $commands 		- array containing comments
# array $side_line_comments	- array containing single line # comments 
# RESULT
# Returns a string containing the contents of the new phpcrontab.conf file
# NOTES
# See editTabByForm
# SOURCE
*/


function buildNewtab($max_line_number, $phpcrontab_filename, $ct_param, $commands, $side_line_comments, $top_line_comments, $bottom_line_comments) {
  
    global $PHP_SELF;

     $line_number=0;
     /* Get rid of # as first character of each line (in case user inserted it) */
     $top_line_comments=preg_replace("/^#/m", "", trim($top_line_comments));
     /* Inserts # as first character of each line */
     $top_line_comments=preg_replace("/^(.)/m", "#\\1", trim($top_line_comments));
      $bottom_line_comments=preg_replace("/^#/m", "", trim($bottom_line_comments));
     $bottom_line_comments=preg_replace("/^(.)/m", "#\\1", trim($bottom_line_comments));

     $new_tab_contents.=$top_line_comments."\r\n\r\n";

        while($line_number< $max_line_number) {

                if($ct_param[$line_number]) {
                    $parameters=implode(" ", $ct_param[$line_number]);
                    $new_tab_contents.=$parameters." ".$commands[$line_number];
                    if($side_line_comments[$line_number]) {
                      $side_line_comments[$line_number]=preg_replace("/^#/m", "", trim($side_line_comments[$line_number]));
                      $side_line_comments[$line_number]=preg_replace("/^(.)/m", "#\\1", trim($side_line_comments[$line_number]));   
                    $new_tab_contents.="  ".$side_line_comments[$line_number]."\r\n";
                    } else {
		    $new_tab_contents.="\r\n";
		    } 
               }

          $line_number++;  
        }
      
        $new_tab_contents.="\r\n\r\n".$bottom_line_comments;
	
        return trim($new_tab_contents); //contents of file to be saved
	
       
}

/*ROBODOC_END*/


/*ROBODOC*f phpcron_admin/cpPhpcron
# NAME
# cpPhpcron
# SYNOPSIS
# void cpPhpcron ([string $phpcron_command]) 
# FUNCTION
# Displays control panel page controlling activity of phpcron.php
# INPUTS
# string $phpcron_command - option argument which determines which command
# 			   to pass to phpcron (see switch statement)
# RESULT
# Echoes the control panel page to the screen
# SOURCE
*/



  
function cpPhpcron ($phpcron_command="default") {
  global $PHP_SELF;

  global $phpcron_file;
  global $phpcron_off;
  global $phpcron_psinfo_file;
  global $assignment_info,$user_config_file, $left_mlc_ch, $right_mlc_ch, $sc_ch, $uc_contents_length;
  global $uc_contents, $uc_contents_length;
  global $cp_left_col;
  global $cp_right_col;
  global $cp_row_title;
  global $cp_title;
  global $status_on;
  global $status_off;
  global $status_venabled;
  global $phpcrontab_filename;
  global $log_result_file;
  global $admin_email_address;
  global $system_name;
  global $daemon_mode;
  global $phpcron_venabled_file;
  global $enable_virtual_daemon;
  global $phpcron_output_file;
  global $admin_email_address;
  global $error_messages;
  global $php_path;

   echo pageTitle("PHPCRON Admin - Control Panel");


  switch ($phpcron_command) {

  case "VStop":

    /* Disable Virtual Daemon */
	 
    if (file_exists($phpcron_venabled_file)) {
         
    
    deleteFile($phpcron_venabled_file);
    
    appendToFile("
****************************************************************
PHPCRON Virtual Daemon Stopped ".date("m/d/Y").":".date("h:i:s:A")."
****************************************************************
", $log_result_file);

 
    
    
    }

    break;
    
    case "DStop":

    /* Turn off Daemon */
    
    if(!stopOtherPhpcron()) {
     $error_messages.="
    Error: Cannot Stop Phpcron. Make sure the server process can write to ".dirname($phpron_off)."<BR>";
    
    }
  
    
    break;

  case "Start":


 
     $os_formatted_path=formatPath($phpcron_file);

  
	  if ($enable_virtual_daemon) { 

    /*Enable Virtual Daemon */

        /* If no perpetual loop just write "VIRTUAL DAEMON ENABLED" to phpcron_venabled_file. This will
        allow phpcron to be run from the unix crontab with the phpcron_virtuald script. 
         */
	 


       $save_results=saveFile("VIRTUAL DAEMON ENABLED", $phpcron_venabled_file);
	    appendToFile("
****************************************************************
PHPCRON Virtual Daemon Started ".date("m/d/Y").":".date("h:i:s:A")."
****************************************************************
", $log_result_file);



        if(!$save_results[0]) { //if not a successful save get error messages

        $index=1;
        $output="";
        while($save_results[$index]) {
        $output.=$save_results[$index];
        $index++;
        }


    $error_messages.=implode("\r\n",$save_results).
"Cannot Enable Virtual Daemon- Must be able to write to ".formatPath($phpcron_venabled_file)." in order for PHPCRON Admin
to control PHPCRON's execution. You will need to fix, and try again for PHPCRON Admin to work properly.<br>\r\n";

        } else {
	
       $error_messages.="The Virtual Daemon has been enabled. Make sure you place phpcron_virtuald
       on your unix crontab file using crontab -e.\n";



      }

	break;
    }
    
    /* Otherwise Start Up PHPCRON.PHP in either daemon(perpetual) or non-daemon mode) */
         
     if(isOtherPhpcrond() and $daemon_mode) { 
            $error_messages.="PHPCRON is already running in daemon mode - Cannot start more than one instance<br>";

     } else {

      /*Start phpcron in background. NoHup allows it to continue after logout */

   
      if ($daemon_mode) {
      $exec_string="nohup $php_path $os_formatted_path -r $phpcron_output_file > /dev/null &";
            } else {
      $exec_string="$php_path $os_formatted_path -r $phpcron_output_file";
               
      }
      //$error_messages.=$exec_string;
       exec($exec_string);


      sleep(1);    

      
      
      if (!$daemon_mode) {
      $error_messages.="Ran PHPCRON only once. This is usually only 
      done for testing purposes.<br>\n";
      
      } 
      
    } 
      
          /* Know there's an error somewhere if the output file can't be made */
	 
	    if (!file_exists("$phpcron_output_file")) {

	     $error_messages.= "
        	  Error: Failed to execute $phpcron_file. Check path and permissions. Can't read $phpcron_output_file.
        	  <br>
        	  ";
    	    }





    break;


  case "Email_Log":

  $attachment=$log_result_file;
  $mimetype="text/english";

  $subject="$system_name PHPCRON Log File Attached";
  $body="PHPCRON Log file is attached for $system_name";

if($mailserver_error=mailAttachment($log_email_address, $subject, $body, $attachment, $mimetype)) {


  $error_messages.="Error: Unable to Email Log File:<br>\r\n".$mailserver_error;
  } else {
  $error_messages.="Emailed Log File to $admin_email_address";
  }

  break;
  
  
  

 case "Delete_Log":
   $error_messages.=clearLogFile($log_result_file);
   break;



  case "Save_UC":


    list($uc_contents, $uc_contents_array)=parseUserConfig($user_config_file, $left_mlc_ch, $right_mlc_ch, $sc_ch);

    /* For Debugging (echo to screen instead of save):
    echo "File Rebuilt is: ".nl2br(htmlentities(rebuildUserCfg($assignment_info, $uc_contents_array)))."<br>";

    */

    /* Rebuild User Configuration File, then Save it */

      $save_results=saveFile(rebuildUserCfg($assignment_info, $uc_contents_array), $user_config_file);

        if($save_results[0]) { //this would be successful save
    
        $settings_state="
        <em>
        Options saved with the following settings:
        </em>
        <br>
        ";
      } else {
        $index=1;
        while($save_results[$index]) {
        $error_messages.=$save_results[$index];
        $index++;
        }
        $element=0;
        $tab_save_error=true;
        $error_messages.="Please fix and try again.<br>";


      }

     

  
    //Load Newly Saved File

    $uc_contents = addslashes(implode ("", file ($user_config_file)));
    $uc_contents_length=strlen($uc_contents);  
    
    /* Include new values to override old values included at top of file */
    include($user_config_file); 
  //no break - just let it flow into default

  default:
  break;
}

  
  /* Build Main Control Panel Box */

  $output.=    "
    <!--**********Begin JavaScript*******************-->
    <SCRIPT LANGUAGE=\"JavaScript\" type=\"text/javascript\">
     <!--  


   function isNumber(theField) {
   string=theField.value;
    for (i = 0; i < string.length; i++)   {   
          // Check that each character is number.
          var c = string.charAt(i);
  
          if (!((c >= \"0\") && (c <= \"9\")))  {
        
        alert(\"This field requires a number.\");
        theField.focus();
        return false;
        }
      }
     return true;
   }

    -->    

    </SCRIPT>
    <!--**********End JavaScript*******************-->

  <!--**********Begin Control Panel Table**************-->
  <table align=\"center\" border=\"0\" class=\"control_panel\" cellpadding=\"2\" cellspacing=\"0\" width=\"600px\" summary=\"Control Panel\">
        <tr>
        <td align=\"center\" valign=\"middle\" colspan=\"2\" style=$cp_title>
                <strong>PHPCRON CONTROL PANEL</strong>
        </td>
      </tr>
      <tr>
          <td align=\"center\" valign=\"middle\" colspan=\"2\" style=$cp_row_title>
              <strong>Status</strong>
          </td>
      </tr>
      <tr>
        <td style=$cp_left_col>
          Server OS:
        </td>
        <td style=$cp_right_col>
            ".PHP_OS."
        </td>
        </tr>
        ";

  if (isOtherPhpcrond()) {

  $daemon_running=true;
  }
  
  $output.="
        <tr>
          <td style=$cp_left_col>
            Mode:
          </td>
	  ";
  if ($daemon_mode) {
    $output.="
         <td style=$cp_right_col>
            Daemon
          </td>
	  </tr>
	  ";
    
  } else {
  
   $output.="<td style=$cp_right_col>
            Non-Daemon
          </td>
	  </tr>
	  ";  
    
  }
  
    $output.="

        <tr>
          <td style=$cp_left_col>
            Daemon Running ?
          </td>
	  ";
  
	  
  if($daemon_running) {
  $output.="
          <td style=$status_on>
            Yes
          </td>
        </tr>";
	

  } else {
  
    $output.="
          <td style=$status_off>
            No
          </td>
        </tr>";
	  
  
  
  }


  //Echo Process Info if in Unix
  if(!MS_WINDOWS and file_exists($phpcron_psinfo_file)) {

        $file_contents=file($phpcron_psinfo_file);

          $output.= "
              <tr>
              <td style=$cp_left_col>
                 Owner:
               </td>
              <td style=$cp_right_col>
                  $file_contents[1]<br>
              </td>
            </tr>
            <tr>
              <td style=$cp_left_col>
                 Process Id:
               </td>
              <td style=$cp_right_col>
                  $file_contents[2]
                  <br>
                  <br>
              </td>
            </tr>
            ";

    }

  $output.="
    <tr>
        <td valign=\"baseline\" style=$cp_left_col>
          Start/Stop Controls:
        </td>
          ";
  
  if (MS_WINDOWS){
  if (!$daemon_running) {
  $output.="
     <td style=$cp_right_col>
  Start Control Not Available in Windows
  </td>
  </tr>
  <tr>";
  }
  
     
  $end_output .= "Please note that PHPCRON Admin does not allow starting PHPCRON under any Microsoft
  operating system (this may be fixed in a future version).  If using PHPCRON on a remote server, you 
  will need to start PHPCRON through a telnet session. A start control will only appear and work under Unix.
  You can however, enable the Virtual Daemon
  <br>
  ";
  }

  

  
 
  if (!MS_WINDOWS and $daemon_mode and !$daemon_running) {  
      $output.="
      <td style=$cp_right_col>
      <form action=$PHP_SELF method=\"post\">
      <input type=\"hidden\" name=\"phpcron_command\" value=\"Start\">
      <input type=\"submit\" value=\"Start Daemon\">
        </form>
	</td>
      ";
      
  } elseif (!MS_WINDOWS and !$daemon_mode and !$daemon_running) {
  
  $output.="
  
      <td style=$cp_right_col>
      <form action=$PHP_SELF method=\"post\">
        <input type=\"hidden\" name=\"phpcron_command\" value=\"Start\">
  	<input type=\"submit\" value=\"Run PHPCRON Once\">
        </form>
	</td>
      ";
  
   
  }

  
 if ($daemon_running) {

 $output.="
         <td style=$cp_right_col>
        <form action=\"$PHP_SELF\" method=\"post\">
        <input type=\"hidden\" name=\"admin_subpage\" value=\"Control_Panel\">
        <input type=\"hidden\" name=\"phpcron_command\" value=\"DStop\">
        <input type=\"submit\" value=\"Stop Daemon\">
        </form>
        </td>        
        ";

}


  $output.="  
        </tr>
        <tr>
          <td align=\"center\" valign=\"middle\" colspan=\"2\" style=$cp_row_title>
              <strong>Virtual Daemon</strong>
          </td>
      </tr>    
  
        <tr>
          <td style=$cp_left_col>
            Virtual Daemon:
          </td>
	  ";
  
  
  if (file_exists($phpcron_venabled_file)) {
      $output.="
          <td style=$status_on >
            Enabled
	 </td>
        </tr>
        ";
   
  } else {
      $output.="
          <td style=$status_off >
             Disabled
          </td>
        </tr>
        ";
  }



if (file_exists($phpcron_venabled_file)) {

 
  $output.="
	<tr>
        <td style=$cp_left_col>
	&nbsp;
        </td>
	<td style=$cp_right_col>    
        <form action=\"$PHP_SELF\" method=\"post\">
        <input type=\"hidden\" name=\"admin_subpage\" value=\"Control_Panel\">
        <input type=\"hidden\" name=\"phpcron_command\" value=\"VStop\">
        <input type=\"submit\" value=\"Disable\">
        </form>
        </td>
        
        ";

} else {

    $output.="
      <tr>
      <td style=$cp_left_col>
      	&nbsp;
      </td>
    
      <td style=$cp_right_col>    
      <form action=$PHP_SELF method=\"post\">
      <input type=\"hidden\" name=\"phpcron_command\" value=\"Start\">       
      <input type=\"hidden\" name=\"enable_virtual_daemon\" value=\"true\">   
      <input type=\"submit\" value=\"Enable\">
        </form>
	</td>
	
      ";


}



  /* Save and Reset of Options */


    //allow to revert to original file
  $output.="

      </tr>
		<tr>
          <td align=\"center\" valign=\"middle\" colspan=\"2\" style=$cp_row_title>
              <strong>Update Status</strong>
      </td>
      </tr>    
      <tr>
                <td style=$cp_left_col>
                    &nbsp;
                </td>
                <td style=$cp_right_col>
                <form action=\"$PHP_SELF\" method=\"post\">
                <input type=\"submit\" value=\"Update\">
                <input type=\"hidden\" name=\"admin_subpage\" value=\"Control_Panel\">
                </form>

                <!--************Begin Options Form************ -->


                </td>

      </tr>


      ";

     //Save Options


  /* Build Options Box */

     if($phpcron_command != "Save_UC") {

      $settings_state="
        <em>
        Current Settings:
        </em>
        <br>";
     }
    /*Separate out Multi-Line Comments, Single Line Comments, and Executable Portions of
    file into identifiable arrays stored in $uc_contents_array */
    list($uc_contents, $uc_contents_array)=parseUserConfig($user_config_file, $left_mlc_ch, $right_mlc_ch, $sc_ch);


    //Split up executable string into ordered arrays containing variable, value, and type of variable

      if($assignment_info=getAssignmentInfo($uc_contents_array)){

        $options_output.="
        <tr>
          <td align=\"center\" valign=\"middle\" colspan=\"2\" style=$cp_row_title>
              <form action=\"$PHP_SELF\" method=\"post\">
              <strong>Options</strong>
              <br>
              (Set in ".formatPath($user_config_file).
      ")<br>
              $settings_state
          </td>

        ";


      $horiz_pos=0;
      while($horiz_pos<$uc_contents_length) {

      $i=0;
        while($assignment_info[$horiz_pos][$i]["variable"]) {
            $cell_width="400px";

            $options_output.="
            </tr>
            <tr>
               <td style=$cp_left_col width=\"$cell_width\">".
                $assignment_info[$horiz_pos][$i]["variable"].
                " (".$assignment_info[$horiz_pos][$i]["type"].
                "):".
              "</td>
              <td style=$cp_right_col width=\"$cell_width\" valign=\"middle\">".
                getFormElement($assignment_info[$horiz_pos][$i]["variable"], $assignment_info[$horiz_pos][$i]["value"], $assignment_info[$horiz_pos][$i]["type"], $horiz_pos, $i)."
                <input type=\"hidden\" name=\"assignment_info[$horiz_pos][$i][variable]\" value=\"".$assignment_info[$horiz_pos][$i][variable]."\">
		
                  <input type=\"hidden\" name=\"assignment_info[$horiz_pos][$i][type]\" value=\"".$assignment_info[$horiz_pos][$i]["type"]."\">

              </td>
            ";
            $i++;

        }
      $horiz_pos++;
      }
        $options_output.=
        "

           <!--*****************Begin Submit Buttons *********************-->
         <tr>
              <td style=$cp_left_col>
              <HR>
              </td>
              <td style=$cp_right_col>
              <HR>
              </td>
         </tr>


         <tr>
          <td style=$cp_left_col>
          Save Changes To Options:
          </td>
          <td style=$cp_right_col>

          <input type=\"submit\" value=\"Save\">
          <input type=\"hidden\" name=\"admin_subpage\" value=\"Control_Panel\">
          <input type=\"hidden\" name=\"phpcron_command\" value=\"Save_UC\">
          </form>
          </td>
        </tr>

           <tr>
                <td style=$cp_left_col >
                    Reset Options to Values in File:
                </td>
                <td style=$cp_right_col>
                <form action=\"$PHP_SELF\" method=\"post\">
                <input type=\"submit\" value=\"Reset\">
                <input type=\"hidden\" name=\"admin_subpage\" value=\"Control_Panel\">
                </form>
                </td>

           </tr>

          <!--*****************End Submit Buttons *********************-->



         <!--*************************BEGIN PHPCRONTAB DISPLAY IN TEXT AREA*********************-->
        <tr>

               <td align=\"center\" valign=\"middle\" colspan=\"2\" style=$cp_row_title>
              <strong>PHPCRONTAB SCHEDULE </strong>
              </td>
        </tr>
        <tr>


            <td style=$cp_right_col colspan=\"2\" >
                <form name=\"po_form\">
                  <input type=\"hidden\" name=\"focushere\">
                      <textarea readonly  onFocus=\"this.blur();\" wrap=\"off\" cols=\"80\" rows=\"20\" name=\"command_output_textarea\">";

                      //Read from phpcrontab file
                      $path_errors=isPathBad($phpcrontab_filename,true,true); 
			if ($path_errors) {
//                      $error_messages.="Error: Unable to read file ".formatPath($phpcrontab_filename)."<br>";

                        while ( list($file_or_dir, $error_string) = each($path_errors)) {

                          while (list($each_error)  = each($error_string)) {
                            $error_messages.=$path_errors[$file_or_dir][$each_message];
                          }
                         }
			 }

                          $tab_output=explode("<br>","ERROR: CANNOT DISPLAY PHPCRONTAB\n ");
                        if (is_readable($phpcrontab_filename)) {
                          $tab_output=file($phpcrontab_filename);
                       }

                      $options_output.=implode("",$tab_output)."
                    </textarea>
                </form>
            </td>
        </tr>

         <!--*************************END PHPCRONTAB DISPLAY IN TEXT AREA*********************-->


           <!--*****************Begin Submit Buttons *********************-->
         <tr>

              <td style=$cp_right_col colspan=\"2\">
              <HR>
              </td>
         </tr>



         <tr>
         <!--
                <td style=$cp_left_col >
                    Edit Schedule (Basic):
                </td>
        -->
                <td style=$cp_right_col colspan=\"2\">
                <form action=\"$PHP_SELF\" method=\"post\">
                <input type=\"submit\" value=\"Edit Schedule (Basic)\">
                <input type=\"hidden\" name=\"admin_subpage\" value=\"Edit_Tab_By_Form\">
                </form>
                </td>

           </tr>
           <tr>

              <td style=$cp_right_col colspan=\"2\">
              <HR>
              </td>
         </tr>


          <!--*****************End Submit Buttons *********************-->



    <!--*************************BEGIN PHPCRON OUTPUT DISPLAY IN TEXT AREA*********************-->
        <tr>

               <td align=\"center\" valign=\"middle\" colspan=\"2\" style=$cp_row_title>
              <a name=\"Output_Display\">
              <strong>PHPCRON OUTPUT </strong>
              </a>
              </td>
        </tr>
        <tr>


            <td style=$cp_right_col colspan=\"2\" >
                <form name=\"po_form\">
                  <input type=\"hidden\" name=\"focushere\">
                      <textarea readonly  onFocus=\"this.blur();\" wrap=\"off\" cols=\"80\" rows=\"20\" name=\"command_output_textarea\">";

                      //Read from phpcron_output file
                      if ($path_errors=isPathBad("$phpcron_output_file",true,true)) {

                       $error_messages.="Error: Unable to read output file ".formatPath("$phpcron_output_file")."<br>";

                        while ( list($file_or_dir, $error_string) = each($path_errors)) {

                          while (list($each_error)  = each($error_string)) {
                            $error_messages.=$path_errors[$file_or_dir][$each_error];
                          }
                         }
		
                          $command_output=explode("<br>","ERROR: CANNOT DISPLAY PHPCRON OUTPUT\r\nCannot Read Output File $phpcron_output_file\n ");
			
                       } else {
                          $command_output=file("$phpcron_output_file");
                       }

                      $options_output.=implode("",$command_output)."
                    </textarea>
                </form>
            </td>
        </tr>

         <!--*************************END PHPCRON OUTPUT DISPLAY IN TEXT AREA*********************-->
         <!--*************************BEGIN SUBMIT BUTTONS ****************************-->
         <tr>
                <td style=$cp_right_col colspan=\"2\">
                <form action=\"$PHP_SELF#Output_Display\" method=\"post\">
                <input type=\"submit\" value=\"Update Display\">
                <input type=\"hidden\" name=\"admin_subpage\" value=\"Control_Panel\">
                </form>
                </td>

          </tr>
          <!--*************************END SUBMIT BUTTONS ****************************-->

      <!--*************************BEGIN PHPCRON LOG DISPLAY IN TEXT AREA*********************-->
        <tr>

               <td align=\"center\" valign=\"middle\" colspan=\"2\" style=$cp_row_title>
              <a name=\"log_display\">
              <strong>PHPCRON COMMAND LOG </strong>
              </a>

              </td>
        </tr>
        <tr>



            <td style=$cp_right_col colspan=\"2\">


                <form name=\"log_form\" >

                  <input type=\"hidden\" name=\"focuslog\">
                      <textarea readonly  onFocus=\"this.blur();\" wrap=\"off\" cols=\"80\" rows=\"20\" name=\"command_output_textarea\">";

                      //Read from phpcron_output file
                      if ($path_errors=isPathBad($log_result_file,true,true)) {


		       

                        while ( list($file_or_dir, $error_string) = each($path_errors)) {

                          while (list($each_error)  = each($error_string)) {
                            $error_messages.=$path_errors[$file_or_dir][$each_error];
                          }
                         }
			 
		       $error_messages.="Error: Unable to read log file ".formatPath($log_result_file)."<br>
		       This will occur if Phpcron has not been run as a Daemon or Virtual Daemon yet, since
		       the log is only created at that point.<br>";
		       

                          $log_output=explode("<br>","ERROR: CANNOT DISPLAY LOG FILE\r\nTo create, run Phpcron in Daemon mode or as a Virtual Daemon.\r\n			  
			  ");
                       } else {
                          $log_output=file($log_result_file);
                       }

                      $options_output.=implode("",$log_output)."
                    </textarea>

                </form>

            </td>


        </tr>

         <!--*************************END PHPCRON LOG DISPLAY IN TEXT AREA*********************-->
         <!--*************************BEGIN SUBMIT BUTTONS ****************************-->
         <tr>
                <td style=$cp_right_col colspan=\"2\">
                <form action=\"$PHP_SELF#log_display\" method=\"post\" onSubmit=\"document.log_form.scrollIntoView(false);\">
                <input type=\"submit\" value=\"Update Display\">
                
                </form>
		
		<form action=\"$PHP_SELF\" method=\"post\">
                <input type=\"submit\" value=\"Download Log File\">
                <input type=\"hidden\" name=\"admin_subpage\" value=\"Control_Panel\">
                <input type=\"hidden\" name=\"download_log\" value=\"true\">
                </form>

                <form action=\"$PHP_SELF\" method=\"post\">
                <input type=\"submit\" value=\"Email Log File To:\">
		<input type=\"text\" name=\"log_email_address\" value=\"$admin_email_address\">	
                <input type=\"hidden\" name=\"admin_subpage\" value=\"Control_Panel\">
                <input type=\"hidden\" name=\"phpcron_command\" value=\"Email_Log\">
                </form>
		
                <form action=\"$PHP_SELF\" method=\"post\">
                <input type=\"submit\" value=\"Permanently Clear Log File\">
                <input type=\"hidden\" name=\"admin_subpage\" value=\"Control_Panel\">
                <input type=\"hidden\" name=\"phpcron_command\" value=\"Delete_Log\">
                </form>

                </td>

          </tr>
          <!--*************************END SUBMIT BUTTONS ****************************-->



          <tr>
            <td align=\"center\" colspan=\"2\" style=$cp_row_title>
                   &nbsp;
            </td>

        </tr>

        </table>

       <!--**********End Control Panel Table**************-->
        ";

    } else {
      
        /* Syntax for user config file allows comments but is somewhat strict -stick to 
        assignments only! and no sinqle quoted strings */
        $output.="
        </table>
        <!--**********End Control Panel Table**************-->
        ";
        $error_messages.= "
        <br>Error: Syntax error in user configuration file ".formatPath($user_config_file).". User configuration file should only
    contain variable assignments and comments in proper php syntax - and must include php ending script characters (only &lt?php and ?&gt 
    are supported). No other statements or html should be included. Please edit manually and try again.
        ";
    }


  /* Echo to Page */

  echo menuBar()."<br>";
    if ($error_messages) {
       echoErrorMessages($error_messages);
    }
  echo $output.
  $options_output;
    if($end_output){
    echo "
    <span class=\"notes\">
       <hr>
        $end_output
      <hr>
    </span>
    "; 
    }
  echo "
  <br>
  ".menuBar();


}
/*ROBODOC_END*/


/*ROBODOC*f phpcron_admin/editTabByForm
# NAME
# editTabByForm
# SYNOPSIS
# void editTabByForm (string $phpcrontab_filename) 
# FUNCTION
# Displays form which edits the phpcrontab.conf file. 
# INPUTS
# string $phpcrontab_filename - string containing filename of phpcrontab.conf
# RESULT
# Echoes the phpcrontab.conf edit page
# SOURCE
*/

function editTabByForm($phpcrontab_filename){
global $PHP_SELF;
global $new_tabfilename;
global $edit_table_title;
global $edit_table_title_no_border;
global $edit_tab_by_form;
global $tab_save_error;
global $new_tab_contents;
global $old_tabfilename;
global $create_tab;
global $secure;



/*NOTE: Allow create file: if there is no phpcrontab file or no parameters then 
substitute another array for $line and save new file. */

if ($tab_save_error) {
  $new_tabfilename=""; //initialize
  $phpcrontab_filename=$old_tabfilename;
  /* Don't read from file - just use attempted saved contents if save failure */
  $phpcronconf_array=explode("\n",stripslashes($new_tab_contents));
} elseif(!$path_errors=isPathBad($phpcrontab_filename,true,true)) {
 /* Read conf file into an array, with each line being an element in the array */

$phpcronconf_array=file($phpcrontab_filename);
} else {

if (is_readable($phpcrontab_filename)) {
$phpcronconf_array=file($phpcrontab_filename);
}
//If there are  path errors, report them

    while ( list($file_or_dir, $error_string) = each($path_errors)) {

      while (list($each_message)  = each($error_string)) {
        $error_messages.=$path_errors[$file_or_dir][$each_message];

      }
    }

    $error_messages="<h3>Cannot Edit $phpcrontab_filename because of file errors:</h3>".$error_messages;
   
}





    //Tests for existence of phpcrontab file - if does not exist, creates one

   if(!file_exists($phpcrontab_filename) or $create_tab) {

    if (!$create_tab) {
      $error_messages.="Creating new phpcrontab file - No existing file found for $phpcrontab_filename<br>";
    } else {
      $error_messages.="Creating new phpcrontab file<br>";
    }
    $create_tab=true;
    $create_tab_contents=
"# comments: lines must begin with a #
#  Phpcrontab.conf
#The phpcontab.conf file contains a schedule of scripts/programs to
# run in the traditional crontab format:
# minute (0-59) hour (0-23) day of month (1-31) month(1-12) day of week(0-6)  command
# Wild Cards are allowed. Each parameter is separated by one space.
# Example:
#
# 59 3 * * 5  php sample_script.php   # every Friday at 3:59 a.m.
#Ranges and multiple values will also work:
# 0 0 1-15 * *   perl sample_script.pl   #executes on 1st through 15th of month
# 0 0 1-3,15 * *   perl sample_script.pl   # executes on 1st-3rd and 15th of month
#
# MINUTES HOUR MONTHDAY MONTH WEEKDAYNUM
";

    $phpcronconf_array=explode("\n",$create_tab_contents);

    
   }

$crontab_stripped=formatPath($phpcrontab_filename); 


$output.="
    <!--**********Begin JavaScript*******************-->
    <SCRIPT LANGUAGE=\"JavaScript\" type=\"text/javascript\">
     <!--  

	   function isNumberBetween(string,low,high) {
	    for (i = 0; i < string.length; i++)
	    {   
        	// Check that each character is number.
        	var c = string.charAt(i);

        	if (!((c >= \"0\") && (c <= \"9\"))) return false;
	    }

	   var number = parseInt (string); //converts string to integer 
	    return ((number >= low) && (number <= high));

	   }

	function trim(str)
	{
	var i = 0,j = str.length - 1;

        	while(str.charAt(i) == ' ') i++;
        	while(str.charAt(j) == ' ') j--;
	j++;

	return str.substring(i,j);

	}




	function validateField (field_string, textvalue, individual_parameter, theField, max_low, max_high) {
	       var warning_message=\"\";

	       if(!textvalue.match(/^(([0-9]{1,2}|[0-9]{1,2}-[0-9]{1,2}),?)+$/))
		 return warn(theField, textvalue + \" in the \" + field_string + \"  field is in an incorrect format.\");



	      for (i_array in individual_parameter)
	      {

	     /*warning_message=warning_message+\"i_array: \" + i_array + \"Being Evaluated:\" + individual_parameter[i_array] + \"\\r\\n\";
	     */
	       /* Check for Range */
	      if(individual_parameter[i_array].match(/^[0-9]*-[0-9]*,?$/)) {

	       var range=new Array();
	      range=individual_parameter[i_array].match(/[0-9]*-?/g) /* explode by hyphen*/

		  /*Just deletes , or - at end of string if it exists */
        	 range[0]=range[0].replace(/[,-]/g,\"\"); 	
		 range[1]=range[1].replace(/[,-]/g,\"\");
		/*warning_message=warning_message+ \"Low Value: \" + range[0] + \" High Value is: \" + range[1] + \"\\r\\n \";;
		*/

		/*Make Sure High > Low */

		if (parseInt(range[0])>=parseInt(range[1])) {

		warning_message=warning_message + \"Low value of range \" + individual_parameter[i_array] + \" in \" + field_string + \" field is greater than or equal to high value.\\r\\n\";


		}
		for (i_range in range)
		{

		  /*check each range to see if between correct values */
		   if (isNumberBetween(range[i_range],max_low,max_high)!=true)
        	  {
		  if(range[i_range]==\"\") {

		  continue; //continue inner loop

		  }
        	  warning_message=warning_message + range[i_range] + \" is in the \" + field_string + \" field which requires a number between \" + max_low + \" and \" + max_high +\".\\r\\n\";

		  }


		}		      


	      continue; //continue outer loop
	      }
        	/*warning_message=warning_message+ \"Second Being Evaluated:\" + individual_parameter[i_array] + \"\\r\\n\";
        	*/
		/*Just deletes , or - at end of string if it exists */
        	individual_parameter[i_array]=individual_parameter[i_array].replace(/[,-]/g,\"\"); 


        	   if (isNumberBetween(individual_parameter[i_array],max_low,max_high)!=true)
        	  {
		  if(individual_parameter[i_array]==\"\") return true;
        	  warning_message=warning_message + individual_parameter[i_array] + \" is in the \" + field_string + \" field which requires a number between \" + max_low + \" and \" + max_high +\".\\r\\n\";
        	  }
		  i_array++;
	      }    

	      if(warning_message !=\"\") {
	      warning_message=\"Error(s):\\r\\n\" + warning_message;      
	      return warn(theField,warning_message);
	      } else {
	      return true;
	      }


	}



  function checkParameter(theField, parameter_type) {
  
    
      /*Textvalue is string hold all of values in field */
      textvalue=trim(theField.value);
      var i_array=0;
 
            
      if (textvalue == \"*\") return true;
      var individual_parameter=new Array();
      
      /*Fill Array Individual Parameter with Values Separated by , or hyphens*/
      individual_parameter=textvalue.match(/[0-9]+(-[0-9]+)?,?/g) /* took out hypen*/
  
          
      switch (parameter_type) {
      
            
      case 0:
      return validateField (\"Minutes\", textvalue, individual_parameter, theField, 0, 59);

      case 1:
      return validateField (\"Hour\", textvalue, individual_parameter, theField, 0, 23);

      case 2:
      return validateField (\"Day of Month\", textvalue, individual_parameter, theField, 0, 31);

      case 3:
      return validateField (\"Month\", textvalue, individual_parameter, theField, 1, 12);

      case 4:
      return validateField (\"Week Day\", textvalue, individual_parameter, theField, 0, 6);
      
      default:
      return warn(theField, \"Error in Code: Parameter Type is Invalid - Can't validate entry\");
      
       }


    }   

    

    function warn (theField, s){   

        alert(s);

        return false;
    }


    function NoEmpty(theField, s) {
    if(theField.value==\"\")
        alert(\"The \" + s + \" field requires an entry\");
    }

    -->  

    </SCRIPT>
    <!--**********End *******************-->
    
      
    <form action=\"$PHP_SELF?admin_subpage=Save_Edtab\" STYLE=\"margin-bottom: 0\" method=\"post\">
      
    <!--*************** Begin Schedule Programs Table (edit phpcrontab info ) *********-->
    <table align=\"center\" width=\"600px\" style=$edit_tab_by_form border=\"0\" cellspacing=\"0\" cellpadding=\"2\" summary=\"PHPCRONTAB Edit Form\">

     <tr >
      <td colspan=\"7\" align=\"center\" style=$edit_table_title>
      
        <h2>Schedule Programs</h2>";

if ($create_tab) {
  $output.= "
  <h4>New PHPCRONTAB File</h4>";
} else {
     $output.=
     "<h4>(edit ".chunk_split($crontab_stripped, 20, " ").")</h4>";
}

$output.="
       </td>
      </tr>
      ";

          $line_number=0;
        
         /* Loop through the array containing the lines of the phpcrontab.conf file */
         while ($line=$phpcronconf_array[$line_number]) {   
 

                 $line=trim($line); //trim extra spaces
                 /* Get lines which contain mixed parameters and comments */
                 preg_match("/#.*$/",$line, $side_line_comments);
                 /* Gets rid of # as first character of each line - 
                 add this back later when save file. User does not have to enter */
                    $side_line_comments[0]=preg_replace("/^#/m", "", trim($side_line_comments[0]));  

                 preg_match("/^#.*$/",$line, $full_line_comments); 
                
                 /* Get rid of # as first character of each line - add this back later when save file. 
                   User does not have to enter. Also move lines over preserve vertical whitespace. */
                 $full_line_comments[0]=trim(preg_replace("/^#(.)/m", "\\1", trim($full_line_comments[0])));
                   //  preserve vertial whitespace
                   $full_line_comments[0]=preg_replace("/^#/m", " ", $full_line_comments[0]);
  
  
                   if($full_line_comments[0]) {
                  $top_line_comments.=$full_line_comments[0]."\r\n";
                  $number_of_top_comments++;
                }
  
              
                   if($param_headings_printed  and $full_line_comments[0]) {
                  $bottom_line_comments.=$full_line_comments[0]."\r\n";
                  $number_of_bottom_comments++;
                }
                 /* Delete commented out sections and lines */
                 $line=preg_replace("/#.*$/","",$line); 

                 /* If line is a blank line then ignore line, otherwise
                   process commands */

                       if(!preg_match ("/^\s*$/", $line)) {

                  /*Print out Top Comments into a Text Area if haven't printed*/

                   if (!$param_headings_printed) {              

                     $output.=tabTopComments($top_line_comments, $number_of_top_comments);  
                    $param_headings_printed=true; //print headings only once
            
                  }

                      /* Parse line into a 6 element array (0-5), 
                        5 time parameters (minute, hour, day of month, month, day of week)
                        + command string */
                            $line = explode(" ", $line,6);
          
                            $command_text=array_pop($line);  // pop off the command text 
                      $command_text=trim ($command_text); //trim extra spaces
        
                        /* Cycle through first five parameters horizontally and put in 
                      text boxes */

                            $parameter_no=0;       
                                  
                      while ($parameter_no<5){
              
                      $box_size=4;
                    

                      $output.= "
          
          <td align=\"center\" >        
            <input class=\"color\" name=\"ct_param[$line_number][$parameter_no]\" type=\"text\"  size=\"$box_size\" value=\"$line[$parameter_no]\" onChange=\"checkParameter(this, $parameter_no)\" >
          </td>";
                    
                                            
                      $parameter_no++;
                      }    
      
                      /* Add Commands and Side Line Comment Boxes */

                      $output.="
              <td align=\"center\">
                <input class=\"color\" type=\"text\" name=\"commands[$line_number]\" value=\"$command_text\"  onChange=\"NoEmpty(this, 'Commands')\">
              </td>
              <td align=\"center\">
                 <input class=\"color\" type=\"text\" name=\"side_line_comments[$line_number]\" value=\"$side_line_comments[0]\"> 
              </td>
              </tr>";
              
        
                } // end of check for blank line
                    $line_number++;
        
      } //end of parse loop  

       if (!$param_headings_printed) {

         /* If no commands in file, print out Top Comments into a Text Area as would not have
          previously printed */
         
         $output.=tabTopComments($top_line_comments, $number_of_top_comments);  
        $param_headings_printed=true; //print headings only once
      }

      /* Add 5 additional lines for new commands. Can do 5 at a time. */

          $max_lines=$line_number+5; //defines line number of last additional command input
          $output.="    
          <tr>
              <td align=\"center\" style=$edit_table_title colspan=\"7\">
                Add Commands (up to 5 at a time):
              </td>
          </tr>
         <tr>
	 ";
      

       while($line_number<$max_lines) { 

             $parameter_no=0;       
  
          while ($parameter_no<5){

          $box_size=4;
      

          $output.= "
<td align=\"center\" >        
<input class=\"color\" name=\"ct_param[$line_number][$parameter_no]\" type=\"text\"  size=\"$box_size\" value=\"$line[$parameter_no]\" onChange=\"checkParameter(this, $parameter_no)\" >
</td>
";
        
                                
          $parameter_no++;
          }    

         $output.="         
           <td align=\"center\">
             <input class=\"color\" type=\"text\" name=\"commands[$line_number]\" onChange=\"NoEmpty(this, 'Commands')\"> 
           </td>
           <td align=\"center\">
             <input class=\"color\" type=\"text\" name=\"side_line_comments[$line_number]\">
           </td>
         </tr>
	<tr>
         ";

          $line_number++; 
      }
        
      /* Bottom Comments */
      $output.="
        <td align=\"center\" colspan=\"7\" style=$edit_table_title>Bottom Comments:</td></tr>
        <tr>
        <td colspan=\"7\" align=\"center\">
            <textarea name=\"bottom_line_comments\" cols=\"80\" rows=\"$number_of_bottom_comments\">$bottom_line_comments
          </textarea>
          </td>
      </tr>
      <!--*************** End Schedule Programs Section of Table (edit phpcrontab info ) *********-->   
      
  <tr>
    <td style=$edit_table_title_no_border colspan=7>
  
  <!--******* FORM SUBMITS*********-->
   ";
   if ($create_tab) {
   if (!$secure) {
   $output.="
     File: <em>New PHPCRONTAB File </em><br> 
     <input type=\"submit\" value=\"Save As:\">

      <input class=\"color\" type=\"text\" name=\"new_tabfilename\">" ;
    }
    $output.="
      <br>
      Check to Save Over Existing File:
       <input type=\"checkbox\" name=\"overwrite\" value=\"true\" class=\"title\">
        <input type=\"hidden\"  name=\"max_line_number\" value=\"$line_number\"> 
  
      <input type=\"hidden\" name=\"current_tabfilename\" value=\"$phpcrontab_filename\">
      
      </form>
    </td>
    </tr>
  <tr>
  <td style=$edit_table_title_no_border  colspan=7>
      ";

   } else {
   $output.="
       <HR>
      <input type=\"submit\" value=\"Save\">";
  if (!$secure) {
  $output.=  "
      <input type=\"submit\" value=\"Save As:\">
      <input class=\"color\" type=\"text\" name=\"new_tabfilename\">";
  }
  $output.="
      <br> 
      Check to Save Over Existing File:
      <input type=\"checkbox\" name=\"overwrite\" value=\"true\" class=\"title\">  
        <input type=\"hidden\" value=\"$line_number\" name=\"max_line_number\"> 
      <input type=\"hidden\" name=\"current_tabfilename\" value=\"$phpcrontab_filename\">
  
      
      </form>
    </td>
    </tr>
  <tr>
  <td border=0  style=$edit_table_title_no_border colspan=7>
      ";

      /* This allows another file to be opened - commenting this out because I changed my mind.
      Think its better for a crontab file to be opened by changing user configuration file. 
      But if you want to use this feature it is implemented, just uncomment.
         <form action=\"$PHP_SELF\" method=\"post\">
        <input type=\"submit\" value=\"Open:\">
      <input class=\"color\" type=\"text\" name=\"new_tabfilename\"> 
      <input type=\"hidden\" value=\"Edit_Tab_By_Form\" name=\"admin_subpage\">
      </form>
      */

  $output.="
      <form action=\"$PHP_SELF\" method=\"post\">
        <input type=\"submit\" value=\"Create New PHPCRONTAB File\">
      <input type=\"hidden\" value=\"Edit_Tab_By_Form\" name=\"admin_subpage\">
      
      <input type=\"hidden\" value=\"true\" name=\"create_tab\">
     </form> 
    </td>
    </tr>
  <tr>
  <td border=0 style=$edit_table_title_no_border  colspan=7> 
      ";
  } 

$output.="
      <HR>
      File: <em>$crontab_stripped</em>
      </td>
      </tr>
  </table>
  <br>
   <!--*******END FORM SUBMITS *********-->";

  
              if ($new_tabfilename) {

            if($path_errors=isPathBad($new_tabfilename, true)) {

                 while ( list($file_or_dir, $error_messages) = each($path_errors)) {

                  while (list($each_message)  = each($error_messages)) {
                    $error_messages.=$path_errors[$file_or_dir][$each_message]; 
                  }
              }

             }


            else {
              $phpcrontab_filename=$new_tabfilename;
              }
            }

  
  if($error_messages) {echoErrorMessages($error_messages);};
  echo $output;   



} //end of function

/*ROBODOC_END*/

/*ROBODOC*f phpcron_admin/fullEditBox
# NAME
# fullEditBox
# SYNOPSIS
# void fullEditBox (string $file_name, string $box_title) 
# FUNCTION
# Allows you to edit,save,and save the text file $file_name in a text box
# INPUTS
# string $filename - string containing filename of phpcrontab.conf
# string $box_title - string containing title of the edit box
# RESULT
# Echoes a textbox containing the contents of $filename with controls to 
# save, etc.
# SOURCE
*/

function fullEditBox($file_name, $box_title){
     global $admin_subpage;
     global $PHP_SELF;
     global $modified_contents;
     global $mc_rows;
     global $fe_save_error;
     global $full_edit_title;
     global $secure;



    if($path_errors=isPathbad($file_name, true, true)) {

      while ( list($file_or_dir, $error_string) = each($path_errors)) {



      while (list($each_message)  = each($error_string)) {
        $error_messages.=$path_errors[$file_or_dir][$each_message];  
    }

    }

    $error_messages="<h3>Cannot Edit $file_name because of file errors:<br></h3>".$error_messages;
    //if path errors, echo message and retur
    
    if (!is_readable($file_name)){
    echoErrorMessages($error_messages);
    echo $output;
    return;
    }

   }
    //Empty file into array
     $file_array=file($file_name);

    if ($fe_save_error) {   //if previously bad save, display modified contents that weren't saved
      $file_string=$modified_contents;
    } else {

      //Implode file_array to put string in text area element
       $file_string=addslashes(trim(implode("",$file_array)));

        //Set number of rows
       if ($file_array) {
           $total_lines=count($file_array);
        }
       $mc_rows=$total_lines+10;

    }
    //Build output

     $output="
    <!--*********** Begin Full Edit Box For $file_name************-->
    <br>
    <table border=\"1\" cellpadding=\"2\" width=\"600px\" cellspacing=\"0\" align=\"center\">
    <tr>
      <td align=center style=$full_edit_title colspan=7 >
       <h3>
  
          $box_title
          <br><br>
           (edit ".chunk_split(formatPath($file_name), 20, " ").")
          <br>
    
      </h3>
      </td>
    </tr>
    <tr>
      <td style=$full_edit_title>

         <form action=\"$PHP_SELF\" method=\"post\">
            <div align=\"center\">
             <textarea name=\"modified_contents\"  wrap=\"off\" cols=\"80\" rows=\"$mc_rows\" 
             class=\"fulledit\">".stripslashes($file_string)."
             </textarea>
          </div>
           
           <HR>
           <input type=\"submit\" value=\"Save\">";
if (!$secure) {
$output.= "<input type=\"submit\" value=\"Save As:\">
           <input type=\"text\" class=\"color\" name=\"new_filename\">";
}
 $output.=" <br>
            Check to Save Over Existing File:
           <input type=\"checkbox\" name=\"overwrite\" value=\"true\" class=\"title\">
        
             <input type=\"hidden\" class=\"color\" name=\"current_filename\" value=\"$file_name\">
           <input type=\"hidden\" name=\"admin_subpage\" value=\"$admin_subpage\">
           <input type=\"hidden\" name=\"mc_rows\" value=\"$mc_rows\">
               </form>

        
      <form action=\"$PHP_SELF\" method=\"post\">
        <input type=\"submit\" value=\"Reload Current File\">
         <input type=\"hidden\" name=\"admin_subpage\" value=\"$admin_subpage\">

      </form>
      <HR>
      Current File: ".formatPath($file_name)."
       </td>
      </tr>
    </table>
     <br>
     <!--*********** End Full Edit Box For $file_name*************-->
     ";
     if($error_messages) {
        echoErrorMessages($error_messages);
     }
     echo $output;

}


/*ROBODOC_END*/

/*ROBODOC*f phpcron_admin/getAssignmentInfo
# NAME
# getAssignmentInfo
# SYNOPSIS
# array getAssignmentInfo (array $uc_contents_array) 
# FUNCTION
# Used in parsing phpcron_userconfig.php. Determines the variable,
# value and type of a quoted variable assignment,
# INPUTS
# array $uc_contents_array[$horiz_pos]["executable"]
# 
# A 2 dimensional array which contains the variable assignment strings derived 
# from  the phpcron_userconfig.php
# RESULT
# Returns false if a string in the array is not a variable assignment or, if
# successful, a three dimensional array containing variable name, value, and
# type for  each assignment in the $uc_contents_array:
# $return_value[$horiz_pos][$i]["variable"], 
# $return_value[$horiz_pos],[$i]["type"],  
# $return_value[$horiz_pos],[$i]["type"]
# This information is assigned to $assignment_info in cpPhpcron. 
# SOURCE
*/

function getAssignmentInfo ($uc_contents_array){ 
/*Returns variable, value and type of quoted assignment (i.e., when $assignment is a 
variable assignment like "a=3;" */

  global $user_config_file;
  global $uc_contents_length;
  include("$user_config_file");

  $horiz_pos=0;

  
  while($horiz_pos<$uc_contents_length) {

  if($uc_contents_array[$horiz_pos]["executable"]) {
  $executable_string.=  stripPhp($uc_contents_array[$horiz_pos]["executable"]);
  }
  $horiz_pos++;
  }
  /* Join Executable Strings and Test for syntax errors (if there are anything but 
  assignments, testedby comparing number of = with number of ; */

  if(preg_match_all("/;/", $executable_string, $semi_matches) <> preg_match_all("/=/",$executable_string,$equal_matches)) {

  return false; //syntax error in string - nunmber of assignments do not equal number of statements;
  }

  /* Cycle through array containing executable strings, explode and create 3 arrays containing
  variable, value and type */

  $horiz_pos=0;
  while($horiz_pos<$uc_contents_length) {
    //if this element is empty then skip the loop 
    if(!$uc_contents_array[$horiz_pos]["executable"]) { 
    $horiz_pos++;
    continue;
    } //end of if

    //strip html tags
    $uc_contents_array[$horiz_pos]["executable"]=trim(strip_tags($uc_contents_array[$horiz_pos]["executable"]));
  
    /* Turn uc_contents_array element into separate assignment strings */

     //break assignment_string into an array of separate assignments
    if(!$assignment_array[$horiz_pos]=explode(";",$uc_contents_array[$horiz_pos]["executable"])) {    
  
      return false; // error if no semi-colon in string
    }
          /* Run through assignment array and break into variable, values, and type */
          $i=0;
           while($assignment_array[$horiz_pos][$i]) {
          
            //assign variable to 0 and $value to 1; return if  
            if(!$temp=explode("=",$assignment_array[$horiz_pos][$i])) {  
  
              return false; //returns false if this string does not contain an assignment
              
            }
  
          $return_value[$horiz_pos][$i]["variable"]=$temp[0];
          $return_value[$horiz_pos][$i]["value"]=$temp[1];
      
           //maintain quotes for type testing
          $test_string=trim(stripslashes($return_value[$horiz_pos][$i]["value"])); 
       //strip slashes, trim, and get rid of quotes
          $value=trim(preg_replace("/\"/","",stripslashes($return_value[$horiz_pos][$i]["value"]))); 
          /*Derive Types*/
          if(preg_match("/^[0-9]*$/", $test_string)) {
               $return_value[$horiz_pos][$i]["type"]="integer";
          } elseif ($return_value[$horiz_pos][$i]["value"]=="true" or $value =="false") {
              $return_value[$horiz_pos][$i]["type"]="boolean";
          }elseif (preg_match("/^\".*\"$/", $test_string)){
                $return_value[$horiz_pos][$i]["type"]="string";
          }  else {
              echoErrorMessages("Error: A type could not be determined for variable 
              $return_value[$horiz_pos][$i][$variable] - Check Syntax in User Configuration File $user_config_file. Only variable 
              assignments of type String (surrounded by double quotes only), Integers, and Booleans are 
              supported in that file.");
          
              return false;
            }

          $i++;
        
          } //end of inside while
  
    $horiz_pos++;

  } //end of outside while

  /*Returns 3 array string containing variable name, value, 
    and  type for each assignment statement */
  
  return $return_value; 
}

/*ROBODOC_END*/

 
/*ROBODOC*f phpcron_admin/getComments
# NAME
# getComments 
# 
# SYNOPSIS
# array getComments (string $big_string, string $left_char, 
#		    string $right_char, string $current_pos) 
# 
# FUNCTION
# Starting with the $current_pos position in $big_string, extracts from
# $big_string,  a php comment that begins with $left_char and ends with
# $right_char or the beginning   of a php block. Used when parsing the
# phpcron_userconfig.php
# INPUTS
# $big_string - string containing contents of phpcron_userconfig.php
# $left_char  - the beginning character of the comment
# $right_char - the ending character of the comment
#  $current_pos - the current position of the parser in $big_string, getComments
# 		will search from this position forward
# RESULT
# Returns an array containing as the first element, the comment string, and the
# second  element the position after the comment in the $big_string.   contents
# are valid.
# SOURCE
*/




function getComments($bigstring, $left_char, $right_char, $current_pos) {

//gets substring which is delimited by left_char and right_char, starting from $current_pos

global $uc_contents_length;
$end_of_string= substr($bigstring, $current_pos); //get rest of string from current position to end

  if(strstr($end_of_string, $right_char)) {
    if ($right_char=="\n") { //if this is a single line comment
        //position of ending comment not including ending character 
      $last_pos=strpos($bigstring, $right_char, $current_pos);
    } else {
      //position of ending comment including ending character
        $last_pos=strpos($bigstring, $right_char, $current_pos)+strlen($right_char); 
    }
    $substring= substr($bigstring, $current_pos, $last_pos-$current_pos); //get substring to end
  }  elseif (strstr($end_of_string, "?>")) {
     // position of end of php block - but don't include end
    $last_pos=strpos($bigstring, "?>", $current_pos)-1; 
    //get to end of php block
    $substring= substr($bigstring, $current_pos, $last_pos-$current_pos); 
  } else {  //otherwise, return end of string
    $last_pos=$uc_contents_length;
    $substring=$end_of_string;
  }
  $current_pos=$last_pos;
  $current_pos=$last_pos; //update current position
  $return_value = array ($substring, $current_pos);//return substring and current position

  return $return_value;

}
/*ROBODOC_END*/


/*ROBODOC*f phpcron_admin/getFormElement
# NAME
# getFormElement 
# 
# SYNOPSIS
# string getFormElement (string $variable, string $value, string $type,
# 		   int horiz_pos, int $variable_index) 
# 
# FUNCTION
# Constructs a string containing HTML comprising an appropriate form element
# to pass a value appropriate for $variable. For instance, if the
# variable is a boolean variable, a true/false radio button will
# be constructed, if a string, a text box. Used to construct the
# control panel.
# 
# INPUTS
# $variable - the string containing the name of the variable being analyzed 
# 	     (extracted    from the phpuserconfig.php)
# $value    - a string containing the name of the value
# $type     -  a string conaining the name of the variable type (e.g., boolean,
# 	      string, etc)   
# $horiz_pos  - the horizontal position where the parser is at in
# 		parsing the contents of phpuserconfig.php   	
# $variable_index - a number used as the second index of the three dimensional 
# 		array which   holds the assignment info See cpPhpcron
# 
# RESULT
# Returns a string containing an appropriate HTML form element for the 
# assignment type.    For instance, if the variable is a boolean variable, a 
# true/false radio button will   be constructed, if a string, a text box. Used 
#  to construct the   control panel.
# 
# NOTES
# See cpPhpcron
# SOURCE
*/


function getFormElement($variable, $value, $type, $horiz_pos, $variable_index) {

   $value=trim(preg_replace("/\"/","",stripslashes($value))); //strip slashes, trim, and get rid of quotes    

  $box_size=strlen($value);
  if($box_size > 40) {
   $box_size=40;     //size of text box
  }

  switch ($type) {
  case "integer":
    
    return "<input type=\"text\" class=\"color\" name=\"assignment_info[$horiz_pos][$variable_index][value]\" value=\"$value\" size=\"$box_size\" onChange=\"isNumber(this)\">";
    break;

  case "boolean":


    if($value=="true") {  
    return "
        <input  type=\"radio\" checked name=\"assignment_info[$horiz_pos][$variable_index][value]\" value=\"true\">On
        <input type=\"radio\" name=\"assignment_info[$horiz_pos][$variable_index][value]\" value=\"false\">Off";
    } else {
    return "
        <input  type=\"radio\"  name=\"assignment_info[$horiz_pos][$variable_index][value]\" value=\"true\">On
        <input type=\"radio\" checked name=\"assignment_info[$horiz_pos][$variable_index][value]\" value=\"false\">Off";
    }

    break;

  case "string":

    return "
          <input type=\"text\" class=\"color\" name=\"assignment_info[$horiz_pos][$variable_index][value]\" value=\"$value\" size=\"$box_size\">";
    break;
  default:
    echoErrorMessages("Error: No Form Found for This Variable $variable- Check Syntax in User Configuration File. Only String, Integers, and
    Booleans are supported.");
    return false;

  }


}


/*ROBODOC_END*/


/*ROBODOC*v phpcron_admin/$uc_contents_array
# NAME
# $uc_contents_array
# DESCRIPTION
# A 2 dimensional array constructed of the following:
# $uc_contents_array[$horiz_pos]["executable"] 
# 	- the non-comment portions of phpcron_userconfig.php	
# $uc_contents_array[$horiz_pos]["ml_comments"]
# 	- the multi-line comment portions of phpcron_userconfig.php
# $uc_contents_array[$horiz_pos]["sl_comments"] 
# 	- the single line comment portions of phpcron_userconfig.php
# NOTES
# See cpPhpcron, parseUserConfig, rebuildUserCfg
*ROBODOC_END*/


/*ROBODOC*v phpcron_admin/$assignment_info
# NAME
# $assignment_info
# DESCRIPTION
# A three dimensional array containing variable name, value, and
# type for  each assignment in the $uc_contents_array:
# $assignment_info[$horiz_pos][$i]["variable"], 
# $assignment_info[$horiz_pos],[$i]["type"],  
# $assignment_info[$horiz_pos],[$i]["type"]
# cpPhpcron assigns gets this information from a call
# to getAssignmentInfo in cpPhpcron.
# NOTES
# See cpPhpcron, getAssignmentInfo
*ROBODOC_END*/


/*ROBODOC*f phpcron_admin/parseUserConfig
# NAME
# parseUserConfig
# SYNOPSIS
# array parseUserConfig(string $user_config_file, string $left_mlc_ch, 
# 		     string $right_mlc_ch, string $sc_ch)
# FUNCTION
# Parses the user configuration file $user_config_file, extracting single 
# line comments,multi-line comments, and command portions of
# $user_config_file
# INPUTS
# $user_config_file - the filename of the phpcron_userconfig.php
# $left_mlc_ch - the characters which mark the beginning of a mult-line
# 	       comment  
# $right_mlc_ch - the characters which mark the end of a mult-line
# 	       comment  	     
# $sc_ch - the characters which mark the beginning of a single-line character
# RESULT
# Returns  an array containing as its first element $uc_contents, a string
# containing the  contents of $user_config_file file and, as its second
# element, $uc_contents_array, a 2 dimensional array which contains the contents
# of the phpcron_userconfig.php
# NOTES
# 	See $uc_contents_array, cpPhpcron
# SOURCE
*/



function parseUserConfig($user_config_file, $left_mlc_ch, $right_mlc_ch, $sc_ch) {
/* parse the userconfig file named in $file to separate out mult-line comments surrounded
by $mlc_left_char and $mlc_right_char and single line comments begun with slc_ch */

global $uc_contents;
global $uc_contents_length;
$current_pos=0;
$horiz_pos=0;

    while ($current_pos<$uc_contents_length){

       $current_char=substr($uc_contents,$current_pos,strlen($left_mlc_ch));

       //if character is a multi-line comment then find to end character of multi-line comment
        if ($current_char==$left_mlc_ch) {

        if($uc_contents_array[$horiz_pos]["executable"]) {$horiz_pos++;}
        list($uc_contents_array[$horiz_pos]["ml_comments"], $current_pos)=getComments($uc_contents, $left_mlc_ch,$right_mlc_ch, $current_pos);

        $horiz_pos++;

      }  elseif($current_char==$sc_ch){
         //increment position for executable
        if($uc_contents_array[$horiz_pos]["executable"]) {$horiz_pos++;}
        list($uc_contents_array[$horiz_pos]["sl_comments"], $current_pos)=getComments($uc_contents, $sc_ch,"\n", $current_pos);

        $horiz_pos++;
        
      } else {
        $uc_contents_array[$horiz_pos]["executable"]=stripPhp($uc_contents_array[$horiz_pos]["executable"].substr($current_char,0,1)); //after comments are stripped out, assign all else to this
        }
      $current_pos++;
    }
    $return_value=array ($uc_contents, $uc_contents_array);
    return $return_value;
 }



/*ROBODOC_END*/

/*ROBODOC*f phpcron_admin/rebuildUserCfg
# NAME
# rebuildUserCfg
# SYNOPSIS
# string rebuildUserCfg(array $assignment_info, array $uc_contents_array)
# FUNCTION
# Rebuilds the new phpcron_userconfig.php to be saved given the information 
# submitted by the control panel form.
# INPUTS
# $assignment_info - a three dimensional array containing the data submitted 
# by the control panel form
# $uc_contents_array - a 2 dimensional array containing the current contents of the
# 		     phpcron_userconfig.php such that:
# 		     $uc_contents_array
# 
# RESULT
# A string containing the new contents of the phpcron_userconfig.php after
# editing by the control panel form. This string is meant to be saved
# as the new phpcron_userconfig file.
# NOTES
# See cpPhpcron
# SOURCE
*/

function rebuildUserCfg($assignment_info, $uc_contents_array) { //Print out Contents of File in Order
  
  /* This function rebuilds the user_config_file using the new information from $assignment_info 
  submitted by the user. */
  global $uc_contents_length;
  $horiz_pos=0;

    while($horiz_pos<$uc_contents_length) {

    $i=0;


    while($assignment_info[$horiz_pos][$i]["variable"] ) {

      if ($assignment_info[$horiz_pos][$i]["type"]=="string") { //add quotes for a string
          $assignment_info[$horiz_pos][$i]["value"]="\"".$assignment_info[$horiz_pos][$i]["value"]."\"";
      }

      if($i==0) {
      /* After first time add additional elements (don't replace - otherwise won't get
      additional assignments on same line) */
        $uc_contents_array[$horiz_pos]["executable"]=$assignment_info[$horiz_pos][$i]["variable"].
                                    "=".$assignment_info[$horiz_pos][$i]["value"].";";

      }else {
        $uc_contents_array[$horiz_pos]["executable"].=$assignment_info[$horiz_pos][$i]["variable"].
                                    "=".$assignment_info[$horiz_pos][$i]["value"].";";
      }
      /* For Debugging:
      echo "Horiz Pos: $horiz_pos Index: $i<br>";
      echo "Assignment Info Variable:".$assignment_info[$horiz_pos][$i]["variable"]."<br>";
      echo "Contents:".$uc_contents_array[$horiz_pos]["executable"]."<br>";
      echo "SL Comments:".$uc_contents_array[$horiz_pos]["sl_comments"]."<br>";
      echo "ML Comments:".$uc_contents_array[$horiz_pos]["ml_comments"]."<br>";
      */

      $i++;
    }

    if($uc_contents_array[$horiz_pos+1]["sl_comments"]) {
      $plus1=$horiz_pos+1;
      /*For Debugging
      echo "Exec Contents $horiz_pos:".$uc_contents_array[$horiz_pos]["executable"]."<br>";
      echo "Exec Contents:".$plus1.$uc_contents_array[$horiz_pos+1]["executable"]."<br>";
      echo "sl comments again:".$plus1.$uc_contents_array[$horiz_pos+1]["sl_comments"];
      */

      /*only add tab if there are commands on same line (the executable element 
      holds a word character)*/
      if (preg_match("/\w/",$uc_contents_array[$horiz_pos]["executable"])){ 
      
      $uc_contents_array[$horiz_pos+1]["sl_comments"]="\t".$uc_contents_array[$horiz_pos+1]["sl_comments"]."\n";
      } else {    

      $uc_contents_array[$horiz_pos+1]["sl_comments"]=$uc_contents_array[$horiz_pos+1]["sl_comments"]."\n";
      
      }
    }
  
    if($uc_contents_array[$horiz_pos]["ml_comments"]) {
      $uc_contents_array[$horiz_pos]["ml_comments"]=$uc_contents_array[$horiz_pos]["ml_comments"]."\n";
    }
    $new_file_contents.=$uc_contents_array[$horiz_pos]["sl_comments"].$uc_contents_array[$horiz_pos]["ml_comments"].$uc_contents_array[$horiz_pos]["executable"];
    $horiz_pos++;
  
    }
    $new_file_contents="\r\n<?php\r\n\r\n".trim(stripslashes($new_file_contents))."\r\n\r\n?>"; //add php tags
    return $new_file_contents;
  }


/*ROBODOC_END*/

/*ROBODOC*f phpcron_admin/stripPhp
# NAME
# stripPhp
# SYNOPSIS
# string stripPhp(string $phpstring)
# FUNCTION
# Strips $phpstring of the <?php and the ?> tags
# INPUTS
# A string containing a php script.
# RESULT
# The contents of the php script without the beginning and  ending php
# tags.
# SOURCE
*/

function stripPhp($phpstring) {
   $phpstring=preg_replace("/(<\?php)|(\?>)/","",$phpstring); 
  return $phpstring;
}

/*ROBODOC_END*/

/*ROBODOC*f phpcron_admin/tabTopComments
# NAME
# tabTopComments
# SYNOPSIS
# string tabTopComments(string $top_line_comments, int $number_of_top_comments)
# FUNCTION
# Creates a row of a table containing a textarea containing the top comments of
# the phpcrontab.conf. Comprises a part of the form which edits the
# phpcrontab.conf file.
# INPUTS
# $top_line_comments - a string created in editTabByForm containing  all of the
# 		      comments at the top of the phpcrontab.conf file 
# $number_of_top_comments - number of lines of top comments in phpcrontab.conf
# RESULT
# A string containing the HTML for producing the table row containing the 
# textarea holding the top comments of phpcrontab.conf 
# NOTES
# See editTabByForm
# SOURCE
*/

function tabTopComments($top_line_comments, $number_of_top_comments) {
global $edit_table_title;
 return " <tr>
             <td align=\"center\" colspan=\"7\">
             <textarea name=\"top_line_comments\" cols=\"80\" wrap=\"off\" rows=\"$number_of_top_comments\">$top_line_comments                      
             </textarea>
            </td>
          </tr>
           <tr align=\"center\" style=$edit_table_title>
       
                 <td style=$edit_table_title>
                      Min<br>(0-59)
                </td>
                 <td style=$edit_table_title>
                      Hour<br>(0-23)
                </td>
                 <td style=$edit_table_title>
                      Month<br>Day<br>(1-31)
                </td>
                 <td style=$edit_table_title>
                      Month<br>(1-12)
                </td>
                 <td style=$edit_table_title>
                      Week<br>Day<br>(0-6)
                </td>                                            
                <td style=$edit_table_title>
                    Commands 
                </td>
                <td style=$edit_table_title>
                  Comments
                </td>
            </tr>
            <tr>
            ";
}

/*ROBODOC_END*/




/*****End Functions **/
?>


