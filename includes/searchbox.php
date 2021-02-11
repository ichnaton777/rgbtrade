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
   <div id="mainsearch">

     <fieldset>
   <form action="<?php print $getaction; ?>" method="get" id="searchForm" name="searchForm">
   <input type="hidden" name="section" value="<?php print T_("$section"); ?>" />

       <table  width="200px">
     <tr><td colspan="3"><h1 id="pagetitle"><?php print $title; ?></h1></td></tr>
     <?php print "$tr"; ?>

       <tr><td colspan="3" align="center"><input type="text" class="mainSearch" name="searchBox" size="30" value="<?php print $q; ?>"/></td></tr>
           <tr><td colspan="3" align="center"><input type="submit" value="<?php echo T_("Search") ;?>"/></td></tr>
       </table>
       </form>
     </fieldset>
     </div>
