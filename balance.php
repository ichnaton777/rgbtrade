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
  include("includes/rgbTransfer.php");

  $showUser = new rgbUser;
  if (isset($_GET['nick'])) {
    $showUser->setUserNick(mysqli_real_escape_string($db,stripslashes($_GET['nick'])));
  } else {
    if ($user->getloggedin()) {
       $showUser->setUserNick($user->getUserNick());
    } else {
      pc_debug("Balance requested but no nick given and not logged in.",__FILE__,__LINE__);
      user_message(T_("Ooops"),T_("Please login before asking for your balance"),"index.php","red");
    }
  }
  $showUser->loadUser();
  $showBalance = new rgbBalance();
  $showBalance->setUserId($showUser->getUserId());
  $showBalance->loadBalance();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title><?php print SYSTEM_NAME . "&nbsp;" . T_("Balance");?></title>
    <link rel="stylesheet" type="text/css" href="themes/petrol/stylesheet.css" />
    <link rel="shortcut icon" href="favicon.ico">
  </head>
  <body onLoad='document.searchForm.searchBox.focus()'>
<div id="fullpage">
    <?php include('includes/topbox.php'); ?>

    <!-- end header part -->
  <? include('includes/sidebar.php'); ?>

   <!-- page contents -->
   <div id="contents">
<?php
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
  $menuBox ->setTitle($showUser->getUserNick() . " " .
     $showUser->getUserLink("profile.php",T_("Profile")) . "|" .
     $showUser->getUserLink("transferlist.php",T_("Transfers")) . "|" .
     $tlink .
     $showUser->getUserLink("adlist.php",T_("Ads"))      . "|".
     $contactlink
  );
  $menuBox->titleBox();


    $balanceBox2 = new resultBox("","balancebox2","7","petrol","#ffffff","widebox",604);
    $balanceBox2->setTitle(T_("Balance"));
    $balanceBox2->boxStart();
    // widht = 604-32=572. 4x143
    $titles = array(T_('Date') =>'133'  , T_('Red')=>'113','/8'=>'20',
       T_('Green')=>'113',' /8'=>'20',T_('Blue')=>'113','  /8'=>'20');
    $balanceBox2->boxHorTitleRow($titles);
    $balanceBox2->boxLeftEdge();
    $balanceBox2->boxCell($showBalance->showBalanceDateTime());
    $balanceBox2->boxCell($showBalance->balanceRedValue->getRoundedValue() , 'rdata');
    $balanceBox2->boxCell($showBalance->balanceRedValue->get8thImg(),'rdata');
    $balanceBox2->boxCell($showBalance->balanceGreenValue->getRoundedValue() , 'rdata');
    $balanceBox2->boxCell($showBalance->balanceGreenValue->get8thImg(),'rdata');
    $balanceBox2->boxCell($showBalance->balanceBlueValue->getRoundedValue() , 'rdata');
    $balanceBox2->boxCell($showBalance->balanceBlueValue->get8thImg(),'rdata');
    $balanceBox2->boxRightEdge();
    $balanceBox2->boxEnd();

    $yearlyBox = new resultBox("","yearlybox","7","petrol","#ffffff","widebox",604);
    $yearlyBox->setTitle(T_("Yearly Total"));

    $yearlyBox->boxStart();
    // widht = 604-32=572. 4x143
    $titles = array(T_('Date') =>'133'  , T_('Red')=>'113','/8'=>'20',
       T_('Green')=>'113',' /8'=>'20',T_('Blue')=>'113','  /8'=>'20');
    $yearlyBox->boxHorTitleRow($titles);
     // code from longtermbox, strip html tags
    $balcount=50;
    $sql = "select *, DATE(balanceDateTime) as baldate from rgbBalances where 
       balanceType = 'milestone' and balanceUserId = " . $showUser->getUserId() . 
       " order by balanceDateTime asc limit $balcount" ;
    $q= mysqli_query($db,$sql);
    if(mysqli_error($db)) {
       pc_debug("mysqli error: " . mysqli_error($db)  , __FILE__,__LINE__);
    } else {
          if(mysqli_num_rows($q) >0) {
             while($result=mysqli_fetch_assoc($q)) {
             // pc_debug("balance= " . $result['balanceName'] ,__FILE__,__LINE__);
             //  print "<tr><td class='minidata'>" . $result['balanceName'] . "</td>";
             $yearlyBox->boxLeftEdge();
             $yearlyBox->boxCell(strftime("%F",strtotime($result['baldate'])),'rdata');
             $rv = new rgbDimension;
             $rv->setValue($result['balanceRedValue']);
             $gv = new rgbDimension;
             $gv->setValue($result['balanceGreenValue']);
             $bv = new rgbDimension;
             $bv->setValue($result['balanceBlueValue']);
             $yearlyBox->boxCell($rv->getRoundedValue(),'rdata');
             $yearlyBox->boxCell($rv->get8thImg(),'rdata' );
             $yearlyBox->boxCell($gv->getRoundedValue(),'rdata');
             $yearlyBox->boxCell($gv->get8thImg(),'rdata' );
             $yearlyBox->boxCell($bv->getRoundedValue(),'rdata');
             $yearlyBox->boxCell($bv->get8thImg(),'rdata' );
             $yearlyBox->boxRightEdge();
           }     
         }   
     }
    $yearlyBox->boxEnd();
  ?>

 </div><!-- div contents -->
</div>
  </body>
</html>


