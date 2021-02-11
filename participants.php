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
  $minisection = "participants";
  include("includes/rgbtop.php");
  include("includes/loggedin.php");
  include("includes/rgbBalance.php");
  include("includes/rgbDimension.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
  <head>
    <title><?php print SYSTEM_NAME . "&nbsp;" ; print T_("Participants");?></title>
    <link rel="stylesheet" type="text/css" href="themes/petrol/stylesheet.css" />
    <link rel="shortcut icon" href="favicon.ico">
  </head>
  <body>
<div id="fullpage">
  <?php $participant="bla"; ?>
    <?php include('includes/topbox.php'); ?>

    <!-- end header part -->
  <? 
    $section = "participants";
    include('includes/sidebar.php'); 
    if(isset($_GET['searchBox'])) {
    // main search facility, read out searchbOx from index.php and set the correct section if known (should be)
      $q = mysql_real_escape_string($_GET['searchBox']);
    $extrasql = "(userNick like '%$q%' or userCity like '%$q%' or userPlan like '%$q%') and ";
  }else {
      $extrasql = "";
  }
     
    ?><div id="contents"><?
    
    $participantsBox = new resultBox("","transferbox","4","petrol","#ffffff","widebox2",604);
    $participantsBox->setTitle(T_("Participants"));
    $participantsBox->boxStart();
    $titles = array(T_('Avatar')=>'100px',T_('Plan')=>'280px',T_('Balance RGB')=>'80px',T_('Details')=>'aa');
    $participantsBox->boxHorTitleRow($titles);
    $query = "select userId,   userNick,   userCity, 
                     userPlan, userAvatar, balanceRedValue, 
                     balanceGreenValue ,   balanceBlueValue , userBirth, userZipCode
                     from rgbUsers , rgbBalances 
                     where $extrasql rgbUsers.userId = rgbBalances.balanceUserId 
                     and balanceType = 'running'
                     and userStatus = 'live' order by balanceRedValue desc";
    $pageSize = 10;
    pc_debug("participants: $query",__FILE__,__LINE__);
    $pagedResults = new MySQLPagedResultSet($query,$pageSize,$db);
    while ($result = $pagedResults->fetchObject()) {
       $myUser = new rgbUser;
       $myUser->setUserNick($result->userNick);
       $myUser->setUserId(  $result->userId);
       $myUser->setAvatar(  $result->userAvatar);
       $myUser->setPlan(    $result->userPlan);
       $myUser->setCity(    $result->userCity);
       $myUser->setZipCode(    $result->userZipCode);
       $myUser->setUserBirth(    $result->userBirth);
       $myBalance = new rgbBalance();
       $myBalance->balanceRedValue->setValue(   $result->balanceRedValue);
       $myBalance->balanceGreenValue->setValue( $result->balanceGreenValue);
       $myBalance->balanceBlueValue->setValue(  $result->balanceBlueValue);

       $participantsBox->boxHorLineRow();
       $participantsBox->boxLeftEdge();
       $participantsBox->boxCell($myUser->getAvatarImage(),"top");
       $participantsBox->boxCell('<b>' . $myUser->getNickUrl() .'</b><br />'. $myUser->getPlan() , "top");
           $balancetable = '<table valign="top">
           <tr class="r"><td class="r">R</td></td>
           <td> '.          $myBalance->balanceRedValue->getRoundedValue() .  '</td>
           <td class="f">'. $myBalance->balanceRedValue->get8th().' </td></tr>
           <tr class="g"><td class="g">G</td></td>
           <td> '.          $myBalance->balanceGreenValue->getRoundedValue() .  '</td>
           <td class="f">'. $myBalance->balanceGreenValue->get8th().' </td></tr>
           <tr class="b"><td class="b">B</td></td>
           <td> '.          $myBalance->balanceBlueValue->getRoundedValue() .  '</td>
           <td class="f">'. $myBalance->balanceBlueValue->get8th().' </td></tr>
           <tr><td colspan="3" class="wdatalabel"></td>
           </table>';
       $participantsBox->boxCell($balancetable,"top");
       $detailstable = '
         <table>
       <tr><td>' . $myUser->getCity() .' </td></tr>
         <tr><td>' . $myUser->getZipCodeGoogleMap() . '</td></tr>
         <tr><td class="wdatasmall"><img src="images/baby_24.png" align="left" hspace="2" alt="Since" title="Since">' . $myUser->getUserBirth() . '</td></tr>
         </table>';
       $participantsBox->boxCell($detailstable,"top");
       $participantsBox->boxRightEdge();
       next($result);
    }
    $navigation = '<tr><td  background="themes/petrol/images/left_edgew.png" width="16px" height="100%"></td><th colspan="1"></th><th valign="bottom"  colspan ="1">' . $pagedResults->getPageNav() .  '</th><th colspan="1"></th></th><th ></th></th><td background="themes/petrol/images/right_edgew.png" width="16px" height="100%"></td></tr>';
       print $navigation;
    $participantsBox->boxEnd();
  ?>


       </div>
    </div>
</div>
  </body>
</html>


