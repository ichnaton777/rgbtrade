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

  class rgbTransfer {
    var $transferId;     # id of this transfer
    var $transferFromId; # userId of user who pays RGB
    var $transferToId;   # userId of user who receives RGB
    var $transferById;   # userId of user who ordered transfer
    var $transferText;
    var $transferRedValue;  # complete value, say 4 3/8
    var $transferGreenValue;
    var $transferBlueValue;
    var $transferStatus;

    function __construct() {
      $this->transferStatus     = "sent";
      $this->transferRedValue   = new rgbDimension;
      $this->transferGreenValue = new rgbDimension;
      $this->transferBlueValue  = new rgbDimension;
    }

    function setId($id) {
      $this->transferId = $id;
    }
    function getId() {
      return $this->transferId;
    }

    function setFromId($id) {
      $this->transferFromId = $id;
    }

    function getFromId() {
      return $this->transferFromId;
    }

    function setToId($id) {
      $this->transferToId = $id;
    }

    function getToId() {
      return $this->transferToId;
    }

    function setById($id) {
        $this->transferById = $id;
    }

    function getById() {
        return $this->transferById;
    }

    function setText($text) {
      $this->transferText = $text;
    }

    function getTheText() {
      return $this->transferText;
    }

    function getRedValue() {
      return $this->transferRedValue;
    }

    function getStatus() {
        return($this->transferStatus);
    }
    function setStatus($status) {
        $this->transferStatus = $status;
    }

    function setRedValue($value) {
      $this->transferRedValue = $value;
    }

    function getGreenValue() {
      return $this->transferGreenValue;
    }

    function setGreenValue($value) {
      $this->transferGreenValue = $value;
    }

    function getBlueValue() {
      return $this->transferBlueValue;
    }

    function setBlueValue($value) {
      $this->transferBlueValue = $value;
    }

    function getDateTime() {
      return $this->transferDateTime;
    }

    function getDateTimeString() {
      return strtotime($this->getDateTime());
    }

    function setDateTime($date) {
      $this->transferDateTime = $date;
    }


    function checkTransfer () {
        // can only be valid if session user is either from or to.
        pc_debug("from user is " . $this->getFromId() . " and to user is " .  $this->getToId() . 
                 " and session is " . $_SESSION['userId'] ,__FILE__,__LINE__);
        return (($this->getToId() == $_SESSION['userId']) || 
            ($this->getFromId() == $_SESSION['userId']));
    }



    function saveTransfer() {
      // $message=var_export($this);
      pc_debug("saving transfer",__FILE__,__LINE__);
      global $db;
      if (get_magic_quotes_gpc()) {
        $this->transferText    = stripslashes(mysqli_real_escape_string($db,$_POST['transferText']));
      } else {
        $this->transferText    = mysqli_real_escape_string($db,$_POST['transferText']);
      }
      $red = $_POST['redValue'];
      if($red=="") {
        $red = 0;
      }
      $red8th = $_POST['red8th'];
      pc_debug("red values are" . $red . " and " . $red8th , __FILE__,__LINE__);
      $this->transferRedValue->setFractedValue($red,$red8th);
      $green = $_POST['greenValue'];
      $green8th = $_POST['green8th'];
      $this->transferGreenValue->setFractedValue($green,$green8th);
      $blue = $_POST['blueValue'];
      $blue8th = $_POST['blue8th'];
      $this->transferBlueValue->setFractedValue($blue,$blue8th);
      /* already done 
      $tofrom = $_POST['tofrom'];
      if ($tofrom == "to") {
        $this->transferFromId = $_SESSION['userId'];
        $this->transferToId   = $_POST['transferUserId'];
      } else {
        $this->transferToId = $_SESSION['userId'];
        $this->transferFromId   = $_POST['transferUserId'];
      }
       */

      // prepare a series of 3 sql statements 
      // insert the transfer, and 2 updates of both involved balances
      $tSql = sprintf("insert into rgbTransfers (
        transferFromId, 
        transferToId,
        transferById,
        transferText, 
        transferRedvalue, 
        transferGreenValue, 
        transferBlueValue) 
        values (%s , %s , %s, '%s' , %s , %s , %s )",
        $this->transferFromId, 
        $this->transferToId, 
        $_SESSION['userId'],
        $this->transferText, 
        $this->transferRedValue->getValue(), 
        $this->transferGreenValue->getValue(), 
        $this->transferBlueValue->getValue());
      pc_debug("mysqli $tSql" , __FILE__,__LINE__);

      if ($qT = mysqli_query($db,$tSql) ) {
        $this->transferId = mysqli_insert_id();
      }

        // TO user sees his balance going PLUS
      $uTo = sprintf("update rgbBalances set 
             balanceRedValue = balanceRedValue+%s,
             balanceGreenValue = balanceGreenValue+%s,
             balanceBlueValue = balanceBlueValue+%s,
             balanceLastTransferId = %s
             where balanceUserId = %s 
             and   balanceType = 'running'",
             $this->transferRedValue->getValue(), 
             $this->transferGreenValue->getValue(), 
             $this->transferBlueValue->getValue(),
             $this->transferId,
             $this->transferToId);
      pc_debug("mysqli to $uTo" , __FILE__,__LINE__);
      $uFrom =  sprintf("update rgbBalances set 
             balanceRedValue = balanceRedValue-%s,
             balanceGreenValue = balanceGreenValue-%s,
             balanceBlueValue = balanceBlueValue-%s,
             balanceLastTransferId = %s
             where balanceUserId = %s 
             and   balanceType = 'running'",
             $this->transferRedValue->getValue(), 
             $this->transferGreenValue->getValue(), 
             $this->transferBlueValue->getValue(),
             $this->transferId,
             $this->transferFromId);
      pc_debug("mysqli from $uFrom" , __FILE__,__LINE__);
         $this->setStatus("done");
         if ($qTo = mysqli_query($db,$uTo)) {
               pc_debug("mysqli ran! : $qTo" , __FILE__,__LINE__);
         } else {
           pc_debug("mysqli query failed:! $qTo" . mysqli_error($db) , __FILE__,__LINE__);
           $this->setStatus("failed");
         }
         if ($qFrom = mysqli_query($db,$uFrom)) {
           pc_debug("mysqli ran! : $qFrom" , __FILE__,__LINE__);
         } else {
           pc_debug("mysqli query failed:! $qFrom" . mysqli_error($db) , __FILE__,__LINE__);
           $this->setStatus("failed");
         }

    }
}
?>
