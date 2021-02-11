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
  $user->setloggedoff();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
  <head>
    <title><?php print (SYSTEM_NAME . "&nbsp;" . "Log Out");?></title>
    <link rel="stylesheet" type="text/css" href="themes/petrol/stylesheet.css" />
  </head>
  <body onLoad='document.searchForm.searchBox.focus()'>
<div id="fullpage">
    <?php include('includes/topbox.php'); ?>

    <!-- end header part -->
  <? include('includes/sidebar.php'); ?>

   <!-- page contents -->
   <div id="mainsearch">
     <fieldset>
     <form action="." method="get" id="searchForm" name="searchForm">
       <table  width="200px">
       <tr><td ><h1 id="pagetitle"><?php print T_("You have now been logged out."); ?></h1></td></tr>
         
         
       <tr><td ></td></tr><tr><td ><a href="index.php"><?php print T_("Continue");?></a></td></tr>
       </table>
       </form>
     </fieldset>
     </div>

</div>
  </body>
</html>


