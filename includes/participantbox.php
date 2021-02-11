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
      <td><a href="participants.php"><?php print T_("Participants");?></a></td></tr>
      <tr><td ><a href="<?php print DOC_URL;?>"><?php print T_("How does it work?"); ?></a></td>
      <td><a href="categorylist.php"><?php print T_("Categories");?></td></tr>
        </table>
</div>
      <div id="partbox" >
          <table   border="0" class="pbox">
            <tr><td class="pbox"><b><? print $user->getUserNick();?></b></td><td class="pbox"><a href="profile.php?nick=<?php print $user->getUserNick(); ?>" class="pbox"><?php print T_("Profile");?></a></td>
            <td class="pbox"><a href="adlist.php?nick=<?php print $user->userNick ; ?>" class="pbox"><?php print T_("My Ads");?></a></td></tr>
            <tr><td class="pbox"><a href="logout.php" class="pbox"><?php print T_("Logout"); ?></a></td><td class="pbox"><a href="balance.php?nick=<?php print $user->userNick ; ?>" class="pbox"><?php print T_("Balance");?></a></td>
            <td class="pbox"><a href="ad.php?nextAction=new" class="pbox"><?php print T_("New Ad");?></a></td></tr>
                
       </table>
      </div>
