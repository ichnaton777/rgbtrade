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
  include("includes/forms.php");             // by mlemos
  include("includes/rgbDimension.php");
  include("includes/rgbAd.php");      
  $user->loadUser();
  $form = new form_class; 

  // case of an edit ad, load from database before needing the values, setting form inputs
   // new: present empty form
   // add: saving the new form, display OK message
   // edit: present exisitng add for edit
   // save: saving edited exisitng ad

  if(isset($_REQUEST["nextAction"])){
      $myAction = $_REQUEST["nextAction"];
  } else {
      $myAction = "none";
  }
  pc_debug("DB ad: myAction= $myAction", __FILE__,__LINE__);
  //print_r($_REQUEST);

  switch($myAction) {
  case "edit":
      if(isset($_GET['adId'])) {
          pc_debug("DB ad to load ", __FILE__,__LINE__);
          $myAd = new rgbAd();
          $myAd->setAdId(mysqli_real_escape_string($db,$_GET['adId']));
          $myAd->load();
          $postaction="edit";
          $form->NAME = "ad";
          pc_debug("DB ad loaded:$postaction", __FILE__,__LINE__);
      } else {
          pc_debug("DB no ad to edit",__FILE__,__LINE__);
      }
   break;
   case "new":
     // present empty form
       $myAd = new rgbAd();
       $postaction="new";
       $form->NAME = "ad";
       pc_debug("DB ad adding: postaction = $postaction", __FILE__,__LINE__);
       pc_debug("DB user   :" . $user->getUserNick(), __FILE__,__LINE__);
       /* dont need this crap no more
       $myAd->setAdGroupId(2);
       $myAd->setAdCategoryId(3);
        */
   break;
   case "add":
       $myAd = new rgbAd();
       $postaction="add";
       // need to pick these up to overwrite the defaults before the form is built
       $myAd->setAdGroupId(mysqli_real_escape_string($db,$_POST['adGroup']));
       $myAd->setAdCategoryId(mysqli_real_escape_string($db,$_POST['adCategory']));
       pc_debug("DB add ! ",__FILE__,__LINE__);
   break;
   case "save":
       $myAd = new rgbAd();
       $postaction="save";
       $myAd->setAdId(mysqli_real_escape_string($db,$_POST['adId']));
       $form->NAME = "ad";
       // lets see who owns this ad ?
       $myAd->load(); // need to get current userid
       // here check my ad is mine 
       if ($myAd->getUserId() == $user->getUserId() ) {
         pc_debug("DB I'm the owner!",__FILE__,__LINE__);
       } else {
           pc_debug("DB Hey, I'm NOT the owner!",__FILE__,__LINE__);
           $user->setloggedoff();
           header("location:error.php?error=login&error=notyourad");
       }
       pc_debug("DB ad to save :$postaction", __FILE__,__LINE__);
       $myAd->LoadForm($form); // get submitted values in Ad object. need them here.
    break;
    case "delete":
        exit;
   break;
   default:
         // when shall we run this ? never!
         pc_debug("DB impossible case",__FILE__,__LINE__);
         print "exit";
         //phpinfo();
         exit;
   }



   if( ($postaction!= "new" && $postaction!= "add") && ( $myAd->getUserId() != $user->getUserId() || !$user->getLoggedIn())) {
       // can't be here in any case, visitor view only in adlist, never in ad.
       $user->setloggedoff();
       pc_debug("DB not my ad!" . $myAd->getUserId() ."=" . $user->getUserId() ,__FILE__,__LINE__);
       header("location:error.php?error=login");
   } else {
       pc_debug("DB my ad!" . $myAd->getUserId() ."=" . $user->getUserId() ,__FILE__,__LINE__);
   }


  // start off with the form

  $form->METHOD = "POST";
  $form->ENCTYPE="multipart/form-data";
  $form->debug="trigger_error";
  $form->ResubmitConfirmMessage= T_("Are you sure you want to do this two times?");
  $form->OutputPasswordValues=0;
  $form->OptionsSeparator="<br />\n";
  $form->ShowAllErrors=1;
  $form->InvalidCLASS='invalid';
  $form->ErrorMessagePrefix="- ";
  $form->ErrorMessageSuffix="";
  $form->ACTION="ad.php";
    

  // radio button "Offer"
    $form->AddInput(array(
         "TYPE"=>"radio",
         "NAME"=>"adOfferRequest",
         "VALUE"=>"offer",
         "ID"=>"offer",
         "LABEL"=>T_("Offer"),
         "LabelCLASS"=>"hordata",
         "CLASS"=>"formInput",
         "ACCESSKEY"=>"o",
         "ReadOnlyMark"=>"[X]"
    ));

  // radio button "Request"
    $form->AddInput(array(
         "TYPE"=>"radio",
         "NAME"=>"adOfferRequest",
         "VALUE"=>"request",
         "ID"=>"request",
         "LABEL"=>T_("Request"),
         "ACCESSKEY"=>"q",
         "CLASS"=>"formInput",
         "LabelCLASS"=>"hordata",
         "ReadOnlyMark"=>"[X]"
       ));

       // set value for adOfferRequest radios, if any

       if ($myAd->getAdOfferRequest() == "request") {
           $form->SetCheckedState('request', 'request');
           pc_debug("DB checked request",__FILE__,__LINE__);

       } else if ($myAd->getAdOfferRequest() == "offer") {
           $form->SetCheckedState('offer', 'offer');
           pc_debug("DB checked offer",__FILE__,__LINE__);
       } else {
           pc_debug("DB false checked " . $myAd->getAdOfferRequest(),__FILE__,__LINE__);
       }

       $form->AddInput(array(
         "TYPE"=>"text",
         "NAME"=>"adTitle",
         "VALUE"=>$myAd->getAdTitle(),
         "ID"=>"adTitle",
         "LABEL"=>T_("Title"),
         "ACCESSKEY"=>"t",
         "CLASS"=>"formInput",
         "LabelCLASS"=>"hordatalabel",
         "MAXSIZE"=>"250",
         "SIZE"=>"30",
          "ValidateMinimumLength"=>"5",
          "ValidateMinimumLengthErrorMessage"=>"De omschrijving heeft tenminste 5 tekens."
         ));





  // text input Red Value
       $form->AddInput(array(
         "TYPE"=>"text",
         "NAME"=>"adRedValue",
         "VALUE"=>$myAd->adRedValue->getRoundedValue(),
         "ID"=>"adRedValue",
         "LABEL"=>T_("Red"),
         "CLASS"=>"formInput",
         "LabelCLASS"=>"bred",
         "SIZE"=>"6",
         "ValidateAsInteger"=>1,
         "ValidateAsIntegerErrorMessage"=>"The value for Red can only be an Integer. For the fractions, please use one
         of the offered options such as 1/2, 1/4 etc",
         ));
         
  // text input Green Value
       $form->AddInput(array(
         "TYPE"=>"text",
         "NAME"=>"adGreenValue",
         "VALUE"=>$myAd->adGreenValue->getRoundedValue(),
         "ID"=>"adGreenValue",
         "LABEL"=>T_("Green"),
         "CLASS"=>"formInput",
         "LabelCLASS"=>"bgreen",
         "SIZE"=>"6",
         "ValidateAsInteger"=>1,
         "ValidateAsIntegerErrorMessage"=>"The value for Green can only be an Integer. For the fractions, please use one
         of the offered options such as 1/2, 1/4 etc",
         ));

  // text input blue value
       $form->AddInput(array(
         "TYPE"=>"text",
         "NAME"=>"adBlueValue",
         "VALUE"=>$myAd->adBlueValue->getRoundedValue(),
         "ID"=>"adBlueValue",
         "LABEL"=>T_("Blue"),
         "CLASS"=>"formInput",
         "LabelCLASS"=>"bblue",
         "SIZE"=>"6",
         "ValidateAsInteger"=>1,
         "ValidateAsIntegerErrorMessage"=>"The value for Red can only be an Integer. For the fractions, please use one
         of the offered options such as 1/2, 1/4 etc",
         ));

         // pc_debug("red=".$myAd->adGreenValue->get8th(), __FILE__,__LINE__);


  //   select input red 8th
        $form->AddInput(array(
          "TYPE"=>"select",
          "NAME"=>"adRed8Value",
          "ID"=>"adRed8Value",
          "VALUE"=>$myAd->adRedValue->get8th(),
          "SIZE"=>1,
          "OPTIONS"=>array(
            "0/8"=>"0",
            "1/8"=>"1/8",
            "2/8"=>"2/8",
            "3/8"=>"3/8",
            "4/8"=>"4/8",
            "5/8"=>"5/8",
            "6/8"=>"6/8",
            "7/8"=>"7/8"
          ),
          "ValidateAsDifferentFromText"=>"pick",
          "ValidateAsDifferentFromTextErrorMessage"=>
          "Pick one of the offered options",
          "ValidationErrorMessage"=>"You did not pick one of the offered options",
          "LABEL"=>T_("Red")."/8",
          "ACCESSKEY"=>",",
          "CLASS"=>"formInput",
         ));
          // pc_debug("red8:". $myAd->adRedValue->get8th(),__FILE__,__LINE__);

    //   select input green 8th
        $form->AddInput(array(
          "TYPE"=>"select",
          "NAME"=>"adGreen8Value",
          "ID"=>"adGreen8Value",
          "VALUE"=>$myAd->adGreenValue->get8th(),
          "SIZE"=>1,
          "OPTIONS"=>array(
            "0/8"=>"0",
            "1/8"=>"1/8",
            "2/8"=>"2/8",
            "3/8"=>"3/8",
            "4/8"=>"4/8",
            "5/8"=>"5/8",
            "6/8"=>"6/8",
            "7/8"=>"7/8"
          ),
          "ValidateAsDifferentFromText"=>"pick",
          "ValidateAsDifferentFromTextErrorMessage"=>
          "Pick one of the offered options",
          "ValidationErrorMessage"=>"You did not pick one of the offered options",
          "LABEL"=>T_("Green")."/8",
          "ACCESSKEY"=>",",
          "CLASS"=>"formInput",
         ));


       

   //   select input blue 8th
        $form->AddInput(array(
          "TYPE"=>"select",
          "NAME"=>"adBlue8Value",
          "ID"=>"adBlue8Value",
          "VALUE"=>$myAd->adBlueValue->get8th(),
          "SIZE"=>1,
          "OPTIONS"=>array(
            "0/8"=>"0",
            "1/8"=>"1/8",
            "2/8"=>"2/8",
            "3/8"=>"3/8",
            "4/8"=>"4/8",
            "5/8"=>"5/8",
            "6/8"=>"6/8",
            "7/8"=>"7/8"
          ),
          "ValidateAsDifferentFromText"=>"pick",
          "ValidateAsDifferentFromTextErrorMessage"=>
          "Pick one of the offered options",
          "ValidationErrorMessage"=>"You did not pick one of the offered options",
          "LABEL"=>T_("Blue")."/8",
          "ACCESSKEY"=>",",
          "CLASS"=>"formInput",
         ));

       if (defined('CATEGORY_EDIT') && CATEGORY_EDIT) {
         $grouplabel = sprintf(T_("Group %s[change]%s"),"<a href=\"categorylist.php\">","</a>");
         pc_debug("DB XX grouplabel = $grouplabel",__FILE__,__LINE__);
       } else {
         $grouplabel = T_("Group");
         pc_debug("DB YY grouplabel = $grouplabel",__FILE__,__LINE__);
       }
       pc_debug("DB grouplabel = $grouplabel",__FILE__,__LINE__);
       
         
         
       if($myAd->getAdGroupId() <=0) {
           $myAd->setAdGroupId(mysqli_real_escape_string($db,$_REQUEST['adGroup']));
       }
       if($myAd->getAdCategoryId() <=0) {
           $myAd->setAdCategoryId(mysqli_real_escape_string($db,$_REQUEST['adCategory']));
       }
         // better set too much possible values than get into a impossible case later in the show
         $cats = getGroupsByParent(1);
         //$cats = getColourCatArray("red",'available',-1);
         // var_dump($cats);

         pc_debug("setting adGroup: groupId: " . $myAd->getAdGroupId(), __FILE__,__LINE__);
         $error=$form->AddInput(array(
           "TYPE"=>"select",
           "NAME"=>"adGroup",
           "ID"=>"adGroup",
           // "VALUE"=>$myAd->getAdGroupId(),
           // ERROR, set it dynamically:
           "VALUE"=>$myAd->getAdGroupId(),
           //"VALUE"=>1027,
           "OPTIONS"=>$cats,
           "ValidateAsDifferentFromText"=>"pick",
          "ValidateAsDifferentFromTextErrorMessage"=>
          "Pick the credit card type or set to Unknown if you do not know the type.",
          "ValidationErrorMessage"=>"It was not specified a valid credit card type.",
          "LABEL"=>$grouplabel,
          "ACCESSKEY"=>"P",
          "CLASS"=>"formInput",
          "ONCHANGE"=>"getSubCategoryList(this)"
         ));
         if($error) {
             pc_debug("Form addinput adGroup error: $error",__FILE__,__LINE__);
         }

         $groups = getGroupsByParent($myAd->getAdGroupId());

         $form->AddInput(array(
           "TYPE"=>"select",
           "NAME"=>"adCategory",
           "ID"=>"adCategory",
            "VALUE"=>$myAd->getAdCategoryId(),
           // ERROR, set it dynamically:
           // "VALUE"=>0,
           "OPTIONS"=>$groups,
           "ValidateAsDifferentFromText"=>"pick",
          "ValidateAsDifferentFromTextErrorMessage"=>
          "Pick the credit card type or set to Unknown if you do not know the type.",
          "ValidationErrorMessage"=>"It was not specified a valid credit card type.",
          "LABEL"=>T_("Category"),
          "ACCESSKEY"=>"C",
          "CLASS"=>"formInput",
         ));
         pc_debug("DB try to set category: " . $myAd->getAdCategoryId() ,__FILE__,__LINE__);
         // echo "cats=";
         // var_dump($cats);

         $form->AddInput(array(
           "TYPE"=>"textarea",
           "NAME"=>"adText",
           "ID"=>"adText",
           "VALUE"=>$myAd->getAdText(),
           "ValidateAsNonEmpty"=>1,
           "ValidateAsNonEmptyErrorMessage"=>"U heeft geen advertentie tekst opgegeven.",
          "LABEL"=>T_("Description"),
          "ACCESSKEY"=>"C",
          "CLASS"=>"formInput",
          "ROWS"=>10,
          "COLS"=>25 //,
          // "ValidateMinimumLength"=>"10",
          // "ValidateMinimumLengthErrorMessage"=>"De omschrijving heeft tenminste 10 tekens."
         ));

         $form->AddInput(array(
           "TYPE"=>"text",
           "NAME"=>"ccode",
           "ID"=>"ccode",
           "VALUE"=>"",
           "SIZE"=>5,
           "MAXISE"=>5,
           "LABEL"=>T_("Security Code"),
           "CLASS"=>"formInput"
         ));
    $form->AddInput(array(
         "TYPE"=>"file",
         "NAME"=>"uploadFile",
         "ID"=>"uploadFile",
         "ACCEPT"=>"image/gif",
         "LABEL"=>T_("Photo"),
          "SIZE"=>"15",
          "CLASS"=>"formInput"
         ));


        // NEW FLOW

  $form->LoadInputValues($form->WasSubmitted("adText"));
	$verify=array();

  /*
  print "here";
  if($form->WasSubmitted("action")&& $form->getInputValue("action") == "save")
	{
    $postaction="save";
		if(($error_message=$form->Validate($verify))=="")
		{
			$doit=$postaction;
      pc_debug("verified OK, doit is now $postaction", __FILE__,__LINE__);
		}
		else
		{
			$doit=0;
			$error_message=nl2br(HtmlSpecialChars($error_message));
		}
	}
	else
	{
		$error_message="";
		$doit=0;
	}
  print "2here2";
  */



      pc_debug("DB to switch : postaction=$postaction", __FILE__,__LINE__);
     
   // new: present empty form
   // add: saving the new form
   // edit: present exisitng add for edit
   // save: saving edited exisitng ad
   

  switch($postaction){
   case "new":
  	  $form->ReadOnly=0;
      $form->AddInput(array(
         "TYPE"=>"hidden",
         "NAME"=>"nextAction",
         "VALUE"=>"add"
       ));
       // used as dummy
      $form->AddInput(array(
         "TYPE"=>"hidden",
         "NAME"=>"adId",
         "VALUE"=>""
       ));
      $form->AddInput(array(
         "TYPE"=>"submit",
         "NAME"=>"submit",
         "VALUE"=>"Save"
       ));
      
      
      break;
  case "add" :
  	  $form->ReadOnly=1;
      $myAd->saveThumb();
      $inserted_id = $myAd->insert($form,$user);
      pc_debug("DB inserted id = $inserted_id ",__FILE__,__LINE__);
      $myAd->saveThumb();

      $form->AddInput(array(
         "TYPE"=>"hidden",
         "NAME"=>"adId",
         "VALUE"=>""
       ));
      $form->AddInput(array(
         "TYPE"=>"hidden",
         "NAME"=>"nextAction",
         "VALUE"=>"save"
       ));
      $form->AddInput(array(
         "TYPE"=>"submit",
         "NAME"=>"submit",
         "VALUE"=>T_("Save")
       ));
      pc_debug("DB save-add", __FILE__,__LINE__);
      break;
   case "edit":
  	  $form->ReadOnly=0;
      pc_debug("DB edit-view", __FILE__,__LINE__);
       $form->AddInput(array(
         "TYPE"=>"hidden",
         "NAME"=>"nextAction",
         "VALUE"=>"save"
       ));
      $form->AddInput(array(
         "TYPE"=>"hidden",
         "NAME"=>"adId",
         "VALUE"=>$myAd->getAdId(),
         "ValidateAsInteger"=>1,
         "DiscardInvalidValues"=>1
       ));
      $form->AddInput(array(
         "TYPE"=>"submit",
         "NAME"=>"submit",
         "VALUE"=>T_("Save")
       ));

      //
      /* do we still need this crap ?
      $cats = getColourCatArray("red",'available',-1);
      // print_r($cats);
      $form->setSelectOptions("adGroup",$cats,array($myAd->getAdGroupId()));
      pc_debug("DB  groupId = " . $myAd->getAdGroupId(),__FILE__,__LINE__);
      $cats2 = getColourCatArray("red",'available',-1);
      $form->setSelectOptions("adCategory",$cats2,array($myAd->getAdCategoryId()));
      pc_debug("DB category  = " . $myAd->getAdCategoryId(),__FILE__,__LINE__);
       */


      $display = true;

      break;
   case "save":
  	  $form->ReadOnly=1;
      pc_debug("DB saving edit", __FILE__,__LINE__);
       $form->AddInput(array(
         "TYPE"=>"hidden",
         "NAME"=>"nextAction",
         "VALUE"=>"view"
       ));
       $form->AddInput(array(
         "TYPE"=>"hidden",
         "NAME"=>"adId",
         "VALUE"=>$myAd->getAdId()
       ));
      $form->AddInput(array(
         "TYPE"=>"submit",
         "NAME"=>"submit",
         "VALUE"=>"Opslaan"
       ));

      //$myAd->setAdId($form->getInputValue('adId'));
      pc_debug("DB adId is now:". $myAd->getAdId(), __FILE__,__LINE__);
      $myAd->LoadForm($form); // get submitted values in Ad object. need them here.

      $cats = getColourCatArray("red");
      // $form->setSelectOptions("adGroup",$cats,array($myAd->getAdGroupId()));
      // $form->loadInputValues();
      // pc_debug("DB groupId = " . $myAd->getAdGroupId(),__FILE__,__LINE__);
      pc_debug("groupId = " . $form->getInputValue("adGroup"),__FILE__,__LINE__);
      $cats2 = getColourCatArray("",'available',$myAd->getAdGroupId());
      // $form->setSelectOptions("adCategory",$cats2,array($myAd->getAdCategoryId()));
      //$form->setSelectOptions("adCategory",$cats,0);

      $myAd->saveThumb();
      if($myAd->save($form,$user) ) {
          $edit_saved = true;
      } else {
          print "Opslaan Nok";
      }
      $display = false;
      break;

      case "delete":
          /* removed */
      break;

    default:
        pc_debug("DB ad doit: $doit", __FILE__,__LINE__);
		    if(strlen($error_message))
		     {
			    Reset($verify);
			    $focus=Key($verify);
          pc_debug("DB ad error message: $error_message", __FILE__,__LINE__);
	    	}
		    else
	    	{
          // $myAd->save($form,$user);
			    $focus='adTitle';
	    	}
		     $form->ConnectFormToInput($focus, 'ONLOAD', 'Focus', array());
         break;
  }
  
  // klopt niet, worst nu aangeroepen bij edit!
  // if($form->WasSubmitted("action")&& $form->getInputValue("action") == "save")
  if ($postaction =="save" || $postaction == "add")
	{
    //$postaction="save";
    pc_debug("DB save here?",__FILE__,__LINE__);
		if(($error_message=$form->Validate($verify))=="")
		{
			$doit=$postaction;
      pc_debug("DB verified OK, doit is now $postaction", __FILE__,__LINE__);
		}
		else
		{
			$doit=0;
			$error_message=nl2br(HtmlSpecialChars($error_message));
		}
	}
	else
	{
		$error_message="";
		$doit=0;
	}
  

	$onload = HtmlSpecialChars($form->PageLoad());



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
  <head>
    <title><?php print SYSTEM_NAME . "&nbsp;" . T_("Ad Editor");?></title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="themes/petrol/stylesheet.css" />
    <link rel="shortcut icon" href="favicon.ico">
    <script type="text/javascript" src="includes/tw-sack.js"></script>
    <script type="text/javascript">
         var ajax = new sack();

         function getSubCategoryList(elem) {
             var groupId = document.ad.adGroup.value;
             var myColour  = document.ad.adColour;
             var myColourVal = getCheckedValue(myColour);
                 document.getElementById('adCategory').options.length = 0;     // Empty Category box
                 ajax.requestFile = 'getAdCategories.php?colour='+myColourVal+'&myCat='+groupId;     // Specifying which file to get
                 ajax.onCompletion = createCategories;                        // Specify function that will be executed after file has been found
                 ajax.runAJAX();                                              // Execute AJAX function
         }

         function getCheckedValue(radioObj) {
                if(!radioObj) return "";
                    var radioLength = radioObj.length;
                    if(radioLength == undefined)
                        if(radioObj.checked)
                            return radioObj.value;
                        else
                            return "";
                        for(var i = 0; i < radioLength; i++) {
                             if(radioObj[i].checked) {
                                  return radioObj[i].value;
                             }
                        }
               return "";
         }


          function createCategories()
          {
              var obj = document.getElementById('adCategory');
              eval(ajax.response);                                            // Executing the response from Ajax as Javascript code  
          }

     </script>
  </head>
  <body>
