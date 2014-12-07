-- phpMyAdmin SQL Dump
-- version 4.2.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 07, 2014 at 01:06 AM
-- Server version: 5.5.25a
-- PHP Version: 5.6.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `musicstore`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `update_user_rating`(IN `uid` INT, IN `dir` INT, IN `factor` FLOAT)
    MODIFIES SQL DATA
begin
  declare rate float;
  
  if dir = 0 then
    set rate = factor * -1;
  else
    set rate = factor;
  end if;
  
  update user set rating = case 
  		when rating + rate > 10 then 10
        when rating + rate < 2 then 2
        else rating + rate
        end
  where userid = uid;
end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `approve`
--

CREATE TABLE IF NOT EXISTS `approve` (
  `cid` int(11) NOT NULL,
  `userid1` int(11) DEFAULT NULL,
  `userid2` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `approve`
--

INSERT INTO `approve` (`cid`, `userid1`, `userid2`) VALUES
(3, NULL, NULL),
(4, NULL, NULL),
(5, NULL, NULL),
(15, NULL, NULL),
(17, NULL, NULL);

--
-- Triggers `approve`
--
DELIMITER //
CREATE TRIGGER `concert_approve_after` AFTER UPDATE ON `approve`
 FOR EACH ROW begin
 declare uid integer;
 
 if new.userid1 is not NULL and new.userid2 is not NULL and 
 	old.userid2 is NULL then
  begin
    update concert set approved = 1 where cid = new.cid;
    
    select userid into uid from concert where cid = new.cid;
    call update_user_rating(uid, 1, .7);
  end;
 end if;
end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `artist`
--

CREATE TABLE IF NOT EXISTS `artist` (
  `userid` int(50) NOT NULL,
  `bandid` int(50) NOT NULL,
  `url` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `artist`
--

INSERT INTO `artist` (`userid`, `bandid`, `url`) VALUES
(6, 1, NULL),
(7, 2, '50cent.com'),
(8, 10, NULL),
(9, 13, 'http://www.bukeandgase.com/'),
(10, 13, 'http://www.bukeandgase.com/');

-- --------------------------------------------------------

--
-- Table structure for table `attend`
--

CREATE TABLE IF NOT EXISTS `attend` (
  `userid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `attended` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attend`
--

INSERT INTO `attend` (`userid`, `cid`, `attended`) VALUES
(4, 5, 1),
(4, 3, 0),
(6, 6, 1),
(6, 7, 1),
(6, 8, 0),
(7, 11, 0),
(7, 10, 1),
(8, 14, 0),
(8, 13, 1),
(9, 15, 0),
(9, 16, 1),
(10, 16, 1),
(6, 14, 0),
(2, 15, 0),
(8, 17, 0);

-- --------------------------------------------------------

--
-- Table structure for table `band`
--

CREATE TABLE IF NOT EXISTS `band` (
`bandid` int(10) NOT NULL,
  `bname` varchar(50) NOT NULL,
  `catid` int(50) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `band`
--

INSERT INTO `band` (`bandid`, `bname`, `catid`) VALUES
(1, 'Sonic Youth', 6),
(2, 'The Strokes', 41),
(3, 'Anthrax', 24),
(4, 'Swans', 18),
(5, 'Yeah Yeah Yeahs', 26),
(6, 'TV on the Radio', 26),
(7, 'Dirty Projectors', 29),
(8, 'The National', 39),
(9, 'The Hold Steady', 36),
(10, '50 Cent', 42),
(11, 'Madonna', 42),
(12, 'Steely Dan', 31),
(13, 'Buke and Gase', 26),
(14, 'Animal Collective', 18),
(15, 'The Antlers', 30),
(16, 'Vampire Weekend', 26),
(17, 'Matt and Kim', 26),
(18, 'Alicia Keys', 42),
(19, 'Patti Smith', 42),
(20, 'Beastie Boys', 24);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
`catid` int(11) NOT NULL,
  `catname` varchar(50) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=48 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`catid`, `catname`) VALUES
(6, 'Alternative'),
(7, 'Anime'),
(8, 'Blues'),
(10, 'Children''s Music'),
(11, 'Classical'),
(12, 'Comedy'),
(13, 'Commercial'),
(14, 'Country'),
(15, 'Dance'),
(16, 'Disney'),
(17, 'Easy Listening'),
(18, 'Electronic'),
(19, 'Enka'),
(20, 'French Pop'),
(21, 'German Folk'),
(22, 'German Pop'),
(23, 'Fitness & Workout'),
(24, 'Hip-Hop / Rap'),
(25, 'Holiday'),
(26, 'Indie Pop'),
(27, 'Industrial'),
(28, 'Inspirational'),
(29, 'Instrumental'),
(30, 'J-Pop'),
(31, 'Jazz'),
(32, 'K-Pop'),
(33, 'Karaoke'),
(34, 'Kayokyoku'),
(35, 'Latin'),
(36, 'New Age'),
(37, 'Opera'),
(38, 'Pop'),
(39, 'R&B / Soul'),
(40, 'Reggae'),
(41, 'Rock'),
(42, 'Singer / Songwriter'),
(43, 'Soundtrack'),
(44, 'Spoken Word'),
(45, 'Tex-Mex / Tejano'),
(46, 'Vocal'),
(47, 'World');

-- --------------------------------------------------------

--
-- Table structure for table `concert`
--

CREATE TABLE IF NOT EXISTS `concert` (
`cid` int(50) NOT NULL,
  `userid` int(50) NOT NULL,
  `bandid` int(50) NOT NULL,
  `cname` varchar(50) NOT NULL,
  `venueid` int(50) DEFAULT NULL,
  `ctime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ticket` float DEFAULT NULL,
  `url` varchar(200) DEFAULT NULL,
  `approved` tinyint(3) NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `concert`
--

INSERT INTO `concert` (`cid`, `userid`, `bandid`, `cname`, `venueid`, `ctime`, `ticket`, `url`, `approved`, `created`) VALUES
(3, 1, 10, 'Rocking Music', 13, '2014-12-05 14:00:00', 10, NULL, 0, '2014-12-05 03:29:48'),
(4, 2, 18, 'Disc Release', 11, '2014-12-03 23:00:00', NULL, NULL, 0, '2014-12-05 17:01:35'),
(5, 4, 10, 'In Da Club', 8, '2014-11-03 14:00:00', NULL, NULL, 0, '2014-12-05 17:04:50'),
(6, 6, 1, 'Bad Moon Rising', 10, '2014-10-02 22:00:00', 12, NULL, 1, '2014-12-05 17:10:16'),
(7, 6, 1, 'EVOL', 15, '2014-11-26 17:00:00', 0, NULL, 1, '2014-12-05 17:11:12'),
(8, 6, 1, 'Daydream Nation', 7, '2015-01-16 18:02:00', 5, 'http://sonicyouth.com', 1, '2014-12-05 17:12:42'),
(9, 7, 2, 'Is This It', 13, '2014-11-01 19:45:00', 45, NULL, 1, '2014-12-05 17:17:16'),
(10, 7, 2, 'Room on Fire', 15, '2014-11-20 22:04:00', NULL, NULL, 1, '2014-12-05 17:18:34'),
(11, 7, 2, 'Comedown Machine', 13, '2014-12-31 21:12:00', 50, 'http://thestrokes.com', 1, '2014-12-05 17:20:23'),
(12, 7, 2, 'Angles', 12, '2015-01-08 21:12:00', 50, 'http://thestrokes.com', 1, '2014-12-05 17:21:51'),
(13, 8, 10, 'Animal Ambition', 11, '2014-12-02 02:00:00', 25, 'http://50cent.com', 1, '2014-12-05 17:25:39'),
(14, 8, 10, 'Street King Immortal', 11, '2015-01-09 03:00:00', 63, 'http://50cent.com', 1, '2014-12-05 17:27:16'),
(15, 9, 13, 'General Dome', 10, '2015-01-29 17:00:00', 23, NULL, 1, '2014-12-05 17:33:03'),
(16, 9, 13, 'Riposte', 10, '2014-11-29 17:00:00', 23, NULL, 1, '2014-12-05 17:35:24'),
(17, 11, 10, 'Sample Concert', 13, '2014-12-24 14:00:00', 45, NULL, 0, '2014-12-05 21:58:39');

--
-- Triggers `concert`
--
DELIMITER //
CREATE TRIGGER `concert_delete_after` AFTER DELETE ON `concert`
 FOR EACH ROW begin
 declare rate float;
 
 select rating into rate from user where userid = old.userid;
 
 if rate < 8 and old.approved = 0 then
   call update_user_rating(old.userid, 1, .5);
 elseif rate < 8 and old.approved = 1 then
   call update_user_rating(old.userid, 0, .7);
 elseif rate >= 8 then
   call update_user_rating(old.userid, 0, .2);
 end if;
end
//
DELIMITER ;
DELIMITER //
CREATE TRIGGER `concert_insert_after` AFTER INSERT ON `concert`
 FOR EACH ROW begin
  declare rate float;
  
  select rating into rate from user where userid = new.userid;
  
  if rate < 8 then
    insert into approve(cid) values(new.cid);
  end if;
end
//
DELIMITER ;
DELIMITER //
CREATE TRIGGER `concert_insert_before` BEFORE INSERT ON `concert`
 FOR EACH ROW begin  
  declare rate float;
  
  select rating into rate from user where userid = new.userid;
  
  if rate < 8 then  	
  	begin
      set new.approved = 0;
      call update_user_rating(new.userid, 0, .5);
    end;
  else 
  	begin
      set new.approved = 1;
      call update_user_rating(new.userid, 1, .1);
    end;
  end if;
end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `concertgenre`
--

CREATE TABLE IF NOT EXISTS `concertgenre` (
  `cid` int(11) NOT NULL,
  `subcatid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `concertgenre`
--

INSERT INTO `concertgenre` (`cid`, `subcatid`) VALUES
(3, 95),
(3, 119),
(3, 150),
(3, 17),
(3, 10),
(3, 44),
(4, 225),
(4, 226),
(4, 229),
(4, 231),
(4, 10),
(4, 12),
(6, 18),
(6, 214),
(7, 214),
(7, 12),
(8, 34),
(8, 17),
(8, 10),
(8, 20),
(9, 73),
(9, 17),
(10, 73),
(10, 20),
(10, 149),
(10, 25),
(11, 17),
(11, 266),
(11, 18),
(11, 144),
(11, 83),
(12, 83),
(12, 144),
(12, 44),
(12, 10),
(12, 11),
(12, 17),
(12, 210),
(12, 208),
(13, 101),
(13, 104),
(13, 105),
(13, 106),
(13, 109),
(13, 102),
(14, 100),
(14, 101),
(14, 102),
(14, 103),
(14, 104),
(14, 105),
(14, 106),
(14, 107),
(14, 108),
(15, 12),
(15, 72),
(15, 98),
(15, 237),
(15, 26),
(15, 238),
(16, 12),
(16, 72),
(16, 98),
(16, 237),
(16, 238),
(16, 26),
(17, 101),
(17, 11);

-- --------------------------------------------------------

--
-- Table structure for table `data_track`
--

CREATE TABLE IF NOT EXISTS `data_track` (
  `uid` int(11) NOT NULL,
  `rating` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_track`
--

INSERT INTO `data_track` (`uid`, `rating`) VALUES
(1, 0),
(2, 7);

-- --------------------------------------------------------

--
-- Table structure for table `fan`
--

CREATE TABLE IF NOT EXISTS `fan` (
  `userid` int(11) NOT NULL,
  `bandid` int(11) NOT NULL,
  `fandate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fan`
--

INSERT INTO `fan` (`userid`, `bandid`, `fandate`) VALUES
(1, 2, '2014-12-03 17:40:17'),
(1, 18, '2014-12-03 17:40:17'),
(2, 5, '2014-12-03 17:40:17'),
(2, 18, '2014-12-03 17:40:17'),
(4, 10, '2014-12-03 17:40:17'),
(5, 11, '2014-12-03 17:40:17'),
(5, 16, '2014-12-03 17:40:17'),
(5, 6, '2014-12-03 17:40:17'),
(5, 5, '2014-12-03 17:40:17'),
(6, 1, '2014-12-03 17:40:17'),
(6, 10, '2014-12-03 17:40:17'),
(7, 12, '2014-12-03 17:40:17'),
(8, 10, '2014-12-03 17:40:17'),
(9, 13, '2014-12-03 17:40:17'),
(10, 13, '2014-12-03 17:40:17'),
(9, 20, '2014-12-03 17:40:17'),
(1, 10, '2014-12-05 04:35:30');

-- --------------------------------------------------------

--
-- Table structure for table `follow`
--

CREATE TABLE IF NOT EXISTS `follow` (
  `userid` int(11) NOT NULL,
  `followerid` int(11) NOT NULL,
  `followdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `follow`
--

INSERT INTO `follow` (`userid`, `followerid`, `followdate`) VALUES
(6, 1, '2014-12-03 17:34:43'),
(6, 2, '2014-12-03 17:34:43'),
(6, 7, '2014-12-03 17:34:43'),
(7, 1, '2014-12-03 17:34:43'),
(7, 5, '2014-12-03 17:34:43'),
(7, 2, '2014-12-03 17:34:43'),
(8, 3, '2014-12-03 17:34:43'),
(8, 2, '2014-12-03 17:34:43'),
(9, 4, '2014-12-03 17:34:43'),
(9, 8, '2014-12-03 17:34:43'),
(10, 1, '2014-12-03 17:34:43'),
(10, 3, '2014-12-03 17:34:43'),
(10, 4, '2014-12-03 17:34:43'),
(1, 2, '2014-12-03 17:34:43'),
(1, 3, '2014-12-03 17:34:43'),
(1, 5, '2014-12-03 17:34:43'),
(3, 4, '2014-12-03 17:34:43'),
(4, 3, '2014-12-03 17:34:43'),
(5, 1, '2014-12-03 17:34:43'),
(5, 2, '2014-12-03 17:34:43'),
(8, 1, '2014-12-05 04:35:43'),
(8, 9, '2014-12-05 17:36:35'),
(8, 11, '2014-12-05 22:02:26');

-- --------------------------------------------------------

--
-- Table structure for table `list`
--

CREATE TABLE IF NOT EXISTS `list` (
  `listid` int(11) NOT NULL,
  `cid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `list`
--

INSERT INTO `list` (`listid`, `cid`) VALUES
(6, 3),
(9, 8);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE IF NOT EXISTS `post` (
`postid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `text` text,
  `postdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `access` int(1) NOT NULL DEFAULT '2'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`postid`, `userid`, `text`, `postdate`, `access`) VALUES
(1, 1, 'test post', '2014-12-05 06:58:55', 2),
(2, 1, 'test private post', '2014-12-05 07:36:38', 0),
(3, 1, 'test follower only post', '2014-12-05 07:36:51', 1),
(4, 2, 'Today I went to a concert but I dont remember it', '2014-12-05 16:47:10', 2),
(5, 8, 'Its good to be back on track', '2014-12-05 17:29:48', 2),
(6, 8, 'Don''t miss the Street King fellas', '2014-12-05 17:30:12', 1),
(7, 11, 'Test post for the followers', '2014-12-05 21:55:54', 1);

-- --------------------------------------------------------

--
-- Table structure for table `recommend`
--

CREATE TABLE IF NOT EXISTS `recommend` (
  `userid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `recdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `recommend`
--

INSERT INTO `recommend` (`userid`, `cid`, `recdate`) VALUES
(1, 3, '2014-12-05 08:24:40'),
(6, 8, '2014-12-05 17:13:51'),
(7, 11, '2014-12-05 17:20:58'),
(8, 13, '2014-12-05 17:29:03'),
(8, 14, '2014-12-05 17:29:09'),
(8, 12, '2014-12-05 17:29:20'),
(9, 15, '2014-12-05 17:36:50');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE IF NOT EXISTS `review` (
`reviewid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `review` text,
  `reviewdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`reviewid`, `userid`, `cid`, `rating`, `review`, `reviewdate`) VALUES
(1, 1, 3, 4, 'This is really rocking', '2014-12-05 08:01:52'),
(2, 8, 5, 5, 'I loved this concert', '2014-12-05 17:38:17'),
(3, 1, 5, 4, 'This is cool to hear', '2014-12-05 17:38:41'),
(4, 6, 14, 3, 'I am going to like this', '2014-12-05 17:41:36'),
(5, 2, 4, 3, 'This was really great', '2014-12-05 19:34:26'),
(6, 8, 14, 5, 'I like this concert', '2014-12-05 22:02:57');

-- --------------------------------------------------------

--
-- Table structure for table `subcategory`
--

CREATE TABLE IF NOT EXISTS `subcategory` (
`subcatid` int(11) NOT NULL,
  `catid` int(11) DEFAULT NULL,
  `subcatname` varchar(50) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=280 ;

--
-- Dumping data for table `subcategory`
--

INSERT INTO `subcategory` (`subcatid`, `catid`, `subcatname`) VALUES
(10, 6, 'Alternative Rock'),
(11, 6, 'College Rock'),
(12, 6, 'Experimental Rock'),
(13, 6, 'Goth / Gothic Rock'),
(14, 6, 'Grunge'),
(15, 6, 'Hardcore Punk'),
(16, 6, 'Hard Rock'),
(17, 6, 'Indie Rock'),
(18, 6, 'New Wave'),
(19, 6, 'Progressive Rock'),
(20, 6, 'Punk'),
(21, 6, 'Shoegaze'),
(22, 6, 'Steampunk'),
(24, 8, 'Acoustic Blues'),
(25, 8, 'Chicago Blues'),
(26, 8, 'Classic Blues'),
(27, 8, 'Contemporary Blues'),
(28, 8, 'Country Blues'),
(29, 8, 'Delta Blues'),
(30, 8, 'Electric Blues'),
(34, 10, 'Avant-Garde'),
(35, 10, 'Baroque'),
(36, 10, 'Chamber Music'),
(37, 10, 'Chant'),
(38, 10, 'Choral'),
(39, 10, 'Classical Crossover'),
(40, 10, 'Early Music'),
(41, 10, 'High Classical'),
(42, 10, 'Impressionist'),
(43, 10, 'Medieval'),
(44, 10, 'Minimalism'),
(45, 10, 'Modern Composition'),
(46, 10, 'Opera'),
(47, 10, 'Orchestral'),
(48, 10, 'Renaissance'),
(49, 10, 'Romantic'),
(50, 10, 'Wedding Music'),
(51, 11, 'Novelty'),
(52, 11, 'Standup Comedy'),
(53, 12, 'Jingles'),
(54, 12, 'TV Themes'),
(55, 14, 'Alternative Country'),
(56, 14, 'Americana'),
(57, 14, 'Bluegrass'),
(58, 14, 'Contemporary Bluegrass'),
(59, 14, 'Contemporary Country'),
(60, 14, 'Country Gospel'),
(61, 14, 'Country Pop'),
(62, 14, 'Honky Tonk'),
(63, 14, 'Outlaw Country'),
(64, 14, 'Traditional Bluegrass'),
(65, 14, 'Traditional Country'),
(66, 14, 'Urban Cowboy'),
(67, 15, 'Club / Club Dance'),
(68, 15, 'Breakbeat'),
(69, 15, 'Deep House'),
(70, 15, 'Dubstep'),
(71, 15, 'Electro House'),
(72, 15, 'Exercise'),
(73, 15, 'Garage'),
(74, 15, 'Hardcore'),
(75, 15, 'Hard Dance'),
(76, 15, 'Hi-NRG / Eurodance'),
(77, 15, 'House'),
(78, 15, 'Jackin House'),
(79, 15, 'Jungle / Drum''n''bass'),
(80, 15, 'Techno'),
(81, 15, 'Trance'),
(82, 15, 'Trap'),
(83, 17, 'Bop'),
(84, 17, 'Lounge'),
(85, 17, 'Swing'),
(86, 18, '8bit / Bitpop / Chiptune'),
(87, 18, 'Ambient'),
(88, 18, 'Bassline'),
(89, 18, 'Chiptune'),
(90, 18, 'Crunk'),
(91, 18, 'Downtempo'),
(92, 18, 'Drum & Bass'),
(93, 18, 'Electro'),
(94, 18, 'Electro-swing'),
(95, 18, 'Electronica'),
(96, 18, 'Electronic Rock'),
(97, 18, 'Hardstyle'),
(98, 18, 'IDM / Experimental'),
(99, 18, 'Industrial'),
(100, 18, 'Trip Hop'),
(101, 24, 'Alternative Rap'),
(102, 24, 'Bounce'),
(103, 24, 'Dirty South'),
(104, 24, 'East Coast Rap'),
(105, 24, 'Gangsta Rap'),
(106, 24, 'Hardcore Rap'),
(107, 24, 'Hip-Hop'),
(108, 24, 'Latin Rap'),
(109, 24, 'Old School Rap'),
(110, 24, 'Rap'),
(111, 24, 'Turntablism'),
(112, 24, 'Underground Rap'),
(113, 24, 'West Coast Rap'),
(114, 25, 'Chanukah'),
(115, 25, 'Christmas'),
(116, 25, 'Christmas: Children''s'),
(117, 25, 'Christmas: Classic'),
(118, 25, 'Christmas: Classical'),
(119, 25, 'Christmas: Jazz'),
(120, 25, 'Christmas: Modern'),
(121, 25, 'Christmas: Pop'),
(122, 25, 'Christmas: R&B'),
(123, 25, 'Christmas: Religious'),
(124, 25, 'Christmas: Rock'),
(125, 25, 'Easter'),
(126, 25, 'Halloween'),
(127, 25, 'Holiday: Other'),
(128, 25, 'Thanksgiving'),
(129, 28, 'CCM'),
(130, 28, 'Christian Metal'),
(131, 28, 'Christian Pop'),
(132, 28, 'Christian Rap'),
(133, 28, 'Christian Rock'),
(134, 28, 'Classic Christian'),
(135, 28, 'Contemporary Gospel'),
(136, 28, 'Gospel'),
(137, 28, 'Christian & Gospel'),
(138, 28, 'Praise & Worship'),
(139, 28, 'Qawwali'),
(140, 28, 'Southern Gospel'),
(141, 28, 'Traditional Gospel'),
(142, 29, 'March / Marching Band'),
(143, 30, 'J-Rock'),
(144, 30, 'J-Synth'),
(145, 30, 'J-Ska'),
(146, 30, 'J-Punk'),
(147, 31, 'Acid Jazz'),
(148, 31, 'Avant-Garde Jazz'),
(149, 31, 'Big Band'),
(150, 31, 'Blue Note'),
(151, 31, 'Contemporary Jazz'),
(152, 31, 'Cool'),
(153, 31, 'Crossover Jazz'),
(154, 31, 'Dixieland'),
(155, 31, 'Ethio-jazz'),
(156, 31, 'Fusion'),
(157, 31, 'Gypsy Jazz'),
(158, 31, 'Hard Bop'),
(159, 31, 'Latin Jazz'),
(160, 31, 'Mainstream Jazz'),
(161, 31, 'Ragtime'),
(162, 31, 'Smooth Jazz'),
(163, 31, 'Trad Jazz'),
(164, 35, 'Alternativo & Rock Latino'),
(165, 35, 'Argentine tango'),
(166, 35, 'vBaladas y Boleros'),
(167, 35, 'Bossa Nova'),
(168, 35, 'Brazilian'),
(169, 35, 'Contemporary Latin'),
(170, 35, 'Flamenco / Spanish Flamenco'),
(171, 35, 'Latin Jazz'),
(172, 35, 'Nuevo Flamenco'),
(173, 35, 'Pop Latino'),
(174, 35, 'Portuguese fado'),
(175, 35, 'RaÃ­ces'),
(176, 35, 'Reggaeton y Hip-Hop'),
(177, 35, 'Regional Mexicano'),
(178, 35, 'Salsa y Tropical'),
(179, 36, 'Environmental'),
(180, 36, 'Healing'),
(181, 36, 'Meditation'),
(182, 36, 'Nature'),
(183, 36, 'Relaxation'),
(184, 36, 'Travel'),
(185, 38, 'Adult Contemporary'),
(186, 38, 'Britpop'),
(187, 38, 'Pop / Rock'),
(188, 38, 'Soft Rock'),
(189, 38, 'Teen Pop'),
(190, 39, 'Contemporary R&B'),
(191, 39, 'Disco'),
(192, 39, 'Doo Wop'),
(193, 39, 'Funk'),
(194, 39, 'Motown'),
(195, 39, 'Neo-Soul'),
(196, 39, 'Quiet Storm'),
(197, 39, 'Soul'),
(198, 40, 'Dancehall'),
(199, 40, 'Dub'),
(200, 40, 'Roots Reggae'),
(201, 40, 'Ska'),
(202, 41, 'Acid Rock'),
(203, 41, 'Adult Alternative'),
(204, 41, 'American Trad Rock'),
(205, 41, 'Arena Rock'),
(206, 41, 'Blues-Rock'),
(207, 41, 'British Invasion'),
(208, 41, 'Death Metal / Black Metal'),
(209, 41, 'Glam Rock'),
(210, 41, 'Gothic Metal'),
(211, 41, 'Hair Metal'),
(212, 41, 'Hard Rock'),
(213, 41, 'Metal'),
(214, 41, 'Noise Rock'),
(215, 41, 'Jam Bands'),
(216, 41, 'Prog-Rock / Art Rock'),
(217, 41, 'Psychedelic'),
(218, 41, 'Rock & Roll'),
(219, 41, 'Rockabilly'),
(220, 41, 'Roots Rock'),
(221, 41, 'Singer / Songwriter'),
(222, 41, 'Southern Rock'),
(223, 41, 'Surf'),
(224, 41, 'Tex-Mex'),
(225, 42, 'Alternative Folk'),
(226, 42, 'Contemporary Folk'),
(227, 42, 'Contemporary Singer / Songwriter'),
(228, 42, 'Folk-Rock'),
(229, 42, 'Love Song'),
(230, 42, 'New Acoustic'),
(231, 42, 'Traditional Folk'),
(232, 43, 'Foreign Cinema'),
(233, 43, 'Musicals'),
(234, 43, 'Original Score'),
(235, 43, 'Soundtrack'),
(236, 43, 'TV Soundtrack'),
(237, 45, 'Chicano'),
(238, 45, 'Classic'),
(239, 45, 'Conjunto'),
(240, 45, 'Conjunto Progressive'),
(241, 45, 'New Mex'),
(242, 45, 'Tex-Mex'),
(243, 46, 'A cappella'),
(244, 46, 'Barbershop'),
(245, 46, 'Doo-wop'),
(246, 46, 'Standards'),
(247, 46, 'Traditional Pop'),
(248, 46, 'Vocal Jazz'),
(249, 46, 'Vocal Pop'),
(250, 47, 'Africa'),
(251, 47, 'Afro-Beat'),
(252, 47, 'Afro-Pop'),
(253, 47, 'Asia'),
(254, 47, 'Australia'),
(255, 47, 'Cajun'),
(256, 47, 'Calypso'),
(257, 47, 'Caribbean'),
(258, 47, 'Celtic'),
(259, 47, 'Celtic Folk'),
(260, 47, 'Contemporary Celtic'),
(261, 47, 'Drinking Songs'),
(262, 47, 'Drone'),
(263, 47, 'Europe'),
(264, 47, 'France'),
(265, 47, 'Hawaii'),
(266, 47, 'Indian Pop'),
(267, 47, 'Japan'),
(268, 47, 'Japanese Pop'),
(269, 47, 'Klezmer'),
(270, 47, 'Middle East'),
(271, 47, 'North America'),
(272, 47, 'Ode'),
(273, 47, 'Polka'),
(274, 47, 'Soca'),
(275, 47, 'South Africa'),
(276, 47, 'South America'),
(277, 47, 'Traditional Celtic'),
(278, 47, 'Worldbeat'),
(279, 47, 'Zydeco');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`userid` int(10) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(64) DEFAULT NULL,
  `fname` varchar(50) DEFAULT NULL,
  `lname` varchar(50) DEFAULT NULL,
  `birthyear` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `rating` float NOT NULL DEFAULT '7',
  `joindate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `city` varchar(50) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userid`, `username`, `password`, `fname`, `lname`, `birthyear`, `email`, `rating`, `joindate`, `city`) VALUES
(1, 'Gopi', '0b198d55930f4e900f8779ed1a2dfae3', 'Gopikrishna', 'Sathyamurthy', '1991', 'gs1922@nyu.edu', 6.5, '2014-12-02 19:45:51', 'New York'),
(2, 'Keith', '0b198d55930f4e900f8779ed1a2dfae3', 'Michelle', 'Perkins', NULL, 'kperkins0@dion.ne.jp', 6.5, '2014-12-02 19:46:48', 'Baumata'),
(3, 'Craig', '0b198d55930f4e900f8779ed1a2dfae3', 'Janice', 'Wilson', NULL, 'cwilson1@indiegogo.com', 6, '2014-12-02 19:46:48', 'Tlatah'),
(4, 'Brian', '0b198d55930f4e900f8779ed1a2dfae3', 'Norma', 'Cunningham', NULL, 'bcunningham2@parallels.com', 5.5, '2014-12-02 19:46:48', 'Santander'),
(5, 'Jimmy', '0b198d55930f4e900f8779ed1a2dfae3', 'Marilyn', 'Harris', NULL, 'jharris4@icio.us', 6, '2014-12-02 19:48:39', 'Khora'),
(6, 'KimGordon', '0b198d55930f4e900f8779ed1a2dfae3', 'Kim', 'Gordon', '1953', NULL, 8.3, '2014-12-03 17:22:32', NULL),
(7, 'Julian', '0b198d55930f4e900f8779ed1a2dfae3', 'Julian', 'Casablancas', '1978', NULL, 8.4, '2014-12-03 17:23:34', NULL),
(8, 'Curtis', '0b198d55930f4e900f8779ed1a2dfae3', 'Curtis James', 'Jackson', NULL, NULL, 8.2, '2014-12-03 17:24:48', NULL),
(9, 'Arone', '0b198d55930f4e900f8779ed1a2dfae3', 'Arone', 'Dyer', NULL, NULL, 8.1, '2014-12-03 17:25:40', NULL),
(10, 'Aron', '0b198d55930f4e900f8779ed1a2dfae3', 'Aron', 'Sanchez', NULL, NULL, 7, '2014-12-03 17:26:03', NULL),
(11, 'Abc1991', '0b198d55930f4e900f8779ed1a2dfae3', 'ABC', 'XYZ', NULL, NULL, 6.5, '2014-12-05 21:53:49', '');

-- --------------------------------------------------------

--
-- Table structure for table `usergenre`
--

CREATE TABLE IF NOT EXISTS `usergenre` (
  `userid` int(11) NOT NULL,
  `subcatid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usergenre`
--

INSERT INTO `usergenre` (`userid`, `subcatid`) VALUES
(1, 147),
(1, 14),
(1, 213),
(1, 16),
(1, 26),
(1, 211),
(1, 202),
(1, 24),
(1, 233),
(1, 148),
(1, 10),
(1, 34),
(8, 10),
(8, 101),
(8, 102),
(8, 113),
(8, 82),
(8, 50),
(8, 126),
(5, 10),
(5, 101),
(11, 147),
(11, 10),
(11, 82);

-- --------------------------------------------------------

--
-- Table structure for table `userlist`
--

CREATE TABLE IF NOT EXISTS `userlist` (
`listid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `listname` varchar(50) NOT NULL,
  `listdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `userlist`
--

INSERT INTO `userlist` (`listid`, `userid`, `listname`, `listdate`) VALUES
(6, 1, 'Welcome List', '2014-12-05 06:35:51'),
(7, 2, 'Welcome List', '2014-12-05 16:58:37'),
(8, 8, 'Hello List', '2014-12-05 19:43:06'),
(9, 11, 'Test list', '2014-12-05 22:03:19');

-- --------------------------------------------------------

--
-- Table structure for table `venue`
--

CREATE TABLE IF NOT EXISTS `venue` (
`venueid` int(50) NOT NULL,
  `venuename` varchar(50) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `venue`
--

INSERT INTO `venue` (`venueid`, `venuename`) VALUES
(6, 'Belmont Park'),
(7, 'Yankee Stadium'),
(8, 'Madison Square Garden'),
(9, 'Ralph Wilson Stadium'),
(10, 'Arthur Ashe Stadium'),
(11, 'Barclays Center'),
(12, 'Forest Hills Stadium'),
(13, 'Citi Field'),
(14, 'First Niagara Center'),
(15, 'Nikon at Jones Beach Theater');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `approve`
--
ALTER TABLE `approve`
 ADD PRIMARY KEY (`cid`), ADD KEY `userid1` (`userid1`), ADD KEY `userid2` (`userid2`), ADD KEY `cid` (`cid`);

--
-- Indexes for table `artist`
--
ALTER TABLE `artist`
 ADD PRIMARY KEY (`userid`,`bandid`), ADD KEY `userid` (`userid`), ADD KEY `bandid` (`bandid`);

--
-- Indexes for table `attend`
--
ALTER TABLE `attend`
 ADD KEY `userid` (`userid`), ADD KEY `cid` (`cid`);

--
-- Indexes for table `band`
--
ALTER TABLE `band`
 ADD PRIMARY KEY (`bandid`), ADD KEY `catid` (`catid`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
 ADD PRIMARY KEY (`catid`);

--
-- Indexes for table `concert`
--
ALTER TABLE `concert`
 ADD PRIMARY KEY (`cid`), ADD KEY `userid` (`userid`), ADD KEY `bandid` (`bandid`), ADD KEY `venueid` (`venueid`);

--
-- Indexes for table `concertgenre`
--
ALTER TABLE `concertgenre`
 ADD KEY `cid` (`cid`), ADD KEY `subcatid` (`subcatid`);

--
-- Indexes for table `fan`
--
ALTER TABLE `fan`
 ADD KEY `userid` (`userid`), ADD KEY `bandid` (`bandid`);

--
-- Indexes for table `follow`
--
ALTER TABLE `follow`
 ADD KEY `userid` (`userid`), ADD KEY `followerid` (`followerid`);

--
-- Indexes for table `list`
--
ALTER TABLE `list`
 ADD KEY `listid` (`listid`), ADD KEY `cid` (`cid`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
 ADD PRIMARY KEY (`postid`), ADD KEY `userid` (`userid`);

--
-- Indexes for table `recommend`
--
ALTER TABLE `recommend`
 ADD KEY `userid` (`userid`), ADD KEY `cid` (`cid`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
 ADD PRIMARY KEY (`reviewid`), ADD KEY `userid` (`userid`), ADD KEY `cid` (`cid`);

--
-- Indexes for table `subcategory`
--
ALTER TABLE `subcategory`
 ADD PRIMARY KEY (`subcatid`), ADD KEY `catid` (`catid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`userid`), ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `usergenre`
--
ALTER TABLE `usergenre`
 ADD KEY `userid` (`userid`), ADD KEY `subcatid` (`subcatid`);

--
-- Indexes for table `userlist`
--
ALTER TABLE `userlist`
 ADD PRIMARY KEY (`listid`), ADD KEY `userid` (`userid`);

--
-- Indexes for table `venue`
--
ALTER TABLE `venue`
 ADD PRIMARY KEY (`venueid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `band`
--
ALTER TABLE `band`
MODIFY `bandid` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
MODIFY `catid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=48;
--
-- AUTO_INCREMENT for table `concert`
--
ALTER TABLE `concert`
MODIFY `cid` int(50) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
MODIFY `postid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
MODIFY `reviewid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `subcategory`
--
ALTER TABLE `subcategory`
MODIFY `subcatid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=280;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `userid` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `userlist`
--
ALTER TABLE `userlist`
MODIFY `listid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `venue`
--
ALTER TABLE `venue`
MODIFY `venueid` int(50) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `approve`
--
ALTER TABLE `approve`
ADD CONSTRAINT `approve_ibfk_1` FOREIGN KEY (`cid`) REFERENCES `concert` (`cid`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `approve_ibfk_2` FOREIGN KEY (`userid1`) REFERENCES `user` (`userid`) ON DELETE SET NULL ON UPDATE CASCADE,
ADD CONSTRAINT `approve_ibfk_3` FOREIGN KEY (`userid2`) REFERENCES `user` (`userid`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `artist`
--
ALTER TABLE `artist`
ADD CONSTRAINT `artist_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `artist_ibfk_2` FOREIGN KEY (`bandid`) REFERENCES `band` (`bandid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `attend`
--
ALTER TABLE `attend`
ADD CONSTRAINT `attend_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `attend_ibfk_2` FOREIGN KEY (`cid`) REFERENCES `concert` (`cid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `band`
--
ALTER TABLE `band`
ADD CONSTRAINT `band_ibfk_1` FOREIGN KEY (`catid`) REFERENCES `category` (`catid`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `concert`
--
ALTER TABLE `concert`
ADD CONSTRAINT `concert_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE CASCADE,
ADD CONSTRAINT `concert_ibfk_2` FOREIGN KEY (`bandid`) REFERENCES `band` (`bandid`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `concert_ibfk_3` FOREIGN KEY (`venueid`) REFERENCES `venue` (`venueid`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `concertgenre`
--
ALTER TABLE `concertgenre`
ADD CONSTRAINT `concertgenre_ibfk_1` FOREIGN KEY (`cid`) REFERENCES `concert` (`cid`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `concertgenre_ibfk_2` FOREIGN KEY (`subcatid`) REFERENCES `subcategory` (`subcatid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `fan`
--
ALTER TABLE `fan`
ADD CONSTRAINT `fan_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fan_ibfk_2` FOREIGN KEY (`bandid`) REFERENCES `band` (`bandid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `follow`
--
ALTER TABLE `follow`
ADD CONSTRAINT `follow_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `follow_ibfk_2` FOREIGN KEY (`followerid`) REFERENCES `user` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `list`
--
ALTER TABLE `list`
ADD CONSTRAINT `list_ibfk_1` FOREIGN KEY (`listid`) REFERENCES `userlist` (`listid`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `list_ibfk_2` FOREIGN KEY (`cid`) REFERENCES `concert` (`cid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post`
--
ALTER TABLE `post`
ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `recommend`
--
ALTER TABLE `recommend`
ADD CONSTRAINT `recommend_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `recommend_ibfk_2` FOREIGN KEY (`cid`) REFERENCES `concert` (`cid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `review`
--
ALTER TABLE `review`
ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`cid`) REFERENCES `concert` (`cid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subcategory`
--
ALTER TABLE `subcategory`
ADD CONSTRAINT `subcategory_ibfk_1` FOREIGN KEY (`catid`) REFERENCES `category` (`catid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `usergenre`
--
ALTER TABLE `usergenre`
ADD CONSTRAINT `usergenre_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `usergenre_ibfk_2` FOREIGN KEY (`subcatid`) REFERENCES `subcategory` (`subcatid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `userlist`
--
ALTER TABLE `userlist`
ADD CONSTRAINT `userlist_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
