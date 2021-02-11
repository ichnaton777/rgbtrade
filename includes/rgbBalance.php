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

  /* rgbBalance is a class for maintaining the balance, i.e. the bank account balance in rgb units.
  */
  class rgbBalance  {
   var $balanceId;
   var $balanceDateTime; # moment of last change in DB
   var $balanceRedValue;
   var $balanceGreenValue;
   var $balanceBlueValue;
   var $balancelastTransactionId;
   var $balanceUserId;
   var $balanceType; # running, milestone
   var $balanceName; # users name, i.e. Start, year 2008, etc

  function __construct() {
   $this->balanceId         = null;
   $this->balanceDateTime   = null;
   $this->balanceRedValue   = new rgbDimension;
   $this->balanceGreenValue = new rgbDimension;
   $this->balanceBlueValue  = new rgbDimension;
   $this->balanceUserId     = null;
   $this->balanceType       = null;
  }

  function insert() {
    // we need the UserId  and a a balance type else we dont have a job
    if (!isset($this->balanceUserId) || !isset($this->balanceType)) {
      return false;
    }
    $db = $GLOBALS['db'];
    $sql = sprintf("insert into rgbBalances ( 
        balanceUserId,          balanceType, balanceName) values (
        %s,                     '%s' , '%s')", 
        $this->balanceUserId, $this->balanceType, $this->balanceName
                   );
    $q = mysqli_query($db,$sql);
    if(!$q) { 
       pc_debug("mysqli error: $sql ".  mysqli_error($db) ,__FILE__,__LINE__);
       return false;
    } 
    pc_debug("balance insert done; $sql",__FILE__,__LINE__);

  }
 function loadBalance() {
    global $db;
   // if (!is_numeric($this->getUserid())) return false;
    $sql = sprintf("select balanceId, balanceDateTime, balanceRedValue, balanceGreenValue, balanceBlueValue, 
                    balanceLastTransferId, balanceUserId, balanceType, balanceName from rgbBalances 
                    where balanceUserId = '%s' 
                    and   balanceType = '%s'",
                    $this->getUserId(),
                    "running"
                  );
    if(! $q = mysqli_query($db,$sql)) {
      pc_debug("mysqli error: $sql".  mysqli_error($db),__FILE__,__LINE__);
    } 
    $res = mysqli_fetch_array($q);
    $this->balanceId         = $res["balanceId"];
    $this->balanceDateTime   = $res["balanceDateTime"];
    $this->balanceRedValue->setValue($res["balanceRedValue"]);
    $this->balanceGreenValue->setValue($res["balanceGreenValue"]);
    $this->balanceBlueValue->setValue($res["balanceBlueValue"]);
    $this->balanceUserId     = $res["balanceUserId"];
    $this->balanceType       = $res["balanceType"];
    $this->balanceName       = $res["balanceName"];
    pc_debug("loaded balance " . $this->balanceId . "with $sql. " , __FILE__,__LINE__ );

    return true;
 }
                    

 function getType() {
   return $this->balanceType;
 }

 function setType($myType) {
   $this->balanceType = $myType;
 }

 function getUserId() {
   return $this->balanceUserId;
 }

 function setUserId($myId) {
   $this->balanceUserId = $myId;
 }

 function getBalanceDateTime() {
   return $this->balanceDateTime;
 }

 function showBalanceDateTime() {
   $dt = strtotime($this->getBalanceDateTime());
   return strftime('%d %b %G %H:%M ',$dt);
 }

 function getBalanceName() {
    return $this->balanceName;
 }

 function setBalanceName($aName) {
    $this->balanceName = $aName;
 }

}
