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

  /* rgbAd is a class for advertising 
  */
  class rgbAd  {
   var $adId;
   var $adUserId;       # rgbUsers->userId
   var $adUserNick;     # rgbUsers->userId->userNick
   var $adStatus;       # unused, but will be, live - invisible
   var $adTtitle;       # title (subject) of the ad
   var $adText;         # long free text
   var $adThumbImage;   # no blob but url to img
   var $adBigImage;     # no blob but url to img
   var $adOfferRequest; # either 'offer' or 'request'
   var $adRedValue;     # value in Red
   var $adGreenValue;   # value in Green
   var $adBlueValue;    # value in Blue
   var $adGroupId;      # rgbAdCategoeries -> adCategoryId
   var $adCategoryId;   # rgbAdCategoeries -> adCategoryId , Group is super of category
   


  function __construct() {
   $this->adId           = null;
   $this->adUserId       = null;
   $this->adStatus       = 'live' ;
   $this->adTitle        = "";
   $this->adText         = "";
   $this->adThumbImage   = "";
   $this->adBigImage     = "";
   $this->adOfferRequest = null;
   $this->adRedValue     = new rgbDimension;
   $this->adGreenValue   = new rgbDimension;
   $this->adBlueValue    = new rgbDimension;
   $this->adGroupId      = 2; // called "Change me"
   $this->adCategoryId   = 3; // called "Change me"
   $this->adLastChange   = null;
   $this->adRedValue->setValue(0);
   $this->adGreenValue->setValue(0);
   $this->adBlueValue->setValue(0);
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

  function setUserNick($nick) {
    $this->adUserNick = $nick;
  }
  function getUserNick() {
    return $this->adUserNick;
  }



  function getThumbImage($html = false ) {
    // new function expects database to contain full (relative) path incl /uploads
    // send me the HTML if we need it, but not if there is no image
    if ($html == "html" && $this->adThumbImage <> "") {
      // return '<img src="uploads/' . $this-> getUserNick() . "/ads/" . $this->adThumbImage . "\" hspace=\"3\" vspace=\"3\" />";
      return '<img src="' . $this->adThumbImage . "\" hspace=\"3\" vspace=\"3\" />";
    } else {
       // even if empty string ;-)
      return $this->adThumbImage;
    }

  }
  

  function setThumbImage($myImage) {
    $this->adThumbImage = $myImage;
  }

  function getBigImage($html = false) {
      // new function expects database to contain full (relative) path incl /uploads
      pc_debug("to return bigImage" . $this->adBigImage,__FILE__,__LINE__);
    if   ($html == "html" && $this->adBigImage <> "") {
      // return '<img src="uploads/' . $this-> getUserNick() . "/ads/" . $this->adBigImage . "\" />";
      return '<img src="' . $this->adBigImage . '" />';
    } if ($html == "path" ) { 
        // return 'uploads/' . $this-> getUserNick() . "/ads/" .  $this->adBigImage ;
        return  $this->adBigImage ;
    } else {
       // even if empty string ;-)
    return $this->adBigImage;
    }
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

  function getAdOfferRequestImage() {
    if ($this->getAdOfferRequest() == "request") {
      return "<img src=\"images/request_star_24.png\"  align=\"left\" alt=\"Vraag\" title=\"Vraag\" hspace=\"5\">";
    } else if ($this->getAdOfferRequest() == "offer") {
      return "<img src=\"images/offer_star_24.png\"  align=\"left\" alt=\"Aanbod\" title=\"Aanbod\" hspace=\"5\">";
    } else {
      return "";
    }
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
    $this->adCategoryId = $id;
  }


  function insert($form,$user) {
    $db = $GLOBALS['db'];
    pc_debug("inserting ad",__LINE__,__FILE__);
    $this->adRedValue->setFractedValue($form->getInputValue("adRedValue") , $form->getInputValue("adRed8Value"));
    $this->adGreenValue->setFractedValue($form->getInputValue("adGreenValue") , $form->getInputValue("adGreen8Value"));
    $this->adBlueValue->setFractedValue($form->getInputValue("adBlueValue") , $form->getInputValue("adBlue8Value"));
    $this->setAdOfferRequest($form->GetCheckedRadio("adOfferRequest"));
    $this->setAdGroupId($form->GetInputValue("adGroup"));
    $this->setAdCategoryId($form->GetInputValue("adCategory"));
    $sql = sprintf("insert into rgbAds (adUserId,     adStatus,    adTitle,        adText, 
                                        adThumbImage, adBigImage,  adOfferRequest, adRedValue, 
                                        adGreenValue, adBlueValue, adGroupId,      adCategoryId) 
                    values (%s, '%s', '%s', '%s' , 
                            '%s', '%s', '%s', %s, 
                            %s, %s, %s, %s)", 
                            $user->getUserId(), 'live', 
                            mysqli_real_escape_string($db,$form->getInputValue("adTitle")), mysqli_real_escape_string($db,$form->getInputValue("adText")), 
                            $this->getThumbImage(),$this->getBigImage(),  $this->getAdOfferRequest() ,  $this->adRedValue->getValue() ,
                            $this->adGreenValue->getValue() , $this->adBlueValue->getValue(), 
                            $this->getAdGroupId(),$this->getAdCategoryId()
             );

      pc_debug("mysqli insert ad $sql" , __FILE__,__LINE__);
      if ($q = mysqli_query($db,$sql)) {
        $this->setAdId(mysqli_insert_id());
        pc_debug("inserted ad is adId" . $this->getAdId() ,__LINE__,__FILE__);
        return ($this->getAdId());
      } else {
        pc_debug(mysqli_error($db,), __FILE__,__LINE__);
        return false;
      }

  }
  function makeUploadPath($user,$section) {
      // return string based for upload saving, based on user, ad/avatar section
      // and SAFE_MODE_COMPAT
      // Also create directories when needed
      //
      if (defined('SAFE_MODE_COMPAT') && SAFE_MODE_COMPAT ) {
          # use default dir, / , nick_originalname.jpg
          # not 100% secure, but to overwrite other peoples pics, you need similar nickname and crafted pic names...
          return array('uploads/'. $_SESSION['userNick'] . '_' . basename($_FILES['uploadFile']['name']),
                       'uploads/'. $_SESSION['userNick'] .  '_' . 't_'. basename($_FILES['uploadFile']['name']));
      } else {
          pc_debug("making upload path, safe mode = " . SAFE_MODE_COMPAT, __FILE__,__LINE__);

         if (!is_dir('uploads/' . $_SESSION['userNick'] )) {
           mkdir('uploads/' .$_SESSION['userNick']);
         }
         if (!is_dir('uploads/' .  $_SESSION['userNick'] .'/ads')) {
           mkdir('uploads/' . $_SESSION['userNick'] .'/ads');
         }
         $newPath      = 'uploads/' .  $_SESSION['userNick'] . '/ads/'. basename($_FILES['uploadFile']['name']);
         $newPathThumb = 'uploads/' .  $_SESSION['userNick'] . '/ads/t_'. basename($_FILES['uploadFile']['name']);
         return array($newPath,$newPathThumb);
      }


  }

  function saveThumb() {
     global $db;
     pc_debug("saving thumb",__LINE__,__FILE__);
     if(!isset($_FILES['uploadFile']) || $_FILES['uploadFile']['name'] == '') {
           pc_debug("no file to save",__FILE__,__LINE__);
       return false;
     }
     pc_debug("upload file to save",__FILE__,__LINE__);
     if ($_FILES['uploadFile']['error'] == UPLOAD_ERR_OK) {
       // make sure we have a place to park the new file. a single dir for each user.
       list( $newPath,$newPathThumb) = $this->makeUploadPath($_SESSION['userNick'],'ads');
       pc_debug("newpath thumbs : " . $newPath . $newPathThumb , __FILE__,__LINE__);


       if (move_uploaded_file($_FILES['uploadFile']['tmp_name'],$newPath)) {
           //$this->setAvatar(basename($_FILES['avatar']['name']));
           // we have an okay image available.
           // now: leave the original and set BigImage to it
           // open it, , scale to 100px width and save to thumb, regardless of size
           //

            $dimensions = getimagesize($newPath);  
            $width      = $dimensions[0]; 
            $height     = $dimensions[1];
            $newwidth =  100; // hard coded, never change !
            $newheight =  $height / $width * 100;

            // Load
            $thumb = imagecreatetruecolor($newwidth, $newheight);
            if (preg_match('/jpg|jpeg/i',$newPath)){
                        $source=imagecreatefromjpeg($newPath);
            }
            if (preg_match('/png/i',$newPath)){
                            $source=imagecreatefrompng($newPath);
            } 
            if (preg_match('/gif/i',$newPath)){
                            $source=imagecreatefromgif($newPath);
            }


            //
            // // Resize
            imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
            //
            // // Output
            //
            if (preg_match("/png/i",$newPath)) {
                imagepng($thumb,$newPathThumb); 
            } else if (preg_match('/jpg|jpeg/i',$newPathThumb)) { 
               imagejpeg($thumb,$newPathThumb); 
            } else {
               imagegif($thumb,$newPathThumb); 
            }

            imagedestroy($source); 
            imagedestroy($thumb); 
            //
            //
            //
            //
            // BUG, this is VARIABLE!
            //
           //$this->setThumbImage('t_' . basename($_FILES['uploadFile']['name']));
           //$this->setBigImage(         basename($_FILES['uploadFile']['name']));
           $this->setBigImage($newPath);
           $this->setThumbImage($newPathThumb);
           pc_debug("saving image in db: big :##$newPath##thumb$newPathThumb##",__FILE__,__LINE__);
           chmod("$newPath", 0755);
           chmod("$newPathThumb", 0755);
       } else {
           pc_debug("ERROR:can not save to $newPath",__FILE__,__LINE__);
       }
           pc_debug("done saving upload to $newPath",__FILE__,__LINE__);
     } else {
           pc_debug("Error during upload?" . $_FILES['uploadFile']['error'] ,__FILE__,__LINE__);
           // var_dump($_FILES);
     }

  }



  function loadForm($form) {
    $this->adRedValue->setFractedValue($form->getInputValue("adRedValue") , $form->getInputValue("adRed8Value"));
    $this->adGreenValue->setFractedValue($form->getInputValue("adGreenValue") , $form->getInputValue("adGreen8Value"));
    $this->adBlueValue->setFractedValue($form->getInputValue("adBlueValue") , $form->getInputValue("adBlue8Value"));
    $this->setAdOfferRequest($form->GetCheckedRadio("adOfferRequest"));
    $this->setAdGroupId($form->getInputValue("adGroup"));
    $this->setAdCategoryId($form->getInputValue("adCategory"));
    // print_r($form);
  }


  function save($form,$user) {
    $db = $GLOBALS['db'];
    $form->loadInputValues();
    $this->adRedValue->setFractedValue($form->getInputValue("adRedValue") , $form->getInputValue("adRed8Value"));
    $this->adGreenValue->setFractedValue($form->getInputValue("adGreenValue") , $form->getInputValue("adGreen8Value"));
    $this->adBlueValue->setFractedValue($form->getInputValue("adBlueValue") , $form->getInputValue("adBlue8Value"));
    $this->setAdOfferRequest($form->GetCheckedRadio("adOfferRequest"));
    // too complicated to use form for this one, do it straight.
    $this->setAdGroupId(mysqli_real_escape_string($db,$_REQUEST['adGroup']));
    $this->setAdCategoryId(mysqli_real_escape_string($db,$_REQUEST['adCategory']));


    $sql = sprintf("update rgbAds set adTitle = '%s',       adText = '%s', 
                                      adOfferRequest = '%s',adRedValue = %s,   adGreenValue = %s,  adBlueValue = %s,
                                      adgroupId = %s , adCategoryId = %s , adThumbImage = '%s',
                                      adBigImage = '%s' 
                                      where adId = %s",
                                      mysqli_real_escape_string($db,$form->getInputValue("adTitle")), 
                                      mysqli_real_escape_string($db,$form->getInputValue("adText")),
                                      $this->getAdOfferRequest(),
                                      $this->adRedValue->getValue() , $this->adGreenValue->getValue() , $this->adBlueValue->getValue(), 
                                      $this->getAdGroupId(),$this->getAdCategoryId(), $this->getThumbImage(),
                                      $this->getBigImage(),
                                      $this->getAdId());
    pc_debug("\n $sql\n" , __FILE__,__LINE__);
    if(!$q = mysqli_query($db,$sql)) {
      pc_debug("mysqli error" . mysqli_error($db), __FILE__,__LINE__);
      return false;
    }
    return true;
  }

  function load() {
    global $db;
    $sql = sprintf("select * from rgbAds where adId = '%s'", $this->getAdId());
    pc_debug("running $sql",__FILE__,__LINE__);
    $q   = mysqli_query($db,$sql);
    $res = mysqli_fetch_assoc($q);
    $this->adText  = $res["adText"];
    $this->adTitle  = $res["adTitle"];
    $this->adStatus = $res["adStatus"];
    $this->adLastChange = $res["adLastChange"];
    $this->adOfferRequest = $res["adOfferRequest"];
    $this->adRedValue->setValue($res["adRedValue"]);
    $this->adGreenValue->setValue($res["adGreenValue"]);
    $this->adBlueValue->setValue($res["adBlueValue"]);
    $this->setThumbImage($res["adThumbImage"]);
    $this->setBigImage($res["adBigImage"]);
    $this->setAdGroupId($res["adGroupId"]);
    $this->setAdCategoryId($res["adCategoryId"]);
    $this->setUserId($res["adUserid"]);
  }

  function delete() {
    global $db;
      $sql = sprintf("delete from rgbAds where adId = %s",  $this->getAdId());
    pc_debug("running $sql",__FILE__,__LINE__);
    $q   = mysqli_query($db,$sql);
    if(mysqli_error($db)) {
        pc_debug("mysqli error: " . mysqli_error($db) ,__FILE__,__LINE__);
        return false;
    } else {
        return true;
    }
  }

  function confirmDeleteMessage() {
    print "confirming ?";
  }
}
  
