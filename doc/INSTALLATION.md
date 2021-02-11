Installation Instructions.
August 28, 2007

Requirements:
* PHP 7.0 
* Mysql 4.1 or later

Requirements are such that today's Linux Virtual Hosting Webspaces, 
offered cheap by ISP's, will do. So, any other database than mysql 
will probably not be supported. Current releases do not require PHP
above 4.3, but we will be moving to PHP5 in 2009, still lagging years
behind the PHP folks. Windows-based hosting will probably work, but 
that configuration has been untested so far.

Configuration
=============
* Unzip the zipfile with your favourite zip program. There is only a 
  directory called rgbtrade. Upload the files in it to your webspace 
  (with FTP probably).
* Copy the file includes/rgbConfig-example.php to 
  includes/rgbConfig.php
* Change the following settings in  includes/rgbConfig.php :
  $host     = "localhost";                      # database host name, or just localhost
  $user     = "Your_mysql_username"
  $pass     = "Your_mysql_password";
  $dbname   = "Your_mysql_databasename";

* Change the following variables to your desires:

  setlocale(LC_TIME,'nl');
    Currently, only nl is working/tested but probably anything should
    work. Note that for the moment, also,
    Dutch is the only language supported.

  define('DEFAULT_LOCALE', 'nl_NL');                   
    This picks up the correct language file, choose from: en_US, nl_NL

  define('DOC_URL', 'http://kleureneconomie.nl/doc/'); 
    This points to the on Internet where the documentation lives. Pick one of the available 
    or write your own :
    * en_US  http://rgbtrade.org/documentation 
    * nl_NL  http://kleureneconomie.nl/doc/ 

 define('SYSTEM_NAME','RGBoog');
   This is the name for humans you whish the system to call itself. This name is simply
   displayed where needed. Good names are short and distinctive.

 define('SYSTEM_URL','http://rgboog.nl/');            
   This is the place on the internet where this system will live. For example,
    http://server.com/path/ or http://rgboog.nl/. End with / is okay.

  define('DEBUG',true);
    To get debug output, set true. When live, set to false. 
    When set, see Permissions for an extra thing to do.

  define('SYSTEMMODE',"beta"); # prelive, beta, live
    prelive: site exists, but no login possible. Some texts will show 
             up that you can edit (includes/whatis.php and 
             includes/how.php).
    beta:    site is running as live, but the logo will contain the 
             word 'beta', clicking will reveal that we are still in 
             beta phase and what that means. rgboog.nl (intended 
             first site) is supposed to remain beta until at least 
             july 2008.
    live:    normal operation

  define('CATEGORY_EDIT',true)
    true:    the category editor (to place ads in) is open for 
             changes. Convenient and inconvenient at the same time
    false:   no more changes to the categories.

  define('SAFE_MODE_COMPAT',true)
    true:    you are on a safe mode web host or you want to be able to move to
             a safe mode host without any changes. Uploads (User avatars, ad
             images) are all put straight into the /uploads folder.
    false:   you're not on a safe mode host and, when moving, you will just
             change this setting. All uploads are stored into a folder structure
             such as /uploads/johnsmith/ads/image1.jpg

  define('DAY_OUT_OF_TIME','12-21');   
             On this day the system computes end-of-year totals
             format: MM-DD. Year is omitted, because it repeats yearly.
             Note: NOT use 31-12 but write 12-31!
             popular days out of time: 
              July 25: 07-25  : 13-Moon-Calendar or Dreamspell, by José Argüelles
              Dec 21 : 12-21  : Julejaar, by Tanja Hilgers
              Dec 31 : 12-31  : Gregorian  Calendar, decreed by Pope Gregory XIII

  define('ADMIN_EMAIL','post@kleureneconomie.nl');
              your (?) email address. This will be used once a year to send
              confirmation of the yearly reset at day out of time.

Upload your version of includes/rgbConfig.php


Database
========
Enter the table and initial data into mysql. Virtual host users usually have 
phpmyadmin to populate the database. Use the file 

  sql/Rgbtrade-definitions.sql 

to create
the tables. Then, use 

  sql/Rgbtrade-data-categories-LANG.sql 
  
to create some initial table data for the categories. Note that you should pick a language file
for your language containing the correct initial data. Please note that the
category list is long and under development by itself. 

