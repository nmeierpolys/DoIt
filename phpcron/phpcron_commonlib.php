<?php
/*ROBODOC** PHPCRON/phpcron_commonlib_readme
# NAME
# phpcron_commonlib.php
# DESCRIPTION
# This is a collection of functions used by both
# phpcron.php and phpcron_admin.php.
# AUTHOR
# David C. Druffner
# ddruff@gemini1consulting.com
# COPYRIGHT
# COPYRIGHT 2001 (C) David C. Druffner
# ddruff@gemini1consulting.com
# This script is released under a modified BSD License.
# See php phpcron.php -license and LICENSE.txt in download package 
# for full license details
# BUGS
# Bugs can be reported via the online manual:
# http://www.gemini1consulting.com/tekhelp/online_manuals/phpcron/
# NOTES
# This is a collection of functions used by both
# phpcron.php and phpcron_admin.php.
#
# The current manual for Phpcron and Phpcron Admin is located at 
# http://www.gemini1consulting.com/tekhelp/online_manuals/phpcron/
# The Home Page is:
# http://phpcron.sourceforge.net/
# Download from the Source Forge Project Page:
# http://www.sourceforge.net/projects/phpcron/
# In-Line Documentation:
# A slightly modified version of ROBODOC is used to
# generate documentation for   this code. I have modified the headers.c file in
# the Robodoc source code to  et  the variable header_markers to equal only
# /*ROBODOC* as the start of a  header  marker - this avoids confusion with other
# strings and comments in PHP  code.   Robodoc is available at
# http://www.xs4all.nl/~rfsber/Robo/robodoc.html
*ROBODOC_END*/
 
 /*ROBODOC*v phpcron_commonlib/$php_path
# NAME
# $php_path
# DESCRIPTION
# Variable containing path to php executable
# NOTES
# This is very important for some servers which require you to
# specify the path of an executable.
*ROBODOC_END*/

$php_path="/usr/local/bin/php";

//Important to ensure that new files are created with the right permissions.
umask(0000);

 
 
/*ROBODOC*v phpcron_commonlib/$license
# NAME
# $license
# DESCRIPTION
# Variable containing text of license 
*/
$license="
Phpcron, Phpcron Admin, and all associated and packaged scripts carry the
following license:

COPYRIGHT (C) 2001 David Druffner
ddruff@gemini1consulting.com

Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions are met: 

 1.Redistributions of source code must retain the above copyright notice, this
list of conditions and the following disclaimer.  

 2.Redistributions in binary form must reproduce the above copyright notice,
this list of conditions and the following disclaimer in the documentation
and/or other materials provided with the distribution. 

 3.The name of the author may not be used to endorse or promote products
derived from this software without specific prior written permission.  

THIS SOFTWARE IS PROVIDED BY THE AUTHOR ``AS IS'' AND ANY EXPRESS OR IMPLIED
WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO
EVENT SHALL THE AUTHOR, ANY DISTRIBUTOR, OR ANY DOWNLOAD HOSTING COMPANY BE
LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
POSSIBILITY OF SUCH DAMAGE.   
";


/*ROBODOC_END*/

  
/*ROBODOC*v phpcron_commonlib/$phpcron_file
# NAME
# $phpcron_file 
# DESCRIPTION
# Variable containing path to phpcron.php 
/*ROBODOC_END*/

$phpcron_file=$phpcron_directory."phpcron.php";

/*ROBODOC*v phpcron_commonlib/$phpcron_psinfo_file
# NAME			
# $phpcron_psinfo_file 
# DESCRIPTION
# Variable containing path and filename of file
# containing information for the process
# running the phpcron.php script.
*ROBODOC_END*/

	 
$phpcron_psinfo_file=$phpcron_directory."phpcron_info";


/*ROBODOC*v phpcron_commonlib/$phpcron_venabled_file
# NAME			
# $phpcron_venabled_file 
# DESCRIPTION
# If this file exists, then phpcron.php in non-daemon mode will run the
# scheduled commands in phpcrontab.conf 
*ROBODOC_END*/

	 
$phpcron_venabled_file=$phpcron_directory."phpcron_venabled";


/*ROBODOC*v phpcron_commonlib/$phpcron_off
# NAME			
# $phpcron_psinfo_file - path and filename of file the existence of 
# which causes phpcron.php to shut down
ROBODOC_END*/
	 

$phpcron_off=$phpcron_directory."phpcron_off"; 

/*ROBODOC*d phpcron_commonlib/MS_WINDOWS
# 
# NAME
# MS_WINDOWS - constant - true if OS is Windows, false if not
# FUNCTION
# Used to check if OS is Windows or Unix.
*ROBODOC_END*/

 if(preg_match("/WIN/", PHP_OS)) {

  define("MS_WINDOWS",true);

 } else {
  define("MS_WINDOWS",false);
 }


