/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50719
 Source Host           : localhost:3306
 Source Schema         : fashop

 Target Server Type    : MySQL
 Target Server Version : 50719
 File Encoding         : 65001

 Date: 05/09/2018 14:49:53
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for ez_access_token
-- ----------------------------
DROP TABLE IF EXISTS `ez_access_token`;
CREATE TABLE `ez_access_token`  (
  `jti` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sub` int(10) UNSIGNED NULL DEFAULT NULL,
  `iat` int(10) UNSIGNED NULL DEFAULT NULL,
  `exp` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '过期时间',
  `ip` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `create_time` int(10) UNSIGNED NULL DEFAULT NULL,
  `is_logout` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '是否主动退出',
  `is_invalid` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '作废，当修改密码后会作废 1作废 0没有作废',
  `logout_time` int(10) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`jti`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 755 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_address
-- ----------------------------
DROP TABLE IF EXISTS `ez_address`;
CREATE TABLE `ez_address`  (
  `id` mediumint(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '地址ID',
  `user_id` mediumint(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '会员ID',
  `truename` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '会员姓名',
  `province_id` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '省份id',
  `city_id` mediumint(9) NULL DEFAULT NULL COMMENT '市级ID',
  `area_id` mediumint(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '地区ID',
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '地址',
  `combine_detail` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '地区内容组合',
  `tel_phone` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '座机电话',
  `mobile_phone` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '手机电话',
  `zip_code` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '邮编',
  `is_default` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '1默认收货地址',
  `type` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '\'个人\',\'公司\',\'其他\'....',
  `street_id` int(11) NULL DEFAULT 0 COMMENT '街道id',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `member_id`(`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '买家地址信息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_area
-- ----------------------------
DROP TABLE IF EXISTS `ez_area`;
CREATE TABLE `ez_area`  (
  `id` int(10) NOT NULL COMMENT 'ID 名称code',
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '栏目名',
  `pid` int(10) NOT NULL COMMENT '父栏目',
  `location` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '全路径',
  `level_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '级别名称',
  `longitude` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '经度',
  `latitude` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '维度',
  `level` tinyint(1) NULL DEFAULT NULL COMMENT '级别',
  `position` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '方位',
  `city_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '城市代码',
  `zip_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '邮编',
  `pinyin` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '拼音',
  `initial` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '首字母',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `id`(`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ez_area
-- ----------------------------
INSERT INTO `ez_area` VALUES (110000, '北京市', 0, '116.407394,39.904211', 'province', '116.407394', '39.904211', 1, NULL, NULL, NULL, 'Beijing', 'B', NULL);
INSERT INTO `ez_area` VALUES (110100, '北京城区', 110000, '116.407394,39.904211', 'city', '116.407394', '39.904211', 2, NULL, '010', '100000', 'Beijing', 'B', NULL);
INSERT INTO `ez_area` VALUES (110101, '东城区', 110100, '116.41649,39.928341', 'district', '116.41649', '39.928341', 3, NULL, '010', '100010', 'Dongcheng', 'D', NULL);
INSERT INTO `ez_area` VALUES (110102, '西城区', 110100, '116.365873,39.912235', 'district', '116.365873', '39.912235', 3, NULL, '010', '100032', 'Xicheng', 'X', NULL);
INSERT INTO `ez_area` VALUES (110105, '朝阳区', 110100, '116.443205,39.921506', 'district', '116.443205', '39.921506', 3, NULL, '010', '100020', 'Chaoyang', 'C', NULL);
INSERT INTO `ez_area` VALUES (110106, '丰台区', 110100, '116.287039,39.858421', 'district', '116.287039', '39.858421', 3, NULL, '010', '100071', 'Fengtai', 'F', NULL);
INSERT INTO `ez_area` VALUES (110107, '石景山区', 110100, '116.222933,39.906611', 'district', '116.222933', '39.906611', 3, NULL, '010', '100043', 'Shijingshan', 'S', NULL);
INSERT INTO `ez_area` VALUES (110108, '海淀区', 110100, '116.298262,39.95993', 'district', '116.298262', '39.95993', 3, NULL, '010', '100089', 'Haidian', 'H', NULL);
INSERT INTO `ez_area` VALUES (110109, '门头沟区', 110100, '116.101719,39.940338', 'district', '116.101719', '39.940338', 3, NULL, '010', '102300', 'Mentougou', 'M', NULL);
INSERT INTO `ez_area` VALUES (110111, '房山区', 110100, '116.143486,39.748823', 'district', '116.143486', '39.748823', 3, NULL, '010', '102488', 'Fangshan', 'F', NULL);
INSERT INTO `ez_area` VALUES (110112, '通州区', 110100, '116.656434,39.909946', 'district', '116.656434', '39.909946', 3, NULL, '010', '101149', 'Tongzhou', 'T', NULL);
INSERT INTO `ez_area` VALUES (110113, '顺义区', 110100, '116.654642,40.130211', 'district', '116.654642', '40.130211', 3, NULL, '010', '101300', 'Shunyi', 'S', NULL);
INSERT INTO `ez_area` VALUES (110114, '昌平区', 110100, '116.231254,40.220804', 'district', '116.231254', '40.220804', 3, NULL, '010', '102200', 'Changping', 'C', NULL);
INSERT INTO `ez_area` VALUES (110115, '大兴区', 110100, '116.341483,39.726917', 'district', '116.341483', '39.726917', 3, NULL, '010', '102600', 'Daxing', 'D', NULL);
INSERT INTO `ez_area` VALUES (110116, '怀柔区', 110100, '116.631931,40.316053', 'district', '116.631931', '40.316053', 3, NULL, '010', '101400', 'Huairou', 'H', NULL);
INSERT INTO `ez_area` VALUES (110117, '平谷区', 110100, '117.121351,40.140595', 'district', '117.121351', '40.140595', 3, NULL, '010', '101200', 'Pinggu', 'P', NULL);
INSERT INTO `ez_area` VALUES (110118, '密云区', 110100, '116.843047,40.376894', 'district', '116.843047', '40.376894', 3, NULL, '010', '101500', 'Miyun', 'M', NULL);
INSERT INTO `ez_area` VALUES (110119, '延庆区', 110100, '115.974981,40.456591', 'district', '115.974981', '40.456591', 3, NULL, '010', '102100', 'Yanqing', 'Y', NULL);
INSERT INTO `ez_area` VALUES (120000, '天津市', 0, '117.200983,39.084158', 'province', '117.200983', '39.084158', 1, NULL, NULL, NULL, 'Tianjin', 'T', NULL);
INSERT INTO `ez_area` VALUES (120100, '天津城区', 120000, '117.200983,39.084158', 'city', '117.200983', '39.084158', 2, NULL, '022', '300000', 'Tianjin', 'T', NULL);
INSERT INTO `ez_area` VALUES (120101, '和平区', 120100, '117.214699,39.117196', 'district', '117.214699', '39.117196', 3, NULL, '022', '300041', 'Heping', 'H', NULL);
INSERT INTO `ez_area` VALUES (120102, '河东区', 120100, '117.251584,39.128294', 'district', '117.251584', '39.128294', 3, NULL, '022', '300171', 'Hedong', 'H', NULL);
INSERT INTO `ez_area` VALUES (120103, '河西区', 120100, '117.223371,39.109563', 'district', '117.223371', '39.109563', 3, NULL, '022', '300202', 'Hexi', 'H', NULL);
INSERT INTO `ez_area` VALUES (120104, '南开区', 120100, '117.150738,39.138205', 'district', '117.150738', '39.138205', 3, NULL, '022', '300110', 'Nankai', 'N', NULL);
INSERT INTO `ez_area` VALUES (120105, '河北区', 120100, '117.196648,39.147869', 'district', '117.196648', '39.147869', 3, NULL, '022', '300143', 'Hebei', 'H', NULL);
INSERT INTO `ez_area` VALUES (120106, '红桥区', 120100, '117.151533,39.167345', 'district', '117.151533', '39.167345', 3, NULL, '022', '300131', 'Hongqiao', 'H', NULL);
INSERT INTO `ez_area` VALUES (120110, '东丽区', 120100, '117.31362,39.086802', 'district', '117.31362', '39.086802', 3, NULL, '022', '300300', 'Dongli', 'D', NULL);
INSERT INTO `ez_area` VALUES (120111, '西青区', 120100, '117.008826,39.141152', 'district', '117.008826', '39.141152', 3, NULL, '022', '300380', 'Xiqing', 'X', NULL);
INSERT INTO `ez_area` VALUES (120112, '津南区', 120100, '117.35726,38.937928', 'district', '117.35726', '38.937928', 3, NULL, '022', '300350', 'Jinnan', 'J', NULL);
INSERT INTO `ez_area` VALUES (120113, '北辰区', 120100, '117.135488,39.224791', 'district', '117.135488', '39.224791', 3, NULL, '022', '300400', 'Beichen', 'B', NULL);
INSERT INTO `ez_area` VALUES (120114, '武清区', 120100, '117.044387,39.384119', 'district', '117.044387', '39.384119', 3, NULL, '022', '301700', 'Wuqing', 'W', NULL);
INSERT INTO `ez_area` VALUES (120115, '宝坻区', 120100, '117.309874,39.717564', 'district', '117.309874', '39.717564', 3, NULL, '022', '301800', 'Baodi', 'B', NULL);
INSERT INTO `ez_area` VALUES (120116, '滨海新区', 120100, '117.698407,39.01727', 'district', '117.698407', '39.01727', 3, NULL, '022', '300451', 'Binhaixinqu', 'B', NULL);
INSERT INTO `ez_area` VALUES (120117, '宁河区', 120100, '117.826724,39.330087', 'district', '117.826724', '39.330087', 3, NULL, '022', '301500', 'Ninghe', 'N', NULL);
INSERT INTO `ez_area` VALUES (120118, '静海区', 120100, '116.974232,38.94745', 'district', '116.974232', '38.94745', 3, NULL, '022', '301600', 'Jinghai', 'J', NULL);
INSERT INTO `ez_area` VALUES (120119, '蓟州区', 120100, '117.408296,40.045851', 'district', '117.408296', '40.045851', 3, NULL, '022', '301900', 'Jizhou', 'J', NULL);
INSERT INTO `ez_area` VALUES (130000, '河北省', 0, '114.530235,38.037433', 'province', '114.530235', '38.037433', 1, NULL, NULL, NULL, 'Hebei', 'H', NULL);
INSERT INTO `ez_area` VALUES (130100, '石家庄市', 130000, '114.514793,38.042228', 'city', '114.514793', '38.042228', 2, NULL, '0311', '050011', 'Shijiazhuang', 'S', NULL);
INSERT INTO `ez_area` VALUES (130102, '长安区', 130100, '114.539395,38.036347', 'district', '114.539395', '38.036347', 3, NULL, '0311', '050011', 'Chang\'an', 'C', NULL);
INSERT INTO `ez_area` VALUES (130104, '桥西区', 130100, '114.461088,38.004193', 'district', '114.461088', '38.004193', 3, NULL, '0311', '050091', 'Qiaoxi', 'Q', NULL);
INSERT INTO `ez_area` VALUES (130105, '新华区', 130100, '114.463377,38.05095', 'district', '114.463377', '38.05095', 3, NULL, '0311', '050051', 'Xinhua', 'X', NULL);
INSERT INTO `ez_area` VALUES (130107, '井陉矿区', 130100, '114.062062,38.065151', 'district', '114.062062', '38.065151', 3, NULL, '0311', '050100', 'Jingxingkuangqu', 'J', NULL);
INSERT INTO `ez_area` VALUES (130108, '裕华区', 130100, '114.531202,38.00643', 'district', '114.531202', '38.00643', 3, NULL, '0311', '050031', 'Yuhua', 'Y', NULL);
INSERT INTO `ez_area` VALUES (130109, '藁城区', 130100, '114.847023,38.021453', 'district', '114.847023', '38.021453', 3, NULL, '0311', '052160', 'Gaocheng', 'G', NULL);
INSERT INTO `ez_area` VALUES (130110, '鹿泉区', 130100, '114.313654,38.085953', 'district', '114.313654', '38.085953', 3, NULL, '0311', '050200', 'Luquan', 'L', NULL);
INSERT INTO `ez_area` VALUES (130111, '栾城区', 130100, '114.648318,37.900199', 'district', '114.648318', '37.900199', 3, NULL, '0311', '051430', 'Luancheng', 'L', NULL);
INSERT INTO `ez_area` VALUES (130121, '井陉县', 130100, '114.145242,38.032118', 'district', '114.145242', '38.032118', 3, NULL, '0311', '050300', 'Jingxing', 'J', NULL);
INSERT INTO `ez_area` VALUES (130123, '正定县', 130100, '114.570941,38.146444', 'district', '114.570941', '38.146444', 3, NULL, '0311', '050800', 'Zhengding', 'Z', NULL);
INSERT INTO `ez_area` VALUES (130125, '行唐县', 130100, '114.552714,38.438377', 'district', '114.552714', '38.438377', 3, NULL, '0311', '050600', 'Xingtang', 'X', NULL);
INSERT INTO `ez_area` VALUES (130126, '灵寿县', 130100, '114.382614,38.308665', 'district', '114.382614', '38.308665', 3, NULL, '0311', '050500', 'Lingshou', 'L', NULL);
INSERT INTO `ez_area` VALUES (130127, '高邑县', 130100, '114.611121,37.615534', 'district', '114.611121', '37.615534', 3, NULL, '0311', '051330', 'Gaoyi', 'G', NULL);
INSERT INTO `ez_area` VALUES (130128, '深泽县', 130100, '115.20092,38.184033', 'district', '115.20092', '38.184033', 3, NULL, '0311', '052560', 'Shenze', 'S', NULL);
INSERT INTO `ez_area` VALUES (130129, '赞皇县', 130100, '114.386111,37.665663', 'district', '114.386111', '37.665663', 3, NULL, '0311', '051230', 'Zanhuang', 'Z', NULL);
INSERT INTO `ez_area` VALUES (130130, '无极县', 130100, '114.97634,38.179192', 'district', '114.97634', '38.179192', 3, NULL, '0311', '052460', 'Wuji', 'W', NULL);
INSERT INTO `ez_area` VALUES (130131, '平山县', 130100, '114.195918,38.247888', 'district', '114.195918', '38.247888', 3, NULL, '0311', '050400', 'Pingshan', 'P', NULL);
INSERT INTO `ez_area` VALUES (130132, '元氏县', 130100, '114.525409,37.766513', 'district', '114.525409', '37.766513', 3, NULL, '0311', '051130', 'Yuanshi', 'Y', NULL);
INSERT INTO `ez_area` VALUES (130133, '赵县', 130100, '114.776297,37.756578', 'district', '114.776297', '37.756578', 3, NULL, '0311', '051530', 'Zhaoxian', 'Z', NULL);
INSERT INTO `ez_area` VALUES (130181, '辛集市', 130100, '115.217658,37.943121', 'district', '115.217658', '37.943121', 3, NULL, '0311', '052360', 'Xinji', 'X', NULL);
INSERT INTO `ez_area` VALUES (130183, '晋州市', 130100, '115.044213,38.033671', 'district', '115.044213', '38.033671', 3, NULL, '0311', '052260', 'Jinzhou', 'J', NULL);
INSERT INTO `ez_area` VALUES (130184, '新乐市', 130100, '114.683776,38.343319', 'district', '114.683776', '38.343319', 3, NULL, '0311', '050700', 'Xinle', 'X', NULL);
INSERT INTO `ez_area` VALUES (130200, '唐山市', 130000, '118.180193,39.630867', 'city', '118.180193', '39.630867', 2, NULL, '0315', '063000', 'Tangshan', 'T', NULL);
INSERT INTO `ez_area` VALUES (130202, '路南区', 130200, '118.154354,39.625058', 'district', '118.154354', '39.625058', 3, NULL, '0315', '063000', 'Lunan', 'L', NULL);
INSERT INTO `ez_area` VALUES (130203, '路北区', 130200, '118.200692,39.624437', 'district', '118.200692', '39.624437', 3, NULL, '0315', '063000', 'Lubei', 'L', NULL);
INSERT INTO `ez_area` VALUES (130204, '古冶区', 130200, '118.447635,39.733578', 'district', '118.447635', '39.733578', 3, NULL, '0315', '063100', 'Guye', 'G', NULL);
INSERT INTO `ez_area` VALUES (130205, '开平区', 130200, '118.261841,39.671001', 'district', '118.261841', '39.671001', 3, NULL, '0315', '063021', 'Kaiping', 'K', NULL);
INSERT INTO `ez_area` VALUES (130207, '丰南区', 130200, '118.085169,39.576031', 'district', '118.085169', '39.576031', 3, NULL, '0315', '063300', 'Fengnan', 'F', NULL);
INSERT INTO `ez_area` VALUES (130208, '丰润区', 130200, '118.162215,39.832582', 'district', '118.162215', '39.832582', 3, NULL, '0315', '064000', 'Fengrun', 'F', NULL);
INSERT INTO `ez_area` VALUES (130209, '曹妃甸区', 130200, '118.460379,39.27307', 'district', '118.460379', '39.27307', 3, NULL, '0315', '063200', 'Caofeidian', 'C', NULL);
INSERT INTO `ez_area` VALUES (130223, '滦县', 130200, '118.703598,39.740593', 'district', '118.703598', '39.740593', 3, NULL, '0315', '063700', 'Luanxian', 'L', NULL);
INSERT INTO `ez_area` VALUES (130224, '滦南县', 130200, '118.682379,39.518996', 'district', '118.682379', '39.518996', 3, NULL, '0315', '063500', 'Luannan', 'L', NULL);
INSERT INTO `ez_area` VALUES (130225, '乐亭县', 130200, '118.912571,39.425608', 'district', '118.912571', '39.425608', 3, NULL, '0315', '063600', 'Laoting', 'L', NULL);
INSERT INTO `ez_area` VALUES (130227, '迁西县', 130200, '118.314715,40.1415', 'district', '118.314715', '40.1415', 3, NULL, '0315', '064300', 'Qianxi', 'Q', NULL);
INSERT INTO `ez_area` VALUES (130229, '玉田县', 130200, '117.738658,39.900401', 'district', '117.738658', '39.900401', 3, NULL, '0315', '064100', 'Yutian', 'Y', NULL);
INSERT INTO `ez_area` VALUES (130281, '遵化市', 130200, '117.965892,40.189201', 'district', '117.965892', '40.189201', 3, NULL, '0315', '064200', 'Zunhua', 'Z', NULL);
INSERT INTO `ez_area` VALUES (130283, '迁安市', 130200, '118.701144,39.999174', 'district', '118.701144', '39.999174', 3, NULL, '0315', '064400', 'Qian\'an', 'Q', NULL);
INSERT INTO `ez_area` VALUES (130300, '秦皇岛市', 130000, '119.518197,39.888701', 'city', '119.518197', '39.888701', 2, NULL, '0335', '066000', 'Qinhuangdao', 'Q', NULL);
INSERT INTO `ez_area` VALUES (130302, '海港区', 130300, '119.564962,39.94756', 'district', '119.564962', '39.94756', 3, NULL, '0335', '066000', 'Haigang', 'H', NULL);
INSERT INTO `ez_area` VALUES (130303, '山海关区', 130300, '119.775799,39.978848', 'district', '119.775799', '39.978848', 3, NULL, '0335', '066200', 'Shanhaiguan', 'S', NULL);
INSERT INTO `ez_area` VALUES (130304, '北戴河区', 130300, '119.484522,39.834596', 'district', '119.484522', '39.834596', 3, NULL, '0335', '066100', 'Beidaihe', 'B', NULL);
INSERT INTO `ez_area` VALUES (130306, '抚宁区', 130300, '119.244847,39.876253', 'district', '119.244847', '39.876253', 3, NULL, '0335', '066300', 'Funing', 'F', NULL);
INSERT INTO `ez_area` VALUES (130321, '青龙满族自治县', 130300, '118.949684,40.407578', 'district', '118.949684', '40.407578', 3, NULL, '0335', '066500', 'Qinglong', 'Q', NULL);
INSERT INTO `ez_area` VALUES (130322, '昌黎县', 130300, '119.199551,39.700911', 'district', '119.199551', '39.700911', 3, NULL, '0335', '066600', 'Changli', 'C', NULL);
INSERT INTO `ez_area` VALUES (130324, '卢龙县', 130300, '118.892986,39.891946', 'district', '118.892986', '39.891946', 3, NULL, '0335', '066400', 'Lulong', 'L', NULL);
INSERT INTO `ez_area` VALUES (130400, '邯郸市', 130000, '114.538959,36.625594', 'city', '114.538959', '36.625594', 2, NULL, '0310', '056002', 'Handan', 'H', NULL);
INSERT INTO `ez_area` VALUES (130402, '邯山区', 130400, '114.531002,36.594313', 'district', '114.531002', '36.594313', 3, NULL, '0310', '056001', 'Hanshan', 'H', NULL);
INSERT INTO `ez_area` VALUES (130403, '丛台区', 130400, '114.492896,36.636409', 'district', '114.492896', '36.636409', 3, NULL, '0310', '056002', 'Congtai', 'C', NULL);
INSERT INTO `ez_area` VALUES (130404, '复兴区', 130400, '114.462061,36.639033', 'district', '114.462061', '36.639033', 3, NULL, '0310', '056003', 'Fuxing', 'F', NULL);
INSERT INTO `ez_area` VALUES (130406, '峰峰矿区', 130400, '114.212802,36.419739', 'district', '114.212802', '36.419739', 3, NULL, '0310', '056200', 'Fengfengkuangqu', 'F', NULL);
INSERT INTO `ez_area` VALUES (130407, '肥乡区', 130400, '114.800166,36.548131', 'district', '114.800166', '36.548131', 3, NULL, '0310', '057550', 'Feixiang', 'F', NULL);
INSERT INTO `ez_area` VALUES (130408, '永年区', 130400, '114.543832,36.743966', 'district', '114.543832', '36.743966', 3, NULL, '0310', '057150', 'Yongnian', 'Y', NULL);
INSERT INTO `ez_area` VALUES (130423, '临漳县', 130400, '114.619536,36.335025', 'district', '114.619536', '36.335025', 3, NULL, '0310', '056600', 'Linzhang', 'L', NULL);
INSERT INTO `ez_area` VALUES (130424, '成安县', 130400, '114.670032,36.444317', 'district', '114.670032', '36.444317', 3, NULL, '0310', '056700', 'Cheng\'an', 'C', NULL);
INSERT INTO `ez_area` VALUES (130425, '大名县', 130400, '115.147814,36.285616', 'district', '115.147814', '36.285616', 3, NULL, '0310', '056900', 'Daming', 'D', NULL);
INSERT INTO `ez_area` VALUES (130426, '涉县', 130400, '113.6914,36.584994', 'district', '113.6914', '36.584994', 3, NULL, '0310', '056400', 'Shexian', 'S', NULL);
INSERT INTO `ez_area` VALUES (130427, '磁县', 130400, '114.373946,36.374011', 'district', '114.373946', '36.374011', 3, NULL, '0310', '056500', 'Cixian', 'C', NULL);
INSERT INTO `ez_area` VALUES (130430, '邱县', 130400, '115.200589,36.811148', 'district', '115.200589', '36.811148', 3, NULL, '0310', '057450', 'Qiuxian', 'Q', NULL);
INSERT INTO `ez_area` VALUES (130431, '鸡泽县', 130400, '114.889376,36.91034', 'district', '114.889376', '36.91034', 3, NULL, '0310', '057350', 'Jize', 'J', NULL);
INSERT INTO `ez_area` VALUES (130432, '广平县', 130400, '114.948606,36.483484', 'district', '114.948606', '36.483484', 3, NULL, '0310', '057650', 'Guangping', 'G', NULL);
INSERT INTO `ez_area` VALUES (130433, '馆陶县', 130400, '115.282467,36.547556', 'district', '115.282467', '36.547556', 3, NULL, '0310', '057750', 'Guantao', 'G', NULL);
INSERT INTO `ez_area` VALUES (130434, '魏县', 130400, '114.93892,36.359868', 'district', '114.93892', '36.359868', 3, NULL, '0310', '056800', 'Weixian', 'W', NULL);
INSERT INTO `ez_area` VALUES (130435, '曲周县', 130400, '114.957504,36.76607', 'district', '114.957504', '36.76607', 3, NULL, '0310', '057250', 'Quzhou', 'Q', NULL);
INSERT INTO `ez_area` VALUES (130481, '武安市', 130400, '114.203697,36.696506', 'district', '114.203697', '36.696506', 3, NULL, '0310', '056300', 'Wu\'an', 'W', NULL);
INSERT INTO `ez_area` VALUES (130500, '邢台市', 130000, '114.504677,37.070834', 'city', '114.504677', '37.070834', 2, NULL, '0319', '054001', 'Xingtai', 'X', NULL);
INSERT INTO `ez_area` VALUES (130502, '桥东区', 130500, '114.507058,37.071287', 'district', '114.507058', '37.071287', 3, NULL, '0319', '054001', 'Qiaodong', 'Q', NULL);
INSERT INTO `ez_area` VALUES (130503, '桥西区', 130500, '114.468601,37.059827', 'district', '114.468601', '37.059827', 3, NULL, '0319', '054000', 'Qiaoxi', 'Q', NULL);
INSERT INTO `ez_area` VALUES (130521, '邢台县', 130500, '114.561132,37.05073', 'district', '114.561132', '37.05073', 3, NULL, '0319', '054001', 'Xingtai', 'X', NULL);
INSERT INTO `ez_area` VALUES (130522, '临城县', 130500, '114.498761,37.444498', 'district', '114.498761', '37.444498', 3, NULL, '0319', '054300', 'Lincheng', 'L', NULL);
INSERT INTO `ez_area` VALUES (130523, '内丘县', 130500, '114.512128,37.286669', 'district', '114.512128', '37.286669', 3, NULL, '0319', '054200', 'Neiqiu', 'N', NULL);
INSERT INTO `ez_area` VALUES (130524, '柏乡县', 130500, '114.693425,37.482422', 'district', '114.693425', '37.482422', 3, NULL, '0319', '055450', 'Baixiang', 'B', NULL);
INSERT INTO `ez_area` VALUES (130525, '隆尧县', 130500, '114.770419,37.350172', 'district', '114.770419', '37.350172', 3, NULL, '0319', '055350', 'Longyao', 'L', NULL);
INSERT INTO `ez_area` VALUES (130526, '任县', 130500, '114.671936,37.120982', 'district', '114.671936', '37.120982', 3, NULL, '0319', '055150', 'Renxian', 'R', NULL);
INSERT INTO `ez_area` VALUES (130527, '南和县', 130500, '114.683863,37.005017', 'district', '114.683863', '37.005017', 3, NULL, '0319', '054400', 'Nanhe', 'N', NULL);
INSERT INTO `ez_area` VALUES (130528, '宁晋县', 130500, '114.93992,37.624564', 'district', '114.93992', '37.624564', 3, NULL, '0319', '055550', 'Ningjin', 'N', NULL);
INSERT INTO `ez_area` VALUES (130529, '巨鹿县', 130500, '115.037477,37.221112', 'district', '115.037477', '37.221112', 3, NULL, '0319', '055250', 'Julu', 'J', NULL);
INSERT INTO `ez_area` VALUES (130530, '新河县', 130500, '115.250907,37.520862', 'district', '115.250907', '37.520862', 3, NULL, '0319', '055650', 'Xinhe', 'X', NULL);
INSERT INTO `ez_area` VALUES (130531, '广宗县', 130500, '115.142626,37.074661', 'district', '115.142626', '37.074661', 3, NULL, '0319', '054600', 'Guangzong', 'G', NULL);
INSERT INTO `ez_area` VALUES (130532, '平乡县', 130500, '115.030075,37.063148', 'district', '115.030075', '37.063148', 3, NULL, '0319', '054500', 'Pingxiang', 'P', NULL);
INSERT INTO `ez_area` VALUES (130533, '威县', 130500, '115.266703,36.975478', 'district', '115.266703', '36.975478', 3, NULL, '0319', '054700', 'Weixian', 'W', NULL);
INSERT INTO `ez_area` VALUES (130534, '清河县', 130500, '115.667208,37.039991', 'district', '115.667208', '37.039991', 3, NULL, '0319', '054800', 'Qinghe', 'Q', NULL);
INSERT INTO `ez_area` VALUES (130535, '临西县', 130500, '115.501048,36.870811', 'district', '115.501048', '36.870811', 3, NULL, '0319', '054900', 'Linxi', 'L', NULL);
INSERT INTO `ez_area` VALUES (130581, '南宫市', 130500, '115.408747,37.359264', 'district', '115.408747', '37.359264', 3, NULL, '0319', '055750', 'Nangong', 'N', NULL);
INSERT INTO `ez_area` VALUES (130582, '沙河市', 130500, '114.503339,36.854929', 'district', '114.503339', '36.854929', 3, NULL, '0319', '054100', 'Shahe', 'S', NULL);
INSERT INTO `ez_area` VALUES (130600, '保定市', 130000, '115.464589,38.874434', 'city', '115.464589', '38.874434', 2, NULL, '0312', '071052', 'Baoding', 'B', NULL);
INSERT INTO `ez_area` VALUES (130602, '竞秀区', 130600, '115.45877,38.877449', 'district', '115.45877', '38.877449', 3, NULL, '0312', '071051', 'Xinshi', 'X', NULL);
INSERT INTO `ez_area` VALUES (130606, '莲池区', 130600, '115.497097,38.883582', 'district', '115.497097', '38.883582', 3, NULL, '0312', '071000', 'Lianchi', 'L', NULL);
INSERT INTO `ez_area` VALUES (130607, '满城区', 130600, '115.322334,38.949119', 'district', '115.322334', '38.949119', 3, NULL, '0312', '072150', 'Mancheng', 'M', NULL);
INSERT INTO `ez_area` VALUES (130608, '清苑区', 130600, '115.489959,38.765148', 'district', '115.489959', '38.765148', 3, NULL, '0312', '071100', 'Qingyuan', 'Q', NULL);
INSERT INTO `ez_area` VALUES (130609, '徐水区', 130600, '115.655774,39.018736', 'district', '115.655774', '39.018736', 3, NULL, '0312', '072550', 'Xushui', 'X', NULL);
INSERT INTO `ez_area` VALUES (130623, '涞水县', 130600, '115.713904,39.394316', 'district', '115.713904', '39.394316', 3, NULL, '0312', '074100', 'Laishui', 'L', NULL);
INSERT INTO `ez_area` VALUES (130624, '阜平县', 130600, '114.195104,38.849152', 'district', '114.195104', '38.849152', 3, NULL, '0312', '073200', 'Fuping', 'F', NULL);
INSERT INTO `ez_area` VALUES (130626, '定兴县', 130600, '115.808296,39.263145', 'district', '115.808296', '39.263145', 3, NULL, '0312', '072650', 'Dingxing', 'D', NULL);
INSERT INTO `ez_area` VALUES (130627, '唐县', 130600, '114.982972,38.748203', 'district', '114.982972', '38.748203', 3, NULL, '0312', '072350', 'Tangxian', 'T', NULL);
INSERT INTO `ez_area` VALUES (130628, '高阳县', 130600, '115.778965,38.700088', 'district', '115.778965', '38.700088', 3, NULL, '0312', '071500', 'Gaoyang', 'G', NULL);
INSERT INTO `ez_area` VALUES (130629, '容城县', 130600, '115.861657,39.042784', 'district', '115.861657', '39.042784', 3, NULL, '0312', '071700', 'Rongcheng', 'R', NULL);
INSERT INTO `ez_area` VALUES (130630, '涞源县', 130600, '114.694283,39.360247', 'district', '114.694283', '39.360247', 3, NULL, '0312', '074300', 'Laiyuan', 'L', NULL);
INSERT INTO `ez_area` VALUES (130631, '望都县', 130600, '115.155128,38.695842', 'district', '115.155128', '38.695842', 3, NULL, '0312', '072450', 'Wangdu', 'W', NULL);
INSERT INTO `ez_area` VALUES (130632, '安新县', 130600, '115.935603,38.935369', 'district', '115.935603', '38.935369', 3, NULL, '0312', '071600', 'Anxin', 'A', NULL);
INSERT INTO `ez_area` VALUES (130633, '易县', 130600, '115.497457,39.349393', 'district', '115.497457', '39.349393', 3, NULL, '0312', '074200', 'Yixian', 'Y', NULL);
INSERT INTO `ez_area` VALUES (130634, '曲阳县', 130600, '114.745008,38.622248', 'district', '114.745008', '38.622248', 3, NULL, '0312', '073100', 'Quyang', 'Q', NULL);
INSERT INTO `ez_area` VALUES (130635, '蠡县', 130600, '115.583854,38.488055', 'district', '115.583854', '38.488055', 3, NULL, '0312', '071400', 'Lixian', 'L', NULL);
INSERT INTO `ez_area` VALUES (130636, '顺平县', 130600, '115.13547,38.837487', 'district', '115.13547', '38.837487', 3, NULL, '0312', '072250', 'Shunping', 'S', NULL);
INSERT INTO `ez_area` VALUES (130637, '博野县', 130600, '115.46438,38.457364', 'district', '115.46438', '38.457364', 3, NULL, '0312', '071300', 'Boye', 'B', NULL);
INSERT INTO `ez_area` VALUES (130638, '雄县', 130600, '116.10865,38.99455', 'district', '116.10865', '38.99455', 3, NULL, '0312', '071800', 'Xiongxian', 'X', NULL);
INSERT INTO `ez_area` VALUES (130681, '涿州市', 130600, '115.974422,39.485282', 'district', '115.974422', '39.485282', 3, NULL, '0312', '072750', 'Zhuozhou', 'Z', NULL);
INSERT INTO `ez_area` VALUES (130682, '定州市', 130600, '114.990392,38.516461', 'district', '114.990392', '38.516461', 3, NULL, '0312', '073000', 'Dingzhou', 'D', NULL);
INSERT INTO `ez_area` VALUES (130683, '安国市', 130600, '115.326646,38.418439', 'district', '115.326646', '38.418439', 3, NULL, '0312', '071200', 'Anguo', 'A', NULL);
INSERT INTO `ez_area` VALUES (130684, '高碑店市', 130600, '115.873886,39.326839', 'district', '115.873886', '39.326839', 3, NULL, '0312', '074000', 'Gaobeidian', 'G', NULL);
INSERT INTO `ez_area` VALUES (130700, '张家口市', 130000, '114.886252,40.768493', 'city', '114.886252', '40.768493', 2, NULL, '0313', '075000', 'Zhangjiakou', 'Z', NULL);
INSERT INTO `ez_area` VALUES (130702, '桥东区', 130700, '114.894189,40.788434', 'district', '114.894189', '40.788434', 3, NULL, '0313', '075000', 'Qiaodong', 'Q', NULL);
INSERT INTO `ez_area` VALUES (130703, '桥西区', 130700, '114.869657,40.819581', 'district', '114.869657', '40.819581', 3, NULL, '0313', '075061', 'Qiaoxi', 'Q', NULL);
INSERT INTO `ez_area` VALUES (130705, '宣化区', 130700, '115.099494,40.608793', 'district', '115.099494', '40.608793', 3, NULL, '0313', '075100', 'Xuanhua', 'X', NULL);
INSERT INTO `ez_area` VALUES (130706, '下花园区', 130700, '115.287352,40.502652', 'district', '115.287352', '40.502652', 3, NULL, '0313', '075300', 'Xiahuayuan', 'X', NULL);
INSERT INTO `ez_area` VALUES (130708, '万全区', 130700, '114.740557,40.766965', 'district', '114.740557', '40.766965', 3, NULL, '0313', '076250', 'Wanquan', 'W', NULL);
INSERT INTO `ez_area` VALUES (130709, '崇礼区', 130700, '115.282668,40.974675', 'district', '115.282668', '40.974675', 3, NULL, '0313', '076350', 'Chongli', 'C', NULL);
INSERT INTO `ez_area` VALUES (130722, '张北县', 130700, '114.720077,41.158596', 'district', '114.720077', '41.158596', 3, NULL, '0313', '076450', 'Zhangbei', 'Z', NULL);
INSERT INTO `ez_area` VALUES (130723, '康保县', 130700, '114.600404,41.852368', 'district', '114.600404', '41.852368', 3, NULL, '0313', '076650', 'Kangbao', 'K', NULL);
INSERT INTO `ez_area` VALUES (130724, '沽源县', 130700, '115.688692,41.669668', 'district', '115.688692', '41.669668', 3, NULL, '0313', '076550', 'Guyuan', 'G', NULL);
INSERT INTO `ez_area` VALUES (130725, '尚义县', 130700, '113.969618,41.076226', 'district', '113.969618', '41.076226', 3, NULL, '0313', '076750', 'Shangyi', 'S', NULL);
INSERT INTO `ez_area` VALUES (130726, '蔚县', 130700, '114.588903,39.840842', 'district', '114.588903', '39.840842', 3, NULL, '0313', '075700', 'Yuxian', 'Y', NULL);
INSERT INTO `ez_area` VALUES (130727, '阳原县', 130700, '114.150348,40.104663', 'district', '114.150348', '40.104663', 3, NULL, '0313', '075800', 'Yangyuan', 'Y', NULL);
INSERT INTO `ez_area` VALUES (130728, '怀安县', 130700, '114.385791,40.674193', 'district', '114.385791', '40.674193', 3, NULL, '0313', '076150', 'Huai\'an', 'H', NULL);
INSERT INTO `ez_area` VALUES (130730, '怀来县', 130700, '115.517861,40.415343', 'district', '115.517861', '40.415343', 3, NULL, '0313', '075400', 'Huailai', 'H', NULL);
INSERT INTO `ez_area` VALUES (130731, '涿鹿县', 130700, '115.205345,40.379562', 'district', '115.205345', '40.379562', 3, NULL, '0313', '075600', 'Zhuolu', 'Z', NULL);
INSERT INTO `ez_area` VALUES (130732, '赤城县', 130700, '115.831498,40.912921', 'district', '115.831498', '40.912921', 3, NULL, '0313', '075500', 'Chicheng', 'C', NULL);
INSERT INTO `ez_area` VALUES (130800, '承德市', 130000, '117.962749,40.952942', 'city', '117.962749', '40.952942', 2, NULL, '0314', '067000', 'Chengde', 'C', NULL);
INSERT INTO `ez_area` VALUES (130802, '双桥区', 130800, '117.943466,40.974643', 'district', '117.943466', '40.974643', 3, NULL, '0314', '067000', 'Shuangqiao', 'S', NULL);
INSERT INTO `ez_area` VALUES (130803, '双滦区', 130800, '117.799888,40.959236', 'district', '117.799888', '40.959236', 3, NULL, '0314', '067001', 'Shuangluan', 'S', NULL);
INSERT INTO `ez_area` VALUES (130804, '鹰手营子矿区', 130800, '117.659499,40.546361', 'district', '117.659499', '40.546361', 3, NULL, '0314', '067200', 'Yingshouyingzikuangqu', 'Y', NULL);
INSERT INTO `ez_area` VALUES (130821, '承德县', 130800, '118.173824,40.768238', 'district', '118.173824', '40.768238', 3, NULL, '0314', '067400', 'Chengde', 'C', NULL);
INSERT INTO `ez_area` VALUES (130822, '兴隆县', 130800, '117.500558,40.417358', 'district', '117.500558', '40.417358', 3, NULL, '0314', '067300', 'Xinglong', 'X', NULL);
INSERT INTO `ez_area` VALUES (130824, '滦平县', 130800, '117.332801,40.941482', 'district', '117.332801', '40.941482', 3, NULL, '0314', '068250', 'Luanping', 'L', NULL);
INSERT INTO `ez_area` VALUES (130825, '隆化县', 130800, '117.738937,41.313791', 'district', '117.738937', '41.313791', 3, NULL, '0314', '068150', 'Longhua', 'L', NULL);
INSERT INTO `ez_area` VALUES (130826, '丰宁满族自治县', 130800, '116.646051,41.209069', 'district', '116.646051', '41.209069', 3, NULL, '0314', '068350', 'Fengning', 'F', NULL);
INSERT INTO `ez_area` VALUES (130827, '宽城满族自治县', 130800, '118.485313,40.611391', 'district', '118.485313', '40.611391', 3, NULL, '0314', '067600', 'Kuancheng', 'K', NULL);
INSERT INTO `ez_area` VALUES (130828, '围场满族蒙古族自治县', 130800, '117.760159,41.938529', 'district', '117.760159', '41.938529', 3, NULL, '0314', '068450', 'Weichang', 'W', NULL);
INSERT INTO `ez_area` VALUES (130881, '平泉市', 130800, '118.701951,41.018405', 'district', '118.701951', '41.018405', 3, NULL, '0314', '067500', 'Pingquan', 'P', NULL);
INSERT INTO `ez_area` VALUES (130900, '沧州市', 130000, '116.838834,38.304477', 'city', '116.838834', '38.304477', 2, NULL, '0317', '061001', 'Cangzhou', 'C', NULL);
INSERT INTO `ez_area` VALUES (130902, '新华区', 130900, '116.866284,38.314416', 'district', '116.866284', '38.314416', 3, NULL, '0317', '061000', 'Xinhua', 'X', NULL);
INSERT INTO `ez_area` VALUES (130903, '运河区', 130900, '116.843673,38.283749', 'district', '116.843673', '38.283749', 3, NULL, '0317', '061001', 'Yunhe', 'Y', NULL);
INSERT INTO `ez_area` VALUES (130921, '沧县', 130900, '117.007478,38.219856', 'district', '117.007478', '38.219856', 3, NULL, '0317', '061000', 'Cangxian', 'C', NULL);
INSERT INTO `ez_area` VALUES (130922, '青县', 130900, '116.804305,38.583021', 'district', '116.804305', '38.583021', 3, NULL, '0317', '062650', 'Qingxian', 'Q', NULL);
INSERT INTO `ez_area` VALUES (130923, '东光县', 130900, '116.537067,37.888248', 'district', '116.537067', '37.888248', 3, NULL, '0317', '061600', 'Dongguang', 'D', NULL);
INSERT INTO `ez_area` VALUES (130924, '海兴县', 130900, '117.497651,38.143169', 'district', '117.497651', '38.143169', 3, NULL, '0317', '061200', 'Haixing', 'H', NULL);
INSERT INTO `ez_area` VALUES (130925, '盐山县', 130900, '117.230602,38.058087', 'district', '117.230602', '38.058087', 3, NULL, '0317', '061300', 'Yanshan', 'Y', NULL);
INSERT INTO `ez_area` VALUES (130926, '肃宁县', 130900, '115.829758,38.422801', 'district', '115.829758', '38.422801', 3, NULL, '0317', '062350', 'Suning', 'S', NULL);
INSERT INTO `ez_area` VALUES (130927, '南皮县', 130900, '116.708347,38.038421', 'district', '116.708347', '38.038421', 3, NULL, '0317', '061500', 'Nanpi', 'N', NULL);
INSERT INTO `ez_area` VALUES (130928, '吴桥县', 130900, '116.391508,37.627661', 'district', '116.391508', '37.627661', 3, NULL, '0317', '061800', 'Wuqiao', 'W', NULL);
INSERT INTO `ez_area` VALUES (130929, '献县', 130900, '116.122725,38.190185', 'district', '116.122725', '38.190185', 3, NULL, '0317', '062250', 'Xianxian', 'X', NULL);
INSERT INTO `ez_area` VALUES (130930, '孟村回族自治县', 130900, '117.104298,38.053409', 'district', '117.104298', '38.053409', 3, NULL, '0317', '061400', 'Mengcun', 'M', NULL);
INSERT INTO `ez_area` VALUES (130981, '泊头市', 130900, '116.578367,38.083437', 'district', '116.578367', '38.083437', 3, NULL, '0317', '062150', 'Botou', 'B', NULL);
INSERT INTO `ez_area` VALUES (130982, '任丘市', 130900, '116.082917,38.683591', 'district', '116.082917', '38.683591', 3, NULL, '0317', '062550', 'Renqiu', 'R', NULL);
INSERT INTO `ez_area` VALUES (130983, '黄骅市', 130900, '117.329949,38.371402', 'district', '117.329949', '38.371402', 3, NULL, '0317', '061100', 'Huanghua', 'H', NULL);
INSERT INTO `ez_area` VALUES (130984, '河间市', 130900, '116.099517,38.446624', 'district', '116.099517', '38.446624', 3, NULL, '0317', '062450', 'Hejian', 'H', NULL);
INSERT INTO `ez_area` VALUES (131000, '廊坊市', 130000, '116.683752,39.538047', 'city', '116.683752', '39.538047', 2, NULL, '0316', '065000', 'Langfang', 'L', NULL);
INSERT INTO `ez_area` VALUES (131002, '安次区', 131000, '116.694544,39.502569', 'district', '116.694544', '39.502569', 3, NULL, '0316', '065000', 'Anci', 'A', NULL);
INSERT INTO `ez_area` VALUES (131003, '广阳区', 131000, '116.71069,39.522786', 'district', '116.71069', '39.522786', 3, NULL, '0316', '065000', 'Guangyang', 'G', NULL);
INSERT INTO `ez_area` VALUES (131022, '固安县', 131000, '116.298657,39.438214', 'district', '116.298657', '39.438214', 3, NULL, '0316', '065500', 'Gu\'an', 'G', NULL);
INSERT INTO `ez_area` VALUES (131023, '永清县', 131000, '116.50568,39.330689', 'district', '116.50568', '39.330689', 3, NULL, '0316', '065600', 'Yongqing', 'Y', NULL);
INSERT INTO `ez_area` VALUES (131024, '香河县', 131000, '117.006093,39.761424', 'district', '117.006093', '39.761424', 3, NULL, '0316', '065400', 'Xianghe', 'X', NULL);
INSERT INTO `ez_area` VALUES (131025, '大城县', 131000, '116.653793,38.705449', 'district', '116.653793', '38.705449', 3, NULL, '0316', '065900', 'Daicheng', 'D', NULL);
INSERT INTO `ez_area` VALUES (131026, '文安县', 131000, '116.457898,38.87292', 'district', '116.457898', '38.87292', 3, NULL, '0316', '065800', 'Wen\'an', 'W', NULL);
INSERT INTO `ez_area` VALUES (131028, '大厂回族自治县', 131000, '116.989574,39.886547', 'district', '116.989574', '39.886547', 3, NULL, '0316', '065300', 'Dachang', 'D', NULL);
INSERT INTO `ez_area` VALUES (131081, '霸州市', 131000, '116.391484,39.125744', 'district', '116.391484', '39.125744', 3, NULL, '0316', '065700', 'Bazhou', 'B', NULL);
INSERT INTO `ez_area` VALUES (131082, '三河市', 131000, '117.078294,39.982718', 'district', '117.078294', '39.982718', 3, NULL, '0316', '065200', 'Sanhe', 'S', NULL);
INSERT INTO `ez_area` VALUES (131100, '衡水市', 130000, '115.670177,37.73892', 'city', '115.670177', '37.73892', 2, NULL, '0318', '053000', 'Hengshui', 'H', NULL);
INSERT INTO `ez_area` VALUES (131102, '桃城区', 131100, '115.67545,37.735465', 'district', '115.67545', '37.735465', 3, NULL, '0318', '053000', 'Taocheng', 'T', NULL);
INSERT INTO `ez_area` VALUES (131103, '冀州区', 131100, '115.579308,37.550856', 'district', '115.579308', '37.550856', 3, NULL, '0318', '053200', 'Jizhou', 'J', NULL);
INSERT INTO `ez_area` VALUES (131121, '枣强县', 131100, '115.724259,37.513417', 'district', '115.724259', '37.513417', 3, NULL, '0318', '053100', 'Zaoqiang', 'Z', NULL);
INSERT INTO `ez_area` VALUES (131122, '武邑县', 131100, '115.887531,37.801665', 'district', '115.887531', '37.801665', 3, NULL, '0318', '053400', 'Wuyi', 'W', NULL);
INSERT INTO `ez_area` VALUES (131123, '武强县', 131100, '115.982461,38.041368', 'district', '115.982461', '38.041368', 3, NULL, '0318', '053300', 'Wuqiang', 'W', NULL);
INSERT INTO `ez_area` VALUES (131124, '饶阳县', 131100, '115.725833,38.235892', 'district', '115.725833', '38.235892', 3, NULL, '0318', '053900', 'Raoyang', 'R', NULL);
INSERT INTO `ez_area` VALUES (131125, '安平县', 131100, '115.519278,38.234501', 'district', '115.519278', '38.234501', 3, NULL, '0318', '053600', 'Anping', 'A', NULL);
INSERT INTO `ez_area` VALUES (131126, '故城县', 131100, '115.965874,37.347409', 'district', '115.965874', '37.347409', 3, NULL, '0318', '053800', 'Gucheng', 'G', NULL);
INSERT INTO `ez_area` VALUES (131127, '景县', 131100, '116.270648,37.69229', 'district', '116.270648', '37.69229', 3, NULL, '0318', '053500', 'Jingxian', 'J', NULL);
INSERT INTO `ez_area` VALUES (131128, '阜城县', 131100, '116.175262,37.862505', 'district', '116.175262', '37.862505', 3, NULL, '0318', '053700', 'Fucheng', 'F', NULL);
INSERT INTO `ez_area` VALUES (131182, '深州市', 131100, '115.559574,38.001535', 'district', '115.559574', '38.001535', 3, NULL, '0318', '053800', 'Shenzhou', 'S', NULL);
INSERT INTO `ez_area` VALUES (140000, '山西省', 0, '112.562678,37.873499', 'province', '112.562678', '37.873499', 1, NULL, NULL, NULL, 'Shanxi', 'S', NULL);
INSERT INTO `ez_area` VALUES (140100, '太原市', 140000, '112.548879,37.87059', 'city', '112.548879', '37.87059', 2, NULL, '0351', '030082', 'Taiyuan', 'T', NULL);
INSERT INTO `ez_area` VALUES (140105, '小店区', 140100, '112.565659,37.736525', 'district', '112.565659', '37.736525', 3, NULL, '0351', '030032', 'Xiaodian', 'X', NULL);
INSERT INTO `ez_area` VALUES (140106, '迎泽区', 140100, '112.5634,37.863451', 'district', '112.5634', '37.863451', 3, NULL, '0351', '030002', 'Yingze', 'Y', NULL);
INSERT INTO `ez_area` VALUES (140107, '杏花岭区', 140100, '112.570604,37.893955', 'district', '112.570604', '37.893955', 3, NULL, '0351', '030009', 'Xinghualing', 'X', NULL);
INSERT INTO `ez_area` VALUES (140108, '尖草坪区', 140100, '112.486691,37.940387', 'district', '112.486691', '37.940387', 3, NULL, '0351', '030023', 'Jiancaoping', 'J', NULL);
INSERT INTO `ez_area` VALUES (140109, '万柏林区', 140100, '112.515937,37.85958', 'district', '112.515937', '37.85958', 3, NULL, '0351', '030024', 'Wanbailin', 'W', NULL);
INSERT INTO `ez_area` VALUES (140110, '晋源区', 140100, '112.47794,37.715193', 'district', '112.47794', '37.715193', 3, NULL, '0351', '030025', 'Jinyuan', 'J', NULL);
INSERT INTO `ez_area` VALUES (140121, '清徐县', 140100, '112.358667,37.607443', 'district', '112.358667', '37.607443', 3, NULL, '0351', '030400', 'Qingxu', 'Q', NULL);
INSERT INTO `ez_area` VALUES (140122, '阳曲县', 140100, '112.672952,38.058488', 'district', '112.672952', '38.058488', 3, NULL, '0351', '030100', 'Yangqu', 'Y', NULL);
INSERT INTO `ez_area` VALUES (140123, '娄烦县', 140100, '111.797083,38.067932', 'district', '111.797083', '38.067932', 3, NULL, '0351', '030300', 'Loufan', 'L', NULL);
INSERT INTO `ez_area` VALUES (140181, '古交市', 140100, '112.175853,37.907129', 'district', '112.175853', '37.907129', 3, NULL, '0351', '030200', 'Gujiao', 'G', NULL);
INSERT INTO `ez_area` VALUES (140200, '大同市', 140000, '113.300129,40.076763', 'city', '113.300129', '40.076763', 2, NULL, '0352', '037008', 'Datong', 'D', NULL);
INSERT INTO `ez_area` VALUES (140202, '城区', 140200, '113.298026,40.075666', 'district', '113.298026', '40.075666', 3, NULL, '0352', '037008', 'Chengqu', 'C', NULL);
INSERT INTO `ez_area` VALUES (140203, '矿区', 140200, '113.177206,40.036858', 'district', '113.177206', '40.036858', 3, NULL, '0352', '037003', 'Kuangqu', 'K', NULL);
INSERT INTO `ez_area` VALUES (140211, '南郊区', 140200, '113.149693,40.005404', 'district', '113.149693', '40.005404', 3, NULL, '0352', '037001', 'Nanjiao', 'N', NULL);
INSERT INTO `ez_area` VALUES (140212, '新荣区', 140200, '113.140004,40.255866', 'district', '113.140004', '40.255866', 3, NULL, '0352', '037002', 'Xinrong', 'X', NULL);
INSERT INTO `ez_area` VALUES (140221, '阳高县', 140200, '113.748944,40.361059', 'district', '113.748944', '40.361059', 3, NULL, '0352', '038100', 'Yanggao', 'Y', NULL);
INSERT INTO `ez_area` VALUES (140222, '天镇县', 140200, '114.090867,40.420237', 'district', '114.090867', '40.420237', 3, NULL, '0352', '038200', 'Tianzhen', 'T', NULL);
INSERT INTO `ez_area` VALUES (140223, '广灵县', 140200, '114.282758,39.760281', 'district', '114.282758', '39.760281', 3, NULL, '0352', '037500', 'Guangling', 'G', NULL);
INSERT INTO `ez_area` VALUES (140224, '灵丘县', 140200, '114.23435,39.442406', 'district', '114.23435', '39.442406', 3, NULL, '0352', '034400', 'Lingqiu', 'L', NULL);
INSERT INTO `ez_area` VALUES (140225, '浑源县', 140200, '113.699475,39.693406', 'district', '113.699475', '39.693406', 3, NULL, '0352', '037400', 'Hunyuan', 'H', NULL);
INSERT INTO `ez_area` VALUES (140226, '左云县', 140200, '112.703008,40.013442', 'district', '112.703008', '40.013442', 3, NULL, '0352', '037100', 'Zuoyun', 'Z', NULL);
INSERT INTO `ez_area` VALUES (140227, '大同县', 140200, '113.61244,40.040294', 'district', '113.61244', '40.040294', 3, NULL, '0352', '037300', 'Datong', 'D', NULL);
INSERT INTO `ez_area` VALUES (140300, '阳泉市', 140000, '113.580519,37.856971', 'city', '113.580519', '37.856971', 2, NULL, '0353', '045000', 'Yangquan', 'Y', NULL);
INSERT INTO `ez_area` VALUES (140302, '城区', 140300, '113.600669,37.847436', 'district', '113.600669', '37.847436', 3, NULL, '0353', '045000', 'Chengqu', 'C', NULL);
INSERT INTO `ez_area` VALUES (140303, '矿区', 140300, '113.555279,37.868494', 'district', '113.555279', '37.868494', 3, NULL, '0353', '045000', 'Kuangqu', 'K', NULL);
INSERT INTO `ez_area` VALUES (140311, '郊区', 140300, '113.594163,37.944679', 'district', '113.594163', '37.944679', 3, NULL, '0353', '045011', 'Jiaoqu', 'J', NULL);
INSERT INTO `ez_area` VALUES (140321, '平定县', 140300, '113.630107,37.804988', 'district', '113.630107', '37.804988', 3, NULL, '0353', '045200', 'Pingding', 'P', NULL);
INSERT INTO `ez_area` VALUES (140322, '盂县', 140300, '113.41233,38.085619', 'district', '113.41233', '38.085619', 3, NULL, '0353', '045100', 'Yuxian', 'Y', NULL);
INSERT INTO `ez_area` VALUES (140400, '长治市', 140000, '113.116404,36.195409', 'city', '113.116404', '36.195409', 2, NULL, '0355', '046000', 'Changzhi', 'C', NULL);
INSERT INTO `ez_area` VALUES (140402, '城区', 140400, '113.123088,36.20353', 'district', '113.123088', '36.20353', 3, NULL, '0355', '046011', 'Chengqu', 'C', NULL);
INSERT INTO `ez_area` VALUES (140411, '郊区', 140400, '113.101211,36.218388', 'district', '113.101211', '36.218388', 3, NULL, '0355', '046011', 'Jiaoqu', 'J', NULL);
INSERT INTO `ez_area` VALUES (140421, '长治县', 140400, '113.051407,36.052858', 'district', '113.051407', '36.052858', 3, NULL, '0355', '047100', 'Changzhi', 'C', NULL);
INSERT INTO `ez_area` VALUES (140423, '襄垣县', 140400, '113.051491,36.535817', 'district', '113.051491', '36.535817', 3, NULL, '0355', '046200', 'Xiangyuan', 'X', NULL);
INSERT INTO `ez_area` VALUES (140424, '屯留县', 140400, '112.891998,36.315663', 'district', '112.891998', '36.315663', 3, NULL, '0355', '046100', 'Tunliu', 'T', NULL);
INSERT INTO `ez_area` VALUES (140425, '平顺县', 140400, '113.435961,36.200179', 'district', '113.435961', '36.200179', 3, NULL, '0355', '047400', 'Pingshun', 'P', NULL);
INSERT INTO `ez_area` VALUES (140426, '黎城县', 140400, '113.387155,36.502328', 'district', '113.387155', '36.502328', 3, NULL, '0355', '047600', 'Licheng', 'L', NULL);
INSERT INTO `ez_area` VALUES (140427, '壶关县', 140400, '113.207049,36.115448', 'district', '113.207049', '36.115448', 3, NULL, '0355', '047300', 'Huguan', 'H', NULL);
INSERT INTO `ez_area` VALUES (140428, '长子县', 140400, '112.8779,36.122334', 'district', '112.8779', '36.122334', 3, NULL, '0355', '046600', 'Zhangzi', 'Z', NULL);
INSERT INTO `ez_area` VALUES (140429, '武乡县', 140400, '112.864561,36.837625', 'district', '112.864561', '36.837625', 3, NULL, '0355', '046300', 'Wuxiang', 'W', NULL);
INSERT INTO `ez_area` VALUES (140430, '沁县', 140400, '112.699226,36.756063', 'district', '112.699226', '36.756063', 3, NULL, '0355', '046400', 'Qinxian', 'Q', NULL);
INSERT INTO `ez_area` VALUES (140431, '沁源县', 140400, '112.337446,36.5002', 'district', '112.337446', '36.5002', 3, NULL, '0355', '046500', 'Qinyuan', 'Q', NULL);
INSERT INTO `ez_area` VALUES (140481, '潞城市', 140400, '113.228852,36.334104', 'district', '113.228852', '36.334104', 3, NULL, '0355', '047500', 'Lucheng', 'L', NULL);
INSERT INTO `ez_area` VALUES (140500, '晋城市', 140000, '112.851486,35.490684', 'city', '112.851486', '35.490684', 2, NULL, '0356', '048000', 'Jincheng', 'J', NULL);
INSERT INTO `ez_area` VALUES (140502, '城区', 140500, '112.853555,35.501571', 'district', '112.853555', '35.501571', 3, NULL, '0356', '048000', 'Chengqu', 'C', NULL);
INSERT INTO `ez_area` VALUES (140521, '沁水县', 140500, '112.186738,35.690141', 'district', '112.186738', '35.690141', 3, NULL, '0356', '048200', 'Qinshui', 'Q', NULL);
INSERT INTO `ez_area` VALUES (140522, '阳城县', 140500, '112.414738,35.486029', 'district', '112.414738', '35.486029', 3, NULL, '0356', '048100', 'Yangcheng', 'Y', NULL);
INSERT INTO `ez_area` VALUES (140524, '陵川县', 140500, '113.280688,35.775685', 'district', '113.280688', '35.775685', 3, NULL, '0356', '048300', 'Lingchuan', 'L', NULL);
INSERT INTO `ez_area` VALUES (140525, '泽州县', 140500, '112.899137,35.617221', 'district', '112.899137', '35.617221', 3, NULL, '0356', '048012', 'Zezhou', 'Z', NULL);
INSERT INTO `ez_area` VALUES (140581, '高平市', 140500, '112.92392,35.797997', 'district', '112.92392', '35.797997', 3, NULL, '0356', '048400', 'Gaoping', 'G', NULL);
INSERT INTO `ez_area` VALUES (140600, '朔州市', 140000, '112.432991,39.331855', 'city', '112.432991', '39.331855', 2, NULL, '0349', '038500', 'Shuozhou', 'S', NULL);
INSERT INTO `ez_area` VALUES (140602, '朔城区', 140600, '112.432312,39.319519', 'district', '112.432312', '39.319519', 3, NULL, '0349', '036000', 'Shuocheng', 'S', NULL);
INSERT INTO `ez_area` VALUES (140603, '平鲁区', 140600, '112.28833,39.512155', 'district', '112.28833', '39.512155', 3, NULL, '0349', '038600', 'Pinglu', 'P', NULL);
INSERT INTO `ez_area` VALUES (140621, '山阴县', 140600, '112.816413,39.527893', 'district', '112.816413', '39.527893', 3, NULL, '0349', '036900', 'Shanyin', 'S', NULL);
INSERT INTO `ez_area` VALUES (140622, '应县', 140600, '113.191098,39.554247', 'district', '113.191098', '39.554247', 3, NULL, '0349', '037600', 'Yingxian', 'Y', NULL);
INSERT INTO `ez_area` VALUES (140623, '右玉县', 140600, '112.466989,39.989063', 'district', '112.466989', '39.989063', 3, NULL, '0349', '037200', 'Youyu', 'Y', NULL);
INSERT INTO `ez_area` VALUES (140624, '怀仁县', 140600, '113.131717,39.821627', 'district', '113.131717', '39.821627', 3, NULL, '0349', '038300', 'Huairen', 'H', NULL);
INSERT INTO `ez_area` VALUES (140700, '晋中市', 140000, '112.752652,37.687357', 'city', '112.752652', '37.687357', 2, NULL, '0354', '030600', 'Jinzhong', 'J', NULL);
INSERT INTO `ez_area` VALUES (140702, '榆次区', 140700, '112.708224,37.697794', 'district', '112.708224', '37.697794', 3, NULL, '0354', '030600', 'Yuci', 'Y', NULL);
INSERT INTO `ez_area` VALUES (140721, '榆社县', 140700, '112.975209,37.070916', 'district', '112.975209', '37.070916', 3, NULL, '0354', '031800', 'Yushe', 'Y', NULL);
INSERT INTO `ez_area` VALUES (140722, '左权县', 140700, '113.379403,37.082943', 'district', '113.379403', '37.082943', 3, NULL, '0354', '032600', 'Zuoquan', 'Z', NULL);
INSERT INTO `ez_area` VALUES (140723, '和顺县', 140700, '113.570415,37.32957', 'district', '113.570415', '37.32957', 3, NULL, '0354', '032700', 'Heshun', 'H', NULL);
INSERT INTO `ez_area` VALUES (140724, '昔阳县', 140700, '113.706977,37.61253', 'district', '113.706977', '37.61253', 3, NULL, '0354', '045300', 'Xiyang', 'X', NULL);
INSERT INTO `ez_area` VALUES (140725, '寿阳县', 140700, '113.176373,37.895191', 'district', '113.176373', '37.895191', 3, NULL, '0354', '045400', 'Shouyang', 'S', NULL);
INSERT INTO `ez_area` VALUES (140726, '太谷县', 140700, '112.551305,37.421307', 'district', '112.551305', '37.421307', 3, NULL, '0354', '030800', 'Taigu', 'T', NULL);
INSERT INTO `ez_area` VALUES (140727, '祁县', 140700, '112.335542,37.357869', 'district', '112.335542', '37.357869', 3, NULL, '0354', '030900', 'Qixian', 'Q', NULL);
INSERT INTO `ez_area` VALUES (140728, '平遥县', 140700, '112.176136,37.189421', 'district', '112.176136', '37.189421', 3, NULL, '0354', '031100', 'Pingyao', 'P', NULL);
INSERT INTO `ez_area` VALUES (140729, '灵石县', 140700, '111.77864,36.847927', 'district', '111.77864', '36.847927', 3, NULL, '0354', '031300', 'Lingshi', 'L', NULL);
INSERT INTO `ez_area` VALUES (140781, '介休市', 140700, '111.916711,37.026944', 'district', '111.916711', '37.026944', 3, NULL, '0354', '032000', 'Jiexiu', 'J', NULL);
INSERT INTO `ez_area` VALUES (140800, '运城市', 140000, '111.00746,35.026516', 'city', '111.00746', '35.026516', 2, NULL, '0359', '044000', 'Yuncheng', 'Y', NULL);
INSERT INTO `ez_area` VALUES (140802, '盐湖区', 140800, '110.998272,35.015101', 'district', '110.998272', '35.015101', 3, NULL, '0359', '044000', 'Yanhu', 'Y', NULL);
INSERT INTO `ez_area` VALUES (140821, '临猗县', 140800, '110.774547,35.144277', 'district', '110.774547', '35.144277', 3, NULL, '0359', '044100', 'Linyi', 'L', NULL);
INSERT INTO `ez_area` VALUES (140822, '万荣县', 140800, '110.838024,35.415253', 'district', '110.838024', '35.415253', 3, NULL, '0359', '044200', 'Wanrong', 'W', NULL);
INSERT INTO `ez_area` VALUES (140823, '闻喜县', 140800, '111.22472,35.356644', 'district', '111.22472', '35.356644', 3, NULL, '0359', '043800', 'Wenxi', 'W', NULL);
INSERT INTO `ez_area` VALUES (140824, '稷山县', 140800, '110.983333,35.604025', 'district', '110.983333', '35.604025', 3, NULL, '0359', '043200', 'Jishan', 'J', NULL);
INSERT INTO `ez_area` VALUES (140825, '新绛县', 140800, '111.224734,35.616251', 'district', '111.224734', '35.616251', 3, NULL, '0359', '043100', 'Xinjiang', 'X', NULL);
INSERT INTO `ez_area` VALUES (140826, '绛县', 140800, '111.568236,35.49119', 'district', '111.568236', '35.49119', 3, NULL, '0359', '043600', 'Jiangxian', 'J', NULL);
INSERT INTO `ez_area` VALUES (140827, '垣曲县', 140800, '111.670108,35.297369', 'district', '111.670108', '35.297369', 3, NULL, '0359', '043700', 'Yuanqu', 'Y', NULL);
INSERT INTO `ez_area` VALUES (140828, '夏县', 140800, '111.220456,35.141363', 'district', '111.220456', '35.141363', 3, NULL, '0359', '044400', 'Xiaxian', 'X', NULL);
INSERT INTO `ez_area` VALUES (140829, '平陆县', 140800, '111.194133,34.82926', 'district', '111.194133', '34.82926', 3, NULL, '0359', '044300', 'Pinglu', 'P', NULL);
INSERT INTO `ez_area` VALUES (140830, '芮城县', 140800, '110.694369,34.693579', 'district', '110.694369', '34.693579', 3, NULL, '0359', '044600', 'Ruicheng', 'R', NULL);
INSERT INTO `ez_area` VALUES (140881, '永济市', 140800, '110.447543,34.8671', 'district', '110.447543', '34.8671', 3, NULL, '0359', '044500', 'Yongji', 'Y', NULL);
INSERT INTO `ez_area` VALUES (140882, '河津市', 140800, '110.712063,35.596383', 'district', '110.712063', '35.596383', 3, NULL, '0359', '043300', 'Hejin', 'H', NULL);
INSERT INTO `ez_area` VALUES (140900, '忻州市', 140000, '112.734174,38.416663', 'city', '112.734174', '38.416663', 2, NULL, '0350', '034000', 'Xinzhou', 'X', NULL);
INSERT INTO `ez_area` VALUES (140902, '忻府区', 140900, '112.746046,38.404242', 'district', '112.746046', '38.404242', 3, NULL, '0350', '034000', 'Xinfu', 'X', NULL);
INSERT INTO `ez_area` VALUES (140921, '定襄县', 140900, '112.957237,38.473506', 'district', '112.957237', '38.473506', 3, NULL, '0350', '035400', 'Dingxiang', 'D', NULL);
INSERT INTO `ez_area` VALUES (140922, '五台县', 140900, '113.255309,38.728315', 'district', '113.255309', '38.728315', 3, NULL, '0350', '035500', 'Wutai', 'W', NULL);
INSERT INTO `ez_area` VALUES (140923, '代县', 140900, '112.960282,39.066917', 'district', '112.960282', '39.066917', 3, NULL, '0350', '034200', 'Daixian', 'D', NULL);
INSERT INTO `ez_area` VALUES (140924, '繁峙县', 140900, '113.265563,39.188811', 'district', '113.265563', '39.188811', 3, NULL, '0350', '034300', 'Fanshi', 'F', NULL);
INSERT INTO `ez_area` VALUES (140925, '宁武县', 140900, '112.304722,39.001524', 'district', '112.304722', '39.001524', 3, NULL, '0350', '036700', 'Ningwu', 'N', NULL);
INSERT INTO `ez_area` VALUES (140926, '静乐县', 140900, '111.939498,38.359306', 'district', '111.939498', '38.359306', 3, NULL, '0350', '035100', 'Jingle', 'J', NULL);
INSERT INTO `ez_area` VALUES (140927, '神池县', 140900, '112.211296,39.090552', 'district', '112.211296', '39.090552', 3, NULL, '0350', '036100', 'Shenchi', 'S', NULL);
INSERT INTO `ez_area` VALUES (140928, '五寨县', 140900, '111.846904,38.910726', 'district', '111.846904', '38.910726', 3, NULL, '0350', '036200', 'Wuzhai', 'W', NULL);
INSERT INTO `ez_area` VALUES (140929, '岢岚县', 140900, '111.57285,38.70418', 'district', '111.57285', '38.70418', 3, NULL, '0350', '036300', 'Kelan', 'K', NULL);
INSERT INTO `ez_area` VALUES (140930, '河曲县', 140900, '111.138472,39.384482', 'district', '111.138472', '39.384482', 3, NULL, '0350', '036500', 'Hequ', 'H', NULL);
INSERT INTO `ez_area` VALUES (140931, '保德县', 140900, '111.086564,39.022487', 'district', '111.086564', '39.022487', 3, NULL, '0350', '036600', 'Baode', 'B', NULL);
INSERT INTO `ez_area` VALUES (140932, '偏关县', 140900, '111.508831,39.436306', 'district', '111.508831', '39.436306', 3, NULL, '0350', '036400', 'Pianguan', 'P', NULL);
INSERT INTO `ez_area` VALUES (140981, '原平市', 140900, '112.711058,38.731402', 'district', '112.711058', '38.731402', 3, NULL, '0350', '034100', 'Yuanping', 'Y', NULL);
INSERT INTO `ez_area` VALUES (141000, '临汾市', 140000, '111.518975,36.088005', 'city', '111.518975', '36.088005', 2, NULL, '0357', '041000', 'Linfen', 'L', NULL);
INSERT INTO `ez_area` VALUES (141002, '尧都区', 141000, '111.579554,36.07884', 'district', '111.579554', '36.07884', 3, NULL, '0357', '041000', 'Yaodu', 'Y', NULL);
INSERT INTO `ez_area` VALUES (141021, '曲沃县', 141000, '111.47586,35.641086', 'district', '111.47586', '35.641086', 3, NULL, '0357', '043400', 'Quwo', 'Q', NULL);
INSERT INTO `ez_area` VALUES (141022, '翼城县', 141000, '111.718951,35.738576', 'district', '111.718951', '35.738576', 3, NULL, '0357', '043500', 'Yicheng', 'Y', NULL);
INSERT INTO `ez_area` VALUES (141023, '襄汾县', 141000, '111.441725,35.876293', 'district', '111.441725', '35.876293', 3, NULL, '0357', '041500', 'Xiangfen', 'X', NULL);
INSERT INTO `ez_area` VALUES (141024, '洪洞县', 141000, '111.674965,36.253747', 'district', '111.674965', '36.253747', 3, NULL, '0357', '041600', 'Hongtong', 'H', NULL);
INSERT INTO `ez_area` VALUES (141025, '古县', 141000, '111.920465,36.266914', 'district', '111.920465', '36.266914', 3, NULL, '0357', '042400', 'Guxian', 'G', NULL);
INSERT INTO `ez_area` VALUES (141026, '安泽县', 141000, '112.250144,36.147787', 'district', '112.250144', '36.147787', 3, NULL, '0357', '042500', 'Anze', 'A', NULL);
INSERT INTO `ez_area` VALUES (141027, '浮山县', 141000, '111.848883,35.968124', 'district', '111.848883', '35.968124', 3, NULL, '0357', '042600', 'Fushan', 'F', NULL);
INSERT INTO `ez_area` VALUES (141028, '吉县', 141000, '110.681763,36.098188', 'district', '110.681763', '36.098188', 3, NULL, '0357', '042200', 'Jixian', 'J', NULL);
INSERT INTO `ez_area` VALUES (141029, '乡宁县', 141000, '110.847021,35.970389', 'district', '110.847021', '35.970389', 3, NULL, '0357', '042100', 'Xiangning', 'X', NULL);
INSERT INTO `ez_area` VALUES (141030, '大宁县', 141000, '110.75291,36.465102', 'district', '110.75291', '36.465102', 3, NULL, '0357', '042300', 'Daning', 'D', NULL);
INSERT INTO `ez_area` VALUES (141031, '隰县', 141000, '110.940637,36.69333', 'district', '110.940637', '36.69333', 3, NULL, '0357', '041300', 'Xixian', 'X', NULL);
INSERT INTO `ez_area` VALUES (141032, '永和县', 141000, '110.632006,36.759507', 'district', '110.632006', '36.759507', 3, NULL, '0357', '041400', 'Yonghe', 'Y', NULL);
INSERT INTO `ez_area` VALUES (141033, '蒲县', 141000, '111.096439,36.411826', 'district', '111.096439', '36.411826', 3, NULL, '0357', '041200', 'Puxian', 'P', NULL);
INSERT INTO `ez_area` VALUES (141034, '汾西县', 141000, '111.56395,36.652854', 'district', '111.56395', '36.652854', 3, NULL, '0357', '031500', 'Fenxi', 'F', NULL);
INSERT INTO `ez_area` VALUES (141081, '侯马市', 141000, '111.372002,35.619105', 'district', '111.372002', '35.619105', 3, NULL, '0357', '043000', 'Houma', 'H', NULL);
INSERT INTO `ez_area` VALUES (141082, '霍州市', 141000, '111.755398,36.56893', 'district', '111.755398', '36.56893', 3, NULL, '0357', '031400', 'Huozhou', 'H', NULL);
INSERT INTO `ez_area` VALUES (141100, '吕梁市', 140000, '111.144699,37.519126', 'city', '111.144699', '37.519126', 2, NULL, '0358', '033000', 'Lvliang', 'L', NULL);
INSERT INTO `ez_area` VALUES (141102, '离石区', 141100, '111.150695,37.51786', 'district', '111.150695', '37.51786', 3, NULL, '0358', '033000', 'Lishi', 'L', NULL);
INSERT INTO `ez_area` VALUES (141121, '文水县', 141100, '112.028866,37.438101', 'district', '112.028866', '37.438101', 3, NULL, '0358', '032100', 'Wenshui', 'W', NULL);
INSERT INTO `ez_area` VALUES (141122, '交城县', 141100, '112.156064,37.551963', 'district', '112.156064', '37.551963', 3, NULL, '0358', '030500', 'Jiaocheng', 'J', NULL);
INSERT INTO `ez_area` VALUES (141123, '兴县', 141100, '111.127667,38.462389', 'district', '111.127667', '38.462389', 3, NULL, '0358', '033600', 'Xingxian', 'X', NULL);
INSERT INTO `ez_area` VALUES (141124, '临县', 141100, '110.992093,37.950758', 'district', '110.992093', '37.950758', 3, NULL, '0358', '033200', 'Linxian', 'L', NULL);
INSERT INTO `ez_area` VALUES (141125, '柳林县', 141100, '110.889007,37.429772', 'district', '110.889007', '37.429772', 3, NULL, '0358', '033300', 'Liulin', 'L', NULL);
INSERT INTO `ez_area` VALUES (141126, '石楼县', 141100, '110.834634,36.99857', 'district', '110.834634', '36.99857', 3, NULL, '0358', '032500', 'Shilou', 'S', NULL);
INSERT INTO `ez_area` VALUES (141127, '岚县', 141100, '111.671917,38.279299', 'district', '111.671917', '38.279299', 3, NULL, '0358', '033500', 'Lanxian', 'L', NULL);
INSERT INTO `ez_area` VALUES (141128, '方山县', 141100, '111.244098,37.894631', 'district', '111.244098', '37.894631', 3, NULL, '0358', '033100', 'Fangshan', 'F', NULL);
INSERT INTO `ez_area` VALUES (141129, '中阳县', 141100, '111.179657,37.357058', 'district', '111.179657', '37.357058', 3, NULL, '0358', '033400', 'Zhongyang', 'Z', NULL);
INSERT INTO `ez_area` VALUES (141130, '交口县', 141100, '111.181151,36.982186', 'district', '111.181151', '36.982186', 3, NULL, '0358', '032400', 'Jiaokou', 'J', NULL);
INSERT INTO `ez_area` VALUES (141181, '孝义市', 141100, '111.778818,37.146294', 'district', '111.778818', '37.146294', 3, NULL, '0358', '032300', 'Xiaoyi', 'X', NULL);
INSERT INTO `ez_area` VALUES (141182, '汾阳市', 141100, '111.770477,37.261756', 'district', '111.770477', '37.261756', 3, NULL, '0358', '032200', 'Fenyang', 'F', NULL);
INSERT INTO `ez_area` VALUES (150000, '内蒙古自治区', 0, '111.76629,40.81739', 'province', '111.76629', '40.81739', 1, NULL, NULL, NULL, 'Inner Mongolia', 'I', NULL);
INSERT INTO `ez_area` VALUES (150100, '呼和浩特市', 150000, '111.749995,40.842356', 'city', '111.749995', '40.842356', 2, NULL, '0471', '010000', 'Hohhot', 'H', NULL);
INSERT INTO `ez_area` VALUES (150102, '新城区', 150100, '111.665544,40.858289', 'district', '111.665544', '40.858289', 3, NULL, '0471', '010050', 'Xincheng', 'X', NULL);
INSERT INTO `ez_area` VALUES (150103, '回民区', 150100, '111.623692,40.808608', 'district', '111.623692', '40.808608', 3, NULL, '0471', '010030', 'Huimin', 'H', NULL);
INSERT INTO `ez_area` VALUES (150104, '玉泉区', 150100, '111.673881,40.753655', 'district', '111.673881', '40.753655', 3, NULL, '0471', '010020', 'Yuquan', 'Y', NULL);
INSERT INTO `ez_area` VALUES (150105, '赛罕区', 150100, '111.701355,40.792667', 'district', '111.701355', '40.792667', 3, NULL, '0471', '010020', 'Saihan', 'S', NULL);
INSERT INTO `ez_area` VALUES (150121, '土默特左旗', 150100, '111.163902,40.729572', 'district', '111.163902', '40.729572', 3, NULL, '0471', '010100', 'Tumotezuoqi', 'T', NULL);
INSERT INTO `ez_area` VALUES (150122, '托克托县', 150100, '111.194312,40.277431', 'district', '111.194312', '40.277431', 3, NULL, '0471', '010200', 'Tuoketuo', 'T', NULL);
INSERT INTO `ez_area` VALUES (150123, '和林格尔县', 150100, '111.821843,40.378787', 'district', '111.821843', '40.378787', 3, NULL, '0471', '011500', 'Helingeer', 'H', NULL);
INSERT INTO `ez_area` VALUES (150124, '清水河县', 150100, '111.647609,39.921095', 'district', '111.647609', '39.921095', 3, NULL, '0471', '011600', 'Qingshuihe', 'Q', NULL);
INSERT INTO `ez_area` VALUES (150125, '武川县', 150100, '111.451303,41.096471', 'district', '111.451303', '41.096471', 3, NULL, '0471', '011700', 'Wuchuan', 'W', NULL);
INSERT INTO `ez_area` VALUES (150200, '包头市', 150000, '109.953504,40.621157', 'city', '109.953504', '40.621157', 2, NULL, '0472', '014025', 'Baotou', 'B', NULL);
INSERT INTO `ez_area` VALUES (150202, '东河区', 150200, '110.044106,40.576319', 'district', '110.044106', '40.576319', 3, NULL, '0472', '014040', 'Donghe', 'D', NULL);
INSERT INTO `ez_area` VALUES (150203, '昆都仑区', 150200, '109.837707,40.642578', 'district', '109.837707', '40.642578', 3, NULL, '0472', '014010', 'Kundulun', 'K', NULL);
INSERT INTO `ez_area` VALUES (150204, '青山区', 150200, '109.901572,40.643246', 'district', '109.901572', '40.643246', 3, NULL, '0472', '014030', 'Qingshan', 'Q', NULL);
INSERT INTO `ez_area` VALUES (150205, '石拐区', 150200, '110.060254,40.681748', 'district', '110.060254', '40.681748', 3, NULL, '0472', '014070', 'Shiguai', 'S', NULL);
INSERT INTO `ez_area` VALUES (150206, '白云鄂博矿区', 150200, '109.973803,41.769511', 'district', '109.973803', '41.769511', 3, NULL, '0472', '014080', 'Baiyunebokuangqu', 'B', NULL);
INSERT INTO `ez_area` VALUES (150207, '九原区', 150200, '109.967449,40.610561', 'district', '109.967449', '40.610561', 3, NULL, '0472', '014060', 'Jiuyuan', 'J', NULL);
INSERT INTO `ez_area` VALUES (150221, '土默特右旗', 150200, '110.524262,40.569426', 'district', '110.524262', '40.569426', 3, NULL, '0472', '014100', 'Tumoteyouqi', 'T', NULL);
INSERT INTO `ez_area` VALUES (150222, '固阳县', 150200, '110.060514,41.034105', 'district', '110.060514', '41.034105', 3, NULL, '0472', '014200', 'Guyang', 'G', NULL);
INSERT INTO `ez_area` VALUES (150223, '达尔罕茂明安联合旗', 150200, '110.432626,41.698992', 'district', '110.432626', '41.698992', 3, NULL, '0472', '014500', 'Damaoqi', 'D', NULL);
INSERT INTO `ez_area` VALUES (150300, '乌海市', 150000, '106.794216,39.655248', 'city', '106.794216', '39.655248', 2, NULL, '0473', '016000', 'Wuhai', 'W', NULL);
INSERT INTO `ez_area` VALUES (150302, '海勃湾区', 150300, '106.822778,39.691156', 'district', '106.822778', '39.691156', 3, NULL, '0473', '016000', 'Haibowan', 'H', NULL);
INSERT INTO `ez_area` VALUES (150303, '海南区', 150300, '106.891424,39.441364', 'district', '106.891424', '39.441364', 3, NULL, '0473', '016030', 'Hainan', 'H', NULL);
INSERT INTO `ez_area` VALUES (150304, '乌达区', 150300, '106.726099,39.505925', 'district', '106.726099', '39.505925', 3, NULL, '0473', '016040', 'Wuda', 'W', NULL);
INSERT INTO `ez_area` VALUES (150400, '赤峰市', 150000, '118.88694,42.257843', 'city', '118.88694', '42.257843', 2, NULL, '0476', '024000', 'Chifeng', 'C', NULL);
INSERT INTO `ez_area` VALUES (150402, '红山区', 150400, '118.953854,42.296588', 'district', '118.953854', '42.296588', 3, NULL, '0476', '024020', 'Hongshan', 'H', NULL);
INSERT INTO `ez_area` VALUES (150403, '元宝山区', 150400, '119.288611,42.038902', 'district', '119.288611', '42.038902', 3, NULL, '0476', '024076', 'Yuanbaoshan', 'Y', NULL);
INSERT INTO `ez_area` VALUES (150404, '松山区', 150400, '118.916208,42.299798', 'district', '118.916208', '42.299798', 3, NULL, '0476', '024005', 'Songshan', 'S', NULL);
INSERT INTO `ez_area` VALUES (150421, '阿鲁科尔沁旗', 150400, '120.0657,43.872298', 'district', '120.0657', '43.872298', 3, NULL, '0476', '025550', 'Alukeerqinqi', 'A', NULL);
INSERT INTO `ez_area` VALUES (150422, '巴林左旗', 150400, '119.362931,43.960889', 'district', '119.362931', '43.960889', 3, NULL, '0476', '025450', 'Balinzuoqi', 'B', NULL);
INSERT INTO `ez_area` VALUES (150423, '巴林右旗', 150400, '118.66518,43.534414', 'district', '118.66518', '43.534414', 3, NULL, '0476', '025150', 'Balinyouqi', 'B', NULL);
INSERT INTO `ez_area` VALUES (150424, '林西县', 150400, '118.05545,43.61812', 'district', '118.05545', '43.61812', 3, NULL, '0476', '025250', 'Linxi', 'L', NULL);
INSERT INTO `ez_area` VALUES (150425, '克什克腾旗', 150400, '117.545797,43.264988', 'district', '117.545797', '43.264988', 3, NULL, '0476', '025350', 'Keshiketengqi', 'K', NULL);
INSERT INTO `ez_area` VALUES (150426, '翁牛特旗', 150400, '119.00658,42.936188', 'district', '119.00658', '42.936188', 3, NULL, '0476', '024500', 'Wengniuteqi', 'W', NULL);
INSERT INTO `ez_area` VALUES (150428, '喀喇沁旗', 150400, '118.701937,41.927363', 'district', '118.701937', '41.927363', 3, NULL, '0476', '024400', 'Kalaqinqi', 'K', NULL);
INSERT INTO `ez_area` VALUES (150429, '宁城县', 150400, '119.318876,41.601375', 'district', '119.318876', '41.601375', 3, NULL, '0476', '024200', 'Ningcheng', 'N', NULL);
INSERT INTO `ez_area` VALUES (150430, '敖汉旗', 150400, '119.921603,42.290781', 'district', '119.921603', '42.290781', 3, NULL, '0476', '024300', 'Aohanqi', 'A', NULL);
INSERT INTO `ez_area` VALUES (150500, '通辽市', 150000, '122.243444,43.652889', 'city', '122.243444', '43.652889', 2, NULL, '0475', '028000', 'Tongliao', 'T', NULL);
INSERT INTO `ez_area` VALUES (150502, '科尔沁区', 150500, '122.255671,43.623078', 'district', '122.255671', '43.623078', 3, NULL, '0475', '028000', 'Keerqin', 'K', NULL);
INSERT INTO `ez_area` VALUES (150521, '科尔沁左翼中旗', 150500, '123.312264,44.126625', 'district', '123.312264', '44.126625', 3, NULL, '0475', '029300', 'Keerqinzuoyizhongqi', 'K', NULL);
INSERT INTO `ez_area` VALUES (150522, '科尔沁左翼后旗', 150500, '122.35677,42.935105', 'district', '122.35677', '42.935105', 3, NULL, '0475', '028100', 'Keerqinzuoyihouqi', 'K', NULL);
INSERT INTO `ez_area` VALUES (150523, '开鲁县', 150500, '121.319308,43.601244', 'district', '121.319308', '43.601244', 3, NULL, '0475', '028400', 'Kailu', 'K', NULL);
INSERT INTO `ez_area` VALUES (150524, '库伦旗', 150500, '121.8107,42.735656', 'district', '121.8107', '42.735656', 3, NULL, '0475', '028200', 'Kulunqi', 'K', NULL);
INSERT INTO `ez_area` VALUES (150525, '奈曼旗', 150500, '120.658282,42.867226', 'district', '120.658282', '42.867226', 3, NULL, '0475', '028300', 'Naimanqi', 'N', NULL);
INSERT INTO `ez_area` VALUES (150526, '扎鲁特旗', 150500, '120.911676,44.556389', 'district', '120.911676', '44.556389', 3, NULL, '0475', '029100', 'Zhaluteqi', 'Z', NULL);
INSERT INTO `ez_area` VALUES (150581, '霍林郭勒市', 150500, '119.68187,45.533962', 'district', '119.68187', '45.533962', 3, NULL, '0475', '029200', 'Huolinguole', 'H', NULL);
INSERT INTO `ez_area` VALUES (150600, '鄂尔多斯市', 150000, '109.781327,39.608266', 'city', '109.781327', '39.608266', 2, NULL, '0477', '017004', 'Ordos', 'O', NULL);
INSERT INTO `ez_area` VALUES (150602, '东胜区', 150600, '109.963333,39.822593', 'district', '109.963333', '39.822593', 3, NULL, '0477', '017000', 'Dongsheng', 'D', NULL);
INSERT INTO `ez_area` VALUES (150603, '康巴什区', 150600, '109.790076,39.607472', 'district', '109.790076', '39.607472', 3, NULL, '0477', '017020', 'Kangbashi', 'K', NULL);
INSERT INTO `ez_area` VALUES (150621, '达拉特旗', 150600, '110.033833,40.412438', 'district', '110.033833', '40.412438', 3, NULL, '0477', '014300', 'Dalateqi', 'D', NULL);
INSERT INTO `ez_area` VALUES (150622, '准格尔旗', 150600, '111.240171,39.864361', 'district', '111.240171', '39.864361', 3, NULL, '0477', '017100', 'Zhungeerqi', 'Z', NULL);
INSERT INTO `ez_area` VALUES (150623, '鄂托克前旗', 150600, '107.477514,38.182362', 'district', '107.477514', '38.182362', 3, NULL, '0477', '016200', 'Etuokeqianqi', 'E', NULL);
INSERT INTO `ez_area` VALUES (150624, '鄂托克旗', 150600, '107.97616,39.08965', 'district', '107.97616', '39.08965', 3, NULL, '0477', '016100', 'Etuokeqi', 'E', NULL);
INSERT INTO `ez_area` VALUES (150625, '杭锦旗', 150600, '108.736208,39.833309', 'district', '108.736208', '39.833309', 3, NULL, '0477', '017400', 'Hangjinqi', 'H', NULL);
INSERT INTO `ez_area` VALUES (150626, '乌审旗', 150600, '108.817607,38.604136', 'district', '108.817607', '38.604136', 3, NULL, '0477', '017300', 'Wushenqi', 'W', NULL);
INSERT INTO `ez_area` VALUES (150627, '伊金霍洛旗', 150600, '109.74774,39.564659', 'district', '109.74774', '39.564659', 3, NULL, '0477', '017200', 'Yijinhuoluoqi', 'Y', NULL);
INSERT INTO `ez_area` VALUES (150700, '呼伦贝尔市', 150000, '119.765558,49.211576', 'city', '119.765558', '49.211576', 2, NULL, '0470', '021008', 'Hulunber', 'H', NULL);
INSERT INTO `ez_area` VALUES (150702, '海拉尔区', 150700, '119.736176,49.212188', 'district', '119.736176', '49.212188', 3, NULL, '0470', '021000', 'Hailaer', 'H', NULL);
INSERT INTO `ez_area` VALUES (150703, '扎赉诺尔区', 150700, '117.670248,49.510375', 'district', '117.670248', '49.510375', 3, NULL, '0470', '021410', 'Zhalainuoer', 'Z', NULL);
INSERT INTO `ez_area` VALUES (150721, '阿荣旗', 150700, '123.459049,48.126584', 'district', '123.459049', '48.126584', 3, NULL, '0470', '162750', 'Arongqi', 'A', NULL);
INSERT INTO `ez_area` VALUES (150722, '莫力达瓦达斡尔族自治旗', 150700, '124.519023,48.477728', 'district', '124.519023', '48.477728', 3, NULL, '0470', '162850', 'Moqi', 'M', NULL);
INSERT INTO `ez_area` VALUES (150723, '鄂伦春自治旗', 150700, '123.726201,50.591842', 'district', '123.726201', '50.591842', 3, NULL, '0470', '165450', 'Elunchun', 'E', NULL);
INSERT INTO `ez_area` VALUES (150724, '鄂温克族自治旗', 150700, '119.755239,49.146592', 'district', '119.755239', '49.146592', 3, NULL, '0470', '021100', 'Ewen', 'E', NULL);
INSERT INTO `ez_area` VALUES (150725, '陈巴尔虎旗', 150700, '119.424026,49.328916', 'district', '119.424026', '49.328916', 3, NULL, '0470', '021500', 'Chenbaerhuqi', 'C', NULL);
INSERT INTO `ez_area` VALUES (150726, '新巴尔虎左旗', 150700, '118.269819,48.218241', 'district', '118.269819', '48.218241', 3, NULL, '0470', '021200', 'Xinbaerhuzuoqi', 'X', NULL);
INSERT INTO `ez_area` VALUES (150727, '新巴尔虎右旗', 150700, '116.82369,48.672101', 'district', '116.82369', '48.672101', 3, NULL, '0470', '021300', 'Xinbaerhuyouqi', 'X', NULL);
INSERT INTO `ez_area` VALUES (150781, '满洲里市', 150700, '117.378529,49.597841', 'district', '117.378529', '49.597841', 3, NULL, '0470', '021400', 'Manzhouli', 'M', NULL);
INSERT INTO `ez_area` VALUES (150782, '牙克石市', 150700, '120.711775,49.285629', 'district', '120.711775', '49.285629', 3, NULL, '0470', '022150', 'Yakeshi', 'Y', NULL);
INSERT INTO `ez_area` VALUES (150783, '扎兰屯市', 150700, '122.737467,48.013733', 'district', '122.737467', '48.013733', 3, NULL, '0470', '162650', 'Zhalantun', 'Z', NULL);
INSERT INTO `ez_area` VALUES (150784, '额尔古纳市', 150700, '120.180506,50.243102', 'district', '120.180506', '50.243102', 3, NULL, '0470', '022250', 'Eerguna', 'E', NULL);
INSERT INTO `ez_area` VALUES (150785, '根河市', 150700, '121.520388,50.780344', 'district', '121.520388', '50.780344', 3, NULL, '0470', '022350', 'Genhe', 'G', NULL);
INSERT INTO `ez_area` VALUES (150800, '巴彦淖尔市', 150000, '107.387657,40.743213', 'city', '107.387657', '40.743213', 2, NULL, '0478', '015001', 'Bayan Nur', 'B', NULL);
INSERT INTO `ez_area` VALUES (150802, '临河区', 150800, '107.363918,40.751187', 'district', '107.363918', '40.751187', 3, NULL, '0478', '015001', 'Linhe', 'L', NULL);
INSERT INTO `ez_area` VALUES (150821, '五原县', 150800, '108.267561,41.088421', 'district', '108.267561', '41.088421', 3, NULL, '0478', '015100', 'Wuyuan', 'W', NULL);
INSERT INTO `ez_area` VALUES (150822, '磴口县', 150800, '107.008248,40.330523', 'district', '107.008248', '40.330523', 3, NULL, '0478', '015200', 'Dengkou', 'D', NULL);
INSERT INTO `ez_area` VALUES (150823, '乌拉特前旗', 150800, '108.652114,40.737018', 'district', '108.652114', '40.737018', 3, NULL, '0478', '014400', 'Wulateqianqi', 'W', NULL);
INSERT INTO `ez_area` VALUES (150824, '乌拉特中旗', 150800, '108.513645,41.587732', 'district', '108.513645', '41.587732', 3, NULL, '0478', '015300', 'Wulatezhongqi', 'W', NULL);
INSERT INTO `ez_area` VALUES (150825, '乌拉特后旗', 150800, '107.074621,41.084282', 'district', '107.074621', '41.084282', 3, NULL, '0478', '015500', 'Wulatehouqi', 'W', NULL);
INSERT INTO `ez_area` VALUES (150826, '杭锦后旗', 150800, '107.151245,40.88602', 'district', '107.151245', '40.88602', 3, NULL, '0478', '015400', 'Hangjinhouqi', 'H', NULL);
INSERT INTO `ez_area` VALUES (150900, '乌兰察布市', 150000, '113.132584,40.994785', 'city', '113.132584', '40.994785', 2, NULL, '0474', '012000', 'Ulanqab', 'U', NULL);
INSERT INTO `ez_area` VALUES (150902, '集宁区', 150900, '113.116453,41.034134', 'district', '113.116453', '41.034134', 3, NULL, '0474', '012000', 'Jining', 'J', NULL);
INSERT INTO `ez_area` VALUES (150921, '卓资县', 150900, '112.577528,40.894691', 'district', '112.577528', '40.894691', 3, NULL, '0474', '012300', 'Zhuozi', 'Z', NULL);
INSERT INTO `ez_area` VALUES (150922, '化德县', 150900, '114.010437,41.90456', 'district', '114.010437', '41.90456', 3, NULL, '0474', '013350', 'Huade', 'H', NULL);
INSERT INTO `ez_area` VALUES (150923, '商都县', 150900, '113.577816,41.562113', 'district', '113.577816', '41.562113', 3, NULL, '0474', '013450', 'Shangdu', 'S', NULL);
INSERT INTO `ez_area` VALUES (150924, '兴和县', 150900, '113.834173,40.872301', 'district', '113.834173', '40.872301', 3, NULL, '0474', '013650', 'Xinghe', 'X', NULL);
INSERT INTO `ez_area` VALUES (150925, '凉城县', 150900, '112.503971,40.531555', 'district', '112.503971', '40.531555', 3, NULL, '0474', '013750', 'Liangcheng', 'L', NULL);
INSERT INTO `ez_area` VALUES (150926, '察哈尔右翼前旗', 150900, '113.214733,40.785631', 'district', '113.214733', '40.785631', 3, NULL, '0474', '012200', 'Chayouqianqi', 'C', NULL);
INSERT INTO `ez_area` VALUES (150927, '察哈尔右翼中旗', 150900, '112.635577,41.277462', 'district', '112.635577', '41.277462', 3, NULL, '0474', '013550', 'Chayouzhongqi', 'C', NULL);
INSERT INTO `ez_area` VALUES (150928, '察哈尔右翼后旗', 150900, '113.191035,41.436069', 'district', '113.191035', '41.436069', 3, NULL, '0474', '012400', 'Chayouhouqi', 'C', NULL);
INSERT INTO `ez_area` VALUES (150929, '四子王旗', 150900, '111.706617,41.533462', 'district', '111.706617', '41.533462', 3, NULL, '0474', '011800', 'Siziwangqi', 'S', NULL);
INSERT INTO `ez_area` VALUES (150981, '丰镇市', 150900, '113.109892,40.436983', 'district', '113.109892', '40.436983', 3, NULL, '0474', '012100', 'Fengzhen', 'F', NULL);
INSERT INTO `ez_area` VALUES (152200, '兴安盟', 150000, '122.037657,46.082462', 'city', '122.037657', '46.082462', 2, NULL, '0482', '137401', 'Hinggan', 'H', NULL);
INSERT INTO `ez_area` VALUES (152201, '乌兰浩特市', 152200, '122.093123,46.072731', 'district', '122.093123', '46.072731', 3, NULL, '0482', '137401', 'Wulanhaote', 'W', NULL);
INSERT INTO `ez_area` VALUES (152202, '阿尔山市', 152200, '119.943575,47.17744', 'district', '119.943575', '47.17744', 3, NULL, '0482', '137800', 'Aershan', 'A', NULL);
INSERT INTO `ez_area` VALUES (152221, '科尔沁右翼前旗', 152200, '121.952621,46.079833', 'district', '121.952621', '46.079833', 3, NULL, '0482', '137423', 'Keyouqianqi', 'K', NULL);
INSERT INTO `ez_area` VALUES (152222, '科尔沁右翼中旗', 152200, '121.47653,45.060837', 'district', '121.47653', '45.060837', 3, NULL, '0482', '029400', 'Keyouzhongqi', 'K', NULL);
INSERT INTO `ez_area` VALUES (152223, '扎赉特旗', 152200, '122.899656,46.723237', 'district', '122.899656', '46.723237', 3, NULL, '0482', '137600', 'Zhalaiteqi', 'Z', NULL);
INSERT INTO `ez_area` VALUES (152224, '突泉县', 152200, '121.593799,45.38193', 'district', '121.593799', '45.38193', 3, NULL, '0482', '137500', 'Tuquan', 'T', NULL);
INSERT INTO `ez_area` VALUES (152500, '锡林郭勒盟', 150000, '116.048222,43.933454', 'city', '116.048222', '43.933454', 2, NULL, '0479', '026000', 'Xilin Gol', 'X', NULL);
INSERT INTO `ez_area` VALUES (152501, '二连浩特市', 152500, '111.951002,43.6437', 'district', '111.951002', '43.6437', 3, NULL, '0479', '011100', 'Erlianhaote', 'E', NULL);
INSERT INTO `ez_area` VALUES (152502, '锡林浩特市', 152500, '116.086029,43.933403', 'district', '116.086029', '43.933403', 3, NULL, '0479', '026021', 'Xilinhaote', 'X', NULL);
INSERT INTO `ez_area` VALUES (152522, '阿巴嘎旗', 152500, '114.950248,44.022995', 'district', '114.950248', '44.022995', 3, NULL, '0479', '011400', 'Abagaqi', 'A', NULL);
INSERT INTO `ez_area` VALUES (152523, '苏尼特左旗', 152500, '113.667248,43.85988', 'district', '113.667248', '43.85988', 3, NULL, '0479', '011300', 'Sunitezuoqi', 'S', NULL);
INSERT INTO `ez_area` VALUES (152524, '苏尼特右旗', 152500, '112.641783,42.742892', 'district', '112.641783', '42.742892', 3, NULL, '0479', '011200', 'Suniteyouqi', 'S', NULL);
INSERT INTO `ez_area` VALUES (152525, '东乌珠穆沁旗', 152500, '116.974494,45.498221', 'district', '116.974494', '45.498221', 3, NULL, '0479', '026300', 'Dongwuqi', 'D', NULL);
INSERT INTO `ez_area` VALUES (152526, '西乌珠穆沁旗', 152500, '117.608911,44.587882', 'district', '117.608911', '44.587882', 3, NULL, '0479', '026200', 'Xiwuqi', 'X', NULL);
INSERT INTO `ez_area` VALUES (152527, '太仆寺旗', 152500, '115.282986,41.877135', 'district', '115.282986', '41.877135', 3, NULL, '0479', '027000', 'Taipusiqi', 'T', NULL);
INSERT INTO `ez_area` VALUES (152528, '镶黄旗', 152500, '113.847287,42.232371', 'district', '113.847287', '42.232371', 3, NULL, '0479', '013250', 'Xianghuangqi', 'X', NULL);
INSERT INTO `ez_area` VALUES (152529, '正镶白旗', 152500, '115.029848,42.28747', 'district', '115.029848', '42.28747', 3, NULL, '0479', '013800', 'Zhengxiangbaiqi', 'Z', NULL);
INSERT INTO `ez_area` VALUES (152530, '正蓝旗', 152500, '115.99247,42.241638', 'district', '115.99247', '42.241638', 3, NULL, '0479', '027200', 'Zhenglanqi', 'Z', NULL);
INSERT INTO `ez_area` VALUES (152531, '多伦县', 152500, '116.485555,42.203591', 'district', '116.485555', '42.203591', 3, NULL, '0479', '027300', 'Duolun', 'D', NULL);
INSERT INTO `ez_area` VALUES (152900, '阿拉善盟', 150000, '105.728957,38.851921', 'city', '105.728957', '38.851921', 2, NULL, '0483', '750306', 'Alxa', 'A', NULL);
INSERT INTO `ez_area` VALUES (152921, '阿拉善左旗', 152900, '105.666275,38.833389', 'district', '105.666275', '38.833389', 3, NULL, '0483', '750306', 'Alashanzuoqi', 'A', NULL);
INSERT INTO `ez_area` VALUES (152922, '阿拉善右旗', 152900, '101.666917,39.216185', 'district', '101.666917', '39.216185', 3, NULL, '0483', '737300', 'Alashanyouqi', 'A', NULL);
INSERT INTO `ez_area` VALUES (152923, '额济纳旗', 152900, '101.055731,41.95455', 'district', '101.055731', '41.95455', 3, NULL, '0483', '735400', 'Ejinaqi', 'E', NULL);
INSERT INTO `ez_area` VALUES (210000, '辽宁省', 0, '123.431382,41.836175', 'province', '123.431382', '41.836175', 1, NULL, NULL, NULL, 'Liaoning', 'L', NULL);
INSERT INTO `ez_area` VALUES (210100, '沈阳市', 210000, '123.465035,41.677284', 'city', '123.465035', '41.677284', 2, NULL, '024', '110013', 'Shenyang', 'S', NULL);
INSERT INTO `ez_area` VALUES (210102, '和平区', 210100, '123.420368,41.789833', 'district', '123.420368', '41.789833', 3, NULL, '024', '110001', 'Heping', 'H', NULL);
INSERT INTO `ez_area` VALUES (210103, '沈河区', 210100, '123.458691,41.796177', 'district', '123.458691', '41.796177', 3, NULL, '024', '110011', 'Shenhe', 'S', NULL);
INSERT INTO `ez_area` VALUES (210104, '大东区', 210100, '123.469948,41.805137', 'district', '123.469948', '41.805137', 3, NULL, '024', '110041', 'Dadong', 'D', NULL);
INSERT INTO `ez_area` VALUES (210105, '皇姑区', 210100, '123.442378,41.824516', 'district', '123.442378', '41.824516', 3, NULL, '024', '110031', 'Huanggu', 'H', NULL);
INSERT INTO `ez_area` VALUES (210106, '铁西区', 210100, '123.333968,41.820807', 'district', '123.333968', '41.820807', 3, NULL, '024', '110021', 'Tiexi', 'T', NULL);
INSERT INTO `ez_area` VALUES (210111, '苏家屯区', 210100, '123.344062,41.664757', 'district', '123.344062', '41.664757', 3, NULL, '024', '110101', 'Sujiatun', 'S', NULL);
INSERT INTO `ez_area` VALUES (210112, '浑南区', 210100, '123.449714,41.714914', 'district', '123.449714', '41.714914', 3, NULL, '024', '110015', 'Hunnan', 'H', NULL);
INSERT INTO `ez_area` VALUES (210113, '沈北新区', 210100, '123.583196,41.912487', 'district', '123.583196', '41.912487', 3, NULL, '024', '110121', 'Shenbeixinqu', 'S', NULL);
INSERT INTO `ez_area` VALUES (210114, '于洪区', 210100, '123.308119,41.793721', 'district', '123.308119', '41.793721', 3, NULL, '024', '110141', 'Yuhong', 'Y', NULL);
INSERT INTO `ez_area` VALUES (210115, '辽中区', 210100, '122.765409,41.516826', 'district', '122.765409', '41.516826', 3, NULL, '024', '110200', 'Liaozhong', 'L', NULL);
INSERT INTO `ez_area` VALUES (210123, '康平县', 210100, '123.343699,42.72793', 'district', '123.343699', '42.72793', 3, NULL, '024', '110500', 'Kangping', 'K', NULL);
INSERT INTO `ez_area` VALUES (210124, '法库县', 210100, '123.440294,42.50108', 'district', '123.440294', '42.50108', 3, NULL, '024', '110400', 'Faku', 'F', NULL);
INSERT INTO `ez_area` VALUES (210181, '新民市', 210100, '122.836723,41.985186', 'district', '122.836723', '41.985186', 3, NULL, '024', '110300', 'Xinmin', 'X', NULL);
INSERT INTO `ez_area` VALUES (210200, '大连市', 210000, '121.614848,38.914086', 'city', '121.614848', '38.914086', 2, NULL, '0411', '116011', 'Dalian', 'D', NULL);
INSERT INTO `ez_area` VALUES (210202, '中山区', 210200, '121.644926,38.918574', 'district', '121.644926', '38.918574', 3, NULL, '0411', '116001', 'Zhongshan', 'Z', NULL);
INSERT INTO `ez_area` VALUES (210203, '西岗区', 210200, '121.612324,38.914687', 'district', '121.612324', '38.914687', 3, NULL, '0411', '116011', 'Xigang', 'X', NULL);
INSERT INTO `ez_area` VALUES (210204, '沙河口区', 210200, '121.594297,38.904788', 'district', '121.594297', '38.904788', 3, NULL, '0411', '116021', 'Shahekou', 'S', NULL);
INSERT INTO `ez_area` VALUES (210211, '甘井子区', 210200, '121.525466,38.953343', 'district', '121.525466', '38.953343', 3, NULL, '0411', '116033', 'Ganjingzi', 'G', NULL);
INSERT INTO `ez_area` VALUES (210212, '旅顺口区', 210200, '121.261953,38.851705', 'district', '121.261953', '38.851705', 3, NULL, '0411', '116041', 'Lvshunkou', 'L', NULL);
INSERT INTO `ez_area` VALUES (210213, '金州区', 210200, '121.782655,39.050001', 'district', '121.782655', '39.050001', 3, NULL, '0411', '116100', 'Jinzhou', 'J', NULL);
INSERT INTO `ez_area` VALUES (210214, '普兰店区', 210200, '121.938269,39.392095', 'district', '121.938269', '39.392095', 3, NULL, '0411', '116200', 'Pulandian', 'P', NULL);
INSERT INTO `ez_area` VALUES (210224, '长海县', 210200, '122.588494,39.272728', 'district', '122.588494', '39.272728', 3, NULL, '0411', '116500', 'Changhai', 'C', NULL);
INSERT INTO `ez_area` VALUES (210281, '瓦房店市', 210200, '121.979543,39.626897', 'district', '121.979543', '39.626897', 3, NULL, '0411', '116300', 'Wafangdian', 'W', NULL);
INSERT INTO `ez_area` VALUES (210283, '庄河市', 210200, '122.967424,39.680843', 'district', '122.967424', '39.680843', 3, NULL, '0411', '116400', 'Zhuanghe', 'Z', NULL);
INSERT INTO `ez_area` VALUES (210300, '鞍山市', 210000, '122.994329,41.108647', 'city', '122.994329', '41.108647', 2, NULL, '0412', '114001', 'Anshan', 'A', NULL);
INSERT INTO `ez_area` VALUES (210302, '铁东区', 210300, '122.991052,41.089933', 'district', '122.991052', '41.089933', 3, NULL, '0412', '114001', 'Tiedong', 'T', NULL);
INSERT INTO `ez_area` VALUES (210303, '铁西区', 210300, '122.969629,41.119884', 'district', '122.969629', '41.119884', 3, NULL, '0413', '114013', 'Tiexi', 'T', NULL);
INSERT INTO `ez_area` VALUES (210304, '立山区', 210300, '123.029091,41.150401', 'district', '123.029091', '41.150401', 3, NULL, '0414', '114031', 'Lishan', 'L', NULL);
INSERT INTO `ez_area` VALUES (210311, '千山区', 210300, '122.944751,41.068901', 'district', '122.944751', '41.068901', 3, NULL, '0415', '114041', 'Qianshan', 'Q', NULL);
INSERT INTO `ez_area` VALUES (210321, '台安县', 210300, '122.436196,41.412767', 'district', '122.436196', '41.412767', 3, NULL, '0417', '114100', 'Tai\'an', 'T', NULL);
INSERT INTO `ez_area` VALUES (210323, '岫岩满族自治县', 210300, '123.280935,40.29088', 'district', '123.280935', '40.29088', 3, NULL, '0418', '114300', 'Xiuyan', 'X', NULL);
INSERT INTO `ez_area` VALUES (210381, '海城市', 210300, '122.685217,40.882377', 'district', '122.685217', '40.882377', 3, NULL, '0416', '114200', 'Haicheng', 'H', NULL);
INSERT INTO `ez_area` VALUES (210400, '抚顺市', 210000, '123.957208,41.880872', 'city', '123.957208', '41.880872', 2, NULL, '024', '113008', 'Fushun', 'F', NULL);
INSERT INTO `ez_area` VALUES (210402, '新抚区', 210400, '123.912872,41.862026', 'district', '123.912872', '41.862026', 3, NULL, '024', '113008', 'Xinfu', 'X', NULL);
INSERT INTO `ez_area` VALUES (210403, '东洲区', 210400, '124.038685,41.853191', 'district', '124.038685', '41.853191', 3, NULL, '024', '113003', 'Dongzhou', 'D', NULL);
INSERT INTO `ez_area` VALUES (210404, '望花区', 210400, '123.784225,41.853641', 'district', '123.784225', '41.853641', 3, NULL, '024', '113001', 'Wanghua', 'W', NULL);
INSERT INTO `ez_area` VALUES (210411, '顺城区', 210400, '123.945075,41.883235', 'district', '123.945075', '41.883235', 3, NULL, '024', '113006', 'Shuncheng', 'S', NULL);
INSERT INTO `ez_area` VALUES (210421, '抚顺县', 210400, '124.097978,41.922644', 'district', '124.097978', '41.922644', 3, NULL, '024', '113006', 'Fushun', 'F', NULL);
INSERT INTO `ez_area` VALUES (210422, '新宾满族自治县', 210400, '125.039978,41.734256', 'district', '125.039978', '41.734256', 3, NULL, '024', '113200', 'Xinbin', 'X', NULL);
INSERT INTO `ez_area` VALUES (210423, '清原满族自治县', 210400, '124.924083,42.100538', 'district', '124.924083', '42.100538', 3, NULL, '024', '113300', 'Qingyuan', 'Q', NULL);
INSERT INTO `ez_area` VALUES (210500, '本溪市', 210000, '123.685142,41.486981', 'city', '123.685142', '41.486981', 2, NULL, '0414', '117000', 'Benxi', 'B', NULL);
INSERT INTO `ez_area` VALUES (210502, '平山区', 210500, '123.769088,41.299587', 'district', '123.769088', '41.299587', 3, NULL, '0414', '117000', 'Pingshan', 'P', NULL);
INSERT INTO `ez_area` VALUES (210503, '溪湖区', 210500, '123.767646,41.329219', 'district', '123.767646', '41.329219', 3, NULL, '0414', '117002', 'Xihu', 'X', NULL);
INSERT INTO `ez_area` VALUES (210504, '明山区', 210500, '123.817214,41.308719', 'district', '123.817214', '41.308719', 3, NULL, '0414', '117021', 'Mingshan', 'M', NULL);
INSERT INTO `ez_area` VALUES (210505, '南芬区', 210500, '123.744802,41.100445', 'district', '123.744802', '41.100445', 3, NULL, '0414', '117014', 'Nanfen', 'N', NULL);
INSERT INTO `ez_area` VALUES (210521, '本溪满族自治县', 210500, '124.120635,41.302009', 'district', '124.120635', '41.302009', 3, NULL, '0414', '117100', 'Benxi', 'B', NULL);
INSERT INTO `ez_area` VALUES (210522, '桓仁满族自治县', 210500, '125.361007,41.267127', 'district', '125.361007', '41.267127', 3, NULL, '0414', '117200', 'Huanren', 'H', NULL);
INSERT INTO `ez_area` VALUES (210600, '丹东市', 210000, '124.35445,40.000787', 'city', '124.35445', '40.000787', 2, NULL, '0415', '118000', 'Dandong', 'D', NULL);
INSERT INTO `ez_area` VALUES (210602, '元宝区', 210600, '124.395661,40.136434', 'district', '124.395661', '40.136434', 3, NULL, '0415', '118000', 'Yuanbao', 'Y', NULL);
INSERT INTO `ez_area` VALUES (210603, '振兴区', 210600, '124.383237,40.129944', 'district', '124.383237', '40.129944', 3, NULL, '0415', '118002', 'Zhenxing', 'Z', NULL);
INSERT INTO `ez_area` VALUES (210604, '振安区', 210600, '124.470034,40.201553', 'district', '124.470034', '40.201553', 3, NULL, '0415', '118001', 'Zhen\'an', 'Z', NULL);
INSERT INTO `ez_area` VALUES (210624, '宽甸满族自治县', 210600, '124.783659,40.731316', 'district', '124.783659', '40.731316', 3, NULL, '0415', '118200', 'Kuandian', 'K', NULL);
INSERT INTO `ez_area` VALUES (210681, '东港市', 210600, '124.152705,39.863008', 'district', '124.152705', '39.863008', 3, NULL, '0415', '118300', 'Donggang', 'D', NULL);
INSERT INTO `ez_area` VALUES (210682, '凤城市', 210600, '124.066919,40.452297', 'district', '124.066919', '40.452297', 3, NULL, '0415', '118100', 'Fengcheng', 'F', NULL);
INSERT INTO `ez_area` VALUES (210700, '锦州市', 210000, '121.126846,41.095685', 'city', '121.126846', '41.095685', 2, NULL, '0416', '121000', 'Jinzhou', 'J', NULL);
INSERT INTO `ez_area` VALUES (210702, '古塔区', 210700, '121.128279,41.117245', 'district', '121.128279', '41.117245', 3, NULL, '0416', '121001', 'Guta', 'G', NULL);
INSERT INTO `ez_area` VALUES (210703, '凌河区', 210700, '121.150877,41.114989', 'district', '121.150877', '41.114989', 3, NULL, '0416', '121000', 'Linghe', 'L', NULL);
INSERT INTO `ez_area` VALUES (210711, '太和区', 210700, '121.103892,41.109147', 'district', '121.103892', '41.109147', 3, NULL, '0416', '121011', 'Taihe', 'T', NULL);
INSERT INTO `ez_area` VALUES (210726, '黑山县', 210700, '122.126292,41.653593', 'district', '122.126292', '41.653593', 3, NULL, '0416', '121400', 'Heishan', 'H', NULL);
INSERT INTO `ez_area` VALUES (210727, '义县', 210700, '121.23908,41.533086', 'district', '121.23908', '41.533086', 3, NULL, '0416', '121100', 'Yixian', 'Y', NULL);
INSERT INTO `ez_area` VALUES (210781, '凌海市', 210700, '121.35549,41.160567', 'district', '121.35549', '41.160567', 3, NULL, '0416', '121200', 'Linghai', 'L', NULL);
INSERT INTO `ez_area` VALUES (210782, '北镇市', 210700, '121.777395,41.58844', 'district', '121.777395', '41.58844', 3, NULL, '0416', '121300', 'Beizhen', 'B', NULL);
INSERT INTO `ez_area` VALUES (210800, '营口市', 210000, '122.219458,40.625364', 'city', '122.219458', '40.625364', 2, NULL, '0417', '115003', 'Yingkou', 'Y', NULL);
INSERT INTO `ez_area` VALUES (210802, '站前区', 210800, '122.259033,40.672563', 'district', '122.259033', '40.672563', 3, NULL, '0417', '115002', 'Zhanqian', 'Z', NULL);
INSERT INTO `ez_area` VALUES (210803, '西市区', 210800, '122.206419,40.666213', 'district', '122.206419', '40.666213', 3, NULL, '0417', '115004', 'Xishi', 'X', NULL);
INSERT INTO `ez_area` VALUES (210804, '鲅鱼圈区', 210800, '122.121521,40.226661', 'district', '122.121521', '40.226661', 3, NULL, '0417', '115007', 'Bayuquan', 'B', NULL);
INSERT INTO `ez_area` VALUES (210811, '老边区', 210800, '122.380087,40.680191', 'district', '122.380087', '40.680191', 3, NULL, '0417', '115005', 'Laobian', 'L', NULL);
INSERT INTO `ez_area` VALUES (210881, '盖州市', 210800, '122.349012,40.40074', 'district', '122.349012', '40.40074', 3, NULL, '0417', '115200', 'Gaizhou', 'G', NULL);
INSERT INTO `ez_area` VALUES (210882, '大石桥市', 210800, '122.509006,40.644482', 'district', '122.509006', '40.644482', 3, NULL, '0417', '115100', 'Dashiqiao', 'D', NULL);
INSERT INTO `ez_area` VALUES (210900, '阜新市', 210000, '121.670273,42.021602', 'city', '121.670273', '42.021602', 2, NULL, '0418', '123000', 'Fuxin', 'F', NULL);
INSERT INTO `ez_area` VALUES (210902, '海州区', 210900, '121.657638,42.011162', 'district', '121.657638', '42.011162', 3, NULL, '0418', '123000', 'Haizhou', 'H', NULL);
INSERT INTO `ez_area` VALUES (210903, '新邱区', 210900, '121.792535,42.087632', 'district', '121.792535', '42.087632', 3, NULL, '0418', '123005', 'Xinqiu', 'X', NULL);
INSERT INTO `ez_area` VALUES (210904, '太平区', 210900, '121.678604,42.010669', 'district', '121.678604', '42.010669', 3, NULL, '0418', '123003', 'Taiping', 'T', NULL);
INSERT INTO `ez_area` VALUES (210905, '清河门区', 210900, '121.416105,41.7831', 'district', '121.416105', '41.7831', 3, NULL, '0418', '123006', 'Qinghemen', 'Q', NULL);
INSERT INTO `ez_area` VALUES (210911, '细河区', 210900, '121.68054,42.025494', 'district', '121.68054', '42.025494', 3, NULL, '0418', '123000', 'Xihe', 'X', NULL);
INSERT INTO `ez_area` VALUES (210921, '阜新蒙古族自治县', 210900, '121.757901,42.065175', 'district', '121.757901', '42.065175', 3, NULL, '0418', '123100', 'Fuxin', 'F', NULL);
INSERT INTO `ez_area` VALUES (210922, '彰武县', 210900, '122.538793,42.386543', 'district', '122.538793', '42.386543', 3, NULL, '0418', '123200', 'Zhangwu', 'Z', NULL);
INSERT INTO `ez_area` VALUES (211000, '辽阳市', 210000, '123.236974,41.267794', 'city', '123.236974', '41.267794', 2, NULL, '0419', '111000', 'Liaoyang', 'L', NULL);
INSERT INTO `ez_area` VALUES (211002, '白塔区', 211000, '123.174325,41.270347', 'district', '123.174325', '41.270347', 3, NULL, '0419', '111000', 'Baita', 'B', NULL);
INSERT INTO `ez_area` VALUES (211003, '文圣区', 211000, '123.231408,41.283754', 'district', '123.231408', '41.283754', 3, NULL, '0419', '111000', 'Wensheng', 'W', NULL);
INSERT INTO `ez_area` VALUES (211004, '宏伟区', 211000, '123.196672,41.217649', 'district', '123.196672', '41.217649', 3, NULL, '0419', '111003', 'Hongwei', 'H', NULL);
INSERT INTO `ez_area` VALUES (211005, '弓长岭区', 211000, '123.419803,41.151847', 'district', '123.419803', '41.151847', 3, NULL, '0419', '111008', 'Gongchangling', 'G', NULL);
INSERT INTO `ez_area` VALUES (211011, '太子河区', 211000, '123.18144,41.295023', 'district', '123.18144', '41.295023', 3, NULL, '0419', '111000', 'Taizihe', 'T', NULL);
INSERT INTO `ez_area` VALUES (211021, '辽阳县', 211000, '123.105694,41.205329', 'district', '123.105694', '41.205329', 3, NULL, '0419', '111200', 'Liaoyang', 'L', NULL);
INSERT INTO `ez_area` VALUES (211081, '灯塔市', 211000, '123.339312,41.426372', 'district', '123.339312', '41.426372', 3, NULL, '0419', '111300', 'Dengta', 'D', NULL);
INSERT INTO `ez_area` VALUES (211100, '盘锦市', 210000, '122.170584,40.719847', 'city', '122.170584', '40.719847', 2, NULL, '0427', '124010', 'Panjin', 'P', NULL);
INSERT INTO `ez_area` VALUES (211102, '双台子区', 211100, '122.039787,41.19965', 'district', '122.039787', '41.19965', 3, NULL, '0427', '124000', 'Shuangtaizi', 'S', NULL);
INSERT INTO `ez_area` VALUES (211103, '兴隆台区', 211100, '122.070769,41.119898', 'district', '122.070769', '41.119898', 3, NULL, '0427', '124010', 'Xinglongtai', 'X', NULL);
INSERT INTO `ez_area` VALUES (211104, '大洼区', 211100, '122.082574,41.002279', 'district', '122.082574', '41.002279', 3, NULL, '0427', '124200', 'Dawa', 'D', NULL);
INSERT INTO `ez_area` VALUES (211122, '盘山县', 211100, '121.996411,41.242639', 'district', '121.996411', '41.242639', 3, NULL, '0427', '124000', 'Panshan', 'P', NULL);
INSERT INTO `ez_area` VALUES (211200, '铁岭市', 210000, '123.726035,42.223828', 'city', '123.726035', '42.223828', 2, NULL, '024', '112000', 'Tieling', 'T', NULL);
INSERT INTO `ez_area` VALUES (211202, '银州区', 211200, '123.842305,42.286129', 'district', '123.842305', '42.286129', 3, NULL, '024', '112000', 'Yinzhou', 'Y', NULL);
INSERT INTO `ez_area` VALUES (211204, '清河区', 211200, '124.159191,42.546565', 'district', '124.159191', '42.546565', 3, NULL, '024', '112003', 'Qinghe', 'Q', NULL);
INSERT INTO `ez_area` VALUES (211221, '铁岭县', 211200, '123.728933,42.223395', 'district', '123.728933', '42.223395', 3, NULL, '024', '112000', 'Tieling', 'T', NULL);
INSERT INTO `ez_area` VALUES (211223, '西丰县', 211200, '124.727392,42.73803', 'district', '124.727392', '42.73803', 3, NULL, '024', '112400', 'Xifeng', 'X', NULL);
INSERT INTO `ez_area` VALUES (211224, '昌图县', 211200, '124.111099,42.785791', 'district', '124.111099', '42.785791', 3, NULL, '024', '112500', 'Changtu', 'C', NULL);
INSERT INTO `ez_area` VALUES (211281, '调兵山市', 211200, '123.567117,42.467521', 'district', '123.567117', '42.467521', 3, NULL, '024', '112700', 'Diaobingshan', 'D', NULL);
INSERT INTO `ez_area` VALUES (211282, '开原市', 211200, '124.038268,42.546307', 'district', '124.038268', '42.546307', 3, NULL, '024', '112300', 'Kaiyuan', 'K', NULL);
INSERT INTO `ez_area` VALUES (211300, '朝阳市', 210000, '120.450879,41.573762', 'city', '120.450879', '41.573762', 2, NULL, '0421', '122000', 'Chaoyang', 'C', NULL);
INSERT INTO `ez_area` VALUES (211302, '双塔区', 211300, '120.453744,41.565627', 'district', '120.453744', '41.565627', 3, NULL, '0421', '122000', 'Shuangta', 'S', NULL);
INSERT INTO `ez_area` VALUES (211303, '龙城区', 211300, '120.413376,41.576749', 'district', '120.413376', '41.576749', 3, NULL, '0421', '122000', 'Longcheng', 'L', NULL);
INSERT INTO `ez_area` VALUES (211321, '朝阳县', 211300, '120.389754,41.497825', 'district', '120.389754', '41.497825', 3, NULL, '0421', '122000', 'Chaoyang', 'C', NULL);
INSERT INTO `ez_area` VALUES (211322, '建平县', 211300, '119.64328,41.403128', 'district', '119.64328', '41.403128', 3, NULL, '0421', '122400', 'Jianping', 'J', NULL);
INSERT INTO `ez_area` VALUES (211324, '喀喇沁左翼蒙古族自治县', 211300, '119.741223,41.12815', 'district', '119.741223', '41.12815', 3, NULL, '0421', '122300', 'Kalaqinzuoyi', 'K', NULL);
INSERT INTO `ez_area` VALUES (211381, '北票市', 211300, '120.77073,41.800683', 'district', '120.77073', '41.800683', 3, NULL, '0421', '122100', 'Beipiao', 'B', NULL);
INSERT INTO `ez_area` VALUES (211382, '凌源市', 211300, '119.401574,41.245445', 'district', '119.401574', '41.245445', 3, NULL, '0421', '122500', 'Lingyuan', 'L', NULL);
INSERT INTO `ez_area` VALUES (211400, '葫芦岛市', 210000, '120.836939,40.71104', 'city', '120.836939', '40.71104', 2, NULL, '0429', '125000', 'Huludao', 'H', NULL);
INSERT INTO `ez_area` VALUES (211402, '连山区', 211400, '120.869231,40.774461', 'district', '120.869231', '40.774461', 3, NULL, '0429', '125001', 'Lianshan', 'L', NULL);
INSERT INTO `ez_area` VALUES (211403, '龙港区', 211400, '120.893786,40.735519', 'district', '120.893786', '40.735519', 3, NULL, '0429', '125003', 'Longgang', 'L', NULL);
INSERT INTO `ez_area` VALUES (211404, '南票区', 211400, '120.749727,41.107107', 'district', '120.749727', '41.107107', 3, NULL, '0429', '125027', 'Nanpiao', 'N', NULL);
INSERT INTO `ez_area` VALUES (211421, '绥中县', 211400, '120.344311,40.32558', 'district', '120.344311', '40.32558', 3, NULL, '0429', '125200', 'Suizhong', 'S', NULL);
INSERT INTO `ez_area` VALUES (211422, '建昌县', 211400, '119.837124,40.824367', 'district', '119.837124', '40.824367', 3, NULL, '0429', '125300', 'Jianchang', 'J', NULL);
INSERT INTO `ez_area` VALUES (211481, '兴城市', 211400, '120.756479,40.609731', 'district', '120.756479', '40.609731', 3, NULL, '0429', '125100', 'Xingcheng', 'X', NULL);
INSERT INTO `ez_area` VALUES (220000, '吉林省', 0, '125.32568,43.897016', 'province', '125.32568', '43.897016', 1, NULL, NULL, NULL, 'Jilin', 'J', NULL);
INSERT INTO `ez_area` VALUES (220100, '长春市', 220000, '125.323513,43.817251', 'city', '125.323513', '43.817251', 2, NULL, '0431', '130022', 'Changchun', 'C', NULL);
INSERT INTO `ez_area` VALUES (220102, '南关区', 220100, '125.350173,43.863989', 'district', '125.350173', '43.863989', 3, NULL, '0431', '130022', 'Nanguan', 'N', NULL);
INSERT INTO `ez_area` VALUES (220103, '宽城区', 220100, '125.326581,43.943612', 'district', '125.326581', '43.943612', 3, NULL, '0431', '130051', 'Kuancheng', 'K', NULL);
INSERT INTO `ez_area` VALUES (220104, '朝阳区', 220100, '125.288254,43.833762', 'district', '125.288254', '43.833762', 3, NULL, '0431', '130012', 'Chaoyang', 'C', NULL);
INSERT INTO `ez_area` VALUES (220105, '二道区', 220100, '125.374327,43.865577', 'district', '125.374327', '43.865577', 3, NULL, '0431', '130031', 'Erdao', 'E', NULL);
INSERT INTO `ez_area` VALUES (220106, '绿园区', 220100, '125.256135,43.880975', 'district', '125.256135', '43.880975', 3, NULL, '0431', '130062', 'Lvyuan', 'L', NULL);
INSERT INTO `ez_area` VALUES (220112, '双阳区', 220100, '125.664662,43.525311', 'district', '125.664662', '43.525311', 3, NULL, '0431', '130600', 'Shuangyang', 'S', NULL);
INSERT INTO `ez_area` VALUES (220113, '九台区', 220100, '125.839573,44.151742', 'district', '125.839573', '44.151742', 3, NULL, '0431', '130500', 'Jiutai', 'J', NULL);
INSERT INTO `ez_area` VALUES (220122, '农安县', 220100, '125.184887,44.432763', 'district', '125.184887', '44.432763', 3, NULL, '0431', '130200', 'Nong\'an', 'N', NULL);
INSERT INTO `ez_area` VALUES (220182, '榆树市', 220100, '126.533187,44.840318', 'district', '126.533187', '44.840318', 3, NULL, '0431', '130400', 'Yushu', 'Y', NULL);
INSERT INTO `ez_area` VALUES (220183, '德惠市', 220100, '125.728755,44.522056', 'district', '125.728755', '44.522056', 3, NULL, '0431', '130300', 'Dehui', 'D', NULL);
INSERT INTO `ez_area` VALUES (220200, '吉林市', 220000, '126.549572,43.837883', 'city', '126.549572', '43.837883', 2, NULL, '0432', '132011', 'Jilin', 'J', NULL);
INSERT INTO `ez_area` VALUES (220202, '昌邑区', 220200, '126.574709,43.881818', 'district', '126.574709', '43.881818', 3, NULL, '0432', '132002', 'Changyi', 'C', NULL);
INSERT INTO `ez_area` VALUES (220203, '龙潭区', 220200, '126.562197,43.910802', 'district', '126.562197', '43.910802', 3, NULL, '0432', '132021', 'Longtan', 'L', NULL);
INSERT INTO `ez_area` VALUES (220204, '船营区', 220200, '126.540966,43.833445', 'district', '126.540966', '43.833445', 3, NULL, '0432', '132011', 'Chuanying', 'C', NULL);
INSERT INTO `ez_area` VALUES (220211, '丰满区', 220200, '126.562274,43.821601', 'district', '126.562274', '43.821601', 3, NULL, '0432', '132013', 'Fengman', 'F', NULL);
INSERT INTO `ez_area` VALUES (220221, '永吉县', 220200, '126.497741,43.672582', 'district', '126.497741', '43.672582', 3, NULL, '0432', '132200', 'Yongji', 'Y', NULL);
INSERT INTO `ez_area` VALUES (220281, '蛟河市', 220200, '127.344229,43.724007', 'district', '127.344229', '43.724007', 3, NULL, '0432', '132500', 'Jiaohe', 'J', NULL);
INSERT INTO `ez_area` VALUES (220282, '桦甸市', 220200, '126.746309,42.972096', 'district', '126.746309', '42.972096', 3, NULL, '0432', '132400', 'Huadian', 'H', NULL);
INSERT INTO `ez_area` VALUES (220283, '舒兰市', 220200, '126.965607,44.406105', 'district', '126.965607', '44.406105', 3, NULL, '0432', '132600', 'Shulan', 'S', NULL);
INSERT INTO `ez_area` VALUES (220284, '磐石市', 220200, '126.060427,42.946285', 'district', '126.060427', '42.946285', 3, NULL, '0432', '132300', 'Panshi', 'P', NULL);
INSERT INTO `ez_area` VALUES (220300, '四平市', 220000, '124.350398,43.166419', 'city', '124.350398', '43.166419', 2, NULL, '0434', '136000', 'Siping', 'S', NULL);
INSERT INTO `ez_area` VALUES (220302, '铁西区', 220300, '124.345722,43.146155', 'district', '124.345722', '43.146155', 3, NULL, '0434', '136000', 'Tiexi', 'T', NULL);
INSERT INTO `ez_area` VALUES (220303, '铁东区', 220300, '124.409591,43.162105', 'district', '124.409591', '43.162105', 3, NULL, '0434', '136001', 'Tiedong', 'T', NULL);
INSERT INTO `ez_area` VALUES (220322, '梨树县', 220300, '124.33539,43.30706', 'district', '124.33539', '43.30706', 3, NULL, '0434', '136500', 'Lishu', 'L', NULL);
INSERT INTO `ez_area` VALUES (220323, '伊通满族自治县', 220300, '125.305393,43.345754', 'district', '125.305393', '43.345754', 3, NULL, '0434', '130700', 'Yitong', 'Y', NULL);
INSERT INTO `ez_area` VALUES (220381, '公主岭市', 220300, '124.822929,43.504676', 'district', '124.822929', '43.504676', 3, NULL, '0434', '136100', 'Gongzhuling', 'G', NULL);
INSERT INTO `ez_area` VALUES (220382, '双辽市', 220300, '123.502723,43.518302', 'district', '123.502723', '43.518302', 3, NULL, '0434', '136400', 'Shuangliao', 'S', NULL);
INSERT INTO `ez_area` VALUES (220400, '辽源市', 220000, '125.14366,42.887766', 'city', '125.14366', '42.887766', 2, NULL, '0437', '136200', 'Liaoyuan', 'L', NULL);
INSERT INTO `ez_area` VALUES (220402, '龙山区', 220400, '125.136627,42.90158', 'district', '125.136627', '42.90158', 3, NULL, '0437', '136200', 'Longshan', 'L', NULL);
INSERT INTO `ez_area` VALUES (220403, '西安区', 220400, '125.149281,42.927324', 'district', '125.149281', '42.927324', 3, NULL, '0437', '136201', 'Xi\'an', 'X', NULL);
INSERT INTO `ez_area` VALUES (220421, '东丰县', 220400, '125.531021,42.677371', 'district', '125.531021', '42.677371', 3, NULL, '0437', '136300', 'Dongfeng', 'D', NULL);
INSERT INTO `ez_area` VALUES (220422, '东辽县', 220400, '124.991424,42.92625', 'district', '124.991424', '42.92625', 3, NULL, '0437', '136600', 'Dongliao', 'D', NULL);
INSERT INTO `ez_area` VALUES (220500, '通化市', 220000, '125.939697,41.728401', 'city', '125.939697', '41.728401', 2, NULL, '0435', '134001', 'Tonghua', 'T', NULL);
INSERT INTO `ez_area` VALUES (220502, '东昌区', 220500, '125.927101,41.702859', 'district', '125.927101', '41.702859', 3, NULL, '0435', '134001', 'Dongchang', 'D', NULL);
INSERT INTO `ez_area` VALUES (220503, '二道江区', 220500, '126.042678,41.774044', 'district', '126.042678', '41.774044', 3, NULL, '0435', '134003', 'Erdaojiang', 'E', NULL);
INSERT INTO `ez_area` VALUES (220521, '通化县', 220500, '125.759259,41.679808', 'district', '125.759259', '41.679808', 3, NULL, '0435', '134100', 'Tonghua', 'T', NULL);
INSERT INTO `ez_area` VALUES (220523, '辉南县', 220500, '126.046783,42.684921', 'district', '126.046783', '42.684921', 3, NULL, '0435', '135100', 'Huinan', 'H', NULL);
INSERT INTO `ez_area` VALUES (220524, '柳河县', 220500, '125.744735,42.284605', 'district', '125.744735', '42.284605', 3, NULL, '0435', '135300', 'Liuhe', 'L', NULL);
INSERT INTO `ez_area` VALUES (220581, '梅河口市', 220500, '125.710859,42.539253', 'district', '125.710859', '42.539253', 3, NULL, '0435', '135000', 'Meihekou', 'M', NULL);
INSERT INTO `ez_area` VALUES (220582, '集安市', 220500, '126.19403,41.125307', 'district', '126.19403', '41.125307', 3, NULL, '0435', '134200', 'Ji\'an', 'J', NULL);
INSERT INTO `ez_area` VALUES (220600, '白山市', 220000, '126.41473,41.943972', 'city', '126.41473', '41.943972', 2, NULL, '0439', '134300', 'Baishan', 'B', NULL);
INSERT INTO `ez_area` VALUES (220602, '浑江区', 220600, '126.416093,41.945409', 'district', '126.416093', '41.945409', 3, NULL, '0439', '134300', 'Hunjiang', 'H', NULL);
INSERT INTO `ez_area` VALUES (220605, '江源区', 220600, '126.591178,42.056747', 'district', '126.591178', '42.056747', 3, NULL, '0439', '134700', 'Jiangyuan', 'J', NULL);
INSERT INTO `ez_area` VALUES (220621, '抚松县', 220600, '127.449763,42.221207', 'district', '127.449763', '42.221207', 3, NULL, '0439', '134500', 'Fusong', 'F', NULL);
INSERT INTO `ez_area` VALUES (220622, '靖宇县', 220600, '126.813583,42.388896', 'district', '126.813583', '42.388896', 3, NULL, '0439', '135200', 'Jingyu', 'J', NULL);
INSERT INTO `ez_area` VALUES (220623, '长白朝鲜族自治县', 220600, '128.200789,41.420018', 'district', '128.200789', '41.420018', 3, NULL, '0439', '134400', 'Changbai', 'C', NULL);
INSERT INTO `ez_area` VALUES (220681, '临江市', 220600, '126.918087,41.811979', 'district', '126.918087', '41.811979', 3, NULL, '0439', '134600', 'Linjiang', 'L', NULL);
INSERT INTO `ez_area` VALUES (220700, '松原市', 220000, '124.825042,45.141548', 'city', '124.825042', '45.141548', 2, NULL, '0438', '138000', 'Songyuan', 'S', NULL);
INSERT INTO `ez_area` VALUES (220702, '宁江区', 220700, '124.86562,45.209915', 'district', '124.86562', '45.209915', 3, NULL, '0438', '138000', 'Ningjiang', 'N', NULL);
INSERT INTO `ez_area` VALUES (220721, '前郭尔罗斯蒙古族自治县', 220700, '124.823417,45.118061', 'district', '124.823417', '45.118061', 3, NULL, '0438', '138000', 'Qianguoerluosi', 'Q', NULL);
INSERT INTO `ez_area` VALUES (220722, '长岭县', 220700, '123.967483,44.275895', 'district', '123.967483', '44.275895', 3, NULL, '0438', '131500', 'Changling', 'C', NULL);
INSERT INTO `ez_area` VALUES (220723, '乾安县', 220700, '124.041139,45.003773', 'district', '124.041139', '45.003773', 3, NULL, '0438', '131400', 'Qian\'an', 'Q', NULL);
INSERT INTO `ez_area` VALUES (220781, '扶余市', 220700, '126.049803,44.9892', 'district', '126.049803', '44.9892', 3, NULL, '0438', '131200', 'Fuyu', 'F', NULL);
INSERT INTO `ez_area` VALUES (220800, '白城市', 220000, '122.838714,45.619884', 'city', '122.838714', '45.619884', 2, NULL, '0436', '137000', 'Baicheng', 'B', NULL);
INSERT INTO `ez_area` VALUES (220802, '洮北区', 220800, '122.851029,45.621716', 'district', '122.851029', '45.621716', 3, NULL, '0436', '137000', 'Taobei', 'T', NULL);
INSERT INTO `ez_area` VALUES (220821, '镇赉县', 220800, '123.199607,45.84835', 'district', '123.199607', '45.84835', 3, NULL, '0436', '137300', 'Zhenlai', 'Z', NULL);
INSERT INTO `ez_area` VALUES (220822, '通榆县', 220800, '123.088238,44.81291', 'district', '123.088238', '44.81291', 3, NULL, '0436', '137200', 'Tongyu', 'T', NULL);
INSERT INTO `ez_area` VALUES (220881, '洮南市', 220800, '122.798579,45.356807', 'district', '122.798579', '45.356807', 3, NULL, '0436', '137100', 'Taonan', 'T', NULL);
INSERT INTO `ez_area` VALUES (220882, '大安市', 220800, '124.292626,45.506996', 'district', '124.292626', '45.506996', 3, NULL, '0436', '131300', 'Da\'an', 'D', NULL);
INSERT INTO `ez_area` VALUES (222400, '延边朝鲜族自治州', 220000, '129.471868,42.909408', 'city', '129.471868', '42.909408', 2, NULL, '0433', '133000', 'Yanbian', 'Y', NULL);
INSERT INTO `ez_area` VALUES (222401, '延吉市', 222400, '129.508804,42.89125', 'district', '129.508804', '42.89125', 3, NULL, '0433', '133000', 'Yanji', 'Y', NULL);
INSERT INTO `ez_area` VALUES (222402, '图们市', 222400, '129.84371,42.968044', 'district', '129.84371', '42.968044', 3, NULL, '0433', '133100', 'Tumen', 'T', NULL);
INSERT INTO `ez_area` VALUES (222403, '敦化市', 222400, '128.232131,43.372642', 'district', '128.232131', '43.372642', 3, NULL, '0433', '133700', 'Dunhua', 'D', NULL);
INSERT INTO `ez_area` VALUES (222404, '珲春市', 222400, '130.366036,42.862821', 'district', '130.366036', '42.862821', 3, NULL, '0433', '133300', 'Hunchun', 'H', NULL);
INSERT INTO `ez_area` VALUES (222405, '龙井市', 222400, '129.427066,42.76631', 'district', '129.427066', '42.76631', 3, NULL, '0433', '133400', 'Longjing', 'L', NULL);
INSERT INTO `ez_area` VALUES (222406, '和龙市', 222400, '129.010106,42.546675', 'district', '129.010106', '42.546675', 3, NULL, '0433', '133500', 'Helong', 'H', NULL);
INSERT INTO `ez_area` VALUES (222424, '汪清县', 222400, '129.771607,43.312522', 'district', '129.771607', '43.312522', 3, NULL, '0433', '133200', 'Wangqing', 'W', NULL);
INSERT INTO `ez_area` VALUES (222426, '安图县', 222400, '128.899772,43.11195', 'district', '128.899772', '43.11195', 3, NULL, '0433', '133600', 'Antu', 'A', NULL);
INSERT INTO `ez_area` VALUES (230000, '黑龙江省', 0, '126.661665,45.742366', 'province', '126.661665', '45.742366', 1, NULL, NULL, NULL, 'Heilongjiang', 'H', NULL);
INSERT INTO `ez_area` VALUES (230100, '哈尔滨市', 230000, '126.534967,45.803775', 'city', '126.534967', '45.803775', 2, NULL, '0451', '150010', 'Harbin', 'H', NULL);
INSERT INTO `ez_area` VALUES (230102, '道里区', 230100, '126.616973,45.75577', 'district', '126.616973', '45.75577', 3, NULL, '0451', '150010', 'Daoli', 'D', NULL);
INSERT INTO `ez_area` VALUES (230103, '南岗区', 230100, '126.668784,45.760174', 'district', '126.668784', '45.760174', 3, NULL, '0451', '150006', 'Nangang', 'N', NULL);
INSERT INTO `ez_area` VALUES (230104, '道外区', 230100, '126.64939,45.792057', 'district', '126.64939', '45.792057', 3, NULL, '0451', '150020', 'Daowai', 'D', NULL);
INSERT INTO `ez_area` VALUES (230108, '平房区', 230100, '126.637611,45.597911', 'district', '126.637611', '45.597911', 3, NULL, '0451', '150060', 'Pingfang', 'P', NULL);
INSERT INTO `ez_area` VALUES (230109, '松北区', 230100, '126.516914,45.794504', 'district', '126.516914', '45.794504', 3, NULL, '0451', '150028', 'Songbei', 'S', NULL);
INSERT INTO `ez_area` VALUES (230110, '香坊区', 230100, '126.662593,45.707716', 'district', '126.662593', '45.707716', 3, NULL, '0451', '150036', 'Xiangfang', 'X', NULL);
INSERT INTO `ez_area` VALUES (230111, '呼兰区', 230100, '126.587905,45.889457', 'district', '126.587905', '45.889457', 3, NULL, '0451', '150500', 'Hulan', 'H', NULL);
INSERT INTO `ez_area` VALUES (230112, '阿城区', 230100, '126.958098,45.548669', 'district', '126.958098', '45.548669', 3, NULL, '0451', '150300', 'A\'cheng', 'A', NULL);
INSERT INTO `ez_area` VALUES (230113, '双城区', 230100, '126.312624,45.383218', 'district', '126.312624', '45.383218', 3, NULL, '0451', '150100', 'Shuangcheng', 'S', NULL);
INSERT INTO `ez_area` VALUES (230123, '依兰县', 230100, '129.567877,46.325419', 'district', '129.567877', '46.325419', 3, NULL, '0451', '154800', 'Yilan', 'Y', NULL);
INSERT INTO `ez_area` VALUES (230124, '方正县', 230100, '128.829536,45.851694', 'district', '128.829536', '45.851694', 3, NULL, '0451', '150800', 'Fangzheng', 'F', NULL);
INSERT INTO `ez_area` VALUES (230125, '宾县', 230100, '127.466634,45.745917', 'district', '127.466634', '45.745917', 3, NULL, '0451', '150400', 'Binxian', 'B', NULL);
INSERT INTO `ez_area` VALUES (230126, '巴彦县', 230100, '127.403781,46.086549', 'district', '127.403781', '46.086549', 3, NULL, '0451', '151800', 'Bayan', 'B', NULL);
INSERT INTO `ez_area` VALUES (230127, '木兰县', 230100, '128.043466,45.950582', 'district', '128.043466', '45.950582', 3, NULL, '0451', '151900', 'Mulan', 'M', NULL);
INSERT INTO `ez_area` VALUES (230128, '通河县', 230100, '128.746124,45.990205', 'district', '128.746124', '45.990205', 3, NULL, '0451', '150900', 'Tonghe', 'T', NULL);
INSERT INTO `ez_area` VALUES (230129, '延寿县', 230100, '128.331643,45.451897', 'district', '128.331643', '45.451897', 3, NULL, '0451', '150700', 'Yanshou', 'Y', NULL);
INSERT INTO `ez_area` VALUES (230183, '尚志市', 230100, '128.009894,45.209586', 'district', '128.009894', '45.209586', 3, NULL, '0451', '150600', 'Shangzhi', 'S', NULL);
INSERT INTO `ez_area` VALUES (230184, '五常市', 230100, '127.167618,44.931991', 'district', '127.167618', '44.931991', 3, NULL, '0451', '150200', 'Wuchang', 'W', NULL);
INSERT INTO `ez_area` VALUES (230200, '齐齐哈尔市', 230000, '123.918186,47.354348', 'city', '123.918186', '47.354348', 2, NULL, '0452', '161005', 'Qiqihar', 'Q', NULL);
INSERT INTO `ez_area` VALUES (230202, '龙沙区', 230200, '123.957531,47.317308', 'district', '123.957531', '47.317308', 3, NULL, '0452', '161000', 'Longsha', 'L', NULL);
INSERT INTO `ez_area` VALUES (230203, '建华区', 230200, '123.955464,47.354364', 'district', '123.955464', '47.354364', 3, NULL, '0452', '161006', 'Jianhua', 'J', NULL);
INSERT INTO `ez_area` VALUES (230204, '铁锋区', 230200, '123.978293,47.340517', 'district', '123.978293', '47.340517', 3, NULL, '0452', '161000', 'Tiefeng', 'T', NULL);
INSERT INTO `ez_area` VALUES (230205, '昂昂溪区', 230200, '123.8224,47.15516', 'district', '123.8224', '47.15516', 3, NULL, '0452', '161031', 'Angangxi', 'A', NULL);
INSERT INTO `ez_area` VALUES (230206, '富拉尔基区', 230200, '123.629189,47.208843', 'district', '123.629189', '47.208843', 3, NULL, '0452', '161041', 'Fulaerji', 'F', NULL);
INSERT INTO `ez_area` VALUES (230207, '碾子山区', 230200, '122.887775,47.516872', 'district', '122.887775', '47.516872', 3, NULL, '0452', '161046', 'Nianzishan', 'N', NULL);
INSERT INTO `ez_area` VALUES (230208, '梅里斯达斡尔族区', 230200, '123.75291,47.309537', 'district', '123.75291', '47.309537', 3, NULL, '0452', '161021', 'Meilisi', 'M', NULL);
INSERT INTO `ez_area` VALUES (230221, '龙江县', 230200, '123.205323,47.338665', 'district', '123.205323', '47.338665', 3, NULL, '0452', '161100', 'Longjiang', 'L', NULL);
INSERT INTO `ez_area` VALUES (230223, '依安县', 230200, '125.306278,47.893548', 'district', '125.306278', '47.893548', 3, NULL, '0452', '161500', 'Yi\'an', 'Y', NULL);
INSERT INTO `ez_area` VALUES (230224, '泰来县', 230200, '123.416631,46.393694', 'district', '123.416631', '46.393694', 3, NULL, '0452', '162400', 'Tailai', 'T', NULL);
INSERT INTO `ez_area` VALUES (230225, '甘南县', 230200, '123.507429,47.922405', 'district', '123.507429', '47.922405', 3, NULL, '0452', '162100', 'Gannan', 'G', NULL);
INSERT INTO `ez_area` VALUES (230227, '富裕县', 230200, '124.473793,47.774347', 'district', '124.473793', '47.774347', 3, NULL, '0452', '161200', 'Fuyu', 'F', NULL);
INSERT INTO `ez_area` VALUES (230229, '克山县', 230200, '125.875705,48.037031', 'district', '125.875705', '48.037031', 3, NULL, '0452', '161600', 'Keshan', 'K', NULL);
INSERT INTO `ez_area` VALUES (230230, '克东县', 230200, '126.24872,48.04206', 'district', '126.24872', '48.04206', 3, NULL, '0452', '164800', 'Kedong', 'K', NULL);
INSERT INTO `ez_area` VALUES (230231, '拜泉县', 230200, '126.100213,47.595851', 'district', '126.100213', '47.595851', 3, NULL, '0452', '164700', 'Baiquan', 'B', NULL);
INSERT INTO `ez_area` VALUES (230281, '讷河市', 230200, '124.88287,48.466592', 'district', '124.88287', '48.466592', 3, NULL, '0452', '161300', 'Nehe', 'N', NULL);
INSERT INTO `ez_area` VALUES (230300, '鸡西市', 230000, '130.969333,45.295075', 'city', '130.969333', '45.295075', 2, NULL, '0467', '158100', 'Jixi', 'J', NULL);
INSERT INTO `ez_area` VALUES (230302, '鸡冠区', 230300, '130.981185,45.304355', 'district', '130.981185', '45.304355', 3, NULL, '0467', '158100', 'Jiguan', 'J', NULL);
INSERT INTO `ez_area` VALUES (230303, '恒山区', 230300, '130.904963,45.210668', 'district', '130.904963', '45.210668', 3, NULL, '0467', '158130', 'Hengshan', 'H', NULL);
INSERT INTO `ez_area` VALUES (230304, '滴道区', 230300, '130.843613,45.348763', 'district', '130.843613', '45.348763', 3, NULL, '0467', '158150', 'Didao', 'D', NULL);
INSERT INTO `ez_area` VALUES (230305, '梨树区', 230300, '130.69699,45.092046', 'district', '130.69699', '45.092046', 3, NULL, '0467', '158160', 'Lishu', 'L', NULL);
INSERT INTO `ez_area` VALUES (230306, '城子河区', 230300, '131.011304,45.33697', 'district', '131.011304', '45.33697', 3, NULL, '0467', '158170', 'Chengzihe', 'C', NULL);
INSERT INTO `ez_area` VALUES (230307, '麻山区', 230300, '130.478187,45.212088', 'district', '130.478187', '45.212088', 3, NULL, '0467', '158180', 'Mashan', 'M', NULL);
INSERT INTO `ez_area` VALUES (230321, '鸡东县', 230300, '131.124079,45.260412', 'district', '131.124079', '45.260412', 3, NULL, '0467', '158200', 'Jidong', 'J', NULL);
INSERT INTO `ez_area` VALUES (230381, '虎林市', 230300, '132.93721,45.762685', 'district', '132.93721', '45.762685', 3, NULL, '0467', '158400', 'Hulin', 'H', NULL);
INSERT INTO `ez_area` VALUES (230382, '密山市', 230300, '131.846635,45.529774', 'district', '131.846635', '45.529774', 3, NULL, '0467', '158300', 'Mishan', 'M', NULL);
INSERT INTO `ez_area` VALUES (230400, '鹤岗市', 230000, '130.297943,47.350189', 'city', '130.297943', '47.350189', 2, NULL, '0468', '154100', 'Hegang', 'H', NULL);
INSERT INTO `ez_area` VALUES (230402, '向阳区', 230400, '130.294235,47.342468', 'district', '130.294235', '47.342468', 3, NULL, '0468', '154100', 'Xiangyang', 'X', NULL);
INSERT INTO `ez_area` VALUES (230403, '工农区', 230400, '130.274684,47.31878', 'district', '130.274684', '47.31878', 3, NULL, '0468', '154101', 'Gongnong', 'G', NULL);
INSERT INTO `ez_area` VALUES (230404, '南山区', 230400, '130.286788,47.315174', 'district', '130.286788', '47.315174', 3, NULL, '0468', '154104', 'Nanshan', 'N', NULL);
INSERT INTO `ez_area` VALUES (230405, '兴安区', 230400, '130.239245,47.252849', 'district', '130.239245', '47.252849', 3, NULL, '0468', '154102', 'Xing\'an', 'X', NULL);
INSERT INTO `ez_area` VALUES (230406, '东山区', 230400, '130.317002,47.338537', 'district', '130.317002', '47.338537', 3, NULL, '0468', '154106', 'Dongshan', 'D', NULL);
INSERT INTO `ez_area` VALUES (230407, '兴山区', 230400, '130.303481,47.357702', 'district', '130.303481', '47.357702', 3, NULL, '0468', '154105', 'Xingshan', 'X', NULL);
INSERT INTO `ez_area` VALUES (230421, '萝北县', 230400, '130.85155,47.576444', 'district', '130.85155', '47.576444', 3, NULL, '0468', '154200', 'Luobei', 'L', NULL);
INSERT INTO `ez_area` VALUES (230422, '绥滨县', 230400, '131.852759,47.289115', 'district', '131.852759', '47.289115', 3, NULL, '0468', '156200', 'Suibin', 'S', NULL);
INSERT INTO `ez_area` VALUES (230500, '双鸭山市', 230000, '131.141195,46.676418', 'city', '131.141195', '46.676418', 2, NULL, '0469', '155100', 'Shuangyashan', 'S', NULL);
INSERT INTO `ez_area` VALUES (230502, '尖山区', 230500, '131.158415,46.64635', 'district', '131.158415', '46.64635', 3, NULL, '0469', '155100', 'Jianshan', 'J', NULL);
INSERT INTO `ez_area` VALUES (230503, '岭东区', 230500, '131.164723,46.592721', 'district', '131.164723', '46.592721', 3, NULL, '0469', '155120', 'Lingdong', 'L', NULL);
INSERT INTO `ez_area` VALUES (230505, '四方台区', 230500, '131.337592,46.597264', 'district', '131.337592', '46.597264', 3, NULL, '0469', '155130', 'Sifangtai', 'S', NULL);
INSERT INTO `ez_area` VALUES (230506, '宝山区', 230500, '131.401589,46.577167', 'district', '131.401589', '46.577167', 3, NULL, '0469', '155131', 'Baoshan', 'B', NULL);
INSERT INTO `ez_area` VALUES (230521, '集贤县', 230500, '131.141311,46.728412', 'district', '131.141311', '46.728412', 3, NULL, '0469', '155900', 'Jixian', 'J', NULL);
INSERT INTO `ez_area` VALUES (230522, '友谊县', 230500, '131.808063,46.767299', 'district', '131.808063', '46.767299', 3, NULL, '0469', '155800', 'Youyi', 'Y', NULL);
INSERT INTO `ez_area` VALUES (230523, '宝清县', 230500, '132.196853,46.327457', 'district', '132.196853', '46.327457', 3, NULL, '0469', '155600', 'Baoqing', 'B', NULL);
INSERT INTO `ez_area` VALUES (230524, '饶河县', 230500, '134.013872,46.798163', 'district', '134.013872', '46.798163', 3, NULL, '0469', '155700', 'Raohe', 'R', NULL);
INSERT INTO `ez_area` VALUES (230600, '大庆市', 230000, '125.103784,46.589309', 'city', '125.103784', '46.589309', 2, NULL, '0459', '163000', 'Daqing', 'D', NULL);
INSERT INTO `ez_area` VALUES (230602, '萨尔图区', 230600, '125.135591,46.629092', 'district', '125.135591', '46.629092', 3, NULL, '0459', '163001', 'Saertu', 'S', NULL);
INSERT INTO `ez_area` VALUES (230603, '龙凤区', 230600, '125.135326,46.562247', 'district', '125.135326', '46.562247', 3, NULL, '0459', '163711', 'Longfeng', 'L', NULL);
INSERT INTO `ez_area` VALUES (230604, '让胡路区', 230600, '124.870596,46.652357', 'district', '124.870596', '46.652357', 3, NULL, '0459', '163712', 'Ranghulu', 'R', NULL);
INSERT INTO `ez_area` VALUES (230605, '红岗区', 230600, '124.891039,46.398418', 'district', '124.891039', '46.398418', 3, NULL, '0459', '163511', 'Honggang', 'H', NULL);
INSERT INTO `ez_area` VALUES (230606, '大同区', 230600, '124.812364,46.039827', 'district', '124.812364', '46.039827', 3, NULL, '0459', '163515', 'Datong', 'D', NULL);
INSERT INTO `ez_area` VALUES (230621, '肇州县', 230600, '125.268643,45.699066', 'district', '125.268643', '45.699066', 3, NULL, '0459', '166400', 'Zhaozhou', 'Z', NULL);
INSERT INTO `ez_area` VALUES (230622, '肇源县', 230600, '125.078223,45.51932', 'district', '125.078223', '45.51932', 3, NULL, '0459', '166500', 'Zhaoyuan', 'Z', NULL);
INSERT INTO `ez_area` VALUES (230623, '林甸县', 230600, '124.863603,47.171717', 'district', '124.863603', '47.171717', 3, NULL, '0459', '166300', 'Lindian', 'L', NULL);
INSERT INTO `ez_area` VALUES (230624, '杜尔伯特蒙古族自治县', 230600, '124.442572,46.862817', 'district', '124.442572', '46.862817', 3, NULL, '0459', '166200', 'Duerbote', 'D', NULL);
INSERT INTO `ez_area` VALUES (230700, '伊春市', 230000, '128.841125,47.727535', 'city', '128.841125', '47.727535', 2, NULL, '0458', '153000', 'Yichun', 'Y', NULL);
INSERT INTO `ez_area` VALUES (230702, '伊春区', 230700, '128.907257,47.728237', 'district', '128.907257', '47.728237', 3, NULL, '0458', '153000', 'Yichun', 'Y', NULL);
INSERT INTO `ez_area` VALUES (230703, '南岔区', 230700, '129.283467,47.138034', 'district', '129.283467', '47.138034', 3, NULL, '0458', '153100', 'Nancha', 'N', NULL);
INSERT INTO `ez_area` VALUES (230704, '友好区', 230700, '128.836291,47.841032', 'district', '128.836291', '47.841032', 3, NULL, '0458', '153031', 'Youhao', 'Y', NULL);
INSERT INTO `ez_area` VALUES (230705, '西林区', 230700, '129.312851,47.480735', 'district', '129.312851', '47.480735', 3, NULL, '0458', '153025', 'Xilin', 'X', NULL);
INSERT INTO `ez_area` VALUES (230706, '翠峦区', 230700, '128.669754,47.726394', 'district', '128.669754', '47.726394', 3, NULL, '0458', '153013', 'Cuiluan', 'C', NULL);
INSERT INTO `ez_area` VALUES (230707, '新青区', 230700, '129.533599,48.290455', 'district', '129.533599', '48.290455', 3, NULL, '0458', '153036', 'Xinqing', 'X', NULL);
INSERT INTO `ez_area` VALUES (230708, '美溪区', 230700, '129.129314,47.63509', 'district', '129.129314', '47.63509', 3, NULL, '0458', '153021', 'Meixi', 'M', NULL);
INSERT INTO `ez_area` VALUES (230709, '金山屯区', 230700, '129.429117,47.413074', 'district', '129.429117', '47.413074', 3, NULL, '0458', '153026', 'Jinshantun', 'J', NULL);
INSERT INTO `ez_area` VALUES (230710, '五营区', 230700, '129.245343,48.10791', 'district', '129.245343', '48.10791', 3, NULL, '0458', '153033', 'Wuying', 'W', NULL);
INSERT INTO `ez_area` VALUES (230711, '乌马河区', 230700, '128.799477,47.727687', 'district', '128.799477', '47.727687', 3, NULL, '0458', '153011', 'Wumahe', 'W', NULL);
INSERT INTO `ez_area` VALUES (230712, '汤旺河区', 230700, '129.571108,48.454651', 'district', '129.571108', '48.454651', 3, NULL, '0458', '153037', 'Tangwanghe', 'T', NULL);
INSERT INTO `ez_area` VALUES (230713, '带岭区', 230700, '129.020888,47.028379', 'district', '129.020888', '47.028379', 3, NULL, '0458', '153106', 'Dailing', 'D', NULL);
INSERT INTO `ez_area` VALUES (230714, '乌伊岭区', 230700, '129.43792,48.590322', 'district', '129.43792', '48.590322', 3, NULL, '0458', '153038', 'Wuyiling', 'W', NULL);
INSERT INTO `ez_area` VALUES (230715, '红星区', 230700, '129.390983,48.239431', 'district', '129.390983', '48.239431', 3, NULL, '0458', '153035', 'Hongxing', 'H', NULL);
INSERT INTO `ez_area` VALUES (230716, '上甘岭区', 230700, '129.02426,47.974707', 'district', '129.02426', '47.974707', 3, NULL, '0458', '153032', 'Shangganling', 'S', NULL);
INSERT INTO `ez_area` VALUES (230722, '嘉荫县', 230700, '130.403134,48.888972', 'district', '130.403134', '48.888972', 3, NULL, '0458', '153200', 'Jiayin', 'J', NULL);
INSERT INTO `ez_area` VALUES (230781, '铁力市', 230700, '128.032424,46.986633', 'district', '128.032424', '46.986633', 3, NULL, '0458', '152500', 'Tieli', 'T', NULL);
INSERT INTO `ez_area` VALUES (230800, '佳木斯市', 230000, '130.318878,46.799777', 'city', '130.318878', '46.799777', 2, NULL, '0454', '154002', 'Jiamusi', 'J', NULL);
INSERT INTO `ez_area` VALUES (230803, '向阳区', 230800, '130.365346,46.80779', 'district', '130.365346', '46.80779', 3, NULL, '0454', '154002', 'Xiangyang', 'X', NULL);
INSERT INTO `ez_area` VALUES (230804, '前进区', 230800, '130.375062,46.814102', 'district', '130.375062', '46.814102', 3, NULL, '0454', '154002', 'Qianjin', 'Q', NULL);
INSERT INTO `ez_area` VALUES (230805, '东风区', 230800, '130.403664,46.822571', 'district', '130.403664', '46.822571', 3, NULL, '0454', '154005', 'Dongfeng', 'D', NULL);
INSERT INTO `ez_area` VALUES (230811, '郊区', 230800, '130.327194,46.810085', 'district', '130.327194', '46.810085', 3, NULL, '0454', '154004', 'Jiaoqu', 'J', NULL);
INSERT INTO `ez_area` VALUES (230822, '桦南县', 230800, '130.553343,46.239184', 'district', '130.553343', '46.239184', 3, NULL, '0454', '154400', 'Huanan', 'H', NULL);
INSERT INTO `ez_area` VALUES (230826, '桦川县', 230800, '130.71908,47.023001', 'district', '130.71908', '47.023001', 3, NULL, '0454', '154300', 'Huachuan', 'H', NULL);
INSERT INTO `ez_area` VALUES (230828, '汤原县', 230800, '129.905072,46.730706', 'district', '129.905072', '46.730706', 3, NULL, '0454', '154700', 'Tangyuan', 'T', NULL);
INSERT INTO `ez_area` VALUES (230881, '同江市', 230800, '132.510919,47.642707', 'district', '132.510919', '47.642707', 3, NULL, '0454', '156400', 'Tongjiang', 'T', NULL);
INSERT INTO `ez_area` VALUES (230882, '富锦市', 230800, '132.037686,47.250107', 'district', '132.037686', '47.250107', 3, NULL, '0454', '156100', 'Fujin', 'F', NULL);
INSERT INTO `ez_area` VALUES (230883, '抚远市', 230800, '134.307884,48.364687', 'district', '134.307884', '48.364687', 3, NULL, '0454', '156500', 'Fuyuan', 'F', NULL);
INSERT INTO `ez_area` VALUES (230900, '七台河市', 230000, '131.003082,45.771396', 'city', '131.003082', '45.771396', 2, NULL, '0464', '154600', 'Qitaihe', 'Q', NULL);
INSERT INTO `ez_area` VALUES (230902, '新兴区', 230900, '130.932143,45.81593', 'district', '130.932143', '45.81593', 3, NULL, '0464', '154604', 'Xinxing', 'X', NULL);
INSERT INTO `ez_area` VALUES (230903, '桃山区', 230900, '131.020202,45.765705', 'district', '131.020202', '45.765705', 3, NULL, '0464', '154600', 'Taoshan', 'T', NULL);
INSERT INTO `ez_area` VALUES (230904, '茄子河区', 230900, '131.068075,45.785215', 'district', '131.068075', '45.785215', 3, NULL, '0464', '154622', 'Qiezihe', 'Q', NULL);
INSERT INTO `ez_area` VALUES (230921, '勃利县', 230900, '130.59217,45.755063', 'district', '130.59217', '45.755063', 3, NULL, '0464', '154500', 'Boli', 'B', NULL);
INSERT INTO `ez_area` VALUES (231000, '牡丹江市', 230000, '129.633168,44.551653', 'city', '129.633168', '44.551653', 2, NULL, '0453', '157000', 'Mudanjiang', 'M', NULL);
INSERT INTO `ez_area` VALUES (231002, '东安区', 231000, '129.626641,44.58136', 'district', '129.626641', '44.58136', 3, NULL, '0453', '157000', 'Dong\'an', 'D', NULL);
INSERT INTO `ez_area` VALUES (231003, '阳明区', 231000, '129.635615,44.596104', 'district', '129.635615', '44.596104', 3, NULL, '0453', '157013', 'Yangming', 'Y', NULL);
INSERT INTO `ez_area` VALUES (231004, '爱民区', 231000, '129.591537,44.596042', 'district', '129.591537', '44.596042', 3, NULL, '0453', '157009', 'Aimin', 'A', NULL);
INSERT INTO `ez_area` VALUES (231005, '西安区', 231000, '129.616058,44.577625', 'district', '129.616058', '44.577625', 3, NULL, '0453', '157000', 'Xi\'an', 'X', NULL);
INSERT INTO `ez_area` VALUES (231025, '林口县', 231000, '130.284033,45.278046', 'district', '130.284033', '45.278046', 3, NULL, '0453', '157600', 'Linkou', 'L', NULL);
INSERT INTO `ez_area` VALUES (231081, '绥芬河市', 231000, '131.152545,44.412308', 'district', '131.152545', '44.412308', 3, NULL, '0453', '157300', 'Suifenhe', 'S', NULL);
INSERT INTO `ez_area` VALUES (231083, '海林市', 231000, '129.380481,44.594213', 'district', '129.380481', '44.594213', 3, NULL, '0453', '157100', 'Hailin', 'H', NULL);
INSERT INTO `ez_area` VALUES (231084, '宁安市', 231000, '129.482851,44.34072', 'district', '129.482851', '44.34072', 3, NULL, '0453', '157400', 'Ning\'an', 'N', NULL);
INSERT INTO `ez_area` VALUES (231085, '穆棱市', 231000, '130.524436,44.918813', 'district', '130.524436', '44.918813', 3, NULL, '0453', '157500', 'Muling', 'M', NULL);
INSERT INTO `ez_area` VALUES (231086, '东宁市', 231000, '131.122915,44.087585', 'district', '131.122915', '44.087585', 3, NULL, '0453', '157200', 'Dongning', 'D', NULL);
INSERT INTO `ez_area` VALUES (231100, '黑河市', 230000, '127.528293,50.245129', 'city', '127.528293', '50.245129', 2, NULL, '0456', '164300', 'Heihe', 'H', NULL);
INSERT INTO `ez_area` VALUES (231102, '爱辉区', 231100, '127.50045,50.252105', 'district', '127.50045', '50.252105', 3, NULL, '0456', '164300', 'Aihui', 'A', NULL);
INSERT INTO `ez_area` VALUES (231121, '嫩江县', 231100, '125.221192,49.185766', 'district', '125.221192', '49.185766', 3, NULL, '0456', '161400', 'Nenjiang', 'N', NULL);
INSERT INTO `ez_area` VALUES (231123, '逊克县', 231100, '128.478749,49.564252', 'district', '128.478749', '49.564252', 3, NULL, '0456', '164400', 'Xunke', 'X', NULL);
INSERT INTO `ez_area` VALUES (231124, '孙吴县', 231100, '127.336303,49.425647', 'district', '127.336303', '49.425647', 3, NULL, '0456', '164200', 'Sunwu', 'S', NULL);
INSERT INTO `ez_area` VALUES (231181, '北安市', 231100, '126.490864,48.241365', 'district', '126.490864', '48.241365', 3, NULL, '0456', '164000', 'Bei\'an', 'B', NULL);
INSERT INTO `ez_area` VALUES (231182, '五大连池市', 231100, '126.205516,48.517257', 'district', '126.205516', '48.517257', 3, NULL, '0456', '164100', 'Wudalianchi', 'W', NULL);
INSERT INTO `ez_area` VALUES (231200, '绥化市', 230000, '126.968887,46.653845', 'city', '126.968887', '46.653845', 2, NULL, '0455', '152000', 'Suihua', 'S', NULL);
INSERT INTO `ez_area` VALUES (231202, '北林区', 231200, '126.985504,46.6375', 'district', '126.985504', '46.6375', 3, NULL, '0455', '152000', 'Beilin', 'B', NULL);
INSERT INTO `ez_area` VALUES (231221, '望奎县', 231200, '126.486075,46.832719', 'district', '126.486075', '46.832719', 3, NULL, '0455', '152100', 'Wangkui', 'W', NULL);
INSERT INTO `ez_area` VALUES (231222, '兰西县', 231200, '126.288117,46.25245', 'district', '126.288117', '46.25245', 3, NULL, '0455', '151500', 'Lanxi', 'L', NULL);
INSERT INTO `ez_area` VALUES (231223, '青冈县', 231200, '126.099195,46.70391', 'district', '126.099195', '46.70391', 3, NULL, '0455', '151600', 'Qinggang', 'Q', NULL);
INSERT INTO `ez_area` VALUES (231224, '庆安县', 231200, '127.507824,46.880102', 'district', '127.507824', '46.880102', 3, NULL, '0455', '152400', 'Qing\'an', 'Q', NULL);
INSERT INTO `ez_area` VALUES (231225, '明水县', 231200, '125.906301,47.173426', 'district', '125.906301', '47.173426', 3, NULL, '0455', '151700', 'Mingshui', 'M', NULL);
INSERT INTO `ez_area` VALUES (231226, '绥棱县', 231200, '127.114832,47.236015', 'district', '127.114832', '47.236015', 3, NULL, '0455', '152200', 'Suileng', 'S', NULL);
INSERT INTO `ez_area` VALUES (231281, '安达市', 231200, '125.346156,46.419633', 'district', '125.346156', '46.419633', 3, NULL, '0455', '151400', 'Anda', 'A', NULL);
INSERT INTO `ez_area` VALUES (231282, '肇东市', 231200, '125.961814,46.051126', 'district', '125.961814', '46.051126', 3, NULL, '0455', '151100', 'Zhaodong', 'Z', NULL);
INSERT INTO `ez_area` VALUES (231283, '海伦市', 231200, '126.930106,47.45117', 'district', '126.930106', '47.45117', 3, NULL, '0455', '152300', 'Hailun', 'H', NULL);
INSERT INTO `ez_area` VALUES (232700, '大兴安岭地区', 230000, '124.711526,52.335262', 'city', '124.711526', '52.335262', 2, NULL, '0457', '165000', 'DaXingAnLing', 'D', NULL);
INSERT INTO `ez_area` VALUES (232701, '加格达奇区', 232700, '124.139595,50.408735', 'district', '124.139595', '50.408735', 3, NULL, '0457', '165000', 'Jiagedaqi', 'J', NULL);
INSERT INTO `ez_area` VALUES (232721, '呼玛县', 232700, '126.652396,51.726091', 'district', '126.652396', '51.726091', 3, NULL, '0457', '165100', 'Huma', 'H', NULL);
INSERT INTO `ez_area` VALUES (232722, '塔河县', 232700, '124.709996,52.334456', 'district', '124.709996', '52.334456', 3, NULL, '0457', '165200', 'Tahe', 'T', NULL);
INSERT INTO `ez_area` VALUES (232723, '漠河县', 232700, '122.538591,52.972272', 'district', '122.538591', '52.972272', 3, NULL, '0457', '165300', 'Mohe', 'M', NULL);
INSERT INTO `ez_area` VALUES (310000, '上海市', 0, '121.473662,31.230372', 'province', '121.473662', '31.230372', 1, NULL, NULL, NULL, 'Shanghai', 'S', NULL);
INSERT INTO `ez_area` VALUES (310100, '上海城区', 310000, '121.473662,31.230372', 'city', '121.473662', '31.230372', 2, NULL, '021', '200000', 'Shanghai', 'S', NULL);
INSERT INTO `ez_area` VALUES (310101, '黄浦区', 310100, '121.484428,31.231739', 'district', '121.484428', '31.231739', 3, NULL, '021', '200001', 'Huangpu', 'H', NULL);
INSERT INTO `ez_area` VALUES (310104, '徐汇区', 310100, '121.436128,31.188464', 'district', '121.436128', '31.188464', 3, NULL, '021', '200030', 'Xuhui', 'X', NULL);
INSERT INTO `ez_area` VALUES (310105, '长宁区', 310100, '121.424622,31.220372', 'district', '121.424622', '31.220372', 3, NULL, '021', '200050', 'Changning', 'C', NULL);
INSERT INTO `ez_area` VALUES (310106, '静安区', 310100, '121.447453,31.227906', 'district', '121.447453', '31.227906', 3, NULL, '021', '200040', 'Jing\'an', 'J', NULL);
INSERT INTO `ez_area` VALUES (310107, '普陀区', 310100, '121.395514,31.249603', 'district', '121.395514', '31.249603', 3, NULL, '021', '200333', 'Putuo', 'P', NULL);
INSERT INTO `ez_area` VALUES (310109, '虹口区', 310100, '121.505133,31.2646', 'district', '121.505133', '31.2646', 3, NULL, '021', '200086', 'Hongkou', 'H', NULL);
INSERT INTO `ez_area` VALUES (310110, '杨浦区', 310100, '121.525727,31.259822', 'district', '121.525727', '31.259822', 3, NULL, '021', '200082', 'Yangpu', 'Y', NULL);
INSERT INTO `ez_area` VALUES (310112, '闵行区', 310100, '121.380831,31.1129', 'district', '121.380831', '31.1129', 3, NULL, '021', '201100', 'Minhang', 'M', NULL);
INSERT INTO `ez_area` VALUES (310113, '宝山区', 310100, '121.489612,31.405457', 'district', '121.489612', '31.405457', 3, NULL, '021', '201900', 'Baoshan', 'B', NULL);
INSERT INTO `ez_area` VALUES (310114, '嘉定区', 310100, '121.265374,31.375869', 'district', '121.265374', '31.375869', 3, NULL, '021', '201800', 'Jiading', 'J', NULL);
INSERT INTO `ez_area` VALUES (310115, '浦东新区', 310100, '121.544379,31.221517', 'district', '121.544379', '31.221517', 3, NULL, '021', '200135', 'Pudong', 'P', NULL);
INSERT INTO `ez_area` VALUES (310116, '金山区', 310100, '121.342455,30.741798', 'district', '121.342455', '30.741798', 3, NULL, '021', '200540', 'Jinshan', 'J', NULL);
INSERT INTO `ez_area` VALUES (310117, '松江区', 310100, '121.227747,31.032243', 'district', '121.227747', '31.032243', 3, NULL, '021', '201600', 'Songjiang', 'S', NULL);
INSERT INTO `ez_area` VALUES (310118, '青浦区', 310100, '121.124178,31.150681', 'district', '121.124178', '31.150681', 3, NULL, '021', '201700', 'Qingpu', 'Q', NULL);
INSERT INTO `ez_area` VALUES (310120, '奉贤区', 310100, '121.474055,30.917766', 'district', '121.474055', '30.917766', 3, NULL, '021', '201400', 'Fengxian', 'F', NULL);
INSERT INTO `ez_area` VALUES (310151, '崇明区', 310100, '121.397421,31.623728', 'district', '121.397421', '31.623728', 3, NULL, '021', '202150', 'Chongming', 'C', NULL);
INSERT INTO `ez_area` VALUES (320000, '江苏省', 0, '118.762765,32.060875', 'province', '118.762765', '32.060875', 1, NULL, NULL, NULL, 'Jiangsu', 'J', NULL);
INSERT INTO `ez_area` VALUES (320100, '南京市', 320000, '118.796682,32.05957', 'city', '118.796682', '32.05957', 2, NULL, '025', '210008', 'Nanjing', 'N', NULL);
INSERT INTO `ez_area` VALUES (320102, '玄武区', 320100, '118.797757,32.048498', 'district', '118.797757', '32.048498', 3, NULL, '025', '210018', 'Xuanwu', 'X', NULL);
INSERT INTO `ez_area` VALUES (320104, '秦淮区', 320100, '118.79476,32.039113', 'district', '118.79476', '32.039113', 3, NULL, '025', '210001', 'Qinhuai', 'Q', NULL);
INSERT INTO `ez_area` VALUES (320105, '建邺区', 320100, '118.731793,32.003731', 'district', '118.731793', '32.003731', 3, NULL, '025', '210004', 'Jianye', 'J', NULL);
INSERT INTO `ez_area` VALUES (320106, '鼓楼区', 320100, '118.770182,32.066601', 'district', '118.770182', '32.066601', 3, NULL, '025', '210009', 'Gulou', 'G', NULL);
INSERT INTO `ez_area` VALUES (320111, '浦口区', 320100, '118.628003,32.058903', 'district', '118.628003', '32.058903', 3, NULL, '025', '211800', 'Pukou', 'P', NULL);
INSERT INTO `ez_area` VALUES (320113, '栖霞区', 320100, '118.909153,32.096388', 'district', '118.909153', '32.096388', 3, NULL, '025', '210046', 'Qixia', 'Q', NULL);
INSERT INTO `ez_area` VALUES (320114, '雨花台区', 320100, '118.779051,31.99126', 'district', '118.779051', '31.99126', 3, NULL, '025', '210012', 'Yuhuatai', 'Y', NULL);
INSERT INTO `ez_area` VALUES (320115, '江宁区', 320100, '118.840015,31.952612', 'district', '118.840015', '31.952612', 3, NULL, '025', '211100', 'Jiangning', 'J', NULL);
INSERT INTO `ez_area` VALUES (320116, '六合区', 320100, '118.822132,32.323584', 'district', '118.822132', '32.323584', 3, NULL, '025', '211500', 'Luhe', 'L', NULL);
INSERT INTO `ez_area` VALUES (320117, '溧水区', 320100, '119.028288,31.651099', 'district', '119.028288', '31.651099', 3, NULL, '025', '211200', 'Lishui', 'L', NULL);
INSERT INTO `ez_area` VALUES (320118, '高淳区', 320100, '118.89222,31.327586', 'district', '118.89222', '31.327586', 3, NULL, '025', '211300', 'Gaochun', 'G', NULL);
INSERT INTO `ez_area` VALUES (320200, '无锡市', 320000, '120.31191,31.491169', 'city', '120.31191', '31.491169', 2, NULL, '0510', '214000', 'Wuxi', 'W', NULL);
INSERT INTO `ez_area` VALUES (320205, '锡山区', 320200, '120.357858,31.589715', 'district', '120.357858', '31.589715', 3, NULL, '0510', '214101', 'Xishan', 'X', NULL);
INSERT INTO `ez_area` VALUES (320206, '惠山区', 320200, '120.298433,31.680335', 'district', '120.298433', '31.680335', 3, NULL, '0510', '214174', 'Huishan', 'H', NULL);
INSERT INTO `ez_area` VALUES (320211, '滨湖区', 320200, '120.283811,31.527276', 'district', '120.283811', '31.527276', 3, NULL, '0510', '214123', 'Binhu', 'B', NULL);
INSERT INTO `ez_area` VALUES (320213, '梁溪区', 320200, '120.303108,31.566155', 'district', '120.303108', '31.566155', 3, NULL, '0510', '214000', 'Liangxi', 'L', NULL);
INSERT INTO `ez_area` VALUES (320214, '新吴区', 320200, '120.352782,31.550966', 'district', '120.352782', '31.550966', 3, NULL, '0510', '214028', 'Xinwu', 'X', NULL);
INSERT INTO `ez_area` VALUES (320281, '江阴市', 320200, '120.286129,31.921345', 'district', '120.286129', '31.921345', 3, NULL, '0510', '214431', 'Jiangyin', 'J', NULL);
INSERT INTO `ez_area` VALUES (320282, '宜兴市', 320200, '119.823308,31.340637', 'district', '119.823308', '31.340637', 3, NULL, '0510', '214200', 'Yixing', 'Y', NULL);
INSERT INTO `ez_area` VALUES (320300, '徐州市', 320000, '117.284124,34.205768', 'city', '117.284124', '34.205768', 2, NULL, '0516', '221003', 'Xuzhou', 'X', NULL);
INSERT INTO `ez_area` VALUES (320302, '鼓楼区', 320300, '117.185576,34.288646', 'district', '117.185576', '34.288646', 3, NULL, '0516', '221005', 'Gulou', 'G', NULL);
INSERT INTO `ez_area` VALUES (320303, '云龙区', 320300, '117.251076,34.253164', 'district', '117.251076', '34.253164', 3, NULL, '0516', '221007', 'Yunlong', 'Y', NULL);
INSERT INTO `ez_area` VALUES (320305, '贾汪区', 320300, '117.464958,34.436936', 'district', '117.464958', '34.436936', 3, NULL, '0516', '221003', 'Jiawang', 'J', NULL);
INSERT INTO `ez_area` VALUES (320311, '泉山区', 320300, '117.194469,34.225522', 'district', '117.194469', '34.225522', 3, NULL, '0516', '221006', 'Quanshan', 'Q', NULL);
INSERT INTO `ez_area` VALUES (320312, '铜山区', 320300, '117.169461,34.180779', 'district', '117.169461', '34.180779', 3, NULL, '0516', '221106', 'Tongshan', 'T', NULL);
INSERT INTO `ez_area` VALUES (320321, '丰县', 320300, '116.59539,34.693906', 'district', '116.59539', '34.693906', 3, NULL, '0516', '221700', 'Fengxian', 'F', NULL);
INSERT INTO `ez_area` VALUES (320322, '沛县', 320300, '116.936353,34.760761', 'district', '116.936353', '34.760761', 3, NULL, '0516', '221600', 'Peixian', 'P', NULL);
INSERT INTO `ez_area` VALUES (320324, '睢宁县', 320300, '117.941563,33.912597', 'district', '117.941563', '33.912597', 3, NULL, '0516', '221200', 'Suining', 'S', NULL);
INSERT INTO `ez_area` VALUES (320381, '新沂市', 320300, '118.354537,34.36958', 'district', '118.354537', '34.36958', 3, NULL, '0516', '221400', 'Xinyi', 'X', NULL);
INSERT INTO `ez_area` VALUES (320382, '邳州市', 320300, '118.012531,34.338888', 'district', '118.012531', '34.338888', 3, NULL, '0516', '221300', 'Pizhou', 'P', NULL);
INSERT INTO `ez_area` VALUES (320400, '常州市', 320000, '119.974061,31.811226', 'city', '119.974061', '31.811226', 2, NULL, '0519', '213000', 'Changzhou', 'C', NULL);
INSERT INTO `ez_area` VALUES (320402, '天宁区', 320400, '119.999219,31.792787', 'district', '119.999219', '31.792787', 3, NULL, '0519', '213000', 'Tianning', 'T', NULL);
INSERT INTO `ez_area` VALUES (320404, '钟楼区', 320400, '119.902369,31.802089', 'district', '119.902369', '31.802089', 3, NULL, '0519', '213023', 'Zhonglou', 'Z', NULL);
INSERT INTO `ez_area` VALUES (320411, '新北区', 320400, '119.971697,31.830427', 'district', '119.971697', '31.830427', 3, NULL, '0519', '213022', 'Xinbei', 'X', NULL);
INSERT INTO `ez_area` VALUES (320412, '武进区', 320400, '119.942437,31.701187', 'district', '119.942437', '31.701187', 3, NULL, '0519', '213100', 'Wujin', 'W', NULL);
INSERT INTO `ez_area` VALUES (320413, '金坛区', 320400, '119.597811,31.723219', 'district', '119.597811', '31.723219', 3, NULL, '0519', '213200', 'Jintan', 'J', NULL);
INSERT INTO `ez_area` VALUES (320481, '溧阳市', 320400, '119.48421,31.416911', 'district', '119.48421', '31.416911', 3, NULL, '0519', '213300', 'Liyang', 'L', NULL);
INSERT INTO `ez_area` VALUES (320500, '苏州市', 320000, '120.585728,31.2974', 'city', '120.585728', '31.2974', 2, NULL, '0512', '215002', 'Suzhou', 'S', NULL);
INSERT INTO `ez_area` VALUES (320505, '虎丘区', 320500, '120.434238,31.329601', 'district', '120.434238', '31.329601', 3, NULL, '0512', '215004', 'Huqiu', 'H', NULL);
INSERT INTO `ez_area` VALUES (320506, '吴中区', 320500, '120.632308,31.263183', 'district', '120.632308', '31.263183', 3, NULL, '0512', '215128', 'Wuzhong', 'W', NULL);
INSERT INTO `ez_area` VALUES (320507, '相城区', 320500, '120.642626,31.369089', 'district', '120.642626', '31.369089', 3, NULL, '0512', '215131', 'Xiangcheng', 'X', NULL);
INSERT INTO `ez_area` VALUES (320508, '姑苏区', 320500, '120.617369,31.33565', 'district', '120.617369', '31.33565', 3, NULL, '0512', '215031', 'Gusu', 'G', NULL);
INSERT INTO `ez_area` VALUES (320509, '吴江区', 320500, '120.645157,31.138677', 'district', '120.645157', '31.138677', 3, NULL, '0512', '215200', 'Wujiang', 'W', NULL);
INSERT INTO `ez_area` VALUES (320581, '常熟市', 320500, '120.752481,31.654375', 'district', '120.752481', '31.654375', 3, NULL, '0512', '215500', 'Changshu', 'C', NULL);
INSERT INTO `ez_area` VALUES (320582, '张家港市', 320500, '120.555982,31.875571', 'district', '120.555982', '31.875571', 3, NULL, '0512', '215600', 'Zhangjiagang', 'Z', NULL);
INSERT INTO `ez_area` VALUES (320583, '昆山市', 320500, '120.980736,31.385597', 'district', '120.980736', '31.385597', 3, NULL, '0512', '215300', 'Kunshan', 'K', NULL);
INSERT INTO `ez_area` VALUES (320585, '太仓市', 320500, '121.13055,31.457735', 'district', '121.13055', '31.457735', 3, NULL, '0512', '215400', 'Taicang', 'T', NULL);
INSERT INTO `ez_area` VALUES (320600, '南通市', 320000, '120.894676,31.981143', 'city', '120.894676', '31.981143', 2, NULL, '0513', '226001', 'Nantong', 'N', NULL);
INSERT INTO `ez_area` VALUES (320602, '崇川区', 320600, '120.857434,32.009875', 'district', '120.857434', '32.009875', 3, NULL, '0513', '226001', 'Chongchuan', 'C', NULL);
INSERT INTO `ez_area` VALUES (320611, '港闸区', 320600, '120.818526,32.032441', 'district', '120.818526', '32.032441', 3, NULL, '0513', '226001', 'Gangzha', 'G', NULL);
INSERT INTO `ez_area` VALUES (320612, '通州区', 320600, '121.073828,32.06568', 'district', '121.073828', '32.06568', 3, NULL, '0513', '226300', 'Tongzhou', 'T', NULL);
INSERT INTO `ez_area` VALUES (320621, '海安县', 320600, '120.467343,32.533572', 'district', '120.467343', '32.533572', 3, NULL, '0513', '226600', 'Hai\'an', 'H', NULL);
INSERT INTO `ez_area` VALUES (320623, '如东县', 320600, '121.185201,32.331765', 'district', '121.185201', '32.331765', 3, NULL, '0513', '226400', 'Rudong', 'R', NULL);
INSERT INTO `ez_area` VALUES (320681, '启东市', 320600, '121.655432,31.793278', 'district', '121.655432', '31.793278', 3, NULL, '0513', '226200', 'Qidong', 'Q', NULL);
INSERT INTO `ez_area` VALUES (320682, '如皋市', 320600, '120.573803,32.371562', 'district', '120.573803', '32.371562', 3, NULL, '0513', '226500', 'Rugao', 'R', NULL);
INSERT INTO `ez_area` VALUES (320684, '海门市', 320600, '121.18181,31.869483', 'district', '121.18181', '31.869483', 3, NULL, '0513', '226100', 'Haimen', 'H', NULL);
INSERT INTO `ez_area` VALUES (320700, '连云港市', 320000, '119.221611,34.596653', 'city', '119.221611', '34.596653', 2, NULL, '0518', '222002', 'Lianyungang', 'L', NULL);
INSERT INTO `ez_area` VALUES (320703, '连云区', 320700, '119.338788,34.760249', 'district', '119.338788', '34.760249', 3, NULL, '0518', '222042', 'Lianyun', 'L', NULL);
INSERT INTO `ez_area` VALUES (320706, '海州区', 320700, '119.163509,34.572274', 'district', '119.163509', '34.572274', 3, NULL, '0518', '222003', 'Haizhou', 'H', NULL);
INSERT INTO `ez_area` VALUES (320707, '赣榆区', 320700, '119.17333,34.841348', 'district', '119.17333', '34.841348', 3, NULL, '0518', '222100', 'Ganyu', 'G', NULL);
INSERT INTO `ez_area` VALUES (320722, '东海县', 320700, '118.752842,34.542308', 'district', '118.752842', '34.542308', 3, NULL, '0518', '222300', 'Donghai', 'D', NULL);
INSERT INTO `ez_area` VALUES (320723, '灌云县', 320700, '119.239381,34.284381', 'district', '119.239381', '34.284381', 3, NULL, '0518', '222200', 'Guanyun', 'G', NULL);
INSERT INTO `ez_area` VALUES (320724, '灌南县', 320700, '119.315651,34.087134', 'district', '119.315651', '34.087134', 3, NULL, '0518', '222500', 'Guannan', 'G', NULL);
INSERT INTO `ez_area` VALUES (320800, '淮安市', 320000, '119.113185,33.551052', 'city', '119.113185', '33.551052', 2, NULL, '0517', '223001', 'Huai\'an', 'H', NULL);
INSERT INTO `ez_area` VALUES (320803, '淮安区', 320800, '119.141099,33.502868', 'district', '119.141099', '33.502868', 3, NULL, '0517', '223200', 'Huai\'an', 'H', NULL);
INSERT INTO `ez_area` VALUES (320804, '淮阴区', 320800, '119.034725,33.631892', 'district', '119.034725', '33.631892', 3, NULL, '0517', '223300', 'Huaiyin', 'H', NULL);
INSERT INTO `ez_area` VALUES (320812, '清江浦区', 320800, '119.026718,33.552627', 'district', '119.026718', '33.552627', 3, NULL, '0517', '223001', 'Qingjiangpu', 'Q', NULL);
INSERT INTO `ez_area` VALUES (320813, '洪泽区', 320800, '118.873241,33.294214', 'district', '118.873241', '33.294214', 3, NULL, '0517', '223100', 'Hongze', 'H', NULL);
INSERT INTO `ez_area` VALUES (320826, '涟水县', 320800, '119.260227,33.781331', 'district', '119.260227', '33.781331', 3, NULL, '0517', '223400', 'Lianshui', 'L', NULL);
INSERT INTO `ez_area` VALUES (320830, '盱眙县', 320800, '118.54436,33.011971', 'district', '118.54436', '33.011971', 3, NULL, '0517', '211700', 'Xuyi', 'X', NULL);
INSERT INTO `ez_area` VALUES (320831, '金湖县', 320800, '119.020584,33.025433', 'district', '119.020584', '33.025433', 3, NULL, '0517', '211600', 'Jinhu', 'J', NULL);
INSERT INTO `ez_area` VALUES (320900, '盐城市', 320000, '120.163107,33.347708', 'city', '120.163107', '33.347708', 2, NULL, '0515', '224005', 'Yancheng', 'Y', NULL);
INSERT INTO `ez_area` VALUES (320902, '亭湖区', 320900, '120.197358,33.390536', 'district', '120.197358', '33.390536', 3, NULL, '0515', '224005', 'Tinghu', 'T', NULL);
INSERT INTO `ez_area` VALUES (320903, '盐都区', 320900, '120.153712,33.338283', 'district', '120.153712', '33.338283', 3, NULL, '0515', '224055', 'Yandu', 'Y', NULL);
INSERT INTO `ez_area` VALUES (320904, '大丰区', 320900, '120.50085,33.200333', 'district', '120.50085', '33.200333', 3, NULL, '0515', '224100', 'Dafeng', 'D', NULL);
INSERT INTO `ez_area` VALUES (320921, '响水县', 320900, '119.578364,34.199479', 'district', '119.578364', '34.199479', 3, NULL, '0515', '224600', 'Xiangshui', 'X', NULL);
INSERT INTO `ez_area` VALUES (320922, '滨海县', 320900, '119.82083,33.990334', 'district', '119.82083', '33.990334', 3, NULL, '0515', '224500', 'Binhai', 'B', NULL);
INSERT INTO `ez_area` VALUES (320923, '阜宁县', 320900, '119.802527,33.759325', 'district', '119.802527', '33.759325', 3, NULL, '0515', '224400', 'Funing', 'F', NULL);
INSERT INTO `ez_area` VALUES (320924, '射阳县', 320900, '120.229986,33.758361', 'district', '120.229986', '33.758361', 3, NULL, '0515', '224300', 'Sheyang', 'S', NULL);
INSERT INTO `ez_area` VALUES (320925, '建湖县', 320900, '119.7886,33.439067', 'district', '119.7886', '33.439067', 3, NULL, '0515', '224700', 'Jianhu', 'J', NULL);
INSERT INTO `ez_area` VALUES (320981, '东台市', 320900, '120.320328,32.868426', 'district', '120.320328', '32.868426', 3, NULL, '0515', '224200', 'Dongtai', 'D', NULL);
INSERT INTO `ez_area` VALUES (321000, '扬州市', 320000, '119.412939,32.394209', 'city', '119.412939', '32.394209', 2, NULL, '0514', '225002', 'Yangzhou', 'Y', NULL);
INSERT INTO `ez_area` VALUES (321002, '广陵区', 321000, '119.431849,32.39472', 'district', '119.431849', '32.39472', 3, NULL, '0514', '225002', 'Guangling', 'G', NULL);
INSERT INTO `ez_area` VALUES (321003, '邗江区', 321000, '119.397994,32.377655', 'district', '119.397994', '32.377655', 3, NULL, '0514', '225002', 'Hanjiang', 'H', NULL);
INSERT INTO `ez_area` VALUES (321012, '江都区', 321000, '119.569989,32.434672', 'district', '119.569989', '32.434672', 3, NULL, '0514', '225200', 'Jiangdu', 'J', NULL);
INSERT INTO `ez_area` VALUES (321023, '宝应县', 321000, '119.360729,33.240391', 'district', '119.360729', '33.240391', 3, NULL, '0514', '225800', 'Baoying', 'B', NULL);
INSERT INTO `ez_area` VALUES (321081, '仪征市', 321000, '119.184766,32.272258', 'district', '119.184766', '32.272258', 3, NULL, '0514', '211400', 'Yizheng', 'Y', NULL);
INSERT INTO `ez_area` VALUES (321084, '高邮市', 321000, '119.459161,32.781659', 'district', '119.459161', '32.781659', 3, NULL, '0514', '225600', 'Gaoyou', 'G', NULL);
INSERT INTO `ez_area` VALUES (321100, '镇江市', 320000, '119.425836,32.187849', 'city', '119.425836', '32.187849', 2, NULL, '0511', '212004', 'Zhenjiang', 'Z', NULL);
INSERT INTO `ez_area` VALUES (321102, '京口区', 321100, '119.47016,32.19828', 'district', '119.47016', '32.19828', 3, NULL, '0511', '212003', 'Jingkou', 'J', NULL);
INSERT INTO `ez_area` VALUES (321111, '润州区', 321100, '119.411959,32.195264', 'district', '119.411959', '32.195264', 3, NULL, '0511', '212005', 'Runzhou', 'R', NULL);
INSERT INTO `ez_area` VALUES (321112, '丹徒区', 321100, '119.433853,32.131962', 'district', '119.433853', '32.131962', 3, NULL, '0511', '212028', 'Dantu', 'D', NULL);
INSERT INTO `ez_area` VALUES (321181, '丹阳市', 321100, '119.606439,32.010214', 'district', '119.606439', '32.010214', 3, NULL, '0511', '212300', 'Danyang', 'D', NULL);
INSERT INTO `ez_area` VALUES (321182, '扬中市', 321100, '119.797634,32.23483', 'district', '119.797634', '32.23483', 3, NULL, '0511', '212200', 'Yangzhong', 'Y', NULL);
INSERT INTO `ez_area` VALUES (321183, '句容市', 321100, '119.168695,31.944998', 'district', '119.168695', '31.944998', 3, NULL, '0511', '212400', 'Jurong', 'J', NULL);
INSERT INTO `ez_area` VALUES (321200, '泰州市', 320000, '119.922933,32.455536', 'city', '119.922933', '32.455536', 2, NULL, '0523', '225300', 'Taizhou', 'T', NULL);
INSERT INTO `ez_area` VALUES (321202, '海陵区', 321200, '119.919424,32.491016', 'district', '119.919424', '32.491016', 3, NULL, '0523', '225300', 'Hailing', 'H', NULL);
INSERT INTO `ez_area` VALUES (321203, '高港区', 321200, '119.881717,32.318821', 'district', '119.881717', '32.318821', 3, NULL, '0523', '225321', 'Gaogang', 'G', NULL);
INSERT INTO `ez_area` VALUES (321204, '姜堰区', 321200, '120.127934,32.509155', 'district', '120.127934', '32.509155', 3, NULL, '0523', '225500', 'Jiangyan', 'J', NULL);
INSERT INTO `ez_area` VALUES (321281, '兴化市', 321200, '119.852541,32.910459', 'district', '119.852541', '32.910459', 3, NULL, '0523', '225700', 'Xinghua', 'X', NULL);
INSERT INTO `ez_area` VALUES (321282, '靖江市', 321200, '120.277138,31.982751', 'district', '120.277138', '31.982751', 3, NULL, '0523', '214500', 'Jingjiang', 'J', NULL);
INSERT INTO `ez_area` VALUES (321283, '泰兴市', 321200, '120.051743,32.171853', 'district', '120.051743', '32.171853', 3, NULL, '0523', '225400', 'Taixing', 'T', NULL);
INSERT INTO `ez_area` VALUES (321300, '宿迁市', 320000, '118.275198,33.963232', 'city', '118.275198', '33.963232', 2, NULL, '0527', '223800', 'Suqian', 'S', NULL);
INSERT INTO `ez_area` VALUES (321302, '宿城区', 321300, '118.242533,33.963029', 'district', '118.242533', '33.963029', 3, NULL, '0527', '223800', 'Sucheng', 'S', NULL);
INSERT INTO `ez_area` VALUES (321311, '宿豫区', 321300, '118.330781,33.946822', 'district', '118.330781', '33.946822', 3, NULL, '0527', '223800', 'Suyu', 'S', NULL);
INSERT INTO `ez_area` VALUES (321322, '沭阳县', 321300, '118.804784,34.111022', 'district', '118.804784', '34.111022', 3, NULL, '0527', '223600', 'Shuyang', 'S', NULL);
INSERT INTO `ez_area` VALUES (321323, '泗阳县', 321300, '118.703424,33.722478', 'district', '118.703424', '33.722478', 3, NULL, '0527', '223700', 'Siyang', 'S', NULL);
INSERT INTO `ez_area` VALUES (321324, '泗洪县', 321300, '118.223591,33.476051', 'district', '118.223591', '33.476051', 3, NULL, '0527', '223900', 'Sihong', 'S', NULL);
INSERT INTO `ez_area` VALUES (330000, '浙江省', 0, '120.152585,30.266597', 'province', '120.152585', '30.266597', 1, NULL, NULL, NULL, 'Zhejiang', 'Z', NULL);
INSERT INTO `ez_area` VALUES (330100, '杭州市', 330000, '120.209789,30.24692', 'city', '120.209789', '30.24692', 2, NULL, '0571', '310026', 'Hangzhou', 'H', NULL);
INSERT INTO `ez_area` VALUES (330102, '上城区', 330100, '120.169312,30.242404', 'district', '120.169312', '30.242404', 3, NULL, '0571', '310002', 'Shangcheng', 'S', NULL);
INSERT INTO `ez_area` VALUES (330103, '下城区', 330100, '120.180891,30.281677', 'district', '120.180891', '30.281677', 3, NULL, '0571', '310006', 'Xiacheng', 'X', NULL);
INSERT INTO `ez_area` VALUES (330104, '江干区', 330100, '120.205001,30.257012', 'district', '120.205001', '30.257012', 3, NULL, '0571', '310016', 'Jianggan', 'J', NULL);
INSERT INTO `ez_area` VALUES (330105, '拱墅区', 330100, '120.141406,30.319037', 'district', '120.141406', '30.319037', 3, NULL, '0571', '310011', 'Gongshu', 'G', NULL);
INSERT INTO `ez_area` VALUES (330106, '西湖区', 330100, '120.130194,30.259463', 'district', '120.130194', '30.259463', 3, NULL, '0571', '310013', 'Xihu', 'X', NULL);
INSERT INTO `ez_area` VALUES (330108, '滨江区', 330100, '120.211623,30.208847', 'district', '120.211623', '30.208847', 3, NULL, '0571', '310051', 'Binjiang', 'B', NULL);
INSERT INTO `ez_area` VALUES (330109, '萧山区', 330100, '120.264253,30.183806', 'district', '120.264253', '30.183806', 3, NULL, '0571', '311200', 'Xiaoshan', 'X', NULL);
INSERT INTO `ez_area` VALUES (330110, '余杭区', 330100, '120.299401,30.419045', 'district', '120.299401', '30.419045', 3, NULL, '0571', '311100', 'Yuhang', 'Y', NULL);
INSERT INTO `ez_area` VALUES (330111, '富阳区', 330100, '119.960076,30.048692', 'district', '119.960076', '30.048692', 3, NULL, '0571', '311400', 'Fuyang', 'F', NULL);
INSERT INTO `ez_area` VALUES (330122, '桐庐县', 330100, '119.691467,29.79299', 'district', '119.691467', '29.79299', 3, NULL, '0571', '311500', 'Tonglu', 'T', NULL);
INSERT INTO `ez_area` VALUES (330127, '淳安县', 330100, '119.042037,29.608886', 'district', '119.042037', '29.608886', 3, NULL, '0571', '311700', 'Chun\'an', 'C', NULL);
INSERT INTO `ez_area` VALUES (330182, '建德市', 330100, '119.281231,29.474759', 'district', '119.281231', '29.474759', 3, NULL, '0571', '311600', 'Jiande', 'J', NULL);
INSERT INTO `ez_area` VALUES (330185, '临安市', 330100, '119.724734,30.233873', 'district', '119.724734', '30.233873', 3, NULL, '0571', '311300', 'Lin\'an', 'L', NULL);
INSERT INTO `ez_area` VALUES (330200, '宁波市', 330000, '121.622485,29.859971', 'city', '121.622485', '29.859971', 2, NULL, '0574', '315000', 'Ningbo', 'N', NULL);
INSERT INTO `ez_area` VALUES (330203, '海曙区', 330200, '121.550752,29.874903', 'district', '121.550752', '29.874903', 3, NULL, '0574', '315000', 'Haishu', 'H', NULL);
INSERT INTO `ez_area` VALUES (330205, '江北区', 330200, '121.555081,29.886781', 'district', '121.555081', '29.886781', 3, NULL, '0574', '315020', 'Jiangbei', 'J', NULL);
INSERT INTO `ez_area` VALUES (330206, '北仑区', 330200, '121.844172,29.899778', 'district', '121.844172', '29.899778', 3, NULL, '0574', '315800', 'Beilun', 'B', NULL);
INSERT INTO `ez_area` VALUES (330211, '镇海区', 330200, '121.596496,29.965203', 'district', '121.596496', '29.965203', 3, NULL, '0574', '315200', 'Zhenhai', 'Z', NULL);
INSERT INTO `ez_area` VALUES (330212, '鄞州区', 330200, '121.546603,29.816511', 'district', '121.546603', '29.816511', 3, NULL, '0574', '315100', 'Yinzhou', 'Y', NULL);
INSERT INTO `ez_area` VALUES (330213, '奉化区', 330200, '121.406997,29.655144', 'district', '121.406997', '29.655144', 3, NULL, '0574', '315500', 'Fenghua', 'F', NULL);
INSERT INTO `ez_area` VALUES (330225, '象山县', 330200, '121.869339,29.476705', 'district', '121.869339', '29.476705', 3, NULL, '0574', '315700', 'Xiangshan', 'X', NULL);
INSERT INTO `ez_area` VALUES (330226, '宁海县', 330200, '121.429477,29.287939', 'district', '121.429477', '29.287939', 3, NULL, '0574', '315600', 'Ninghai', 'N', NULL);
INSERT INTO `ez_area` VALUES (330281, '余姚市', 330200, '121.154629,30.037106', 'district', '121.154629', '30.037106', 3, NULL, '0574', '315400', 'Yuyao', 'Y', NULL);
INSERT INTO `ez_area` VALUES (330282, '慈溪市', 330200, '121.266561,30.170261', 'district', '121.266561', '30.170261', 3, NULL, '0574', '315300', 'Cixi', 'C', NULL);
INSERT INTO `ez_area` VALUES (330300, '温州市', 330000, '120.699361,27.993828', 'city', '120.699361', '27.993828', 2, NULL, '0577', '325000', 'Wenzhou', 'W', NULL);
INSERT INTO `ez_area` VALUES (330302, '鹿城区', 330300, '120.655271,28.015737', 'district', '120.655271', '28.015737', 3, NULL, '0577', '325000', 'Lucheng', 'L', NULL);
INSERT INTO `ez_area` VALUES (330303, '龙湾区', 330300, '120.811213,27.932747', 'district', '120.811213', '27.932747', 3, NULL, '0577', '325013', 'Longwan', 'L', NULL);
INSERT INTO `ez_area` VALUES (330304, '瓯海区', 330300, '120.61491,27.966844', 'district', '120.61491', '27.966844', 3, NULL, '0577', '325005', 'Ouhai', 'O', NULL);
INSERT INTO `ez_area` VALUES (330305, '洞头区', 330300, '121.157249,27.836154', 'district', '121.157249', '27.836154', 3, NULL, '0577', '325700', 'Dongtou', 'D', NULL);
INSERT INTO `ez_area` VALUES (330324, '永嘉县', 330300, '120.692025,28.153607', 'district', '120.692025', '28.153607', 3, NULL, '0577', '325100', 'Yongjia', 'Y', NULL);
INSERT INTO `ez_area` VALUES (330326, '平阳县', 330300, '120.565793,27.661918', 'district', '120.565793', '27.661918', 3, NULL, '0577', '325400', 'Pingyang', 'P', NULL);
INSERT INTO `ez_area` VALUES (330327, '苍南县', 330300, '120.427619,27.519773', 'district', '120.427619', '27.519773', 3, NULL, '0577', '325800', 'Cangnan', 'C', NULL);
INSERT INTO `ez_area` VALUES (330328, '文成县', 330300, '120.091498,27.786996', 'district', '120.091498', '27.786996', 3, NULL, '0577', '325300', 'Wencheng', 'W', NULL);
INSERT INTO `ez_area` VALUES (330329, '泰顺县', 330300, '119.717649,27.556884', 'district', '119.717649', '27.556884', 3, NULL, '0577', '325500', 'Taishun', 'T', NULL);
INSERT INTO `ez_area` VALUES (330381, '瑞安市', 330300, '120.655148,27.778657', 'district', '120.655148', '27.778657', 3, NULL, '0577', '325200', 'Rui\'an', 'R', NULL);
INSERT INTO `ez_area` VALUES (330382, '乐清市', 330300, '120.983906,28.113725', 'district', '120.983906', '28.113725', 3, NULL, '0577', '325600', 'Yueqing', 'Y', NULL);
INSERT INTO `ez_area` VALUES (330400, '嘉兴市', 330000, '120.75547,30.746191', 'city', '120.75547', '30.746191', 2, NULL, '0573', '314000', 'Jiaxing', 'J', NULL);
INSERT INTO `ez_area` VALUES (330402, '南湖区', 330400, '120.783024,30.747842', 'district', '120.783024', '30.747842', 3, NULL, '0573', '314051', 'Nanhu', 'N', NULL);
INSERT INTO `ez_area` VALUES (330411, '秀洲区', 330400, '120.710082,30.765188', 'district', '120.710082', '30.765188', 3, NULL, '0573', '314031', 'Xiuzhou', 'X', NULL);
INSERT INTO `ez_area` VALUES (330421, '嘉善县', 330400, '120.926028,30.830864', 'district', '120.926028', '30.830864', 3, NULL, '0573', '314100', 'Jiashan', 'J', NULL);
INSERT INTO `ez_area` VALUES (330424, '海盐县', 330400, '120.946263,30.526435', 'district', '120.946263', '30.526435', 3, NULL, '0573', '314300', 'Haiyan', 'H', NULL);
INSERT INTO `ez_area` VALUES (330481, '海宁市', 330400, '120.680239,30.511539', 'district', '120.680239', '30.511539', 3, NULL, '0573', '314400', 'Haining', 'H', NULL);
INSERT INTO `ez_area` VALUES (330482, '平湖市', 330400, '121.015142,30.677233', 'district', '121.015142', '30.677233', 3, NULL, '0573', '314200', 'Pinghu', 'P', NULL);
INSERT INTO `ez_area` VALUES (330483, '桐乡市', 330400, '120.565098,30.630173', 'district', '120.565098', '30.630173', 3, NULL, '0573', '314500', 'Tongxiang', 'T', NULL);
INSERT INTO `ez_area` VALUES (330500, '湖州市', 330000, '120.086809,30.89441', 'city', '120.086809', '30.89441', 2, NULL, '0572', '313000', 'Huzhou', 'H', NULL);
INSERT INTO `ez_area` VALUES (330502, '吴兴区', 330500, '120.185838,30.857151', 'district', '120.185838', '30.857151', 3, NULL, '0572', '313000', 'Wuxing', 'W', NULL);
INSERT INTO `ez_area` VALUES (330503, '南浔区', 330500, '120.418513,30.849689', 'district', '120.418513', '30.849689', 3, NULL, '0572', '313009', 'Nanxun', 'N', NULL);
INSERT INTO `ez_area` VALUES (330521, '德清县', 330500, '119.9774,30.54251', 'district', '119.9774', '30.54251', 3, NULL, '0572', '313200', 'Deqing', 'D', NULL);
INSERT INTO `ez_area` VALUES (330522, '长兴县', 330500, '119.910952,31.026665', 'district', '119.910952', '31.026665', 3, NULL, '0572', '313100', 'Changxing', 'C', NULL);
INSERT INTO `ez_area` VALUES (330523, '安吉县', 330500, '119.680353,30.638674', 'district', '119.680353', '30.638674', 3, NULL, '0572', '313300', 'Anji', 'A', NULL);
INSERT INTO `ez_area` VALUES (330600, '绍兴市', 330000, '120.580364,30.030192', 'city', '120.580364', '30.030192', 2, NULL, '0575', '312000', 'Shaoxing', 'S', NULL);
INSERT INTO `ez_area` VALUES (330602, '越城区', 330600, '120.582633,29.988244', 'district', '120.582633', '29.988244', 3, NULL, '0575', '312000', 'Yuecheng', 'Y', NULL);
INSERT INTO `ez_area` VALUES (330603, '柯桥区', 330600, '120.495085,30.081929', 'district', '120.495085', '30.081929', 3, NULL, '0575', '312030', 'Keqiao ', 'K', NULL);
INSERT INTO `ez_area` VALUES (330604, '上虞区', 330600, '120.868122,30.03312', 'district', '120.868122', '30.03312', 3, NULL, '0575', '312300', 'Shangyu', 'S', NULL);
INSERT INTO `ez_area` VALUES (330624, '新昌县', 330600, '120.903866,29.499831', 'district', '120.903866', '29.499831', 3, NULL, '0575', '312500', 'Xinchang', 'X', NULL);
INSERT INTO `ez_area` VALUES (330681, '诸暨市', 330600, '120.246863,29.708692', 'district', '120.246863', '29.708692', 3, NULL, '0575', '311800', 'Zhuji', 'Z', NULL);
INSERT INTO `ez_area` VALUES (330683, '嵊州市', 330600, '120.831025,29.56141', 'district', '120.831025', '29.56141', 3, NULL, '0575', '312400', 'Shengzhou', 'S', NULL);
INSERT INTO `ez_area` VALUES (330700, '金华市', 330000, '119.647229,29.079208', 'city', '119.647229', '29.079208', 2, NULL, '0579', '321000', 'Jinhua', 'J', NULL);
INSERT INTO `ez_area` VALUES (330702, '婺城区', 330700, '119.571728,29.0872', 'district', '119.571728', '29.0872', 3, NULL, '0579', '321000', 'Wucheng', 'W', NULL);
INSERT INTO `ez_area` VALUES (330703, '金东区', 330700, '119.69278,29.099723', 'district', '119.69278', '29.099723', 3, NULL, '0579', '321000', 'Jindong', 'J', NULL);
INSERT INTO `ez_area` VALUES (330723, '武义县', 330700, '119.816562,28.89267', 'district', '119.816562', '28.89267', 3, NULL, '0579', '321200', 'Wuyi', 'W', NULL);
INSERT INTO `ez_area` VALUES (330726, '浦江县', 330700, '119.892222,29.452476', 'district', '119.892222', '29.452476', 3, NULL, '0579', '322200', 'Pujiang', 'P', NULL);
INSERT INTO `ez_area` VALUES (330727, '磐安县', 330700, '120.450005,29.054548', 'district', '120.450005', '29.054548', 3, NULL, '0579', '322300', 'Pan\'an', 'P', NULL);
INSERT INTO `ez_area` VALUES (330781, '兰溪市', 330700, '119.460472,29.2084', 'district', '119.460472', '29.2084', 3, NULL, '0579', '321100', 'Lanxi', 'L', NULL);
INSERT INTO `ez_area` VALUES (330782, '义乌市', 330700, '120.075106,29.306775', 'district', '120.075106', '29.306775', 3, NULL, '0579', '322000', 'Yiwu', 'Y', NULL);
INSERT INTO `ez_area` VALUES (330783, '东阳市', 330700, '120.241566,29.289648', 'district', '120.241566', '29.289648', 3, NULL, '0579', '322100', 'Dongyang', 'D', NULL);
INSERT INTO `ez_area` VALUES (330784, '永康市', 330700, '120.047651,28.888555', 'district', '120.047651', '28.888555', 3, NULL, '0579', '321300', 'Yongkang', 'Y', NULL);
INSERT INTO `ez_area` VALUES (330800, '衢州市', 330000, '118.859457,28.970079', 'city', '118.859457', '28.970079', 2, NULL, '0570', '324002', 'Quzhou', 'Q', NULL);
INSERT INTO `ez_area` VALUES (330802, '柯城区', 330800, '118.871516,28.96862', 'district', '118.871516', '28.96862', 3, NULL, '0570', '324100', 'Kecheng', 'K', NULL);
INSERT INTO `ez_area` VALUES (330803, '衢江区', 330800, '118.95946,28.97978', 'district', '118.95946', '28.97978', 3, NULL, '0570', '324022', 'Qujiang', 'Q', NULL);
INSERT INTO `ez_area` VALUES (330822, '常山县', 330800, '118.511235,28.901462', 'district', '118.511235', '28.901462', 3, NULL, '0570', '324200', 'Changshan', 'C', NULL);
INSERT INTO `ez_area` VALUES (330824, '开化县', 330800, '118.415495,29.137336', 'district', '118.415495', '29.137336', 3, NULL, '0570', '324300', 'Kaihua', 'K', NULL);
INSERT INTO `ez_area` VALUES (330825, '龙游县', 330800, '119.172189,29.028439', 'district', '119.172189', '29.028439', 3, NULL, '0570', '324400', 'Longyou', 'L', NULL);
INSERT INTO `ez_area` VALUES (330881, '江山市', 330800, '118.626991,28.737331', 'district', '118.626991', '28.737331', 3, NULL, '0570', '324100', 'Jiangshan', 'J', NULL);
INSERT INTO `ez_area` VALUES (330900, '舟山市', 330000, '122.207106,29.985553', 'city', '122.207106', '29.985553', 2, NULL, '0580', '316000', 'Zhoushan', 'Z', NULL);
INSERT INTO `ez_area` VALUES (330902, '定海区', 330900, '122.106773,30.019858', 'district', '122.106773', '30.019858', 3, NULL, '0580', '316000', 'Dinghai', 'D', NULL);
INSERT INTO `ez_area` VALUES (330903, '普陀区', 330900, '122.323867,29.97176', 'district', '122.323867', '29.97176', 3, NULL, '0580', '316100', 'Putuo', 'P', NULL);
INSERT INTO `ez_area` VALUES (330921, '岱山县', 330900, '122.226237,30.264139', 'district', '122.226237', '30.264139', 3, NULL, '0580', '316200', 'Daishan', 'D', NULL);
INSERT INTO `ez_area` VALUES (330922, '嵊泗县', 330900, '122.451382,30.725686', 'district', '122.451382', '30.725686', 3, NULL, '0580', '202450', 'Shengsi', 'S', NULL);
INSERT INTO `ez_area` VALUES (331000, '台州市', 330000, '121.42076,28.65638', 'city', '121.42076', '28.65638', 2, NULL, '0576', '318000', 'Taizhou', 'T', NULL);
INSERT INTO `ez_area` VALUES (331002, '椒江区', 331000, '121.442978,28.672981', 'district', '121.442978', '28.672981', 3, NULL, '0576', '318000', 'Jiaojiang', 'J', NULL);
INSERT INTO `ez_area` VALUES (331003, '黄岩区', 331000, '121.261972,28.650083', 'district', '121.261972', '28.650083', 3, NULL, '0576', '318020', 'Huangyan', 'H', NULL);
INSERT INTO `ez_area` VALUES (331004, '路桥区', 331000, '121.365123,28.582654', 'district', '121.365123', '28.582654', 3, NULL, '0576', '318050', 'Luqiao', 'L', NULL);
INSERT INTO `ez_area` VALUES (331021, '玉环市', 331000, '121.231805,28.135929', 'district', '121.231805', '28.135929', 3, NULL, '0576', '317600', 'Yuhuan', 'Y', NULL);
INSERT INTO `ez_area` VALUES (331022, '三门县', 331000, '121.395711,29.104789', 'district', '121.395711', '29.104789', 3, NULL, '0576', '317100', 'Sanmen', 'S', NULL);
INSERT INTO `ez_area` VALUES (331023, '天台县', 331000, '121.006595,29.144064', 'district', '121.006595', '29.144064', 3, NULL, '0576', '317200', 'Tiantai', 'T', NULL);
INSERT INTO `ez_area` VALUES (331024, '仙居县', 331000, '120.728801,28.846966', 'district', '120.728801', '28.846966', 3, NULL, '0576', '317300', 'Xianju', 'X', NULL);
INSERT INTO `ez_area` VALUES (331081, '温岭市', 331000, '121.385604,28.372506', 'district', '121.385604', '28.372506', 3, NULL, '0576', '317500', 'Wenling', 'W', NULL);
INSERT INTO `ez_area` VALUES (331082, '临海市', 331000, '121.144556,28.858881', 'district', '121.144556', '28.858881', 3, NULL, '0576', '317000', 'Linhai', 'L', NULL);
INSERT INTO `ez_area` VALUES (331100, '丽水市', 330000, '119.922796,28.46763', 'city', '119.922796', '28.46763', 2, NULL, '0578', '323000', 'Lishui', 'L', NULL);
INSERT INTO `ez_area` VALUES (331102, '莲都区', 331100, '119.912626,28.445928', 'district', '119.912626', '28.445928', 3, NULL, '0578', '323000', 'Liandu', 'L', NULL);
INSERT INTO `ez_area` VALUES (331121, '青田县', 331100, '120.289478,28.139837', 'district', '120.289478', '28.139837', 3, NULL, '0578', '323900', 'Qingtian', 'Q', NULL);
INSERT INTO `ez_area` VALUES (331122, '缙云县', 331100, '120.091572,28.659283', 'district', '120.091572', '28.659283', 3, NULL, '0578', '321400', 'Jinyun', 'J', NULL);
INSERT INTO `ez_area` VALUES (331123, '遂昌县', 331100, '119.276103,28.592148', 'district', '119.276103', '28.592148', 3, NULL, '0578', '323300', 'Suichang', 'S', NULL);
INSERT INTO `ez_area` VALUES (331124, '松阳县', 331100, '119.481511,28.448803', 'district', '119.481511', '28.448803', 3, NULL, '0578', '323400', 'Songyang', 'S', NULL);
INSERT INTO `ez_area` VALUES (331125, '云和县', 331100, '119.573397,28.11579', 'district', '119.573397', '28.11579', 3, NULL, '0578', '323600', 'Yunhe', 'Y', NULL);
INSERT INTO `ez_area` VALUES (331126, '庆元县', 331100, '119.06259,27.61922', 'district', '119.06259', '27.61922', 3, NULL, '0578', '323800', 'Qingyuan', 'Q', NULL);
INSERT INTO `ez_area` VALUES (331127, '景宁畲族自治县', 331100, '119.635739,27.9733', 'district', '119.635739', '27.9733', 3, NULL, '0578', '323500', 'Jingning', 'J', NULL);
INSERT INTO `ez_area` VALUES (331181, '龙泉市', 331100, '119.141473,28.074649', 'district', '119.141473', '28.074649', 3, NULL, '0578', '323700', 'Longquan', 'L', NULL);
INSERT INTO `ez_area` VALUES (340000, '安徽省', 0, '117.329949,31.733806', 'province', '117.329949', '31.733806', 1, NULL, NULL, NULL, 'Anhui', 'A', NULL);
INSERT INTO `ez_area` VALUES (340100, '合肥市', 340000, '117.227219,31.820591', 'city', '117.227219', '31.820591', 2, NULL, '0551', '230001', 'Hefei', 'H', NULL);
INSERT INTO `ez_area` VALUES (340102, '瑶海区', 340100, '117.309546,31.857917', 'district', '117.309546', '31.857917', 3, NULL, '0551', '230011', 'Yaohai', 'Y', NULL);
INSERT INTO `ez_area` VALUES (340103, '庐阳区', 340100, '117.264786,31.878589', 'district', '117.264786', '31.878589', 3, NULL, '0551', '230001', 'Luyang', 'L', NULL);
INSERT INTO `ez_area` VALUES (340104, '蜀山区', 340100, '117.260521,31.85124', 'district', '117.260521', '31.85124', 3, NULL, '0551', '230031', 'Shushan', 'S', NULL);
INSERT INTO `ez_area` VALUES (340111, '包河区', 340100, '117.309519,31.793859', 'district', '117.309519', '31.793859', 3, NULL, '0551', '230041', 'Baohe', 'B', NULL);
INSERT INTO `ez_area` VALUES (340121, '长丰县', 340100, '117.167564,32.478018', 'district', '117.167564', '32.478018', 3, NULL, '0551', '231100', 'Changfeng', 'C', NULL);
INSERT INTO `ez_area` VALUES (340122, '肥东县', 340100, '117.469382,31.88794', 'district', '117.469382', '31.88794', 3, NULL, '0551', '231600', 'Feidong', 'F', NULL);
INSERT INTO `ez_area` VALUES (340123, '肥西县', 340100, '117.157981,31.706809', 'district', '117.157981', '31.706809', 3, NULL, '0551', '231200', 'Feixi', 'F', NULL);
INSERT INTO `ez_area` VALUES (340124, '庐江县', 340100, '117.2882,31.256524', 'district', '117.2882', '31.256524', 3, NULL, '0565', '231500', 'Lujiang', 'L', NULL);
INSERT INTO `ez_area` VALUES (340181, '巢湖市', 340100, '117.890354,31.624522', 'district', '117.890354', '31.624522', 3, NULL, '0565', '238000', 'Chaohu', 'C', NULL);
INSERT INTO `ez_area` VALUES (340200, '芜湖市', 340000, '118.432941,31.352859', 'city', '118.432941', '31.352859', 2, NULL, '0551', '241000', 'Wuhu', 'W', NULL);
INSERT INTO `ez_area` VALUES (340202, '镜湖区', 340200, '118.385009,31.340728', 'district', '118.385009', '31.340728', 3, NULL, '0553', '241000', 'Jinghu', 'J', NULL);
INSERT INTO `ez_area` VALUES (340203, '弋江区', 340200, '118.372655,31.311756', 'district', '118.372655', '31.311756', 3, NULL, '0553', '241000', 'Yijiang', 'Y', NULL);
INSERT INTO `ez_area` VALUES (340207, '鸠江区', 340200, '118.391734,31.369373', 'district', '118.391734', '31.369373', 3, NULL, '0553', '241000', 'Jiujiang', 'J', NULL);
INSERT INTO `ez_area` VALUES (340208, '三山区', 340200, '118.268101,31.219568', 'district', '118.268101', '31.219568', 3, NULL, '0553', '241000', 'Sanshan', 'S', NULL);
INSERT INTO `ez_area` VALUES (340221, '芜湖县', 340200, '118.576124,31.134809', 'district', '118.576124', '31.134809', 3, NULL, '0553', '241100', 'Wuhu', 'W', NULL);
INSERT INTO `ez_area` VALUES (340222, '繁昌县', 340200, '118.198703,31.101782', 'district', '118.198703', '31.101782', 3, NULL, '0553', '241200', 'Fanchang', 'F', NULL);
INSERT INTO `ez_area` VALUES (340223, '南陵县', 340200, '118.334359,30.914922', 'district', '118.334359', '30.914922', 3, NULL, '0553', '242400', 'Nanling', 'N', NULL);
INSERT INTO `ez_area` VALUES (340225, '无为县', 340200, '117.902366,31.303167', 'district', '117.902366', '31.303167', 3, NULL, '0565', '238300', 'Wuwei', 'W', NULL);
INSERT INTO `ez_area` VALUES (340300, '蚌埠市', 340000, '117.388512,32.91663', 'city', '117.388512', '32.91663', 2, NULL, '0552', '233000', 'Bengbu', 'B', NULL);
INSERT INTO `ez_area` VALUES (340302, '龙子湖区', 340300, '117.379778,32.950611', 'district', '117.379778', '32.950611', 3, NULL, '0552', '233000', 'Longzihu', 'L', NULL);
INSERT INTO `ez_area` VALUES (340303, '蚌山区', 340300, '117.373595,32.917048', 'district', '117.373595', '32.917048', 3, NULL, '0552', '233000', 'Bengshan', 'B', NULL);
INSERT INTO `ez_area` VALUES (340304, '禹会区', 340300, '117.342155,32.929799', 'district', '117.342155', '32.929799', 3, NULL, '0552', '233010', 'Yuhui', 'Y', NULL);
INSERT INTO `ez_area` VALUES (340311, '淮上区', 340300, '117.35933,32.965435', 'district', '117.35933', '32.965435', 3, NULL, '0552', '233002', 'Huaishang', 'H', NULL);
INSERT INTO `ez_area` VALUES (340321, '怀远县', 340300, '117.205237,32.970031', 'district', '117.205237', '32.970031', 3, NULL, '0552', '233400', 'Huaiyuan', 'H', NULL);
INSERT INTO `ez_area` VALUES (340322, '五河县', 340300, '117.879486,33.127823', 'district', '117.879486', '33.127823', 3, NULL, '0552', '233300', 'Wuhe', 'W', NULL);
INSERT INTO `ez_area` VALUES (340323, '固镇县', 340300, '117.316913,33.31688', 'district', '117.316913', '33.31688', 3, NULL, '0552', '233700', 'Guzhen', 'G', NULL);
INSERT INTO `ez_area` VALUES (340400, '淮南市', 340000, '117.018399,32.587117', 'city', '117.018399', '32.587117', 2, NULL, '0554', '232001', 'Huainan', 'H', NULL);
INSERT INTO `ez_area` VALUES (340402, '大通区', 340400, '117.053314,32.631519', 'district', '117.053314', '32.631519', 3, NULL, '0554', '232033', 'Datong', 'D', NULL);
INSERT INTO `ez_area` VALUES (340403, '田家庵区', 340400, '117.017349,32.647277', 'district', '117.017349', '32.647277', 3, NULL, '0554', '232000', 'Tianjiaan', 'T', NULL);
INSERT INTO `ez_area` VALUES (340404, '谢家集区', 340400, '116.859188,32.600037', 'district', '116.859188', '32.600037', 3, NULL, '0554', '232052', 'Xiejiaji', 'X', NULL);
INSERT INTO `ez_area` VALUES (340405, '八公山区', 340400, '116.83349,32.631379', 'district', '116.83349', '32.631379', 3, NULL, '0554', '232072', 'Bagongshan', 'B', NULL);
INSERT INTO `ez_area` VALUES (340406, '潘集区', 340400, '116.834715,32.77208', 'district', '116.834715', '32.77208', 3, NULL, '0554', '232082', 'Panji', 'P', NULL);
INSERT INTO `ez_area` VALUES (340421, '凤台县', 340400, '116.71105,32.709444', 'district', '116.71105', '32.709444', 3, NULL, '0554', '232100', 'Fengtai', 'F', NULL);
INSERT INTO `ez_area` VALUES (340422, '寿县', 340400, '116.798232,32.545109', 'district', '116.798232', '32.545109', 3, NULL, '0554', '232200', 'Shouxian', 'S', NULL);
INSERT INTO `ez_area` VALUES (340500, '马鞍山市', 340000, '118.507011,31.67044', 'city', '118.507011', '31.67044', 2, NULL, '0555', '243001', 'Ma\'anshan', 'M', NULL);
INSERT INTO `ez_area` VALUES (340503, '花山区', 340500, '118.492565,31.71971', 'district', '118.492565', '31.71971', 3, NULL, '0555', '243000', 'Huashan', 'H', NULL);
INSERT INTO `ez_area` VALUES (340504, '雨山区', 340500, '118.498578,31.682132', 'district', '118.498578', '31.682132', 3, NULL, '0555', '243071', 'Yushan', 'Y', NULL);
INSERT INTO `ez_area` VALUES (340506, '博望区', 340500, '118.844538,31.558471', 'district', '118.844538', '31.558471', 3, NULL, '0555', '243131', 'Bowang', 'B', NULL);
INSERT INTO `ez_area` VALUES (340521, '当涂县', 340500, '118.497972,31.571213', 'district', '118.497972', '31.571213', 3, NULL, '0555', '243100', 'Dangtu', 'D', NULL);
INSERT INTO `ez_area` VALUES (340522, '含山县', 340500, '118.101421,31.735598', 'district', '118.101421', '31.735598', 3, NULL, '0555', '238100', 'Hanshan ', 'H', NULL);
INSERT INTO `ez_area` VALUES (340523, '和县', 340500, '118.353667,31.742293', 'district', '118.353667', '31.742293', 3, NULL, '0555', '238200', 'Hexian', 'H', NULL);
INSERT INTO `ez_area` VALUES (340600, '淮北市', 340000, '116.798265,33.955844', 'city', '116.798265', '33.955844', 2, NULL, '0561', '235000', 'Huaibei', 'H', NULL);
INSERT INTO `ez_area` VALUES (340602, '杜集区', 340600, '116.828133,33.991451', 'district', '116.828133', '33.991451', 3, NULL, '0561', '235000', 'Duji', 'D', NULL);
INSERT INTO `ez_area` VALUES (340603, '相山区', 340600, '116.794344,33.959892', 'district', '116.794344', '33.959892', 3, NULL, '0561', '235000', 'Xiangshan', 'X', NULL);
INSERT INTO `ez_area` VALUES (340604, '烈山区', 340600, '116.813042,33.895139', 'district', '116.813042', '33.895139', 3, NULL, '0561', '235000', 'Lieshan', 'L', NULL);
INSERT INTO `ez_area` VALUES (340621, '濉溪县', 340600, '116.766298,33.915477', 'district', '116.766298', '33.915477', 3, NULL, '0561', '235100', 'Suixi', 'S', NULL);
INSERT INTO `ez_area` VALUES (340700, '铜陵市', 340000, '117.81154,30.945515', 'city', '117.81154', '30.945515', 2, NULL, '0562', '244000', 'Tongling', 'T', NULL);
INSERT INTO `ez_area` VALUES (340705, '铜官区', 340700, '117.85616,30.936272', 'district', '117.85616', '30.936272', 3, NULL, '0562', '244000', 'Tongguanshan', 'T', NULL);
INSERT INTO `ez_area` VALUES (340706, '义安区', 340700, '117.791544,30.952823', 'district', '117.791544', '30.952823', 3, NULL, '0562', '244100', 'Yi\'an ', 'Y', NULL);
INSERT INTO `ez_area` VALUES (340711, '郊区', 340700, '117.768026,30.821069', 'district', '117.768026', '30.821069', 3, NULL, '0562', '244000', 'Jiaoqu', 'J', NULL);
INSERT INTO `ez_area` VALUES (340722, '枞阳县', 340700, '117.250594,30.706018', 'district', '117.250594', '30.706018', 3, NULL, '0562', '246700', 'Zongyang', 'Z', NULL);
INSERT INTO `ez_area` VALUES (340800, '安庆市', 340000, '117.115101,30.531919', 'city', '117.115101', '30.531919', 2, NULL, '0556', '246001', 'Anqing', 'A', NULL);
INSERT INTO `ez_area` VALUES (340802, '迎江区', 340800, '117.09115,30.511548', 'district', '117.09115', '30.511548', 3, NULL, '0556', '246001', 'Yingjiang', 'Y', NULL);
INSERT INTO `ez_area` VALUES (340803, '大观区', 340800, '117.013469,30.553697', 'district', '117.013469', '30.553697', 3, NULL, '0556', '246002', 'Daguan', 'D', NULL);
INSERT INTO `ez_area` VALUES (340811, '宜秀区', 340800, '116.987542,30.613332', 'district', '116.987542', '30.613332', 3, NULL, '0556', '246003', 'Yixiu', 'Y', NULL);
INSERT INTO `ez_area` VALUES (340822, '怀宁县', 340800, '116.829475,30.733824', 'district', '116.829475', '30.733824', 3, NULL, '0556', '246100', 'Huaining', 'H', NULL);
INSERT INTO `ez_area` VALUES (340824, '潜山县', 340800, '116.581371,30.631136', 'district', '116.581371', '30.631136', 3, NULL, '0556', '246300', 'Qianshan', 'Q', NULL);
INSERT INTO `ez_area` VALUES (340825, '太湖县', 340800, '116.308795,30.45422', 'district', '116.308795', '30.45422', 3, NULL, '0556', '246400', 'Taihu', 'T', NULL);
INSERT INTO `ez_area` VALUES (340826, '宿松县', 340800, '116.129105,30.153746', 'district', '116.129105', '30.153746', 3, NULL, '0556', '246500', 'Susong', 'S', NULL);
INSERT INTO `ez_area` VALUES (340827, '望江县', 340800, '116.706498,30.128002', 'district', '116.706498', '30.128002', 3, NULL, '0556', '246200', 'Wangjiang', 'W', NULL);
INSERT INTO `ez_area` VALUES (340828, '岳西县', 340800, '116.359692,30.849762', 'district', '116.359692', '30.849762', 3, NULL, '0556', '246600', 'Yuexi', 'Y', NULL);
INSERT INTO `ez_area` VALUES (340881, '桐城市', 340800, '116.936748,31.035848', 'district', '116.936748', '31.035848', 3, NULL, '0556', '231400', 'Tongcheng', 'T', NULL);
INSERT INTO `ez_area` VALUES (341000, '黄山市', 340000, '118.338272,29.715185', 'city', '118.338272', '29.715185', 2, NULL, '0559', '245000', 'Huangshan', 'H', NULL);
INSERT INTO `ez_area` VALUES (341002, '屯溪区', 341000, '118.315329,29.696108', 'district', '118.315329', '29.696108', 3, NULL, '0559', '245000', 'Tunxi', 'T', NULL);
INSERT INTO `ez_area` VALUES (341003, '黄山区', 341000, '118.141567,30.272942', 'district', '118.141567', '30.272942', 3, NULL, '0559', '242700', 'Huangshan', 'H', NULL);
INSERT INTO `ez_area` VALUES (341004, '徽州区', 341000, '118.336743,29.827271', 'district', '118.336743', '29.827271', 3, NULL, '0559', '245061', 'Huizhou', 'H', NULL);
INSERT INTO `ez_area` VALUES (341021, '歙县', 341000, '118.415345,29.861379', 'district', '118.415345', '29.861379', 3, NULL, '0559', '245200', 'Shexian', 'S', NULL);
INSERT INTO `ez_area` VALUES (341022, '休宁县', 341000, '118.193618,29.784124', 'district', '118.193618', '29.784124', 3, NULL, '0559', '245400', 'Xiuning', 'X', NULL);
INSERT INTO `ez_area` VALUES (341023, '黟县', 341000, '117.938373,29.924805', 'district', '117.938373', '29.924805', 3, NULL, '0559', '245500', 'Yixian', 'Y', NULL);
INSERT INTO `ez_area` VALUES (341024, '祁门县', 341000, '117.717396,29.854055', 'district', '117.717396', '29.854055', 3, NULL, '0559', '245600', 'Qimen', 'Q', NULL);
INSERT INTO `ez_area` VALUES (341100, '滁州市', 340000, '118.327944,32.255636', 'city', '118.327944', '32.255636', 2, NULL, '0550', '239000', 'Chuzhou', 'C', NULL);
INSERT INTO `ez_area` VALUES (341102, '琅琊区', 341100, '118.305961,32.294631', 'district', '118.305961', '32.294631', 3, NULL, '0550', '239000', 'Langya', 'L', NULL);
INSERT INTO `ez_area` VALUES (341103, '南谯区', 341100, '118.41697,32.200197', 'district', '118.41697', '32.200197', 3, NULL, '0550', '239000', 'Nanqiao', 'N', NULL);
INSERT INTO `ez_area` VALUES (341122, '来安县', 341100, '118.435718,32.452199', 'district', '118.435718', '32.452199', 3, NULL, '0550', '239200', 'Lai\'an', 'L', NULL);
INSERT INTO `ez_area` VALUES (341124, '全椒县', 341100, '118.274149,32.08593', 'district', '118.274149', '32.08593', 3, NULL, '0550', '239500', 'Quanjiao', 'Q', NULL);
INSERT INTO `ez_area` VALUES (341125, '定远县', 341100, '117.698562,32.530981', 'district', '117.698562', '32.530981', 3, NULL, '0550', '233200', 'Dingyuan', 'D', NULL);
INSERT INTO `ez_area` VALUES (341126, '凤阳县', 341100, '117.531622,32.874735', 'district', '117.531622', '32.874735', 3, NULL, '0550', '233100', 'Fengyang', 'F', NULL);
INSERT INTO `ez_area` VALUES (341181, '天长市', 341100, '119.004816,32.667571', 'district', '119.004816', '32.667571', 3, NULL, '0550', '239300', 'Tianchang', 'T', NULL);
INSERT INTO `ez_area` VALUES (341182, '明光市', 341100, '118.018193,32.78196', 'district', '118.018193', '32.78196', 3, NULL, '0550', '239400', 'Mingguang', 'M', NULL);
INSERT INTO `ez_area` VALUES (341200, '阜阳市', 340000, '115.814504,32.890479', 'city', '115.814504', '32.890479', 2, NULL, '0558', '236033', 'Fuyang', 'F', NULL);
INSERT INTO `ez_area` VALUES (341202, '颍州区', 341200, '115.806942,32.883468', 'district', '115.806942', '32.883468', 3, NULL, '0558', '236001', 'Yingzhou', 'Y', NULL);
INSERT INTO `ez_area` VALUES (341203, '颍东区', 341200, '115.856762,32.912477', 'district', '115.856762', '32.912477', 3, NULL, '0558', '236058', 'Yingdong', 'Y', NULL);
INSERT INTO `ez_area` VALUES (341204, '颍泉区', 341200, '115.80835,32.925211', 'district', '115.80835', '32.925211', 3, NULL, '0558', '236045', 'Yingquan', 'Y', NULL);
INSERT INTO `ez_area` VALUES (341221, '临泉县', 341200, '115.263115,33.039715', 'district', '115.263115', '33.039715', 3, NULL, '0558', '236400', 'Linquan', 'L', NULL);
INSERT INTO `ez_area` VALUES (341222, '太和县', 341200, '115.621941,33.160327', 'district', '115.621941', '33.160327', 3, NULL, '0558', '236600', 'Taihe', 'T', NULL);
INSERT INTO `ez_area` VALUES (341225, '阜南县', 341200, '115.595643,32.658297', 'district', '115.595643', '32.658297', 3, NULL, '0558', '236300', 'Funan', 'F', NULL);
INSERT INTO `ez_area` VALUES (341226, '颍上县', 341200, '116.256772,32.653211', 'district', '116.256772', '32.653211', 3, NULL, '0558', '236200', 'Yingshang', 'Y', NULL);
INSERT INTO `ez_area` VALUES (341282, '界首市', 341200, '115.374821,33.258244', 'district', '115.374821', '33.258244', 3, NULL, '0558', '236500', 'Jieshou', 'J', NULL);
INSERT INTO `ez_area` VALUES (341300, '宿州市', 340000, '116.964195,33.647309', 'city', '116.964195', '33.647309', 2, NULL, '0557', '234000', 'Suzhou', 'S', NULL);
INSERT INTO `ez_area` VALUES (341302, '埇桥区', 341300, '116.977203,33.64059', 'district', '116.977203', '33.64059', 3, NULL, '0557', '234000', 'Yongqiao', 'Y', NULL);
INSERT INTO `ez_area` VALUES (341321, '砀山县', 341300, '116.367095,34.442561', 'district', '116.367095', '34.442561', 3, NULL, '0557', '235300', 'Dangshan', 'D', NULL);
INSERT INTO `ez_area` VALUES (341322, '萧县', 341300, '116.947349,34.188732', 'district', '116.947349', '34.188732', 3, NULL, '0557', '235200', 'Xiaoxian', 'X', NULL);
INSERT INTO `ez_area` VALUES (341323, '灵璧县', 341300, '117.549395,33.554604', 'district', '117.549395', '33.554604', 3, NULL, '0557', '234200', 'Lingbi', 'L', NULL);
INSERT INTO `ez_area` VALUES (341324, '泗县', 341300, '117.910629,33.482982', 'district', '117.910629', '33.482982', 3, NULL, '0557', '234300', 'Sixian', 'S', NULL);
INSERT INTO `ez_area` VALUES (341500, '六安市', 340000, '116.520139,31.735456', 'city', '116.520139', '31.735456', 2, NULL, '0564', '237000', 'Lu\'an', 'L', NULL);
INSERT INTO `ez_area` VALUES (341502, '金安区', 341500, '116.539173,31.750119', 'district', '116.539173', '31.750119', 3, NULL, '0564', '237005', 'Jin\'an', 'J', NULL);
INSERT INTO `ez_area` VALUES (341503, '裕安区', 341500, '116.479829,31.738183', 'district', '116.479829', '31.738183', 3, NULL, '0564', '237010', 'Yu\'an', 'Y', NULL);
INSERT INTO `ez_area` VALUES (341504, '叶集区', 341500, '115.925271,31.863693', 'district', '115.925271', '31.863693', 3, NULL, '0564', '237431 ', 'Yeji', 'Y', NULL);
INSERT INTO `ez_area` VALUES (341522, '霍邱县', 341500, '116.277911,32.353038', 'district', '116.277911', '32.353038', 3, NULL, '0564', '237400', 'Huoqiu', 'H', NULL);
INSERT INTO `ez_area` VALUES (341523, '舒城县', 341500, '116.948736,31.462234', 'district', '116.948736', '31.462234', 3, NULL, '0564', '231300', 'Shucheng', 'S', NULL);
INSERT INTO `ez_area` VALUES (341524, '金寨县', 341500, '115.934366,31.72717', 'district', '115.934366', '31.72717', 3, NULL, '0564', '237300', 'Jinzhai', 'J', NULL);
INSERT INTO `ez_area` VALUES (341525, '霍山县', 341500, '116.351892,31.410561', 'district', '116.351892', '31.410561', 3, NULL, '0564', '237200', 'Huoshan', 'H', NULL);
INSERT INTO `ez_area` VALUES (341600, '亳州市', 340000, '115.77867,33.844592', 'city', '115.77867', '33.844592', 2, NULL, '0558', '236802', 'Bozhou', 'B', NULL);
INSERT INTO `ez_area` VALUES (341602, '谯城区', 341600, '115.779025,33.876235', 'district', '115.779025', '33.876235', 3, NULL, '0558', '236800', 'Qiaocheng', 'Q', NULL);
INSERT INTO `ez_area` VALUES (341621, '涡阳县', 341600, '116.215665,33.492921', 'district', '116.215665', '33.492921', 3, NULL, '0558', '233600', 'Guoyang', 'G', NULL);
INSERT INTO `ez_area` VALUES (341622, '蒙城县', 341600, '116.564247,33.26583', 'district', '116.564247', '33.26583', 3, NULL, '0558', '233500', 'Mengcheng', 'M', NULL);
INSERT INTO `ez_area` VALUES (341623, '利辛县', 341600, '116.208564,33.144515', 'district', '116.208564', '33.144515', 3, NULL, '0558', '236700', 'Lixin', 'L', NULL);
INSERT INTO `ez_area` VALUES (341700, '池州市', 340000, '117.491592,30.664779', 'city', '117.491592', '30.664779', 2, NULL, '0566', '247100', 'Chizhou', 'C', NULL);
INSERT INTO `ez_area` VALUES (341702, '贵池区', 341700, '117.567264,30.687219', 'district', '117.567264', '30.687219', 3, NULL, '0566', '247100', 'Guichi', 'G', NULL);
INSERT INTO `ez_area` VALUES (341721, '东至县', 341700, '117.027618,30.111163', 'district', '117.027618', '30.111163', 3, NULL, '0566', '247200', 'Dongzhi', 'D', NULL);
INSERT INTO `ez_area` VALUES (341722, '石台县', 341700, '117.486306,30.210313', 'district', '117.486306', '30.210313', 3, NULL, '0566', '245100', 'Shitai', 'S', NULL);
INSERT INTO `ez_area` VALUES (341723, '青阳县', 341700, '117.84743,30.63923', 'district', '117.84743', '30.63923', 3, NULL, '0566', '242800', 'Qingyang', 'Q', NULL);
INSERT INTO `ez_area` VALUES (341800, '宣城市', 340000, '118.75868,30.940195', 'city', '118.75868', '30.940195', 2, NULL, '0563', '242000', 'Xuancheng', 'X', NULL);
INSERT INTO `ez_area` VALUES (341802, '宣州区', 341800, '118.785561,30.944076', 'district', '118.785561', '30.944076', 3, NULL, '0563', '242000', 'Xuanzhou', 'X', NULL);
INSERT INTO `ez_area` VALUES (341821, '郎溪县', 341800, '119.179656,31.126412', 'district', '119.179656', '31.126412', 3, NULL, '0563', '242100', 'Langxi', 'L', NULL);
INSERT INTO `ez_area` VALUES (341822, '广德县', 341800, '119.420935,30.877555', 'district', '119.420935', '30.877555', 3, NULL, '0563', '242200', 'Guangde', 'G', NULL);
INSERT INTO `ez_area` VALUES (341823, '泾县', 341800, '118.419859,30.688634', 'district', '118.419859', '30.688634', 3, NULL, '0563', '242500', 'Jingxian', 'J', NULL);
INSERT INTO `ez_area` VALUES (341824, '绩溪县', 341800, '118.578519,30.067533', 'district', '118.578519', '30.067533', 3, NULL, '0563', '245300', 'Jixi', 'J', NULL);
INSERT INTO `ez_area` VALUES (341825, '旌德县', 341800, '118.549861,30.298142', 'district', '118.549861', '30.298142', 3, NULL, '0563', '242600', 'Jingde', 'J', NULL);
INSERT INTO `ez_area` VALUES (341881, '宁国市', 341800, '118.983171,30.633882', 'district', '118.983171', '30.633882', 3, NULL, '0563', '242300', 'Ningguo', 'N', NULL);
INSERT INTO `ez_area` VALUES (350000, '福建省', 0, '119.295143,26.100779', 'province', '119.295143', '26.100779', 1, NULL, NULL, NULL, 'Fujian', 'F', NULL);
INSERT INTO `ez_area` VALUES (350100, '福州市', 350000, '119.296389,26.074268', 'city', '119.296389', '26.074268', 2, NULL, '0591', '350001', 'Fuzhou', 'F', NULL);
INSERT INTO `ez_area` VALUES (350102, '鼓楼区', 350100, '119.303917,26.081983', 'district', '119.303917', '26.081983', 3, NULL, '0591', '350001', 'Gulou', 'G', NULL);
INSERT INTO `ez_area` VALUES (350103, '台江区', 350100, '119.314041,26.052843', 'district', '119.314041', '26.052843', 3, NULL, '0591', '350004', 'Taijiang', 'T', NULL);
INSERT INTO `ez_area` VALUES (350104, '仓山区', 350100, '119.273545,26.046743', 'district', '119.273545', '26.046743', 3, NULL, '0591', '350007', 'Cangshan', 'C', NULL);
INSERT INTO `ez_area` VALUES (350105, '马尾区', 350100, '119.455588,25.9895', 'district', '119.455588', '25.9895', 3, NULL, '0591', '350015', 'Mawei', 'M', NULL);
INSERT INTO `ez_area` VALUES (350111, '晋安区', 350100, '119.328521,26.082107', 'district', '119.328521', '26.082107', 3, NULL, '0591', '350011', 'Jin\'an', 'J', NULL);
INSERT INTO `ez_area` VALUES (350121, '闽侯县', 350100, '119.131724,26.150047', 'district', '119.131724', '26.150047', 3, NULL, '0591', '350100', 'Minhou', 'M', NULL);
INSERT INTO `ez_area` VALUES (350122, '连江县', 350100, '119.539704,26.197364', 'district', '119.539704', '26.197364', 3, NULL, '0591', '350500', 'Lianjiang', 'L', NULL);
INSERT INTO `ez_area` VALUES (350123, '罗源县', 350100, '119.549776,26.489558', 'district', '119.549776', '26.489558', 3, NULL, '0591', '350600', 'Luoyuan', 'L', NULL);
INSERT INTO `ez_area` VALUES (350124, '闽清县', 350100, '118.863361,26.221197', 'district', '118.863361', '26.221197', 3, NULL, '0591', '350800', 'Minqing', 'M', NULL);
INSERT INTO `ez_area` VALUES (350125, '永泰县', 350100, '118.932592,25.866694', 'district', '118.932592', '25.866694', 3, NULL, '0591', '350700', 'Yongtai', 'Y', NULL);
INSERT INTO `ez_area` VALUES (350128, '平潭县', 350100, '119.790168,25.49872', 'district', '119.790168', '25.49872', 3, NULL, '0591', '350400', 'Pingtan', 'P', NULL);
INSERT INTO `ez_area` VALUES (350181, '福清市', 350100, '119.384201,25.72071', 'district', '119.384201', '25.72071', 3, NULL, '0591', '350300', 'Fuqing', 'F', NULL);
INSERT INTO `ez_area` VALUES (350182, '长乐市', 350100, '119.523266,25.962888', 'district', '119.523266', '25.962888', 3, NULL, '0591', '350200', 'Changle', 'C', NULL);
INSERT INTO `ez_area` VALUES (350200, '厦门市', 350000, '118.089204,24.479664', 'city', '118.089204', '24.479664', 2, NULL, '0592', '361003', 'Xiamen', 'X', NULL);
INSERT INTO `ez_area` VALUES (350203, '思明区', 350200, '118.082649,24.445484', 'district', '118.082649', '24.445484', 3, NULL, '0592', '361001', 'Siming', 'S', NULL);
INSERT INTO `ez_area` VALUES (350205, '海沧区', 350200, '118.032984,24.484685', 'district', '118.032984', '24.484685', 3, NULL, '0592', '361026', 'Haicang', 'H', NULL);
INSERT INTO `ez_area` VALUES (350206, '湖里区', 350200, '118.146768,24.512904', 'district', '118.146768', '24.512904', 3, NULL, '0592', '361006', 'Huli', 'H', NULL);
INSERT INTO `ez_area` VALUES (350211, '集美区', 350200, '118.097337,24.575969', 'district', '118.097337', '24.575969', 3, NULL, '0592', '361021', 'Jimei', 'J', NULL);
INSERT INTO `ez_area` VALUES (350212, '同安区', 350200, '118.152041,24.723234', 'district', '118.152041', '24.723234', 3, NULL, '0592', '361100', 'Tong\'an', 'T', NULL);
INSERT INTO `ez_area` VALUES (350213, '翔安区', 350200, '118.248034,24.618543', 'district', '118.248034', '24.618543', 3, NULL, '0592', '361101', 'Xiang\'an', 'X', NULL);
INSERT INTO `ez_area` VALUES (350300, '莆田市', 350000, '119.007777,25.454084', 'city', '119.007777', '25.454084', 2, NULL, '0594', '351100', 'Putian', 'P', NULL);
INSERT INTO `ez_area` VALUES (350302, '城厢区', 350300, '118.993884,25.419319', 'district', '118.993884', '25.419319', 3, NULL, '0594', '351100', 'Chengxiang', 'C', NULL);
INSERT INTO `ez_area` VALUES (350303, '涵江区', 350300, '119.116289,25.45872', 'district', '119.116289', '25.45872', 3, NULL, '0594', '351111', 'Hanjiang', 'H', NULL);
INSERT INTO `ez_area` VALUES (350304, '荔城区', 350300, '119.015061,25.431941', 'district', '119.015061', '25.431941', 3, NULL, '0594', '351100', 'Licheng', 'L', NULL);
INSERT INTO `ez_area` VALUES (350305, '秀屿区', 350300, '119.105494,25.31836', 'district', '119.105494', '25.31836', 3, NULL, '0594', '351152', 'Xiuyu', 'X', NULL);
INSERT INTO `ez_area` VALUES (350322, '仙游县', 350300, '118.691637,25.362093', 'district', '118.691637', '25.362093', 3, NULL, '0594', '351200', 'Xianyou', 'X', NULL);
INSERT INTO `ez_area` VALUES (350400, '三明市', 350000, '117.638678,26.263406', 'city', '117.638678', '26.263406', 2, NULL, '0598', '365000', 'Sanming', 'S', NULL);
INSERT INTO `ez_area` VALUES (350402, '梅列区', 350400, '117.645855,26.271711', 'district', '117.645855', '26.271711', 3, NULL, '0598', '365000', 'Meilie', 'M', NULL);
INSERT INTO `ez_area` VALUES (350403, '三元区', 350400, '117.608044,26.234019', 'district', '117.608044', '26.234019', 3, NULL, '0598', '365001', 'Sanyuan', 'S', NULL);
INSERT INTO `ez_area` VALUES (350421, '明溪县', 350400, '117.202226,26.355856', 'district', '117.202226', '26.355856', 3, NULL, '0598', '365200', 'Mingxi', 'M', NULL);
INSERT INTO `ez_area` VALUES (350423, '清流县', 350400, '116.816909,26.177796', 'district', '116.816909', '26.177796', 3, NULL, '0598', '365300', 'Qingliu', 'Q', NULL);
INSERT INTO `ez_area` VALUES (350424, '宁化县', 350400, '116.654365,26.261754', 'district', '116.654365', '26.261754', 3, NULL, '0598', '365400', 'Ninghua', 'N', NULL);
INSERT INTO `ez_area` VALUES (350425, '大田县', 350400, '117.847115,25.692699', 'district', '117.847115', '25.692699', 3, NULL, '0598', '366100', 'Datian', 'D', NULL);
INSERT INTO `ez_area` VALUES (350426, '尤溪县', 350400, '118.190467,26.170171', 'district', '118.190467', '26.170171', 3, NULL, '0598', '365100', 'Youxi', 'Y', NULL);
INSERT INTO `ez_area` VALUES (350427, '沙县', 350400, '117.792396,26.397199', 'district', '117.792396', '26.397199', 3, NULL, '0598', '365500', 'Shaxian', 'S', NULL);
INSERT INTO `ez_area` VALUES (350428, '将乐县', 350400, '117.471372,26.728952', 'district', '117.471372', '26.728952', 3, NULL, '0598', '353300', 'Jiangle', 'J', NULL);
INSERT INTO `ez_area` VALUES (350429, '泰宁县', 350400, '117.17574,26.900259', 'district', '117.17574', '26.900259', 3, NULL, '0598', '354400', 'Taining', 'T', NULL);
INSERT INTO `ez_area` VALUES (350430, '建宁县', 350400, '116.848443,26.833588', 'district', '116.848443', '26.833588', 3, NULL, '0598', '354500', 'Jianning', 'J', NULL);
INSERT INTO `ez_area` VALUES (350481, '永安市', 350400, '117.365052,25.941937', 'district', '117.365052', '25.941937', 3, NULL, '0598', '366000', 'Yong\'an', 'Y', NULL);
INSERT INTO `ez_area` VALUES (350500, '泉州市', 350000, '118.675676,24.874132', 'city', '118.675676', '24.874132', 2, NULL, '0595', '362000', 'Quanzhou', 'Q', NULL);
INSERT INTO `ez_area` VALUES (350502, '鲤城区', 350500, '118.587097,24.907424', 'district', '118.587097', '24.907424', 3, NULL, '0595', '362000', 'Licheng', 'L', NULL);
INSERT INTO `ez_area` VALUES (350503, '丰泽区', 350500, '118.613172,24.891173', 'district', '118.613172', '24.891173', 3, NULL, '0595', '362000', 'Fengze', 'F', NULL);
INSERT INTO `ez_area` VALUES (350504, '洛江区', 350500, '118.671193,24.939796', 'district', '118.671193', '24.939796', 3, NULL, '0595', '362011', 'Luojiang', 'L', NULL);
INSERT INTO `ez_area` VALUES (350505, '泉港区', 350500, '118.916309,25.119815', 'district', '118.916309', '25.119815', 3, NULL, '0595', '362114', 'Quangang', 'Q', NULL);
INSERT INTO `ez_area` VALUES (350521, '惠安县', 350500, '118.796607,25.030801', 'district', '118.796607', '25.030801', 3, NULL, '0595', '362100', 'Hui\'an', 'H', NULL);
INSERT INTO `ez_area` VALUES (350524, '安溪县', 350500, '118.186288,25.055954', 'district', '118.186288', '25.055954', 3, NULL, '0595', '362400', 'Anxi', 'A', NULL);
INSERT INTO `ez_area` VALUES (350525, '永春县', 350500, '118.294048,25.321565', 'district', '118.294048', '25.321565', 3, NULL, '0595', '362600', 'Yongchun', 'Y', NULL);
INSERT INTO `ez_area` VALUES (350526, '德化县', 350500, '118.241094,25.491493', 'district', '118.241094', '25.491493', 3, NULL, '0595', '362500', 'Dehua', 'D', NULL);
INSERT INTO `ez_area` VALUES (350527, '金门县', 350500, '118.323221,24.436417', 'district', '118.323221', '24.436417', 3, NULL, '082', '890至896', 'Jinmen', 'J', NULL);
INSERT INTO `ez_area` VALUES (350581, '石狮市', 350500, '118.648066,24.732204', 'district', '118.648066', '24.732204', 3, NULL, '0595', '362700', 'Shishi', 'S', NULL);
INSERT INTO `ez_area` VALUES (350582, '晋江市', 350500, '118.551682,24.781636', 'district', '118.551682', '24.781636', 3, NULL, '0595', '362200', 'Jinjiang', 'J', NULL);
INSERT INTO `ez_area` VALUES (350583, '南安市', 350500, '118.386279,24.960385', 'district', '118.386279', '24.960385', 3, NULL, '0595', '362300', 'Nan\'an', 'N', NULL);
INSERT INTO `ez_area` VALUES (350600, '漳州市', 350000, '117.647093,24.513025', 'city', '117.647093', '24.513025', 2, NULL, '0596', '363005', 'Zhangzhou', 'Z', NULL);
INSERT INTO `ez_area` VALUES (350602, '芗城区', 350600, '117.653968,24.510787', 'district', '117.653968', '24.510787', 3, NULL, '0596', '363000', 'Xiangcheng', 'X', NULL);
INSERT INTO `ez_area` VALUES (350603, '龙文区', 350600, '117.709754,24.503113', 'district', '117.709754', '24.503113', 3, NULL, '0596', '363005', 'Longwen', 'L', NULL);
INSERT INTO `ez_area` VALUES (350622, '云霄县', 350600, '117.339573,23.957936', 'district', '117.339573', '23.957936', 3, NULL, '0596', '363300', 'Yunxiao', 'Y', NULL);
INSERT INTO `ez_area` VALUES (350623, '漳浦县', 350600, '117.613808,24.117102', 'district', '117.613808', '24.117102', 3, NULL, '0596', '363200', 'Zhangpu', 'Z', NULL);
INSERT INTO `ez_area` VALUES (350624, '诏安县', 350600, '117.175184,23.711579', 'district', '117.175184', '23.711579', 3, NULL, '0596', '363500', 'Zhao\'an', 'Z', NULL);
INSERT INTO `ez_area` VALUES (350625, '长泰县', 350600, '117.759153,24.625449', 'district', '117.759153', '24.625449', 3, NULL, '0596', '363900', 'Changtai', 'C', NULL);
INSERT INTO `ez_area` VALUES (350626, '东山县', 350600, '117.430061,23.701262', 'district', '117.430061', '23.701262', 3, NULL, '0596', '363400', 'Dongshan', 'D', NULL);
INSERT INTO `ez_area` VALUES (350627, '南靖县', 350600, '117.35732,24.514654', 'district', '117.35732', '24.514654', 3, NULL, '0596', '363600', 'Nanjing', 'N', NULL);
INSERT INTO `ez_area` VALUES (350628, '平和县', 350600, '117.315017,24.363508', 'district', '117.315017', '24.363508', 3, NULL, '0596', '363700', 'Pinghe', 'P', NULL);
INSERT INTO `ez_area` VALUES (350629, '华安县', 350600, '117.534103,25.004425', 'district', '117.534103', '25.004425', 3, NULL, '0596', '363800', 'Hua\'an', 'H', NULL);
INSERT INTO `ez_area` VALUES (350681, '龙海市', 350600, '117.818197,24.446706', 'district', '117.818197', '24.446706', 3, NULL, '0596', '363100', 'Longhai', 'L', NULL);
INSERT INTO `ez_area` VALUES (350700, '南平市', 350000, '118.17771,26.641774', 'city', '118.17771', '26.641774', 2, NULL, '0599', '353000', 'Nanping', 'N', NULL);
INSERT INTO `ez_area` VALUES (350702, '延平区', 350700, '118.182036,26.637438', 'district', '118.182036', '26.637438', 3, NULL, '0600', '353000', 'Yanping', 'Y', NULL);
INSERT INTO `ez_area` VALUES (350703, '建阳区', 350700, '118.120464,27.331876', 'district', '118.120464', '27.331876', 3, NULL, '0599', '354200', 'Jianyang', 'J', NULL);
INSERT INTO `ez_area` VALUES (350721, '顺昌县', 350700, '117.810357,26.793288', 'district', '117.810357', '26.793288', 3, NULL, '0605', '353200', 'Shunchang', 'S', NULL);
INSERT INTO `ez_area` VALUES (350722, '浦城县', 350700, '118.541256,27.917263', 'district', '118.541256', '27.917263', 3, NULL, '0606', '353400', 'Pucheng', 'P', NULL);
INSERT INTO `ez_area` VALUES (350723, '光泽县', 350700, '117.334106,27.540987', 'district', '117.334106', '27.540987', 3, NULL, '0607', '354100', 'Guangze', 'G', NULL);
INSERT INTO `ez_area` VALUES (350724, '松溪县', 350700, '118.785468,27.526232', 'district', '118.785468', '27.526232', 3, NULL, '0608', '353500', 'Songxi', 'S', NULL);
INSERT INTO `ez_area` VALUES (350725, '政和县', 350700, '118.857642,27.366104', 'district', '118.857642', '27.366104', 3, NULL, '0609', '353600', 'Zhenghe', 'Z', NULL);
INSERT INTO `ez_area` VALUES (350781, '邵武市', 350700, '117.492533,27.340326', 'district', '117.492533', '27.340326', 3, NULL, '0601', '354000', 'Shaowu', 'S', NULL);
INSERT INTO `ez_area` VALUES (350782, '武夷山市', 350700, '118.035309,27.756647', 'district', '118.035309', '27.756647', 3, NULL, '0602', '354300', 'Wuyishan', 'W', NULL);
INSERT INTO `ez_area` VALUES (350783, '建瓯市', 350700, '118.304966,27.022774', 'district', '118.304966', '27.022774', 3, NULL, '0603', '353100', 'Jianou', 'J', NULL);
INSERT INTO `ez_area` VALUES (350800, '龙岩市', 350000, '117.017295,25.075119', 'city', '117.017295', '25.075119', 2, NULL, '0597', '364000', 'Longyan', 'L', NULL);
INSERT INTO `ez_area` VALUES (350802, '新罗区', 350800, '117.037155,25.098312', 'district', '117.037155', '25.098312', 3, NULL, '0597', '364000', 'Xinluo', 'X', NULL);
INSERT INTO `ez_area` VALUES (350803, '永定区', 350800, '116.732091,24.723961', 'district', '116.732091', '24.723961', 3, NULL, '0597', '364100', 'Yongding', 'Y', NULL);
INSERT INTO `ez_area` VALUES (350821, '长汀县', 350800, '116.357581,25.833531', 'district', '116.357581', '25.833531', 3, NULL, '0597', '366300', 'Changting', 'C', NULL);
INSERT INTO `ez_area` VALUES (350823, '上杭县', 350800, '116.420098,25.049518', 'district', '116.420098', '25.049518', 3, NULL, '0597', '364200', 'Shanghang', 'S', NULL);
INSERT INTO `ez_area` VALUES (350824, '武平县', 350800, '116.100414,25.095386', 'district', '116.100414', '25.095386', 3, NULL, '0597', '364300', 'Wuping', 'W', NULL);
INSERT INTO `ez_area` VALUES (350825, '连城县', 350800, '116.754472,25.710538', 'district', '116.754472', '25.710538', 3, NULL, '0597', '366200', 'Liancheng', 'L', NULL);
INSERT INTO `ez_area` VALUES (350881, '漳平市', 350800, '117.419998,25.290184', 'district', '117.419998', '25.290184', 3, NULL, '0597', '364400', 'Zhangping', 'Z', NULL);
INSERT INTO `ez_area` VALUES (350900, '宁德市', 350000, '119.547932,26.665617', 'city', '119.547932', '26.665617', 2, NULL, '0593', '352100', 'Ningde', 'N', NULL);
INSERT INTO `ez_area` VALUES (350902, '蕉城区', 350900, '119.526299,26.66061', 'district', '119.526299', '26.66061', 3, NULL, '0593', '352100', 'Jiaocheng', 'J', NULL);
INSERT INTO `ez_area` VALUES (350921, '霞浦县', 350900, '120.005146,26.885703', 'district', '120.005146', '26.885703', 3, NULL, '0593', '355100', 'Xiapu', 'X', NULL);
INSERT INTO `ez_area` VALUES (350922, '古田县', 350900, '118.746284,26.577837', 'district', '118.746284', '26.577837', 3, NULL, '0593', '352200', 'Gutian', 'G', NULL);
INSERT INTO `ez_area` VALUES (350923, '屏南县', 350900, '118.985895,26.908276', 'district', '118.985895', '26.908276', 3, NULL, '0593', '352300', 'Pingnan', 'P', NULL);
INSERT INTO `ez_area` VALUES (350924, '寿宁县', 350900, '119.514986,27.454479', 'district', '119.514986', '27.454479', 3, NULL, '0593', '355500', 'Shouning', 'S', NULL);
INSERT INTO `ez_area` VALUES (350925, '周宁县', 350900, '119.339025,27.104591', 'district', '119.339025', '27.104591', 3, NULL, '0593', '355400', 'Zhouning', 'Z', NULL);
INSERT INTO `ez_area` VALUES (350926, '柘荣县', 350900, '119.900609,27.233933', 'district', '119.900609', '27.233933', 3, NULL, '0593', '355300', 'Zherong', 'Z', NULL);
INSERT INTO `ez_area` VALUES (350981, '福安市', 350900, '119.64785,27.08834', 'district', '119.64785', '27.08834', 3, NULL, '0593', '355000', 'Fu\'an', 'F', NULL);
INSERT INTO `ez_area` VALUES (350982, '福鼎市', 350900, '120.216977,27.324479', 'district', '120.216977', '27.324479', 3, NULL, '0593', '355200', 'Fuding', 'F', NULL);
INSERT INTO `ez_area` VALUES (360000, '江西省', 0, '115.81635,28.63666', 'province', '115.81635', '28.63666', 1, NULL, NULL, NULL, 'Jiangxi', 'J', NULL);
INSERT INTO `ez_area` VALUES (360100, '南昌市', 360000, '115.858198,28.682892', 'city', '115.858198', '28.682892', 2, NULL, '0791', '330008', 'Nanchang', 'N', NULL);
INSERT INTO `ez_area` VALUES (360102, '东湖区', 360100, '115.903526,28.698731', 'district', '115.903526', '28.698731', 3, NULL, '0791', '330006', 'Donghu', 'D', NULL);
INSERT INTO `ez_area` VALUES (360103, '西湖区', 360100, '115.877233,28.657595', 'district', '115.877233', '28.657595', 3, NULL, '0791', '330009', 'Xihu', 'X', NULL);
INSERT INTO `ez_area` VALUES (360104, '青云谱区', 360100, '115.925749,28.621169', 'district', '115.925749', '28.621169', 3, NULL, '0791', '330001', 'Qingyunpu', 'Q', NULL);
INSERT INTO `ez_area` VALUES (360105, '湾里区', 360100, '115.730847,28.714796', 'district', '115.730847', '28.714796', 3, NULL, '0791', '330004', 'Wanli', 'W', NULL);
INSERT INTO `ez_area` VALUES (360111, '青山湖区', 360100, '115.962144,28.682984', 'district', '115.962144', '28.682984', 3, NULL, '0791', '330029', 'Qingshanhu', 'Q', NULL);
INSERT INTO `ez_area` VALUES (360112, '新建区', 360100, '115.815277,28.692864', 'district', '115.815277', '28.692864', 3, NULL, '0791', '330100', 'Xinjian', 'X', NULL);
INSERT INTO `ez_area` VALUES (360121, '南昌县', 360100, '115.933742,28.558296', 'district', '115.933742', '28.558296', 3, NULL, '0791', '330200', 'Nanchang', 'N', NULL);
INSERT INTO `ez_area` VALUES (360123, '安义县', 360100, '115.548658,28.846', 'district', '115.548658', '28.846', 3, NULL, '0791', '330500', 'Anyi', 'A', NULL);
INSERT INTO `ez_area` VALUES (360124, '进贤县', 360100, '116.241288,28.377343', 'district', '116.241288', '28.377343', 3, NULL, '0791', '331700', 'Jinxian', 'J', NULL);
INSERT INTO `ez_area` VALUES (360200, '景德镇市', 360000, '117.178222,29.268945', 'city', '117.178222', '29.268945', 2, NULL, '0798', '333000', 'Jingdezhen', 'J', NULL);
INSERT INTO `ez_area` VALUES (360202, '昌江区', 360200, '117.18363,29.273565', 'district', '117.18363', '29.273565', 3, NULL, '0799', '333000', 'Changjiang', 'C', NULL);
INSERT INTO `ez_area` VALUES (360203, '珠山区', 360200, '117.202919,29.299938', 'district', '117.202919', '29.299938', 3, NULL, '0800', '333000', 'Zhushan', 'Z', NULL);
INSERT INTO `ez_area` VALUES (360222, '浮梁县', 360200, '117.215066,29.352253', 'district', '117.215066', '29.352253', 3, NULL, '0802', '333400', 'Fuliang', 'F', NULL);
INSERT INTO `ez_area` VALUES (360281, '乐平市', 360200, '117.151796,28.97844', 'district', '117.151796', '28.97844', 3, NULL, '0801', '333300', 'Leping', 'L', NULL);
INSERT INTO `ez_area` VALUES (360300, '萍乡市', 360000, '113.887083,27.658373', 'city', '113.887083', '27.658373', 2, NULL, '0799', '337000', 'Pingxiang', 'P', NULL);
INSERT INTO `ez_area` VALUES (360302, '安源区', 360300, '113.870704,27.61511', 'district', '113.870704', '27.61511', 3, NULL, '0800', '337000', 'Anyuan', 'A', NULL);
INSERT INTO `ez_area` VALUES (360313, '湘东区', 360300, '113.733047,27.640075', 'district', '113.733047', '27.640075', 3, NULL, '0801', '337016', 'Xiangdong', 'X', NULL);
INSERT INTO `ez_area` VALUES (360321, '莲花县', 360300, '113.961488,27.127664', 'district', '113.961488', '27.127664', 3, NULL, '0802', '337100', 'Lianhua', 'L', NULL);
INSERT INTO `ez_area` VALUES (360322, '上栗县', 360300, '113.795311,27.880301', 'district', '113.795311', '27.880301', 3, NULL, '0803', '337009', 'Shangli', 'S', NULL);
INSERT INTO `ez_area` VALUES (360323, '芦溪县', 360300, '114.029827,27.630806', 'district', '114.029827', '27.630806', 3, NULL, '0804', '337053', 'Luxi', 'L', NULL);
INSERT INTO `ez_area` VALUES (360400, '九江市', 360000, '115.952914,29.662117', 'city', '115.952914', '29.662117', 2, NULL, '0792', '332000', 'Jiujiang', 'J', NULL);
INSERT INTO `ez_area` VALUES (360402, '濂溪区', 360400, '115.992842,29.668064', 'district', '115.992842', '29.668064', 3, NULL, '0792', '332005', 'Lushan', 'L', NULL);
INSERT INTO `ez_area` VALUES (360403, '浔阳区', 360400, '115.990301,29.727593', 'district', '115.990301', '29.727593', 3, NULL, '0792', '332000', 'Xunyang', 'X', NULL);
INSERT INTO `ez_area` VALUES (360421, '九江县', 360400, '115.911323,29.608431', 'district', '115.911323', '29.608431', 3, NULL, '0792', '332100', 'Jiujiang', 'J', NULL);
INSERT INTO `ez_area` VALUES (360423, '武宁县', 360400, '115.092757,29.246591', 'district', '115.092757', '29.246591', 3, NULL, '0792', '332300', 'Wuning', 'W', NULL);
INSERT INTO `ez_area` VALUES (360424, '修水县', 360400, '114.546836,29.025726', 'district', '114.546836', '29.025726', 3, NULL, '0792', '332400', 'Xiushui', 'X', NULL);
INSERT INTO `ez_area` VALUES (360425, '永修县', 360400, '115.831956,29.011871', 'district', '115.831956', '29.011871', 3, NULL, '0792', '330300', 'Yongxiu', 'Y', NULL);
INSERT INTO `ez_area` VALUES (360426, '德安县', 360400, '115.767447,29.298696', 'district', '115.767447', '29.298696', 3, NULL, '0792', '330400', 'De\'an', 'D', NULL);
INSERT INTO `ez_area` VALUES (360428, '都昌县', 360400, '116.203979,29.273239', 'district', '116.203979', '29.273239', 3, NULL, '0792', '332600', 'Duchang', 'D', NULL);
INSERT INTO `ez_area` VALUES (360429, '湖口县', 360400, '116.251947,29.731101', 'district', '116.251947', '29.731101', 3, NULL, '0792', '332500', 'Hukou', 'H', NULL);
INSERT INTO `ez_area` VALUES (360430, '彭泽县', 360400, '116.56438,29.876991', 'district', '116.56438', '29.876991', 3, NULL, '0792', '332700', 'Pengze', 'P', NULL);
INSERT INTO `ez_area` VALUES (360481, '瑞昌市', 360400, '115.681335,29.675834', 'district', '115.681335', '29.675834', 3, NULL, '0792', '332200', 'Ruichang', 'R', NULL);
INSERT INTO `ez_area` VALUES (360482, '共青城市', 360400, '115.808844,29.248316', 'district', '115.808844', '29.248316', 3, NULL, '0792', '332020', 'Gongqingcheng', 'G', NULL);
INSERT INTO `ez_area` VALUES (360483, '庐山市', 360400, '116.04506,29.448128', 'district', '116.04506', '29.448128', 3, NULL, '0792', '332005', 'Lushan', 'L', NULL);
INSERT INTO `ez_area` VALUES (360500, '新余市', 360000, '114.917346,27.817808', 'city', '114.917346', '27.817808', 2, NULL, '0790', '338025', 'Xinyu', 'X', NULL);
INSERT INTO `ez_area` VALUES (360502, '渝水区', 360500, '114.944549,27.800148', 'district', '114.944549', '27.800148', 3, NULL, '0790', '338025', 'Yushui', 'Y', NULL);
INSERT INTO `ez_area` VALUES (360521, '分宜县', 360500, '114.692049,27.814757', 'district', '114.692049', '27.814757', 3, NULL, '0790', '336600', 'Fenyi', 'F', NULL);
INSERT INTO `ez_area` VALUES (360600, '鹰潭市', 360000, '117.042173,28.272537', 'city', '117.042173', '28.272537', 2, NULL, '0701', '335000', 'Yingtan', 'Y', NULL);
INSERT INTO `ez_area` VALUES (360602, '月湖区', 360600, '117.102475,28.267018', 'district', '117.102475', '28.267018', 3, NULL, '0701', '335000', 'Yuehu', 'Y', NULL);
INSERT INTO `ez_area` VALUES (360622, '余江县', 360600, '116.85926,28.198652', 'district', '116.85926', '28.198652', 3, NULL, '0701', '335200', 'Yujiang', 'Y', NULL);
INSERT INTO `ez_area` VALUES (360681, '贵溪市', 360600, '117.245497,28.292519', 'district', '117.245497', '28.292519', 3, NULL, '0701', '335400', 'Guixi', 'G', NULL);
INSERT INTO `ez_area` VALUES (360700, '赣州市', 360000, '114.933546,25.830694', 'city', '114.933546', '25.830694', 2, NULL, '0797', '341000', 'Ganzhou', 'G', NULL);
INSERT INTO `ez_area` VALUES (360702, '章贡区', 360700, '114.921171,25.817816', 'district', '114.921171', '25.817816', 3, NULL, '0797', '341000', 'Zhanggong', 'Z', NULL);
INSERT INTO `ez_area` VALUES (360703, '南康区', 360700, '114.765412,25.66145', 'district', '114.765412', '25.66145', 3, NULL, '0797', '341400', 'Nankang', 'N', NULL);
INSERT INTO `ez_area` VALUES (360704, '赣县区', 360700, '115.011561,25.86069', 'district', '115.011561', '25.86069', 3, NULL, '0797', '341100', 'Ganxian', 'G', NULL);
INSERT INTO `ez_area` VALUES (360722, '信丰县', 360700, '114.922922,25.386379', 'district', '114.922922', '25.386379', 3, NULL, '0797', '341600', 'Xinfeng', 'X', NULL);
INSERT INTO `ez_area` VALUES (360723, '大余县', 360700, '114.362112,25.401313', 'district', '114.362112', '25.401313', 3, NULL, '0797', '341500', 'Dayu', 'D', NULL);
INSERT INTO `ez_area` VALUES (360724, '上犹县', 360700, '114.551138,25.785172', 'district', '114.551138', '25.785172', 3, NULL, '0797', '341200', 'Shangyou', 'S', NULL);
INSERT INTO `ez_area` VALUES (360725, '崇义县', 360700, '114.308267,25.681784', 'district', '114.308267', '25.681784', 3, NULL, '0797', '341300', 'Chongyi', 'C', NULL);
INSERT INTO `ez_area` VALUES (360726, '安远县', 360700, '115.393922,25.136927', 'district', '115.393922', '25.136927', 3, NULL, '0797', '342100', 'Anyuan', 'A', NULL);
INSERT INTO `ez_area` VALUES (360727, '龙南县', 360700, '114.789873,24.911069', 'district', '114.789873', '24.911069', 3, NULL, '0797', '341700', 'Longnan', 'L', NULL);
INSERT INTO `ez_area` VALUES (360728, '定南县', 360700, '115.027845,24.78441', 'district', '115.027845', '24.78441', 3, NULL, '0797', '341900', 'Dingnan', 'D', NULL);
INSERT INTO `ez_area` VALUES (360729, '全南县', 360700, '114.530125,24.742403', 'district', '114.530125', '24.742403', 3, NULL, '0797', '341800', 'Quannan', 'Q', NULL);
INSERT INTO `ez_area` VALUES (360730, '宁都县', 360700, '116.009472,26.470116', 'district', '116.009472', '26.470116', 3, NULL, '0797', '342800', 'Ningdu', 'N', NULL);
INSERT INTO `ez_area` VALUES (360731, '于都县', 360700, '115.415508,25.952068', 'district', '115.415508', '25.952068', 3, NULL, '0797', '342300', 'Yudu', 'Y', NULL);
INSERT INTO `ez_area` VALUES (360732, '兴国县', 360700, '115.363189,26.337937', 'district', '115.363189', '26.337937', 3, NULL, '0797', '342400', 'Xingguo', 'X', NULL);
INSERT INTO `ez_area` VALUES (360733, '会昌县', 360700, '115.786056,25.600272', 'district', '115.786056', '25.600272', 3, NULL, '0797', '342600', 'Huichang', 'H', NULL);
INSERT INTO `ez_area` VALUES (360734, '寻乌县', 360700, '115.637933,24.969167', 'district', '115.637933', '24.969167', 3, NULL, '0797', '342200', 'Xunwu', 'X', NULL);
INSERT INTO `ez_area` VALUES (360735, '石城县', 360700, '116.346995,26.314775', 'district', '116.346995', '26.314775', 3, NULL, '0797', '342700', 'Shicheng', 'S', NULL);
INSERT INTO `ez_area` VALUES (360781, '瑞金市', 360700, '116.027134,25.885555', 'district', '116.027134', '25.885555', 3, NULL, '0797', '342500', 'Ruijin', 'R', NULL);
INSERT INTO `ez_area` VALUES (360800, '吉安市', 360000, '114.966567,27.090763', 'city', '114.966567', '27.090763', 2, NULL, '0796', '343000', 'Ji\'an', 'J', NULL);
INSERT INTO `ez_area` VALUES (360802, '吉州区', 360800, '114.994763,27.143801', 'district', '114.994763', '27.143801', 3, NULL, '0796', '343000', 'Jizhou', 'J', NULL);
INSERT INTO `ez_area` VALUES (360803, '青原区', 360800, '115.014811,27.081977', 'district', '115.014811', '27.081977', 3, NULL, '0796', '343009', 'Qingyuan', 'Q', NULL);
INSERT INTO `ez_area` VALUES (360821, '吉安县', 360800, '114.907875,27.039787', 'district', '114.907875', '27.039787', 3, NULL, '0796', '343100', 'Ji\'an', 'J', NULL);
INSERT INTO `ez_area` VALUES (360822, '吉水县', 360800, '115.135507,27.229632', 'district', '115.135507', '27.229632', 3, NULL, '0796', '331600', 'Jishui', 'J', NULL);
INSERT INTO `ez_area` VALUES (360823, '峡江县', 360800, '115.316566,27.582901', 'district', '115.316566', '27.582901', 3, NULL, '0796', '331409', 'Xiajiang', 'X', NULL);
INSERT INTO `ez_area` VALUES (360824, '新干县', 360800, '115.387052,27.740191', 'district', '115.387052', '27.740191', 3, NULL, '0796', '331300', 'Xingan', 'X', NULL);
INSERT INTO `ez_area` VALUES (360825, '永丰县', 360800, '115.421344,27.316939', 'district', '115.421344', '27.316939', 3, NULL, '0796', '331500', 'Yongfeng', 'Y', NULL);
INSERT INTO `ez_area` VALUES (360826, '泰和县', 360800, '114.92299,26.801628', 'district', '114.92299', '26.801628', 3, NULL, '0796', '343700', 'Taihe', 'T', NULL);
INSERT INTO `ez_area` VALUES (360827, '遂川县', 360800, '114.520537,26.313737', 'district', '114.520537', '26.313737', 3, NULL, '0796', '343900', 'Suichuan', 'S', NULL);
INSERT INTO `ez_area` VALUES (360828, '万安县', 360800, '114.759364,26.456553', 'district', '114.759364', '26.456553', 3, NULL, '0796', '343800', 'Wan\'an', 'W', NULL);
INSERT INTO `ez_area` VALUES (360829, '安福县', 360800, '114.619893,27.392873', 'district', '114.619893', '27.392873', 3, NULL, '0796', '343200', 'Anfu', 'A', NULL);
INSERT INTO `ez_area` VALUES (360830, '永新县', 360800, '114.243072,26.944962', 'district', '114.243072', '26.944962', 3, NULL, '0796', '343400', 'Yongxin', 'Y', NULL);
INSERT INTO `ez_area` VALUES (360881, '井冈山市', 360800, '114.289228,26.748081', 'district', '114.289228', '26.748081', 3, NULL, '0796', '343600', 'Jinggangshan', 'J', NULL);
INSERT INTO `ez_area` VALUES (360900, '宜春市', 360000, '114.416785,27.815743', 'city', '114.416785', '27.815743', 2, NULL, '0795', '336000', 'Yichun', 'Y', NULL);
INSERT INTO `ez_area` VALUES (360902, '袁州区', 360900, '114.427858,27.797091', 'district', '114.427858', '27.797091', 3, NULL, '0795', '336000', 'Yuanzhou', 'Y', NULL);
INSERT INTO `ez_area` VALUES (360921, '奉新县', 360900, '115.400491,28.688423', 'district', '115.400491', '28.688423', 3, NULL, '0795', '330700', 'Fengxin', 'F', NULL);
INSERT INTO `ez_area` VALUES (360922, '万载县', 360900, '114.444854,28.105689', 'district', '114.444854', '28.105689', 3, NULL, '0795', '336100', 'Wanzai', 'W', NULL);
INSERT INTO `ez_area` VALUES (360923, '上高县', 360900, '114.947683,28.238061', 'district', '114.947683', '28.238061', 3, NULL, '0795', '336400', 'Shanggao', 'S', NULL);
INSERT INTO `ez_area` VALUES (360924, '宜丰县', 360900, '114.802852,28.394565', 'district', '114.802852', '28.394565', 3, NULL, '0795', '336300', 'Yifeng', 'Y', NULL);
INSERT INTO `ez_area` VALUES (360925, '靖安县', 360900, '115.362628,28.861478', 'district', '115.362628', '28.861478', 3, NULL, '0795', '330600', 'Jing\'an', 'J', NULL);
INSERT INTO `ez_area` VALUES (360926, '铜鼓县', 360900, '114.371172,28.520769', 'district', '114.371172', '28.520769', 3, NULL, '0795', '336200', 'Tonggu', 'T', NULL);
INSERT INTO `ez_area` VALUES (360981, '丰城市', 360900, '115.771093,28.159141', 'district', '115.771093', '28.159141', 3, NULL, '0795', '331100', 'Fengcheng', 'F', NULL);
INSERT INTO `ez_area` VALUES (360982, '樟树市', 360900, '115.546152,28.055853', 'district', '115.546152', '28.055853', 3, NULL, '0795', '331200', 'Zhangshu', 'Z', NULL);
INSERT INTO `ez_area` VALUES (360983, '高安市', 360900, '115.360619,28.441152', 'district', '115.360619', '28.441152', 3, NULL, '0795', '330800', 'Gao\'an', 'G', NULL);
INSERT INTO `ez_area` VALUES (361000, '抚州市', 360000, '116.358181,27.949217', 'city', '116.358181', '27.949217', 2, NULL, '0794', '344000', 'Fuzhou', 'F', NULL);
INSERT INTO `ez_area` VALUES (361002, '临川区', 361000, '116.312166,27.934572', 'district', '116.312166', '27.934572', 3, NULL, '0794', '344000', 'Linchuan', 'L', NULL);
INSERT INTO `ez_area` VALUES (361003, '东乡区', 361000, '116.603559,28.247696', 'district', '116.603559', '28.247696', 3, NULL, '0794', '331800', 'Dongxiang', 'D', NULL);
INSERT INTO `ez_area` VALUES (361021, '南城县', 361000, '116.63704,27.569678', 'district', '116.63704', '27.569678', 3, NULL, '0794', '344700', 'Nancheng', 'N', NULL);
INSERT INTO `ez_area` VALUES (361022, '黎川县', 361000, '116.907681,27.282333', 'district', '116.907681', '27.282333', 3, NULL, '0794', '344600', 'Lichuan', 'L', NULL);
INSERT INTO `ez_area` VALUES (361023, '南丰县', 361000, '116.525725,27.218444', 'district', '116.525725', '27.218444', 3, NULL, '0794', '344500', 'Nanfeng', 'N', NULL);
INSERT INTO `ez_area` VALUES (361024, '崇仁县', 361000, '116.07626,27.754466', 'district', '116.07626', '27.754466', 3, NULL, '0794', '344200', 'Chongren', 'C', NULL);
INSERT INTO `ez_area` VALUES (361025, '乐安县', 361000, '115.83048,27.428765', 'district', '115.83048', '27.428765', 3, NULL, '0794', '344300', 'Le\'an', 'L', NULL);
INSERT INTO `ez_area` VALUES (361026, '宜黄县', 361000, '116.236201,27.554886', 'district', '116.236201', '27.554886', 3, NULL, '0794', '344400', 'Yihuang', 'Y', NULL);
INSERT INTO `ez_area` VALUES (361027, '金溪县', 361000, '116.755058,27.918959', 'district', '116.755058', '27.918959', 3, NULL, '0794', '344800', 'Jinxi', 'J', NULL);
INSERT INTO `ez_area` VALUES (361028, '资溪县', 361000, '117.060263,27.706101', 'district', '117.060263', '27.706101', 3, NULL, '0794', '335300', 'Zixi', 'Z', NULL);
INSERT INTO `ez_area` VALUES (361030, '广昌县', 361000, '116.335686,26.843684', 'district', '116.335686', '26.843684', 3, NULL, '0794', '344900', 'Guangchang', 'G', NULL);
INSERT INTO `ez_area` VALUES (361100, '上饶市', 360000, '117.943433,28.454863', 'city', '117.943433', '28.454863', 2, NULL, '0793', '334000', 'Shangrao', 'S', NULL);
INSERT INTO `ez_area` VALUES (361102, '信州区', 361100, '117.966268,28.431006', 'district', '117.966268', '28.431006', 3, NULL, '0793', '334000', 'Xinzhou', 'X', NULL);
INSERT INTO `ez_area` VALUES (361103, '广丰区', 361100, '118.19124,28.436285', 'district', '118.19124', '28.436285', 3, NULL, '0793', '334600', 'Guangfeng', 'G', NULL);
INSERT INTO `ez_area` VALUES (361121, '上饶县', 361100, '117.907849,28.448982', 'district', '117.907849', '28.448982', 3, NULL, '0793', '334100', 'Shangrao', 'S', NULL);
INSERT INTO `ez_area` VALUES (361123, '玉山县', 361100, '118.244769,28.682309', 'district', '118.244769', '28.682309', 3, NULL, '0793', '334700', 'Yushan', 'Y', NULL);
INSERT INTO `ez_area` VALUES (361124, '铅山县', 361100, '117.709659,28.315664', 'district', '117.709659', '28.315664', 3, NULL, '0793', '334500', 'Yanshan', 'Y', NULL);
INSERT INTO `ez_area` VALUES (361125, '横峰县', 361100, '117.596452,28.407117', 'district', '117.596452', '28.407117', 3, NULL, '0793', '334300', 'Hengfeng', 'H', NULL);
INSERT INTO `ez_area` VALUES (361126, '弋阳县', 361100, '117.449588,28.378044', 'district', '117.449588', '28.378044', 3, NULL, '0793', '334400', 'Yiyang', 'Y', NULL);
INSERT INTO `ez_area` VALUES (361127, '余干县', 361100, '116.695646,28.702302', 'district', '116.695646', '28.702302', 3, NULL, '0793', '335100', 'Yugan', 'Y', NULL);
INSERT INTO `ez_area` VALUES (361128, '鄱阳县', 361100, '116.70359,29.004847', 'district', '116.70359', '29.004847', 3, NULL, '0793', '333100', 'Poyang', 'P', NULL);
INSERT INTO `ez_area` VALUES (361129, '万年县', 361100, '117.058445,28.694582', 'district', '117.058445', '28.694582', 3, NULL, '0793', '335500', 'Wannian', 'W', NULL);
INSERT INTO `ez_area` VALUES (361130, '婺源县', 361100, '117.861797,29.248085', 'district', '117.861797', '29.248085', 3, NULL, '0793', '333200', 'Wuyuan', 'W', NULL);
INSERT INTO `ez_area` VALUES (361181, '德兴市', 361100, '117.578713,28.946464', 'district', '117.578713', '28.946464', 3, NULL, '0793', '334200', 'Dexing', 'D', NULL);
INSERT INTO `ez_area` VALUES (370000, '山东省', 0, '117.019915,36.671156', 'province', '117.019915', '36.671156', 1, NULL, NULL, NULL, 'Shandong', 'S', NULL);
INSERT INTO `ez_area` VALUES (370100, '济南市', 370000, '117.120098,36.6512', 'city', '117.120098', '36.6512', 2, NULL, '0531', '250001', 'Jinan', 'J', NULL);
INSERT INTO `ez_area` VALUES (370102, '历下区', 370100, '117.076441,36.666465', 'district', '117.076441', '36.666465', 3, NULL, '0531', '250014', 'Lixia', 'L', NULL);
INSERT INTO `ez_area` VALUES (370103, '市中区', 370100, '116.997845,36.651335', 'district', '116.997845', '36.651335', 3, NULL, '0531', '250001', 'Shizhongqu', 'S', NULL);
INSERT INTO `ez_area` VALUES (370104, '槐荫区', 370100, '116.901224,36.651441', 'district', '116.901224', '36.651441', 3, NULL, '0531', '250117', 'Huaiyin', 'H', NULL);
INSERT INTO `ez_area` VALUES (370105, '天桥区', 370100, '116.987153,36.678589', 'district', '116.987153', '36.678589', 3, NULL, '0531', '250031', 'Tianqiao', 'T', NULL);
INSERT INTO `ez_area` VALUES (370112, '历城区', 370100, '117.06523,36.680259', 'district', '117.06523', '36.680259', 3, NULL, '0531', '250100', 'Licheng', 'L', NULL);
INSERT INTO `ez_area` VALUES (370113, '长清区', 370100, '116.751843,36.55371', 'district', '116.751843', '36.55371', 3, NULL, '0531', '250300', 'Changqing', 'C', NULL);
INSERT INTO `ez_area` VALUES (370114, '章丘区', 370100, '117.526228,36.681258', 'district', '117.526228', '36.681258', 3, NULL, '0531', '250200', 'Zhangqiu', 'Z', NULL);
INSERT INTO `ez_area` VALUES (370124, '平阴县', 370100, '116.456006,36.289251', 'district', '116.456006', '36.289251', 3, NULL, '0531', '250400', 'Pingyin', 'P', NULL);
INSERT INTO `ez_area` VALUES (370125, '济阳县', 370100, '117.173524,36.978537', 'district', '117.173524', '36.978537', 3, NULL, '0531', '251400', 'Jiyang', 'J', NULL);
INSERT INTO `ez_area` VALUES (370126, '商河县', 370100, '117.157232,37.309041', 'district', '117.157232', '37.309041', 3, NULL, '0531', '251600', 'Shanghe', 'S', NULL);
INSERT INTO `ez_area` VALUES (370200, '青岛市', 370000, '120.382621,36.067131', 'city', '120.382621', '36.067131', 2, NULL, '0532', '266001', 'Qingdao', 'Q', NULL);
INSERT INTO `ez_area` VALUES (370202, '市南区', 370200, '120.412392,36.075651', 'district', '120.412392', '36.075651', 3, NULL, '0532', '266001', 'Shinan', 'S', NULL);
INSERT INTO `ez_area` VALUES (370203, '市北区', 370200, '120.374701,36.0876', 'district', '120.374701', '36.0876', 3, NULL, '0532', '266011', 'Shibei', 'S', NULL);
INSERT INTO `ez_area` VALUES (370211, '黄岛区', 370200, '120.198055,35.960933', 'district', '120.198055', '35.960933', 3, NULL, '0532', '266500', 'Huangdao', 'H', NULL);
INSERT INTO `ez_area` VALUES (370212, '崂山区', 370200, '120.468956,36.107538', 'district', '120.468956', '36.107538', 3, NULL, '0532', '266100', 'Laoshan', 'L', NULL);
INSERT INTO `ez_area` VALUES (370213, '李沧区', 370200, '120.432922,36.145519', 'district', '120.432922', '36.145519', 3, NULL, '0532', '266021', 'Licang', 'L', NULL);
INSERT INTO `ez_area` VALUES (370214, '城阳区', 370200, '120.396256,36.307559', 'district', '120.396256', '36.307559', 3, NULL, '0532', '266041', 'Chengyang', 'C', NULL);
INSERT INTO `ez_area` VALUES (370281, '胶州市', 370200, '120.033382,36.26468', 'district', '120.033382', '36.26468', 3, NULL, '0532', '266300', 'Jiaozhou', 'J', NULL);
INSERT INTO `ez_area` VALUES (370282, '即墨市', 370200, '120.447158,36.389408', 'district', '120.447158', '36.389408', 3, NULL, '0532', '266200', 'Jimo', 'J', NULL);
INSERT INTO `ez_area` VALUES (370283, '平度市', 370200, '119.98842,36.776357', 'district', '119.98842', '36.776357', 3, NULL, '0532', '266700', 'Pingdu', 'P', NULL);
INSERT INTO `ez_area` VALUES (370285, '莱西市', 370200, '120.51769,36.889084', 'district', '120.51769', '36.889084', 3, NULL, '0532', '266600', 'Laixi', 'L', NULL);
INSERT INTO `ez_area` VALUES (370300, '淄博市', 370000, '118.055019,36.813546', 'city', '118.055019', '36.813546', 2, NULL, '0533', '255039', 'Zibo', 'Z', NULL);
INSERT INTO `ez_area` VALUES (370302, '淄川区', 370300, '117.966723,36.643452', 'district', '117.966723', '36.643452', 3, NULL, '0533', '255100', 'Zichuan', 'Z', NULL);
INSERT INTO `ez_area` VALUES (370303, '张店区', 370300, '118.017938,36.806669', 'district', '118.017938', '36.806669', 3, NULL, '0533', '255022', 'Zhangdian', 'Z', NULL);
INSERT INTO `ez_area` VALUES (370304, '博山区', 370300, '117.861851,36.494701', 'district', '117.861851', '36.494701', 3, NULL, '0533', '255200', 'Boshan', 'B', NULL);
INSERT INTO `ez_area` VALUES (370305, '临淄区', 370300, '118.309118,36.826981', 'district', '118.309118', '36.826981', 3, NULL, '0533', '255400', 'Linzi', 'L', NULL);
INSERT INTO `ez_area` VALUES (370306, '周村区', 370300, '117.869886,36.803072', 'district', '117.869886', '36.803072', 3, NULL, '0533', '255300', 'Zhoucun', 'Z', NULL);
INSERT INTO `ez_area` VALUES (370321, '桓台县', 370300, '118.097922,36.959804', 'district', '118.097922', '36.959804', 3, NULL, '0533', '256400', 'Huantai', 'H', NULL);
INSERT INTO `ez_area` VALUES (370322, '高青县', 370300, '117.826924,37.170979', 'district', '117.826924', '37.170979', 3, NULL, '0533', '256300', 'Gaoqing', 'G', NULL);
INSERT INTO `ez_area` VALUES (370323, '沂源县', 370300, '118.170855,36.185038', 'district', '118.170855', '36.185038', 3, NULL, '0533', '256100', 'Yiyuan', 'Y', NULL);
INSERT INTO `ez_area` VALUES (370400, '枣庄市', 370000, '117.323725,34.810488', 'city', '117.323725', '34.810488', 2, NULL, '0632', '277101', 'Zaozhuang', 'Z', NULL);
INSERT INTO `ez_area` VALUES (370402, '市中区', 370400, '117.556139,34.863554', 'district', '117.556139', '34.863554', 3, NULL, '0632', '277101', 'Shizhongqu', 'S', NULL);
INSERT INTO `ez_area` VALUES (370403, '薛城区', 370400, '117.263164,34.795062', 'district', '117.263164', '34.795062', 3, NULL, '0632', '277000', 'Xuecheng', 'X', NULL);
INSERT INTO `ez_area` VALUES (370404, '峄城区', 370400, '117.590816,34.773263', 'district', '117.590816', '34.773263', 3, NULL, '0632', '277300', 'Yicheng', 'Y', NULL);
INSERT INTO `ez_area` VALUES (370405, '台儿庄区', 370400, '117.734414,34.56244', 'district', '117.734414', '34.56244', 3, NULL, '0632', '277400', 'Taierzhuang', 'T', NULL);
INSERT INTO `ez_area` VALUES (370406, '山亭区', 370400, '117.461517,35.099528', 'district', '117.461517', '35.099528', 3, NULL, '0632', '277200', 'Shanting', 'S', NULL);
INSERT INTO `ez_area` VALUES (370481, '滕州市', 370400, '117.165824,35.114155', 'district', '117.165824', '35.114155', 3, NULL, '0632', '277500', 'Tengzhou', 'T', NULL);
INSERT INTO `ez_area` VALUES (370500, '东营市', 370000, '118.674614,37.433963', 'city', '118.674614', '37.433963', 2, NULL, '0546', '257093', 'Dongying', 'D', NULL);
INSERT INTO `ez_area` VALUES (370502, '东营区', 370500, '118.582184,37.448964', 'district', '118.582184', '37.448964', 3, NULL, '0546', '257029', 'Dongying', 'D', NULL);
INSERT INTO `ez_area` VALUES (370503, '河口区', 370500, '118.525543,37.886162', 'district', '118.525543', '37.886162', 3, NULL, '0546', '257200', 'Hekou', 'H', NULL);
INSERT INTO `ez_area` VALUES (370505, '垦利区', 370500, '118.575228,37.573054', 'district', '118.575228', '37.573054', 3, NULL, '0546', '257500', 'Kenli', 'K', NULL);
INSERT INTO `ez_area` VALUES (370522, '利津县', 370500, '118.255287,37.490328', 'district', '118.255287', '37.490328', 3, NULL, '0546', '257400', 'Lijin', 'L', NULL);
INSERT INTO `ez_area` VALUES (370523, '广饶县', 370500, '118.407107,37.053555', 'district', '118.407107', '37.053555', 3, NULL, '0546', '257300', 'Guangrao', 'G', NULL);
INSERT INTO `ez_area` VALUES (370600, '烟台市', 370000, '121.447852,37.464539', 'city', '121.447852', '37.464539', 2, NULL, '0635', '264010', 'Yantai', 'Y', NULL);
INSERT INTO `ez_area` VALUES (370602, '芝罘区', 370600, '121.400445,37.541475', 'district', '121.400445', '37.541475', 3, NULL, '0635', '264001', 'Zhifu', 'Z', NULL);
INSERT INTO `ez_area` VALUES (370611, '福山区', 370600, '121.267741,37.498246', 'district', '121.267741', '37.498246', 3, NULL, '0635', '265500', 'Fushan', 'F', NULL);
INSERT INTO `ez_area` VALUES (370612, '牟平区', 370600, '121.600455,37.387061', 'district', '121.600455', '37.387061', 3, NULL, '0635', '264100', 'Muping', 'M', NULL);
INSERT INTO `ez_area` VALUES (370613, '莱山区', 370600, '121.445301,37.511291', 'district', '121.445301', '37.511291', 3, NULL, '0635', '264600', 'Laishan', 'L', NULL);
INSERT INTO `ez_area` VALUES (370634, '长岛县', 370600, '120.73658,37.921368', 'district', '120.73658', '37.921368', 3, NULL, '0635', '265800', 'Changdao', 'C', NULL);
INSERT INTO `ez_area` VALUES (370681, '龙口市', 370600, '120.477813,37.646107', 'district', '120.477813', '37.646107', 3, NULL, '0635', '265700', 'Longkou', 'L', NULL);
INSERT INTO `ez_area` VALUES (370682, '莱阳市', 370600, '120.711672,36.978941', 'district', '120.711672', '36.978941', 3, NULL, '0635', '265200', 'Laiyang', 'L', NULL);
INSERT INTO `ez_area` VALUES (370683, '莱州市', 370600, '119.942274,37.177129', 'district', '119.942274', '37.177129', 3, NULL, '0635', '261400', 'Laizhou', 'L', NULL);
INSERT INTO `ez_area` VALUES (370684, '蓬莱市', 370600, '120.758848,37.810661', 'district', '120.758848', '37.810661', 3, NULL, '0635', '265600', 'Penglai', 'P', NULL);
INSERT INTO `ez_area` VALUES (370685, '招远市', 370600, '120.434071,37.355469', 'district', '120.434071', '37.355469', 3, NULL, '0635', '265400', 'Zhaoyuan', 'Z', NULL);
INSERT INTO `ez_area` VALUES (370686, '栖霞市', 370600, '120.849675,37.335123', 'district', '120.849675', '37.335123', 3, NULL, '0635', '265300', 'Qixia', 'Q', NULL);
INSERT INTO `ez_area` VALUES (370687, '海阳市', 370600, '121.173793,36.688', 'district', '121.173793', '36.688', 3, NULL, '0635', '265100', 'Haiyang', 'H', NULL);
INSERT INTO `ez_area` VALUES (370700, '潍坊市', 370000, '119.161748,36.706962', 'city', '119.161748', '36.706962', 2, NULL, '0536', '261041', 'Weifang', 'W', NULL);
INSERT INTO `ez_area` VALUES (370702, '潍城区', 370700, '119.024835,36.7281', 'district', '119.024835', '36.7281', 3, NULL, '0536', '261021', 'Weicheng', 'W', NULL);
INSERT INTO `ez_area` VALUES (370703, '寒亭区', 370700, '119.211157,36.755623', 'district', '119.211157', '36.755623', 3, NULL, '0536', '261100', 'Hanting', 'H', NULL);
INSERT INTO `ez_area` VALUES (370704, '坊子区', 370700, '119.166485,36.654448', 'district', '119.166485', '36.654448', 3, NULL, '0536', '261200', 'Fangzi', 'F', NULL);
INSERT INTO `ez_area` VALUES (370705, '奎文区', 370700, '119.132482,36.70759', 'district', '119.132482', '36.70759', 3, NULL, '0536', '261031', 'Kuiwen', 'K', NULL);
INSERT INTO `ez_area` VALUES (370724, '临朐县', 370700, '118.542982,36.512506', 'district', '118.542982', '36.512506', 3, NULL, '0536', '262600', 'Linqu', 'L', NULL);
INSERT INTO `ez_area` VALUES (370725, '昌乐县', 370700, '118.829992,36.706964', 'district', '118.829992', '36.706964', 3, NULL, '0536', '262400', 'Changle', 'C', NULL);
INSERT INTO `ez_area` VALUES (370781, '青州市', 370700, '118.479654,36.684789', 'district', '118.479654', '36.684789', 3, NULL, '0536', '262500', 'Qingzhou', 'Q', NULL);
INSERT INTO `ez_area` VALUES (370782, '诸城市', 370700, '119.410103,35.995654', 'district', '119.410103', '35.995654', 3, NULL, '0536', '262200', 'Zhucheng', 'Z', NULL);
INSERT INTO `ez_area` VALUES (370783, '寿光市', 370700, '118.790739,36.85576', 'district', '118.790739', '36.85576', 3, NULL, '0536', '262700', 'Shouguang', 'S', NULL);
INSERT INTO `ez_area` VALUES (370784, '安丘市', 370700, '119.218978,36.478493', 'district', '119.218978', '36.478493', 3, NULL, '0536', '262100', 'Anqiu', 'A', NULL);
INSERT INTO `ez_area` VALUES (370785, '高密市', 370700, '119.755597,36.382594', 'district', '119.755597', '36.382594', 3, NULL, '0536', '261500', 'Gaomi', 'G', NULL);
INSERT INTO `ez_area` VALUES (370786, '昌邑市', 370700, '119.403069,36.843319', 'district', '119.403069', '36.843319', 3, NULL, '0536', '261300', 'Changyi', 'C', NULL);
INSERT INTO `ez_area` VALUES (370800, '济宁市', 370000, '116.587282,35.414982', 'city', '116.587282', '35.414982', 2, NULL, '0537', '272119', 'Jining', 'J', NULL);
INSERT INTO `ez_area` VALUES (370811, '任城区', 370800, '116.606103,35.444028', 'district', '116.606103', '35.444028', 3, NULL, '0537', '272113', 'Rencheng', 'R', NULL);
INSERT INTO `ez_area` VALUES (370812, '兖州区', 370800, '116.783833,35.553144', 'district', '116.783833', '35.553144', 3, NULL, '0537', '272000', 'Yanzhou ', 'Y', NULL);
INSERT INTO `ez_area` VALUES (370826, '微山县', 370800, '117.128827,34.806554', 'district', '117.128827', '34.806554', 3, NULL, '0537', '277600', 'Weishan', 'W', NULL);
INSERT INTO `ez_area` VALUES (370827, '鱼台县', 370800, '116.650608,35.012749', 'district', '116.650608', '35.012749', 3, NULL, '0537', '272300', 'Yutai', 'Y', NULL);
INSERT INTO `ez_area` VALUES (370828, '金乡县', 370800, '116.311532,35.066619', 'district', '116.311532', '35.066619', 3, NULL, '0537', '272200', 'Jinxiang', 'J', NULL);
INSERT INTO `ez_area` VALUES (370829, '嘉祥县', 370800, '116.342449,35.408824', 'district', '116.342449', '35.408824', 3, NULL, '0537', '272400', 'Jiaxiang', 'J', NULL);
INSERT INTO `ez_area` VALUES (370830, '汶上县', 370800, '116.49708,35.712298', 'district', '116.49708', '35.712298', 3, NULL, '0537', '272501', 'Wenshang', 'W', NULL);
INSERT INTO `ez_area` VALUES (370831, '泗水县', 370800, '117.251195,35.664323', 'district', '117.251195', '35.664323', 3, NULL, '0537', '273200', 'Sishui', 'S', NULL);
INSERT INTO `ez_area` VALUES (370832, '梁山县', 370800, '116.096044,35.802306', 'district', '116.096044', '35.802306', 3, NULL, '0537', '272600', 'Liangshan', 'L', NULL);
INSERT INTO `ez_area` VALUES (370881, '曲阜市', 370800, '116.986526,35.581108', 'district', '116.986526', '35.581108', 3, NULL, '0537', '273100', 'Qufu', 'Q', NULL);
INSERT INTO `ez_area` VALUES (370883, '邹城市', 370800, '117.007453,35.40268', 'district', '117.007453', '35.40268', 3, NULL, '0537', '273500', 'Zoucheng', 'Z', NULL);
INSERT INTO `ez_area` VALUES (370900, '泰安市', 370000, '117.087614,36.200252', 'city', '117.087614', '36.200252', 2, NULL, '0538', '271000', 'Tai\'an', 'T', NULL);
INSERT INTO `ez_area` VALUES (370902, '泰山区', 370900, '117.135354,36.192083', 'district', '117.135354', '36.192083', 3, NULL, '0538', '271000', 'Taishan', 'T', NULL);
INSERT INTO `ez_area` VALUES (370911, '岱岳区', 370900, '117.041581,36.187989', 'district', '117.041581', '36.187989', 3, NULL, '0538', '271000', 'Daiyue', 'D', NULL);
INSERT INTO `ez_area` VALUES (370921, '宁阳县', 370900, '116.805796,35.758786', 'district', '116.805796', '35.758786', 3, NULL, '0538', '271400', 'Ningyang', 'N', NULL);
INSERT INTO `ez_area` VALUES (370923, '东平县', 370900, '116.470304,35.937102', 'district', '116.470304', '35.937102', 3, NULL, '0538', '271500', 'Dongping', 'D', NULL);
INSERT INTO `ez_area` VALUES (370982, '新泰市', 370900, '117.767952,35.909032', 'district', '117.767952', '35.909032', 3, NULL, '0538', '271200', 'Xintai', 'X', NULL);
INSERT INTO `ez_area` VALUES (370983, '肥城市', 370900, '116.768358,36.182571', 'district', '116.768358', '36.182571', 3, NULL, '0538', '271600', 'Feicheng', 'F', NULL);
INSERT INTO `ez_area` VALUES (371000, '威海市', 370000, '122.120282,37.513412', 'city', '122.120282', '37.513412', 2, NULL, '0631', '264200', 'Weihai', 'W', NULL);
INSERT INTO `ez_area` VALUES (371002, '环翠区', 371000, '122.123443,37.50199', 'district', '122.123443', '37.50199', 3, NULL, '0631', '264200', 'Huancui', 'H', NULL);
INSERT INTO `ez_area` VALUES (371003, '文登区', 371000, '122.05767,37.193735', 'district', '122.05767', '37.193735', 3, NULL, '0631', '266440', 'Wendeng', 'W', NULL);
INSERT INTO `ez_area` VALUES (371082, '荣成市', 371000, '122.486657,37.16516', 'district', '122.486657', '37.16516', 3, NULL, '0631', '264300', 'Rongcheng', 'R', NULL);
INSERT INTO `ez_area` VALUES (371083, '乳山市', 371000, '121.539764,36.919816', 'district', '121.539764', '36.919816', 3, NULL, '0631', '264500', 'Rushan', 'R', NULL);
INSERT INTO `ez_area` VALUES (371100, '日照市', 370000, '119.526925,35.416734', 'city', '119.526925', '35.416734', 2, NULL, '0633', '276800', 'Rizhao', 'R', NULL);
INSERT INTO `ez_area` VALUES (371102, '东港区', 371100, '119.462267,35.42548', 'district', '119.462267', '35.42548', 3, NULL, '0633', '276800', 'Donggang', 'D', NULL);
INSERT INTO `ez_area` VALUES (371103, '岚山区', 371100, '119.318928,35.121884', 'district', '119.318928', '35.121884', 3, NULL, '0633', '276808', 'Lanshan', 'L', NULL);
INSERT INTO `ez_area` VALUES (371121, '五莲县', 371100, '119.213619,35.760228', 'district', '119.213619', '35.760228', 3, NULL, '0633', '262300', 'Wulian', 'W', NULL);
INSERT INTO `ez_area` VALUES (371122, '莒县', 371100, '118.837063,35.579868', 'district', '118.837063', '35.579868', 3, NULL, '0633', '276500', 'Juxian', 'J', NULL);
INSERT INTO `ez_area` VALUES (371200, '莱芜市', 370000, '117.676723,36.213813', 'city', '117.676723', '36.213813', 2, NULL, '0634', '271100', 'Laiwu', 'L', NULL);
INSERT INTO `ez_area` VALUES (371202, '莱城区', 371200, '117.659884,36.203179', 'district', '117.659884', '36.203179', 3, NULL, '0634', '271199', 'Laicheng', 'L', NULL);
INSERT INTO `ez_area` VALUES (371203, '钢城区', 371200, '117.811354,36.058572', 'district', '117.811354', '36.058572', 3, NULL, '0634', '271100', 'Gangcheng', 'G', NULL);
INSERT INTO `ez_area` VALUES (371300, '临沂市', 370000, '118.356414,35.104673', 'city', '118.356414', '35.104673', 2, NULL, '0539', '253000', 'Linyi', 'L', NULL);
INSERT INTO `ez_area` VALUES (371302, '兰山区', 371300, '118.347842,35.051804', 'district', '118.347842', '35.051804', 3, NULL, '0539', '276002', 'Lanshan', 'L', NULL);
INSERT INTO `ez_area` VALUES (371311, '罗庄区', 371300, '118.284786,34.996741', 'district', '118.284786', '34.996741', 3, NULL, '0539', '276022', 'Luozhuang', 'L', NULL);
INSERT INTO `ez_area` VALUES (371312, '河东区', 371300, '118.402893,35.089916', 'district', '118.402893', '35.089916', 3, NULL, '0539', '276034', 'Hedong', 'H', NULL);
INSERT INTO `ez_area` VALUES (371321, '沂南县', 371300, '118.465221,35.550217', 'district', '118.465221', '35.550217', 3, NULL, '0539', '276300', 'Yinan', 'Y', NULL);
INSERT INTO `ez_area` VALUES (371322, '郯城县', 371300, '118.367215,34.613586', 'district', '118.367215', '34.613586', 3, NULL, '0539', '276100', 'Tancheng', 'T', NULL);
INSERT INTO `ez_area` VALUES (371323, '沂水县', 371300, '118.627917,35.79045', 'district', '118.627917', '35.79045', 3, NULL, '0539', '276400', 'Yishui', 'Y', NULL);
INSERT INTO `ez_area` VALUES (371324, '兰陵县', 371300, '118.07065,34.857149', 'district', '118.07065', '34.857149', 3, NULL, '0539', '277700', 'Lanling', 'L', NULL);
INSERT INTO `ez_area` VALUES (371325, '费县', 371300, '117.977325,35.26596', 'district', '117.977325', '35.26596', 3, NULL, '0539', '273400', 'Feixian', 'F', NULL);
INSERT INTO `ez_area` VALUES (371326, '平邑县', 371300, '117.640352,35.505943', 'district', '117.640352', '35.505943', 3, NULL, '0539', '273300', 'Pingyi', 'P', NULL);
INSERT INTO `ez_area` VALUES (371327, '莒南县', 371300, '118.835163,35.174846', 'district', '118.835163', '35.174846', 3, NULL, '0539', '276600', 'Junan', 'J', NULL);
INSERT INTO `ez_area` VALUES (371328, '蒙阴县', 371300, '117.953621,35.719396', 'district', '117.953621', '35.719396', 3, NULL, '0539', '276200', 'Mengyin', 'M', NULL);
INSERT INTO `ez_area` VALUES (371329, '临沭县', 371300, '118.650781,34.919851', 'district', '118.650781', '34.919851', 3, NULL, '0539', '276700', 'Linshu', 'L', NULL);
INSERT INTO `ez_area` VALUES (371400, '德州市', 370000, '116.359381,37.436657', 'city', '116.359381', '37.436657', 2, NULL, '0534', '253000', 'Dezhou', 'D', NULL);
INSERT INTO `ez_area` VALUES (371402, '德城区', 371400, '116.29947,37.450804', 'district', '116.29947', '37.450804', 3, NULL, '0534', '253012', 'Decheng', 'D', NULL);
INSERT INTO `ez_area` VALUES (371403, '陵城区', 371400, '116.576092,37.335794', 'district', '116.576092', '37.335794', 3, NULL, '0534', '253500', 'Lingcheng', 'L', NULL);
INSERT INTO `ez_area` VALUES (371422, '宁津县', 371400, '116.800306,37.652189', 'district', '116.800306', '37.652189', 3, NULL, '0534', '253400', 'Ningjin', 'N', NULL);
INSERT INTO `ez_area` VALUES (371423, '庆云县', 371400, '117.385256,37.775349', 'district', '117.385256', '37.775349', 3, NULL, '0534', '253700', 'Qingyun', 'Q', NULL);
INSERT INTO `ez_area` VALUES (371424, '临邑县', 371400, '116.866799,37.189797', 'district', '116.866799', '37.189797', 3, NULL, '0534', '251500', 'Linyi', 'L', NULL);
INSERT INTO `ez_area` VALUES (371425, '齐河县', 371400, '116.762893,36.784158', 'district', '116.762893', '36.784158', 3, NULL, '0534', '251100', 'Qihe', 'Q', NULL);
INSERT INTO `ez_area` VALUES (371426, '平原县', 371400, '116.434032,37.165323', 'district', '116.434032', '37.165323', 3, NULL, '0534', '253100', 'Pingyuan', 'P', NULL);
INSERT INTO `ez_area` VALUES (371427, '夏津县', 371400, '116.001726,36.948371', 'district', '116.001726', '36.948371', 3, NULL, '0534', '253200', 'Xiajin', 'X', NULL);
INSERT INTO `ez_area` VALUES (371428, '武城县', 371400, '116.069302,37.213311', 'district', '116.069302', '37.213311', 3, NULL, '0534', '253300', 'Wucheng', 'W', NULL);
INSERT INTO `ez_area` VALUES (371481, '乐陵市', 371400, '117.231934,37.729907', 'district', '117.231934', '37.729907', 3, NULL, '0534', '253600', 'Leling', 'L', NULL);
INSERT INTO `ez_area` VALUES (371482, '禹城市', 371400, '116.638327,36.933812', 'district', '116.638327', '36.933812', 3, NULL, '0534', '251200', 'Yucheng', 'Y', NULL);
INSERT INTO `ez_area` VALUES (371500, '聊城市', 370000, '115.985389,36.456684', 'city', '115.985389', '36.456684', 2, NULL, '0635', '252052', 'Liaocheng', 'L', NULL);
INSERT INTO `ez_area` VALUES (371502, '东昌府区', 371500, '115.988349,36.434669', 'district', '115.988349', '36.434669', 3, NULL, '0635', '252000', 'Dongchangfu', 'D', NULL);
INSERT INTO `ez_area` VALUES (371521, '阳谷县', 371500, '115.79182,36.114392', 'district', '115.79182', '36.114392', 3, NULL, '0635', '252300', 'Yanggu', 'Y', NULL);
INSERT INTO `ez_area` VALUES (371522, '莘县', 371500, '115.671191,36.233598', 'district', '115.671191', '36.233598', 3, NULL, '0635', '252400', 'Shenxian', 'S', NULL);
INSERT INTO `ez_area` VALUES (371523, '茌平县', 371500, '116.25527,36.580688', 'district', '116.25527', '36.580688', 3, NULL, '0635', '252100', 'Chiping', 'C', NULL);
INSERT INTO `ez_area` VALUES (371524, '东阿县', 371500, '116.247579,36.334917', 'district', '116.247579', '36.334917', 3, NULL, '0635', '252200', 'Dong\'e', 'D', NULL);
INSERT INTO `ez_area` VALUES (371525, '冠县', 371500, '115.442739,36.484009', 'district', '115.442739', '36.484009', 3, NULL, '0635', '252500', 'Guanxian', 'G', NULL);
INSERT INTO `ez_area` VALUES (371526, '高唐县', 371500, '116.23016,36.846762', 'district', '116.23016', '36.846762', 3, NULL, '0635', '252800', 'Gaotang', 'G', NULL);
INSERT INTO `ez_area` VALUES (371581, '临清市', 371500, '115.704881,36.838277', 'district', '115.704881', '36.838277', 3, NULL, '0635', '252600', 'Linqing', 'L', NULL);
INSERT INTO `ez_area` VALUES (371600, '滨州市', 370000, '117.970699,37.38198', 'city', '117.970699', '37.38198', 2, NULL, '0543', '256619', 'Binzhou', 'B', NULL);
INSERT INTO `ez_area` VALUES (371602, '滨城区', 371600, '118.019326,37.430724', 'district', '118.019326', '37.430724', 3, NULL, '0543', '256613', 'Bincheng', 'B', NULL);
INSERT INTO `ez_area` VALUES (371603, '沾化区', 371600, '118.098902,37.69926', 'district', '118.098902', '37.69926', 3, NULL, '0543', '256800', 'Zhanhua', 'Z', NULL);
INSERT INTO `ez_area` VALUES (371621, '惠民县', 371600, '117.509921,37.489877', 'district', '117.509921', '37.489877', 3, NULL, '0543', '251700', 'Huimin', 'H', NULL);
INSERT INTO `ez_area` VALUES (371622, '阳信县', 371600, '117.603339,37.632433', 'district', '117.603339', '37.632433', 3, NULL, '0543', '251800', 'Yangxin', 'Y', NULL);
INSERT INTO `ez_area` VALUES (371623, '无棣县', 371600, '117.625696,37.77026', 'district', '117.625696', '37.77026', 3, NULL, '0543', '251900', 'Wudi', 'W', NULL);
INSERT INTO `ez_area` VALUES (371625, '博兴县', 371600, '118.110709,37.15457', 'district', '118.110709', '37.15457', 3, NULL, '0543', '256500', 'Boxing', 'B', NULL);
INSERT INTO `ez_area` VALUES (371626, '邹平县', 371600, '117.743109,36.862989', 'district', '117.743109', '36.862989', 3, NULL, '0543', '256200', 'Zouping', 'Z', NULL);
INSERT INTO `ez_area` VALUES (371700, '菏泽市', 370000, '115.480656,35.23375', 'city', '115.480656', '35.23375', 2, NULL, '0530', '274020', 'Heze', 'H', NULL);
INSERT INTO `ez_area` VALUES (371702, '牡丹区', 371700, '115.417826,35.252512', 'district', '115.417826', '35.252512', 3, NULL, '0530', '274009', 'Mudan', 'M', NULL);
INSERT INTO `ez_area` VALUES (371703, '定陶区', 371700, '115.57302,35.070995', 'district', '115.57302', '35.070995', 3, NULL, '0530', '274100', 'Dingtao', 'D', NULL);
INSERT INTO `ez_area` VALUES (371721, '曹县', 371700, '115.542328,34.825508', 'district', '115.542328', '34.825508', 3, NULL, '0530', '274400', 'Caoxian', 'C', NULL);
INSERT INTO `ez_area` VALUES (371722, '单县', 371700, '116.107428,34.778808', 'district', '116.107428', '34.778808', 3, NULL, '0530', '273700', 'Shanxian', 'S', NULL);
INSERT INTO `ez_area` VALUES (371723, '成武县', 371700, '115.889764,34.952459', 'district', '115.889764', '34.952459', 3, NULL, '0530', '274200', 'Chengwu', 'C', NULL);
INSERT INTO `ez_area` VALUES (371724, '巨野县', 371700, '116.062394,35.388925', 'district', '116.062394', '35.388925', 3, NULL, '0530', '274900', 'Juye', 'J', NULL);
INSERT INTO `ez_area` VALUES (371725, '郓城县', 371700, '115.9389,35.575135', 'district', '115.9389', '35.575135', 3, NULL, '0530', '274700', 'Yuncheng', 'Y', NULL);
INSERT INTO `ez_area` VALUES (371726, '鄄城县', 371700, '115.510192,35.563408', 'district', '115.510192', '35.563408', 3, NULL, '0530', '274600', 'Juancheng', 'J', NULL);
INSERT INTO `ez_area` VALUES (371728, '东明县', 371700, '115.107404,35.276162', 'district', '115.107404', '35.276162', 3, NULL, '0530', '274500', 'Dongming', 'D', NULL);
INSERT INTO `ez_area` VALUES (410000, '河南省', 0, '113.753394,34.765869', 'province', '113.753394', '34.765869', 1, NULL, NULL, NULL, 'Henan', 'H', NULL);
INSERT INTO `ez_area` VALUES (410100, '郑州市', 410000, '113.625328,34.746611', 'city', '113.625328', '34.746611', 2, NULL, '0371', '450000', 'Zhengzhou', 'Z', NULL);
INSERT INTO `ez_area` VALUES (410102, '中原区', 410100, '113.613337,34.748256', 'district', '113.613337', '34.748256', 3, NULL, '0371', '450007', 'Zhongyuan', 'Z', NULL);
INSERT INTO `ez_area` VALUES (410103, '二七区', 410100, '113.640211,34.724114', 'district', '113.640211', '34.724114', 3, NULL, '0371', '450052', 'Erqi', 'E', NULL);
INSERT INTO `ez_area` VALUES (410104, '管城回族区', 410100, '113.6775,34.75429', 'district', '113.6775', '34.75429', 3, NULL, '0371', '450000', 'Guancheng', 'G', NULL);
INSERT INTO `ez_area` VALUES (410105, '金水区', 410100, '113.660617,34.800004', 'district', '113.660617', '34.800004', 3, NULL, '0371', '450003', 'Jinshui', 'J', NULL);
INSERT INTO `ez_area` VALUES (410106, '上街区', 410100, '113.30893,34.802752', 'district', '113.30893', '34.802752', 3, NULL, '0371', '450041', 'Shangjie', 'S', NULL);
INSERT INTO `ez_area` VALUES (410108, '惠济区', 410100, '113.6169,34.867457', 'district', '113.6169', '34.867457', 3, NULL, '0371', '450053', 'Huiji', 'H', NULL);
INSERT INTO `ez_area` VALUES (410122, '中牟县', 410100, '113.976253,34.718936', 'district', '113.976253', '34.718936', 3, NULL, '0371', '451450', 'Zhongmu', 'Z', NULL);
INSERT INTO `ez_area` VALUES (410181, '巩义市', 410100, '113.022406,34.7481', 'district', '113.022406', '34.7481', 3, NULL, '0371', '451200', 'Gongyi', 'G', NULL);
INSERT INTO `ez_area` VALUES (410182, '荥阳市', 410100, '113.38324,34.786948', 'district', '113.38324', '34.786948', 3, NULL, '0371', '450100', 'Xingyang', 'X', NULL);
INSERT INTO `ez_area` VALUES (410183, '新密市', 410100, '113.391087,34.539376', 'district', '113.391087', '34.539376', 3, NULL, '0371', '452300', 'Xinmi', 'X', NULL);
INSERT INTO `ez_area` VALUES (410184, '新郑市', 410100, '113.740662,34.395949', 'district', '113.740662', '34.395949', 3, NULL, '0371', '451100', 'Xinzheng', 'X', NULL);
INSERT INTO `ez_area` VALUES (410185, '登封市', 410100, '113.050581,34.454443', 'district', '113.050581', '34.454443', 3, NULL, '0371', '452470', 'Dengfeng', 'D', NULL);
INSERT INTO `ez_area` VALUES (410200, '开封市', 410000, '114.307677,34.797966', 'city', '114.307677', '34.797966', 2, NULL, '0378', '475001', 'Kaifeng', 'K', NULL);
INSERT INTO `ez_area` VALUES (410202, '龙亭区', 410200, '114.356076,34.815565', 'district', '114.356076', '34.815565', 3, NULL, '0378', '475100', 'Longting', 'L', NULL);
INSERT INTO `ez_area` VALUES (410203, '顺河回族区', 410200, '114.364875,34.800458', 'district', '114.364875', '34.800458', 3, NULL, '0378', '475000', 'Shunhe', 'S', NULL);
INSERT INTO `ez_area` VALUES (410204, '鼓楼区', 410200, '114.348306,34.78856', 'district', '114.348306', '34.78856', 3, NULL, '0378', '475000', 'Gulou', 'G', NULL);
INSERT INTO `ez_area` VALUES (410205, '禹王台区', 410200, '114.34817,34.777104', 'district', '114.34817', '34.777104', 3, NULL, '0378', '475003', 'Yuwangtai', 'Y', NULL);
INSERT INTO `ez_area` VALUES (410212, '祥符区', 410200, '114.441285,34.756916', 'district', '114.441285', '34.756916', 3, NULL, '0378', '475100', 'Xiangfu', 'X', NULL);
INSERT INTO `ez_area` VALUES (410221, '杞县', 410200, '114.783139,34.549174', 'district', '114.783139', '34.549174', 3, NULL, '0378', '475200', 'Qixian', 'Q', NULL);
INSERT INTO `ez_area` VALUES (410222, '通许县', 410200, '114.467467,34.480433', 'district', '114.467467', '34.480433', 3, NULL, '0378', '475400', 'Tongxu', 'T', NULL);
INSERT INTO `ez_area` VALUES (410223, '尉氏县', 410200, '114.193081,34.411494', 'district', '114.193081', '34.411494', 3, NULL, '0378', '475500', 'Weishi', 'W', NULL);
INSERT INTO `ez_area` VALUES (410225, '兰考县', 410200, '114.821348,34.822211', 'district', '114.821348', '34.822211', 3, NULL, '0378', '475300', 'Lankao', 'L', NULL);
INSERT INTO `ez_area` VALUES (410300, '洛阳市', 410000, '112.453926,34.620202', 'city', '112.453926', '34.620202', 2, NULL, '0379', '471000', 'Luoyang', 'L', NULL);
INSERT INTO `ez_area` VALUES (410302, '老城区', 410300, '112.469766,34.6842', 'district', '112.469766', '34.6842', 3, NULL, '0379', '471002', 'Laocheng', 'L', NULL);
INSERT INTO `ez_area` VALUES (410303, '西工区', 410300, '112.427914,34.660378', 'district', '112.427914', '34.660378', 3, NULL, '0379', '471000', 'Xigong', 'X', NULL);
INSERT INTO `ez_area` VALUES (410304, '瀍河回族区', 410300, '112.500131,34.679773', 'district', '112.500131', '34.679773', 3, NULL, '0379', '471002', 'Chanhe', 'C', NULL);
INSERT INTO `ez_area` VALUES (410305, '涧西区', 410300, '112.395756,34.658033', 'district', '112.395756', '34.658033', 3, NULL, '0379', '471003', 'Jianxi', 'J', NULL);
INSERT INTO `ez_area` VALUES (410306, '吉利区', 410300, '112.589112,34.900467', 'district', '112.589112', '34.900467', 3, NULL, '0379', '471012', 'Jili', 'J', NULL);
INSERT INTO `ez_area` VALUES (410311, '洛龙区', 410300, '112.463833,34.619711', 'district', '112.463833', '34.619711', 3, NULL, '0379', '471000', 'Luolong', 'L', NULL);
INSERT INTO `ez_area` VALUES (410322, '孟津县', 410300, '112.445354,34.825638', 'district', '112.445354', '34.825638', 3, NULL, '0379', '471100', 'Mengjin', 'M', NULL);
INSERT INTO `ez_area` VALUES (410323, '新安县', 410300, '112.13244,34.728284', 'district', '112.13244', '34.728284', 3, NULL, '0379', '471800', 'Xin\'an', 'X', NULL);
INSERT INTO `ez_area` VALUES (410324, '栾川县', 410300, '111.615768,33.785698', 'district', '111.615768', '33.785698', 3, NULL, '0379', '471500', 'Luanchuan', 'L', NULL);
INSERT INTO `ez_area` VALUES (410325, '嵩县', 410300, '112.085634,34.134516', 'district', '112.085634', '34.134516', 3, NULL, '0379', '471400', 'Songxian', 'S', NULL);
INSERT INTO `ez_area` VALUES (410326, '汝阳县', 410300, '112.473139,34.153939', 'district', '112.473139', '34.153939', 3, NULL, '0379', '471200', 'Ruyang', 'R', NULL);
INSERT INTO `ez_area` VALUES (410327, '宜阳县', 410300, '112.179238,34.514644', 'district', '112.179238', '34.514644', 3, NULL, '0379', '471600', 'Yiyang', 'Y', NULL);
INSERT INTO `ez_area` VALUES (410328, '洛宁县', 410300, '111.653111,34.389197', 'district', '111.653111', '34.389197', 3, NULL, '0379', '471700', 'Luoning', 'L', NULL);
INSERT INTO `ez_area` VALUES (410329, '伊川县', 410300, '112.425676,34.421323', 'district', '112.425676', '34.421323', 3, NULL, '0379', '471300', 'Yichuan', 'Y', NULL);
INSERT INTO `ez_area` VALUES (410381, '偃师市', 410300, '112.789534,34.72722', 'district', '112.789534', '34.72722', 3, NULL, '0379', '471900', 'Yanshi', 'Y', NULL);
INSERT INTO `ez_area` VALUES (410400, '平顶山市', 410000, '113.192661,33.766169', 'city', '113.192661', '33.766169', 2, NULL, '0375', '467000', 'Pingdingshan', 'P', NULL);
INSERT INTO `ez_area` VALUES (410402, '新华区', 410400, '113.293977,33.737251', 'district', '113.293977', '33.737251', 3, NULL, '0375', '467002', 'Xinhua', 'X', NULL);
INSERT INTO `ez_area` VALUES (410403, '卫东区', 410400, '113.335192,33.734706', 'district', '113.335192', '33.734706', 3, NULL, '0375', '467021', 'Weidong', 'W', NULL);
INSERT INTO `ez_area` VALUES (410404, '石龙区', 410400, '112.898818,33.898713', 'district', '112.898818', '33.898713', 3, NULL, '0375', '467045', 'Shilong', 'S', NULL);
INSERT INTO `ez_area` VALUES (410411, '湛河区', 410400, '113.320873,33.725681', 'district', '113.320873', '33.725681', 3, NULL, '0375', '467000', 'Zhanhe', 'Z', NULL);
INSERT INTO `ez_area` VALUES (410421, '宝丰县', 410400, '113.054801,33.868434', 'district', '113.054801', '33.868434', 3, NULL, '0375', '467400', 'Baofeng', 'B', NULL);
INSERT INTO `ez_area` VALUES (410422, '叶县', 410400, '113.357239,33.626731', 'district', '113.357239', '33.626731', 3, NULL, '0375', '467200', 'Yexian', 'Y', NULL);
INSERT INTO `ez_area` VALUES (410423, '鲁山县', 410400, '112.908202,33.738293', 'district', '112.908202', '33.738293', 3, NULL, '0375', '467300', 'Lushan', 'L', NULL);
INSERT INTO `ez_area` VALUES (410425, '郏县', 410400, '113.212609,33.971787', 'district', '113.212609', '33.971787', 3, NULL, '0375', '467100', 'Jiaxian', 'J', NULL);
INSERT INTO `ez_area` VALUES (410481, '舞钢市', 410400, '113.516343,33.314033', 'district', '113.516343', '33.314033', 3, NULL, '0375', '462500', 'Wugang', 'W', NULL);
INSERT INTO `ez_area` VALUES (410482, '汝州市', 410400, '112.844517,34.167029', 'district', '112.844517', '34.167029', 3, NULL, '0375', '467500', 'Ruzhou', 'R', NULL);
INSERT INTO `ez_area` VALUES (410500, '安阳市', 410000, '114.392392,36.097577', 'city', '114.392392', '36.097577', 2, NULL, '0372', '455000', 'Anyang', 'A', NULL);
INSERT INTO `ez_area` VALUES (410502, '文峰区', 410500, '114.357082,36.090468', 'district', '114.357082', '36.090468', 3, NULL, '0372', '455000', 'Wenfeng', 'W', NULL);
INSERT INTO `ez_area` VALUES (410503, '北关区', 410500, '114.355742,36.10766', 'district', '114.355742', '36.10766', 3, NULL, '0372', '455001', 'Beiguan', 'B', NULL);
INSERT INTO `ez_area` VALUES (410505, '殷都区', 410500, '114.303553,36.10989', 'district', '114.303553', '36.10989', 3, NULL, '0372', '455004', 'Yindu', 'Y', NULL);
INSERT INTO `ez_area` VALUES (410506, '龙安区', 410500, '114.301331,36.076225', 'district', '114.301331', '36.076225', 3, NULL, '0372', '455001', 'Long\'an', 'L', NULL);
INSERT INTO `ez_area` VALUES (410522, '安阳县', 410500, '114.130207,36.130584', 'district', '114.130207', '36.130584', 3, NULL, '0372', '455000', 'Anyang', 'A', NULL);
INSERT INTO `ez_area` VALUES (410523, '汤阴县', 410500, '114.357763,35.924514', 'district', '114.357763', '35.924514', 3, NULL, '0372', '456150', 'Tangyin', 'T', NULL);
INSERT INTO `ez_area` VALUES (410526, '滑县', 410500, '114.519311,35.575417', 'district', '114.519311', '35.575417', 3, NULL, '0372', '456400', 'Huaxian', 'H', NULL);
INSERT INTO `ez_area` VALUES (410527, '内黄县', 410500, '114.901452,35.971704', 'district', '114.901452', '35.971704', 3, NULL, '0372', '456350', 'Neihuang', 'N', NULL);
INSERT INTO `ez_area` VALUES (410581, '林州市', 410500, '113.820129,36.083046', 'district', '113.820129', '36.083046', 3, NULL, '0372', '456550', 'Linzhou', 'L', NULL);
INSERT INTO `ez_area` VALUES (410600, '鹤壁市', 410000, '114.297309,35.748325', 'city', '114.297309', '35.748325', 2, NULL, '0392', '458030', 'Hebi', 'H', NULL);
INSERT INTO `ez_area` VALUES (410602, '鹤山区', 410600, '114.163258,35.954611', 'district', '114.163258', '35.954611', 3, NULL, '0392', '458010', 'Heshan', 'H', NULL);
INSERT INTO `ez_area` VALUES (410603, '山城区', 410600, '114.184318,35.898033', 'district', '114.184318', '35.898033', 3, NULL, '0392', '458000', 'Shancheng', 'S', NULL);
INSERT INTO `ez_area` VALUES (410611, '淇滨区', 410600, '114.298789,35.741592', 'district', '114.298789', '35.741592', 3, NULL, '0392', '458000', 'Qibin', 'Q', NULL);
INSERT INTO `ez_area` VALUES (410621, '浚县', 410600, '114.55091,35.67636', 'district', '114.55091', '35.67636', 3, NULL, '0392', '456250', 'Xunxian', 'X', NULL);
INSERT INTO `ez_area` VALUES (410622, '淇县', 410600, '114.208828,35.622507', 'district', '114.208828', '35.622507', 3, NULL, '0392', '456750', 'Qixian', 'Q', NULL);
INSERT INTO `ez_area` VALUES (410700, '新乡市', 410000, '113.926763,35.303704', 'city', '113.926763', '35.303704', 2, NULL, '0373', '453000', 'Xinxiang', 'X', NULL);
INSERT INTO `ez_area` VALUES (410702, '红旗区', 410700, '113.875245,35.30385', 'district', '113.875245', '35.30385', 3, NULL, '0373', '453000', 'Hongqi', 'H', NULL);
INSERT INTO `ez_area` VALUES (410703, '卫滨区', 410700, '113.865663,35.301992', 'district', '113.865663', '35.301992', 3, NULL, '0373', '453000', 'Weibin', 'W', NULL);
INSERT INTO `ez_area` VALUES (410704, '凤泉区', 410700, '113.915184,35.383978', 'district', '113.915184', '35.383978', 3, NULL, '0373', '453011', 'Fengquan', 'F', NULL);
INSERT INTO `ez_area` VALUES (410711, '牧野区', 410700, '113.908772,35.315039', 'district', '113.908772', '35.315039', 3, NULL, '0373', '453002', 'Muye', 'M', NULL);
INSERT INTO `ez_area` VALUES (410721, '新乡县', 410700, '113.805205,35.190836', 'district', '113.805205', '35.190836', 3, NULL, '0373', '453700', 'Xinxiang', 'X', NULL);
INSERT INTO `ez_area` VALUES (410724, '获嘉县', 410700, '113.657433,35.259808', 'district', '113.657433', '35.259808', 3, NULL, '0373', '453800', 'Huojia', 'H', NULL);
INSERT INTO `ez_area` VALUES (410725, '原阳县', 410700, '113.940046,35.065587', 'district', '113.940046', '35.065587', 3, NULL, '0373', '453500', 'Yuanyang', 'Y', NULL);
INSERT INTO `ez_area` VALUES (410726, '延津县', 410700, '114.20509,35.141889', 'district', '114.20509', '35.141889', 3, NULL, '0373', '453200', 'Yanjin', 'Y', NULL);
INSERT INTO `ez_area` VALUES (410727, '封丘县', 410700, '114.418882,35.041198', 'district', '114.418882', '35.041198', 3, NULL, '0373', '453300', 'Fengqiu', 'F', NULL);
INSERT INTO `ez_area` VALUES (410728, '长垣县', 410700, '114.668936,35.201548', 'district', '114.668936', '35.201548', 3, NULL, '0373', '453400', 'Changyuan', 'C', NULL);
INSERT INTO `ez_area` VALUES (410781, '卫辉市', 410700, '114.064907,35.398494', 'district', '114.064907', '35.398494', 3, NULL, '0373', '453100', 'Weihui', 'W', NULL);
INSERT INTO `ez_area` VALUES (410782, '辉县市', 410700, '113.805468,35.462312', 'district', '113.805468', '35.462312', 3, NULL, '0373', '453600', 'Huixian', 'H', NULL);
INSERT INTO `ez_area` VALUES (410800, '焦作市', 410000, '113.241823,35.215893', 'city', '113.241823', '35.215893', 2, NULL, '0391', '454002', 'Jiaozuo', 'J', NULL);
INSERT INTO `ez_area` VALUES (410802, '解放区', 410800, '113.230816,35.240282', 'district', '113.230816', '35.240282', 3, NULL, '0391', '454000', 'Jiefang', 'J', NULL);
INSERT INTO `ez_area` VALUES (410803, '中站区', 410800, '113.182946,35.236819', 'district', '113.182946', '35.236819', 3, NULL, '0391', '454191', 'Zhongzhan', 'Z', NULL);
INSERT INTO `ez_area` VALUES (410804, '马村区', 410800, '113.322332,35.256108', 'district', '113.322332', '35.256108', 3, NULL, '0391', '454171', 'Macun', 'M', NULL);
INSERT INTO `ez_area` VALUES (410811, '山阳区', 410800, '113.254881,35.214507', 'district', '113.254881', '35.214507', 3, NULL, '0391', '454002', 'Shanyang', 'S', NULL);
INSERT INTO `ez_area` VALUES (410821, '修武县', 410800, '113.447755,35.223514', 'district', '113.447755', '35.223514', 3, NULL, '0391', '454350', 'Xiuwu', 'X', NULL);
INSERT INTO `ez_area` VALUES (410822, '博爱县', 410800, '113.064379,35.171045', 'district', '113.064379', '35.171045', 3, NULL, '0391', '454450', 'Boai', 'B', NULL);
INSERT INTO `ez_area` VALUES (410823, '武陟县', 410800, '113.401679,35.099378', 'district', '113.401679', '35.099378', 3, NULL, '0391', '454950', 'Wuzhi', 'W', NULL);
INSERT INTO `ez_area` VALUES (410825, '温县', 410800, '113.08053,34.940189', 'district', '113.08053', '34.940189', 3, NULL, '0391', '454850', 'Wenxian', 'W', NULL);
INSERT INTO `ez_area` VALUES (410882, '沁阳市', 410800, '112.950716,35.087539', 'district', '112.950716', '35.087539', 3, NULL, '0391', '454550', 'Qinyang', 'Q', NULL);
INSERT INTO `ez_area` VALUES (410883, '孟州市', 410800, '112.791401,34.907315', 'district', '112.791401', '34.907315', 3, NULL, '0391', '454750', 'Mengzhou', 'M', NULL);
INSERT INTO `ez_area` VALUES (410900, '濮阳市', 410000, '115.029216,35.761829', 'city', '115.029216', '35.761829', 2, NULL, '0393', '457000', 'Puyang', 'P', NULL);
INSERT INTO `ez_area` VALUES (410902, '华龙区', 410900, '115.074151,35.777346', 'district', '115.074151', '35.777346', 3, NULL, '0393', '457001', 'Hualong', 'H', NULL);
INSERT INTO `ez_area` VALUES (410922, '清丰县', 410900, '115.104389,35.88518', 'district', '115.104389', '35.88518', 3, NULL, '0393', '457300', 'Qingfeng', 'Q', NULL);
INSERT INTO `ez_area` VALUES (410923, '南乐县', 410900, '115.204675,36.069476', 'district', '115.204675', '36.069476', 3, NULL, '0393', '457400', 'Nanle', 'N', NULL);
INSERT INTO `ez_area` VALUES (410926, '范县', 410900, '115.504201,35.851906', 'district', '115.504201', '35.851906', 3, NULL, '0393', '457500', 'Fanxian', 'F', NULL);
INSERT INTO `ez_area` VALUES (410927, '台前县', 410900, '115.871906,35.96939', 'district', '115.871906', '35.96939', 3, NULL, '0393', '457600', 'Taiqian', 'T', NULL);
INSERT INTO `ez_area` VALUES (410928, '濮阳县', 410900, '115.029078,35.712193', 'district', '115.029078', '35.712193', 3, NULL, '0393', '457100', 'Puyang', 'P', NULL);
INSERT INTO `ez_area` VALUES (411000, '许昌市', 410000, '113.852454,34.035771', 'city', '113.852454', '34.035771', 2, NULL, '0374', '461000', 'Xuchang', 'X', NULL);
INSERT INTO `ez_area` VALUES (411002, '魏都区', 411000, '113.822647,34.025341', 'district', '113.822647', '34.025341', 3, NULL, '0374', '461000', 'Weidu', 'W', NULL);
INSERT INTO `ez_area` VALUES (411003, '建安区', 411000, '113.822983,34.12466', 'district', '113.822983', '34.12466', 3, NULL, '0374', '461100', 'Jian\'an', 'J', NULL);
INSERT INTO `ez_area` VALUES (411024, '鄢陵县', 411000, '114.177399,34.102332', 'district', '114.177399', '34.102332', 3, NULL, '0374', '461200', 'Yanling', 'Y', NULL);
INSERT INTO `ez_area` VALUES (411025, '襄城县', 411000, '113.505874,33.851459', 'district', '113.505874', '33.851459', 3, NULL, '0374', '461700', 'Xiangcheng', 'X', NULL);
INSERT INTO `ez_area` VALUES (411081, '禹州市', 411000, '113.488478,34.140701', 'district', '113.488478', '34.140701', 3, NULL, '0374', '461670', 'Yuzhou', 'Y', NULL);
INSERT INTO `ez_area` VALUES (411082, '长葛市', 411000, '113.813714,34.19592', 'district', '113.813714', '34.19592', 3, NULL, '0374', '461500', 'Changge', 'C', NULL);
INSERT INTO `ez_area` VALUES (411100, '漯河市', 410000, '114.016536,33.580873', 'city', '114.016536', '33.580873', 2, NULL, '0395', '462000', 'Luohe', 'L', NULL);
INSERT INTO `ez_area` VALUES (411102, '源汇区', 411100, '114.017948,33.565441', 'district', '114.017948', '33.565441', 3, NULL, '0395', '462000', 'Yuanhui', 'Y', NULL);
INSERT INTO `ez_area` VALUES (411103, '郾城区', 411100, '114.006943,33.587409', 'district', '114.006943', '33.587409', 3, NULL, '0395', '462300', 'Yancheng', 'Y', NULL);
INSERT INTO `ez_area` VALUES (411104, '召陵区', 411100, '114.093902,33.586565', 'district', '114.093902', '33.586565', 3, NULL, '0395', '462300', 'Zhaoling', 'Z', NULL);
INSERT INTO `ez_area` VALUES (411121, '舞阳县', 411100, '113.609286,33.437876', 'district', '113.609286', '33.437876', 3, NULL, '0395', '462400', 'Wuyang', 'W', NULL);
INSERT INTO `ez_area` VALUES (411122, '临颍县', 411100, '113.931261,33.828042', 'district', '113.931261', '33.828042', 3, NULL, '0395', '462600', 'Linying', 'L', NULL);
INSERT INTO `ez_area` VALUES (411200, '三门峡市', 410000, '111.200367,34.772792', 'city', '111.200367', '34.772792', 2, NULL, '0398', '472000', 'Sanmenxia', 'S', NULL);
INSERT INTO `ez_area` VALUES (411202, '湖滨区', 411200, '111.188397,34.770886', 'district', '111.188397', '34.770886', 3, NULL, '0398', '472000', 'Hubin', 'H', NULL);
INSERT INTO `ez_area` VALUES (411203, '陕州区', 411200, '111.103563,34.720547', 'district', '111.103563', '34.720547', 3, NULL, '0398', '472100', 'Shanzhou', 'S', NULL);
INSERT INTO `ez_area` VALUES (411221, '渑池县', 411200, '111.761797,34.767951', 'district', '111.761797', '34.767951', 3, NULL, '0398', '472400', 'Mianchi', 'M', NULL);
INSERT INTO `ez_area` VALUES (411224, '卢氏县', 411200, '111.047858,34.054324', 'district', '111.047858', '34.054324', 3, NULL, '0398', '472200', 'Lushi', 'L', NULL);
INSERT INTO `ez_area` VALUES (411281, '义马市', 411200, '111.87448,34.7474', 'district', '111.87448', '34.7474', 3, NULL, '0398', '472300', 'Yima', 'Y', NULL);
INSERT INTO `ez_area` VALUES (411282, '灵宝市', 411200, '110.89422,34.516828', 'district', '110.89422', '34.516828', 3, NULL, '0398', '472500', 'Lingbao', 'L', NULL);
INSERT INTO `ez_area` VALUES (411300, '南阳市', 410000, '112.528308,32.990664', 'city', '112.528308', '32.990664', 2, NULL, '0377', '473002', 'Nanyang', 'N', NULL);
INSERT INTO `ez_area` VALUES (411302, '宛城区', 411300, '112.539558,33.003784', 'district', '112.539558', '33.003784', 3, NULL, '0377', '473001', 'Wancheng', 'W', NULL);
INSERT INTO `ez_area` VALUES (411303, '卧龙区', 411300, '112.528789,32.989877', 'district', '112.528789', '32.989877', 3, NULL, '0377', '473003', 'Wolong', 'W', NULL);
INSERT INTO `ez_area` VALUES (411321, '南召县', 411300, '112.429133,33.489877', 'district', '112.429133', '33.489877', 3, NULL, '0377', '474650', 'Nanzhao', 'N', NULL);
INSERT INTO `ez_area` VALUES (411322, '方城县', 411300, '113.012494,33.254391', 'district', '113.012494', '33.254391', 3, NULL, '0377', '473200', 'Fangcheng', 'F', NULL);
INSERT INTO `ez_area` VALUES (411323, '西峡县', 411300, '111.47353,33.307294', 'district', '111.47353', '33.307294', 3, NULL, '0377', '474550', 'Xixia', 'X', NULL);
INSERT INTO `ez_area` VALUES (411324, '镇平县', 411300, '112.234697,33.03411', 'district', '112.234697', '33.03411', 3, NULL, '0377', '474250', 'Zhenping', 'Z', NULL);
INSERT INTO `ez_area` VALUES (411325, '内乡县', 411300, '111.849392,33.044864', 'district', '111.849392', '33.044864', 3, NULL, '0377', '474350', 'Neixiang', 'N', NULL);
INSERT INTO `ez_area` VALUES (411326, '淅川县', 411300, '111.490964,33.13782', 'district', '111.490964', '33.13782', 3, NULL, '0377', '474450', 'Xichuan', 'X', NULL);
INSERT INTO `ez_area` VALUES (411327, '社旗县', 411300, '112.948245,33.056109', 'district', '112.948245', '33.056109', 3, NULL, '0377', '473300', 'Sheqi', 'S', NULL);
INSERT INTO `ez_area` VALUES (411328, '唐河县', 411300, '112.807636,32.681335', 'district', '112.807636', '32.681335', 3, NULL, '0377', '473400', 'Tanghe', 'T', NULL);
INSERT INTO `ez_area` VALUES (411329, '新野县', 411300, '112.360026,32.520805', 'district', '112.360026', '32.520805', 3, NULL, '0377', '473500', 'Xinye', 'X', NULL);
INSERT INTO `ez_area` VALUES (411330, '桐柏县', 411300, '113.428287,32.380073', 'district', '113.428287', '32.380073', 3, NULL, '0377', '474750', 'Tongbai', 'T', NULL);
INSERT INTO `ez_area` VALUES (411381, '邓州市', 411300, '112.087493,32.68758', 'district', '112.087493', '32.68758', 3, NULL, '0377', '474150', 'Dengzhou', 'D', NULL);
INSERT INTO `ez_area` VALUES (411400, '商丘市', 410000, '115.656339,34.414961', 'city', '115.656339', '34.414961', 2, NULL, '0370', '476000', 'Shangqiu', 'S', NULL);
INSERT INTO `ez_area` VALUES (411402, '梁园区', 411400, '115.613965,34.443893', 'district', '115.613965', '34.443893', 3, NULL, '0370', '476000', 'Liangyuan', 'L', NULL);
INSERT INTO `ez_area` VALUES (411403, '睢阳区', 411400, '115.653301,34.388389', 'district', '115.653301', '34.388389', 3, NULL, '0370', '476100', 'Suiyang', 'S', NULL);
INSERT INTO `ez_area` VALUES (411421, '民权县', 411400, '115.173971,34.648191', 'district', '115.173971', '34.648191', 3, NULL, '0370', '476800', 'Minquan', 'M', NULL);
INSERT INTO `ez_area` VALUES (411422, '睢县', 411400, '115.071879,34.445655', 'district', '115.071879', '34.445655', 3, NULL, '0370', '476900', 'Suixian', 'S', NULL);
INSERT INTO `ez_area` VALUES (411423, '宁陵县', 411400, '115.313743,34.460399', 'district', '115.313743', '34.460399', 3, NULL, '0370', '476700', 'Ningling', 'N', NULL);
INSERT INTO `ez_area` VALUES (411424, '柘城县', 411400, '115.305708,34.091082', 'district', '115.305708', '34.091082', 3, NULL, '0370', '476200', 'Zhecheng', 'Z', NULL);
INSERT INTO `ez_area` VALUES (411425, '虞城县', 411400, '115.828319,34.400835', 'district', '115.828319', '34.400835', 3, NULL, '0370', '476300', 'Yucheng', 'Y', NULL);
INSERT INTO `ez_area` VALUES (411426, '夏邑县', 411400, '116.131447,34.237553', 'district', '116.131447', '34.237553', 3, NULL, '0370', '476400', 'Xiayi', 'X', NULL);
INSERT INTO `ez_area` VALUES (411481, '永城市', 411400, '116.4495,33.929291', 'district', '116.4495', '33.929291', 3, NULL, '0370', '476600', 'Yongcheng', 'Y', NULL);
INSERT INTO `ez_area` VALUES (411500, '信阳市', 410000, '114.091193,32.147679', 'city', '114.091193', '32.147679', 2, NULL, '0376', '464000', 'Xinyang', 'X', NULL);
INSERT INTO `ez_area` VALUES (411502, '浉河区', 411500, '114.058713,32.116803', 'district', '114.058713', '32.116803', 3, NULL, '0376', '464000', 'Shihe', 'S', NULL);
INSERT INTO `ez_area` VALUES (411503, '平桥区', 411500, '114.125656,32.101031', 'district', '114.125656', '32.101031', 3, NULL, '0376', '464100', 'Pingqiao', 'P', NULL);
INSERT INTO `ez_area` VALUES (411521, '罗山县', 411500, '114.512872,32.203883', 'district', '114.512872', '32.203883', 3, NULL, '0376', '464200', 'Luoshan', 'L', NULL);
INSERT INTO `ez_area` VALUES (411522, '光山县', 411500, '114.919152,32.010002', 'district', '114.919152', '32.010002', 3, NULL, '0376', '465450', 'Guangshan', 'G', NULL);
INSERT INTO `ez_area` VALUES (411523, '新县', 411500, '114.879239,31.643918', 'district', '114.879239', '31.643918', 3, NULL, '0376', '465550', 'Xinxian', 'X', NULL);
INSERT INTO `ez_area` VALUES (411524, '商城县', 411500, '115.406862,31.798377', 'district', '115.406862', '31.798377', 3, NULL, '0376', '465350', 'Shangcheng', 'S', NULL);
INSERT INTO `ez_area` VALUES (411525, '固始县', 411500, '115.654481,32.168137', 'district', '115.654481', '32.168137', 3, NULL, '0376', '465250', 'Gushi', 'G', NULL);
INSERT INTO `ez_area` VALUES (411526, '潢川县', 411500, '115.051908,32.131522', 'district', '115.051908', '32.131522', 3, NULL, '0376', '465150', 'Huangchuan', 'H', NULL);
INSERT INTO `ez_area` VALUES (411527, '淮滨县', 411500, '115.419537,32.473258', 'district', '115.419537', '32.473258', 3, NULL, '0376', '464400', 'Huaibin', 'H', NULL);
INSERT INTO `ez_area` VALUES (411528, '息县', 411500, '114.740456,32.342792', 'district', '114.740456', '32.342792', 3, NULL, '0376', '464300', 'Xixian', 'X', NULL);
INSERT INTO `ez_area` VALUES (411600, '周口市', 410000, '114.69695,33.626149', 'city', '114.69695', '33.626149', 2, NULL, '0394', '466000', 'Zhoukou', 'Z', NULL);
INSERT INTO `ez_area` VALUES (411602, '川汇区', 411600, '114.650628,33.647598', 'district', '114.650628', '33.647598', 3, NULL, '0394', '466000', 'Chuanhui', 'C', NULL);
INSERT INTO `ez_area` VALUES (411621, '扶沟县', 411600, '114.394821,34.059968', 'district', '114.394821', '34.059968', 3, NULL, '0394', '461300', 'Fugou', 'F', NULL);
INSERT INTO `ez_area` VALUES (411622, '西华县', 411600, '114.529756,33.767407', 'district', '114.529756', '33.767407', 3, NULL, '0394', '466600', 'Xihua', 'X', NULL);
INSERT INTO `ez_area` VALUES (411623, '商水县', 411600, '114.611651,33.542138', 'district', '114.611651', '33.542138', 3, NULL, '0394', '466100', 'Shangshui', 'S', NULL);
INSERT INTO `ez_area` VALUES (411624, '沈丘县', 411600, '115.098583,33.409369', 'district', '115.098583', '33.409369', 3, NULL, '0394', '466300', 'Shenqiu', 'S', NULL);
INSERT INTO `ez_area` VALUES (411625, '郸城县', 411600, '115.177188,33.644743', 'district', '115.177188', '33.644743', 3, NULL, '0394', '477150', 'Dancheng', 'D', NULL);
INSERT INTO `ez_area` VALUES (411626, '淮阳县', 411600, '114.886153,33.731561', 'district', '114.886153', '33.731561', 3, NULL, '0394', '466700', 'Huaiyang', 'H', NULL);
INSERT INTO `ez_area` VALUES (411627, '太康县', 411600, '114.837888,34.064463', 'district', '114.837888', '34.064463', 3, NULL, '0394', '461400', 'Taikang', 'T', NULL);
INSERT INTO `ez_area` VALUES (411628, '鹿邑县', 411600, '115.484454,33.86', 'district', '115.484454', '33.86', 3, NULL, '0394', '477200', 'Luyi', 'L', NULL);
INSERT INTO `ez_area` VALUES (411681, '项城市', 411600, '114.875333,33.465838', 'district', '114.875333', '33.465838', 3, NULL, '0394', '466200', 'Xiangcheng', 'X', NULL);
INSERT INTO `ez_area` VALUES (411700, '驻马店市', 410000, '114.022247,33.012885', 'city', '114.022247', '33.012885', 2, NULL, '0396', '463000', 'Zhumadian', 'Z', NULL);
INSERT INTO `ez_area` VALUES (411702, '驿城区', 411700, '113.993914,32.973054', 'district', '113.993914', '32.973054', 3, NULL, '0396', '463000', 'Yicheng', 'Y', NULL);
INSERT INTO `ez_area` VALUES (411721, '西平县', 411700, '114.021538,33.387684', 'district', '114.021538', '33.387684', 3, NULL, '0396', '463900', 'Xiping', 'X', NULL);
INSERT INTO `ez_area` VALUES (411722, '上蔡县', 411700, '114.264381,33.262439', 'district', '114.264381', '33.262439', 3, NULL, '0396', '463800', 'Shangcai', 'S', NULL);
INSERT INTO `ez_area` VALUES (411723, '平舆县', 411700, '114.619159,32.96271', 'district', '114.619159', '32.96271', 3, NULL, '0396', '463400', 'Pingyu', 'P', NULL);
INSERT INTO `ez_area` VALUES (411724, '正阳县', 411700, '114.392773,32.605697', 'district', '114.392773', '32.605697', 3, NULL, '0396', '463600', 'Zhengyang', 'Z', NULL);
INSERT INTO `ez_area` VALUES (411725, '确山县', 411700, '114.026429,32.802064', 'district', '114.026429', '32.802064', 3, NULL, '0396', '463200', 'Queshan', 'Q', NULL);
INSERT INTO `ez_area` VALUES (411726, '泌阳县', 411700, '113.327144,32.723975', 'district', '113.327144', '32.723975', 3, NULL, '0396', '463700', 'Biyang', 'B', NULL);
INSERT INTO `ez_area` VALUES (411727, '汝南县', 411700, '114.362379,33.006729', 'district', '114.362379', '33.006729', 3, NULL, '0396', '463300', 'Runan', 'R', NULL);
INSERT INTO `ez_area` VALUES (411728, '遂平县', 411700, '114.013182,33.145649', 'district', '114.013182', '33.145649', 3, NULL, '0396', '463100', 'Suiping', 'S', NULL);
INSERT INTO `ez_area` VALUES (411729, '新蔡县', 411700, '114.96547,32.744896', 'district', '114.96547', '32.744896', 3, NULL, '0396', '463500', 'Xincai', 'X', NULL);
INSERT INTO `ez_area` VALUES (419001, '济源市', 410000, '112.602256,35.067199', 'city', '112.602256', '35.067199', 2, NULL, '0391', '454650', 'Jiyuan', 'J', NULL);
INSERT INTO `ez_area` VALUES (420000, '湖北省', 0, '114.341745,30.546557', 'province', '114.341745', '30.546557', 1, NULL, NULL, NULL, 'Hubei', 'H', NULL);
INSERT INTO `ez_area` VALUES (420100, '武汉市', 420000, '114.305469,30.593175', 'city', '114.305469', '30.593175', 2, NULL, '027', '430014', 'Wuhan', 'W', NULL);
INSERT INTO `ez_area` VALUES (420102, '江岸区', 420100, '114.30911,30.600052', 'district', '114.30911', '30.600052', 3, NULL, '027', '430014', 'Jiang\'an', 'J', NULL);
INSERT INTO `ez_area` VALUES (420103, '江汉区', 420100, '114.270867,30.601475', 'district', '114.270867', '30.601475', 3, NULL, '027', '430021', 'Jianghan', 'J', NULL);
INSERT INTO `ez_area` VALUES (420104, '硚口区', 420100, '114.21492,30.582202', 'district', '114.21492', '30.582202', 3, NULL, '027', '430033', 'Qiaokou', 'Q', NULL);
INSERT INTO `ez_area` VALUES (420105, '汉阳区', 420100, '114.21861,30.553983', 'district', '114.21861', '30.553983', 3, NULL, '027', '430050', 'Hanyang', 'H', NULL);
INSERT INTO `ez_area` VALUES (420106, '武昌区', 420100, '114.31665,30.554408', 'district', '114.31665', '30.554408', 3, NULL, '027', '430061', 'Wuchang', 'W', NULL);
INSERT INTO `ez_area` VALUES (420107, '青山区', 420100, '114.384968,30.640191', 'district', '114.384968', '30.640191', 3, NULL, '027', '430080', 'Qingshan', 'Q', NULL);
INSERT INTO `ez_area` VALUES (420111, '洪山区', 420100, '114.343796,30.500247', 'district', '114.343796', '30.500247', 3, NULL, '027', '430070', 'Hongshan', 'H', NULL);
INSERT INTO `ez_area` VALUES (420112, '东西湖区', 420100, '114.137116,30.619917', 'district', '114.137116', '30.619917', 3, NULL, '027', '430040', 'Dongxihu', 'D', NULL);
INSERT INTO `ez_area` VALUES (420113, '汉南区', 420100, '114.084597,30.308829', 'district', '114.084597', '30.308829', 3, NULL, '027', '430090', 'Hannan', 'H', NULL);
INSERT INTO `ez_area` VALUES (420114, '蔡甸区', 420100, '114.087285,30.536454', 'district', '114.087285', '30.536454', 3, NULL, '027', '430100', 'Caidian', 'C', NULL);
INSERT INTO `ez_area` VALUES (420115, '江夏区', 420100, '114.319097,30.376308', 'district', '114.319097', '30.376308', 3, NULL, '027', '430200', 'Jiangxia', 'J', NULL);
INSERT INTO `ez_area` VALUES (420116, '黄陂区', 420100, '114.375725,30.882174', 'district', '114.375725', '30.882174', 3, NULL, '027', '432200', 'Huangpi', 'H', NULL);
INSERT INTO `ez_area` VALUES (420117, '新洲区', 420100, '114.801096,30.841425', 'district', '114.801096', '30.841425', 3, NULL, '027', '431400', 'Xinzhou', 'X', NULL);
INSERT INTO `ez_area` VALUES (420200, '黄石市', 420000, '115.038962,30.201038', 'city', '115.038962', '30.201038', 2, NULL, '0714', '435003', 'Huangshi', 'H', NULL);
INSERT INTO `ez_area` VALUES (420202, '黄石港区', 420200, '115.065849,30.222938', 'district', '115.065849', '30.222938', 3, NULL, '0714', '435000', 'Huangshigang', 'H', NULL);
INSERT INTO `ez_area` VALUES (420203, '西塞山区', 420200, '115.109955,30.204924', 'district', '115.109955', '30.204924', 3, NULL, '0714', '435001', 'Xisaishan', 'X', NULL);
INSERT INTO `ez_area` VALUES (420204, '下陆区', 420200, '114.961327,30.173912', 'district', '114.961327', '30.173912', 3, NULL, '0714', '435005', 'Xialu', 'X', NULL);
INSERT INTO `ez_area` VALUES (420205, '铁山区', 420200, '114.891605,30.203118', 'district', '114.891605', '30.203118', 3, NULL, '0714', '435006', 'Tieshan', 'T', NULL);
INSERT INTO `ez_area` VALUES (420222, '阳新县', 420200, '115.215227,29.830257', 'district', '115.215227', '29.830257', 3, NULL, '0714', '435200', 'Yangxin', 'Y', NULL);
INSERT INTO `ez_area` VALUES (420281, '大冶市', 420200, '114.980424,30.096147', 'district', '114.980424', '30.096147', 3, NULL, '0714', '435100', 'Daye', 'D', NULL);
INSERT INTO `ez_area` VALUES (420300, '十堰市', 420000, '110.799291,32.629462', 'city', '110.799291', '32.629462', 2, NULL, '0719', '442000', 'Shiyan', 'S', NULL);
INSERT INTO `ez_area` VALUES (420302, '茅箭区', 420300, '110.813719,32.591904', 'district', '110.813719', '32.591904', 3, NULL, '0719', '442012', 'Maojian', 'M', NULL);
INSERT INTO `ez_area` VALUES (420303, '张湾区', 420300, '110.769132,32.652297', 'district', '110.769132', '32.652297', 3, NULL, '0719', '442001', 'Zhangwan', 'Z', NULL);
INSERT INTO `ez_area` VALUES (420304, '郧阳区', 420300, '110.81205,32.834775', 'district', '110.81205', '32.834775', 3, NULL, '0719', '442500', 'Yunyang', 'Y', NULL);
INSERT INTO `ez_area` VALUES (420322, '郧西县', 420300, '110.425983,32.993182', 'district', '110.425983', '32.993182', 3, NULL, '0719', '442600', 'Yunxi', 'Y', NULL);
INSERT INTO `ez_area` VALUES (420323, '竹山县', 420300, '110.228747,32.224808', 'district', '110.228747', '32.224808', 3, NULL, '0719', '442200', 'Zhushan', 'Z', NULL);
INSERT INTO `ez_area` VALUES (420324, '竹溪县', 420300, '109.715304,32.318255', 'district', '109.715304', '32.318255', 3, NULL, '0719', '442300', 'Zhuxi', 'Z', NULL);
INSERT INTO `ez_area` VALUES (420325, '房县', 420300, '110.733181,32.050378', 'district', '110.733181', '32.050378', 3, NULL, '0719', '442100', 'Fangxian', 'F', NULL);
INSERT INTO `ez_area` VALUES (420381, '丹江口市', 420300, '111.513127,32.540157', 'district', '111.513127', '32.540157', 3, NULL, '0719', '442700', 'Danjiangkou', 'D', NULL);
INSERT INTO `ez_area` VALUES (420500, '宜昌市', 420000, '111.286445,30.691865', 'city', '111.286445', '30.691865', 2, NULL, '0717', '443000', 'Yichang', 'Y', NULL);
INSERT INTO `ez_area` VALUES (420502, '西陵区', 420500, '111.285646,30.710781', 'district', '111.285646', '30.710781', 3, NULL, '0717', '443000', 'Xiling', 'X', NULL);
INSERT INTO `ez_area` VALUES (420503, '伍家岗区', 420500, '111.361037,30.644334', 'district', '111.361037', '30.644334', 3, NULL, '0717', '443001', 'Wujiagang', 'W', NULL);
INSERT INTO `ez_area` VALUES (420504, '点军区', 420500, '111.268119,30.693247', 'district', '111.268119', '30.693247', 3, NULL, '0717', '443006', 'Dianjun', 'D', NULL);
INSERT INTO `ez_area` VALUES (420505, '猇亭区', 420500, '111.43462,30.530903', 'district', '111.43462', '30.530903', 3, NULL, '0717', '443007', 'Xiaoting', 'X', NULL);
INSERT INTO `ez_area` VALUES (420506, '夷陵区', 420500, '111.32638,30.770006', 'district', '111.32638', '30.770006', 3, NULL, '0717', '443100', 'Yiling', 'Y', NULL);
INSERT INTO `ez_area` VALUES (420525, '远安县', 420500, '111.640508,31.060869', 'district', '111.640508', '31.060869', 3, NULL, '0717', '444200', 'Yuan\'an', 'Y', NULL);
INSERT INTO `ez_area` VALUES (420526, '兴山县', 420500, '110.746804,31.348196', 'district', '110.746804', '31.348196', 3, NULL, '0717', '443711', 'Xingshan', 'X', NULL);
INSERT INTO `ez_area` VALUES (420527, '秭归县', 420500, '110.977711,30.825897', 'district', '110.977711', '30.825897', 3, NULL, '0717', '443600', 'Zigui', 'Z', NULL);
INSERT INTO `ez_area` VALUES (420528, '长阳土家族自治县', 420500, '111.207242,30.472763', 'district', '111.207242', '30.472763', 3, NULL, '0717', '443500', 'Changyang', 'C', NULL);
INSERT INTO `ez_area` VALUES (420529, '五峰土家族自治县', 420500, '111.07374,30.156741', 'district', '111.07374', '30.156741', 3, NULL, '0717', '443413', 'Wufeng', 'W', NULL);
INSERT INTO `ez_area` VALUES (420581, '宜都市', 420500, '111.450096,30.378299', 'district', '111.450096', '30.378299', 3, NULL, '0717', '443300', 'Yidu', 'Y', NULL);
INSERT INTO `ez_area` VALUES (420582, '当阳市', 420500, '111.788312,30.821266', 'district', '111.788312', '30.821266', 3, NULL, '0717', '444100', 'Dangyang', 'D', NULL);
INSERT INTO `ez_area` VALUES (420583, '枝江市', 420500, '111.76053,30.42594', 'district', '111.76053', '30.42594', 3, NULL, '0717', '443200', 'Zhijiang', 'Z', NULL);
INSERT INTO `ez_area` VALUES (420600, '襄阳市', 420000, '112.122426,32.009016', 'city', '112.122426', '32.009016', 2, NULL, '0710', '441021', 'Xiangyang', 'X', NULL);
INSERT INTO `ez_area` VALUES (420602, '襄城区', 420600, '112.134052,32.010366', 'district', '112.134052', '32.010366', 3, NULL, '0710', '441021', 'Xiangcheng', 'X', NULL);
INSERT INTO `ez_area` VALUES (420606, '樊城区', 420600, '112.135684,32.044832', 'district', '112.135684', '32.044832', 3, NULL, '0710', '441001', 'Fancheng', 'F', NULL);
INSERT INTO `ez_area` VALUES (420607, '襄州区', 420600, '112.211982,32.087127', 'district', '112.211982', '32.087127', 3, NULL, '0710', '441100', 'Xiangzhou', 'X', NULL);
INSERT INTO `ez_area` VALUES (420624, '南漳县', 420600, '111.838905,31.774636', 'district', '111.838905', '31.774636', 3, NULL, '0710', '441500', 'Nanzhang', 'N', NULL);
INSERT INTO `ez_area` VALUES (420625, '谷城县', 420600, '111.652982,32.263849', 'district', '111.652982', '32.263849', 3, NULL, '0710', '441700', 'Gucheng', 'G', NULL);
INSERT INTO `ez_area` VALUES (420626, '保康县', 420600, '111.261308,31.87831', 'district', '111.261308', '31.87831', 3, NULL, '0710', '441600', 'Baokang', 'B', NULL);
INSERT INTO `ez_area` VALUES (420682, '老河口市', 420600, '111.683861,32.359068', 'district', '111.683861', '32.359068', 3, NULL, '0710', '441800', 'Laohekou', 'L', NULL);
INSERT INTO `ez_area` VALUES (420683, '枣阳市', 420600, '112.771959,32.128818', 'district', '112.771959', '32.128818', 3, NULL, '0710', '441200', 'Zaoyang', 'Z', NULL);
INSERT INTO `ez_area` VALUES (420684, '宜城市', 420600, '112.257788,31.719806', 'district', '112.257788', '31.719806', 3, NULL, '0710', '441400', 'Yicheng', 'Y', NULL);
INSERT INTO `ez_area` VALUES (420700, '鄂州市', 420000, '114.894935,30.391141', 'city', '114.894935', '30.391141', 2, NULL, '0711', '436000', 'Ezhou', 'E', NULL);
INSERT INTO `ez_area` VALUES (420702, '梁子湖区', 420700, '114.684731,30.100141', 'district', '114.684731', '30.100141', 3, NULL, '0711', '436064', 'Liangzihu', 'L', NULL);
INSERT INTO `ez_area` VALUES (420703, '华容区', 420700, '114.729878,30.534309', 'district', '114.729878', '30.534309', 3, NULL, '0711', '436030', 'Huarong', 'H', NULL);
INSERT INTO `ez_area` VALUES (420704, '鄂城区', 420700, '114.891586,30.400651', 'district', '114.891586', '30.400651', 3, NULL, '0711', '436000', 'Echeng', 'E', NULL);
INSERT INTO `ez_area` VALUES (420800, '荆门市', 420000, '112.199427,31.035395', 'city', '112.199427', '31.035395', 2, NULL, '0724', '448000', 'Jingmen', 'J', NULL);
INSERT INTO `ez_area` VALUES (420802, '东宝区', 420800, '112.201493,31.051852', 'district', '112.201493', '31.051852', 3, NULL, '0724', '448004', 'Dongbao', 'D', NULL);
INSERT INTO `ez_area` VALUES (420804, '掇刀区', 420800, '112.207962,30.973451', 'district', '112.207962', '30.973451', 3, NULL, '0724', '448124', 'Duodao', 'D', NULL);
INSERT INTO `ez_area` VALUES (420821, '京山县', 420800, '113.119566,31.018457', 'district', '113.119566', '31.018457', 3, NULL, '0724', '431800', 'Jingshan', 'J', NULL);
INSERT INTO `ez_area` VALUES (420822, '沙洋县', 420800, '112.588581,30.709221', 'district', '112.588581', '30.709221', 3, NULL, '0724', '448200', 'Shayang', 'S', NULL);
INSERT INTO `ez_area` VALUES (420881, '钟祥市', 420800, '112.58812,31.167819', 'district', '112.58812', '31.167819', 3, NULL, '0724', '431900', 'Zhongxiang', 'Z', NULL);
INSERT INTO `ez_area` VALUES (420900, '孝感市', 420000, '113.957037,30.917766', 'city', '113.957037', '30.917766', 2, NULL, '0712', '432100', 'Xiaogan', 'X', NULL);
INSERT INTO `ez_area` VALUES (420902, '孝南区', 420900, '113.910705,30.916812', 'district', '113.910705', '30.916812', 3, NULL, '0712', '432100', 'Xiaonan', 'X', NULL);
INSERT INTO `ez_area` VALUES (420921, '孝昌县', 420900, '113.998009,31.258159', 'district', '113.998009', '31.258159', 3, NULL, '0712', '432900', 'Xiaochang', 'X', NULL);
INSERT INTO `ez_area` VALUES (420922, '大悟县', 420900, '114.127022,31.561164', 'district', '114.127022', '31.561164', 3, NULL, '0712', '432800', 'Dawu', 'D', NULL);
INSERT INTO `ez_area` VALUES (420923, '云梦县', 420900, '113.753554,31.020983', 'district', '113.753554', '31.020983', 3, NULL, '0712', '432500', 'Yunmeng', 'Y', NULL);
INSERT INTO `ez_area` VALUES (420981, '应城市', 420900, '113.572707,30.92837', 'district', '113.572707', '30.92837', 3, NULL, '0712', '432400', 'Yingcheng', 'Y', NULL);
INSERT INTO `ez_area` VALUES (420982, '安陆市', 420900, '113.688941,31.25561', 'district', '113.688941', '31.25561', 3, NULL, '0712', '432600', 'Anlu', 'A', NULL);
INSERT INTO `ez_area` VALUES (420984, '汉川市', 420900, '113.839149,30.661243', 'district', '113.839149', '30.661243', 3, NULL, '0712', '432300', 'Hanchuan', 'H', NULL);
INSERT INTO `ez_area` VALUES (421000, '荆州市', 420000, '112.239746,30.335184', 'city', '112.239746', '30.335184', 2, NULL, '0716', '434000', 'Jingzhou', 'J', NULL);
INSERT INTO `ez_area` VALUES (421002, '沙市区', 421000, '112.25193,30.326009', 'district', '112.25193', '30.326009', 3, NULL, '0716', '434000', 'Shashi', 'S', NULL);
INSERT INTO `ez_area` VALUES (421003, '荆州区', 421000, '112.190185,30.352853', 'district', '112.190185', '30.352853', 3, NULL, '0716', '434020', 'Jingzhou', 'J', NULL);
INSERT INTO `ez_area` VALUES (421022, '公安县', 421000, '112.229648,30.058336', 'district', '112.229648', '30.058336', 3, NULL, '0716', '434300', 'Gong\'an', 'G', NULL);
INSERT INTO `ez_area` VALUES (421023, '监利县', 421000, '112.904788,29.840179', 'district', '112.904788', '29.840179', 3, NULL, '0716', '433300', 'Jianli', 'J', NULL);
INSERT INTO `ez_area` VALUES (421024, '江陵县', 421000, '112.424664,30.041822', 'district', '112.424664', '30.041822', 3, NULL, '0716', '434101', 'Jiangling', 'J', NULL);
INSERT INTO `ez_area` VALUES (421081, '石首市', 421000, '112.425454,29.720938', 'district', '112.425454', '29.720938', 3, NULL, '0716', '434400', 'Shishou', 'S', NULL);
INSERT INTO `ez_area` VALUES (421083, '洪湖市', 421000, '113.475801,29.826916', 'district', '113.475801', '29.826916', 3, NULL, '0716', '433200', 'Honghu', 'H', NULL);
INSERT INTO `ez_area` VALUES (421087, '松滋市', 421000, '111.756781,30.174529', 'district', '111.756781', '30.174529', 3, NULL, '0716', '434200', 'Songzi', 'S', NULL);
INSERT INTO `ez_area` VALUES (421100, '黄冈市', 420000, '114.872199,30.453667', 'city', '114.872199', '30.453667', 2, NULL, '0713', '438000', 'Huanggang', 'H', NULL);
INSERT INTO `ez_area` VALUES (421102, '黄州区', 421100, '114.880104,30.434354', 'district', '114.880104', '30.434354', 3, NULL, '0713', '438000', 'Huangzhou', 'H', NULL);
INSERT INTO `ez_area` VALUES (421121, '团风县', 421100, '114.872191,30.643569', 'district', '114.872191', '30.643569', 3, NULL, '0713', '438800', 'Tuanfeng', 'T', NULL);
INSERT INTO `ez_area` VALUES (421122, '红安县', 421100, '114.618236,31.288153', 'district', '114.618236', '31.288153', 3, NULL, '0713', '438401', 'Hong\'an', 'H', NULL);
INSERT INTO `ez_area` VALUES (421123, '罗田县', 421100, '115.399222,30.78429', 'district', '115.399222', '30.78429', 3, NULL, '0713', '438600', 'Luotian', 'L', NULL);
INSERT INTO `ez_area` VALUES (421124, '英山县', 421100, '115.681359,30.735157', 'district', '115.681359', '30.735157', 3, NULL, '0713', '438700', 'Yingshan', 'Y', NULL);
INSERT INTO `ez_area` VALUES (421125, '浠水县', 421100, '115.265355,30.452115', 'district', '115.265355', '30.452115', 3, NULL, '0713', '438200', 'Xishui', 'X', NULL);
INSERT INTO `ez_area` VALUES (421126, '蕲春县', 421100, '115.437007,30.225964', 'district', '115.437007', '30.225964', 3, NULL, '0713', '435300', 'Qichun', 'Q', NULL);
INSERT INTO `ez_area` VALUES (421127, '黄梅县', 421100, '115.944219,30.070453', 'district', '115.944219', '30.070453', 3, NULL, '0713', '435500', 'Huangmei', 'H', NULL);
INSERT INTO `ez_area` VALUES (421181, '麻城市', 421100, '115.008163,31.172739', 'district', '115.008163', '31.172739', 3, NULL, '0713', '438300', 'Macheng', 'M', NULL);
INSERT INTO `ez_area` VALUES (421182, '武穴市', 421100, '115.561217,29.844107', 'district', '115.561217', '29.844107', 3, NULL, '0713', '435400', 'Wuxue', 'W', NULL);
INSERT INTO `ez_area` VALUES (421200, '咸宁市', 420000, '114.322616,29.841362', 'city', '114.322616', '29.841362', 2, NULL, '0715', '437000', 'Xianning', 'X', NULL);
INSERT INTO `ez_area` VALUES (421202, '咸安区', 421200, '114.298711,29.852891', 'district', '114.298711', '29.852891', 3, NULL, '0715', '437000', 'Xian\'an', 'X', NULL);
INSERT INTO `ez_area` VALUES (421221, '嘉鱼县', 421200, '113.939271,29.970676', 'district', '113.939271', '29.970676', 3, NULL, '0715', '437200', 'Jiayu', 'J', NULL);
INSERT INTO `ez_area` VALUES (421222, '通城县', 421200, '113.816966,29.245269', 'district', '113.816966', '29.245269', 3, NULL, '0715', '437400', 'Tongcheng', 'T', NULL);
INSERT INTO `ez_area` VALUES (421223, '崇阳县', 421200, '114.039523,29.556688', 'district', '114.039523', '29.556688', 3, NULL, '0715', '437500', 'Chongyang', 'C', NULL);
INSERT INTO `ez_area` VALUES (421224, '通山县', 421200, '114.482622,29.606372', 'district', '114.482622', '29.606372', 3, NULL, '0715', '437600', 'Tongshan', 'T', NULL);
INSERT INTO `ez_area` VALUES (421281, '赤壁市', 421200, '113.90038,29.725184', 'district', '113.90038', '29.725184', 3, NULL, '0715', '437300', 'Chibi', 'C', NULL);
INSERT INTO `ez_area` VALUES (421300, '随州市', 420000, '113.382515,31.690191', 'city', '113.382515', '31.690191', 2, NULL, '0722', '441300', 'Suizhou', 'S', NULL);
INSERT INTO `ez_area` VALUES (421303, '曾都区', 421300, '113.37112,31.71628', 'district', '113.37112', '31.71628', 3, NULL, '0722', '441300', 'Zengdu', 'Z', NULL);
INSERT INTO `ez_area` VALUES (421321, '随县', 421300, '113.290634,31.883739', 'district', '113.290634', '31.883739', 3, NULL, '0722', '441309', 'Suixian', 'S', NULL);
INSERT INTO `ez_area` VALUES (421381, '广水市', 421300, '113.825889,31.616853', 'district', '113.825889', '31.616853', 3, NULL, '0722', '432700', 'Guangshui', 'G', NULL);
INSERT INTO `ez_area` VALUES (422800, '恩施土家族苗族自治州', 420000, '109.488172,30.272156', 'city', '109.488172', '30.272156', 2, NULL, '0718', '445000', 'Enshi', 'E', NULL);
INSERT INTO `ez_area` VALUES (422801, '恩施市', 422800, '109.479664,30.29468', 'district', '109.479664', '30.29468', 3, NULL, '0718', '445000', 'Enshi', 'E', NULL);
INSERT INTO `ez_area` VALUES (422802, '利川市', 422800, '108.936452,30.29098', 'district', '108.936452', '30.29098', 3, NULL, '0718', '445400', 'Lichuan', 'L', NULL);
INSERT INTO `ez_area` VALUES (422822, '建始县', 422800, '109.722109,30.602129', 'district', '109.722109', '30.602129', 3, NULL, '0718', '445300', 'Jianshi', 'J', NULL);
INSERT INTO `ez_area` VALUES (422823, '巴东县', 422800, '110.340756,31.042324', 'district', '110.340756', '31.042324', 3, NULL, '0718', '444300', 'Badong', 'B', NULL);
INSERT INTO `ez_area` VALUES (422825, '宣恩县', 422800, '109.489926,29.98692', 'district', '109.489926', '29.98692', 3, NULL, '0718', '445500', 'Xuanen', 'X', NULL);
INSERT INTO `ez_area` VALUES (422826, '咸丰县', 422800, '109.139726,29.665202', 'district', '109.139726', '29.665202', 3, NULL, '0718', '445600', 'Xianfeng', 'X', NULL);
INSERT INTO `ez_area` VALUES (422827, '来凤县', 422800, '109.407828,29.493484', 'district', '109.407828', '29.493484', 3, NULL, '0718', '445700', 'Laifeng', 'L', NULL);
INSERT INTO `ez_area` VALUES (422828, '鹤峰县', 422800, '110.033662,29.890171', 'district', '110.033662', '29.890171', 3, NULL, '0718', '445800', 'Hefeng', 'H', NULL);
INSERT INTO `ez_area` VALUES (429004, '仙桃市', 420000, '113.423583,30.361438', 'city', '113.423583', '30.361438', 2, NULL, '0728', '433000', 'Xiantao', 'X', NULL);
INSERT INTO `ez_area` VALUES (429005, '潜江市', 420000, '112.899762,30.402167', 'city', '112.899762', '30.402167', 2, NULL, '0728', '433100', 'Qianjiang', 'Q', NULL);
INSERT INTO `ez_area` VALUES (429006, '天门市', 420000, '113.166078,30.663337', 'city', '113.166078', '30.663337', 2, NULL, '0728', '431700', 'Tianmen', 'T', NULL);
INSERT INTO `ez_area` VALUES (429021, '神农架林区', 420000, '110.675743,31.744915', 'city', '110.675743', '31.744915', 2, NULL, '0719', '442400', 'Shennongjia', 'S', NULL);
INSERT INTO `ez_area` VALUES (430000, '湖南省', 0, '112.9836,28.112743', 'province', '112.9836', '28.112743', 1, NULL, NULL, NULL, 'Hunan', 'H', NULL);
INSERT INTO `ez_area` VALUES (430100, '长沙市', 430000, '112.938884,28.22808', 'city', '112.938884', '28.22808', 2, NULL, '0731', '410005', 'Changsha', 'C', NULL);
INSERT INTO `ez_area` VALUES (430102, '芙蓉区', 430100, '113.032539,28.185389', 'district', '113.032539', '28.185389', 3, NULL, '0731', '410011', 'Furong', 'F', NULL);
INSERT INTO `ez_area` VALUES (430103, '天心区', 430100, '112.989897,28.114526', 'district', '112.989897', '28.114526', 3, NULL, '0731', '410004', 'Tianxin', 'T', NULL);
INSERT INTO `ez_area` VALUES (430104, '岳麓区', 430100, '112.93132,28.234538', 'district', '112.93132', '28.234538', 3, NULL, '0731', '410013', 'Yuelu', 'Y', NULL);
INSERT INTO `ez_area` VALUES (430105, '开福区', 430100, '112.985884,28.256298', 'district', '112.985884', '28.256298', 3, NULL, '0731', '410008', 'Kaifu', 'K', NULL);
INSERT INTO `ez_area` VALUES (430111, '雨花区', 430100, '113.03826,28.135722', 'district', '113.03826', '28.135722', 3, NULL, '0731', '410011', 'Yuhua', 'Y', NULL);
INSERT INTO `ez_area` VALUES (430112, '望城区', 430100, '112.831176,28.353434', 'district', '112.831176', '28.353434', 3, NULL, '0731', '410200', 'Wangcheng', 'W', NULL);
INSERT INTO `ez_area` VALUES (430121, '长沙县', 430100, '113.081097,28.246918', 'district', '113.081097', '28.246918', 3, NULL, '0731', '410100', 'Changsha', 'C', NULL);
INSERT INTO `ez_area` VALUES (430124, '宁乡市', 430100, '112.551885,28.277483', 'district', '112.551885', '28.277483', 3, NULL, '0731', '410600', 'Ningxiang', 'N', NULL);
INSERT INTO `ez_area` VALUES (430181, '浏阳市', 430100, '113.643076,28.162833', 'district', '113.643076', '28.162833', 3, NULL, '0731', '410300', 'Liuyang', 'L', NULL);
INSERT INTO `ez_area` VALUES (430200, '株洲市', 430000, '113.133853,27.827986', 'city', '113.133853', '27.827986', 2, NULL, '0731', '412000', 'Zhuzhou', 'Z', NULL);
INSERT INTO `ez_area` VALUES (430202, '荷塘区', 430200, '113.173487,27.855928', 'district', '113.173487', '27.855928', 3, NULL, '0731', '412000', 'Hetang', 'H', NULL);
INSERT INTO `ez_area` VALUES (430203, '芦淞区', 430200, '113.152724,27.78507', 'district', '113.152724', '27.78507', 3, NULL, '0731', '412000', 'Lusong', 'L', NULL);
INSERT INTO `ez_area` VALUES (430204, '石峰区', 430200, '113.117731,27.875445', 'district', '113.117731', '27.875445', 3, NULL, '0731', '412005', 'Shifeng', 'S', NULL);
INSERT INTO `ez_area` VALUES (430211, '天元区', 430200, '113.082216,27.826866', 'district', '113.082216', '27.826866', 3, NULL, '0731', '412007', 'Tianyuan', 'T', NULL);
INSERT INTO `ez_area` VALUES (430221, '株洲县', 430200, '113.144109,27.699232', 'district', '113.144109', '27.699232', 3, NULL, '0731', '412100', 'Zhuzhou', 'Z', NULL);
INSERT INTO `ez_area` VALUES (430223, '攸县', 430200, '113.396385,27.014583', 'district', '113.396385', '27.014583', 3, NULL, '0731', '412300', 'Youxian', 'Y', NULL);
INSERT INTO `ez_area` VALUES (430224, '茶陵县', 430200, '113.539094,26.777521', 'district', '113.539094', '26.777521', 3, NULL, '0731', '412400', 'Chaling', 'C', NULL);
INSERT INTO `ez_area` VALUES (430225, '炎陵县', 430200, '113.772655,26.489902', 'district', '113.772655', '26.489902', 3, NULL, '0731', '412500', 'Yanling', 'Y', NULL);
INSERT INTO `ez_area` VALUES (430281, '醴陵市', 430200, '113.496999,27.646096', 'district', '113.496999', '27.646096', 3, NULL, '0731', '412200', 'Liling', 'L', NULL);
INSERT INTO `ez_area` VALUES (430300, '湘潭市', 430000, '112.944026,27.829795', 'city', '112.944026', '27.829795', 2, NULL, '0731', '411100', 'Xiangtan', 'X', NULL);
INSERT INTO `ez_area` VALUES (430302, '雨湖区', 430300, '112.907162,27.856325', 'district', '112.907162', '27.856325', 3, NULL, '0731', '411100', 'Yuhu', 'Y', NULL);
INSERT INTO `ez_area` VALUES (430304, '岳塘区', 430300, '112.969479,27.872028', 'district', '112.969479', '27.872028', 3, NULL, '0731', '411101', 'Yuetang', 'Y', NULL);
INSERT INTO `ez_area` VALUES (430321, '湘潭县', 430300, '112.950831,27.778958', 'district', '112.950831', '27.778958', 3, NULL, '0731', '411228', 'Xiangtan', 'X', NULL);
INSERT INTO `ez_area` VALUES (430381, '湘乡市', 430300, '112.550205,27.718549', 'district', '112.550205', '27.718549', 3, NULL, '0731', '411400', 'Xiangxiang', 'X', NULL);
INSERT INTO `ez_area` VALUES (430382, '韶山市', 430300, '112.52667,27.915008', 'district', '112.52667', '27.915008', 3, NULL, '0731', '411300', 'Shaoshan', 'S', NULL);
INSERT INTO `ez_area` VALUES (430400, '衡阳市', 430000, '112.572018,26.893368', 'city', '112.572018', '26.893368', 2, NULL, '0734', '421001', 'Hengyang', 'H', NULL);
INSERT INTO `ez_area` VALUES (430405, '珠晖区', 430400, '112.620209,26.894765', 'district', '112.620209', '26.894765', 3, NULL, '0734', '421002', 'Zhuhui', 'Z', NULL);
INSERT INTO `ez_area` VALUES (430406, '雁峰区', 430400, '112.6154,26.840602', 'district', '112.6154', '26.840602', 3, NULL, '0734', '421001', 'Yanfeng', 'Y', NULL);
INSERT INTO `ez_area` VALUES (430407, '石鼓区', 430400, '112.597992,26.943755', 'district', '112.597992', '26.943755', 3, NULL, '0734', '421005', 'Shigu', 'S', NULL);
INSERT INTO `ez_area` VALUES (430408, '蒸湘区', 430400, '112.567107,26.911854', 'district', '112.567107', '26.911854', 3, NULL, '0734', '421001', 'Zhengxiang', 'Z', NULL);
INSERT INTO `ez_area` VALUES (430412, '南岳区', 430400, '112.738604,27.232443', 'district', '112.738604', '27.232443', 3, NULL, '0734', '421900', 'Nanyue', 'N', NULL);
INSERT INTO `ez_area` VALUES (430421, '衡阳县', 430400, '112.370546,26.969577', 'district', '112.370546', '26.969577', 3, NULL, '0734', '421200', 'Hengyang', 'H', NULL);
INSERT INTO `ez_area` VALUES (430422, '衡南县', 430400, '112.677877,26.738247', 'district', '112.677877', '26.738247', 3, NULL, '0734', '421131', 'Hengnan', 'H', NULL);
INSERT INTO `ez_area` VALUES (430423, '衡山县', 430400, '112.868268,27.23029', 'district', '112.868268', '27.23029', 3, NULL, '0734', '421300', 'Hengshan', 'H', NULL);
INSERT INTO `ez_area` VALUES (430424, '衡东县', 430400, '112.953168,27.08117', 'district', '112.953168', '27.08117', 3, NULL, '0734', '421400', 'Hengdong', 'H', NULL);
INSERT INTO `ez_area` VALUES (430426, '祁东县', 430400, '112.090356,26.799896', 'district', '112.090356', '26.799896', 3, NULL, '0734', '421600', 'Qidong', 'Q', NULL);
INSERT INTO `ez_area` VALUES (430481, '耒阳市', 430400, '112.859759,26.422277', 'district', '112.859759', '26.422277', 3, NULL, '0734', '421800', 'Leiyang', 'L', NULL);
INSERT INTO `ez_area` VALUES (430482, '常宁市', 430400, '112.399878,26.421956', 'district', '112.399878', '26.421956', 3, NULL, '0734', '421500', 'Changning', 'C', NULL);
INSERT INTO `ez_area` VALUES (430500, '邵阳市', 430000, '111.467674,27.23895', 'city', '111.467674', '27.23895', 2, NULL, '0739', '422000', 'Shaoyang', 'S', NULL);
INSERT INTO `ez_area` VALUES (430502, '双清区', 430500, '111.496341,27.232708', 'district', '111.496341', '27.232708', 3, NULL, '0739', '422001', 'Shuangqing', 'S', NULL);
INSERT INTO `ez_area` VALUES (430503, '大祥区', 430500, '111.439091,27.221452', 'district', '111.439091', '27.221452', 3, NULL, '0739', '422000', 'Daxiang', 'D', NULL);
INSERT INTO `ez_area` VALUES (430511, '北塔区', 430500, '111.452196,27.246489', 'district', '111.452196', '27.246489', 3, NULL, '0739', '422007', 'Beita', 'B', NULL);
INSERT INTO `ez_area` VALUES (430521, '邵东县', 430500, '111.74427,27.258987', 'district', '111.74427', '27.258987', 3, NULL, '0739', '422800', 'Shaodong', 'S', NULL);
INSERT INTO `ez_area` VALUES (430522, '新邵县', 430500, '111.458656,27.320917', 'district', '111.458656', '27.320917', 3, NULL, '0739', '422900', 'Xinshao', 'X', NULL);
INSERT INTO `ez_area` VALUES (430523, '邵阳县', 430500, '111.273805,26.990637', 'district', '111.273805', '26.990637', 3, NULL, '0739', '422100', 'Shaoyang', 'S', NULL);
INSERT INTO `ez_area` VALUES (430524, '隆回县', 430500, '111.032437,27.113978', 'district', '111.032437', '27.113978', 3, NULL, '0739', '422200', 'Longhui', 'L', NULL);
INSERT INTO `ez_area` VALUES (430525, '洞口县', 430500, '110.575846,27.06032', 'district', '110.575846', '27.06032', 3, NULL, '0739', '422300', 'Dongkou', 'D', NULL);
INSERT INTO `ez_area` VALUES (430527, '绥宁县', 430500, '110.155655,26.581954', 'district', '110.155655', '26.581954', 3, NULL, '0739', '422600', 'Suining', 'S', NULL);
INSERT INTO `ez_area` VALUES (430528, '新宁县', 430500, '110.856988,26.433367', 'district', '110.856988', '26.433367', 3, NULL, '0739', '422700', 'Xinning', 'X', NULL);
INSERT INTO `ez_area` VALUES (430529, '城步苗族自治县', 430500, '110.322239,26.390598', 'district', '110.322239', '26.390598', 3, NULL, '0739', '422500', 'Chengbu', 'C', NULL);
INSERT INTO `ez_area` VALUES (430581, '武冈市', 430500, '110.631884,26.726599', 'district', '110.631884', '26.726599', 3, NULL, '0739', '422400', 'Wugang', 'W', NULL);
INSERT INTO `ez_area` VALUES (430600, '岳阳市', 430000, '113.12873,29.356803', 'city', '113.12873', '29.356803', 2, NULL, '0730', '414000', 'Yueyang', 'Y', NULL);
INSERT INTO `ez_area` VALUES (430602, '岳阳楼区', 430600, '113.129684,29.371814', 'district', '113.129684', '29.371814', 3, NULL, '0730', '414000', 'Yueyanglou', 'Y', NULL);
INSERT INTO `ez_area` VALUES (430603, '云溪区', 430600, '113.272312,29.472745', 'district', '113.272312', '29.472745', 3, NULL, '0730', '414009', 'Yunxi', 'Y', NULL);
INSERT INTO `ez_area` VALUES (430611, '君山区', 430600, '113.006435,29.461106', 'district', '113.006435', '29.461106', 3, NULL, '0730', '414005', 'Junshan', 'J', NULL);
INSERT INTO `ez_area` VALUES (430621, '岳阳县', 430600, '113.116418,29.144066', 'district', '113.116418', '29.144066', 3, NULL, '0730', '414100', 'Yueyang', 'Y', NULL);
INSERT INTO `ez_area` VALUES (430623, '华容县', 430600, '112.540463,29.531057', 'district', '112.540463', '29.531057', 3, NULL, '0730', '414200', 'Huarong', 'H', NULL);
INSERT INTO `ez_area` VALUES (430624, '湘阴县', 430600, '112.909426,28.689104', 'district', '112.909426', '28.689104', 3, NULL, '0730', '414600', 'Xiangyin', 'X', NULL);
INSERT INTO `ez_area` VALUES (430626, '平江县', 430600, '113.581234,28.701868', 'district', '113.581234', '28.701868', 3, NULL, '0730', '414500', 'Pingjiang', 'P', NULL);
INSERT INTO `ez_area` VALUES (430681, '汨罗市', 430600, '113.067251,28.806881', 'district', '113.067251', '28.806881', 3, NULL, '0730', '414400', 'Miluo', 'M', NULL);
INSERT INTO `ez_area` VALUES (430682, '临湘市', 430600, '113.450423,29.476849', 'district', '113.450423', '29.476849', 3, NULL, '0730', '414300', 'Linxiang', 'L', NULL);
INSERT INTO `ez_area` VALUES (430700, '常德市', 430000, '111.698784,29.031654', 'city', '111.698784', '29.031654', 2, NULL, '0736', '415000', 'Changde', 'C', NULL);
INSERT INTO `ez_area` VALUES (430702, '武陵区', 430700, '111.683153,29.055163', 'district', '111.683153', '29.055163', 3, NULL, '0736', '415000', 'Wuling', 'W', NULL);
INSERT INTO `ez_area` VALUES (430703, '鼎城区', 430700, '111.680783,29.018593', 'district', '111.680783', '29.018593', 3, NULL, '0736', '415101', 'Dingcheng', 'D', NULL);
INSERT INTO `ez_area` VALUES (430721, '安乡县', 430700, '112.171131,29.411309', 'district', '112.171131', '29.411309', 3, NULL, '0736', '415600', 'Anxiang', 'A', NULL);
INSERT INTO `ez_area` VALUES (430722, '汉寿县', 430700, '111.970514,28.906106', 'district', '111.970514', '28.906106', 3, NULL, '0736', '415900', 'Hanshou', 'H', NULL);
INSERT INTO `ez_area` VALUES (430723, '澧县', 430700, '111.758702,29.633236', 'district', '111.758702', '29.633236', 3, NULL, '0736', '415500', 'Lixian', 'L', NULL);
INSERT INTO `ez_area` VALUES (430724, '临澧县', 430700, '111.647517,29.440793', 'district', '111.647517', '29.440793', 3, NULL, '0736', '415200', 'Linli', 'L', NULL);
INSERT INTO `ez_area` VALUES (430725, '桃源县', 430700, '111.488925,28.902503', 'district', '111.488925', '28.902503', 3, NULL, '0736', '415700', 'Taoyuan', 'T', NULL);
INSERT INTO `ez_area` VALUES (430726, '石门县', 430700, '111.380014,29.584292', 'district', '111.380014', '29.584292', 3, NULL, '0736', '415300', 'Shimen', 'S', NULL);
INSERT INTO `ez_area` VALUES (430781, '津市市', 430700, '111.877499,29.60548', 'district', '111.877499', '29.60548', 3, NULL, '0736', '415400', 'Jinshi', 'J', NULL);
INSERT INTO `ez_area` VALUES (430800, '张家界市', 430000, '110.479148,29.117013', 'city', '110.479148', '29.117013', 2, NULL, '0744', '427000', 'Zhangjiajie', 'Z', NULL);
INSERT INTO `ez_area` VALUES (430802, '永定区', 430800, '110.537138,29.119855', 'district', '110.537138', '29.119855', 3, NULL, '0744', '427000', 'Yongding', 'Y', NULL);
INSERT INTO `ez_area` VALUES (430811, '武陵源区', 430800, '110.550433,29.34573', 'district', '110.550433', '29.34573', 3, NULL, '0744', '427400', 'Wulingyuan', 'W', NULL);
INSERT INTO `ez_area` VALUES (430821, '慈利县', 430800, '111.139775,29.429999', 'district', '111.139775', '29.429999', 3, NULL, '0744', '427200', 'Cili', 'C', NULL);
INSERT INTO `ez_area` VALUES (430822, '桑植县', 430800, '110.204652,29.414111', 'district', '110.204652', '29.414111', 3, NULL, '0744', '427100', 'Sangzhi', 'S', NULL);
INSERT INTO `ez_area` VALUES (430900, '益阳市', 430000, '112.355129,28.554349', 'city', '112.355129', '28.554349', 2, NULL, '0737', '413000', 'Yiyang', 'Y', NULL);
INSERT INTO `ez_area` VALUES (430902, '资阳区', 430900, '112.324272,28.59111', 'district', '112.324272', '28.59111', 3, NULL, '0737', '413001', 'Ziyang', 'Z', NULL);
INSERT INTO `ez_area` VALUES (430903, '赫山区', 430900, '112.374145,28.579494', 'district', '112.374145', '28.579494', 3, NULL, '0737', '413002', 'Heshan', 'H', NULL);
INSERT INTO `ez_area` VALUES (430921, '南县', 430900, '112.396337,29.362275', 'district', '112.396337', '29.362275', 3, NULL, '0737', '413200', 'Nanxian', 'N', NULL);
INSERT INTO `ez_area` VALUES (430922, '桃江县', 430900, '112.155822,28.518084', 'district', '112.155822', '28.518084', 3, NULL, '0737', '413400', 'Taojiang', 'T', NULL);
INSERT INTO `ez_area` VALUES (430923, '安化县', 430900, '111.212846,28.374107', 'district', '111.212846', '28.374107', 3, NULL, '0737', '413500', 'Anhua', 'A', NULL);
INSERT INTO `ez_area` VALUES (430981, '沅江市', 430900, '112.355954,28.847045', 'district', '112.355954', '28.847045', 3, NULL, '0737', '413100', 'Yuanjiang', 'Y', NULL);
INSERT INTO `ez_area` VALUES (431000, '郴州市', 430000, '113.014984,25.770532', 'city', '113.014984', '25.770532', 2, NULL, '0735', '423000', 'Chenzhou', 'C', NULL);
INSERT INTO `ez_area` VALUES (431002, '北湖区', 431000, '113.011035,25.784054', 'district', '113.011035', '25.784054', 3, NULL, '0735', '423000', 'Beihu', 'B', NULL);
INSERT INTO `ez_area` VALUES (431003, '苏仙区', 431000, '113.112105,25.797013', 'district', '113.112105', '25.797013', 3, NULL, '0735', '423000', 'Suxian', 'S', NULL);
INSERT INTO `ez_area` VALUES (431021, '桂阳县', 431000, '112.734173,25.754172', 'district', '112.734173', '25.754172', 3, NULL, '0735', '424400', 'Guiyang', 'G', NULL);
INSERT INTO `ez_area` VALUES (431022, '宜章县', 431000, '112.948712,25.399938', 'district', '112.948712', '25.399938', 3, NULL, '0735', '424200', 'Yizhang', 'Y', NULL);
INSERT INTO `ez_area` VALUES (431023, '永兴县', 431000, '113.116527,26.12715', 'district', '113.116527', '26.12715', 3, NULL, '0735', '423300', 'Yongxing', 'Y', NULL);
INSERT INTO `ez_area` VALUES (431024, '嘉禾县', 431000, '112.36902,25.587519', 'district', '112.36902', '25.587519', 3, NULL, '0735', '424500', 'Jiahe', 'J', NULL);
INSERT INTO `ez_area` VALUES (431025, '临武县', 431000, '112.563456,25.27556', 'district', '112.563456', '25.27556', 3, NULL, '0735', '424300', 'Linwu', 'L', NULL);
INSERT INTO `ez_area` VALUES (431026, '汝城县', 431000, '113.684727,25.532816', 'district', '113.684727', '25.532816', 3, NULL, '0735', '424100', 'Rucheng', 'R', NULL);
INSERT INTO `ez_area` VALUES (431027, '桂东县', 431000, '113.944614,26.077616', 'district', '113.944614', '26.077616', 3, NULL, '0735', '423500', 'Guidong', 'G', NULL);
INSERT INTO `ez_area` VALUES (431028, '安仁县', 431000, '113.26932,26.709061', 'district', '113.26932', '26.709061', 3, NULL, '0735', '423600', 'Anren', 'A', NULL);
INSERT INTO `ez_area` VALUES (431081, '资兴市', 431000, '113.236146,25.976243', 'district', '113.236146', '25.976243', 3, NULL, '0735', '423400', 'Zixing', 'Z', NULL);
INSERT INTO `ez_area` VALUES (431100, '永州市', 430000, '111.613418,26.419641', 'city', '111.613418', '26.419641', 2, NULL, '0746', '425000', 'Yongzhou', 'Y', NULL);
INSERT INTO `ez_area` VALUES (431102, '零陵区', 431100, '111.631109,26.221936', 'district', '111.631109', '26.221936', 3, NULL, '0746', '425100', 'Lingling', 'L', NULL);
INSERT INTO `ez_area` VALUES (431103, '冷水滩区', 431100, '111.592343,26.46128', 'district', '111.592343', '26.46128', 3, NULL, '0746', '425100', 'Lengshuitan', 'L', NULL);
INSERT INTO `ez_area` VALUES (431121, '祁阳县', 431100, '111.840657,26.58012', 'district', '111.840657', '26.58012', 3, NULL, '0746', '426100', 'Qiyang', 'Q', NULL);
INSERT INTO `ez_area` VALUES (431122, '东安县', 431100, '111.316464,26.392183', 'district', '111.316464', '26.392183', 3, NULL, '0746', '425900', 'Dong\'an', 'D', NULL);
INSERT INTO `ez_area` VALUES (431123, '双牌县', 431100, '111.659967,25.961909', 'district', '111.659967', '25.961909', 3, NULL, '0746', '425200', 'Shuangpai', 'S', NULL);
INSERT INTO `ez_area` VALUES (431124, '道县', 431100, '111.600795,25.526437', 'district', '111.600795', '25.526437', 3, NULL, '0746', '425300', 'Daoxian', 'D', NULL);
INSERT INTO `ez_area` VALUES (431125, '江永县', 431100, '111.343911,25.273539', 'district', '111.343911', '25.273539', 3, NULL, '0746', '425400', 'Jiangyong', 'J', NULL);
INSERT INTO `ez_area` VALUES (431126, '宁远县', 431100, '111.945844,25.570888', 'district', '111.945844', '25.570888', 3, NULL, '0746', '425600', 'Ningyuan', 'N', NULL);
INSERT INTO `ez_area` VALUES (431127, '蓝山县', 431100, '112.196567,25.369725', 'district', '112.196567', '25.369725', 3, NULL, '0746', '425800', 'Lanshan', 'L', NULL);
INSERT INTO `ez_area` VALUES (431128, '新田县', 431100, '112.203287,25.904305', 'district', '112.203287', '25.904305', 3, NULL, '0746', '425700', 'Xintian', 'X', NULL);
INSERT INTO `ez_area` VALUES (431129, '江华瑶族自治县', 431100, '111.579535,25.185809', 'district', '111.579535', '25.185809', 3, NULL, '0746', '425500', 'Jianghua', 'J', NULL);
INSERT INTO `ez_area` VALUES (431200, '怀化市', 430000, '110.001923,27.569517', 'city', '110.001923', '27.569517', 2, NULL, '0745', '418000', 'Huaihua', 'H', NULL);
INSERT INTO `ez_area` VALUES (431202, '鹤城区', 431200, '110.040315,27.578926', 'district', '110.040315', '27.578926', 3, NULL, '0745', '418000', 'Hecheng', 'H', NULL);
INSERT INTO `ez_area` VALUES (431221, '中方县', 431200, '109.944711,27.440138', 'district', '109.944711', '27.440138', 3, NULL, '0745', '418005', 'Zhongfang', 'Z', NULL);
INSERT INTO `ez_area` VALUES (431222, '沅陵县', 431200, '110.393844,28.452686', 'district', '110.393844', '28.452686', 3, NULL, '0745', '419600', 'Yuanling', 'Y', NULL);
INSERT INTO `ez_area` VALUES (431223, '辰溪县', 431200, '110.183917,28.006336', 'district', '110.183917', '28.006336', 3, NULL, '0745', '419500', 'Chenxi', 'C', NULL);
INSERT INTO `ez_area` VALUES (431224, '溆浦县', 431200, '110.594879,27.908267', 'district', '110.594879', '27.908267', 3, NULL, '0745', '419300', 'Xupu', 'X', NULL);
INSERT INTO `ez_area` VALUES (431225, '会同县', 431200, '109.735661,26.887238', 'district', '109.735661', '26.887238', 3, NULL, '0745', '418300', 'Huitong', 'H', NULL);
INSERT INTO `ez_area` VALUES (431226, '麻阳苗族自治县', 431200, '109.81701,27.857569', 'district', '109.81701', '27.857569', 3, NULL, '0745', '419400', 'Mayang', 'M', NULL);
INSERT INTO `ez_area` VALUES (431227, '新晃侗族自治县', 431200, '109.174932,27.352673', 'district', '109.174932', '27.352673', 3, NULL, '0745', '419200', 'Xinhuang', 'X', NULL);
INSERT INTO `ez_area` VALUES (431228, '芷江侗族自治县', 431200, '109.684629,27.443499', 'district', '109.684629', '27.443499', 3, NULL, '0745', '419100', 'Zhijiang', 'Z', NULL);
INSERT INTO `ez_area` VALUES (431229, '靖州苗族侗族自治县', 431200, '109.696273,26.575107', 'district', '109.696273', '26.575107', 3, NULL, '0745', '418400', 'Jingzhou', 'J', NULL);
INSERT INTO `ez_area` VALUES (431230, '通道侗族自治县', 431200, '109.784412,26.158054', 'district', '109.784412', '26.158054', 3, NULL, '0745', '418500', 'Tongdao', 'T', NULL);
INSERT INTO `ez_area` VALUES (431281, '洪江市', 431200, '109.836669,27.208609', 'district', '109.836669', '27.208609', 3, NULL, '0745', '418100', 'Hongjiang', 'H', NULL);
INSERT INTO `ez_area` VALUES (431300, '娄底市', 430000, '111.994482,27.70027', 'city', '111.994482', '27.70027', 2, NULL, '0738', '417000', 'Loudi', 'L', NULL);
INSERT INTO `ez_area` VALUES (431302, '娄星区', 431300, '112.001914,27.729863', 'district', '112.001914', '27.729863', 3, NULL, '0738', '417000', 'Louxing', 'L', NULL);
INSERT INTO `ez_area` VALUES (431321, '双峰县', 431300, '112.175163,27.457172', 'district', '112.175163', '27.457172', 3, NULL, '0738', '417700', 'Shuangfeng', 'S', NULL);
INSERT INTO `ez_area` VALUES (431322, '新化县', 431300, '111.327412,27.726514', 'district', '111.327412', '27.726514', 3, NULL, '0738', '417600', 'Xinhua', 'X', NULL);
INSERT INTO `ez_area` VALUES (431381, '冷水江市', 431300, '111.434984,27.686251', 'district', '111.434984', '27.686251', 3, NULL, '0738', '417500', 'Lengshuijiang', 'L', NULL);
INSERT INTO `ez_area` VALUES (431382, '涟源市', 431300, '111.664329,27.692577', 'district', '111.664329', '27.692577', 3, NULL, '0738', '417100', 'Lianyuan', 'L', NULL);
INSERT INTO `ez_area` VALUES (433100, '湘西土家族苗族自治州', 430000, '109.738906,28.31195', 'city', '109.738906', '28.31195', 2, NULL, '0743', '416000', 'Xiangxi', 'X', NULL);
INSERT INTO `ez_area` VALUES (433101, '吉首市', 433100, '109.698015,28.262376', 'district', '109.698015', '28.262376', 3, NULL, '0743', '416000', 'Jishou', 'J', NULL);
INSERT INTO `ez_area` VALUES (433122, '泸溪县', 433100, '110.21961,28.216641', 'district', '110.21961', '28.216641', 3, NULL, '0743', '416100', 'Luxi', 'L', NULL);
INSERT INTO `ez_area` VALUES (433123, '凤凰县', 433100, '109.581083,27.958081', 'district', '109.581083', '27.958081', 3, NULL, '0743', '416200', 'Fenghuang', 'F', NULL);
INSERT INTO `ez_area` VALUES (433124, '花垣县', 433100, '109.482078,28.572029', 'district', '109.482078', '28.572029', 3, NULL, '0743', '416400', 'Huayuan', 'H', NULL);
INSERT INTO `ez_area` VALUES (433125, '保靖县', 433100, '109.660559,28.699878', 'district', '109.660559', '28.699878', 3, NULL, '0743', '416500', 'Baojing', 'B', NULL);
INSERT INTO `ez_area` VALUES (433126, '古丈县', 433100, '109.950728,28.616935', 'district', '109.950728', '28.616935', 3, NULL, '0743', '416300', 'Guzhang', 'G', NULL);
INSERT INTO `ez_area` VALUES (433127, '永顺县', 433100, '109.856933,28.979955', 'district', '109.856933', '28.979955', 3, NULL, '0743', '416700', 'Yongshun', 'Y', NULL);
INSERT INTO `ez_area` VALUES (433130, '龙山县', 433100, '109.443938,29.457663', 'district', '109.443938', '29.457663', 3, NULL, '0743', '416800', 'Longshan', 'L', NULL);
INSERT INTO `ez_area` VALUES (440000, '广东省', 0, '113.26641,23.132324', 'province', '113.26641', '23.132324', 1, NULL, NULL, NULL, 'Guangdong', 'G', NULL);
INSERT INTO `ez_area` VALUES (440100, '广州市', 440000, '113.264385,23.12911', 'city', '113.264385', '23.12911', 2, NULL, '020', '510032', 'Guangzhou', 'G', NULL);
INSERT INTO `ez_area` VALUES (440103, '荔湾区', 440100, '113.244258,23.125863', 'district', '113.244258', '23.125863', 3, NULL, '020', '510170', 'Liwan', 'L', NULL);
INSERT INTO `ez_area` VALUES (440104, '越秀区', 440100, '113.266835,23.128537', 'district', '113.266835', '23.128537', 3, NULL, '020', '510030', 'Yuexiu', 'Y', NULL);
INSERT INTO `ez_area` VALUES (440105, '海珠区', 440100, '113.317443,23.083788', 'district', '113.317443', '23.083788', 3, NULL, '020', '510300', 'Haizhu', 'H', NULL);
INSERT INTO `ez_area` VALUES (440106, '天河区', 440100, '113.361575,23.124807', 'district', '113.361575', '23.124807', 3, NULL, '020', '510665', 'Tianhe', 'T', NULL);
INSERT INTO `ez_area` VALUES (440111, '白云区', 440100, '113.273238,23.157367', 'district', '113.273238', '23.157367', 3, NULL, '020', '510405', 'Baiyun', 'B', NULL);
INSERT INTO `ez_area` VALUES (440112, '黄埔区', 440100, '113.480541,23.181706', 'district', '113.480541', '23.181706', 3, NULL, '020', '510700', 'Huangpu', 'H', NULL);
INSERT INTO `ez_area` VALUES (440113, '番禺区', 440100, '113.384152,22.937556', 'district', '113.384152', '22.937556', 3, NULL, '020', '511400', 'Panyu', 'P', NULL);
INSERT INTO `ez_area` VALUES (440114, '花都区', 440100, '113.220463,23.403744', 'district', '113.220463', '23.403744', 3, NULL, '020', '510800', 'Huadu', 'H', NULL);
INSERT INTO `ez_area` VALUES (440115, '南沙区', 440100, '113.525165,22.801624', 'district', '113.525165', '22.801624', 3, NULL, '020', '511458', 'Nansha', 'N', NULL);
INSERT INTO `ez_area` VALUES (440117, '从化区', 440100, '113.586679,23.548748', 'district', '113.586679', '23.548748', 3, NULL, '020', '510900', 'Conghua', 'C', NULL);
INSERT INTO `ez_area` VALUES (440118, '增城区', 440100, '113.810627,23.261465', 'district', '113.810627', '23.261465', 3, NULL, '020', '511300', 'Zengcheng', 'Z', NULL);
INSERT INTO `ez_area` VALUES (440200, '韶关市', 440000, '113.59762,24.810879', 'city', '113.59762', '24.810879', 2, NULL, '0751', '512002', 'Shaoguan', 'S', NULL);
INSERT INTO `ez_area` VALUES (440203, '武江区', 440200, '113.587756,24.792926', 'district', '113.587756', '24.792926', 3, NULL, '0751', '512026', 'Wujiang', 'W', NULL);
INSERT INTO `ez_area` VALUES (440204, '浈江区', 440200, '113.611098,24.804381', 'district', '113.611098', '24.804381', 3, NULL, '0751', '512023', 'Zhenjiang', 'Z', NULL);
INSERT INTO `ez_area` VALUES (440205, '曲江区', 440200, '113.604535,24.682501', 'district', '113.604535', '24.682501', 3, NULL, '0751', '512101', 'Qujiang', 'Q', NULL);
INSERT INTO `ez_area` VALUES (440222, '始兴县', 440200, '114.061789,24.952976', 'district', '114.061789', '24.952976', 3, NULL, '0751', '512500', 'Shixing', 'S', NULL);
INSERT INTO `ez_area` VALUES (440224, '仁化县', 440200, '113.749027,25.085621', 'district', '113.749027', '25.085621', 3, NULL, '0751', '512300', 'Renhua', 'R', NULL);
INSERT INTO `ez_area` VALUES (440229, '翁源县', 440200, '114.130342,24.350346', 'district', '114.130342', '24.350346', 3, NULL, '0751', '512600', 'Wengyuan', 'W', NULL);
INSERT INTO `ez_area` VALUES (440232, '乳源瑶族自治县', 440200, '113.275883,24.776078', 'district', '113.275883', '24.776078', 3, NULL, '0751', '512700', 'Ruyuan', 'R', NULL);
INSERT INTO `ez_area` VALUES (440233, '新丰县', 440200, '114.206867,24.05976', 'district', '114.206867', '24.05976', 3, NULL, '0751', '511100', 'Xinfeng', 'X', NULL);
INSERT INTO `ez_area` VALUES (440281, '乐昌市', 440200, '113.347545,25.130602', 'district', '113.347545', '25.130602', 3, NULL, '0751', '512200', 'Lechang', 'L', NULL);
INSERT INTO `ez_area` VALUES (440282, '南雄市', 440200, '114.311982,25.117753', 'district', '114.311982', '25.117753', 3, NULL, '0751', '512400', 'Nanxiong', 'N', NULL);
INSERT INTO `ez_area` VALUES (440300, '深圳市', 440000, '114.057939,22.543527', 'city', '114.057939', '22.543527', 2, NULL, '0755', '518035', 'Shenzhen', 'S', NULL);
INSERT INTO `ez_area` VALUES (440303, '罗湖区', 440300, '114.131459,22.548389', 'district', '114.131459', '22.548389', 3, NULL, '0755', '518021', 'Luohu', 'L', NULL);
INSERT INTO `ez_area` VALUES (440304, '福田区', 440300, '114.055072,22.521521', 'district', '114.055072', '22.521521', 3, NULL, '0755', '518048', 'Futian', 'F', NULL);
INSERT INTO `ez_area` VALUES (440305, '南山区', 440300, '113.930413,22.533287', 'district', '113.930413', '22.533287', 3, NULL, '0755', '518051', 'Nanshan', 'N', NULL);
INSERT INTO `ez_area` VALUES (440306, '宝安区', 440300, '113.883802,22.554996', 'district', '113.883802', '22.554996', 3, NULL, '0755', '518101', 'Bao\'an', 'B', NULL);
INSERT INTO `ez_area` VALUES (440307, '龙岗区', 440300, '114.246899,22.720974', 'district', '114.246899', '22.720974', 3, NULL, '0755', '518172', 'Longgang', 'L', NULL);
INSERT INTO `ez_area` VALUES (440308, '盐田区', 440300, '114.236739,22.557001', 'district', '114.236739', '22.557001', 3, NULL, '0755', '518081', 'Yantian', 'Y', NULL);
INSERT INTO `ez_area` VALUES (440309, '龙华区', 440300, '114.045422,22.696667', 'district', '114.045422', '22.696667', 3, NULL, '0755', '518100', 'Guangmingxinqu', 'G', NULL);
INSERT INTO `ez_area` VALUES (440310, '坪山区', 440300, '114.350584,22.708881', 'district', '114.350584', '22.708881', 3, NULL, '0755', '518000', 'Pingshanxinqu', 'P', NULL);
INSERT INTO `ez_area` VALUES (440400, '珠海市', 440000, '113.576677,22.270978', 'city', '113.576677', '22.270978', 2, NULL, '0756', '519000', 'Zhuhai', 'Z', NULL);
INSERT INTO `ez_area` VALUES (440402, '香洲区', 440400, '113.543784,22.265811', 'district', '113.543784', '22.265811', 3, NULL, '0756', '519000', 'Xiangzhou', 'X', NULL);
INSERT INTO `ez_area` VALUES (440403, '斗门区', 440400, '113.296467,22.2092', 'district', '113.296467', '22.2092', 3, NULL, '0756', '519110', 'Doumen', 'D', NULL);
INSERT INTO `ez_area` VALUES (440404, '金湾区', 440400, '113.362656,22.147471', 'district', '113.362656', '22.147471', 3, NULL, '0756', '519040', 'Jinwan', 'J', NULL);
INSERT INTO `ez_area` VALUES (440500, '汕头市', 440000, '116.681972,23.354091', 'city', '116.681972', '23.354091', 2, NULL, '0754', '515041', 'Shantou', 'S', NULL);
INSERT INTO `ez_area` VALUES (440507, '龙湖区', 440500, '116.716446,23.372254', 'district', '116.716446', '23.372254', 3, NULL, '0754', '515041', 'Longhu', 'L', NULL);
INSERT INTO `ez_area` VALUES (440511, '金平区', 440500, '116.70345,23.365556', 'district', '116.70345', '23.365556', 3, NULL, '0754', '515041', 'Jinping', 'J', NULL);
INSERT INTO `ez_area` VALUES (440512, '濠江区', 440500, '116.726973,23.286079', 'district', '116.726973', '23.286079', 3, NULL, '0754', '515071', 'Haojiang', 'H', NULL);
INSERT INTO `ez_area` VALUES (440513, '潮阳区', 440500, '116.601509,23.265356', 'district', '116.601509', '23.265356', 3, NULL, '0754', '515100', 'Chaoyang', 'C', NULL);
INSERT INTO `ez_area` VALUES (440514, '潮南区', 440500, '116.439178,23.23865', 'district', '116.439178', '23.23865', 3, NULL, '0754', '515144', 'Chaonan', 'C', NULL);
INSERT INTO `ez_area` VALUES (440515, '澄海区', 440500, '116.755992,23.466709', 'district', '116.755992', '23.466709', 3, NULL, '0754', '515800', 'Chenghai', 'C', NULL);
INSERT INTO `ez_area` VALUES (440523, '南澳县', 440500, '117.023374,23.421724', 'district', '117.023374', '23.421724', 3, NULL, '0754', '515900', 'Nanao', 'N', NULL);
INSERT INTO `ez_area` VALUES (440600, '佛山市', 440000, '113.121435,23.021478', 'city', '113.121435', '23.021478', 2, NULL, '0757', '528000', 'Foshan', 'F', NULL);
INSERT INTO `ez_area` VALUES (440604, '禅城区', 440600, '113.122421,23.009551', 'district', '113.122421', '23.009551', 3, NULL, '0757', '528000', 'Chancheng', 'C', NULL);
INSERT INTO `ez_area` VALUES (440605, '南海区', 440600, '113.143441,23.028956', 'district', '113.143441', '23.028956', 3, NULL, '0757', '528251', 'Nanhai', 'N', NULL);
INSERT INTO `ez_area` VALUES (440606, '顺德区', 440600, '113.293359,22.80524', 'district', '113.293359', '22.80524', 3, NULL, '0757', '528300', 'Shunde', 'S', NULL);
INSERT INTO `ez_area` VALUES (440607, '三水区', 440600, '112.896685,23.155931', 'district', '112.896685', '23.155931', 3, NULL, '0757', '528133', 'Sanshui', 'S', NULL);
INSERT INTO `ez_area` VALUES (440608, '高明区', 440600, '112.892585,22.900139', 'district', '112.892585', '22.900139', 3, NULL, '0757', '528500', 'Gaoming', 'G', NULL);
INSERT INTO `ez_area` VALUES (440700, '江门市', 440000, '113.081542,22.57899', 'city', '113.081542', '22.57899', 2, NULL, '0750', '529000', 'Jiangmen', 'J', NULL);
INSERT INTO `ez_area` VALUES (440703, '蓬江区', 440700, '113.078521,22.595149', 'district', '113.078521', '22.595149', 3, NULL, '0750', '529000', 'Pengjiang', 'P', NULL);
INSERT INTO `ez_area` VALUES (440704, '江海区', 440700, '113.111612,22.560473', 'district', '113.111612', '22.560473', 3, NULL, '0750', '529040', 'Jianghai', 'J', NULL);
INSERT INTO `ez_area` VALUES (440705, '新会区', 440700, '113.034187,22.4583', 'district', '113.034187', '22.4583', 3, NULL, '0750', '529100', 'Xinhui', 'X', NULL);
INSERT INTO `ez_area` VALUES (440781, '台山市', 440700, '112.794065,22.251924', 'district', '112.794065', '22.251924', 3, NULL, '0750', '529200', 'Taishan', 'T', NULL);
INSERT INTO `ez_area` VALUES (440783, '开平市', 440700, '112.698545,22.376395', 'district', '112.698545', '22.376395', 3, NULL, '0750', '529337', 'Kaiping', 'K', NULL);
INSERT INTO `ez_area` VALUES (440784, '鹤山市', 440700, '112.964252,22.76545', 'district', '112.964252', '22.76545', 3, NULL, '0750', '529700', 'Heshan', 'H', NULL);
INSERT INTO `ez_area` VALUES (440785, '恩平市', 440700, '112.305145,22.183206', 'district', '112.305145', '22.183206', 3, NULL, '0750', '529400', 'Enping', 'E', NULL);
INSERT INTO `ez_area` VALUES (440800, '湛江市', 440000, '110.356639,21.270145', 'city', '110.356639', '21.270145', 2, NULL, '0759', '524047', 'Zhanjiang', 'Z', NULL);
INSERT INTO `ez_area` VALUES (440802, '赤坎区', 440800, '110.365899,21.266119', 'district', '110.365899', '21.266119', 3, NULL, '0759', '524033', 'Chikan', 'C', NULL);
INSERT INTO `ez_area` VALUES (440803, '霞山区', 440800, '110.397656,21.192457', 'district', '110.397656', '21.192457', 3, NULL, '0759', '524011', 'Xiashan', 'X', NULL);
INSERT INTO `ez_area` VALUES (440804, '坡头区', 440800, '110.455332,21.244721', 'district', '110.455332', '21.244721', 3, NULL, '0759', '524057', 'Potou', 'P', NULL);
INSERT INTO `ez_area` VALUES (440811, '麻章区', 440800, '110.334387,21.263442', 'district', '110.334387', '21.263442', 3, NULL, '0759', '524094', 'Mazhang', 'M', NULL);
INSERT INTO `ez_area` VALUES (440823, '遂溪县', 440800, '110.250123,21.377246', 'district', '110.250123', '21.377246', 3, NULL, '0759', '524300', 'Suixi', 'S', NULL);
INSERT INTO `ez_area` VALUES (440825, '徐闻县', 440800, '110.176749,20.325489', 'district', '110.176749', '20.325489', 3, NULL, '0759', '524100', 'Xuwen', 'X', NULL);
INSERT INTO `ez_area` VALUES (440881, '廉江市', 440800, '110.286208,21.6097', 'district', '110.286208', '21.6097', 3, NULL, '0759', '524400', 'Lianjiang', 'L', NULL);
INSERT INTO `ez_area` VALUES (440882, '雷州市', 440800, '110.096586,20.914178', 'district', '110.096586', '20.914178', 3, NULL, '0759', '524200', 'Leizhou', 'L', NULL);
INSERT INTO `ez_area` VALUES (440883, '吴川市', 440800, '110.778411,21.441808', 'district', '110.778411', '21.441808', 3, NULL, '0759', '524500', 'Wuchuan', 'W', NULL);
INSERT INTO `ez_area` VALUES (440900, '茂名市', 440000, '110.925439,21.662991', 'city', '110.925439', '21.662991', 2, NULL, '0668', '525000', 'Maoming', 'M', NULL);
INSERT INTO `ez_area` VALUES (440902, '茂南区', 440900, '110.918026,21.641337', 'district', '110.918026', '21.641337', 3, NULL, '0668', '525000', 'Maonan', 'M', NULL);
INSERT INTO `ez_area` VALUES (440904, '电白区', 440900, '111.013556,21.514163', 'district', '111.013556', '21.514163', 3, NULL, '0668', '525400', 'Dianbai', 'D', NULL);
INSERT INTO `ez_area` VALUES (440981, '高州市', 440900, '110.853299,21.918203', 'district', '110.853299', '21.918203', 3, NULL, '0668', '525200', 'Gaozhou', 'G', NULL);
INSERT INTO `ez_area` VALUES (440982, '化州市', 440900, '110.639565,21.66463', 'district', '110.639565', '21.66463', 3, NULL, '0668', '525100', 'Huazhou', 'H', NULL);
INSERT INTO `ez_area` VALUES (440983, '信宜市', 440900, '110.947043,22.354385', 'district', '110.947043', '22.354385', 3, NULL, '0668', '525300', 'Xinyi', 'X', NULL);
INSERT INTO `ez_area` VALUES (441200, '肇庆市', 440000, '112.465091,23.047191', 'city', '112.465091', '23.047191', 2, NULL, '0758', '526040', 'Zhaoqing', 'Z', NULL);
INSERT INTO `ez_area` VALUES (441202, '端州区', 441200, '112.484848,23.052101', 'district', '112.484848', '23.052101', 3, NULL, '0758', '526060', 'Duanzhou', 'D', NULL);
INSERT INTO `ez_area` VALUES (441203, '鼎湖区', 441200, '112.567588,23.158447', 'district', '112.567588', '23.158447', 3, NULL, '0758', '526070', 'Dinghu', 'D', NULL);
INSERT INTO `ez_area` VALUES (441204, '高要区', 441200, '112.457981,23.025305', 'district', '112.457981', '23.025305', 3, NULL, '0758', '526100', 'Gaoyao', 'G', NULL);
INSERT INTO `ez_area` VALUES (441223, '广宁县', 441200, '112.44069,23.634675', 'district', '112.44069', '23.634675', 3, NULL, '0758', '526300', 'Guangning', 'G', NULL);
INSERT INTO `ez_area` VALUES (441224, '怀集县', 441200, '112.167742,23.92035', 'district', '112.167742', '23.92035', 3, NULL, '0758', '526400', 'Huaiji', 'H', NULL);
INSERT INTO `ez_area` VALUES (441225, '封开县', 441200, '111.512343,23.424033', 'district', '111.512343', '23.424033', 3, NULL, '0758', '526500', 'Fengkai', 'F', NULL);
INSERT INTO `ez_area` VALUES (441226, '德庆县', 441200, '111.785937,23.143722', 'district', '111.785937', '23.143722', 3, NULL, '0758', '526600', 'Deqing', 'D', NULL);
INSERT INTO `ez_area` VALUES (441284, '四会市', 441200, '112.734103,23.327001', 'district', '112.734103', '23.327001', 3, NULL, '0758', '526200', 'Sihui', 'S', NULL);
INSERT INTO `ez_area` VALUES (441300, '惠州市', 440000, '114.415612,23.112381', 'city', '114.415612', '23.112381', 2, NULL, '0752', '516000', 'Huizhou', 'H', NULL);
INSERT INTO `ez_area` VALUES (441302, '惠城区', 441300, '114.382474,23.084137', 'district', '114.382474', '23.084137', 3, NULL, '0752', '516008', 'Huicheng', 'H', NULL);
INSERT INTO `ez_area` VALUES (441303, '惠阳区', 441300, '114.456176,22.789788', 'district', '114.456176', '22.789788', 3, NULL, '0752', '516211', 'Huiyang', 'H', NULL);
INSERT INTO `ez_area` VALUES (441322, '博罗县', 441300, '114.289528,23.172771', 'district', '114.289528', '23.172771', 3, NULL, '0752', '516100', 'Boluo', 'B', NULL);
INSERT INTO `ez_area` VALUES (441323, '惠东县', 441300, '114.719988,22.985014', 'district', '114.719988', '22.985014', 3, NULL, '0752', '516300', 'Huidong', 'H', NULL);
INSERT INTO `ez_area` VALUES (441324, '龙门县', 441300, '114.254863,23.727737', 'district', '114.254863', '23.727737', 3, NULL, '0752', '516800', 'Longmen', 'L', NULL);
INSERT INTO `ez_area` VALUES (441400, '梅州市', 440000, '116.122523,24.288578', 'city', '116.122523', '24.288578', 2, NULL, '0753', '514021', 'Meizhou', 'M', NULL);
INSERT INTO `ez_area` VALUES (441402, '梅江区', 441400, '116.116695,24.31049', 'district', '116.116695', '24.31049', 3, NULL, '0753', '514000', 'Meijiang', 'M', NULL);
INSERT INTO `ez_area` VALUES (441403, '梅县区', 441400, '116.081656,24.265926', 'district', '116.081656', '24.265926', 3, NULL, '0753', '514787', 'Meixian', 'M', NULL);
INSERT INTO `ez_area` VALUES (441422, '大埔县', 441400, '116.695195,24.347782', 'district', '116.695195', '24.347782', 3, NULL, '0753', '514200', 'Dabu', 'D', NULL);
INSERT INTO `ez_area` VALUES (441423, '丰顺县', 441400, '116.181691,23.739343', 'district', '116.181691', '23.739343', 3, NULL, '0753', '514300', 'Fengshun', 'F', NULL);
INSERT INTO `ez_area` VALUES (441424, '五华县', 441400, '115.775788,23.932409', 'district', '115.775788', '23.932409', 3, NULL, '0753', '514400', 'Wuhua', 'W', NULL);
INSERT INTO `ez_area` VALUES (441426, '平远县', 441400, '115.891638,24.567261', 'district', '115.891638', '24.567261', 3, NULL, '0753', '514600', 'Pingyuan', 'P', NULL);
INSERT INTO `ez_area` VALUES (441427, '蕉岭县', 441400, '116.171355,24.658699', 'district', '116.171355', '24.658699', 3, NULL, '0753', '514100', 'Jiaoling', 'J', NULL);
INSERT INTO `ez_area` VALUES (441481, '兴宁市', 441400, '115.731167,24.136708', 'district', '115.731167', '24.136708', 3, NULL, '0753', '514500', 'Xingning', 'X', NULL);
INSERT INTO `ez_area` VALUES (441500, '汕尾市', 440000, '115.375431,22.78705', 'city', '115.375431', '22.78705', 2, NULL, '0660', '516600', 'Shanwei', 'S', NULL);
INSERT INTO `ez_area` VALUES (441502, '城区', 441500, '115.365058,22.779207', 'district', '115.365058', '22.779207', 3, NULL, '0660', '516600', 'Chengqu', 'C', NULL);
INSERT INTO `ez_area` VALUES (441521, '海丰县', 441500, '115.323436,22.966585', 'district', '115.323436', '22.966585', 3, NULL, '0660', '516400', 'Haifeng', 'H', NULL);
INSERT INTO `ez_area` VALUES (441523, '陆河县', 441500, '115.660143,23.301616', 'district', '115.660143', '23.301616', 3, NULL, '0660', '516700', 'Luhe', 'L', NULL);
INSERT INTO `ez_area` VALUES (441581, '陆丰市', 441500, '115.652151,22.919228', 'district', '115.652151', '22.919228', 3, NULL, '0660', '516500', 'Lufeng', 'L', NULL);
INSERT INTO `ez_area` VALUES (441600, '河源市', 440000, '114.700961,23.743686', 'city', '114.700961', '23.743686', 2, NULL, '0762', '517000', 'Heyuan', 'H', NULL);
INSERT INTO `ez_area` VALUES (441602, '源城区', 441600, '114.702517,23.733969', 'district', '114.702517', '23.733969', 3, NULL, '0762', '517000', 'Yuancheng', 'Y', NULL);
INSERT INTO `ez_area` VALUES (441621, '紫金县', 441600, '115.184107,23.635745', 'district', '115.184107', '23.635745', 3, NULL, '0762', '517400', 'Zijin', 'Z', NULL);
INSERT INTO `ez_area` VALUES (441622, '龙川县', 441600, '115.259871,24.100066', 'district', '115.259871', '24.100066', 3, NULL, '0762', '517300', 'Longchuan', 'L', NULL);
INSERT INTO `ez_area` VALUES (441623, '连平县', 441600, '114.488556,24.369583', 'district', '114.488556', '24.369583', 3, NULL, '0762', '517100', 'Lianping', 'L', NULL);
INSERT INTO `ez_area` VALUES (441624, '和平县', 441600, '114.938684,24.44218', 'district', '114.938684', '24.44218', 3, NULL, '0762', '517200', 'Heping', 'H', NULL);
INSERT INTO `ez_area` VALUES (441625, '东源县', 441600, '114.746344,23.788189', 'district', '114.746344', '23.788189', 3, NULL, '0762', '517583', 'Dongyuan', 'D', NULL);
INSERT INTO `ez_area` VALUES (441700, '阳江市', 440000, '111.982589,21.857887', 'city', '111.982589', '21.857887', 2, NULL, '0662', '529500', 'Yangjiang', 'Y', NULL);
INSERT INTO `ez_area` VALUES (441702, '江城区', 441700, '111.955058,21.861786', 'district', '111.955058', '21.861786', 3, NULL, '0662', '529500', 'Jiangcheng', 'J', NULL);
INSERT INTO `ez_area` VALUES (441704, '阳东区', 441700, '112.006363,21.868337', 'district', '112.006363', '21.868337', 3, NULL, '0662', '529900', 'Yangdong', 'Y', NULL);
INSERT INTO `ez_area` VALUES (441721, '阳西县', 441700, '111.61766,21.752771', 'district', '111.61766', '21.752771', 3, NULL, '0662', '529800', 'Yangxi', 'Y', NULL);
INSERT INTO `ez_area` VALUES (441781, '阳春市', 441700, '111.791587,22.17041', 'district', '111.791587', '22.17041', 3, NULL, '0662', '529600', 'Yangchun', 'Y', NULL);
INSERT INTO `ez_area` VALUES (441800, '清远市', 440000, '113.056042,23.681774', 'city', '113.056042', '23.681774', 2, NULL, '0763', '511500', 'Qingyuan', 'Q', NULL);
INSERT INTO `ez_area` VALUES (441802, '清城区', 441800, '113.062692,23.697899', 'district', '113.062692', '23.697899', 3, NULL, '0763', '511515', 'Qingcheng', 'Q', NULL);
INSERT INTO `ez_area` VALUES (441803, '清新区', 441800, '113.017747,23.734677', 'district', '113.017747', '23.734677', 3, NULL, '0763', '511810', 'Qingxin', 'Q', NULL);
INSERT INTO `ez_area` VALUES (441821, '佛冈县', 441800, '113.531607,23.879192', 'district', '113.531607', '23.879192', 3, NULL, '0763', '511600', 'Fogang', 'F', NULL);
INSERT INTO `ez_area` VALUES (441823, '阳山县', 441800, '112.641363,24.465359', 'district', '112.641363', '24.465359', 3, NULL, '0763', '513100', 'Yangshan', 'Y', NULL);
INSERT INTO `ez_area` VALUES (441825, '连山壮族瑶族自治县', 441800, '112.093617,24.570491', 'district', '112.093617', '24.570491', 3, NULL, '0763', '513200', 'Lianshan', 'L', NULL);
INSERT INTO `ez_area` VALUES (441826, '连南瑶族自治县', 441800, '112.287012,24.726017', 'district', '112.287012', '24.726017', 3, NULL, '0763', '513300', 'Liannan', 'L', NULL);
INSERT INTO `ez_area` VALUES (441881, '英德市', 441800, '113.401701,24.206986', 'district', '113.401701', '24.206986', 3, NULL, '0763', '513000', 'Yingde', 'Y', NULL);
INSERT INTO `ez_area` VALUES (441882, '连州市', 441800, '112.377361,24.780966', 'district', '112.377361', '24.780966', 3, NULL, '0763', '513400', 'Lianzhou', 'L', NULL);
INSERT INTO `ez_area` VALUES (441900, '东莞市', 440000, '113.751799,23.020673', 'city', '113.751799', '23.020673', 2, NULL, '0769', '523888', 'Dongguan', 'D', NULL);
INSERT INTO `ez_area` VALUES (442000, '中山市', 440000, '113.39277,22.517585', 'city', '113.39277', '22.517585', 2, NULL, '0760', '528403', 'Zhongshan', 'Z', NULL);
INSERT INTO `ez_area` VALUES (442100, '东沙群岛', 440000, '116.887613,20.617825', 'city', '116.887613', '20.617825', 2, NULL, NULL, NULL, 'Dongsha Islands', 'D', NULL);
INSERT INTO `ez_area` VALUES (445100, '潮州市', 440000, '116.622444,23.657262', 'city', '116.622444', '23.657262', 2, NULL, '0768', '521000', 'Chaozhou', 'C', NULL);
INSERT INTO `ez_area` VALUES (445102, '湘桥区', 445100, '116.628627,23.674387', 'district', '116.628627', '23.674387', 3, NULL, '0768', '521000', 'Xiangqiao', 'X', NULL);
INSERT INTO `ez_area` VALUES (445103, '潮安区', 445100, '116.678203,23.462613', 'district', '116.678203', '23.462613', 3, NULL, '0768', '515638', 'Chao\'an', 'C', NULL);
INSERT INTO `ez_area` VALUES (445122, '饶平县', 445100, '117.0039,23.663824', 'district', '117.0039', '23.663824', 3, NULL, '0768', '515700', 'Raoping', 'R', NULL);
INSERT INTO `ez_area` VALUES (445200, '揭阳市', 440000, '116.372708,23.549701', 'city', '116.372708', '23.549701', 2, NULL, '0633', '522000', 'Jieyang', 'J', NULL);
INSERT INTO `ez_area` VALUES (445202, '榕城区', 445200, '116.367012,23.525382', 'district', '116.367012', '23.525382', 3, NULL, '0633', '522000', 'Rongcheng', 'R', NULL);
INSERT INTO `ez_area` VALUES (445203, '揭东区', 445200, '116.412015,23.566126', 'district', '116.412015', '23.566126', 3, NULL, '0633', '515500', 'Jiedong', 'J', NULL);
INSERT INTO `ez_area` VALUES (445222, '揭西县', 445200, '115.841837,23.431294', 'district', '115.841837', '23.431294', 3, NULL, '0633', '515400', 'Jiexi', 'J', NULL);
INSERT INTO `ez_area` VALUES (445224, '惠来县', 445200, '116.29515,23.033266', 'district', '116.29515', '23.033266', 3, NULL, '0633', '515200', 'Huilai', 'H', NULL);
INSERT INTO `ez_area` VALUES (445281, '普宁市', 445200, '116.165777,23.297493', 'district', '116.165777', '23.297493', 3, NULL, '0633', '515300', 'Puning', 'P', NULL);
INSERT INTO `ez_area` VALUES (445300, '云浮市', 440000, '112.044491,22.915094', 'city', '112.044491', '22.915094', 2, NULL, '0766', '527300', 'Yunfu', 'Y', NULL);
INSERT INTO `ez_area` VALUES (445302, '云城区', 445300, '112.043945,22.92815', 'district', '112.043945', '22.92815', 3, NULL, '0766', '527300', 'Yuncheng', 'Y', NULL);
INSERT INTO `ez_area` VALUES (445303, '云安区', 445300, '112.003208,23.071019', 'district', '112.003208', '23.071019', 3, NULL, '0766', '527500', 'Yun\'an', 'Y', NULL);
INSERT INTO `ez_area` VALUES (445321, '新兴县', 445300, '112.225334,22.69569', 'district', '112.225334', '22.69569', 3, NULL, '0766', '527400', 'Xinxing', 'X', NULL);
INSERT INTO `ez_area` VALUES (445322, '郁南县', 445300, '111.535285,23.23456', 'district', '111.535285', '23.23456', 3, NULL, '0766', '527100', 'Yunan', 'Y', NULL);
INSERT INTO `ez_area` VALUES (445381, '罗定市', 445300, '111.569892,22.768285', 'district', '111.569892', '22.768285', 3, NULL, '0766', '527200', 'Luoding', 'L', NULL);
INSERT INTO `ez_area` VALUES (450000, '广西壮族自治区', 0, '108.327546,22.815478', 'province', '108.327546', '22.815478', 1, NULL, NULL, NULL, 'Guangxi', 'G', NULL);
INSERT INTO `ez_area` VALUES (450100, '南宁市', 450000, '108.366543,22.817002', 'city', '108.366543', '22.817002', 2, NULL, '0771', '530028', 'Nanning', 'N', NULL);
INSERT INTO `ez_area` VALUES (450102, '兴宁区', 450100, '108.368871,22.854021', 'district', '108.368871', '22.854021', 3, NULL, '0771', '530023', 'Xingning', 'X', NULL);
INSERT INTO `ez_area` VALUES (450103, '青秀区', 450100, '108.494024,22.785879', 'district', '108.494024', '22.785879', 3, NULL, '0771', '530213', 'Qingxiu', 'Q', NULL);
INSERT INTO `ez_area` VALUES (450105, '江南区', 450100, '108.273133,22.78136', 'district', '108.273133', '22.78136', 3, NULL, '0771', '530031', 'Jiangnan', 'J', NULL);
INSERT INTO `ez_area` VALUES (450107, '西乡塘区', 450100, '108.313494,22.833928', 'district', '108.313494', '22.833928', 3, NULL, '0771', '530001', 'Xixiangtang', 'X', NULL);
INSERT INTO `ez_area` VALUES (450108, '良庆区', 450100, '108.39301,22.752997', 'district', '108.39301', '22.752997', 3, NULL, '0771', '530219', 'Liangqing', 'L', NULL);
INSERT INTO `ez_area` VALUES (450109, '邕宁区', 450100, '108.487368,22.75839', 'district', '108.487368', '22.75839', 3, NULL, '0771', '530200', 'Yongning', 'Y', NULL);
INSERT INTO `ez_area` VALUES (450110, '武鸣区', 450100, '108.27467,23.158595', 'district', '108.27467', '23.158595', 3, NULL, '0771', '530100', 'Wuming', 'W', NULL);
INSERT INTO `ez_area` VALUES (450123, '隆安县', 450100, '107.696153,23.166028', 'district', '107.696153', '23.166028', 3, NULL, '0771', '532700', 'Long\'an', 'L', NULL);
INSERT INTO `ez_area` VALUES (450124, '马山县', 450100, '108.177019,23.708321', 'district', '108.177019', '23.708321', 3, NULL, '0771', '530600', 'Mashan', 'M', NULL);
INSERT INTO `ez_area` VALUES (450125, '上林县', 450100, '108.602846,23.431908', 'district', '108.602846', '23.431908', 3, NULL, '0771', '530500', 'Shanglin', 'S', NULL);
INSERT INTO `ez_area` VALUES (450126, '宾阳县', 450100, '108.810326,23.217786', 'district', '108.810326', '23.217786', 3, NULL, '0771', '530400', 'Binyang', 'B', NULL);
INSERT INTO `ez_area` VALUES (450127, '横县', 450100, '109.261384,22.679931', 'district', '109.261384', '22.679931', 3, NULL, '0771', '530300', 'Hengxian', 'H', NULL);
INSERT INTO `ez_area` VALUES (450200, '柳州市', 450000, '109.428608,24.326291', 'city', '109.428608', '24.326291', 2, NULL, '0772', '545001', 'Liuzhou', 'L', NULL);
INSERT INTO `ez_area` VALUES (450202, '城中区', 450200, '109.4273,24.366', 'district', '109.4273', '24.366', 3, NULL, '0772', '545001', 'Chengzhong', 'C', NULL);
INSERT INTO `ez_area` VALUES (450203, '鱼峰区', 450200, '109.452442,24.318516', 'district', '109.452442', '24.318516', 3, NULL, '0772', '545005', 'Yufeng', 'Y', NULL);
INSERT INTO `ez_area` VALUES (450204, '柳南区', 450200, '109.385518,24.336229', 'district', '109.385518', '24.336229', 3, NULL, '0772', '545007', 'Liunan', 'L', NULL);
INSERT INTO `ez_area` VALUES (450205, '柳北区', 450200, '109.402049,24.362691', 'district', '109.402049', '24.362691', 3, NULL, '0772', '545002', 'Liubei', 'L', NULL);
INSERT INTO `ez_area` VALUES (450206, '柳江区', 450200, '109.32638,24.254891', 'district', '109.32638', '24.254891', 3, NULL, '0772', '545100', 'Liujiang', 'L', NULL);
INSERT INTO `ez_area` VALUES (450222, '柳城县', 450200, '109.24473,24.651518', 'district', '109.24473', '24.651518', 3, NULL, '0772', '545200', 'Liucheng', 'L', NULL);
INSERT INTO `ez_area` VALUES (450223, '鹿寨县', 450200, '109.750638,24.472897', 'district', '109.750638', '24.472897', 3, NULL, '0772', '545600', 'Luzhai', 'L', NULL);
INSERT INTO `ez_area` VALUES (450224, '融安县', 450200, '109.397538,25.224549', 'district', '109.397538', '25.224549', 3, NULL, '0772', '545400', 'Rong\'an', 'R', NULL);
INSERT INTO `ez_area` VALUES (450225, '融水苗族自治县', 450200, '109.256334,25.065934', 'district', '109.256334', '25.065934', 3, NULL, '0772', '545300', 'Rongshui', 'R', NULL);
INSERT INTO `ez_area` VALUES (450226, '三江侗族自治县', 450200, '109.607675,25.783198', 'district', '109.607675', '25.783198', 3, NULL, '0772', '545500', 'Sanjiang', 'S', NULL);
INSERT INTO `ez_area` VALUES (450300, '桂林市', 450000, '110.179953,25.234479', 'city', '110.179953', '25.234479', 2, NULL, '0773', '541100', 'Guilin', 'G', NULL);
INSERT INTO `ez_area` VALUES (450302, '秀峰区', 450300, '110.264183,25.273625', 'district', '110.264183', '25.273625', 3, NULL, '0773', '541001', 'Xiufeng', 'X', NULL);
INSERT INTO `ez_area` VALUES (450303, '叠彩区', 450300, '110.301723,25.314', 'district', '110.301723', '25.314', 3, NULL, '0773', '541001', 'Diecai', 'D', NULL);
INSERT INTO `ez_area` VALUES (450304, '象山区', 450300, '110.281082,25.261686', 'district', '110.281082', '25.261686', 3, NULL, '0773', '541002', 'Xiangshan', 'X', NULL);
INSERT INTO `ez_area` VALUES (450305, '七星区', 450300, '110.317826,25.252701', 'district', '110.317826', '25.252701', 3, NULL, '0773', '541004', 'Qixing', 'Q', NULL);
INSERT INTO `ez_area` VALUES (450311, '雁山区', 450300, '110.28669,25.101934', 'district', '110.28669', '25.101934', 3, NULL, '0773', '541006', 'Yanshan', 'Y', NULL);
INSERT INTO `ez_area` VALUES (450312, '临桂区', 450300, '110.212463,25.238628', 'district', '110.212463', '25.238628', 3, NULL, '0773', '541100', 'Lingui', 'L', NULL);
INSERT INTO `ez_area` VALUES (450321, '阳朔县', 450300, '110.496593,24.77848', 'district', '110.496593', '24.77848', 3, NULL, '0773', '541900', 'Yangshuo', 'Y', NULL);
INSERT INTO `ez_area` VALUES (450323, '灵川县', 450300, '110.319897,25.394781', 'district', '110.319897', '25.394781', 3, NULL, '0773', '541200', 'Lingchuan', 'L', NULL);
INSERT INTO `ez_area` VALUES (450324, '全州县', 450300, '111.072946,25.928387', 'district', '111.072946', '25.928387', 3, NULL, '0773', '541503', 'Quanzhou', 'Q', NULL);
INSERT INTO `ez_area` VALUES (450325, '兴安县', 450300, '110.67167,25.611704', 'district', '110.67167', '25.611704', 3, NULL, '0773', '541300', 'Xing\'an', 'X', NULL);
INSERT INTO `ez_area` VALUES (450326, '永福县', 450300, '109.983076,24.979855', 'district', '109.983076', '24.979855', 3, NULL, '0773', '541800', 'Yongfu', 'Y', NULL);
INSERT INTO `ez_area` VALUES (450327, '灌阳县', 450300, '111.160851,25.489383', 'district', '111.160851', '25.489383', 3, NULL, '0773', '541600', 'Guanyang', 'G', NULL);
INSERT INTO `ez_area` VALUES (450328, '龙胜各族自治县', 450300, '110.011238,25.797931', 'district', '110.011238', '25.797931', 3, NULL, '0773', '541700', 'Longsheng', 'L', NULL);
INSERT INTO `ez_area` VALUES (450329, '资源县', 450300, '110.6527,26.042443', 'district', '110.6527', '26.042443', 3, NULL, '0773', '541400', 'Ziyuan', 'Z', NULL);
INSERT INTO `ez_area` VALUES (450330, '平乐县', 450300, '110.643305,24.633362', 'district', '110.643305', '24.633362', 3, NULL, '0773', '542400', 'Pingle', 'P', NULL);
INSERT INTO `ez_area` VALUES (450331, '荔浦县', 450300, '110.395104,24.488342', 'district', '110.395104', '24.488342', 3, NULL, '0773', '546600', 'Lipu', 'L', NULL);
INSERT INTO `ez_area` VALUES (450332, '恭城瑶族自治县', 450300, '110.828409,24.831682', 'district', '110.828409', '24.831682', 3, NULL, '0773', '542500', 'Gongcheng', 'G', NULL);
INSERT INTO `ez_area` VALUES (450400, '梧州市', 450000, '111.279115,23.476962', 'city', '111.279115', '23.476962', 2, NULL, '0774', '543002', 'Wuzhou', 'W', NULL);
INSERT INTO `ez_area` VALUES (450403, '万秀区', 450400, '111.320518,23.472991', 'district', '111.320518', '23.472991', 3, NULL, '0774', '543000', 'Wanxiu', 'W', NULL);
INSERT INTO `ez_area` VALUES (450405, '长洲区', 450400, '111.274673,23.485944', 'district', '111.274673', '23.485944', 3, NULL, '0774', '543003', 'Changzhou', 'C', NULL);
INSERT INTO `ez_area` VALUES (450406, '龙圩区', 450400, '111.246606,23.404772', 'district', '111.246606', '23.404772', 3, NULL, '0774', '543002', 'Longxu', 'L', NULL);
INSERT INTO `ez_area` VALUES (450421, '苍梧县', 450400, '111.544007,23.845097', 'district', '111.544007', '23.845097', 3, NULL, '0774', '543100', 'Cangwu', 'C', NULL);
INSERT INTO `ez_area` VALUES (450422, '藤县', 450400, '110.914849,23.374983', 'district', '110.914849', '23.374983', 3, NULL, '0774', '543300', 'Tengxian', 'T', NULL);
INSERT INTO `ez_area` VALUES (450423, '蒙山县', 450400, '110.525003,24.19357', 'district', '110.525003', '24.19357', 3, NULL, '0774', '546700', 'Mengshan', 'M', NULL);
INSERT INTO `ez_area` VALUES (450481, '岑溪市', 450400, '110.994913,22.91835', 'district', '110.994913', '22.91835', 3, NULL, '0774', '543200', 'Cenxi', 'C', NULL);
INSERT INTO `ez_area` VALUES (450500, '北海市', 450000, '109.120161,21.481291', 'city', '109.120161', '21.481291', 2, NULL, '0779', '536000', 'Beihai', 'B', NULL);
INSERT INTO `ez_area` VALUES (450502, '海城区', 450500, '109.117209,21.475004', 'district', '109.117209', '21.475004', 3, NULL, '0779', '536000', 'Haicheng', 'H', NULL);
INSERT INTO `ez_area` VALUES (450503, '银海区', 450500, '109.139862,21.449308', 'district', '109.139862', '21.449308', 3, NULL, '0779', '536000', 'Yinhai', 'Y', NULL);
INSERT INTO `ez_area` VALUES (450512, '铁山港区', 450500, '109.42158,21.529127', 'district', '109.42158', '21.529127', 3, NULL, '0779', '536017', 'Tieshangang', 'T', NULL);
INSERT INTO `ez_area` VALUES (450521, '合浦县', 450500, '109.207335,21.660935', 'district', '109.207335', '21.660935', 3, NULL, '0779', '536100', 'Hepu', 'H', NULL);
INSERT INTO `ez_area` VALUES (450600, '防城港市', 450000, '108.353846,21.68686', 'city', '108.353846', '21.68686', 2, NULL, '0770', '538001', 'Fangchenggang', 'F', NULL);
INSERT INTO `ez_area` VALUES (450602, '港口区', 450600, '108.380143,21.643383', 'district', '108.380143', '21.643383', 3, NULL, '0770', '538001', 'Gangkou', 'G', NULL);
INSERT INTO `ez_area` VALUES (450603, '防城区', 450600, '108.353499,21.769211', 'district', '108.353499', '21.769211', 3, NULL, '0770', '538021', 'Fangcheng', 'F', NULL);
INSERT INTO `ez_area` VALUES (450621, '上思县', 450600, '107.983627,22.153671', 'district', '107.983627', '22.153671', 3, NULL, '0770', '535500', 'Shangsi', 'S', NULL);
INSERT INTO `ez_area` VALUES (450681, '东兴市', 450600, '107.971828,21.547821', 'district', '107.971828', '21.547821', 3, NULL, '0770', '538100', 'Dongxing', 'D', NULL);
INSERT INTO `ez_area` VALUES (450700, '钦州市', 450000, '108.654146,21.979933', 'city', '108.654146', '21.979933', 2, NULL, '0777', '535099', 'Qinzhou', 'Q', NULL);
INSERT INTO `ez_area` VALUES (450702, '钦南区', 450700, '108.657209,21.938859', 'district', '108.657209', '21.938859', 3, NULL, '0777', '535099', 'Qinnan', 'Q', NULL);
INSERT INTO `ez_area` VALUES (450703, '钦北区', 450700, '108.44911,22.132761', 'district', '108.44911', '22.132761', 3, NULL, '0777', '535099', 'Qinbei', 'Q', NULL);
INSERT INTO `ez_area` VALUES (450721, '灵山县', 450700, '109.291006,22.416536', 'district', '109.291006', '22.416536', 3, NULL, '0777', '535099', 'Lingshan', 'L', NULL);
INSERT INTO `ez_area` VALUES (450722, '浦北县', 450700, '109.556953,22.271651', 'district', '109.556953', '22.271651', 3, NULL, '0777', '535099', 'Pubei', 'P', NULL);
INSERT INTO `ez_area` VALUES (450800, '贵港市', 450000, '109.598926,23.11153', 'city', '109.598926', '23.11153', 2, NULL, '0775', '537100', 'Guigang', 'G', NULL);
INSERT INTO `ez_area` VALUES (450802, '港北区', 450800, '109.57224,23.11153', 'district', '109.57224', '23.11153', 3, NULL, '0775', '537100', 'Gangbei', 'G', NULL);
INSERT INTO `ez_area` VALUES (450803, '港南区', 450800, '109.599556,23.075573', 'district', '109.599556', '23.075573', 3, NULL, '0775', '537100', 'Gangnan', 'G', NULL);
INSERT INTO `ez_area` VALUES (450804, '覃塘区', 450800, '109.452662,23.127149', 'district', '109.452662', '23.127149', 3, NULL, '0775', '537121', 'Qintang', 'Q', NULL);
INSERT INTO `ez_area` VALUES (450821, '平南县', 450800, '110.392311,23.539264', 'district', '110.392311', '23.539264', 3, NULL, '0775', '537300', 'Pingnan', 'P', NULL);
INSERT INTO `ez_area` VALUES (450881, '桂平市', 450800, '110.079379,23.394325', 'district', '110.079379', '23.394325', 3, NULL, '0775', '537200', 'Guiping', 'G', NULL);
INSERT INTO `ez_area` VALUES (450900, '玉林市', 450000, '110.18122,22.654032', 'city', '110.18122', '22.654032', 2, NULL, '0775', '537000', 'Yulin', 'Y', NULL);
INSERT INTO `ez_area` VALUES (450902, '玉州区', 450900, '110.151153,22.628087', 'district', '110.151153', '22.628087', 3, NULL, '0775', '537000', 'Yuzhou', 'Y', NULL);
INSERT INTO `ez_area` VALUES (450903, '福绵区', 450900, '110.059439,22.585556', 'district', '110.059439', '22.585556', 3, NULL, '0775', '537023', 'Fumian', 'F', NULL);
INSERT INTO `ez_area` VALUES (450921, '容县', 450900, '110.558074,22.857839', 'district', '110.558074', '22.857839', 3, NULL, '0775', '537500', 'Rongxian', 'R', NULL);
INSERT INTO `ez_area` VALUES (450922, '陆川县', 450900, '110.264052,22.321048', 'district', '110.264052', '22.321048', 3, NULL, '0775', '537700', 'Luchuan', 'L', NULL);
INSERT INTO `ez_area` VALUES (450923, '博白县', 450900, '109.975985,22.273048', 'district', '109.975985', '22.273048', 3, NULL, '0775', '537600', 'Bobai', 'B', NULL);
INSERT INTO `ez_area` VALUES (450924, '兴业县', 450900, '109.875304,22.736421', 'district', '109.875304', '22.736421', 3, NULL, '0775', '537800', 'Xingye', 'X', NULL);
INSERT INTO `ez_area` VALUES (450981, '北流市', 450900, '110.354214,22.70831', 'district', '110.354214', '22.70831', 3, NULL, '0775', '537400', 'Beiliu', 'B', NULL);
INSERT INTO `ez_area` VALUES (451000, '百色市', 450000, '106.618202,23.90233', 'city', '106.618202', '23.90233', 2, NULL, '0776', '533000', 'Baise', 'B', NULL);
INSERT INTO `ez_area` VALUES (451002, '右江区', 451000, '106.618225,23.90097', 'district', '106.618225', '23.90097', 3, NULL, '0776', '533000', 'Youjiang', 'Y', NULL);
INSERT INTO `ez_area` VALUES (451021, '田阳县', 451000, '106.915496,23.735692', 'district', '106.915496', '23.735692', 3, NULL, '0776', '533600', 'Tianyang', 'T', NULL);
INSERT INTO `ez_area` VALUES (451022, '田东县', 451000, '107.12608,23.597194', 'district', '107.12608', '23.597194', 3, NULL, '0776', '531500', 'Tiandong', 'T', NULL);
INSERT INTO `ez_area` VALUES (451023, '平果县', 451000, '107.589809,23.329376', 'district', '107.589809', '23.329376', 3, NULL, '0776', '531400', 'Pingguo', 'P', NULL);
INSERT INTO `ez_area` VALUES (451024, '德保县', 451000, '106.615373,23.32345', 'district', '106.615373', '23.32345', 3, NULL, '0776', '533700', 'Debao', 'D', NULL);
INSERT INTO `ez_area` VALUES (451026, '那坡县', 451000, '105.83253,23.387441', 'district', '105.83253', '23.387441', 3, NULL, '0776', '533900', 'Napo', 'N', NULL);
INSERT INTO `ez_area` VALUES (451027, '凌云县', 451000, '106.56131,24.347557', 'district', '106.56131', '24.347557', 3, NULL, '0776', '533100', 'Lingyun', 'L', NULL);
INSERT INTO `ez_area` VALUES (451028, '乐业县', 451000, '106.556519,24.776827', 'district', '106.556519', '24.776827', 3, NULL, '0776', '533200', 'Leye', 'L', NULL);
INSERT INTO `ez_area` VALUES (451029, '田林县', 451000, '106.228538,24.294487', 'district', '106.228538', '24.294487', 3, NULL, '0776', '533300', 'Tianlin', 'T', NULL);
INSERT INTO `ez_area` VALUES (451030, '西林县', 451000, '105.093825,24.489823', 'district', '105.093825', '24.489823', 3, NULL, '0776', '533500', 'Xilin', 'X', NULL);
INSERT INTO `ez_area` VALUES (451031, '隆林各族自治县', 451000, '105.34404,24.770896', 'district', '105.34404', '24.770896', 3, NULL, '0776', '533400', 'Longlin', 'L', NULL);
INSERT INTO `ez_area` VALUES (451081, '靖西市', 451000, '106.417805,23.134117', 'district', '106.417805', '23.134117', 3, NULL, '0776', '533800', 'Jingxi', 'J', NULL);
INSERT INTO `ez_area` VALUES (451100, '贺州市', 450000, '111.566871,24.403528', 'city', '111.566871', '24.403528', 2, NULL, '0774', '542800', 'Hezhou', 'H', NULL);
INSERT INTO `ez_area` VALUES (451102, '八步区', 451100, '111.552095,24.411805', 'district', '111.552095', '24.411805', 3, NULL, '0774', '542800', 'Babu', 'B', NULL);
INSERT INTO `ez_area` VALUES (451103, '平桂区', 451100, '111.479923,24.453845', 'district', '111.479923', '24.453845', 3, NULL, '0774', '542800', 'Pingui', 'P', NULL);
INSERT INTO `ez_area` VALUES (451121, '昭平县', 451100, '110.811325,24.169385', 'district', '110.811325', '24.169385', 3, NULL, '0774', '546800', 'Zhaoping', 'Z', NULL);
INSERT INTO `ez_area` VALUES (451122, '钟山县', 451100, '111.303009,24.525957', 'district', '111.303009', '24.525957', 3, NULL, '0774', '542600', 'Zhongshan', 'Z', NULL);
INSERT INTO `ez_area` VALUES (451123, '富川瑶族自治县', 451100, '111.27745,24.814443', 'district', '111.27745', '24.814443', 3, NULL, '0774', '542700', 'Fuchuan', 'F', NULL);
INSERT INTO `ez_area` VALUES (451200, '河池市', 450000, '108.085261,24.692931', 'city', '108.085261', '24.692931', 2, NULL, '0778', '547000', 'Hechi', 'H', NULL);
INSERT INTO `ez_area` VALUES (451202, '金城江区', 451200, '108.037276,24.689703', 'district', '108.037276', '24.689703', 3, NULL, '0779', '547000', 'Jinchengjiang', 'J', NULL);
INSERT INTO `ez_area` VALUES (451203, '宜州区', 451200, '108.636414,24.485214', 'district', '108.636414', '24.485214', 3, NULL, '0780', '546300', 'Yizhou', 'Y', NULL);
INSERT INTO `ez_area` VALUES (451221, '南丹县', 451200, '107.541244,24.975631', 'district', '107.541244', '24.975631', 3, NULL, '0781', '547200', 'Nandan', 'N', NULL);
INSERT INTO `ez_area` VALUES (451222, '天峨县', 451200, '107.173802,24.999108', 'district', '107.173802', '24.999108', 3, NULL, '0782', '547300', 'Tiane', 'T', NULL);
INSERT INTO `ez_area` VALUES (451223, '凤山县', 451200, '107.04219,24.546876', 'district', '107.04219', '24.546876', 3, NULL, '0783', '547600', 'Fengshan', 'F', NULL);
INSERT INTO `ez_area` VALUES (451224, '东兰县', 451200, '107.374293,24.510842', 'district', '107.374293', '24.510842', 3, NULL, '0784', '547400', 'Donglan', 'D', NULL);
INSERT INTO `ez_area` VALUES (451225, '罗城仫佬族自治县', 451200, '108.904706,24.777411', 'district', '108.904706', '24.777411', 3, NULL, '0785', '546400', 'Luocheng', 'L', NULL);
INSERT INTO `ez_area` VALUES (451226, '环江毛南族自治县', 451200, '108.258028,24.825664', 'district', '108.258028', '24.825664', 3, NULL, '0786', '547100', 'Huanjiang', 'H', NULL);
INSERT INTO `ez_area` VALUES (451227, '巴马瑶族自治县', 451200, '107.258588,24.142298', 'district', '107.258588', '24.142298', 3, NULL, '0787', '547500', 'Bama', 'B', NULL);
INSERT INTO `ez_area` VALUES (451228, '都安瑶族自治县', 451200, '108.105311,23.932675', 'district', '108.105311', '23.932675', 3, NULL, '0788', '530700', 'Du\'an', 'D', NULL);
INSERT INTO `ez_area` VALUES (451229, '大化瑶族自治县', 451200, '107.998149,23.736457', 'district', '107.998149', '23.736457', 3, NULL, '0789', '530800', 'Dahua', 'D', NULL);
INSERT INTO `ez_area` VALUES (451300, '来宾市', 450000, '109.221465,23.750306', 'city', '109.221465', '23.750306', 2, NULL, '0772', '546100', 'Laibin', 'L', NULL);
INSERT INTO `ez_area` VALUES (451302, '兴宾区', 451300, '109.183333,23.72892', 'district', '109.183333', '23.72892', 3, NULL, '0772', '546100', 'Xingbin', 'X', NULL);
INSERT INTO `ez_area` VALUES (451321, '忻城县', 451300, '108.665666,24.066234', 'district', '108.665666', '24.066234', 3, NULL, '0772', '546200', 'Xincheng', 'X', NULL);
INSERT INTO `ez_area` VALUES (451322, '象州县', 451300, '109.705065,23.973793', 'district', '109.705065', '23.973793', 3, NULL, '0772', '545800', 'Xiangzhou', 'X', NULL);
INSERT INTO `ez_area` VALUES (451323, '武宣县', 451300, '109.663206,23.59411', 'district', '109.663206', '23.59411', 3, NULL, '0772', '545900', 'Wuxuan', 'W', NULL);
INSERT INTO `ez_area` VALUES (451324, '金秀瑶族自治县', 451300, '110.189462,24.130374', 'district', '110.189462', '24.130374', 3, NULL, '0772', '545799', 'Jinxiu', 'J', NULL);
INSERT INTO `ez_area` VALUES (451381, '合山市', 451300, '108.886082,23.806535', 'district', '108.886082', '23.806535', 3, NULL, '0772', '546500', 'Heshan', 'H', NULL);
INSERT INTO `ez_area` VALUES (451400, '崇左市', 450000, '107.365094,22.377253', 'city', '107.365094', '22.377253', 2, NULL, '0771', '532299', 'Chongzuo', 'C', NULL);
INSERT INTO `ez_area` VALUES (451402, '江州区', 451400, '107.353437,22.405325', 'district', '107.353437', '22.405325', 3, NULL, '0771', '532299', 'Jiangzhou', 'J', NULL);
INSERT INTO `ez_area` VALUES (451421, '扶绥县', 451400, '107.904186,22.635012', 'district', '107.904186', '22.635012', 3, NULL, '0771', '532199', 'Fusui', 'F', NULL);
INSERT INTO `ez_area` VALUES (451422, '宁明县', 451400, '107.076456,22.140192', 'district', '107.076456', '22.140192', 3, NULL, '0771', '532599', 'Ningming', 'N', NULL);
INSERT INTO `ez_area` VALUES (451423, '龙州县', 451400, '106.854482,22.342778', 'district', '106.854482', '22.342778', 3, NULL, '0771', '532499', 'Longzhou', 'L', NULL);
INSERT INTO `ez_area` VALUES (451424, '大新县', 451400, '107.200654,22.829287', 'district', '107.200654', '22.829287', 3, NULL, '0771', '532399', 'Daxin', 'D', NULL);
INSERT INTO `ez_area` VALUES (451425, '天等县', 451400, '107.143432,23.081394', 'district', '107.143432', '23.081394', 3, NULL, '0771', '532899', 'Tiandeng', 'T', NULL);
INSERT INTO `ez_area` VALUES (451481, '凭祥市', 451400, '106.766293,22.094484', 'district', '106.766293', '22.094484', 3, NULL, '0771', '532699', 'Pingxiang', 'P', NULL);
INSERT INTO `ez_area` VALUES (460000, '海南省', 0, '110.349228,20.017377', 'province', '110.349228', '20.017377', 1, NULL, NULL, NULL, 'Hainan', 'H', NULL);
INSERT INTO `ez_area` VALUES (460100, '海口市', 460000, '110.198286,20.044412', 'city', '110.198286', '20.044412', 2, NULL, '0898', '570000', 'Haikou', 'H', NULL);
INSERT INTO `ez_area` VALUES (460105, '秀英区', 460100, '110.293603,20.007494', 'district', '110.293603', '20.007494', 3, NULL, '0898', '570311', 'Xiuying', 'X', NULL);
INSERT INTO `ez_area` VALUES (460106, '龙华区', 460100, '110.328492,20.031006', 'district', '110.328492', '20.031006', 3, NULL, '0898', '570145', 'Longhua', 'L', NULL);
INSERT INTO `ez_area` VALUES (460107, '琼山区', 460100, '110.353972,20.003169', 'district', '110.353972', '20.003169', 3, NULL, '0898', '571100', 'Qiongshan', 'Q', NULL);
INSERT INTO `ez_area` VALUES (460108, '美兰区', 460100, '110.366358,20.029083', 'district', '110.366358', '20.029083', 3, NULL, '0898', '570203', 'Meilan', 'M', NULL);
INSERT INTO `ez_area` VALUES (460200, '三亚市', 460000, '109.511772,18.253135', 'city', '109.511772', '18.253135', 2, NULL, '0898', '572000', 'Sanya', 'S', NULL);
INSERT INTO `ez_area` VALUES (460202, '海棠区', 460200, '109.752569,18.400106', 'district', '109.752569', '18.400106', 3, NULL, '0898', '572000', 'Haitang', 'H', NULL);
INSERT INTO `ez_area` VALUES (460203, '吉阳区', 460200, '109.578336,18.281406', 'district', '109.578336', '18.281406', 3, NULL, '0898', '572000', 'Jiyang', 'J', NULL);
INSERT INTO `ez_area` VALUES (460204, '天涯区', 460200, '109.452378,18.298156', 'district', '109.452378', '18.298156', 3, NULL, '0898', '572000', 'Tianya', 'T', NULL);
INSERT INTO `ez_area` VALUES (460205, '崖州区', 460200, '109.171841,18.357291', 'district', '109.171841', '18.357291', 3, NULL, '0898', '572000', 'Yazhou', 'Y', NULL);
INSERT INTO `ez_area` VALUES (460300, '三沙市', 460000, '112.338695,16.831839', 'city', '112.338695', '16.831839', 2, NULL, '0898', '573199', 'Sansha', 'S', NULL);
INSERT INTO `ez_area` VALUES (460321, '西沙群岛', 460300, '111.792944,16.204546', 'district', '111.792944', '16.204546', 3, NULL, '0898', '572000', 'Xisha Islands', 'X', NULL);
INSERT INTO `ez_area` VALUES (460322, '南沙群岛', 460300, '116.749997,11.471888', 'district', '116.749997', '11.471888', 3, NULL, '0898', '573100', 'Nansha Islands', 'N', NULL);
INSERT INTO `ez_area` VALUES (460323, '中沙群岛的岛礁及其海域', 460300, '117.740071,15.112855', 'district', '117.740071', '15.112855', 3, NULL, '0898', '573100', 'Zhongsha Islands', 'Z', NULL);
INSERT INTO `ez_area` VALUES (460400, '儋州市', 460000, '109.580811,19.521134', 'city', '109.580811', '19.521134', 2, NULL, '0898', '571700', 'Danzhou', 'D', NULL);
INSERT INTO `ez_area` VALUES (469001, '五指山市', 460000, '109.516925,18.775146', 'city', '109.516925', '18.775146', 2, NULL, '0898', '572200', 'Wuzhishan', 'W', NULL);
INSERT INTO `ez_area` VALUES (469002, '琼海市', 460000, '110.474497,19.259134', 'city', '110.474497', '19.259134', 2, NULL, '0898', '571400', 'Qionghai', 'Q', NULL);
INSERT INTO `ez_area` VALUES (469005, '文昌市', 460000, '110.797717,19.543422', 'city', '110.797717', '19.543422', 2, NULL, '0898', '571339', 'Wenchang', 'W', NULL);
INSERT INTO `ez_area` VALUES (469006, '万宁市', 460000, '110.391073,18.795143', 'city', '110.391073', '18.795143', 2, NULL, '0898', '571500', 'Wanning', 'W', NULL);
INSERT INTO `ez_area` VALUES (469007, '东方市', 460000, '108.651815,19.095351', 'city', '108.651815', '19.095351', 2, NULL, '0898', '572600', 'Dongfang', 'D', NULL);
INSERT INTO `ez_area` VALUES (469021, '定安县', 460000, '110.359339,19.681404', 'city', '110.359339', '19.681404', 2, NULL, '0898', '571200', 'Ding\'an', 'D', NULL);
INSERT INTO `ez_area` VALUES (469022, '屯昌县', 460000, '110.103415,19.351765', 'city', '110.103415', '19.351765', 2, NULL, '0898', '571600', 'Tunchang', 'T', NULL);
INSERT INTO `ez_area` VALUES (469023, '澄迈县', 460000, '110.006754,19.738521', 'city', '110.006754', '19.738521', 2, NULL, '0898', '571900', 'Chengmai', 'C', NULL);
INSERT INTO `ez_area` VALUES (469024, '临高县', 460000, '109.690508,19.912025', 'city', '109.690508', '19.912025', 2, NULL, '0898', '571800', 'Lingao', 'L', NULL);
INSERT INTO `ez_area` VALUES (469025, '白沙黎族自治县', 460000, '109.451484,19.224823', 'city', '109.451484', '19.224823', 2, NULL, '0898', '572800', 'Baisha', 'B', NULL);
INSERT INTO `ez_area` VALUES (469026, '昌江黎族自治县', 460000, '109.055739,19.298184', 'city', '109.055739', '19.298184', 2, NULL, '0898', '572700', 'Changjiang', 'C', NULL);
INSERT INTO `ez_area` VALUES (469027, '乐东黎族自治县', 460000, '109.173054,18.750259', 'city', '109.173054', '18.750259', 2, NULL, '0898', '572500', 'Ledong', 'L', NULL);
INSERT INTO `ez_area` VALUES (469028, '陵水黎族自治县', 460000, '110.037503,18.506048', 'city', '110.037503', '18.506048', 2, NULL, '0898', '572400', 'Lingshui', 'L', NULL);
INSERT INTO `ez_area` VALUES (469029, '保亭黎族苗族自治县', 460000, '109.70259,18.63913', 'city', '109.70259', '18.63913', 2, NULL, '0898', '572300', 'Baoting', 'B', NULL);
INSERT INTO `ez_area` VALUES (469030, '琼中黎族苗族自治县', 460000, '109.838389,19.033369', 'city', '109.838389', '19.033369', 2, NULL, '0898', '572900', 'Qiongzhong', 'Q', NULL);
INSERT INTO `ez_area` VALUES (500000, '重庆市', 0, '106.551643,29.562849', 'province', '106.551643', '29.562849', 1, NULL, NULL, NULL, 'Chongqing', 'C', NULL);
INSERT INTO `ez_area` VALUES (500100, '重庆城区', 500000, '106.551643,29.562849', 'city', '106.551643', '29.562849', 2, NULL, '023', '400000', 'Chongqing', 'C', NULL);
INSERT INTO `ez_area` VALUES (500101, '万州区', 500100, '108.408661,30.807667', 'district', '108.408661', '30.807667', 3, NULL, '023', '404000', 'Wanzhou', 'W', NULL);
INSERT INTO `ez_area` VALUES (500102, '涪陵区', 500100, '107.38977,29.703022', 'district', '107.38977', '29.703022', 3, NULL, '023', '408000', 'Fuling', 'F', NULL);
INSERT INTO `ez_area` VALUES (500103, '渝中区', 500100, '106.568896,29.552736', 'district', '106.568896', '29.552736', 3, NULL, '023', '400010', 'Yuzhong', 'Y', NULL);
INSERT INTO `ez_area` VALUES (500104, '大渡口区', 500100, '106.482346,29.484527', 'district', '106.482346', '29.484527', 3, NULL, '023', '400080', 'Dadukou', 'D', NULL);
INSERT INTO `ez_area` VALUES (500105, '江北区', 500100, '106.574271,29.606703', 'district', '106.574271', '29.606703', 3, NULL, '023', '400020', 'Jiangbei', 'J', NULL);
INSERT INTO `ez_area` VALUES (500106, '沙坪坝区', 500100, '106.456878,29.541144', 'district', '106.456878', '29.541144', 3, NULL, '023', '400030', 'Shapingba', 'S', NULL);
INSERT INTO `ez_area` VALUES (500107, '九龙坡区', 500100, '106.510676,29.502272', 'district', '106.510676', '29.502272', 3, NULL, '023', '400050', 'Jiulongpo', 'J', NULL);
INSERT INTO `ez_area` VALUES (500108, '南岸区', 500100, '106.644447,29.50126', 'district', '106.644447', '29.50126', 3, NULL, '023', '400064', 'Nan\'an', 'N', NULL);
INSERT INTO `ez_area` VALUES (500109, '北碚区', 500100, '106.395612,29.805107', 'district', '106.395612', '29.805107', 3, NULL, '023', '400700', 'Beibei', 'B', NULL);
INSERT INTO `ez_area` VALUES (500110, '綦江区', 500100, '106.651361,29.028066', 'district', '106.651361', '29.028066', 3, NULL, '023', '400800', 'Qijiang', 'Q', NULL);
INSERT INTO `ez_area` VALUES (500111, '大足区', 500100, '105.721733,29.707032', 'district', '105.721733', '29.707032', 3, NULL, '023', '400900', 'Dazu', 'D', NULL);
INSERT INTO `ez_area` VALUES (500112, '渝北区', 500100, '106.631187,29.718142', 'district', '106.631187', '29.718142', 3, NULL, '023', '401120', 'Yubei', 'Y', NULL);
INSERT INTO `ez_area` VALUES (500113, '巴南区', 500100, '106.540256,29.402408', 'district', '106.540256', '29.402408', 3, NULL, '023', '401320', 'Banan', 'B', NULL);
INSERT INTO `ez_area` VALUES (500114, '黔江区', 500100, '108.770677,29.533609', 'district', '108.770677', '29.533609', 3, NULL, '023', '409700', 'Qianjiang', 'Q', NULL);
INSERT INTO `ez_area` VALUES (500115, '长寿区', 500100, '107.080734,29.857912', 'district', '107.080734', '29.857912', 3, NULL, '023', '401220', 'Changshou', 'C', NULL);
INSERT INTO `ez_area` VALUES (500116, '江津区', 500100, '106.259281,29.290069', 'district', '106.259281', '29.290069', 3, NULL, '023', '402260', 'Jiangjin', 'J', NULL);
INSERT INTO `ez_area` VALUES (500117, '合川区', 500100, '106.27613,29.972084', 'district', '106.27613', '29.972084', 3, NULL, '023', '401520', 'Hechuan', 'H', NULL);
INSERT INTO `ez_area` VALUES (500118, '永川区', 500100, '105.927001,29.356311', 'district', '105.927001', '29.356311', 3, NULL, '023', '402160', 'Yongchuan', 'Y', NULL);
INSERT INTO `ez_area` VALUES (500119, '南川区', 500100, '107.099266,29.15789', 'district', '107.099266', '29.15789', 3, NULL, '023', '408400', 'Nanchuan', 'N', NULL);
INSERT INTO `ez_area` VALUES (500120, '璧山区', 500100, '106.227305,29.592024', 'district', '106.227305', '29.592024', 3, NULL, '023', '402760', 'Bishan', 'B', NULL);
INSERT INTO `ez_area` VALUES (500151, '铜梁区', 500100, '106.056404,29.844811', 'district', '106.056404', '29.844811', 3, NULL, '023', '402560', 'Tongliang', 'T', NULL);
INSERT INTO `ez_area` VALUES (500152, '潼南区', 500100, '105.840431,30.190992', 'district', '105.840431', '30.190992', 3, NULL, '023', '402660', 'Tongnan', 'T', NULL);
INSERT INTO `ez_area` VALUES (500153, '荣昌区', 500100, '105.594623,29.405002', 'district', '105.594623', '29.405002', 3, NULL, '023', '402460', 'Rongchang', 'R', NULL);
INSERT INTO `ez_area` VALUES (500154, '开州区', 500100, '108.393135,31.160711', 'district', '108.393135', '31.160711', 3, NULL, '023', '405400', 'Kaizhou', 'K', NULL);
INSERT INTO `ez_area` VALUES (500155, '梁平区', 500200, '107.769568,30.654233', 'district', '107.769568', '30.654233', 3, NULL, '023', '405200', 'Liangping', 'L', NULL);
INSERT INTO `ez_area` VALUES (500156, '武隆区', 500200, '107.760025,29.325601', 'district', '107.760025', '29.325601', 3, NULL, '023', '408500', 'Wulong', 'W', NULL);
INSERT INTO `ez_area` VALUES (500200, '重庆郊县', 500000, '108.165537,29.293902', 'city', '108.165537', '29.293902', 2, NULL, NULL, NULL, 'Chongqingjiaoxian', 'C', NULL);
INSERT INTO `ez_area` VALUES (500229, '城口县', 500200, '108.664214,31.947633', 'district', '108.664214', '31.947633', 3, NULL, '023', '405900', 'Chengkou', 'C', NULL);
INSERT INTO `ez_area` VALUES (500230, '丰都县', 500200, '107.730894,29.8635', 'district', '107.730894', '29.8635', 3, NULL, '023', '408200', 'Fengdu', 'F', NULL);
INSERT INTO `ez_area` VALUES (500231, '垫江县', 500200, '107.33339,30.327716', 'district', '107.33339', '30.327716', 3, NULL, '023', '408300', 'Dianjiang', 'D', NULL);
INSERT INTO `ez_area` VALUES (500233, '忠县', 500200, '108.039002,30.299559', 'district', '108.039002', '30.299559', 3, NULL, '023', '404300', 'Zhongxian', 'Z', NULL);
INSERT INTO `ez_area` VALUES (500235, '云阳县', 500200, '108.697324,30.930612', 'district', '108.697324', '30.930612', 3, NULL, '023', '404500', 'Yunyang', 'Y', NULL);
INSERT INTO `ez_area` VALUES (500236, '奉节县', 500200, '109.400403,31.018363', 'district', '109.400403', '31.018363', 3, NULL, '023', '404600', 'Fengjie', 'F', NULL);
INSERT INTO `ez_area` VALUES (500237, '巫山县', 500200, '109.879153,31.074834', 'district', '109.879153', '31.074834', 3, NULL, '023', '404700', 'Wushan', 'W', NULL);
INSERT INTO `ez_area` VALUES (500238, '巫溪县', 500200, '109.570062,31.398604', 'district', '109.570062', '31.398604', 3, NULL, '023', '405800', 'Wuxi', 'W', NULL);
INSERT INTO `ez_area` VALUES (500240, '石柱土家族自治县', 500200, '108.114069,29.999285', 'district', '108.114069', '29.999285', 3, NULL, '023', '409100', 'Shizhu', 'S', NULL);
INSERT INTO `ez_area` VALUES (500241, '秀山土家族苗族自治县', 500200, '109.007094,28.447997', 'district', '109.007094', '28.447997', 3, NULL, '023', '409900', 'Xiushan', 'X', NULL);
INSERT INTO `ez_area` VALUES (500242, '酉阳土家族苗族自治县', 500200, '108.767747,28.841244', 'district', '108.767747', '28.841244', 3, NULL, '023', '409800', 'Youyang', 'Y', NULL);
INSERT INTO `ez_area` VALUES (500243, '彭水苗族土家族自治县', 500200, '108.165537,29.293902', 'district', '108.165537', '29.293902', 3, NULL, '023', '409600', 'Pengshui', 'P', NULL);
INSERT INTO `ez_area` VALUES (510000, '四川省', 0, '104.075809,30.651239', 'province', '104.075809', '30.651239', 1, NULL, NULL, NULL, 'Sichuan', 'S', NULL);
INSERT INTO `ez_area` VALUES (510100, '成都市', 510000, '104.066794,30.572893', 'city', '104.066794', '30.572893', 2, NULL, '028', '610015', 'Chengdu', 'C', NULL);
INSERT INTO `ez_area` VALUES (510104, '锦江区', 510100, '104.117022,30.598158', 'district', '104.117022', '30.598158', 3, NULL, '028', '610021', 'Jinjiang', 'J', NULL);
INSERT INTO `ez_area` VALUES (510105, '青羊区', 510100, '104.061442,30.673914', 'district', '104.061442', '30.673914', 3, NULL, '028', '610031', 'Qingyang', 'Q', NULL);
INSERT INTO `ez_area` VALUES (510106, '金牛区', 510100, '104.052236,30.691359', 'district', '104.052236', '30.691359', 3, NULL, '028', '610036', 'Jinniu', 'J', NULL);
INSERT INTO `ez_area` VALUES (510107, '武侯区', 510100, '104.043235,30.641907', 'district', '104.043235', '30.641907', 3, NULL, '028', '610041', 'Wuhou', 'W', NULL);
INSERT INTO `ez_area` VALUES (510108, '成华区', 510100, '104.101515,30.659966', 'district', '104.101515', '30.659966', 3, NULL, '028', '610066', 'Chenghua', 'C', NULL);
INSERT INTO `ez_area` VALUES (510112, '龙泉驿区', 510100, '104.274632,30.556506', 'district', '104.274632', '30.556506', 3, NULL, '028', '610100', 'Longquanyi', 'L', NULL);
INSERT INTO `ez_area` VALUES (510113, '青白江区', 510100, '104.250945,30.878629', 'district', '104.250945', '30.878629', 3, NULL, '028', '610300', 'Qingbaijiang', 'Q', NULL);
INSERT INTO `ez_area` VALUES (510114, '新都区', 510100, '104.158705,30.823498', 'district', '104.158705', '30.823498', 3, NULL, '028', '610500', 'Xindu', 'X', NULL);
INSERT INTO `ez_area` VALUES (510115, '温江区', 510100, '103.856646,30.682203', 'district', '103.856646', '30.682203', 3, NULL, '028', '611130', 'Wenjiang', 'W', NULL);
INSERT INTO `ez_area` VALUES (510116, '双流区', 510100, '103.923566,30.574449', 'district', '103.923566', '30.574449', 3, NULL, '028', '610200', 'Shuangliu', 'S', NULL);
INSERT INTO `ez_area` VALUES (510117, '郫都区', 510100, '103.901091,30.795854', 'district', '103.901091', '30.795854', 3, NULL, '028', '611730', 'Pidu', 'P', NULL);
INSERT INTO `ez_area` VALUES (510121, '金堂县', 510100, '104.411976,30.861979', 'district', '104.411976', '30.861979', 3, NULL, '028', '610400', 'Jintang', 'J', NULL);
INSERT INTO `ez_area` VALUES (510129, '大邑县', 510100, '103.511865,30.572268', 'district', '103.511865', '30.572268', 3, NULL, '028', '611330', 'Dayi', 'D', NULL);
INSERT INTO `ez_area` VALUES (510131, '蒲江县', 510100, '103.506498,30.196788', 'district', '103.506498', '30.196788', 3, NULL, '028', '611630', 'Pujiang', 'P', NULL);
INSERT INTO `ez_area` VALUES (510132, '新津县', 510100, '103.811286,30.410346', 'district', '103.811286', '30.410346', 3, NULL, '028', '611430', 'Xinjin', 'X', NULL);
INSERT INTO `ez_area` VALUES (510181, '都江堰市', 510100, '103.647153,30.988767', 'district', '103.647153', '30.988767', 3, NULL, '028', '611830', 'Dujiangyan', 'D', NULL);
INSERT INTO `ez_area` VALUES (510182, '彭州市', 510100, '103.957983,30.990212', 'district', '103.957983', '30.990212', 3, NULL, '028', '611930', 'Pengzhou', 'P', NULL);
INSERT INTO `ez_area` VALUES (510183, '邛崃市', 510100, '103.464207,30.410324', 'district', '103.464207', '30.410324', 3, NULL, '028', '611530', 'Qionglai', 'Q', NULL);
INSERT INTO `ez_area` VALUES (510184, '崇州市', 510100, '103.673001,30.630122', 'district', '103.673001', '30.630122', 3, NULL, '028', '611230', 'Chongzhou', 'C', NULL);
INSERT INTO `ez_area` VALUES (510185, '简阳市', 510100, '104.54722,30.411264', 'district', '104.54722', '30.411264', 3, NULL, '028', '641400', 'Jianyang', 'J', NULL);
INSERT INTO `ez_area` VALUES (510300, '自贡市', 510000, '104.778442,29.33903', 'city', '104.778442', '29.33903', 2, NULL, '0813', '643000', 'Zigong', 'Z', NULL);
INSERT INTO `ez_area` VALUES (510302, '自流井区', 510300, '104.777191,29.337429', 'district', '104.777191', '29.337429', 3, NULL, '0813', '643000', 'Ziliujing', 'Z', NULL);
INSERT INTO `ez_area` VALUES (510303, '贡井区', 510300, '104.715288,29.345313', 'district', '104.715288', '29.345313', 3, NULL, '0813', '643020', 'Gongjing', 'G', NULL);
INSERT INTO `ez_area` VALUES (510304, '大安区', 510300, '104.773994,29.363702', 'district', '104.773994', '29.363702', 3, NULL, '0813', '643010', 'Da\'an', 'D', NULL);
INSERT INTO `ez_area` VALUES (510311, '沿滩区', 510300, '104.874079,29.272586', 'district', '104.874079', '29.272586', 3, NULL, '0813', '643030', 'Yantan', 'Y', NULL);
INSERT INTO `ez_area` VALUES (510321, '荣县', 510300, '104.417493,29.445479', 'district', '104.417493', '29.445479', 3, NULL, '0813', '643100', 'Rongxian', 'R', NULL);
INSERT INTO `ez_area` VALUES (510322, '富顺县', 510300, '104.975048,29.181429', 'district', '104.975048', '29.181429', 3, NULL, '0813', '643200', 'Fushun', 'F', NULL);
INSERT INTO `ez_area` VALUES (510400, '攀枝花市', 510000, '101.718637,26.582347', 'city', '101.718637', '26.582347', 2, NULL, '0812', '617000', 'Panzhihua', 'P', NULL);
INSERT INTO `ez_area` VALUES (510402, '东区', 510400, '101.704109,26.546491', 'district', '101.704109', '26.546491', 3, NULL, '0812', '617067', 'Dongqu', 'D', NULL);
INSERT INTO `ez_area` VALUES (510403, '西区', 510400, '101.630619,26.597781', 'district', '101.630619', '26.597781', 3, NULL, '0812', '617068', 'Xiqu', 'X', NULL);
INSERT INTO `ez_area` VALUES (510411, '仁和区', 510400, '101.738528,26.497765', 'district', '101.738528', '26.497765', 3, NULL, '0812', '617061', 'Renhe', 'R', NULL);
INSERT INTO `ez_area` VALUES (510421, '米易县', 510400, '102.112895,26.897694', 'district', '102.112895', '26.897694', 3, NULL, '0812', '617200', 'Miyi', 'M', NULL);
INSERT INTO `ez_area` VALUES (510422, '盐边县', 510400, '101.855071,26.683213', 'district', '101.855071', '26.683213', 3, NULL, '0812', '617100', 'Yanbian', 'Y', NULL);
INSERT INTO `ez_area` VALUES (510500, '泸州市', 510000, '105.442285,28.871805', 'city', '105.442285', '28.871805', 2, NULL, '0830', '646000', 'Luzhou', 'L', NULL);
INSERT INTO `ez_area` VALUES (510502, '江阳区', 510500, '105.434982,28.87881', 'district', '105.434982', '28.87881', 3, NULL, '0830', '646000', 'Jiangyang', 'J', NULL);
INSERT INTO `ez_area` VALUES (510503, '纳溪区', 510500, '105.371505,28.773134', 'district', '105.371505', '28.773134', 3, NULL, '0830', '646300', 'Naxi', 'N', NULL);
INSERT INTO `ez_area` VALUES (510504, '龙马潭区', 510500, '105.437751,28.913257', 'district', '105.437751', '28.913257', 3, NULL, '0830', '646000', 'Longmatan', 'L', NULL);
INSERT INTO `ez_area` VALUES (510521, '泸县', 510500, '105.381893,29.151534', 'district', '105.381893', '29.151534', 3, NULL, '0830', '646106', 'Luxian', 'L', NULL);
INSERT INTO `ez_area` VALUES (510522, '合江县', 510500, '105.830986,28.811164', 'district', '105.830986', '28.811164', 3, NULL, '0830', '646200', 'Hejiang', 'H', NULL);
INSERT INTO `ez_area` VALUES (510524, '叙永县', 510500, '105.444765,28.155801', 'district', '105.444765', '28.155801', 3, NULL, '0830', '646400', 'Xuyong', 'X', NULL);
INSERT INTO `ez_area` VALUES (510525, '古蔺县', 510500, '105.812601,28.038801', 'district', '105.812601', '28.038801', 3, NULL, '0830', '646500', 'Gulin', 'G', NULL);
INSERT INTO `ez_area` VALUES (510600, '德阳市', 510000, '104.397894,31.126855', 'city', '104.397894', '31.126855', 2, NULL, '0838', '618000', 'Deyang', 'D', NULL);
INSERT INTO `ez_area` VALUES (510603, '旌阳区', 510600, '104.416966,31.142633', 'district', '104.416966', '31.142633', 3, NULL, '0838', '618000', 'Jingyang', 'J', NULL);
INSERT INTO `ez_area` VALUES (510623, '中江县', 510600, '104.678751,31.03307', 'district', '104.678751', '31.03307', 3, NULL, '0838', '618100', 'Zhongjiang', 'Z', NULL);
INSERT INTO `ez_area` VALUES (510626, '罗江县', 510600, '104.510249,31.317045', 'district', '104.510249', '31.317045', 3, NULL, '0838', '618500', 'Luojiang', 'L', NULL);
INSERT INTO `ez_area` VALUES (510681, '广汉市', 510600, '104.282429,30.977119', 'district', '104.282429', '30.977119', 3, NULL, '0838', '618300', 'Guanghan', 'G', NULL);
INSERT INTO `ez_area` VALUES (510682, '什邡市', 510600, '104.167501,31.12678', 'district', '104.167501', '31.12678', 3, NULL, '0838', '618400', 'Shifang', 'S', NULL);
INSERT INTO `ez_area` VALUES (510683, '绵竹市', 510600, '104.22075,31.338077', 'district', '104.22075', '31.338077', 3, NULL, '0838', '618200', 'Mianzhu', 'M', NULL);
INSERT INTO `ez_area` VALUES (510700, '绵阳市', 510000, '104.679004,31.467459', 'city', '104.679004', '31.467459', 2, NULL, '0816', '621000', 'Mianyang', 'M', NULL);
INSERT INTO `ez_area` VALUES (510703, '涪城区', 510700, '104.756944,31.455101', 'district', '104.756944', '31.455101', 3, NULL, '0816', '621000', 'Fucheng', 'F', NULL);
INSERT INTO `ez_area` VALUES (510704, '游仙区', 510700, '104.766392,31.473779', 'district', '104.766392', '31.473779', 3, NULL, '0816', '621022', 'Youxian', 'Y', NULL);
INSERT INTO `ez_area` VALUES (510705, '安州区', 510700, '104.567187,31.534886', 'district', '104.567187', '31.534886', 3, NULL, '0816', '622650', 'Anzhou', 'A', NULL);
INSERT INTO `ez_area` VALUES (510722, '三台县', 510700, '105.094586,31.095979', 'district', '105.094586', '31.095979', 3, NULL, '0816', '621100', 'Santai', 'S', NULL);
INSERT INTO `ez_area` VALUES (510723, '盐亭县', 510700, '105.389453,31.208362', 'district', '105.389453', '31.208362', 3, NULL, '0816', '621600', 'Yanting', 'Y', NULL);
INSERT INTO `ez_area` VALUES (510725, '梓潼县', 510700, '105.170845,31.642718', 'district', '105.170845', '31.642718', 3, NULL, '0816', '622150', 'Zitong', 'Z', NULL);
INSERT INTO `ez_area` VALUES (510726, '北川羌族自治县', 510700, '104.46797,31.617203', 'district', '104.46797', '31.617203', 3, NULL, '0816', '622750', 'Beichuan', 'B', NULL);
INSERT INTO `ez_area` VALUES (510727, '平武县', 510700, '104.555583,32.409675', 'district', '104.555583', '32.409675', 3, NULL, '0816', '622550', 'Pingwu', 'P', NULL);
INSERT INTO `ez_area` VALUES (510781, '江油市', 510700, '104.745915,31.778026', 'district', '104.745915', '31.778026', 3, NULL, '0816', '621700', 'Jiangyou', 'J', NULL);
INSERT INTO `ez_area` VALUES (510800, '广元市', 510000, '105.843357,32.435435', 'city', '105.843357', '32.435435', 2, NULL, '0839', '628000', 'Guangyuan', 'G', NULL);
INSERT INTO `ez_area` VALUES (510802, '利州区', 510800, '105.845307,32.433756', 'district', '105.845307', '32.433756', 3, NULL, '0839', '628017', 'Lizhou', 'L', NULL);
INSERT INTO `ez_area` VALUES (510811, '昭化区', 510800, '105.962819,32.323256', 'district', '105.962819', '32.323256', 3, NULL, '0839', '628017', 'Zhaohua', 'Z', NULL);
INSERT INTO `ez_area` VALUES (510812, '朝天区', 510800, '105.882642,32.651336', 'district', '105.882642', '32.651336', 3, NULL, '0839', '628017', 'Chaotian', 'C', NULL);
INSERT INTO `ez_area` VALUES (510821, '旺苍县', 510800, '106.289983,32.229058', 'district', '106.289983', '32.229058', 3, NULL, '0839', '628200', 'Wangcang', 'W', NULL);
INSERT INTO `ez_area` VALUES (510822, '青川县', 510800, '105.238842,32.575484', 'district', '105.238842', '32.575484', 3, NULL, '0839', '628100', 'Qingchuan', 'Q', NULL);
INSERT INTO `ez_area` VALUES (510823, '剑阁县', 510800, '105.524766,32.287722', 'district', '105.524766', '32.287722', 3, NULL, '0839', '628300', 'Jiange', 'J', NULL);
INSERT INTO `ez_area` VALUES (510824, '苍溪县', 510800, '105.934756,31.731709', 'district', '105.934756', '31.731709', 3, NULL, '0839', '628400', 'Cangxi', 'C', NULL);
INSERT INTO `ez_area` VALUES (510900, '遂宁市', 510000, '105.592803,30.53292', 'city', '105.592803', '30.53292', 2, NULL, '0825', '629000', 'Suining', 'S', NULL);
INSERT INTO `ez_area` VALUES (510903, '船山区', 510900, '105.568297,30.525475', 'district', '105.568297', '30.525475', 3, NULL, '0825', '629000', 'Chuanshan', 'C', NULL);
INSERT INTO `ez_area` VALUES (510904, '安居区', 510900, '105.456342,30.355379', 'district', '105.456342', '30.355379', 3, NULL, '0825', '629000', 'Anju', 'A', NULL);
INSERT INTO `ez_area` VALUES (510921, '蓬溪县', 510900, '105.70757,30.757575', 'district', '105.70757', '30.757575', 3, NULL, '0825', '629100', 'Pengxi', 'P', NULL);
INSERT INTO `ez_area` VALUES (510922, '射洪县', 510900, '105.388412,30.871131', 'district', '105.388412', '30.871131', 3, NULL, '0825', '629200', 'Shehong', 'S', NULL);
INSERT INTO `ez_area` VALUES (510923, '大英县', 510900, '105.236923,30.594409', 'district', '105.236923', '30.594409', 3, NULL, '0825', '629300', 'Daying', 'D', NULL);
INSERT INTO `ez_area` VALUES (511000, '内江市', 510000, '105.058432,29.580228', 'city', '105.058432', '29.580228', 2, NULL, '0832', '641000', 'Neijiang', 'N', NULL);
INSERT INTO `ez_area` VALUES (511002, '市中区', 511000, '105.067597,29.587053', 'district', '105.067597', '29.587053', 3, NULL, '0832', '641000', 'Shizhongqu', 'S', NULL);
INSERT INTO `ez_area` VALUES (511011, '东兴区', 511000, '105.075489,29.592756', 'district', '105.075489', '29.592756', 3, NULL, '0832', '641100', 'Dongxing', 'D', NULL);
INSERT INTO `ez_area` VALUES (511024, '威远县', 511000, '104.668879,29.52744', 'district', '104.668879', '29.52744', 3, NULL, '0832', '642450', 'Weiyuan', 'W', NULL);
INSERT INTO `ez_area` VALUES (511025, '资中县', 511000, '104.851944,29.764059', 'district', '104.851944', '29.764059', 3, NULL, '0832', '641200', 'Zizhong', 'Z', NULL);
INSERT INTO `ez_area` VALUES (511028, '隆昌市', 511000, '105.287612,29.339476', 'district', '105.287612', '29.339476', 3, NULL, '0832', '642150', 'Longchang', 'L', NULL);
INSERT INTO `ez_area` VALUES (511100, '乐山市', 510000, '103.765678,29.552115', 'city', '103.765678', '29.552115', 2, NULL, '0833', '614000', 'Leshan', 'L', NULL);
INSERT INTO `ez_area` VALUES (511102, '市中区', 511100, '103.761329,29.555374', 'district', '103.761329', '29.555374', 3, NULL, '0833', '614000', 'Shizhongqu', 'S', NULL);
INSERT INTO `ez_area` VALUES (511111, '沙湾区', 511100, '103.549991,29.413091', 'district', '103.549991', '29.413091', 3, NULL, '0833', '614900', 'Shawan', 'S', NULL);
INSERT INTO `ez_area` VALUES (511112, '五通桥区', 511100, '103.818014,29.406945', 'district', '103.818014', '29.406945', 3, NULL, '0833', '614800', 'Wutongqiao', 'W', NULL);
INSERT INTO `ez_area` VALUES (511113, '金口河区', 511100, '103.07862,29.244345', 'district', '103.07862', '29.244345', 3, NULL, '0833', '614700', 'Jinkouhe', 'J', NULL);
INSERT INTO `ez_area` VALUES (511123, '犍为县', 511100, '103.949326,29.20817', 'district', '103.949326', '29.20817', 3, NULL, '0833', '614400', 'Qianwei', 'Q', NULL);
INSERT INTO `ez_area` VALUES (511124, '井研县', 511100, '104.069726,29.651287', 'district', '104.069726', '29.651287', 3, NULL, '0833', '613100', 'Jingyan', 'J', NULL);
INSERT INTO `ez_area` VALUES (511126, '夹江县', 511100, '103.571656,29.73763', 'district', '103.571656', '29.73763', 3, NULL, '0833', '614100', 'Jiajiang', 'J', NULL);
INSERT INTO `ez_area` VALUES (511129, '沐川县', 511100, '103.902334,28.956647', 'district', '103.902334', '28.956647', 3, NULL, '0833', '614500', 'Muchuan', 'M', NULL);
INSERT INTO `ez_area` VALUES (511132, '峨边彝族自治县', 511100, '103.262048,29.230425', 'district', '103.262048', '29.230425', 3, NULL, '0833', '614300', 'Ebian', 'E', NULL);
INSERT INTO `ez_area` VALUES (511133, '马边彝族自治县', 511100, '103.546347,28.83552', 'district', '103.546347', '28.83552', 3, NULL, '0833', '614600', 'Mabian', 'M', NULL);
INSERT INTO `ez_area` VALUES (511181, '峨眉山市', 511100, '103.484503,29.601198', 'district', '103.484503', '29.601198', 3, NULL, '0833', '614200', 'Emeishan', 'E', NULL);
INSERT INTO `ez_area` VALUES (511300, '南充市', 510000, '106.110698,30.837793', 'city', '106.110698', '30.837793', 2, NULL, '0817', '637000', 'Nanchong', 'N', NULL);
INSERT INTO `ez_area` VALUES (511302, '顺庆区', 511300, '106.09245,30.796803', 'district', '106.09245', '30.796803', 3, NULL, '0817', '637000', 'Shunqing', 'S', NULL);
INSERT INTO `ez_area` VALUES (511303, '高坪区', 511300, '106.118808,30.781623', 'district', '106.118808', '30.781623', 3, NULL, '0817', '637100', 'Gaoping', 'G', NULL);
INSERT INTO `ez_area` VALUES (511304, '嘉陵区', 511300, '106.071876,30.758823', 'district', '106.071876', '30.758823', 3, NULL, '0817', '637100', 'Jialing', 'J', NULL);
INSERT INTO `ez_area` VALUES (511321, '南部县', 511300, '106.036584,31.347467', 'district', '106.036584', '31.347467', 3, NULL, '0817', '637300', 'Nanbu', 'N', NULL);
INSERT INTO `ez_area` VALUES (511322, '营山县', 511300, '106.565519,31.076579', 'district', '106.565519', '31.076579', 3, NULL, '0817', '637700', 'Yingshan', 'Y', NULL);
INSERT INTO `ez_area` VALUES (511323, '蓬安县', 511300, '106.412136,31.029091', 'district', '106.412136', '31.029091', 3, NULL, '0817', '637800', 'Peng\'an', 'P', NULL);
INSERT INTO `ez_area` VALUES (511324, '仪陇县', 511300, '106.303042,31.271561', 'district', '106.303042', '31.271561', 3, NULL, '0817', '637600', 'Yilong', 'Y', NULL);
INSERT INTO `ez_area` VALUES (511325, '西充县', 511300, '105.90087,30.995683', 'district', '105.90087', '30.995683', 3, NULL, '0817', '637200', 'Xichong', 'X', NULL);
INSERT INTO `ez_area` VALUES (511381, '阆中市', 511300, '106.005046,31.558356', 'district', '106.005046', '31.558356', 3, NULL, '0817', '637400', 'Langzhong', 'L', NULL);
INSERT INTO `ez_area` VALUES (511400, '眉山市', 510000, '103.848403,30.076994', 'city', '103.848403', '30.076994', 2, NULL, '028', '620020', 'Meishan', 'M', NULL);
INSERT INTO `ez_area` VALUES (511402, '东坡区', 511400, '103.831863,30.042308', 'district', '103.831863', '30.042308', 3, NULL, '028', '620010', 'Dongpo', 'D', NULL);
INSERT INTO `ez_area` VALUES (511403, '彭山区', 511400, '103.872949,30.193056', 'district', '103.872949', '30.193056', 3, NULL, '028', '620860', 'Pengshan', 'P', NULL);
INSERT INTO `ez_area` VALUES (511421, '仁寿县', 511400, '104.133995,29.995635', 'district', '104.133995', '29.995635', 3, NULL, '028', '620500', 'Renshou', 'R', NULL);
INSERT INTO `ez_area` VALUES (511423, '洪雅县', 511400, '103.372863,29.90489', 'district', '103.372863', '29.90489', 3, NULL, '028', '620360', 'Hongya', 'H', NULL);
INSERT INTO `ez_area` VALUES (511424, '丹棱县', 511400, '103.512783,30.01521', 'district', '103.512783', '30.01521', 3, NULL, '028', '620200', 'Danling', 'D', NULL);
INSERT INTO `ez_area` VALUES (511425, '青神县', 511400, '103.846688,29.831357', 'district', '103.846688', '29.831357', 3, NULL, '028', '620460', 'Qingshen', 'Q', NULL);
INSERT INTO `ez_area` VALUES (511500, '宜宾市', 510000, '104.642845,28.752134', 'city', '104.642845', '28.752134', 2, NULL, '0831', '644000', 'Yibin', 'Y', NULL);
INSERT INTO `ez_area` VALUES (511502, '翠屏区', 511500, '104.620009,28.765689', 'district', '104.620009', '28.765689', 3, NULL, '0831', '644000', 'Cuiping', 'C', NULL);
INSERT INTO `ez_area` VALUES (511503, '南溪区', 511500, '104.969152,28.846382', 'district', '104.969152', '28.846382', 3, NULL, '0831', '644100', 'Nanxi', 'N', NULL);
INSERT INTO `ez_area` VALUES (511521, '宜宾县', 511500, '104.533212,28.690045', 'district', '104.533212', '28.690045', 3, NULL, '0831', '644600', 'Yibin', 'Y', NULL);
INSERT INTO `ez_area` VALUES (511523, '江安县', 511500, '105.066879,28.723855', 'district', '105.066879', '28.723855', 3, NULL, '0831', '644200', 'Jiang\'an', 'J', NULL);
INSERT INTO `ez_area` VALUES (511524, '长宁县', 511500, '104.921174,28.582169', 'district', '104.921174', '28.582169', 3, NULL, '0831', '644300', 'Changning', 'C', NULL);
INSERT INTO `ez_area` VALUES (511525, '高县', 511500, '104.517748,28.436166', 'district', '104.517748', '28.436166', 3, NULL, '0831', '645150', 'Gaoxian', 'G', NULL);
INSERT INTO `ez_area` VALUES (511526, '珙县', 511500, '104.709202,28.43863', 'district', '104.709202', '28.43863', 3, NULL, '0831', '644500', 'Gongxian', 'G', NULL);
INSERT INTO `ez_area` VALUES (511527, '筠连县', 511500, '104.512025,28.167831', 'district', '104.512025', '28.167831', 3, NULL, '0831', '645250', 'Junlian', 'J', NULL);
INSERT INTO `ez_area` VALUES (511528, '兴文县', 511500, '105.236325,28.303614', 'district', '105.236325', '28.303614', 3, NULL, '0831', '644400', 'Xingwen', 'X', NULL);
INSERT INTO `ez_area` VALUES (511529, '屏山县', 511500, '104.345974,28.828482', 'district', '104.345974', '28.828482', 3, NULL, '0831', '645350', 'Pingshan', 'P', NULL);
INSERT INTO `ez_area` VALUES (511600, '广安市', 510000, '106.633088,30.456224', 'city', '106.633088', '30.456224', 2, NULL, '0826', '638000', 'Guang\'an', 'G', NULL);
INSERT INTO `ez_area` VALUES (511602, '广安区', 511600, '106.641662,30.473913', 'district', '106.641662', '30.473913', 3, NULL, '0826', '638000', 'Guang\'an', 'G', NULL);
INSERT INTO `ez_area` VALUES (511603, '前锋区', 511600, '106.886143,30.495804', 'district', '106.886143', '30.495804', 3, NULL, '0826', '638019', 'Qianfeng', 'Q', NULL);
INSERT INTO `ez_area` VALUES (511621, '岳池县', 511600, '106.440114,30.537863', 'district', '106.440114', '30.537863', 3, NULL, '0826', '638300', 'Yuechi', 'Y', NULL);
INSERT INTO `ez_area` VALUES (511622, '武胜县', 511600, '106.295764,30.348772', 'district', '106.295764', '30.348772', 3, NULL, '0826', '638400', 'Wusheng', 'W', NULL);
INSERT INTO `ez_area` VALUES (511623, '邻水县', 511600, '106.93038,30.334768', 'district', '106.93038', '30.334768', 3, NULL, '0826', '638500', 'Linshui', 'L', NULL);
INSERT INTO `ez_area` VALUES (511681, '华蓥市', 511600, '106.7831,30.390188', 'district', '106.7831', '30.390188', 3, NULL, '0826', '638600', 'Huaying', 'H', NULL);
INSERT INTO `ez_area` VALUES (511700, '达州市', 510000, '107.467758,31.209121', 'city', '107.467758', '31.209121', 2, NULL, '0818', '635000', 'Dazhou', 'D', NULL);
INSERT INTO `ez_area` VALUES (511702, '通川区', 511700, '107.504928,31.214715', 'district', '107.504928', '31.214715', 3, NULL, '0818', '635000', 'Tongchuan', 'T', NULL);
INSERT INTO `ez_area` VALUES (511703, '达川区', 511700, '107.511749,31.196157', 'district', '107.511749', '31.196157', 3, NULL, '0818', '635000', 'Dachuan', 'D', NULL);
INSERT INTO `ez_area` VALUES (511722, '宣汉县', 511700, '107.72719,31.353835', 'district', '107.72719', '31.353835', 3, NULL, '0818', '636150', 'Xuanhan', 'X', NULL);
INSERT INTO `ez_area` VALUES (511723, '开江县', 511700, '107.868736,31.082986', 'district', '107.868736', '31.082986', 3, NULL, '0818', '636250', 'Kaijiang', 'K', NULL);
INSERT INTO `ez_area` VALUES (511724, '大竹县', 511700, '107.204795,30.73641', 'district', '107.204795', '30.73641', 3, NULL, '0818', '635100', 'Dazhu', 'D', NULL);
INSERT INTO `ez_area` VALUES (511725, '渠县', 511700, '106.97303,30.836618', 'district', '106.97303', '30.836618', 3, NULL, '0818', '635200', 'Quxian', 'Q', NULL);
INSERT INTO `ez_area` VALUES (511781, '万源市', 511700, '108.034657,32.081631', 'district', '108.034657', '32.081631', 3, NULL, '0818', '636350', 'Wanyuan', 'W', NULL);
INSERT INTO `ez_area` VALUES (511800, '雅安市', 510000, '103.042375,30.010602', 'city', '103.042375', '30.010602', 2, NULL, '0835', '625000', 'Ya\'an', 'Y', NULL);
INSERT INTO `ez_area` VALUES (511802, '雨城区', 511800, '103.033026,30.005461', 'district', '103.033026', '30.005461', 3, NULL, '0835', '625000', 'Yucheng', 'Y', NULL);
INSERT INTO `ez_area` VALUES (511803, '名山区', 511800, '103.109184,30.069954', 'district', '103.109184', '30.069954', 3, NULL, '0835', '625100', 'Mingshan', 'M', NULL);
INSERT INTO `ez_area` VALUES (511822, '荥经县', 511800, '102.846737,29.792931', 'district', '102.846737', '29.792931', 3, NULL, '0835', '625200', 'Yingjing', 'Y', NULL);
INSERT INTO `ez_area` VALUES (511823, '汉源县', 511800, '102.645467,29.347192', 'district', '102.645467', '29.347192', 3, NULL, '0835', '625300', 'Hanyuan', 'H', NULL);
INSERT INTO `ez_area` VALUES (511824, '石棉县', 511800, '102.359462,29.227874', 'district', '102.359462', '29.227874', 3, NULL, '0835', '625400', 'Shimian', 'S', NULL);
INSERT INTO `ez_area` VALUES (511825, '天全县', 511800, '102.758317,30.066712', 'district', '102.758317', '30.066712', 3, NULL, '0835', '625500', 'Tianquan', 'T', NULL);
INSERT INTO `ez_area` VALUES (511826, '芦山县', 511800, '102.932385,30.142307', 'district', '102.932385', '30.142307', 3, NULL, '0835', '625600', 'Lushan', 'L', NULL);
INSERT INTO `ez_area` VALUES (511827, '宝兴县', 511800, '102.815403,30.37641', 'district', '102.815403', '30.37641', 3, NULL, '0835', '625700', 'Baoxing', 'B', NULL);
INSERT INTO `ez_area` VALUES (511900, '巴中市', 510000, '106.747477,31.867903', 'city', '106.747477', '31.867903', 2, NULL, '0827', '636000', 'Bazhong', 'B', NULL);
INSERT INTO `ez_area` VALUES (511902, '巴州区', 511900, '106.768878,31.851478', 'district', '106.768878', '31.851478', 3, NULL, '0827', '636001', 'Bazhou', 'B', NULL);
INSERT INTO `ez_area` VALUES (511903, '恩阳区', 511900, '106.654386,31.787186', 'district', '106.654386', '31.787186', 3, NULL, '0827', '636064', 'Enyang', 'E', NULL);
INSERT INTO `ez_area` VALUES (511921, '通江县', 511900, '107.245033,31.911705', 'district', '107.245033', '31.911705', 3, NULL, '0827', '636700', 'Tongjiang', 'T', NULL);
INSERT INTO `ez_area` VALUES (511922, '南江县', 511900, '106.828697,32.346589', 'district', '106.828697', '32.346589', 3, NULL, '0827', '636600', 'Nanjiang', 'N', NULL);
INSERT INTO `ez_area` VALUES (511923, '平昌县', 511900, '107.104008,31.560874', 'district', '107.104008', '31.560874', 3, NULL, '0827', '636400', 'Pingchang', 'P', NULL);
INSERT INTO `ez_area` VALUES (512000, '资阳市', 510000, '104.627636,30.128901', 'city', '104.627636', '30.128901', 2, NULL, '028', '641300', 'Ziyang', 'Z', NULL);
INSERT INTO `ez_area` VALUES (512002, '雁江区', 512000, '104.677091,30.108216', 'district', '104.677091', '30.108216', 3, NULL, '028', '641300', 'Yanjiang', 'Y', NULL);
INSERT INTO `ez_area` VALUES (512021, '安岳县', 512000, '105.35534,30.103107', 'district', '105.35534', '30.103107', 3, NULL, '028', '642350', 'Anyue', 'A', NULL);
INSERT INTO `ez_area` VALUES (512022, '乐至县', 512000, '105.02019,30.276121', 'district', '105.02019', '30.276121', 3, NULL, '028', '641500', 'Lezhi', 'L', NULL);
INSERT INTO `ez_area` VALUES (513200, '阿坝藏族羌族自治州', 510000, '102.224653,31.899413', 'city', '102.224653', '31.899413', 2, NULL, '0837', '624000', 'Aba', 'A', NULL);
INSERT INTO `ez_area` VALUES (513201, '马尔康市', 513200, '102.20652,31.905693', 'district', '102.20652', '31.905693', 3, NULL, '0837', '624000', 'Maerkang', 'M', NULL);
INSERT INTO `ez_area` VALUES (513221, '汶川县', 513200, '103.590179,31.476854', 'district', '103.590179', '31.476854', 3, NULL, '0837', '623000', 'Wenchuan', 'W', NULL);
INSERT INTO `ez_area` VALUES (513222, '理县', 513200, '103.164661,31.435174', 'district', '103.164661', '31.435174', 3, NULL, '0837', '623100', 'Lixian', 'L', NULL);
INSERT INTO `ez_area` VALUES (513223, '茂县', 513200, '103.853363,31.681547', 'district', '103.853363', '31.681547', 3, NULL, '0837', '623200', 'Maoxian', 'M', NULL);
INSERT INTO `ez_area` VALUES (513224, '松潘县', 513200, '103.604698,32.655325', 'district', '103.604698', '32.655325', 3, NULL, '0837', '623300', 'Songpan', 'S', NULL);
INSERT INTO `ez_area` VALUES (513225, '九寨沟县', 513200, '104.243841,33.252056', 'district', '104.243841', '33.252056', 3, NULL, '0837', '623400', 'Jiuzhaigou', 'J', NULL);
INSERT INTO `ez_area` VALUES (513226, '金川县', 513200, '102.063829,31.476277', 'district', '102.063829', '31.476277', 3, NULL, '0837', '624100', 'Jinchuan', 'J', NULL);
INSERT INTO `ez_area` VALUES (513227, '小金县', 513200, '102.362984,30.995823', 'district', '102.362984', '30.995823', 3, NULL, '0837', '624200', 'Xiaojin', 'X', NULL);
INSERT INTO `ez_area` VALUES (513228, '黑水县', 513200, '102.990108,32.061895', 'district', '102.990108', '32.061895', 3, NULL, '0837', '623500', 'Heishui', 'H', NULL);
INSERT INTO `ez_area` VALUES (513230, '壤塘县', 513200, '100.978526,32.265796', 'district', '100.978526', '32.265796', 3, NULL, '0837', '624300', 'Rangtang', 'R', NULL);
INSERT INTO `ez_area` VALUES (513231, '阿坝县', 513200, '101.706655,32.902459', 'district', '101.706655', '32.902459', 3, NULL, '0837', '624600', 'Aba', 'A', NULL);
INSERT INTO `ez_area` VALUES (513232, '若尔盖县', 513200, '102.967826,33.578159', 'district', '102.967826', '33.578159', 3, NULL, '0837', '624500', 'Ruoergai', 'R', NULL);
INSERT INTO `ez_area` VALUES (513233, '红原县', 513200, '102.544405,32.790891', 'district', '102.544405', '32.790891', 3, NULL, '0837', '624400', 'Hongyuan', 'H', NULL);
INSERT INTO `ez_area` VALUES (513300, '甘孜藏族自治州', 510000, '101.96231,30.04952', 'city', '101.96231', '30.04952', 2, NULL, '0836', '626000', 'Garze', 'G', NULL);
INSERT INTO `ez_area` VALUES (513301, '康定市', 513300, '101.957146,29.998435', 'district', '101.957146', '29.998435', 3, NULL, '0836', '626000', 'Kangding', 'K', NULL);
INSERT INTO `ez_area` VALUES (513322, '泸定县', 513300, '102.234617,29.91416', 'district', '102.234617', '29.91416', 3, NULL, '0836', '626100', 'Luding', 'L', NULL);
INSERT INTO `ez_area` VALUES (513323, '丹巴县', 513300, '101.890358,30.878577', 'district', '101.890358', '30.878577', 3, NULL, '0836', '626300', 'Danba', 'D', NULL);
INSERT INTO `ez_area` VALUES (513324, '九龙县', 513300, '101.507294,29.000347', 'district', '101.507294', '29.000347', 3, NULL, '0836', '626200', 'Jiulong', 'J', NULL);
INSERT INTO `ez_area` VALUES (513325, '雅江县', 513300, '101.014425,30.031533', 'district', '101.014425', '30.031533', 3, NULL, '0836', '627450', 'Yajiang', 'Y', NULL);
INSERT INTO `ez_area` VALUES (513326, '道孚县', 513300, '101.125237,30.979545', 'district', '101.125237', '30.979545', 3, NULL, '0836', '626400', 'Daofu', 'D', NULL);
INSERT INTO `ez_area` VALUES (513327, '炉霍县', 513300, '100.676372,31.39179', 'district', '100.676372', '31.39179', 3, NULL, '0836', '626500', 'Luhuo', 'L', NULL);
INSERT INTO `ez_area` VALUES (513328, '甘孜县', 513300, '99.99267,31.622933', 'district', '99.99267', '31.622933', 3, NULL, '0836', '626700', 'Ganzi', 'G', NULL);
INSERT INTO `ez_area` VALUES (513329, '新龙县', 513300, '100.311368,30.939169', 'district', '100.311368', '30.939169', 3, NULL, '0836', '626800', 'Xinlong', 'X', NULL);
INSERT INTO `ez_area` VALUES (513330, '德格县', 513300, '98.580914,31.806118', 'district', '98.580914', '31.806118', 3, NULL, '0836', '627250', 'Dege', 'D', NULL);
INSERT INTO `ez_area` VALUES (513331, '白玉县', 513300, '98.824182,31.209913', 'district', '98.824182', '31.209913', 3, NULL, '0836', '627150', 'Baiyu', 'B', NULL);
INSERT INTO `ez_area` VALUES (513332, '石渠县', 513300, '98.102914,32.97896', 'district', '98.102914', '32.97896', 3, NULL, '0836', '627350', 'Shiqu', 'S', NULL);
INSERT INTO `ez_area` VALUES (513333, '色达县', 513300, '100.332743,32.268129', 'district', '100.332743', '32.268129', 3, NULL, '0836', '626600', 'Seda', 'S', NULL);
INSERT INTO `ez_area` VALUES (513334, '理塘县', 513300, '100.269817,29.996049', 'district', '100.269817', '29.996049', 3, NULL, '0836', '627550', 'Litang', 'L', NULL);
INSERT INTO `ez_area` VALUES (513335, '巴塘县', 513300, '99.110712,30.004677', 'district', '99.110712', '30.004677', 3, NULL, '0836', '627650', 'Batang', 'B', NULL);
INSERT INTO `ez_area` VALUES (513336, '乡城县', 513300, '99.798435,28.931172', 'district', '99.798435', '28.931172', 3, NULL, '0836', '627850', 'Xiangcheng', 'X', NULL);
INSERT INTO `ez_area` VALUES (513337, '稻城县', 513300, '100.298403,29.037007', 'district', '100.298403', '29.037007', 3, NULL, '0836', '627750', 'Daocheng', 'D', NULL);
INSERT INTO `ez_area` VALUES (513338, '得荣县', 513300, '99.286335,28.713036', 'district', '99.286335', '28.713036', 3, NULL, '0836', '627950', 'Derong', 'D', NULL);
INSERT INTO `ez_area` VALUES (513400, '凉山彝族自治州', 510000, '102.267712,27.88157', 'city', '102.267712', '27.88157', 2, NULL, '0834', '615000', 'Liangshan', 'L', NULL);
INSERT INTO `ez_area` VALUES (513401, '西昌市', 513400, '102.264449,27.894504', 'district', '102.264449', '27.894504', 3, NULL, '0835', '615000', 'Xichang', 'X', NULL);
INSERT INTO `ez_area` VALUES (513422, '木里藏族自治县', 513400, '101.280205,27.928835', 'district', '101.280205', '27.928835', 3, NULL, '0851', '615800', 'Muli', 'M', NULL);
INSERT INTO `ez_area` VALUES (513423, '盐源县', 513400, '101.509188,27.422645', 'district', '101.509188', '27.422645', 3, NULL, '0836', '615700', 'Yanyuan', 'Y', NULL);
INSERT INTO `ez_area` VALUES (513424, '德昌县', 513400, '102.17567,27.402839', 'district', '102.17567', '27.402839', 3, NULL, '0837', '615500', 'Dechang', 'D', NULL);
INSERT INTO `ez_area` VALUES (513425, '会理县', 513400, '102.244683,26.655026', 'district', '102.244683', '26.655026', 3, NULL, '0838', '615100', 'Huili', 'H', NULL);
INSERT INTO `ez_area` VALUES (513426, '会东县', 513400, '102.57796,26.634669', 'district', '102.57796', '26.634669', 3, NULL, '0839', '615200', 'Huidong', 'H', NULL);
INSERT INTO `ez_area` VALUES (513427, '宁南县', 513400, '102.751745,27.061189', 'district', '102.751745', '27.061189', 3, NULL, '0840', '615400', 'Ningnan', 'N', NULL);
INSERT INTO `ez_area` VALUES (513428, '普格县', 513400, '102.540901,27.376413', 'district', '102.540901', '27.376413', 3, NULL, '0841', '615300', 'Puge', 'P', NULL);
INSERT INTO `ez_area` VALUES (513429, '布拖县', 513400, '102.812061,27.706061', 'district', '102.812061', '27.706061', 3, NULL, '0842', '616350', 'Butuo', 'B', NULL);
INSERT INTO `ez_area` VALUES (513430, '金阳县', 513400, '103.248772,27.69686', 'district', '103.248772', '27.69686', 3, NULL, '0843', '616250', 'Jinyang', 'J', NULL);
INSERT INTO `ez_area` VALUES (513431, '昭觉县', 513400, '102.840264,28.015333', 'district', '102.840264', '28.015333', 3, NULL, '0844', '616150', 'Zhaojue', 'Z', NULL);
INSERT INTO `ez_area` VALUES (513432, '喜德县', 513400, '102.412518,28.306726', 'district', '102.412518', '28.306726', 3, NULL, '0845', '616750', 'Xide', 'X', NULL);
INSERT INTO `ez_area` VALUES (513433, '冕宁县', 513400, '102.17701,28.549656', 'district', '102.17701', '28.549656', 3, NULL, '0846', '615600', 'Mianning', 'M', NULL);
INSERT INTO `ez_area` VALUES (513434, '越西县', 513400, '102.50768,28.639801', 'district', '102.50768', '28.639801', 3, NULL, '0847', '616650', 'Yuexi', 'Y', NULL);
INSERT INTO `ez_area` VALUES (513435, '甘洛县', 513400, '102.771504,28.959157', 'district', '102.771504', '28.959157', 3, NULL, '0848', '616850', 'Ganluo', 'G', NULL);
INSERT INTO `ez_area` VALUES (513436, '美姑县', 513400, '103.132179,28.32864', 'district', '103.132179', '28.32864', 3, NULL, '0849', '616450', 'Meigu', 'M', NULL);
INSERT INTO `ez_area` VALUES (513437, '雷波县', 513400, '103.571696,28.262682', 'district', '103.571696', '28.262682', 3, NULL, '0850', '616550', 'Leibo', 'L', NULL);
INSERT INTO `ez_area` VALUES (520000, '贵州省', 0, '106.70546,26.600055', 'province', '106.70546', '26.600055', 1, NULL, NULL, NULL, 'Guizhou', 'G', NULL);
INSERT INTO `ez_area` VALUES (520100, '贵阳市', 520000, '106.630153,26.647661', 'city', '106.630153', '26.647661', 2, NULL, '0851', '550001', 'Guiyang', 'G', NULL);
INSERT INTO `ez_area` VALUES (520102, '南明区', 520100, '106.714374,26.567944', 'district', '106.714374', '26.567944', 3, NULL, '0851', '550001', 'Nanming', 'N', NULL);
INSERT INTO `ez_area` VALUES (520103, '云岩区', 520100, '106.724494,26.604688', 'district', '106.724494', '26.604688', 3, NULL, '0851', '550001', 'Yunyan', 'Y', NULL);
INSERT INTO `ez_area` VALUES (520111, '花溪区', 520100, '106.67026,26.409817', 'district', '106.67026', '26.409817', 3, NULL, '0851', '550025', 'Huaxi', 'H', NULL);
INSERT INTO `ez_area` VALUES (520112, '乌当区', 520100, '106.750625,26.630845', 'district', '106.750625', '26.630845', 3, NULL, '0851', '550018', 'Wudang', 'W', NULL);
INSERT INTO `ez_area` VALUES (520113, '白云区', 520100, '106.623007,26.678561', 'district', '106.623007', '26.678561', 3, NULL, '0851', '550014', 'Baiyun', 'B', NULL);
INSERT INTO `ez_area` VALUES (520115, '观山湖区', 520100, '106.622453,26.60145', 'district', '106.622453', '26.60145', 3, NULL, '0851', '550009', 'Guanshanhu', 'G', NULL);
INSERT INTO `ez_area` VALUES (520121, '开阳县', 520100, '106.965089,27.057764', 'district', '106.965089', '27.057764', 3, NULL, '0851', '550300', 'Kaiyang', 'K', NULL);
INSERT INTO `ez_area` VALUES (520122, '息烽县', 520100, '106.740407,27.090479', 'district', '106.740407', '27.090479', 3, NULL, '0851', '551100', 'Xifeng', 'X', NULL);
INSERT INTO `ez_area` VALUES (520123, '修文县', 520100, '106.592108,26.838926', 'district', '106.592108', '26.838926', 3, NULL, '0851', '550200', 'Xiuwen', 'X', NULL);
INSERT INTO `ez_area` VALUES (520181, '清镇市', 520100, '106.470714,26.556079', 'district', '106.470714', '26.556079', 3, NULL, '0851', '551400', 'Qingzhen', 'Q', NULL);
INSERT INTO `ez_area` VALUES (520200, '六盘水市', 520000, '104.830458,26.592707', 'city', '104.830458', '26.592707', 2, NULL, '0858', '553400', 'Liupanshui', 'L', NULL);
INSERT INTO `ez_area` VALUES (520201, '钟山区', 520200, '104.843555,26.574979', 'district', '104.843555', '26.574979', 3, NULL, '0858', '553000', 'Zhongshan', 'Z', NULL);
INSERT INTO `ez_area` VALUES (520203, '六枝特区', 520200, '105.476608,26.213108', 'district', '105.476608', '26.213108', 3, NULL, '0858', '553400', 'Liuzhi', 'L', NULL);
INSERT INTO `ez_area` VALUES (520221, '水城县', 520200, '104.95783,26.547904', 'district', '104.95783', '26.547904', 3, NULL, '0858', '553000', 'Shuicheng', 'S', NULL);
INSERT INTO `ez_area` VALUES (520222, '盘州市', 520200, '104.471375,25.709852', 'district', '104.471375', '25.709852', 3, NULL, '0858', '561601', 'Panxian', 'P', NULL);
INSERT INTO `ez_area` VALUES (520300, '遵义市', 520000, '106.927389,27.725654', 'city', '106.927389', '27.725654', 2, NULL, '0852', '563000', 'Zunyi', 'Z', NULL);
INSERT INTO `ez_area` VALUES (520302, '红花岗区', 520300, '106.8937,27.644754', 'district', '106.8937', '27.644754', 3, NULL, '0852', '563000', 'Honghuagang', 'H', NULL);
INSERT INTO `ez_area` VALUES (520303, '汇川区', 520300, '106.93427,27.750125', 'district', '106.93427', '27.750125', 3, NULL, '0852', '563000', 'Huichuan', 'H', NULL);
INSERT INTO `ez_area` VALUES (520304, '播州区', 520300, '106.829574,27.536298', 'district', '106.829574', '27.536298', 3, NULL, '0852', '56310', 'Bozhou', 'B', NULL);
INSERT INTO `ez_area` VALUES (520322, '桐梓县', 520300, '106.825198,28.133311', 'district', '106.825198', '28.133311', 3, NULL, '0852', '563200', 'Tongzi', 'T', NULL);
INSERT INTO `ez_area` VALUES (520323, '绥阳县', 520300, '107.191222,27.946222', 'district', '107.191222', '27.946222', 3, NULL, '0852', '563300', 'Suiyang', 'S', NULL);
INSERT INTO `ez_area` VALUES (520324, '正安县', 520300, '107.453945,28.553285', 'district', '107.453945', '28.553285', 3, NULL, '0852', '563400', 'Zheng\'an', 'Z', NULL);
INSERT INTO `ez_area` VALUES (520325, '道真仡佬族苗族自治县', 520300, '107.613133,28.862425', 'district', '107.613133', '28.862425', 3, NULL, '0852', '563500', 'Daozhen', 'D', NULL);
INSERT INTO `ez_area` VALUES (520326, '务川仡佬族苗族自治县', 520300, '107.898956,28.563086', 'district', '107.898956', '28.563086', 3, NULL, '0852', '564300', 'Wuchuan', 'W', NULL);
INSERT INTO `ez_area` VALUES (520327, '凤冈县', 520300, '107.716355,27.954695', 'district', '107.716355', '27.954695', 3, NULL, '0852', '564200', 'Fenggang', 'F', NULL);
INSERT INTO `ez_area` VALUES (520328, '湄潭县', 520300, '107.465407,27.749055', 'district', '107.465407', '27.749055', 3, NULL, '0852', '564100', 'Meitan', 'M', NULL);
INSERT INTO `ez_area` VALUES (520329, '余庆县', 520300, '107.905197,27.215491', 'district', '107.905197', '27.215491', 3, NULL, '0852', '564400', 'Yuqing', 'Y', NULL);
INSERT INTO `ez_area` VALUES (520330, '习水县', 520300, '106.197137,28.33127', 'district', '106.197137', '28.33127', 3, NULL, '0852', '564600', 'Xishui', 'X', NULL);
INSERT INTO `ez_area` VALUES (520381, '赤水市', 520300, '105.697472,28.590337', 'district', '105.697472', '28.590337', 3, NULL, '0852', '564700', 'Chishui', 'C', NULL);
INSERT INTO `ez_area` VALUES (520382, '仁怀市', 520300, '106.40109,27.792514', 'district', '106.40109', '27.792514', 3, NULL, '0852', '564500', 'Renhuai', 'R', NULL);
INSERT INTO `ez_area` VALUES (520400, '安顺市', 520000, '105.947594,26.253088', 'city', '105.947594', '26.253088', 2, NULL, '0853', '561000', 'Anshun', 'A', NULL);
INSERT INTO `ez_area` VALUES (520402, '西秀区', 520400, '105.965116,26.245315', 'district', '105.965116', '26.245315', 3, NULL, '0853', '561000', 'Xixiu', 'X', NULL);
INSERT INTO `ez_area` VALUES (520403, '平坝区', 520400, '106.256412,26.405715', 'district', '106.256412', '26.405715', 3, NULL, '0853', '561100', 'Pingba', 'P', NULL);
INSERT INTO `ez_area` VALUES (520422, '普定县', 520400, '105.743277,26.301565', 'district', '105.743277', '26.301565', 3, NULL, '0853', '562100', 'Puding', 'P', NULL);
INSERT INTO `ez_area` VALUES (520423, '镇宁布依族苗族自治县', 520400, '105.770283,26.058086', 'district', '105.770283', '26.058086', 3, NULL, '0853', '561200', 'Zhenning', 'Z', NULL);
INSERT INTO `ez_area` VALUES (520424, '关岭布依族苗族自治县', 520400, '105.61933,25.94361', 'district', '105.61933', '25.94361', 3, NULL, '0853', '561300', 'Guanling', 'G', NULL);
INSERT INTO `ez_area` VALUES (520425, '紫云苗族布依族自治县', 520400, '106.084441,25.751047', 'district', '106.084441', '25.751047', 3, NULL, '0853', '550800', 'Ziyun', 'Z', NULL);
INSERT INTO `ez_area` VALUES (520500, '毕节市', 520000, '105.291702,27.283908', 'city', '105.291702', '27.283908', 2, NULL, '0857', '551700', 'Bijie', 'B', NULL);
INSERT INTO `ez_area` VALUES (520502, '七星关区', 520500, '105.30474,27.298458', 'district', '105.30474', '27.298458', 3, NULL, '0857', '551700', 'Qixingguan', 'Q', NULL);
INSERT INTO `ez_area` VALUES (520521, '大方县', 520500, '105.613037,27.141735', 'district', '105.613037', '27.141735', 3, NULL, '0857', '551600', 'Dafang', 'D', NULL);
INSERT INTO `ez_area` VALUES (520522, '黔西县', 520500, '106.033544,27.007713', 'district', '106.033544', '27.007713', 3, NULL, '0857', '551500', 'Qianxi', 'Q', NULL);
INSERT INTO `ez_area` VALUES (520523, '金沙县', 520500, '106.220227,27.459214', 'district', '106.220227', '27.459214', 3, NULL, '0857', '551800', 'Jinsha', 'J', NULL);
INSERT INTO `ez_area` VALUES (520524, '织金县', 520500, '105.770542,26.663449', 'district', '105.770542', '26.663449', 3, NULL, '0857', '552100', 'Zhijin', 'Z', NULL);
INSERT INTO `ez_area` VALUES (520525, '纳雍县', 520500, '105.382714,26.777645', 'district', '105.382714', '26.777645', 3, NULL, '0857', '553300', 'Nayong', 'N', NULL);
INSERT INTO `ez_area` VALUES (520526, '威宁彝族回族苗族自治县', 520500, '104.253071,26.873806', 'district', '104.253071', '26.873806', 3, NULL, '0857', '553100', 'Weining', 'W', NULL);
INSERT INTO `ez_area` VALUES (520527, '赫章县', 520500, '104.727418,27.123078', 'district', '104.727418', '27.123078', 3, NULL, '0857', '553200', 'Hezhang', 'H', NULL);
INSERT INTO `ez_area` VALUES (520600, '铜仁市', 520000, '109.189598,27.731514', 'city', '109.189598', '27.731514', 2, NULL, '0856', '554300', 'Tongren', 'T', NULL);
INSERT INTO `ez_area` VALUES (520602, '碧江区', 520600, '109.263998,27.815927', 'district', '109.263998', '27.815927', 3, NULL, '0856', '554300', 'Bijiang', 'B', NULL);
INSERT INTO `ez_area` VALUES (520603, '万山区', 520600, '109.213644,27.517896', 'district', '109.213644', '27.517896', 3, NULL, '0856', '554200', 'Wanshan', 'W', NULL);
INSERT INTO `ez_area` VALUES (520621, '江口县', 520600, '108.839557,27.69965', 'district', '108.839557', '27.69965', 3, NULL, '0856', '554400', 'Jiangkou', 'J', NULL);
INSERT INTO `ez_area` VALUES (520622, '玉屏侗族自治县', 520600, '108.906411,27.235813', 'district', '108.906411', '27.235813', 3, NULL, '0856', '554004', 'Yuping', 'Y', NULL);
INSERT INTO `ez_area` VALUES (520623, '石阡县', 520600, '108.223612,27.513829', 'district', '108.223612', '27.513829', 3, NULL, '0856', '555100', 'Shiqian', 'S', NULL);
INSERT INTO `ez_area` VALUES (520624, '思南县', 520600, '108.253882,27.93755', 'district', '108.253882', '27.93755', 3, NULL, '0856', '565100', 'Sinan', 'S', NULL);
INSERT INTO `ez_area` VALUES (520625, '印江土家族苗族自治县', 520600, '108.409751,27.994246', 'district', '108.409751', '27.994246', 3, NULL, '0856', '555200', 'Yinjiang', 'Y', NULL);
INSERT INTO `ez_area` VALUES (520626, '德江县', 520600, '108.119807,28.263963', 'district', '108.119807', '28.263963', 3, NULL, '0856', '565200', 'Dejiang', 'D', NULL);
INSERT INTO `ez_area` VALUES (520627, '沿河土家族自治县', 520600, '108.50387,28.563927', 'district', '108.50387', '28.563927', 3, NULL, '0856', '565300', 'Yuanhe', 'Y', NULL);
INSERT INTO `ez_area` VALUES (520628, '松桃苗族自治县', 520600, '109.202886,28.154071', 'district', '109.202886', '28.154071', 3, NULL, '0856', '554100', 'Songtao', 'S', NULL);
INSERT INTO `ez_area` VALUES (522300, '黔西南布依族苗族自治州', 520000, '104.906397,25.087856', 'city', '104.906397', '25.087856', 2, NULL, '0859', '562400', 'Qianxinan', 'Q', NULL);
INSERT INTO `ez_area` VALUES (522301, '兴义市', 522300, '104.895467,25.09204', 'district', '104.895467', '25.09204', 3, NULL, '0859', '562400', 'Xingyi', 'X', NULL);
INSERT INTO `ez_area` VALUES (522322, '兴仁县', 522300, '105.186237,25.435183', 'district', '105.186237', '25.435183', 3, NULL, '0859', '562300', 'Xingren', 'X', NULL);
INSERT INTO `ez_area` VALUES (522323, '普安县', 522300, '104.953062,25.784135', 'district', '104.953062', '25.784135', 3, NULL, '0859', '561500', 'Pu\'an', 'P', NULL);
INSERT INTO `ez_area` VALUES (522324, '晴隆县', 522300, '105.218991,25.834783', 'district', '105.218991', '25.834783', 3, NULL, '0859', '561400', 'Qinglong', 'Q', NULL);
INSERT INTO `ez_area` VALUES (522325, '贞丰县', 522300, '105.649864,25.38576', 'district', '105.649864', '25.38576', 3, NULL, '0859', '562200', 'Zhenfeng', 'Z', NULL);
INSERT INTO `ez_area` VALUES (522326, '望谟县', 522300, '106.099617,25.178421', 'district', '106.099617', '25.178421', 3, NULL, '0859', '552300', 'Wangmo', 'W', NULL);
INSERT INTO `ez_area` VALUES (522327, '册亨县', 522300, '105.811592,24.983663', 'district', '105.811592', '24.983663', 3, NULL, '0859', '552200', 'Ceheng', 'C', NULL);
INSERT INTO `ez_area` VALUES (522328, '安龙县', 522300, '105.442701,25.099014', 'district', '105.442701', '25.099014', 3, NULL, '0859', '552400', 'Anlong', 'A', NULL);
INSERT INTO `ez_area` VALUES (522600, '黔东南苗族侗族自治州', 520000, '107.982874,26.583457', 'city', '107.982874', '26.583457', 2, NULL, '0855', '556000', 'Qiandongnan', 'Q', NULL);
INSERT INTO `ez_area` VALUES (522601, '凯里市', 522600, '107.97754,26.582963', 'district', '107.97754', '26.582963', 3, NULL, '0855', '556000', 'Kaili', 'K', NULL);
INSERT INTO `ez_area` VALUES (522622, '黄平县', 522600, '107.916411,26.905396', 'district', '107.916411', '26.905396', 3, NULL, '0855', '556100', 'Huangping', 'H', NULL);
INSERT INTO `ez_area` VALUES (522623, '施秉县', 522600, '108.124379,27.03292', 'district', '108.124379', '27.03292', 3, NULL, '0855', '556200', 'Shibing', 'S', NULL);
INSERT INTO `ez_area` VALUES (522624, '三穗县', 522600, '108.675267,26.952967', 'district', '108.675267', '26.952967', 3, NULL, '0855', '556500', 'Sansui', 'S', NULL);
INSERT INTO `ez_area` VALUES (522625, '镇远县', 522600, '108.429534,27.049497', 'district', '108.429534', '27.049497', 3, NULL, '0855', '557700', 'Zhenyuan', 'Z', NULL);
INSERT INTO `ez_area` VALUES (522626, '岑巩县', 522600, '108.81606,27.173887', 'district', '108.81606', '27.173887', 3, NULL, '0855', '557800', 'Cengong', 'C', NULL);
INSERT INTO `ez_area` VALUES (522627, '天柱县', 522600, '109.207751,26.909639', 'district', '109.207751', '26.909639', 3, NULL, '0855', '556600', 'Tianzhu', 'T', NULL);
INSERT INTO `ez_area` VALUES (522628, '锦屏县', 522600, '109.200534,26.676233', 'district', '109.200534', '26.676233', 3, NULL, '0855', '556700', 'Jinping', 'J', NULL);
INSERT INTO `ez_area` VALUES (522629, '剑河县', 522600, '108.441501,26.728274', 'district', '108.441501', '26.728274', 3, NULL, '0855', '556400', 'Jianhe', 'J', NULL);
INSERT INTO `ez_area` VALUES (522630, '台江县', 522600, '108.321245,26.667525', 'district', '108.321245', '26.667525', 3, NULL, '0855', '556300', 'Taijiang', 'T', NULL);
INSERT INTO `ez_area` VALUES (522631, '黎平县', 522600, '109.136932,26.230706', 'district', '109.136932', '26.230706', 3, NULL, '0855', '557300', 'Liping', 'L', NULL);
INSERT INTO `ez_area` VALUES (522632, '榕江县', 522600, '108.52188,25.931893', 'district', '108.52188', '25.931893', 3, NULL, '0855', '557200', 'Rongjiang', 'R', NULL);
INSERT INTO `ez_area` VALUES (522633, '从江县', 522600, '108.905329,25.753009', 'district', '108.905329', '25.753009', 3, NULL, '0855', '557400', 'Congjiang', 'C', NULL);
INSERT INTO `ez_area` VALUES (522634, '雷山县', 522600, '108.07754,26.378442', 'district', '108.07754', '26.378442', 3, NULL, '0855', '557100', 'Leishan', 'L', NULL);
INSERT INTO `ez_area` VALUES (522635, '麻江县', 522600, '107.589359,26.491105', 'district', '107.589359', '26.491105', 3, NULL, '0855', '557600', 'Majiang', 'M', NULL);
INSERT INTO `ez_area` VALUES (522636, '丹寨县', 522600, '107.788727,26.19832', 'district', '107.788727', '26.19832', 3, NULL, '0855', '557500', 'Danzhai', 'D', NULL);
INSERT INTO `ez_area` VALUES (522700, '黔南布依族苗族自治州', 520000, '107.522171,26.253275', 'city', '107.522171', '26.253275', 2, NULL, '0854', '558000', 'Qiannan', 'Q', NULL);
INSERT INTO `ez_area` VALUES (522701, '都匀市', 522700, '107.518847,26.259427', 'district', '107.518847', '26.259427', 3, NULL, '0854', '558000', 'Duyun', 'D', NULL);
INSERT INTO `ez_area` VALUES (522702, '福泉市', 522700, '107.520386,26.686335', 'district', '107.520386', '26.686335', 3, NULL, '0854', '550500', 'Fuquan', 'F', NULL);
INSERT INTO `ez_area` VALUES (522722, '荔波县', 522700, '107.898882,25.423895', 'district', '107.898882', '25.423895', 3, NULL, '0854', '558400', 'Libo', 'L', NULL);
INSERT INTO `ez_area` VALUES (522723, '贵定县', 522700, '107.232793,26.557089', 'district', '107.232793', '26.557089', 3, NULL, '0854', '551300', 'Guiding', 'G', NULL);
INSERT INTO `ez_area` VALUES (522725, '瓮安县', 522700, '107.470942,27.078441', 'district', '107.470942', '27.078441', 3, NULL, '0854', '550400', 'Weng\'an', 'W', NULL);
INSERT INTO `ez_area` VALUES (522726, '独山县', 522700, '107.545048,25.822132', 'district', '107.545048', '25.822132', 3, NULL, '0854', '558200', 'Dushan', 'D', NULL);
INSERT INTO `ez_area` VALUES (522727, '平塘县', 522700, '107.322323,25.822349', 'district', '107.322323', '25.822349', 3, NULL, '0854', '558300', 'Pingtang', 'P', NULL);
INSERT INTO `ez_area` VALUES (522728, '罗甸县', 522700, '106.751589,25.426173', 'district', '106.751589', '25.426173', 3, NULL, '0854', '550100', 'Luodian', 'L', NULL);
INSERT INTO `ez_area` VALUES (522729, '长顺县', 522700, '106.441805,26.025626', 'district', '106.441805', '26.025626', 3, NULL, '0854', '550700', 'Changshun', 'C', NULL);
INSERT INTO `ez_area` VALUES (522730, '龙里县', 522700, '106.979524,26.453154', 'district', '106.979524', '26.453154', 3, NULL, '0854', '551200', 'Longli', 'L', NULL);
INSERT INTO `ez_area` VALUES (522731, '惠水县', 522700, '106.656442,26.13278', 'district', '106.656442', '26.13278', 3, NULL, '0854', '550600', 'Huishui', 'H', NULL);
INSERT INTO `ez_area` VALUES (522732, '三都水族自治县', 522700, '107.869749,25.983202', 'district', '107.869749', '25.983202', 3, NULL, '0854', '558100', 'Sandu', 'S', NULL);
INSERT INTO `ez_area` VALUES (530000, '云南省', 0, '102.710002,25.045806', 'province', '102.710002', '25.045806', 1, NULL, NULL, NULL, 'Yunnan', 'Y', NULL);
INSERT INTO `ez_area` VALUES (530100, '昆明市', 530000, '102.832891,24.880095', 'city', '102.832891', '24.880095', 2, NULL, '0871', '650500', 'Kunming', 'K', NULL);
INSERT INTO `ez_area` VALUES (530102, '五华区', 530100, '102.707262,25.043635', 'district', '102.707262', '25.043635', 3, NULL, '0871', '650021', 'Wuhua', 'W', NULL);
INSERT INTO `ez_area` VALUES (530103, '盘龙区', 530100, '102.751941,25.116465', 'district', '102.751941', '25.116465', 3, NULL, '0871', '650051', 'Panlong', 'P', NULL);
INSERT INTO `ez_area` VALUES (530111, '官渡区', 530100, '102.749026,24.950231', 'district', '102.749026', '24.950231', 3, NULL, '0871', '650200', 'Guandu', 'G', NULL);
INSERT INTO `ez_area` VALUES (530112, '西山区', 530100, '102.664382,25.038604', 'district', '102.664382', '25.038604', 3, NULL, '0871', '650118', 'Xishan', 'X', NULL);
INSERT INTO `ez_area` VALUES (530113, '东川区', 530100, '103.187824,26.082873', 'district', '103.187824', '26.082873', 3, NULL, '0871', '654100', 'Dongchuan', 'D', NULL);
INSERT INTO `ez_area` VALUES (530114, '呈贡区', 530100, '102.821675,24.885587', 'district', '102.821675', '24.885587', 3, NULL, '0871', '650500', 'Chenggong', 'C', NULL);
INSERT INTO `ez_area` VALUES (530115, '晋宁区', 530100, '102.595412,24.66974', 'district', '102.595412', '24.66974', 3, NULL, '0871', '650600', 'Jinning', 'J', NULL);
INSERT INTO `ez_area` VALUES (530124, '富民县', 530100, '102.4976,25.221935', 'district', '102.4976', '25.221935', 3, NULL, '0871', '650400', 'Fumin', 'F', NULL);
INSERT INTO `ez_area` VALUES (530125, '宜良县', 530100, '103.141603,24.919839', 'district', '103.141603', '24.919839', 3, NULL, '0871', '652100', 'Yiliang', 'Y', NULL);
INSERT INTO `ez_area` VALUES (530126, '石林彝族自治县', 530100, '103.290536,24.771761', 'district', '103.290536', '24.771761', 3, NULL, '0871', '652200', 'Shilin', 'S', NULL);
INSERT INTO `ez_area` VALUES (530127, '嵩明县', 530100, '103.036908,25.338643', 'district', '103.036908', '25.338643', 3, NULL, '0871', '651700', 'Songming', 'S', NULL);
INSERT INTO `ez_area` VALUES (530128, '禄劝彝族苗族自治县', 530100, '102.471518,25.551332', 'district', '102.471518', '25.551332', 3, NULL, '0871', '651500', 'Luquan', 'L', NULL);
INSERT INTO `ez_area` VALUES (530129, '寻甸回族彝族自治县', 530100, '103.256615,25.558201', 'district', '103.256615', '25.558201', 3, NULL, '0871', '655200', 'Xundian', 'X', NULL);
INSERT INTO `ez_area` VALUES (530181, '安宁市', 530100, '102.478494,24.919493', 'district', '102.478494', '24.919493', 3, NULL, '0871', '650300', 'Anning', 'A', NULL);
INSERT INTO `ez_area` VALUES (530300, '曲靖市', 530000, '103.796167,25.489999', 'city', '103.796167', '25.489999', 2, NULL, '0874', '655000', 'Qujing', 'Q', NULL);
INSERT INTO `ez_area` VALUES (530302, '麒麟区', 530300, '103.80474,25.495326', 'district', '103.80474', '25.495326', 3, NULL, '0874', '655000', 'Qilin', 'Q', NULL);
INSERT INTO `ez_area` VALUES (530303, '沾益区', 530300, '103.822324,25.600507', 'district', '103.822324', '25.600507', 3, NULL, '0874', '655331', 'Zhanyi', 'Z', NULL);
INSERT INTO `ez_area` VALUES (530321, '马龙县', 530300, '103.578478,25.42805', 'district', '103.578478', '25.42805', 3, NULL, '0874', '655100', 'Malong', 'M', NULL);
INSERT INTO `ez_area` VALUES (530322, '陆良县', 530300, '103.666663,25.030051', 'district', '103.666663', '25.030051', 3, NULL, '0874', '655600', 'Luliang', 'L', NULL);
INSERT INTO `ez_area` VALUES (530323, '师宗县', 530300, '103.985321,24.822233', 'district', '103.985321', '24.822233', 3, NULL, '0874', '655700', 'Shizong', 'S', NULL);
INSERT INTO `ez_area` VALUES (530324, '罗平县', 530300, '104.308675,24.884626', 'district', '104.308675', '24.884626', 3, NULL, '0874', '655800', 'Luoping', 'L', NULL);
INSERT INTO `ez_area` VALUES (530325, '富源县', 530300, '104.255014,25.674238', 'district', '104.255014', '25.674238', 3, NULL, '0874', '655500', 'Fuyuan', 'F', NULL);
INSERT INTO `ez_area` VALUES (530326, '会泽县', 530300, '103.297386,26.417345', 'district', '103.297386', '26.417345', 3, NULL, '0874', '654200', 'Huize', 'H', NULL);
INSERT INTO `ez_area` VALUES (530381, '宣威市', 530300, '104.10455,26.219735', 'district', '104.10455', '26.219735', 3, NULL, '0874', '655400', 'Xuanwei', 'X', NULL);
INSERT INTO `ez_area` VALUES (530400, '玉溪市', 530000, '102.527197,24.347324', 'city', '102.527197', '24.347324', 2, NULL, '0877', '653100', 'Yuxi', 'Y', NULL);
INSERT INTO `ez_area` VALUES (530402, '红塔区', 530400, '102.540122,24.341215', 'district', '102.540122', '24.341215', 3, NULL, '0877', '653100', 'Hongta', 'H', NULL);
INSERT INTO `ez_area` VALUES (530403, '江川区', 530400, '102.75344,24.287485', 'district', '102.75344', '24.287485', 3, NULL, '0877', '652600', 'Jiangchuan', 'J', NULL);
INSERT INTO `ez_area` VALUES (530422, '澄江县', 530400, '102.904629,24.675689', 'district', '102.904629', '24.675689', 3, NULL, '0877', '652500', 'Chengjiang', 'C', NULL);
INSERT INTO `ez_area` VALUES (530423, '通海县', 530400, '102.725452,24.111048', 'district', '102.725452', '24.111048', 3, NULL, '0877', '652700', 'Tonghai', 'T', NULL);
INSERT INTO `ez_area` VALUES (530424, '华宁县', 530400, '102.928835,24.19276', 'district', '102.928835', '24.19276', 3, NULL, '0877', '652800', 'Huaning', 'H', NULL);
INSERT INTO `ez_area` VALUES (530425, '易门县', 530400, '102.162531,24.671651', 'district', '102.162531', '24.671651', 3, NULL, '0877', '651100', 'Yimen', 'Y', NULL);
INSERT INTO `ez_area` VALUES (530426, '峨山彝族自治县', 530400, '102.405819,24.168957', 'district', '102.405819', '24.168957', 3, NULL, '0877', '653200', 'Eshan', 'E', NULL);
INSERT INTO `ez_area` VALUES (530427, '新平彝族傣族自治县', 530400, '101.990157,24.07005', 'district', '101.990157', '24.07005', 3, NULL, '0877', '653400', 'Xinping', 'X', NULL);
INSERT INTO `ez_area` VALUES (530428, '元江哈尼族彝族傣族自治县', 530400, '101.998103,23.596503', 'district', '101.998103', '23.596503', 3, NULL, '0877', '653300', 'Yuanjiang', 'Y', NULL);
INSERT INTO `ez_area` VALUES (530500, '保山市', 530000, '99.161761,25.112046', 'city', '99.161761', '25.112046', 2, NULL, '0875', '678000', 'Baoshan', 'B', NULL);
INSERT INTO `ez_area` VALUES (530502, '隆阳区', 530500, '99.165607,25.121154', 'district', '99.165607', '25.121154', 3, NULL, '0875', '678000', 'Longyang', 'L', NULL);
INSERT INTO `ez_area` VALUES (530521, '施甸县', 530500, '99.189221,24.723064', 'district', '99.189221', '24.723064', 3, NULL, '0875', '678200', 'Shidian', 'S', NULL);
INSERT INTO `ez_area` VALUES (530523, '龙陵县', 530500, '98.689261,24.586794', 'district', '98.689261', '24.586794', 3, NULL, '0875', '678300', 'Longling', 'L', NULL);
INSERT INTO `ez_area` VALUES (530524, '昌宁县', 530500, '99.605142,24.827839', 'district', '99.605142', '24.827839', 3, NULL, '0875', '678100', 'Changning', 'C', NULL);
INSERT INTO `ez_area` VALUES (530581, '腾冲市', 530500, '98.490966,25.020439', 'district', '98.490966', '25.020439', 3, NULL, '0875', '679100', 'Tengchong', 'T', NULL);
INSERT INTO `ez_area` VALUES (530600, '昭通市', 530000, '103.717465,27.338257', 'city', '103.717465', '27.338257', 2, NULL, '0870', '657000', 'Zhaotong', 'Z', NULL);
INSERT INTO `ez_area` VALUES (530602, '昭阳区', 530600, '103.706539,27.320075', 'district', '103.706539', '27.320075', 3, NULL, '0870', '657000', 'Zhaoyang', 'Z', NULL);
INSERT INTO `ez_area` VALUES (530621, '鲁甸县', 530600, '103.558042,27.186659', 'district', '103.558042', '27.186659', 3, NULL, '0870', '657100', 'Ludian', 'L', NULL);
INSERT INTO `ez_area` VALUES (530622, '巧家县', 530600, '102.930164,26.90846', 'district', '102.930164', '26.90846', 3, NULL, '0870', '654600', 'Qiaojia', 'Q', NULL);
INSERT INTO `ez_area` VALUES (530623, '盐津县', 530600, '104.234441,28.10871', 'district', '104.234441', '28.10871', 3, NULL, '0870', '657500', 'Yanjin', 'Y', NULL);
INSERT INTO `ez_area` VALUES (530624, '大关县', 530600, '103.891146,27.747978', 'district', '103.891146', '27.747978', 3, NULL, '0870', '657400', 'Daguan', 'D', NULL);
INSERT INTO `ez_area` VALUES (530625, '永善县', 530600, '103.638067,28.229112', 'district', '103.638067', '28.229112', 3, NULL, '0870', '657300', 'Yongshan', 'Y', NULL);
INSERT INTO `ez_area` VALUES (530626, '绥江县', 530600, '103.968978,28.592099', 'district', '103.968978', '28.592099', 3, NULL, '0870', '657700', 'Suijiang', 'S', NULL);
INSERT INTO `ez_area` VALUES (530627, '镇雄县', 530600, '104.87376,27.441622', 'district', '104.87376', '27.441622', 3, NULL, '0870', '657200', 'Zhenxiong', 'Z', NULL);
INSERT INTO `ez_area` VALUES (530628, '彝良县', 530600, '104.048289,27.625418', 'district', '104.048289', '27.625418', 3, NULL, '0870', '657600', 'Yiliang', 'Y', NULL);
INSERT INTO `ez_area` VALUES (530629, '威信县', 530600, '105.049027,27.8469', 'district', '105.049027', '27.8469', 3, NULL, '0870', '657900', 'Weixin', 'W', NULL);
INSERT INTO `ez_area` VALUES (530630, '水富县', 530600, '104.41603,28.62988', 'district', '104.41603', '28.62988', 3, NULL, '0870', '657800', 'Shuifu', 'S', NULL);
INSERT INTO `ez_area` VALUES (530700, '丽江市', 530000, '100.22775,26.855047', 'city', '100.22775', '26.855047', 2, NULL, '0888', '674100', 'Lijiang', 'L', NULL);
INSERT INTO `ez_area` VALUES (530702, '古城区', 530700, '100.225784,26.876927', 'district', '100.225784', '26.876927', 3, NULL, '0888', '674100', 'Gucheng', 'G', NULL);
INSERT INTO `ez_area` VALUES (530721, '玉龙纳西族自治县', 530700, '100.236954,26.821459', 'district', '100.236954', '26.821459', 3, NULL, '0888', '674100', 'Yulong', 'Y', NULL);
INSERT INTO `ez_area` VALUES (530722, '永胜县', 530700, '100.750826,26.684225', 'district', '100.750826', '26.684225', 3, NULL, '0888', '674200', 'Yongsheng', 'Y', NULL);
INSERT INTO `ez_area` VALUES (530723, '华坪县', 530700, '101.266195,26.629211', 'district', '101.266195', '26.629211', 3, NULL, '0888', '674800', 'Huaping', 'H', NULL);
INSERT INTO `ez_area` VALUES (530724, '宁蒗彝族自治县', 530700, '100.852001,27.28207', 'district', '100.852001', '27.28207', 3, NULL, '0888', '674300', 'Ninglang', 'N', NULL);
INSERT INTO `ez_area` VALUES (530800, '普洱市', 530000, '100.966156,22.825155', 'city', '100.966156', '22.825155', 2, NULL, '0879', '665000', 'Pu\'er', 'P', NULL);
INSERT INTO `ez_area` VALUES (530802, '思茅区', 530800, '100.977256,22.787115', 'district', '100.977256', '22.787115', 3, NULL, '0879', '665000', 'Simao', 'S', NULL);
INSERT INTO `ez_area` VALUES (530821, '宁洱哈尼族彝族自治县', 530800, '101.045837,23.048401', 'district', '101.045837', '23.048401', 3, NULL, '0879', '665100', 'Ninger', 'N', NULL);
INSERT INTO `ez_area` VALUES (530822, '墨江哈尼族自治县', 530800, '101.692461,23.431894', 'district', '101.692461', '23.431894', 3, NULL, '0879', '654800', 'Mojiang', 'M', NULL);
INSERT INTO `ez_area` VALUES (530823, '景东彝族自治县', 530800, '100.833877,24.446731', 'district', '100.833877', '24.446731', 3, NULL, '0879', '676200', 'Jingdong', 'J', NULL);
INSERT INTO `ez_area` VALUES (530824, '景谷傣族彝族自治县', 530800, '100.702871,23.497028', 'district', '100.702871', '23.497028', 3, NULL, '0879', '666400', 'Jinggu', 'J', NULL);
INSERT INTO `ez_area` VALUES (530825, '镇沅彝族哈尼族拉祜族自治县', 530800, '101.108595,24.004441', 'district', '101.108595', '24.004441', 3, NULL, '0879', '666500', 'Zhenyuan', 'Z', NULL);
INSERT INTO `ez_area` VALUES (530826, '江城哈尼族彝族自治县', 530800, '101.86212,22.585867', 'district', '101.86212', '22.585867', 3, NULL, '0879', '665900', 'Jiangcheng', 'J', NULL);
INSERT INTO `ez_area` VALUES (530827, '孟连傣族拉祜族佤族自治县', 530800, '99.584157,22.329099', 'district', '99.584157', '22.329099', 3, NULL, '0879', '665800', 'Menglian', 'M', NULL);
INSERT INTO `ez_area` VALUES (530828, '澜沧拉祜族自治县', 530800, '99.931975,22.555904', 'district', '99.931975', '22.555904', 3, NULL, '0879', '665600', 'Lancang', 'L', NULL);
INSERT INTO `ez_area` VALUES (530829, '西盟佤族自治县', 530800, '99.590123,22.644508', 'district', '99.590123', '22.644508', 3, NULL, '0879', '665700', 'Ximeng', 'X', NULL);
INSERT INTO `ez_area` VALUES (530900, '临沧市', 530000, '100.08879,23.883955', 'city', '100.08879', '23.883955', 2, NULL, '0883', '677000', 'Lincang', 'L', NULL);
INSERT INTO `ez_area` VALUES (530902, '临翔区', 530900, '100.082523,23.895137', 'district', '100.082523', '23.895137', 3, NULL, '0883', '677000', 'Linxiang', 'L', NULL);
INSERT INTO `ez_area` VALUES (530921, '凤庆县', 530900, '99.928459,24.580424', 'district', '99.928459', '24.580424', 3, NULL, '0883', '675900', 'Fengqing', 'F', NULL);
INSERT INTO `ez_area` VALUES (530922, '云县', 530900, '100.129354,24.44422', 'district', '100.129354', '24.44422', 3, NULL, '0883', '675800', 'Yunxian', 'Y', NULL);
INSERT INTO `ez_area` VALUES (530923, '永德县', 530900, '99.259339,24.018357', 'district', '99.259339', '24.018357', 3, NULL, '0883', '677600', 'Yongde', 'Y', NULL);
INSERT INTO `ez_area` VALUES (530924, '镇康县', 530900, '98.825284,23.762584', 'district', '98.825284', '23.762584', 3, NULL, '0883', '677704', 'Zhenkang', 'Z', NULL);
INSERT INTO `ez_area` VALUES (530925, '双江拉祜族佤族布朗族傣族自治县', 530900, '99.827697,23.473499', 'district', '99.827697', '23.473499', 3, NULL, '0883', '677300', 'Shuangjiang', 'S', NULL);
INSERT INTO `ez_area` VALUES (530926, '耿马傣族佤族自治县', 530900, '99.397126,23.538092', 'district', '99.397126', '23.538092', 3, NULL, '0883', '677500', 'Gengma', 'G', NULL);
INSERT INTO `ez_area` VALUES (530927, '沧源佤族自治县', 530900, '99.246196,23.146712', 'district', '99.246196', '23.146712', 3, NULL, '0883', '677400', 'Cangyuan', 'C', NULL);
INSERT INTO `ez_area` VALUES (532300, '楚雄彝族自治州', 530000, '101.527992,25.045513', 'city', '101.527992', '25.045513', 2, NULL, '0878', '675000', 'Chuxiong', 'C', NULL);
INSERT INTO `ez_area` VALUES (532301, '楚雄市', 532300, '101.545906,25.032889', 'district', '101.545906', '25.032889', 3, NULL, '0878', '675000', 'Chuxiong', 'C', NULL);
INSERT INTO `ez_area` VALUES (532322, '双柏县', 532300, '101.641937,24.688875', 'district', '101.641937', '24.688875', 3, NULL, '0878', '675100', 'Shuangbai', 'S', NULL);
INSERT INTO `ez_area` VALUES (532323, '牟定县', 532300, '101.546566,25.313121', 'district', '101.546566', '25.313121', 3, NULL, '0878', '675500', 'Mouding', 'M', NULL);
INSERT INTO `ez_area` VALUES (532324, '南华县', 532300, '101.273577,25.192293', 'district', '101.273577', '25.192293', 3, NULL, '0878', '675200', 'Nanhua', 'N', NULL);
INSERT INTO `ez_area` VALUES (532325, '姚安县', 532300, '101.241728,25.504173', 'district', '101.241728', '25.504173', 3, NULL, '0878', '675300', 'Yao\'an', 'Y', NULL);
INSERT INTO `ez_area` VALUES (532326, '大姚县', 532300, '101.336617,25.729513', 'district', '101.336617', '25.729513', 3, NULL, '0878', '675400', 'Dayao', 'D', NULL);
INSERT INTO `ez_area` VALUES (532327, '永仁县', 532300, '101.666132,26.049464', 'district', '101.666132', '26.049464', 3, NULL, '0878', '651400', 'Yongren', 'Y', NULL);
INSERT INTO `ez_area` VALUES (532328, '元谋县', 532300, '101.87452,25.704338', 'district', '101.87452', '25.704338', 3, NULL, '0878', '651300', 'Yuanmou', 'Y', NULL);
INSERT INTO `ez_area` VALUES (532329, '武定县', 532300, '102.404337,25.530389', 'district', '102.404337', '25.530389', 3, NULL, '0878', '651600', 'Wuding', 'W', NULL);
INSERT INTO `ez_area` VALUES (532331, '禄丰县', 532300, '102.079027,25.150111', 'district', '102.079027', '25.150111', 3, NULL, '0878', '651200', 'Lufeng', 'L', NULL);
INSERT INTO `ez_area` VALUES (532500, '红河哈尼族彝族自治州', 530000, '103.374893,23.363245', 'city', '103.374893', '23.363245', 2, NULL, '0873', '661400', 'Honghe', 'H', NULL);
INSERT INTO `ez_area` VALUES (532501, '个旧市', 532500, '103.160034,23.359121', 'district', '103.160034', '23.359121', 3, NULL, '0873', '661000', 'Gejiu', 'G', NULL);
INSERT INTO `ez_area` VALUES (532502, '开远市', 532500, '103.266624,23.714523', 'district', '103.266624', '23.714523', 3, NULL, '0873', '661600', 'Kaiyuan', 'K', NULL);
INSERT INTO `ez_area` VALUES (532503, '蒙自市', 532500, '103.364905,23.396201', 'district', '103.364905', '23.396201', 3, NULL, '0873', '661101', 'Mengzi', 'M', NULL);
INSERT INTO `ez_area` VALUES (532504, '弥勒市', 532500, '103.414874,24.411912', 'district', '103.414874', '24.411912', 3, NULL, '0873', '652300', 'Mile ', 'M', NULL);
INSERT INTO `ez_area` VALUES (532523, '屏边苗族自治县', 532500, '103.687612,22.983559', 'district', '103.687612', '22.983559', 3, NULL, '0873', '661200', 'Pingbian', 'P', NULL);
INSERT INTO `ez_area` VALUES (532524, '建水县', 532500, '102.826557,23.6347', 'district', '102.826557', '23.6347', 3, NULL, '0873', '654300', 'Jianshui', 'J', NULL);
INSERT INTO `ez_area` VALUES (532525, '石屏县', 532500, '102.494983,23.705936', 'district', '102.494983', '23.705936', 3, NULL, '0873', '662200', 'Shiping', 'S', NULL);
INSERT INTO `ez_area` VALUES (532527, '泸西县', 532500, '103.766196,24.532025', 'district', '103.766196', '24.532025', 3, NULL, '0873', '652400', 'Luxi', 'L', NULL);
INSERT INTO `ez_area` VALUES (532528, '元阳县', 532500, '102.835223,23.219932', 'district', '102.835223', '23.219932', 3, NULL, '0873', '662400', 'Yuanyang', 'Y', NULL);
INSERT INTO `ez_area` VALUES (532529, '红河县', 532500, '102.4206,23.369161', 'district', '102.4206', '23.369161', 3, NULL, '0873', '654400', 'Honghexian', 'H', NULL);
INSERT INTO `ez_area` VALUES (532530, '金平苗族瑶族傣族自治县', 532500, '103.226448,22.779543', 'district', '103.226448', '22.779543', 3, NULL, '0873', '661500', 'Jinping', 'J', NULL);
INSERT INTO `ez_area` VALUES (532531, '绿春县', 532500, '102.392463,22.993717', 'district', '102.392463', '22.993717', 3, NULL, '0873', '662500', 'Lvchun', 'L', NULL);
INSERT INTO `ez_area` VALUES (532532, '河口瑶族自治县', 532500, '103.93952,22.529645', 'district', '103.93952', '22.529645', 3, NULL, '0873', '661300', 'Hekou', 'H', NULL);
INSERT INTO `ez_area` VALUES (532600, '文山壮族苗族自治州', 530000, '104.216248,23.400733', 'city', '104.216248', '23.400733', 2, NULL, '0876', '663000', 'Wenshan', 'W', NULL);
INSERT INTO `ez_area` VALUES (532601, '文山市', 532600, '104.232665,23.386527', 'district', '104.232665', '23.386527', 3, NULL, '0876', '663000', 'Wenshan', 'W', NULL);
INSERT INTO `ez_area` VALUES (532622, '砚山县', 532600, '104.337211,23.605768', 'district', '104.337211', '23.605768', 3, NULL, '0876', '663100', 'Yanshan', 'Y', NULL);
INSERT INTO `ez_area` VALUES (532623, '西畴县', 532600, '104.672597,23.437782', 'district', '104.672597', '23.437782', 3, NULL, '0876', '663500', 'Xichou', 'X', NULL);
INSERT INTO `ez_area` VALUES (532624, '麻栗坡县', 532600, '104.702799,23.125714', 'district', '104.702799', '23.125714', 3, NULL, '0876', '663600', 'Malipo', 'M', NULL);
INSERT INTO `ez_area` VALUES (532625, '马关县', 532600, '104.394157,23.012915', 'district', '104.394157', '23.012915', 3, NULL, '0876', '663700', 'Maguan', 'M', NULL);
INSERT INTO `ez_area` VALUES (532626, '丘北县', 532600, '104.166587,24.051746', 'district', '104.166587', '24.051746', 3, NULL, '0876', '663200', 'Qiubei', 'Q', NULL);
INSERT INTO `ez_area` VALUES (532627, '广南县', 532600, '105.055107,24.046386', 'district', '105.055107', '24.046386', 3, NULL, '0876', '663300', 'Guangnan', 'G', NULL);
INSERT INTO `ez_area` VALUES (532628, '富宁县', 532600, '105.630999,23.625283', 'district', '105.630999', '23.625283', 3, NULL, '0876', '663400', 'Funing', 'F', NULL);
INSERT INTO `ez_area` VALUES (532800, '西双版纳傣族自治州', 530000, '100.796984,22.009113', 'city', '100.796984', '22.009113', 2, NULL, '0691', '666100', 'Xishuangbanna', 'X', NULL);
INSERT INTO `ez_area` VALUES (532801, '景洪市', 532800, '100.799545,22.011928', 'district', '100.799545', '22.011928', 3, NULL, '0691', '666100', 'Jinghong', 'J', NULL);
INSERT INTO `ez_area` VALUES (532822, '勐海县', 532800, '100.452547,21.957353', 'district', '100.452547', '21.957353', 3, NULL, '0691', '666200', 'Menghai', 'M', NULL);
INSERT INTO `ez_area` VALUES (532823, '勐腊县', 532800, '101.564635,21.459233', 'district', '101.564635', '21.459233', 3, NULL, '0691', '666300', 'Mengla', 'M', NULL);
INSERT INTO `ez_area` VALUES (532900, '大理白族自治州', 530000, '100.267638,25.606486', 'city', '100.267638', '25.606486', 2, NULL, '0872', '671000', 'Dali', 'D', NULL);
INSERT INTO `ez_area` VALUES (532901, '大理市', 532900, '100.30127,25.678068', 'district', '100.30127', '25.678068', 3, NULL, '0872', '671000', 'Dali', 'D', NULL);
INSERT INTO `ez_area` VALUES (532922, '漾濞彝族自治县', 532900, '99.958015,25.670148', 'district', '99.958015', '25.670148', 3, NULL, '0872', '672500', 'Yangbi', 'Y', NULL);
INSERT INTO `ez_area` VALUES (532923, '祥云县', 532900, '100.550945,25.48385', 'district', '100.550945', '25.48385', 3, NULL, '0872', '672100', 'Xiangyun', 'X', NULL);
INSERT INTO `ez_area` VALUES (532924, '宾川县', 532900, '100.590473,25.829828', 'district', '100.590473', '25.829828', 3, NULL, '0872', '671600', 'Binchuan', 'B', NULL);
INSERT INTO `ez_area` VALUES (532925, '弥渡县', 532900, '100.49099,25.343804', 'district', '100.49099', '25.343804', 3, NULL, '0872', '675600', 'Midu', 'M', NULL);
INSERT INTO `ez_area` VALUES (532926, '南涧彝族自治县', 532900, '100.509035,25.04351', 'district', '100.509035', '25.04351', 3, NULL, '0872', '675700', 'Nanjian', 'N', NULL);
INSERT INTO `ez_area` VALUES (532927, '巍山彝族回族自治县', 532900, '100.307174,25.227212', 'district', '100.307174', '25.227212', 3, NULL, '0872', '672400', 'Weishan', 'W', NULL);
INSERT INTO `ez_area` VALUES (532928, '永平县', 532900, '99.541236,25.464681', 'district', '99.541236', '25.464681', 3, NULL, '0872', '672600', 'Yongping', 'Y', NULL);
INSERT INTO `ez_area` VALUES (532929, '云龙县', 532900, '99.37112,25.885595', 'district', '99.37112', '25.885595', 3, NULL, '0872', '672700', 'Yunlong', 'Y', NULL);
INSERT INTO `ez_area` VALUES (532930, '洱源县', 532900, '99.951053,26.11116', 'district', '99.951053', '26.11116', 3, NULL, '0872', '671200', 'Eryuan', 'E', NULL);
INSERT INTO `ez_area` VALUES (532931, '剑川县', 532900, '99.905559,26.537033', 'district', '99.905559', '26.537033', 3, NULL, '0872', '671300', 'Jianchuan', 'J', NULL);
INSERT INTO `ez_area` VALUES (532932, '鹤庆县', 532900, '100.176498,26.560231', 'district', '100.176498', '26.560231', 3, NULL, '0872', '671500', 'Heqing', 'H', NULL);
INSERT INTO `ez_area` VALUES (533100, '德宏傣族景颇族自治州', 530000, '98.584895,24.433353', 'city', '98.584895', '24.433353', 2, NULL, '0692', '678400', 'Dehong', 'D', NULL);
INSERT INTO `ez_area` VALUES (533102, '瑞丽市', 533100, '97.85559,24.017958', 'district', '97.85559', '24.017958', 3, NULL, '0692', '678600', 'Ruili', 'R', NULL);
INSERT INTO `ez_area` VALUES (533103, '芒市', 533100, '98.588086,24.43369', 'district', '98.588086', '24.43369', 3, NULL, '0692', '678400', 'Mangshi', 'M', NULL);
INSERT INTO `ez_area` VALUES (533122, '梁河县', 533100, '98.296657,24.804232', 'district', '98.296657', '24.804232', 3, NULL, '0692', '679200', 'Lianghe', 'L', NULL);
INSERT INTO `ez_area` VALUES (533123, '盈江县', 533100, '97.931936,24.705164', 'district', '97.931936', '24.705164', 3, NULL, '0692', '679300', 'Yingjiang', 'Y', NULL);
INSERT INTO `ez_area` VALUES (533124, '陇川县', 533100, '97.792104,24.182965', 'district', '97.792104', '24.182965', 3, NULL, '0692', '678700', 'Longchuan', 'L', NULL);
INSERT INTO `ez_area` VALUES (533300, '怒江傈僳族自治州', 530000, '98.8566,25.817555', 'city', '98.8566', '25.817555', 2, NULL, '0886', '673100', 'Nujiang', 'N', NULL);
INSERT INTO `ez_area` VALUES (533301, '泸水市', 533300, '98.857977,25.822879', 'district', '98.857977', '25.822879', 3, NULL, '0886', '673100', 'Lushui', 'L', NULL);
INSERT INTO `ez_area` VALUES (533323, '福贡县', 533300, '98.869132,26.901831', 'district', '98.869132', '26.901831', 3, NULL, '0886', '673400', 'Fugong', 'F', NULL);
INSERT INTO `ez_area` VALUES (533324, '贡山独龙族怒族自治县', 533300, '98.665964,27.740999', 'district', '98.665964', '27.740999', 3, NULL, '0886', '673500', 'Gongshan', 'G', NULL);
INSERT INTO `ez_area` VALUES (533325, '兰坪白族普米族自治县', 533300, '99.416677,26.453571', 'district', '99.416677', '26.453571', 3, NULL, '0886', '671400', 'Lanping', 'L', NULL);
INSERT INTO `ez_area` VALUES (533400, '迪庆藏族自治州', 530000, '99.702583,27.818807', 'city', '99.702583', '27.818807', 2, NULL, '0887', '674400', 'Deqen', 'D', NULL);
INSERT INTO `ez_area` VALUES (533401, '香格里拉市', 533400, '99.700904,27.829578', 'district', '99.700904', '27.829578', 3, NULL, '0887', '674400', 'Xianggelila', 'X', NULL);
INSERT INTO `ez_area` VALUES (533422, '德钦县', 533400, '98.911559,28.486163', 'district', '98.911559', '28.486163', 3, NULL, '0887', '674500', 'Deqin', 'D', NULL);
INSERT INTO `ez_area` VALUES (533423, '维西傈僳族自治县', 533400, '99.287173,27.177161', 'district', '99.287173', '27.177161', 3, NULL, '0887', '674600', 'Weixi', 'W', NULL);
INSERT INTO `ez_area` VALUES (540000, '西藏自治区', 0, '91.117525,29.647535', 'province', '91.117525', '29.647535', 1, NULL, NULL, NULL, 'Tibet', 'T', NULL);
INSERT INTO `ez_area` VALUES (540100, '拉萨市', 540000, '91.172148,29.652341', 'city', '91.172148', '29.652341', 2, NULL, '0891', '850000', 'Lhasa', 'L', NULL);
INSERT INTO `ez_area` VALUES (540102, '城关区', 540100, '91.140552,29.654838', 'district', '91.140552', '29.654838', 3, NULL, '0891', '850000', 'Chengguan', 'C', NULL);
INSERT INTO `ez_area` VALUES (540103, '堆龙德庆区', 540100, '91.003339,29.646063', 'district', '91.003339', '29.646063', 3, NULL, '0891', '851400', 'Duilongdeqing', 'D', NULL);
INSERT INTO `ez_area` VALUES (540121, '林周县', 540100, '91.265287,29.893545', 'district', '91.265287', '29.893545', 3, NULL, '0891', '851600', 'Linzhou', 'L', NULL);
INSERT INTO `ez_area` VALUES (540122, '当雄县', 540100, '91.101162,30.473118', 'district', '91.101162', '30.473118', 3, NULL, '0891', '851500', 'Dangxiong', 'D', NULL);
INSERT INTO `ez_area` VALUES (540123, '尼木县', 540100, '90.164524,29.431831', 'district', '90.164524', '29.431831', 3, NULL, '0891', '851300', 'Nimu', 'N', NULL);
INSERT INTO `ez_area` VALUES (540124, '曲水县', 540100, '90.743853,29.353058', 'district', '90.743853', '29.353058', 3, NULL, '0891', '850600', 'Qushui', 'Q', NULL);
INSERT INTO `ez_area` VALUES (540126, '达孜县', 540100, '91.349867,29.66941', 'district', '91.349867', '29.66941', 3, NULL, '0891', '850100', 'Dazi', 'D', NULL);
INSERT INTO `ez_area` VALUES (540127, '墨竹工卡县', 540100, '91.730732,29.834111', 'district', '91.730732', '29.834111', 3, NULL, '0891', '850200', 'Mozhugongka', 'M', NULL);
INSERT INTO `ez_area` VALUES (540200, '日喀则市', 540000, '88.880583,29.266869', 'city', '88.880583', '29.266869', 2, NULL, '0892', '857000', 'Rikaze', 'R', NULL);
INSERT INTO `ez_area` VALUES (540202, '桑珠孜区', 540200, '88.898483,29.24779', 'district', '88.898483', '29.24779', 3, NULL, '0892', '857000', 'Sangzhuzi', 'S', NULL);
INSERT INTO `ez_area` VALUES (540221, '南木林县', 540200, '89.099242,29.68233', 'district', '89.099242', '29.68233', 3, NULL, '0892', '857100', 'Nanmulin', 'N', NULL);
INSERT INTO `ez_area` VALUES (540222, '江孜县', 540200, '89.605627,28.911626', 'district', '89.605627', '28.911626', 3, NULL, '0892', '857400', 'Jiangzi', 'J', NULL);
INSERT INTO `ez_area` VALUES (540223, '定日县', 540200, '87.12612,28.658743', 'district', '87.12612', '28.658743', 3, NULL, '0892', '858200', 'Dingri', 'D', NULL);
INSERT INTO `ez_area` VALUES (540224, '萨迦县', 540200, '88.021674,28.899664', 'district', '88.021674', '28.899664', 3, NULL, '0892', '857800', 'Sajia', 'S', NULL);
INSERT INTO `ez_area` VALUES (540225, '拉孜县', 540200, '87.63704,29.081659', 'district', '87.63704', '29.081659', 3, NULL, '0892', '858100', 'Lazi', 'L', NULL);
INSERT INTO `ez_area` VALUES (540226, '昂仁县', 540200, '87.236051,29.294802', 'district', '87.236051', '29.294802', 3, NULL, '0892', '858500', 'Angren', 'A', NULL);
INSERT INTO `ez_area` VALUES (540227, '谢通门县', 540200, '88.261664,29.432476', 'district', '88.261664', '29.432476', 3, NULL, '0892', '858900', 'Xietongmen', 'X', NULL);
INSERT INTO `ez_area` VALUES (540228, '白朗县', 540200, '89.261977,29.107688', 'district', '89.261977', '29.107688', 3, NULL, '0892', '857300', 'Bailang', 'B', NULL);
INSERT INTO `ez_area` VALUES (540229, '仁布县', 540200, '89.841983,29.230933', 'district', '89.841983', '29.230933', 3, NULL, '0892', '857200', 'Renbu', 'R', NULL);
INSERT INTO `ez_area` VALUES (540230, '康马县', 540200, '89.681663,28.555627', 'district', '89.681663', '28.555627', 3, NULL, '0892', '857500', 'Kangma', 'K', NULL);
INSERT INTO `ez_area` VALUES (540231, '定结县', 540200, '87.765872,28.364159', 'district', '87.765872', '28.364159', 3, NULL, '0892', '857900', 'Dingjie', 'D', NULL);
INSERT INTO `ez_area` VALUES (540232, '仲巴县', 540200, '84.03153,29.770279', 'district', '84.03153', '29.770279', 3, NULL, '0892', '858800', 'Zhongba', 'Z', NULL);
INSERT INTO `ez_area` VALUES (540233, '亚东县', 540200, '88.907093,27.484806', 'district', '88.907093', '27.484806', 3, NULL, '0892', '857600', 'Yadong', 'Y', NULL);
INSERT INTO `ez_area` VALUES (540234, '吉隆县', 540200, '85.297534,28.852393', 'district', '85.297534', '28.852393', 3, NULL, '0892', '858700', 'Jilong', 'J', NULL);
INSERT INTO `ez_area` VALUES (540235, '聂拉木县', 540200, '85.982237,28.155186', 'district', '85.982237', '28.155186', 3, NULL, '0892', '858300', 'Nielamu', 'N', NULL);
INSERT INTO `ez_area` VALUES (540236, '萨嘎县', 540200, '85.232941,29.328818', 'district', '85.232941', '29.328818', 3, NULL, '0892', '857800', 'Saga', 'S', NULL);
INSERT INTO `ez_area` VALUES (540237, '岗巴县', 540200, '88.520031,28.274601', 'district', '88.520031', '28.274601', 3, NULL, '0892', '857700', 'Gangba', 'G', NULL);
INSERT INTO `ez_area` VALUES (540300, '昌都市', 540000, '97.17202,31.140969', 'city', '97.17202', '31.140969', 2, NULL, '0895', '854000', 'Qamdo', 'Q', NULL);
INSERT INTO `ez_area` VALUES (540302, '卡若区', 540300, '97.196021,31.112087', 'district', '97.196021', '31.112087', 3, NULL, '0895', '854000', 'Karuo', 'K', NULL);
INSERT INTO `ez_area` VALUES (540321, '江达县', 540300, '98.21843,31.499202', 'district', '98.21843', '31.499202', 3, NULL, '0895', '854100', 'Jiangda', 'J', NULL);
INSERT INTO `ez_area` VALUES (540322, '贡觉县', 540300, '98.27097,30.860099', 'district', '98.27097', '30.860099', 3, NULL, '0895', '854200', 'Gongjue', 'G', NULL);
INSERT INTO `ez_area` VALUES (540323, '类乌齐县', 540300, '96.600246,31.211601', 'district', '96.600246', '31.211601', 3, NULL, '0895', '855600', 'Leiwuqi', 'L', NULL);
INSERT INTO `ez_area` VALUES (540324, '丁青县', 540300, '95.619868,31.409024', 'district', '95.619868', '31.409024', 3, NULL, '0895', '855700', 'Dingqing', 'D', NULL);
INSERT INTO `ez_area` VALUES (540325, '察雅县', 540300, '97.568752,30.653943', 'district', '97.568752', '30.653943', 3, NULL, '0895', '854300', 'Chaya', 'C', NULL);
INSERT INTO `ez_area` VALUES (540326, '八宿县', 540300, '96.917836,30.053209', 'district', '96.917836', '30.053209', 3, NULL, '0895', '854600', 'Basu', 'B', NULL);
INSERT INTO `ez_area` VALUES (540327, '左贡县', 540300, '97.841022,29.671069', 'district', '97.841022', '29.671069', 3, NULL, '0895', '854400', 'Zuogong', 'Z', NULL);
INSERT INTO `ez_area` VALUES (540328, '芒康县', 540300, '98.593113,29.679907', 'district', '98.593113', '29.679907', 3, NULL, '0895', '854500', 'Mangkang', 'M', NULL);
INSERT INTO `ez_area` VALUES (540329, '洛隆县', 540300, '95.825197,30.741845', 'district', '95.825197', '30.741845', 3, NULL, '0895', '855400', 'Luolong', 'L', NULL);
INSERT INTO `ez_area` VALUES (540330, '边坝县', 540300, '94.7078,30.933652', 'district', '94.7078', '30.933652', 3, NULL, '0895', '855500', 'Bianba', 'B', NULL);
INSERT INTO `ez_area` VALUES (540400, '林芝市', 540000, '94.36149,29.649128', 'city', '94.36149', '29.649128', 2, NULL, '0894', '850400', 'Linzhi', 'L', NULL);
INSERT INTO `ez_area` VALUES (540402, '巴宜区', 540400, '94.361094,29.636576', 'district', '94.361094', '29.636576', 3, NULL, '0894', '540401', 'Bayi', 'B', NULL);
INSERT INTO `ez_area` VALUES (540421, '工布江达县', 540400, '93.246077,29.88528', 'district', '93.246077', '29.88528', 3, NULL, '0894', '850300', 'Gongbujiangda', 'G', NULL);
INSERT INTO `ez_area` VALUES (540422, '米林县', 540400, '94.213679,29.213811', 'district', '94.213679', '29.213811', 3, NULL, '0894', '850500', 'Milin', 'M', NULL);
INSERT INTO `ez_area` VALUES (540423, '墨脱县', 540400, '95.333197,29.325298', 'district', '95.333197', '29.325298', 3, NULL, '0894', '855300', 'Motuo', 'M', NULL);
INSERT INTO `ez_area` VALUES (540424, '波密县', 540400, '95.767913,29.859028', 'district', '95.767913', '29.859028', 3, NULL, '0894', '855200', 'Bomi', 'B', NULL);
INSERT INTO `ez_area` VALUES (540425, '察隅县', 540400, '97.466919,28.66128', 'district', '97.466919', '28.66128', 3, NULL, '0894', '855100', 'Chayu', 'C', NULL);
INSERT INTO `ez_area` VALUES (540426, '朗县', 540400, '93.074702,29.046337', 'district', '93.074702', '29.046337', 3, NULL, '0894', '856500', 'Langxian', 'L', NULL);
INSERT INTO `ez_area` VALUES (540500, '山南市', 540000, '91.773134,29.237137', 'city', '91.773134', '29.237137', 2, NULL, '0893', '856000', 'Shannan', 'S', NULL);
INSERT INTO `ez_area` VALUES (540502, '乃东区', 540500, '91.761538,29.224904', 'district', '91.761538', '29.224904', 3, NULL, '0893', '856100', 'Naidong', 'N', NULL);
INSERT INTO `ez_area` VALUES (540521, '扎囊县', 540500, '91.33725,29.245113', 'district', '91.33725', '29.245113', 3, NULL, '0893', '850800', 'Zhanang', 'Z', NULL);
INSERT INTO `ez_area` VALUES (540522, '贡嘎县', 540500, '90.98414,29.289455', 'district', '90.98414', '29.289455', 3, NULL, '0893', '850700', 'Gongga', 'G', NULL);
INSERT INTO `ez_area` VALUES (540523, '桑日县', 540500, '92.015818,29.259189', 'district', '92.015818', '29.259189', 3, NULL, '0893', '856200', 'Sangri', 'S', NULL);
INSERT INTO `ez_area` VALUES (540524, '琼结县', 540500, '91.683881,29.024625', 'district', '91.683881', '29.024625', 3, NULL, '0893', '856800', 'Qiongjie', 'Q', NULL);
INSERT INTO `ez_area` VALUES (540525, '曲松县', 540500, '92.203738,29.062826', 'district', '92.203738', '29.062826', 3, NULL, '0893', '856300', 'Qusong', 'Q', NULL);
INSERT INTO `ez_area` VALUES (540526, '措美县', 540500, '91.433509,28.438202', 'district', '91.433509', '28.438202', 3, NULL, '0893', '856900', 'Cuomei', 'C', NULL);
INSERT INTO `ez_area` VALUES (540527, '洛扎县', 540500, '90.859992,28.385713', 'district', '90.859992', '28.385713', 3, NULL, '0893', '856600', 'Luozha', 'L', NULL);
INSERT INTO `ez_area` VALUES (540528, '加查县', 540500, '92.593993,29.14029', 'district', '92.593993', '29.14029', 3, NULL, '0893', '856400', 'Jiacha', 'J', NULL);
INSERT INTO `ez_area` VALUES (540529, '隆子县', 540500, '92.463308,28.408548', 'district', '92.463308', '28.408548', 3, NULL, '0893', '856600', 'Longzi', 'L', NULL);
INSERT INTO `ez_area` VALUES (540530, '错那县', 540500, '91.960132,27.991707', 'district', '91.960132', '27.991707', 3, NULL, '0893', '856700', 'Cuona', 'C', NULL);
INSERT INTO `ez_area` VALUES (540531, '浪卡子县', 540500, '90.397977,28.968031', 'district', '90.397977', '28.968031', 3, NULL, '0893', '851100', 'Langkazi', 'L', NULL);
INSERT INTO `ez_area` VALUES (542400, '那曲地区', 540000, '92.052064,31.476479', 'city', '92.052064', '31.476479', 2, NULL, '0896', '852000', 'Nagqu', 'N', NULL);
INSERT INTO `ez_area` VALUES (542421, '那曲县', 542400, '92.0535,31.469643', 'district', '92.0535', '31.469643', 3, NULL, '0896', '852000', 'Naqu', 'N', NULL);
INSERT INTO `ez_area` VALUES (542422, '嘉黎县', 542400, '93.232528,30.640814', 'district', '93.232528', '30.640814', 3, NULL, '0896', '852400', 'Jiali', 'J', NULL);
INSERT INTO `ez_area` VALUES (542423, '比如县', 542400, '93.679639,31.480249', 'district', '93.679639', '31.480249', 3, NULL, '0896', '852300', 'Biru', 'B', NULL);
INSERT INTO `ez_area` VALUES (542424, '聂荣县', 542400, '92.303377,32.10775', 'district', '92.303377', '32.10775', 3, NULL, '0896', '853500', 'Nierong', 'N', NULL);
INSERT INTO `ez_area` VALUES (542425, '安多县', 542400, '91.68233,32.265176', 'district', '91.68233', '32.265176', 3, NULL, '0896', '853400', 'Anduo', 'A', NULL);
INSERT INTO `ez_area` VALUES (542426, '申扎县', 542400, '88.709852,30.930505', 'district', '88.709852', '30.930505', 3, NULL, '0896', '853100', 'Shenzha', 'S', NULL);
INSERT INTO `ez_area` VALUES (542427, '索县', 542400, '93.785516,31.886671', 'district', '93.785516', '31.886671', 3, NULL, '0896', '852200', 'Suoxian', 'S', NULL);
INSERT INTO `ez_area` VALUES (542428, '班戈县', 542400, '90.009957,31.392411', 'district', '90.009957', '31.392411', 3, NULL, '0896', '852500', 'Bange', 'B', NULL);
INSERT INTO `ez_area` VALUES (542429, '巴青县', 542400, '94.053438,31.91847', 'district', '94.053438', '31.91847', 3, NULL, '0896', '852100', 'Baqing', 'B', NULL);
INSERT INTO `ez_area` VALUES (542430, '尼玛县', 542400, '87.236772,31.784701', 'district', '87.236772', '31.784701', 3, NULL, '0896', '852600', 'Nima', 'N', NULL);
INSERT INTO `ez_area` VALUES (542431, '双湖县', 542400, '88.837641,33.188514', 'district', '88.837641', '33.188514', 3, NULL, '0896', '852600', 'Shuanghu', 'S', NULL);
INSERT INTO `ez_area` VALUES (542500, '阿里地区', 540000, '80.105804,32.501111', 'city', '80.105804', '32.501111', 2, NULL, '0897', '859000', 'Ngari', 'N', NULL);
INSERT INTO `ez_area` VALUES (542521, '普兰县', 542500, '81.176237,30.294402', 'district', '81.176237', '30.294402', 3, NULL, '0897', '859500', 'Pulan', 'P', NULL);
INSERT INTO `ez_area` VALUES (542522, '札达县', 542500, '79.802706,31.479216', 'district', '79.802706', '31.479216', 3, NULL, '0897', '859600', 'Zhada', 'Z', NULL);
INSERT INTO `ez_area` VALUES (542523, '噶尔县', 542500, '80.096419,32.491488', 'district', '80.096419', '32.491488', 3, NULL, '0897', '859400', 'Gaer', 'G', NULL);
INSERT INTO `ez_area` VALUES (542524, '日土县', 542500, '79.732427,33.381359', 'district', '79.732427', '33.381359', 3, NULL, '0897', '859700', 'Ritu', 'R', NULL);
INSERT INTO `ez_area` VALUES (542525, '革吉县', 542500, '81.145433,32.387233', 'district', '81.145433', '32.387233', 3, NULL, '0897', '859100', 'Geji', 'G', NULL);
INSERT INTO `ez_area` VALUES (542526, '改则县', 542500, '84.06259,32.302713', 'district', '84.06259', '32.302713', 3, NULL, '0897', '859200', 'Gaize', 'G', NULL);
INSERT INTO `ez_area` VALUES (542527, '措勤县', 542500, '85.151455,31.017312', 'district', '85.151455', '31.017312', 3, NULL, '0897', '859300', 'Cuoqin', 'C', NULL);
INSERT INTO `ez_area` VALUES (610000, '陕西省', 0, '108.954347,34.265502', 'province', '108.954347', '34.265502', 1, NULL, NULL, NULL, 'Shaanxi', 'S', NULL);
INSERT INTO `ez_area` VALUES (610100, '西安市', 610000, '108.93977,34.341574', 'city', '108.93977', '34.341574', 2, NULL, '029', '710003', 'Xi\'an', 'X', NULL);
INSERT INTO `ez_area` VALUES (610102, '新城区', 610100, '108.960716,34.266447', 'district', '108.960716', '34.266447', 3, NULL, '029', '710004', 'Xincheng', 'X', NULL);
INSERT INTO `ez_area` VALUES (610103, '碑林区', 610100, '108.94059,34.256783', 'district', '108.94059', '34.256783', 3, NULL, '029', '710001', 'Beilin', 'B', NULL);
INSERT INTO `ez_area` VALUES (610104, '莲湖区', 610100, '108.943895,34.265239', 'district', '108.943895', '34.265239', 3, NULL, '029', '710003', 'Lianhu', 'L', NULL);
INSERT INTO `ez_area` VALUES (610111, '灞桥区', 610100, '109.064646,34.272793', 'district', '109.064646', '34.272793', 3, NULL, '029', '710038', 'Baqiao', 'B', NULL);
INSERT INTO `ez_area` VALUES (610112, '未央区', 610100, '108.946825,34.29292', 'district', '108.946825', '34.29292', 3, NULL, '029', '710014', 'Weiyang', 'W', NULL);
INSERT INTO `ez_area` VALUES (610113, '雁塔区', 610100, '108.944644,34.214113', 'district', '108.944644', '34.214113', 3, NULL, '029', '710061', 'Yanta', 'Y', NULL);
INSERT INTO `ez_area` VALUES (610114, '阎良区', 610100, '109.226124,34.662232', 'district', '109.226124', '34.662232', 3, NULL, '029', '710087', 'Yanliang', 'Y', NULL);
INSERT INTO `ez_area` VALUES (610115, '临潼区', 610100, '109.214237,34.367069', 'district', '109.214237', '34.367069', 3, NULL, '029', '710600', 'Lintong', 'L', NULL);
INSERT INTO `ez_area` VALUES (610116, '长安区', 610100, '108.907173,34.158926', 'district', '108.907173', '34.158926', 3, NULL, '029', '710100', 'Chang\'an', 'C', NULL);
INSERT INTO `ez_area` VALUES (610117, '高陵区', 610100, '109.088297,34.534829', 'district', '109.088297', '34.534829', 3, NULL, '029', '710200', 'Gaoling', 'G', NULL);
INSERT INTO `ez_area` VALUES (610118, '鄠邑区', 610100, '108.604894,34.109244', 'district', '108.604894', '34.109244', 3, NULL, '029', '710300', 'Huyi', 'H', NULL);
INSERT INTO `ez_area` VALUES (610122, '蓝田县', 610100, '109.32345,34.151298', 'district', '109.32345', '34.151298', 3, NULL, '029', '710500', 'Lantian', 'L', NULL);
INSERT INTO `ez_area` VALUES (610124, '周至县', 610100, '108.222162,34.163669', 'district', '108.222162', '34.163669', 3, NULL, '029', '710400', 'Zhouzhi', 'Z', NULL);
INSERT INTO `ez_area` VALUES (610200, '铜川市', 610000, '108.945019,34.897887', 'city', '108.945019', '34.897887', 2, NULL, '0919', '727100', 'Tongchuan', 'T', NULL);
INSERT INTO `ez_area` VALUES (610202, '王益区', 610200, '109.075578,35.068964', 'district', '109.075578', '35.068964', 3, NULL, '0919', '727000', 'Wangyi', 'W', NULL);
INSERT INTO `ez_area` VALUES (610203, '印台区', 610200, '109.099974,35.114492', 'district', '109.099974', '35.114492', 3, NULL, '0919', '727007', 'Yintai', 'Y', NULL);
INSERT INTO `ez_area` VALUES (610204, '耀州区', 610200, '108.980102,34.909793', 'district', '108.980102', '34.909793', 3, NULL, '0919', '727100', 'Yaozhou', 'Y', NULL);
INSERT INTO `ez_area` VALUES (610222, '宜君县', 610200, '109.116932,35.398577', 'district', '109.116932', '35.398577', 3, NULL, '0919', '727200', 'Yijun', 'Y', NULL);
INSERT INTO `ez_area` VALUES (610300, '宝鸡市', 610000, '107.237743,34.363184', 'city', '107.237743', '34.363184', 2, NULL, '0917', '721000', 'Baoji', 'B', NULL);
INSERT INTO `ez_area` VALUES (610302, '渭滨区', 610300, '107.155344,34.355068', 'district', '107.155344', '34.355068', 3, NULL, '0917', '721000', 'Weibin', 'W', NULL);
INSERT INTO `ez_area` VALUES (610303, '金台区', 610300, '107.146806,34.376069', 'district', '107.146806', '34.376069', 3, NULL, '0917', '721000', 'Jintai', 'J', NULL);
INSERT INTO `ez_area` VALUES (610304, '陈仓区', 610300, '107.369987,34.35147', 'district', '107.369987', '34.35147', 3, NULL, '0917', '721300', 'Chencang', 'C', NULL);
INSERT INTO `ez_area` VALUES (610322, '凤翔县', 610300, '107.400737,34.521217', 'district', '107.400737', '34.521217', 3, NULL, '0917', '721400', 'Fengxiang', 'F', NULL);
INSERT INTO `ez_area` VALUES (610323, '岐山县', 610300, '107.621053,34.443459', 'district', '107.621053', '34.443459', 3, NULL, '0917', '722400', 'Qishan', 'Q', NULL);
INSERT INTO `ez_area` VALUES (610324, '扶风县', 610300, '107.900219,34.37541', 'district', '107.900219', '34.37541', 3, NULL, '0917', '722200', 'Fufeng', 'F', NULL);
INSERT INTO `ez_area` VALUES (610326, '眉县', 610300, '107.749766,34.274246', 'district', '107.749766', '34.274246', 3, NULL, '0917', '722300', 'Meixian', 'M', NULL);
INSERT INTO `ez_area` VALUES (610327, '陇县', 610300, '106.864397,34.89305', 'district', '106.864397', '34.89305', 3, NULL, '0917', '721200', 'Longxian', 'L', NULL);
INSERT INTO `ez_area` VALUES (610328, '千阳县', 610300, '107.132441,34.642381', 'district', '107.132441', '34.642381', 3, NULL, '0917', '721100', 'Qianyang', 'Q', NULL);
INSERT INTO `ez_area` VALUES (610329, '麟游县', 610300, '107.793524,34.677902', 'district', '107.793524', '34.677902', 3, NULL, '0917', '721500', 'Linyou', 'L', NULL);
INSERT INTO `ez_area` VALUES (610330, '凤县', 610300, '106.515803,33.91091', 'district', '106.515803', '33.91091', 3, NULL, '0917', '721700', 'Fengxian', 'F', NULL);
INSERT INTO `ez_area` VALUES (610331, '太白县', 610300, '107.319116,34.058401', 'district', '107.319116', '34.058401', 3, NULL, '0917', '721600', 'Taibai', 'T', NULL);
INSERT INTO `ez_area` VALUES (610400, '咸阳市', 610000, '108.709136,34.32987', 'city', '108.709136', '34.32987', 2, NULL, '029', '712000', 'Xianyang', 'X', NULL);
INSERT INTO `ez_area` VALUES (610402, '秦都区', 610400, '108.706272,34.329567', 'district', '108.706272', '34.329567', 3, NULL, '029', '712000', 'Qindu', 'Q', NULL);
INSERT INTO `ez_area` VALUES (610403, '杨陵区', 610400, '108.084731,34.272117', 'district', '108.084731', '34.272117', 3, NULL, '029', '712100', 'Yangling', 'Y', NULL);
INSERT INTO `ez_area` VALUES (610404, '渭城区', 610400, '108.737204,34.36195', 'district', '108.737204', '34.36195', 3, NULL, '029', '712000', 'Weicheng', 'W', NULL);
INSERT INTO `ez_area` VALUES (610422, '三原县', 610400, '108.940509,34.617381', 'district', '108.940509', '34.617381', 3, NULL, '029', '713800', 'Sanyuan', 'S', NULL);
INSERT INTO `ez_area` VALUES (610423, '泾阳县', 610400, '108.842622,34.527114', 'district', '108.842622', '34.527114', 3, NULL, '029', '713700', 'Jingyang', 'J', NULL);
INSERT INTO `ez_area` VALUES (610424, '乾县', 610400, '108.239473,34.527551', 'district', '108.239473', '34.527551', 3, NULL, '029', '713300', 'Qianxian', 'Q', NULL);
INSERT INTO `ez_area` VALUES (610425, '礼泉县', 610400, '108.425018,34.481764', 'district', '108.425018', '34.481764', 3, NULL, '029', '713200', 'Liquan', 'L', NULL);
INSERT INTO `ez_area` VALUES (610426, '永寿县', 610400, '108.142311,34.691979', 'district', '108.142311', '34.691979', 3, NULL, '029', '713400', 'Yongshou', 'Y', NULL);
INSERT INTO `ez_area` VALUES (610427, '彬县', 610400, '108.077658,35.043911', 'district', '108.077658', '35.043911', 3, NULL, '029', '713500', 'Binxian', 'B', NULL);
INSERT INTO `ez_area` VALUES (610428, '长武县', 610400, '107.798757,35.205886', 'district', '107.798757', '35.205886', 3, NULL, '029', '713600', 'Changwu', 'C', NULL);
INSERT INTO `ez_area` VALUES (610429, '旬邑县', 610400, '108.333986,35.111978', 'district', '108.333986', '35.111978', 3, NULL, '029', '711300', 'Xunyi', 'X', NULL);
INSERT INTO `ez_area` VALUES (610430, '淳化县', 610400, '108.580681,34.79925', 'district', '108.580681', '34.79925', 3, NULL, '029', '711200', 'Chunhua', 'C', NULL);
INSERT INTO `ez_area` VALUES (610431, '武功县', 610400, '108.200398,34.260203', 'district', '108.200398', '34.260203', 3, NULL, '029', '712200', 'Wugong', 'W', NULL);
INSERT INTO `ez_area` VALUES (610481, '兴平市', 610400, '108.490475,34.29922', 'district', '108.490475', '34.29922', 3, NULL, '029', '713100', 'Xingping', 'X', NULL);
INSERT INTO `ez_area` VALUES (610500, '渭南市', 610000, '109.471094,34.52044', 'city', '109.471094', '34.52044', 2, NULL, '0913', '714000', 'Weinan', 'W', NULL);
INSERT INTO `ez_area` VALUES (610502, '临渭区', 610500, '109.510175,34.499314', 'district', '109.510175', '34.499314', 3, NULL, '0913', '714000', 'Linwei', 'L', NULL);
INSERT INTO `ez_area` VALUES (610503, '华州区', 610500, '109.775247,34.495915', 'district', '109.775247', '34.495915', 3, NULL, '0913', '714100', 'Huazhou', 'H', NULL);
INSERT INTO `ez_area` VALUES (610522, '潼关县', 610500, '110.246349,34.544296', 'district', '110.246349', '34.544296', 3, NULL, '0913', '714300', 'Tongguan', 'T', NULL);
INSERT INTO `ez_area` VALUES (610523, '大荔县', 610500, '109.941734,34.797259', 'district', '109.941734', '34.797259', 3, NULL, '0913', '715100', 'Dali', 'D', NULL);
INSERT INTO `ez_area` VALUES (610524, '合阳县', 610500, '110.149453,35.237988', 'district', '110.149453', '35.237988', 3, NULL, '0913', '715300', 'Heyang', 'H', NULL);
INSERT INTO `ez_area` VALUES (610525, '澄城县', 610500, '109.93235,35.190245', 'district', '109.93235', '35.190245', 3, NULL, '0913', '715200', 'Chengcheng', 'C', NULL);
INSERT INTO `ez_area` VALUES (610526, '蒲城县', 610500, '109.586403,34.955562', 'district', '109.586403', '34.955562', 3, NULL, '0913', '715500', 'Pucheng', 'P', NULL);
INSERT INTO `ez_area` VALUES (610527, '白水县', 610500, '109.590671,35.177451', 'district', '109.590671', '35.177451', 3, NULL, '0913', '715600', 'Baishui', 'B', NULL);
INSERT INTO `ez_area` VALUES (610528, '富平县', 610500, '109.18032,34.751077', 'district', '109.18032', '34.751077', 3, NULL, '0913', '711700', 'Fuping', 'F', NULL);
INSERT INTO `ez_area` VALUES (610581, '韩城市', 610500, '110.442846,35.476788', 'district', '110.442846', '35.476788', 3, NULL, '0913', '715400', 'Hancheng', 'H', NULL);
INSERT INTO `ez_area` VALUES (610582, '华阴市', 610500, '110.092078,34.566079', 'district', '110.092078', '34.566079', 3, NULL, '0913', '714200', 'Huayin', 'H', NULL);
INSERT INTO `ez_area` VALUES (610600, '延安市', 610000, '109.494112,36.651381', 'city', '109.494112', '36.651381', 2, NULL, '0911', '716000', 'Yan\'an', 'Y', NULL);
INSERT INTO `ez_area` VALUES (610602, '宝塔区', 610600, '109.48976,36.585472', 'district', '109.48976', '36.585472', 3, NULL, '0911', '716000', 'Baota', 'B', NULL);
INSERT INTO `ez_area` VALUES (610603, '安塞区', 610600, '109.328842,36.863853', 'district', '109.328842', '36.863853', 3, NULL, '0911', '717400', 'Ansai', 'A', NULL);
INSERT INTO `ez_area` VALUES (610621, '延长县', 610600, '110.012334,36.579313', 'district', '110.012334', '36.579313', 3, NULL, '0911', '717100', 'Yanchang', 'Y', NULL);
INSERT INTO `ez_area` VALUES (610622, '延川县', 610600, '110.193514,36.878117', 'district', '110.193514', '36.878117', 3, NULL, '0911', '717200', 'Yanchuan', 'Y', NULL);
INSERT INTO `ez_area` VALUES (610623, '子长县', 610600, '109.675264,37.142535', 'district', '109.675264', '37.142535', 3, NULL, '0911', '717300', 'Zichang', 'Z', NULL);
INSERT INTO `ez_area` VALUES (610625, '志丹县', 610600, '108.768432,36.822194', 'district', '108.768432', '36.822194', 3, NULL, '0911', '717500', 'Zhidan', 'Z', NULL);
INSERT INTO `ez_area` VALUES (610626, '吴起县', 610600, '108.175933,36.927215', 'district', '108.175933', '36.927215', 3, NULL, '0911', '717600', 'Wuqi', 'W', NULL);
INSERT INTO `ez_area` VALUES (610627, '甘泉县', 610600, '109.351019,36.276526', 'district', '109.351019', '36.276526', 3, NULL, '0911', '716100', 'Ganquan', 'G', NULL);
INSERT INTO `ez_area` VALUES (610628, '富县', 610600, '109.379776,35.987953', 'district', '109.379776', '35.987953', 3, NULL, '0911', '727500', 'Fuxian', 'F', NULL);
INSERT INTO `ez_area` VALUES (610629, '洛川县', 610600, '109.432369,35.761974', 'district', '109.432369', '35.761974', 3, NULL, '0911', '727400', 'Luochuan', 'L', NULL);
INSERT INTO `ez_area` VALUES (610630, '宜川县', 610600, '110.168963,36.050178', 'district', '110.168963', '36.050178', 3, NULL, '0911', '716200', 'Yichuan', 'Y', NULL);
INSERT INTO `ez_area` VALUES (610631, '黄龙县', 610600, '109.840314,35.584743', 'district', '109.840314', '35.584743', 3, NULL, '0911', '715700', 'Huanglong', 'H', NULL);
INSERT INTO `ez_area` VALUES (610632, '黄陵县', 610600, '109.262961,35.579427', 'district', '109.262961', '35.579427', 3, NULL, '0911', '727300', 'Huangling', 'H', NULL);
INSERT INTO `ez_area` VALUES (610700, '汉中市', 610000, '107.02305,33.067225', 'city', '107.02305', '33.067225', 2, NULL, '0916', '723000', 'Hanzhong', 'H', NULL);
INSERT INTO `ez_area` VALUES (610702, '汉台区', 610700, '107.031856,33.067771', 'district', '107.031856', '33.067771', 3, NULL, '0916', '723000', 'Hantai', 'H', NULL);
INSERT INTO `ez_area` VALUES (610721, '南郑县', 610700, '106.93623,32.999333', 'district', '106.93623', '32.999333', 3, NULL, '0916', '723100', 'Nanzheng', 'N', NULL);
INSERT INTO `ez_area` VALUES (610722, '城固县', 610700, '107.33393,33.157131', 'district', '107.33393', '33.157131', 3, NULL, '0916', '723200', 'Chenggu', 'C', NULL);
INSERT INTO `ez_area` VALUES (610723, '洋县', 610700, '107.545836,33.222738', 'district', '107.545836', '33.222738', 3, NULL, '0916', '723300', 'Yangxian', 'Y', NULL);
INSERT INTO `ez_area` VALUES (610724, '西乡县', 610700, '107.766613,32.983101', 'district', '107.766613', '32.983101', 3, NULL, '0916', '723500', 'Xixiang', 'X', NULL);
INSERT INTO `ez_area` VALUES (610725, '勉县', 610700, '106.673221,33.153553', 'district', '106.673221', '33.153553', 3, NULL, '0916', '724200', 'Mianxian', 'M', NULL);
INSERT INTO `ez_area` VALUES (610726, '宁强县', 610700, '106.257171,32.829694', 'district', '106.257171', '32.829694', 3, NULL, '0916', '724400', 'Ningqiang', 'N', NULL);
INSERT INTO `ez_area` VALUES (610727, '略阳县', 610700, '106.156718,33.327281', 'district', '106.156718', '33.327281', 3, NULL, '0916', '724300', 'Lueyang', 'L', NULL);
INSERT INTO `ez_area` VALUES (610728, '镇巴县', 610700, '107.895035,32.536704', 'district', '107.895035', '32.536704', 3, NULL, '0916', '723600', 'Zhenba', 'Z', NULL);
INSERT INTO `ez_area` VALUES (610729, '留坝县', 610700, '106.920808,33.617571', 'district', '106.920808', '33.617571', 3, NULL, '0916', '724100', 'Liuba', 'L', NULL);
INSERT INTO `ez_area` VALUES (610730, '佛坪县', 610700, '107.990538,33.524359', 'district', '107.990538', '33.524359', 3, NULL, '0916', '723400', 'Foping', 'F', NULL);
INSERT INTO `ez_area` VALUES (610800, '榆林市', 610000, '109.734474,38.285369', 'city', '109.734474', '38.285369', 2, NULL, '0912', '719000', 'Yulin', 'Y', NULL);
INSERT INTO `ez_area` VALUES (610802, '榆阳区', 610800, '109.721069,38.277046', 'district', '109.721069', '38.277046', 3, NULL, '0912', '719000', 'Yuyang', 'Y', NULL);
INSERT INTO `ez_area` VALUES (610803, '横山区', 610800, '109.294346,37.962208', 'district', '109.294346', '37.962208', 3, NULL, '0912', '719100', 'Hengshan', 'H', NULL);
INSERT INTO `ez_area` VALUES (610822, '府谷县', 610800, '111.067276,39.028116', 'district', '111.067276', '39.028116', 3, NULL, '0912', '719400', 'Fugu', 'F', NULL);
INSERT INTO `ez_area` VALUES (610824, '靖边县', 610800, '108.793988,37.599438', 'district', '108.793988', '37.599438', 3, NULL, '0912', '718500', 'Jingbian', 'J', NULL);
INSERT INTO `ez_area` VALUES (610825, '定边县', 610800, '107.601267,37.594612', 'district', '107.601267', '37.594612', 3, NULL, '0912', '718600', 'Dingbian', 'D', NULL);
INSERT INTO `ez_area` VALUES (610826, '绥德县', 610800, '110.263362,37.50294', 'district', '110.263362', '37.50294', 3, NULL, '0912', '718000', 'Suide', 'S', NULL);
INSERT INTO `ez_area` VALUES (610827, '米脂县', 610800, '110.183754,37.755416', 'district', '110.183754', '37.755416', 3, NULL, '0912', '718100', 'Mizhi', 'M', NULL);
INSERT INTO `ez_area` VALUES (610828, '佳县', 610800, '110.491345,38.01951', 'district', '110.491345', '38.01951', 3, NULL, '0912', '719200', 'Jiaxian', 'J', NULL);
INSERT INTO `ez_area` VALUES (610829, '吴堡县', 610800, '110.739673,37.452067', 'district', '110.739673', '37.452067', 3, NULL, '0912', '718200', 'Wubu', 'W', NULL);
INSERT INTO `ez_area` VALUES (610830, '清涧县', 610800, '110.121209,37.088878', 'district', '110.121209', '37.088878', 3, NULL, '0912', '718300', 'Qingjian', 'Q', NULL);
INSERT INTO `ez_area` VALUES (610831, '子洲县', 610800, '110.03525,37.610683', 'district', '110.03525', '37.610683', 3, NULL, '0912', '718400', 'Zizhou', 'Z', NULL);
INSERT INTO `ez_area` VALUES (610881, '神木市', 610800, '110.498939,38.842578', 'district', '110.498939', '38.842578', 3, NULL, '0912', '719300', 'Shenmu', 'S', NULL);
INSERT INTO `ez_area` VALUES (610900, '安康市', 610000, '109.029113,32.68481', 'city', '109.029113', '32.68481', 2, NULL, '0915', '725000', 'Ankang', 'A', NULL);
INSERT INTO `ez_area` VALUES (610902, '汉滨区', 610900, '109.026836,32.695172', 'district', '109.026836', '32.695172', 3, NULL, '0915', '725000', 'Hanbin', 'H', NULL);
INSERT INTO `ez_area` VALUES (610921, '汉阴县', 610900, '108.508745,32.893026', 'district', '108.508745', '32.893026', 3, NULL, '0915', '725100', 'Hanyin', 'H', NULL);
INSERT INTO `ez_area` VALUES (610922, '石泉县', 610900, '108.247886,33.038408', 'district', '108.247886', '33.038408', 3, NULL, '0915', '725200', 'Shiquan', 'S', NULL);
INSERT INTO `ez_area` VALUES (610923, '宁陕县', 610900, '108.314283,33.310527', 'district', '108.314283', '33.310527', 3, NULL, '0915', '711600', 'Ningshan', 'N', NULL);
INSERT INTO `ez_area` VALUES (610924, '紫阳县', 610900, '108.534228,32.520246', 'district', '108.534228', '32.520246', 3, NULL, '0915', '725300', 'Ziyang', 'Z', NULL);
INSERT INTO `ez_area` VALUES (610925, '岚皋县', 610900, '108.902049,32.307001', 'district', '108.902049', '32.307001', 3, NULL, '0915', '725400', 'Langao', 'L', NULL);
INSERT INTO `ez_area` VALUES (610926, '平利县', 610900, '109.361864,32.388854', 'district', '109.361864', '32.388854', 3, NULL, '0915', '725500', 'Pingli', 'P', NULL);
INSERT INTO `ez_area` VALUES (610927, '镇坪县', 610900, '109.526873,31.883672', 'district', '109.526873', '31.883672', 3, NULL, '0915', '725600', 'Zhenping', 'Z', NULL);
INSERT INTO `ez_area` VALUES (610928, '旬阳县', 610900, '109.361024,32.832012', 'district', '109.361024', '32.832012', 3, NULL, '0915', '725700', 'Xunyang', 'X', NULL);
INSERT INTO `ez_area` VALUES (610929, '白河县', 610900, '110.112629,32.809026', 'district', '110.112629', '32.809026', 3, NULL, '0915', '725800', 'Baihe', 'B', NULL);
INSERT INTO `ez_area` VALUES (611000, '商洛市', 610000, '109.91857,33.872726', 'city', '109.91857', '33.872726', 2, NULL, '0914', '726000', 'Shangluo', 'S', NULL);
INSERT INTO `ez_area` VALUES (611002, '商州区', 611000, '109.941839,33.862599', 'district', '109.941839', '33.862599', 3, NULL, '0914', '726000', 'Shangzhou', 'S', NULL);
INSERT INTO `ez_area` VALUES (611021, '洛南县', 611000, '110.148508,34.090837', 'district', '110.148508', '34.090837', 3, NULL, '0914', '726100', 'Luonan', 'L', NULL);
INSERT INTO `ez_area` VALUES (611022, '丹凤县', 611000, '110.32733,33.695783', 'district', '110.32733', '33.695783', 3, NULL, '0914', '726200', 'Danfeng', 'D', NULL);
INSERT INTO `ez_area` VALUES (611023, '商南县', 611000, '110.881807,33.530995', 'district', '110.881807', '33.530995', 3, NULL, '0914', '726300', 'Shangnan', 'S', NULL);
INSERT INTO `ez_area` VALUES (611024, '山阳县', 611000, '109.882289,33.532172', 'district', '109.882289', '33.532172', 3, NULL, '0914', '726400', 'Shanyang', 'S', NULL);
INSERT INTO `ez_area` VALUES (611025, '镇安县', 611000, '109.152892,33.423357', 'district', '109.152892', '33.423357', 3, NULL, '0914', '711500', 'Zhen\'an', 'Z', NULL);
INSERT INTO `ez_area` VALUES (611026, '柞水县', 611000, '109.114206,33.68611', 'district', '109.114206', '33.68611', 3, NULL, '0914', '711400', 'Zhashui', 'Z', NULL);
INSERT INTO `ez_area` VALUES (620000, '甘肃省', 0, '103.826447,36.05956', 'province', '103.826447', '36.05956', 1, NULL, NULL, NULL, 'Gansu', 'G', NULL);
INSERT INTO `ez_area` VALUES (620100, '兰州市', 620000, '103.834303,36.061089', 'city', '103.834303', '36.061089', 2, NULL, '0931', '730030', 'Lanzhou', 'L', NULL);
INSERT INTO `ez_area` VALUES (620102, '城关区', 620100, '103.825307,36.057464', 'district', '103.825307', '36.057464', 3, NULL, '0931', '730030', 'Chengguan', 'C', NULL);
INSERT INTO `ez_area` VALUES (620103, '七里河区', 620100, '103.785949,36.066146', 'district', '103.785949', '36.066146', 3, NULL, '0931', '730050', 'Qilihe', 'Q', NULL);
INSERT INTO `ez_area` VALUES (620104, '西固区', 620100, '103.627951,36.088552', 'district', '103.627951', '36.088552', 3, NULL, '0931', '730060', 'Xigu', 'X', NULL);
INSERT INTO `ez_area` VALUES (620105, '安宁区', 620100, '103.719054,36.104579', 'district', '103.719054', '36.104579', 3, NULL, '0931', '730070', 'Anning', 'A', NULL);
INSERT INTO `ez_area` VALUES (620111, '红古区', 620100, '102.859323,36.345669', 'district', '102.859323', '36.345669', 3, NULL, '0931', '730084', 'Honggu', 'H', NULL);
INSERT INTO `ez_area` VALUES (620121, '永登县', 620100, '103.26038,36.736513', 'district', '103.26038', '36.736513', 3, NULL, '0931', '730300', 'Yongdeng', 'Y', NULL);
INSERT INTO `ez_area` VALUES (620122, '皋兰县', 620100, '103.947377,36.332663', 'district', '103.947377', '36.332663', 3, NULL, '0931', '730200', 'Gaolan', 'G', NULL);
INSERT INTO `ez_area` VALUES (620123, '榆中县', 620100, '104.112527,35.843056', 'district', '104.112527', '35.843056', 3, NULL, '0931', '730100', 'Yuzhong', 'Y', NULL);
INSERT INTO `ez_area` VALUES (620200, '嘉峪关市', 620000, '98.289419,39.772554', 'city', '98.289419', '39.772554', 2, NULL, '0937', '735100', 'Jiayuguan', 'J', NULL);
INSERT INTO `ez_area` VALUES (620300, '金昌市', 620000, '102.188117,38.520717', 'city', '102.188117', '38.520717', 2, NULL, '0935', '737100', 'Jinchang', 'J', NULL);
INSERT INTO `ez_area` VALUES (620302, '金川区', 620300, '102.194015,38.521087', 'district', '102.194015', '38.521087', 3, NULL, '0935', '737100', 'Jinchuan', 'J', NULL);
INSERT INTO `ez_area` VALUES (620321, '永昌县', 620300, '101.984458,38.243434', 'district', '101.984458', '38.243434', 3, NULL, '0935', '737200', 'Yongchang', 'Y', NULL);
INSERT INTO `ez_area` VALUES (620400, '白银市', 620000, '104.138771,36.545261', 'city', '104.138771', '36.545261', 2, NULL, '0943', '730900', 'Baiyin', 'B', NULL);
INSERT INTO `ez_area` VALUES (620402, '白银区', 620400, '104.148556,36.535398', 'district', '104.148556', '36.535398', 3, NULL, '0943', '730900', 'Baiyin', 'B', NULL);
INSERT INTO `ez_area` VALUES (620403, '平川区', 620400, '104.825208,36.728304', 'district', '104.825208', '36.728304', 3, NULL, '0943', '730913', 'Pingchuan', 'P', NULL);
INSERT INTO `ez_area` VALUES (620421, '靖远县', 620400, '104.676774,36.571365', 'district', '104.676774', '36.571365', 3, NULL, '0943', '730600', 'Jingyuan', 'J', NULL);
INSERT INTO `ez_area` VALUES (620422, '会宁县', 620400, '105.053358,35.692823', 'district', '105.053358', '35.692823', 3, NULL, '0943', '730700', 'Huining', 'H', NULL);
INSERT INTO `ez_area` VALUES (620423, '景泰县', 620400, '104.063091,37.183804', 'district', '104.063091', '37.183804', 3, NULL, '0943', '730400', 'Jingtai', 'J', NULL);
INSERT INTO `ez_area` VALUES (620500, '天水市', 620000, '105.724979,34.580885', 'city', '105.724979', '34.580885', 2, NULL, '0938', '741000', 'Tianshui', 'T', NULL);
INSERT INTO `ez_area` VALUES (620502, '秦州区', 620500, '105.724215,34.580888', 'district', '105.724215', '34.580888', 3, NULL, '0938', '741000', 'Qinzhou', 'Q', NULL);
INSERT INTO `ez_area` VALUES (620503, '麦积区', 620500, '105.889556,34.570384', 'district', '105.889556', '34.570384', 3, NULL, '0938', '741020', 'Maiji', 'M', NULL);
INSERT INTO `ez_area` VALUES (620521, '清水县', 620500, '106.137293,34.749864', 'district', '106.137293', '34.749864', 3, NULL, '0938', '741400', 'Qingshui', 'Q', NULL);
INSERT INTO `ez_area` VALUES (620522, '秦安县', 620500, '105.674982,34.858916', 'district', '105.674982', '34.858916', 3, NULL, '0938', '741600', 'Qin\'an', 'Q', NULL);
INSERT INTO `ez_area` VALUES (620523, '甘谷县', 620500, '105.340747,34.745486', 'district', '105.340747', '34.745486', 3, NULL, '0938', '741200', 'Gangu', 'G', NULL);
INSERT INTO `ez_area` VALUES (620524, '武山县', 620500, '104.890587,34.72139', 'district', '104.890587', '34.72139', 3, NULL, '0938', '741300', 'Wushan', 'W', NULL);
INSERT INTO `ez_area` VALUES (620525, '张家川回族自治县', 620500, '106.204517,34.988037', 'district', '106.204517', '34.988037', 3, NULL, '0938', '741500', 'Zhangjiachuan', 'Z', NULL);
INSERT INTO `ez_area` VALUES (620600, '武威市', 620000, '102.638201,37.928267', 'city', '102.638201', '37.928267', 2, NULL, '0935', '733000', 'Wuwei', 'W', NULL);
INSERT INTO `ez_area` VALUES (620602, '凉州区', 620600, '102.642184,37.928224', 'district', '102.642184', '37.928224', 3, NULL, '0935', '733000', 'Liangzhou', 'L', NULL);
INSERT INTO `ez_area` VALUES (620621, '民勤县', 620600, '103.093791,38.62435', 'district', '103.093791', '38.62435', 3, NULL, '0935', '733300', 'Minqin', 'M', NULL);
INSERT INTO `ez_area` VALUES (620622, '古浪县', 620600, '102.897533,37.47012', 'district', '102.897533', '37.47012', 3, NULL, '0935', '733100', 'Gulang', 'G', NULL);
INSERT INTO `ez_area` VALUES (620623, '天祝藏族自治县', 620600, '103.141757,36.97174', 'district', '103.141757', '36.97174', 3, NULL, '0935', '733200', 'Tianzhu', 'T', NULL);
INSERT INTO `ez_area` VALUES (620700, '张掖市', 620000, '100.449913,38.925548', 'city', '100.449913', '38.925548', 2, NULL, '0936', '734000', 'Zhangye', 'Z', NULL);
INSERT INTO `ez_area` VALUES (620702, '甘州区', 620700, '100.415096,38.944662', 'district', '100.415096', '38.944662', 3, NULL, '0936', '734000', 'Ganzhou', 'G', NULL);
INSERT INTO `ez_area` VALUES (620721, '肃南裕固族自治县', 620700, '99.615601,38.836931', 'district', '99.615601', '38.836931', 3, NULL, '0936', '734400', 'Sunan', 'S', NULL);
INSERT INTO `ez_area` VALUES (620722, '民乐县', 620700, '100.812629,38.430347', 'district', '100.812629', '38.430347', 3, NULL, '0936', '734500', 'Minle', 'M', NULL);
INSERT INTO `ez_area` VALUES (620723, '临泽县', 620700, '100.164283,39.152462', 'district', '100.164283', '39.152462', 3, NULL, '0936', '734200', 'Linze', 'L', NULL);
INSERT INTO `ez_area` VALUES (620724, '高台县', 620700, '99.819519,39.378311', 'district', '99.819519', '39.378311', 3, NULL, '0936', '734300', 'Gaotai', 'G', NULL);
INSERT INTO `ez_area` VALUES (620725, '山丹县', 620700, '101.088529,38.784505', 'district', '101.088529', '38.784505', 3, NULL, '0936', '734100', 'Shandan', 'S', NULL);
INSERT INTO `ez_area` VALUES (620800, '平凉市', 620000, '106.665061,35.542606', 'city', '106.665061', '35.542606', 2, NULL, '0933', '744000', 'Pingliang', 'P', NULL);
INSERT INTO `ez_area` VALUES (620802, '崆峒区', 620800, '106.674767,35.542491', 'district', '106.674767', '35.542491', 3, NULL, '0933', '744000', 'Kongtong', 'K', NULL);
INSERT INTO `ez_area` VALUES (620821, '泾川县', 620800, '107.36785,35.332666', 'district', '107.36785', '35.332666', 3, NULL, '0933', '744300', 'Jingchuan', 'J', NULL);
INSERT INTO `ez_area` VALUES (620822, '灵台县', 620800, '107.595874,35.070027', 'district', '107.595874', '35.070027', 3, NULL, '0933', '744400', 'Lingtai', 'L', NULL);
INSERT INTO `ez_area` VALUES (620823, '崇信县', 620800, '107.025763,35.305596', 'district', '107.025763', '35.305596', 3, NULL, '0933', '744200', 'Chongxin', 'C', NULL);
INSERT INTO `ez_area` VALUES (620824, '华亭县', 620800, '106.653158,35.218292', 'district', '106.653158', '35.218292', 3, NULL, '0933', '744100', 'Huating', 'H', NULL);
INSERT INTO `ez_area` VALUES (620825, '庄浪县', 620800, '106.036686,35.202385', 'district', '106.036686', '35.202385', 3, NULL, '0933', '744600', 'Zhuanglang', 'Z', NULL);
INSERT INTO `ez_area` VALUES (620826, '静宁县', 620800, '105.732556,35.521976', 'district', '105.732556', '35.521976', 3, NULL, '0933', '743400', 'Jingning', 'J', NULL);
INSERT INTO `ez_area` VALUES (620900, '酒泉市', 620000, '98.493927,39.732795', 'city', '98.493927', '39.732795', 2, NULL, '0937', '735000', 'Jiuquan', 'J', NULL);
INSERT INTO `ez_area` VALUES (620902, '肃州区', 620900, '98.507843,39.744953', 'district', '98.507843', '39.744953', 3, NULL, '0937', '735000', 'Suzhou', 'S', NULL);
INSERT INTO `ez_area` VALUES (620921, '金塔县', 620900, '98.901252,39.983955', 'district', '98.901252', '39.983955', 3, NULL, '0937', '735300', 'Jinta', 'J', NULL);
INSERT INTO `ez_area` VALUES (620922, '瓜州县', 620900, '95.782318,40.520538', 'district', '95.782318', '40.520538', 3, NULL, '0937', '736100', 'Guazhou', 'G', NULL);
INSERT INTO `ez_area` VALUES (620923, '肃北蒙古族自治县', 620900, '94.876579,39.51245', 'district', '94.876579', '39.51245', 3, NULL, '0937', '736300', 'Subei', 'S', NULL);
INSERT INTO `ez_area` VALUES (620924, '阿克塞哈萨克族自治县', 620900, '94.340204,39.633943', 'district', '94.340204', '39.633943', 3, NULL, '0937', '736400', 'Akesai', 'A', NULL);
INSERT INTO `ez_area` VALUES (620981, '玉门市', 620900, '97.045661,40.292106', 'district', '97.045661', '40.292106', 3, NULL, '0937', '735200', 'Yumen', 'Y', NULL);
INSERT INTO `ez_area` VALUES (620982, '敦煌市', 620900, '94.661941,40.142089', 'district', '94.661941', '40.142089', 3, NULL, '0937', '736200', 'Dunhuang', 'D', NULL);
INSERT INTO `ez_area` VALUES (621000, '庆阳市', 620000, '107.643571,35.70898', 'city', '107.643571', '35.70898', 2, NULL, '0934', '745000', 'Qingyang', 'Q', NULL);
INSERT INTO `ez_area` VALUES (621002, '西峰区', 621000, '107.651077,35.730652', 'district', '107.651077', '35.730652', 3, NULL, '0934', '745000', 'Xifeng', 'X', NULL);
INSERT INTO `ez_area` VALUES (621021, '庆城县', 621000, '107.881802,36.016299', 'district', '107.881802', '36.016299', 3, NULL, '0934', '745100', 'Qingcheng', 'Q', NULL);
INSERT INTO `ez_area` VALUES (621022, '环县', 621000, '107.308501,36.568434', 'district', '107.308501', '36.568434', 3, NULL, '0934', '745700', 'Huanxian', 'H', NULL);
INSERT INTO `ez_area` VALUES (621023, '华池县', 621000, '107.990062,36.461306', 'district', '107.990062', '36.461306', 3, NULL, '0934', '745600', 'Huachi', 'H', NULL);
INSERT INTO `ez_area` VALUES (621024, '合水县', 621000, '108.019554,35.819194', 'district', '108.019554', '35.819194', 3, NULL, '0934', '745400', 'Heshui', 'H', NULL);
INSERT INTO `ez_area` VALUES (621025, '正宁县', 621000, '108.359865,35.49178', 'district', '108.359865', '35.49178', 3, NULL, '0934', '745300', 'Zhengning', 'Z', NULL);
INSERT INTO `ez_area` VALUES (621026, '宁县', 621000, '107.928371,35.502176', 'district', '107.928371', '35.502176', 3, NULL, '0934', '745200', 'Ningxian', 'N', NULL);
INSERT INTO `ez_area` VALUES (621027, '镇原县', 621000, '107.200832,35.677462', 'district', '107.200832', '35.677462', 3, NULL, '0934', '744500', 'Zhenyuan', 'Z', NULL);
INSERT INTO `ez_area` VALUES (621100, '定西市', 620000, '104.592225,35.606978', 'city', '104.592225', '35.606978', 2, NULL, '0932', '743000', 'Dingxi', 'D', NULL);
INSERT INTO `ez_area` VALUES (621102, '安定区', 621100, '104.610668,35.580629', 'district', '104.610668', '35.580629', 3, NULL, '0932', '743000', 'Anding', 'A', NULL);
INSERT INTO `ez_area` VALUES (621121, '通渭县', 621100, '105.24206,35.210831', 'district', '105.24206', '35.210831', 3, NULL, '0932', '743300', 'Tongwei', 'T', NULL);
INSERT INTO `ez_area` VALUES (621122, '陇西县', 621100, '104.634983,35.00394', 'district', '104.634983', '35.00394', 3, NULL, '0932', '748100', 'Longxi', 'L', NULL);
INSERT INTO `ez_area` VALUES (621123, '渭源县', 621100, '104.215467,35.136755', 'district', '104.215467', '35.136755', 3, NULL, '0932', '748200', 'Weiyuan', 'W', NULL);
INSERT INTO `ez_area` VALUES (621124, '临洮县', 621100, '103.859565,35.394988', 'district', '103.859565', '35.394988', 3, NULL, '0932', '730500', 'Lintao', 'L', NULL);
INSERT INTO `ez_area` VALUES (621125, '漳县', 621100, '104.471572,34.848444', 'district', '104.471572', '34.848444', 3, NULL, '0932', '748300', 'Zhangxian', 'Z', NULL);
INSERT INTO `ez_area` VALUES (621126, '岷县', 621100, '104.03688,34.438075', 'district', '104.03688', '34.438075', 3, NULL, '0932', '748400', 'Minxian', 'M', NULL);
INSERT INTO `ez_area` VALUES (621200, '陇南市', 620000, '104.960851,33.37068', 'city', '104.960851', '33.37068', 2, NULL, '0939', '746000', 'Longnan', 'L', NULL);
INSERT INTO `ez_area` VALUES (621202, '武都区', 621200, '104.926337,33.392211', 'district', '104.926337', '33.392211', 3, NULL, '0939', '746000', 'Wudu', 'W', NULL);
INSERT INTO `ez_area` VALUES (621221, '成县', 621200, '105.742424,33.75061', 'district', '105.742424', '33.75061', 3, NULL, '0939', '742500', 'Chengxian', 'C', NULL);
INSERT INTO `ez_area` VALUES (621222, '文县', 621200, '104.683433,32.943815', 'district', '104.683433', '32.943815', 3, NULL, '0939', '746400', 'Wenxian', 'W', NULL);
INSERT INTO `ez_area` VALUES (621223, '宕昌县', 621200, '104.393385,34.047261', 'district', '104.393385', '34.047261', 3, NULL, '0939', '748500', 'Dangchang', 'D', NULL);
INSERT INTO `ez_area` VALUES (621224, '康县', 621200, '105.609169,33.329136', 'district', '105.609169', '33.329136', 3, NULL, '0939', '746500', 'Kangxian', 'K', NULL);
INSERT INTO `ez_area` VALUES (621225, '西和县', 621200, '105.298756,34.014215', 'district', '105.298756', '34.014215', 3, NULL, '0939', '742100', 'Xihe', 'X', NULL);
INSERT INTO `ez_area` VALUES (621226, '礼县', 621200, '105.17864,34.189345', 'district', '105.17864', '34.189345', 3, NULL, '0939', '742200', 'Lixian', 'L', NULL);
INSERT INTO `ez_area` VALUES (621227, '徽县', 621200, '106.08778,33.768826', 'district', '106.08778', '33.768826', 3, NULL, '0939', '742300', 'Huixian', 'H', NULL);
INSERT INTO `ez_area` VALUES (621228, '两当县', 621200, '106.304966,33.908917', 'district', '106.304966', '33.908917', 3, NULL, '0939', '742400', 'Liangdang', 'L', NULL);
INSERT INTO `ez_area` VALUES (622900, '临夏回族自治州', 620000, '103.210655,35.601352', 'city', '103.210655', '35.601352', 2, NULL, '0930', '731100', 'Linxia', 'L', NULL);
INSERT INTO `ez_area` VALUES (622901, '临夏市', 622900, '103.243021,35.604376', 'district', '103.243021', '35.604376', 3, NULL, '0930', '731100', 'Linxia', 'L', NULL);
INSERT INTO `ez_area` VALUES (622921, '临夏县', 622900, '103.039826,35.478722', 'district', '103.039826', '35.478722', 3, NULL, '0930', '731800', 'Linxia', 'L', NULL);
INSERT INTO `ez_area` VALUES (622922, '康乐县', 622900, '103.708354,35.370505', 'district', '103.708354', '35.370505', 3, NULL, '0930', '731500', 'Kangle', 'K', NULL);
INSERT INTO `ez_area` VALUES (622923, '永靖县', 622900, '103.285853,35.958306', 'district', '103.285853', '35.958306', 3, NULL, '0930', '731600', 'Yongjing', 'Y', NULL);
INSERT INTO `ez_area` VALUES (622924, '广河县', 622900, '103.575834,35.488051', 'district', '103.575834', '35.488051', 3, NULL, '0930', '731300', 'Guanghe', 'G', NULL);
INSERT INTO `ez_area` VALUES (622925, '和政县', 622900, '103.350997,35.424603', 'district', '103.350997', '35.424603', 3, NULL, '0930', '731200', 'Hezheng', 'H', NULL);
INSERT INTO `ez_area` VALUES (622926, '东乡族自治县', 622900, '103.389346,35.663752', 'district', '103.389346', '35.663752', 3, NULL, '0930', '731400', 'Dongxiangzu', 'D', NULL);
INSERT INTO `ez_area` VALUES (622927, '积石山保安族东乡族撒拉族自治县', 622900, '102.875843,35.71766', 'district', '102.875843', '35.71766', 3, NULL, '0930', '731700', 'Jishishan', 'J', NULL);
INSERT INTO `ez_area` VALUES (623000, '甘南藏族自治州', 620000, '102.910995,34.983409', 'city', '102.910995', '34.983409', 2, NULL, '0941', '747000', 'Gannan', 'G', NULL);
INSERT INTO `ez_area` VALUES (623001, '合作市', 623000, '102.910484,35.000286', 'district', '102.910484', '35.000286', 3, NULL, '0941', '747000', 'Hezuo', 'H', NULL);
INSERT INTO `ez_area` VALUES (623021, '临潭县', 623000, '103.353919,34.692747', 'district', '103.353919', '34.692747', 3, NULL, '0941', '747500', 'Lintan', 'L', NULL);
INSERT INTO `ez_area` VALUES (623022, '卓尼县', 623000, '103.507109,34.589588', 'district', '103.507109', '34.589588', 3, NULL, '0941', '747600', 'Zhuoni', 'Z', NULL);
INSERT INTO `ez_area` VALUES (623023, '舟曲县', 623000, '104.251482,33.793631', 'district', '104.251482', '33.793631', 3, NULL, '0941', '746300', 'Zhouqu', 'Z', NULL);
INSERT INTO `ez_area` VALUES (623024, '迭部县', 623000, '103.221869,34.055938', 'district', '103.221869', '34.055938', 3, NULL, '0941', '747400', 'Diebu', 'D', NULL);
INSERT INTO `ez_area` VALUES (623025, '玛曲县', 623000, '102.072698,33.997712', 'district', '102.072698', '33.997712', 3, NULL, '0941', '747300', 'Maqu', 'M', NULL);
INSERT INTO `ez_area` VALUES (623026, '碌曲县', 623000, '102.487327,34.590944', 'district', '102.487327', '34.590944', 3, NULL, '0941', '747200', 'Luqu', 'L', NULL);
INSERT INTO `ez_area` VALUES (623027, '夏河县', 623000, '102.521807,35.202503', 'district', '102.521807', '35.202503', 3, NULL, '0941', '747100', 'Xiahe', 'X', NULL);
INSERT INTO `ez_area` VALUES (630000, '青海省', 0, '101.780268,36.620939', 'province', '101.780268', '36.620939', 1, NULL, NULL, NULL, 'Qinghai', 'Q', NULL);
INSERT INTO `ez_area` VALUES (630100, '西宁市', 630000, '101.778223,36.617134', 'city', '101.778223', '36.617134', 2, NULL, '0971', '810000', 'Xining', 'X', NULL);
INSERT INTO `ez_area` VALUES (630102, '城东区', 630100, '101.803717,36.599744', 'district', '101.803717', '36.599744', 3, NULL, '0971', '810007', 'Chengdong', 'C', NULL);
INSERT INTO `ez_area` VALUES (630103, '城中区', 630100, '101.705298,36.545652', 'district', '101.705298', '36.545652', 3, NULL, '0971', '810000', 'Chengzhong', 'C', NULL);
INSERT INTO `ez_area` VALUES (630104, '城西区', 630100, '101.765843,36.628304', 'district', '101.765843', '36.628304', 3, NULL, '0971', '810001', 'Chengxi', 'C', NULL);
INSERT INTO `ez_area` VALUES (630105, '城北区', 630100, '101.766228,36.650038', 'district', '101.766228', '36.650038', 3, NULL, '0971', '810003', 'Chengbei', 'C', NULL);
INSERT INTO `ez_area` VALUES (630121, '大通回族土族自治县', 630100, '101.685643,36.926954', 'district', '101.685643', '36.926954', 3, NULL, '0971', '810100', 'Datong', 'D', NULL);
INSERT INTO `ez_area` VALUES (630122, '湟中县', 630100, '101.571667,36.500879', 'district', '101.571667', '36.500879', 3, NULL, '0971', '811600', 'Huangzhong', 'H', NULL);
INSERT INTO `ez_area` VALUES (630123, '湟源县', 630100, '101.256464,36.682426', 'district', '101.256464', '36.682426', 3, NULL, '0971', '812100', 'Huangyuan', 'H', NULL);
INSERT INTO `ez_area` VALUES (630200, '海东市', 630000, '102.104287,36.502039', 'city', '102.104287', '36.502039', 2, NULL, '0972', '810700', 'Haidong', 'H', NULL);
INSERT INTO `ez_area` VALUES (630202, '乐都区', 630200, '102.401724,36.482058', 'district', '102.401724', '36.482058', 3, NULL, '0972', '810700', 'Ledu', 'L', NULL);
INSERT INTO `ez_area` VALUES (630203, '平安区', 630200, '102.108834,36.500563', 'district', '102.108834', '36.500563', 3, NULL, '0972', '810600', 'Ping\'an', 'P', NULL);
INSERT INTO `ez_area` VALUES (630222, '民和回族土族自治县', 630200, '102.830892,36.320321', 'district', '102.830892', '36.320321', 3, NULL, '0972', '810800', 'Minhe', 'M', NULL);
INSERT INTO `ez_area` VALUES (630223, '互助土族自治县', 630200, '101.959271,36.844248', 'district', '101.959271', '36.844248', 3, NULL, '0972', '810500', 'Huzhu', 'H', NULL);
INSERT INTO `ez_area` VALUES (630224, '化隆回族自治县', 630200, '102.264143,36.094908', 'district', '102.264143', '36.094908', 3, NULL, '0972', '810900', 'Hualong', 'H', NULL);
INSERT INTO `ez_area` VALUES (630225, '循化撒拉族自治县', 630200, '102.489135,35.851152', 'district', '102.489135', '35.851152', 3, NULL, '0972', '811100', 'Xunhua', 'X', NULL);
INSERT INTO `ez_area` VALUES (632200, '海北藏族自治州', 630000, '100.900997,36.954413', 'city', '100.900997', '36.954413', 2, NULL, '0970', '812200', 'Haibei', 'H', NULL);
INSERT INTO `ez_area` VALUES (632221, '门源回族自治县', 632200, '101.611539,37.388746', 'district', '101.611539', '37.388746', 3, NULL, '0970', '810300', 'Menyuan', 'M', NULL);
INSERT INTO `ez_area` VALUES (632222, '祁连县', 632200, '100.253211,38.177112', 'district', '100.253211', '38.177112', 3, NULL, '0970', '810400', 'Qilian', 'Q', NULL);
INSERT INTO `ez_area` VALUES (632223, '海晏县', 632200, '100.99426,36.896359', 'district', '100.99426', '36.896359', 3, NULL, '0970', '812200', 'Haiyan', 'H', NULL);
INSERT INTO `ez_area` VALUES (632224, '刚察县', 632200, '100.145833,37.32547', 'district', '100.145833', '37.32547', 3, NULL, '0970', '812300', 'Gangcha', 'G', NULL);
INSERT INTO `ez_area` VALUES (632300, '黄南藏族自治州', 630000, '102.015248,35.519548', 'city', '102.015248', '35.519548', 2, NULL, '0973', '811300', 'Huangnan', 'H', NULL);
INSERT INTO `ez_area` VALUES (632321, '同仁县', 632300, '102.018323,35.516063', 'district', '102.018323', '35.516063', 3, NULL, '0973', '811300', 'Tongren', 'T', NULL);
INSERT INTO `ez_area` VALUES (632322, '尖扎县', 632300, '102.04014,35.943156', 'district', '102.04014', '35.943156', 3, NULL, '0973', '811200', 'Jianzha', 'J', NULL);
INSERT INTO `ez_area` VALUES (632323, '泽库县', 632300, '101.466689,35.035313', 'district', '101.466689', '35.035313', 3, NULL, '0973', '811400', 'Zeku', 'Z', NULL);
INSERT INTO `ez_area` VALUES (632324, '河南蒙古族自治县', 632300, '101.617503,34.734568', 'district', '101.617503', '34.734568', 3, NULL, '0973', '811500', 'Henan', 'H', NULL);
INSERT INTO `ez_area` VALUES (632500, '海南藏族自治州', 630000, '100.622692,36.296529', 'city', '100.622692', '36.296529', 2, NULL, '0974', '813000', 'Hainan', 'H', NULL);
INSERT INTO `ez_area` VALUES (632521, '共和县', 632500, '100.620031,36.284107', 'district', '100.620031', '36.284107', 3, NULL, '0974', '813000', 'Gonghe', 'G', NULL);
INSERT INTO `ez_area` VALUES (632522, '同德县', 632500, '100.578051,35.25479', 'district', '100.578051', '35.25479', 3, NULL, '0974', '813200', 'Tongde', 'T', NULL);
INSERT INTO `ez_area` VALUES (632523, '贵德县', 632500, '101.433391,36.040166', 'district', '101.433391', '36.040166', 3, NULL, '0974', '811700', 'Guide', 'G', NULL);
INSERT INTO `ez_area` VALUES (632524, '兴海县', 632500, '99.987965,35.588612', 'district', '99.987965', '35.588612', 3, NULL, '0974', '813300', 'Xinghai', 'X', NULL);
INSERT INTO `ez_area` VALUES (632525, '贵南县', 632500, '100.747503,35.586714', 'district', '100.747503', '35.586714', 3, NULL, '0974', '813100', 'Guinan', 'G', NULL);
INSERT INTO `ez_area` VALUES (632600, '果洛藏族自治州', 630000, '100.244808,34.471431', 'city', '100.244808', '34.471431', 2, NULL, '0975', '814000', 'Golog', 'G', NULL);
INSERT INTO `ez_area` VALUES (632621, '玛沁县', 632600, '100.238888,34.477433', 'district', '100.238888', '34.477433', 3, NULL, '0975', '814000', 'Maqin', 'M', NULL);
INSERT INTO `ez_area` VALUES (632622, '班玛县', 632600, '100.737138,32.932723', 'district', '100.737138', '32.932723', 3, NULL, '0975', '814300', 'Banma', 'B', NULL);
INSERT INTO `ez_area` VALUES (632623, '甘德县', 632600, '99.900923,33.969216', 'district', '99.900923', '33.969216', 3, NULL, '0975', '814100', 'Gande', 'G', NULL);
INSERT INTO `ez_area` VALUES (632624, '达日县', 632600, '99.651392,33.74892', 'district', '99.651392', '33.74892', 3, NULL, '0975', '814200', 'Dari', 'D', NULL);
INSERT INTO `ez_area` VALUES (632625, '久治县', 632600, '101.482831,33.429471', 'district', '101.482831', '33.429471', 3, NULL, '0975', '624700', 'Jiuzhi', 'J', NULL);
INSERT INTO `ez_area` VALUES (632626, '玛多县', 632600, '98.209206,34.915946', 'district', '98.209206', '34.915946', 3, NULL, '0975', '813500', 'Maduo', 'M', NULL);
INSERT INTO `ez_area` VALUES (632700, '玉树藏族自治州', 630000, '97.091934,33.011674', 'city', '97.091934', '33.011674', 2, NULL, '0976', '815000', 'Yushu', 'Y', NULL);
INSERT INTO `ez_area` VALUES (632701, '玉树市', 632700, '97.008784,32.993106', 'district', '97.008784', '32.993106', 3, NULL, '0976', '815000', 'Yushu', 'Y', NULL);
INSERT INTO `ez_area` VALUES (632722, '杂多县', 632700, '95.300723,32.893185', 'district', '95.300723', '32.893185', 3, NULL, '0976', '815300', 'Zaduo', 'Z', NULL);
INSERT INTO `ez_area` VALUES (632723, '称多县', 632700, '97.110831,33.369218', 'district', '97.110831', '33.369218', 3, NULL, '0976', '815100', 'Chenduo', 'C', NULL);
INSERT INTO `ez_area` VALUES (632724, '治多县', 632700, '95.61896,33.844956', 'district', '95.61896', '33.844956', 3, NULL, '0976', '815400', 'Zhiduo', 'Z', NULL);
INSERT INTO `ez_area` VALUES (632725, '囊谦县', 632700, '96.48943,32.203432', 'district', '96.48943', '32.203432', 3, NULL, '0976', '815200', 'Nangqian', 'N', NULL);
INSERT INTO `ez_area` VALUES (632726, '曲麻莱县', 632700, '95.797367,34.126428', 'district', '95.797367', '34.126428', 3, NULL, '0976', '815500', 'Qumalai', 'Q', NULL);
INSERT INTO `ez_area` VALUES (632800, '海西蒙古族藏族自治州', 630000, '97.369751,37.377139', 'city', '97.369751', '37.377139', 2, NULL, '0977', '817000', 'Haixi', 'H', NULL);
INSERT INTO `ez_area` VALUES (632801, '格尔木市', 632800, '94.928453,36.406367', 'district', '94.928453', '36.406367', 3, NULL, '0977', '816000', 'Geermu', 'G', NULL);
INSERT INTO `ez_area` VALUES (632802, '德令哈市', 632800, '97.360984,37.369436', 'district', '97.360984', '37.369436', 3, NULL, '0977', '817000', 'Delingha', 'D', NULL);
INSERT INTO `ez_area` VALUES (632821, '乌兰县', 632800, '98.480195,36.929749', 'district', '98.480195', '36.929749', 3, NULL, '0977', '817100', 'Wulan', 'W', NULL);
INSERT INTO `ez_area` VALUES (632822, '都兰县', 632800, '98.095844,36.302496', 'district', '98.095844', '36.302496', 3, NULL, '0977', '816100', 'Dulan', 'D', NULL);
INSERT INTO `ez_area` VALUES (632823, '天峻县', 632800, '99.022984,37.300851', 'district', '99.022984', '37.300851', 3, NULL, '0977', '817200', 'Tianjun', 'T', NULL);
INSERT INTO `ez_area` VALUES (632825, '海西蒙古族藏族自治州直辖', 632800, '95.356546,37.853328', 'district', '95.356546', '37.853328', 3, NULL, '0977', '817000', 'Haixi', 'H', NULL);
INSERT INTO `ez_area` VALUES (640000, '宁夏回族自治区', 0, '106.259126,38.472641', 'province', '106.259126', '38.472641', 1, NULL, NULL, NULL, 'Ningxia', 'N', NULL);
INSERT INTO `ez_area` VALUES (640100, '银川市', 640000, '106.230909,38.487193', 'city', '106.230909', '38.487193', 2, NULL, '0951', '750004', 'Yinchuan', 'Y', NULL);
INSERT INTO `ez_area` VALUES (640104, '兴庆区', 640100, '106.28865,38.473609', 'district', '106.28865', '38.473609', 3, NULL, '0951', '750001', 'Xingqing', 'X', NULL);
INSERT INTO `ez_area` VALUES (640105, '西夏区', 640100, '106.161106,38.502605', 'district', '106.161106', '38.502605', 3, NULL, '0951', '750021', 'Xixia', 'X', NULL);
INSERT INTO `ez_area` VALUES (640106, '金凤区', 640100, '106.239679,38.47436', 'district', '106.239679', '38.47436', 3, NULL, '0951', '750011', 'Jinfeng', 'J', NULL);
INSERT INTO `ez_area` VALUES (640121, '永宁县', 640100, '106.253145,38.277372', 'district', '106.253145', '38.277372', 3, NULL, '0951', '750100', 'Yongning', 'Y', NULL);
INSERT INTO `ez_area` VALUES (640122, '贺兰县', 640100, '106.349861,38.554599', 'district', '106.349861', '38.554599', 3, NULL, '0951', '750200', 'Helan', 'H', NULL);
INSERT INTO `ez_area` VALUES (640181, '灵武市', 640100, '106.340053,38.102655', 'district', '106.340053', '38.102655', 3, NULL, '0951', '750004', 'Lingwu', 'L', NULL);
INSERT INTO `ez_area` VALUES (640200, '石嘴山市', 640000, '106.383303,38.983236', 'city', '106.383303', '38.983236', 2, NULL, '0952', '753000', 'Shizuishan', 'S', NULL);
INSERT INTO `ez_area` VALUES (640202, '大武口区', 640200, '106.367958,39.01918', 'district', '106.367958', '39.01918', 3, NULL, '0952', '753000', 'Dawukou', 'D', NULL);
INSERT INTO `ez_area` VALUES (640205, '惠农区', 640200, '106.781176,39.239302', 'district', '106.781176', '39.239302', 3, NULL, '0952', '753600', 'Huinong', 'H', NULL);
INSERT INTO `ez_area` VALUES (640221, '平罗县', 640200, '106.523474,38.913544', 'district', '106.523474', '38.913544', 3, NULL, '0952', '753400', 'Pingluo', 'P', NULL);
INSERT INTO `ez_area` VALUES (640300, '吴忠市', 640000, '106.198913,37.997428', 'city', '106.198913', '37.997428', 2, NULL, '0953', '751100', 'Wuzhong', 'W', NULL);
INSERT INTO `ez_area` VALUES (640302, '利通区', 640300, '106.212613,37.98349', 'district', '106.212613', '37.98349', 3, NULL, '0953', '751100', 'Litong', 'L', NULL);
INSERT INTO `ez_area` VALUES (640303, '红寺堡区', 640300, '106.062113,37.425702', 'district', '106.062113', '37.425702', 3, NULL, '0953', '751900', 'Hongsibao', 'H', NULL);
INSERT INTO `ez_area` VALUES (640323, '盐池县', 640300, '107.407358,37.783205', 'district', '107.407358', '37.783205', 3, NULL, '0953', '751500', 'Yanchi', 'Y', NULL);
INSERT INTO `ez_area` VALUES (640324, '同心县', 640300, '105.895309,36.95449', 'district', '105.895309', '36.95449', 3, NULL, '0953', '751300', 'Tongxin', 'T', NULL);
INSERT INTO `ez_area` VALUES (640381, '青铜峡市', 640300, '106.078817,38.021302', 'district', '106.078817', '38.021302', 3, NULL, '0953', '751600', 'Qingtongxia', 'Q', NULL);
INSERT INTO `ez_area` VALUES (640400, '固原市', 640000, '106.24261,36.015855', 'city', '106.24261', '36.015855', 2, NULL, '0954', '756000', 'Guyuan', 'G', NULL);
INSERT INTO `ez_area` VALUES (640402, '原州区', 640400, '106.287781,36.003739', 'district', '106.287781', '36.003739', 3, NULL, '0954', '756000', 'Yuanzhou', 'Y', NULL);
INSERT INTO `ez_area` VALUES (640422, '西吉县', 640400, '105.729085,35.963912', 'district', '105.729085', '35.963912', 3, NULL, '0954', '756200', 'Xiji', 'X', NULL);
INSERT INTO `ez_area` VALUES (640423, '隆德县', 640400, '106.111595,35.625914', 'district', '106.111595', '35.625914', 3, NULL, '0954', '756300', 'Longde', 'L', NULL);
INSERT INTO `ez_area` VALUES (640424, '泾源县', 640400, '106.330646,35.498159', 'district', '106.330646', '35.498159', 3, NULL, '0954', '756400', 'Jingyuan', 'J', NULL);
INSERT INTO `ez_area` VALUES (640425, '彭阳县', 640400, '106.631809,35.858815', 'district', '106.631809', '35.858815', 3, NULL, '0954', '756500', 'Pengyang', 'P', NULL);
INSERT INTO `ez_area` VALUES (640500, '中卫市', 640000, '105.196902,37.499972', 'city', '105.196902', '37.499972', 2, NULL, '0955', '751700', 'Zhongwei', 'Z', NULL);
INSERT INTO `ez_area` VALUES (640502, '沙坡头区', 640500, '105.173721,37.516883', 'district', '105.173721', '37.516883', 3, NULL, '0955', '755000', 'Shapotou', 'S', NULL);
INSERT INTO `ez_area` VALUES (640521, '中宁县', 640500, '105.685218,37.491546', 'district', '105.685218', '37.491546', 3, NULL, '0955', '751200', 'Zhongning', 'Z', NULL);
INSERT INTO `ez_area` VALUES (640522, '海原县', 640500, '105.643487,36.565033', 'district', '105.643487', '36.565033', 3, NULL, '0955', '751800', 'Haiyuan', 'H', NULL);
INSERT INTO `ez_area` VALUES (650000, '新疆维吾尔自治区', 0, '87.627704,43.793026', 'province', '87.627704', '43.793026', 1, NULL, NULL, NULL, 'Xinjiang', 'X', NULL);
INSERT INTO `ez_area` VALUES (650100, '乌鲁木齐市', 650000, '87.616848,43.825592', 'city', '87.616848', '43.825592', 2, NULL, '0991', '830002', 'Urumqi', 'U', NULL);
INSERT INTO `ez_area` VALUES (650102, '天山区', 650100, '87.631676,43.794399', 'district', '87.631676', '43.794399', 3, NULL, '0991', '830002', 'Tianshan', 'T', NULL);
INSERT INTO `ez_area` VALUES (650103, '沙依巴克区', 650100, '87.598195,43.800939', 'district', '87.598195', '43.800939', 3, NULL, '0991', '830000', 'Shayibake', 'S', NULL);
INSERT INTO `ez_area` VALUES (650104, '新市区', 650100, '87.569431,43.855378', 'district', '87.569431', '43.855378', 3, NULL, '0991', '830011', 'Xinshi', 'X', NULL);
INSERT INTO `ez_area` VALUES (650105, '水磨沟区', 650100, '87.642481,43.832459', 'district', '87.642481', '43.832459', 3, NULL, '0991', '830017', 'Shuimogou', 'S', NULL);
INSERT INTO `ez_area` VALUES (650106, '头屯河区', 650100, '87.428141,43.877664', 'district', '87.428141', '43.877664', 3, NULL, '0991', '830022', 'Toutunhe', 'T', NULL);
INSERT INTO `ez_area` VALUES (650107, '达坂城区', 650100, '88.311099,43.363668', 'district', '88.311099', '43.363668', 3, NULL, '0991', '830039', 'Dabancheng', 'D', NULL);
INSERT INTO `ez_area` VALUES (650109, '米东区', 650100, '87.655935,43.974784', 'district', '87.655935', '43.974784', 3, NULL, '0991', '830019', 'Midong', 'M', NULL);
INSERT INTO `ez_area` VALUES (650121, '乌鲁木齐县', 650100, '87.409417,43.47136', 'district', '87.409417', '43.47136', 3, NULL, '0991', '830063', 'Wulumuqi', 'W', NULL);
INSERT INTO `ez_area` VALUES (650200, '克拉玛依市', 650000, '84.889207,45.579888', 'city', '84.889207', '45.579888', 2, NULL, '0990', '834000', 'Karamay', 'K', NULL);
INSERT INTO `ez_area` VALUES (650202, '独山子区', 650200, '84.886974,44.328095', 'district', '84.886974', '44.328095', 3, NULL, '0992', '834021', 'Dushanzi', 'D', NULL);
INSERT INTO `ez_area` VALUES (650203, '克拉玛依区', 650200, '84.867844,45.602525', 'district', '84.867844', '45.602525', 3, NULL, '0990', '834000', 'Kelamayi', 'K', NULL);
INSERT INTO `ez_area` VALUES (650204, '白碱滩区', 650200, '85.131696,45.687854', 'district', '85.131696', '45.687854', 3, NULL, '0990', '834008', 'Baijiantan', 'B', NULL);
INSERT INTO `ez_area` VALUES (650205, '乌尔禾区', 650200, '85.693742,46.089148', 'district', '85.693742', '46.089148', 3, NULL, '0990', '834012', 'Wuerhe', 'W', NULL);
INSERT INTO `ez_area` VALUES (650400, '吐鲁番市', 650000, '89.189752,42.951303', 'city', '89.189752', '42.951303', 2, NULL, '0995', '838000', 'Tulufan', 'T', NULL);
INSERT INTO `ez_area` VALUES (650402, '高昌区', 650400, '89.185877,42.942327', 'district', '89.185877', '42.942327', 3, NULL, '0995', '838000', 'Gaochang', 'G', NULL);
INSERT INTO `ez_area` VALUES (650421, '鄯善县', 650400, '90.21333,42.868744', 'district', '90.21333', '42.868744', 3, NULL, '0995', '838200', 'Shanshan', 'S', NULL);
INSERT INTO `ez_area` VALUES (650422, '托克逊县', 650400, '88.653827,42.792526', 'district', '88.653827', '42.792526', 3, NULL, '0995', '838100', 'Tuokexun', 'T', NULL);
INSERT INTO `ez_area` VALUES (650500, '哈密市', 650000, '93.515224,42.819541', 'city', '93.515224', '42.819541', 2, NULL, '0902', '839000', 'Hami', 'H', NULL);
INSERT INTO `ez_area` VALUES (650502, '伊州区', 650500, '93.514797,42.827254', 'district', '93.514797', '42.827254', 3, NULL, '0902', '839000', 'Yizhou', 'Y', NULL);
INSERT INTO `ez_area` VALUES (650521, '巴里坤哈萨克自治县', 650500, '93.010383,43.599929', 'district', '93.010383', '43.599929', 3, NULL, '0902', '839200', 'Balikun', 'B', NULL);
INSERT INTO `ez_area` VALUES (650522, '伊吾县', 650500, '94.697074,43.254978', 'district', '94.697074', '43.254978', 3, NULL, '0902', '839300', 'Yiwu', 'Y', NULL);
INSERT INTO `ez_area` VALUES (652300, '昌吉回族自治州', 650000, '87.308224,44.011182', 'city', '87.308224', '44.011182', 2, NULL, '0994', '831100', 'Changji', 'C', NULL);
INSERT INTO `ez_area` VALUES (652301, '昌吉市', 652300, '87.267532,44.014435', 'district', '87.267532', '44.014435', 3, NULL, '0994', '831100', 'Changji', 'C', NULL);
INSERT INTO `ez_area` VALUES (652302, '阜康市', 652300, '87.952991,44.164402', 'district', '87.952991', '44.164402', 3, NULL, '0994', '831500', 'Fukang', 'F', NULL);
INSERT INTO `ez_area` VALUES (652323, '呼图壁县', 652300, '86.871584,44.179361', 'district', '86.871584', '44.179361', 3, NULL, '0994', '831200', 'Hutubi', 'H', NULL);
INSERT INTO `ez_area` VALUES (652324, '玛纳斯县', 652300, '86.20368,44.284722', 'district', '86.20368', '44.284722', 3, NULL, '0994', '832200', 'Manasi', 'M', NULL);
INSERT INTO `ez_area` VALUES (652325, '奇台县', 652300, '89.593967,44.022066', 'district', '89.593967', '44.022066', 3, NULL, '0994', '831800', 'Qitai', 'Q', NULL);
INSERT INTO `ez_area` VALUES (652327, '吉木萨尔县', 652300, '89.180437,44.000497', 'district', '89.180437', '44.000497', 3, NULL, '0994', '831700', 'Jimusaer', 'J', NULL);
INSERT INTO `ez_area` VALUES (652328, '木垒哈萨克自治县', 652300, '90.286028,43.834689', 'district', '90.286028', '43.834689', 3, NULL, '0994', '831900', 'Mulei', 'M', NULL);
INSERT INTO `ez_area` VALUES (652700, '博尔塔拉蒙古自治州', 650000, '82.066363,44.906039', 'city', '82.066363', '44.906039', 2, NULL, '0909', '833400', 'Bortala', 'B', NULL);
INSERT INTO `ez_area` VALUES (652701, '博乐市', 652700, '82.051004,44.853869', 'district', '82.051004', '44.853869', 3, NULL, '0909', '833400', 'Bole', 'B', NULL);
INSERT INTO `ez_area` VALUES (652702, '阿拉山口市', 652700, '82.559396,45.172227', 'district', '82.559396', '45.172227', 3, NULL, '0909', '833400', 'Alashankou', 'A', NULL);
INSERT INTO `ez_area` VALUES (652722, '精河县', 652700, '82.890656,44.599393', 'district', '82.890656', '44.599393', 3, NULL, '0909', '833300', 'Jinghe', 'J', NULL);
INSERT INTO `ez_area` VALUES (652723, '温泉县', 652700, '81.024816,44.968856', 'district', '81.024816', '44.968856', 3, NULL, '0909', '833500', 'Wenquan', 'W', NULL);
INSERT INTO `ez_area` VALUES (652800, '巴音郭楞蒙古自治州', 650000, '86.145297,41.764115', 'city', '86.145297', '41.764115', 2, NULL, '0996', '841000', 'Bayingol', 'B', NULL);
INSERT INTO `ez_area` VALUES (652801, '库尔勒市', 652800, '86.174633,41.725891', 'district', '86.174633', '41.725891', 3, NULL, '0996', '841000', 'Kuerle', 'K', NULL);
INSERT INTO `ez_area` VALUES (652822, '轮台县', 652800, '84.252156,41.777702', 'district', '84.252156', '41.777702', 3, NULL, '0996', '841600', 'Luntai', 'L', NULL);
INSERT INTO `ez_area` VALUES (652823, '尉犁县', 652800, '86.261321,41.343933', 'district', '86.261321', '41.343933', 3, NULL, '0996', '841500', 'Yuli', 'Y', NULL);
INSERT INTO `ez_area` VALUES (652824, '若羌县', 652800, '88.167152,39.023241', 'district', '88.167152', '39.023241', 3, NULL, '0996', '841800', 'Ruoqiang', 'R', NULL);
INSERT INTO `ez_area` VALUES (652825, '且末县', 652800, '85.529702,38.145485', 'district', '85.529702', '38.145485', 3, NULL, '0996', '841900', 'Qiemo', 'Q', NULL);
INSERT INTO `ez_area` VALUES (652826, '焉耆回族自治县', 652800, '86.574067,42.059759', 'district', '86.574067', '42.059759', 3, NULL, '0996', '841100', 'Yanqi', 'Y', NULL);
INSERT INTO `ez_area` VALUES (652827, '和静县', 652800, '86.384065,42.323625', 'district', '86.384065', '42.323625', 3, NULL, '0996', '841300', 'Hejing', 'H', NULL);
INSERT INTO `ez_area` VALUES (652828, '和硕县', 652800, '86.876799,42.284331', 'district', '86.876799', '42.284331', 3, NULL, '0996', '841200', 'Heshuo', 'H', NULL);
INSERT INTO `ez_area` VALUES (652829, '博湖县', 652800, '86.631997,41.980152', 'district', '86.631997', '41.980152', 3, NULL, '0996', '841400', 'Bohu', 'B', NULL);
INSERT INTO `ez_area` VALUES (652900, '阿克苏地区', 650000, '80.260605,41.168779', 'city', '80.260605', '41.168779', 2, NULL, '0997', '843000', 'Aksu', 'A', NULL);
INSERT INTO `ez_area` VALUES (652901, '阿克苏市', 652900, '80.263387,41.167548', 'district', '80.263387', '41.167548', 3, NULL, '0997', '843000', 'Akesu', 'A', NULL);
INSERT INTO `ez_area` VALUES (652922, '温宿县', 652900, '80.238959,41.276688', 'district', '80.238959', '41.276688', 3, NULL, '0997', '843100', 'Wensu', 'W', NULL);
INSERT INTO `ez_area` VALUES (652923, '库车县', 652900, '82.987312,41.714696', 'district', '82.987312', '41.714696', 3, NULL, '0997', '842000', 'Kuche', 'K', NULL);
INSERT INTO `ez_area` VALUES (652924, '沙雅县', 652900, '82.781818,41.221666', 'district', '82.781818', '41.221666', 3, NULL, '0997', '842200', 'Shaya', 'S', NULL);
INSERT INTO `ez_area` VALUES (652925, '新和县', 652900, '82.618736,41.551206', 'district', '82.618736', '41.551206', 3, NULL, '0997', '842100', 'Xinhe', 'X', NULL);
INSERT INTO `ez_area` VALUES (652926, '拜城县', 652900, '81.85148,41.795912', 'district', '81.85148', '41.795912', 3, NULL, '0997', '842300', 'Baicheng', 'B', NULL);
INSERT INTO `ez_area` VALUES (652927, '乌什县', 652900, '79.224616,41.222319', 'district', '79.224616', '41.222319', 3, NULL, '0997', '843400', 'Wushi', 'W', NULL);
INSERT INTO `ez_area` VALUES (652928, '阿瓦提县', 652900, '80.375053,40.643647', 'district', '80.375053', '40.643647', 3, NULL, '0997', '843200', 'Awati', 'A', NULL);
INSERT INTO `ez_area` VALUES (652929, '柯坪县', 652900, '79.054497,40.501936', 'district', '79.054497', '40.501936', 3, NULL, '0997', '843600', 'Keping', 'K', NULL);
INSERT INTO `ez_area` VALUES (653000, '克孜勒苏柯尔克孜自治州', 650000, '76.167819,39.714526', 'city', '76.167819', '39.714526', 2, NULL, '0908', '845350', 'Kizilsu', 'K', NULL);
INSERT INTO `ez_area` VALUES (653001, '阿图什市', 653000, '76.1684,39.71616', 'district', '76.1684', '39.71616', 3, NULL, '0908', '845350', 'Atushi', 'A', NULL);
INSERT INTO `ez_area` VALUES (653022, '阿克陶县', 653000, '75.947396,39.147785', 'district', '75.947396', '39.147785', 3, NULL, '0908', '845550', 'Aketao', 'A', NULL);
INSERT INTO `ez_area` VALUES (653023, '阿合奇县', 653000, '78.446253,40.936936', 'district', '78.446253', '40.936936', 3, NULL, '0997', '843500', 'Aheqi', 'A', NULL);
INSERT INTO `ez_area` VALUES (653024, '乌恰县', 653000, '75.259227,39.71931', 'district', '75.259227', '39.71931', 3, NULL, '0908', '845450', 'Wuqia', 'W', NULL);
INSERT INTO `ez_area` VALUES (653100, '喀什地区', 650000, '75.989741,39.47046', 'city', '75.989741', '39.47046', 2, NULL, '0998', '844000', 'Kashgar', 'K', NULL);
INSERT INTO `ez_area` VALUES (653101, '喀什市', 653100, '75.99379,39.467685', 'district', '75.99379', '39.467685', 3, NULL, '0998', '844000', 'Kashi', 'K', NULL);
INSERT INTO `ez_area` VALUES (653121, '疏附县', 653100, '75.862813,39.375043', 'district', '75.862813', '39.375043', 3, NULL, '0998', '844100', 'Shufu', 'S', NULL);
INSERT INTO `ez_area` VALUES (653122, '疏勒县', 653100, '76.048139,39.401384', 'district', '76.048139', '39.401384', 3, NULL, '0998', '844200', 'Shule', 'S', NULL);
INSERT INTO `ez_area` VALUES (653123, '英吉沙县', 653100, '76.175729,38.930381', 'district', '76.175729', '38.930381', 3, NULL, '0998', '844500', 'Yingjisha', 'Y', NULL);
INSERT INTO `ez_area` VALUES (653124, '泽普县', 653100, '77.259675,38.18529', 'district', '77.259675', '38.18529', 3, NULL, '0998', '844800', 'Zepu', 'Z', NULL);
INSERT INTO `ez_area` VALUES (653125, '莎车县', 653100, '77.245761,38.41422', 'district', '77.245761', '38.41422', 3, NULL, '0998', '844700', 'Shache', 'S', NULL);
INSERT INTO `ez_area` VALUES (653126, '叶城县', 653100, '77.413836,37.882989', 'district', '77.413836', '37.882989', 3, NULL, '0998', '844900', 'Yecheng', 'Y', NULL);
INSERT INTO `ez_area` VALUES (653127, '麦盖提县', 653100, '77.610125,38.898001', 'district', '77.610125', '38.898001', 3, NULL, '0998', '844600', 'Maigaiti', 'M', NULL);
INSERT INTO `ez_area` VALUES (653128, '岳普湖县', 653100, '76.8212,39.2198', 'district', '76.8212', '39.2198', 3, NULL, '0998', '844400', 'Yuepuhu', 'Y', NULL);
INSERT INTO `ez_area` VALUES (653129, '伽师县', 653100, '76.723719,39.488181', 'district', '76.723719', '39.488181', 3, NULL, '0998', '844300', 'Jiashi', 'J', NULL);
INSERT INTO `ez_area` VALUES (653130, '巴楚县', 653100, '78.549296,39.785155', 'district', '78.549296', '39.785155', 3, NULL, '0998', '843800', 'Bachu', 'B', NULL);
INSERT INTO `ez_area` VALUES (653131, '塔什库尔干塔吉克自治县', 653100, '75.229889,37.772094', 'district', '75.229889', '37.772094', 3, NULL, '0998', '845250', 'Tashikuergantajike', 'T', NULL);
INSERT INTO `ez_area` VALUES (653200, '和田地区', 650000, '79.922211,37.114157', 'city', '79.922211', '37.114157', 2, NULL, '0903', '848000', 'Hotan', 'H', NULL);
INSERT INTO `ez_area` VALUES (653201, '和田市', 653200, '79.913534,37.112148', 'district', '79.913534', '37.112148', 3, NULL, '0903', '848000', 'Hetianshi', 'H', NULL);
INSERT INTO `ez_area` VALUES (653221, '和田县', 653200, '79.81907,37.120031', 'district', '79.81907', '37.120031', 3, NULL, '0903', '848000', 'Hetianxian', 'H', NULL);
INSERT INTO `ez_area` VALUES (653222, '墨玉县', 653200, '79.728683,37.277143', 'district', '79.728683', '37.277143', 3, NULL, '0903', '848100', 'Moyu', 'M', NULL);
INSERT INTO `ez_area` VALUES (653223, '皮山县', 653200, '78.283669,37.62145', 'district', '78.283669', '37.62145', 3, NULL, '0903', '845150', 'Pishan', 'P', NULL);
INSERT INTO `ez_area` VALUES (653224, '洛浦县', 653200, '80.188986,37.073667', 'district', '80.188986', '37.073667', 3, NULL, '0903', '848200', 'Luopu', 'L', NULL);
INSERT INTO `ez_area` VALUES (653225, '策勒县', 653200, '80.806159,36.998335', 'district', '80.806159', '36.998335', 3, NULL, '0903', '848300', 'Cele', 'C', NULL);
INSERT INTO `ez_area` VALUES (653226, '于田县', 653200, '81.677418,36.85708', 'district', '81.677418', '36.85708', 3, NULL, '0903', '848400', 'Yutian', 'Y', NULL);
INSERT INTO `ez_area` VALUES (653227, '民丰县', 653200, '82.695861,37.06408', 'district', '82.695861', '37.06408', 3, NULL, '0903', '848500', 'Minfeng', 'M', NULL);
INSERT INTO `ez_area` VALUES (654000, '伊犁哈萨克自治州', 650000, '81.324136,43.916823', 'city', '81.324136', '43.916823', 2, NULL, '0999', '835100', 'Ili', 'I', NULL);
INSERT INTO `ez_area` VALUES (654002, '伊宁市', 654000, '81.27795,43.908558', 'district', '81.27795', '43.908558', 3, NULL, '0999', '835000', 'Yining', 'Y', NULL);
INSERT INTO `ez_area` VALUES (654003, '奎屯市', 654000, '84.903267,44.426529', 'district', '84.903267', '44.426529', 3, NULL, '0992', '833200', 'Kuitun', 'K', NULL);
INSERT INTO `ez_area` VALUES (654004, '霍尔果斯市', 654000, '80.411271,44.213941', 'district', '80.411271', '44.213941', 3, NULL, '0999', '835221', 'Huoerguosi', 'H', NULL);
INSERT INTO `ez_area` VALUES (654021, '伊宁县', 654000, '81.52745,43.977119', 'district', '81.52745', '43.977119', 3, NULL, '0999', '835100', 'Yining', 'Y', NULL);
INSERT INTO `ez_area` VALUES (654022, '察布查尔锡伯自治县', 654000, '81.151337,43.840726', 'district', '81.151337', '43.840726', 3, NULL, '0999', '835300', 'Chabuchaerxibo', 'C', NULL);
INSERT INTO `ez_area` VALUES (654023, '霍城县', 654000, '80.87898,44.055984', 'district', '80.87898', '44.055984', 3, NULL, '0999', '835200', 'Huocheng', 'H', NULL);
INSERT INTO `ez_area` VALUES (654024, '巩留县', 654000, '82.231718,43.482628', 'district', '82.231718', '43.482628', 3, NULL, '0999', '835400', 'Gongliu', 'G', NULL);
INSERT INTO `ez_area` VALUES (654025, '新源县', 654000, '83.232848,43.433896', 'district', '83.232848', '43.433896', 3, NULL, '0999', '835800', 'Xinyuan', 'X', NULL);
INSERT INTO `ez_area` VALUES (654026, '昭苏县', 654000, '81.130974,43.157293', 'district', '81.130974', '43.157293', 3, NULL, '0999', '835600', 'Zhaosu', 'Z', NULL);
INSERT INTO `ez_area` VALUES (654027, '特克斯县', 654000, '81.836206,43.217183', 'district', '81.836206', '43.217183', 3, NULL, '0999', '835500', 'Tekesi', 'T', NULL);
INSERT INTO `ez_area` VALUES (654028, '尼勒克县', 654000, '82.511809,43.800247', 'district', '82.511809', '43.800247', 3, NULL, '0999', '835700', 'Nileke', 'N', NULL);
INSERT INTO `ez_area` VALUES (654200, '塔城地区', 650000, '82.980316,46.745364', 'city', '82.980316', '46.745364', 2, NULL, '0901', '834700', 'Qoqek', 'Q', NULL);
INSERT INTO `ez_area` VALUES (654201, '塔城市', 654200, '82.986978,46.751428', 'district', '82.986978', '46.751428', 3, NULL, '0901', '834700', 'Tacheng', 'T', NULL);
INSERT INTO `ez_area` VALUES (654202, '乌苏市', 654200, '84.713396,44.41881', 'district', '84.713396', '44.41881', 3, NULL, '0992', '833000', 'Wusu', 'W', NULL);
INSERT INTO `ez_area` VALUES (654221, '额敏县', 654200, '83.628303,46.524673', 'district', '83.628303', '46.524673', 3, NULL, '0901', '834600', 'Emin', 'E', NULL);
INSERT INTO `ez_area` VALUES (654223, '沙湾县', 654200, '85.619416,44.326388', 'district', '85.619416', '44.326388', 3, NULL, '0993', '832100', 'Shawan', 'S', NULL);
INSERT INTO `ez_area` VALUES (654224, '托里县', 654200, '83.60695,45.947638', 'district', '83.60695', '45.947638', 3, NULL, '0901', '834500', 'Tuoli', 'T', NULL);
INSERT INTO `ez_area` VALUES (654225, '裕民县', 654200, '82.982667,46.201104', 'district', '82.982667', '46.201104', 3, NULL, '0901', '834800', 'Yumin', 'Y', NULL);
INSERT INTO `ez_area` VALUES (654226, '和布克赛尔蒙古自治县', 654200, '85.728328,46.793235', 'district', '85.728328', '46.793235', 3, NULL, '0990', '834400', 'Hebukesaier', 'H', NULL);
INSERT INTO `ez_area` VALUES (654300, '阿勒泰地区', 650000, '88.141253,47.844924', 'city', '88.141253', '47.844924', 2, NULL, '0906', '836500', 'Altay', 'A', NULL);
INSERT INTO `ez_area` VALUES (654301, '阿勒泰市', 654300, '88.131842,47.827308', 'district', '88.131842', '47.827308', 3, NULL, '0906', '836500', 'Aletai', 'A', NULL);
INSERT INTO `ez_area` VALUES (654321, '布尔津县', 654300, '86.874923,47.702163', 'district', '86.874923', '47.702163', 3, NULL, '0906', '836600', 'Buerjin', 'B', NULL);
INSERT INTO `ez_area` VALUES (654322, '富蕴县', 654300, '89.525504,46.994115', 'district', '89.525504', '46.994115', 3, NULL, '0906', '836100', 'Fuyun', 'F', NULL);
INSERT INTO `ez_area` VALUES (654323, '福海县', 654300, '87.486703,47.111918', 'district', '87.486703', '47.111918', 3, NULL, '0906', '836400', 'Fuhai', 'F', NULL);
INSERT INTO `ez_area` VALUES (654324, '哈巴河县', 654300, '86.418621,48.060846', 'district', '86.418621', '48.060846', 3, NULL, '0906', '836700', 'Habahe', 'H', NULL);
INSERT INTO `ez_area` VALUES (654325, '青河县', 654300, '90.37555,46.679113', 'district', '90.37555', '46.679113', 3, NULL, '0906', '836200', 'Qinghe', 'Q', NULL);
INSERT INTO `ez_area` VALUES (654326, '吉木乃县', 654300, '85.874096,47.443101', 'district', '85.874096', '47.443101', 3, NULL, '0906', '836800', 'Jimunai', 'J', NULL);
INSERT INTO `ez_area` VALUES (659001, '石河子市', 650000, '86.080602,44.306097', 'city', '86.080602', '44.306097', 2, NULL, '0993', '832000', 'Shihezi', 'S', NULL);
INSERT INTO `ez_area` VALUES (659002, '阿拉尔市', 650000, '81.280527,40.547653', 'city', '81.280527', '40.547653', 2, NULL, '0997', '843300', 'Aral', 'A', NULL);
INSERT INTO `ez_area` VALUES (659003, '图木舒克市', 650000, '79.073963,39.868965', 'city', '79.073963', '39.868965', 2, NULL, '0998', '843806', 'Tumxuk', 'T', NULL);
INSERT INTO `ez_area` VALUES (659004, '五家渠市', 650000, '87.54324,44.166756', 'city', '87.54324', '44.166756', 2, NULL, '0994', '831300', 'Wujiaqu', 'W', NULL);
INSERT INTO `ez_area` VALUES (659005, '北屯市', 650000, '87.837075,47.332643', 'city', '87.837075', '47.332643', 2, NULL, '0906', '836000', 'Beitun', 'B', NULL);
INSERT INTO `ez_area` VALUES (659006, '铁门关市', 650000, '85.501217,41.82725', 'city', '85.501217', '41.82725', 2, NULL, '0906', '836000', 'Tiemenguan', 'T', NULL);
INSERT INTO `ez_area` VALUES (659007, '双河市', 650000, '82.353656,44.840524', 'city', '82.353656', '44.840524', 2, NULL, '0909', '833408', 'Shuanghe', 'S', NULL);
INSERT INTO `ez_area` VALUES (659008, '可克达拉市', 650000, '81.044542,43.944798', 'city', '81.044542', '43.944798', 2, NULL, '0999', '835213', 'Kekedala', 'K', NULL);
INSERT INTO `ez_area` VALUES (659009, '昆玉市', 650000, '79.291083,37.209642', 'city', '79.291083', '37.209642', 2, NULL, '0903', '848116', 'Kunyu', 'K', NULL);
INSERT INTO `ez_area` VALUES (710000, '台湾省', 0, '121.509062,25.044332', 'province', '121.509062', '25.044332', 1, NULL, NULL, NULL, 'Taiwan', 'T', NULL);
INSERT INTO `ez_area` VALUES (810000, '香港特别行政区', 0, '114.171203,22.277468', 'province', '114.171203', '22.277468', 1, NULL, NULL, NULL, 'Xianggang', 'X', NULL);
INSERT INTO `ez_area` VALUES (810001, '中西区', 810000, '114.154373,22.281981', 'district', '114.154373', '22.281981', 3, NULL, '00852', '999077', 'Zhongxi', 'Z', NULL);
INSERT INTO `ez_area` VALUES (810002, '湾仔区', 810000, '114.182915,22.276389', 'district', '114.182915', '22.276389', 3, NULL, '00852', '999077', 'Wanzai', 'W', NULL);
INSERT INTO `ez_area` VALUES (810003, '东区', 810000, '114.226003,22.279693', 'district', '114.226003', '22.279693', 3, NULL, '00852', '999077', 'Dongqu', 'D', NULL);
INSERT INTO `ez_area` VALUES (810004, '南区', 810000, '114.160012,22.245897', 'district', '114.160012', '22.245897', 3, NULL, '00852', '999077', 'Nanqu', 'N', NULL);
INSERT INTO `ez_area` VALUES (810005, '油尖旺区', 810000, '114.173332,22.311704', 'district', '114.173332', '22.311704', 3, NULL, '00852', '999077', 'Youjianwang', 'Y', NULL);
INSERT INTO `ez_area` VALUES (810006, '深水埗区', 810000, '114.163242,22.333854', 'district', '114.163242', '22.333854', 3, NULL, '00852', '999077', 'Shenshuibu', 'S', NULL);
INSERT INTO `ez_area` VALUES (810007, '九龙城区', 810000, '114.192847,22.31251', 'district', '114.192847', '22.31251', 3, NULL, '00852', '999077', 'Jiulong', 'J', NULL);
INSERT INTO `ez_area` VALUES (810008, '黄大仙区', 810000, '114.203886,22.336321', 'district', '114.203886', '22.336321', 3, NULL, '00852', '999077', 'Huangdaxian', 'H', NULL);
INSERT INTO `ez_area` VALUES (810009, '观塘区', 810000, '114.214054,22.320838', 'district', '114.214054', '22.320838', 3, NULL, '00852', '999077', 'Guantang', 'G', NULL);
INSERT INTO `ez_area` VALUES (810010, '荃湾区', 810000, '114.121079,22.368306', 'district', '114.121079', '22.368306', 3, NULL, '00852', '999077', 'Quanwan', 'Q', NULL);
INSERT INTO `ez_area` VALUES (810011, '屯门区', 810000, '113.976574,22.393844', 'district', '113.976574', '22.393844', 3, NULL, '00852', '999077', 'Tunmen', 'T', NULL);
INSERT INTO `ez_area` VALUES (810012, '元朗区', 810000, '114.032438,22.441428', 'district', '114.032438', '22.441428', 3, NULL, '00852', '999077', 'Yuanlang', 'Y', NULL);
INSERT INTO `ez_area` VALUES (810013, '北区', 810000, '114.147364,22.496104', 'district', '114.147364', '22.496104', 3, NULL, '00852', '999077', 'Beiqu', 'B', NULL);
INSERT INTO `ez_area` VALUES (810014, '大埔区', 810000, '114.171743,22.445653', 'district', '114.171743', '22.445653', 3, NULL, '00852', '999077', 'Dabu', 'D', NULL);
INSERT INTO `ez_area` VALUES (810015, '西贡区', 810000, '114.264645,22.314213', 'district', '114.264645', '22.314213', 3, NULL, '00852', '999077', 'Xigong', 'X', NULL);
INSERT INTO `ez_area` VALUES (810016, '沙田区', 810000, '114.195365,22.379532', 'district', '114.195365', '22.379532', 3, NULL, '00852', '999077', 'Shantian', 'S', NULL);
INSERT INTO `ez_area` VALUES (810017, '葵青区', 810000, '114.139319,22.363877', 'district', '114.139319', '22.363877', 3, NULL, '00852', '999077', 'Kuiqing', 'K', NULL);
INSERT INTO `ez_area` VALUES (810018, '离岛区', 810000, '113.94612,22.286408', 'district', '113.94612', '22.286408', 3, NULL, '00852', '999077', 'Lidao', 'L', NULL);
INSERT INTO `ez_area` VALUES (820000, '澳门特别行政区', 0, '113.543028,22.186835', 'province', '113.543028', '22.186835', 1, NULL, NULL, NULL, 'Aomen', 'A', NULL);
INSERT INTO `ez_area` VALUES (820001, '花地玛堂区', 820000, '113.552896,22.20787', 'district', '113.552896', '22.20787', 3, NULL, '00853', '999078', 'Huadima', 'H', NULL);
INSERT INTO `ez_area` VALUES (820002, '花王堂区', 820000, '113.548961,22.199207', 'district', '113.548961', '22.199207', 3, NULL, '00853', '999078', 'Huawang', 'H', NULL);
INSERT INTO `ez_area` VALUES (820003, '望德堂区', 820000, '113.550183,22.193721', 'district', '113.550183', '22.193721', 3, NULL, '00853', '999078', 'Wangde', 'W', NULL);
INSERT INTO `ez_area` VALUES (820004, '大堂区', 820000, '113.553647,22.188539', 'district', '113.553647', '22.188539', 3, NULL, '00853', '999078', 'Da', 'D', NULL);
INSERT INTO `ez_area` VALUES (820005, '风顺堂区', 820000, '113.541928,22.187368', 'district', '113.541928', '22.187368', 3, NULL, '00853', '999078', 'Fengshun', 'F', NULL);
INSERT INTO `ez_area` VALUES (820006, '嘉模堂区', 820000, '113.558705,22.15376', 'district', '113.558705', '22.15376', 3, NULL, '00853', '999078', 'Jiamo', 'J', NULL);
INSERT INTO `ez_area` VALUES (820007, '路凼填海区', 820000, '113.569599,22.13663', 'district', '113.569599', '22.13663', 3, NULL, '00853', '999078', 'Ludang', 'L', NULL);
INSERT INTO `ez_area` VALUES (820008, '圣方济各堂区', 820000, '113.559954,22.123486', 'district', '113.559954', '22.123486', 3, NULL, '00853', '999078', 'Shengfangjige', 'S', NULL);

-- ----------------------------
-- Table structure for ez_article
-- ----------------------------
DROP TABLE IF EXISTS `ez_article`;
CREATE TABLE `ez_article`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` int(11) UNSIGNED NULL DEFAULT NULL COMMENT '分类id',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '名称',
  `hits` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '点击率',
  `text` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '内容',
  `desc` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '描述',
  `sort` smallint(6) UNSIGNED NULL DEFAULT 999 COMMENT '排序',
  `img` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '图片',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '时间',
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '链接',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '0未审核1审核',
  `flags` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '自定义属性',
  `source` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '来源',
  `author` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '作者',
  `keywords` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '关键字',
  `images` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '多图',
  `extend` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '多功能拓展 json',
  `template` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '模板地址',
  `img_status` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '1显示0不显示',
  `attachment` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '附件',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '信息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `ez_auth_group`;
CREATE TABLE `ez_auth_group`  (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `rule_ids` json NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '用户组表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ez_auth_group
-- ----------------------------
INSERT INTO `ez_auth_group` VALUES (1, '管理组', NULL, 1, NULL);
INSERT INTO `ez_auth_group` VALUES (2, '客户端开发组', NULL, 1, NULL);

-- ----------------------------
-- Table structure for ez_auth_group_access
-- ----------------------------
DROP TABLE IF EXISTS `ez_auth_group_access`;
CREATE TABLE `ez_auth_group_access`  (
  `uid` int(8) UNSIGNED NOT NULL COMMENT '用户id',
  `group_id` int(8) UNSIGNED NOT NULL COMMENT '用户组id',
  UNIQUE INDEX `uid_group_id`(`uid`, `group_id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `group_id`(`group_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '用户组明细表' ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of ez_auth_group_access
-- ----------------------------
INSERT INTO `ez_auth_group_access` VALUES (1, 1);

-- ----------------------------
-- Table structure for ez_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `ez_auth_rule`;
CREATE TABLE `ez_auth_rule`  (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sign` char(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '规则唯一标识',
  `title` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '规则中文名称',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态：为1正常，为0禁用',
  `type` char(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `condition` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '规则表达式，为空表示存在就验证，不为空表示按照条件验证',
  `pid` mediumint(8) UNSIGNED NULL DEFAULT 0 COMMENT '父级id',
  `is_system` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '系统节点',
  `sort` mediumint(6) UNSIGNED NULL DEFAULT 999 COMMENT '排序',
  `is_display` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '0不展示1展示',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `name`(`sign`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 325 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '规则表' ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of ez_auth_rule
-- ----------------------------
INSERT INTO `ez_auth_rule` VALUES (1, 'area', '地区管理', 1, 'admin', '', 0, 1, 0, 1);
INSERT INTO `ez_auth_rule` VALUES (2, 'auth', '权限管理', 1, 'admin', '', 0, 1, 555, 1);
INSERT INTO `ez_auth_rule` VALUES (3, 'cashback', '返现管理', 1, 'admin', '', 0, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (4, 'dispatch', '不知道干嘛的', 1, 'admin', '', 0, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (5, 'express', '物流公司', 1, 'admin', '', 0, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (6, 'freight', '运费模板', 1, 'admin', '', 0, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (7, 'goods', '商品管理', 1, 'admin', '', 0, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (8, 'goodsbrand', '商品品牌', 1, 'admin', '', 0, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (9, 'goodscategory', '商品分类', 1, 'admin', '', 0, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (10, 'goodsevaluation', '商品评价', 1, 'admin', '', 0, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (11, 'goodsgive', '赠品', 1, 'admin', '', 0, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (12, 'goodsspec', '商品规格', 1, 'admin', '', 0, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (13, 'goodsspecvalue', '商品规格值', 1, 'admin', '', 0, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (14, 'goodstags', '商品标签', 1, 'admin', '', 0, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (15, 'goodstype', '商品类型', 1, 'admin', '', 0, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (16, 'image', '图片管理', 1, 'admin', '', 0, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (17, 'index', '概况', 1, 'admin', '', 0, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (18, 'info', '文章管理', 1, 'admin', '', 0, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (19, 'infocategory', '文章分类', 1, 'admin', '', 0, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (20, 'install', '安装', 1, 'admin', '', 0, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (21, 'integral', '积分', 1, 'admin', '', 0, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (22, 'member', '成员', 1, 'admin', '', 0, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (23, 'message', '消息', 1, 'admin', '', 0, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (24, 'mix', '杂项', 1, 'admin', '', 0, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (25, 'order', '订单', 1, 'admin', '', 0, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (26, 'orderrefund', '退款退货', 1, 'admin', '', 0, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (27, 'orderrefundreason', '退款退款退货原因控制器', 1, 'admin', '', 0, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (28, 'page', '页面', 1, 'admin', '', 0, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (29, 'payment', '支付方式', 1, 'admin', '', 0, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (30, 'pdcash', '提现', 1, 'admin', '', 0, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (31, 'pdlog', '提现日志', 1, 'admin', '', 0, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (32, 'pdrecharge', '预存款', 1, 'admin', '', 0, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (33, 'report', '举报', 1, 'admin', '', 0, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (34, 'runtime', '缓存管理', 1, 'admin', '', 0, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (35, 'sendarea', '可配送区域', 1, 'admin', '', 0, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (36, 'setting', '设置，可能要废弃', 1, 'admin', '', 0, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (37, 'shipper', '物流地址', 1, 'admin', '', 0, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (38, 'shop', '店铺', 1, 'admin', '', 0, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (39, 'statistics', '数据统计', 1, 'admin', '', 0, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (40, 'upload', '上传', 1, 'admin', '', 0, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (41, 'user', '会员', 1, 'admin', '', 0, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (42, 'useradvice', '意见反馈', 1, 'admin', '', 0, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (43, 'useradvicetype', '意见反馈类别', 1, 'admin', '', 0, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (44, 'userlevel', '会员级别', 1, 'admin', '', 0, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (45, 'version', '版本控制', 1, 'admin', '', 0, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (46, 'voucher', '优惠券', 1, 'admin', '', 0, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (47, 'wechat', '微信管理', 1, 'admin', '', 0, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (48, 'area/list', '@method', 1, 'admin', '', 1, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (49, 'area/openoperation', '设置开通或者取消开通城市', 1, 'admin', '', 1, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (50, 'area/hotoperation', '设置热门或者取消热门城市', 1, 'admin', '', 1, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (51, 'area/createjs', '生产代码js', 1, 'admin', '', 1, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (52, 'auth/groupauthorise', '角色组授权', 1, 'admin', '', 2, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (53, 'auth/grouplist', '角色组列表', 1, 'admin', '', 2, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (54, 'auth/groupinfo', '角色组的信息', 1, 'admin', '', 2, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (55, 'auth/groupmemberlist', '角色组内成员', 1, 'admin', '', 2, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (56, 'auth/groupmemberedit', '组内成员修改', 1, 'admin', '', 2, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (57, 'auth/groupadd', '角色组添加', 1, 'admin', '', 2, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (58, 'auth/groupedit', '角色组修改', 1, 'admin', '', 2, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (59, 'auth/groupdel', '角色组删除', 1, 'admin', '', 2, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (60, 'auth/ruletree', '节点树形结构', 1, 'admin', '', 2, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (61, 'auth/ruleinfo', '节点详情', 1, 'admin', '', 2, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (62, 'auth/ruleadd', '节点规则添加', 1, 'admin', '', 2, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (63, 'auth/ruleedit', '节点规则修改', 1, 'admin', '', 2, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (64, 'auth/ruledel', '节点规则删除', 1, 'admin', '', 2, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (65, 'auth/rulesort', '节点排序', 1, 'admin', '', 2, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (66, 'cashback/add', '返现添加', 1, 'admin', '', 3, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (67, 'cashback/edit', '返现修改', 1, 'admin', '', 3, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (68, 'cashback/del', '返现删除', 1, 'admin', '', 3, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (69, 'dispatch/add', '添加', 1, 'admin', '', 4, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (70, 'dispatch/edit', '修改', 1, 'admin', '', 4, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (71, 'dispatch/del', '删除', 1, 'admin', '', 4, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (72, 'dispatch/map', '@method', 1, 'admin', '', 4, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (73, 'dispatch/dispatprint', '@method', 1, 'admin', '', 4, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (74, 'dispatch/delsn', '@method', 1, 'admin', '', 4, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (75, 'dispatch/addsn', '@method', 1, 'admin', '', 4, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (76, 'express/add', '添加物流公司', 1, 'admin', '', 5, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (77, 'express/edit', '编辑物流公司', 1, 'admin', '', 5, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (78, 'express/setcommonlyuse', '设置为常用物流状态', 1, 'admin', '', 5, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (79, 'express/list', '物流公司列表', 1, 'admin', '', 5, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (80, 'express/del', '删除物流公司', 1, 'admin', '', 5, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (81, 'freight/add', '添加运费模板', 1, 'admin', '', 6, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (82, 'freight/edit', '编辑运费模板', 1, 'admin', '', 6, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (83, 'freight/list', '运费列表', 1, 'admin', '', 6, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (84, 'freight/del', '删除运费模板', 1, 'admin', '', 6, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (85, 'goods/adddetail', '商品详情(添加商品时展示使用)', 1, 'admin', '', 7, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (86, 'goods/add', '添加商品', 1, 'admin', '', 7, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (87, 'goods/edit', '修改商品', 1, 'admin', '', 7, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (88, 'goods/info', '商品信息', 1, 'admin', '', 7, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (89, 'goods/editdetail', '商品详情(修改商品时展示使用)', 1, 'admin', '', 7, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (90, 'goods/pulloffshelves', '商品违规下架', 1, 'admin', '', 7, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (91, 'goods/batchgrounding', '商品批量上架', 1, 'admin', '', 7, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (92, 'goods/batchupshelf', '商品批量下架', 1, 'admin', '', 7, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (93, 'goods/batchdel', '批量删除商品', 1, 'admin', '', 7, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (94, 'goodsbrand/add', '商品品牌添加', 1, 'admin', '', 8, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (95, 'goodsbrand/edit', '商品品牌修改', 1, 'admin', '', 8, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (96, 'goodsbrand/del', '商品品牌删除', 1, 'admin', '', 8, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (97, 'goodscategory/add', '添加商品分类', 1, 'admin', '', 9, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (98, 'goodscategory/edit', '修改商品分类', 1, 'admin', '', 9, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (99, 'goodscategory/list', '商品分类列表', 1, 'admin', '', 9, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (100, 'goodscategory/parentlist', '一级分类所有数据', 1, 'admin', '', 9, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (101, 'goodscategory/del', '删除商品分类', 1, 'admin', '', 9, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (102, 'goodscategory/sort', '排序', 1, 'admin', '', 9, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (103, 'goodsevaluation/list', '评价列表', 1, 'admin', '', 10, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (104, 'goodsevaluation/reply', '添加回复', 1, 'admin', '', 10, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (105, 'goodsgive/add', '添加', 1, 'admin', '', 11, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (106, 'goodsgive/edit', '修改', 1, 'admin', '', 11, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (107, 'goodsgive/del', '删除', 1, 'admin', '', 11, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (108, 'goodsspec/search', '商品规格列表', 1, 'admin', '', 12, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (109, 'goodsspec/add', '添加商品规格', 1, 'admin', '', 12, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (110, 'goodsspec/edit', '修改商品规格', 1, 'admin', '', 12, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (111, 'goodsspec/del', '删除商品规格', 1, 'admin', '', 12, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (112, 'goodsspecvalue/search', '商品规格值列表', 1, 'admin', '', 13, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (113, 'goodsspecvalue/add', '添加商品规格值', 1, 'admin', '', 13, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (114, 'goodsspecvalue/del', '删除商品规格值', 1, 'admin', '', 13, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (115, 'goodstags/insert', '', 1, 'admin', '', 14, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (116, 'goodstags/edit', '', 1, 'admin', '', 14, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (117, 'goodstags/del', '', 1, 'admin', '', 14, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (118, 'goodstype/add', '添加类型', 1, 'admin', '', 15, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (119, 'goodstype/edit', '修改类型', 1, 'admin', '', 15, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (120, 'goodstype/del', '@method', 1, 'admin', '', 15, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (121, 'goodstype/typeattributeedit', '', 1, 'admin', '', 15, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (122, 'image/list', '应用图片列表', 1, 'admin', '', 16, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (123, 'image/wechat', '微信图片列表', 1, 'admin', '', 16, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (124, 'image/add', '上传图片', 1, 'admin', '', 16, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (125, 'image/remotegrab', '提取网络图片', 1, 'admin', '', 16, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (126, 'image/goodsimagelist', '商品图列表', 1, 'admin', '', 16, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (127, 'index/left', '@method', 1, 'admin', '', 17, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (128, 'index/top', '顶部', 1, 'admin', '', 17, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (129, 'index/main', '主体', 1, 'admin', '', 17, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (130, 'index/footer', '尾部', 1, 'admin', '', 17, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (131, 'index/get_all_access_node', '获得当前用户的权限节点', 1, 'admin', '', 17, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (132, 'info/add', '添加', 1, 'admin', '', 18, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (133, 'info/edit', '修改', 1, 'admin', '', 18, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (134, 'info/del', '删除', 1, 'admin', '', 18, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (135, 'info/getrelationmodeldatasearch', '获得关联数据的搜索接口', 1, 'admin', '', 18, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (136, 'infocategory/add', '信息分类添加', 1, 'admin', '', 19, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (137, 'infocategory/edit', '信息分类修改', 1, 'admin', '', 19, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (138, 'infocategory/del', '信息分类删除', 1, 'admin', '', 19, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (139, 'infocategory/sort', '信息分类排序', 1, 'admin', '', 19, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (140, 'install/configure', '检测本地环境是否符合当前安装要求', 1, 'admin', '', 20, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (141, 'install/establishdb', '', 1, 'admin', '', 20, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (142, 'install/createsheet', '', 1, 'admin', '', 20, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (143, 'install/complete', '', 1, 'admin', '', 20, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (144, 'integral/insert', '', 1, 'admin', '', 21, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (145, 'integral/edit', '', 1, 'admin', '', 21, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (146, 'integral/del', '', 1, 'admin', '', 21, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (147, 'integral/log', '', 1, 'admin', '', 21, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (148, 'member/list', '后台用户', 1, 'admin', '', 22, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (149, 'member/add', '添加成员', 1, 'admin', '', 22, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (150, 'member/edit', '修改', 1, 'admin', '', 22, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (151, 'member/info', '获得详情', 1, 'admin', '', 22, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (152, 'member/del', '删除后台用户', 1, 'admin', '', 22, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (153, 'message/add', '通知添加', 1, 'admin', '', 23, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (154, 'message/messagetypeindex', '消息类型列表', 1, 'admin', '', 23, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (155, 'message/messagetypeadd', '消息类型添加', 1, 'admin', '', 23, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (156, 'message/messagetypeedit', '消息类型添加', 1, 'admin', '', 23, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (157, 'message/getmessagerelationmodeldatasearch', '获得消息关联数据的搜索接口', 1, 'admin', '', 23, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (158, 'mix/verifycode', '', 1, 'admin', '', 24, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (159, 'mix/testsessioncookie', '', 1, 'admin', '', 24, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (160, 'order/list', '订单列表', 1, 'admin', '', 25, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (161, 'order/ordercount', '订单数量', 1, 'admin', '', 25, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (162, 'order/info', '订单详情', 1, 'admin', '', 25, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (163, 'order/sendgoods', '设置发货', 1, 'admin', '', 25, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (164, 'order/logisticsquery', '物流查询', 1, 'admin', '', 25, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (165, 'orderrefund/list', '退款售后列表', 1, 'admin', '', 26, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (166, 'orderrefund/info', '退款详情', 1, 'admin', '', 26, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (167, 'orderrefund/handle', '退款审核页', 1, 'admin', '', 26, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (168, 'orderrefund/receive', '退款退货的订单', 1, 'admin', '', 26, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (169, 'orderrefund/refund', '进行退款处理', 1, 'admin', '', 26, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (170, 'orderrefund/wxpayrefund', '微信支付退款', 1, 'admin', '', 26, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (171, 'orderrefund/predepositrefund', '余额支付退款', 1, 'admin', '', 26, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (172, 'orderrefund/alipayrefund', '', 1, 'admin', '', 26, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (173, 'orderrefundreason/add', '添加', 1, 'admin', '', 27, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (174, 'orderrefundreason/detail', '详情', 1, 'admin', '', 27, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (175, 'orderrefundreason/edit', '修改', 1, 'admin', '', 27, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (176, 'orderrefundreason/del', '删除', 1, 'admin', '', 27, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (177, 'page/list', '模板列表', 1, 'admin', '', 28, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (178, 'page/add', '模板添加', 1, 'admin', '', 28, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (179, 'page/edit', '模板编辑', 1, 'admin', '', 28, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (180, 'page/setportal', '设为首页', 1, 'admin', '', 28, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (181, 'payment/setting', '支付方式', 1, 'admin', '', 29, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (182, 'payment/edit', '编辑', 1, 'admin', '', 29, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (183, 'pdcash/del', '删除提现记录', 1, 'admin', '', 30, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (184, 'pdcash/pay', '更改提现为支付状态', 1, 'admin', '', 30, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (185, 'pdcash/detail', '查看提现信息', 1, 'admin', '', 30, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (186, 'pdcash/pdcashpay', '更改支付状态', 1, 'admin', '', 30, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (187, 'pdrecharge/edit', '充值编辑(更改成收到款)', 1, 'admin', '', 32, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (188, 'pdrecharge/detail', '充值查看', 1, 'admin', '', 32, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (189, 'pdrecharge/del', '充值删除', 1, 'admin', '', 32, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (190, 'pdrecharge/export_step1', '导出预存款充值记录', 1, 'admin', '', 32, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (191, 'pdrecharge/export_cash_step1', '导出预存款提现记录', 1, 'admin', '', 32, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (192, 'pdrecharge/export_mx_step1', '预存款明细信息导出', 1, 'admin', '', 32, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (193, 'report/del', '删除()', 1, 'admin', '', 33, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (194, 'runtime/logrecord', '日记记录', 1, 'admin', '', 34, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (195, 'runtime/clearcache', '清理缓存', 1, 'admin', '', 34, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (196, 'runtime/clearlog', '清理日志', 1, 'admin', '', 34, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (197, 'sendarea/add', '新建可配送区域模板', 1, 'admin', '', 35, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (198, 'sendarea/list', '可配送区域模板列表', 1, 'admin', '', 35, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (199, 'sendarea/edit', '编辑可配送区域模板', 1, 'admin', '', 35, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (200, 'sendarea/del', '删除可配送区域模板', 1, 'admin', '', 35, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (201, 'setting/groupsearch', '分组列表', 1, 'admin', '', 36, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (202, 'setting/groupadd', '分组新增', 1, 'admin', '', 36, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (203, 'setting/groupedit', '分组修改', 1, 'admin', '', 36, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (204, 'setting/groupinfo', '分组详情', 1, 'admin', '', 36, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (205, 'setting/search', '配置搜索', 1, 'admin', '', 36, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (206, 'setting/add', '配置新增', 1, 'admin', '', 36, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (207, 'setting/edit', '配置修改', 1, 'admin', '', 36, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (208, 'setting/info', '配置详情', 1, 'admin', '', 36, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (209, 'setting/editmulti', '配置批量修改', 1, 'admin', '', 36, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (210, 'setting/del', '配置删除', 1, 'admin', '', 36, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (211, 'shipper/list', '物流地址列表', 1, 'admin', '', 37, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (212, 'shipper/add', '新增物流地址', 1, 'admin', '', 37, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (213, 'shipper/edit', '修改物流地址', 1, 'admin', '', 37, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (214, 'shipper/del', '删除物流地址', 1, 'admin', '', 37, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (215, 'shipper/setdefault', '设置默认地址', 1, 'admin', '', 37, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (216, 'shipper/setrefunddefault', '设置默认退货地址', 1, 'admin', '', 37, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (217, 'shop/setbaseinfo', '店铺基础信息设置', 1, 'admin', '', 38, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (218, 'shop/setcolorscheme', '店铺配色方案设置', 1, 'admin', '', 38, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (219, 'shop/setportaltemplate', '店铺首页模板选择', 1, 'admin', '', 38, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (220, 'shop/info', '店铺信息', 1, 'admin', '', 38, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (221, 'shop/setgoodscategorystyle', '店铺分类页风格设置', 1, 'admin', '', 38, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (222, 'statistics/nosendcount', '首页-概况-未发货订单数量', 1, 'admin', '', 39, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (223, 'statistics/daytotal', '首页-概况-当日销售额', 1, 'admin', '', 39, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (224, 'statistics/costaverage', '首页-概况-平均客单价', 1, 'admin', '', 39, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (225, 'statistics/yesterdaynewusercount', '首页-概况-昨日新增客户', 1, 'admin', '', 39, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (226, 'statistics/allusercount', '首页-概况-累计客户', 1, 'admin', '', 39, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (227, 'statistics/allpositivecount', '首页-概况-累计好评度', 1, 'admin', '', 39, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (228, 'statistics/yesterdaypositivecount', '首页-概况-昨日好评数', 1, 'admin', '', 39, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (229, 'statistics/yesterdaymoderatecount', '首页-概况-昨日中评数', 1, 'admin', '', 39, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (230, 'statistics/yesterdaynegativecount', '首页-概况-昨日差评数', 1, 'admin', '', 39, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (231, 'statistics/yesterdayadvicecount', '首页-概况-昨日建议反馈', 1, 'admin', '', 39, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (232, 'statistics/quantity', '首页-概况-数量', 1, 'admin', '', 39, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (233, 'statistics/monthsaleshistogram', '首页-概况-柱状图-月销售额', 1, 'admin', '', 39, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (234, 'statistics/monthordercounthistogram', '首页-概况-柱状图-月订单量', 1, 'admin', '', 39, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (235, 'statistics/monthuseraddcounthistogram', '首页-概况-柱状图-客户增量', 1, 'admin', '', 39, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (236, 'statistics/monthnewusersaleshistogram', '首页-概况-柱状图-新客户消费', 1, 'admin', '', 39, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (237, 'statistics/accumulativeamount', '累计', 1, 'admin', '', 39, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (238, 'statistics/dayaverage', '日均', 1, 'admin', '', 39, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (239, 'statistics/getlastyear', '获取去年的时间戳', 1, 'admin', '', 39, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (240, 'statistics/getdatefromrange', '获取指定日期段内每一天的日期', 1, 'admin', '', 39, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (241, 'statistics/daysnumber', '@method', 1, 'admin', '', 39, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (242, 'upload/addimage', '添加图片', 1, 'admin', '', 40, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (243, 'user/search', '客户管理', 1, 'admin', '', 41, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (244, 'user/add', '新增客户', 1, 'admin', '', 41, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (245, 'user/batchdel', '批量删除客户', 1, 'admin', '', 41, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (246, 'user/detail', '客户详情-客户信息', 1, 'admin', '', 41, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (247, 'user/statistics', '客户详情-交易概况-统计', 1, 'admin', '', 41, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (248, 'user/order', '客户详情-交易概况-用户订单', 1, 'admin', '', 41, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (249, 'user/address', '客户详情-交易概况-收货信息', 1, 'admin', '', 41, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (250, 'user/edit', '修改用户', 1, 'admin', '', 41, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (251, 'user/getuserlist', '获得用户列表', 1, 'admin', '', 41, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (252, 'useradvice/detail', '意见反馈详情', 1, 'admin', '', 42, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (253, 'useradvice/del', '意见反馈删除', 1, 'admin', '', 42, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (254, 'useradvicetype/add', '意见反馈类别添加', 1, 'admin', '', 43, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (255, 'useradvicetype/edit', '意见反馈类别修改', 1, 'admin', '', 43, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (256, 'useradvicetype/del', '意见反馈类别删除', 1, 'admin', '', 43, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (257, 'userlevel/add', '会员级别添加', 1, 'admin', '', 44, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (258, 'userlevel/edit', '会员级别修改', 1, 'admin', '', 44, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (259, 'userlevel/del', '会员级别删除', 1, 'admin', '', 44, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (260, 'version/add', '添加', 1, 'admin', '', 45, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (261, 'version/edit', '修改', 1, 'admin', '', 45, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (262, 'version/del', '删除', 1, 'admin', '', 45, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (263, 'voucher/takeback', '收回', 1, 'admin', '', 46, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (264, 'voucher/templatelist', '默认操作列出优惠券', 1, 'admin', '', 46, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (265, 'voucher/templateadd', '优惠券模版添加', 1, 'admin', '', 46, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (266, 'voucher/templateedit', '优惠券模版编辑', 1, 'admin', '', 46, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (267, 'voucher/templatedel', '删除优惠券', 1, 'admin', '', 46, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (268, 'voucher/templateinfo', '查看优惠券详细', 1, 'admin', '', 46, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (269, 'voucher/publishvoucher', '发布优惠券', 1, 'admin', '', 46, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (270, 'wechat/menulist', '读取（查询）已设置菜单', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (271, 'wechat/menucurrent', '获取当前菜单', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (272, 'wechat/menucreate', '创建自定义菜单', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (273, 'wechat/menudelete', '删除菜单', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (274, 'wechat/broadcastusersearch', '消息群发用户筛选', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (275, 'wechat/sendbroadcast', '立即群发（图文消息,图片消息,语音消息）', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (276, 'wechat/broadcastsendvideo', '立即群发（视频消息）', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (277, 'wechat/broadcastsendtext', '立即群发(文本消息)', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (278, 'wechat/broadcastsendcard', '卡券消息', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (279, 'wechat/broadcastpreviewtext', '发送预览群发', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (280, 'wechat/broadcastsendimagetext', '发送预览群发', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (281, 'wechat/broadcastsendvoice', '发送预览群发', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (282, 'wechat/broadcastsendpreviewcard', '发送预览群发', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (283, 'wechat/broadcastpreviewtextbyname', '发送预览群发', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (284, 'wechat/broadcastpreviewnewsbyname', '发送预览群发', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (285, 'wechat/broadcastpreviewimagebyname', '发送预览群发', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (286, 'wechat/broadcastpreviewvoicebyname', '发送预览群发', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (287, 'wechat/broadcastpreviewvideobyname', '发送预览群发', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (288, 'wechat/broadcastpreviewcardbyname', '发送预览群发', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (289, 'wechat/broadcastdelete', '删除群发消息', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (290, 'wechat/broadcaststatus', '查询群发消息发送状态', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (291, 'wechat/userget', '获取单个用户信息', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (292, 'wechat/userselect', '获取多个用户信息', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (293, 'wechat/userlist', '获取用户列表', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (294, 'wechat/userremark', '修改用户备注', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (295, 'wechat/userblock', '拉黑用户', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (296, 'wechat/userunblock', '取消拉黑用户', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (297, 'wechat/userblacklist', '黑名单列表', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (298, 'wechat/materiallist', '获取永久素材', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (299, 'wechat/materialuploadimage', '上传图片', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (300, 'wechat/uploadvoice', '上传声音', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (301, 'wechat/uploadvideo', '上传视频', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (302, 'wechat/uploadthumb', '上传缩略图', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (303, 'wechat/uploadvideoforbroadcasting', '上传群发视频', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (304, 'wechat/createvideoforbroadcasting', '创建群发消息', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (305, 'wechat/getjssdkmedia', '获取', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (306, 'wechat/list', '获取永久素材列表', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (307, 'wechat/stats', '获取素材计数', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (308, 'wechat/delete', '删除永久素材；', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (309, 'wechat/uploadimage', '', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (310, 'wechat/clear', '', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (311, 'wechat/create', '', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (312, 'wechat/userinfo', '', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (313, 'wechat/localnewsadd', '本地图文添加', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (314, 'wechat/localnewsedit', '本地图文修改', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (315, 'wechat/localnewsdel', '本地图文删除', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (316, 'wechat/localnews', '本地图文列表', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (317, 'wechat/usertaglist', '获取所有标签', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (318, 'wechat/usertagcreate', '创建标签', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (319, 'wechat/usertagupdate', '修改标签信息', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (320, 'wechat/usertagdelete', '删除标签', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (321, 'wechat/usertagsbyopenid', '获取指定', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (322, 'wechat/usertagusersoftag', '获取标签下用户列表', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (323, 'wechat/usertagtagusers', '批量为用户添加标签', 1, 'admin', '', 47, 1, 999, 1);
INSERT INTO `ez_auth_rule` VALUES (324, 'wechat/usertaguntagusers', '批量为用户移除标签', 1, 'admin', '', 47, 1, 999, 1);

-- ----------------------------
-- Table structure for ez_cart
-- ----------------------------
DROP TABLE IF EXISTS `ez_cart`;
CREATE TABLE `ez_cart`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '购物车id',
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '买家id',
  `goods_sku_id` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '商品id',
  `goods_num` smallint(5) UNSIGNED NOT NULL DEFAULT 1 COMMENT '购买商品数量',
  `is_check` tinyint(3) UNSIGNED NOT NULL DEFAULT 1 COMMENT '选中状态 默认1选中 0未选中',
  `create_time` int(10) UNSIGNED NULL DEFAULT NULL,
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `member_id`(`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '购物车数据表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_coupon
-- ----------------------------
DROP TABLE IF EXISTS `ez_coupon`;
CREATE TABLE `ez_coupon`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '名称',
  `start_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '开始时间',
  `end_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '结束时间',
  `denomination` decimal(10, 2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '面额',
  `time_type` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '有效时间类型 默认0 XXX天内有效 1固定时间段',
  `effective_days` smallint(5) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'XXX天内有效',
  `use_start_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '使用开始时间',
  `use_end_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '使用结束时间',
  `number` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '发放数量',
  `limit_type` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '使用条件 默认0不限制 1满XXX使用',
  `limit_price` decimal(10, 2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '满XXX使用',
  `receive_limit_num` smallint(5) UNSIGNED NOT NULL DEFAULT 0 COMMENT '每人限领 0不限制',
  `level` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '级别 默认0全店 1商品级',
  `partake` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'json 优惠参与 折扣discount 满减fullcut 优惠券coupon 废弃',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '优惠券' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_coupon_goods
-- ----------------------------
DROP TABLE IF EXISTS `ez_coupon_goods`;
CREATE TABLE `ez_coupon_goods`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `discount_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '限时折扣id',
  `goods_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '商品主表id',
  `goods_sku_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '商品id',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '优惠券商品' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_cron
-- ----------------------------
DROP TABLE IF EXISTS `ez_cron`;
CREATE TABLE `ez_cron`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` tinyint(3) UNSIGNED NULL DEFAULT NULL COMMENT '任务类型 1商品上架 2发送邮件 3优惠套装过期 4推荐展位过期',
  `exeid` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '关联任务的ID[如商品ID,会员ID]',
  `exetime` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '执行时间',
  `code` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '邮件模板CODE',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '内容',
  INDEX `id`(`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '任务队列表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_discount
-- ----------------------------
DROP TABLE IF EXISTS `ez_discount`;
CREATE TABLE `ez_discount`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '名称',
  `start_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '开始时间',
  `end_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '结束时间',
  `limit_number` smallint(5) UNSIGNED NOT NULL DEFAULT 0 COMMENT '限购件数 默认0不限制',
  `partake` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'json 优惠参与 折扣discount 满减fullcut 优惠券coupon 废弃',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '限时折扣' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_discount_goods
-- ----------------------------
DROP TABLE IF EXISTS `ez_discount_goods`;
CREATE TABLE `ez_discount_goods`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `discount_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '限时折扣id',
  `goods_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '商品主表id',
  `goods_sku_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '商品id',
  `discounts` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'XXX折',
  `minus` decimal(10, 2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '立减XXX元',
  `price` decimal(10, 2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '打折后XXX元',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '限时折扣活动商品' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_dispatch
-- ----------------------------
DROP TABLE IF EXISTS `ez_dispatch`;
CREATE TABLE `ez_dispatch`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `sn_id` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '订单号',
  `time` int(10) NOT NULL COMMENT '配送日期',
  `driver_id` int(10) NOT NULL COMMENT '司机id',
  `driver_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '司机姓名',
  `number` int(10) NOT NULL COMMENT '订单数量',
  `cost` int(10) NOT NULL COMMENT '费用',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '配送表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_express
-- ----------------------------
DROP TABLE IF EXISTS `ez_express`;
CREATE TABLE `ez_express`  (
  `id` tinyint(1) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '物流id',
  `company_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '公司名称',
  `kuaidi100_code` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '快递100Code',
  `taobao_code` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '淘宝100Code',
  `is_commonly_use` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否为常用物流 1 是   0 否',
  `create_time` int(10) NOT NULL DEFAULT 0 COMMENT '添加时间',
  `update_time` int(10) NOT NULL DEFAULT 0 COMMENT '更新时间',
  `delete_time` int(11) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  `is_system` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '系统级 默认0自定义 1系统',
  UNIQUE INDEX `id`(`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 90 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '物流公司' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ez_express
-- ----------------------------
INSERT INTO `ez_express` VALUES (1, 'aae全球专递', 'aae', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (2, '安捷快递', 'anjie', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (3, '安信达快递', 'anxindakuaixi', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (4, '彪记快递', 'biaojikuaidi', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (5, 'bht', 'bht', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (6, '百福东方国际物流', 'baifudongfang', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (7, '中国东方（COE）', 'coe', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (8, '长宇物流', 'changyuwuliu', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (9, '大田物流', 'datianwuliu', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (10, '德邦物流', 'debangwuliu', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (11, 'dhl', 'dhl', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (12, 'dpex', 'dpex', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (13, 'd速快递', 'dsukuaidi', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (14, '递四方', 'disifang', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (15, 'ems快递', 'ems', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (16, 'fedex（国外）', 'fedex', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (17, '飞康达物流', 'feikangda', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (18, '凤凰快递', 'fenghuangkuaidi', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (19, '飞快达', 'feikuaida', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (20, '国通快递', 'guotongkuaidi', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (21, '港中能达物流', 'ganzhongnengda', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (22, '广东邮政物流', 'guangdongyouzhengwuliu', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (23, '共速达', 'gongsuda', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (24, '汇通快运', 'huitongkuaidi', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (25, '恒路物流', 'hengluwuliu', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (26, '华夏龙物流', 'huaxialongwuliu', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (27, '海红', 'haihongwangsong', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (28, '海外环球', 'haiwaihuanqiu', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (29, '佳怡物流', 'jiayiwuliu', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (30, '京广速递', 'jinguangsudikuaijian', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (31, '急先达', 'jixianda', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (32, '佳吉物流', 'jjwl', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (33, '加运美物流', 'jymwl', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (34, '金大物流', 'jindawuliu', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (35, '嘉里大通', 'jialidatong', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (36, '晋越快递', 'jykd', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (37, '快捷速递', 'kuaijiesudi', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (38, '联邦快递（国内）', 'lianb', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (39, '联昊通物流', 'lianhaowuliu', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (40, '龙邦物流', 'longbanwuliu', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (41, '立即送', 'lijisong', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (42, '乐捷递', 'lejiedi', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (43, '民航快递', 'minghangkuaidi', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (44, '美国快递', 'meiguokuaidi', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (45, '门对门', 'menduimen', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (46, 'OCS', 'ocs', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (47, '配思货运', 'peisihuoyunkuaidi', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (48, '全晨快递', 'quanchenkuaidi', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (49, '全峰快递', 'quanfengkuaidi', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (50, '全际通物流', 'quanjitong', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (51, '全日通快递', 'quanritongkuaidi', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (52, '全一快递', 'quanyikuaidi', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (53, '如风达', 'rufengda', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (54, '三态速递', 'santaisudi', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (55, '盛辉物流', 'shenghuiwuliu', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (56, '申通', 'shentong', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (57, '顺丰', 'shunfeng', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (58, '速尔物流', 'sue', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (59, '盛丰物流', 'shengfeng', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (60, '赛澳递', 'saiaodi', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (61, '天地华宇', 'tiandihuayu', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (62, '天天快递', 'tiantian', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (63, 'tnt', 'tnt', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (64, 'ups', 'ups', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (65, '万家物流', 'wanjiawuliu', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (66, '文捷航空速递', 'wenjiesudi', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (67, '伍圆', 'wuyuan', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (68, '万象物流', 'wxwl', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (69, '新邦物流', 'xinbangwuliu', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (70, '信丰物流', 'xinfengwuliu', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (71, '亚风速递', 'yafengsudi', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (72, '一邦速递', 'yibangwuliu', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (73, '优速物流', 'youshuwuliu', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (74, '邮政包裹挂号信', 'youzhengguonei', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (75, '邮政国际包裹挂号信', 'youzhengguoji', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (76, '远成物流', 'yuanchengwuliu', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (77, '圆通速递', 'yuantong', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (78, '源伟丰快递', 'yuanweifeng', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (79, '元智捷诚快递', 'yuanzhijiecheng', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (80, '韵达快运', 'yunda', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (81, '运通快递', 'yuntongkuaidi', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (82, '越丰物流', 'yuefengwuliu', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (83, '源安达', 'yad', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (84, '银捷速递', 'yinjiesudi', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (85, '宅急送', 'zhaijisong', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (86, '中铁快运', 'zhongtiekuaiyun', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (87, '中通速递', 'zhongtong', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (88, '中邮物流', 'zhongyouwuliu', '', 0, 1517557058, 1535100021, NULL, 1);
INSERT INTO `ez_express` VALUES (89, '忠信达', 'zhongxinda', '', 0, 1517557058, 1535100021, NULL, 1);

-- ----------------------------
-- Table structure for ez_extend
-- ----------------------------
DROP TABLE IF EXISTS `ez_extend`;
CREATE TABLE `ez_extend`  (
  `id` int(10) UNSIGNED NOT NULL DEFAULT 1 COMMENT 'ID',
  `express` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '快递公司ID的组合',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '时间',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '店铺信息扩展表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ez_extend
-- ----------------------------
INSERT INTO `ez_extend` VALUES (1, NULL, 0, NULL);

-- ----------------------------
-- Table structure for ez_freight
-- ----------------------------
DROP TABLE IF EXISTS `ez_freight`;
CREATE TABLE `ez_freight`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '模板id',
  `name` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '模板名称',
  `pay_type` tinyint(1) UNSIGNED NOT NULL COMMENT '计算方式：1 按件数 2 按重量',
  `areas` json NULL,
  `create_time` int(10) NOT NULL DEFAULT 0 COMMENT '添加时间',
  `update_time` int(10) NOT NULL DEFAULT 0 COMMENT '更新时间',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '运费模板' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_fullcut
-- ----------------------------
DROP TABLE IF EXISTS `ez_fullcut`;
CREATE TABLE `ez_fullcut`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '名称',
  `start_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '开始时间',
  `end_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '结束时间',
  `partake` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'json 优惠参与 折扣discount 满减fullcut 优惠券coupon 废弃',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  `hierarchy` json NULL COMMENT '层级 至多5个,每个(包涵fll_price满XXX元,minus减XXX元,discountsXXX折,type满减类型 默认0减XXX元  1打XXX折)',
  `level` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '级别 默认0全店 1商品级',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '满减优惠' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_fullcut_goods
-- ----------------------------
DROP TABLE IF EXISTS `ez_fullcut_goods`;
CREATE TABLE `ez_fullcut_goods`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `fullcut_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '限时折扣id',
  `goods_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '商品主表id',
  `goods_sku_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '商品id',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '满减优惠活动商品' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_goods
-- ----------------------------
DROP TABLE IF EXISTS `ez_goods`;
CREATE TABLE `ez_goods`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '商品公共表id',
  `title` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '商品名称',
  `images` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '商品图片 默认第一个为封面图片',
  `category_ids` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '商品分类',
  `base_sale_num` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '基础销量',
  `body` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '商品内容',
  `is_on_sale` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否需上架出售 0 否 1 是',
  `image_spec_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '使用图片的规格id',
  `image_spec_images` json NULL COMMENT '规格图片集合，废弃',
  `sku_list` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'sku商品集合，数组',
  `create_time` int(10) UNSIGNED NOT NULL COMMENT '创建时间',
  `price` decimal(10, 2) NOT NULL COMMENT '商品价格',
  `update_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '修改时间',
  `evaluation_good_star` tinyint(1) UNSIGNED NULL DEFAULT 5 COMMENT '好评星级',
  `evaluation_count` int(10) NULL DEFAULT 0 COMMENT '评价数',
  `stock` int(10) NULL DEFAULT 0 COMMENT 'goods表库存之和',
  `sale_num` int(10) NULL DEFAULT 0 COMMENT '销售量',
  `sale_time` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '开售时间',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  `spec_list` json NULL,
  `img` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '封面图',
  `pay_type` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '计算方式：1 按件数 2 按重量',
  `freight_fee` decimal(10, 2) UNSIGNED NULL DEFAULT 0.00 COMMENT '运费',
  `freight_id` int(10) NOT NULL DEFAULT 0 COMMENT '运费模板id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '商品公共内容表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_goods_attribute_index
-- ----------------------------
DROP TABLE IF EXISTS `ez_goods_attribute_index`;
CREATE TABLE `ez_goods_attribute_index`  (
  `goods_id` int(10) UNSIGNED NOT NULL COMMENT '商品id',
  `goods_common_id` int(10) UNSIGNED NOT NULL COMMENT '商品公共表id',
  `category_id` int(10) UNSIGNED NOT NULL COMMENT '商品分类id',
  `type_id` int(10) UNSIGNED NOT NULL COMMENT '类型id',
  `attribute_id` int(10) UNSIGNED NOT NULL COMMENT '属性id',
  `attribute_value_id` int(10) UNSIGNED NOT NULL COMMENT '属性值id',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`goods_id`, `category_id`, `attribute_value_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '商品与属性对应表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_goods_attributes
-- ----------------------------
DROP TABLE IF EXISTS `ez_goods_attributes`;
CREATE TABLE `ez_goods_attributes`  (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `goods_id` int(10) NOT NULL COMMENT '商品ID  可能作废',
  `attribute_id` int(10) NOT NULL COMMENT '属性ID',
  `attribute_value` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '属性值',
  `attribute_price` decimal(11, 2) NULL DEFAULT 0.00 COMMENT '价格',
  `attribute_stock` int(11) NULL DEFAULT 0 COMMENT '库存',
  `is_recomm` tinyint(4) NULL DEFAULT 0 COMMENT '是否推荐价格 0:否 1:是',
  `sku_id` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '商品id',
  `type` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '商品属性种类：1为规格，2为属性',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '状态(是否显示，显示:1,隐藏:0)',
  `sort` smallint(6) UNSIGNED NULL DEFAULT 999 COMMENT '排序',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `goodsId`(`goods_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '商品属性表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_goods_cart
-- ----------------------------
DROP TABLE IF EXISTS `ez_goods_cart`;
CREATE TABLE `ez_goods_cart`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) NOT NULL,
  `couponid` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `storeid` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `couponid`(`couponid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_goods_category
-- ----------------------------
DROP TABLE IF EXISTS `ez_goods_category`;
CREATE TABLE `ez_goods_category`  (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '分类名称',
  `pid` mediumint(8) UNSIGNED NOT NULL DEFAULT 0 COMMENT '父级id，如果不填为一级',
  `icon` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '商品分类图标，图片地址',
  `sort` smallint(6) UNSIGNED NOT NULL DEFAULT 999 COMMENT '排序',
  `create_time` int(10) NOT NULL DEFAULT 0 COMMENT '添加时间',
  `update_time` int(10) NOT NULL DEFAULT 0 COMMENT '更新时间',
  `keywords` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `description` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `grade` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '价格分级',
  `img` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '分类前面的小图标',
  `type_id` int(10) UNSIGNED NULL DEFAULT 0 COMMENT '关联类型id',
  `banner` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '横幅',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '商品分类' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_goods_collect
-- ----------------------------
DROP TABLE IF EXISTS `ez_goods_collect`;
CREATE TABLE `ez_goods_collect`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `user_id` int(10) NULL DEFAULT NULL COMMENT '使用UID',
  `goods_sku_id` int(10) NULL DEFAULT NULL COMMENT '商品skuID',
  `goods_id` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '商品id',
  `create_time` int(10) NULL DEFAULT NULL COMMENT '收藏时间',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '收藏(关注)' ROW_FORMAT = Fixed;

-- ----------------------------
-- Table structure for ez_goods_evaluate
-- ----------------------------
DROP TABLE IF EXISTS `ez_goods_evaluate`;
CREATE TABLE `ez_goods_evaluate`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '评价ID',
  `order_id` int(11) NOT NULL COMMENT '订单表自增ID',
  `order_no` bigint(20) UNSIGNED NOT NULL COMMENT '订单编号',
  `order_goods_id` int(11) NOT NULL COMMENT '订单商品表编号',
  `goods_id` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '商品主表id',
  `goods_sku_id` int(11) NOT NULL COMMENT '商品表编号',
  `goods_title` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '商品名称',
  `goods_price` decimal(10, 2) NULL DEFAULT NULL COMMENT '商品价格',
  `goods_img` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '商品图片',
  `score` tinyint(1) NOT NULL COMMENT '1-5分',
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '信誉评价内容，有可能会存表情',
  `is_anonymous` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0表示不是 1表示是匿名评价',
  `create_time` int(11) NOT NULL COMMENT '评价时间',
  `user_id` int(11) NOT NULL COMMENT '评价人编号',
  `state` tinyint(1) NOT NULL DEFAULT 0 COMMENT '评价信息的状态 0为正常 1为禁止显示',
  `remark` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '管理员对评价的处理备注',
  `explain` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '解释内容',
  `images` json NULL COMMENT '晒单图片json',
  `additional_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '追加评论',
  `additional_time` int(10) NULL DEFAULT 0 COMMENT '追加时间',
  `additional_images` json NULL COMMENT '追加评价图片',
  `reply_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '回复评价的内容',
  `reply_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '回复时间',
  `reply_content2` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '回复追加的内容',
  `reply_time2` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '回复时间',
  `display` tinyint(1) NULL DEFAULT 1 COMMENT '回复状态 1是显示 0是隐藏',
  `top` tinyint(1) NULL DEFAULT 0 COMMENT '置顶 0：不是；1：是；',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '信誉评价表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_goods_image
-- ----------------------------
DROP TABLE IF EXISTS `ez_goods_image`;
CREATE TABLE `ez_goods_image`  (
  `goods_id` int(10) UNSIGNED NOT NULL COMMENT '商品公共内容id',
  `color_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '颜色规格值id',
  `img` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '商品图片',
  `sort` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序',
  `is_default` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '默认主题，1是，0否',
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '商品图片' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_goods_sku
-- ----------------------------
DROP TABLE IF EXISTS `ez_goods_sku`;
CREATE TABLE `ez_goods_sku`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '商品id(SKU)',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  `goods_id` int(10) UNSIGNED NOT NULL COMMENT '商品公共表id',
  `spec` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '规格json信息',
  `price` decimal(10, 2) NULL DEFAULT NULL COMMENT '商品价格',
  `stock` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '商品库存',
  `code` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '商品编码',
  `img` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '商品主图',
  `weight` double(10, 2) UNSIGNED NULL DEFAULT 0.00 COMMENT '商品重量',
  `title` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '商品名称（+规格名称）',
  `sale_num` int(10) UNSIGNED NULL DEFAULT 0 COMMENT '销售数量',
  `create_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '商品添加时间',
  `update_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '商品编辑时间',
  `spec_value_sign` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '规格值标识',
  `spec_sign` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '规格标识',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '商品表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_goods_spec
-- ----------------------------
DROP TABLE IF EXISTS `ez_goods_spec`;
CREATE TABLE `ez_goods_spec`  (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '规格id',
  `name` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '规格名称',
  `sort` int(8) UNSIGNED NOT NULL DEFAULT 999 COMMENT '规格排序',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '商品规格' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_goods_spec_value
-- ----------------------------
DROP TABLE IF EXISTS `ez_goods_spec_value`;
CREATE TABLE `ez_goods_spec_value`  (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '规格值id',
  `spec_id` int(10) NULL DEFAULT NULL COMMENT '规格id',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '规格值名称',
  `sort` mediumint(5) UNSIGNED NOT NULL DEFAULT 100 COMMENT '排序',
  `color` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '色彩值',
  `img` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '图片',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '商品规格值表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_image
-- ----------------------------
DROP TABLE IF EXISTS `ez_image`;
CREATE TABLE `ez_image`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `size` float(10, 0) NULL DEFAULT NULL,
  `type` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `create_time` int(10) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_info_category
-- ----------------------------
DROP TABLE IF EXISTS `ez_info_category`;
CREATE TABLE `ez_info_category`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '名字 ',
  `pid` smallint(6) UNSIGNED NOT NULL COMMENT '父级id',
  `level` smallint(6) UNSIGNED NOT NULL DEFAULT 0 COMMENT '层级默认为0',
  `sort` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序默认为0',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT 1 COMMENT '状态 1为开启0为关闭',
  `desc` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '描述',
  `name` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '唯一标识',
  `template_index` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '频道页模板',
  `template_list` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '列表页模板',
  `template_detail` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '详情页模板',
  `template_type` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0列表1封面',
  `img` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '封面图',
  `text` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '详情',
  `flags` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '属性',
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '跳转链接',
  `images` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '多图上传',
  `extend` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '拓展',
  `keywords` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '关键词',
  `img_status` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '1显示0不显示',
  `img2` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '分类表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_invoice
-- ----------------------------
DROP TABLE IF EXISTS `ez_invoice`;
CREATE TABLE `ez_invoice`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '索引id',
  `user_id` int(10) UNSIGNED NOT NULL COMMENT '会员ID',
  `type` enum('1','2') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '1普通发票2增值税发票',
  `title` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '发票抬头[普通发票]',
  `content` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '发票内容[普通发票]',
  `company_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '单位名称',
  `company_code` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '纳税人识别号',
  `company_register_address` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '注册地址',
  `company_register_phone` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '注册电话',
  `company_register_brank_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '开户银行',
  `company_register_brank_account` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '银行帐户',
  `receive_name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '收票人姓名',
  `receive_phone` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '收票人手机号',
  `receive_province` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '收票人省份',
  `receive_address` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '送票地址',
  `consumption_type` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '发票消费类型',
  `is_default` tinyint(1) UNSIGNED NULL DEFAULT NULL COMMENT '默认发票',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '买家发票信息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_material
-- ----------------------------
DROP TABLE IF EXISTS `ez_material`;
CREATE TABLE `ez_material`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `media` json NULL COMMENT '媒体',
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT 'news、voice、video',
  `create_time` int(10) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_message
-- ----------------------------
DROP TABLE IF EXISTS `ez_message`;
CREATE TABLE `ez_message`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '短消息索引id',
  `title` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '短消息标题',
  `body` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '消息内容,数据格式为json',
  `create_time` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '短消息发送时间',
  `send_state` tinyint(1) NULL DEFAULT 0 COMMENT '发送状态 0未发送 1已发送',
  `relation_model` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '关联模块，并非表名',
  `relation_model_id` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '关联表id',
  `is_group` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '是否为群发0否1是',
  `type_id` smallint(6) UNSIGNED NULL DEFAULT NULL COMMENT '消息类型id',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '推送消息' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_message_state
-- ----------------------------
DROP TABLE IF EXISTS `ez_message_state`;
CREATE TABLE `ez_message_state`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `to_user_id` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '接收者id',
  `message_id` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '信息id',
  `read_state` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '0 未读 1已读',
  `del_state` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '0未删 1已删',
  `read_time` int(10) UNSIGNED NULL DEFAULT 0 COMMENT '读取时间',
  `del_time` int(10) UNSIGNED NULL DEFAULT 0 COMMENT '删除时间',
  `app_push_state` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT 'app是否推送0未1是',
  `create_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '创建时间',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '消息阅读记录(读删表)' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_message_type
-- ----------------------------
DROP TABLE IF EXISTS `ez_message_type`;
CREATE TABLE `ez_message_type`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '通知类型标题',
  `remark` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '通知类型的备注',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '状态0关闭，1开启',
  `model` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '关联模型',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ez_message_type
-- ----------------------------
INSERT INTO `ez_message_type` VALUES (1, '系统消息', '系统预留', 1, '', NULL);
INSERT INTO `ez_message_type` VALUES (2, '文章', '文章（广告）的通知', 1, 'info_detail', NULL);
INSERT INTO `ez_message_type` VALUES (3, '发货', '订单发货消息通知\n', 1, 'order_send', NULL);
INSERT INTO `ez_message_type` VALUES (4, '优惠券', '优惠券发出的消息通知', 1, 'voucher_send', NULL);
INSERT INTO `ez_message_type` VALUES (5, '退款', '退款消息通知\n', 1, 'order_refund', NULL);

-- ----------------------------
-- Table structure for ez_offpay_area
-- ----------------------------
DROP TABLE IF EXISTS `ez_offpay_area`;
CREATE TABLE `ez_offpay_area`  (
  `id` int(8) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `area_id` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '县ID组合',
  INDEX `id`(`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '货到付款支持地区表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ez_offpay_area
-- ----------------------------
INSERT INTO `ez_offpay_area` VALUES (1, NULL);

-- ----------------------------
-- Table structure for ez_order
-- ----------------------------
DROP TABLE IF EXISTS `ez_order`;
CREATE TABLE `ez_order`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单索引id',
  `sn` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '订单编号',
  `pay_sn` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '支付单号',
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '买家id',
  `user_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '买家姓名',
  `user_phone` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '买家手机号码',
  `user_email` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '买家电子邮箱',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '订单生成时间',
  `payment_code` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '支付方式名称代码',
  `pay_name` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '支付方式',
  `payment_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '支付成功的(付款的)时间',
  `finnshed_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '订单完成时间',
  `goods_amount` decimal(10, 2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '商品总价格',
  `goods_num` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '商品个数',
  `amount` decimal(10, 2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '订单总价格',
  `pd_amount` decimal(10, 2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '预存款支付金额',
  `freight_fee` decimal(10, 2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '实际支付的运费',
  `freight_unified_fee` decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '运费统一运费',
  `freight_template_fee` decimal(10, 2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '运费模板运费',
  `state` int(5) NOT NULL DEFAULT 10 COMMENT '订单状态：0(已取消)10(默认):未付款;20:已付款;30:已发货;40:已收货;',
  `refund_amount` decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '退款金额',
  `refund_state` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '退款状态:0是无退款,1是部分退款,2是全部退款',
  `lock_state` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '锁定状态:0是正常,大于0是锁定,默认是0',
  `delay_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '延迟时间,默认为0',
  `points` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '积分',
  `evaluate_state` tinyint(1) NOT NULL DEFAULT 0 COMMENT '评价状态 0未评价，1已评价',
  `is_print` tinyint(1) NULL DEFAULT 0 COMMENT '是否打印 1打印 0未打印',
  `trade_no` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '支付宝交易号OR微信交易号',
  `wechat_openid` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '用户微信openid',
  `from` enum('1','2') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '1' COMMENT '1WEB2mobile',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  `all_agree_refound` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '默认为0，1是订单的全部商品都退了',
  `payable_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '订单可支付时间 下单时间+24小时 时间戳',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '订单表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_order_extend
-- ----------------------------
DROP TABLE IF EXISTS `ez_order_extend`;
CREATE TABLE `ez_order_extend`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单索引id',
  `tracking_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '配送时间',
  `tracking_no` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '物流单号',
  `shipper_id` tinyint(1) NOT NULL DEFAULT 0 COMMENT '商家物流地址id',
  `express_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '物流公司id，默认为0 代表不需要物流',
  `message` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '买家留言',
  `voucher_price` int(11) NULL DEFAULT NULL COMMENT '代金券面额',
  `voucher_id` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '代金券id',
  `voucher_code` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '代金券编码',
  `remark` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '发货备注',
  `reciver_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '收货人姓名',
  `receiver_phone` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '收货人电话',
  `reciver_info` json NOT NULL COMMENT '收货人其它信息 json',
  `reciver_province_id` mediumint(8) UNSIGNED NOT NULL DEFAULT 0 COMMENT '收货人省级ID',
  `reciver_city_id` int(10) NULL DEFAULT NULL,
  `reciver_area_id` int(10) NULL DEFAULT NULL,
  `invoice_info` json NOT NULL COMMENT '发票信息 json',
  `promotion_info` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '促销信息备注',
  `evaluate_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '评价时间',
  `service_remarks` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '后台客服对此订单做出的备注',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  `deliver_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '配送人名字',
  `deliver_phone` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '配送人电话',
  `deliver_address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '配送地址',
  `freight_rule` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '运费规则1按商品累加运费2组合运费',
  `need_express` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '是否需要物流1需要0不需要',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '订单信息扩展表|明细' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_order_goods
-- ----------------------------
DROP TABLE IF EXISTS `ez_order_goods`;
CREATE TABLE `ez_order_goods`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单商品表索引id',
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '买家ID',
  `order_id` int(11) NOT NULL DEFAULT 0 COMMENT '订单id',
  `goods_id` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '商品主表id',
  `goods_sku_id` int(11) NOT NULL DEFAULT 0 COMMENT '商品id',
  `goods_title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '商品名称',
  `goods_price` decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '商品价格',
  `goods_pay_price` decimal(10, 2) NULL DEFAULT NULL COMMENT '商品实际支付费用',
  `goods_num` smallint(5) UNSIGNED NOT NULL DEFAULT 1 COMMENT '商品数量',
  `goods_img` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '商品图片',
  `goods_spec` json NULL COMMENT '商品规格',
  `goods_type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1默认2团购商品3限时折扣商品4组合套装5赠品',
  `goods_freight_way` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '商品运费方式',
  `goods_freight_fee` decimal(10, 2) UNSIGNED NULL DEFAULT NULL COMMENT '商品的运费',
  `evaluate_state` tinyint(1) NOT NULL DEFAULT 0 COMMENT '评价状态 0未评价，1已评价，2已追评',
  `evaluate_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '评价时间',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `coupon_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '线上卡券 大于0线上卡券 微信卡券表表ID 一个规格的商品对应一张微信卡券',
  `coupon_card_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '线上卡券 微信卡券表微信卡券ID',
  `lock_state` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '锁定（1退款中）',
  `refund_handle_state` tinyint(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '退款平台处理状态 默认0处理中(未处理) 10拒绝(驳回) 20同意 30成功(已完成) 50取消(用户主动撤销) 51取消(用户主动收货)',
  `refund_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '退款ID',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '订单商品表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_order_log
-- ----------------------------
DROP TABLE IF EXISTS `ez_order_log`;
CREATE TABLE `ez_order_log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `order_id` int(11) NOT NULL COMMENT '订单id',
  `msg` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '文字描述',
  `create_time` int(10) UNSIGNED NOT NULL COMMENT '处理时间',
  `role` char(5) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '操作角色',
  `user` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '操作人',
  `order_state` tinyint(2) UNSIGNED NULL DEFAULT NULL COMMENT '订单状态：0(已取消)10:未付款;20:已付款;30:已发货;40:已收货;',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '订单处理历史表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_order_pay
-- ----------------------------
DROP TABLE IF EXISTS `ez_order_pay`;
CREATE TABLE `ez_order_pay`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pay_sn` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '支付单号',
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '买家ID',
  `pay_state` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '0默认未支付1已支付(只有第三方支付接口通知到时才会更改此状态)',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '订单支付表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_order_refund
-- ----------------------------
DROP TABLE IF EXISTS `ez_order_refund`;
CREATE TABLE `ez_order_refund`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '记录ID',
  `order_id` int(10) UNSIGNED NOT NULL COMMENT '订单ID',
  `order_sn` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '订单编号',
  `order_state` int(5) UNSIGNED NULL DEFAULT 20 COMMENT '订单状态:20:已付款;30:已发货;40:已收货;',
  `order_goods_id` int(10) UNSIGNED NULL DEFAULT 0 COMMENT '子订单ID',
  `refund_sn` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '申请编号',
  `user_id` int(10) UNSIGNED NOT NULL COMMENT '买家ID',
  `user_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '买家会员名',
  `goods_id` int(11) NULL DEFAULT NULL COMMENT '商品id',
  `goods_sku_id` int(10) UNSIGNED NOT NULL COMMENT '商品ID,全部退款是0',
  `goods_title` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '商品名称',
  `goods_spec` json NULL COMMENT '商品规格',
  `goods_img` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '商品图片',
  `goods_pay_price` decimal(10, 2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '商品实际成交价',
  `goods_num` smallint(5) UNSIGNED NULL DEFAULT 1 COMMENT '商品数量',
  `goods_freight_fee` decimal(10, 2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '运费金额',
  `refund_type` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '申请类型:1为仅退款,2为退货退款,默认为1',
  `refund_amount` decimal(10, 2) NULL DEFAULT 0.00 COMMENT '退款金额 小于等于子订单的金额',
  `order_amount` decimal(10, 2) NULL DEFAULT 0.00 COMMENT '总订单的金额',
  `order_lock` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '订单锁定类型:1为不用锁定,2为需要锁定,默认为1',
  `create_time` int(10) UNSIGNED NOT NULL COMMENT '添加时间',
  `user_reason` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '退款原因',
  `user_explain` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '退款说明',
  `tracking_no` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '退款退货物 买家发货流单号',
  `tracking_phone` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '退款退货物 买家发货手机号',
  `tracking_company` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '退款退货 买家发货公司',
  `tracking_explain` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '退款退货物 买家发货说明',
  `tracking_images` json NULL COMMENT '退款退货物 买家发货凭证 最多6张',
  `tracking_time` int(10) UNSIGNED NULL DEFAULT 0 COMMENT '退款退货物 买家发货时间,默认为0',
  `receive` tinyint(2) UNSIGNED NOT NULL DEFAULT 1 COMMENT '卖家是否收到买家退货退款货物 1未收到货 2已收到货',
  `receive_time` int(10) UNSIGNED NULL DEFAULT 0 COMMENT '卖家收货时间,默认为0',
  `receive_message` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '卖家收货备注',
  `payment_code` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '支付方式',
  `trade_no` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '支付宝交易号OR微信交易号',
  `handle_state` tinyint(2) NULL DEFAULT 0 COMMENT '卖家处理状态 默认0处理中(未处理) 10拒绝(驳回) 20同意 30成功(已完成) 50取消(用户主动撤销) 51取消(用户主动收货)',
  `handle_message` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '卖家处理信息',
  `handle_time` int(11) NULL DEFAULT 0 COMMENT '卖家处理时间',
  `batch_no` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '支付宝退款批次号 退款回调使用',
  `success_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '退款回调完成时间',
  `user_receive` tinyint(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '用户选择是否收到货物 默认0未发货(Order state=20) 1未收到货 2已收到货 卖家未发货(已付款)时无需传此参数',
  `user_images` json NULL COMMENT '照片凭证 json',
  `is_close` tinyint(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '默认0 1已关闭(退款关闭)',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  `handle_expiry_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '过期时间之管理员处理',
  `send_expiry_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '过期时间之用户发货',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '退款\\退款退货表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_order_refund_log
-- ----------------------------
DROP TABLE IF EXISTS `ez_order_refund_log`;
CREATE TABLE `ez_order_refund_log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `order_refund_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '订单id',
  `user_id` int(10) NULL DEFAULT 0 COMMENT '操作人',
  `role` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '操作角色',
  `order_refund_state` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '平台处理状态 默认0处理中(未处理) 10拒绝(驳回) 20同意 30成功(已完成) 50取消(用户主动撤销) 51取消(用户主动收货)',
  `msg` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '文字描述',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '操作时间',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '退款\\退货处理历史表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_order_refund_reason
-- ----------------------------
DROP TABLE IF EXISTS `ez_order_refund_reason`;
CREATE TABLE `ez_order_refund_reason`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '标题',
  `type` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '1未收到货 2已收到货',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '退款\\退款退货原因表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ez_order_refund_reason
-- ----------------------------
INSERT INTO `ez_order_refund_reason` VALUES (1, '多拍/拍错/不想要', 1, NULL);
INSERT INTO `ez_order_refund_reason` VALUES (2, '快递一直未到', 1, NULL);
INSERT INTO `ez_order_refund_reason` VALUES (3, '未按约定时间发货', 1, NULL);
INSERT INTO `ez_order_refund_reason` VALUES (4, '快递无跟踪记录', 1, NULL);
INSERT INTO `ez_order_refund_reason` VALUES (5, '空包裹/少货', 1, NULL);
INSERT INTO `ez_order_refund_reason` VALUES (6, '其他', 1, NULL);
INSERT INTO `ez_order_refund_reason` VALUES (7, '7天无理由退换货', 2, NULL);
INSERT INTO `ez_order_refund_reason` VALUES (8, '商品成分描述不符', 2, NULL);
INSERT INTO `ez_order_refund_reason` VALUES (9, '生产日期/保质期与卖家承诺不符', 2, NULL);
INSERT INTO `ez_order_refund_reason` VALUES (10, '图片/产地/批号/规格等描述不符', 2, NULL);
INSERT INTO `ez_order_refund_reason` VALUES (11, '卖家发错货', 2, NULL);
INSERT INTO `ez_order_refund_reason` VALUES (12, '假冒品牌', 2, NULL);
INSERT INTO `ez_order_refund_reason` VALUES (13, '收到商品少件或破损', 2, NULL);
INSERT INTO `ez_order_refund_reason` VALUES (14, '其他', 2, NULL);

-- ----------------------------
-- Table structure for ez_order_statis
-- ----------------------------
DROP TABLE IF EXISTS `ez_order_statis`;
CREATE TABLE `ez_order_statis`  (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT '统计编号(年月日)',
  `start_date` date NOT NULL COMMENT '开始日期',
  `end_date` date NOT NULL COMMENT '结束日期',
  `order_totals` decimal(10, 2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '订单金额',
  `order_shipping_totals` decimal(10, 2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '运费',
  `order_return_totals` decimal(10, 2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '退单金额',
  `order_commis_totals` decimal(10, 2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '佣金金额',
  `order_commis_return_totals` decimal(10, 2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '退还佣金',
  `cost_totals` decimal(10, 2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '店铺促销活动费用',
  `result_totals` decimal(10, 2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '本期应结',
  `create_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '创建记录日期',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id`(`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '销量统计表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_page
-- ----------------------------
DROP TABLE IF EXISTS `ez_page`;
CREATE TABLE `ez_page`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '模板名称',
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '页面描述',
  `body` json NOT NULL COMMENT '模板json内容',
  `is_portal` tinyint(1) NULL DEFAULT 0 COMMENT '是否为主页',
  `is_system` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '系统级 默认0自定义 1系统',
  `background_color` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '背景颜色',
  `type` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '模板类型',
  `create_time` int(10) NOT NULL COMMENT '创建时间',
  `update_time` int(10) NOT NULL COMMENT '更新时间',
  `module` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '模块名字',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  `clone_from_id` int(10) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '模板页面' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_pay_log
-- ----------------------------
DROP TABLE IF EXISTS `ez_pay_log`;
CREATE TABLE `ez_pay_log`  (
  `log_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '支付记录自增id',
  `order_id` mediumint(8) UNSIGNED NOT NULL DEFAULT 0 COMMENT '对应的交交易记录的id,取值表order_info',
  `order_amount` decimal(10, 2) UNSIGNED NOT NULL COMMENT '支付金额',
  `order_type` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '支付类型,0订单支付,1会员预付款支付',
  `is_paid` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否已支付,0否;1是',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '系统支付记录' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_payment
-- ----------------------------
DROP TABLE IF EXISTS `ez_payment`;
CREATE TABLE `ez_payment`  (
  `type` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '支付代码名称',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '支付名称',
  `config` json NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '接口状态0禁用1启用',
  PRIMARY KEY (`type`) USING BTREE,
  UNIQUE INDEX `type`(`type`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '支付方式表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ez_payment
-- ----------------------------
INSERT INTO `ez_payment` VALUES ('wechat', '微信支付', NULL, 1);

-- ----------------------------
-- Table structure for ez_pd_cash
-- ----------------------------
DROP TABLE IF EXISTS `ez_pd_cash`;
CREATE TABLE `ez_pd_cash`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增编号',
  `sn` bigint(20) NOT NULL COMMENT '记录唯一标示',
  `user_id` int(11) NOT NULL COMMENT '会员编号',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '会员名称',
  `amount` decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '金额',
  `bank_name` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '收款银行',
  `bank_no` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '收款账号',
  `bank_user` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '开户人姓名',
  `create_time` int(11) NOT NULL COMMENT '添加时间',
  `payment_time` int(11) NULL DEFAULT NULL COMMENT '付款时间',
  `payment_state` tinyint(1) NOT NULL DEFAULT 0 COMMENT '提现支付状态 0默认1支付完成',
  `payment_admin` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '支付管理员',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '预存款提现记录表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_pd_log
-- ----------------------------
DROP TABLE IF EXISTS `ez_pd_log`;
CREATE TABLE `ez_pd_log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增编号',
  `pd_id` int(10) UNSIGNED NOT NULL COMMENT 'pd_cash或pd_recharge表或order表(余额付款)id 退款表ID',
  `pd_sn` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT 'pd_cash或pd_recharge表交易号(sn) 或 order表(余额付款 支付单号sn) 退款表refund_sn',
  `user_id` int(11) NOT NULL COMMENT '会员编号',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '会员名称',
  `admin_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '管理员名称',
  `type` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'order_pay下单支付预存款,order_freeze下单冻结预存款,order_cancel取消订单解冻预存款,order_comb_pay下单支付被冻结的预存款,recharge充值,cash_apply申请提现冻结预存款,cash_pay提现成功,cash_del取消提现申请，解冻预存款,refund退款',
  `available_amount` decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '可用金额变更0表示未变更',
  `freeze_amount` decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '冻结金额变更0表示未变更',
  `create_time` int(11) NOT NULL COMMENT '添加时间',
  `remark` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '描述',
  `state` tinyint(1) NULL DEFAULT 0 COMMENT '0未成功 1已成功',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '预存款变更日志表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_pd_recharge
-- ----------------------------
DROP TABLE IF EXISTS `ez_pd_recharge`;
CREATE TABLE `ez_pd_recharge`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增编号',
  `sn` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '记录唯一标示',
  `user_id` int(11) NOT NULL COMMENT '会员编号',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '会员名称',
  `amount` decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '充值金额',
  `payment_code` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '支付方式 alipay wxpayweb wxpayapp...',
  `payment_name` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '支付方式 支付宝 微信支付',
  `trade_sn` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '第三方支付接口交易号',
  `payment_state` tinyint(1) NOT NULL DEFAULT 0 COMMENT '支付状态 0未支付1支付',
  `payment_time` int(11) NOT NULL DEFAULT 0 COMMENT '支付时间',
  `admin_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '管理员名',
  `create_time` int(11) NOT NULL COMMENT '添加时间',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '预存款充值表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_plugin
-- ----------------------------
DROP TABLE IF EXISTS `ez_plugin`;
CREATE TABLE `ez_plugin`  (
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `install_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '安装时间',
  `db_version` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '数据版本号'
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_sale_num
-- ----------------------------
DROP TABLE IF EXISTS `ez_sale_num`;
CREATE TABLE `ez_sale_num`  (
  `date` int(8) UNSIGNED NOT NULL COMMENT '销售日期 格式：20151019',
  `salenum` int(11) UNSIGNED NOT NULL COMMENT '销量',
  `goods_id` int(11) UNSIGNED NOT NULL COMMENT '商品ID'
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '销量统计表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_send_area
-- ----------------------------
DROP TABLE IF EXISTS `ez_send_area`;
CREATE TABLE `ez_send_area`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '配送区域模板名称',
  `area_ids` json NULL COMMENT '市id集合 json',
  `create_time` int(10) NOT NULL COMMENT '添加时间',
  `update_time` int(10) NOT NULL COMMENT '更新时间',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  `is_system` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '系统级 默认0自定义 1系统',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '可配送区域' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_shipper
-- ----------------------------
DROP TABLE IF EXISTS `ez_shipper`;
CREATE TABLE `ez_shipper`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '物流地址id',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '发货人',
  `province_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '省ID',
  `city_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '市ID',
  `area_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '区县ID',
  `street_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '街道ID',
  `combine_detail` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '地区信息',
  `address` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '详细地址',
  `contact_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '联系电话',
  `is_default` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否为默认地址，默认 0 不是、1 是',
  `create_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT 0 COMMENT '更新时间',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  `refund_default` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '默认退货地址 默认0否 1是',
  `is_system` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '系统级 默认0自定义 1系统',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_shop
-- ----------------------------
DROP TABLE IF EXISTS `ez_shop`;
CREATE TABLE `ez_shop`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '配置ID',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '店铺名字',
  `logo` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '店铺标志图片',
  `contact_number` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '联系电话',
  `description` tinytext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '店铺描述',
  `color_scheme` int(10) UNSIGNED NULL DEFAULT 0 COMMENT '配色方案',
  `portal_template_id` int(10) UNSIGNED NULL DEFAULT 10001 COMMENT '店铺首页模板id',
  `wechat_platform_qr` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '微信公众平台二维码',
  `goods_category_style` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '店铺分类页风格',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  `salt` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '盐',
  `host` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `order_auto_close_expires` int(10) UNSIGNED NOT NULL DEFAULT 604800 COMMENT '待付款订单N秒后自动关闭订单',
  `order_auto_confirm_expires` int(10) UNSIGNED NOT NULL DEFAULT 604800 COMMENT '已发货订单后自动确认收货\n已发货订单后自动确认收货',
  `order_auto_close_refound_expires` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '已收货订单后关闭退款／退货功能，0代表确认收货后无法维权',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '店铺表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ez_shop
-- ----------------------------
INSERT INTO `ez_shop` VALUES (1, 'FaShop', NULL, NULL, NULL, 3, 10002, NULL, 0, NULL, NULL, NULL, 259380, 172800, 259200);

-- ----------------------------
-- Table structure for ez_sms
-- ----------------------------
DROP TABLE IF EXISTS `ez_sms`;
CREATE TABLE `ez_sms`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `phone` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '手机号',
  `create_time` int(10) NOT NULL COMMENT '时间',
  `status` tinyint(2) NOT NULL COMMENT '状态0未验证，1已验证',
  `model` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '标识',
  `text` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '内容',
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '用户id',
  `user_phone` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户电话',
  `code` char(6) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '验证码',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '短信记录' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_sms_provider
-- ----------------------------
DROP TABLE IF EXISTS `ez_sms_provider`;
CREATE TABLE `ez_sms_provider`  (
  `type` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '支付代码名称',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '支付名称',
  `config` json NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '接口状态0禁用1启用',
  PRIMARY KEY (`type`) USING BTREE,
  UNIQUE INDEX `type`(`type`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '支付方式表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ez_sms_provider
-- ----------------------------
INSERT INTO `ez_sms_provider` VALUES ('aliyun', '阿里云', '{\"access_key_id\": \"\", \"access_key_secret\": \"\"}', 1);

-- ----------------------------
-- Table structure for ez_sms_scene
-- ----------------------------
DROP TABLE IF EXISTS `ez_sms_scene`;
CREATE TABLE `ez_sms_scene`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '名称',
  `sign` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '唯一标识',
  `signature` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '签名',
  `provider_template_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '服务商提供的模板id',
  `provider_type` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '提供商标识',
  `body` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '内容',
  `is_system` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '系统默认',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `sign`(`sign`) USING BTREE,
  UNIQUE INDEX `name`(`name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '支付方式表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ez_sms_scene
-- ----------------------------
INSERT INTO `ez_sms_scene` VALUES (1, '短信验证码', 'verify_code', NULL, NULL, 'aliyun', '您的验证码为：$(code)，该验证码 5 分钟内有效，请勿泄漏给其他人', 1);

-- ----------------------------
-- Table structure for ez_system
-- ----------------------------
DROP TABLE IF EXISTS `ez_system`;
CREATE TABLE `ez_system`  (
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'fashop的当前版本',
  `value` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`name`) USING BTREE,
  UNIQUE INDEX `name`(`name`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ez_system
-- ----------------------------
INSERT INTO `ez_system` VALUES ('fashop_version', '1.0.0');
INSERT INTO `ez_system` VALUES ('app_key', NULL);
INSERT INTO `ez_system` VALUES ('app_secret', NULL);

-- ----------------------------
-- Table structure for ez_transport
-- ----------------------------
DROP TABLE IF EXISTS `ez_transport`;
CREATE TABLE `ez_transport`  (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '运费模板ID',
  `title` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '运费模板名称',
  `send_tpl_id` mediumint(8) UNSIGNED NULL DEFAULT NULL COMMENT '发货地区模板ID',
  `update_time` int(10) UNSIGNED NULL DEFAULT 0 COMMENT '最后更新时间',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '运费模板' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_transport_extend
-- ----------------------------
DROP TABLE IF EXISTS `ez_transport_extend`;
CREATE TABLE `ez_transport_extend`  (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '运费模板扩展ID',
  `area_id` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '市级地区ID组成的串，以，隔开，两端也有，',
  `top_area_id` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '省级地区ID组成的串，以，隔开，两端也有，',
  `area_name` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '地区name组成的串，以，隔开',
  `snum` mediumint(8) UNSIGNED NULL DEFAULT 1 COMMENT '首件数量',
  `sprice` decimal(10, 2) NULL DEFAULT 0.00 COMMENT '首件运费',
  `xnum` mediumint(8) UNSIGNED NULL DEFAULT 1 COMMENT '续件数量',
  `xprice` decimal(10, 2) NULL DEFAULT 0.00 COMMENT '续件运费',
  `is_default` enum('1','2') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '2' COMMENT '是否默认运费1是2否',
  `transport_id` mediumint(8) UNSIGNED NOT NULL COMMENT '运费模板ID',
  `transport_title` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '运费模板',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '运费模板扩展表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_upload
-- ----------------------------
DROP TABLE IF EXISTS `ez_upload`;
CREATE TABLE `ez_upload`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '文件名',
  `file_size` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '文件大小',
  `file_type` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '文件类型',
  `file_path` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '文件存放路径',
  `user_id` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '用户id',
  `create_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '创建时间',
  `type` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '标识',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_user
-- ----------------------------
DROP TABLE IF EXISTS `ez_user`;
CREATE TABLE `ez_user`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户名',
  `password` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '密码',
  `phone` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '手机号',
  `email` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '邮箱',
  `state` tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '默认1 0禁止 1正常',
  `salt` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '盐',
  `is_discard` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '被丢弃 默认0否 1是[用于绑定后的失效的占位行]',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_user_alias
-- ----------------------------
DROP TABLE IF EXISTS `ez_user_alias`;
CREATE TABLE `ez_user_alias`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '主账号ID[user_id]',
  `alias_user_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '第三方帐号ID[user_id 占位行的id]',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '用户ID别名表[废弃 解绑时数据混乱]' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_user_assets
-- ----------------------------
DROP TABLE IF EXISTS `ez_user_assets`;
CREATE TABLE `ez_user_assets`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '用户ID',
  `points` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '积分',
  `balance` decimal(10, 2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '余额',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '用户资产表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_user_level
-- ----------------------------
DROP TABLE IF EXISTS `ez_user_level`;
CREATE TABLE `ez_user_level`  (
  `id` int(100) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `title` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '级别名称 称号',
  `growth_value` int(11) NOT NULL DEFAULT 0 COMMENT '成长值 经验',
  `desc` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '描述   福利',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '会员级别表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_user_open
-- ----------------------------
DROP TABLE IF EXISTS `ez_user_open`;
CREATE TABLE `ez_user_open`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '主账号ID',
  `origin_user_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '原始用户ID',
  `genre` tinyint(3) UNSIGNED NOT NULL COMMENT '类型 1微信 2小程序 3QQ 4微博....',
  `openid` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'openid',
  `unionid` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'unionid',
  `access_token` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'access_token',
  `expires_in` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'access_token过期时间',
  `refresh_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'access_token过期可用该字段刷新用户access_token',
  `scope` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '应用授权作用域',
  `nickname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '昵称',
  `avatar` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '头像',
  `sex` tinyint(3) UNSIGNED NOT NULL DEFAULT 1 COMMENT '1男0女',
  `country` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '国家',
  `province` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '省份',
  `city` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '城市',
  `info_aggregate` json NULL COMMENT 'json 个人信息集合',
  `state` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否绑定主帐号 默认0否 1是',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '第三方帐号信息【一个用户(唯一的phone)拥有多个第三方帐号】' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_user_points_log
-- ----------------------------
DROP TABLE IF EXISTS `ez_user_points_log`;
CREATE TABLE `ez_user_points_log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `msg` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '文字描述',
  `create_time` int(10) UNSIGNED NOT NULL COMMENT '处理时间',
  `user_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `points` int(10) NULL DEFAULT NULL COMMENT '积分变化的数量',
  `type` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '类型名字',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '会员名称',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '订单处理历史表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_user_profile
-- ----------------------------
DROP TABLE IF EXISTS `ez_user_profile`;
CREATE TABLE `ez_user_profile`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '用户id',
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '客户姓名',
  `nickname` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '昵称',
  `avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '头像',
  `sex` tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '1男0女',
  `birthday` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '生日',
  `qq` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'QQ',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '用户辅助信息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_user_temp
-- ----------------------------
DROP TABLE IF EXISTS `ez_user_temp`;
CREATE TABLE `ez_user_temp`  (
  `user_id` int(10) UNSIGNED NOT NULL,
  `cost_average_price` decimal(10, 2) NULL DEFAULT NULL,
  `cost_times` int(10) UNSIGNED NULL DEFAULT NULL,
  `resent_cost_time` int(10) UNSIGNED NULL DEFAULT NULL,
  `resent_visit_time` int(10) UNSIGNED NULL DEFAULT NULL,
  `cost_price` decimal(10, 2) NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_user_visit
-- ----------------------------
DROP TABLE IF EXISTS `ez_user_visit`;
CREATE TABLE `ez_user_visit`  (
  `user_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `create_time` int(10) UNSIGNED NULL DEFAULT NULL
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Table structure for ez_user_wechat
-- ----------------------------
DROP TABLE IF EXISTS `ez_user_wechat`;
CREATE TABLE `ez_user_wechat`  (
  `user_id` int(10) UNSIGNED NOT NULL,
  `openid` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sex` tinyint(1) UNSIGNED NULL DEFAULT NULL,
  `nickname` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `language` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `city` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `province` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `country` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `headimgurl` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `unionid` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `remark` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `groupid` int(10) NULL DEFAULT NULL,
  `tagid_list` json NULL,
  `subscribe` tinyint(1) UNSIGNED NULL DEFAULT NULL,
  `subscribe_time` int(10) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_verify_code
-- ----------------------------
DROP TABLE IF EXISTS `ez_verify_code`;
CREATE TABLE `ez_verify_code`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `code` char(6) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '验证码',
  `receiver` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '接收者',
  `channel_type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '渠道类型，sms 短信、email 邮箱',
  `behavior` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '行为标识，如register',
  `status` tinyint(2) NOT NULL COMMENT '状态0未验证，1已验证',
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '用户id',
  `create_time` int(10) NOT NULL COMMENT '时间',
  `expire_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '过期时间',
  `ip` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `send_state` tinyint(1) NULL DEFAULT NULL COMMENT '发送状态 1成功 0失败',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '短信记录' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_version
-- ----------------------------
DROP TABLE IF EXISTS `ez_version`;
CREATE TABLE `ez_version`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `version` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '版本号',
  `update_state` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'required必须更新optional可选noneed不需要更新',
  `download_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '下载地址',
  `platform` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'ios/android',
  `create_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '创建时间',
  `publish_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '发布时间',
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '更新说明',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ez_version
-- ----------------------------
INSERT INTO `ez_version` VALUES (1, '1.0.0', 'noneed', '', 'ios', 1504255175, 0, '', NULL);
INSERT INTO `ez_version` VALUES (2, '1.0.0', 'noneed', '', 'android', 1504255182, 0, '', NULL);

-- ----------------------------
-- Table structure for ez_visit
-- ----------------------------
DROP TABLE IF EXISTS `ez_visit`;
CREATE TABLE `ez_visit`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `user_id` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '使用UID',
  `model_relation_id` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '模块关联id',
  `create_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '收藏时间',
  `model` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '模块表名',
  `ip` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'IP',
  `delete_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '收藏(关注)' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_wechat
-- ----------------------------
DROP TABLE IF EXISTS `ez_wechat`;
CREATE TABLE `ez_wechat`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '公众号名称，填写公众号的账号名称',
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '描述，用于说明此公众号的功能及用途',
  `account` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '公众号账号， 填写公众号的账号,一般为英文账号，如：9476400@qq.com',
  `original` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '原始ID，原始ID不能修改,请谨慎填写，如：gh_9468ce6ce474',
  `level` tinyint(1) NULL DEFAULT NULL COMMENT '类型， 1普通订阅号、2普通服务号、3认证订阅号、4认证服务号',
  `app_key` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'AppId',
  `app_secret` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'AppSecret',
  `headimg` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '头像',
  `qrcode` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '二维码',
  `auto_reply_status` tinyint(1) NULL DEFAULT 0 COMMENT '被关注自动回复状态0关闭1开启',
  `auto_reply_subscribe_replay_content` json NULL COMMENT '被关注自动回复内容',
  `mch_id` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `app_id` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ez_wechat
-- ----------------------------
INSERT INTO `ez_wechat` VALUES (1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for ez_wechat_auto_reply
-- ----------------------------
DROP TABLE IF EXISTS `ez_wechat_auto_reply`;
CREATE TABLE `ez_wechat_auto_reply`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `rule_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '规则名称',
  `create_time` int(10) UNSIGNED NULL DEFAULT NULL,
  `reply_mode` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'reply_all',
  `reply_content` json NULL,
  `keys` json NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_wechat_auto_reply_keywords
-- ----------------------------
DROP TABLE IF EXISTS `ez_wechat_auto_reply_keywords`;
CREATE TABLE `ez_wechat_auto_reply_keywords`  (
  `auto_reply_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `key` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `match_mode` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'contain'
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_wechat_broadcast
-- ----------------------------
DROP TABLE IF EXISTS `ez_wechat_broadcast`;
CREATE TABLE `ez_wechat_broadcast`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `create_time` int(10) NULL DEFAULT NULL,
  `condition` json NULL,
  `send_time` int(10) UNSIGNED NULL DEFAULT NULL,
  `send_content` json NOT NULL,
  `send_state` tinyint(1) NULL DEFAULT 0 COMMENT '是否已经发生 0未发送 1成功 2失败',
  `send_user_count` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '发送人数',
  `openids` json NULL COMMENT '发送的openid集合',
  `send_content_type` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '`text`文本、`image`图片、`news`图文 、`voice`音频、 `video`视频',
  `condition_type` tinyint(1) NOT NULL COMMENT '1全部粉丝  2按条件筛选 3手动选择粉丝',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ez_wechat_user
-- ----------------------------
DROP TABLE IF EXISTS `ez_wechat_user`;
CREATE TABLE `ez_wechat_user`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `app_id` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `subscribe` tinyint(1) NULL DEFAULT NULL,
  `openid` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `nickname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `sex` tinyint(1) UNSIGNED NULL DEFAULT NULL,
  `language` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `city` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `province` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `country` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `headimgurl` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `subscribe_time` int(10) NULL DEFAULT NULL,
  `unionid` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `remark` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `groupid` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `tagid_list` json NULL,
  `create_time` int(10) NULL DEFAULT NULL,
  `update_time` int(10) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `openid`(`openid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
