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
  // thanks to http://www.php-mysql-tutorial.com/user-authentication/image-verification.php
  
  session_start();

  // generate  5 digit random number
  $alphanum = "abcdefghkmnpqrstwxyz2345678!?<>{}[]@#%&*";
  $rand = substr(str_shuffle($alphanum), 0, 5);

  // create the hash for the random number and put it in the session
  $_SESSION["verify"] = md5($rand);

  // create the image
  $image = imagecreate(60, 30);

  // use white as the background image
  $bgColor = imagecolorallocate ($image, 242, 242,242); 

  // the text color is black
  $textColor = imagecolorallocate ($image, 0, 128, 128); 

  // write the random number
  imagestring ($image, 5, 5, 8,  $rand, $textColor); 
      
  // send several headers to make sure the image is not cached    
  // taken directly from the PHP Manual
      
  // Date in the past 
  header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 

  // always modified 
  header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 

  // HTTP/1.1 
  header("Cache-Control: no-store, no-cache, must-revalidate"); 
  header("Cache-Control: post-check=0, pre-check=0", false); 

  // HTTP/1.0 
  header("Pragma: no-cache");     


  // send the content type header so the image is displayed properly
  #header('Content-type: image/jpeg');
  header('Content-type: image/png');

  // send the image to the browser
  // imagejpeg($image);
  imagepng($image);

  // destroy the image to free up the memory
  imagedestroy($image);
?> 
