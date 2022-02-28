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

# MySQL Database               # Your ISP gives you this, or use an
#                              # admin panel to help yourself
 $host    = "localhost";       # database host name, or just localhost
 $user    = "rgb";             # mysqli user name
 $pass    = "rgbpw";           # mysqli user's password
 $dbname  = "rgb";             # mysqli database name to connect to

 # Localization
 # For Convenience, grouped by language. Comment or uncomment as you like.
 #
 # all for en_US :
 #
 setlocale(LC_TIME,'en');                             # enable formatting. nl or en
 define('DEFAULT_LOCALE', 'en_US');                   # en_US, nl_NL 

/* new in 2022 to fix escape string */
define('CHARSET') = "utf8mb4" ; // following examples

# pick one of the available or write your own
 define('DOC_URL', 'https://github.com/ichnaton777/rgbtrade');    # place on Internet where the documentation lives. 
 define('DOC_COL_URL', 'https://book.kleureneconomie.nl/part2/fullpackage.html');   #  documentation for: what is RGB?

 /* nl_NL settings in this block.
 * setlocale(LC_TIME,'nl');                             # enable formatting. nl or en
 * define('DEFAULT_LOCALE', 'nl_NL');                   # en_US, nl_NL 
 *                                                      # pick one of the available or write your own
 * define('DOC_URL', 'http://rgbtrade.org/nl-doc/');    # place on Internet where the documentation lives. 
 * define('DOC_COL_URL', 'http://colourcash.org/introduction/colours/');   #  documentation for: what is RGB?
 *******/
                                                      # en_US  http://rgbtrade.org/documentation 

 # required system settings
 #
 define('SYSTEM_NAME','RGBtrade');                      # Name for usage by humans. Name of the system.
 define('SYSTEM_URL','http://your.com/');              # http://server.com/path/ example http://rgboog.nl/
 define('SYSTEM_EMAIL','rgbtrade@your.com');   # email address you're using to send email from. should attend box for bounces perhaps
 define('DEBUG',true);                                 # enable debugging in /log/error.txt. true or false
 define('SYSTEMMODE',"beta");                          # prelive, beta, live
 define('CATEGORY_EDIT',true);                         # enable category editor. true or false
 define('SAFE_MODE_COMPAT',true) ;                     # set to true on PHP safe mode servers. true or false


 define('DAY_OUT_OF_TIME','12-21');   # On this day the system computes end-of-year totals
                                      # format: MM-DD. Year is omitted, because it repeats yearly.
                                      # NOT use 31-12 but write 12-31!
                                      # popular days out of time: 
                                      # July 25:  07-25  : 13-Moon-Calendar or Dreamspell, by José Argüelles
                                      # December 21      : 12-21  : Julejaar, by Tanja Hilgers
                                      # December 31      : 12-31  : Gregorian  Calendar, decreed by Pope Gregory XIII

 define('ADMIN_EMAIL','post@kleureneconomie.nl');
                                      # your (?) email address. This will be used once a year to send
                                      # confirmation of the yearly reset at day out of time.

 # end of file. good luck!

?>
