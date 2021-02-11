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

  $user = new rgbUser;
  if (isset($_SESSION['status']) && $_SESSION['status'] == "live" ) {
    $user->setUserNick($_SESSION['userNick']);
    $user->setUserId($_SESSION['userId']);
    pc_debug("Already logged in, continue " . $_SESSION['userNick'],__LINE__,__FILE__);
  } else {
    if (isset($_SESSION['status'])) {
      pc_debug("Check login again: session-status = ".  $_SESSION['status'] ,__LINE__,__FILE__);
    } else {
      pc_debug("Check login again: session-status is not set" ,__LINE__,__FILE__);
    }

    if (isset($_POST['action'])  && $_POST['action'] == 'login') {
      if( $user->checklogin() ) 
      {
        // okay login
      //   print "2";
        $user->setlogin();
        pc_debug("Setting log in",__LINE__,__FILE__);
      } else {
        pc_debug("Login faulty: login: ",__LINE__,__FILE__);
        pc_debug("going to redirect",__LINE__,__FILE__);
        // what else do we have then this?
        $user->setloggedoff();
        header("location:error.php?error=login");
      }
    } else {
       // not re-logging in, but, are we in a logged in session ?
       if ($user->getloggedin()) {
          //   print "4 :stay tuned";
          pc_debug("Login OKAY",__LINE__,__FILE__);
          $user->setUserNick($_SESSION['userNick']);
          $user->setUserId($_SESSION['userId']);
       } else {
          //  print "5";
          // set what we already know
          $user->setloggedoff();
       }

    }
  }
?>