/*ROBODOC*v phpcron_commonlib/$viewed_by_browser
# NAME
# $viewed_by_browser - true if script is read by browser, false if console
# FUNCTION
# True if script is read by browser, false if executed on the
# command line. Set automatically by script on each execution 
# by reading whether $SERVER_PROTOCOL or $HTTP_USER_AGENT is set.
# BUGS
# I'm sure this won't work in all cases, but was the best solution
# I could come up with. Some web servers might not give out these
# variables and the script would interpret that to mean that
# it was being executed on the command line. The main result of this
# in phpcron.php is that the HTML tags would be stripped from all output
# (probably leading to a blank screen)and a built-in safeguard
# against going into daemon mode would be disabled (but there
# are other safeguards that should still prevent this).
# NOTES
# If phpcron.php is executed in a browser in daemon mode than an httpd
# process would be spawned that would only be able to be killed by 
# root (or by a self-kill if it detects a phpcron_off file in
# existence). This is a BAD THING as it could lead to server overload.
# Thus the daemon mode is shut off if a browser is detected. In addition,
# phpcron.php has certain self-checks to kill itself if there
# is another phpcron.php process running in daemon mode. See
# the function isOtherPhpcrond.
# SOURCE
*/


 if ($SERVER_PROTOCOL or $HTTP_USER_AGENT) {    

 $viewed_by_browser=true;
  $slow_debug_scroll=0; 
  } else {
    $viewed_by_browser=false;
  }

/*ROBODOC_END*/


if (getenv("$TMPDIR")) {

define("TEMP_DIR",getenv("$TMPDIR"));
} else {

define("TEMP_DIR","/tmp");
}
/*************************Start Functions ***********************************/

/*



/*ROBODOC*f phpcron_commonlib/checkPhpVersion
# NAME
# checkPhpVersion - formats string to conform to HTML/XML standards
# SYNOPSIS
# boolean checkPhpVersion(string $required_version, string $warning_string, 
# boolean $quit) 
# FUNCTION
# Verifies that the PHP version running on the Web Server is at least
# equal to the version required by the script.
# INPUTS
# $a, $b, $c   -strings containing minimum PHP version needed by the Script,
# 		e.g., 3.0.0. would be 3,0,0
# $warning_string    -optional parameter to be output to the user if fails 
# 		      version check
# $quit	- optional parameter which if true will force the 
# 	  cript to end 
# RESULT
# Returns true if version of PHP is at least the minimum, false otherwise
# SOURCE
*/

function checkPhpVersion ($version_required, $warning_string="/", $quit=false) {


$version_installed=phpversion();
/*Break Up $version_required string by decimal point*/
$version_required=explode(".", $version_required);

if (!ereg( "[[$version_required[0]-9]\.[$version_required[1]-9]\.[$version_required[2]-9].*", $version_installed )){

 if ($warning_string !="/") {
    sendOutput($warning_string);
  }
  if ($quit) {
  
  exit;
  }

  return false;
exit;
} else {

return true;
}



}

/*ROBODOC_END*/

/*ROBODOC*f phpcron_commonlib/sendOutput
# NAME
# sendOutput - handles output depending on environment and global variables
# SYNOPSIS																						  
# void sendOutput(string $output, boolean $suppress_override)
# FUNCTION
# Handles all output for phpcron.php. If a command line suppression switch has
# been turned on,  then the output is not echoed, unless the $suppress_override
# parameter is set to true (default is false) - usually done for critical
# errors.  Also, if the $redirect_output flag is true, the output will not be
# echoed  to the screen, but to the $redirect_file.  If the output is being
# sent to the browser, the output is left alone,  but if is being printed to
# the console as the output from a command line  script, than all html is
# stripped.
# INPUTS
# $output   - string containing output being echoed
# $suppress_override - optional parameter, if set the echo will occur whether
# or not the global output suppression has been turned
# on (see $suppress_output)
# NOTES
# Relies on values in global variables $viewed_by_browser, $suppress_output, 
# $redirect_output, and $redirect_file
# SOURCE	
*/

function sendOutput($output_message, $suppress_override=false) {

global $suppress_output;

global $viewed_by_browser;
global $redirect_output;
global $redirect_file;

      if(!$suppress_output or $suppress_override) {


          //display message
          if (!$viewed_by_browser) {
            $output_message=strip_tags($output_message);
          }

          if ($redirect_output) {

          $save_results=appendToFile($output_message, $redirect_file);

          if (!$save_results[0]) {
              //echo error messages
              echo "Error: Cannot Append to File $redirect_file.".
				  		 "Check filename and permissions.\r\n";
          }

          } else {

          echo $output_message;

          }
      }
}

/*ROBODOC_END*/

/*ROBODOC*f phpcron_commonlib/getProcessInfo()
# NAME
# getProcessInfo() - formats string to conform to HTML/XML standards
# SYNOPSIS
# $string getProcessInfo(void) 
# FUNCTION
# When called returns information for the process running the PHP script
# (Unix only). Relies on a ps ef system call.
# RESULT
# Returns a three element string array:
# $process_info["all"] - all the proces info returned by ps ef
# $process_info["id"] - gives the $pid of the process
# $process_info["owner"] - gives the owner of the process
# SOURCE
*/


function getProcessInfo () {
//get process info of current process
  global $pid;
    //get owner of script process
    if (!MS_WINDOWS) { //show pid info if not in windows
    
      exec("ps hefp $pid u", $output, $return_value);
      $output=implode(" ", $output);

      // get owner of process and put in $matches[1];


      preg_match("/(^[A-z0-9A-Z]*\b).*$/",$output,$matches);
      $process_info["all"]=$matches[0];
      $process_info["owner"]=$matches[1];
      $process_info["id"]=$pid;


    return $process_info;
   }
   //return nothing if windows/dos
}

