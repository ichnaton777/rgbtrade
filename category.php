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
  include_once("includes/rgbtop.php");
  include_once("includes/loggedin.php");
  include_once("includes/forms.php");             // by mlemos
  include_once("includes/rgbAd.php");   
  $user->loadUser();
  if (!$user->getLoggedIn()) {
      header("location:index.php");
  }
  $form = new form_class; 
  $myCat = new rgbAdCategory;
  $form->NAME = "categoryForm";

  // case of an edit category, load from database before needing the values, setting form inputs
  // new: present empty form
  // add: saving the new form, display OK message
  // edit: present exisitng add for edit
  // save: saving edited exisitng ad
  //
  // action-> GET variable, should be opening of a form
  // formAction -> POST variable, add or save

 if (isset($_GET['action']) && $_GET['action'] =="add" ) {
 // present an add form
         $postaction="new";
         $formAction="add";
         pc_debug("user   :" . $user->getUserNick(), __FILE__,__LINE__);
 } else if (isset($_GET['action']) && $_GET['action'] == "edit" ) {
     pc_debug("editing cat",__FILE__,__LINE__);
     //$myCat = new rgbAdCategory;
     if (isset($_GET['catid']) && is_numeric($_GET['catid'])) {
         // split here in edit-form and save-form
         $myCat->setCategoryId($_GET['catid']);
         if($myCat->load()) {
             $postaction="edit";
             $formAction="save";
             pc_debug("goint to edit cat",__FILE__,__LINE__);
             } else {
                 pc_debug("editing non-existent category " . $_GET['catid'] , __FILE__,__LINE__);
                 header("location:index.php");
                 exit;
         }
     } else { 
          print ".xit"; 
          exit;
     }
 } else if (isset($_REQUEST['formAction']) && $_REQUEST['formAction'] =="add") {
     $postaction="add";
 }
 if(isset($_REQUEST["formAction"]) && $_REQUEST["formAction"] == "save"){
     if(($error_message=$form->Validate($verify))=="") {
              $doit=1;
              pc_debug("verified OK, doit set 1", __FILE__,__LINE__);
              $postaction="message";
              $formAction="";
              pc_debug("postaction=message set : $error_message",__FILE__,__LINE__);
              // $form->LoadInputValues();
      } else {
              $doit=0;
              $error_message=nl2br(HtmlSpecialChars($error_message));
              pc_debug("verified NOT ok,".  $error_message, __FILE__,__LINE__);
     }
 } else {
        $error_message="";
        pc_debug("formAction not set. or not save"  , __FILE__,__LINE__);
        $doit=0;
 }

    // $form->LoadInputValues($form->WasSubmitted("catStatus"));
    //$verify=array();
    //if($form->WasSubmitted("formAction")) {
    // if($form->WasSubmitted("catStatus")) {



  pc_debug("do it or not?",__FILE__,__LINE__);
  // start off with the form for 
  // $form = new form_class; 
  $form->METHOD = "POST";
  $form->ENCTYPE="multipart/form-data";
  $form->debug="trigger_error";
  $form->ResubmitConfirmMessage=
        "Wilt u dit formulier echt tweemaal verzenden?";
  $form->OutputPasswordValues=0;
  $form->OptionsSeparator="<br />\n";
  $form->ShowAllErrors=1;
  $form->InvalidCLASS='invalid';
  $form->ErrorMessagePrefix="Fout: ";
  $form->ErrorMessageSuffix="";
  $form->ACTION="category.php";

  // doing the form inputs that can be defined and are assigned a value later on.
  
    $form->AddInput(array(
         "TYPE"=>"radio",
         "NAME"=>"catStatus",
         "VALUE"=>"available",
         "ID"=>"available",
         "LABEL"=>T_("Available"),
         "LabelCLASS"=>"hordata",
         "CLASS"=>"formInput",
         "ACCESSKEY"=>"o",
         "ReadOnlyMark"=>"[X]"
    ));

    $form->AddInput(array(
         "TYPE"=>"radio",
         "NAME"=>"catStatus",
         "VALUE"=>"unavailable",
         "ID"=>"unavailable",
         "LABEL"=>T_("Unavailable"),
         "ACCESSKEY"=>"q",
         "CLASS"=>"formInput",
         "LabelCLASS"=>"hordata",
         "ReadOnlyMark"=>"[X]"
       ));
      $form->setCheckedRadio("catStatus",$myCat->getStatus());


    // let's see. If there already is an ad in this category/group, then you can't change the colouw anymore. 
    // otherwise, the ad breaks.
    //
    //
    $sqlc = sprintf("select count(adId) from rgbAds where adCategoryId = %s or adGroupId = %s ", $myCat->getCategoryId(), $myCat->getCategoryId());
    pc_debug("sql: $sqlc" . mysql_error(), __FILE__,__LINE__);
    $qc = mysql_query($sqlc);
    $res=mysql_fetch_row($qc);
    pc_debug("row count: " . $res[0] , __FILE__,__LINE__);
    // // workaround to disable horrible bug with radio colour


    // if we have no parent, then set the parent accoring to the colour.
    //
    if($myCat->getParentId() < 1) {
        // take 1 as default root parent
              $myCat->setparentId(2);
    } 
       // $cats = getColourCatArray();  // last param : -1 means all parents
       $cats = getGroupsByParent(1);  
       $cats = array("1"=>"Universele Hoofd Categorie") + $cats;
       // var_dump($cats);
       $error= $form->AddInput(array(
         "TYPE"=>"select",
         "NAME"=>"parentId",
         "ID"=>"parentId",
          "VALUE"=>$myCat->getParentId(),
          "OPTIONS"=>$cats,
          "ValidateAsDifferentFromText"=>"pick",
          "ValidateAsDifferentFromTextErrorMessage"=>
          "Kies een van de geboden categorieen of kies de bovenste als u niet kunt kiezen",
          "ValidationErrorMessage"=>"It was not specified a valid credit card type.",
          "LABEL"=>T_("Group"),
          "ACCESSKEY"=>"G"
        ));
       pc_debug("error parentId = $error" . "parentId = " . $myCat->getParentId(),__FILE__,__LINE__);

         $form->AddInput(array(
           "TYPE"=>"text",
           "NAME"=>"ccode",
           "ID"=>"ccode",
           "VALUE"=>"",
           "SIZE"=>5,
           "MAXSIZE"=>5,
           "LABEL"=>T_("Security Code"),
           "CLASS"=>"formInput"
         ));

      $form->AddInput(array(
         "TYPE"=>"submit",
         "NAME"=>"submit",
         "VALUE"=>T_("Save")
       ));

       $form->AddInput(array(
         "TYPE"=>"text",
         "NAME"=>"titleL10N",
         "VALUE"=>"",
         "ID"=>"titleL10N",
         "LABEL"=>T_("Display Title"),
         "ACCESSKEY"=>"t",
         "CLASS"=>"formInput",
         "LabelCLASS"=>"hordatalabel",
         "MAXLENGTH"=>"35",
         "SIZE"=>"28",
          "ValidateMinimumLength"=>"3",
          "ValidateMinimumLengthErrorMessage"=>T_("The International Title has a minimum of 3 characters"),
        ));

       pc_debug("goint to set enName" . $myCat->getEnName(), __FILE__,__LINE__);
       $form->AddInput(array(
         "TYPE"=>"text",
         "NAME"=>"titleEn",
         "VALUE"=>"",
         "ID"=>"titleEn",
         "LABEL"=> T_("English Title"),
         "ACCESSKEY"=>"t",
         "CLASS"=>"formInput",
         "LabelCLASS"=>"hordatalabel",
         "MAXLENGTH"=>"35",
         "SIZE"=>"28",
          "ValidateMinimumLength"=>"3",
          "ValidateMinimumLengthErrorMessage"=>T_("The Title has a minimum of 3 characters")

         ));
     //
    // for "new" cats, the catId is defaulted to 0
       $form->AddInput(array(
             "TYPE"=>"hidden",
             "NAME"=>"catId",
             "VALUE"=>$myCat->getCategoryId(),
             "ValidateAsInteger"=>1,
             "DiscardInvalidValues"=>1,
             "ValidationErrorMessage"=>T_("There is no valid ID, this must be a bug")
           ));

    if(!$doit) {
        pc_debug("doing not it",__FILE__,__LINE__);
        if(strlen($error_message)) {
            Reset($verify);
            $focus=Key($verify);
        }
        else {
            $focus='adTitle';
        }
    }


   if (!isset($formAction)) {
      $formAction="none";
   }


   if (!isset($postaction)){
      $postaction="none";
   }

    switch($postaction) {
     case "add":
      $doit=1;
      //$myCat= new rgbAdCategory();
      $form->LoadInputValues();
      pc_debug("my formAction= " . $formAction, __FILE__,__LINE__);
      pc_debug("my status    = " . $myCat->getStatus() , __FILE__,__LINE__);
      $message = $myCat->insert($form,$user);
      pc_debug("inserted category 3: message $message",__FILE__,__LINE__);
      break;
    case "edit" :
      $form->setCheckedRadio("catStatus",$myCat->getStatus());
      pc_debug("myCat status    = " . $myCat->getStatus(), __FILE__,__LINE__);
      $cats=getGroupsByParent(1); // ("red","available",$myCat->getParentId());
      $cats = array("1"=>"Universele Hoofd Categorie") + $cats;
      // var_dump($cats);
      $form->setSelectOptions("parentId",$cats,array($myCat->getParentId()));
      $form->setInputValue("parentId",$myCat->getParentId());
      pc_debug("parent (#)      = " . $myCat->getParentId(),__FILE__,__LINE__);
      pc_debug("editing category= ". $myCat->getCategoryId(),__FILE__,__LINE__);
      pc_debug("my formAction   = " . $formAction, __FILE__,__LINE__);
      pc_debug("my status       = " . $myCat->getStatus() , __FILE__,__LINE__);
      break;
      /*
     case "save" :
         // NEVER SET!
      pc_debug("postaction SAVE ",__FILE__,__LINE__);
      // $myCat->save($form,$user);
      pc_debug("---- going to save category",__FILE__,__LINE__);
      $doit=1;
      $form->LoadInputValues();
      $cats=getColourCatArray($form->getInputValue("catColour"));
      $form->setSelectOptions("parentId",$cats,$form->getInputValue("parentId"));
      // $myCat= new rgbAdCategory();
     // $form->SetCheckedRadio("catColour",$myCat->getColour()); 
     // $form->setCheckedRadio("catStatus",$myCat->getStatus());
      pc_debug("input values loaded",__FILE__,__LINE__);
      pc_debug("myCat formAction = " . $formAction, __FILE__,__LINE__);
      pc_debug("myCat status     = " . $myCat->getStatus() , __FILE__,__LINE__);
      pc_debug("myCat parentId   = " . $myCat->getParentId(),__FILE__,__LINE__);
      pc_debug("form parentId    = " . $form->getInputValue("parentId"),__FILE__,__LINE__);
      $message = $myCat->save($form,$user);
      break;
       */
    } 

     $onload = HtmlSpecialChars($form->PageLoad());
      // hidden input action
       $form->AddInput(array(
         "TYPE"=>"hidden",
         "NAME"=>"formAction",
         "ID"=>"formAction",
         "VALUE"=>"$formAction"
       ));

       $form->setInputValue("titleEn",$myCat->getEnName());
       $form->setInputValue("titleL10N",$myCat->getL10NName());
       

  if($doit) {
      // save that stuff
      pc_debug("saving here",__FILE__,__LINE__);
      $form->LoadInputValues();
      $form->ReadOnly=0;
      pc_debug("input values loaded",__FILE__,__LINE__);
      pc_debug("myCat formAction = " . $formAction, __FILE__,__LINE__);
      pc_debug("myCat status     = " . $myCat->getStatus() , __FILE__,__LINE__);
      pc_debug("myCat parentId   = " . $myCat->getParentId(),__FILE__,__LINE__);
      pc_debug("form parentId    = " . $form->getInputValue("parentId"),__FILE__,__LINE__);
      // $myCat->save($form,$user);
      $message = $myCat->save($form,$user);
      pc_debug("saving category message returned : $message" ,__FILE__,__LINE__);
  }
       
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
  <head>
    <title><?php print (SYSTEM_NAME . "&nbsp;" . "Category Editor");?></title>
    <link rel="stylesheet" type="text/css" href="themes/petrol/stylesheet.css" />
    <script type="text/javascript" src="includes/tw-sack.js"></script>
    <script type="text/javascript">
         var ajax = new sack();
         function getCategoryList(myColour,formSelect) {
                 // var countryCode = sel.options[sel.selectedIndex].value;
                 document.getElementById('parentId').options.length = 0;      // Empty parent Category box
                 ajax.requestFile = 'getCategories.php';     // Specifying which file to get
                 // alert('request = ' +  ajax.requestFile);
                 ajax.onCompletion = createCategories;                        // Specify function that will be executed after file has been found
                 ajax.runAJAX();                                              // Execute AJAX function
          }

          function createCategories()
          {
              var obj = document.getElementById('parentId');
              eval(ajax.response);                                            // Executing the response from Ajax as Javascript code  
          }

     </script>
  </head>
  <body>
