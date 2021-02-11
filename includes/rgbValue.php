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

  class rgbValue {
    var $redValue;
    var $greenValue;
    var $blueValue;

    function rgbValue() {
      $this->redValue   = new rgbDimension;
      $this->greenValue = new rgbDimension;
      $this->blueValue  = new rgbDimension;
    }

 function setRedValue($value) {
   $this->redValue->setValue($value);
 }
 function setGreenValue($value) {
   $this->greenValue->setValue($value);
 }
 function setBlueValue($value) {
   $this->blueValue->setValue($value);
 }
 function getRedValue() {
   return (float)$this->redValue->getValue();
 }
 function getGreenValue() {
   return (float)$this->greenValue->getValue();
 }
 function getBlueValue() {
   return (float)$this->blueValue->getValue();
 }


 function getRedRoundedValue() {
   return $this->redValue->getRoundedValue();
 }
 function getRedFraction() {
   $fraction = $this->redValue->getFraction();
   return (float) $fraction;
 }
 function getRed8th() {
   return (string)  $this->redValue->get8th();
 }



 function getGreenRoundedValue() {
   return $this->greenValue-> getRoundedValue();
 }

 function getGreenFraction() {
   return  $this->greenValue->getFraction(); 
 }
 function getGreen8th() {
   return $this->greenValue-> get8th();
 }



 function getBlueRoundedValue() {
   return $this->blueValue->getRoundedValue();
 }
 function getBlueFraction() {
   return $this->blueValue->getFraction(); 
 }
 function getBlue8th() {
   return $this->blueValue->get8th();
 }
}

?>
