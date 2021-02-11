
    <!-- sidebar left -->
   <div id="leftbartb">


   <table   width="150" class="greybox" cellpadding="0" cellspacing="0">
   <tr>
       <td width="16"><img src="themes/petrol/images/tl_16.png" alt="" /></td>
       <td bgcolor="#f2f2f2"><img src="themes/petrol/images/upper_133.png" alt="" /></td>
       <td width="16"><img src="themes/petrol/images/tr_16.png" alt="" /></td>
   </tr>
   <tr bgcolor="#f2f2f2">
      <td background="themes/petrol/images/left_edge.png"></td><td>

      <?php include("includes/rgbtrade_intro.php");?>
       </td> <td background="themes/petrol/images/right_edge.png"></td>
   </tr>
       <tr bgcolor="#f2f2f2">
          <td><img src="themes/petrol/images/bl_16.png" alt="" /></td>
          <td><img src="themes/petrol/images/lower_133.png" alt="" /></td>
            <td><img src="themes/petrol/images/br_16.png" alt="" /></td>
       </tr>
<tr height="16"><td></td></tr>
   <tr>
       <td width="16"><img src="themes/petrol/images/tl_16.png" alt="" /></td>
       <td bgcolor="#f2f2f2"><img src="themes/petrol/images/upper_133.png" alt="" /></td>
       <td width="16"><img src="themes/petrol/images/tr_16.png" alt="" /></td>
   </tr>
   <tr bgcolor="#f2f2f2">
      <td background="themes/petrol/images/left_edge.png"></td><td>

   <?php if (!strstr($_SERVER['REQUEST_URI'],"index.php")) {
     ?>

   <div class="miniSearch">
     <fieldset>
       <form action="<?php print $getaction; ?>" method="get" id="searchForm" name="searchForm">
       <input type="hidden" name="section" value="<?php print $section; ?>" />
       <table  width="100px">
     <script defer><!--
     function qs(el){if(window.RegExp&&window.encodeURIComponent){var ue=el.href,qe=encodeURIComponent(document.searchForm.searchBox.value);if(ue.indexOf("searchBox=")!=-1){el.href=ue.replace(new RegExp("searchBox=[^&$]*"),"searchBox="+qe);}else{el.href=ue+"&q="+qe;}}return 1;}
     //-->
     </script>
     <?
            print "$trmini"; 
   ?>
       <tr><td colspan="3" align="center"><input type="text" class="miniSearch" name="searchBox" size="15" value="<?php print $q; ?>"/></td></tr>
       <tr><td colspan="3" align="center"><input type="submit" value="<?php print T_("Search");?>" /></td></tr>
       </table>
       </form>
     </fieldset>
    </div>
       </td> <td background="themes/petrol/images/right_edge.png"></td>
    </tr>
  <? } 
           pc_debug("req uri: " . $_SERVER['REQUEST_URI'] ,__FILE__,__LINE__);
?>

   <tr bgcolor="#f2f2f2">
         <td background="themes/petrol/images/left_edge.png"></td>
         <td> 
<?php if ($user->getLoggedIn() && defined('CATEGORY_EDIT') && CATEGORY_EDIT) { 
  print "<a href=\"categorylist.php\">" . T_("Category Editor") . "</a>";
}
?></td>
         <td background="themes/petrol/images/right_edge.png"></td>

   </tr>
   <tr bgcolor="#f2f2f2">
         <td background="themes/petrol/images/left_edge.png"></td>
      
         <td><h1 class="h"><?php print T_("Ads");?></h1>
<?php         
              // $ar = getUsedCategoriesByParent("1"); 
              // $ar = getColourCatArrayNonEmpty("red","available","1"); 
              $ar = getUsedGroupsByParent("1"); 
              foreach($ar as $id => $name)  {
                  if ($id!=1) 
                print '<a class="ared" href="adlist.php?categoryid=' . $id . '">' . $name . '</a><br />';
              }
?>

       </td> <td background="themes/petrol/images/right_edge.png"></td>
       </tr>
       <tr bgcolor="#f2f2f2">
          <td><img src="themes/petrol/images/bl_16.png" alt="" /></td>
          <td><img src="themes/petrol/images/lower_133.png" alt="" /></td>
            <td><img src="themes/petrol/images/br_16.png" alt="" /></td>
       </tr>
       </table>
</div>

   <!-- end sidebar -->
