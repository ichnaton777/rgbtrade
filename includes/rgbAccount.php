<?
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

/* rgbAccount
 * class to maintain rgb participants accounts, not their bank account values.
 * status values: toconfirm, live, 
 */

class rgbAccount {
  var userId;
  var userStatus;
  var confirmCode;
  var password;
  

  function rgbAcccount() {
    var userId = null;
    var userStatus = null;
  }

  function sendConfirmMail() {
  }

  function checkConfirmUrl() {
  }

  function sendNewPasswordVerifyMail() {
  }

  function checkNewPasswordVerifyUrl() {
  }

  function showNewPasswordForm() {
  }

  function remove() {
  }
  

?>







