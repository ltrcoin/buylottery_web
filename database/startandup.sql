/*
Navicat MySQL Data Transfer

Source Server         : khoinghiep
Source Server Version : 50722
Source Host           : 163.44.207.57:3306
Source Database       : startandup

Target Server Type    : MYSQL
Target Server Version : 50722
File Encoding         : 65001

Date: 2018-06-25 21:27:25
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tbl_action_group
-- ----------------------------
DROP TABLE IF EXISTS `tbl_action_group`;
CREATE TABLE `tbl_action_group` (
  `action_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`action_id`,`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_action_group
-- ----------------------------
INSERT INTO `tbl_action_group` VALUES ('1', '1');
INSERT INTO `tbl_action_group` VALUES ('1', '3');
INSERT INTO `tbl_action_group` VALUES ('2', '2');
INSERT INTO `tbl_action_group` VALUES ('6', '2');
INSERT INTO `tbl_action_group` VALUES ('13', '2');
INSERT INTO `tbl_action_group` VALUES ('14', '2');
INSERT INTO `tbl_action_group` VALUES ('15', '8');
INSERT INTO `tbl_action_group` VALUES ('17', '8');
INSERT INTO `tbl_action_group` VALUES ('18', '8');

-- ----------------------------
-- Table structure for tbl_actions
-- ----------------------------
DROP TABLE IF EXISTS `tbl_actions`;
CREATE TABLE `tbl_actions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT 'Tn hnh ng',
  `description` text NOT NULL COMMENT 'Mô tả hành động',
  `can_checkin` tinyint(4) DEFAULT '1' COMMENT 'Có quyền checkin hay không? Mặc định có',
  `can_checkout` tinyint(4) DEFAULT '1' COMMENT 'Có quyền checkout hay không? Mặc định có',
  `organization_id` int(11) NOT NULL COMMENT 'Id tổ chức',
  `for_all_group` tinyint(4) DEFAULT '0' COMMENT 'Cờ đánh dấu hành động này dành cho tất cả các nhóm hay không. Mặc định là không (0)',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'Cờ xác nhận bản ghi được xóa hay chưa? Mặc định chưa xóa (NULL)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_actions
-- ----------------------------
INSERT INTO `tbl_actions` VALUES ('1', 'StartUp Report', 'Báo cáo về các startup', '1', '1', '2', '0', null, '2018-06-03 10:56:35', '2018-06-03 10:56:35');
INSERT INTO `tbl_actions` VALUES ('2', 'Thống kê cơ sở vật chất', 'Thống kê về vật chất các doanh nghiệp', '1', '1', '2', '1', null, '2018-06-03 12:25:11', '2018-06-03 12:25:11');
INSERT INTO `tbl_actions` VALUES ('6', 'Test', 'TestTestTest', '1', '1', '2', '0', '2018-05-26 05:41:27', '2018-06-03 12:27:16', '2018-06-03 12:27:16');
INSERT INTO `tbl_actions` VALUES ('9', 'Tổ chức họp mặt đại biểu doanh nghiệp mới', 'Tổ chức họp mặt đại biểu doanh nghiệp mới trên địa bàn tỉnh', '1', '1', '1', '1', '2018-05-27 02:02:58', '2018-06-17 18:12:28', null);
INSERT INTO `tbl_actions` VALUES ('10', 'Thống kê số lượng doanh nghiệp mới', 'Thống kê số lượng doanh nghiệp mới', '0', '0', '1', '1', '2018-05-27 02:17:52', '2018-06-17 18:13:05', null);
INSERT INTO `tbl_actions` VALUES ('11', 'Báo cáo tình hình hoạt động của Sở trong tháng', 'Báo cáo tình hình hoạt động của Sở trong tháng', '1', '1', '1', '1', '2018-05-28 03:06:18', '2018-06-17 18:13:40', null);
INSERT INTO `tbl_actions` VALUES ('12', 'Lập danh sách các nhà đầu tư', 'Lập danh sách các nhà đầu tư trên địa bàn tỉnh Hải Dương', '1', '0', '1', '1', '2018-06-03 10:56:21', '2018-06-17 18:14:24', null);
INSERT INTO `tbl_actions` VALUES ('13', 'Báo cáo về mức đầu tư của các nhà đầu tư', 'Báo cáo về mức đầu tư của các nhà đầu tư cho doanh nghiệp trên địa bàn tỉnh', '1', '1', '76', '0', '2018-06-03 12:27:40', '2018-06-20 16:18:55', null);
INSERT INTO `tbl_actions` VALUES ('14', 'hành động A', 'hành động a', '0', '0', '2', '0', '2018-06-03 17:08:33', '2018-06-03 17:09:02', '2018-06-03 17:09:02');
INSERT INTO `tbl_actions` VALUES ('15', 'Báo cáo mức tăng doanh nghiệp mới', 'Báo cáo mức tăng doanh nghiệp mới', '1', '1', '1', '0', '2018-06-04 04:39:54', '2018-06-20 16:18:47', null);
INSERT INTO `tbl_actions` VALUES ('16', 'Lập danh sách các tổ chức hỗ trợ giáo dục', 'TestLập danh sách các tổ chức hỗ trợ giáo dục', '0', '0', '75', '1', '2018-06-11 12:18:35', '2018-06-20 16:18:40', null);
INSERT INTO `tbl_actions` VALUES ('17', 'Báo cáo tổng số chuyên gia hỗ trợ khởi nghiệp', 'Báo cáo tổng số chuyên gia hỗ trợ khởi nghiệp', '0', '0', '73', '0', '2018-06-11 13:32:56', '2018-06-20 16:18:31', null);
INSERT INTO `tbl_actions` VALUES ('18', 'Báo cáo danh sách các nhà đầu tư hỗ trợ khởi nghiệp tỉnh Bắc Ninh', 'Báo cáo danh sách các nhà đầu tư hỗ trợ khởi nghiệp tỉnh Bắc Ninh', '1', '1', '1', '0', '2018-06-17 16:40:56', '2018-06-20 16:18:23', null);

-- ----------------------------
-- Table structure for tbl_city
-- ----------------------------
DROP TABLE IF EXISTS `tbl_city`;
CREATE TABLE `tbl_city` (
  `matp` int(11) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `type` varchar(30) CHARACTER SET utf8 NOT NULL,
  `lat` varchar(255) NOT NULL,
  `lng` varchar(255) NOT NULL,
  PRIMARY KEY (`matp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of tbl_city
-- ----------------------------
INSERT INTO `tbl_city` VALUES ('1', 'Thành phố Hà Nội', 'Thành phố Trung ương', '', '');
INSERT INTO `tbl_city` VALUES ('2', 'Tỉnh Hà Giang', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('4', 'Tỉnh Cao Bằng', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('6', 'Tỉnh Bắc Kạn', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('8', 'Tỉnh Tuyên Quang', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('10', 'Tỉnh Lào Cai', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('11', 'Tỉnh Điện Biên', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('12', 'Tỉnh Lai Châu', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('14', 'Tỉnh Sơn La', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('15', 'Tỉnh Yên Bái', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('17', 'Tỉnh Hoà Bình', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('19', 'Tỉnh Thái Nguyên', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('20', 'Tỉnh Lạng Sơn', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('22', 'Tỉnh Quảng Ninh', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('24', 'Tỉnh Bắc Giang', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('25', 'Tỉnh Phú Thọ', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('26', 'Tỉnh Vĩnh Phúc', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('27', 'Tỉnh Bắc Ninh', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('30', 'Tỉnh Hải Dương', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('31', 'Thành phố Hải Phòng', 'Thành phố Trung ương', '', '');
INSERT INTO `tbl_city` VALUES ('33', 'Tỉnh Hưng Yên', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('34', 'Tỉnh Thái Bình', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('35', 'Tỉnh Hà Nam', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('36', 'Tỉnh Nam Định', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('37', 'Tỉnh Ninh Bình', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('38', 'Tỉnh Thanh Hóa', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('40', 'Tỉnh Nghệ An', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('42', 'Tỉnh Hà Tĩnh', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('44', 'Tỉnh Quảng Bình', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('45', 'Tỉnh Quảng Trị', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('46', 'Tỉnh Thừa Thiên Huế', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('48', 'Thành phố Đà Nẵng', 'Thành phố Trung ương', '', '');
INSERT INTO `tbl_city` VALUES ('49', 'Tỉnh Quảng Nam', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('51', 'Tỉnh Quảng Ngãi', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('52', 'Tỉnh Bình Định', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('54', 'Tỉnh Phú Yên', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('56', 'Tỉnh Khánh Hòa', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('58', 'Tỉnh Ninh Thuận', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('60', 'Tỉnh Bình Thuận', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('62', 'Tỉnh Kon Tum', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('64', 'Tỉnh Gia Lai', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('66', 'Tỉnh Đắk Lắk', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('67', 'Tỉnh Đắk Nông', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('68', 'Tỉnh Lâm Đồng', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('70', 'Tỉnh Bình Phước', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('72', 'Tỉnh Tây Ninh', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('74', 'Tỉnh Bình Dương', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('75', 'Tỉnh Đồng Nai', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('77', 'Tỉnh Bà Rịa - Vũng Tàu', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('79', 'Thành phố Hồ Chí Minh', 'Thành phố Trung ương', '', '');
INSERT INTO `tbl_city` VALUES ('80', 'Tỉnh Long An', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('82', 'Tỉnh Tiền Giang', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('83', 'Tỉnh Bến Tre', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('84', 'Tỉnh Trà Vinh', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('86', 'Tỉnh Vĩnh Long', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('87', 'Tỉnh Đồng Tháp', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('89', 'Tỉnh An Giang', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('91', 'Tỉnh Kiên Giang', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('92', 'Thành phố Cần Thơ', 'Thành phố Trung ương', '', '');
INSERT INTO `tbl_city` VALUES ('93', 'Tỉnh Hậu Giang', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('94', 'Tỉnh Sóc Trăng', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('95', 'Tỉnh Bạc Liêu', 'Tỉnh', '', '');
INSERT INTO `tbl_city` VALUES ('96', 'Tỉnh Cà Mau', 'Tỉnh', '', '');

-- ----------------------------
-- Table structure for tbl_dev
-- ----------------------------
DROP TABLE IF EXISTS `tbl_dev`;
CREATE TABLE `tbl_dev` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `introimage` varchar(256) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `fullname` varchar(256) NOT NULL,
  `address` varchar(256) DEFAULT NULL,
  `tel` varchar(256) DEFAULT NULL,
  `remember_token` varchar(256) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_dev
-- ----------------------------
INSERT INTO `tbl_dev` VALUES ('1', 'admin@dev.com', '$2y$10$vU.CqbKPS2e6KL87zi.Kw.Zz7k//bkCW6o.5Lio3vIHDJvM212hS.', null, '1', 'Dev đẹp zai', null, null, '4vffFsEsfWJZp91pH0WouxuQ7E1qjimAbICKp1w3SA1v17K0kxftx2wU5p0j', '2017-05-06 12:23:13', '2017-05-06 12:23:13');

-- ----------------------------
-- Table structure for tbl_dropdown
-- ----------------------------
DROP TABLE IF EXISTS `tbl_dropdown`;
CREATE TABLE `tbl_dropdown` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tbl_dropdown
-- ----------------------------
INSERT INTO `tbl_dropdown` VALUES ('1', 'vi', 'wog', 'Không gian làm việc, tiện ích văn phòng', 'organization.support_organization.support_type', '2018-06-04 19:44:49', '2018-06-04 19:44:53', null);
INSERT INTO `tbl_dropdown` VALUES ('3', 'vi', 'ic', 'Kết nối đầu tư', 'organization.support_organization.support_type', '2018-06-04 19:44:49', '2018-06-04 19:44:53', null);
INSERT INTO `tbl_dropdown` VALUES ('4', 'vi', 'ba', 'Thúc đẩy kinh doanh (Business Accelarator)', 'organization.support_organization.support_type', '2018-06-04 19:44:49', '2018-06-04 19:44:53', null);
INSERT INTO `tbl_dropdown` VALUES ('5', 'vi', 'cbt', 'Đào tạo nâng cao năng lực', 'organization.support_organization.support_type', '2018-06-04 19:44:49', '2018-06-04 19:44:53', null);
INSERT INTO `tbl_dropdown` VALUES ('6', 'vi', 'eses', 'Trao đổi startup, chuyên gia hỗ trợ (trong nước, quốc tế)', 'organization.support_organization.support_type', '2018-06-04 19:44:49', '2018-06-04 19:44:53', null);
INSERT INTO `tbl_dropdown` VALUES ('7', 'vi', 'fi', 'Pháp lý , Tài chính', 'organization.support_organization.support_type', '2018-06-04 19:44:49', '2018-06-04 19:44:53', null);
INSERT INTO `tbl_dropdown` VALUES ('8', 'vi', 'ad', 'Marketing, Quản trị doanh nghiệp', 'organization.support_organization.support_type', '2018-06-04 19:44:49', '2018-06-04 19:44:53', null);
INSERT INTO `tbl_dropdown` VALUES ('9', 'vi', 'bi', 'Cơ sở ươm tạo', 'organization.support_organization.support_type', '2018-06-04 19:44:49', '2018-06-04 19:44:53', null);
INSERT INTO `tbl_dropdown` VALUES ('10', 'vi', 'com', 'Thuế, Truyền thông', 'organization.support_organization.support_type', '2018-06-04 19:44:49', '2018-06-04 19:44:53', null);
INSERT INTO `tbl_dropdown` VALUES ('11', 'en', 'wog', 'Workspace, Office Gadgets', 'organization.support_organization.support_type', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('13', 'en', 'ic', 'Investment Connection', 'organization.support_organization.support_type', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('14', 'en', 'ba', 'Business Accelerator', 'organization.support_organization.support_type', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('15', 'en', 'cbt', 'Capacity building training', 'organization.support_organization.support_type', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('16', 'en', 'eses', 'Exchange startup, expert support (domestic and international)', 'organization.support_organization.support_type', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('17', 'en', 'fi', 'Legal, Finance', 'organization.support_organization.support_type', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('18', 'en', 'ad', 'Marketing, Corporate Governance', 'organization.support_organization.support_type', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('19', 'en', 'bi', 'Business Incubator', 'organization.support_organization.support_type', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('20', 'en', 'com', 'Taxation, Communications', 'organization.support_organization.support_type', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('21', 'vi', 'et', 'Công nghệ giáo dục ', 'organization.support_organization.investment_sector', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('22', 'vi', 'ft', 'Công nghệ tài chính ', 'organization.support_organization.investment_sector', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('23', 'vi', 'mt', 'Công nghệ y tế', 'organization.support_organization.investment_sector', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('25', 'vi', 'at', 'Công nghệ nông nghiệp ', 'organization.support_organization.investment_sector', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('26', 'vi', 'foodt', 'Công nghệ ẩm thực', 'organization.support_organization.investment_sector', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('27', 'vi', 'tot', 'Công nghệ du lịch', 'organization.support_organization.investment_sector', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('28', 'vi', 'bt', 'Công nghệ nền tàng', 'organization.support_organization.investment_sector', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('29', 'vi', 'tech', 'Công nghệ 4.0 (bigdata, AI, VR/AR, IoT)', 'organization.support_organization.investment_sector', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('30', 'vi', 'tac', 'Công nghệ có ảnh hưởng tới cộng đồng', 'organization.support_organization.investment_sector', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('31', 'en', 'et', 'Educational Technology', 'organization.support_organization.investment_sector', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('32', 'en', 'ft', 'Financial Technology', 'organization.support_organization.investment_sector', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('33', 'en', 'mt', 'Medical Technology', 'organization.support_organization.investment_sector', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('34', 'en', 'at', 'Agricultural Technology', 'organization.support_organization.investment_sector', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('35', 'en', 'foodt', 'Food Technology', 'organization.support_organization.investment_sector', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('36', 'en', 'tot', 'Technology of Tourism', 'organization.support_organization.investment_sector', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('37', 'en', 'bt', 'Background Technology', 'organization.support_organization.investment_sector', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('38', 'en', 'tech', 'Technology 4.0 (bigdata, AI, VR / AR, IoT)', 'organization.support_organization.investment_sector', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('39', 'en', 'tac', 'Technology affects the community', 'organization.support_organization.investment_sector', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('40', 'en', 'sf', 'Seedfund', 'organization.support_organization.investment_phase', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('42', 'en', 'sa', 'Series A', 'organization.support_organization.investment_phase', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('43', 'en', 'sb', 'Series B', 'organization.support_organization.investment_phase', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('44', 'en', 'sc', 'Series C', 'organization.support_organization.investment_phase', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('45', 'vi', 'sf', 'Seedfund', 'organization.support_organization.investment_phase', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('46', 'vi', 'sa', 'Series A', 'organization.support_organization.investment_phase', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('47', 'vi', 'sb', 'Series B', 'organization.support_organization.investment_phase', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('48', 'vi', 'sc', 'Series C', 'organization.support_organization.investment_phase', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('49', 'vi', '<1', '< 1 Triệu $', 'organization.support_organization.value_of_investment', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('50', 'vi', '1-5', '1 triệu - 5 triệu $', 'organization.support_organization.value_of_investment', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('51', 'vi', '>5', '> 5 triệu $', 'organization.support_organization.value_of_investment', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('52', 'en', '>5', '> 5 million $', 'organization.support_organization.value_of_investment', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('53', 'en', '1-5', '1 million - 5 million$', 'organization.support_organization.value_of_investment', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('54', 'en', '<1', '< 1 million $', 'organization.support_organization.value_of_investment', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('55', 'en', 'if', 'Investment Funds', 'organization.support_organization.type_investment_funds', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('56', 'en', 'fmc', 'Fund Management Company', 'organization.support_organization.type_investment_funds', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('57', 'en', 'ic', 'Investment Company', 'organization.support_organization.type_investment_funds', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('58', 'vi', 'if', 'Quỹ đầu tư', 'organization.support_organization.type_investment_funds', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('59', 'vi', 'fmc', 'Công ty quản lý quỹ', 'organization.support_organization.type_investment_funds', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('60', 'vi', 'ic', 'Công ty đầu tư', 'organization.support_organization.type_investment_funds', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('61', 'en', 'prof', 'Professor', 'organization.support_organization.diploma', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('62', 'en', 'dop', 'Doctorates', 'organization.support_organization.diploma', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('63', 'en', 'mos', 'Master of Science', 'organization.support_organization.diploma', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('64', 'en', 'bac', 'Bachelor', 'organization.support_organization.diploma', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('65', 'en', 'eng', 'Engineer', 'organization.support_organization.diploma', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('66', 'en', 'hs', 'Highschool Student', 'organization.support_organization.diploma', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('67', 'vi', 'prof', 'Giáo sư', 'organization.support_organization.diploma', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('68', 'vi', 'dop', 'Tiến sĩ', 'organization.support_organization.diploma', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('69', 'vi', 'mos', 'Thạc sĩ', 'organization.support_organization.diploma', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('70', 'vi', 'bac', 'Cử nhân', 'organization.support_organization.diploma', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('71', 'vi', 'eng', 'Kỹ sư', 'organization.support_organization.diploma', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('72', 'vi', 'hs', 'Học sinh trung học phổ thông', 'organization.support_organization.diploma', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('73', 'vi', 'frd', 'Cơ sở vật chất phục vụ nghiên cứu phát triển', 'organization.support_organization.support_type', '2018-06-04 19:44:49', '2018-06-04 19:44:53', null);
INSERT INTO `tbl_dropdown` VALUES ('74', 'en', 'frd', 'Facilities for research and development', 'organization.support_organization.support_type', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('75', 'vi', 'pdqms', 'Cung cấp dịch vụ về tiêu chuẩn đo lường chất lượng', 'organization.support_organization.support_type', '2018-06-04 19:44:49', '2018-06-04 19:44:53', null);
INSERT INTO `tbl_dropdown` VALUES ('76', 'en', 'pdqms', 'Providing services on quality measurement standards', 'organization.support_organization.support_type', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('77', 'en', 'ips', 'Intellectual Property Service', 'organization.support_organization.support_type', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('78', 'vi', 'ips', 'Dịch vụ Sở hữu trí tuệ', 'organization.support_organization.support_type', '2018-06-04 19:44:49', '2018-06-04 19:44:53', null);
INSERT INTO `tbl_dropdown` VALUES ('79', 'en', 'la', 'Legal advice', 'organization.support_organization.support_type', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('80', 'vi', 'la', 'Tư vấn pháp lý', 'organization.support_organization.support_type', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('81', 'vi', 'fs', 'Tư vấn tài chính', 'organization.support_organization.support_type', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('82', 'en', 'fs', 'Finance Support', 'organization.support_organization.support_type', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('83', 'vi', 'bmc', 'Tư vấn quản trị doanh nghiệp', 'organization.support_organization.support_type', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('84', 'en', 'bmc', 'Business management consultancy', 'organization.support_organization.support_type', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('85', 'vi', 'cbm', 'Tư vấn mô hình kinh doanh', 'organization.support_organization.support_type', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('86', 'en', 'cbm', 'Business model consulting', 'organization.support_organization.support_type', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('87', 'vi', 'ia', 'Tư vấn đầu tư', 'organization.support_organization.support_type', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('88', 'en', 'ia', 'Investment advice', 'organization.support_organization.support_type', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('89', 'en', 'qmc', 'Quality Measurement Consultant', 'organization.support_organization.support_type', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('90', 'vi', 'qmc', 'Tư vấn tiêu chuẩn đo lường chất lượng', 'organization.support_organization.support_type', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('91', 'vi', 'bmcc', 'Tư vấn thương hiệu truyền thông marketing', 'organization.support_organization.support_type', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('92', 'en', 'bmcc', 'Brand Marketing Communication Consultant', 'organization.support_organization.support_type', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('93', 'vi', 'ipc', 'Tư vấn sở hữu trí tuệ', 'organization.support_organization.support_type', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);
INSERT INTO `tbl_dropdown` VALUES ('94', 'en', 'ipc', 'Intellectual Property Consultants', 'organization.support_organization.support_type', '2018-06-04 00:00:00', '2018-06-04 00:00:00', null);

-- ----------------------------
-- Table structure for tbl_form_field
-- ----------------------------
DROP TABLE IF EXISTS `tbl_form_field`;
CREATE TABLE `tbl_form_field` (
  `field_name` varchar(40) NOT NULL,
  `field_type` varchar(20) NOT NULL,
  `task_id` int(11) DEFAULT NULL,
  `action_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_form_field
-- ----------------------------
INSERT INTO `tbl_form_field` VALUES ('Ho ten', 'Text', '3', null);
INSERT INTO `tbl_form_field` VALUES ('Ngay sinh', 'Date', '3', null);
INSERT INTO `tbl_form_field` VALUES ('Họ Tên', 'Text', null, '17');
INSERT INTO `tbl_form_field` VALUES ('Số điện thoại', 'Number', null, '17');
INSERT INTO `tbl_form_field` VALUES ('Email', 'Text', null, '17');
INSERT INTO `tbl_form_field` VALUES ('Field 1', 'Text', null, '16');
INSERT INTO `tbl_form_field` VALUES ('Field 2', 'Date', null, '16');
INSERT INTO `tbl_form_field` VALUES ('Tên DN Khởi Nghiệp', 'Text', null, '15');
INSERT INTO `tbl_form_field` VALUES ('Ngày thành lập', 'Date', null, '15');
INSERT INTO `tbl_form_field` VALUES ('Mô tả', 'Text Area', null, '15');

-- ----------------------------
-- Table structure for tbl_group
-- ----------------------------
DROP TABLE IF EXISTS `tbl_group`;
CREATE TABLE `tbl_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT 'vi',
  `organization_id` int(11) NOT NULL,
  `code` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `checkin` tinyint(1) DEFAULT NULL,
  `checkout` tinyint(1) DEFAULT NULL,
  `confirm` tinyint(1) DEFAULT NULL,
  `reject` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of tbl_group
-- ----------------------------
INSERT INTO `tbl_group` VALUES ('2', 'vi', '1', 'G-Admin', 'Admin', 'Nhóm admin', '1', '1', '1', '1', '2018-05-29 04:24:15', '2018-06-03 17:14:52', null);
INSERT INTO `tbl_group` VALUES ('8', 'vi', '1', 'G 2', 'Group 2', 'fdf', '0', '0', '0', '0', '2018-06-03 07:19:52', '2018-06-03 07:19:52', null);
INSERT INTO `tbl_group` VALUES ('9', 'vi', '1', 'Gd', 'Default', 'Mặc định khi tạo tài khoản', '0', '0', '0', '0', '2018-06-03 20:40:24', '2018-06-17 02:41:22', null);
INSERT INTO `tbl_group` VALUES ('10', 'vi', '1', 'G-DVQL', 'Admin', 'Nhóm Đơn vị quản lý', '1', '1', '1', '1', '2018-05-29 04:24:15', '2018-06-03 17:14:52', null);
INSERT INTO `tbl_group` VALUES ('11', 'vi', '95', 'G-TCHT', 'Admin', 'Nhóm Tổ chức hỗ trợ', '1', '1', '1', '1', '2018-05-29 04:24:15', '2018-06-03 17:14:52', null);
INSERT INTO `tbl_group` VALUES ('12', 'vi', '103', 'G-DNKN', 'Admin', 'Nhóm Doanh nghiệp khởi nghiệp', '1', '1', '1', '1', '2018-05-29 04:24:15', '2018-06-03 17:14:52', null);
INSERT INTO `tbl_group` VALUES ('13', 'vi', '94', 'G-NDT', 'Admin', 'Nhóm Doanh nghiệp khởi nghiệp', '1', '1', '1', '1', '2018-05-29 04:24:15', '2018-06-03 17:14:52', null);

-- ----------------------------
-- Table structure for tbl_group_permission
-- ----------------------------
DROP TABLE IF EXISTS `tbl_group_permission`;
CREATE TABLE `tbl_group_permission` (
  `group_id` int(11) NOT NULL,
  `permission_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`group_id`,`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of tbl_group_permission
-- ----------------------------
INSERT INTO `tbl_group_permission` VALUES ('2', 'backend.actions.add', 'module.action.create');
INSERT INTO `tbl_group_permission` VALUES ('2', 'backend.actions.delete', 'module.action.delete');
INSERT INTO `tbl_group_permission` VALUES ('2', 'backend.actions.detail', 'module.action.detail');
INSERT INTO `tbl_group_permission` VALUES ('2', 'backend.actions.edit', 'module.action.update');
INSERT INTO `tbl_group_permission` VALUES ('2', 'backend.actions.index', 'module.action.view_list');
INSERT INTO `tbl_group_permission` VALUES ('2', 'backend.config.language', 'module.site.user');
INSERT INTO `tbl_group_permission` VALUES ('2', 'backend.group.add', 'module.group.create');
INSERT INTO `tbl_group_permission` VALUES ('2', 'backend.group.delete', 'module.group.delete');
INSERT INTO `tbl_group_permission` VALUES ('2', 'backend.group.detail', 'module.group.detail');
INSERT INTO `tbl_group_permission` VALUES ('2', 'backend.group.edit', 'module.group.update');
INSERT INTO `tbl_group_permission` VALUES ('2', 'backend.group.index', 'module.group.view_list');
INSERT INTO `tbl_group_permission` VALUES ('2', 'backend.group.reverseCheckin', 'module.group.update');
INSERT INTO `tbl_group_permission` VALUES ('2', 'backend.group.reverseCheckout', 'module.group.update');
INSERT INTO `tbl_group_permission` VALUES ('2', 'backend.group.reverseConfirm', 'module.group.update');
INSERT INTO `tbl_group_permission` VALUES ('2', 'backend.group.reverseReject', 'module.group.update');
INSERT INTO `tbl_group_permission` VALUES ('2', 'backend.organize.create', 'module.organization.create');
INSERT INTO `tbl_group_permission` VALUES ('2', 'backend.organize.delete', 'module.organization.delete');
INSERT INTO `tbl_group_permission` VALUES ('2', 'backend.organize.edit', 'module.organization.update');
INSERT INTO `tbl_group_permission` VALUES ('2', 'backend.organize.index', 'module.organization.view_list');
INSERT INTO `tbl_group_permission` VALUES ('2', 'backend.organize.show', 'module.organization.detail');
INSERT INTO `tbl_group_permission` VALUES ('2', 'backend.reports.index', 'module.site.user');
INSERT INTO `tbl_group_permission` VALUES ('2', 'backend.reports.maps', 'module.site.user');
INSERT INTO `tbl_group_permission` VALUES ('2', 'backend.reports.startup_count', 'module.site.user');
INSERT INTO `tbl_group_permission` VALUES ('2', 'backend.site.error', 'module.site.user');
INSERT INTO `tbl_group_permission` VALUES ('2', 'backend.site.index', 'module.site.user');
INSERT INTO `tbl_group_permission` VALUES ('2', 'backend.site.logout', 'module.site.user');
INSERT INTO `tbl_group_permission` VALUES ('2', 'backend.site.uploadImageContent', 'module.site.user');
INSERT INTO `tbl_group_permission` VALUES ('2', 'backend.task.add', 'module.task.create');
INSERT INTO `tbl_group_permission` VALUES ('2', 'backend.task.delete', 'module.task.delete');
INSERT INTO `tbl_group_permission` VALUES ('2', 'backend.task.detail', 'module.task.detail');
INSERT INTO `tbl_group_permission` VALUES ('2', 'backend.task.edit', 'module.task.update');
INSERT INTO `tbl_group_permission` VALUES ('2', 'backend.task.index', 'module.task.view_list');
INSERT INTO `tbl_group_permission` VALUES ('2', 'backend.user.add', 'module.user.create');
INSERT INTO `tbl_group_permission` VALUES ('2', 'backend.user.delete', 'module.user.delete');
INSERT INTO `tbl_group_permission` VALUES ('2', 'backend.user.edit', 'module.user.update');
INSERT INTO `tbl_group_permission` VALUES ('2', 'backend.user.index', 'module.user.view_list');
INSERT INTO `tbl_group_permission` VALUES ('2', 'backend.user.profile', 'module.user.update');
INSERT INTO `tbl_group_permission` VALUES ('8', 'backend.config.language', 'module.site.user');
INSERT INTO `tbl_group_permission` VALUES ('8', 'backend.site.error', 'module.site.user');
INSERT INTO `tbl_group_permission` VALUES ('8', 'backend.site.index', 'module.site.user');
INSERT INTO `tbl_group_permission` VALUES ('8', 'backend.site.logout', 'module.site.user');
INSERT INTO `tbl_group_permission` VALUES ('8', 'backend.site.uploadImageContent', 'module.site.user');
INSERT INTO `tbl_group_permission` VALUES ('9', 'backend.config.language', 'module.site.user');
INSERT INTO `tbl_group_permission` VALUES ('9', 'backend.site.error', 'module.site.user');
INSERT INTO `tbl_group_permission` VALUES ('9', 'backend.site.index', 'module.site.user');
INSERT INTO `tbl_group_permission` VALUES ('9', 'backend.site.logout', 'module.site.user');
INSERT INTO `tbl_group_permission` VALUES ('9', 'backend.site.uploadImageContent', 'module.site.user');
INSERT INTO `tbl_group_permission` VALUES ('10', 'backend.config.language', 'module.site.user');
INSERT INTO `tbl_group_permission` VALUES ('10', 'backend.group.detail', 'module.group.detail');
INSERT INTO `tbl_group_permission` VALUES ('10', 'backend.group.index', 'module.group.view_list');
INSERT INTO `tbl_group_permission` VALUES ('10', 'backend.reports.index', 'module.site.user');
INSERT INTO `tbl_group_permission` VALUES ('10', 'backend.reports.maps', 'module.site.user');
INSERT INTO `tbl_group_permission` VALUES ('10', 'backend.reports.startup_count', 'module.site.user');
INSERT INTO `tbl_group_permission` VALUES ('10', 'backend.site.error', 'module.site.user');
INSERT INTO `tbl_group_permission` VALUES ('10', 'backend.site.index', 'module.site.user');
INSERT INTO `tbl_group_permission` VALUES ('10', 'backend.site.logout', 'module.site.user');
INSERT INTO `tbl_group_permission` VALUES ('10', 'backend.site.uploadImageContent', 'module.site.user');
INSERT INTO `tbl_group_permission` VALUES ('11', 'backend.actions.detail', 'module.action.detail');
INSERT INTO `tbl_group_permission` VALUES ('11', 'backend.actions.index', 'module.action.view_list');
INSERT INTO `tbl_group_permission` VALUES ('11', 'backend.config.language', 'module.site.user');
INSERT INTO `tbl_group_permission` VALUES ('11', 'backend.group.detail', 'module.group.detail');
INSERT INTO `tbl_group_permission` VALUES ('11', 'backend.organize.index', 'module.organization.view_list');
INSERT INTO `tbl_group_permission` VALUES ('11', 'backend.reports.index', 'module.site.user');
INSERT INTO `tbl_group_permission` VALUES ('11', 'backend.reports.maps', 'module.site.user');
INSERT INTO `tbl_group_permission` VALUES ('11', 'backend.reports.startup_count', 'module.site.user');
INSERT INTO `tbl_group_permission` VALUES ('11', 'backend.site.error', 'module.site.user');
INSERT INTO `tbl_group_permission` VALUES ('11', 'backend.site.index', 'module.site.user');
INSERT INTO `tbl_group_permission` VALUES ('11', 'backend.site.logout', 'module.site.user');
INSERT INTO `tbl_group_permission` VALUES ('11', 'backend.site.uploadImageContent', 'module.site.user');
INSERT INTO `tbl_group_permission` VALUES ('11', 'backend.task.detail', 'module.task.detail');
INSERT INTO `tbl_group_permission` VALUES ('11', 'backend.task.index', 'module.task.view_list');

-- ----------------------------
-- Table structure for tbl_group_user
-- ----------------------------
DROP TABLE IF EXISTS `tbl_group_user`;
CREATE TABLE `tbl_group_user` (
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`group_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of tbl_group_user
-- ----------------------------
INSERT INTO `tbl_group_user` VALUES ('2', '1', null, null);
INSERT INTO `tbl_group_user` VALUES ('2', '14', '2018-06-16 09:45:14', '2018-06-16 09:45:14');
INSERT INTO `tbl_group_user` VALUES ('9', '15', '2018-06-17 03:57:31', '2018-06-17 03:57:31');
INSERT INTO `tbl_group_user` VALUES ('9', '16', '2018-06-17 03:57:31', '2018-06-17 03:57:31');
INSERT INTO `tbl_group_user` VALUES ('9', '17', '2018-06-17 03:57:32', '2018-06-17 03:57:32');
INSERT INTO `tbl_group_user` VALUES ('9', '18', '2018-06-17 03:57:32', '2018-06-17 03:57:32');
INSERT INTO `tbl_group_user` VALUES ('9', '19', '2018-06-17 03:57:32', '2018-06-17 03:57:32');
INSERT INTO `tbl_group_user` VALUES ('9', '20', '2018-06-17 03:57:32', '2018-06-17 03:57:32');
INSERT INTO `tbl_group_user` VALUES ('9', '21', '2018-06-17 03:57:32', '2018-06-17 03:57:32');
INSERT INTO `tbl_group_user` VALUES ('9', '22', '2018-06-17 03:57:32', '2018-06-17 03:57:32');
INSERT INTO `tbl_group_user` VALUES ('9', '23', '2018-06-17 03:57:33', '2018-06-17 03:57:33');
INSERT INTO `tbl_group_user` VALUES ('9', '24', '2018-06-17 03:57:33', '2018-06-17 03:57:33');
INSERT INTO `tbl_group_user` VALUES ('9', '25', '2018-06-17 03:57:33', '2018-06-17 03:57:33');
INSERT INTO `tbl_group_user` VALUES ('9', '26', '2018-06-17 03:57:33', '2018-06-17 03:57:33');
INSERT INTO `tbl_group_user` VALUES ('12', '36', '2018-06-17 04:28:26', '2018-06-17 04:28:26');
INSERT INTO `tbl_group_user` VALUES ('13', '37', '2018-06-17 04:28:27', '2018-06-17 04:28:27');

-- ----------------------------
-- Table structure for tbl_legal_representative
-- ----------------------------
DROP TABLE IF EXISTS `tbl_legal_representative`;
CREATE TABLE `tbl_legal_representative` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `legal_representative_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `organize_id` int(11) DEFAULT NULL,
  `dob` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `diploma` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Bằng cấp',
  `sex` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `study_abroad` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tbl_legal_representative
-- ----------------------------
INSERT INTO `tbl_legal_representative` VALUES ('8', null, '30', '2018-06-12', 'dop', '0', 'study_abroad', '2018-06-08 09:36:20', '2018-06-08 09:36:20');
INSERT INTO `tbl_legal_representative` VALUES ('9', null, '30', '2018-06-05', 'hs', '0', null, '2018-06-08 09:36:20', '2018-06-08 09:36:20');
INSERT INTO `tbl_legal_representative` VALUES ('14', '12', '29', '2018-06-08', 'prof', '1', null, '2018-06-09 01:55:15', '2018-06-09 01:55:15');
INSERT INTO `tbl_legal_representative` VALUES ('15', '34', '29', '2018-06-06', 'mos', '0', 'study_abroad', '2018-06-09 01:55:15', '2018-06-09 01:55:15');
INSERT INTO `tbl_legal_representative` VALUES ('18', '123', '37', '2018-06-13', 'eng', '1', 'study_abroad', '2018-06-09 19:22:19', '2018-06-09 19:22:19');
INSERT INTO `tbl_legal_representative` VALUES ('19', '12', '37', '2018-06-07', 'bac', '1', 'study_abroad', '2018-06-09 19:22:19', '2018-06-09 19:22:19');
INSERT INTO `tbl_legal_representative` VALUES ('20', '123', '37', '2018-06-07', 'prof', '0', 'study_abroad', '2018-06-09 19:22:19', '2018-06-09 19:22:19');
INSERT INTO `tbl_legal_representative` VALUES ('24', 'Nhat Le - Co-founder and CEO\nVinh Pham - Co-founder and Technical Architect\nPhuc Nguyen - Co-founder and Technical Leader', '44', '1992-08-13 00:00:00', 'bac', '1', 'study_abroad', '2018-06-16 02:23:00', '2018-06-16 02:23:00');
INSERT INTO `tbl_legal_representative` VALUES ('47', 'Nhat Le - Co-founder and CEO\nVinh Pham - Co-founder and Technical Architect\nPhuc Nguyen - Co-founder and Technical Leader', '58', '1992-08-13 00:00:00', 'bac', '1', 'study_abroad', '2018-06-16 15:02:52', '2018-06-16 15:02:52');
INSERT INTO `tbl_legal_representative` VALUES ('54', 'Nguyễn Văn A', '95', '2018-06-18', 'prof', '1', 'study_abroad', '2018-06-20 14:51:48', '2018-06-20 14:51:48');
INSERT INTO `tbl_legal_representative` VALUES ('55', 'Nguyễn Văn B', '95', '2018-06-26', 'prof', '0', 'study_abroad', '2018-06-20 14:51:48', '2018-06-20 14:51:48');
INSERT INTO `tbl_legal_representative` VALUES ('56', 'Trần Văn A', '102', '2018-06-13', 'prof', '1', 'study_abroad', '2018-06-20 14:54:21', '2018-06-20 14:54:21');
INSERT INTO `tbl_legal_representative` VALUES ('57', 'Tran Duc A', '103', '2018-06-12', 'dop', '1', 'study_abroad', '2018-06-20 15:10:24', '2018-06-20 15:10:24');
INSERT INTO `tbl_legal_representative` VALUES ('58', 'Nhat Le - Co-founder and CEOVinh Pham - Co-founder and Technical ArchitectPhuc Nguyen - Co-founder and Technical Leader', '93', '2018-06-20', 'bac', '1', 'study_abroad', '2018-06-20 16:53:28', '2018-06-20 16:53:28');

-- ----------------------------
-- Table structure for tbl_notifications
-- ----------------------------
DROP TABLE IF EXISTS `tbl_notifications`;
CREATE TABLE `tbl_notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'key ca notification trong file language\nv d: notification.task.add',
  `replace` text COLLATE utf8_unicode_ci COMMENT 'chui json lu cc gi tr replace placeholder trong chui dch',
  `user_id` int(11) NOT NULL COMMENT 'id ngi nhn',
  `mark_as_read` tinyint(4) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tbl_notifications
-- ----------------------------
INSERT INTO `tbl_notifications` VALUES ('1', 'notification.task.status_change', '{\"name\":\"H\\u1ecdp th\\u1ea3o lu\\u1eadn ph\\u01b0\\u01a1ng \\u00e1n x\\u1eed l\\u00fd...\",\"old\":\"M\\u1edf\",\"new\":\"\\u0110ang ti\\u1ebfn h\\u00e0nh\"}', '1', '1', '2018-06-09 19:26:06', '1', '2018-06-09 20:01:29', '1', null);
INSERT INTO `tbl_notifications` VALUES ('2', 'notification.task.status_change', '{\"name\":\"H\\u1ecdp th\\u1ea3o lu\\u1eadn ph\\u01b0\\u01a1ng \\u00e1n x\\u1eed l\\u00fd...\",\"old\":\"\\u0110ang ti\\u1ebfn h\\u00e0nh\",\"new\":\"Ho\\u00e0n th\\u00e0nh\"}', '1', '1', '2018-06-09 20:01:02', '1', '2018-06-09 20:01:29', null, null);
INSERT INTO `tbl_notifications` VALUES ('3', 'notification.task.add', '{\"name\":\"Th\\u1ed1ng k\\u00ea doanh nghi\\u1ec7p m\\u1edbi th\\u00e0nh l\\u1eadp\",\"task_owner\":\"B\\u1ed9 Khoa h\\u1ecdc C\\u00f4ng ngh\\u1ec7\"}', '1', '1', '2018-06-09 20:09:44', '1', '2018-06-09 20:10:11', '1', null);
INSERT INTO `tbl_notifications` VALUES ('4', 'notification.task.add', '{\"name\":\"Th\\u1ed1ng k\\u00ea doanh nghi\\u1ec7p m\\u1edbi th\\u00e0nh l\\u1eadp\",\"task_owner\":\"B\\u1ed9 Khoa h\\u1ecdc C\\u00f4ng ngh\\u1ec7\"}', '9', '0', '2018-06-09 20:09:44', '1', null, null, null);
INSERT INTO `tbl_notifications` VALUES ('5', 'notification.action.add', '{\"user\":\"B\\u1ed9 Khoa h\\u1ecdc v\\u00e0 C\\u00f4ng ngh\\u1ec7\",\"action_name\":\"Test 2\"}', '1', '1', '2018-06-11 12:18:35', '1', '2018-06-11 12:22:37', '1', null);

-- ----------------------------
-- Table structure for tbl_organize
-- ----------------------------
DROP TABLE IF EXISTS `tbl_organize`;
CREATE TABLE `tbl_organize` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'kiểu tổ chức',
  `parent_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'danh mục cha',
  `code` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'mã tổ chức',
  `city` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'tỉnh thành',
  `matp` int(11) DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `tel` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `certificate` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'giẩy chứng nhận hoạt động',
  `established_date` date DEFAULT NULL COMMENT 'ngày thành lập',
  `support_description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'mô tả chi tiết dự định hỗ trợ',
  `support_type` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'loại hình hỗ trợ',
  `legal_representative_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'têm người đại diện pháp luật',
  `current_status` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'tình trạng hiện tại',
  `tax_code` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'mã số thuế',
  `business_areas` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'lĩnh vực kinh doanh',
  `properties` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Tính chất',
  `support_time` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'thời gian hỗ trợ',
  `costs` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'chi phí',
  `founder_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'người sáng lập',
  `people_type` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Nam-Nữ-Khác-du học',
  `target_market` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `outstanding_features` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'Tinh năng nổi bật',
  `outstanding_features_1` text COLLATE utf8_bin,
  `outstanding_features_2` text COLLATE utf8_bin,
  `investment_status` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `sex` tinyint(4) DEFAULT NULL,
  `total_current_capital` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Tổng vốn hiện tại',
  `investment_sector` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `value_of_investment` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `investment_phase` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `lat` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `lng` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `belongto` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `type_investment_funds` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `needs_tobe_supported` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `startup_has_support` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `number_of_startups_invested` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `investment_capital` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `fee` tinyint(4) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `matp` (`matp`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Danh sách tổ chức';

-- ----------------------------
-- Records of tbl_organize
-- ----------------------------
INSERT INTO `tbl_organize` VALUES ('1', 'Bộ Khoa học Công nghệ', '1', '1', '', 'DVQL1', null, '1', 'Hanumanwada, National Highway 163, Chakliwada, Bibinagar, Telangana, India', '12321@gmail.com', '213123', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '17.4759998', '78.79780099999994', null, null, null, null, null, null, null, '2018-06-21 01:50:02', '2018-06-17 04:03:57', null);
INSERT INTO `tbl_organize` VALUES ('73', 'Sở khoa học công nghệ', '1', null, null, '', null, null, 'Hoàn Kiếm - Hà Nội', 'khcn@gmail.com', '0123456789', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '2018-06-17 03:59:41', '2018-06-17 03:59:41', null);
INSERT INTO `tbl_organize` VALUES ('74', 'Sở khoa học công nghệ Hà Nam', '1', null, null, '', null, null, 'Hoàn Kiếm - Hà Nội', 'khcn_hn@gmail.com', '0123456790', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '2018-06-17 03:59:41', '2018-06-17 03:59:41', null);
INSERT INTO `tbl_organize` VALUES ('75', 'Sở khoa học công nghệ Hải Phòng', '1', null, null, '', null, null, 'Hoàn Kiếm - Hà Nội', 'khcn_hp@gmail.com', '0123456791', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '2018-06-17 03:59:41', '2018-06-17 03:59:41', null);
INSERT INTO `tbl_organize` VALUES ('76', 'Sở khoa học công nghệ  Hưng Yên', '1', null, null, '', null, null, 'Hoàn Kiếm - Hà Nội', 'khcn_hy@gmail.com', '0123456792', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '2018-06-17 03:59:41', '2018-06-17 03:59:41', null);
INSERT INTO `tbl_organize` VALUES ('77', 'Sở khoa học công nghệ Bắc Ninh', '1', null, null, '', null, null, 'Hoàn Kiếm - Hà Nội', 'khcn_bn@gmail.com', '0123456793', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '2018-06-17 03:59:41', '2018-06-17 03:59:41', null);
INSERT INTO `tbl_organize` VALUES ('78', ' Tổ chức hỗ trợ khởi nghiệp Hà Nội', '2', null, null, '', null, null, 'Ba Đình - Hà Nội', 'tcht_hn@gmail.com', '0123451789', null, '1992-08-13', 'Hỗ trợ toàn thành phố', 'com,in,ad,fi', null, null, null, null, 'tn', null, null, null, null, null, null, null, null, null, null, null, 'et,ft,mt', '<1', 'sa,sc,sf', null, null, 'is,dbl', null, null, null, null, null, null, '2018-06-17 03:59:41', '2018-06-17 03:59:41', null);
INSERT INTO `tbl_organize` VALUES ('79', ' Tổ chức hỗ trợ khởi nghiệp Hà Nam', '2', null, null, '', null, null, 'Ba Đình - Hà Nội', 'tcht_hanam@gmail.com', '0123451790', null, '1992-08-14', 'Hỗ trợ toàn tỉnh', 'com,in,ad,fi', null, null, null, null, 'cl', null, null, null, null, null, null, null, null, null, null, null, 'et,ft,mt', '1-5', 'sa,sc,sf', null, null, 'is,dbl', null, null, null, null, null, null, '2016-06-17 03:59:41', '2018-06-17 03:59:41', null);
INSERT INTO `tbl_organize` VALUES ('80', ' Tổ chức hỗ trợ khởi nghiệp Hải Phòng', '2', null, null, '', null, null, 'Ba Đình - Hà Nội', 'tcht_hp@gmail.com', '0123451791', null, '1992-08-15', 'Hỗ trợ toàn tỉnh', 'com,in,ad,fi', null, null, null, null, 'cl', null, null, null, null, null, null, null, null, null, null, null, 'et,ft,mt', '>5', 'sa,sc,sf', null, null, 'is,dbl', null, null, null, null, null, null, '2017-06-17 03:59:41', '2018-06-17 03:59:41', null);
INSERT INTO `tbl_organize` VALUES ('81', ' Tổ chức hỗ trợ khởi nghiệp Hưng Yên', '2', null, null, '', null, null, 'Ba Đình - Hà Nội', 'tcht_hy@gmail.com', '0123451792', null, '1992-08-16', 'Hỗ trợ toàn tỉnh', 'com,in,ad,fi', null, null, null, null, 'tn', null, null, null, null, null, null, null, null, null, null, null, 'et,ft,mt', '1-5', 'sa,sc,sf', null, null, 'is,dbl', null, null, null, null, null, null, '2018-06-17 03:59:41', '2018-06-17 03:59:41', null);
INSERT INTO `tbl_organize` VALUES ('82', ' Tổ chức hỗ trợ khởi nghiệp Bắc Ninh', '2', null, null, '', null, null, 'Ba Đình - Hà Nội', 'tcht_bn@gmail.com', '0123451793', null, '1992-08-17', 'Hỗ trợ toàn tỉnh', 'com,in,ad,fi', null, null, null, null, 'cl', null, null, null, null, null, null, null, null, null, null, null, 'et,ft,mt', '1-5', 'sa,sc,sf', null, null, 'is,dbl', null, null, null, null, null, null, '2018-06-17 03:59:41', '2018-06-17 03:59:41', null);
INSERT INTO `tbl_organize` VALUES ('83', 'Chuyên gia hỗ trợ khởi nghiệp', '3', null, null, '', null, null, 'Hà Đông - Hà Nội', 'cght_kn@gmail.com', '0123456826', null, null, '2', 'com,in,ad,fi', null, null, null, null, '2triệu đô', null, null, null, null, null, null, null, null, null, null, null, '2', null, null, null, null, null, null, null, null, null, null, null, '2018-06-17 03:59:42', '2018-06-17 03:59:42', null);
INSERT INTO `tbl_organize` VALUES ('84', 'Tổ chức đầu tư', '4', null, null, 'TCDT2', null, null, 'Cầu Giấy - Hà Nội', 'qdt@gmail.com', '125941321', null, null, null, null, 'Trần Đức Dũng', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '100 triệu đô', null, null, null, null, null, null, 'ic', null, null, null, null, null, '2018-06-17 03:59:42', '2018-06-17 03:59:42', null);
INSERT INTO `tbl_organize` VALUES ('93', 'Công Ty Cổ Phần Công Nghệ Bmg Ami', '5', null, '82', 'DNST5', null, '1', 'Trung Hoa Ward Police, Trần Duy Hưng, Trung Hoà, Cầu Giấy, Hanoi, Vietnam', 'bmgami@gmail.com', '01234569841', null, '2018-08-13', null, null, null, null, null, 'mt,et,ft,at,tech', null, null, null, null, null, 'Trong nước', 'JupViec.vn company specializes in providing services to help families. To meet the urgent needs of customers and create more jobs for women with difficult circumstances, JupViec.vn service providers deploy \"Stay Home Helpers\" in Hanoi.\r\nLink: https://www.jupviec.vn', 0x416D692063756E672063E1BAA570207068E1BAA76E206DE1BB816D2064C6B0E1BB9B692064E1BAA16E672064E1BB8B63682076E1BBA5206BE1BABF742068E1BBA3702076E1BB9B69207068E1BAA76E2063E1BBA96E672076C3A02063C3B46E67206E6768E1BB87205472C3AD207475E1BB87204E68C3A26E2074E1BAA16F2074E1BB9B69206368E1BBA7206E68C3A02076C3A02063C3A1632063C3B46E67207479207175E1BAA36E206CC3BD206E68C3A02063686F20746875C3AA20C491E1BB83206769E1BAA36D20746869E1BB837520636869207068C3AD2076E1BAAD6E2068C3A06E682C206DE1BB9F2072E1BB996E6720717579206DC3B42064E1BB852064C3A06E672076C3A0206D616E67206CE1BAA169206E6869E1BB8175207472E1BAA369206E676869E1BB876D206DE1BB9B692063686F206E67C6B0E1BB9D6920746875C3AA206E68C3A02E2054726F6E672074C6B0C6A16E67206C61692C20416D692063C3B32064E1BBB120C491E1BB8B6E682078C3A2792064E1BBB16E67206EE1BB816E2074E1BAA36E672063686F206DC3B42068C3AC6E68207468C3A06E68207068E1BB91207468C3B46E67206D696E6820C491E1BB83207175E1BAA36E206CC3AD2063C6B02064C3A26E2C206EC4836E67206CC6B0E1BBA36E672076C3A02062E1BAA36F20C491E1BAA36D20616E206E696E682063686F2063C3A163207468C3A06E68207068E1BB91206869E1BB876E20C491E1BAA1692074E1BAA169205669E1BB8774204E616D2E, null, 'Rồi', null, null, null, null, null, '21.0118971', '105.80128730000001', null, null, 'wog,ic', null, null, null, null, '2018-06-17 04:28:26', '2018-06-20 16:53:28', null);
INSERT INTO `tbl_organize` VALUES ('94', 'Nhà đầu tư hà nội', '6', null, '82', 'NTD01', null, null, 'Mai Dịch, Cầu Giấy, Hanoi, Vietnam', 'ndt@gmail.com', '123654987', null, null, null, null, 'Trần Đức Dũng', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '10 triệu đô', 'et,ft,at', null, null, '21.0395659', '105.77407119999998', null, null, null, null, '3', '3 triệu đô', null, '2018-06-17 04:28:26', '2018-06-20 16:05:37', null);
INSERT INTO `tbl_organize` VALUES ('95', 'Bộ Khoa học Công nghệ', '5', 'Doanh nghiệp khởi nghiệp đổi mới sáng tạo', '82', 'DNST3', null, '1', 'Hanoi, Hoàn Kiếm, Hanoi, Vietnam', 'dungtd@gmail.com', '0968374568', null, '2018-06-27', null, null, null, null, null, 'et,ft,mt,at,tech', null, null, null, null, null, 'Quốc tế', 'Điểm nổi bật về mô hình kinh doanh', 0xC49069E1BB836D206EE1BB95692062E1BAAD742076E1BB812063C3B46E67206E6768E1BB87, 0xC49069E1BB836D206EE1BB95692062E1BAAD742076E1BB81206E68C3A26E2073E1BBB1, 'Rồi', null, null, null, null, null, '21.0277644', '105.83415979999995', null, null, 'wog,ba,cbt,eses,fi', null, null, null, null, '2017-06-21 01:48:14', '2018-06-20 14:51:48', null);
INSERT INTO `tbl_organize` VALUES ('96', 'Tổ chức hỗ trợ đạo tạo Hà Nội', '2', 'Tổ chức hỗ trợ khởi nghiệp', '78', 'TCHT1', null, null, 'Ba Đình, Hanoi, Vietnam', 'tcht1@gmail.com', '0123456789', 'upload/certificate/2018/06/20/42W9nTa3Axb0hDmxmRVOKayX5IovE4PRuRR3RyG3.xlsx', '2018-06-20', 'Hỗ trợ mọi thứ', 'ic,ba,cbt,fi', null, null, null, null, 'cl,tn', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '21.0337815', '105.81405389999998', 'is,inde', null, null, null, null, null, '0', '2018-06-20 14:25:52', '2018-06-20 14:25:52', null);
INSERT INTO `tbl_organize` VALUES ('97', 'Chuyển gia hỗ trợ IT hà nội', '3', 'Chuyên gia hỗ trợ khởi nghiệp', '79', 'CG1', null, null, 'Duy Tân, Cầu Giấy, Hanoi, Vietnam', null, null, null, null, null, 'Tài chính,Tư vấn', null, null, null, null, null, '12', '2', null, null, null, null, null, null, null, null, null, null, null, null, '21.0256478', '105.79524620000007', null, null, null, '32', null, null, '0', '2018-06-20 14:27:15', '2018-06-20 14:27:15', null);
INSERT INTO `tbl_organize` VALUES ('98', 'Tổ chức đầu tư IT Hà Nội', '4', 'Tổ chức đầu tư', '82', 'TCDT1', null, null, 'Hà Đông, Tô Hiệu, Hà Cầu, Hà Đông, Hanoi, Vietnam', 'tcdt1@gmail.com', '0123658744', null, null, null, null, 'Trần Đức Dũng', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '123', 'et,ft,mt,foodt', '<1', 'sa', '20.9647784', '105.77264170000001', null, 'if', null, null, '12', '213', '0', '2018-06-20 14:28:23', '2018-06-20 16:03:35', null);
INSERT INTO `tbl_organize` VALUES ('102', 'GRAB', '5', 'Doanh nghiệp khởi nghiệp đổi mới sáng tạo', null, 'DNST3', null, '1', 'Mễ Trì, Hanoi, Vietnam', 'grab@gmail.com', '0569871215', null, '2017-07-27', null, null, null, null, null, 'foodt,bt,tech,tac', null, null, null, null, null, 'Trong nước', 'Điểm nổi bật về mô hình kinh doanh', null, null, 'Rồi', null, null, null, null, null, '21.0055267', '105.77913269999999', null, null, 'frd,bmc,cbm,qmc,bmcc,ipc', null, null, null, '0', '2016-06-20 14:54:21', '2018-06-20 14:54:21', null);
INSERT INTO `tbl_organize` VALUES ('103', 'Uber', '5', 'Doanh nghiệp khởi nghiệp đổi mới sáng tạo', null, 'DNST4', null, '1', 'Vietnam, Hanoi, Cầu Giấy, Dịch Vọng Hậu, Starbucks Coffee Duy Tân', 'dungtd@gmail.com', '0123564897', null, '2016-05-03', null, null, null, null, null, 'tot,ft,mt,at,foodt,tot', null, null, null, null, null, 'Trong nước', 'Điểm nổi bật về mô hình kinh doanh', null, null, 'Rồi', null, null, null, null, null, '21.0308737', '105.78534160000004', null, null, 'ic,ba,cbt', null, null, null, '0', '2018-06-20 15:10:23', '2018-06-20 15:10:23', null);
INSERT INTO `tbl_organize` VALUES ('104', 'Chuyên gia hỗ trợ khởi nghiệp ABC', '3', 'Chuyên gia hỗ trợ khởi nghiệp', '82', 'CG2', null, null, 'Thái Hà, Đống Đa, Hanoi, Vietnam', null, null, null, null, null, 'Tài chính,Cơ sở vật chất', null, null, null, null, null, '12', '12', null, null, null, null, null, null, null, null, null, null, null, null, '21.0134109', '105.81943330000001', null, null, null, '32', null, null, '0', '2018-06-20 19:36:35', '2018-06-20 19:36:35', null);

-- ----------------------------
-- Table structure for tbl_permission
-- ----------------------------
DROP TABLE IF EXISTS `tbl_permission`;
CREATE TABLE `tbl_permission` (
  `permission_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of tbl_permission
-- ----------------------------
INSERT INTO `tbl_permission` VALUES ('backend.actions.add', 'Trang hành động  - tạo mới', 'module.action.create');
INSERT INTO `tbl_permission` VALUES ('backend.actions.delete', 'Trang hành động  - Xóa', 'module.action.delete');
INSERT INTO `tbl_permission` VALUES ('backend.actions.detail', 'Trang hành động - xem chi tiết', 'module.action.detail');
INSERT INTO `tbl_permission` VALUES ('backend.actions.edit', 'Trang hành động - Cập nhật', 'module.action.update');
INSERT INTO `tbl_permission` VALUES ('backend.actions.index', 'Trang hành động - xem danh sách', 'module.action.view_list');
INSERT INTO `tbl_permission` VALUES ('backend.group.add', 'Trang nhóm - Tạo mới', 'module.group.create');
INSERT INTO `tbl_permission` VALUES ('backend.group.delete', 'Trang nhóm - Xóa', 'module.group.delete');
INSERT INTO `tbl_permission` VALUES ('backend.group.detail', 'Trang nhóm - Xem chi tiết', 'module.group.detail');
INSERT INTO `tbl_permission` VALUES ('backend.group.edit', 'Trang nhóm - Cập nhật', 'module.group.update');
INSERT INTO `tbl_permission` VALUES ('backend.group.index', 'Trang Nhóm - Xem danh sách', 'module.group.view_list');
INSERT INTO `tbl_permission` VALUES ('backend.group.reverseCheckin', 'Trang nhóm - Cập nhật quyền Check In', 'module.group.update');
INSERT INTO `tbl_permission` VALUES ('backend.group.reverseCheckout', 'Trang nhóm - Cập nhật quyền check out', 'module.group.update');
INSERT INTO `tbl_permission` VALUES ('backend.group.reverseConfirm', 'Trang nhóm - Cập nhật quyền confirm', 'module.group.update');
INSERT INTO `tbl_permission` VALUES ('backend.group.reverseReject', 'Trang nhóm - Cập nhật quyền reject', 'module.group.update');
INSERT INTO `tbl_permission` VALUES ('backend.organize.create', 'Trang tổ chức - Tạo mới', 'module.organization.create');
INSERT INTO `tbl_permission` VALUES ('backend.organize.delete', 'Trang tổ chức - Xóa', 'module.organization.delete');
INSERT INTO `tbl_permission` VALUES ('backend.organize.edit', 'Trang tổ chức - Cập nhật', 'module.organization.update');
INSERT INTO `tbl_permission` VALUES ('backend.organize.index', 'Trang tổ chức - Xem danh sách', 'module.organization.view_list');
INSERT INTO `tbl_permission` VALUES ('backend.organize.show', 'Trang tổ chức - Xem chi tiết', 'module.organization.detail');
INSERT INTO `tbl_permission` VALUES ('backend.task.add', 'Trang tác vụ - Tạo mới', 'module.task.create');
INSERT INTO `tbl_permission` VALUES ('backend.task.delete', 'Trang tác vụ - Xóa', 'module.task.delete');
INSERT INTO `tbl_permission` VALUES ('backend.task.detail', 'Trang tác vụ - Xam chi tiết', 'module.task.detail');
INSERT INTO `tbl_permission` VALUES ('backend.task.edit', 'Trang tác vụ - Cập nhật', 'module.task.update');
INSERT INTO `tbl_permission` VALUES ('backend.task.index', 'Trang tác vụ - Xem danh sách', 'module.task.view_list');
INSERT INTO `tbl_permission` VALUES ('backend.user.add', 'Trang user - Tạo mới', 'module.user.create');
INSERT INTO `tbl_permission` VALUES ('backend.user.delete', 'Trang user - Xóa', 'module.user.delete');
INSERT INTO `tbl_permission` VALUES ('backend.user.edit', 'Trang user - Cập nhật', 'module.user.update');
INSERT INTO `tbl_permission` VALUES ('backend.user.index', 'Trang user - Xem danh sách', 'module.user.view_list');
INSERT INTO `tbl_permission` VALUES ('backend.user.profile', 'Trang user - Cập nhật profile', 'module.user.update');

-- ----------------------------
-- Table structure for tbl_social_account
-- ----------------------------
DROP TABLE IF EXISTS `tbl_social_account`;
CREATE TABLE `tbl_social_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `provider_user_id` varchar(50) DEFAULT NULL,
  `provider` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_social_account
-- ----------------------------
INSERT INTO `tbl_social_account` VALUES ('4', '107532520903207220155', 'google', '30', '2018-06-18 08:22:27', '2018-06-18 08:22:27');

-- ----------------------------
-- Table structure for tbl_task_action
-- ----------------------------
DROP TABLE IF EXISTS `tbl_task_action`;
CREATE TABLE `tbl_task_action` (
  `task_id` int(11) NOT NULL,
  `action_id` int(11) NOT NULL,
  PRIMARY KEY (`task_id`,`action_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of tbl_task_action
-- ----------------------------
INSERT INTO `tbl_task_action` VALUES ('1', '15');
INSERT INTO `tbl_task_action` VALUES ('2', '11');
INSERT INTO `tbl_task_action` VALUES ('3', '15');
INSERT INTO `tbl_task_action` VALUES ('4', '13');
INSERT INTO `tbl_task_action` VALUES ('4', '17');
INSERT INTO `tbl_task_action` VALUES ('5', '13');

-- ----------------------------
-- Table structure for tbl_task_group
-- ----------------------------
DROP TABLE IF EXISTS `tbl_task_group`;
CREATE TABLE `tbl_task_group` (
  `task_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`task_id`,`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of tbl_task_group
-- ----------------------------
INSERT INTO `tbl_task_group` VALUES ('1', '8');
INSERT INTO `tbl_task_group` VALUES ('4', '10');
INSERT INTO `tbl_task_group` VALUES ('5', '10');

-- ----------------------------
-- Table structure for tbl_task_organization
-- ----------------------------
DROP TABLE IF EXISTS `tbl_task_organization`;
CREATE TABLE `tbl_task_organization` (
  `task_id` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL,
  PRIMARY KEY (`task_id`,`organization_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of tbl_task_organization
-- ----------------------------

-- ----------------------------
-- Table structure for tbl_task_user
-- ----------------------------
DROP TABLE IF EXISTS `tbl_task_user`;
CREATE TABLE `tbl_task_user` (
  `task_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`task_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of tbl_task_user
-- ----------------------------
INSERT INTO `tbl_task_user` VALUES ('3', '1');

-- ----------------------------
-- Table structure for tbl_tasks
-- ----------------------------
DROP TABLE IF EXISTS `tbl_tasks`;
CREATE TABLE `tbl_tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tn tc v',
  `organization_id` int(11) NOT NULL COMMENT 'Id của tổ chức giao tác vụ',
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Kiểu tác vụ (giao tổ chức hay cá nhân). 0: tổ chức, 1: cá nhân',
  `assign_all` tinyint(4) DEFAULT '0' COMMENT 'Giao cho tất cả tổ chức/cá nhân hay không. 1: có, 0: không',
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Mô tả tác vụ',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT 'Trạng thái tác vụ. 1: Open, 2: Processing, 3: Completed, 4: Rejected, 5: Checkin, 6: Checkout',
  `start_date` date NOT NULL COMMENT 'Ngày bắt đầu',
  `end_date` date NOT NULL COMMENT 'Ngày kết theca',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL COMMENT 'id  của user tạo ra bản ghi',
  `updated_by` int(11) DEFAULT NULL COMMENT 'id của user cập nhật bản ghi lần gần nhất',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of tbl_tasks
-- ----------------------------
INSERT INTO `tbl_tasks` VALUES ('1', 'Lập báo cáo tình hình doanh nghiệp mới', '1', '2', '0', 'Tác vụ giao cho nhóm', '1', '2018-05-31', '2018-06-07', '2018-05-31 16:07:45', '2018-06-09 19:58:58', null, null, '1');
INSERT INTO `tbl_tasks` VALUES ('2', 'Họp thảo luận phương án xử lý...', '1', '2', '1', 'Họp thảo luận phương án xử lý...', '2', '2018-06-04', '2018-06-13', '2018-06-04 01:32:54', '2018-06-09 20:01:02', null, null, '1');
INSERT INTO `tbl_tasks` VALUES ('3', 'Thống kê doanh nghiệp mới thành lập', '1', '3', '0', 'Thống kê  doanh nghiệp mới thành lập trong tháng 6/2018 trên địa bản các tỉnh Hà Nội, Hải Dương, Hải Phòng', '0', '2018-06-10', '2018-07-31', '2018-06-09 20:09:44', '2018-06-09 20:09:44', null, '1', null);
INSERT INTO `tbl_tasks` VALUES ('4', 'Báo cáo về hoạt động hỗ trợ khởi nghiệp', '1', '2', '0', 'Báo cáo về hoạt động hỗ trợ khởi nghiệp', '0', '2018-06-18', '2018-06-30', '2018-06-17 18:20:34', '2018-06-17 18:20:34', null, '1', null);
INSERT INTO `tbl_tasks` VALUES ('5', 'Báo cáo tình hình đầu tư vào các doanh nghiệp khởi nghiệp', '1', '2', '0', 'Lập danh sách, báo cáo số lượng nhà đầu tư, só tiền đầu tư cho các doanh nghiệp khởi nghiệp mới', '0', '2018-06-20', '2018-07-03', '2018-06-18 03:19:57', '2018-06-18 03:19:57', null, '1', null);

-- ----------------------------
-- Table structure for tbl_users
-- ----------------------------
DROP TABLE IF EXISTS `tbl_users`;
CREATE TABLE `tbl_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(128) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `password` varchar(128) NOT NULL,
  `introimage` varchar(256) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `fullname` varchar(256) NOT NULL,
  `isAdmin` tinyint(4) NOT NULL DEFAULT '0',
  `address` varchar(256) DEFAULT NULL,
  `tel` varchar(256) DEFAULT NULL,
  `remember_token` varchar(256) DEFAULT NULL,
  `is_admin` int(1) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_users
-- ----------------------------
INSERT INTO `tbl_users` VALUES ('1', '', 'admin@startandup.org', '$2y$10$UWRvFt8OHEyH3DolmFCwHefs8q3dOhAkJNi2qJ5Ys5uMjhhvcii0m', 'upload/avatar/2018/06/03/db6eUe6vGAYbsyVhCEnjounWsg2epEavTgG8dlno.jpeg', '1', 'Bộ Khoa học và Công nghệ', '0', '113 Trần Duy Hưng - Hà Nội', null, 'ccYQEacXMISq6wqXegtquLnujrJP3KETwOKWk5kMPOCVIdvtES8q6l3EsJqg', '1', null, '2017-04-21 07:08:52', '2018-06-04 03:45:34', null);
INSERT INTO `tbl_users` VALUES ('9', null, 'nguyendatbn90@gmail.com', '$2y$10$PYIcJJP.Sc3t/Srse8w3mu2BoBgExWKy5GcHAwMFADJzITWZStFfe', 'https://lh4.googleusercontent.com/-L1gxOjQNJT8/AAAAAAAAAAI/AAAAAAAAAAA/AB6qoq0OXZemOBQLjy0MLpVuLMTkGoC7jA/mo/photo.jpg?sz=50', '1', 'Nguyễn Đạt', '0', null, null, 'uNmKW76LgEYwrgBwb4dX3KQiZOacTofMnSo4DBZ0HfLySCrjrucm8GhGR1it', '2', null, '2018-06-09 19:47:12', '2018-06-09 19:47:12', null);
INSERT INTO `tbl_users` VALUES ('10', null, 'vnnvh80@gmail.com', '$2y$10$4nVU95ZuVWVifnQPZywaV.Dl23A9B8iDqSfoRpiDvibwa0WLL8WUS', null, '1', 'Nguyễn Viết Huy', '0', null, '0979776427', '8U9CNHmR9Z4Rgjf91pDdeZjsVcbp7e7r7y0SVU6Ig3bMYVt772dzrRblfzvd', null, null, '2018-06-10 14:39:11', '2018-06-10 14:39:11', null);
INSERT INTO `tbl_users` VALUES ('14', 'dungtd', 'dungtd1308@gmail.com', '$2y$10$qI.cNQ9BLnFzwrnvjiKn2ujn5BepEaMl6KDv4DeuxF6n4Yk05XKti', null, '1', 'tran dung', '0', null, '1231867391', null, null, null, '2018-06-16 09:45:14', '2018-06-16 09:45:14', null);
INSERT INTO `tbl_users` VALUES ('15', null, 'khcn@gmail.com', '$2y$10$xnOfsMbEwM.CEcFg1yU1.ORMIrZ6R6RDCCV8Vp669P5CV/MJV.fSK', null, '1', 'Sở khoa học công nghệ', '0', null, '0123456789', null, null, null, '2018-06-17 03:57:31', '2018-06-17 03:57:31', null);
INSERT INTO `tbl_users` VALUES ('16', null, 'khcn_hn@gmail.com', '$2y$10$TWGzd1CvfP5xmlhHCG7is.cWlpEJJqc1/jPKn7OHosOoEUd8oHeZy', null, '1', 'Sở khoa học công nghệ Hà Nam', '0', null, '0123456790', null, null, null, '2018-06-17 03:57:31', '2018-06-17 03:57:31', null);
INSERT INTO `tbl_users` VALUES ('17', null, 'khcn_hp@gmail.com', '$2y$10$qVWtbK82d5//uZa56HZ0yOgfG14jlGn8Dz8m12fv86dWVvjqeRyH.', null, '1', 'Sở khoa học công nghệ Hải Phòng', '0', null, '0123456791', null, null, null, '2018-06-17 03:57:32', '2018-06-17 03:57:32', null);
INSERT INTO `tbl_users` VALUES ('18', null, 'khcn_hy@gmail.com', '$2y$10$Io4qbZBfoo/ynfmpBmblBel4KIn54R3Kk.MI7nfJktO4ds6xqARQm', null, '1', 'Sở khoa học công nghệ  Hưng Yên', '0', null, '0123456792', null, null, null, '2018-06-17 03:57:32', '2018-06-17 03:57:32', null);
INSERT INTO `tbl_users` VALUES ('19', null, 'khcn_bn@gmail.com', '$2y$10$1pULMtl5eu62haVNfh971.V0imAqld/RUxJxHTCA7k4VNQ8.XzdQS', null, '1', 'Sở khoa học công nghệ Bắc Ninh', '0', null, '0123456793', null, null, null, '2018-06-17 03:57:32', '2018-06-17 03:57:32', null);
INSERT INTO `tbl_users` VALUES ('20', null, 'tcht_hn@gmail.com', '$2y$10$WN9KFfGacnijjSn/1g2e7eKAEywedERXICAEkXtd7p.8HZxE98V2q', null, '1', ' Tổ chức hỗ trợ khởi nghiệp Hà Nội', '0', null, '0123451789', null, null, null, '2018-06-17 03:57:32', '2018-06-17 03:57:32', null);
INSERT INTO `tbl_users` VALUES ('21', null, 'tcht_hanam@gmail.com', '$2y$10$aIR8fcyrmatXWGbNleySaeEOKUQL0C9Xqx.Z1y4QGOglrqRv92YeS', null, '1', ' Tổ chức hỗ trợ khởi nghiệp Hà Nam', '0', null, '0123451790', null, null, null, '2018-06-17 03:57:32', '2018-06-17 03:57:32', null);
INSERT INTO `tbl_users` VALUES ('22', null, 'tcht_hp@gmail.com', '$2y$10$8Fvgc4d93YIpx3gy.fJEWe3xqCJHkLzZzTBy1YwYiaOMcWKgcRZ86', null, '1', ' Tổ chức hỗ trợ khởi nghiệp Hải Phòng', '0', null, '0123451791', 'hna0Ngz6aHGKqfBMvk3x3t7FOFKOiAS1PITLjsJM5E47lUyCZ91etUJm2ckr', null, null, '2018-06-17 03:57:32', '2018-06-17 03:57:32', null);
INSERT INTO `tbl_users` VALUES ('23', null, 'tcht_hy@gmail.com', '$2y$10$pFhhKFUJaWHzjq.U0qdj.OOeaiGU7zQUdNjppNlxX4w.fAah9Ouku', null, '1', ' Tổ chức hỗ trợ khởi nghiệp Hưng Yên', '0', null, '0123451792', null, null, null, '2018-06-17 03:57:33', '2018-06-17 03:57:33', null);
INSERT INTO `tbl_users` VALUES ('24', null, 'tcht_bn@gmail.com', '$2y$10$qOhcY6ul35lvPQ1HG8gl6udOsc5MkblgCw5rojQMxbtXcSOt08U7O', null, '1', ' Tổ chức hỗ trợ khởi nghiệp Bắc Ninh', '0', null, '0123451793', null, null, null, '2018-06-17 03:57:33', '2018-06-17 03:57:33', null);
INSERT INTO `tbl_users` VALUES ('25', null, 'cght_kn@gmail.com', '$2y$10$tMTrUMDF40cezQRf4t7CfuGagkd5mDKJEfovTBiGydv1oIA.0MLaq', null, '1', 'Chuyên gia hỗ trợ khởi nghiệp', '0', null, '0123456826', null, null, null, '2018-06-17 03:57:33', '2018-06-17 03:57:33', null);
INSERT INTO `tbl_users` VALUES ('26', null, 'qdt@gmail.com', '$2y$10$uO9Q8uzaiXxzZApUR32woe8uqbOziX5ZGV8xulI0QoGQQplZ3IK.e', null, '1', 'Tổ chức đầu tư', '0', null, '125941321', null, null, null, '2018-06-17 03:57:33', '2018-06-17 03:57:33', null);
INSERT INTO `tbl_users` VALUES ('36', null, 'bmgami@gmail.com', '$2y$10$aJsfI8ZC1V7IfKdDLA8Ysu8dO6CMNdrr8ykBU1BGw9p3/7kxPaCf6', null, '1', 'Công Ty Cổ Phần Công Nghệ Bmg Ami', '0', null, '01234569841', 'zI5W0VIOaGnlayBq3h6FZJFb4zYvdmFeWIXePD7QvBcQWHnY9ypGfrBf8udI', null, null, '2018-06-17 04:28:26', '2018-06-17 04:28:26', null);
INSERT INTO `tbl_users` VALUES ('37', null, 'ndt@gmail.com', '$2y$10$e8xUBTiaP1nOWAsmeQ7EUuP86.owmbFHzDLOg8iquXiWCZV/xOlC2', null, '1', 'Nhà đầu tư hà nội', '0', null, '123654987', 'spAPQdiCdUx9k3fvaQDp919hi3FYDe5Fwa262gITxw4eWTz5Ga8iC0GTnfkc', null, null, '2018-06-17 04:28:27', '2018-06-17 04:28:27', null);