/*ROBODOC_END*/


/*ROBODOC*f phpcron_commonlibp/isPathbad 
# NAME
# isPathbad
# SYNOPSIS
# boolean isPathbad(string $path_name, 
# [boolean $check_filename, [$file_existing=false)]);  
# FUNCTION
# Checks whether directory and/or filename exists and is readable/writeable 
# (filename checked only if $check_filename is true, the default is false).
# Can be used both for dos and unix paths.
# INPUTS
# $path_name - string containing path name.
# 
# $check_filename -
# 
# Optional boolean parameter. Default is false. If true,
# then  will do check on filename as well as directory and will return   an
# error message if no file name was include_onced in the path.       
# 
# $file_existing 	- 
# optional boolean parameter (requires $check_filname to be
# set) that tells whether or not the file is existing. 
# RESULT
# If there are errors in testing the path, it returns a double array 
# containing error messges in the format of $file_errors["dir"] and
# $file_errors["file"]. If there are no errors, it returns false.
# 
# The double array can be extracted using the list command like this: 
# 
# if($path_errors=isPathbad($path_name)){
# 
# while ( list($file_or_dir, $error_messages) = each($path_errors)) {
# 
# while (list($each_message)  = each($error_messages)) {
# echo $path_errors[$file_or_dir][$each_message]."<br>";  
# }
# }
# }
# 
# EXAMPLE
# $path_errors=isPathBad("/test/test.txt", true);  
# if ($path_errors["directory"] or $path_errors["file"]["write"]) { 
# $output="Error:  Cannot write to test/text.txt. The following errors were
# encountered.:<br>\r\n";  
# while ( list($file_or_dir, $error_messages) = each($path_errors)) 
# {  
# while (list($each_message)  = each($error_messages)) 
# {
# $output.= $path_errors[$file_or_dir][$each_message]."<br>\r\n";
# }
# }
# echo $output;
# 
# 
# } 
# SOURCE
*/

function isPathbad($path_name, $check_filename=false, $file_existing=false) { 																										
																			

  $dir_name=dirname($path_name)."/";
  $base_file_name=basename($path_name);
  $basename_stripped=formatPath($base_file_name);
  $dir_stripped=formatPath($dir_name);
  $pathname_stripped=formatPath($path_name);


    //Check Directory

   if(!file_exists($dir_name)){
     $path_errors["directory"]["exist"]="Error: Directory $dir_stripped does not exist. Please Create.<br>";
   }

     elseif(!is_writeable($dir_name)){

      $path_errors["directory"]["write"]="Error: Directory $dir_stripped cannot be written to. Check permissions.<br>";
   }
   elseif(!is_readable($dir_name)){
     $path_errors["directory"]["read"]="Error: Directory $dir_stripped cannot be read from. Check permissions.<br>";
   }


   //Check File Name

   if ($check_filename and !$base_file_name) { //if file name is required but not suppplied, print error
       $path_errors["file"]["empty"]="Error: $pathname_stripped is an invalid path. No file name was supplied.<br>";
      }

   if ($check_filename and $base_file_name) {

      //check filename format

      if((MS_WINDOWS and !preg_match("/^[-\.a-zA-Z0-9\s_\^\$~!#&\}\{\(\)@'`]+?$/",$base_file_name))or (!MS_WINDOWS and !preg_match("/^.[^\*\?&`'\"\/\>\)\(\]\[\<(\)]+?$/",$base_file_name))) { //check for proper characters in names

              $path_errors["file"]["name"] ="\tError: File $pathname_stripped  contains invalid characters in file name.\r\n<br>";

       }

      if ($file_existing) {

         if(!file_exists($path_name)){
               $path_errors["file"]["exist"]="Error: File $pathname_stripped does not exist.<br>";
         } elseif(!is_file($path_name)){
               $path_errors["file"]["regular"]="Error: Invalid filename. $basename_stripped is a directory.<br>";

         }   elseif(!is_writeable($path_name)){
                  $path_errors["file"]["write"]="Error: File $pathname_stripped cannot be written to. Check permissions on file.<br>";
         }   elseif(!is_readable($path_name)){
               $path_errors["file"]["read"]="Error: File $pathname_stripped is not readable. Check permissions.<br>";
         }

    }




  }
    return $path_errors;

}

/*ROBODOC_END*/

/*ROBODOC*f phpcron_commonlib/formatPath
# NAME
# formatPath
# SYNOPSIS
# $string formatPath(string $path_name);  
# FUNCTION
# Takes a string containing a path name and makes it conform to the operating
# specific  path format for readability, e.g, for dos "c:/test/test.txt" ->  
# "c:\test\test.txt". 	This is meant to be used as a filter before the string
# is   output to the screen so it becomes "human readable". This function 
# assumes that the   path name is in unix format to begin with, so if used
# under a unix OS the string   returned for "c/test/test.txt" would be the same
# as the input. In addition, this function also adds the current directory to
# any path that   lacks an absolutte directory, e.g,"test.txt" would become
# /home/httpd/html/test.txt   if the script was being executed in
# /home/httpd/html/. 
# PURPOSE
# Used as a cross-OS function to format the path name before it is echoed
# to the user. No matter what the Operating System, the path will be readable
# to the user when it is echoed to the screen.
# INPUTS 
# $path_name - string containing path name. 
# RESULT
# Returns a string containing the $path_name in os appropriate format. 
# NOTES
# CURRENT_DIRECTORY is a constant which must be defined in the 
# calling script as follows:
# define ("CURRENT_DIRECTORY",realpath(dirname(__FILE__))); 	      	  
# SOURCE
*/
            