Now you should also add the Blueberg (Blue Mountain) user, using the following files:

  sql/Rgbtrade-data-users-LANG.sql 
  sql/Rgbtrade-data-balances-GENERIC.sql 

There is only one file for the balances, the GENERIC. It contains only numeric data and no textual data.
For installations in any language also use this file.


Permissions
===========
You should create a directory in your rgbtrade directory called uploads. 
To enable file uploads, set the permissions of the uploads
directory to world-writeable (777). This holds generally. On some systems
it may work to set less permissive permissions, such as 755. Try.

In DEBUG mode, you need to set world-write but not read permissions 
on log/error.txt code : 226 world writeable; user and group readable


Cron Job
========
The system contains a "yearly reset" or end-of-year function. In order to run this procedure
automatically at the correct moment - 12.00 GMT/UTC at the DAY OUT OF TIME that is defined in the config file.
The most secure approach to run this reset is to include a daily job at 12:00 GMT/UTC that fetches the file
dailycron.php. On typical unix/linux systems this is done with wget. Make sure you have wget installed
and make a crontab entry with the command 
 
 crontab -e

You are then thrown into a file editor. Edit the file as follows:

# m h  dom mon dow   command
  0 12  *   *   *    wget http://your-rgb-host.org/dailycron.php

Note that you should enter your host name instead of our this fake name.

The dailycron.php script is able to self-check in order to prevent multiple runs per day or runs on the wrong day. There is no
time check, so the first request on dailycron.php will do the trick. There is no problem if you run it at the wrong hour.
To check your system for date settings, type

 date

and you should receive a response like
 
 Wed Feb 25 09:46:18 UTC 2009

The time zone is included here. If your system is not on UTC, you should compute the difference or run at 12.00 local time.

Trouble?
If you have trouble setting the cron job, e.g. because you don't have cron support from your ISP or you run windows, contact
the author and you will be offered a cronjob from an rgbtrade project server.

Admin Panel
===========
Please note that there is NO ADMIN PANEL. There is not any, because, 
why would there? Why would some users be more powerful than others? 
We all create our own money and that's what this is about. Of course, 
the webmaster can make backups (later, anyone will) and enter mysql 
with bare hands. So he should. 

The only problem in sight currently are pr0n-spammers who might abuse our system
for ads for their commercial interests. Hopefully, we stay out of sight ;-)


Customization
=============
You will probably want to change the logo and stuff. Currently there is no theming
system, so you might just want to change a bit here and there.
* Make a new logo pic and put it in the images folder. Update themes/petrol/stylesheet.css
accordingly
* Host name settings for contact messages etc come out of the box
* Setting the SYSTEM_NAME parameter in the configuration fill will cause all HTML pages to
  display this name as well.
* Create a 'Blue Pile' (Blauwberg) user. This is a virtual user representing the outside world
where exhausts and sours end. Pay yourself from this user with Blue for whatever you exhaust.
You should not take Red or Green from Blue Pile. 
* If you want to run multiple rgbtrade systems on the same domain, you must manually edit includes/rgbtop.php
and edit the following line:
if(!isset($_SESSION)) {
    session_set_cookie_params(3600,'/');
     session_start();
}
In line 2, replace the / with the path on the url this system is on eg, '/demo-nl'  or '/test122'.



Translations
===========
English and Dutch are currently supported. The system is easloly able to support your language as well.
Read README-translations.txt for support.


Updates and Problems
====================
This project is approaching Beta, i.e. we are going live with a test
site on rgboog.nl . This release has been sent out for test & try 
purposes.  Currently there is no automatic install or upgrade policy. 
If you intend to go live with it, please inform the author. In that 
case you may be supplied with the updates you may need.

Contact
=======
If you stumble upon problems or have any remarks, please don't hesitate. Just
send an email to post @ kleureneconomie.nl . I'll be happy to hear from you.

License
=======
This package is licensed under the GPL v3 or later. However, it contains code from 
other developers which are licensed under their own but compatible license:
* pagedresults class.  by sitepoint.com. Unclear license but thanks. Code distributed unchanged.
* PHP-gettext by Stephen Armstrong. GPL v2.
* forms class.  by Manuel Lemos.  BSD Style license. Code distributed unchanged.
* sack, simple ajax code-kit by Gregory Wild-Smith (http://www.twilightuniverse.com/) 
  GPL License. Code distrubuted unchanged


Thank you for using this!

=============
End of Readme
=============
