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
  include("includes/rgbBalance.php");
  include("includes/rgbDimension.php");
  // silly to load user here, actually we need to get the avatar before an empty string is saved.
  //
  // $user already set at loggedin.php
  $user->loadUser();

  if(isset($_POST['action']) && $_POST['action'] == "saveuser") {
    if (isset($_FILES['avatar'])) {
         if(is_file($_FILES['avatar']['tmp_name'])) {
           $user->saveAvatar();
           pc_debug("avatar saved",__FILE__,__LINE__);
         }
    } else { 
      pc_debug("non new avatar",__FILE__,__LINE__);
    }
   # test for uniqueness of new email address
   # or update SQL query will fail hard.
    $email = $_POST['email']; 
    $user->setEmail($email);
    if($user->testUniqueEmail($user->getUserNick())) {
       $user->saveUser();
  } else {
     echo "Sorry, that email adres was already taken!";
  }
    if ($_POST['password1'] == $_POST['password2'] && $_POST['password1'] != '********' && $_POST['password2'] != '')
        // passwords match and are not the default star sequence
    { 
        $user->savePassword();
    }

    pc_debug("user saved",__FILE__,__LINE__);
  }
  $showUser = new rgbUser;
  if (isset($_GET['nick'])) {
    $showUser->setUserNick(mysqli_real_escape_string($db,stripslashes($_GET['nick'])));
  } else {
    if (isset($user) && $user->getloggedin()) {
       $showUser->setUserNick($user->getUserNick());
    } else {
      pc_debug("Profile requested but no nick given and not logged in.",__FILE__,__LINE__);
        header("location:error.php?error=login");
      // user_message("Ooops","Please login before asking for a profile","index.php","red");
    }
  }
  $showUser->loadUser();
  $showBalance = new rgbBalance();
  $showBalance->setUserId($showUser->getUserId());
  $showBalance->loadBalance();
  // pc_debug("balance = " .print_r($showBalance) , __FILE__,__LINE__); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title><?php print (SYSTEM_NAME . "&nbsp;" . "Profile");?></title>
    <link rel="stylesheet" type="text/css" href="themes/petrol/stylesheet.css" />
    <link rel="shortcut icon" href="favicon.ico">
  </head>
  <body onLoad='document.searchForm.searchBox.focus()'>
<div id="fullpage">
    <?php include('includes/topbox.php'); ?>

    <!-- end header part -->
  <? include('includes/sidebar.php'); ?>

   <!-- page contents -->
 <?php // include('themes/petrol/profile.php')?>
    <div id="contents">
 <?
  // menu, quite generic actually
 
  $menuBox = new resultbox("menu","menu",4,"petrol","#ffffff","widebox",604);
     if(isset($user) && $user->getloggedin()) {
        // safe to show this link
        $contactlink = " | ". $showUser->getUserLink("contact.php",T_("Contact"));
     } else {
        $contactlink = "";
     }
  if($user->getloggedin() &&$user->getUserNick() <> $showUser->getUserNick()) {
     $tlink = $showUser->getUserLink("transfer.php",T_("New Transfer")) . " | " ;
  } else {
     $tlink = "";
  }
  $menuBox ->setTitle(T_("Profile") . " | " .
     $showUser->getUserLink("balance.php",T_("Balance")) . " | " .
     $showUser->getUserLink("transferlist.php",T_("Transfers")) . " | " .
     $tlink .
     $showUser->getUserLink("adlist.php",T_("Ads"))      . 
     $contactlink
  );
  $menuBox->titleBox();

  $profileBox = new resultBox("","profilebox2",2,"petrol","#ffffff","widebox",400);
  // which edit links do we need to show?
          if ($user->getloggedin() && $user->getUserNick() == $showUser->getUserNick()) {
             // it is me
             $editlink = $showUser->getUserLink("editprofile.php",T_("Edit"));
          } else {
             $editlink = $showUser->getUserNick();
          }
  $profileBox->setTitle($editlink);
  $profileBox->boxStart();

  $profileBox->boxLeftEdge();
  $profileBox->boxCell(T_("Adress:"),"datalabel");
  $profileBox->boxCell(htmlentities($showUser->getAddress()));
  $profileBox->boxRightEdge();

  $profileBox->boxLeftEdge();
  $profileBox->boxCell("");
  $profileBox->boxCell(htmlentities($showUser->getAddress2()));
  $profileBox->boxRightEdge();

  $profileBox->boxLeftEdge();
  $profileBox->boxCell(T_("Zip Code:"),'datalabel');
  $profileBox->boxCell(htmlentities($showUser->getZipCode()));
  $profileBox->boxRightEdge();

  $profileBox->boxLeftEdge();
  $profileBox->boxCell(T_("City:"),"datalabel");
  $profileBox->boxCell(htmlentities($showUser->getCity()));
  $profileBox->boxRightEdge();


  $profileBox->boxLeftEdge();
  $profileBox->boxCell(T_("Area:"),"datalabel");
  $profileBox->boxCell(htmlentities($showUser->getRegion()));
  $profileBox->boxRightEdge();

  $profileBox->boxLeftEdge();
  $profileBox->boxCell(T_("Phone:"),"datalabel");
  $profileBox->boxCell(htmlentities($showUser->getPhone1()));
  $profileBox->boxRightEdge();

  $profileBox->boxLeftEdge();
  $profileBox->boxCell(T_("Phone 2:"),"datalabel");
  $profileBox->boxCell(htmlentities($showUser->getPhone2()));
  $profileBox->boxRightEdge();

  $profileBox->boxLeftEdge();
  $profileBox->boxCell(T_("Website:"),"datalabel");
  $profileBox->boxCell("<a href=\"". htmlentities($showUser->getWebsite()) . "\">" . htmlentities($showUser->getWebsite()) . "</a>");
  $profileBox->boxRightEdge();

  $profileBox->boxLeftEdge();
  $profileBox->boxCell(T_("Plan:"),"datalabel");
  $profileBox->boxCell(htmlentities($showUser->getPlan()));
  $profileBox->boxRightEdge();

  $profileBox->boxLeftEdge();
  $profileBox->boxCell(T_("Avatar:"),"datalabel");
  $profileBox->boxCell($showUser->getAvatarImage());
  $profileBox->boxRightEdge();


  $profileBox->boxEnd();
?>



   

   </div> <!--contents -->



</div> <!--fullpage-->
  </body>
</html>


