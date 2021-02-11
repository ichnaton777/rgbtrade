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
  include("includes/rgbDimension.php");
  include("includes/rgbBalance.php");
  $box=new Box;
  $box->setCssClass("message");


  function registerUser($data,&$box) {
    /* $data userId, userEmail userEmail2, verify */
    /* also create balance row

    mysql> insert into rgbBalances (balanceRedValue, balanceGreenValue ,  balanceBlueValue, balanceUserId,  balanceType) values (0,0,0,8,'running'); Query OK, 1 row affected (0.03 sec)

    mysql> insert into rgbBalances (balanceRedValue, balanceGreenValue ,  balanceBlueValue, balanceUserId,  balanceType) values (0,0,0,1,'milestone');
    Query OK, 1 row affected (0.00 sec)
    */
 
    if ($data['userPassword'] != $data['userPassword2']) {
      user_message(T_("Registration Failed"),T_("Passwords do not match. Enter the same password twice."),"javascript.go(-1)","green");

    }
    else  {
      pc_debug("to register user",__FILE__,__LINE__);
      $user = new rgbUser;
      $user->userNick = $data['userNick'];
      $user->userPassword = $data['userPassword'];
      $user->userEmail = $data['userEmail'];
      $user->userStatus = 'live';
      if ($user->testUniqueNick() && $user->testUniqueEmail() ) {
          // $user->saveAvatar();
        if ($user->insert())  {
          $balance = new rgbBalance;
          $balance->setType('running');
          $balance->setUserId($user->getUserId());
          $balance->insert();
          $mbalance = new rgbBalance;
          $mbalance->setType('milestone');
          $mbalance->setUserId($user->getUserId());
          $mbalance->setBalanceName("Start");
          $mbalance->insert();

          $box->setTitle(T_("Thank you ") . " " .  $user->userNick);
          $box->setText(T_("You can now <a href='editprofile.php'>edit your profile</a>."));
          $box->setVisible(true);
        } else {
          print "register failed ... ";
          pc_debug("registration FAILED due to unknown error",__FILE__,__LINE__);
        }
      }
      else {
        $box->setTitle(T_("Username or Email address is already in use"));
        $box->setText(sprintf(T_("Someone has alreay taken this username or email address. You should %s try again %s with a different username or %s ask for a new password %s for this email address."),"<a href=\"register.php\">","</a>","<a href=\"error.php?error=login\">","</a>"));
        $box->setVisible(true);
      }
    }
  }

  if ($user->getloggedin()) { 
    pc_debug("already logged in, why register?",__FILE__,__LINE__);
  }

  if (isset($_POST['action']) && $_POST['action'] == "register") {
      if($_SESSION['verify'] == md5($_POST['verify'])) {
        registerUser($_POST,$box);
        $user =  new rgbUSer;
        $user->setUserNick($_POST['userNick']);
        $user->setlogin();
        // phpinfo();
    } else  {
        $box->setTitle(T_("Security Code Incorrect"));
        $box->setText(T_("Please enter the characters of the Security Code in the textfield. Note that all characters on the keyboard may be used."));
        $box->setVisible(true);
      pc_debug("verify failed: session: " . $_SESSION['verify']  . " posted :".  md5($_POST['verify']),__FILE__,__LINE__);
    }
  }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
  <head>
    <title><?php print (SYSTEM_NAME . "&nbsp;" . T_("Registration"));?></title>
    <link rel="stylesheet" type="text/css" href="themes/petrol/stylesheet.css" />
    <link rel="shortcut icon" href="favicon.ico">
  </head>
  <body>
<div id="fullpage">
    <?php include('includes/topbox.php'); ?>

    <!-- end header part -->
  <? include('includes/sidebar.php'); ?>

   <!-- page contents -->

<? if (!$box->getVisible()) {
?>

   <div id="resultbox_high">
   <h1 id="resultpagetitle"><?php print T_("Register");?></h1>
   <form action="register.php" method="post" enctype="multipart/form-data" >
   <input type="hidden" name="action" value="register">
   <table width="604" id="transferbox" class="wdatabox2" CELLPADDING="0" CELLSPACING="0">
       <tr><td width="16px"><img src="themes/petrol/images/tl_16w.png"></td>
           <td width="572" colspan="2" ><img src="themes/petrol/images/upper_20w.png" width="100%" height="16"></td>
           <td><img src="themes/petrol/images/tr_16w.png"></td>
       </tr>
       <tr><td  background="themes/petrol/images/left_edgew.png" width="16px"></td><td class="datalabel"><label for="nick"><?php print T_("Username");?>:</label></td><td class="data">
   <input type=text class="formInput" name="userNick" size="30" value=""></td><td background="themes/petrol/images/right_edgew.png" width="16px" ></td></tr>
   <tr><td  background="themes/petrol/images/left_edgew.png" width="16px"></td><td class="datalabel"><label for="email"><?php print T_("Email");?>:</label></td><td class="data">
   <input type=text class="formInput" name="userEmail" size="30" value=""></td><td background="themes/petrol/images/right_edgew.png"></td></tr>
   <tr><td  background="themes/petrol/images/left_edgew.png" width="16px"></td><td class="datalabel"><label for="email"><?php print T_("Password");?>:</label></td><td class="data">
   <input type=password class="formInput" name="userPassword" size="10" value=""></td><td background="themes/petrol/images/right_edgew.png"></td></tr>
   <tr><td  background="themes/petrol/images/left_edgew.png" width="16px"></td><td class="datalabel"><label for="email"><?php print T_("Repeat Password");?>:</label></td><td class="data">
   <input type=password class="formInput" name="userPassword2" size="10" value=""></td><td background="themes/petrol/images/right_edgew.png"></td></tr>
   <tr><td  background="themes/petrol/images/left_edgew.png" width="16px"></td><td class="datalabel"><label for="ccode"><?php print T_("Security Code");?>:</label></td><td><table><td><input type="text" name="verify" id="ccode" class="formInput" size="5"></td><td><img src="randomimage.php"></td></tr></table></td><td background="themes/petrol/images/right_edgew.png"></td></tr>
   <tr><td  background="themes/petrol/images/left_edgew.png" width="16px"></td>
   <td class="datalabel"><label><?php print sprintf(T_("I agree to the %s conditions %s."),"<a onClick='javascript:document.getElementById(\"hiddenconditions\").style.visibility=\"visible\"'>","</a>");?></a</label></td><td class="data"> <input type="checkbox" name="agree" id="agree"></td><td background="themes/petrol/images/right_edgew.png"></td></tr>
   <tr><td  height="16px" background="themes/petrol/images/left_edgew.png" width="16px"></td><td></td><td></td>
   <td background="themes/petrol/images/right_edgew.png"></td></tr>
   <tr><td  background="themes/petrol/images/left_edgew.png" width="16px"></td><td>
   <input type="reset" src="annuleren" name="Cancel" Value="<?php print T_("Cancel");?>" align="right">
</td>
    <td align="center">
    <input type="submit" src="submit.png" value="<?php print T_("Save");?>">
</td><td background="themes/petrol/images/right_edgew.png"></td></tr>
       <tr><td width="16px"><img src="themes/petrol/images/bl_16w.png">
           <td width="572px" colspan="2"><img src="themes/petrol/images/lower_20w.png" width="100%" height="16"></td>
           <td><img src="themes/petrol/images/br_16w.png">
       </tr>
   </table>
   &nbsp; </div>


   </div>
   </form>

   <? 
} else {
    $box->show();
}
 ?>
<div id="hiddenconditions">
<?php include("includes/conditions.php") ;?>
</div>


</div>
  </body>
</html>


