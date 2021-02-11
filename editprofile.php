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
  $user->loadUser();
  if(!($user->getLoggedin() )) {
  // when logged in, assume we are going to edit $user. disregard $_GET['nick']!
     header("location:error.php?error=login");
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
  <head>
  <title><?php print SYSTEM_NAME . " ". T_("Change Profile");?></title>
    <link rel="stylesheet" type="text/css" href="themes/petrol/stylesheet.css" />
  </head>
  <body>
<div id="fullpage">
    <?php include('includes/topbox.php'); ?>

    <!-- end header part -->
  <? include('includes/sidebar.php'); ?>

   <!-- page contents -->

   <form action="profile.php" enctype="multipart/form-data" method="post">

<?php

  $profileBox = new resultBox("","profilebox2",2,"petrol","#ffffff","widebox",400);
  $profileBox->setTitle(T_("Edit your profile"));
  $profileBox->boxStart();

  $profileBox->boxLeftEdge();
  $profileBox->boxCell(T_("Email:"),"datalabel");
  $profileBox->boxCell($user->getUserEdit("email",$user->getEmail()));
  $profileBox->boxRightEdge();

  $profileBox->boxLeftEdge();
  $profileBox->boxCell(T_("Adress:"),"datalabel");
  $profileBox->boxCell($user->getUserEdit("address",($user->getAddress())));
  $profileBox->boxRightEdge();

  $profileBox->boxLeftEdge();
  $profileBox->boxCell(T_(""),"datalabel");
  $profileBox->boxCell($user->getUserEdit("address2",($user->getAddress2())));
  $profileBox->boxRightEdge();

  $profileBox->boxLeftEdge();
  $profileBox->boxCell(T_("Zip Code:"),"datalabel");
  $profileBox->boxCell($user->getUserEdit("zipcode",($user->getZipCode())));
  $profileBox->boxRightEdge();

  $profileBox->boxLeftEdge();
  $profileBox->boxCell(T_("City:"),"datalabel");
  $profileBox->boxCell($user->getUserEdit("city",($user->getCity())));
  $profileBox->boxRightEdge();

  $profileBox->boxLeftEdge();
  $profileBox->boxCell(T_("Area:"),"datalabel");
  $profileBox->boxCell($user->getUserEdit("region",($user->getRegion())));
  $profileBox->boxRightEdge();

  $profileBox->boxLeftEdge();
  $profileBox->boxCell(T_("Phone 1:"),"datalabel");
  $profileBox->boxCell($user->getUserEdit("phone1",($user->getPhone1())));
  $profileBox->boxRightEdge();

  $profileBox->boxLeftEdge();
  $profileBox->boxCell(T_("Phone 2:"),"datalabel");
  $profileBox->boxCell($user->getUserEdit("phone2",($user->getPhone2())));
  $profileBox->boxRightEdge();

  $profileBox->boxLeftEdge();
  $profileBox->boxCell(T_("Website:"),"datalabel");
  $profileBox->boxCell($user->getUserEdit("website",($user->getWebsite())));
  $profileBox->boxRightEdge();

  $profileBox->boxLeftEdge();
  $profileBox->boxCell(T_("Plan:"),"datalabel");
  $profileBox->boxCell("<textarea name=plan cols=30 rows=5 class=formInput>" . stripslashes($user->getPlan()). "</textarea>");
  $profileBox->boxRightEdge(). "</textarea>";

  $profileBox->boxLeftEdge();
  $profileBox->boxCell(T_("Avatar:"),"datalabel");
  $profileBox->boxCell($user->getAvatarImage());
  $profileBox->boxRightEdge();

  $profileBox->boxLeftEdge();
  $profileBox->boxCell(T_("Change Avatar:"),"datalabel");
  $profileBox->boxCell("<input size=\"15\" type=file class=\"formInput\" name=\"avatar\">");
  $profileBox->boxRightEdge();

  $profileBox->boxLeftEdge();
  $profileBox->boxCell(T_("Password"),"datalabel");
  $profileBox->boxCell('<input type=password class="formInput" name="password1" size="10" value="">'); 
  $profileBox->boxRightEdge();

  $profileBox->boxLeftEdge();
  $profileBox->boxCell(T_("Repeat Password"),"datalabel");
  $profileBox->boxCell('<input type=password class="formInput" name="password2" size="10" value="">'); 
  $profileBox->boxRightEdge();

  $profileBox->boxLeftEdge();
  $profileBox->boxCell("<input type=\"button\" Value=" . T_("Cancel") . 
     " align=\"right\" onClick=\"location.href='profile.php'\">");
  $profileBox->boxCell("<input type=\"submit\" value=\"". T_("Save") . "\">");
  $profileBox->boxRightEdge();

  $profileBox->boxEnd();
?> 
   <input type="hidden" name="action" value="saveuser">
</form>



</div>
  </body>
</html>
