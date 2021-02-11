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

 include "includes/rgbConfig.php";
 $db = mysql_connect($host, $user, $pass)
       or die('Could not connect: ' . mysql_error());
       mysql_select_db($dbname) or die('Could not select database');

   function endofcalendar() {
     // test if today is   define('DAY_OUT_OF_TIME','12-21')
      // if DEBUG is set and not live, always return true
      // if live, only return if today is day out of time
      if (date("m-d")  == DAY_OUT_OF_TIME) {
      print("congrats: it is: " . date("m-d"));
         return true;
      }
      //if (SYSTEMMODE != "live" && DEBUG )  {
      //   print "debug, not live, lets run this yearly reset for test! , okay!";
       //  return true;
      //}
      print("No end of year, today is " . date("m-d") . "<br/>");
     return false;
}
  if(endofcalendar()) {

 // inline code
// test if not already ran. are the dates of the running balances set to today?
//  yes -> finis script. no -> run the magic code

 $sql = "select distinct date(balanceDateTime) from rgbBalances where balanceType = 'running' and date(balanceDateTime) = date(NOW())";
       $q= mysql_query($sql);
       if(mysql_num_rows($q)==1) {
          echo "Balance has already been set. Thank you. See you next year!";
          exit;
       } else {
          echo "Will be doing the magic now!";
          $tbegin = "start transaction";
          $tinsert = "insert into  rgbBalances (balanceRedValue, balanceGreenValue, balanceBlueValue, balanceLastTransferId, 
             balanceUserId, balanceType    , balanceName)  
             select  balanceRedValue ,  balanceGreenValue , balanceBlueValue, balanceLastTransferId,  
             balanceUserId, 'milestone', year(now()) from rgbBalances where balanceType = 'running'";
          $tupdate = "update rgbBalances set balanceRedValue=0, balanceGreenValue=0, balanceBlueValue=0 , 
             balanceDateTime = now() where balanceType = 'running'";

          mysql_query($tbegin);
          mysql_query($tinsert);
          mysql_query($tupdate);

          if (mysql_error()) {
             mysql_query("rollback work");
             
          } else {
             mysql_query("commit work");
             mail(ADMIN_EMAIL,'yearly reset','your rgbtrade system has run its yearly reset. congrats');
          }

       }
  }

