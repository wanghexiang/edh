<?php
/*1.8.2����*/
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
  `uid` int(10) unsigned NOT NULL COMMENT '�û�id',
  `screen_name` varchar(20) default NULL COMMENT '�ǳ�',
  `location` varchar(20) default NULL COMMENT 'λ��',
  `description` varchar(225) default NULL COMMENT '����',
  `avatar_large` varchar(225) default NULL COMMENT 'ͷ��',
  `friends_count` smallint(6) default NULL COMMENT '��ע��',
  `domain` varchar(20) default NULL COMMENT '����',
  `followers_count` int(11) default NULL COMMENT '��˿��',
  `statuses_count` int(11) default NULL COMMENT '΢����',
  `status` tinyint(4) default '0' COMMENT '״̬  0δ���� 1������ 2�ѻ�ȡ��ǩ',
  `step` tinyint(4) default NULL COMMENT '���� �ڼ���������',
  `visible` tinyint(1) NOT NULL COMMENT '1Ϊ��ʾ 0Ϊ����',
  `tags` varchar(225) NOT NULL COMMENT '�û���ǩ',
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
@mysql_query("ALTER TABLE ".TABLE_PRE."caipu ADD `wei_id` smallint(6) NOT NULL default '0' COMMENT 'ζ��' ");
@mysql_query("ALTER TABLE ".TABLE_PRE."caipu ADD `do_id` smallint(6) NOT NULL default '0' COMMENT '����' ");
?>