function formatPath($path_name) {

//Note for this to work you must define CURRENT_DIRECTORY as follows in main script:
//define ("CURRENT_DIRECTORY",realpath(dirname(__FILE__)));
				 				 

/* Give a Directory Name if using same directory of script and none is otherwise specified*/
if (dirname($path_name)==".") {
  $path_name=CURRENT_DIRECTORY."/".basename($path_name);

}
				 

  if(MS_WINDOWS) {
  $path_name=stripslashes($path_name);

  $path_name=preg_replace("/\//","\\",$path_name);  //get rid of any forward slashes
  }
				 
   return $path_name;
  
}


/*ROBODOC_END*/


/*ROBODOC*f phpcron_commonlib/is_email
# NAME
# is_email
# SYNOPSIS
# boolean is_email(string $email_address);  
# FUNCTION
# Validates an email address
# INPUTS
# $email_address 		- string containing an email address
# RESULT
# Returns a true if email is in correct format, false if not 
# BUGS
# None known, but since domain formats are constantly changing, there
# may be some obscure domains that this function will see as incorrect
# emails and not accept.		  
# SOURCE
*/
function is_email($email_address) {     

    if(!preg_match("/[\w\-][^@]+\@[\w\-][^@]+\.[\w\-][^@]+/",$email_address)) {

          return false;
    }  else {
        return true;
    }
}

/*ROBODOC_END*/

/*ROBODOC*f phpcron_commonlib/appendToFile
# NAME
# appendToFile
# SYNOPSIS
# string array appendToFile(string $new_file_contents, string $file_name);
# FUNCTION
# Appends $new_file_contents to file named by $file_name, if $file_name 
# does not exist, it will be created.
# INPUTS
# $new_file_contents  -  string containing text to be added to file
# $file_name          -  path and filename of file to be appended to
# RESULT
# Returns a string array containing error messages; the first element of the
# array  contains a success message, if it was unsuccessful, the first element 
# is empty (false) and the remaining elements (1-last) contain error  messages.
# EXAMPLE
# Example 1 - Short form:
# 
# $append_results=appendToFile($clear_message,$log_result_file);
# $append_results[0]=""; //does not echo success message, but you could
# if(trim($append_results)) {
# $error_messages.=implode(" ",$append_results);
# echo $error_messages;
# }
# 
# Example 2 - Long form:
# 
# $append_results=appendToFile($contents, $filename);
# if($append_results[0]) { //this would be successful save        
# //this collects the success message 
# $error_messages.=$append_results[0]; 
# } else { //append so collect error messages in elements 1 - last
# $index=1;
# while($append_results[$index]) {
# $error_messages.=$append_results[$index];
# $index++;
# }
# }
# echo $error_messages;	
# NOTES
# Relies on these other functions:
# /phpcron_commonlib/formatPath 					 
# /phpcron_commonlib/isPathbad 
# SOURCE
*/


function appendToFile($new_file_contents, $file_name)   {



  if(!trim($file_name)) {

      $save_results[1]="Error: No File Name Given";
      return $save_results;
  }

   $filename_stripped=formatPath($file_name);


       $path_errors=isPathbad($file_name, true, true);
      //check if directory is valid and file name is legal
      if (!$path_errors["directory"] and !$path_errors["file"]["name"]) {

       /* Open for reading and writing, place file pointer at end of file (append)
        , if does not exist attempt to create it */

          $fp = fopen( $file_name,"a+");

          if (!$fp) {
               $open_error="Error: File $filename_stripped Cannot Be opened. Check Permissions.<br>\n";
             } else {
             fwrite($fp,$new_file_contents);
             fclose ($fp);
          $save_results[0]="<strong>File $filename_stripped has been successfully saved.<strong><br>";
          }

       } else {

               $i=1;
              $save_results[1]="Error: Cannot save file $filename_stripped.<br>";
                 while ( list($file_or_dir, $error_messages) = each($path_errors)) {

                  while (list($each_message)  = each($error_messages)) {

                    $save_results[$i].= $path_errors[$file_or_dir][$each_message];
                    $i++;
                  }
              }




    }

    if ($open_error) {

        $save_results[$i]=$open_error;
    }

    return $save_results;
 }
 
/*ROBODOC_END*/

