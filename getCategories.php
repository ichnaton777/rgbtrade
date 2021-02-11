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
  include_once("includes/rgbtop.php");

  // if(isset($_REQUEST['myCat']) && !is_null($_REQUEST['myCat'])  && !$_REQUEST['myCat']=="undefined" ) {
  if(isset($_REQUEST['myCat'])){
       $myCatId = mysql_real_escape_string($_REQUEST['myCat']);
          echo "var oGroup = document.createElement('optgroup');\n";
          echo "oGroup.value = 'Maak uw keuze';\n";
       pc_debug("myCatId from REQUEST",__FILE__,__LINE__);
  }
  

  $myCat = new rgbAdCategory;

  $cats_0=array();
  $cats = getColourCatArray("",'available',-1);
  //$cats = getCatsByParent($myCatId);

  while(list($key,$val) = each($cats)) {

      echo "/* starting loop */ \n";
      echo "var oOption = document.createElement('option');\n
            oOption.value = '$key';\n
            oOption.text = '$val';\n
            oGroup.appendChild(oOption);\n\n";
      pc_debug("Ajax setting select box: val = $val ; key = $key",__FILE__,__LINE__);
  }
  echo "var oSelect = document.categoryForm.parentId; 
        oSelect.appendChild(oGroup);";
?>

