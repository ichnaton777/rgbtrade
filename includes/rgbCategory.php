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

  /**
  * Class for the (ad) categories.
  * Every category has a default English name to avoid later conflicts during translations.
  * For translations, this class will use separate tables for each translation...
  */
  
class rgbAdCategory  {
  var $categoryId;
  var $categoryParentId;
  var $categoryEnName; // english name
  var $categoryL10nName;  // l10n is localization, which is mostly translation. If unset, fallback to English
  var $categoryStatus;    // i.e. this users prefered language
  // available, unavailable

  function __construct() {
    $this->categoryId = 0;
    $this->categoryEnName = "";
    $this->categoryL10nName = ""; 
    $this->categoryStatus = "available"; 
    $this->categoryParentId = 1 ; // value is set to 0 when there is no parent, need a value in the select box.
    pc_debug("NEW rgbAdcategory  ",__FILE__,__LINE__);
    pc_debug("default parent is " . $this->categoryParentId ,__FILE__,__LINE__);
  }

  function getCategoryId() {
    return $this->categoryId;
  }

  function setCategoryId($id) {
    $this->categoryId = $id;
  }



  function getParentId() {
    pc_debug("getting parent :" . $this->categoryParentId ,__FILE__,__LINE__);
    // return $this->categoryParentId;
    return $this->categoryParentId;
  }

  function setParentId($id) {
    pc_debug("setting ParentId to $id",__FILE__,__LINE__);
    $this->categoryParentId = $id;
  }

  function setEnName($name) {
    $this->categoryEnName = $name;
  }
  function getEnName() {
    return $this->categoryEnName;
  }

  function setL10nName($name) {
    $this->categoryL10nName = $name;
  }

  function getL10nName() {
    return $this->categoryL10nName;
  }

  function getStatus() {
    return $this->categoryStatus;
  }
  function setStatus($status) {
    $this->categoryStatus = $status;
  }

  function insert($form,$user) {
    $db = $GLOBALS['db'];
    pc_debug("insert new category",__FILE__,__LINE__);
    $this->setEnName($form->GetInputValue("titleEn"));
    $this->setL10NName(mysqli_real_escape_string($db,$form->GetInputValue("titleL10N")));
    $this->setParentId(mysqli_real_escape_string($db,$_REQUEST['parentId']));
    $this->setStatus($form->GetCheckedRadio("catStatus"));
    pc_debug("parentId: ". $this->getParentId() ,__FILE__,__LINE__);
    
    $sql = sprintf("insert into rgbAdCategories (
                                adCategoryTitleEn,adCategoryTitleNl, adCategoryParentId,adCategoryStatus)  
                       values ( '%s',             '%s',              %s,                '%s')",
                         $this->getEnName(),$this->getL10NName(),$this->getParentId(), $this->getStatus() 
                   );
      pc_debug("mysqli insert cat $sql" , __FILE__,__LINE__);
      $q = mysqli_query($db,$sql);
      if (!mysqli_error($db)) {
        $this->setCategoryId = mysqli_insert_id();
        pc_debug("mysqli successfully inserted cat " . mysqli_error($db), __FILE__,__LINE__);
        return(T_("Category added"));
      } else {
        pc_debug("mysqli error inserting cat: " . mysqli_error($db), __FILE__,__LINE__);
        return(T_("Error: the category was not added."));
      }
  }

  function load() {
    $db = $GLOBALS['db'];
    $sql = sprintf("select adCategoryId, adCategoryTitleEn, adCategoryTitleNl, adCategoryParentId,
      adCategoryText, adCategoryStatus from rgbAdCategories 
      where adCategoryId = %s",
      $this->getCategoryId());
    $q=mysqli_query($db,$sql);
    if($result = mysqli_fetch_object($q)) {
      $this->setEnName($result->adCategoryTitleEn);
      $this->setL10NName($result->adCategoryTitleNl);
      $this->setStatus($result->adCategoryStatus);
      $this->setParentId($result->adCategoryParentId);
      pc_debug("** mysqli: $sql ",__FILE__,__LINE__);
      pc_debug("loaded from DB: category:" . $this->getCategoryId(), $this->getL10NName() ,__FILE__,__LINE__);
      return true;
    } else {
        return false;
    }

  }

  function save($form,$user) {
    $db = $GLOBALS['db'];
    $this->setCategoryId($form->getInputValue("catId"));
    $this->setEnName(mysqli_real_escape_string($db,$form->getInputValue("titleEn")));
    $this->setL10NName(mysqli_real_escape_string($db,$form->getInputValue("titleL10N")));
    // using $form for this implies living hell on earth.
    $this->setParentId(mysqli_real_escape_string($db,$_REQUEST['parentId']));
    pc_debug("--- saving category---catId=" . $this->getCategoryId() , __FILE__,__LINE__);
    pc_debug("parentId = " . $this->getParentId(), __FILE__,__LINE__);
    if($this->getParentId()== null || $this->getParentId() == "") {
      $this->setParentId(0);
    } 
    $this->setStatus(mysqli_real_escape_string($db,$_REQUEST['catStatus']));
    pc_debug("category new status = " . $this->getStatus(), __FILE__,__LINE__);
    pc_debug("about to save cat",__FILE__,__LINE__);
    $sql=sprintf("update rgbAdCategories set adCategoryTitleEn = '%s',
                                             adCategoryTitleNl = '%s',
                                             adCategoryParentId = %s,
                                             adCategoryStatus = '%s'
                                             where                       adCategoryId = %s",
                                             $this->getEnName(),
                                             $this->getL10NName(),
                                             $this->getParentId(),
                                             $this->getStatus(),
                                             $this->getCategoryId()
                                           );
    $q=mysqli_query($db,$sql);
    pc_debug("** mysqli: " . $sql . mysqli_error($db),__FILE__,__LINE__);
    if(mysqli_error($db)) {
        return(T_("The category has not been saved"));
    } else {
        return (sprintf(T_("The category has been saved. Please %s continue %s"), "<a href=\"categorylist.php\">", "</a>"));
    }

  }


}
function getGroupsCategoriesTree() {
              $ar = getGroupsByParent("1"); 
              $nar = array();
              foreach($ar as $id => $name)  {
                      $nar = $nar + array("$id"=>"$name");
                      $sub=getGroupsByParent($id);
                      foreach($sub as $sid => $sname)  {
                          if ($sid >1) {
                              $nar = $nar + array("$sid"=>"- $sname");
                          }
                  }
              }
              return $nar;
}

