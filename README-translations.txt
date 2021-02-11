Readme for Translators and translation system workers.
That means: how to remind myself of what we are doing.

1. Assumptions.
It is assumed that we are on a php webserver like apache without gettext support. Because usually cheap web hosts are neglective to
support gettext and to support all desired languages. So we are going with php-gettext from http://savannah.nongnu.org/projects/php-gettext/

2. Starting off.
The rgbtrade started off as a Dutch-only project to increase initial development speed. Now, we have to pay the price. That's how it is. In the winter of 2007-2008, all texts have (or have not) been translates straight to English. Here and there the code has been improved a bit, to avoid deep trouble
or readibility problems. But do not expect clean code.

The configuration files rgbConfig.php and the example file have been extended according to the examples given by php-gettext. A directory tree was made to support two initial languages:
* en_US, the desired main target language, default.
* nl_NL, to offer the original language again

The first release of the gettext improved code should at least support nl_NL and en_US. 

3. Creating translation files
The way of working described at various internet sites to create the .mo and .po gettext files is quite complex and contains spread-around information. Here is the place to memorize our unix commands to get things going next time as well.

a. Marking of code.
All code that is to be translaten should already be requesting gettext, i.e. the text is already within some gettext command, such as T_("...").
Note that we are using the following gettext commands (all starting with T_:
T_("foo");
.. etc plural..




b. Updating the rgbtrade.po file
There is a rgbtrade.po working source in the work directory. After making changes to the php source code, this file should be updated with the following command. It will update all the files listed in files.txt

xgettext -l php -f work/files.txt --from-code=UTF-8   --keyword=T_  -j work/rgbtrade.po  -o work/rgbtrade.po 

Whenever the file rgbtrade.po appears not to be updated, please check that there is not another header block somewhere at the end of the file.


4. Translating.
Open the .po file and update the empty strings. Please hold striclty to notation. You may encounter %s codes, that is where (ususlly hyperlink) html code will be inserted. Please keep the %s in the translation unchanged.

If you start off with a new language, edit rgbConfig.php in the includes folder, and update the following:
 * find out the correct locale name for your language, which is lang_STYLE (portugese_BRAZILIAN, in short: pt_BR)
 * add yours to  
      $supported_locales = array('en_US', 'nl_NL');
   Also, update rgbConfig-example.php to contain the new version.

 * change the line
      define('DEFAULT_LOCALE', 'nl_NL'); 
 * Make new folders in the includes/locale structure: lang_LANG/LC_MESSAGES

 The name of the RGB concept itself is something to translate with a bit more care. In the original dutch language and in the english version, RGB is the abbreviation for RedGreenBlue: the three used colors of Rainbow Trading / Color Economics. Furthermore, the word for Rainbow in Dutch, regenboog, does contain all the characters of RGB. Hence: rgbtrade. In French, I see problems, because Red=rouge, Green=vert, Blue=bleu. RVB. But a rainbow is an arc-en-ciel.  The French will need to come up with their own thing. Bon Voyage. 

     The bottom line: pick your own names, colors and make a logo for it. E.g. when going to German, make it RGBratwurst (rg-sausage). You will have a nice logo and lots of attention. Maybe, rgbeer will do, or something you come up with is what is best for you. 



5. Using the translation: Creating the mo file.
Copy the translated rgbtrade.po file over to its desired location. make sure you now use the

 cp work/rgbtrade.po includes/locale/nl_NL/LC_MESSAGES/nl_NL.po

We already have an rgbtrade.po file filled with translations. It is not good for the webserver/php to be read. It has to be re-encoded to the .mo format with the following command:

msgfmt  includes/locale/nl_NL/LC_MESSAGES/nl_NL.po  -o includes/locale/nl_NL/LC_MESSAGES/nl_NL.mo

6. Fast Way
This is all far too much to remember. In the work folder, there's a script called update-po.sh. Run it in your bash shell after every update in a language file.

 f. Test
 After updating the .mo file, under apache/linux at least, the new version should run immediately. Enjoy!



