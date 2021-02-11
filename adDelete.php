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
  include("includes/rgbtop.php");
  include("includes/loggedin.php");
  include("includes/rgbAd.php");
  include("includes/rgbDimension.php");

 # pick up adId from get parameter
 # get session userId
 # match the above. not allow deleting other persons ad
  #
  #
  $user->loadUser();

  if(isset($_GET['adId'])) {
      $myAd = new rgbAd();
      $myAd->setAdId(mysql_real_escape_string($_GET['adId']));
      $myAd->load();
       if ($myAd->getUserId() == $user->getUserId() ) {
           $myAd->delete();
           $head ="Ok";
           $text= sprintf(T_("Your ad has been deleted. Please %s continue to your ad list %s."),
               "<a href=\"adlist.php?nick=" .$_SESSION['userNick'] .  "\">", 
               "</a>");
       } else {
           header("location:index.php");
       }
  }
      

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title><?php print SYSTEM_NAME . "&nbsp;" . T_("Delete Ad");?></title>
    <link rel="stylesheet" type="text/css" href="themes/petrol/stylesheet.css" />
    <link rel="shortcut icon" href="favicon.ico">


  </head>
  <body>
    <?php include('includes/topbox.php'); ?>

    <!-- end header part -->
  <? include('includes/sidebar.php'); ?>

   <!-- page contents -->
       <div id="resultbox_high">
       <? print "<h1 id=\"pagetitle\">$head</h1><p>$text</p>"; ?>
       </div>
    </div>
  </body>
</html>


