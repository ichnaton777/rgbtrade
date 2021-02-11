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
  $showUser = new rgbUser;
  $transfer = new rgbTransfer;


  if(isset($_POST['action']) && $_POST['action'] == 'newtransfer') {
    pc_debug("new transfer",__FILE__,__LINE__);
    if ($_POST['tofrom'] == "to") {
        $transfer->setToId(mysql_real_escape_string($_POST['transferUserId']));
        $transfer->setFromId($_SESSION['userId']);
    } elseif ( $_POST['tofrom'] == 'from' ) {
        $transfer->setFromId(mysql_real_escape_string($_POST['transferUserId']));
        $transfer->setToId($_SESSION['userId']);
    }
    if($transfer->checkTransfer()) {
       $transfer->saveTransfer();
       $showUser->setUserNick($_POST['nick']);
    } else {
        header("location:error.php?error=login");
        exit;
    }
  }
  else {
     $message = "bla " ; # var_dump($_POST);
     pc_debug("no save transfer $message ","red",__FILE__,__LINE__);
     if (!isset($_GET['nick']) || empty($_GET['nick'])) {
       user_message( T_("Oops"),T_("Who is it you want to transfer to?"),"participants.php","red");
       exit;
     } else {
      $showUser->setUserNick($_GET['nick']);
     }
  }
  $showUser->loadUser();

  if($user->getUserId() == $showUser->getUserId()) {
      pc_debug("I am me transferring",__FILE__,__LINE__);
      header("location:profile.php?nick=" . $user->getUserNick());
  } else {
      pc_debug("not me transferring",__FILE__,__LINE__);
  }


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title><?php print SYSTEM_NAME ." " . 
     T_("New Transfer");?></title>
    <link rel="stylesheet" type="text/css" href="themes/petrol/stylesheet.css" />
  </head>
  <body onLoad='document.searchForm.searchBox.focus()'>
<div id="fullpage">
  <?php $participant="bla"; ?>
    <?php include('includes/topbox.php'); ?>

    <!-- end header part -->
  <? include('includes/sidebar.php'); ?>

   <!-- page contents -->

<? 
  if ( $transfer->getStatus() == "done") {
      // we are open, did we just finish a transfer?
    $box=new Box;
    $box->setCssClass("message");
        $box->setTitle(T_("Transfer Completed"));
        $box->setText(sprintf(T_("Your transfer has been completed. You can now %s check your balance %s"),"<a href='balance.php'>","</a>"));
        $box->setVisible(true);
        $box->show();
} else {
?>
    <form action="transfer.php" method="POST">
    <input type="hidden" name="action" value="newtransfer">
    <input type="hidden" name="nick" value="<? print $showUser->getUserNick();?>">
    <input type="hidden" name="transferUserId" value="<? print $showUser->getUserId();?>">
    <h1 id="boxpagetitle"><?php print T_("New Transfer") . " " . T_("to or from") . " " . $showUser->getUserNick(); ?></h1>
       <div  id="newtransferbox">
       <table    border="0" width="430" height="420" class="wdata" > <!--
       background="themes/petrol/images/450_420_bg.png" -->
       <tr><td></td></tr>
       <tr><td width="70px" class="boxtitle" align="right"><?php print T_("RGB Transfer"); ?></td><td>
     <table>
     <tr><td class="wdatalabel"><input type="radio" name="tofrom" value="to" checked="checked"><?php print T_("To") . " "; 
                    print $showUser->getUserNick() . " " . T_("from") ." "  . $user->getUserNick(); 
              ?></td></tr>
                  <tr><td  class="wdatalabel"><input type="radio" name="tofrom" value="from"><?php print T_("From") . " "  .
                           $showUser->getUserNick()  . " " . T_("to") . " " .   $user->getUserNick(); ?></td></tr>
            </table>
       
       </td></tr>

       <tr><td align="right"><label class="bred"><?php print T_("Red");?></td><td>
       <input type=text class="formInput" name="redValue" size="6">
       <select name="red8th" class="formInput" id="red8">
       <option value="0/8">0</option>
       <option value="1/8">1/8</option>
       <option value="2/8">2/8</option>
       <option value="3/8">3/8</option>
       <option value="4/8">4/8</option>
       <option value="5/8">5/8</option>
       <option value="6/8">6/8</option>
       <option value="7/8">7/8</option>
       </select>
       
       </tr>
       <tr><td align="right"><label class="bgreen"><?php print T_("Green");?></td><td><input type=text class="formInput" name="greenValue" size="6">
       <select name="green8th" id="green8" class="formInput">
       <option value="0/8">0</option>
       <option value="1/8">1/8</option>
       <option value="2/8">2/8</option>
       <option value="3/8">3/8</option>
       <option value="4/8">4/8</option>
       <option value="5/8">5/8</option>
       <option value="6/8">6/8</option>
       <option value="7/8">7/8</option>
       </select>
       <tr><td align="right"><label class="bblue"><?php print T_("Blue");?></td><td><input type=text class="formInput" name="blueValue" size="6">
       <select name="blue8th" id="blue8" class="formInput">
       <option value="0/8">0 </option>
       <option value="1/8">1/8</option>
       <option value="2/8">2/8</option>
       <option value="3/8">3/8</option>
       <option value="4/8">4/8</option>
       <option value="5/8">5/8</option>
       <option value="6/8">6/8</option>
       <option value="7/8">7/8</option>
       </select>
       </td>
       </tr>
       <tr><td class="datalabel" align="right" valign="top"><?php print T_("Description");?>:</td><td><textarea rows="10" cols="25" name="transferText" class="formInput" wrap="physical"></textarea></td></tr>
       <tr><td valign="top"  align="right"><input type="reset" Value="<?php print T_("Cancel");?>" onClick="javascript:history.go(-1)"></td><td align="right" valign="top"><input type="submit" src="submit.png" value="<?php print T_("Submit");?>"></td><td></td></tr>
       <tr><td colspan="7"></td></tr>
       
       </table>


       </table>
       </div>
<? 
}
?>
    </div>




</div>
  </body>
</html>
