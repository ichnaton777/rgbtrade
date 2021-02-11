drop table if exists rgbAds;

create table rgbAds (
  adId INT not null auto_increment,
  adUserid int not null,  
  adStatus enum ("live","invisible") default "live",
  adSubject varchar(256) default "",
  adText  text,
  adThumbImage blob,
  adBigImage blob,
  adLastChange timestamp,
  adOfferRequest enum("offer","request"),
  adRedValue float not null default 0,
  adGreenValue float not null default 0,
  adBlueValue float not null default 0,
  primary key (adId),
  fulltext (adSubject, adText)
  );

drop table if exists rgbUsers;

create table rgbUsers (
   userId int not null  auto_increment,
   userNick varchar (40) not null default '',
   userEmail varchar(40),
   userAddress varchar(40),
   userZipCode varchar(40),
   userCity varchar(40),
   userRegion varchar(40),
   userWebsite varchar(40),
   userGPS varchar(40),
   userPassword varchar(255),
   userPlan text,
   userAvatar blob,
   userStatus enum ('toverify','live','silent','forgotten','system') default 'toverify' ,
   primary key (userId),
   fulltext (userNick), 
   fulltext (userEmail), 
   fulltext (userZipCode), 
   fulltext (userCity), 
   fulltext (userRegion), 
   fulltext (userWebsite),
   fulltext (userPlan)
   );
insert into rgbUsers ( userId, userNick, userStatus) values (0, "system","system") ;



drop table if exists rgbBalances;

create table rgbBalances (
   balanceId int not null auto_increment,
   balanceDateTime timestamp,
   balanceRedValue float,
   balanceGreenValue float,
   balanceBlueValue  float,
   balanceLastTransactionId int,
   balanceUserId int not null,
   balanceType enum ('running','milestone'),
   primary key (balanceid),
   index (balanceUserId)
   );

drop table if exists rgbTransactions;
CREATE TABLE IF NOT EXISTS `rgbTransfers` (
      `transferId` int(11) NOT NULL auto_increment,
      `transferFromId` int(11) NOT NULL,
      `transferToId` int(11) NOT NULL,
      `transferDateTime` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
      `transferText` text,
      `transferRedValue` float default NULL,
      `transferGreenValue` float default NULL,
      `transferBlueValue` float default NULL,
      `transferStatus` enum('sent','done','undone') default 'done',
      `transferById` int(11) default NULL,
      PRIMARY KEY  (`transferId`),
      KEY `transferFromId` (`transferFromId`),
      KEY `transferToId` (`transferToId`),
      KEY `transferStatus` (`transferStatus`),
      KEY `transferDateTime` (`transferDateTime`),
      KEY `transferById` (`transferById`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;


drop table if exists rgbAdCategories ;
create table rgbAdCategories (
  adCategoryId int not null auto_increment,
  adCategoryTitle varchar(64),
  adCategorySuperId int default 0,
  adCategoryText text,
  primary key(adCategoryId),
  fulltext (adCategoryText)
  );



drop table if exists rgbUserPreference;
create table rgbUserPreference (
  userPreferenceId INT not null  auto_increment,
  userId int not null default 0,
  userPreferenceName varchar(32),
  userPreferenceValue varchar(32),
  index (userPreferenceId),
  index (userId,userPreferenceName)

);

insert into rgbUserPreference ( userPreferenceId, userId,  userPreferenceName, userPreferenceValue) 
values  (0,0, "systemname","RGBoog");
