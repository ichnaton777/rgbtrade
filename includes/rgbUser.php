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

  /* Class rgbUser
  *  This file is part of the rgbTrade system, enabling the use of a 3-D monetary unit for trading. 
  *  For details see www.kleureneconomie.nl or sourceforge.net/rgbtrade
  *  @author  Barry Voeten, barry@voeten.com
  *  @license Gnu Public License 
  */

class rgbUser {
  var $userId; // database ID
  var $userNick;
  var $userEmail;
  var $userAddress;
  var $userAddress2;
  var $userZipCode;
  var $userCity;
  var $userPhone1;
  var $userPhone2;
  var $userRegion;
  var $userWebsite;
  var $userPassword;
  var $userAvatar;
  var $userStatus;
  var $userSessionID;
  var $userLastLog;
  var $userPlan;
  var $userBirth;

   function __construct() {
    $this->userNick = '';
    $this->userEmail = '';
    $this->userAddress = '';
    $this->userAddress2 = '';
    $this->userZipCode = '';
    $this->userCity = '';
    $this->userPhone1 = '';
    $this->userPhone2 = '';
    $this->userWebsite = '';
    $this->userPassword = '';
    $this->userStatus = '';
    $this->userPlan = '';
    $this->userSessionID = 'Thesessionid';
    $this->LastLog = date('d-m-Y');
    $this->userBirth = '' ; // will be fixed at insert or load time
  }


  function testUniqueNick() {
    $db = $GLOBALS['db'];
    $sql = sprintf("select * from rgbUsers where userNick = '%s'",$this->userNick);
    $q = mysqli_query($db,$sql);
    if (mysqli_num_rows($q) > 0 ) {
      print "Helaas, " . $this->userNick  . " bestaat al";
      return false;
    }
    return true;
  }


  function testUniqueEmail($nick="") {
    global $errorBox;
    $db = $GLOBALS['db'];
    if($nick=="") {
       $sql = sprintf("select * from rgbUsers where userEmail = '%s'",$this->userEmail);
    } else {
        $sql = sprintf("select * from rgbUsers where userEmail = '%s' and userNick <> '%s'",$this->userEmail,$nick);
    }
    $q = mysqli_query($db,$sql);
    if (mysqli_num_rows($q) > 0 ) {
      $errorBox->title = "Helaas";
      $errorBox->text =  "date emailadres bestaat al";
      $errorBox->visible = true;
      // print "email false";
      return false;
    }
    return true;
  }

