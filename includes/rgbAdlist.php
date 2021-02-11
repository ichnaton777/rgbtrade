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

  /* rgbAdlist is a class showing a list of ads
  */
  class rgbAdlist  {
   var $searchString;    # user entered string
   var $offerRequest;    # selection criterium, may be both
   var $searchCategory;  # id of rgbCategoryId of selected category
   var $adList;          # store here an array of results
   
  function rgbAdlist() {
    $searchString = null;
    $offerRequest = null;
    $searchString = null;
    $adList       = null;
  }


  function addAd(rgbAd) {
    $myAd = new rgbAd($value);
    $this->adlist[] =  $myAd;
  }


  function getAdList() {
    //perform query here and return array of rgbAd objects
  }

  function setSearchString($string) {
    $this->searchString = $string;
  }
  function setOfferRequest($value) {
    if($value == "offer" || $value == "request" || $value == "both" ) {
      $this->offerRequest = $value;
    } else
    return false;
  }

  function getAdId () {
    return $this->adId;
  }

  function setAdId($myAdId) {
    $this->adId = $myAdId;
  }

  function getUserId() {
    return $this->adUserId;
  }

  function setUserId($myUserId) {
     $this->adUserId = $myUserId;
  }

  function getAdStatus() {
    return $this->adStatus;
  }

  function setAdStatus($myStatus) {
    $this->adStatus = $myStatus;
  }

  function getAdTitle() {
    return $this->adTitle;
  }

  function setAdTitle($myTitle) {
    $this->adTitle = $myTitle;
  }

  function getAdText() {
    return $this->adText;
  }

  function setAdText($myText) {
    $this->adText = $myText;
  }

  function getThumbImage() {
    return $this->adThumbImage;
  }

  function setThumbImage($myImage) {
    $this->adThumbImage = $myImage;
  }

  function getBigImage() {
    return $this->adBigImage;
  }

  function setBigImage($myImage) {
    $this->adBigImage = $myImage;
  }

  function setAdOfferRequest ($my) {
    $this->adOfferRequest = $my;
  }

  function getAdOfferRequest() {
    return $this->adOfferRequest;
  }

  function getAdGroupId() {
    return $this->adGroupId;
  }

  function setAdGroupId($id) {
    $this->adGroupId = $id;
  }

  function getAdCategoryId() {
    return $this->adCategoryId;
  }

  function setAdCategoryId($id) {
    $this->adcategoryId = $id;
  }


  function insert($form,$user) {
    $db = $GLOBALS['db'];
    $this->adRedValue->setFractedValue($form->getInputValue("adRedValue") , $form->getInputValue("adRed8Value"));
    $this->adGreenValue->setFractedValue($form->getInputValue("adGreenValue") , $form->getInputValue("adGreen8Value"));
    $this->adBlueValue->setFractedValue($form->getInputValue("adBlueValue") , $form->getInputValue("adBlue8Value"));
    $this->setAdOfferRequest($form->GetCheckedRadio("adOfferRequest"));

    $myDb = $GLOBALS['db'];
    $sql = sprintf("insert into rgbAds (adUserId,     adStatus,    adTitle,        adText, 
                                        adThumbImage, adBigImage,  adOfferRequest, adRedValue, 
                                        adGreenValue, adBlueValue, adGroupId,      adCategoryId) 
                    values (%s, '%s', '%s', '%s' , 
                            '%s', '%s', '%s', %s, 
                            %s, %s, %s, %s)", 
                            $user->getUserId(), 'live', $form->getInputValue("adTitle"), $form->getInputValue("adText"), 
                            '','',  $this->getAdOfferRequest() ,  $this->adRedValue->getValue() ,
                            $this->adGreenValue->getValue() , $this->adBlueValue->getValue(), 1,1
             );

      pc_debug("mysqli insert ad $sql" , __FILE__,__LINE__);
      if ($q = mysqli_query($db,$sql)) {
        $this->setAdId = mysqli_insert_id();
      } else {
        pc_debug(mysqli_error($db), __FILE__,__LINE__);
      }

  }
}
  