/*ROBODOC*f phpcron_commonlib/saveFile
# NAME
# saveFile
# SYNOPSIS
# string array saveFile(string $file_contents, string $file_name);
# FUNCTION
# Saves $file_contents to file named by $file_name. If $file_name already
# exists it will be overwritten, if not, it will be created.
# INPUTS
# $file_contents  -  string containing text to be saved
# $file_name      -  path and filename of file to be saved
# RESULT
# Returns a string array containing error messages; the first element of the
# array  contains a success message (or false if it failed). If it was
# unsuccessful, the remaining elements (1-last) contain error  messages. 
# EXAMPLE
# 
# Example 1 - Short form:
# 
# $save_results=saveFile($clear_message,$log_result_file);
# $save_results[0]=""; //does not echo success message, but you could
# if(trim($save_results)) {
# $error_messages.=implode(" ",$save_results);
# echo $error_messages;
# }
# 
# Example 2 - Long form:
# 
# $save_results=saveFile($contents, $filename);
# 
# if($save_results[0]) { //this would be successful save        
# //this collects the success message 
# $error_messages.=$save_results[0]; 
# } else { //save so collect error messages in elements 1 - last
# $index=1;
# while($save_results[$index]) {
# $error_messages.=$save_results[$index];
# $index++;
# }
# }
# echo $error_messages;	
# NOTES:
# This is essentially the same as the appendToFile function, but the pointer is
# at the beginning, not the end of the file. It relies on these other
# functions:
# 
# formatPath 					 
# isPathbad 
# SOURCE
*/  

function saveFile($new_file_contents, $file_name)   {

   /* Save File over file_name (overwrites);
  returns an array of $save_results; $save_results[0] is true on success, false on failure
  and failure messages are in remaining elements of array */

      $new_file_contents=trim(stripslashes($new_file_contents));   //strip slashes from paths
      $filename_stripped=formatPath($file_name);
      $path_errors=isPathbad($file_name, true, false);

      if (!isset($path_errors)) { //check if directory is valid and file name is legal
          $fp = @fopen( $file_name,"w"); //open for writing, place file pointer at beginning of file, if does not exist attempt to create it
             if (!$fp) {
               $open_error="Error: File $filename_stripped Cannot Be opened. Check Permissions.<br>\n";
             } else {

             fwrite($fp,$new_file_contents);
             fclose ($fp);
             $save_results[0]="<strong>File $filename_stripped has been successfully saved.<strong><br>";
	
             }
      $i=1;   
  
      } else {

          $i=2;
         $save_results[1]="Error: Cannot save file $filename_stripped.<br>";
	
          while ( list($file_or_dir, $error_message) = each($path_errors)) {

            while (list($each_message)  = each($error_message)) {

              $save_results[$i].= $path_errors[$file_or_dir][$each_message];
              $i++;
            }
        }


    }
    
    if ($open_error) {

        $save_results[$i]=$open_error;
    }
    
    return $save_results;
 
 }

/*ROBODOC_END*/


/*ROBODOC*f phpcron_commonlib/deleteFile
# NAME
# deleteFile - deletes file in unix and dos
# SYNOPSIS
# boolean deleteFile(string $file_name)
# FUNCTION
# Deletes file $filename in dos or unix
# INPUTS
# $file_name - name of file to be deleted
# RESULT
# Returns true on success, false on failure
# NOTES
# Must define MS_WINDOWS constant like so in the calling script:
# 
# if(preg_match("/WIN/", PHP_OS)) {
# define("MS_WINDOWS",true);
# } else {
# define("MS_WINDOWS",false);
# }
# SOURCE
*/

 function deleteFile($file_name) {


 if (!file_exists($file_name)) {
  return true; //if file doesn't exist than don't worry about it
 }
 clearstatcache(); //clear cache since will be checking same file again
 $path_errors=isPathBad($file_name, true, true);

 if ( !$path_errors["directory"]["write"] and !$path_errors["file"])  {

   if(MS_WINDOWS) {
   $file_name=formatPath($file_name);

   exec("del $file_name");

   } else {

    unlink($file_name);

   }
   return true;
 } else {


 return false;    //return false if errors - can't write to path
 }
}

/*ROBODOC_END*/

/*ROBODOC*f phpcron_commonlib/isInteger
# NAME
# isInteger - tests whether a string contains integers only
# SYNOPSIS
# boolean isInteger(string $integer_string)
# FUNCTION
# Checks whether $integer_string contains only integers
# INPUTS
# $integer_string - string to be tested
# RESULT
# Returns true on success, false on failure
# SOURCE
*/


function isInteger ($integer_string) {
  /* It's false if the string is null */
  if (!isset($integer_string)) {
    return false;
  }
  $i=0;
  $length=strlen($integer_string);
  while($i<$length) {
  $ch=substr($integer_string,$i,1);
  if (ord($ch) < 48 or ord($ch) > 57) { //this tests 0 through 9
    return false;
  }
  $i++;
  }
  return true;

}

/*ROBODOC_END*/

/*ROBODOC*f phpcron_commonlib/isIntegerInRange
# NAME
# isIntegerInRange - tests whether an integer is within a named range
# SYNOPSIS
# boolean isIntegerInRange(string $integer_string, integer $low, integer
# $high)
# FUNCTION
# Checks whether $integer_string contains an integer equal to or between the
# values  of $low and $high.
# INPUTS
# $integer_string - string to be tested
# $low 		- integer at low end of range
# $high 	- integer at high end of range
# RESULT
# Returns true if tested string is outside of the $low and $high range, 
# false otherwise. Values that equal $low and $high will return true. 
# SOURCE
*/


