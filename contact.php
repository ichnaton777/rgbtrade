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
  if ($user->getloggedin()) {
    pc_debug("DB logged in at contact:" . $user->getUserNick(),__FILE__,__LINE__);
  } else {
    pc_debug("DB not logged in at contact)",__FILE__,__LINE__);
    user_message(T_("Ooops"),T_("Please login before asking for a contact form"),"index.php","red");
    exit;
  }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title><?php print (SYSTEM_NAME . "&nbsp;" . "Contact");?></title>
    <link rel="stylesheet" type="text/css" href="themes/petrol/stylesheet.css" />
  </head>
  <body>
<div id="fullpage">
    <?php include('includes/topbox.php'); ?>

    <!-- end header part -->
  <? include('includes/sidebar.php'); ?>
<?



    if(isset($_POST['action']) && $_POST['action'] == 'mail') {
      if($_SESSION['verify'] != md5($_POST['verify'])) {
           pc_debug("verify code failed :" . $_SESSION['verify'] ."#" . $_POST['verify'],__FILE__,__LINE__);
           user_message(T_("Ooops"),T_("The security code is incorrect."),"javascript:history.go(-1)","red");
           exit;
      }

         $recipientNick = htmlspecialchars($_POST['recipientNick']);
         
         $subject       = "[" . SYSTEM_NAME . "]" . htmlspecialchars($_POST['subject']);
         $message       = htmlspecialchars($_POST['message']);
         $intro = sprintf(T_("Dear %s,\n") . T_("A participant of the website %s with the nickname %s has sent you a message. \nYou may visit his profile at %s. Please read the message below.\n\n"),
             $recipientNick, SYSTEM_NAME, $user->getUserNick(), SYSTEM_URL . "profile.php?nick=" . $user->getUserNick()) ;
         $showUser = new rgbUser;
         $showUser->setUserNick($recipientNick);
         $showUser->loadUser();
         $showEmail   = $showUser->getEmail();
         $senderNick  = $user->getUserNick();
         $senderEmail = $user->getEmail();

         $from = "$senderNick <$senderEmail>";
         $headers = "From: $from";
         if (mail("$showEmail","$subject","$intro$message",$headers)) {
           user_message(T_("Ok"),T_("Your message has been sent."),"profile.php?nick=" . $showUser->getUserNick(),"green");
           pc_debug("DB Mail sent succesfully",__FILE__,__LINE__);
         } else {
           pc_debug("DB Mail failed : $recipientNick, $subject,$message",__FILE__,__LINE__);
         }
    } else {
      $recipientNick= htmlspecialchars($_GET['nick']);
      $contactText = T_("Contact with");
      $sendText    = T_("Send Message");
      $subText     = T_("Subject");
      $msgText     = T_("Message");
      $scText      = T_("Security Code");
      $canText     = T_("Cancel");
      $sendText     = T_("Send by Email");

  $showUser = new rgbUser;
     $showUser->setUserNick(mysql_real_escape_string(stripslashes($_GET['nick'])));
     if($user->getUserNick() <> $showUser->getUserNick()) {
        $tlink = $showUser->getUserLink("transfer.php",T_("New Transfer")) . " | " ;
     } else {
        $tlink = "";
     } 
     $menuBox = new resultbox("menu","menu",4,"petrol","#ffffff","widebox",604);
     $menuBox ->setTitle($showUser->getUserNick() . " " .
       $showUser->getUserLink("profile.php",T_("Profile")) . " | " .
       $showUser->getUserLink("transferlist.php",T_("Transfers")) . " | " .
       $tlink . 
       $showUser->getUserLink("adlist.php",T_("Ads")) 
     );
     print "<div id='contents'>";
     $menuBox->titleBox();

      print <<< EOF

   <!-- page contents -->
 <h1 id="boxpagetitle">$contactText $recipientNick </h1>
   <form action="contact.php" enctype="multipart/form-data"  method="post">
 <input type="hidden" name="recipientNick" value="$recipientNick">
 <input type="hidden" name="action" value="mail">
   <div id="contactbox">
   <table width="420" height="410" class="databox"><tr><td colspan="3" class="boxtitle">$sendText</td>
   </tr>
   <tr><td class="wdatalabel"><label for="email">$subText:</label></td><td class="data">
   <input type=text class="formInput" name="subject" size="30" value=""></td></tr>
   <tr><td class="wdatalabel"><label for="email">$msgText:</label></td><td class="data">
   <textarea name="message" cols="30" rows="14" wrap="physical" class="formInput"></textarea>
   </td></tr>

   <tr><td><label for="ccode">$scText</label></td><td><table><td><input type="text" name="verify" id="ccode" class="formInput" size="5"></td><td><img src="randomimage.php"></td></tr></table></td></tr>

   <tr><td valign="top"><input class="formbutton" type="button" onClick="javascript:history.go(-1)"   Value="$canText" align="right"></td>
    <td align="center" valign="top"><input type="submit" class="formbutton"  value="$sendText"></td></tr>
    <tr><td colspan="6"></td></tr>
   </table>
   &nbsp; </div>


   </div>
   </form>

EOF;
    }
?>
</div>
  </body>
</html>


