-- phpMyAdmin SQL Dump
-- version 2.10.3deb1ubuntu0.2
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generatie Tijd: 10 Mei 2008 om 06:12
-- Server versie: 5.0.45
-- PHP Versie: 5.2.3-1ubuntu6.3
-- 
-- version 0.3, half complete categories list
-- 

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Database: `rgboog`
-- 

-- --------------------------------------------------------

-- 
-- Tabel structuur voor tabel `rgbAdCategories`
-- 
-- Gecreëerd: 01 Mei 2008 om 15:14
-- Laatst bijgewerkt: 08 Mei 2008 om 22:56
-- Laatst gecontroleerd: 01 Mei 2008 om 15:14
-- 

CREATE TABLE IF NOT EXISTS `rgbAdCategories` (
  `adCategoryId` int(11) NOT NULL auto_increment,
  `adCategoryTitleEn` varchar(32) default NULL,
  `adCategoryTitleNl` varchar(32) default NULL,
  `adCategoryParentId` int(11) default NULL,
  `adCategoryText` text,
  `adCategoryStatus` enum('available','unavailable') default 'available',
  PRIMARY KEY  (`adCategoryId`),
  KEY `adCategoryTitleEn` (`adCategoryTitleEn`),
  KEY `adCategoryTitleNl` (`adCategoryTitleNl`),
  KEY `catParents` (`adCategoryParentId`),
  FULLTEXT KEY `adCategoryText` (`adCategoryText`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1396 ;

-- 
-- Gegevens worden uitgevoerd voor tabel `rgbAdCategories`
-- 

INSERT INTO `rgbAdCategories` (`adCategoryId`, `adCategoryTitleEn`, `adCategoryTitleNl`, `adCategoryParentId`, `adCategoryText`, `adCategoryStatus`) VALUES 
(1048, 'Music Instruments', 'Muziek Instrumenten', 1, NULL, 'available'),
(1047, 'Scooters', 'Scooters & Brommers', 1, NULL, 'available'),
(1046, 'Clothing & Shoes', 'Kleding & Schoenen', 1, NULL, 'available'),
(1045, 'Kids & Babies', 'Kinderen & Baby', 1, NULL, 'available'),
(1044, 'Home & Furnishing', 'Huis & Inrichting', 1, NULL, 'available'),
(1043, 'Hobbies & Leisure', 'Hobby & Vrije Tijd', 1, NULL, 'available'),
(1049, 'Sports & Fitness', 'Sport & Fitness', 1, NULL, 'available'),
(1, 'Universal Super Group', 'Universele SuperGroep', 0, NULL, 'unavailable'),
(1042, 'Photography', 'Fotografie', 1, NULL, 'available'),
(1041, 'Bikes', 'Fietsen', 1, NULL, 'available'),
(1040, 'Electronics & White Goods', 'Electronica & Witgoed', 1, NULL, 'available'),
(1039, 'Animals', 'Dieren', 1, NULL, 'available'),
(1038, 'Computers Software', 'Computers Software', 1, NULL, 'available'),
(1037, 'Computers Hardware', 'Computers Hardware', 1, NULL, 'available'),
(1036, 'Camping', 'Kamperen', 1, NULL, 'available'),
(1035, 'Garden', 'Tuin', 1, NULL, 'available'),
(1034, 'Construction', 'Bouw', 1032, NULL, 'unavailable'),
(1033, 'Books & Magazines', 'Boeken & Tijdschriften', 1, NULL, 'available'),
(1032, 'Jobs, Services & Work', 'Werk, Diensten & Klussen', 1, NULL, 'available'),
(1031, 'Cars', 'Auto', 1, NULL, 'available'),
(2, 'Please Update Group', 'Groep aub aanpassen', 1, 'Temporary group due to reconstruction work', 'available'),
(1028, 'Antiques, Arts & Jewellery', 'Antiek, Kunst & Sieraden', 1, NULL, 'available'),
(1029, 'Audio, TV, Video', 'Audio, TV, Video', 1, NULL, 'available'),
(1050, 'Telecom', 'Telecom', 1037, NULL, 'available'),
(1051, 'Holiday & Tourism', 'Vakantie & Tourisme', 1, NULL, 'available'),
(1052, 'Collections', 'Verzamelen', 1, NULL, 'available'),
(1053, 'Watersports & Boats', 'Watersport & Boten', 1, NULL, 'available'),
(1054, 'Houses', 'Woningen', 1, NULL, 'available'),
(1055, 'Business', 'Zakelijk', 1, NULL, 'available'),
(1056, 'Other', 'Diversen', 1, NULL, 'available'),
(1057, 'Cover', 'Bestek', 1028, NULL, 'available'),
(1058, 'Books & Bibles', 'Boeken en Bijbels', 1028, NULL, 'available'),
(3, 'Please Update Category', 'Categorie aub aanpassen', 2, 'Temporary group due to reconstruction work', 'available'),
(1059, 'Enamel', 'Emaille', 1028, NULL, 'available'),
(1060, 'Useful Objects', 'Gebruiksvoorwerpen', 1028, NULL, 'available'),
(1061, 'Tools', 'Gereedschap', 1028, NULL, 'available'),
(1062, 'Glass & Crystal', 'Glas & Kristal', 1028, NULL, 'available'),
(1063, 'Watches', 'Horloges', 1028, NULL, 'available'),
(1064, 'Ceramics & Pottery', 'Keramiek & Aardewerk', 1028, NULL, 'available'),
(1065, 'Clothing', 'Kleding', 1028, NULL, 'available'),
(1066, 'Clocks', 'Klokken', 1028, NULL, 'available'),
(1067, 'Copper & Silver', 'Koper & Zilver', 1028, NULL, 'available'),
(1068, 'Lamps', 'Lampen', 1028, NULL, 'available'),
(1069, 'Beds', 'Bedden', 1028, NULL, 'available'),
(1070, 'Chairs & Benches', 'Stoelen & Banken', 1028, NULL, 'available'),
(1071, 'Tables', 'Tafels', 1028, NULL, 'available'),
(1072, 'Sewing Machines', 'Naaimachines', 1028, NULL, 'available'),
(1073, 'Porceline', 'Porcelein', 1028, NULL, 'available'),
(1074, 'Religion', 'Religie', 1028, NULL, 'available'),
(1075, 'Dishes & Bowls', 'Schalen', 1028, NULL, 'available'),
(1076, 'Dinner & Tea Sets', 'Serviezen', 1028, NULL, 'available'),
(1077, 'Ornaments', 'Sieraden', 1028, NULL, 'available'),
(1078, 'Toys', 'Speelgoed', 1028, NULL, 'available'),
(1079, 'TV & Audio', 'TV & Audio', 1028, NULL, 'available'),
(1080, 'Vases', 'Vazen', 1028, NULL, 'available'),
(1081, 'Wall-signs & Tiles', 'Wandborden & Tegels', 1028, NULL, 'available'),
(1082, 'Other Antiques', 'Overige Antiek4', 1028, NULL, 'unavailable'),
(1083, 'Curiosa', 'Curiosa', 1028, NULL, 'available'),
(1084, 'Statues & Woodcarvings', 'Beelden & Houtsnijwerk', 1028, NULL, 'available'),
(1085, 'Design Objects', 'Design Objecten', 1028, NULL, 'available'),
(1086, 'Etches & Engravings', 'Etsen & Gravures', 1028, NULL, 'available'),
(1087, 'Lithos', 'Litho''s & Zeefdrukken', 1028, NULL, 'available'),
(1088, 'Paintings', 'Schilderijen', 1028, NULL, 'available'),
(1089, 'Drawings and Photos', 'Tekeningen en Foto''s', 1028, NULL, 'available'),
(1090, 'Other', 'Overige', 1028, NULL, 'available'),
(1091, 'Bradelets', 'Armbanden', 1028, NULL, 'available'),
(1092, 'Chains', 'Kettingen', 1028, NULL, 'available'),
(1093, 'Earrings', 'Oorbellen', 1028, NULL, 'available'),
(1094, 'Rings', 'Ringen', 1028, NULL, 'available'),
(1095, 'Tape Recorders', 'Bandrecorders', 1029, NULL, 'available'),
(1096, 'Amplifiers', 'Versterkers', 1029, NULL, 'available'),
(1097, 'Cassette Decks', 'Cassette Decks', 1029, NULL, 'available'),
(1098, 'CD, DVD, LP', 'CD, DVD, LP', 1, NULL, 'available'),
(1099, 'CD-players', 'CD-Spelers', 1029, NULL, 'available'),
(1100, 'Repairs', 'Reparaties', 1, NULL, 'available'),
(1101, 'Home Cinema Sets', 'Home Cinema Sets', 1029, NULL, 'available'),
(1102, 'Headphones & Headsets', 'Koptelefoons & Headsets', 1029, NULL, 'available'),
(1103, 'Loudspeakers', 'Luidsprekers', 1029, NULL, 'available'),
(1104, 'Portable (mp3, ipod, mp4)', 'Portable (mp3, ipod, mp4)', 1029, NULL, 'available'),
(1105, 'Record Players & Pick-ups', 'Platenspelers & Pick-Ups', 1029, NULL, 'available'),
(1106, 'Professional Equipment', 'Professionele Apparatuur', 1029, NULL, 'available'),
(1107, 'Radios', 'Radio''s', 1029, NULL, 'available'),
(1108, 'Satellite', 'Satelliet', 1029, NULL, 'available'),
(1109, 'Stereo-sets', 'Stereo-sets', 1029, NULL, 'available'),
(1110, 'Tuners & Receivers', 'Tuners & Receivers', 1029, NULL, 'available'),
(1111, 'Television', 'Televisies', 1029, NULL, 'available'),
(1112, 'Video Surveillance Cameras', 'Video Bewakings Camera''s', 1029, NULL, 'available'),
(1113, 'Video Cameras', 'Video Camera''s', 1029, NULL, 'available'),
(1114, 'Video Projectors & Beamers', 'Video Projectoren & Beamers', 1029, NULL, 'available'),
(1115, 'Other', 'Overige', 1029, NULL, 'available'),
(1116, 'Video Players & Recorders', 'Video Spelers & Recorders', 1029, NULL, 'available'),
(1117, 'Other', 'Overige', 1032, NULL, 'available'),
(1118, 'Passenger Car', 'Personen Auto', 1031, NULL, 'available'),
(1119, 'Trucks', 'Vrachtwagens', 1031, NULL, 'available'),
(1120, 'Motor Bikes', 'Motoren', 1031, NULL, 'available'),
(1121, 'Car Parts', 'Auto Onderdelen', 1031, NULL, 'available'),
(1122, 'Car Accessories', 'Auto Accessoires', 1029, NULL, 'available'),
(1123, 'Trailers', 'Aanhangers', 1031, NULL, 'available'),
(1124, 'Alarm Equipment', 'Alarminstallaties', 1031, NULL, 'available'),
(1125, 'Care - General', 'Zorg - Algemeen', 1032, NULL, 'available'),
(1126, 'Care - Kids -  Babysit', 'Zorg - Kinderen - Oppas', 1032, NULL, 'available'),
(1127, 'Education', 'Onderwijs', 1032, NULL, 'available'),
(1128, 'Construction', 'Bouw', 1032, NULL, 'available'),
(1129, 'Transports & Traffic', 'Transport & Verkeer', 1032, NULL, 'available'),
(1130, 'Trade & Sales', 'Handel & Verkoop', 1032, NULL, 'available'),
(1131, 'Care - Health', 'Zorg - Gezondheid', 1032, NULL, 'available'),
(1132, 'Gardens & Argiculture', 'Tuinen & Landbouw', 1032, NULL, 'available'),
(1133, 'Office', 'Kantoor', 1032, NULL, 'available'),
(1134, 'Bars & Restaurants', 'Horeca', 1032, NULL, 'available'),
(1135, 'Technical', 'Techniek', 1032, NULL, 'available'),
(1136, 'Industry & Chemicals', 'Industrie & Chemie', 1032, NULL, 'available'),
(1137, 'Graphics Industry', 'Grafische Industrie', 1032, NULL, 'available'),
(1138, 'Textiles', 'Textiel', 1032, NULL, 'available'),
(1139, 'Services', 'Dienstverlening', 1032, NULL, 'available'),
(1140, 'IT & Internet', 'Automatisering & Internet', 1032, NULL, 'available'),
(1141, 'Recycling & Environment', 'Recycling & Milieu', 1032, NULL, 'available'),
(1142, 'Crafts & Artisans', 'Ambachten & Vaklieden', 1032, NULL, 'available'),
(1143, 'Spiritual & Esoteris', 'Spiritueel & Esoterisch', 1032, NULL, 'available'),
(1144, 'Charity', 'Goede Doelen', 1032, NULL, 'available'),
(1145, 'Atlasses & Maps', 'Atlassen & Kaarten', 1033, NULL, 'available'),
(1146, 'Cars & Motorbikes', 'Auto & Motoren', 1033, NULL, 'available'),
(1147, 'Adventure & Action', 'Avontuur & Actie', 1033, NULL, 'available'),
(1148, 'Biographies', 'BiografieÃ«n ', 1033, NULL, 'available'),
(1149, 'Food & Drinks', 'Voeding & Dranken', 1, NULL, 'available'),
(1150, 'Bread & Confectioning', 'Brood & Banket', 1149, NULL, 'available'),
(1151, 'Fruits & Vegetables', 'Groenten & Fruit', 1149, NULL, 'available'),
(1152, 'Dairy & Eggs', 'Zuivel & Eieren', 1149, NULL, 'available'),
(1153, 'Vegetarian', 'Vegetarisch', 1149, NULL, 'available'),
(1154, 'Meat, Fish, Game & Poultry', 'Vlees, Vis, Gevogelte & Wild', 1149, NULL, 'available'),
(1155, 'Tea & Coffee', 'Koffie & Thee', 1149, NULL, 'available'),
(1156, 'Juices & Drinks', 'Sappen & Dranken', 1149, NULL, 'available'),
(1157, 'Beer & Wines', 'Wijn & Bier', 1149, NULL, 'available'),
(1158, 'Spirits & Liquor ', 'Sterke Drank ', 1149, NULL, 'available'),
(1159, 'Seasons & Spices', 'Kruiden & Specerijen', 1149, NULL, 'available'),
(1160, 'Glasses & Lenses', 'Brillen & Lenzen', 1, NULL, 'available'),
(1161, 'Preserves', 'Conserven', 1149, NULL, 'available'),
(1162, 'Cereals & Meal', 'Granen & Meel', 1149, NULL, 'available'),
(1163, 'Rice', 'Rijst', 1149, NULL, 'available'),
(1164, 'Pasta', 'Pasta', 1149, NULL, 'available'),
(1165, 'Reading Glasses', 'Leesbrillen', 1160, NULL, 'available'),
(1166, 'Hard Lenses', 'Harde Lenzen', 1160, NULL, 'available'),
(1167, 'Soft Lenses', 'Zachte Lenzen', 1160, NULL, 'available'),
(1168, 'Glasses', 'Brillen', 1160, NULL, 'available'),
(1169, 'Sun Glasses', 'Zonnebrillen', 1160, NULL, 'available'),
(1170, 'Detectives', 'Detectives', 1033, NULL, 'available'),
(1171, 'Animals & Plants', 'Dieren & Planten', 1033, NULL, 'available'),
(1172, 'Economics', 'Economie', 1033, NULL, 'available'),
(1173, 'Esoterics & Spirituality', 'Esoterie & Spiritualiteit', 1033, NULL, 'available'),
(1174, 'Film. TV & Media', 'Film. TV & Media', 1033, NULL, 'available'),
(1175, 'Philosophy', 'Filosofie', 1033, NULL, 'available'),
(1176, 'Poems & Poetry', 'Gedichten & PoÃ«zie', 1033, NULL, 'available'),
(1177, 'History', 'Geschiedenis', 1033, NULL, 'available'),
(1178, 'Health & Medicine', 'Gezondheid & Medisch', 1033, NULL, 'available'),
(1179, 'Religion & Theology', 'Godsdienst & Theologie', 1033, NULL, 'available'),
(1180, 'Hobby & Leisure', 'Hobby & Vrije Tijd', 1033, NULL, 'available'),
(1181, 'Humor', 'Humor', 1033, NULL, 'available'),
(1182, 'Informatics & Computer', 'Informatica & Computer', 1033, NULL, 'available'),
(1183, 'Kids Books', 'Kinderboeken', 1033, NULL, 'available'),
(1184, 'Babies, Toddlers & Infants', 'Baby''s, Peuters& Kleuters', 1033, NULL, 'available'),
(1185, 'Cook books', 'Kookboeken', 1033, NULL, 'available'),
(1186, 'Art & Photography', 'Kunst & Fotografie', 1033, NULL, 'available'),
(1187, 'Literature', 'Literatuur', 1033, NULL, 'available'),
(1188, 'Music', 'Muziek', 1033, NULL, 'available'),
(1189, 'Politics & Society', 'Politiek & Maatschappij', 1033, NULL, 'available'),
(1190, 'Psychology', 'Psychologie', 1033, NULL, 'available'),
(1191, 'Travel', 'Reizen', 1033, NULL, 'available'),
(1192, 'Novels', 'Romans', 1033, NULL, 'available'),
(1193, 'Science Fiction & Fantasy', 'Science Fiction & Fantasy', 1033, NULL, 'available'),
(1194, 'Sports', 'Sport', 1033, NULL, 'available'),
(1195, 'Regional Novels', 'Streekromans', 1033, NULL, 'available'),
(1196, 'Comics', 'Strips', 1033, NULL, 'available'),
(1197, 'School Books', 'Schoolboeken', 1033, NULL, 'available'),
(1198, 'Study Books & Courses', 'Studieboeken & Cursussen', 1033, NULL, 'available'),
(1199, 'Language - English', 'Taal - English', 1033, NULL, 'available'),
(1200, 'Language - German', 'Taal - Duits', 1033, NULL, 'available'),
(1201, 'Language - French', 'Taal - Frans', 1033, NULL, 'available'),
(1202, 'Language - Spanish', 'Taal - Spaans', 1033, NULL, 'available'),
(1203, 'Language - Russian', 'Taal - Russisch', 1033, NULL, 'available'),
(1204, 'Language - Chinese', 'Taal - Chinees', 1033, NULL, 'available'),
(1205, 'Language - Hindi/Urdu', 'Taal - Hindi/Urdu', 1033, NULL, 'available'),
(1206, 'Language - Arabic', 'Taal - Arabisch', 1033, NULL, 'available'),
(1207, 'Language - Japanese', 'Taal - Japans', 1033, NULL, 'available'),
(1208, 'Language - Other', 'Taal - Overig', 1033, NULL, 'available'),
(1209, 'Technical', 'Techniek', 1033, NULL, 'available'),
(1210, 'Thrillers', 'Thrillers', 1033, NULL, 'available'),
(1211, 'Magazines & Newspapers', 'Tijdschriften & Kranten', 1033, NULL, 'available'),
(1212, 'Science', 'Wetenschap', 1033, NULL, 'available'),
(1213, 'Other', 'Overige', 1033, NULL, 'available'),
(1214, 'Tools & Instruments', 'Gereedschap & Werktuigen', 1, NULL, 'available'),
(1215, 'Dance', 'Dance', 1098, NULL, 'available'),
(1216, 'Jazz', 'Jazz', 1098, NULL, 'available'),
(1217, 'Blues', 'Blues', 1098, NULL, 'available'),
(1218, 'R&B', 'R&B', 1098, NULL, 'available'),
(1219, 'HipHop & Rap', 'HipHop & Rap', 1098, NULL, 'available'),
(1220, 'Rock & Metal', 'Rock & Metal', 1098, NULL, 'available'),
(1221, 'Classical', 'Klassiek', 1098, NULL, 'available'),
(1222, 'Pop', 'Pop', 1098, NULL, 'available'),
(1223, 'World Music', 'Wereld Muziek', 1098, NULL, 'available'),
(1224, 'Movies & Soundtracks', 'Films & Soundstracks', 1098, NULL, 'available'),
(1225, 'Other', 'Overig', 1098, NULL, 'available'),
(1226, 'Monitors', 'Monitoren', 1037, NULL, 'available'),
(1227, 'PC Systems', 'PC Systemen', 1037, NULL, 'available'),
(1228, 'Apple', 'Apple', 1037, NULL, 'available'),
(1229, 'Printers', 'Printers', 1037, NULL, 'available'),
(1230, 'Scanners', 'Scanners', 1037, NULL, 'available'),
(1231, 'Cables', 'Kabels', 1037, NULL, 'available'),
(1232, 'Keyboards', 'Toetsenborden', 1037, NULL, 'available'),
(1233, 'Laptops', 'Laptops', 1037, NULL, 'available'),
(1234, 'Game Computers', 'Spel Computers', 1037, NULL, 'available'),
(1235, 'Networking Equipment', 'Netwerk Apparatuur', 1037, NULL, 'available'),
(1236, 'Processors', 'Processoren', 1037, NULL, 'available'),
(1237, 'Storage', 'Opslag', 1037, NULL, 'available'),
(1238, 'Memory', 'Geheugen', 1037, NULL, 'available'),
(1239, 'Multimedia', 'Multimedia', 1037, NULL, 'available'),
(1240, 'Nintendo', 'Nintendo', 1038, NULL, 'available'),
(1241, 'Sony Playstation', 'Sony Playstation', 1038, NULL, 'available'),
(1242, 'Sony PSP', 'Sony PSP', 1038, NULL, 'available'),
(1243, 'Wii', 'Wii', 1038, NULL, 'available'),
(1244, 'PC Games', 'PC Games', 1038, NULL, 'available'),
(1245, 'GNU/Linux', 'GNU/Linux', 1038, NULL, 'available'),
(1246, 'Navigation & Maps', 'Navigatie & Kaarten', 1038, NULL, 'available'),
(1247, 'Navigation & Traffic', 'Navigatie & Verkeer', 1037, NULL, 'available'),
(1248, 'Other', 'Overig', 1037, NULL, 'available'),
(1249, 'Car Technicians', 'Auto Monteurs', 1032, NULL, 'unavailable'),
(1250, 'Coarses & Workshops', 'Cursussen & Workshops', 1032, NULL, 'available'),
(1251, 'Do It Yourself', 'Doe Het Zelf', 1032, NULL, 'available'),
(1252, 'Care - Animals', 'Zorg - Dieren', 1032, NULL, 'available'),
(1253, 'Repairs - Computers', 'Reparaties - Computers', 1032, NULL, 'available'),
(1254, 'Repairs - Cars', 'Reparaties - Auto''s', 1032, NULL, 'available'),
(1255, 'Repairs - Household Machines', 'Reparaties - Witgoed', 1032, NULL, 'available'),
(1256, 'Repairs - Bikes', 'Reparaties - Fietsen', 1032, NULL, 'available'),
(1257, 'Party', 'Feesten', 1032, NULL, 'available'),
(1258, 'Care -  Domestic', 'Zorg - Huishoudelijk', 1032, NULL, 'available'),
(1259, 'Recycling & Returning', 'Recycling & Inzameling', 1029, NULL, 'available'),
(1260, 'Recycling & Returning', 'Recycling & Inzameling', 1028, NULL, 'available'),
(1261, 'Recycling & Returning', 'Recycling & Inzameling', 1031, NULL, 'available'),
(1262, 'Recycling & Returning', 'Recycling & Inzameling', 1033, NULL, 'available'),
(1263, 'Recycling & Returning', 'Recycling & Inzameling', 1160, NULL, 'available'),
(1264, 'Recycling & Returning', 'Recycling & Inzameling', 1098, NULL, 'available'),
(1265, 'Recycling & Returning', 'Recycling & Inzameling', 1037, NULL, 'available'),
(1266, 'Recycling & Returning', 'Recycling & Inzameling', 1038, NULL, 'available'),
(1267, 'Recycling & Returning', 'Recycling & Inzameling', 1039, NULL, 'available'),
(1268, 'Recycling & Returning', 'Recycling & Inzameling', 1056, NULL, 'available'),
(1269, 'Recycling & Returning', 'Recycling & Inzameling', 1040, NULL, 'available'),
(1270, 'Recycling & Returning', 'Recycling & Inzameling', 1041, NULL, 'available'),
(1271, 'Recycling & Returning', 'Recycling & Inzameling', 1042, NULL, 'available'),
(1272, 'Recycling & Returning', 'Recycling & Inzameling', 1043, NULL, 'available'),
(1273, 'Recycling & Returning', 'Recycling & Inzameling', 1214, NULL, 'available'),
(1274, 'Recycling & Returning', 'Recycling & Inzameling', 1044, NULL, 'available'),
(1275, 'Recycling & Returning', 'Recycling & Inzameling', 1036, NULL, 'available'),
(1276, 'Recycling & Returning', 'Recycling & Inzameling', 1045, NULL, 'available'),
(1277, 'Recycling & Returning', 'Recycling & Inzameling', 1046, NULL, 'available'),
(1278, 'Recycling & Returning', 'Recycling & Inzameling', 1048, NULL, 'available'),
(1279, 'Recycling & Returning', 'Recycling & Inzameling', 1047, NULL, 'available'),
(1280, 'Recycling & Returning', 'Recycling & Inzameling', 1049, NULL, 'available'),
(1281, 'Recycling & Returning', 'Recycling & Inzameling', 1035, NULL, 'available'),
(1282, 'Recycling & Returning', 'Recycling & Inzameling', 1051, NULL, 'available'),
(1283, 'Recycling & Returning', 'Recycling & Inzameling', 1052, NULL, 'available'),
(1284, 'Recycling & Returning', 'Recycling & Inzameling', 1149, NULL, 'available'),
(1285, 'Recycling & Returning', 'Recycling & Inzameling', 1053, NULL, 'available'),
(1286, 'Recycling & Returning', 'Recycling & Inzameling', 1054, NULL, 'available'),
(1287, 'Recycling & Returning', 'Recycling & Inzameling', 1055, NULL, 'available'),
(1288, 'Music & Entertainment', 'Muziek & Entertainment', 1032, NULL, 'available'),
(1289, 'Basic Materials', 'Grondstoffen', 1028, NULL, 'available'),
(1290, 'Basic Materials', 'Grondstoffen', 1029, NULL, 'available'),
(1291, 'Basic Materials', 'Grondstoffen', 1031, NULL, 'available'),
(1292, 'Basic Materials', 'Grondstoffen', 1033, NULL, 'available'),
(1293, 'Basic Materials', 'Grondstoffen', 1160, NULL, 'available'),
(1294, 'Basic Materials', 'Grondstoffen', 1098, NULL, 'available'),
(1295, 'Basic Materials', 'Grondstoffen', 1037, NULL, 'available'),
(1296, 'Basic Materials', 'Grondstoffen', 1039, NULL, 'available'),
(1297, 'PC / Windows', 'PC / Windows', 1038, NULL, 'available'),
(1298, 'Water', 'Water', 1149, NULL, 'available'),
(1299, 'Basic Materials', 'Grondstoffen', 1, NULL, 'available'),
(1300, 'Energy - Electric', 'Energie - Electrisch', 1299, NULL, 'available'),
(1301, 'Energy - Coal', 'Energie - Kolen', 1299, NULL, 'available'),
(1302, 'Energy - Crude Oil', 'Energie - Ruwe Olie', 1299, NULL, 'available'),
(1303, 'Energy - Fuels', 'Energie - Vloeibaar', 1299, NULL, 'available'),
(1304, 'Energy - Turf', 'Energie - Turf', 1299, NULL, 'available'),
(1305, 'Energy - Gas', 'Energie - Gas', 1299, NULL, 'available'),
(1306, 'Timber', 'Hout', 1299, NULL, 'available'),
(1307, 'Metals', 'Metalen', 1299, NULL, 'available'),
(1308, 'Aquaria', 'Aquaria', 1039, NULL, 'available'),
(1309, 'Kennels & Cages - Dogs', 'Hokken & Kooien - Honden', 1039, NULL, 'available'),
(1310, 'Pet Food', 'Diervoeders', 1039, NULL, 'available'),
(1311, 'Sheep & Goats', 'Schapen & Geiten', 1039, NULL, 'available'),
(1312, 'Kennels & Cages - Rodents', 'Hokken & Kooien - Knaagdier', 1039, NULL, 'available'),
(1313, 'Kennels & Cages - Birds', 'Hokken & Kooien - Vogels', 1039, NULL, 'available'),
(1314, 'Dogs & Puppies - Shepherds', 'Honden & Puppies - Herders', 1039, NULL, 'available'),
(1315, 'Dogs & Puppies - Labradors', 'Honden & Puppies - Labradors', 1039, NULL, 'available'),
(1316, 'Dogs & Puppies - Other', 'Hokken & Kooien - Overig', 1039, NULL, 'available'),
(1317, 'Cats & Kittens', 'Katten & Kittens', 1039, NULL, 'available'),
(1318, 'Rodents', 'Knaagdieren', 1039, NULL, 'available'),
(1319, 'Rabbits', 'Konijnen', 1039, NULL, 'available'),
(1320, 'Horses', 'Paarden', 1039, NULL, 'available'),
(1321, 'Ponies', 'Pony''s', 1039, NULL, 'available'),
(1322, 'Horses - Clothing & Boots', 'Paarden - Kleding & Laarzen', 1039, NULL, 'available'),
(1323, 'Horses - Saddles', 'Paarden - Zadels', 1, NULL, 'available'),
(1324, 'Horses - Carriages', 'Paarden - Rijtuigen', 1039, NULL, 'available'),
(1325, 'Horses - Trailers', 'Paarden - Aanhangers', 1039, NULL, 'available'),
(1326, 'Horses - Accessoires', 'Paarden - Accessoires', 1, NULL, 'available'),
(1327, 'Poultry', 'Pluimvee', 1039, NULL, 'available'),
(1328, 'Reptiles & Amphibians', 'Reptielen & AmfibieÃ«n ', 1039, NULL, 'available'),
(1329, 'Horses - Stables & Pasture', 'Paarden - Stallen & Weide', 1039, NULL, 'available'),
(1330, 'Terraria', 'Terraria', 1039, NULL, 'available'),
(1331, 'Cattle - Other', 'Vee - Overige', 1039, NULL, 'available'),
(1332, 'Lost & Found', 'Gevonden & Verloren', 1039, NULL, 'available'),
(1333, 'Fish - Aquariumfish', 'Vissen - Aquariumvissen', 1039, NULL, 'available'),
(1334, 'Fish - Pondfish', 'Vissen - Vijvervissen', 1039, NULL, 'available'),
(1335, 'Birds - Pidgeons', 'Vogels - Duiven', 1039, NULL, 'available'),
(1336, 'Birds - Canaries', 'Vogels - Kanaries', 1039, NULL, 'available'),
(1337, 'Vogels - Parakeets', 'Vogels - Parkieten', 1039, NULL, 'available'),
(1338, 'Birds - Parrots', 'Vogels - Papegaaien', 1039, NULL, 'available'),
(1339, 'Birds - Other', 'Vogels - Overig', 1039, NULL, 'available'),
(1340, 'Other', 'Overig', 1039, NULL, 'available'),
(1341, 'Kitchen - Hoods', 'Keuken - Afzuigkappen', 1040, NULL, 'available'),
(1342, 'Kitchen - Hobs', 'Keuken - Kookplaten', 1040, NULL, 'available'),
(1343, 'Kitchen - Ovens & Grills', 'Keuken - Ovens & Grills', 1040, NULL, 'available'),
(1344, 'Kitchen - Dishwasher', 'Keuken - Afwasmachine', 1040, NULL, 'available'),
(1345, 'Kitchen - Fridges & Freezers', 'Keuken - Koelen en Vriezen', 1040, NULL, 'available'),
(1346, 'Kitchen - Dishwashers', 'Keuken - Vaatwassers', 1040, NULL, 'available'),
(1347, 'Wash - Dryers', 'Wassen - Drogers', 1040, NULL, 'available'),
(1348, 'Wash - Washing Machines', 'Wassen - Wasmachines', 1040, NULL, 'available'),
(1349, 'Wash - Washer Dryers', 'Wassen - Was-Droog Combi', 1040, NULL, 'available'),
(1350, 'Wash - Centrifuges', 'Wassen - Centrifuges', 1040, NULL, 'available'),
(1351, 'Wash - Washboards', 'Wassen - Wasborden', 1040, NULL, 'available'),
(1352, 'Ironing', 'Strijken', 1040, NULL, 'available'),
(1353, 'Vacuum cleaners', 'Stofzuigers', 1040, NULL, 'available'),
(1354, 'Kitchen - Toasters', 'Keuken - Toast & Tosti', 1040, NULL, 'available'),
(1355, 'Fans & Aircos', 'Ventilatoren & Airconditioning', 1040, NULL, 'available'),
(1356, 'Scales', 'Weegschalen', 1040, NULL, 'available'),
(1357, 'Alarms', 'Wekkers', 1040, NULL, 'available'),
(1358, 'Kitchen - Deep Fryers', 'Keuken - Frituur', 1040, NULL, 'available'),
(1359, 'Dogs & Puppies - Other', 'Honden & Puppies - Overig', 1039, NULL, 'available'),
(1360, 'Personal Care', 'Persoonlijke Verzorging', 1040, NULL, 'available'),
(1361, 'Lighting', 'Verlichting', 1040, NULL, 'available'),
(1362, 'Kitchen - Coffee & Tea', 'Keuken - Koffie & Thee', 1040, NULL, 'available'),
(1363, 'Water', 'Water', 1299, NULL, 'available'),
(1364, 'Needleworks', 'Handwerken', 1046, NULL, 'available'),
(1365, 'Course Materials', 'Cursusmateriaal', 1043, NULL, 'available'),
(1366, 'Day Trips', 'Dagjes Uit', 1043, NULL, 'available'),
(1367, 'Party Supplies', 'Feest Artikelen', 1043, NULL, 'available'),
(1368, 'Group Games', 'Gezelsschapsspellen', 1043, NULL, 'available'),
(1369, 'Cards Making', 'Kaarten Maken', 1043, NULL, 'available'),
(1370, 'Clothing Patterns', 'Keding Patronen', 1046, NULL, 'available'),
(1371, 'Beads', 'Kralen', 1046, NULL, 'available'),
(1372, 'Model Cars & Miniatures', 'Model Auto''s & Miniaturen', 1043, NULL, 'available'),
(1373, 'Painting', 'Schilderen', 1028, NULL, 'available'),
(1374, 'Fabrics', 'Stoffen', 1046, NULL, 'available'),
(1375, 'Zippers', 'Ritsen', 1046, NULL, 'available'),
(1376, 'Tickets', 'Toegangskaarten', 1043, NULL, 'available'),
(1377, 'Bathroom', 'Badkamer', 1044, NULL, 'available'),
(1378, 'Couches', 'Banken', 1044, NULL, 'available'),
(1379, 'Sleeping', 'Slapen', 1044, NULL, 'available'),
(1380, 'Wallpaper', 'Behang', 1044, NULL, 'available'),
(1381, 'Fire Control & Fighting', 'Brand Preventie & Blussen', 1044, NULL, 'available'),
(1382, 'Desks & Desk Chairs', 'Bureau''s & Bureaustoelen', 1044, NULL, 'available'),
(1383, 'CD & DVD Racks', 'CD & DVD Rekken', 1044, NULL, 'available'),
(1384, 'Complete Furniture', 'Complete Inboedel', 1044, NULL, 'available'),
(1385, 'Dining Tables & Chairs', 'Eetkamer Tafels & Stoelen', 1044, NULL, 'available'),
(1386, 'Curtains & Blinds', 'Gordijnen, Lamellen & Luiken', 1044, NULL, 'available'),
(1387, 'Stoves & Hearths', 'Kachels & Haarden', 1044, NULL, 'available'),
(1388, 'Candles & Candlesticks', 'Kaarsen & Kandelaars', 1044, NULL, 'available'),
(1389, 'Clothes Valets', 'Kapstokken', 1044, NULL, 'available'),
(1390, 'Chests & Cases', 'Kasten', 1044, NULL, 'available'),
(1391, 'Kitchen', 'Keuken', 1044, NULL, 'available'),
(1392, 'Coffins', 'Kisten', 1044, NULL, 'available'),
(1393, 'Clocks', 'Klokken', 1044, NULL, 'available'),
(1394, 'Lamps', 'Lampen', 1044, NULL, 'available'),
(1395, 'Trash & Recycle Bins', 'Vuilnis & Recycle Bakken', 1044, NULL, 'available');

-- --------------------------------------------------------

-- 
-- Tabel structuur voor tabel `rgbAds`
-- 
-- Gecreëerd: 25 Apr 2008 om 12:12
-- Laatst bijgewerkt: 30 Apr 2008 om 20:45
-- 

CREATE TABLE IF NOT EXISTS `rgbAds` (
  `adId` int(11) NOT NULL auto_increment,
  `adUserid` int(11) NOT NULL,
  `adStatus` enum('live','invisible') default 'live',
  `adTitle` text,
  `adText` text,
  `adLastChange` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `adOfferRequest` enum('offer','request') default NULL,
  `adRedValue` float NOT NULL default '0',
  `adGreenValue` float NOT NULL default '0',
  `adBlueValue` float NOT NULL default '0',
  `adThumbImage` varchar(256) default NULL,
  `adBigImage` varchar(256) default NULL,
  `adGroupId` int(11) NOT NULL default '0',
  `adCategoryId` int(11) NOT NULL default '0',
  PRIMARY KEY  (`adId`),
  KEY `adGroupId` (`adGroupId`),
  KEY `adCategoryies` (`adCategoryId`,`adGroupId`),
  KEY `adCategoryId` (`adCategoryId`),
  KEY `adUserid` (`adUserid`),
  FULLTEXT KEY `adSubject` (`adTitle`,`adText`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- 
-- Gegevens worden uitgevoerd voor tabel `rgbAds`
-- 

INSERT INTO `rgbAds` (`adId`, `adUserid`, `adStatus`, `adTitle`, `adText`, `adLastChange`, `adOfferRequest`, `adRedValue`, `adGreenValue`, `adBlueValue`, `adThumbImage`, `adBigImage`, `adGroupId`, `adCategoryId`) VALUES 
(1, 2, 'live', 'Ginkgo Biloba', 'Zaailingen van de Ginkgo Biloba, de Japanse Notenboom. Een kado voor het leven, want deze jongens gaan gauw 1000 jaar mee.', '2008-04-30 12:46:46', 'offer', 8, 1, 0.125, 'uploads/ichnaton_t_ginkgo-balkon-2002-mei-grootste.jpg', 'uploads/ichnaton_ginkgo-balkon-2002-mei-grootste.jpg', 2, 3),
(2, 2, 'live', 'Composteerbaar organisch materiaal', 'Vers snij-afval uit de keuken, bladafval en overbodige planten uit de tuin. Ook dierenharen.\r\n\r\nGeen gekochte bloemen, die zijn te giftig en verstoren onze compostering.\r\n\r\nKomt u het zelf even bij ons brengen?', '2008-04-30 12:46:46', 'request', 0, 1, 0, '', '', 2, 3),
(3, 3, 'live', 'Regenbroek XL', 'Mooie donkerblauwe regenbroek. Is mij toch iets te groot!\r\nGeschikt voor heren.', '2008-04-30 12:46:46', 'offer', 0, 0, 3, '', '', 2, 3),
(5, 4, 'live', 'Zwarte dames jas mt 50', 'Dames jas vorig jaar gekocht, is me te groot.\r\nLanger model', '2008-04-30 12:46:46', 'offer', 0, 0, 0.375, '', '', 2, 3),
(6, 2, 'live', 'Hulp in de tuin', 'Iemand die wil komen klussen in de tuin. Je kunt gelijk iets opsteken over Permacultuur, dat is de tuinfilosofie die we gaan beginnen toe te passen.', '2008-04-30 20:45:44', 'request', 1, 0, 0, '', '', 2, 3);

-- --------------------------------------------------------

-- 
-- Tabel structuur voor tabel `rgbBalances`
-- 
-- Gecreëerd: 25 Apr 2008 om 11:32
-- Laatst bijgewerkt: 25 Apr 2008 om 11:32
-- 

CREATE TABLE IF NOT EXISTS `rgbBalances` (
  `balanceId` int(11) NOT NULL auto_increment,
  `balanceDateTime` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `balanceRedValue` float NOT NULL default '0',
  `balanceGreenValue` float NOT NULL default '0',
  `balanceBlueValue` float NOT NULL default '0',
  `balanceLastTransferId` int(11) default NULL,
  `balanceUserId` int(11) NOT NULL,
  `balanceType` enum('running','milestone') default NULL,
  PRIMARY KEY  (`balanceId`),
  KEY `balanceUserId` (`balanceUserId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- 
-- Gegevens worden uitgevoerd voor tabel `rgbBalances`
-- 

INSERT INTO `rgbBalances` (`balanceId`, `balanceDateTime`, `balanceRedValue`, `balanceGreenValue`, `balanceBlueValue`, `balanceLastTransferId`, `balanceUserId`, `balanceType`) VALUES 
(1, '2007-12-22 10:52:32', 0, 0, 0, NULL, 1, 'running'),
(2, '2007-12-22 19:14:48', 0, 0, 0, NULL, 2, 'running'),
(3, '2007-12-23 15:21:39', 0, 0, 0, NULL, 3, 'running'),
(4, '2007-12-24 16:13:52', 0, 0, 0, NULL, 4, 'running'),
(5, '2007-12-25 12:37:05', 0, 0, 0, NULL, 5, 'running'),
(6, '2007-12-25 18:50:47', 0, 0, 0, NULL, 6, 'running'),
(7, '2007-12-27 16:45:14', 0, 0, 0, NULL, 7, 'running'),
(8, '2008-01-04 20:41:34', 0, 0, 0, NULL, 8, 'running'),
(9, '2008-01-06 11:57:42', 0, 0, 0, NULL, 9, 'running'),
(10, '2008-01-11 10:55:07', 0, 0, 0, NULL, 10, 'running'),
(11, '2008-01-26 21:35:13', 0, 0, 0, NULL, 11, 'running'),
(12, '2008-03-28 14:18:26', 0, 0, 0, NULL, 12, 'running'),
(13, '2008-03-28 14:24:19', 0, 0, 0, NULL, 13, 'running');

-- --------------------------------------------------------

-- 
-- Tabel structuur voor tabel `rgbTransfers`
-- 
-- Gecreëerd: 25 Apr 2008 om 11:32
-- Laatst bijgewerkt: 25 Apr 2008 om 11:32
-- 

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Gegevens worden uitgevoerd voor tabel `rgbTransfers`
-- 


-- --------------------------------------------------------

-- 
-- Tabel structuur voor tabel `rgbUsers`
-- 
-- Gecreëerd: 25 Apr 2008 om 11:32
-- Laatst bijgewerkt: 25 Apr 2008 om 11:32
-- 

CREATE TABLE IF NOT EXISTS `rgbUsers` (
  `userId` int(11) NOT NULL auto_increment,
  `userNick` varchar(40) NOT NULL default '',
  `userEmail` varchar(60) default NULL,
  `userAddress` varchar(40) default NULL,
  `userAddress2` varchar(40) default NULL,
  `userZipCode` varchar(40) default NULL,
  `userCity` varchar(40) default NULL,
  `userRegion` varchar(40) default NULL,
  `userWebsite` varchar(40) default NULL,
  `userGpsLongitude` varchar(40) default NULL,
  `userGpsLattitude` varchar(40) default NULL,
  `userPassword` varchar(255) default NULL,
  `userPlan` text,
  `userAvatar` varchar(120) default NULL,
  `userStatus` enum('toverify','live','silent','forgotten','system') default 'toverify',
  `userSessionID` char(50) default NULL,
  `userLastLog` datetime default NULL,
  `userPhone1` varchar(12) default NULL,
  `userPhone2` varchar(12) default NULL,
  `userBirth` datetime NOT NULL default '2007-07-07 00:00:00',
  `userVerify` varchar(64) default NULL,
  PRIMARY KEY  (`userId`),
  UNIQUE KEY `userNick` (`userNick`),
  UNIQUE KEY `userEmail` (`userEmail`),
  KEY `userId` (`userId`),
  KEY `userStatus` (`userStatus`),
  FULLTEXT KEY `userZipCode` (`userZipCode`),
  FULLTEXT KEY `userCity` (`userCity`),
  FULLTEXT KEY `userRegion` (`userRegion`),
  FULLTEXT KEY `userWebsite` (`userWebsite`),
  FULLTEXT KEY `userPlan` (`userPlan`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- 
-- Gegevens worden uitgevoerd voor tabel `rgbUsers`
-- 

INSERT INTO `rgbUsers` (`userId`, `userNick`, `userEmail`, `userAddress`, `userAddress2`, `userZipCode`, `userCity`, `userRegion`, `userWebsite`, `userGpsLongitude`, `userGpsLattitude`, `userPassword`, `userPlan`, `userAvatar`, `userStatus`, `userSessionID`, `userLastLog`, `userPhone1`, `userPhone2`, `userBirth`, `userVerify`) VALUES 
(1, 'blauwberg', 'blauwberg@kleureneconomie.nl', '', '', '', '', '', '', NULL, NULL, '*DF5578B593FA4B30B3CFFB53DEB59CCCD77DC3F3', 'Blauwberg is een symbolische gebruiker. Als je een lozing doet via een uitlaat of riool, dan kun je die registreren door een betaling van Blauwberg naar jezelf te doen. Je mag alleen blauw overboeken. Haal je te    rug van de Blauwberg wat er eerder in is gestort, dan mag je dat terugboeken.', 'uploads/blauwberg_ava_blauberg-100.png', 'live', 'Thesessionid', '0000-00-00 00:00:00', '', '', '2007-12-22 10:52:32', NULL),


