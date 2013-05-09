/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50523
Source Host           : localhost:3306
Source Database       : edh

Target Server Type    : MYSQL
Target Server Version : 50523
File Encoding         : 65001

Date: 2013-01-29 14:43:50
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `activity`
-- ----------------------------
DROP TABLE IF EXISTS `activity`;
CREATE TABLE `activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `siteid` smallint(6) NOT NULL,
  `userid` int(11) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `info` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `dateline` int(11) NOT NULL,
  `clicks` int(11) NOT NULL,
  `replys` int(11) NOT NULL,
  `content` text NOT NULL,
  `starttime` int(11) NOT NULL,
  `endtime` int(11) NOT NULL,
  `nickname` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `siteid` (`siteid`,`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of activity
-- ----------------------------

-- ----------------------------
-- Table structure for `activity_topic`
-- ----------------------------
DROP TABLE IF EXISTS `activity_topic`;
CREATE TABLE `activity_topic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `siteid` smallint(6) NOT NULL,
  `act_id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `nickname` varchar(20) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `dateline` int(11) NOT NULL,
  `f_user_id` int(11) NOT NULL,
  `f_id` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `act_id` (`act_id`,`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of activity_topic
-- ----------------------------

-- ----------------------------
-- Table structure for `activity_user`
-- ----------------------------
DROP TABLE IF EXISTS `activity_user`;
CREATE TABLE `activity_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `siteid` smallint(6) NOT NULL,
  `act_id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `dateline` int(11) NOT NULL,
  `telephone` varchar(15) NOT NULL,
  `nickname` varchar(20) NOT NULL,
  `info` varchar(255) NOT NULL,
  `logo` varchar(225) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `act_user` (`act_id`,`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of activity_user
-- ----------------------------

-- ----------------------------
-- Table structure for `ad`
-- ----------------------------
DROP TABLE IF EXISTS `ad`;
CREATE TABLE `ad` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cname` varchar(20) CHARACTER SET gbk NOT NULL,
  `title` varchar(50) CHARACTER SET gbk NOT NULL,
  `url` varchar(255) CHARACTER SET gbk NOT NULL,
  `info` varchar(255) CHARACTER SET gbk NOT NULL,
  `starttime` int(10) unsigned NOT NULL DEFAULT '0',
  `endtime` int(10) unsigned NOT NULL DEFAULT '0',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `showid` int(10) unsigned NOT NULL DEFAULT '0',
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `imgurl` varchar(255) CHARACTER SET gbk COLLATE gbk_bin NOT NULL,
  `price` decimal(7,2) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `orderindex` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cname_id` (`cname`,`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ad
-- ----------------------------

-- ----------------------------
-- Table structure for `admin`
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `adminid` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `adminname` varchar(20) COLLATE gbk_bin NOT NULL,
  `password` varchar(100) COLLATE gbk_bin NOT NULL,
  `email` varchar(100) COLLATE gbk_bin NOT NULL,
  `zuid` smallint(2) unsigned NOT NULL DEFAULT '0',
  `isfounder` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`adminid`),
  KEY `adminname` (`adminname`),
  KEY `zuid` (`zuid`),
  KEY `siteid` (`siteid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES ('1', '1', 'wanghexiang', '2f6c5876c3f133399b929b8e865dd5a7', '', '0', '1');

-- ----------------------------
-- Table structure for `admin_log`
-- ----------------------------
DROP TABLE IF EXISTS `admin_log`;
CREATE TABLE `admin_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(50) COLLATE gbk_bin NOT NULL,
  `ztime` int(11) unsigned NOT NULL DEFAULT '0',
  `logdesc` varchar(400) COLLATE gbk_bin NOT NULL,
  `adminname` varchar(50) COLLATE gbk_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of admin_log
-- ----------------------------

-- ----------------------------
-- Table structure for `admin_zu`
-- ----------------------------
DROP TABLE IF EXISTS `admin_zu`;
CREATE TABLE `admin_zu` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `title` varchar(50) COLLATE gbk_bin NOT NULL,
  `orderindex` smallint(6) unsigned NOT NULL DEFAULT '0',
  `content` text COLLATE gbk_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `siteid` (`siteid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of admin_zu
-- ----------------------------

-- ----------------------------
-- Table structure for `art`
-- ----------------------------
DROP TABLE IF EXISTS `art`;
CREATE TABLE `art` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `shopid` mediumint(9) unsigned NOT NULL DEFAULT '0',
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) COLLATE gbk_bin NOT NULL,
  `dateline` int(11) unsigned NOT NULL DEFAULT '0',
  `keyword` varchar(125) COLLATE gbk_bin NOT NULL,
  `des` varchar(255) COLLATE gbk_bin NOT NULL,
  `click` smallint(6) unsigned NOT NULL DEFAULT '0',
  `catid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `isding` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `ishot` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `isnew` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `istop` int(11) unsigned NOT NULL DEFAULT '0',
  `catid_2nd` int(11) NOT NULL,
  `catid_3nd` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `title_sitei_id` (`title`,`siteid`,`id`),
  KEY `catid_siteid_id` (`catid`,`siteid`,`id`),
  KEY `title_catid_siteid_id` (`title`,`catid`,`siteid`,`id`),
  KEY `siteid_id` (`siteid`,`id`,`isnew`),
  KEY `siteid_isnew_id` (`siteid`,`isnew`,`id`),
  KEY `siteid_ishot_id` (`siteid`,`ishot`,`id`),
  KEY `siteid_isding_id` (`siteid`,`isding`,`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of art
-- ----------------------------

-- ----------------------------
-- Table structure for `art_cat`
-- ----------------------------
DROP TABLE IF EXISTS `art_cat`;
CREATE TABLE `art_cat` (
  `catid` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `shopid` mediumint(9) unsigned NOT NULL DEFAULT '0',
  `cname` varchar(50) COLLATE gbk_bin NOT NULL,
  `title` varchar(200) COLLATE gbk_bin NOT NULL,
  `orderid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `pid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `keyword` varchar(200) COLLATE gbk_bin NOT NULL,
  `info` varchar(250) COLLATE gbk_bin NOT NULL,
  `cattpl` varchar(50) COLLATE gbk_bin NOT NULL,
  `listtpl` varchar(50) COLLATE gbk_bin NOT NULL,
  `contpl` varchar(50) COLLATE gbk_bin NOT NULL,
  `t` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`catid`),
  KEY `orderid` (`orderid`),
  KEY `shopid` (`shopid`),
  KEY `siteid` (`siteid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of art_cat
-- ----------------------------

-- ----------------------------
-- Table structure for `art_comment`
-- ----------------------------
DROP TABLE IF EXISTS `art_comment`;
CREATE TABLE `art_comment` (
  `rid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `shopid` mediumint(9) unsigned NOT NULL DEFAULT '0',
  `pid` mediumint(9) unsigned NOT NULL DEFAULT '0',
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `dateline` int(11) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) COLLATE gbk_bin NOT NULL,
  `content` varchar(255) COLLATE gbk_bin NOT NULL,
  `ip` varchar(30) COLLATE gbk_bin NOT NULL,
  `reply` varchar(1000) COLLATE gbk_bin NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) COLLATE gbk_bin NOT NULL,
  PRIMARY KEY (`rid`),
  KEY `siteid_status_rid` (`siteid`,`status`,`rid`),
  KEY `shopid_status_rid` (`shopid`,`status`,`rid`),
  KEY `pid_siteid_status_rid` (`pid`,`siteid`,`status`,`rid`),
  KEY `pid_shopid_status_rid` (`pid`,`shopid`,`status`,`rid`),
  KEY `userid_rid` (`userid`,`rid`),
  KEY `pid_status_rid` (`pid`,`status`,`rid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of art_comment
-- ----------------------------

-- ----------------------------
-- Table structure for `art_data`
-- ----------------------------
DROP TABLE IF EXISTS `art_data`;
CREATE TABLE `art_data` (
  `id` mediumint(8) unsigned NOT NULL,
  `content` text COLLATE gbk_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of art_data
-- ----------------------------

-- ----------------------------
-- Table structure for `at`
-- ----------------------------
DROP TABLE IF EXISTS `at`;
CREATE TABLE `at` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL DEFAULT '0',
  `touserid` int(11) NOT NULL DEFAULT '0',
  `content` text CHARACTER SET gbk NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `dateline` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of at
-- ----------------------------

-- ----------------------------
-- Table structure for `blog`
-- ----------------------------
DROP TABLE IF EXISTS `blog`;
CREATE TABLE `blog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` int(10) unsigned NOT NULL,
  `userid` int(10) unsigned NOT NULL,
  `nickname` char(20) CHARACTER SET gbk NOT NULL,
  `dateline` int(10) unsigned NOT NULL,
  `content` varchar(255) CHARACTER SET gbk NOT NULL,
  `status` tinyint(1) NOT NULL,
  `forbid` tinyint(1) NOT NULL,
  `fuserid` int(10) unsigned NOT NULL,
  `fnickname` char(20) CHARACTER SET gbk NOT NULL,
  `comments` mediumint(8) unsigned NOT NULL,
  `forwards` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of blog
-- ----------------------------

-- ----------------------------
-- Table structure for `blog_comment`
-- ----------------------------
DROP TABLE IF EXISTS `blog_comment`;
CREATE TABLE `blog_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `siteid` smallint(6) NOT NULL DEFAULT '0',
  `blogid` int(11) NOT NULL DEFAULT '0',
  `userid` mediumint(9) NOT NULL,
  `nickname` varchar(20) CHARACTER SET gbk NOT NULL,
  `content` text CHARACTER SET gbk NOT NULL,
  `dateline` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `forbid` tinyint(1) NOT NULL DEFAULT '0',
  `newdateline` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `picid` (`blogid`,`userid`),
  KEY `uid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of blog_comment
-- ----------------------------

-- ----------------------------
-- Table structure for `cai`
-- ----------------------------
DROP TABLE IF EXISTS `cai`;
CREATE TABLE `cai` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `shopid` mediumint(9) unsigned NOT NULL DEFAULT '0',
  `title` varchar(50) COLLATE gbk_bin NOT NULL,
  `catid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `isding` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `reply` smallint(6) NOT NULL DEFAULT '0',
  `img` varchar(100) COLLATE gbk_bin NOT NULL,
  `des` varchar(255) COLLATE gbk_bin NOT NULL,
  `keyword` varchar(200) COLLATE gbk_bin NOT NULL,
  `author` varchar(50) COLLATE gbk_bin NOT NULL,
  `cainum` smallint(6) unsigned NOT NULL DEFAULT '10',
  `dateline` int(11) unsigned NOT NULL DEFAULT '0',
  `thum_img` varchar(100) COLLATE gbk_bin NOT NULL,
  `delicious` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '好吃',
  `ishot` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `isnew` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `visible` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `price` decimal(8,2) NOT NULL DEFAULT '0.00',
  `doid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `weiid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `promote` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `undelicious` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '难吃',
  `lowprice` decimal(8,2) NOT NULL DEFAULT '0.00',
  `oos` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '缺货',
  `middle_img` varchar(255) COLLATE gbk_bin NOT NULL,
  `orders` mediumint(9) unsigned NOT NULL DEFAULT '0',
  `week1` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `week2` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `week3` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `week4` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `week5` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `week6` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `week7` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `click` smallint(6) unsigned NOT NULL DEFAULT '0',
  `favs` mediumint(9) unsigned NOT NULL DEFAULT '0',
  `grade` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `catid` (`catid`),
  KEY `doid` (`doid`),
  KEY `weiid` (`weiid`),
  KEY `shopid` (`shopid`),
  KEY `week1_id` (`week1`,`id`),
  KEY `week2_id` (`week2`,`id`),
  KEY `week3_id` (`week3`,`id`),
  KEY `week4_id` (`week4`,`id`),
  KEY `week5_id` (`week5`,`id`),
  KEY `week6_id` (`week6`,`id`),
  KEY `week7_id` (`week7`,`id`),
  KEY `siteid_id` (`siteid`,`id`),
  KEY `siteid_isding_id` (`siteid`,`isding`,`id`),
  KEY `siteid_ishot_id` (`siteid`,`ishot`,`id`) USING BTREE,
  KEY `title_siteid_shopid_id` (`title`,`siteid`,`shopid`,`id`),
  KEY `catid_visible_shopid_id` (`catid`,`visible`,`shopid`,`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of cai
-- ----------------------------
INSERT INTO `cai` VALUES ('1', '1', '1', '巨无霸', '1', '1', '0', 'upfile/images/2013/01/28/88fd29cabe29364fb6b2d7f7f05ee03f.jpg', '', '', '', '10', '1359338430', 'upfile/images/2013/01/28/6618d321c7808745c0db7aec36c0c06d.jpg', '0', '1', '1', '1', '20.00', '0', '0', '1', '0', '0.00', '0', '', '1', '1', '1', '1', '1', '1', '1', '1', '1', '0', '0');
INSERT INTO `cai` VALUES ('2', '1', '1', '汉堡', '1', '1', '0', '', '', '', '', '10', '1359340658', 'upfile/images/2013/01/28/a719196bc24ac845159ffe7e5bcf8f65.jpg', '0', '1', '1', '1', '20.00', '0', '0', '1', '0', '0.00', '0', '', '0', '1', '1', '1', '1', '1', '1', '1', '0', '0', '0');
INSERT INTO `cai` VALUES ('3', '1', '1', '中薯条', '1', '1', '0', '', '', '', '', '10', '1359340731', 'upfile/images/2013/01/28/e9c87d8193335d47f3813a3950d1f967.jpg', '0', '1', '1', '1', '6.00', '0', '0', '1', '0', '0.00', '0', '', '0', '1', '1', '1', '1', '1', '1', '1', '1', '0', '0');
INSERT INTO `cai` VALUES ('4', '1', '1', '可乐', '1', '1', '0', '', '', '', '', '10', '1359340827', 'upfile/images/2013/01/28/ad87e8a6adaefccc94a0a80eb0e956f4.jpg', '0', '1', '1', '1', '6.00', '0', '0', '1', '0', '0.00', '0', '', '0', '1', '1', '1', '1', '1', '1', '1', '1', '0', '0');

-- ----------------------------
-- Table structure for `caipu`
-- ----------------------------
DROP TABLE IF EXISTS `caipu`;
CREATE TABLE `caipu` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '描述',
  `cat_id` int(11) NOT NULL COMMENT '一级分类',
  `cat_id_two` int(11) NOT NULL COMMENT '二级分类',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `keywords` varchar(255) NOT NULL COMMENT '关键',
  `description` varchar(255) NOT NULL,
  `maincai` varchar(255) NOT NULL COMMENT '主料',
  `othercai` varchar(255) NOT NULL COMMENT '其他菜',
  `content` text NOT NULL COMMENT '内容',
  `userid` int(11) NOT NULL COMMENT '用户id',
  `dateline` int(11) NOT NULL COMMENT '添加时间',
  `isrecommend` tinyint(4) NOT NULL COMMENT '是否推荐',
  `imgurl` varchar(255) NOT NULL COMMENT '图片地址',
  `tagname` varchar(255) NOT NULL COMMENT '标签名称',
  `wei_id` smallint(6) NOT NULL DEFAULT '0' COMMENT '味道',
  `do_id` smallint(6) NOT NULL DEFAULT '0' COMMENT '做法',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of caipu
-- ----------------------------

-- ----------------------------
-- Table structure for `caipu_cat`
-- ----------------------------
DROP TABLE IF EXISTS `caipu_cat`;
CREATE TABLE `caipu_cat` (
  `catid` smallint(6) NOT NULL AUTO_INCREMENT,
  `pid` smallint(6) NOT NULL COMMENT '上级分类',
  `cname` varchar(20) CHARACTER SET gbk NOT NULL COMMENT '分类名称',
  `orderindex` tinyint(4) NOT NULL COMMENT '排序',
  PRIMARY KEY (`catid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of caipu_cat
-- ----------------------------

-- ----------------------------
-- Table structure for `caipu_tags`
-- ----------------------------
DROP TABLE IF EXISTS `caipu_tags`;
CREATE TABLE `caipu_tags` (
  `tagid` int(11) NOT NULL AUTO_INCREMENT,
  `tagname` varchar(10) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `orderindex` tinyint(4) NOT NULL,
  `c_num` int(11) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`tagid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of caipu_tags
-- ----------------------------

-- ----------------------------
-- Table structure for `caipu_tags_index`
-- ----------------------------
DROP TABLE IF EXISTS `caipu_tags_index`;
CREATE TABLE `caipu_tags_index` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tagid` int(11) NOT NULL,
  `caipu_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of caipu_tags_index
-- ----------------------------

-- ----------------------------
-- Table structure for `cai_cat`
-- ----------------------------
DROP TABLE IF EXISTS `cai_cat`;
CREATE TABLE `cai_cat` (
  `catid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '1' COMMENT '站点id',
  `shopid` mediumint(9) unsigned NOT NULL DEFAULT '0' COMMENT '店铺id',
  `cname` varchar(50) COLLATE gbk_bin NOT NULL COMMENT '分类名称',
  `orderid` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`catid`),
  KEY `shopid` (`shopid`),
  KEY `orderid` (`orderid`),
  KEY `siteid` (`siteid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of cai_cat
-- ----------------------------
INSERT INTO `cai_cat` VALUES ('1', '1', '1', '午饭', '0');

-- ----------------------------
-- Table structure for `cai_comment`
-- ----------------------------
DROP TABLE IF EXISTS `cai_comment`;
CREATE TABLE `cai_comment` (
  `rid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `shopid` mediumint(9) unsigned NOT NULL DEFAULT '0',
  `pid` mediumint(6) unsigned NOT NULL DEFAULT '0',
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `dateline` int(11) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) COLLATE gbk_bin NOT NULL,
  `content` varchar(255) COLLATE gbk_bin NOT NULL,
  `reply` varchar(255) COLLATE gbk_bin NOT NULL,
  `ip` varchar(50) COLLATE gbk_bin NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) COLLATE gbk_bin NOT NULL,
  PRIMARY KEY (`rid`),
  KEY `siteid_rid` (`siteid`,`rid`),
  KEY `siteid_status_rid` (`siteid`,`status`,`rid`),
  KEY `shopid_status_rid` (`shopid`,`status`,`rid`),
  KEY `pid_shopid_status_rid` (`pid`,`status`,`shopid`,`rid`),
  KEY `pid_siteid_status_rid` (`pid`,`siteid`,`status`,`rid`),
  KEY `pid_status_rid` (`pid`,`status`,`rid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of cai_comment
-- ----------------------------

-- ----------------------------
-- Table structure for `cai_data`
-- ----------------------------
DROP TABLE IF EXISTS `cai_data`;
CREATE TABLE `cai_data` (
  `id` mediumint(9) NOT NULL,
  `content` text CHARACTER SET gbk NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of cai_data
-- ----------------------------
INSERT INTO `cai_data` VALUES ('1', '最新美味的红烧鳕鱼饭');
INSERT INTO `cai_data` VALUES ('2', '');
INSERT INTO `cai_data` VALUES ('3', '');
INSERT INTO `cai_data` VALUES ('4', '');

-- ----------------------------
-- Table structure for `cai_do`
-- ----------------------------
DROP TABLE IF EXISTS `cai_do`;
CREATE TABLE `cai_do` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `dname` varchar(50) COLLATE gbk_bin NOT NULL,
  `orderid` smallint(6) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `siteid` (`siteid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of cai_do
-- ----------------------------

-- ----------------------------
-- Table structure for `cai_ping`
-- ----------------------------
DROP TABLE IF EXISTS `cai_ping`;
CREATE TABLE `cai_ping` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `shopid` mediumint(9) unsigned NOT NULL DEFAULT '0',
  `caiid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `ctype` tinyint(4) NOT NULL DEFAULT '0',
  `ip` varchar(50) COLLATE gbk_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `caiid` (`caiid`,`userid`),
  KEY `shopid` (`shopid`),
  KEY `siteid` (`siteid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of cai_ping
-- ----------------------------

-- ----------------------------
-- Table structure for `cai_tags`
-- ----------------------------
DROP TABLE IF EXISTS `cai_tags`;
CREATE TABLE `cai_tags` (
  `caiid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `tagname` varchar(30) COLLATE gbk_bin NOT NULL,
  KEY `caiid` (`caiid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of cai_tags
-- ----------------------------
INSERT INTO `cai_tags` VALUES ('1', '');
INSERT INTO `cai_tags` VALUES ('2', '');
INSERT INTO `cai_tags` VALUES ('3', '');
INSERT INTO `cai_tags` VALUES ('4', '');

-- ----------------------------
-- Table structure for `cai_wei`
-- ----------------------------
DROP TABLE IF EXISTS `cai_wei`;
CREATE TABLE `cai_wei` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `wname` varchar(50) COLLATE gbk_bin NOT NULL,
  `orderid` smallint(6) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `siteid` (`siteid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of cai_wei
-- ----------------------------

-- ----------------------------
-- Table structure for `city`
-- ----------------------------
DROP TABLE IF EXISTS `city`;
CREATE TABLE `city` (
  `cityid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `provinceid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `city` varchar(30) COLLATE gbk_bin NOT NULL,
  `orderindex` smallint(6) unsigned NOT NULL DEFAULT '0',
  `lat` decimal(9,6) NOT NULL,
  `lng` decimal(9,6) NOT NULL,
  PRIMARY KEY (`cityid`),
  KEY `orderindex` (`orderindex`),
  KEY `siteid` (`siteid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of city
-- ----------------------------
INSERT INTO `city` VALUES ('1', '1', '1', '骡马市', '0', '0.000000', '0.000000');

-- ----------------------------
-- Table structure for `config`
-- ----------------------------
DROP TABLE IF EXISTS `config`;
CREATE TABLE `config` (
  `id` tinyint(1) NOT NULL AUTO_INCREMENT,
  `opentime` tinyint(4) NOT NULL DEFAULT '0',
  `phone_on` tinyint(4) NOT NULL DEFAULT '0',
  `phone_user` varchar(100) COLLATE gbk_bin NOT NULL,
  `phone_pwd` varchar(100) COLLATE gbk_bin NOT NULL,
  `phone_num` varchar(20) COLLATE gbk_bin NOT NULL,
  `smtphost` varchar(100) COLLATE gbk_bin NOT NULL,
  `smtpport` smallint(6) NOT NULL DEFAULT '0',
  `smtpemail` varchar(100) COLLATE gbk_bin NOT NULL,
  `smtpuser` varchar(100) COLLATE gbk_bin NOT NULL,
  `smtppwd` varchar(100) COLLATE gbk_bin NOT NULL,
  `water_on` tinyint(4) NOT NULL DEFAULT '0',
  `water_type` tinyint(4) NOT NULL DEFAULT '0',
  `water_pos` tinyint(4) NOT NULL DEFAULT '0',
  `water_str` varchar(100) COLLATE gbk_bin NOT NULL,
  `water_img` varchar(100) COLLATE gbk_bin NOT NULL,
  `water_size` tinyint(4) NOT NULL DEFAULT '0',
  `rewrite_on` tinyint(1) NOT NULL DEFAULT '0',
  `sina_on` tinyint(4) NOT NULL DEFAULT '0',
  `qq_on` tinyint(4) NOT NULL DEFAULT '0',
  `sina_user` varchar(100) COLLATE gbk_bin NOT NULL,
  `sina_pwd` varchar(100) COLLATE gbk_bin NOT NULL,
  `qq_user` varchar(100) COLLATE gbk_bin NOT NULL,
  `qq_pwd` varchar(100) COLLATE gbk_bin NOT NULL,
  `spread_on` tinyint(4) NOT NULL DEFAULT '0',
  `spread_discount` tinyint(4) NOT NULL DEFAULT '0',
  `grade_on` tinyint(4) NOT NULL DEFAULT '0',
  `starthour` tinyint(4) NOT NULL DEFAULT '0',
  `endhour` tinyint(4) NOT NULL DEFAULT '0',
  `startminute` tinyint(4) NOT NULL DEFAULT '0',
  `endminute` tinyint(4) NOT NULL DEFAULT '0',
  `showweek` tinyint(1) NOT NULL DEFAULT '0',
  `minprice` decimal(8,2) NOT NULL,
  `shopid` mediumint(9) NOT NULL DEFAULT '0',
  `thumb_width` smallint(6) NOT NULL DEFAULT '0',
  `thumb_height` smallint(6) NOT NULL DEFAULT '0',
  `alipay` tinyint(1) NOT NULL DEFAULT '0',
  `tenpay` tinyint(1) NOT NULL DEFAULT '0',
  `maxgrade` smallint(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of config
-- ----------------------------
INSERT INTO `config` VALUES ('1', '0', '0', '', '', '', '', '0', '', '', '', '0', '0', '0', '', '', '0', '0', '0', '0', '', '', '', '', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0', '0', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for `cook`
-- ----------------------------
DROP TABLE IF EXISTS `cook`;
CREATE TABLE `cook` (
  `cookid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `shopid` mediumint(9) unsigned NOT NULL DEFAULT '0',
  `nickname` varchar(100) COLLATE gbk_bin NOT NULL,
  `weibo` varchar(100) COLLATE gbk_bin NOT NULL,
  `pic` varchar(100) COLLATE gbk_bin NOT NULL,
  `info` varchar(255) COLLATE gbk_bin NOT NULL,
  `url` varchar(100) COLLATE gbk_bin NOT NULL,
  `content` text COLLATE gbk_bin NOT NULL,
  `isding` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `orderid` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `grade` int(11) unsigned NOT NULL DEFAULT '0',
  `click` int(11) unsigned NOT NULL DEFAULT '0',
  `delicious` int(11) unsigned NOT NULL DEFAULT '0',
  `undelicious` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`cookid`),
  KEY `nickname` (`nickname`),
  KEY `siteid` (`siteid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of cook
-- ----------------------------

-- ----------------------------
-- Table structure for `cook_cai`
-- ----------------------------
DROP TABLE IF EXISTS `cook_cai`;
CREATE TABLE `cook_cai` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `caiid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `cookid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `orderid` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `shopid` mediumint(9) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `siteid` (`siteid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of cook_cai
-- ----------------------------

-- ----------------------------
-- Table structure for `cook_comment`
-- ----------------------------
DROP TABLE IF EXISTS `cook_comment`;
CREATE TABLE `cook_comment` (
  `rid` int(11) NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `shopid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `pid` smallint(6) NOT NULL DEFAULT '0',
  `userid` int(11) NOT NULL DEFAULT '0',
  `dateline` int(11) NOT NULL DEFAULT '0',
  `title` varchar(100) COLLATE gbk_bin NOT NULL,
  `content` text COLLATE gbk_bin NOT NULL,
  `reply` text COLLATE gbk_bin NOT NULL,
  `ip` varchar(50) COLLATE gbk_bin NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `username` varchar(30) COLLATE gbk_bin NOT NULL,
  PRIMARY KEY (`rid`),
  KEY `shopid_status_rid` (`shopid`,`status`,`rid`),
  KEY `siteid_status_rid` (`siteid`,`status`,`rid`),
  KEY `pid_siteid_status_rid` (`pid`,`siteid`,`status`,`rid`),
  KEY `pid_shopid_status_rid` (`pid`,`shopid`,`status`,`rid`),
  KEY `pid_status_rid` (`pid`,`status`,`rid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of cook_comment
-- ----------------------------

-- ----------------------------
-- Table structure for `cook_ping`
-- ----------------------------
DROP TABLE IF EXISTS `cook_ping`;
CREATE TABLE `cook_ping` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `shopid` mediumint(9) NOT NULL DEFAULT '0',
  `cookid` smallint(6) NOT NULL DEFAULT '0',
  `userid` int(11) NOT NULL DEFAULT '0',
  `ctype` tinyint(4) NOT NULL DEFAULT '0',
  `ip` varchar(50) COLLATE gbk_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `caiid` (`cookid`,`userid`),
  KEY `siteid` (`siteid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of cook_ping
-- ----------------------------

-- ----------------------------
-- Table structure for `ddw_stole_rule`
-- ----------------------------
DROP TABLE IF EXISTS `ddw_stole_rule`;
CREATE TABLE `ddw_stole_rule` (
  `id` int(11) NOT NULL,
  `title` varchar(225) NOT NULL,
  `catid` int(11) NOT NULL,
  `s_title` text NOT NULL,
  `e_title` text,
  `s_author` text,
  `e_author` text,
  `s_content` text,
  `e_content` text,
  `status` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ddw_stole_rule
-- ----------------------------

-- ----------------------------
-- Table structure for `fav_cai`
-- ----------------------------
DROP TABLE IF EXISTS `fav_cai`;
CREATE TABLE `fav_cai` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL,
  `shopid` int(10) unsigned NOT NULL,
  `caiid` int(10) unsigned NOT NULL,
  `userid` int(10) unsigned NOT NULL,
  `shopname` varchar(20) CHARACTER SET gbk NOT NULL,
  `dateline` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fav_cai
-- ----------------------------

-- ----------------------------
-- Table structure for `fav_shop`
-- ----------------------------
DROP TABLE IF EXISTS `fav_shop`;
CREATE TABLE `fav_shop` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `shopid` int(11) unsigned NOT NULL,
  `userid` mediumint(9) unsigned NOT NULL,
  `dateline` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `shopid` (`shopid`,`userid`),
  KEY `userid` (`userid`),
  KEY `siteid` (`siteid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of fav_shop
-- ----------------------------

-- ----------------------------
-- Table structure for `flash`
-- ----------------------------
DROP TABLE IF EXISTS `flash`;
CREATE TABLE `flash` (
  `fid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `shopid` mediumint(9) NOT NULL DEFAULT '0',
  `ftitle` varchar(50) COLLATE gbk_bin NOT NULL,
  `furl` varchar(100) COLLATE gbk_bin NOT NULL,
  `fimg` varchar(100) COLLATE gbk_bin NOT NULL,
  `forder` tinyint(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`fid`),
  KEY `shopid` (`shopid`),
  KEY `siteid_fid` (`siteid`,`fid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of flash
-- ----------------------------

-- ----------------------------
-- Table structure for `follow`
-- ----------------------------
DROP TABLE IF EXISTS `follow`;
CREATE TABLE `follow` (
  `userid` mediumint(9) NOT NULL,
  `touserid` mediumint(9) NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '1关注 2双向关注',
  `dateline` int(11) NOT NULL DEFAULT '0',
  KEY `uid` (`userid`,`touserid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of follow
-- ----------------------------

-- ----------------------------
-- Table structure for `goods`
-- ----------------------------
DROP TABLE IF EXISTS `goods`;
CREATE TABLE `goods` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `catid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `title` varchar(50) COLLATE gbk_bin NOT NULL,
  `thumb_img` varchar(255) COLLATE gbk_bin NOT NULL,
  `middle_img` varchar(255) COLLATE gbk_bin NOT NULL,
  `img` varchar(255) COLLATE gbk_bin NOT NULL,
  `info` varchar(255) COLLATE gbk_bin NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `grade` mediumint(9) unsigned NOT NULL,
  `content` text COLLATE gbk_bin NOT NULL,
  `orders` mediumint(9) unsigned NOT NULL,
  `visible` tinyint(1) unsigned NOT NULL,
  `comments` mediumint(9) unsigned NOT NULL,
  `clicks` mediumint(9) unsigned NOT NULL,
  `isrecommend` tinyint(1) unsigned NOT NULL,
  `isnew` tinyint(1) unsigned NOT NULL,
  `ishot` tinyint(1) unsigned NOT NULL,
  `keyword` varchar(255) COLLATE gbk_bin NOT NULL,
  `dateline` int(11) unsigned NOT NULL,
  `payprice` decimal(7,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `title_id` (`title`,`id`),
  KEY `title_catid_id` (`title`,`catid`,`id`),
  KEY `catid_id` (`catid`,`id`),
  KEY `visible_catid` (`visible`,`catid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of goods
-- ----------------------------

-- ----------------------------
-- Table structure for `goods_cat`
-- ----------------------------
DROP TABLE IF EXISTS `goods_cat`;
CREATE TABLE `goods_cat` (
  `catid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `cname` varchar(20) COLLATE gbk_bin NOT NULL,
  `orderindex` smallint(6) unsigned NOT NULL,
  `t` tinyint(1) unsigned NOT NULL,
  `cattpl` varchar(50) COLLATE gbk_bin NOT NULL,
  `listtpl` varchar(50) COLLATE gbk_bin NOT NULL,
  `contpl` varchar(50) COLLATE gbk_bin NOT NULL,
  PRIMARY KEY (`catid`),
  KEY `orderindex` (`orderindex`),
  KEY `siteid` (`siteid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of goods_cat
-- ----------------------------

-- ----------------------------
-- Table structure for `goods_comment`
-- ----------------------------
DROP TABLE IF EXISTS `goods_comment`;
CREATE TABLE `goods_comment` (
  `rid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `pid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `userid` mediumint(9) unsigned NOT NULL DEFAULT '0',
  `dateline` int(11) NOT NULL DEFAULT '0',
  `title` varchar(100) COLLATE gbk_bin NOT NULL,
  `content` varchar(2000) COLLATE gbk_bin NOT NULL,
  `reply` varchar(1000) COLLATE gbk_bin NOT NULL,
  `ip` varchar(50) COLLATE gbk_bin NOT NULL,
  `status` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) COLLATE gbk_bin NOT NULL,
  PRIMARY KEY (`rid`),
  KEY `pid_status_rid` (`pid`,`status`,`rid`),
  KEY `siteid_status_rid` (`siteid`,`status`,`rid`),
  KEY `pid_siteid_status_rid` (`pid`,`siteid`,`status`,`rid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of goods_comment
-- ----------------------------

-- ----------------------------
-- Table structure for `goods_order`
-- ----------------------------
DROP TABLE IF EXISTS `goods_order`;
CREATE TABLE `goods_order` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `orderno` varchar(50) COLLATE gbk_bin NOT NULL,
  `goodsid` mediumint(8) unsigned NOT NULL,
  `grade` mediumint(9) unsigned NOT NULL,
  `userid` mediumint(9) unsigned NOT NULL,
  `nickname` varchar(20) COLLATE gbk_bin NOT NULL,
  `address` varchar(50) COLLATE gbk_bin NOT NULL,
  `status` tinyint(2) unsigned NOT NULL,
  `phone` varchar(20) COLLATE gbk_bin NOT NULL,
  `email` varchar(20) COLLATE gbk_bin NOT NULL,
  `content` text COLLATE gbk_bin NOT NULL,
  `sendtype` tinyint(4) unsigned NOT NULL,
  `isvalid` tinyint(1) unsigned NOT NULL,
  `money` decimal(8,2) NOT NULL,
  `dateline` int(11) unsigned NOT NULL,
  `goodsname` varchar(30) COLLATE gbk_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `orderno` (`orderno`),
  KEY `money` (`money`),
  KEY `dateline_id` (`dateline`,`id`),
  KEY `sendtype_id` (`sendtype`,`id`),
  KEY `userid_isvalid_id` (`userid`,`isvalid`,`id`),
  KEY `isvalid_id` (`isvalid`,`id`),
  KEY `isvalid_dateline_id` (`isvalid`,`dateline`,`id`),
  KEY `userid_sendtype_grade` (`userid`,`sendtype`,`grade`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of goods_order
-- ----------------------------

-- ----------------------------
-- Table structure for `grade`
-- ----------------------------
DROP TABLE IF EXISTS `grade`;
CREATE TABLE `grade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` mediumint(9) unsigned NOT NULL DEFAULT '0',
  `grade` decimal(8,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of grade
-- ----------------------------

-- ----------------------------
-- Table structure for `grade_log`
-- ----------------------------
DROP TABLE IF EXISTS `grade_log`;
CREATE TABLE `grade_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` mediumint(9) unsigned NOT NULL DEFAULT '0',
  `content` varchar(200) COLLATE gbk_bin NOT NULL,
  `grade` decimal(8,2) NOT NULL,
  `dateline` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of grade_log
-- ----------------------------
INSERT INTO `grade_log` VALUES ('1', '1', '订单20130118完成，您获得80.00可用积分。', '80.00', '1359362338');

-- ----------------------------
-- Table structure for `groupbuy`
-- ----------------------------
DROP TABLE IF EXISTS `groupbuy`;
CREATE TABLE `groupbuy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) CHARACTER SET gbk NOT NULL,
  `img` varchar(200) CHARACTER SET gbk NOT NULL,
  `siteid` smallint(6) NOT NULL,
  `shopid` int(11) NOT NULL,
  `catid` smallint(5) unsigned NOT NULL,
  `joins` mediumint(8) unsigned NOT NULL,
  `minjoins` smallint(5) unsigned NOT NULL,
  `goodsprice` decimal(9,1) NOT NULL,
  `groupprice` decimal(9,1) NOT NULL,
  `endtime` int(11) NOT NULL,
  `shopname` varchar(20) CHARACTER SET gbk NOT NULL,
  `status` tinyint(4) NOT NULL,
  `isrecommend` tinyint(4) NOT NULL,
  `info` varchar(255) CHARACTER SET gbk NOT NULL,
  `content` text CHARACTER SET gbk NOT NULL,
  `provinceid` int(10) unsigned NOT NULL,
  `cityid` int(10) unsigned NOT NULL,
  `townid` int(10) unsigned NOT NULL,
  `goods_num` int(11) NOT NULL COMMENT '库存数',
  `grouptype` tinyint(4) NOT NULL DEFAULT '0' COMMENT '团购方式',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of groupbuy
-- ----------------------------

-- ----------------------------
-- Table structure for `groupbuy_category`
-- ----------------------------
DROP TABLE IF EXISTS `groupbuy_category`;
CREATE TABLE `groupbuy_category` (
  `catid` int(11) NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL,
  `cname` varchar(25) NOT NULL,
  `orderindex` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`catid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of groupbuy_category
-- ----------------------------

-- ----------------------------
-- Table structure for `groupbuy_order`
-- ----------------------------
DROP TABLE IF EXISTS `groupbuy_order`;
CREATE TABLE `groupbuy_order` (
  `orderid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `groupid` int(10) unsigned NOT NULL,
  `userid` int(10) unsigned NOT NULL,
  `phone` varchar(20) CHARACTER SET gbk NOT NULL,
  `address` varchar(100) CHARACTER SET gbk NOT NULL,
  `goodsnum` smallint(5) unsigned NOT NULL,
  `title` varchar(50) CHARACTER SET gbk NOT NULL,
  `dateline` int(10) unsigned NOT NULL,
  `status` tinyint(1) NOT NULL,
  `groupprice` decimal(8,2) NOT NULL,
  `totalprice` decimal(8,2) NOT NULL,
  `nickname` varchar(20) NOT NULL,
  `ispay` tinyint(1) unsigned NOT NULL,
  `intime` int(11) NOT NULL DEFAULT '0' COMMENT '生效时间',
  PRIMARY KEY (`orderid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of groupbuy_order
-- ----------------------------

-- ----------------------------
-- Table structure for `guest`
-- ----------------------------
DROP TABLE IF EXISTS `guest`;
CREATE TABLE `guest` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `shopid` mediumint(9) unsigned NOT NULL DEFAULT '0',
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) COLLATE gbk_bin NOT NULL,
  `content` varchar(255) COLLATE gbk_bin NOT NULL,
  `dateline` int(11) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(50) COLLATE gbk_bin NOT NULL,
  `reply` varchar(255) COLLATE gbk_bin NOT NULL,
  `qq` int(11) NOT NULL DEFAULT '0',
  `email` varchar(100) COLLATE gbk_bin NOT NULL,
  `phone` varchar(20) COLLATE gbk_bin NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `username` varchar(50) COLLATE gbk_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `status_id` (`status`,`id`),
  KEY `status_shopid_id` (`status`,`shopid`,`id`),
  KEY `userid_id` (`userid`,`id`),
  KEY `userid_shopid_id` (`userid`,`shopid`,`id`),
  KEY `shopid_id` (`shopid`,`id`),
  KEY `siteid_status_id` (`siteid`,`status`,`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of guest
-- ----------------------------

-- ----------------------------
-- Table structure for `hotarea`
-- ----------------------------
DROP TABLE IF EXISTS `hotarea`;
CREATE TABLE `hotarea` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL,
  `title` varchar(50) COLLATE gbk_bin NOT NULL,
  `lat` decimal(9,6) NOT NULL,
  `lng` decimal(9,6) NOT NULL,
  `orderindex` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of hotarea
-- ----------------------------

-- ----------------------------
-- Table structure for `html`
-- ----------------------------
DROP TABLE IF EXISTS `html`;
CREATE TABLE `html` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `shopid` mediumint(9) unsigned NOT NULL DEFAULT '0',
  `userid` mediumint(9) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) COLLATE gbk_bin NOT NULL,
  `keyword` varchar(200) COLLATE gbk_bin NOT NULL,
  `des` varchar(255) COLLATE gbk_bin NOT NULL,
  `tagname` varchar(20) COLLATE gbk_bin NOT NULL,
  `content` text COLLATE gbk_bin NOT NULL,
  `orderid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `isnav` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `catid` tinyint(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `tagname` (`tagname`),
  KEY `shopid` (`shopid`),
  KEY `siteid` (`siteid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of html
-- ----------------------------

-- ----------------------------
-- Table structure for `html_cat`
-- ----------------------------
DROP TABLE IF EXISTS `html_cat`;
CREATE TABLE `html_cat` (
  `catid` tinyint(4) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `shopid` mediumint(9) unsigned NOT NULL DEFAULT '0',
  `cname` varchar(100) COLLATE gbk_bin NOT NULL,
  `orderid` tinyint(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`catid`),
  KEY `shopid` (`shopid`),
  KEY `siteid` (`siteid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of html_cat
-- ----------------------------

-- ----------------------------
-- Table structure for `link`
-- ----------------------------
DROP TABLE IF EXISTS `link`;
CREATE TABLE `link` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `title` varchar(50) COLLATE gbk_bin NOT NULL,
  `linkurl` varchar(100) COLLATE gbk_bin NOT NULL,
  `linkimg` varchar(100) COLLATE gbk_bin NOT NULL,
  `linktype` tinyint(1) NOT NULL DEFAULT '0',
  `orderid` smallint(6) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `siteid` (`siteid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of link
-- ----------------------------

-- ----------------------------
-- Table structure for `message`
-- ----------------------------
DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` mediumint(8) unsigned NOT NULL,
  `content` text CHARACTER SET gbk COLLATE gbk_bin NOT NULL,
  `dateline` int(10) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `status_id` (`status`,`id`),
  KEY `userid_status_id` (`userid`,`status`,`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of message
-- ----------------------------
INSERT INTO `message` VALUES ('1', '1', 0xE8AEA2E58D95E7BC96E58FB7E4B8BA3230313330313138E5B7B2E98081E8B4A72C3C6120687265663D27696E6465782E7068703F6D3D73686F7063617226613D686973746F7279273EE8AFB7E7A1AEE8AEA4E694B6E8B4A73C2F613E, '1359362338', '0');

-- ----------------------------
-- Table structure for `nav`
-- ----------------------------
DROP TABLE IF EXISTS `nav`;
CREATE TABLE `nav` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `shopid` mediumint(9) unsigned NOT NULL DEFAULT '0',
  `title` varchar(30) COLLATE gbk_bin NOT NULL,
  `navurl` varchar(100) COLLATE gbk_bin NOT NULL,
  `orderid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `ctype` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `pid` smallint(6) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `shopid` (`shopid`),
  KEY `pid` (`pid`),
  KEY `siteid` (`siteid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of nav
-- ----------------------------

-- ----------------------------
-- Table structure for `order`
-- ----------------------------
DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned DEFAULT '1',
  `shopid` mediumint(9) unsigned DEFAULT '0',
  `userid` mediumint(9) unsigned DEFAULT '0',
  `isvalid` tinyint(1) unsigned DEFAULT '0',
  `money` decimal(9,2) DEFAULT '0.00',
  `dateline` int(11) unsigned DEFAULT '0',
  `orderno` varchar(20) COLLATE gbk_bin DEFAULT NULL,
  `ssid` varchar(60) COLLATE gbk_bin DEFAULT NULL,
  `orderphone` varchar(30) COLLATE gbk_bin DEFAULT NULL,
  `orderaddress` varchar(200) COLLATE gbk_bin DEFAULT NULL,
  `orderuser` varchar(100) COLLATE gbk_bin DEFAULT NULL,
  `sendtype` tinyint(1) unsigned DEFAULT '0' COMMENT '配送状态',
  `senddes` text COLLATE gbk_bin,
  `ispay` tinyint(4) unsigned DEFAULT '0' COMMENT '余额支付',
  `iscomment` tinyint(1) unsigned DEFAULT NULL,
  `orderinfo` text COLLATE gbk_bin,
  `received` tinyint(1) unsigned DEFAULT '0' COMMENT '已收货',
  `grade` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orderno` (`orderno`),
  KEY `siteid_isvalid_id` (`siteid`,`isvalid`,`id`),
  KEY `money` (`money`),
  KEY `siteid_isvalid_dateline_id` (`siteid`,`isvalid`,`dateline`,`id`),
  KEY `siteid_isvalid_money` (`siteid`,`money`,`isvalid`,`dateline`),
  KEY `shopid_isvalid_id` (`shopid`,`isvalid`,`id`),
  KEY `siteid_isvalid_sendtype` (`siteid`,`isvalid`,`sendtype`,`id`),
  KEY `siteid_isvalid_user_id` (`siteid`,`isvalid`,`orderuser`,`id`),
  KEY `userid_isvalid_siteid_id` (`userid`,`isvalid`,`siteid`,`id`),
  KEY `siteid_sendtype` (`siteid`,`sendtype`),
  KEY `sendtype_money` (`sendtype`,`money`),
  KEY `userid_siteid` (`userid`,`siteid`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of order
-- ----------------------------
INSERT INTO `order` VALUES ('26', '1', '1', '1', '1', '320.00', '1359365402', '20130126', null, '13880403202', '打发士大夫', 'wanghexiangqq', '0', null, '0', null, '', '0', null);
INSERT INTO `order` VALUES ('27', '1', '1', '1', '1', '360.00', '1359365742', '20130127', null, '123811d1fdsdf', '打发士大夫', 'wanghexiangqq', '0', null, '0', null, '', '0', null);
INSERT INTO `order` VALUES ('28', '1', '1', '1', '1', '80.00', '1359423119', '20130128', null, '1223', '是打发士大夫是打发士大夫是的发生大', 'wanghexiangqq', '0', null, '0', null, '', '0', null);
INSERT INTO `order` VALUES ('29', '1', '1', '1', '1', '168.00', '1359423428', '20130129', null, '1232', '打发士大夫', 'wanghexiangqq', '0', null, '0', null, '', '0', null);

-- ----------------------------
-- Table structure for `ordershare`
-- ----------------------------
DROP TABLE IF EXISTS `ordershare`;
CREATE TABLE `ordershare` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL,
  `shopid` smallint(5) unsigned NOT NULL,
  `userid` int(10) unsigned NOT NULL,
  `dateline` int(10) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `siteid` (`siteid`),
  KEY `shopid` (`shopid`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ordershare
-- ----------------------------
INSERT INTO `ordershare` VALUES ('1', '1', '1', '2', '1359338521', '0', ' @<a href=\'index.php?m=member&userid=2\'></a> 在<a href=\'index.php?m=shop&shopid=1\' target=\'_blank\'>麦当劳</a>点了 <a href=\'index.php?m=cai&id=1\'>巨无霸</a> 2 份&nbsp;&nbsp; ');
INSERT INTO `ordershare` VALUES ('2', '1', '1', '2', '1359341621', '0', ' @<a href=\'index.php?m=member&userid=2\'></a> 在<a href=\'index.php?m=shop&shopid=1\' target=\'_blank\'>麦当劳</a>点了 <a href=\'index.php?m=cai&id=1\'>巨无霸</a> 7 份&nbsp;&nbsp; ');
INSERT INTO `ordershare` VALUES ('3', '1', '1', '2', '1359341704', '0', ' @<a href=\'index.php?m=member&userid=2\'></a> 在<a href=\'index.php?m=shop&shopid=1\' target=\'_blank\'>麦当劳</a>点了 <a href=\'index.php?m=cai&id=1\'>巨无霸</a> 1 份&nbsp;&nbsp; ');
INSERT INTO `ordershare` VALUES ('4', '1', '1', '2', '1359343134', '0', ' @<a href=\'index.php?m=member&userid=2\'></a> 在<a href=\'index.php?m=shop&shopid=1\' target=\'_blank\'>麦当劳</a>点了 <a href=\'index.php?m=cai&id=1\'>巨无霸</a> 12 份&nbsp;&nbsp; ');
INSERT INTO `ordershare` VALUES ('5', '1', '1', '2', '1359343168', '0', ' @<a href=\'index.php?m=member&userid=2\'></a> 在<a href=\'index.php?m=shop&shopid=1\' target=\'_blank\'>麦当劳</a>点了');
INSERT INTO `ordershare` VALUES ('6', '1', '1', '2', '1359343174', '0', ' @<a href=\'index.php?m=member&userid=2\'></a> 在<a href=\'index.php?m=shop&shopid=1\' target=\'_blank\'>麦当劳</a>点了 <a href=\'index.php?m=cai&id=1\'>巨无霸</a> 1 份&nbsp;&nbsp; ');
INSERT INTO `ordershare` VALUES ('7', '1', '1', '2', '1359343438', '0', ' @<a href=\'index.php?m=member&userid=2\'></a> 在<a href=\'index.php?m=shop&shopid=1\' target=\'_blank\'>麦当劳</a>点了 <a href=\'index.php?m=cai&id=1\'>巨无霸</a> 4 份&nbsp;&nbsp; ');
INSERT INTO `ordershare` VALUES ('8', '1', '1', '2', '1359343444', '0', ' @<a href=\'index.php?m=member&userid=2\'></a> 在<a href=\'index.php?m=shop&shopid=1\' target=\'_blank\'>麦当劳</a>点了 <a href=\'index.php?m=cai&id=1\'>巨无霸</a> 4 份&nbsp;&nbsp; ');
INSERT INTO `ordershare` VALUES ('9', '1', '1', '2', '1359343448', '0', ' @<a href=\'index.php?m=member&userid=2\'></a> 在<a href=\'index.php?m=shop&shopid=1\' target=\'_blank\'>麦当劳</a>点了 <a href=\'index.php?m=cai&id=1\'>巨无霸</a> 1 份&nbsp;&nbsp; ');
INSERT INTO `ordershare` VALUES ('10', '1', '1', '2', '1359343814', '0', ' @<a href=\'index.php?m=member&userid=2\'></a> 在<a href=\'index.php?m=shop&shopid=1\' target=\'_blank\'>麦当劳</a>点了 <a href=\'index.php?m=cai&id=1\'>巨无霸</a> 1 份&nbsp;&nbsp; ');
INSERT INTO `ordershare` VALUES ('11', '1', '1', '2', '1359343839', '0', ' @<a href=\'index.php?m=member&userid=2\'></a> 在<a href=\'index.php?m=shop&shopid=1\' target=\'_blank\'>麦当劳</a>点了 <a href=\'index.php?m=cai&id=1\'>巨无霸</a> 1 份&nbsp;&nbsp; ');
INSERT INTO `ordershare` VALUES ('12', '1', '1', '2', '1359344151', '0', ' @<a href=\'index.php?m=member&userid=2\'></a> 在<a href=\'index.php?m=shop&shopid=1\' target=\'_blank\'>麦当劳</a>点了 <a href=\'index.php?m=cai&id=1\'>巨无霸</a> 6 份&nbsp;&nbsp; ');
INSERT INTO `ordershare` VALUES ('13', '1', '1', '2', '1359355169', '0', ' @<a href=\'index.php?m=member&userid=2\'></a> 在<a href=\'index.php?m=shop&shopid=1\' target=\'_blank\'>麦当劳</a>点了 <a href=\'index.php?m=cai&id=1\'>巨无霸</a> 1 份&nbsp;&nbsp; ');
INSERT INTO `ordershare` VALUES ('14', '1', '1', '2', '1359355372', '0', ' @<a href=\'index.php?m=member&userid=2\'></a> 在<a href=\'index.php?m=shop&shopid=1\' target=\'_blank\'>麦当劳</a>点了 <a href=\'index.php?m=cai&id=1\'>巨无霸</a> 3 份&nbsp;&nbsp; ');
INSERT INTO `ordershare` VALUES ('15', '1', '1', '2', '1359355730', '0', ' @<a href=\'index.php?m=member&userid=2\'></a> 在<a href=\'index.php?m=shop&shopid=1\' target=\'_blank\'>麦当劳</a>点了 <a href=\'index.php?m=cai&id=1\'>巨无霸</a> 9 份&nbsp;&nbsp; ');
INSERT INTO `ordershare` VALUES ('16', '1', '1', '2', '1359355841', '0', ' @<a href=\'index.php?m=member&userid=2\'></a> 在<a href=\'index.php?m=shop&shopid=1\' target=\'_blank\'>麦当劳</a>点了 <a href=\'index.php?m=cai&id=1\'>巨无霸</a> 4 份&nbsp;&nbsp; ');
INSERT INTO `ordershare` VALUES ('17', '1', '1', '2', '1359356569', '0', ' @<a href=\'index.php?m=member&userid=2\'></a> 在<a href=\'index.php?m=shop&shopid=1\' target=\'_blank\'>麦当劳</a>点了 <a href=\'index.php?m=cai&id=1\'>巨无霸</a> 3 份&nbsp;&nbsp; ');
INSERT INTO `ordershare` VALUES ('18', '1', '1', '1', '1359357085', '0', ' @<a href=\'index.php?m=member&userid=1\'></a> 在<a href=\'index.php?m=shop&shopid=1\' target=\'_blank\'>麦当劳</a>点了 <a href=\'index.php?m=cai&id=4\'>可乐</a> 1 份&nbsp;&nbsp;  <a href=\'index.php?m=cai&id=3\'>中薯条</a> 1 份&nbsp;&nbsp;  <a href=\'index.php?m=cai&id=2\'>汉堡</a> 1 份&nbsp;&nbsp; ');
INSERT INTO `ordershare` VALUES ('19', '1', '1', '1', '1359357471', '0', ' @<a href=\'index.php?m=member&userid=1\'></a> 在<a href=\'index.php?m=shop&shopid=1\' target=\'_blank\'>麦当劳</a>点了 <a href=\'index.php?m=cai&id=4\'>可乐</a> 2 份&nbsp;&nbsp;  <a href=\'index.php?m=cai&id=3\'>中薯条</a> 2 份&nbsp;&nbsp;  <a href=\'index.php?m=cai&id=2\'>汉堡</a> 2 份&nbsp;&nbsp;  <a href=\'index.php?m=cai&id=1\'>巨无霸</a> 1 份&nbsp;&nbsp; ');
INSERT INTO `ordershare` VALUES ('20', '1', '1', '2', '1359357634', '0', ' @<a href=\'index.php?m=member&userid=2\'></a> 在<a href=\'index.php?m=shop&shopid=1\' target=\'_blank\'>麦当劳</a>点了 <a href=\'index.php?m=cai&id=1\'>巨无霸</a> 6 份&nbsp;&nbsp; ');
INSERT INTO `ordershare` VALUES ('21', '1', '1', '1', '1359359500', '0', ' @<a href=\'index.php?m=member&userid=1\'></a> 在<a href=\'index.php?m=shop&shopid=1\' target=\'_blank\'>麦当劳</a>点了 <a href=\'index.php?m=cai&id=4\'>可乐</a> 3 份&nbsp;&nbsp;  <a href=\'index.php?m=cai&id=3\'>中薯条</a> 2 份&nbsp;&nbsp;  <a href=\'index.php?m=cai&id=2\'>汉堡</a> 3 份&nbsp;&nbsp; ');
INSERT INTO `ordershare` VALUES ('22', '1', '1', '2', '1359359776', '0', ' @<a href=\'index.php?m=member&userid=2\'></a> 在<a href=\'index.php?m=shop&shopid=1\' target=\'_blank\'>麦当劳</a>点了 <a href=\'index.php?m=cai&id=1\'>巨无霸</a> 14 份&nbsp;&nbsp; ');
INSERT INTO `ordershare` VALUES ('23', '1', '1', '2', '1359359855', '0', ' @<a href=\'index.php?m=member&userid=2\'></a> 在<a href=\'index.php?m=shop&shopid=1\' target=\'_blank\'>麦当劳</a>点了 <a href=\'index.php?m=cai&id=1\'>巨无霸</a> 1 份&nbsp;&nbsp; ');
INSERT INTO `ordershare` VALUES ('24', '1', '1', '1', '1359359957', '0', ' @<a href=\'index.php?m=member&userid=1\'></a> 在<a href=\'index.php?m=shop&shopid=1\' target=\'_blank\'>麦当劳</a>点了 <a href=\'index.php?m=cai&id=4\'>可乐</a> 4 份&nbsp;&nbsp;  <a href=\'index.php?m=cai&id=3\'>中薯条</a> 3 份&nbsp;&nbsp;  <a href=\'index.php?m=cai&id=2\'>汉堡</a> 4 份&nbsp;&nbsp; ');
INSERT INTO `ordershare` VALUES ('25', '1', '1', '2', '1359361414', '0', ' @<a href=\'index.php?m=member&userid=2\'></a> 在<a href=\'index.php?m=shop&shopid=1\' target=\'_blank\'>麦当劳</a>点了 <a href=\'index.php?m=cai&id=1\'>巨无霸</a> 3 份&nbsp;&nbsp; ');
INSERT INTO `ordershare` VALUES ('26', '1', '1', '2', '1359361481', '0', ' @<a href=\'index.php?m=member&userid=2\'></a> 在<a href=\'index.php?m=shop&shopid=1\' target=\'_blank\'>麦当劳</a>点了 <a href=\'index.php?m=cai&id=1\'>巨无霸</a> 3 份&nbsp;&nbsp; ');
INSERT INTO `ordershare` VALUES ('27', '1', '1', '1', '1359361632', '0', ' @<a href=\'index.php?m=member&userid=1\'></a> 在<a href=\'index.php?m=shop&shopid=1\' target=\'_blank\'>麦当劳</a>点了 <a href=\'index.php?m=cai&id=1\'>巨无霸</a> 4 份&nbsp;&nbsp; ');
INSERT INTO `ordershare` VALUES ('28', '1', '1', '1', '1359363186', '0', ' @<a href=\'index.php?m=member&userid=1\'></a> 在<a href=\'index.php?m=shop&shopid=1\' target=\'_blank\'>麦当劳</a>点了 <a href=\'index.php?m=cai&id=1\'>巨无霸</a> 5 份&nbsp;&nbsp; ');
INSERT INTO `ordershare` VALUES ('29', '1', '1', '2', '1359363409', '0', ' @<a href=\'index.php?m=member&userid=2\'></a> 在<a href=\'index.php?m=shop&shopid=1\' target=\'_blank\'>麦当劳</a>点了 <a href=\'index.php?m=cai&id=1\'>巨无霸</a> 3 份&nbsp;&nbsp; ');
INSERT INTO `ordershare` VALUES ('30', '1', '1', '1', '1359364395', '0', ' @<a href=\'index.php?m=member&userid=1\'></a> 在<a href=\'index.php?m=shop&shopid=1\' target=\'_blank\'>麦当劳</a>点了 <a href=\'index.php?m=cai&id=4\'>可乐</a> 5 份&nbsp;&nbsp;  <a href=\'index.php?m=cai&id=3\'>中薯条</a> 4 份&nbsp;&nbsp;  <a href=\'index.php?m=cai&id=2\'>汉堡</a> 6 份&nbsp;&nbsp; ');
INSERT INTO `ordershare` VALUES ('31', '1', '1', '1', '1359364952', '0', ' @<a href=\'index.php?m=member&userid=1\'></a> 在<a href=\'index.php?m=shop&shopid=1\' target=\'_blank\'>麦当劳</a>点了 <a href=\'index.php?m=cai&id=1\'>巨无霸</a> 6 份&nbsp;&nbsp; ');
INSERT INTO `ordershare` VALUES ('32', '1', '1', '1', '1359365237', '0', ' @<a href=\'index.php?m=member&userid=1\'></a> 在<a href=\'index.php?m=shop&shopid=1\' target=\'_blank\'>麦当劳</a>点了 <a href=\'index.php?m=cai&id=1\'>巨无霸</a> 8 份&nbsp;&nbsp; ');
INSERT INTO `ordershare` VALUES ('33', '1', '1', '1', '1359365308', '0', ' @<a href=\'index.php?m=member&userid=1\'></a> 在<a href=\'index.php?m=shop&shopid=1\' target=\'_blank\'>麦当劳</a>点了 <a href=\'index.php?m=cai&id=1\'>巨无霸</a> 13 份&nbsp;&nbsp; ');
INSERT INTO `ordershare` VALUES ('34', '1', '1', '1', '1359365375', '0', ' @<a href=\'index.php?m=member&userid=1\'></a> 在<a href=\'index.php?m=shop&shopid=1\' target=\'_blank\'>麦当劳</a>点了 <a href=\'index.php?m=cai&id=1\'>巨无霸</a> 14 份&nbsp;&nbsp; ');
INSERT INTO `ordershare` VALUES ('35', '1', '1', '1', '1359365402', '0', ' @<a href=\'index.php?m=member&userid=1\'></a> 在<a href=\'index.php?m=shop&shopid=1\' target=\'_blank\'>麦当劳</a>点了 <a href=\'index.php?m=cai&id=1\'>巨无霸</a> 16 份&nbsp;&nbsp; ');
INSERT INTO `ordershare` VALUES ('36', '1', '1', '1', '1359365742', '0', ' @<a href=\'index.php?m=member&userid=1\'></a> 在<a href=\'index.php?m=shop&shopid=1\' target=\'_blank\'>麦当劳</a>点了 <a href=\'index.php?m=cai&id=1\'>巨无霸</a> 18 份&nbsp;&nbsp; ');
INSERT INTO `ordershare` VALUES ('37', '1', '1', '1', '1359423119', '0', ' @<a href=\'index.php?m=member&userid=1\'></a> 在<a href=\'index.php?m=shop&shopid=1\' target=\'_blank\'>麦当劳</a>点了 <a href=\'index.php?m=cai&id=1\'>巨无霸</a> 4 份&nbsp;&nbsp; ');
INSERT INTO `ordershare` VALUES ('38', '1', '1', '1', '1359423428', '0', ' @<a href=\'index.php?m=member&userid=1\'></a> 在<a href=\'index.php?m=shop&shopid=1\' target=\'_blank\'>麦当劳</a>点了 <a href=\'index.php?m=cai&id=1\'>巨无霸</a> 3 份&nbsp;&nbsp;  <a href=\'index.php?m=cai&id=2\'>汉堡</a> 3 份&nbsp;&nbsp;  <a href=\'index.php?m=cai&id=3\'>中薯条</a> 3 份&nbsp;&nbsp;  <a href=\'index.php?m=cai&id=4\'>可乐</a> 5 份&nbsp;&nbsp; ');

-- ----------------------------
-- Table structure for `order_cai`
-- ----------------------------
DROP TABLE IF EXISTS `order_cai`;
CREATE TABLE `order_cai` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `shopid` mediumint(9) unsigned NOT NULL DEFAULT '0',
  `orderid` int(11) unsigned NOT NULL DEFAULT '0',
  `caiid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `cainum` smallint(6) unsigned NOT NULL DEFAULT '0',
  `title` varchar(50) COLLATE gbk_bin NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `grade` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `shopid` (`shopid`),
  KEY `orderid` (`orderid`)
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of order_cai
-- ----------------------------
INSERT INTO `order_cai` VALUES ('45', '1', '26', '1', '16', '巨无霸', '20.00', '0');
INSERT INTO `order_cai` VALUES ('46', '1', '27', '1', '18', '巨无霸', '20.00', '0');
INSERT INTO `order_cai` VALUES ('47', '1', '28', '1', '4', '巨无霸', '20.00', '0');
INSERT INTO `order_cai` VALUES ('48', '1', '29', '1', '3', '巨无霸', '20.00', '0');
INSERT INTO `order_cai` VALUES ('49', '1', '29', '2', '3', '汉堡', '20.00', '0');
INSERT INTO `order_cai` VALUES ('50', '1', '29', '3', '3', '中薯条', '6.00', '0');
INSERT INTO `order_cai` VALUES ('51', '1', '29', '4', '5', '可乐', '6.00', '0');

-- ----------------------------
-- Table structure for `photo`
-- ----------------------------
DROP TABLE IF EXISTS `photo`;
CREATE TABLE `photo` (
  `pid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `shopid` mediumint(9) NOT NULL DEFAULT '0',
  `title` varchar(100) COLLATE gbk_bin NOT NULL,
  `info` text COLLATE gbk_bin NOT NULL,
  `keyword` varchar(200) COLLATE gbk_bin NOT NULL,
  `des` varchar(255) COLLATE gbk_bin NOT NULL,
  `ctime` int(11) NOT NULL DEFAULT '0',
  `logo` varchar(200) COLLATE gbk_bin NOT NULL,
  `isnew` tinyint(4) NOT NULL DEFAULT '0',
  `isding` tinyint(4) NOT NULL DEFAULT '0',
  `ishot` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`pid`),
  KEY `siteid` (`siteid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of photo
-- ----------------------------

-- ----------------------------
-- Table structure for `photo_pic`
-- ----------------------------
DROP TABLE IF EXISTS `photo_pic`;
CREATE TABLE `photo_pic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `shopid` mediumint(9) NOT NULL DEFAULT '0',
  `pid` smallint(6) NOT NULL DEFAULT '0',
  `picurl` varchar(400) COLLATE gbk_bin NOT NULL,
  `thumb_picurl` varchar(100) COLLATE gbk_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `siteid` (`siteid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of photo_pic
-- ----------------------------

-- ----------------------------
-- Table structure for `pm`
-- ----------------------------
DROP TABLE IF EXISTS `pm`;
CREATE TABLE `pm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `siteid` smallint(6) NOT NULL DEFAULT '0',
  `userid` mediumint(9) NOT NULL DEFAULT '0',
  `touserid` mediumint(9) NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `dateline` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `useridstatus` tinyint(1) NOT NULL DEFAULT '0',
  `touseridstatus` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `uid` (`userid`,`touserid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of pm
-- ----------------------------

-- ----------------------------
-- Table structure for `pm_index`
-- ----------------------------
DROP TABLE IF EXISTS `pm_index`;
CREATE TABLE `pm_index` (
  `id` int(11) NOT NULL,
  `siteid` smallint(6) NOT NULL DEFAULT '0',
  `userid` int(11) NOT NULL,
  `touserid` int(11) NOT NULL,
  KEY `id` (`id`,`userid`,`touserid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of pm_index
-- ----------------------------

-- ----------------------------
-- Table structure for `province`
-- ----------------------------
DROP TABLE IF EXISTS `province`;
CREATE TABLE `province` (
  `provinceid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `province` varchar(50) NOT NULL,
  `orderindex` tinyint(4) unsigned NOT NULL,
  `lat` decimal(9,6) NOT NULL,
  `lng` decimal(9,6) NOT NULL,
  PRIMARY KEY (`provinceid`),
  KEY `siteid` (`siteid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=gb2312;

-- ----------------------------
-- Records of province
-- ----------------------------
INSERT INTO `province` VALUES ('1', '1', '青羊区', '0', '0.000000', '0.000000');

-- ----------------------------
-- Table structure for `qiandao`
-- ----------------------------
DROP TABLE IF EXISTS `qiandao`;
CREATE TABLE `qiandao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `dateline` int(11) NOT NULL,
  `xinqing` varchar(20) NOT NULL,
  `content` varchar(255) NOT NULL,
  `siteid` smallint(6) NOT NULL,
  `day` varchar(20) NOT NULL,
  `times` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userid_day` (`userid`,`day`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of qiandao
-- ----------------------------

-- ----------------------------
-- Table structure for `room`
-- ----------------------------
DROP TABLE IF EXISTS `room`;
CREATE TABLE `room` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `shopid` int(6) NOT NULL DEFAULT '0',
  `room_name` varchar(50) COLLATE gbk_bin NOT NULL COMMENT '包间名称',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '包间状态',
  `room_men` smallint(2) NOT NULL DEFAULT '0' COMMENT '包间最大人数',
  `room_pic` varchar(100) COLLATE gbk_bin NOT NULL COMMENT '包间图片',
  `room_desc` varchar(255) COLLATE gbk_bin NOT NULL COMMENT '包间简介',
  `room_content` text COLLATE gbk_bin NOT NULL COMMENT '包间详情',
  `dateline` int(11) NOT NULL COMMENT '发布时间',
  `userid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `siteid` (`siteid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of room
-- ----------------------------

-- ----------------------------
-- Table structure for `roomorder`
-- ----------------------------
DROP TABLE IF EXISTS `roomorder`;
CREATE TABLE `roomorder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `shopid` int(9) NOT NULL DEFAULT '0',
  `roomid` mediumint(8) unsigned NOT NULL COMMENT '房间id',
  `room_name` varchar(50) COLLATE gbk_bin NOT NULL COMMENT '房间名称',
  `room_men` tinyint(4) NOT NULL COMMENT '房间人数',
  `nickname` varchar(50) COLLATE gbk_bin NOT NULL COMMENT '客户名称',
  `telephone` varchar(30) COLLATE gbk_bin NOT NULL COMMENT '客户联系电话',
  `info` text COLLATE gbk_bin NOT NULL COMMENT '客户提交的信息',
  `dateline` int(11) NOT NULL COMMENT '客户下单时间',
  `status` tinyint(4) NOT NULL COMMENT '状态 0未审核 1审核通过 2已结束 99 已删除',
  `userid` mediumint(9) NOT NULL COMMENT '用户id',
  `reply` text COLLATE gbk_bin NOT NULL COMMENT '回复内容',
  `order_time` int(11) NOT NULL COMMENT '预定时间',
  PRIMARY KEY (`id`),
  KEY `siteid` (`siteid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of roomorder
-- ----------------------------

-- ----------------------------
-- Table structure for `sendarea`
-- ----------------------------
DROP TABLE IF EXISTS `sendarea`;
CREATE TABLE `sendarea` (
  `catid` mediumint(9) NOT NULL AUTO_INCREMENT,
  `pid` mediumint(9) NOT NULL,
  `cname` varchar(255) COLLATE gbk_bin NOT NULL,
  `orderid` smallint(6) NOT NULL,
  `shopid` smallint(6) NOT NULL,
  `info` text COLLATE gbk_bin NOT NULL,
  PRIMARY KEY (`catid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of sendarea
-- ----------------------------

-- ----------------------------
-- Table structure for `seo`
-- ----------------------------
DROP TABLE IF EXISTS `seo`;
CREATE TABLE `seo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `m` char(10) NOT NULL,
  `a` char(10) NOT NULL,
  `cname` varchar(20) NOT NULL,
  `title` varchar(225) NOT NULL,
  `description` varchar(225) NOT NULL,
  `keywords` varchar(225) NOT NULL,
  `siteid` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of seo
-- ----------------------------

-- ----------------------------
-- Table structure for `session`
-- ----------------------------
DROP TABLE IF EXISTS `session`;
CREATE TABLE `session` (
  `id` char(100) NOT NULL,
  `data` varchar(5000) DEFAULT NULL,
  `dateline` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of session
-- ----------------------------

-- ----------------------------
-- Table structure for `shop`
-- ----------------------------
DROP TABLE IF EXISTS `shop`;
CREATE TABLE `shop` (
  `shopid` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `gid` tinyint(4) NOT NULL,
  `catid` int(10) unsigned NOT NULL,
  `amid` smallint(5) unsigned NOT NULL COMMENT '人均消费',
  `smid` smallint(5) unsigned NOT NULL COMMENT '起送金额',
  `status` tinyint(1) unsigned NOT NULL,
  `balance` decimal(8,1) NOT NULL,
  `tixian` varchar(255) CHARACTER SET gbk NOT NULL,
  `userid` int(10) unsigned NOT NULL,
  `shopname` varchar(255) NOT NULL,
  `grade` decimal(6,2) unsigned NOT NULL,
  `logo` varchar(255) NOT NULL,
  `provinceid` tinyint(4) unsigned NOT NULL,
  `cityid` smallint(6) unsigned NOT NULL,
  `townid` mediumint(9) unsigned NOT NULL,
  `qq` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `info` varchar(255) NOT NULL,
  `visible` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `shopno` varchar(255) NOT NULL,
  `starttime` int(11) unsigned NOT NULL,
  `endtime` int(10) unsigned NOT NULL,
  `lasttime` int(11) unsigned NOT NULL,
  `lat` decimal(9,6) NOT NULL,
  `lng` decimal(9,6) NOT NULL,
  `sendarea` varchar(255) NOT NULL,
  `isrecommend` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `address` varchar(255) NOT NULL,
  `orders` mediumint(9) unsigned NOT NULL DEFAULT '0',
  `favs` mediumint(9) unsigned NOT NULL DEFAULT '0',
  `ishot` tinyint(1) unsigned NOT NULL,
  `isnew` tinyint(1) unsigned NOT NULL,
  `content` text NOT NULL,
  `jf_all` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `jf_fuwu` decimal(2,1) unsigned NOT NULL,
  `jf_kouwei` decimal(2,1) unsigned NOT NULL,
  `jf_jiage` decimal(2,1) unsigned NOT NULL,
  `jf_shijian` decimal(2,1) unsigned NOT NULL,
  `sendmeter` smallint(6) NOT NULL DEFAULT '1000',
  `clicks` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`shopid`),
  KEY `shopname_shopid` (`shopname`,`shopid`),
  KEY `lat_lng_siteid_shopid` (`lat`,`lng`,`siteid`,`shopid`),
  KEY `siteid_shopid` (`siteid`,`shopid`),
  KEY `siteid_isnew_shopid` (`siteid`,`isnew`,`shopid`),
  KEY `siteid_ishot_shopid` (`siteid`,`ishot`,`shopid`),
  KEY `siteid_provinceid_shopid` (`siteid`,`provinceid`,`shopid`),
  KEY `grade` (`grade`),
  KEY `siteid_status` (`siteid`,`status`),
  KEY `amid` (`amid`),
  KEY `smid` (`smid`),
  KEY `siteid_orders` (`siteid`,`orders`),
  KEY `siteid_visible` (`siteid`,`visible`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=gb2312;

-- ----------------------------
-- Records of shop
-- ----------------------------
INSERT INTO `shop` VALUES ('1', '1', '0', '2', '1', '2', '0', '0.0', '', '0', '麦当劳', '0.00', '', '1', '1', '1', '', '', '新店开张，优惠多多', '0', '', '1359338183', '0', '0', '0.000000', '0.000000', '', '0', '顺城大街300号', '1', '0', '0', '0', '', '0', '0.0', '0.0', '0.0', '0.0', '1000', '110');

-- ----------------------------
-- Table structure for `shopadmin`
-- ----------------------------
DROP TABLE IF EXISTS `shopadmin`;
CREATE TABLE `shopadmin` (
  `adminid` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `shopid` mediumint(9) unsigned NOT NULL DEFAULT '0',
  `adminname` varchar(50) CHARACTER SET gbk COLLATE gbk_bin NOT NULL,
  `password` varchar(50) CHARACTER SET gbk COLLATE gbk_bin NOT NULL,
  `rank` tinyint(4) NOT NULL DEFAULT '0',
  `email` varchar(255) CHARACTER SET gbk COLLATE gbk_bin NOT NULL,
  PRIMARY KEY (`adminid`),
  KEY `adminname` (`adminname`),
  KEY `siteid` (`siteid`),
  KEY `shopid_adminid` (`shopid`,`adminid`)
) ENGINE=MyISAM DEFAULT CHARSET=gb2312;

-- ----------------------------
-- Records of shopadmin
-- ----------------------------

-- ----------------------------
-- Table structure for `shopadmin_log`
-- ----------------------------
DROP TABLE IF EXISTS `shopadmin_log`;
CREATE TABLE `shopadmin_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(50) COLLATE gbk_bin NOT NULL,
  `ztime` int(11) NOT NULL DEFAULT '0',
  `logdesc` varchar(400) COLLATE gbk_bin NOT NULL,
  `adminname` varchar(50) COLLATE gbk_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of shopadmin_log
-- ----------------------------

-- ----------------------------
-- Table structure for `shoparea`
-- ----------------------------
DROP TABLE IF EXISTS `shoparea`;
CREATE TABLE `shoparea` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `shopid` mediumint(9) NOT NULL DEFAULT '0',
  `provinceid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `cityid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `townid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `shopid` (`shopid`,`provinceid`,`cityid`,`townid`),
  KEY `siteid` (`siteid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of shoparea
-- ----------------------------
INSERT INTO `shoparea` VALUES ('1', '1', '1', '1', '1', '1');

-- ----------------------------
-- Table structure for `shopcar`
-- ----------------------------
DROP TABLE IF EXISTS `shopcar`;
CREATE TABLE `shopcar` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `shopid` mediumint(9) unsigned NOT NULL DEFAULT '0',
  `userid` mediumint(9) unsigned NOT NULL DEFAULT '0',
  `ssid` varchar(60) COLLATE gbk_bin NOT NULL,
  `caiid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `cainum` smallint(6) unsigned NOT NULL DEFAULT '0',
  `title` varchar(50) COLLATE gbk_bin NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `grade` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `siteid` (`siteid`),
  KEY `userid` (`userid`,`ssid`),
  KEY `shopid` (`shopid`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of shopcar
-- ----------------------------
INSERT INTO `shopcar` VALUES ('29', '1', '1', '0', '1359361559krrkealc7hpf1ddasc6aovnnf3', '1', '18', '巨无霸', '20.00', '0');
INSERT INTO `shopcar` VALUES ('20', '1', '1', '0', '13593570140tptah9co3bn0i7po9u1v8lb77', '4', '5', '可乐', '6.00', '0');
INSERT INTO `shopcar` VALUES ('21', '1', '1', '0', '13593570140tptah9co3bn0i7po9u1v8lb77', '3', '4', '中薯条', '6.00', '0');
INSERT INTO `shopcar` VALUES ('22', '1', '1', '0', '13593570140tptah9co3bn0i7po9u1v8lb77', '2', '6', '汉堡', '20.00', '0');
INSERT INTO `shopcar` VALUES ('31', '1', '1', '0', '1359423046b36cgs6ruqivh8hd4decdsnsf4', '1', '4', '巨无霸', '20.00', '0');
INSERT INTO `shopcar` VALUES ('32', '1', '1', '0', '1359423324i0opuk1ikgm2s7nq7ki7gqh745', '1', '3', '巨无霸', '20.00', '0');
INSERT INTO `shopcar` VALUES ('33', '1', '1', '0', '1359423324i0opuk1ikgm2s7nq7ki7gqh745', '2', '3', '汉堡', '20.00', '0');
INSERT INTO `shopcar` VALUES ('34', '1', '1', '0', '1359423324i0opuk1ikgm2s7nq7ki7gqh745', '3', '3', '中薯条', '6.00', '0');
INSERT INTO `shopcar` VALUES ('35', '1', '1', '0', '1359423324i0opuk1ikgm2s7nq7ki7gqh745', '4', '5', '可乐', '6.00', '0');

-- ----------------------------
-- Table structure for `shopconfig`
-- ----------------------------
DROP TABLE IF EXISTS `shopconfig`;
CREATE TABLE `shopconfig` (
  `shopid` mediumint(9) unsigned NOT NULL DEFAULT '0',
  `opentime` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `starthour` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `endhour` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `startminute` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `endminute` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `showweek` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `minprice` decimal(8,2) NOT NULL,
  `sendarea` varchar(255) COLLATE gbk_bin NOT NULL,
  `email` varchar(255) COLLATE gbk_bin NOT NULL,
  `isemail` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `isphone` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `phone` varchar(20) COLLATE gbk_bin NOT NULL,
  `sendprice` decimal(4,1) unsigned NOT NULL DEFAULT '0.0',
  `ordertype` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `telephone` varchar(15) COLLATE gbk_bin NOT NULL,
  KEY `shopid` (`shopid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of shopconfig
-- ----------------------------
INSERT INTO `shopconfig` VALUES ('1', '0', '0', '0', '0', '0', '0', '0.00', '', '', '0', '0', '', '0.0', '0', '');

-- ----------------------------
-- Table structure for `shop_avgmoney`
-- ----------------------------
DROP TABLE IF EXISTS `shop_avgmoney`;
CREATE TABLE `shop_avgmoney` (
  `amid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL,
  `cname` varchar(25) NOT NULL,
  `orderindex` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`amid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of shop_avgmoney
-- ----------------------------
INSERT INTO `shop_avgmoney` VALUES ('1', '1', '20', '0');
INSERT INTO `shop_avgmoney` VALUES ('2', '1', '10', '0');

-- ----------------------------
-- Table structure for `shop_cat`
-- ----------------------------
DROP TABLE IF EXISTS `shop_cat`;
CREATE TABLE `shop_cat` (
  `catid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL,
  `cname` varchar(25) NOT NULL,
  `orderindex` tinyint(3) unsigned NOT NULL,
  `gid` tinyint(1) NOT NULL,
  PRIMARY KEY (`catid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of shop_cat
-- ----------------------------
INSERT INTO `shop_cat` VALUES ('1', '1', '中餐', '0', '0');
INSERT INTO `shop_cat` VALUES ('2', '1', '快餐', '0', '0');

-- ----------------------------
-- Table structure for `shop_check`
-- ----------------------------
DROP TABLE IF EXISTS `shop_check`;
CREATE TABLE `shop_check` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL,
  `siteid` smallint(5) unsigned NOT NULL,
  `shopid` int(10) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `shopname` varchar(20) CHARACTER SET gbk NOT NULL,
  `dateline` int(10) unsigned NOT NULL,
  `content` varchar(255) CHARACTER SET gbk NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of shop_check
-- ----------------------------

-- ----------------------------
-- Table structure for `shop_comment`
-- ----------------------------
DROP TABLE IF EXISTS `shop_comment`;
CREATE TABLE `shop_comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL,
  `shopid` mediumint(8) unsigned NOT NULL,
  `ctype` tinyint(1) NOT NULL COMMENT '评价类型 店铺 美食',
  `userid` mediumint(8) unsigned NOT NULL,
  `nickname` varchar(25) COLLATE gb2312_bin NOT NULL,
  `orderid` int(10) unsigned NOT NULL,
  `orderno` varchar(20) COLLATE gb2312_bin NOT NULL,
  `caiid` mediumint(8) unsigned NOT NULL,
  `jf_fuwu` tinyint(2) unsigned NOT NULL COMMENT '服务',
  `jf_kouwei` tinyint(2) unsigned NOT NULL COMMENT '口味',
  `jf_shijian` tinyint(2) unsigned NOT NULL COMMENT '时间',
  `jf_jiage` tinyint(1) unsigned NOT NULL COMMENT '价格',
  `jf_all` tinyint(1) NOT NULL,
  `status` tinyint(2) unsigned NOT NULL,
  `dateline` int(10) unsigned NOT NULL,
  `content` varchar(255) COLLATE gb2312_bin NOT NULL,
  `reply` varchar(255) COLLATE gb2312_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `siteid_id` (`siteid`,`id`),
  KEY `shopid_status_id` (`shopid`,`status`,`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=gb2312 COLLATE=gb2312_bin;

-- ----------------------------
-- Records of shop_comment
-- ----------------------------
INSERT INTO `shop_comment` VALUES ('1', '1', '1', '0', '1', '', '18', '20130118', '0', '0', '4', '3', '4', '0', '0', '1359362381', 'sdfsadfsdfsdfsdf', 'sdfsdfsdfsdfsdfsd');

-- ----------------------------
-- Table structure for `shop_data`
-- ----------------------------
DROP TABLE IF EXISTS `shop_data`;
CREATE TABLE `shop_data` (
  `shopid` int(11) NOT NULL,
  `content` mediumtext,
  PRIMARY KEY (`shopid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of shop_data
-- ----------------------------
INSERT INTO `shop_data` VALUES ('1', '最新红烧鳕鱼饭，美味可口');

-- ----------------------------
-- Table structure for `shop_group`
-- ----------------------------
DROP TABLE IF EXISTS `shop_group`;
CREATE TABLE `shop_group` (
  `gid` tinyint(4) NOT NULL AUTO_INCREMENT,
  `title` varchar(25) NOT NULL,
  `orderindex` tinyint(4) NOT NULL,
  PRIMARY KEY (`gid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of shop_group
-- ----------------------------

-- ----------------------------
-- Table structure for `shop_paylog`
-- ----------------------------
DROP TABLE IF EXISTS `shop_paylog`;
CREATE TABLE `shop_paylog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shopid` int(10) unsigned NOT NULL,
  `money` decimal(8,1) NOT NULL,
  `dateline` int(10) unsigned NOT NULL,
  `content` varchar(255) CHARACTER SET gbk NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of shop_paylog
-- ----------------------------

-- ----------------------------
-- Table structure for `shop_sendmoney`
-- ----------------------------
DROP TABLE IF EXISTS `shop_sendmoney`;
CREATE TABLE `shop_sendmoney` (
  `smid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL,
  `cname` varchar(25) NOT NULL,
  `orderindex` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`smid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of shop_sendmoney
-- ----------------------------
INSERT INTO `shop_sendmoney` VALUES ('1', '1', '10', '0');
INSERT INTO `shop_sendmoney` VALUES ('2', '1', '30', '0');

-- ----------------------------
-- Table structure for `shop_tixian`
-- ----------------------------
DROP TABLE IF EXISTS `shop_tixian`;
CREATE TABLE `shop_tixian` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shopid` int(10) unsigned NOT NULL,
  `shopname` varchar(30) CHARACTER SET gbk NOT NULL,
  `money` int(11) NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `dateline` int(10) unsigned NOT NULL,
  `info` varchar(255) NOT NULL,
  `reply` varchar(255) CHARACTER SET gbk NOT NULL,
  `redateline` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `money` (`money`),
  KEY `shopid_status` (`shopid`,`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of shop_tixian
-- ----------------------------

-- ----------------------------
-- Table structure for `sites`
-- ----------------------------
DROP TABLE IF EXISTS `sites`;
CREATE TABLE `sites` (
  `siteid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `sitename` varchar(20) CHARACTER SET gbk NOT NULL,
  `lat` decimal(9,6) NOT NULL,
  `lng` decimal(9,6) NOT NULL,
  `orderindex` smallint(5) unsigned NOT NULL,
  `domain` varchar(50) CHARACTER SET gbk COLLATE gbk_bin NOT NULL,
  PRIMARY KEY (`siteid`),
  KEY `orderindex` (`orderindex`),
  KEY `lat_lng` (`lat`,`lng`),
  KEY `domain` (`domain`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sites
-- ----------------------------
INSERT INTO `sites` VALUES ('1', '默认站点', '0.000000', '0.000000', '0', '');

-- ----------------------------
-- Table structure for `stole`
-- ----------------------------
DROP TABLE IF EXISTS `stole`;
CREATE TABLE `stole` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(225) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `title` varchar(225) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of stole
-- ----------------------------

-- ----------------------------
-- Table structure for `town`
-- ----------------------------
DROP TABLE IF EXISTS `town`;
CREATE TABLE `town` (
  `townid` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `provinceid` mediumint(9) unsigned NOT NULL DEFAULT '0',
  `cityid` mediumint(9) unsigned NOT NULL DEFAULT '0',
  `town` varchar(50) NOT NULL,
  `orderindex` smallint(6) unsigned NOT NULL DEFAULT '0',
  `lat` decimal(9,6) NOT NULL,
  `lng` decimal(9,6) NOT NULL,
  PRIMARY KEY (`townid`),
  KEY `siteid` (`siteid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=gb2312;

-- ----------------------------
-- Records of town
-- ----------------------------
INSERT INTO `town` VALUES ('1', '1', '0', '1', '新世纪广场', '0', '0.000000', '0.000000');

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `userid` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE gbk_bin NOT NULL,
  `password` varchar(100) COLLATE gbk_bin NOT NULL,
  `email` varchar(200) COLLATE gbk_bin NOT NULL,
  `logo` varchar(255) COLLATE gbk_bin NOT NULL,
  `address` varchar(200) COLLATE gbk_bin NOT NULL,
  `phone` varchar(30) COLLATE gbk_bin NOT NULL,
  `qq` int(11) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `nickname` varchar(50) COLLATE gbk_bin NOT NULL,
  `grade` decimal(9,2) NOT NULL DEFAULT '0.00' COMMENT '消费积分',
  `usegrade` decimal(9,2) NOT NULL,
  `fuserid` mediumint(9) unsigned NOT NULL DEFAULT '0' COMMENT '推荐人',
  `dateline` int(11) unsigned NOT NULL DEFAULT '0',
  `shopid` int(11) unsigned NOT NULL,
  `followers` mediumint(8) unsigned NOT NULL,
  `followeds` mediumint(8) unsigned NOT NULL,
  `balance` decimal(8,1) unsigned NOT NULL,
  `info` varchar(255) CHARACTER SET gbk NOT NULL,
  `blogs` smallint(5) unsigned NOT NULL,
  `lat` decimal(9,6) NOT NULL,
  `lng` decimal(9,6) NOT NULL,
  PRIMARY KEY (`userid`),
  KEY `username` (`username`),
  KEY `dateline` (`dateline`),
  KEY `status_userid` (`status`,`userid`),
  KEY `fuserid` (`fuserid`),
  KEY `nickname_userid` (`nickname`,`status`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'wanghexiangqq', 'b00d539dc73cc0e108be938cc6c46563', '19467285@qq.com', '', '', '', '0', '0', '', '80.00', '80.00', '0', '0', '0', '0', '0', '0.0', '', '0', '0.000000', '0.000000');

-- ----------------------------
-- Table structure for `userapi`
-- ----------------------------
DROP TABLE IF EXISTS `userapi`;
CREATE TABLE `userapi` (
  `xid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `xuserid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'x用户id',
  `xusername` varchar(30) COLLATE gbk_bin NOT NULL COMMENT 'x用户名',
  `xfrom` varchar(20) COLLATE gbk_bin NOT NULL COMMENT '来自哪个插件',
  `uid` mediumint(9) unsigned NOT NULL DEFAULT '0' COMMENT '站点id',
  `bind` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已经绑定',
  `openid` varchar(40) COLLATE gbk_bin NOT NULL,
  `accesstoken` varchar(40) COLLATE gbk_bin DEFAULT NULL,
  PRIMARY KEY (`xid`),
  KEY `uid` (`uid`),
  KEY `xuserid` (`xuserid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of userapi
-- ----------------------------

-- ----------------------------
-- Table structure for `user_address`
-- ----------------------------
DROP TABLE IF EXISTS `user_address`;
CREATE TABLE `user_address` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userid` mediumint(9) unsigned NOT NULL,
  `address` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userid_id` (`userid`,`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_address
-- ----------------------------
INSERT INTO `user_address` VALUES ('1', '1', '顺城街');
INSERT INTO `user_address` VALUES ('2', '1', '春熙路');
INSERT INTO `user_address` VALUES ('3', '1', '是打发士大夫是打发士大夫是的发生大');
INSERT INTO `user_address` VALUES ('4', '1', '打发士大夫');

-- ----------------------------
-- Table structure for `user_gps`
-- ----------------------------
DROP TABLE IF EXISTS `user_gps`;
CREATE TABLE `user_gps` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` mediumint(9) NOT NULL,
  `lat` decimal(9,6) NOT NULL,
  `lng` decimal(9,6) NOT NULL,
  `dateline` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_gps
-- ----------------------------

-- ----------------------------
-- Table structure for `user_paylog`
-- ----------------------------
DROP TABLE IF EXISTS `user_paylog`;
CREATE TABLE `user_paylog` (
  `logid` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL DEFAULT '0',
  `content` varchar(255) COLLATE gbk_bin NOT NULL,
  `money` decimal(8,1) NOT NULL DEFAULT '0.0',
  `dateline` int(11) NOT NULL DEFAULT '0',
  `ftype` varchar(20) COLLATE gbk_bin NOT NULL,
  `orderno` varchar(50) COLLATE gbk_bin NOT NULL,
  PRIMARY KEY (`logid`),
  KEY `orderno` (`orderno`),
  KEY `userid_logid` (`userid`,`logid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of user_paylog
-- ----------------------------

-- ----------------------------
-- Table structure for `user_rank`
-- ----------------------------
DROP TABLE IF EXISTS `user_rank`;
CREATE TABLE `user_rank` (
  `id` tinyint(4) unsigned NOT NULL AUTO_INCREMENT,
  `shopid` mediumint(9) unsigned NOT NULL DEFAULT '0',
  `rank_name` varchar(50) COLLATE gbk_bin NOT NULL,
  `min_grade` int(11) unsigned NOT NULL DEFAULT '0',
  `max_grade` int(11) unsigned NOT NULL DEFAULT '0',
  `discount` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of user_rank
-- ----------------------------

-- ----------------------------
-- Table structure for `vote`
-- ----------------------------
DROP TABLE IF EXISTS `vote`;
CREATE TABLE `vote` (
  `vid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `shopid` mediumint(9) unsigned NOT NULL DEFAULT '0',
  `title` varchar(50) COLLATE gbk_bin NOT NULL,
  `vtype` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `dateline` int(11) unsigned NOT NULL DEFAULT '0',
  `detail` text COLLATE gbk_bin NOT NULL,
  `vtoption` text COLLATE gbk_bin NOT NULL,
  `logo` varchar(200) COLLATE gbk_bin NOT NULL,
  `isding` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `showtype` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '展示形式',
  `mustlogin` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '是否登录',
  PRIMARY KEY (`vid`),
  KEY `siteid` (`siteid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of vote
-- ----------------------------

-- ----------------------------
-- Table structure for `vote_sele`
-- ----------------------------
DROP TABLE IF EXISTS `vote_sele`;
CREATE TABLE `vote_sele` (
  `sid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `shopid` mediumint(9) unsigned NOT NULL DEFAULT '0',
  `tid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `orderid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `vid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `vcount` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`sid`),
  KEY `tid` (`tid`,`vid`),
  KEY `vid` (`vid`),
  KEY `siteid` (`siteid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of vote_sele
-- ----------------------------

-- ----------------------------
-- Table structure for `vote_tt`
-- ----------------------------
DROP TABLE IF EXISTS `vote_tt`;
CREATE TABLE `vote_tt` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `shopid` mediumint(9) NOT NULL DEFAULT '0',
  `title` varchar(200) COLLATE gbk_bin NOT NULL,
  `img` varchar(200) COLLATE gbk_bin NOT NULL,
  `url` varchar(200) COLLATE gbk_bin NOT NULL,
  `catid` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`tid`),
  KEY `siteid` (`siteid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of vote_tt
-- ----------------------------

-- ----------------------------
-- Table structure for `vote_ttcat`
-- ----------------------------
DROP TABLE IF EXISTS `vote_ttcat`;
CREATE TABLE `vote_ttcat` (
  `catid` smallint(6) NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `shopid` mediumint(9) NOT NULL DEFAULT '0',
  `cname` varchar(100) COLLATE gbk_bin NOT NULL,
  PRIMARY KEY (`catid`),
  KEY `siteid` (`siteid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of vote_ttcat
-- ----------------------------

-- ----------------------------
-- Table structure for `vote_user`
-- ----------------------------
DROP TABLE IF EXISTS `vote_user`;
CREATE TABLE `vote_user` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `shopid` mediumint(9) unsigned NOT NULL DEFAULT '0',
  `vid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `userid` mediumint(9) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(50) COLLATE gbk_bin NOT NULL,
  `dateline` int(11) NOT NULL DEFAULT '0',
  `sid` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `vid` (`vid`,`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of vote_user
-- ----------------------------

-- ----------------------------
-- Table structure for `web`
-- ----------------------------
DROP TABLE IF EXISTS `web`;
CREATE TABLE `web` (
  `id` tinyint(4) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(6) NOT NULL DEFAULT '0',
  `webname` varchar(20) COLLATE gbk_bin NOT NULL,
  `webtitle` varchar(200) COLLATE gbk_bin NOT NULL,
  `webkey` varchar(200) COLLATE gbk_bin NOT NULL,
  `webdesc` varchar(500) COLLATE gbk_bin NOT NULL,
  `weboff` tinyint(4) NOT NULL DEFAULT '0',
  `webmsn` varchar(200) COLLATE gbk_bin NOT NULL,
  `webqq` varchar(200) COLLATE gbk_bin NOT NULL,
  `beian` varchar(100) COLLATE gbk_bin NOT NULL,
  `weburl` varchar(100) COLLATE gbk_bin NOT NULL,
  `address` varchar(100) COLLATE gbk_bin NOT NULL,
  `phone` varchar(20) COLLATE gbk_bin NOT NULL,
  `offwhy` text COLLATE gbk_bin NOT NULL,
  `webgg` text COLLATE gbk_bin NOT NULL,
  `weblogo` varchar(200) COLLATE gbk_bin NOT NULL,
  `wapurl` varchar(50) COLLATE gbk_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of web
-- ----------------------------

-- ----------------------------
-- Table structure for `webstats`
-- ----------------------------
DROP TABLE IF EXISTS `webstats`;
CREATE TABLE `webstats` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(255) COLLATE gbk_bin NOT NULL,
  `title` varchar(255) COLLATE gbk_bin NOT NULL,
  `stype` tinyint(1) NOT NULL,
  `dateline` int(11) NOT NULL,
  `logo` varchar(255) COLLATE gbk_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of webstats
-- ----------------------------

-- ----------------------------
-- Table structure for `weibo_config`
-- ----------------------------
DROP TABLE IF EXISTS `weibo_config`;
CREATE TABLE `weibo_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(20) NOT NULL,
  `siteid` smallint(6) NOT NULL,
  `token_users` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of weibo_config
-- ----------------------------
INSERT INTO `weibo_config` VALUES ('1', '', '1', null);

-- ----------------------------
-- Table structure for `weibo_souser`
-- ----------------------------
DROP TABLE IF EXISTS `weibo_souser`;
CREATE TABLE `weibo_souser` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL COMMENT '用户id',
  `screen_name` varchar(20) DEFAULT NULL COMMENT '昵称',
  `location` varchar(20) DEFAULT NULL COMMENT '位置',
  `description` varchar(225) DEFAULT NULL COMMENT '描述',
  `avatar_large` varchar(225) DEFAULT NULL COMMENT '头像',
  `friends_count` smallint(6) DEFAULT NULL COMMENT '关注数',
  `domain` varchar(20) DEFAULT NULL COMMENT '域名',
  `followers_count` int(11) DEFAULT NULL COMMENT '粉丝数',
  `statuses_count` int(11) DEFAULT NULL COMMENT '微博数',
  `status` tinyint(4) DEFAULT '0' COMMENT '状态  0未索引 1已索引 2已获取标签',
  `step` tinyint(4) DEFAULT NULL COMMENT '级别 第几次索引的',
  `visible` tinyint(1) NOT NULL COMMENT '1为显示 0为隐藏',
  `tags` varchar(225) NOT NULL COMMENT '用户标签',
  `gender` char(2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `follwers_count` (`visible`,`followers_count`) USING BTREE,
  KEY `statuses_count` (`visible`,`statuses_count`) USING BTREE,
  KEY `v_id` (`visible`,`id`),
  KEY `uid` (`uid`),
  KEY `status` (`status`,`followers_count`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of weibo_souser
-- ----------------------------

-- ----------------------------
-- Table structure for `zuche_area`
-- ----------------------------
DROP TABLE IF EXISTS `zuche_area`;
CREATE TABLE `zuche_area` (
  `area_id` int(11) NOT NULL AUTO_INCREMENT,
  `address` varchar(50) NOT NULL,
  `lat` decimal(9,6) NOT NULL,
  `lng` decimal(9,6) NOT NULL,
  `orderindex` tinyint(4) NOT NULL,
  `siteid` smallint(6) NOT NULL,
  PRIMARY KEY (`area_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zuche_area
-- ----------------------------

-- ----------------------------
-- Table structure for `zuche_order`
-- ----------------------------
DROP TABLE IF EXISTS `zuche_order`;
CREATE TABLE `zuche_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `siji_id` int(11) NOT NULL,
  `from_area_id` int(11) NOT NULL,
  `to_area_id` int(11) NOT NULL,
  `distance` int(11) NOT NULL,
  `price` decimal(6,2) NOT NULL,
  `userid` int(11) NOT NULL,
  `nickname` varchar(20) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `dateline` int(11) NOT NULL,
  `info` varchar(255) NOT NULL,
  `reply` varchar(255) NOT NULL,
  `siteid` smallint(6) NOT NULL,
  `isdel` tinyint(1) NOT NULL DEFAULT '0',
  `from_area` varchar(30) NOT NULL,
  `to_area` varchar(30) NOT NULL,
  `siji` varchar(20) NOT NULL,
  `dianhua` varchar(20) NOT NULL,
  `ispay` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zuche_order
-- ----------------------------

-- ----------------------------
-- Table structure for `zuche_siji`
-- ----------------------------
DROP TABLE IF EXISTS `zuche_siji`;
CREATE TABLE `zuche_siji` (
  `siji_id` int(11) NOT NULL AUTO_INCREMENT,
  `mingzi` varchar(25) NOT NULL,
  `zuowei` tinyint(4) NOT NULL,
  `chexing` varchar(50) NOT NULL,
  `dianhua` varchar(20) NOT NULL,
  `chepai` varchar(20) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `lat` decimal(9,6) NOT NULL,
  `lng` decimal(9,6) NOT NULL,
  `dateline` int(11) NOT NULL,
  `price` decimal(6,2) NOT NULL COMMENT '每公里报价',
  `siteid` smallint(6) NOT NULL,
  `imgurl` varchar(225) NOT NULL,
  `isfree` tinyint(1) NOT NULL COMMENT '1空闲 0忙',
  PRIMARY KEY (`siji_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zuche_siji
-- ----------------------------
