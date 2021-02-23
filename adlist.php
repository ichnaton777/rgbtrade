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
  include("includes/rgbtop.php");
  include("includes/loggedin.php");
  include("includes/rgbAd.php");
  include("includes/rgbDimension.php");

  // we'll make some string parts depending on what comes in.
  // there'll be 3 queries (in each run, maximum, and in the code...):
  // 1: requests, get the categoeries only
  // 2: offers, get the categories only
  // 3: get the ads for offers and requests


  // change to filter per column: idfilter, nickfilter. Otherwise get crazy.
  //
  $bigfilter="";
  $catfilter_m="";
  $catfilter_s="";
  $filtervalue="";
  $filtername="";
  $groupfilter="";
  $orfilter=""; //offer request filter

  if(isset($_GET['or'])) {
      $orfilter= " and adOfferRequest = '" . mysqli_real_escape_string($db,$_GET['or']). "'";
  }





  if (isset($_GET['userId'])) {
    $idfilter = ' and  userId = '. mysqli_real_escape_string($db,$_GET['userId']);
  } else {
      $idfilter ="";
  }

  $geturl = "";
  if (isset($_GET['nick'])) {
    if($_GET['nick'] =="") {
      $nick = $_SESSION['userNick'];
    } else {
      $nick = mysqli_real_escape_string($db,$_GET["nick"]);
    }
    $nickfilter="  and userNick ='". $nick . "'";
    $geturl .= "&nick=$nick";
  } else {
      $nickfilter = "";
  }
  if(isset($_GET['resultpage'])) {
     $resultpage = mysqli_real_escape_string($db,$_GET['resultpage']);
  }
  if(isset($_GET['searchBox'])) {
    // main search facility, read out searchbOx from index.php and set the correct section if known (should be)
      $q = mysqli_real_escape_string($db,$_GET['searchBox']);
      $geturl .= "&searchBox=" . $_GET['searchBox'];

      if(isset($_GET['section'])) {
        $offerRequest = mysqli_real_escape_string($db,$_GET['section']);
      } else {
        $offerRequest = '%';
      }
      switch($offerRequest) {
        case "offers":
        case "offer":
        default:
          $filtervalue = "'offer'";
        break;
        case "request":
        case "requests":
          $filtervalue = "'request'";
          break;
      }
      $filtername = "adOfferRequest";
      $bigfilter = " AND (adTitle like '%$q%' or adText like  '%$q%')";
  }
  if(isset($_GET['adId'])) {
      // filter for sinlge (permalink) ad
      $q = mysqli_real_escape_string($db,$_GET['adId']);
       pc_debug("DB GET adid $q",__FILE__,__LINE__);
      $adidfilter= " and adId = $q";
  } else {
      $adidfilter = "";
  }

  // geen parameters: default terugvallen op meest recente:
  if(!isset($filtername)) {
      $filtername3 = "adStatus";
      $filtervalue3 = "'live'";
      $bigfilter = "";
  }


  if (isset($_GET['categoryid'])) {
      $geturl .= "&categoryid=" . mysqli_real_escape_string($db,$_GET['categoryid']);
       // filters with m for main sql, filters with s for subqueries, others a re for all.
      //
       $catfilter_m = " and GROUPS.adCategoryId = " .  mysqli_real_escape_string($db,$_GET['categoryid']);
       $catfilter_s = " and rgbAdCategories.adCategoryId = " .  mysqli_real_escape_string($db,$_GET['categoryid']);
      pc_debug("category param received, setting filters",__FILE__,__LINE__);
       // filter ads to this category
       // we also need a simpler join, to avoid empty selections. that will be $sqlmain
       $filtername="adCategoryId";
       $filtervalue = "='" . mysqli_real_escape_string($db,$_GET['categoryid']) . "'";
       $bigfilter = "";
       $groupfilter = " and adCategoryId = " .  mysqli_real_escape_string($db,$_GET['categoryid']);
       // almost $sqlmain="select distinct adId, adUserId, adStatus, adTitle, adText, adLastChange, adOfferRequest, adRedValue, adGreenValue, adBlueValue, adThumbImage,          adBigImage, rgbAds.adGroupId, rgbAds.adCategoryId, userNick,userCity ,           unix_timestamp(adLastChange) as adLastChange, unix_timestamp(userBirth) as userBirth, GROUPS.adCategoryTitleNl as grouptitle, GROUPS.adCategoryTitleNl as cattitle 
       // from rgbAds, rgbUsers ,  rgbAdCategories as GROUPS 
       // where rgbUsers.userId = rgbAds.adUserId   and adGroupId = GROUPS.adCategoryId  ";

     //   $sql_main_filter="";
       $sql_main_filter= "$idfilter $nickfilter $bigfilter $adidfilter $orfilter "; // rm: groupfilter
       $sqlmain="
           select distinct adId, adUserId, adStatus, adTitle, adText, adLastChange, adOfferRequest, adRedValue, adGreenValue, 
           adBlueValue, adThumbImage, adBigImage, rgbAds.adGroupId, rgbAds.adCategoryId as adCatId, userNick,userCity , 
           unix_timestamp(adLastChange) as adLastChange, unix_timestamp(userBirth) as userBirth, 
           GROUPS.adCategoryTitleNl as grouptitle, CATNAMES.adCategoryTitleNl as cattitle 
           from rgbAds, rgbUsers ,  rgbAdCategories as GROUPS , rgbAdCategories as CATNAMES
           where rgbUsers.userId = rgbAds.adUserId   and adGroupId = GROUPS.adCategoryId and 
           CATNAMES.adCategoryId = rgbAds.adCategoryId 
           $sql_main_filter and GROUPS.adCategoryId = " .  mysqli_real_escape_string($db,$_GET['categoryid']) . "

           UNION

           select distinct adId, adUserId, adStatus, adTitle, adText, adLastChange, adOfferRequest, adRedValue, adGreenValue, 
           adBlueValue, adThumbImage, adBigImage, rgbAds.adGroupId, rgbAds.adCategoryId as adCatId, userNick,userCity , 
           unix_timestamp(adLastChange) as adLastChange, unix_timestamp(userBirth) as userBirth,  
           GROUPNAMES.adCategoryTitleNl as grouptitle, CATEGORIES.adCategoryTitleNl as cattitle 
           from rgbAds, rgbUsers ,  rgbAdCategories as CATEGORIES, rgbAdCategories as GROUPNAMES
           WHERE rgbUsers.userId = rgbAds.adUserId   
           and   rgbAds.adCategoryId = CATEGORIES.adCategoryId and GROUPNAMES.adCategoryId = rgbAds.adGroupId
           $sql_main_filter  and CATEGORIES.adCategoryId = " .  mysqli_real_escape_string($db,$_GET['categoryid']) . "
          
          
           ";
       pc_debug("sqlmain large version: $sqlmain",__FILE__,__LINE__);

  } else {
      $sql_main_filter= "$idfilter $nickfilter $bigfilter $adidfilter $orfilter "; // rm: groupfilter
      $sqlmain="select distinct adId, adUserId, adStatus, adTitle, adText, adLastChange, adOfferRequest, adRedValue, adGreenValue, adBlueValue, adThumbImage,          adBigImage, rgbAds.adGroupId, rgbAds.adCategoryId as adCatId, userNick,userCity ,           unix_timestamp(adLastChange) as adLastChange, unix_timestamp(userBirth) as userBirth, GROUPS.adCategoryTitleNl as grouptitle, CATEGORIES.adCategoryTitleNl as cattitle from rgbAds, rgbUsers , rgbAdCategories as GROUPS, rgbAdCategories as CATEGORIES where rgbUsers.userId = rgbAds.adUserId and GROUPS.adCategoryId = rgbAds.adGroupId and  CATEGORIES.adCategoryId=rgbAds.adCategoryId $sql_main_filter";
   pc_debug("sqlmain was set to $sqlmain",__FILE__,__LINE__);



     pc_debug("DB ads: $sqlmain",__FILE__,__LINE__);
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title><?php print SYSTEM_NAME . "&nbsp;" . T_("Ads");?></title>
    <link rel="stylesheet" type="text/css" href="themes/petrol/stylesheet.css" />
    <link rel="shortcut icon" href="favicon.ico">

  <script language="Javascript">
  function confirmDelete(adId) {
      if (confirm("<?php print T_("Are you sure you want to delete this ad?");?>")) {
          window.location = "adDelete.php?adId=" + adId;
      } 
  }
      </script>

  </head>
  <body>
<div id="fullpage">
    <?php include('includes/topbox.php'); ?>

    <!-- end header part -->
  <? include('includes/sidebar.php'); ?>

   <!-- page contents -->
<div id="contents">
<? 
  # if a nickname is set show this user's menu entries
  $showUser = new rgbUser;
  if (isset($_GET['nick'])) {

     if(isset($user) && $user->getloggedin()) {
        // safe to show this link
        $contactlink = " | ". $showUser->getUserLink("contact.php",T_("Contact"));
     } else {
        $contactlink = "";
     }

     $showUser->setUserNick(mysqli_real_escape_string($db,stripslashes($_GET['nick'])));

     if($user->getloggedin() &&$user->getUserNick() <> $showUser->getUserNick()) {
        $tlink = $showUser->getUserLink("transfer.php",T_("New Transfer")) . " | " ;
     } else {
        $tlink = "";
     } 
     $menuBox = new resultbox("menu","menu",4,"petrol","#ffffff","widebox",604);
     $menuBox ->setTitle($showUser->getUserNick() . " " .
       $showUser->getUserLink("profile.php",T_("Profile")) . " | " .
       $showUser->getUserLink("transferlist.php",T_("Transfers")) . " | " .
       $tlink . 
       $showUser->getUserLink("adlist.php",T_("Ads")) . 
       $contactlink
     );
     $menuBox->titleBox();
   }
?>

       <div id="resultbox_high">
<? // the place for query 1: request, categories overview

               $colortxt['red']   = T_("Red");
               $colortxt['green'] = T_("Green");
               $colortxt['blue']  = T_("Blue");

      print '<table><tr><td width="280" valign="top">
          <h1 id="resultpagetitle"><img src="images/offer_star_24.png" align="left" alt="Offer" title="Offer" hspace="5">' . T_("Offers Found"). 
          '</h1>';
               $sql_1 = "select count(distinct adId), rgbAds.adGroupId, rgbAdCategories.adCategoryTitleNl,  
                   rgbAds.adCategoryId, adOfferRequest 
                   from rgbAds, rgbUsers , rgbAdCategories 
                   where rgbUsers.userId = rgbAds.adUserId and 
                    rgbAdCategories.adCategoryId=rgbAds.adGroupId     and adOfferRequest = 'offer'
                   $bigfilter $idfilter $nickfilter $catfilter_s $adidfilter $orfilter
                   group by rgbAdCategories.adCategoryId order by rgbAdCategories.adCategoryTitleNl";
    
      // dont need fancy multipage requests here, just go straight on.
      $q_1 = mysqli_query($db,$sql_1);
      if(mysqli_error($db)) {
          pc_debug("DB mysql error in sql_1: " . mysqli_error($db,) . $sql_1,__FILE__,__LINE__);
      } else {
          pc_debug("DB no error in sql_1 " . $sql_1,__FILE__,__LINE__);
          if(mysqli_num_rows($q_1) == 0 ) {
              // print "0 advertenties gevonden : $sql_1";
          } else {
             pc_debug(" DB sql_1 num_rows" . mysqli_num_rows($q_1) ,  __FILE__,__LINE__);
          }

          print "<ul>";
          while($res1 = mysqli_fetch_array($q_1)) {
               $count     = $res1[0];
               $id        = $res1[1];
               $name      = $res1[2];
               pc_debug("DB id = $id, name = $name",__FILE__,__LINE__);
               $txt = "<li class=\"catsum\"><a href=\"adlist.php?or=offer&categoryid=%s&$geturl\"> " . T_("Group") . ": %s (%s)</a></li>";
               $stxt = sprintf("$txt", $id,  $name, $count);
               print $stxt;
          }
      }
?>
       </ul></td>
       <td valign="top">
<? // the place for query 2: offer, categories overview
print '<h1 id="resultpagetitle"><img src="images/request_star_24.png" align="left" alt="Requests" title="Requests" hspace="5">' . 
T_("Requests Found") . '</h1>';
      $sql_2 = "select count(rgbAdCategories.adCategoryId), rgbAds.adGroupId,  adCategoryTitleNl,  
                rgbAds.adUserId, rgbUsers.userId, rgbUsers.userNick
      from rgbAds, rgbAdCategories , rgbUsers
      where rgbAdCategories.adCategoryId = adGroupId and rgbAds.adUserId = rgbUsers.userId and adOfferRequest = 'request'  $bigfilter $idfilter $nickfilter $catfilter_s $adidfilter $orfilter
      group by rgbAdCategories.adCategoryId order by adCategoryTitleNl;";
    
      // dont need fancy multipage requests here, just go straight on.
      $q_2 = mysqli_query($db,$sql_2);
      if(mysqli_error($db)) {
          pc_debug("DB mysql error in sql_2: " . mysqli_error($db) . $sql_2,__FILE__,__LINE__);
      } else {
          pc_debug("DB no error in sql_2 " . $sql_2,__FILE__,__LINE__);
      }
          pc_debug("DB no error in sql_2 " . $sql_2,__FILE__,__LINE__);
          if(mysqli_num_rows($q_2) == 0 ) {
              // print "0 advertenties gevonden";
          }

          print "<ul>";
      while($res2 = mysqli_fetch_array($q_2)) {
          $count     = $res2['count(rgbAdCategories.adCategoryId)'];
          $id        = $res2[1];
          $name      = $res2[2];
          // $colour    = $colortxt[$res2[3]];
          pc_debug("DB id = $id, name = $name",__FILE__,__LINE__);

          $txt = "<li class=\"catsum\"><a href=\"adlist.php?or=request&categoryid=%s$geturl\"> " . T_("Group") . ":  %s (%s)</a></li>";
          $stxt = sprintf("$txt", $id,   $name, $count);
          print $stxt;
      }
?>
       </ul></td></tr></table>

       <table      bgcolor="#ffffff"  width="604px" class="wdatabox2" id="transferbox"  CELLPADDING="0" CELLSPACING="0" >

       <!-- edge row -->
       <!-- 4 cols : image  (100px)
                     text   (280     )
                     rgb     (40
                     location (70
                     == 548 -->

       <tr><td width="16px"><img src="themes/petrol/images/tl_16w.png">
           <td colspan="4" width="570px" background="themes/petrol/images/upper_20w.png"  height="16"></td>
           <td><img src="themes/petrol/images/tr_16w.png">
       </tr>
       <!-- headings row -->
      

<?php // MAIN SQL ADLIST
      // table heading
      print '<tr><td><img src="themes/petrol/images/left_edgew.png" width="16px" height="100%"></td><th class="wdatalabel" width="100px">';
      print T_("Photo");
      print '</th> <th  width="280px" class="wdatalabel">';
      print T_("Offer/Request");
      print '</th><th class="wdatalabel" width="40px">RGB</th> <th class="wdatalabel">';
      print  T_("Advertiser");
      print '</th><td background="themes/petrol/images/right_edgew.png" width="16px" height="100%"></td></tr>';
      //
      // data row 

      //
          //$q=mysql_query($sql);
          /*print mysql_error();
          if (mysql_num_rows($q) == 0) {
            print '<tr><td  background="themes/petrol/images/left_edgew.png" width="16px" height="130px"></td>';
            print '<tr><td>';
            print T_("No results");
            print '</td></tr>';

          } else {
            */
            $pageSize = 10;
            $pagedResults = new MySQLPagedResultSet($sqlmain,$pageSize,$db);
            if(mysqli_error($db))  {
                pc_debug("mysql error in sqlmain:## $sqlmain ## " . mysqli_error($db),__FILE__,__LINE__);
            } else {
                pc_debug("no mysql error in sqlmain : ## $sqlmain ##" . mysqli_error($db),__FILE__,__LINE__);
            }
            while ($res = $pagedResults->fetchObject()) {
              $myAd = new rgbAd();
              $myAd->setAdId($res->adId);
              $myAd->setUserId($res->adUserId);
              $myAd->setAdStatus($res->adStatus);
              $myAd->setAdTitle($res->adTitle);
              if ((int)$myAd->getUserId() == (int)$user->getUserId() ) {
                // this ad is mine, show me an edit link
                $adTitle = sprintf('<a class="wdata" href="ad.php?nextAction=edit&adId=%s">%s</a>',$myAd->getAdId(), $myAd->getAdTitle() );
                // I know my own city, here is the delete link
                // $city = '<a  class="wdata" href="ad.php?nextAction=delete&confirm=false&adId=' . $myAd->getAdId(). '">Verwijder Advertentie</a>';
                $city = '<a  class="wdata" onClick="confirmDelete(' . $myAd->getAdId(). ')">' . T_("Delete this Ad"). '</a>';
              } else {
                $adTitle = $myAd->getAdTitle();
                $city    = $res->userCity;
              }
              pc_debug("DB this ad is " . $myAd->getUserId() . " and user is " . $user->getUserId(),__FILE__,__LINE__);

              $myAd->setAdText(nl2br($res->adText));
              $myAd->setAdOfferRequest($res->adOfferRequest);
              $myAd->setThumbImage($res->adThumbImage);
              $myAd->setBigImage($res->adBigImage);
              // pc_debug("thumb : " . var_dump($myAd),__FILE__,__LINE__);
              $myAd->adLastChange  = date("d M y",$res->adLastChange);
              $myAd->adRedValue  ->setValue($res->adRedValue);
              $myAd->adGreenValue->setValue($res->adGreenValue);
              $myAd->adBlueValue ->setValue($res->adBlueValue);
              $redRounded       = $myAd->adRedValue->getRoundedValue();
              $greenRounded     = $myAd->adGreenValue->getRoundedValue();
              $blueRounded      = $myAd->adBlueValue->getRoundedValue();
              $red8             = $myAd->adRedValue->get8th();
              $green8           = $myAd->adGreenValue->get8th();
              $blue8            = $myAd->adBlueValue->get8th();
              $nick             = $res->userNick;
              $grouptitle       = $res->grouptitle;
              $cattitle         = $res->cattitle;
              $myAd->setUserNick($res->userNick);
              // $birth            = date("d M y",$res->userBirth);
              $orimage          = $myAd->getAdOfferRequestImage();
              $or               = $myAd->getAdOfferRequest();
              $groupid          = $res->adGroupId;
              $catid            = $res->adCatId;
              if($or=="offer") { 
                  $ortxt = T_("Offered:");
              } else {
                  $ortxt = T_("Requested:");
              }
              $thumb            = $myAd->getThumbImage("html");
              $big              = $myAd->getBigImage("path");
              pc_debug("DB big image =" . $big,__FILE__,__LINE__);

              print<<<END_LOOP
       <tr><td height="1" bgcolor="#008080" colspan=6></td></tr>
       <!-- start 1st ad -->
       <tr><td  background="themes/petrol/images/left_edgew.png" width="16px" ></td>
       <td class="wdata"><a href="$big">$thumb</a></td>
       <td class="wdata">
           <table>
                    <tr><td class="wdatalabel"><a href="adlist.php?categoryid=$groupid">$grouptitle</a> - 
                                               <a href="adlist.php?categoryid=$catid">$cattitle</a></td></tr> 
                    <tr><td class="wdatalabel">$ortxt <b>$adTitle</b>
                  </td></tr>
                  <td>$myAd->adText</td>
            </table>
                  <td valign="top">
                      <table valign="top">
                      <tr class="r"><td class="f">R</td></td><td width="60px">$redRounded</td><td class="f">$red8</td></tr>
                            <tr class="g"><td class="f">G</td></td><td>$greenRounded</td><td class="f">$green8</td></tr>
                            <tr class="b"><td class="f">B</td></td><td>$blueRounded</td><td class="f">$blue8</small></td></tr>
                     </table>
                     </td>
       <td class="wdatalabel">
       <table><tr><td><a  class="wdata" href="profile.php?nick=$nick">$nick</a></td></tr>
                <tr><td>$city</td></tr>
END_LOOP;
          if ((int)$myAd->getUserId() != (int)$user->getUserId() ) {
            print '<tr><td valign="middle">' . T_('Ad'). ':<a  class="wdata" href="adlist.php?adId=' . $myAd->getAdId() . '">'. $myAd->getAdId() . '</a></td></tr>';
            //print '<tr><td><img src="images/baby_16.png" align="left" hspace="2" alt="Sinds" title="Deelnemer Sinds">' . $birth . '</td></tr>'; 
          }
              print ' </table>
       </td>
       <td background="themes/petrol/images/right_edgew.png" width="16px" ></td>
       </tr>
       <!-- end repeating code -->
       ';
          }
        // }
?>



       <tr><td  background="themes/petrol/images/left_edgew.png" width="16px" height="100%"></td><th colspan="1"></th><th valign="bottom"  colspan ="2" class="resultPageNav">
       
      <?  print $pagedResults->getPageNav($geturl); ?> </th></th><th ></th></th><td background="themes/petrol/images/right_edgew.png" width="16px" height="100%"></td></tr>
       <!-- edge row -->
       <tr><td width="16px" ><img src="themes/petrol/images/bl_16w.png">
           <td colspan="4" width="570px" background="themes/petrol/images/lower_20w.png"  height="16"></td>
           <td  width="16px"><img src="themes/petrol/images/br_16w.png">
       </tr>
       </table>
       </div>
    </div>
</div>
  </body>
</html>


