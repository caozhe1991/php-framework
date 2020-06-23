/*
Navicat MySQL Data Transfer

Source Server         : 192.168.1.1
Source Server Version : 50173
Source Host           : 127.0.0.1:3306
Source Database       : wholeton_cc

Target Server Type    : MYSQL
Target Server Version : 50173
File Encoding         : 65001

Date: 2019-10-29 18:09:20
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tb_account
-- ----------------------------
DROP TABLE IF EXISTS `tb_account`;
CREATE TABLE `tb_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tb_article
-- ----------------------------
DROP TABLE IF EXISTS `tb_article`;
CREATE TABLE `tb_article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL,
  `style` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0=QQ看点默认风格，1=微信大图风格，2=微信小图风格',
  `images` varchar(512) NOT NULL,
  `author` varchar(32) NOT NULL COMMENT '作者',
  `body` text NOT NULL,
  `time` int(11) unsigned NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `read_count` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tb_audit_audio_video_001
-- ----------------------------
DROP TABLE IF EXISTS `tb_audit_audio_video_001`;
CREATE TABLE `tb_audit_audio_video_001` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `did` int(10) unsigned NOT NULL DEFAULT '0',
  `cid` int(10) unsigned NOT NULL DEFAULT '0',
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `user_name` varchar(63) NOT NULL,
  `src_ip` int(10) unsigned NOT NULL DEFAULT '0',
  `lan_mac` varchar(63) NOT NULL,
  `terminal_type` int(11) NOT NULL DEFAULT '0',
  `type` varchar(63) NOT NULL,
  `account` varchar(63) NOT NULL,
  `password` varchar(63) NOT NULL,
  `mark` int(11) NOT NULL DEFAULT '0',
  `url` varchar(511) NOT NULL,
  `host` varchar(255) NOT NULL,
  `down_bytes` bigint(20) unsigned NOT NULL DEFAULT '0',
  `up_bytes` bigint(20) unsigned NOT NULL DEFAULT '0',
  `alarm_level` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=317 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tb_audit_game_001
-- ----------------------------
DROP TABLE IF EXISTS `tb_audit_game_001`;
CREATE TABLE `tb_audit_game_001` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `did` int(10) unsigned NOT NULL,
  `cid` int(10) unsigned NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(63) NOT NULL,
  `src_ip` int(10) unsigned NOT NULL,
  `lan_mac` varchar(63) NOT NULL,
  `terminal_type` int(11) NOT NULL,
  `type` varchar(63) NOT NULL,
  `account` varchar(63) NOT NULL,
  `password` varchar(63) NOT NULL,
  `mark` bigint(20) NOT NULL,
  `host` varchar(255) NOT NULL,
  `down_bytes` bigint(20) unsigned NOT NULL,
  `up_bytes` bigint(20) unsigned NOT NULL,
  `alarm_level` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tb_audit_http_file_transfer_001
-- ----------------------------
DROP TABLE IF EXISTS `tb_audit_http_file_transfer_001`;
CREATE TABLE `tb_audit_http_file_transfer_001` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `did` int(10) unsigned NOT NULL,
  `cid` int(10) unsigned NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(63) NOT NULL,
  `src_ip` int(10) unsigned NOT NULL,
  `lan_mac` varchar(63) NOT NULL,
  `terminal_type` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `filepath` varchar(255) NOT NULL,
  `filesize` int(11) NOT NULL,
  `host` varchar(255) NOT NULL,
  `url` varchar(1023) NOT NULL,
  `direction` tinyint(4) NOT NULL,
  `mail_id` varchar(511) NOT NULL,
  `mark` bigint(20) NOT NULL,
  `down_bytes` bigint(20) unsigned NOT NULL DEFAULT '0',
  `up_bytes` bigint(20) unsigned NOT NULL DEFAULT '0',
  `alarm_level` tinyint(4) NOT NULL,
  `file_type` varchar(255) NOT NULL,
  `sec_transfer` tinyint(4) NOT NULL,
  `acl_obj` varchar(255) NOT NULL,
  `access` tinyint(4) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=258 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tb_audit_im_char_001
-- ----------------------------
DROP TABLE IF EXISTS `tb_audit_im_char_001`;
CREATE TABLE `tb_audit_im_char_001` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `did` int(10) unsigned NOT NULL DEFAULT '0',
  `cid` int(10) unsigned NOT NULL DEFAULT '0',
  `start_time` datetime NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `user_name` varchar(63) NOT NULL,
  `src_ip` int(10) unsigned NOT NULL DEFAULT '0',
  `lan_mac` varchar(63) NOT NULL,
  `protocol` varchar(63) NOT NULL,
  `sender` varchar(255) NOT NULL,
  `receiver` varchar(255) NOT NULL,
  `terminal_type` int(11) NOT NULL DEFAULT '0',
  `host` varchar(3) NOT NULL,
  `content` text NOT NULL,
  `alarm_level` tinyint(4) NOT NULL DEFAULT '0',
  `acl_obj` varchar(255) NOT NULL,
  `access` smallint(6) NOT NULL DEFAULT '0',
  `status` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=246 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tb_audit_im_login_001
-- ----------------------------
DROP TABLE IF EXISTS `tb_audit_im_login_001`;
CREATE TABLE `tb_audit_im_login_001` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `did` int(10) unsigned NOT NULL DEFAULT '0',
  `cid` int(10) unsigned NOT NULL DEFAULT '0',
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `user_name` varchar(63) NOT NULL,
  `src_ip` int(10) unsigned NOT NULL DEFAULT '0',
  `lan_mac` varchar(63) NOT NULL,
  `protocol` varchar(31) NOT NULL,
  `account` varchar(127) NOT NULL,
  `alarm_level` tinyint(4) NOT NULL DEFAULT '0',
  `terminal_type` int(11) NOT NULL DEFAULT '0',
  `host` varchar(63) NOT NULL,
  `uniq_id` varchar(63) NOT NULL,
  `acl_obj` varchar(255) NOT NULL,
  `access` smallint(6) NOT NULL DEFAULT '0',
  `status` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=138 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tb_audit_mail_001
-- ----------------------------
DROP TABLE IF EXISTS `tb_audit_mail_001`;
CREATE TABLE `tb_audit_mail_001` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `did` int(10) unsigned NOT NULL DEFAULT '0',
  `cid` int(10) unsigned NOT NULL DEFAULT '0',
  `start_time` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(61) NOT NULL,
  `src_ip` int(10) unsigned NOT NULL,
  `lan_mac` varchar(61) NOT NULL,
  `terminal_type` int(11) NOT NULL,
  `protocol` tinyint(4) NOT NULL,
  `sender` varchar(255) NOT NULL,
  `receiver` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `attachment` varchar(255) NOT NULL,
  `mail_server` varchar(255) NOT NULL,
  `mime_path` varchar(255) NOT NULL,
  `mail_id` varchar(63) NOT NULL,
  `alarm_level` tinyint(4) NOT NULL,
  `acl_obj` varchar(255) NOT NULL,
  `email_obj` varchar(255) NOT NULL,
  `fieldname` varchar(31) NOT NULL,
  `access` smallint(6) NOT NULL,
  `language_type` int(11) NOT NULL,
  `status` smallint(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tb_audit_p2p_down_001
-- ----------------------------
DROP TABLE IF EXISTS `tb_audit_p2p_down_001`;
CREATE TABLE `tb_audit_p2p_down_001` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `did` int(10) unsigned NOT NULL,
  `cid` int(10) unsigned NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(63) NOT NULL,
  `src_ip` int(10) unsigned NOT NULL,
  `lan_mac` varchar(63) NOT NULL,
  `type` varchar(63) NOT NULL,
  `account` varchar(63) NOT NULL,
  `password` varchar(63) NOT NULL,
  `mark` bigint(20) NOT NULL,
  `terminal_type` int(11) NOT NULL,
  `host` varchar(63) NOT NULL,
  `down_bytes` bigint(20) NOT NULL,
  `up_bytes` bigint(20) NOT NULL,
  `alarm_level` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=107 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tb_audit_search_engine_001
-- ----------------------------
DROP TABLE IF EXISTS `tb_audit_search_engine_001`;
CREATE TABLE `tb_audit_search_engine_001` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `did` int(10) unsigned NOT NULL DEFAULT '0',
  `cid` int(10) unsigned NOT NULL DEFAULT '0',
  `start_time` datetime NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `user_name` varchar(63) NOT NULL,
  `src_ip` int(10) unsigned NOT NULL,
  `lan_mac` varchar(31) NOT NULL,
  `terminal_type` int(11) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `host` varchar(127) NOT NULL,
  `url` varchar(1023) NOT NULL,
  `alarm_level` tinyint(4) NOT NULL,
  `access` tinyint(4) NOT NULL,
  `acl_obj` varchar(255) NOT NULL,
  `language_type` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `did` (`did`) USING BTREE,
  KEY `time` (`did`,`start_time`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=1956 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tb_audit_shopping_001
-- ----------------------------
DROP TABLE IF EXISTS `tb_audit_shopping_001`;
CREATE TABLE `tb_audit_shopping_001` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `did` int(10) unsigned NOT NULL,
  `cid` int(10) unsigned NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(63) NOT NULL,
  `src_ip` int(10) unsigned NOT NULL,
  `lan_mac` varchar(63) NOT NULL,
  `terminal_type` int(11) NOT NULL,
  `type` varchar(63) NOT NULL,
  `account` varchar(63) NOT NULL,
  `password` varchar(63) NOT NULL,
  `mark` bigint(20) NOT NULL,
  `host` varchar(63) NOT NULL,
  `url` varchar(511) NOT NULL,
  `down_bytes` bigint(20) NOT NULL,
  `up_bytes` bigint(20) NOT NULL,
  `alarm_level` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4816 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tb_audit_web_title_001
-- ----------------------------
DROP TABLE IF EXISTS `tb_audit_web_title_001`;
CREATE TABLE `tb_audit_web_title_001` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `did` int(11) NOT NULL DEFAULT '0',
  `cid` int(10) unsigned NOT NULL,
  `capture_time` datetime NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `user_name` varchar(63) NOT NULL,
  `src_ip` int(11) unsigned NOT NULL DEFAULT '0',
  `lan_mac` varchar(16) NOT NULL,
  `terminal_type` int(10) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL,
  `host` varchar(63) NOT NULL,
  `url` varchar(1023) NOT NULL,
  `content_size` int(10) NOT NULL DEFAULT '0',
  `alarm_level` tinyint(3) unsigned NOT NULL,
  `mark` int(10) NOT NULL,
  `language_type` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2471 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tb_audit_web_url_001
-- ----------------------------
DROP TABLE IF EXISTS `tb_audit_web_url_001`;
CREATE TABLE `tb_audit_web_url_001` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `did` int(10) unsigned NOT NULL,
  `cid` int(10) unsigned NOT NULL,
  `start_time` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(31) NOT NULL,
  `src_ip` int(10) unsigned NOT NULL,
  `lan_mac` varchar(31) NOT NULL,
  `terminal_type` int(11) NOT NULL,
  `method` varchar(15) NOT NULL,
  `url` varchar(1023) NOT NULL,
  `host` varchar(63) NOT NULL,
  `content_type` varchar(255) NOT NULL,
  `content_size` int(11) NOT NULL,
  `alarm_level` tinyint(4) NOT NULL,
  `acl_obj` int(11) NOT NULL,
  `url_obj` int(11) NOT NULL,
  `access` tinyint(4) NOT NULL,
  `status` int(11) NOT NULL,
  `language_type` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=157332 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tb_devices
-- ----------------------------
DROP TABLE IF EXISTS `tb_devices`;
CREATE TABLE `tb_devices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` varchar(31) NOT NULL DEFAULT '',
  `key` varchar(255) NOT NULL DEFAULT '',
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `time` date DEFAULT NULL COMMENT '激活时间',
  `company` varchar(255) NOT NULL DEFAULT '' COMMENT '公司名称',
  `contact` varchar(31) NOT NULL DEFAULT '' COMMENT '联系人',
  `phone` varchar(15) NOT NULL DEFAULT '' COMMENT '联系人手机号',
  `tel` varchar(15) NOT NULL DEFAULT '' COMMENT '电话',
  `email` varchar(255) NOT NULL DEFAULT '' COMMENT '电子邮件',
  `warrant` int(11) NOT NULL DEFAULT '0' COMMENT '保修期(天)',
  `staff` varchar(31) NOT NULL DEFAULT '' COMMENT '上门实施人员',
  `update_time` datetime DEFAULT NULL,
  `switch` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tb_feedback
-- ----------------------------
DROP TABLE IF EXISTS `tb_feedback`;
CREATE TABLE `tb_feedback` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `device_id` varchar(32) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '类型',
  `source` varchar(255) NOT NULL DEFAULT '0' COMMENT '来源',
  `version` varchar(64) NOT NULL COMMENT '版本',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `describe` text NOT NULL COMMENT '详细描述',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '反馈状态',
  `admin` varchar(64) NOT NULL COMMENT '负责人',
  `reply_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '回复状态',
  `create_time` datetime NOT NULL COMMENT '创建日期',
  `reply_time` datetime DEFAULT NULL COMMENT '回复日期',
  `over_time` datetime DEFAULT NULL COMMENT '结束日期',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tb_images
-- ----------------------------
DROP TABLE IF EXISTS `tb_images`;
CREATE TABLE `tb_images` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `img_name` varchar(64) NOT NULL,
  `img_path` varchar(255) NOT NULL,
  `up_time` datetime NOT NULL,
  `fid` int(11) NOT NULL DEFAULT '0',
  `uid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tb_reply
-- ----------------------------
DROP TABLE IF EXISTS `tb_reply`;
CREATE TABLE `tb_reply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fid` int(11) NOT NULL COMMENT 'tb_feedback 的ID',
  `uid` int(11) NOT NULL COMMENT 'tb_user 的ID',
  `direction` tinyint(4) NOT NULL DEFAULT '0' COMMENT '方向',
  `reply_time` datetime NOT NULL COMMENT '回复日期',
  `reply_content` text NOT NULL COMMENT '回复内容',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tb_upload_info
-- ----------------------------
DROP TABLE IF EXISTS `tb_upload_info`;
CREATE TABLE `tb_upload_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `func_name` varchar(255) NOT NULL,
  `device_id` varchar(255) NOT NULL,
  `update_time` datetime NOT NULL,
  `switch` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tb_user
-- ----------------------------
DROP TABLE IF EXISTS `tb_user`;
CREATE TABLE `tb_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cloud_id` varchar(16) NOT NULL,
  `user` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `integral` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '积分',
  `email` varchar(64) NOT NULL,
  `device_id` varchar(32) NOT NULL,
  `skin` varchar(32) NOT NULL,
  `font` varchar(32) NOT NULL DEFAULT '',
  `register_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
