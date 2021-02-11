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
?>

<div id="top"><a href="index.php"><div id="toplogo"></div></a><div id="topabout">
        <table width="250">
        <tr><td width="150"><a href="whatis.php"><?php print T_("What is") . " " . SYSTEM_NAME; ?></a></td>
        <td><a href="register.php"><?php print T_("Register");?></a></td></tr>
        <tr><td ><a href="<?php print DOC_URL ;?>"><?php print T_("How does it work?"); ?></a></td>
        <td><a href="participants.php"><?php print T_("Participants");?></a></td></tr>
        </table>
</div>


      <div id="login">
        <form id="loginForm" class="rgbForm" action="profile.php" method="post">
        <input type="hidden" name="action" value="login">
        <input type="hidden" name="userRemember" value="no">
          <table   border="0" >
            <tr><td> <table>
            <tr><td class="formLabel"><label for="userName"><?php print T_("Username");?></label></td>
                     <td><input size="12" class="formInput" type="text" name="userNick" id="userNick"/> </td></tr>
                     <tr><td class="formLabel"><label for="userPassword"   ><?php print T_("Password");?></label    ></td>
                     <td><input size="12" class="formInput" type="password" name="userPassword" id="userPassword" /></td></tr>
                 </table>
            </td><td> <input type="image" name="login" src="themes/petrol/images/login.png" alt="login" /></td></tr>
       </table>
        </form>
      </div>