function isIntegerInRange ($integer_string, $low, $high) {
/* range is inclusive, so includes high and low values*/

    if  (!isInteger($integer_string)) {

    return false;
    }

    $myinteger=intval($integer_string);
    if (($myinteger < $low) or ($myinteger > $high)) {
    return false;
    } else {
    return true;
    }
}

/*ROBODOC_END*/

/*ROBODOC*f phpcron_commonlib/mailAttachment
# NAME
# mailAttachment - emails a file as a mime encoded attachment
# SYNOPSIS
# boolean mailAttachment( string $email_address, string $subject, 
# string $body, string $attachment, string $mimetype) 
# FUNCTION
# Mime encodes a file and emails it as an attachment. 
# INPUTS
# $email_address - the "To" email address
# $subject - Subject of email
# $body  - message to be included in the body of the email
# $attachment  - name of file to be attached
# $mimetype - mimetype of file to be encoded, e.g, "text/english"
# RESULT
# Returns an error message on failure. See the example below.
# EXAMPLE
# if($mailserver_error=mailAttachment
# ($admin_email_address, $subject, $body, $attachment, $mimetype)) {
# $error_messages.="Error: Unable to Email Log File:<br>\r\n".
# $mailserver_error;
# } else {	   //it succeeded
# $error_messages.="Emailed Log File to $admin_email_address";
# }
# echo $error_messages;
# SOURCE
*/

function mailAttachment( $email_address, $subject, $body, $attachment, $mimetype)  {

$boundary = md5(uniqid(time()));


//MIME MUST be first character in headers - no spaces  or carriage returns
$headers ="MIME-Version: 1.0
Content-type: multipart/mixed;boundary=\"$boundary\"

Multipart MIME message
\r\n";

$messagebody = "
--$boundary
Content-type: text/plain;charset=us-ascii
Content-transfer-encoding: 8bit

".$body
."\r\n";

$fp = fopen($attachment, "r");
$attached_file = fread($fp, filesize($attachment));
$attached_file = chunk_split(base64_encode($attached_file));
$file_name = basename($attachment);

$messagebody .= "
--$boundary
Content-type: ".$mimetype."; name=\"$file_name\"
Content-transfer-encoding: base64
Content-Disposition: attachment; filename=\"$file_name\"

".$attached_file
."

";


     // End of mail
     $messagebody .= "--$boundary--";

     $mail_result=@mail($email_address, $subject, $messagebody, $headers);

     if(!$mail_result) {
     $error_message="Mail message could not be sent.\r\n<br>
      Make sure you have a mail server installed and running.\r\n<br>";
      return $error_message; //returns true if unable to mail
     }
}

/*ROBODOC_END*/

/*ROBODOC*f phpcron_commonlib/isOtherPhpcrond
# NAME
# isOtherPhpcrond - checks to see if another phpcrond deamon process is running
# SYNOPSIS
# boolean  isOtherPhpcrond(void)
# FUNCTION
# Does a triple check (unix) or single check (dos) to see if another 
# phpcrond daemon is running. 
# 
# In unix and dos it checks to see if the phpcron_psinfo_file exists in the 
# current directory of the script. 
# 
# Under unix,the function will also 1) check the /tmp directory since  
# phpcrond will also generate a file there in unix if the directory exists  
# and is writeable, and 2) grep the ps command to see if it can detect an  
# instance of phpcron.
# PURPOSE
# It is vital that only one phpcrond daemon run at the same time - especially
# on a box  that is being used by many users (e.g., a virtual hosting box).
# This function  tries its best to detect whether such other instance is
# running. 
# RESULT
# Returns true if another instance of phpcrond is detected, false if not. 
# BUGS
# Since it relies on a specific use of the ps, the ps check may not work under 
# some versions of Unix. 
# SOURCE 
*/

function isOtherPhpcrond() {

/*Triple check done initially in phpcron.php to see if there is another instance running */

global $phpcron_psinfo_file;
$other_instance=false;
$temp_path="$TEMP_DIR/".basename($phpcron_psinfo_file);

if(file_exists($phpcron_psinfo_file)) {
    //Check to see if another instance is running

      deleteFile($phpcron_psinfo_file);
      sleep(1); //wait for phpcron to create again if there is another instance
      clearstatcache(); //clear cache since will be checking same file again
      if (file_exists($phpcron_psinfo_file)) {
      $other_instance=true;


      }

}
if(is_writeable("$TEMP_DIR/") and file_exists("$TEMP_DIR/".basename($phpcron_psinfo_file))) {


    //Check temp directory to see if a file ps info file is there

      deleteFile($temp_path);

      
      sleep(1); //wait for phpcron to create again if there is another instance
      clearstatcache(); //clear cache since will be checking same file again
      if (file_exists("$TEMP_DIR/".basename($phpcron_psinfo_file))) {
      $other_instance=true;

      }

}


//check in the tmp directory

exec("ps ef | grep '^*phpcron.php*daemon.*$'",$output,$result_code);
$number_of_instances=count($output);
if($number_of_instances>1) {

$other_instance=true;

}

return $other_instance;

}

/*ROBODOC_END*/

