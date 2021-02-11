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
  include("includes/rgbTransfer.php");
  include("includes/rgbDimension.php");
  $user->loadUser();
  if(!$user->getLoggedIn()) {
      header("location:index.php");
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title><?php print SYSTEM_NAME ." " . 
     T_("End Of Year Administration");?></title>
    <link rel="stylesheet" type="text/css" href="themes/petrol/stylesheet.css" />
  </head>
  <body onLoad='document.searchForm.searchBox.focus()'>
  <?php $participant="bla"; ?>
    <?php include('includes/topbox.php'); ?>

    <!-- end header part -->
  <? include('includes/sidebar.php'); ?>

   <!-- page contents -->

<? 
  // This page can only be used at DAY_OUT_OF_TIME, so, is today the DAY_OUT_OF_TIME ?
  //
  $today = getdate();                                   // array, $today['mon'] $today['mday']
  $todaystring = $today['mon'] . "-" . $today['mday'] ; // construct same string formatting as DAY_OUT_OF_TIME : 12-21
  if (defined('DAY_OUT_OF_TIME') && $todaystring == DAY_OUT_OF_TIME) {
      print "it is today : $todaystring";
    
      if(isset($_GET['start']) && ($_GET['start'] == "true" )) {
          // we start the process here
          // if the process has already ran today, we have to see that first
          $thisyear = $today['year']; // format : 2008
          // check for that after we wrote the rest 
          //
          // what are we going to do
          // just hit the stored procedure, with today as parameter. we can then always trick the
          // procedure to run afterwards, when missed
          //

      } else {
          // we offer a link to start the process

      $dbox = new Box;
      $dbox->setCssClass("message");
      $dbox->setTitle(T_("End Of Year Administration"));
      $dbox->setText(T_("Today ") .  $todaystring . T_(", is the Day Out Of Time for this system. Congratulations.  You should make sure the End-Of-Year-Administration is done today. So, <a href='endofyearadmin.php?start=true'>Start the End-Of-Year-Administration</a>."));
      $dbox->setVisible(true);
      $dbox->show();
      }
  } else {
      // this page is closed, sorry
    $box=new Box;
    $box->setCssClass("message");
        $box->setTitle(T_("Page Closed"));
    $box->setText(T_("The End Of Year Administration can only be done at the dedined Day Out Of Time,") 
        .  DAY_OUT_OF_TIME . T_("If it was missed, please contact upstream development for support."));
        $box->setVisible(true);
        $box->show();
  }
?>
    </div>




  </body>
</html>
