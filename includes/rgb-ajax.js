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
/* Scripts to support the AJAX Code-Kit (SACK)     */

  include("includes/rgbtop.php");

  var ajax = new sack();
  // in categories.php
  function getCategoryList(myColour,formSelect) {
    var myCatId =  document.getElementById('catId');
    document.getElementById('parentId').options.length = 0;  // Empty parent Category box
    ajax.requestFile = 'getCategories.php?colour='+myColour+ '&myCat=' + myCatId;  // Specifying which file to get
    ajax.onCompletion = createCategories(); // Specify function that will be executed after file has been found
    ajax.runAJAX();   // Execute AJAX function
  }

  // in categories.php
  function createCategories()
  {
    var obj = document.getElementById('parentId');
    eval(ajax.response);  // Executing the response from Ajax as Javascript code   
  }  

  // in ad.php
  function getAdGroupList(myColour,formSelect) {
    // var myCatId =  document.getElementById('adGroup');
    document.getElementById('adGroup').options.length = 0;  // Empty parent Category box
    ajax.requestFile = 'getCategories.php?colour='+myColour;  // Specifying which file to get
    ajax.onCompletion = createAdGroups(); // Specify function that will be executed after file has been found
    ajax.runAJAX();   // Execute AJAX function
  }

  // in ad.php
  function createAdGroups()
  {
    var obj = document.getElementById('AdGroup');
    eval(ajax.response);  // Executing the response from Ajax as Javascript code   
  }  



