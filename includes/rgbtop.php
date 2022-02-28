<?php
/*************************************************************************
*   This file is part of Rgbtrade
*
*   Rgbtrade is free software: you can redistribute it and/or modify
*   it under the terms of the GNU General Public License as published by
*   the Free Software Foundation, either version 3 of the License, or
*   (at your option) any later version.
*
*   Rgbtrade is distributed in the hope that it will be useful,
*   but WITHOUT ANY WARRANTY; without even the implied warranty of
*   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*   GNU General Public License for more details.
*
*   You should have received a copy of the GNU General Public License
*   along with Rgbtrade.  If not, see <http://www.gnu.org/licenses/>.
**************************************************************************/

if(!isset($_SESSION)) {
   session_set_cookie_params(3600,'/');
   session_start();
}
if('DEBUG') {
   error_reporting(E_ALL);
} else {
   error_reporting(E_ERROR);
}
 require_once('includes/gettext.inc');
 include_once("includes/gettext.php");          // PHP-gettext. Not using default server-side, usually is not there
 if (is_file("includes/rgbConfig.php")) {
   include_once("includes/rgbConfig.php");
 } else {
     print T_("Please make a configuration file first. Use the example includes/rgbConfig-example.php and name it includes/rgbConfig.php");
 }
 include_once("includes/rgbUser.php");
 include_once("includes/box.php");
 include_once("includes/pagedresults.php");     // by sitepoint.com
 include_once("includes/resultbox.php");
 include_once("includes/rgbCategory.php");

 /**
 * manually include required rgb Classes in each page - save load every run 
 * include("includes/rgbDimension.php");
 * include("includes/rgbValue.php");
 * include("includes/rgbBalance.php");
 * include("includes/rgbTransfer.php");
 * include("includes/rgbAd.php");
 * include("includes/forms.php");             // by mlemos
 */ 

 $db = mysqli_connect($host, $user, $pass)
    or die('Could not connect: ' . mysqli_error($db));
  mysqli_select_db($db,$dbname) or die('Could not select database');

 mysqli_set_charset($db,'CHARSET'); 


  define('PROJECT_DIR', realpath('./'));
  define('LOCALE_DIR', PROJECT_DIR .'/includes/locale');
         
  require_once('gettext.inc');

  $supported_locales = array('en_US', 'nl_NL', 'pt_BR');
  $encoding = 'UTF-8';
  
  $locale = (isset($_GET['lang']))? $_GET['lang'] : DEFAULT_LOCALE;
  T_setlocale(LC_MESSAGES, $locale);
  // Set the text domain to the language, so we have files called nl_NL.po and .mo.
  $domain = DEFAULT_LOCALE;
  T_bindtextdomain($domain, LOCALE_DIR);
  T_bind_textdomain_codeset($domain, $encoding);
  T_textdomain($domain);
  
 header("Content-type: text/html; charset=$encoding");

 function pc_error_handler($errno, $error, $file, $line) {
   $now=date('H:i:s');
   // $message = "[$now] [$error] [$file:$line]";
   $fileshort=substr($file,-20);
   $message = "[$now] [$fileshort:$line] [$error]";
   error_log($message);
   if ($log = fopen('log/error.txt','a'))
   { 
     fwrite($log, $message."\n");
   }
   else 
   { 
     print "<!-- No Log File - not writeable -->";
   }

 }

 function pc_debug($message,$file,$line) {
   if (defined('DEBUG') && DEBUG) {
     error_log($message);
     pc_error_handler(512,$message,$file,$line);
   }
 }
 
 function user_message($title,$text,$url,$severity) {
   switch($severity){
     case "red":
       $style="error_red";
       break;
    case "green":
      $style = "error_green";
      break;
     }
     print("<div class=\"message\"><h3 class=\"$style\">$title</h3><p class=\"$style\">$text</p>");
     print sprintf("<br>" . T_("Please %s continue") . "</a></div></div></div></html>",
          "<a href=\"$url\">");
 }

 // running every call, set main / mini search box
       
       if (isset($_GET['section'])) {
         $section = htmlentities($_GET['section']);
       } else {
         if(isset($minisection)) {
         $section = $minisection;
         } else {
           $section = "";
         }
       }
       if (isset($_GET['q'])) {
         $q = htmlentities($_GET['q']);
       } else {
         $q = "";
       }

       switch($section) {
           case "offers":
           default:
               $tr = '<tr><td align="left"><b>' . T_("Offers"). '</b></td><td align="center"><a href="index.php?section=requests" 
                   onclick="return qs(this)">' . T_("Requests") . '</a></td><td align="right"><a onclick="return qs(this)" 
                   href="index.php?section=participants">' . T_("Participants") . '</a></tr>';
               $trmini = '<tr><td align="left"><b>' . T_("Offers"). '</b></td><td align="center"><a href="index.php?section=requests" 
                   onclick="return qs(this)">' . T_("Requests") . '</a></td></tr><tr><td colspan="2" align="center"><a 
                   onclick="return qs(this)" href="index.php?section=participants">' . T_("Participants") . '</a></tr>';
               $title = T_("Search in:");
               $getaction = "adlist.php?section=offers";
               $section = "offers"; // for later use
           break;
           case "requests" : 
               $tr = '<tr><td align="left"><a onclick="return qs(this)" href="index.php?section=offers">' . T_("Offers"). 
                   '</a></td><td align="center"><b>' . T_("Requests") . '</b></td><td align="right"><a 
                   onclick="return qs(this)" href="index.php?section=participants">' . T_("Participants") . '</a></tr>';
               $trmini = '<tr><td align="left"><a onclick="return qs(this)" href="index.php?section=offers">' . 
                   T_("Offers"). '</a></td><td align="center"><b>' . T_("Requests") . '</b></td></tr><tr><td align="center" 
                   colspan="2"><a onclick="return qs(this)" href="index.php?section=participants">' . T_("Participants") . '</a></tr>';
               $title = T_("Search in:");
               $getaction = "adlist.php?section=requests";
           break;
           case "participants":
               $tr= '<tr><td align="left"><a onclick="return qs(this)" href="index.php?section=offers">' . 
                   T_("Offers"). '</a></td><td align="center"><a href="index.php?section=requests" onclick="return qs(this)">' . 
                   T_("Requests") . '</a></td><td align="right"><b>' . T_("Participants") . '</b></tr>';
               $trmini = '<tr><td align="left"><a onclick="return qs(this)" href="index.php?section=offers">' . 
                   T_("Offers"). '</a></td><td align="center"><a href="index.php?section=requests" onclick="return qs(this)">' . 
                   T_("Requests") . '</a></td></tr><tr><td colspan="2" align="center"><b>' . T_("Participants") . '</b></tr>';
               $title = T_("Search in:");
               $getaction = "participants.php";
            break;
           }
    pc_debug("participants_section: $section",__FILE__,__LINE__);
    


?>
