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
  include("includes/forms.php");             // by mlemos
  include("includes/rgbAd.php");   
  $user->loadUser();
  if (!$user->getLoggedIn()) {
      header("location:index.php");
  }
  $form = new form_class; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
  <head>
  <title><?php print T_("Category List");?></title>
    <link rel="stylesheet" type="text/css" href="themes/petrol/stylesheet.css" />
    <script type="text/javascript" src="includes/tw-sack.js"></script>
  </head>
  <body>
<div id="fullpage">
  <?php include('includes/topbox.php'); ?>
  <?php include('includes/sidebar.php'); ?>


  <form method="post" action="" name="newAd" enctype="multipart/form-data" onsubmit="return ValidateForm(this)">
       <div  id="newadbox">
      <h1 id="boxpagetitle"><?php print T_("Category List");?></h1>

       <table     border="0"  width="250"  class="wdata" cellpadding="0" cellspacing="0" >
         <tr>
            <td width="16"><img src="themes/petrol/images/tl_16.png" alt="" /></td>
            <td  background="themes/petrol/images/upper_133.png"  alt="" /></td>
            <td width="16"><img src="themes/petrol/images/tr_16.png" alt="" /></td>
        </tr>
        <tr  bgcolor="#f2f2f2" >
            <td background="themes/petrol/images/left_edge.png"></td>
            <td   align="left" >
              <!-- categories here-->
<? if (defined('CATEGORY_EDIT') && CATEGORY_EDIT) { ?>
              <h2><a href="category.php?action=add" title="Add Category">[<?php print T_("New Category");?>]</a></h2>
<? } ?>

<?php       //  $ar = getColourCatArray("","available","-1"); 
              $ar = getGroupsByParent("1"); 
              foreach($ar as $id => $name)  {
                  if ($id >1) {
                      if (defined('CATEGORY_EDIT') && CATEGORY_EDIT) {
                        print '<a class="ared" href="category.php?action=edit&catid=' . $id . '"><b>' . $name . '</b></a><br />';
                      } else {
                        print '<b>' . $name . '</b><br />';
                      }

                      $sub=getGroupsByParent($id);
                      foreach($sub as $sid => $sname)  {
                          if ($sid >1) {
                              if (defined('CATEGORY_EDIT') && CATEGORY_EDIT) {
                                 print '<a class="ared" href="category.php?action=edit&catid=' . $sid . '">&nbsp; - ' . $sname . '</a><br />';
                              } else {
                                 print '&nbsp; - ' . $sname . '<br />';
                              }
                          }
                      }
                  }
              }
?>
    <hr<h1 id="pagetitle"><?php print T_("Unavailable Categories");?></h1>

<?php         $ar = getColourCatArray("red","unavailable"); 
              foreach($ar as $id => $name)  {
                  if($id>0) 
                     if (defined('CATEGORY_EDIT') && CATEGORY_EDIT) {
                        print '<a class="ared" href="category.php?action=edit&catid=' . $id . '">' . $name . '</a><br />';
                     } else {
                        print  $name . '<br />';
                     }
              }
?>
       </td> <td background="themes/petrol/images/right_edge.png"></td>
       </tr>
       <tr bgcolor="#f2f2f2">
          <td><img src="themes/petrol/images/bl_16.png" alt="" /></td>
          <td background="themes/petrol/images/lower_133.png" alt="" /></td>
            <td><img src="themes/petrol/images/br_16.png" alt="" /></td>
       </tr>
       </table>
       </div>

       </div>
    </div>




</div>
  </body>
</html>
</form>


