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

  class rgbDimension {
    var $value;

  function __construct() {
    $this->value = 0;
  }
  function setValue($value) {
    $this->value = $value;
  }
  function setFractedValue($rounded,$fracted) {
    // unsplit 1 and 1/8 into 1.125
    // if (!is_numeric($rounded) || !is_numeric($fracted)) {
    if (!is_numeric($rounded) || !preg_match("/[0-9]\/[[0-9]/",$fracted)) {
      $message = "Incorrect fracted values $rounded and $fracted";
      pc_debug($message,__FILE__,__LINE__);
      return false;
    } else {
      $sum = $rounded +  $fracted / 8 ; 
      $this->setValue($sum);
      $message = "correct fracted values $rounded and $fracted setting to . $sum"; 
      pc_debug($message,__FILE__,__LINE__);
    }
  }

  function getValue() {
    return (float) $this->value;
  }

  function getRoundedValue() {
    if ($this->getValue() >0 ) {
       $message = 'rounding ' . $this->getValue() . 'to' . floor($this->getValue()) ;
       // pc_debug($message,__FILE__,__LINE__);
       return (int) floor($this->getValue());
    } else {
       $message = 'rounding ' . $this->getValue() . 'to' . ceil($this->getValue()) ;
       // pc_debug($message,__FILE__,__LINE__);
       return (int) ceil($this->getValue());
    }
  }


  function getFraction() {
    // returns something like 0.125
    $fraction = (float) ($this->getValue() - $this->getRoundedValue()); 
    return abs($fraction);
  }

  function get8th() {
    // return something like "5/8"
    // if ($this->getFraction() <> 0) {
      return (string)  $this->getFraction() * 8 . "/8";
    // } else {
     //  return "0/8";
    // }
  }
  function get8thImg() {
     // shows string url to image with 8th image pie
     // themes/petrol/discs/1of8-16px.png
     $fraction = $this->getFraction()*8;
     if($fraction==0) {
        return (string) "";
     } else {
        return (string) "<img src=\"themes/petrol/discs/" . $fraction . 
                        "of8.png\" align=\"right\" alt=\"" . $fraction . T_(" of 8") . "\"/>";
     }
  }

}
?>