  function insert() {
    $db = $GLOBALS['db'];
    $sql = sprintf("insert into rgbUsers (userNick, userEmail,userAddress, userZipCode,
    userCity, userRegion, userPhone1, userPhone2, userWebsite,  userPassword,
    userPlan, userAvatar, userStatus, userSessionID, userLastLog, userBirth )
    values ('%s','%s','%s','%s','%s','%s','%s','%s','%s',password('%s'),'%s','%s','%s','%s','%s',%s)", 
    $this->userNick,
    $this->userEmail,
    $this->userAddress,
    $this->userZipCode,
    $this->userCity,
    $this->userRegion,
    $this->userPhone1,
    $this->userPhone2,
    $this->userWebsite,
    $this->userPassword,
    $this->userPlan,
    $this->userAvatar,
    $this->userStatus,
    $this->userSessionID,
    $this->userLastLog,
    'NOW()'
  );
    $q = mysqli_query($db,$sql);
    if(!$q) { 
      echo mysqli_error($db) . "##$sql##" ;
      pc_debug("user insert failed for  " . $this->userNick . mysqli_error($db), __FILE__,__LINE__);
      return false;
    } else {
      pc_debug("user insert okay:" . $this->userNick . mysqli_error($db), __FILE__,__LINE__);
      # print "$sql okay";
      $this->setUserId(mysqli_insert_id($db));
      return true;
    }
  }

  function checkLogin() {
    $db = $GLOBALS['db'];
    $sql = sprintf("select * from rgbUsers where userNick = '%s' and userPassword = password('%s')", 
    // add check for user status live,if unconfirmed send to email confirm page
    mysqli_real_escape_string($db,$_POST['userNick']),
    mysqli_real_escape_string($db,$_POST['userPassword']));
    if (!$q = mysqli_query($db,$sql)) {
      print mysqli_error($db);
      return false;
    }
    if (mysqli_num_rows($q) > 0  ) {
      //print "ok";
      $res = mysqli_fetch_assoc($q);
      $this->setUserId($res["userId"]);
      $this->setUserNick($_POST['userNick']);
      return true;
    } else {
      // print "not logged in : $sql ";
       pc_debug("login invalid",__FILE__,__LINE__);
      return false;
    }
  }

  function setlogin() {
       $_SESSION['status'] = 'live';
       $_SESSION['userNick'] = $this->getUserNick();
       $_SESSION['userId'] = $this->getUserId();
     //  print "logged in now!";
  }

  function setloggedoff() {
       $_SESSION['status'] = 'loggedoff';
       unset($_SESSION['userNick']);
    //   print "logged off now!";
  }

  function getloggedin() {
    
    return isset($_SESSION['status']) && $_SESSION['status'] == 'live';

  }

  function getUserNick() {
    return $this->userNick;
  }

   function getNickUrl() {
     return '<a href="profile.php?nick=' . $this->getUserNick() . '">' . $this->getUserNick() . '</a>';
   }

  function setUserNick($nick){
    $this->userNick = $nick;
  }
  function getUserId() {
    return $this->userId;
  }
  function setUserId($id) {
    $this->userId = $id;
  }
  function getEmail() {
    return $this->userEmail;
  }
  function setEmail($email) {
    $this->userEmail = $email;
  }
  function getAddress() {
    return $this->userAddress;
  }
  function setAddress($address) {
    $this->userAddress = $address;
  }
  function getAddress2() {
    return $this->userAddress2;
  }
  function setAddress2($address2) {
    $this->userAddress2 = $address2;
  }
  function getZipCode() {
    return $this->userZipCode;
  }
  function getZipCodeGoogleMap() {
      if ($this->getZipCode() !="") {
          return "<a title=\"Kaart van postcode " . $this->getZipCode() . "\" href=\"http://maps.google.nl/maps?f=q&hl=nl&geocode=&q=" . 
              str_replace(" ","", $this->getZipCode()) .
              "&ie=UTF8&z=10&iwloc=addr&om=1\">" . T_("Location") . "</a>";
      }
  }


  function setZipCode($code) {
    $this->userZipCode = $code;
  }
  function getRegion() {
    return $this->userRegion;
  }
  function setRegion($region) {
    $this->userRegion = $region;
  }
  function getCity() {
    return $this->userCity;
  }
  function setCity($city) {
    $this->userCity = $city;
  }
  function getPhone1() {
    return $this->userPhone1;
  }
  function setPhone1($phone) {
   $this->userPhone1 = $phone;
  }
  function getPhone2() {
    return $this->userPhone2;
  }
  function setPhone2($phone) {
    $this->userPhone2 = $phone;
  }
  function getPlan() {
    return $this->userPlan;
  }
  function setPlan($plan) {
    $this->userPlan = $plan;
  }
  function getAvatar() {
    return $this->userAvatar;
  }
  function getAvatarUrl() {
    if ($this->getAvatar() <> "") {
      // return "uploads/" . $this->getUserNick() . "/" . $this->getAvatar();
      return  $this->getAvatar();
    }
    else return "";
  }
    
  function getAvatarImage() {
    if ($this->getAvatar() <> "") {
       return "<img src=\"" . $this->getAvatarUrl() . "\">";
    } else return "";
  }
  function setAvatar($avatar) {
    $this->userAvatar = $avatar;
  }
  function getWebsite() {
    return $this->userWebsite;
  }
  function setWebsite($website) {
    $this->userWebsite = $website;
  }

  function getUserBirth() {
    return date("d-m-Y",strtotime($this->userBirth));
  }
  function setUserBirth($birth) {
    $this->userBirth = $birth;
  }


  function loadUser(){
    global $db;
    $sql = sprintf("select * from rgbUsers where userNick = '%s'", $this->getUserNick());
    pc_debug("running load user $sql",__FILE__,__LINE__);
    $q   = mysqli_query($db,$sql)  ;
    if (mysqli_error($db)) {
        pc_debug("ERROR load_user:" . $this->userId  . mysqli_error($db),__FILE__,__LINE__);
    }
    $res = mysqli_fetch_assoc($q);
    echo "\n\nRes=";
    var_dump($res);
    $this->userEmail    = $res['userEmail'];
    $this->userAddress  = $res["userAddress"];
    $this->userId       = $res["userId"];
    $this->userNick     = $res["userNick"];
    $this->userAddress  = $res["userAddress"];
    $this->userAddress2 = $res["userAddress2"];
    $this->userZipCode  = $res["userZipCode"];
    $this->userCity     = $res["userCity"];
    $this->userRegion   = $res["userRegion"];
    $this->userPhone1   = $res["userPhone1"];
    $this->userPhone2   = $res["userPhone2"];
    $this->userPlan     = $res["userPlan"];
    $this->userAvatar   = $res["userAvatar"];
    $this->userWebsite  = $res["userWebsite"];
    $this->userBirth    = $res["userBirth"];
   }

  // does not belong here, actually, but it makes things work today.
  //
  function makeUploadPath() {
      // return string based for upload saving, based on user, ad/avatar section
      // and SAFE_MODE_COMPAT
      // Also create directories when needed
      //
      if (defined('SAFE_MODE_COMPAT') && SAFE_MODE_COMPAT ) {
          # use default dir, / , nick_originalname.jpg
          # not 100% secure, but to overwrite other peoples pics, you need similar nickname and crafted pic names...
          return ('uploads/'. $_SESSION['userNick'] . '_ava_' . basename($_FILES['avatar']['name']));
      } else {
          pc_debug("making upload path, safe mode = " . SAFE_MODE_COMPAT, __FILE__,__LINE__);

         if (!is_dir('uploads/' . $_SESSION['userNick'] )) {
           mkdir('uploads/' .$_SESSION['userNick']);
         }
         $newPath = 'uploads/' . $this->getUserNick() . '/_ava_'. basename($_FILES['avatar']['name']);
         return($newPath);
      }
  }

   function saveAvatar() {
     global $db;
     pc_debug("saving avatar",__LINE__,__FILE__);
     if ($_FILES['avatar']['error'] == UPLOAD_ERR_OK) {
       // make sure we have a place to park the new file. a single dir for each user.

       if (!is_dir('uploads/' . $this->getUserNick() )) {
         mkdir('uploads/' . $this->getUserNick());
       }
       // $newPath = 'uploads/' . $this->getUserNick() . '/'. basename($_FILES['avatar']['name']);
       $newPath = $this->makeUploadPath();

       if (move_uploaded_file($_FILES['avatar']['tmp_name'],$newPath)) {
           $this->setAvatar($newPath);
           $dimensions = getimagesize($newPath);
           $width      = $dimensions[0];
           $height     = $dimensions[1];
           $newwidth =  100; // hard coded, never change !
           $newheight =  $height / $width * 100;
           // Load
           $thumb = imagecreatetruecolor($newwidth, $newheight);
           if (preg_match('/jpe?g/i',$newPath)){
               $source=imagecreatefromjpeg($newPath);
           }
           if (preg_match('/png/i',$newPath)){
               $source=imagecreatefrompng($newPath);
           }
           if (preg_match('/gif/i',$newPath)){
               $source=imagecreatefromgif($newPath);
           }
           // Resize
           imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
           // Output
           if (preg_match("/png/i",$newPath)) {
               imagepng($thumb,$newPath);
           } else if (preg_match('/jpe?g/i',$newPath)) {
               imagejpeg($thumb,$newPath);
           } else {
                imagegif($thumb,$newPath);
           }
           chmod("$newPath", 0755);
       } else {
           print "can not save to $newPath";
       }
     }
   }

   function checkAvatar($url) {
       //obsolete
     $okay = true;
     list($width, $height, $type, $attr)=getImageSize($url);
     if ($width > 100) {
        print "Image too wide, max 100 px";
        $okay = false;
     }
     if ($height > 100) {
        print "Image too high, max 100 px";
        $okay = false;
     }
     if (filesize($url) > 8000) {
        print "Image file size too large, max 5000 bytes";
        $okay = false;
     }
     return $okay;
   }

   function saveUser(){
    global $db;
    if (get_magic_quotes_gpc()) {
      $email    = stripslashes(mysqli_real_escape_string($db,$_POST['email']));
      $address1 = stripslashes(mysqli_real_escape_string($db,$_POST['address']));
      $address2 = stripslashes(mysqli_real_escape_string($db,$_POST['address2']));
      $zipcode  = stripslashes(mysqli_real_escape_string($db,$_POST['zipcode']));
      $city     = stripslashes(mysqli_real_escape_string($db,$_POST['city']));
      $phone1   = stripslashes(mysqli_real_escape_string($db,$_POST['phone1']));
      $phone2   = stripslashes(mysqli_real_escape_string($db,$_POST['phone2']));
      $plan     = stripslashes(mysqli_real_escape_string($db,$_POST['plan']));
      $region   = stripslashes(mysqli_real_escape_string($db,$_POST['region']));
      $website  = stripslashes(mysqli_real_escape_string($db,$_POST['website']));
    } else {
      $email    = mysqli_real_escape_string($db,$_POST['email']);
      $address1 = mysqli_real_escape_string($db,$_POST['address']);
      $address2 = mysqli_real_escape_string($db,$_POST['address2']);
      $zipcode  = mysqli_real_escape_string($db,$_POST['zipcode']);
      $city     = mysqli_real_escape_string($db,$_POST['city']);
      $phone1   = mysqli_real_escape_string($db,$_POST['phone1']);
      $phone2   = mysqli_real_escape_string($db,$_POST['phone2']);
      $plan     = mysqli_real_escape_string($db,$_POST['plan']);
      $region   = mysqli_real_escape_string($db,$_POST['region']);
      $website  = mysqli_real_escape_string($db,$_POST['website']);
    }
    if( !strstr($website,'http://') ) {
        $website = 'http://' . $website;
    }
    // check that the email adress is still unique, or database update query will fail.
    //

    $avatar = $this->getAvatar();
    $sql = sprintf("update rgbUsers set 
         userEmail     = '%s',
         userAddress   = '%s',
         userAddress2  = '%s',
         userZipCode   = '%s',
         userCity      = '%s',
         userPhone1    = '%s',
         userPhone2    = '%s',
         userPlan      = '%s',
         userRegion    = '%s',
         userAvatar    = '%s',
         userWebsite   = '%s'
         where userId  = '%s'" ,
         $email,
         $address1,
         $address2,
         $zipcode,
         $city,
         $phone1,
         $phone2,
         $plan,
         $region,
         $avatar,
         $website,
         $this->getUserId());
    $q = mysqli_query($db,$sql);
    print mysqli_error($db);
    # print "<!-- $sql" . "id" . $this->getUserId() . " -->";
   }

    function savePassword() {
        global $db;
        if (get_magic_quotes_gpc()) {
          $password    = stripslashes(mysqli_real_escape_string($db,$_POST['password1']));
        } else {
          $password    = mysqli_real_escape_string($db,$_POST['password1']);
        }
        $sql = sprintf("update rgbUsers set 
             userPassword     = password('%s')
             where userId = '%s'",
             $password,
             $this->getUserId());
        $q = mysqli_query($db,$sql);
        print mysqli_error($db);
    }

    function getUserLink($url,$text) {
       // return string with link to $url, showing $ text. Link
       // adjusted to contain $this as parameter where needed.
         return sprintf("<a href=\"$url?nick=%s\">$text</a>",$this->getUserNick());
    
    
     }
    function getUserEdit($name,$value) {
       return "<input type=\"text\" class=\"formInput\" name=\"$name\" size=\"30\" value=\"$value\">";
    }
} # end class



?>
