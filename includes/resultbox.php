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

  /* draw the head, lines and foor of divs and tables in a flexible way 
  nice include of the colors file, hmm is that fast or what ?*/

  class resultBox {
    var $boxDivId; # refer to div id in stylesheet
    var $boxTableId; # refer to Table id in stylesheet
    var $boxCols;  # number of data attributes to display
    var $theme;    # name of theme where images are
    var $title;    # box title
    var $boxTableBgColor;
    var $boxClass;
    var $tableWidth;


    function __construct($myBoxDivId, $myBoxTableId, $myBoxCols, $myTheme, 
                       $myBgColor, $myBoxClass, $myTableWidth=604) {
      $this->boxDivId   = $myBoxDivId;
      $this->boxTableId = $myBoxTableId;
      $this->boxCols    = $myBoxCols;
      $this->theme      = $myTheme;
      $this->boxTableBgColor = $myBgColor;
      $this->tableWidth = $myTableWidth; # count 2x16px for left and right.
      $this->boxClass   = $myBoxClass;
      $this->title = "";
    }

    
    function boxStart() {
      $myBoxTableBgColor = $this->boxTableBgColor;
      $myBoxCols  = $this->boxCols;
      $myTheme    = $this->theme;
      $myTitle    = $this->getTitle();
      $myDivId    = $this->boxDivId;
      $myBoxClass = $this->boxClass;
      $myTableId  = $this->boxTableId;
      $myTableWidth = $this->tableWidth;

      print <<< END_BLOCK
         <!-- page contents --><div id="$myDivId" class="$myBoxClass">
         <h1 id="resultpagetitle">$myTitle</h1>
         <table  id="$myTableId" bgcolor="$myBoxTableBgColor" width="$myTableWidth" cellpadding="0" cellspacing="0" >
         <tr><td width="16px"><img src="themes/$myTheme/images/tl_16w.png"></td>
             <!-- <td colspan="$myBoxCols" width="548px"><img src="themes/$myTheme/images/upper_20w.png" width="100%" height="16"></td> -->
             <td colspan="$myBoxCols" width="548px" background="themes/$myTheme/images/upper_20w.png"  height="16"></td>
             <td><img src="themes/$myTheme/images/tr_16w.png"></td>
         </tr>
END_BLOCK;
    }

    function boxEnd() {
      $myBoxCols = $this->boxCols;
      $myTheme = $this->theme;
      print <<< END_BLOCK
         <tr><td width="16px"><img src="themes/$myTheme/images/bl_16w.png"></td>
             <td colspan="$myBoxCols" width="548px" background="themes/$myTheme/images/lower_20w.png" height="16"></td>
             <td><img src="themes/$myTheme/images/br_16w.png"></td>
         </tr>
         </table><!-- end result box --> </div><!-- end div $this->boxDivId-->
END_BLOCK;
    }

    function titleBox() {
       $myTitle = $this->title;
     echo "<h1 class=\"resultpagetitle\">$myTitle</h1>";
  }
    


    function boxLeftEdge() {
      $myTheme = $this->theme;
       print "<tr><td background=\"themes/$myTheme/images/left_edgew.png\" width=\"16px\" height=\"100%\"></td>";
      print "\n";
    }
    function boxRightEdge() {
      $myTheme = $this->theme;
       print "<td background=\"themes/$myTheme/images/right_edgew.png\" width=\"16px\" height=\"100%\"></td></tr>";
      print "\n\n";
    }

    function boxHorTitleRow($data) {
      // data is assoc array "Label" => "width"
      $myTheme = $this->theme;
      $this->boxLeftEdge();
       // print "<tr><td background=\"themes/$myTheme/images/left_edgew.png\" width=\"16px\" height=\"100%\"></td>";
       foreach($data as $label => $size) {
         print "<th class=\"rdatalabel\" width=\"$size\">$label</th>";
       }
      // print "<td background=\"themes/$myTheme/images/right_edgew.png\" width=\"16px\" height=\"100%\"></td></tr>";
      $this->boxRightEdge();
    }
    function boxCell($data,$style="wdata") {
      // $data is plain HTML code, style is a preselect format
      if ($style == "top")   : print "<td valign=\"top\">$data</td>"; endif;
      if ($style == "wdata") : print "<td class=\"wdata\">$data</td>"; endif;
      if ($style == "rdata") : print "<td class=\"rdata\">$data</td>"; endif;
      if ($style == "wdatasmall") : print "<td class=\"wdatasmall\">$data</td>"; endif;
      if ($style == "title") : print "<th class=\"wdatalabel\">$data</th>"; endif;
      if ($style == "datalabel") : print "<td class=\"datalabel\"><label>$data</label></td>"; endif;
      print "\n";
    }
    function boxCellSpan($data,$style="wdata",$span) {
      if ($style == "top")   : print "<td colspan=\"$span\" valign=\"top\">$data</td>"; endif;
      if ($style == "wdata") : print "<td colspan=\"$span\" class=\"wdata\">$data</td>"; endif;
      if ($style == "wdatasmall") : print "<td colspan=\"$span\" class=\"wdatasmall\">$data</td>"; endif;
      if ($style == "title") : print "<th colspan=\"$span\" class=\"wdatalabel\">$data</th>"; endif;
    }


    function boxRowBorder() {
      $myTheme = $this->theme;
      $this->boxLeftEdge();
      $size = $this->boxCols + 2;
      print "<tr><td height=\"1\" bgcolor=\"#008080\" colspan=" . $size . "></td></tr>";
      $this->boxRightEdge();
    }

    function setTitle($title) {
        $this->title=$title;
    }
    function getTitle() {
        return $this->title;
    }
    function boxHorLineRow() {
        print '<tr><td height="1" bgcolor="#008080" colspan=6></td></tr>';
     }



  }
       




