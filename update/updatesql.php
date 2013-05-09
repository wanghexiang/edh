<?php
/*1.8.2更新*/
@mysql_query("ALTER TABLE ".TABLE_PRE."userapi ADD accesstoken VARCHAR(255) CHARACTER SET gbk COLLATE gbk_chinese_ci   ");
@mysql_query("CREATE TABLE `".TABLE_PRE."weibo_config` (
  `id` int(11) NOT NULL auto_increment,
  `nickname` varchar(20) NOT NULL,
  `siteid` smallint(6) NOT NULL,
  `token_users` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;"); 
@mysql_query("CREATE TABLE `".TABLE_PRE."weibo_souser` (
  `id` int(11) NOT NULL auto_increment,
  `uid` int(10) unsigned NOT NULL COMMENT '用户id',
  `screen_name` varchar(20) default NULL COMMENT '昵称',
  `location` varchar(20) default NULL COMMENT '位置',
  `description` varchar(225) default NULL COMMENT '描述',
  `avatar_large` varchar(225) default NULL COMMENT '头像',
  `friends_count` smallint(6) default NULL COMMENT '关注数',
  `domain` varchar(20) default NULL COMMENT '域名',
  `followers_count` int(11) default NULL COMMENT '粉丝数',
  `statuses_count` int(11) default NULL COMMENT '微博数',
  `status` tinyint(4) default '0' COMMENT '状态  0未索引 1已索引 2已获取标签',
  `step` tinyint(4) default NULL COMMENT '级别 第几次索引的',
  `visible` tinyint(1) NOT NULL COMMENT '1为显示 0为隐藏',
  `tags` varchar(225) NOT NULL COMMENT '用户标签',
  `gender` char(2) default NULL,
  PRIMARY KEY  (`id`),
  KEY `follwers_count` USING BTREE (`visible`,`followers_count`),
  KEY `statuses_count` USING BTREE (`visible`,`statuses_count`),
  KEY `v_id` (`visible`,`id`),
  KEY `uid` (`uid`),
  KEY `status` USING BTREE (`status`,`followers_count`)
) ENGINE=MyISAM AUTO_INCREMENT=5939784 DEFAULT CHARSET=utf8;");
@mysql_query("ALTER TABLE ".TABLE_PRE."art ADD `catid_2nd` int(11) NOT NULL");
@mysql_query("ALTER TABLE ".TABLE_PRE."art ADD `catid_3nd` int(11) NOT NULL");
@mysql_query("ALTER TABLE ".TABLE_PRE."caipu ADD `wei_id` smallint(6) NOT NULL default '0' COMMENT '味道' ");
@mysql_query("ALTER TABLE ".TABLE_PRE."caipu ADD `do_id` smallint(6) NOT NULL default '0' COMMENT '做法' ");
?>