/*ROBODOC*f phpcron_commonlib/stopOtherPhpcron
# NAME
# stopOtherPhpcron
# SYNOPSIS
# boolean stopOtherPhpcron(void)
# FUNCTION
# Stops all Phpcron daemons that may be running. Does so by saving a  "stop"
# file ($phpcron_off) in the phpcron directory and in the $TEMP_DIR which when
# detected by phpcron.php will stop that process. 
# RESULT
# True on success, false on failure.
# SOURCE
*/

function stopOtherPhpcron(){

/* Stops all phpcron daemons gracefully. */
global $phpcron_off;

   
    $save_errors=saveFile("PHPCRON Stopped",$phpcron_off);
    
    $save_errors=implode("<br>",$save_errors);
   // echo "<br>".$save_errors;
 
    saveFile("PHPCRON Stopped","$TEMP_DIR/".basename($phpcron_off));

    sleep (1); //wait for it to stop
   
    return !isOtherPhpcrond(); //checks to see if any other phpcrond is still running and returns true/false

}

/*ROBODOC_END*/

/*ROBODOC*f phpcron_commonlib/parseCronTimeParams
# NAME
# parseCronTimeParams
# SYNOPSIS
# boolean parseCronTimeParams(string $time_param_string)
# FUNCTION
# Parses phpcrontab parameter string (minute, hour, date of month, day of week
# in traditional unix crontab format) and returns true or false whether current
# time matches. Implements ranges and alternate values and you can mix and
# match. E.g., you can do this: 18,20-25,20 1-2 * * *  
# RESULT
# True if matches current time, false on failure.
 SOURCE
*/

function parseCronTimeParams($time_param_string) {

/* Parses phpcrontab parameter string (minute, hour, date of month, day of
week in traditional unix crontab format) and returns true or false whether
current time matches. Implements ranges and alternate values and you can mix
and match. E.g., you can do this: 18,20-25,20 1-2 * * *       */


/*Separate string by spaces, if it does not equal 5 then can't parse */

if (count($tparams=explode(" ",$time_param_string)) <> 5) {
return false;
}

/* Get Current time in same format as $time_param_string */
$timestamp= trim(date("i H d m w"));

/*Put individual vales of time stamp into sequential array */
$timestamp=explode(" ",$timestamp);

/*Main Loop - Cycle through each time parameter and match
to actual time */

$i=0;
while (isset($tparams[$i])) {


/***********Check for Asterisk************/

if (preg_match("/^\*$/",$tparams[$i])) {

$i++;
continue 1; /*Go to Next Value*/
} elseif (preg_match("/^".$timestamp[$i]."$/",$tparams[$i])) {

/***********Check for Exact Match***********/

$i++;
continue 1; /*Go to Next Value*/
                            //a #    or    a range        comma optional [repeat one or more times to end]
} elseif (preg_match("/^(([0-9]{1,2}|[0-9]{1,2}-[0-9]{1,2}),?)+$/",$tparams[$i])) {

/**********Check for Comma and Ranges (can be mixed)*************/


/*Separate Out Values Separated by Commas*/
$alternate_values=explode(",",$tparams[$i]);
$i_av=0;

/*Cycle through each value to compare with corresponding time unit*/

while (isset($alternate_values[$i_av])) {

/* Check for individual number match */
if ($alternate_values[$i_av]==$timestamp[$i]) {

 /*Continue with outer while loop since we have a match
and try next value */
$i++;

continue 2;

}

/*Check if this alternate value is also a range*/

if (preg_match("/^([0-9]{1,2}-[0-9]{1,2})$/",$alternate_values[$i_av])) {

/*If so, check the range */

/*Separate Out Low and High of Range Separated by Hyphen*/
$range=explode("-",$alternate_values[$i_av]);

if (isIntegerInRange($timestamp[$i], $range[0], $range[1])) {
/* Continue with outer loop if it's within range */
$i++;
continue 2; 
}

} 


$i_av++; /*Increment $alternate_values[$i_av] */
}

return false; //if it makes it this far there has been no matches

} else {
/* If doesn't match any of the patterns it's non-conforming */
return false; 
}

$i++; /* Increment tparams[$i] value */
}
return true;

}

/*ROBODOC_END*/

/*ROBODOC*f phpcron_commonlib/isCronTimeParamsBad
NAME
# isCronTimeParamsBad
# SYNOPSIS
# boolean isCronTimeParamsBad(string $time_param_string, int $command_number)
# FUNCTION
# Validates phpcrontab parameter string (minute, hour, date of month, day of
# week in traditional unix crontab format) and returns error messages (true) if
# string is bad or false if ok.  
# INPUTS
# string $time_param_string - a parameter string extracted from the 
# 			    phpcrontab.conf file (e.g., * 2-4,7,12 * * 3)
# int $command_number - line number in phpcrontrab.conf containing parameter 
# 	              string
# RESULT
# Error messages (true) if string is bad or false if ok.  
# SOURCE
*/

