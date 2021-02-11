<div id="yearbox" class="box95"><table class="minibox"><tr><td colspan=5 class="miniboxtitle"><?php print T_("Yearly Total");?></td></tr>
<tr><td class="minidata"><?php print T_("Year"); ?></td><td class="minidata"><?php print T_("Final day"); ?> </td><td class="minidata"><?php print T_("Red");?></td><td class="minidata"><?php print T_("Green");?></td><td class="minidata"><?php print T_("Blue");?></td></tr>
<?

$sql = "select *, DATE(balanceDateTime) as baldate from rgbBalances where balanceType = 'milestone' and balanceUserId = " . $showUser->getUserId() . " order by balanceDateTime desc limit $balcount" ;
# print $sql;
$q= mysql_query($sql);
if(mysql_error()) {
   pc_debug("mysql error: " . mysql_error()  , __FILE__,__LINE__);
} else {
   if(mysql_num_rows($q) >0) {
    while($result=mysql_fetch_array($q)) {
       pc_debug("balance= " . $result['balanceName'] ,__FILE__,__LINE__);
       print "<tr><td class='minidata'>" . $result['balanceName'] . "</td>";
       print "<td class='minidata'>" . date($result['baldate']) . "</td>";
       $rv = new rgbDimension;
       $rv->setValue($result['balanceRedValue']);
       $gv = new rgbDimension;
       $gv->setValue($result['balanceGreenValue']);
       $bv = new rgbDimension;
       $bv->setValue($result['balanceBlueValue']);
       print "<td class='minidata'>" . $rv->getRoundedValue() . " " . $rv->get8th() . "</td>";
       print "<td class='minidata'>" . $gv->getRoundedValue() . " " . $gv->get8th() . "</td>";
       print "<td class='minidata'>" . $bv->getRoundedValue() . " " . $bv->get8th() . "</td>";
    }
   }
}

?></table></div>