<div id="fullpage">
  <?php include('includes/topbox.php'); ?>
  <?php include('includes/sidebar.php'); ?>

<? if (isset($inserted_id) && $inserted_id ) {
    user_message(T_("Your ad has been placed"),T_("You can now see how visitors will see your ad."),"adlist.php?adId=$inserted_id","green");
} else  {
    if (isset($edit_saved) && $edit_saved ) {
       user_message(T_("Your ad has been saved"),T_("You can now see how visitors will see your ad."),"adlist.php?adId=" . $myAd->getAdId(),"green");
    }
    else {
     // do the rest of the page
 
  $form->StartLayoutCapture(); ?>
       <div  id="newadbox">
  <h1 id="boxpagetitle"><?php print T_("Ad Editor");?></h1>
       <table      width="472"   cellpadding="0" cellspacing="0" >
         <tr>
            <td width="16"><img src="themes/petrol/images/tl_16.png" alt="" /></td>
            <td width="440" colspan="2" background="themes/petrol/images/upper_133.png"  alt="" /></td>
            <td width="16"><img src="themes/petrol/images/tr_16.png" alt="" /></td>
        </tr>
        <tr  bgcolor="#f2f2f2" >
            <td background="themes/petrol/images/left_edge.png"></td>
            <td  class="datalabel" align="right" ></td>
            <td align="left">
            <?
                $form->AddInputPart("offer"); 
                $form->AddInputPart("nextAction"); 
                $form->AddInputPart("adId");  // in case of a new form, empty string, discard when saving
                $form->AddLabelPart(array("FOR"=>"offer"));
                pc_debug("gettext test: Offer here",__FILE__,__LINE__);
                $form->AddInputPart("request"); 
                $form->AddLabelPart(array("FOR"=>"request")); 
                // $form->AddInputPart(array("FOR"=>"request")); ?></td>
               <td ><img src="themes/petrol/images/right_edge.png"></td>
       </tr>

       <tr bgcolor="#f2f2f2">
           <td   background="themes/petrol/images/left_edge.png"></td>
           <td   class="hordatalabel" align="right">
               <? $form->AddLabelPart(array("FOR"=>"adTitle")); ?></td>
           <td>
               <? $form->AddInputPart("adTitle"); ?></td>
           <td><img src="themes/petrol/images/right_edge.png"></td>
       </tr>

     <!-- spacer -->
    <tr bgcolor="#f2f2f2"><td background="themes/petrol/images/left_edge.png"></td>
           <td height="20" colspan="2"></td> 
           <td><img src="themes/petrol/images/right_edge.png"></td>
    </tr>

       <tr bgcolor="#f2f2f2">
           <td background="themes/petrol/images/left_edge.png"></td>
           <td class="hordatalabel"><label class="hordatalabel"><?php print T_("Value");?></td><td>
               <? $form->AddInputPart("adRedValue"); ?>
               <? $form->AddInputPart("adRed8Value"); ?>
               <? $form->AddLabelPart(array("FOR"=>"adRedValue")); ?>
           <td><img src="themes/petrol/images/right_edge.png"></td>
       </tr>

       <tr  bgcolor="#f2f2f2">
           <td background="themes/petrol/images/left_edge.png"></td>
           <td class="hordatalabel"></td><td>
               <? $form->AddInputPart("adGreenValue"); ?>
               <? $form->AddInputPart("adGreen8Value"); ?>
               <? $form->AddLabelPart(array("FOR"=>"adGreenValue")); ?>
           <td><img src="themes/petrol/images/right_edge.png"></td>
       </tr>

       <tr  bgcolor="#f2f2f2">
           <td background="themes/petrol/images/left_edge.png"></td>
           <td class="hordatalabel"></td><td>
               <? $form->AddInputPart("adBlueValue"); ?>
               <? $form->AddInputPart("adBlue8Value"); ?>
               <? $form->AddLabelPart(array("FOR"=>"adBlueValue")); ?>
           <td><img src="themes/petrol/images/right_edge.png"></td>
      </tr>

<!-- spacer -->
    <tr bgcolor="#f2f2f2"><td background="themes/petrol/images/left_edge.png"></td>
           <td height="20" colspan="2"></td> 
           <td><img src="themes/petrol/images/right_edge.png"></td>
    </tr>


       <tr bgcolor="#f2f2f2">
           <td background="themes/petrol/images/left_edge.png"></td>
           <td class="hordatalabel" align="right"><? $form->AddLabelPart(array("FOR"=>"adGroup")); ?></td><td>
               <? $form->AddInputPart("adGroup"); ?>
           </td>
           <td><img src="themes/petrol/images/right_edge.png"></td>
      </tr>

       <tr bgcolor="#f2f2f2">
           <td background="themes/petrol/images/left_edge.png"></td>
           <td class="hordatalabel" align="right"><? $form->AddLabelPart(array("FOR"=>"adCategory")); ?></td>
           <td>
               <? $form->AddInputPart("adCategory"); ?></td>
           <td><img src="themes/petrol/images/right_edge.png"></td>
       </tr>

<!-- spacer -->
    <tr bgcolor="#f2f2f2"><td background="themes/petrol/images/left_edge.png"></td>
           <td height="20" colspan="2"></td> 
           <td><img src="themes/petrol/images/right_edge.png"></td>
    </tr>

       <tr bgcolor="#f2f2f2">
           <td background="themes/petrol/images/left_edge.png"></td>
           <td class="hordatalabel" align="right"><? $form->AddLabelPart(array("FOR"=>"adText")); ?></td><td>
                <? $form->AddInputPart("adText"); ?></td>
           <td background="themes/petrol/images/right_edge.png"></td>
       </tr>


       <tr bgcolor="#f2f2f2">
           <td background="themes/petrol/images/left_edge.png"></td>
           <td class="hordatalabel" align="right"><? $form->AddLabelPart(array("FOR"=>"uploadFile")); ?></td><td>
               <? print $myAd->getThumbImage("html");
                  $form->AddInputPart("uploadFile"); ?></td>
           <td background="themes/petrol/images/right_edge.png"></td>
       </tr>

       <tr bgcolor="#f2f2f2">
           <td background="themes/petrol/images/left_edge.png"></td>
           <td class="hordatalabel">
               <? $form->AddLabelPart(array("FOR"=>"ccode")); ?></td>
           <td><table><tr><td>
                              <? $form->AddInputPart("ccode"); ?></td>
                          <td><img src="images/dd-formmailer-verify.php.png"></td>
                      </tr>
              </table></td>
           <td><img src="themes/petrol/images/right_edge.png"></td>
      </tr>

       <tr  bgcolor="#f2f2f2">
           <td background="themes/petrol/images/left_edge.png"></td>
           <td colspan="2">
               <table><tr>
                      <td width="300"><input onClick="javascript:history.go(-1)"  
                      type=button src="cancel" name="cancel" Value="<?php print T_("Cancel");?>
"><td><td>
                          <? $form->AddInputPart("submit"); ?>
                                
                          </td>
                      </tr>
              </table>
           <td><img src="themes/petrol/images/right_edge.png"></td>

         <tr>
            <td width="16"><img src="themes/petrol/images/bl_16.png" alt="" /></td>
            <td width="440" colspan="2" background="themes/petrol/images/lower_133.png"  alt="" /></td>
            <td width="16"><img src="themes/petrol/images/br_16.png" alt="" /></td>
        </tr>
        <tr> <td height="20" colspan="4"></td> </tr>

       </table>
       </div>
    </div>




</div>
  </body>
</html>
<?php 
  $form->EndLayoutCapture();
  $form->DisplayOutput(); 
    }
} // end of message print else
?>


<?
// phpinfo();
?>