function getGroupsByParent($parentId) {
                 $db = $GLOBALS['db'];
                 $sql = sprintf("select rgbAdCategories.adCategoryId, adCategoryTitleEn, adCategoryTitleNl, adCategoryParentId  
                     from rgbAdCategories
                     where rgbAdCategories.adCategoryParentId = %s and adCategoryStatus='available'
                     order by adCategoryTitleNl",$parentId);
                 $q=mysqli_query($db,$sql);
                 pc_debug("**mysqli** " . $sql . mysqli_error($db),__FILE__,__LINE__);
                 $ar=array();
                 while ($result = mysqli_fetch_object($q)) {
                      $myId = $result->adCategoryId;
                      $myName = $result->adCategoryTitleNl;
                      $ar["$myId"] = "$myName";
                 }
      return $ar;
}
function getUsedGroupsByParent($parentId) {
  $db = $GLOBALS['db'];
  $sql = sprintf("select rgbAdCategories.adCategoryId, adCategoryTitleEn, adCategoryTitleNl, adCategoryParentId  
                     from rgbAdCategories, rgbAds 
                     where rgbAdCategories.adCategoryParentId = %s and (rgbAds.adGroupId  = rgbAdCategories.adCategoryId ) 
                     group by rgbAdCategories.adCategoryId having count(adId) > 0 order by rgbAdCategories.adCategoryTitleNl",$parentId);
                 $q=mysqli_query($db,$sql);
                 pc_debug("**mysqli** " . $sql . mysqli_error($db),__FILE__,__LINE__);
                 $ar=array();
                 while ($result = mysqli_fetch_object($q)) {
                      $myId = $result->adCategoryId;
                      $myName = $result->adCategoryTitleNl;
                      $ar["$myId"] = "$myName";
                 }
      return $ar;
}
      

function getUsedCategoriesByParent($parentId) {
                 $db = $GLOBALS['db'];
                 $sql = sprintf("select rgbAdCategories.adCategoryId, adCategoryTitleEn, adCategoryTitleNl, adCategoryParentId  
                     from rgbAdCategories, rgbAds 
                     where rgbAdCategories.adCategoryParentId = %s and (rgbAds.adCategoryId  = rgbAdCategories.adCategoryId ) 
                     group by rgbAdCategories.adCategoryId having count(adId) > 0",$parentId);
                 $q = mysqli_query($db,$sql);
                 pc_debug("**mysqli** " . $sql . mysqli_error($db),__FILE__,__LINE__);
                 $ar=array();
                 while ($result = mysqli_fetch_object($q)) {
                      $myId = $result->adCategoryId;
                      $myName = $result->adCategoryTitleNl;
                      $ar["$myId"] = "$myName";
                 }
      return $ar;
}

function getCategoriesByParent($parentId) {
                 $db = $GLOBALS['db'];
                 $sql = sprintf("select rgbAdCategories.adCategoryId, adCategoryTitleEn, adCategoryTitleNl, adCategoryParentId  
                     from rgbAdCategories
                     where rgbAdCategories.adCategoryParentId = %s order by adCategoryTitleNl ",$parentId);
                 $q = mysqli_query($db,$sql);
                 pc_debug("**mysqli** " . $sql . mysqli_error($db),__FILE__,__LINE__);
                 $ar=array();
                 while ($result = mysqli_fetch_object($q)) {
                      $myId = $result->adCategoryId;
                      $myName = $result->adCategoryTitleNl;
                      $ar["$myId"] = "$myName";
                 }
      return $ar;
}

  function getColourCatArrayNonEmpty() {
                 $db = $GLOBALS['db'];
                 pc_debug("cat array non empty " ,__FILE__,__LINE__);
                 $sql = sprintf("select rgbAdCategories.adCategoryId, adCategoryTitleEn, adCategoryTitleNl, adCategoryParentId  
                     from rgbAdCategories, rgbAds 
                     where (rgbAds.adCategoryId  = rgbAdCategories.adCategoryId or rgbAds.adGroupId= rgbAdCategories.adCategoryId ) 
                     group by rgbAdCategories.adCategoryId having count(adId) > 0");
                 $q = mysqli_query($db,$sql);
                 pc_debug("**mysqli** " . $sql . mysqli_error($db),__FILE__,__LINE__);
                 $ar=array();
                 while ($result = mysqli_fetch_object($q)) {
                      $myId = $result->adCategoryId;
                      $myName = $result->adCategoryTitleNl;
                      // pc_debug("category id $myId name $myName" , __FILE__,__LINE__);
                      $ar["$myId"] = "$myName";
                 }
      return $ar;
  }



  function getColourCatArray($colour="unset",$status="available",$parentId=-1) {
      // returns array of categories ordered by name
      // return array("0"=>"Geen"); (Geen means None)
      // use NL title here, dont care yet for english title.
      // status defaults to available when unset
      // parentId : if set, only select those with parentId $parentId
      // only parentId allowed if colour is set
      //
      //
      // As you can see, this awful function should be nicely redesigned...
      //
      //// big change: remove color
      //
      $db = $GLOBALS['db'];
      if($status=="unavailable") {
          pc_debug("cat array: unavailable ones" ,__FILE__,__LINE__);
          $sql = "select adCategoryId, adCategoryTitleEn, adCategoryTitleNl, adCategoryParentId
                          from rgbAdCategories where adCategoryStatus = '$status' 
                          and adCategoryId > 3
                          order by adCategoryTitleNl asc";
              $q = mysqli_query($db,$sql);
              pc_debug("**mysqli** " . $sql . mysqli_error($db),__FILE__,__LINE__);
              $ar=array();
              $ar["0"] = "Maak uw keuze";
              while ($result = mysqli_fetch_object($q)) {
                     $myId = $result->adCategoryId;
                     $myName = $result->adCategoryTitleNl;
                     // pc_debug("category id $myId name $myName" , __FILE__,__LINE__);
                     $ar["$myId"] = "$myName";
                     // $ar = array_merge($ar, array("$myId" => "$myName"));
               }
      } else {
          if($parentId >= 0) {
                 pc_debug("cat array: parent >= 0 " ,__FILE__,__LINE__);
              $sql = sprintf("select adCategoryId, adCategoryTitleEn, adCategoryTitleNl, adCategoryParentId
                              from rgbAdCategories where 
                               (adCategoryParentId = %s or adCategoryId  = %s)
                              order by adCategoryTitleNl asc", $parentId,$parentId);
              $q = mysqli_query($db,$sql);
              pc_debug("**mysqli** " . $sql . mysqli_error($db),__FILE__,__LINE__);
              $ar=array();
              // $ar["0"] = "Maak uw keuze";
              if (mysqli_error($db)) {
                  pc_debug("sql error: " . mysqli_error($db) ,__FILE__,__LINE__);
              } else if (mysqli_num_rows($q) > 0) {
                  while ($result = mysqli_fetch_object($q)) {
                         $myId = $result->adCategoryId;
                         $myName = $result->adCategoryTitleNl;
                         // pc_debug("category id $myId name $myName" , __FILE__,__LINE__);
                         $ar["$myId"] = "$myName";
                         // $ar = array_merge($ar, array("$myId" => "$myName"));
                 }
               }
          } else {
                 pc_debug("cat array: parent < 0 " ,__FILE__,__LINE__);
                      $sql = sprintf("select adCategoryId, adCategoryTitleEn, adCategoryTitleNl, adCategoryParentId
                                      from rgbAdCategories 
                                      order by adCategoryTitleNl asc");
                 $q = mysqli_query($db,$sql);
                 pc_debug("**mysqli** " . $sql . mysqli_error($db),__FILE__,__LINE__);
                 $ar=array();
                 // $ar["0"] = "Maak uw keuze";
                 while ($result = mysqli_fetch_object($q)) {
                      $myId = $result->adCategoryId;
                      $myName = $result->adCategoryTitleNl;
                       pc_debug("category id $myId name $myName" , __FILE__,__LINE__);
                      $ar["$myId"] = "$myName";
                      // $ar = array_merge($ar, array("$myId" => "$myName"));
                 }
          }
      }
      return $ar;
  }
?>