<div id="fullpage">
  <?php include('includes/topbox.php'); ?>
  <?php include('includes/sidebar.php'); ?>
<?php 

       
   if(!$doit) {    
       $form->StartLayoutCapture(); 
       print '<div  id="newadbox">';

       if (defined('CATEGORY_EDIT') && CATEGORY_EDIT) { ?>
           <h1 id="boxpagetitle">Categorie beheer<a href="categorylist.php"> [<?php print T_("List"); ?>]</a> <a href="category.php?action=add">[+]</a></h1>
   <? } ?>

       <table    border="0" width="430px" height="275" class="wdata" >
       <tr><td></td></tr>

       <tr><td class="hordatalabel"><label class="hordatalabel"><? $form->AddLabelPart(array("FOR"=>"titleEn")); ?></td><td>
     <? $form->AddInputPart("formAction");?>
     <? $form->AddInputPart("titleEn"); ?>
       </tr>
       <tr><td class="hordatalabel"><label class="hordatalabel"><? $form->AddLabelPart(array("FOR"=>"titleL10N")); ?></td><td>
     <? $form->AddInputPart("titleL10N"); ?>
     <? $form->AddInputPart("catId"); ?>
       </tr>


<!-- spacer -->
<tr><td height="20px" colspan="2"></td></tr>


       <tr><td width="70px" class="hordatalabel" align="right"><? $form->AddLabelPart(array("FOR"=>"parentId")); ?></td><td>
     <? $form->AddInputPart("parentId"); ?>
     </td></tr>


       <tr><td width="70px" class="hordatalabel" align="right">Status</td><td>
     <? $form->AddInputPart("available"); ?>
     <? $form->AddLabelPart(array("FOR"=>"available")); ?> &nbsp;

     <? $form->AddInputPart("unavailable"); ?>
     <? $form->AddLabelPart(array("FOR"=>"unavailable")); ?> &nbsp;
     </tr> 


   <tr><td class="hordatalabel">
     <? $form->AddLabelPart(array("FOR"=>"ccode")); ?>
   </td><td>
        <table><td>
     <? $form->AddInputPart("ccode"); ?>
        </td>
         <td><img src="images/dd-formmailer-verify.php.png"></td></tr></table></td></tr>

       <tr><td></td><td colspan="1" height="150px" valign="top"  align="right">
       
       <table><tr><td width="300"><input onClick="javascript:window.location='categorylist.php'"  type=button src="annuleren" name="Cancel" 
       Value="<?php print T_("Cancel");?>"><td><td><input type="submit" src="submit.png" value="<?php print T_("Save");?>"></td></tr></table>
       
       </table>


       </table>
       </div>
    </div>
<?  } else {

    print "<div id=\"newadbox\">$message</div>";
}
?>

</div>
  </body>
</html>
<?php 
 if (!$doit) {
  $form->EndLayoutCapture();
  $form->DisplayOutput(); 
 }
?>
