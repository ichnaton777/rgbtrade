-- phpMyAdmin SQL Dump
-- version 2.10.3deb1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generatie Tijd: 25 Nov 2007 om 11:19
-- Server versie: 5.0.45
-- PHP Versie: 5.2.3-1ubuntu6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Database: 'rgb'
-- 

-- --------------------------------------------------------

-- 
-- Tabel structuur voor tabel 'rgbAdCategories'
-- 

CREATE TABLE rgbAdCategories (
  adCategoryId int(11) NOT NULL auto_increment,
  adCategoryTitleEn varchar(32) default NULL,
  adCategoryTitleNl varchar(32) default NULL,
  adCategoryParentId int(11) default NULL,
  adCategoryText text,
  adCategoryStatus enum('available','unavailable') default 'available',
  adCategoryMainColour enum('red','green','blue','none') default NULL,
  PRIMARY KEY  (adCategoryId),
  KEY adCategoryTitleEn (adCategoryTitleEn),
  KEY adCategoryTitleNl (adCategoryTitleNl),
  FULLTEXT KEY adCategoryText (adCategoryText)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Tabel structuur voor tabel 'rgbAds'
-- 

CREATE TABLE rgbAds (
  adId int(11) NOT NULL auto_increment,
  adUserid int(11) NOT NULL,
  adStatus enum('live','invisible') default 'live',
  adTitle text,
  adText text,
  adLastChange timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  adOfferRequest enum('offer','request') default NULL,
  adRedValue float NOT NULL default '0',
  adGreenValue float NOT NULL default '0',
  adBlueValue float NOT NULL default '0',
  adThumbImage varchar(256) default NULL,
  adBigImage varchar(256) default NULL,
  adGroupId int(11) NOT NULL default '0',
  adCategoryId int(11) NOT NULL default '0',
  adMainColour enum('unset','red','green','blue') default NULL,
  PRIMARY KEY  (adId),
  KEY adGroupId (adGroupId),
  KEY adCategoryies (adCategoryId,adGroupId),
  KEY adCategoryId (adCategoryId),
  KEY adUserid (adUserid),
  FULLTEXT KEY adSubject (adTitle,adText)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Tabel structuur voor tabel 'rgbBalances'
-- 

CREATE TABLE rgbBalances (
  balanceId int(11) NOT NULL auto_increment,
  balanceDateTime timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  balanceRedValue float NOT NULL default '0',
  balanceGreenValue float NOT NULL default '0',
  balanceBlueValue float NOT NULL default '0',
  balanceLastTransferId int(11) default NULL,
  balanceUserId int(11) NOT NULL,
  balanceType enum('running','milestone') default NULL,
  PRIMARY KEY  (balanceId),
  KEY balanceUserId (balanceUserId)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Tabel structuur voor tabel 'rgbTransfers'
-- 

CREATE TABLE rgbTransfers (
  transferId int(11) NOT NULL auto_increment,
  transferFromId int(11) NOT NULL,
  transferToId int(11) NOT NULL,
  transferDateTime timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  transferText text,
  transferRedValue float default NULL,
  transferGreenValue float default NULL,
  transferBlueValue float default NULL,
  transferStatus enum('sent','done','undone') default 'done',
  transferById int(11) default NULL,
  PRIMARY KEY  (transferId),
  KEY transferFromId (transferFromId),
  KEY transferToId (transferToId),
  KEY transferStatus (transferStatus),
  KEY transferDateTime (transferDateTime),
  KEY transferById (transferById)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Tabel structuur voor tabel 'rgbUsers'
-- 

CREATE TABLE rgbUsers (
  userId int(11) NOT NULL auto_increment,
  userNick varchar(40) NOT NULL default '',
  userEmail varchar(60) default NULL,
  userAddress varchar(40) default NULL,
  userAddress2 varchar(40) default NULL,
  userZipCode varchar(40) default NULL,
  userCity varchar(40) default NULL,
  userRegion varchar(40) default NULL,
  userWebsite varchar(40) default NULL,
  userGpsLongitude varchar(40) default NULL,
  userGpsLattitude varchar(40) default NULL,
  userPassword varchar(255) default NULL,
  userPlan text,
  userAvatar varchar(120) default NULL,
  userStatus enum('toverify','live','silent','forgotten','system') default 'toverify',
  userSessionID char(50) default NULL,
  userLastLog datetime default NULL,
  userPhone1 varchar(12) default NULL,
  userPhone2 varchar(12) default NULL,
  userBirth datetime NOT NULL default '2007-07-07 00:00:00',
  userVerify varchar(64) default NULL,
  PRIMARY KEY  (userId),
  UNIQUE KEY userNick (userNick),
  UNIQUE KEY userEmail (userEmail),
  KEY userId (userId),
  KEY userStatus (userStatus),
  FULLTEXT KEY userZipCode (userZipCode),
  FULLTEXT KEY userCity (userCity),
  FULLTEXT KEY userRegion (userRegion),
  FULLTEXT KEY userWebsite (userWebsite),
  FULLTEXT KEY userPlan (userPlan)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

INSERT INTO `rgbUsers` ( `userId` , `userNick` , `userEmail` , `userAddress` , `userAddress2` , `userZipCode` , `userCity` , `userRegion` , `userWebsite` , `userGpsLongitude` , `userGpsLattitude` , `userPassword` , `userPlan` , `userAvatar` , `userStatus` , `userSessionID` , `userLastLog` , `userPhone1` , `userPhone2` , `userBirth` , `userVerify` )
VALUES (
    '1', 'blauwberg', NULL , NULL , NULL , NULL , NULL , NULL , NULL , NULL , NULL , NULL , 'Blauwberg is een symbolische gebruiker. Als je een lozing doet via een uitlaat of riool, dan kun je die registreren door een betaling van Blauwberg naar jezelf te doen. Je mag alleen blauw overboeken. Haal je terug van de Blauwberg wat er eerder in is gestort, dan mag je dat terugboeken.', NULL , 'system', NULL , NULL , NULL , NULL , '2007-07-07 00:00:00', NULL
);
