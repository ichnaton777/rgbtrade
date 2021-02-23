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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
  <head>
    <title>RGBoog</title>
    <link rel="stylesheet" type="text/css" href="themes/petrol/stylesheet.css" />
  </head>
  <body onLoad='document.searchForm.searchBox.focus()'>
<div id="fullpage">
    <?php include('includes/topbox.php'); ?>

    <!-- end header part -->
  <? include('includes/sidebar.php'); ?>

   <!-- page contents -->
<div id="contents">

<? 
  $error="";
  if(isset($_REQUEST['verify'])) {
      $verify = mysqli_real_escape_string($db,$_REQUEST['verify']);
      $error  = "verified";
      pc_debug("error set to verified",__FILE__,__LINE__);
  }

  if (isset($_GET['error'])) {
    $error=$_GET['error'];
  } 
  if(isset($_POST['error'])) {
      $error = $_POST['error'];
  }
   pc_debug("error is now $error",__FILE__,__LINE__);

  switch($error) {
      case "verified";
      // we have an incoming link with the verify code. if correct, present new password form. the most basic approach.
      //
      $nick = mysqli_real_escape_string($db,$_REQUEST['userNick']);
      $email = mysqli_real_escape_string($db,$_REQUEST['userEmail']);
      $qv  = sprintf("select * from rgbUsers where userVerify = '%s' and userEmail = '%s' and userNick = '%s'",$verify,$email,$nick);
      $rv  = mysqli_query($db,$qv);
     // no verify in the debug log  pc_debug("mysqli : $qv " . mysqli_error($db), __FILE__,__LINE__);
      if(mysqli_num_rows($rv) == 1) { 
          // okay this is good. verify code ok.
          //
          // if the password is supplied, eat and digest.
          // else, present the form and put the verify code in an hidden input, to check again.
          //
          pc_debug("good. One user with this data. eat password now", __FILE__,__LINE__);
          if (isset($_REQUEST['newpassword']) &&  isset($_REQUEST['newpassword2'])) {
              $newpassword = mysqli_escape_string($db,$_REQUEST['newpassword']);
              $newpassword2 = mysqli_escape_string($db,$_REQUEST['newpassword2']);
              if ($newpassword == $newpassword2) {
                  $sqlu = sprintf("update rgbUsers set userPassword = password('%s') , userVerify='' where  userEmail = '%s' and userNick = '%s'", 
                                   $newpassword, $email,$nick);
                  $qu   = mysqli_query($db,$sqlu);
                  if(!mysqli_error($db,)) {
                      $result = T_("Your password has been changed. Please continue.");
                      // no verify in debug pc_debug("password updated " . $sqlu, __FILE__,__LINE__);
                      print '<h1 id="resultpagetitle">' . T_("Your password has been changed.") . '</h1>';
                      print T_("You can now log in.");
                  } else {
                      $result = T_("The change of password has failed.");
                      print '<h1 id="resultpagetitle">' . $result . "</h1>";
                      pc_debug("password not updated : $sqlu" . mysqli_error($db), __FILE__,__LINE__);
                  }
              } else {
                  // passwords do not match, client side code has not been running there...
                  // WTF!
                  exit;
                  }
          } else { 
              pc_debug("to print form new passwords",__FILE__,__LINE__);
              // var_dump($_REQUEST);
              $renew = T_("Set new password");
              $enter = T_("Enter a password");
              $repeat = T_("Repeat password");
              $save   = T_("Save");
              print <<< EOF
                  <form action="error.php" method="POST">
                  <input type="hidden" name="verify" value="$verify">
                  <input type="hidden" name="userEmail" value="$email">
                  <input type="hidden" name="userNick" value="$nick">
 <h1 id="resultpagetitle">$renew</h1>
 <table width="285px" class="databox">
   <tr><td class="datalabel"><label for="newpassword">$enter:</label></td><td class="data">
<input type=password class="formInput" name="newpassword" size="10" value=""></td></td></tr>
<input type=hidden class="formInput" name="error" size="10" value="verified"></td></td></tr>
<tr><td class="datalabel"><label for="newpassword2">$repeat:</label></td><td class="data">
<input type=password class="formInput" name="newpassword2" size="10" value=""></td></td></tr>
<tr><td><input type="submit" value="$save"></td></tr>
</form>
         
EOF;
          // show error message and not much else
        }
      } else {
          // print error
          print "<h1 id=\"resultpagetitle\">" . T_("Invalid codes") . "</h1>" . 
              T_("The combination of email address, username and verification code is not valid.").
          pc_debug("not 1 return from query : $qv " . mysqli_error($db),__FILE__,__LINE__);
      }
      break;
  case "sendpassword";
  pc_debug("to send password",__FILE__,__LINE__);
         $nick = mysqli_real_escape_string($db,$_POST['userNick']);
         $email = mysqli_real_escape_string($db,$_POST['userEmail']);

         $q1=sprintf("select * from rgbUsers where userNick = '%s' and userEmail = '%s'", $nick,$email);
         $r1=mysqli_query($db,$q1);
         if(mysqli_num_rows($r1) <>1 ) {
             // exactly one return means uniq user, which should. nick is unique , email is unique.
             print T_("Email address and password do not match.") ;
             exit;
         } 
         $alphanum = "abcdefghkmnpqrstwxyz2345678!?<>{}[]@#%&*";
         $rand = substr(str_shuffle($alphanum), 0, 20);
         $verify = md5($rand);
         $sql2=sprintf("update rgbUsers set userVerify ='%s' where userNick = '%s' and userEmail = '%s'",$verify,$nick,$email);
         $q2=mysqli_query($db,$sql2);
         $server = $_SERVER["HTTP_HOST"];
         $script = $_SERVER['SCRIPT_NAME'];

         if(mysqli_error($db)) {
             pc_debug("mysqli error $sql2" . mysqli_error($db) ,__FILE__,__LINE__);
         }

         $subject       = T_("Verification email for a new password");
         $intro = sprintf(T_("A new password has been requested for user %s on the website %s. To change your password, follow this link: \n\nhttp://%s/%s?userEmail=%s&userNick=%s&verify=%s \n\nIf you do not want a new password or you have not asked for this message, please ignore this email.\n\nThank You!"), $nick , SYSTEM_NAME, $server, $script ,$email, $nick, $verify);

         $from = SYSTEM_EMAIL;
         $headers = "From: $from";
         if (mail("$email","$subject","$intro",$headers)) {
           pc_debug("Mail sent succesfully",__FILE__,__LINE__);
           print "<h1 id=\"resultpagetitle\">" . T_("Email sent") . "</h1>";
           print T_("You will receive an email with a link. If you follow that link, you can change the password.");
         } else {
           pc_debug("Mail failed : $nick, $subject,$message",__FILE__,__LINE__);
           print "<h1 id=\"resultpagetitle\">" . T_("Email failed"). "</h1>";
           print T_("It was not possible to send an email. Please try again later. ");
         }
  break;
  case "login":
      // have to gettext from here
    print "<table><tr><td class=\"boxtitle\">" . T_("You are not logged in") . "</td></tr>";
    print "<tr><td>" . T_("Please try to log in.") . "</td></tr>";
    print "<tr><td>";
    print '
        <form id="loginForm" class="rgbForm" action="profile.php" method="post">
        <input type="hidden" name="action" value="login">
        <input type="hidden" name="userRemember" value="no">
          <table   border="0" >
            <tr><td> <table>
                     <tr><td class="formLabel"><label for="userName">' . T_("Username") . '</label></td>
                     <td><input size="12" class="formInput" type="text" name="userNick" id="userNick"/> </td></tr>
                     <tr><td class="formLabel"><label for="userPassword"   >' . T_("Password") . '</label></td>
                     <td><input size="12" class="formInput" type="password" name="userPassword" id="userPassword" /></td></tr>
                 </table>
            </td><td> <input type="image" name="login" src="themes/petrol/images/login.png" alt="login" /></td></tr>
       </table>
        </form>';
    print "</td></tr>";
    print "<tr><td class=\"boxtitle\"><a name=\"email\"></a>" . T_("Password Lost?") . "</td></tr>";
    print "<tr><td>" . T_("Enter your username and email address to receive the confirmation code.") . "</td></tr>";
    print '
        <form id="loginForm" class="rgbForm" action="error.php" method="post">
        <input type="hidden" name="error" value="sendpassword">
        <input type="hidden" name="userRemember" value="no">
          <table   border="0" >
            <tr><td> <table>
                     <tr><td class="formLabel"><label for="userName">' . T_("Username") . '</label></td>
                     <td><input size="12" class="formInput" type="text" name="userNick" id="userNick2"/> </td></tr>
                     <tr><td class="formLabel"><label for="userEmail"   >' . T_("Email") . '</label    ></td>
                     <td><input size="20" class="formInput" type="text" name="userEmail" id="userEmail" /></td></tr>
                 </table>
            </td></tr><tr><td> <input type="submit" name="login" value="' . T_("Send Code") . '" alt="login" /></td></tr>
       </table>
        </form>';
    break;
  default: 
    print "<tr><td>" . T_("Error without error ?") . "</td></tr>";
    break;
  }
?>
</table></div>
</div></div>

  </body>
</html>
