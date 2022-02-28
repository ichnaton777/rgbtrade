<?
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
 // this version of getCategories is for usage in ad.php. Handles AJAX requests and gives pure DOM code (whatever)
  include_once("includes/rgbtop.php");

  // if(isset($_REQUEST['myCat']) && !is_null($_REQUEST['myCat'])  && !$_REQUEST['myCat']=="undefined" ) {
  if(isset($_REQUEST['myCat'])){
      // getting a sub category, so set myCatId to the current one
       $myCatId = mysqli_real_escape_string($db,$_REQUEST['myCat']);
          echo "var oGroup = document.createElement('optgroup');\n";
          echo "oGroup.value = 'Maak uw keuze';\n";
       pc_debug("myCatId from REQUEST",__FILE__,__LINE__);
  }  else {
      $myCatId = -1 ; // implies: no category at all
  }

       pc_debug("myCatId = $myCatId",__FILE__,__LINE__);
  

  $myCat = new rgbAdCategory;
  $cats_0=array();
  $cats = getCategoriesByParent($myCatId);
  pc_debug("myCatId = $myCatId",__FILE__,__LINE__);
  foreach ($cats as $key => $val) {
      echo "var anOption = new Option(\"$val\",\"$key\",false,false);";
            if ($myCatId == -1) {
                // implicitly, no catId, ie. we are giving a group, not a category
                pc_debug(" adding to adGroup",__FILE__,__LINE__);
                  echo "var oSelect = document.ad.adGroup;
                        oSelect.options[oSelect.options.length] = anOption;";
                  
            } else {
                pc_debug(" adding to adCategory",__FILE__,__LINE__);
                  echo "var oSelect = document.ad.adCategory;
                        oSelect.options[oSelect.options.length] = anOption;";
            }

       pc_debug("Ajax setting select box: val = $val ; key = $key",__FILE__,__LINE__);
  }
?>

