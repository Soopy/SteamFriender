
-- phpMyAdmin SQL Dump
-- version 2.11.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 08, 2013 at 11:27 AM
-- Server version: 5.1.57
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `steam_friender`
--

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `appID` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `storeLink` varchar(255) NOT NULL,
  `isCoop` int(1) NOT NULL,
  `isMultiplayer` int(1) NOT NULL,
  `isLocalCoop` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1304 ;


--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` int(10) NOT NULL AUTO_INCREMENT,
  `steamid` varchar(255) NOT NULL,
  `personaname` varchar(255) NOT NULL,
  `profileurl` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `avatarmedium` varchar(255) NOT NULL,
  `avatarfull` varchar(255) NOT NULL,
  `personastate` varchar(255) NOT NULL,
  `communityvisibilitystate` varchar(255) NOT NULL,
  `profilestate` varchar(255) NOT NULL,
  `lastlogoff` varchar(255) NOT NULL,
  `commentpermission` varchar(255) NOT NULL,
  `realname` varchar(255) NOT NULL,
  `primaryclanid` varchar(255) NOT NULL,
  `timecreated` varchar(255) NOT NULL,
  `gameid` varchar(255) NOT NULL,
  `gameserverip` varchar(255) NOT NULL,
  `gameextrainfo` varchar(255) NOT NULL,
  `loccountrycode` varchar(255) NOT NULL,
  `locstatecode` varchar(255) NOT NULL,
  `loccityid` varchar(255) NOT NULL,
  `games` varchar(5000) NOT NULL DEFAULT '0',
  `answered` int(1) NOT NULL DEFAULT '0',
  `type` int(1) NOT NULL DEFAULT '0',
  `hours` int(1) NOT NULL DEFAULT '0',
  `age` int(1) NOT NULL DEFAULT '0',
  `genre` varchar(255) NOT NULL DEFAULT '0',
  `location` int(11) NOT NULL DEFAULT '0',
  `lookingtoplay` varchar(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=141 ;