function isCronTimeParamsBad($time_param_string, $command_number) {


/*Separate string by spaces, if it does not equal 5 then can't parse */

if (count($tparams=explode(" ",trim($time_param_string))) <> 5) {
$error_messages.="Error in Command #$command_number: Parameter String Must Have 5 Parameters.<br>";

return $error_messages;
}

/* Set Correct high and low for each parameter */

 $correct_range[0]["low"] = 0;
 $correct_range[0]["high"] = 59;
 $correct_range[0]["unit"] = "Minutes";
 $correct_range[1]["low"] = 0;
 $correct_range[1]["high"] = 23;
 $correct_range[1]["unit"] = "Hour";
 $correct_range[2]["low"] = 1;
 $correct_range[2]["high"] = 31;
 $correct_range[2]["unit"] = "Day of Month";
 $correct_range[3]["low"] = 1;
 $correct_range[3]["high"] =12;
 $correct_range[3]["unit"] = "Month";
 $correct_range[4]["low"] = 0;
 $correct_range[4]["high"] = 6;
 $correct_range[4]["unit"] = "Day of Week";
  
 
/*Main Loop - Cycle through each time parameter and validate*/

$i=0;
while (isset($tparams[$i])) {


/***********Check for Asterisk************/

if (preg_match("/^\*$/",$tparams[$i])) {

$i++;
continue 1; /*Go to Next Value*/
} elseif (preg_match("/^[0-9]+$/",trim($tparams[$i]))) {

/***********Check for Single Number***********/
if (isIntegerInRange($tparams[$i], $correct_range[$i]["low"], $correct_range[$i]["high"])) {
/* Continue with loop if it's within range */
$i++;
continue 1; 
} else {

$error_messages.="Error in Command #$command_number: ".$tparams[$i]." is an incorrect value for ".$correct_range[$i]["unit"].", it must be between ".$correct_range[$i]["low"]." and ".$correct_range[$i]["high"].".<br>\r\n";

}

} elseif (preg_match("/^(([0-9]{1,2}|[0-9]{1,2}-[0-9]{1,2}),?)+$/",$tparams[$i])) {

/**********Check for Comma and Ranges (can be mixed)*************/


/*Separate Out Values Separated by Commas*/

$tparams[$i]=str_replace(",", " ", $tparams[$i]);

//$error_messages.="Parameter String: $tparams[$i]<br>";
$alternate_values=explode(" ",$tparams[$i]);

$i_av=0;

/*Cycle through each value to compare with corresponding time unit*/

while (isset($alternate_values[$i_av])) {

/*Check if it is a range */
	
if(preg_match("/^[0-9]{1,2}-[0-9]{1,2}$/",$alternate_values[$i_av])) {

	$range=explode("-",$alternate_values[$i_av]);
	
	/*Make Sure High > Low */
	
	if ($range[0]>=$range[1]) {
	$error_messages.="Error in Command #$command_number: Low value of range ".$alternate_values[$i_av]." in ".$correct_range[$i]["unit"]." field is greater than or equal to high value.<br>\r\n";
	}
	$i_range=0;
	while(isset($range[$i_range])){
	if (!isIntegerInRange($range[$i_range], $correct_range[$i]["low"], $correct_range[$i]["high"])) {

	$error_messages.="Error in Command #$command_number: ".$range[$i_range]." is an incorrect value for ".$correct_range[$i]["unit"].", it must be between ".$correct_range[$i]["low"]." and ".$correct_range[$i]["high"].".<br>\r\n";

	}
	$i_range++;
	}

	$i_av++;
	continue; //continue with while loop
          
}

/*If not a range, check individual value*/

//$error_messages.="Value: $alternate_values[$i_av]<br>";
if (!isIntegerInRange($alternate_values[$i_av], $correct_range[$i]["low"], $correct_range[$i]["high"])) {


$error_messages.="Error in Command #$command_number: ".$alternate_values[$i_av]." is an incorrect value for ".$correct_range[$i]["unit"].", it must be between ".$correct_range[$i]["low"]." and ".$correct_range[$i]["high"].".<br>\r\n";

}


$i_av++; /*Increment $alternate_values[$i_av] */
}

} else {
/* If doesn't match any of the patterns it's non-conforming */
$error_messages.="Error in Command #$command_number: The time parameters are in incorrect format<br>\r\n";

}

$i++; /* Increment tparams[$i] value */
}
return $error_messages;

}


/*ROBODOC_END*/

/*ROBODOC*f phpcron_commandlib/downloadFile
# NAME
# downloadFile
# SYNOPSIS
# boolean downloadFile(string $download_file_path, string $download_file_name)
# FUNCTION
# Sends an octet stream header to browser forcing a download of the file  found
# at $download_file_path with the $download_file_name.  It needs to be called
# before headers are sent and should end before any output is sent or use
# output buffering.  
# INPUTS
# string $download_file_path - path of the file to be downloaded
# string $download_file_name - file name which the download file will be
# saved as on the local computer (not the name
# 			     of the download file on the server)
# RESULT
# False on failure, true on success.
# EXAMPLE
# if($download_log) {
# $download_file_name="phpcron_logfile".date("mdy_H_i").".txt";    
# downloadFile($log_result_file, $download_file_name);
# exit;  
# }
# SOURCE
*/

function downloadFile($download_file_path, $download_file_name) {
   
if (!$download_file_path or !file_exists($download_file_path) or !is_readable($download_file_path)) {

return false;
}
$data=file($download_file_path);

$data=trim(implode("",$data));

header ("Content-length: " . strlen($data)); 
header ("Content-type: application/octetstream");
header ("Content-disposition: inline; filename=$download_file_name");

print($data);
  
return true;        
} 

/*ROBODOC_END*/


?>
