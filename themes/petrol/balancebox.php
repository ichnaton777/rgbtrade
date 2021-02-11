
      <div id="balancebox" class="box95">
      <table width="240" class="databox"><tr><td  colspan="3" class="boxtitle"><?php print T_("Balance");?>
          <?php print $showBalance->showBalanceDateTime();?>
          </td></tr>
              <tr class="r"><th width="80" class="f"><?php print T_("Red");?></th>
         <td align="right" width="80">
         <?php print $showBalance->balanceRedValue->getRoundedValue() .   " </td><td width=\"80\" class=\"data\"><label class=\"bred\"> " .
                     $showBalance->balanceRedValue->get8th();
         ?>
         </label></td></tr>
         <tr class="g"><th class="f"><?php print T_("Green");?></th>
         <td align="right">
         <?php print $showBalance->balanceGreenValue->getRoundedValue() . " </td><td class=\"data\"><label class=\"bgreen\"> " .
           $showBalance->balanceGreenValue->get8th();
         ?>
         </label></td></tr>
         <tr class="b"><th class="f"><?php print T_("Blue");?></th>
         <td align="right">
         <?php print $showBalance->balanceBlueValue->getRoundedValue() .  "</td><td class=\"data\"><label class=\"bblue\"> " .
           $showBalance->balanceBlueValue->get8th();
                   ?>
          </td></tr>
          </table>
      </div>
