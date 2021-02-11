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
    $showUser->setUserNick(mysql_real_escape_string(stripslashes($_GET['nick'])));
  } else {
    if ($user->getloggedin()) {
       $showUser->setUserNick($user->getUserNick());
    } else {
      pc_debug("Balance requested but no nick given and not logged in.",__FILE__,__LINE__);
      user_message(T_("Ooops"),T_("Please login before asking for your transfers"),"index.php","red");
    }
  }
  $showUser->loadUser();
  $showBalance = new rgbBalance();
  $showBalance->setUserId($showUser->getUserId());
  $showBalance->loadBalance();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
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
  $menuBox ->setTitle($showUser->getUserNick() . " " .
     $showUser->getUserLink("profile.php",T_("Profile")) . " | " .
     $showUser->getUserLink("balance.php",T_("Yearly Totals")) . " | " .
     $tlink . 
     $showUser->getUserLink("adlist.php",T_("Ads"))      . 
     $contactlink
  );
  $menuBox->titleBox();


    $balanceBox2 = new resultBox("","balancebox2","4","petrol","#ffffff","widebox",604);
    $balanceBox2->setTitle(T_("Balance"));
    $balanceBox2->boxStart();
    // widht = 604-32=572. 4x143
    $titles = array(T_('Date') =>'173'  , T_('Red')=>'133',T_('Green')=>'133',T_('Blue')=>'133');
    $balanceBox2->boxHorTitleRow($titles);
    $balanceBox2->boxLeftEdge();
    $balanceBox2->boxCell($showBalance->showBalanceDateTime(),'rdata');
    $balanceBox2->boxCell($showBalance->balanceRedValue->getRoundedValue() .  " " .
                     $showBalance->balanceRedValue->get8thImg(),'rdata');
    $balanceBox2->boxCell($showBalance->balanceGreenValue->getRoundedValue() .  " " .
                     $showBalance->balanceGreenValue->get8thImg(),'rdata');
    $balanceBox2->boxCell($showBalance->balanceBlueValue->getRoundedValue() .  " " .
                     $showBalance->balanceBlueValue->get8thImg(),'rdata');
    $balanceBox2->boxRightEdge();
    $balanceBox2->boxEnd();

    $transfersBox = new resultBox("resultbox_low","transferbox","5","petrol","#ffffff","resultbox_low",604);
    $transfersBox->setTitle(T_("Transfers"));
    $transfersBox->boxStart();
    // $titles = array(T_('Date')=>'60',T_('Participant')=>'100',T_('RGB')=>'140',T_('Description')=>'260');
    $titles =  array(T_('Date')=>'110',T_('Participant')=>'110',T_('Red')=>'110',T_('Green')=>'110',T_('Blue')=>'110');
    $titles2 = array('&nbsp;'=>'110',' '=>'110',T_('Description')=>'110','.'=>'110',','=>'110');
    $transfersBox->boxHorTitleRow($titles);
    // get also the Nick of the ById
    $query = sprintf("select transferId, transferFromId, transferToId, transferText, transferById,
                     transferRedValue, transferGreenValue, transferBlueValue, 
                     transferDateTime, userNick, userId               
                     from rgbTransfers, rgbUsers               
                     where rgbTransfers.transferFromId = '%s' 
                     and rgbTransfers.transferToId = rgbUsers.userId    
                     UNION 
                     select transferId, transferFromId, transferToId, transferText, transferById,
                     transferRedValue, transferGreenValue, transferBlueValue, 
                     transferDateTime, userNick, userId               
                     from rgbTransfers, rgbUsers               
                     where rgbTransfers.transferToId = '%s' 
                     and rgbTransfers.transferFromId = rgbUsers.userId 
                     order by transferDateTime desc",
                     $showUser->getUserId(),
                     $showUser->getUserId()
                   );
                   pc_debug("query is $query",__FILE__,__LINE__);
    $pageSize = 4;
    $pagedResults = new MySQLPagedResultSet($query,$pageSize,$db);
      $transfersBox->boxRowBorder();
    while ($result = $pagedResults->fetchObject()) {
      $myTransfer = new rgbTransfer;
      $myTransfer->setId($result->transferId);
      $myTransfer->setFromId($result->transferFromId);
      $myTransfer->setToId($result->transferToId);
      $myTransfer->setById($result->transferById);
      $myTransfer->setText($result->transferText);
      $myTransfer->transferRedValue->setValue($result->transferRedValue);
      $myTransfer->transferGreenValue->setValue($result->transferGreenValue);
      $myTransfer->transferBlueValue->setValue($result->transferBlueValue);
      $myTransfer->setDateTime($result->transferDateTime);
      $myTransferPartnerId   = $result->userId;   # id of the other fellow
      $myTransferPartnerNick = $result->userNick; # nick of the other fellow
      if ($myTransferPartnerId == $myTransfer->getToId()) {
        $toFrom = T_("To") . " "; # to
        $sign = "- ";
      } else {
        $toFrom = T_("From") . " "; # to
        $sign = "";
      }
      // who ordered this transfer (the byId)? there is no byNick in the result, but who needs it. It's
      // either the partner, or just me (showUser)
      $by = T_("By");
      if ($myTransfer->getById() == $myTransferPartnerId) {
          $by .= " <a href=\"balance.php?nick=$myTransferPartnerNick\">$myTransferPartnerNick</a>";
      } else {
          $by .=  "  <a href=\"balance.php?nick=" . $showUser->getUserNick() . "\">" . $showUser->getUserNick() . "</a>" ;
      }
      T_("By");

      $transfersBox->boxLeftEdge();
      $fDate = Date("M j Y G:i", $myTransfer->getDateTimeString());
      $transfersBox->boxCell($fDate,"wdatasmall");
      $transfersBox->boxCell($toFrom . "<a href=\"balance.php?nick=$myTransferPartnerNick\">$myTransferPartnerNick</a> <br/>
                             $by","top");
      /* rgbbox = 140px : RGB: 15, value : 90, frac 25 , 
      */
           $transfersBox->boxCell( $sign .   $myTransfer->transferRedValue->getRoundedValue() . " " . $myTransfer->transferRedValue->get8thImg(),'rdata');
           $transfersBox->boxCell( $sign .   $myTransfer->transferGreenValue->getRoundedValue() . " " . $myTransfer->transferGreenValue->get8thImg(),'rdata');
           $transfersBox->boxCell( $sign .   $myTransfer->transferBlueValue->getRoundedValue() . " " .  $myTransfer->transferBlueValue->get8thImg(),'rdata');
      $transfersBox->boxRightEdge();
      $transfersBox->boxLeftEdge();
      $transfersBox->boxCell(" ","top");
      $transfersBox->boxCell(" ","top");
      $transfersBox->boxCellSpan("Descripton ","title","3");
      $transfersBox->boxRightEdge();
      $transfersBox->boxLeftEdge();
      $transfersBox->boxCell(" ","top");
      $transfersBox->boxCell(" ","top");
      $transfersBox->boxCell($myTransfer->getTheText(),"top");
      $transfersBox->boxCell(" ","top");
      $transfersBox->boxCell(" ","top");
      $transfersBox->boxRightEdge();
      $transfersBox->boxRowBorder();
      $transfersBox->boxRowBorder();
    }
    $navigation = '<tr><td  background="themes/petrol/images/left_edgew.png" width="16px" height="100%"></td><th colspan="1"></th><th valign="bottom"  colspan ="4">' . $pagedResults->getPageNav("nick=" . $showUser->getUserNick()) .  '</th><td background="themes/petrol/images/right_edgew.png" width="16px" height="100%"></td></tr>';
       print $navigation;
      $transfersBox->boxEnd();
  ?>
<div>
  <p>&nbsp; |
  <a href="profile.php?nick=<?php print $showUser->getUserNick();?>"><?php print T_("Profile"); ?></a> &nbsp; |  &nbsp; 
    <a href="adlist.php?nick=<?php print $showUser->getUserNick();?>"><?php print  T_("Ads");?></a> &nbsp;    | &nbsp; 
    <a href="transfer.php?nick=<?php print $showUser->getUserNick();?>"><?php print T_("New Transfer");?></a>&nbsp; | &nbsp; 
    <a href="balance.php?nick=<?php print $showUser->getUserNick();?>"><?php print T_("Balance");?></a>&nbsp; | &nbsp; 
    <a href="contact.php?nick=<?php print $showUser->getUserNick();?>"><?php print T_("Send Email");?></a>&nbsp; | &nbsp; 
   </p>
   <p>&nbsp;</p>
   

    </div>



 </div><!-- div contents -->
</div>
  </body>
</html>


