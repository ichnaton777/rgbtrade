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
  /* Class Box
  *  This file is part of the rgbTrade system, enabling the use of a 3-D monetary unit for trading. 
  *  For details see www.kleureneconomie.nl or sourceforge.net/rgbtrade
  *  @author  Barry Voeten, barry@voeten.com
  *  @license Gnu Public License 
  */

  class Box {
    var $title;
    var $cssclass;
    var $text;
    var $visible;

    function __construct()  {
      $this->style="";
      $this->title="";
      $this->text="";
      $this->visible = false ;
    }

    function show()  {
      if($this->visible == true){
        print "<div id='dynaBox' class='" . $this->getCssClass() . "'><h1 class='" . $this->getCssClass() . "'>" . $this->getTitle() . "</h1>" .  $this->getTheText() . "</div>"  ;
      }
    }
    function setTitle($title) {
        $this->title=$title;
    }
    function getTitle() {
        return $this->title;
    }
    function setCssClass($class) {
        $this->cssclass = $class;
    }
    function getCssClass() {
        return $this->cssclass;
    }

    function setText($text) {
        $this->text = $text;
    }
    function getTheText() {
        return($this->text);
    }

    function setVisible($visible) {
        $this->visible = $visible;
    }

    function getVisible() {
        return($this->visible);
    }

  }
?>
