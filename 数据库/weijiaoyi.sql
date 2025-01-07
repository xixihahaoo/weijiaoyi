/*
 Navicat Premium Data Transfer

 Source Server         : weijiaoyi
 Source Server Type    : MySQL
 Source Server Version : 50719
 Source Host           : 39.107.99.235:3306
 Source Schema         : weijiaoyi

 Target Server Type    : MySQL
 Target Server Version : 50719
 File Encoding         : 65001

 Date: 07/01/2025 16:25:56
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for dict_pay_type
-- ----------------------------
DROP TABLE IF EXISTS `dict_pay_type`;
CREATE TABLE `dict_pay_type`  (
  `id` smallint(4) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pay_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '支付类型名称',
  `tempdate` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dict_pay_type
-- ----------------------------

-- ----------------------------
-- Table structure for log_cli
-- ----------------------------
DROP TABLE IF EXISTS `log_cli`;
CREATE TABLE `log_cli`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` smallint(4) UNSIGNED NULL DEFAULT 0 COMMENT '执行的类型，1,商品状态 2前几分钟休市  3佣金周结 4.首信易获取支付状态',
  `create_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '脚本执行时间',
  `tempdate` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0),
  `script_name` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '执行的脚本的名称',
  `note` varchar(3000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '脚本运行备注',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 24 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of log_cli
-- ----------------------------

-- ----------------------------
-- Table structure for log_cli_temp
-- ----------------------------
DROP TABLE IF EXISTS `log_cli_temp`;
CREATE TABLE `log_cli_temp`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` smallint(4) UNSIGNED NULL DEFAULT 0 COMMENT '执行的类型，1,商品状态 2前几分钟休市  3佣金周结 4.首信易获取支付状态',
  `create_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '脚本执行时间',
  `tempdate` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0),
  `script_name` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '执行的脚本的名称',
  `note` varchar(3000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '脚本运行备注',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 24 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of log_cli_temp
-- ----------------------------

-- ----------------------------
-- Table structure for log_ms
-- ----------------------------
DROP TABLE IF EXISTS `log_ms`;
CREATE TABLE `log_ms`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` int(11) NULL DEFAULT NULL,
  `note0` text CHARACTER SET utf8 COLLATE utf8_bin NULL,
  `note1` text CHARACTER SET utf8 COLLATE utf8_bin NULL,
  `note2` text CHARACTER SET utf8 COLLATE utf8_bin NULL,
  `note3` text CHARACTER SET utf8 COLLATE utf8_bin NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of log_ms
-- ----------------------------

-- ----------------------------
-- Table structure for log_weixinshangcheng
-- ----------------------------
DROP TABLE IF EXISTS `log_weixinshangcheng`;
CREATE TABLE `log_weixinshangcheng`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `balance_no` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `create_date` int(11) NULL DEFAULT NULL,
  `note` varchar(500) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `status` tinyint(3) UNSIGNED NULL DEFAULT 1 COMMENT '默认1处理成功，0处理失败',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of log_weixinshangcheng
-- ----------------------------

-- ----------------------------
-- Table structure for temp_ips_flow
-- ----------------------------
DROP TABLE IF EXISTS `temp_ips_flow`;
CREATE TABLE `temp_ips_flow`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `create_date` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `order_no` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `balance_no` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `amount` decimal(10, 2) NULL DEFAULT NULL,
  `balance` decimal(10, 2) NULL DEFAULT NULL,
  `tempdate` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0),
  `balance_id` int(10) NULL DEFAULT NULL,
  `uid` int(10) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of temp_ips_flow
-- ----------------------------

-- ----------------------------
-- Table structure for temp_oids
-- ----------------------------
DROP TABLE IF EXISTS `temp_oids`;
CREATE TABLE `temp_oids`  (
  `oid` int(10) NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of temp_oids
-- ----------------------------

-- ----------------------------
-- Table structure for temp_operate_orders
-- ----------------------------
DROP TABLE IF EXISTS `temp_operate_orders`;
CREATE TABLE `temp_operate_orders`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` int(10) NULL DEFAULT NULL,
  `operate_id` int(10) NULL DEFAULT NULL,
  `order_cott` int(10) NULL DEFAULT NULL,
  `balance` decimal(10, 2) NULL DEFAULT NULL,
  `feerebate` decimal(10, 2) NULL DEFAULT NULL,
  `total_fee` decimal(10, 2) NULL DEFAULT NULL,
  `now_balance` decimal(10, 2) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of temp_operate_orders
-- ----------------------------

-- ----------------------------
-- Table structure for temp_orders
-- ----------------------------
DROP TABLE IF EXISTS `temp_orders`;
CREATE TABLE `temp_orders`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `oid` int(10) NULL DEFAULT NULL,
  `jno` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of temp_orders
-- ----------------------------

-- ----------------------------
-- Table structure for temp_unit_orders
-- ----------------------------
DROP TABLE IF EXISTS `temp_unit_orders`;
CREATE TABLE `temp_unit_orders`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` int(10) NULL DEFAULT NULL,
  `operate_id` int(10) NULL DEFAULT NULL,
  `order_cott` int(10) NULL DEFAULT NULL,
  `balance` decimal(10, 2) NULL DEFAULT NULL,
  `now_balance` decimal(10, 2) NULL DEFAULT NULL,
  `yingkui` decimal(10, 2) NULL DEFAULT NULL,
  `money_in` decimal(10, 2) NULL DEFAULT NULL,
  `money_in_new` decimal(10, 2) NULL DEFAULT NULL,
  `status` tinyint(1) UNSIGNED NULL DEFAULT NULL,
  `state` tinyint(1) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uid`(`operate_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of temp_unit_orders
-- ----------------------------

-- ----------------------------
-- Table structure for temp_userinfo
-- ----------------------------
DROP TABLE IF EXISTS `temp_userinfo`;
CREATE TABLE `temp_userinfo`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` int(10) NULL DEFAULT NULL,
  `balance` decimal(10, 2) NULL DEFAULT NULL,
  `new_balance` decimal(10, 2) NULL DEFAULT NULL,
  `money_in` decimal(10, 2) NULL DEFAULT NULL,
  `money_out` decimal(10, 2) NULL DEFAULT NULL,
  `total_balance` decimal(10, 2) NULL DEFAULT NULL,
  `status` tinyint(1) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1707 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of temp_userinfo
-- ----------------------------
INSERT INTO `temp_userinfo` VALUES (1, 2932, 0.00, -100.00, 200.00, NULL, 100.00, 0);
INSERT INTO `temp_userinfo` VALUES (2, 2976, 1.50, -992.50, 1594.00, NULL, 601.50, 0);
INSERT INTO `temp_userinfo` VALUES (8, 3090, 0.00, -23.60, 100.00, NULL, 76.40, 0);
INSERT INTO `temp_userinfo` VALUES (10, 3306, 0.00, 343.50, 300.00, NULL, 643.50, 0);
INSERT INTO `temp_userinfo` VALUES (11, 3320, 25.00, -475.00, 700.00, NULL, 225.00, 0);
INSERT INTO `temp_userinfo` VALUES (13, 3544, 1469.80, 1055.30, 200.00, NULL, 1255.30, 0);
INSERT INTO `temp_userinfo` VALUES (15, 3574, 0.00, -2.00, 100.00, NULL, 98.00, 0);
INSERT INTO `temp_userinfo` VALUES (17, 3608, 0.00, -100.00, 300.00, NULL, 200.00, 0);
INSERT INTO `temp_userinfo` VALUES (18, 3642, 1.00, 71.50, 100.00, NULL, 171.50, 0);
INSERT INTO `temp_userinfo` VALUES (20, 3670, 2330.50, -1513.00, 2300.00, NULL, 787.00, 0);
INSERT INTO `temp_userinfo` VALUES (21, 3676, 0.00, -300.00, 500.00, NULL, 200.00, 0);
INSERT INTO `temp_userinfo` VALUES (23, 3693, 58.40, -865.60, 994.00, NULL, 128.40, 0);
INSERT INTO `temp_userinfo` VALUES (26, 3712, 171.50, -28.50, 300.00, NULL, 271.50, 0);
INSERT INTO `temp_userinfo` VALUES (34, 4008, 0.00, -300.00, 500.00, NULL, 200.00, 0);
INSERT INTO `temp_userinfo` VALUES (41, 4048, 27.80, -1321.70, 900.00, NULL, -421.70, 1);
INSERT INTO `temp_userinfo` VALUES (46, 4156, 0.50, -28.50, 100.00, NULL, 71.50, 0);
INSERT INTO `temp_userinfo` VALUES (48, 4179, 15.90, -280.10, 396.00, NULL, 115.90, 0);
INSERT INTO `temp_userinfo` VALUES (50, 4197, 0.00, 71.50, 100.00, NULL, 171.50, 0);
INSERT INTO `temp_userinfo` VALUES (55, 4208, 417.40, 47.90, 298.00, NULL, 345.90, 0);
INSERT INTO `temp_userinfo` VALUES (66, 4296, 79.50, -1706.50, 1200.00, NULL, -506.50, 1);
INSERT INTO `temp_userinfo` VALUES (68, 4311, 100.00, -100.00, 1200.00, NULL, 1100.00, 0);
INSERT INTO `temp_userinfo` VALUES (70, 4434, 9192.90, 7840.10, 1000.00, NULL, 8840.10, 0);
INSERT INTO `temp_userinfo` VALUES (71, 4444, 0.00, 71.50, 100.00, NULL, 171.50, 0);
INSERT INTO `temp_userinfo` VALUES (73, 4461, 8.80, 374.00, 400.00, NULL, 774.00, 0);
INSERT INTO `temp_userinfo` VALUES (75, 4525, 1135.80, 854.50, 200.00, NULL, 1054.50, 0);
INSERT INTO `temp_userinfo` VALUES (77, 4571, 87.00, -84.50, 500.00, NULL, 415.50, 0);
INSERT INTO `temp_userinfo` VALUES (78, 4588, 154.50, 114.50, 500.00, NULL, 614.50, 0);
INSERT INTO `temp_userinfo` VALUES (80, 4644, 31.00, -512.00, 500.00, NULL, -12.00, 1);
INSERT INTO `temp_userinfo` VALUES (84, 4664, 4220.40, 122.40, 300.00, NULL, 422.40, 0);
INSERT INTO `temp_userinfo` VALUES (85, 4681, 53.60, -2432.40, 2200.00, NULL, -232.40, 1);
INSERT INTO `temp_userinfo` VALUES (86, 4682, 1175.00, -1392.50, 2396.00, NULL, 1003.50, 0);
INSERT INTO `temp_userinfo` VALUES (87, 4691, 0.50, -142.50, 200.00, NULL, 57.50, 0);
INSERT INTO `temp_userinfo` VALUES (88, 4718, 80.00, 329.90, 300.00, NULL, 629.90, 0);
INSERT INTO `temp_userinfo` VALUES (89, 4719, 0.50, -826.00, 1200.00, NULL, 374.00, 0);
INSERT INTO `temp_userinfo` VALUES (97, 4843, 7131.70, 5433.70, 2198.00, NULL, 7631.70, 0);
INSERT INTO `temp_userinfo` VALUES (98, 4861, 63.80, -1935.20, 200.00, NULL, -1735.20, 1);
INSERT INTO `temp_userinfo` VALUES (100, 4881, 602.00, -214.00, 300.00, NULL, 86.00, 0);
INSERT INTO `temp_userinfo` VALUES (104, 4973, 1476.60, 2423.80, 1500.00, NULL, 3923.80, 0);
INSERT INTO `temp_userinfo` VALUES (111, 5061, 3.00, -57.00, 100.00, NULL, 43.00, 0);
INSERT INTO `temp_userinfo` VALUES (113, 5067, 2078.30, 635.30, 1200.00, NULL, 1835.30, 0);
INSERT INTO `temp_userinfo` VALUES (114, 5090, 1627.80, 103.50, 1000.00, NULL, 1103.50, 0);
INSERT INTO `temp_userinfo` VALUES (118, 5133, 135.40, -364.60, 600.00, NULL, 235.40, 0);
INSERT INTO `temp_userinfo` VALUES (122, 5174, 72.90, -503.50, 400.00, NULL, -103.50, 1);
INSERT INTO `temp_userinfo` VALUES (123, 5181, 32.90, -419.90, 300.00, NULL, -119.90, 1);
INSERT INTO `temp_userinfo` VALUES (130, 5379, 26.70, -173.30, 400.00, NULL, 226.70, 0);
INSERT INTO `temp_userinfo` VALUES (131, 5402, 1.90, 71.50, 100.00, NULL, 171.50, 0);
INSERT INTO `temp_userinfo` VALUES (134, 5457, 1.10, -1103.30, 500.00, NULL, -603.30, 1);
INSERT INTO `temp_userinfo` VALUES (141, 5505, 0.50, 71.50, 100.00, NULL, 171.50, 0);
INSERT INTO `temp_userinfo` VALUES (142, 5507, 0.90, -209.10, 300.00, NULL, 90.90, 0);
INSERT INTO `temp_userinfo` VALUES (143, 5512, 59.70, -19607.80, 19496.00, NULL, -111.80, 1);
INSERT INTO `temp_userinfo` VALUES (144, 5513, 12920.50, 960.50, 2000.00, NULL, 2960.50, 0);
INSERT INTO `temp_userinfo` VALUES (147, 5533, 1002.50, 431.00, 1200.00, NULL, 1631.00, 0);
INSERT INTO `temp_userinfo` VALUES (149, 5542, 1080.30, 408.80, 500.00, NULL, 908.80, 0);
INSERT INTO `temp_userinfo` VALUES (150, 5545, 0.00, 272.50, 2000.00, NULL, 2272.50, 0);
INSERT INTO `temp_userinfo` VALUES (152, 5603, 7520.40, -4479.60, 13000.00, NULL, 8520.40, 0);
INSERT INTO `temp_userinfo` VALUES (153, 5617, 21.50, -2179.00, 1000.00, NULL, -1179.00, 1);
INSERT INTO `temp_userinfo` VALUES (154, 5618, 54.40, -883.60, 400.00, NULL, -483.60, 1);
INSERT INTO `temp_userinfo` VALUES (156, 5627, 75.30, -3192.20, 3296.00, NULL, 103.80, 0);
INSERT INTO `temp_userinfo` VALUES (157, 5629, 0.50, -198.00, 800.00, NULL, 602.00, 0);
INSERT INTO `temp_userinfo` VALUES (158, 5644, 84.90, 2784.90, 2300.00, NULL, 5084.90, 0);
INSERT INTO `temp_userinfo` VALUES (162, 5663, 26.50, -3090.00, 2702.00, NULL, -388.00, 1);
INSERT INTO `temp_userinfo` VALUES (163, 5668, 8.50, -4163.00, 4000.00, NULL, -163.00, 1);
INSERT INTO `temp_userinfo` VALUES (165, 5693, 86.00, -714.00, 2000.00, NULL, 1286.00, 0);
INSERT INTO `temp_userinfo` VALUES (167, 5702, 0.00, -414.00, 500.00, NULL, 86.00, 0);
INSERT INTO `temp_userinfo` VALUES (168, 5704, 2845.10, 2302.10, 400.00, NULL, 2702.10, 0);
INSERT INTO `temp_userinfo` VALUES (169, 5706, 43.00, 143.00, 100.00, NULL, 243.00, 0);
INSERT INTO `temp_userinfo` VALUES (170, 5736, 198.00, -327.00, 598.00, NULL, 271.00, 0);
INSERT INTO `temp_userinfo` VALUES (172, 5750, 17071.00, 14256.50, 2400.00, NULL, 16656.50, 0);
INSERT INTO `temp_userinfo` VALUES (177, 5810, 271.50, -200.00, 400.00, NULL, 200.00, 0);
INSERT INTO `temp_userinfo` VALUES (178, 5816, 294.30, -487.00, 700.00, NULL, 213.00, 0);
INSERT INTO `temp_userinfo` VALUES (183, 5852, 7671.00, -2645.50, 5000.00, NULL, 2354.50, 0);
INSERT INTO `temp_userinfo` VALUES (186, 5906, 10670.80, -21.20, 10792.00, NULL, 10770.80, 0);
INSERT INTO `temp_userinfo` VALUES (192, 5963, 97.80, -1073.70, 1000.00, NULL, -73.70, 1);
INSERT INTO `temp_userinfo` VALUES (194, 5989, 9008.20, 7808.20, 300.00, NULL, 8108.20, 0);
INSERT INTO `temp_userinfo` VALUES (203, 6045, 57.50, -685.50, 600.00, NULL, -85.50, 1);
INSERT INTO `temp_userinfo` VALUES (204, 6061, 0.00, -239.50, 1100.00, NULL, 860.50, 0);
INSERT INTO `temp_userinfo` VALUES (209, 6088, 4.00, 143.00, 1000.00, NULL, 1143.00, 0);
INSERT INTO `temp_userinfo` VALUES (220, 6198, 9647.90, 9176.40, 500.00, NULL, 9676.40, 0);
INSERT INTO `temp_userinfo` VALUES (222, 6207, 1.50, -28.50, 100.00, NULL, 71.50, 0);
INSERT INTO `temp_userinfo` VALUES (225, 6222, 6161.70, 5390.20, 1000.00, NULL, 6390.20, 0);
INSERT INTO `temp_userinfo` VALUES (228, 6254, 0.00, 143.00, 100.00, NULL, 243.00, 0);
INSERT INTO `temp_userinfo` VALUES (229, 6272, 0.00, -941.00, 1000.00, NULL, 59.00, 0);
INSERT INTO `temp_userinfo` VALUES (232, 6286, 71.50, -28.50, 1100.00, NULL, 1071.50, 0);
INSERT INTO `temp_userinfo` VALUES (234, 6294, 6333.30, 5161.80, 100.00, NULL, 5261.80, 0);
INSERT INTO `temp_userinfo` VALUES (236, 6331, 58.50, -1384.50, 2100.00, NULL, 715.50, 0);
INSERT INTO `temp_userinfo` VALUES (241, 6364, 830.20, 630.20, 1000.00, NULL, 1630.20, 0);
INSERT INTO `temp_userinfo` VALUES (245, 6404, 56.00, 358.00, 300.00, NULL, 658.00, 0);
INSERT INTO `temp_userinfo` VALUES (251, 6438, 2033.70, 862.20, 1000.00, NULL, 1862.20, 0);
INSERT INTO `temp_userinfo` VALUES (254, 6476, 560.90, 191.40, 300.00, NULL, 491.40, 0);
INSERT INTO `temp_userinfo` VALUES (257, 6489, 13.30, -1329.70, 1000.00, NULL, -329.70, 1);
INSERT INTO `temp_userinfo` VALUES (262, 6563, 34.00, -566.00, 1700.00, NULL, 1134.00, 0);
INSERT INTO `temp_userinfo` VALUES (263, 6568, 1088.80, -667.90, 1800.00, NULL, 1132.10, 0);
INSERT INTO `temp_userinfo` VALUES (264, 6578, 43.00, -957.00, 100.00, NULL, -857.00, 1);
INSERT INTO `temp_userinfo` VALUES (269, 6606, 58.50, -813.00, 700.00, NULL, -113.00, 1);
INSERT INTO `temp_userinfo` VALUES (277, 6700, 0.60, -764.40, 800.00, NULL, 35.60, 0);
INSERT INTO `temp_userinfo` VALUES (278, 6706, 567.30, -4.20, 600.00, NULL, 595.80, 0);
INSERT INTO `temp_userinfo` VALUES (279, 6710, 1445.50, 102.50, 1500.00, NULL, 1602.50, 0);
INSERT INTO `temp_userinfo` VALUES (280, 6716, 71.70, -1271.30, 1000.00, NULL, -271.30, 1);
INSERT INTO `temp_userinfo` VALUES (285, 6742, 3892.70, 3406.70, 200.00, NULL, 3606.70, 0);
INSERT INTO `temp_userinfo` VALUES (288, 6762, 44.00, -499.00, 1000.00, NULL, 501.00, 0);
INSERT INTO `temp_userinfo` VALUES (289, 6771, 91.30, -794.70, 900.00, NULL, 105.30, 0);
INSERT INTO `temp_userinfo` VALUES (295, 6863, 0.00, -36.00, 300.00, NULL, 264.00, 0);
INSERT INTO `temp_userinfo` VALUES (296, 6864, 97.60, -2839.40, 4394.00, NULL, 1554.60, 0);
INSERT INTO `temp_userinfo` VALUES (299, 6925, 30.00, -1115.90, 798.00, NULL, -317.90, 1);
INSERT INTO `temp_userinfo` VALUES (300, 6927, 755.90, 755.90, 600.00, NULL, 1355.90, 0);
INSERT INTO `temp_userinfo` VALUES (303, 6949, 0.00, 43.00, 200.00, NULL, 243.00, 0);
INSERT INTO `temp_userinfo` VALUES (304, 6950, 1850.20, 1509.20, 598.00, NULL, 2107.20, 0);
INSERT INTO `temp_userinfo` VALUES (308, 6993, 1111.40, -813.10, 1100.00, NULL, 286.90, 0);
INSERT INTO `temp_userinfo` VALUES (309, 7003, 0.50, -230.50, 300.00, NULL, 69.50, 0);
INSERT INTO `temp_userinfo` VALUES (314, 7038, 652.50, -4219.90, 4796.00, NULL, 576.10, 0);
INSERT INTO `temp_userinfo` VALUES (315, 7075, 71.50, 71.50, 100.00, NULL, 171.50, 0);
INSERT INTO `temp_userinfo` VALUES (316, 7079, 16043.50, 14872.00, 1000.00, NULL, 15872.00, 0);
INSERT INTO `temp_userinfo` VALUES (318, 7089, 1017.70, 719.70, 500.00, NULL, 1219.70, 0);
INSERT INTO `temp_userinfo` VALUES (320, 7109, 63.70, -434.30, 698.00, NULL, 263.70, 0);
INSERT INTO `temp_userinfo` VALUES (323, 7134, 274.90, -1192.60, 1296.00, NULL, 103.40, 0);
INSERT INTO `temp_userinfo` VALUES (324, 7149, 34.90, 134.90, 1000.00, NULL, 1134.90, 0);
INSERT INTO `temp_userinfo` VALUES (326, 7151, 6411.20, 5291.80, 900.00, NULL, 6191.80, 0);
INSERT INTO `temp_userinfo` VALUES (327, 7159, 79.00, -519.00, 1000.00, NULL, 481.00, 0);
INSERT INTO `temp_userinfo` VALUES (330, 7169, 3088.50, 1790.50, 1398.00, NULL, 3188.50, 0);
INSERT INTO `temp_userinfo` VALUES (332, 7175, 46.00, -4468.50, 4000.00, NULL, -468.50, 1);
INSERT INTO `temp_userinfo` VALUES (336, 7211, 17.80, -2213.20, 2088.00, NULL, -125.20, 1);
INSERT INTO `temp_userinfo` VALUES (337, 7212, 0.00, -175.70, 400.00, NULL, 224.30, 0);
INSERT INTO `temp_userinfo` VALUES (339, 7219, 0.60, 5.60, 100.00, NULL, 105.60, 0);
INSERT INTO `temp_userinfo` VALUES (341, 7221, 73.60, -3212.40, 3686.00, NULL, 473.60, 0);
INSERT INTO `temp_userinfo` VALUES (343, 7240, 316.40, -279.60, 796.00, NULL, 516.40, 0);
INSERT INTO `temp_userinfo` VALUES (346, 7280, 11.00, -3919.00, 1000.00, NULL, -2919.00, 1);
INSERT INTO `temp_userinfo` VALUES (348, 7296, 0.00, -246.50, 600.00, NULL, 353.50, 0);
INSERT INTO `temp_userinfo` VALUES (349, 7300, 95.00, -2224.50, 1200.00, NULL, -1024.50, 1);
INSERT INTO `temp_userinfo` VALUES (353, 7319, 26348.50, 17062.00, 14000.00, NULL, 31062.00, 0);
INSERT INTO `temp_userinfo` VALUES (355, 7330, 2491.50, 1320.00, 1000.00, NULL, 2320.00, 0);
INSERT INTO `temp_userinfo` VALUES (357, 7348, 429.50, 358.00, 300.00, NULL, 658.00, 0);
INSERT INTO `temp_userinfo` VALUES (358, 7350, 16.40, -4527.10, 4186.00, NULL, -341.10, 1);
INSERT INTO `temp_userinfo` VALUES (364, 7391, 2224.50, 1360.00, 300.00, NULL, 1660.00, 0);
INSERT INTO `temp_userinfo` VALUES (365, 7414, 1068.50, 725.50, 200.00, NULL, 925.50, 0);
INSERT INTO `temp_userinfo` VALUES (366, 7426, 24.00, -1076.00, 2100.00, NULL, 1024.00, 0);
INSERT INTO `temp_userinfo` VALUES (368, 7503, 429.90, 58.40, 300.00, NULL, 358.40, 0);
INSERT INTO `temp_userinfo` VALUES (369, 7518, 2415.20, 2143.70, 100.00, NULL, 2243.70, 0);
INSERT INTO `temp_userinfo` VALUES (374, 7566, 594.40, -248.60, 600.00, NULL, 351.40, 0);
INSERT INTO `temp_userinfo` VALUES (375, 7570, 645.00, -526.50, 1000.00, NULL, 473.50, 0);
INSERT INTO `temp_userinfo` VALUES (377, 7592, 4138.50, -1004.50, 5000.00, NULL, 3995.50, 0);
INSERT INTO `temp_userinfo` VALUES (379, 7601, 399.00, -568.50, 796.00, NULL, 227.50, 0);
INSERT INTO `temp_userinfo` VALUES (384, 7665, 6232.00, 4874.50, 1000.00, NULL, 5874.50, 0);
INSERT INTO `temp_userinfo` VALUES (386, 7701, 969.30, -3337.20, 4192.00, NULL, 854.80, 0);
INSERT INTO `temp_userinfo` VALUES (388, 7733, 2.80, -89.70, 200.00, NULL, 110.30, 0);
INSERT INTO `temp_userinfo` VALUES (389, 7734, 1782.00, 382.00, 2000.00, NULL, 2382.00, 0);
INSERT INTO `temp_userinfo` VALUES (391, 7795, 34.60, -599.30, 1588.00, NULL, 988.70, 0);
INSERT INTO `temp_userinfo` VALUES (394, 7843, 0.00, -500.00, 5500.00, NULL, 5000.00, 0);
INSERT INTO `temp_userinfo` VALUES (397, 7863, 44024.50, 12017.50, 500.00, NULL, 12517.50, 0);
INSERT INTO `temp_userinfo` VALUES (401, 7911, 45.00, -555.00, 800.00, NULL, 245.00, 0);
INSERT INTO `temp_userinfo` VALUES (406, 8145, 3008.70, 1608.20, 400.00, NULL, 2008.20, 0);
INSERT INTO `temp_userinfo` VALUES (408, 8174, 0.00, 70.00, 400.00, NULL, 470.00, 0);
INSERT INTO `temp_userinfo` VALUES (410, 8180, 7086.90, 4915.40, 2300.00, NULL, 7215.40, 0);
INSERT INTO `temp_userinfo` VALUES (413, 8190, 3033.20, 880.40, 1800.00, NULL, 2680.40, 0);
INSERT INTO `temp_userinfo` VALUES (417, 8210, 1346.70, 875.20, 300.00, NULL, 1175.20, 0);
INSERT INTO `temp_userinfo` VALUES (418, 8212, 2.00, -1762.00, 1800.00, NULL, 38.00, 0);
INSERT INTO `temp_userinfo` VALUES (421, 8244, 0.70, -1132.80, 1300.00, NULL, 167.20, 0);
INSERT INTO `temp_userinfo` VALUES (423, 8249, 44.00, -627.50, 500.00, NULL, -127.50, 1);
INSERT INTO `temp_userinfo` VALUES (426, 8276, 171.50, 114.50, 200.00, NULL, 314.50, 0);
INSERT INTO `temp_userinfo` VALUES (427, 8281, 6.90, 436.90, 2400.00, NULL, 2836.90, 0);
INSERT INTO `temp_userinfo` VALUES (431, 8327, 258.00, -513.50, 600.00, NULL, 86.50, 0);
INSERT INTO `temp_userinfo` VALUES (433, 8338, 3431.10, 763.60, 2696.00, NULL, 3459.60, 0);
INSERT INTO `temp_userinfo` VALUES (439, 8391, 43.00, 43.00, 100.00, NULL, 143.00, 0);
INSERT INTO `temp_userinfo` VALUES (440, 8398, 68.00, -403.50, 1000.00, NULL, 596.50, 0);
INSERT INTO `temp_userinfo` VALUES (444, 8437, 1756.90, 537.50, 1100.00, NULL, 1637.50, 0);
INSERT INTO `temp_userinfo` VALUES (447, 8466, 42.30, -1770.20, 1798.00, NULL, 27.80, 0);
INSERT INTO `temp_userinfo` VALUES (449, 8499, 801.60, -3594.20, 3700.00, NULL, 105.80, 0);
INSERT INTO `temp_userinfo` VALUES (454, 8511, 9217.30, 9559.80, 800.00, NULL, 10359.80, 0);
INSERT INTO `temp_userinfo` VALUES (456, 8534, 1657.50, 1657.50, 100.00, NULL, 1757.50, 0);
INSERT INTO `temp_userinfo` VALUES (463, 8602, 134.80, -4541.60, 5500.00, NULL, 958.40, 0);
INSERT INTO `temp_userinfo` VALUES (465, 8616, 67.30, -1104.20, 1000.00, NULL, -104.20, 1);
INSERT INTO `temp_userinfo` VALUES (468, 8636, 229.90, -546.50, 600.00, NULL, 53.50, 0);
INSERT INTO `temp_userinfo` VALUES (470, 8648, 0.00, -257.00, 500.00, NULL, 243.00, 0);
INSERT INTO `temp_userinfo` VALUES (471, 8663, 65.90, -2695.60, 2790.00, NULL, 94.40, 0);
INSERT INTO `temp_userinfo` VALUES (478, 8721, 42.30, -605.60, 500.00, NULL, -105.60, 1);
INSERT INTO `temp_userinfo` VALUES (480, 8736, 958.90, 958.90, 1000.00, NULL, 1958.90, 0);
INSERT INTO `temp_userinfo` VALUES (484, 8789, 64.70, -211.70, 100.00, NULL, -111.70, 1);
INSERT INTO `temp_userinfo` VALUES (487, 8798, 3356.60, 1270.60, 1400.00, NULL, 2670.60, 0);
INSERT INTO `temp_userinfo` VALUES (491, 8836, 1.50, -28.50, 100.00, NULL, 71.50, 0);
INSERT INTO `temp_userinfo` VALUES (495, 8873, 68715.50, 58772.00, 4300.00, NULL, 63072.00, 0);
INSERT INTO `temp_userinfo` VALUES (508, 8980, 43.00, -357.00, 500.00, NULL, 143.00, 0);
INSERT INTO `temp_userinfo` VALUES (516, 9051, 36.10, -2649.90, 2000.00, NULL, -649.90, 1);
INSERT INTO `temp_userinfo` VALUES (522, 9155, 477.00, -1823.30, 2394.00, NULL, 570.70, 0);
INSERT INTO `temp_userinfo` VALUES (524, 9179, 0.90, 90.90, 200.00, NULL, 290.90, 0);
INSERT INTO `temp_userinfo` VALUES (527, 9218, 282.90, -5073.10, 3298.00, NULL, -1775.10, 1);
INSERT INTO `temp_userinfo` VALUES (528, 9219, 2373.20, 1430.20, 1000.00, NULL, 2430.20, 0);
INSERT INTO `temp_userinfo` VALUES (529, 9256, 66.80, -204.70, 100.00, NULL, -104.70, 1);
INSERT INTO `temp_userinfo` VALUES (532, 9295, 0.90, -109.10, 200.00, NULL, 90.90, 0);
INSERT INTO `temp_userinfo` VALUES (533, 9308, 28.10, -3857.90, 4100.00, NULL, 242.10, 0);
INSERT INTO `temp_userinfo` VALUES (534, 9310, 987.20, 415.70, 500.00, NULL, 915.70, 0);
INSERT INTO `temp_userinfo` VALUES (537, 9351, 18.00, 41.00, 100.00, NULL, 141.00, 0);
INSERT INTO `temp_userinfo` VALUES (538, 9361, 1249.60, 978.10, 300.00, NULL, 1278.10, 0);
INSERT INTO `temp_userinfo` VALUES (539, 9379, 49.40, -180.60, 300.00, NULL, 119.40, 0);
INSERT INTO `temp_userinfo` VALUES (541, 9416, 19.50, -1989.00, 1994.00, NULL, 5.00, 0);
INSERT INTO `temp_userinfo` VALUES (546, 9491, 215.00, -1128.00, 1000.00, NULL, -128.00, 1);
INSERT INTO `temp_userinfo` VALUES (552, 9545, 2625.30, 4153.80, 800.00, NULL, 4953.80, 0);
INSERT INTO `temp_userinfo` VALUES (557, 9568, 399.70, -243.30, 1000.00, NULL, 756.70, 0);
INSERT INTO `temp_userinfo` VALUES (562, 9594, 71.50, -328.50, 700.00, NULL, 371.50, 0);
INSERT INTO `temp_userinfo` VALUES (567, 9629, 488.00, -1275.50, 1592.00, NULL, 316.50, 0);
INSERT INTO `temp_userinfo` VALUES (570, 9639, 37.50, -5122.50, 4688.00, NULL, -434.50, 1);
INSERT INTO `temp_userinfo` VALUES (573, 9667, 2726.90, 3897.70, 300.00, NULL, 4197.70, 0);
INSERT INTO `temp_userinfo` VALUES (580, 9732, 3068.50, 3868.50, 200.00, NULL, 4068.50, 0);
INSERT INTO `temp_userinfo` VALUES (583, 9769, 786.00, 214.50, 500.00, NULL, 714.50, 0);
INSERT INTO `temp_userinfo` VALUES (587, 9780, 88.50, -1624.00, 1798.00, NULL, 174.00, 0);
INSERT INTO `temp_userinfo` VALUES (590, 9806, 95.40, -302.60, 498.00, NULL, 195.40, 0);
INSERT INTO `temp_userinfo` VALUES (594, 9849, 1.50, -228.50, 300.00, NULL, 71.50, 0);
INSERT INTO `temp_userinfo` VALUES (595, 9850, 65.50, -3100.00, 2994.00, NULL, -106.00, 1);
INSERT INTO `temp_userinfo` VALUES (598, 9881, 0.00, -157.00, 200.00, NULL, 43.00, 0);
INSERT INTO `temp_userinfo` VALUES (599, 9886, 0.00, 71.50, 100.00, NULL, 171.50, 0);
INSERT INTO `temp_userinfo` VALUES (602, 9952, 5.90, 505.90, 300.00, NULL, 805.90, 0);
INSERT INTO `temp_userinfo` VALUES (611, 10059, 2200.80, 1719.30, 996.00, NULL, 2715.30, 0);
INSERT INTO `temp_userinfo` VALUES (618, 10132, 1092.80, -103.20, 1698.00, NULL, 1594.80, 0);
INSERT INTO `temp_userinfo` VALUES (622, 10172, 1000.00, 48417.50, 1000.00, NULL, 49417.50, 0);
INSERT INTO `temp_userinfo` VALUES (628, 10194, 1265.00, 893.50, 300.00, NULL, 1193.50, 0);
INSERT INTO `temp_userinfo` VALUES (632, 10238, 5402.00, 1402.00, 500.00, NULL, 1902.00, 0);
INSERT INTO `temp_userinfo` VALUES (634, 10260, 0.00, -152.10, 200.00, NULL, 47.90, 0);
INSERT INTO `temp_userinfo` VALUES (638, 10325, 40.50, -1227.00, 1496.00, NULL, 269.00, 0);
INSERT INTO `temp_userinfo` VALUES (639, 10339, 246.40, -125.10, 300.00, NULL, 174.90, 0);
INSERT INTO `temp_userinfo` VALUES (640, 10375, 970.50, 901.00, 800.00, NULL, 1701.00, 0);
INSERT INTO `temp_userinfo` VALUES (643, 10419, 43.70, -1132.70, 1000.00, NULL, -132.70, 1);
INSERT INTO `temp_userinfo` VALUES (646, 10465, 1249.00, -37.00, 1300.00, NULL, 1263.00, 0);
INSERT INTO `temp_userinfo` VALUES (647, 10470, 13.50, -442.50, 500.00, NULL, 57.50, 0);
INSERT INTO `temp_userinfo` VALUES (648, 10494, 72.00, -299.50, 200.00, NULL, -99.50, 1);
INSERT INTO `temp_userinfo` VALUES (651, 10551, 59.20, -2993.60, 2800.00, NULL, -193.60, 1);
INSERT INTO `temp_userinfo` VALUES (652, 10574, 43.50, -113.50, 400.00, NULL, 286.50, 0);
INSERT INTO `temp_userinfo` VALUES (655, 10608, 1989.80, 1418.30, 500.00, NULL, 1918.30, 0);
INSERT INTO `temp_userinfo` VALUES (656, 10626, 5028.40, 28.40, 10000.00, NULL, 10028.40, 0);
INSERT INTO `temp_userinfo` VALUES (664, 10702, 95.20, -570.30, 594.00, NULL, 23.70, 0);
INSERT INTO `temp_userinfo` VALUES (668, 10723, 801.20, 301.20, 1000.00, NULL, 1301.20, 0);
INSERT INTO `temp_userinfo` VALUES (677, 10822, 517.00, -483.00, 1500.00, NULL, 1017.00, 0);
INSERT INTO `temp_userinfo` VALUES (678, 10834, 75.00, -3840.00, 2300.00, NULL, -1540.00, 1);
INSERT INTO `temp_userinfo` VALUES (682, 10924, 179.40, -797.00, 800.00, NULL, 3.00, 0);
INSERT INTO `temp_userinfo` VALUES (683, 10971, 1930.50, 787.50, 1000.00, NULL, 1787.50, 0);
INSERT INTO `temp_userinfo` VALUES (684, 10980, 0.20, -670.80, 1500.00, NULL, 829.20, 0);
INSERT INTO `temp_userinfo` VALUES (686, 10998, 0.30, 39.00, 500.00, NULL, 539.00, 0);
INSERT INTO `temp_userinfo` VALUES (687, 11000, 81.00, -933.50, 900.00, NULL, -33.50, 1);
INSERT INTO `temp_userinfo` VALUES (692, 11046, 71.50, -100.00, 100.00, NULL, 0.00, 0);
INSERT INTO `temp_userinfo` VALUES (694, 11071, 0.20, 243.90, 100.00, NULL, 343.90, 0);
INSERT INTO `temp_userinfo` VALUES (698, 11089, 88.50, -1179.00, 1296.00, NULL, 117.00, 0);
INSERT INTO `temp_userinfo` VALUES (700, 11101, 49.50, -550.50, 700.00, NULL, 149.50, 0);
INSERT INTO `temp_userinfo` VALUES (701, 11107, 762.90, -137.10, 1000.00, NULL, 862.90, 0);
INSERT INTO `temp_userinfo` VALUES (704, 11137, 1045.20, 545.20, 600.00, NULL, 1145.20, 0);
INSERT INTO `temp_userinfo` VALUES (705, 11145, 2151.90, 1708.90, 900.00, NULL, 2608.90, 0);
INSERT INTO `temp_userinfo` VALUES (709, 11191, 58102.00, 23964.50, 28000.00, NULL, 51964.50, 0);
INSERT INTO `temp_userinfo` VALUES (711, 11203, 19.00, 29.00, 400.00, NULL, 429.00, 0);
INSERT INTO `temp_userinfo` VALUES (724, 11378, 744.00, 644.00, 300.00, NULL, 944.00, 0);
INSERT INTO `temp_userinfo` VALUES (728, 11409, 1071.20, 213.70, 1000.00, NULL, 1213.70, 0);
INSERT INTO `temp_userinfo` VALUES (735, 11472, 27.10, -225.70, 100.00, NULL, -125.70, 1);
INSERT INTO `temp_userinfo` VALUES (737, 11484, 2546.00, 1760.00, 500.00, NULL, 2260.00, 0);
INSERT INTO `temp_userinfo` VALUES (738, 11486, 3257.50, 1359.50, 2398.00, NULL, 3757.50, 0);
INSERT INTO `temp_userinfo` VALUES (743, 11647, 3622.30, 3002.90, 500.00, NULL, 3502.90, 0);
INSERT INTO `temp_userinfo` VALUES (748, 11744, 0.00, -157.00, 200.00, NULL, 43.00, 0);
INSERT INTO `temp_userinfo` VALUES (750, 11762, 1.50, -998.50, 1100.00, NULL, 101.50, 0);
INSERT INTO `temp_userinfo` VALUES (753, 11774, 78.00, -608.00, 1500.00, NULL, 892.00, 0);
INSERT INTO `temp_userinfo` VALUES (755, 11824, 24.50, -31147.00, 31100.00, NULL, -47.00, 1);
INSERT INTO `temp_userinfo` VALUES (761, 11906, 1530.60, 1388.10, 500.00, NULL, 1888.10, 0);
INSERT INTO `temp_userinfo` VALUES (762, 11931, 55.00, -459.50, 300.00, NULL, -159.50, 1);
INSERT INTO `temp_userinfo` VALUES (763, 11936, 0.00, 71.50, 100.00, NULL, 171.50, 0);
INSERT INTO `temp_userinfo` VALUES (764, 11940, 27.00, -6571.00, 6998.00, NULL, 427.00, 0);
INSERT INTO `temp_userinfo` VALUES (766, 11987, 2479.70, 1505.30, 1098.00, NULL, 2603.30, 0);
INSERT INTO `temp_userinfo` VALUES (770, 12016, 66.90, 290.90, 1000.00, NULL, 1290.90, 0);
INSERT INTO `temp_userinfo` VALUES (771, 12019, 99.00, -1970.50, 2098.00, NULL, 127.50, 0);
INSERT INTO `temp_userinfo` VALUES (772, 12021, 23.40, -5329.40, 5000.00, NULL, -329.40, 1);
INSERT INTO `temp_userinfo` VALUES (777, 12049, 11372.40, -6201.60, 23174.00, NULL, 16972.40, 0);
INSERT INTO `temp_userinfo` VALUES (780, 12086, 82.10, -1417.90, 1700.00, NULL, 282.10, 0);
INSERT INTO `temp_userinfo` VALUES (782, 12125, 33.80, -4193.40, 4098.00, NULL, -95.40, 1);
INSERT INTO `temp_userinfo` VALUES (783, 12155, 1704.60, 1204.60, 1100.00, NULL, 2304.60, 0);
INSERT INTO `temp_userinfo` VALUES (790, 12272, 0.50, 0.50, 600.00, NULL, 600.50, 0);
INSERT INTO `temp_userinfo` VALUES (800, 12448, 0.00, -228.00, 800.00, NULL, 572.00, 0);
INSERT INTO `temp_userinfo` VALUES (801, 12468, 0.80, -147.20, 200.00, NULL, 52.80, 0);
INSERT INTO `temp_userinfo` VALUES (808, 12559, 39.90, -4225.60, 4194.00, NULL, -31.60, 1);
INSERT INTO `temp_userinfo` VALUES (809, 12562, 25.80, -5017.20, 4700.00, NULL, -317.20, 1);
INSERT INTO `temp_userinfo` VALUES (810, 12567, 7724.40, 7309.20, 300.00, NULL, 7609.20, 0);
INSERT INTO `temp_userinfo` VALUES (813, 12587, 77.50, -2265.50, 2000.00, NULL, -265.50, 1);
INSERT INTO `temp_userinfo` VALUES (815, 12622, 26.80, -1745.60, 1696.00, NULL, -49.60, 1);
INSERT INTO `temp_userinfo` VALUES (820, 12700, 33.10, -2644.90, 2392.00, NULL, -252.90, 1);
INSERT INTO `temp_userinfo` VALUES (828, 12826, 457.00, -1386.00, 1500.00, NULL, 114.00, 0);
INSERT INTO `temp_userinfo` VALUES (829, 12844, 1.20, 2139.20, 500.00, NULL, 2639.20, 0);
INSERT INTO `temp_userinfo` VALUES (833, 12915, 12122.60, 4768.60, 5296.00, NULL, 10064.60, 0);
INSERT INTO `temp_userinfo` VALUES (836, 12960, 76.00, -56499.00, 48000.00, NULL, -8499.00, 1);
INSERT INTO `temp_userinfo` VALUES (839, 13011, 43.00, 43.00, 200.00, NULL, 243.00, 0);
INSERT INTO `temp_userinfo` VALUES (845, 13036, 0.50, 71.50, 100.00, NULL, 171.50, 0);
INSERT INTO `temp_userinfo` VALUES (850, 13131, 291.20, -2200.00, 1698.00, NULL, -502.00, 1);
INSERT INTO `temp_userinfo` VALUES (851, 13137, 9857.50, -142.50, 11000.00, NULL, 10857.50, 0);
INSERT INTO `temp_userinfo` VALUES (853, 13150, 694.40, 44.40, 700.00, NULL, 744.40, 0);
INSERT INTO `temp_userinfo` VALUES (854, 13177, 0.00, -57.00, 100.00, NULL, 43.00, 0);
INSERT INTO `temp_userinfo` VALUES (856, 13190, 184.00, -314.00, 598.00, NULL, 284.00, 0);
INSERT INTO `temp_userinfo` VALUES (859, 13220, 69.50, -998.50, 596.00, NULL, -402.50, 1);
INSERT INTO `temp_userinfo` VALUES (861, 13237, 0.00, -727.00, 800.00, NULL, 73.00, 0);
INSERT INTO `temp_userinfo` VALUES (863, 13262, 4.50, -85.50, 100.00, NULL, 14.50, 0);
INSERT INTO `temp_userinfo` VALUES (864, 13265, 4230.60, 4230.60, 500.00, NULL, 4730.60, 0);
INSERT INTO `temp_userinfo` VALUES (866, 13277, 913.00, -187.50, 1900.00, NULL, 1712.50, 0);
INSERT INTO `temp_userinfo` VALUES (870, 13343, 688.90, 19.40, 598.00, NULL, 617.40, 0);
INSERT INTO `temp_userinfo` VALUES (872, 13359, 71.90, -352.10, 500.00, NULL, 147.90, 0);
INSERT INTO `temp_userinfo` VALUES (875, 13387, 2509.60, 697.10, 1400.00, NULL, 2097.10, 0);
INSERT INTO `temp_userinfo` VALUES (877, 13402, 40.50, -13532.00, 11000.00, NULL, -2532.00, 1);
INSERT INTO `temp_userinfo` VALUES (878, 13410, 17083.50, 8912.00, 8000.00, NULL, 16912.00, 0);
INSERT INTO `temp_userinfo` VALUES (883, 13453, 392.40, -548.60, 898.00, NULL, 349.40, 0);
INSERT INTO `temp_userinfo` VALUES (884, 13457, 0.50, -28.50, 100.00, NULL, 71.50, 0);
INSERT INTO `temp_userinfo` VALUES (886, 13470, 1046.40, 521.90, 696.00, NULL, 1217.90, 0);
INSERT INTO `temp_userinfo` VALUES (890, 13540, 5479.50, 1480.50, 5000.00, NULL, 6480.50, 0);
INSERT INTO `temp_userinfo` VALUES (894, 13572, 1576.70, 816.70, 400.00, NULL, 1216.70, 0);
INSERT INTO `temp_userinfo` VALUES (901, 13697, 37.20, -2599.80, 2694.00, NULL, 94.20, 0);
INSERT INTO `temp_userinfo` VALUES (902, 13703, 161.50, 71.50, 100.00, NULL, 171.50, 0);
INSERT INTO `temp_userinfo` VALUES (903, 13711, 74.40, -223.60, 398.00, NULL, 174.40, 0);
INSERT INTO `temp_userinfo` VALUES (908, 13811, 13.50, -13701.50, 12000.00, NULL, -1701.50, 1);
INSERT INTO `temp_userinfo` VALUES (910, 13840, 0.00, -4910.00, 5000.00, NULL, 90.00, 0);
INSERT INTO `temp_userinfo` VALUES (911, 13854, 98.10, -278.30, 300.00, NULL, 21.70, 0);
INSERT INTO `temp_userinfo` VALUES (914, 13906, 495.00, -6178.00, 9000.00, NULL, 2822.00, 0);
INSERT INTO `temp_userinfo` VALUES (920, 13978, 2169.60, -2967.40, 5194.00, NULL, 2226.60, 0);
INSERT INTO `temp_userinfo` VALUES (921, 13988, 991.10, 248.10, 600.00, NULL, 848.10, 0);
INSERT INTO `temp_userinfo` VALUES (922, 14007, 6177.40, -18967.60, 20000.00, NULL, 1032.40, 0);
INSERT INTO `temp_userinfo` VALUES (931, 14104, 960.90, 261.40, 600.00, NULL, 861.40, 0);
INSERT INTO `temp_userinfo` VALUES (935, 14133, 215.00, -285.00, 800.00, NULL, 515.00, 0);
INSERT INTO `temp_userinfo` VALUES (936, 14134, 0.00, -82.00, 7000.00, NULL, 6918.00, 0);
INSERT INTO `temp_userinfo` VALUES (940, 14155, 1621.00, -1751.00, 2000.00, NULL, 249.00, 0);
INSERT INTO `temp_userinfo` VALUES (942, 14175, 86.50, -1056.50, 800.00, NULL, -256.50, 1);
INSERT INTO `temp_userinfo` VALUES (950, 14269, 86.50, 143.50, 100.00, NULL, 243.50, 0);
INSERT INTO `temp_userinfo` VALUES (955, 14298, 14.50, -85.50, 200.00, NULL, 114.50, 0);
INSERT INTO `temp_userinfo` VALUES (956, 14378, 1571.00, 1199.50, 200.00, NULL, 1399.50, 0);
INSERT INTO `temp_userinfo` VALUES (961, 14447, 511.90, -177.60, 600.00, NULL, 422.40, 0);
INSERT INTO `temp_userinfo` VALUES (966, 14550, 2.50, -1283.50, 600.00, NULL, -683.50, 1);
INSERT INTO `temp_userinfo` VALUES (969, 14682, 0.00, -57.00, 100.00, NULL, 43.00, 0);
INSERT INTO `temp_userinfo` VALUES (972, 14753, 7966.00, 7694.50, 400.00, NULL, 8094.50, 0);
INSERT INTO `temp_userinfo` VALUES (974, 14787, 63.50, -908.00, 800.00, NULL, -108.00, 1);
INSERT INTO `temp_userinfo` VALUES (978, 14867, 0.50, 910.50, 100.00, NULL, 1010.50, 0);
INSERT INTO `temp_userinfo` VALUES (980, 14893, 689.40, -1555.40, 2392.00, NULL, 836.60, 0);
INSERT INTO `temp_userinfo` VALUES (981, 14897, 14.50, -57.00, 100.00, NULL, 43.00, 0);
INSERT INTO `temp_userinfo` VALUES (982, 14902, 87.50, -2427.00, 2400.00, NULL, -27.00, 1);
INSERT INTO `temp_userinfo` VALUES (983, 14918, 95.00, -1199.00, 1594.00, NULL, 395.00, 0);
INSERT INTO `temp_userinfo` VALUES (985, 14922, 17.50, -270.50, 498.00, NULL, 227.50, 0);
INSERT INTO `temp_userinfo` VALUES (986, 14923, 44.60, -1136.70, 1000.00, NULL, -136.70, 1);
INSERT INTO `temp_userinfo` VALUES (989, 14985, 986.00, -11739.50, 14082.00, NULL, 2342.50, 0);
INSERT INTO `temp_userinfo` VALUES (996, 15098, 13.50, -4344.00, 3500.00, NULL, -844.00, 1);
INSERT INTO `temp_userinfo` VALUES (997, 15103, 0.00, 71.50, 100.00, NULL, 171.50, 0);
INSERT INTO `temp_userinfo` VALUES (998, 15106, 752.70, -484.30, 2894.00, NULL, 2409.70, 0);
INSERT INTO `temp_userinfo` VALUES (1002, 15158, 914.00, -984.50, 1498.00, NULL, 513.50, 0);
INSERT INTO `temp_userinfo` VALUES (1003, 15171, 10252.90, 8595.40, 1300.00, NULL, 9895.40, 0);
INSERT INTO `temp_userinfo` VALUES (1009, 15261, 240.40, -36.00, 200.00, NULL, 164.00, 0);
INSERT INTO `temp_userinfo` VALUES (1012, 15308, 1641.50, -228.00, 1898.00, NULL, 1670.00, 0);
INSERT INTO `temp_userinfo` VALUES (1015, 15361, 200.00, -256.50, 598.00, NULL, 341.50, 0);
INSERT INTO `temp_userinfo` VALUES (1018, 15407, 12345.70, 11416.70, 400.00, NULL, 11816.70, 0);
INSERT INTO `temp_userinfo` VALUES (1019, 15437, 14.50, -885.50, 1000.00, NULL, 114.50, 0);
INSERT INTO `temp_userinfo` VALUES (1024, 15581, 71.50, -228.50, 600.00, NULL, 371.50, 0);
INSERT INTO `temp_userinfo` VALUES (1030, 15734, 99.30, -368.20, 396.00, NULL, 27.80, 0);
INSERT INTO `temp_userinfo` VALUES (1032, 15752, 87.00, -284.50, 300.00, NULL, 15.50, 0);
INSERT INTO `temp_userinfo` VALUES (1037, 15786, 86.50, -413.50, 1000.00, NULL, 586.50, 0);
INSERT INTO `temp_userinfo` VALUES (1040, 15856, 7245.00, 5773.50, 1300.00, NULL, 7073.50, 0);
INSERT INTO `temp_userinfo` VALUES (1041, 15869, 0.00, 71.50, 100.00, NULL, 171.50, 0);
INSERT INTO `temp_userinfo` VALUES (1042, 15874, 0.00, 29.00, 200.00, NULL, 229.00, 0);
INSERT INTO `temp_userinfo` VALUES (1049, 15968, 0.50, -28.50, 100.00, NULL, 71.50, 0);
INSERT INTO `temp_userinfo` VALUES (1051, 16007, 69.50, 69.50, 100.00, NULL, 169.50, 0);
INSERT INTO `temp_userinfo` VALUES (1054, 16049, 0.00, -100.00, 200.00, NULL, 100.00, 0);
INSERT INTO `temp_userinfo` VALUES (1062, 16106, 91.00, -16624.00, 15000.00, NULL, -1624.00, 1);
INSERT INTO `temp_userinfo` VALUES (1076, 16269, 1318.00, 379.00, 796.00, NULL, 1175.00, 0);
INSERT INTO `temp_userinfo` VALUES (1082, 16349, 13402.10, 9768.60, 1600.00, NULL, 11368.60, 0);
INSERT INTO `temp_userinfo` VALUES (1086, 16445, 2979.30, 2407.80, 500.00, NULL, 2907.80, 0);
INSERT INTO `temp_userinfo` VALUES (1088, 16481, 262.30, -123.70, 200.00, NULL, 76.30, 0);
INSERT INTO `temp_userinfo` VALUES (1094, 16571, 3.10, -425.90, 500.00, NULL, 74.10, 0);
INSERT INTO `temp_userinfo` VALUES (1098, 16655, 0.50, -285.50, 300.00, NULL, 14.50, 0);
INSERT INTO `temp_userinfo` VALUES (1099, 16666, 912.50, -457.00, 1298.00, NULL, 841.00, 0);
INSERT INTO `temp_userinfo` VALUES (1106, 16827, 615.90, 417.90, 298.00, NULL, 715.90, 0);
INSERT INTO `temp_userinfo` VALUES (1107, 16835, 447.90, -223.60, 600.00, NULL, 376.40, 0);
INSERT INTO `temp_userinfo` VALUES (1108, 16851, 2660.10, 2488.60, 100.00, NULL, 2588.60, 0);
INSERT INTO `temp_userinfo` VALUES (1112, 16890, 3183.60, 2612.10, 500.00, NULL, 3112.10, 0);
INSERT INTO `temp_userinfo` VALUES (1116, 16935, 35.80, -2334.60, 2394.00, NULL, 59.40, 0);
INSERT INTO `temp_userinfo` VALUES (1118, 17057, 0.00, 186.00, 100.00, NULL, 286.00, 0);
INSERT INTO `temp_userinfo` VALUES (1121, 17206, 98.00, -302.00, 500.00, NULL, 198.00, 0);
INSERT INTO `temp_userinfo` VALUES (1122, 17214, 2527.00, 1927.00, 900.00, NULL, 2827.00, 0);
INSERT INTO `temp_userinfo` VALUES (1123, 17239, 37.00, -163.00, 700.00, NULL, 537.00, 0);
INSERT INTO `temp_userinfo` VALUES (1137, 17476, 102.00, -1169.50, 1100.00, NULL, -69.50, 1);
INSERT INTO `temp_userinfo` VALUES (1139, 17491, 92.00, -302.00, 1194.00, NULL, 892.00, 0);
INSERT INTO `temp_userinfo` VALUES (1140, 17494, 305.40, 133.90, 100.00, NULL, 233.90, 0);
INSERT INTO `temp_userinfo` VALUES (1143, 17508, 261.90, -1707.60, 2098.00, NULL, 390.40, 0);
INSERT INTO `temp_userinfo` VALUES (1146, 17533, 49.50, -2422.00, 2300.00, NULL, -122.00, 1);
INSERT INTO `temp_userinfo` VALUES (1158, 17611, 60.60, -3036.40, 2782.00, NULL, -254.40, 1);
INSERT INTO `temp_userinfo` VALUES (1162, 17644, 1208.70, 339.70, 798.00, NULL, 1137.70, 0);
INSERT INTO `temp_userinfo` VALUES (1165, 17689, 3218.60, 2675.60, 1100.00, NULL, 3775.60, 0);
INSERT INTO `temp_userinfo` VALUES (1166, 17702, 33.80, -637.70, 500.00, NULL, -137.70, 1);
INSERT INTO `temp_userinfo` VALUES (1170, 17799, 98.00, -300.00, 498.00, NULL, 198.00, 0);
INSERT INTO `temp_userinfo` VALUES (1177, 17930, 8.00, -759.50, 896.00, NULL, 136.50, 0);
INSERT INTO `temp_userinfo` VALUES (1178, 17949, 823.40, -1663.50, 2100.00, NULL, 436.50, 0);
INSERT INTO `temp_userinfo` VALUES (1193, 18051, 5.10, -937.90, 600.00, NULL, -337.90, 1);
INSERT INTO `temp_userinfo` VALUES (1201, 18158, 520.40, -122.60, 500.00, NULL, 377.40, 0);
INSERT INTO `temp_userinfo` VALUES (1209, 18258, 99.30, -1411.20, 1496.00, NULL, 84.80, 0);
INSERT INTO `temp_userinfo` VALUES (1212, 18277, 2095.30, 1852.30, 300.00, NULL, 2152.30, 0);
INSERT INTO `temp_userinfo` VALUES (1215, 18291, 567.50, -359.50, 698.00, NULL, 338.50, 0);
INSERT INTO `temp_userinfo` VALUES (1216, 18340, 80.50, -685.00, 894.00, NULL, 209.00, 0);
INSERT INTO `temp_userinfo` VALUES (1221, 18414, 1839.90, 1639.90, 300.00, NULL, 1939.90, 0);
INSERT INTO `temp_userinfo` VALUES (1227, 18462, 2211.80, 1827.80, 498.00, NULL, 2325.80, 0);
INSERT INTO `temp_userinfo` VALUES (1228, 18473, 0.00, -487.50, 500.00, NULL, 12.50, 0);
INSERT INTO `temp_userinfo` VALUES (1232, 18520, 72.50, -999.00, 900.00, NULL, -99.00, 1);
INSERT INTO `temp_userinfo` VALUES (1244, 18730, 42.50, -55.50, 298.00, NULL, 242.50, 0);
INSERT INTO `temp_userinfo` VALUES (1247, 18748, 44.70, -1002.10, 894.00, NULL, -108.10, 1);
INSERT INTO `temp_userinfo` VALUES (1248, 18758, 74.90, -566.10, 498.00, NULL, -68.10, 1);
INSERT INTO `temp_userinfo` VALUES (1252, 18799, 29.00, -1814.00, 1500.00, NULL, -314.00, 1);
INSERT INTO `temp_userinfo` VALUES (1259, 18909, 71.00, -428.00, 500.00, NULL, 72.00, 0);
INSERT INTO `temp_userinfo` VALUES (1271, 19119, 98.00, -100.00, 298.00, NULL, 198.00, 0);
INSERT INTO `temp_userinfo` VALUES (1273, 19124, 17.50, -6082.50, 500.00, NULL, -5582.50, 1);
INSERT INTO `temp_userinfo` VALUES (1292, 19341, 673.10, -851.90, 100.00, NULL, -751.90, 1);
INSERT INTO `temp_userinfo` VALUES (1302, 19480, 3.10, -971.30, 998.00, NULL, 26.70, 0);
INSERT INTO `temp_userinfo` VALUES (1306, 19539, 37.80, -162.20, 300.00, NULL, 137.80, 0);
INSERT INTO `temp_userinfo` VALUES (1314, 19644, 84.30, -1159.60, 1196.00, NULL, 36.40, 0);
INSERT INTO `temp_userinfo` VALUES (1330, 19902, 3746.00, 1656.00, 2290.00, NULL, 3946.00, 0);
INSERT INTO `temp_userinfo` VALUES (1333, 19938, 89.30, -151.70, 498.00, NULL, 346.30, 0);
INSERT INTO `temp_userinfo` VALUES (1340, 20038, 2736.20, 1595.20, 998.00, NULL, 2593.20, 0);
INSERT INTO `temp_userinfo` VALUES (1352, 20207, 33.90, -166.10, 300.00, NULL, 133.90, 0);
INSERT INTO `temp_userinfo` VALUES (1363, 20352, 18.70, -677.30, 796.00, NULL, 118.70, 0);
INSERT INTO `temp_userinfo` VALUES (1371, 20435, 459.60, -16.80, 400.00, NULL, 383.20, 0);
INSERT INTO `temp_userinfo` VALUES (1383, 20650, 168.50, -1713.50, 1696.00, NULL, -17.50, 1);
INSERT INTO `temp_userinfo` VALUES (1387, 20688, 172.00, -28.00, 300.00, NULL, 272.00, 0);
INSERT INTO `temp_userinfo` VALUES (1393, 20770, 3174.90, 2460.40, 600.00, NULL, 3060.40, 0);
INSERT INTO `temp_userinfo` VALUES (1411, 20997, 98.50, -271.00, 498.00, NULL, 227.00, 0);
INSERT INTO `temp_userinfo` VALUES (1415, 21051, 54.30, -798.50, 900.00, NULL, 101.50, 0);
INSERT INTO `temp_userinfo` VALUES (1435, 21482, 5788.20, 4816.70, 900.00, NULL, 5716.70, 0);
INSERT INTO `temp_userinfo` VALUES (1439, 21617, 1897.30, 1039.80, 500.00, NULL, 1539.80, 0);
INSERT INTO `temp_userinfo` VALUES (1440, 21627, 186.00, 286.00, 100.00, NULL, 386.00, 0);
INSERT INTO `temp_userinfo` VALUES (1454, 21802, 44.20, -423.30, 496.00, NULL, 72.70, 0);
INSERT INTO `temp_userinfo` VALUES (1463, 21886, 5341.80, 5389.00, 300.00, NULL, 5689.00, 0);
INSERT INTO `temp_userinfo` VALUES (1469, 21952, 3824.80, 3167.30, 400.00, NULL, 3567.30, 0);
INSERT INTO `temp_userinfo` VALUES (1481, 22189, 584.00, 114.50, 398.00, NULL, 512.50, 0);
INSERT INTO `temp_userinfo` VALUES (1485, 22236, 25.10, -568.90, 794.00, NULL, 225.10, 0);
INSERT INTO `temp_userinfo` VALUES (1492, 22316, 93.50, -400.50, 594.00, NULL, 193.50, 0);
INSERT INTO `temp_userinfo` VALUES (1494, 22324, 14095.30, 13382.80, 598.00, NULL, 13980.80, 0);
INSERT INTO `temp_userinfo` VALUES (1496, 22359, 90.10, -622.40, 598.00, NULL, -24.40, 1);
INSERT INTO `temp_userinfo` VALUES (1503, 22468, 0.00, -200.00, 498.00, NULL, 298.00, 0);
INSERT INTO `temp_userinfo` VALUES (1512, 22581, 52.00, -4449.50, 3000.00, NULL, -1449.50, 1);
INSERT INTO `temp_userinfo` VALUES (1515, 22635, 50.40, -5609.10, 5688.00, NULL, 78.90, 0);
INSERT INTO `temp_userinfo` VALUES (1542, 23114, 873.70, -95.80, 898.00, NULL, 802.20, 0);
INSERT INTO `temp_userinfo` VALUES (1547, 23313, 412.50, -128.50, 698.00, NULL, 569.50, 0);
INSERT INTO `temp_userinfo` VALUES (1559, 23472, 76.40, -100.00, 100.00, NULL, 0.00, 0);
INSERT INTO `temp_userinfo` VALUES (1570, 23686, 10.60, -750.90, 1090.00, NULL, 339.10, 0);
INSERT INTO `temp_userinfo` VALUES (1572, 23755, 1528.40, 677.60, 698.00, NULL, 1375.60, 0);
INSERT INTO `temp_userinfo` VALUES (1573, 23794, 59.40, -238.60, 398.00, NULL, 159.40, 0);
INSERT INTO `temp_userinfo` VALUES (1576, 23807, 89.00, -3170.50, 3288.00, NULL, 117.50, 0);
INSERT INTO `temp_userinfo` VALUES (1584, 23919, 62.90, -108.60, 100.00, NULL, -8.60, 1);
INSERT INTO `temp_userinfo` VALUES (1606, 24267, 677.10, -1155.90, 1990.00, NULL, 834.10, 0);
INSERT INTO `temp_userinfo` VALUES (1609, 24322, 47.00, -429.40, 500.00, NULL, 70.60, 0);
INSERT INTO `temp_userinfo` VALUES (1622, 24671, 88.70, -1711.80, 1586.00, NULL, -125.80, 1);
INSERT INTO `temp_userinfo` VALUES (1624, 24701, 41.50, 43.50, 198.00, NULL, 241.50, 0);
INSERT INTO `temp_userinfo` VALUES (1625, 24761, 94.50, 100.50, 794.00, NULL, 894.50, 0);
INSERT INTO `temp_userinfo` VALUES (1627, 24825, 67.50, -128.50, 396.00, NULL, 267.50, 0);
INSERT INTO `temp_userinfo` VALUES (1634, 24973, 1371.20, 753.80, 398.00, NULL, 1151.80, 0);
INSERT INTO `temp_userinfo` VALUES (1635, 24975, 80.00, -487.50, 596.00, NULL, 108.50, 0);
INSERT INTO `temp_userinfo` VALUES (1640, 25080, 45.90, -223.60, 198.00, NULL, -25.60, 1);
INSERT INTO `temp_userinfo` VALUES (1649, 25405, 6.30, -289.70, 396.00, NULL, 106.30, 0);
INSERT INTO `temp_userinfo` VALUES (1653, 25494, 269.50, -200.00, 398.00, NULL, 198.00, 0);
INSERT INTO `temp_userinfo` VALUES (1706, 26886, 0.90, -109.10, 198.00, NULL, 88.90, 0);

-- ----------------------------
-- Table structure for temp_userinfo1
-- ----------------------------
DROP TABLE IF EXISTS `temp_userinfo1`;
CREATE TABLE `temp_userinfo1`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` int(10) NULL DEFAULT NULL,
  `balance` decimal(10, 2) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of temp_userinfo1
-- ----------------------------

-- ----------------------------
-- Table structure for wp_accountinfo
-- ----------------------------
DROP TABLE IF EXISTS `wp_accountinfo`;
CREATE TABLE `wp_accountinfo`  (
  `aid` int(50) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `balance` double(24, 2) NULL DEFAULT 0.00 COMMENT '账号余额',
  `frozen` double(255, 0) NULL DEFAULT NULL COMMENT '冻结金额',
  `recharge_total` decimal(10, 2) NULL COMMENT '用户累计充值金额',
  `pwd` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '交易密码',
  `tempdate` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`aid`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 12 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_accountinfo
-- ----------------------------
INSERT INTO `wp_accountinfo` VALUES (1, 2, 5000.57, NULL, 0.00, NULL, '2025-01-07 15:23:58');
INSERT INTO `wp_accountinfo` VALUES (2, 3, 105551.63, 5000, 0.00, 'e10adc3949ba59abbe56e057f20f883e', '2025-01-07 15:23:58');
INSERT INTO `wp_accountinfo` VALUES (3, 4, 29.37, NULL, 0.00, NULL, '2025-01-07 15:23:58');
INSERT INTO `wp_accountinfo` VALUES (4, 0, 0.00, NULL, 0.00, NULL, '2017-07-17 11:49:52');
INSERT INTO `wp_accountinfo` VALUES (5, 5, -189.00, NULL, 0.00, NULL, '2017-07-27 13:17:03');
INSERT INTO `wp_accountinfo` VALUES (6, 6, 330.20, NULL, 0.00, NULL, '2025-01-07 15:50:38');
INSERT INTO `wp_accountinfo` VALUES (7, 7, 5233.00, NULL, 0.00, NULL, '2017-07-18 15:51:01');
INSERT INTO `wp_accountinfo` VALUES (8, 8, 0.00, NULL, 0.00, NULL, '2017-07-27 12:32:04');
INSERT INTO `wp_accountinfo` VALUES (9, 9, 0.00, NULL, 0.00, NULL, '2017-07-28 14:06:05');
INSERT INTO `wp_accountinfo` VALUES (10, 10, 0.00, NULL, 0.00, NULL, '2017-07-28 14:08:23');
INSERT INTO `wp_accountinfo` VALUES (11, 11, 0.00, NULL, 0.00, NULL, '2017-07-28 14:10:28');

-- ----------------------------
-- Table structure for wp_admin_category
-- ----------------------------
DROP TABLE IF EXISTS `wp_admin_category`;
CREATE TABLE `wp_admin_category`  (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `cname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '产品名称',
  `state` tinyint(2) NOT NULL DEFAULT 1,
  `pid` int(11) NOT NULL,
  `allow_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `class` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '栏目的class',
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '跳转地址',
  PRIMARY KEY (`cid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 47 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_admin_category
-- ----------------------------
INSERT INTO `wp_admin_category` VALUES (1, '内容管理', 1, 0, '1,2,3,4', 'icon-edit', 'news');
INSERT INTO `wp_admin_category` VALUES (2, '栏目管理', 1, 1, '1,2', NULL, '/admin/news/typelist.html');
INSERT INTO `wp_admin_category` VALUES (3, '文章管理', 1, 1, '1,2', NULL, '/admin/news/newslist.html');
INSERT INTO `wp_admin_category` VALUES (4, '产品管理', 1, 0, '1,2,3,4', 'icon-calendar-empty', 'goods');
INSERT INTO `wp_admin_category` VALUES (5, '产品列表', 1, 4, '1,3,4', NULL, '/admin/goods/glist.html');
INSERT INTO `wp_admin_category` VALUES (6, '订单管理', 1, 0, NULL, 'icon-th-large', 'order');
INSERT INTO `wp_admin_category` VALUES (7, '成交明细', 1, 6, NULL, NULL, '/admin/order/tlist.html');
INSERT INTO `wp_admin_category` VALUES (8, '当前持仓', 1, 6, NULL, NULL, '/admin/order/nowlist.html');
INSERT INTO `wp_admin_category` VALUES (9, '特会订单', 1, 6, NULL, NULL, '/admin/order/specil.html');
INSERT INTO `wp_admin_category` VALUES (10, '客户管理', 1, 0, NULL, 'icon-group', 'user');
INSERT INTO `wp_admin_category` VALUES (11, '客户列表', 1, 10, NULL, NULL, '/admin/user/ulist.html');
INSERT INTO `wp_admin_category` VALUES (12, '手动充值', 1, 10, NULL, NULL, '/admin/user/addmoney.html');
INSERT INTO `wp_admin_category` VALUES (13, '代理商管理', 1, 0, NULL, 'icon-group', 'leaguer');
INSERT INTO `wp_admin_category` VALUES (14, '代理商列表', 1, 13, NULL, NULL, '/admin/leaguer/mlist.html');
INSERT INTO `wp_admin_category` VALUES (15, '添加代理商', 1, 13, NULL, NULL, '/admin/leaguer/madd.html');
INSERT INTO `wp_admin_category` VALUES (16, '会员单位', 1, 0, NULL, 'icon-sitemap', 'menber');
INSERT INTO `wp_admin_category` VALUES (17, '会员列表', 1, 16, NULL, NULL, '/admin/menber/mlist.html');
INSERT INTO `wp_admin_category` VALUES (18, '添加会员', 1, 16, NULL, NULL, '/admin/menber/madd.html');
INSERT INTO `wp_admin_category` VALUES (19, '特会管理', 1, 0, NULL, 'icon-sitemap', 'tehui');
INSERT INTO `wp_admin_category` VALUES (20, '特会列表', 1, 19, NULL, NULL, '/admin/tehui/mlist.html');
INSERT INTO `wp_admin_category` VALUES (21, '添加特会', 1, 19, NULL, NULL, '/admin/tehui/madd.html');
INSERT INTO `wp_admin_category` VALUES (22, '运营中心', 1, 0, NULL, 'icon-sitemap', 'operation');
INSERT INTO `wp_admin_category` VALUES (23, '运营中心列表', 1, 22, NULL, NULL, '/admin/operation/mlist.html');
INSERT INTO `wp_admin_category` VALUES (24, '添加运营中心', 1, 22, NULL, NULL, '/admin/operation/madd.html');
INSERT INTO `wp_admin_category` VALUES (25, '权限管理', 1, 0, NULL, 'icon-group', 'authority');
INSERT INTO `wp_admin_category` VALUES (26, '权限分组', 1, 25, NULL, NULL, '/admin/authority/index.html');
INSERT INTO `wp_admin_category` VALUES (27, '系统管理员', 1, 0, NULL, 'icon-code-fork', 'super');
INSERT INTO `wp_admin_category` VALUES (28, '添加管理员', 1, 27, NULL, NULL, '/admin/super/sadd.html');
INSERT INTO `wp_admin_category` VALUES (29, '管理员列表', 1, 27, NULL, NULL, '/admin/super/slist.html');
INSERT INTO `wp_admin_category` VALUES (30, '财务管理', 1, 0, NULL, 'icon-money', 'finance');
INSERT INTO `wp_admin_category` VALUES (31, '充值记录', 1, 30, NULL, NULL, '/admin/finance/recharge/type/充值.html');
INSERT INTO `wp_admin_category` VALUES (32, '提现记录', 1, 30, NULL, NULL, '/admin/finance/recharge/type/提现.html');
INSERT INTO `wp_admin_category` VALUES (33, '入金设置', 1, 30, NULL, NULL, '/admin/finance/financial_setting/type/入金.html');
INSERT INTO `wp_admin_category` VALUES (34, '出金设置', 1, 30, NULL, NULL, '/admin/finance/financial_setting/type/出金.html');
INSERT INTO `wp_admin_category` VALUES (35, '系统设置', 1, 0, NULL, 'icon-cog', 'system');
INSERT INTO `wp_admin_category` VALUES (36, '基本设置', 1, 35, NULL, NULL, '/admin/system/esystem.html');
INSERT INTO `wp_admin_category` VALUES (37, '数据备份', 1, 35, NULL, NULL, '/admin/system/backupdb.html');
INSERT INTO `wp_admin_category` VALUES (38, '退出系统', 1, 35, NULL, NULL, '/admin/system/signinout');
INSERT INTO `wp_admin_category` VALUES (39, '日志管理', 1, 0, NULL, 'icon-comments', 'journal');
INSERT INTO `wp_admin_category` VALUES (40, '日志信息', 1, 39, NULL, NULL, '/admin/journal/userlog.html');
INSERT INTO `wp_admin_category` VALUES (41, '资金流水', 1, 0, NULL, 'icon-comments', 'flow');
INSERT INTO `wp_admin_category` VALUES (42, '流水记录', 1, 41, NULL, NULL, '/admin/flow/money_flow.html');
INSERT INTO `wp_admin_category` VALUES (43, '全民经纪人', 1, 0, NULL, 'icon-th-large', 'agent');
INSERT INTO `wp_admin_category` VALUES (44, '经纪人申请列表', 0, 43, NULL, NULL, '/admin/agent/apply_agentlist.html');
INSERT INTO `wp_admin_category` VALUES (45, '经纪人列表', 1, 43, NULL, NULL, '/admin/agent/agentlist.html');
INSERT INTO `wp_admin_category` VALUES (46, '佣金流水', 1, 43, NULL, NULL, '/admin/agent/flow.html');

-- ----------------------------
-- Table structure for wp_agent
-- ----------------------------
DROP TABLE IF EXISTS `wp_agent`;
CREATE TABLE `wp_agent`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL COMMENT '订单id',
  `user_id` int(11) NOT NULL COMMENT '领取人id',
  `profit` decimal(12, 2) NOT NULL COMMENT '佣金收益',
  `fee` decimal(12, 2) NOT NULL COMMENT '总订单金额',
  `rate` decimal(12, 2) NOT NULL COMMENT '佣金比例',
  `class` tinyint(1) NOT NULL COMMENT '用户级别',
  `status` tinyint(1) NOT NULL COMMENT '1已经发放  2未发放',
  `purchaser_id` int(11) NULL DEFAULT NULL COMMENT '购买人id',
  `create_time` int(1) NULL DEFAULT NULL,
  `tempdate` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE,
  INDEX `purchaser_id`(`purchaser_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of wp_agent
-- ----------------------------

-- ----------------------------
-- Table structure for wp_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `wp_auth_group`;
CREATE TABLE `wp_auth_group`  (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `rules` char(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 25 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of wp_auth_group
-- ----------------------------
INSERT INTO `wp_auth_group` VALUES (1, '超级管理员', 1, '');
INSERT INTO `wp_auth_group` VALUES (16, '内容管理', 1, '1,2,48,3,4,5,6,7,8,9,41');
INSERT INTO `wp_auth_group` VALUES (17, '订单管理', 1, '1,2,48,3,4,13,14,15');
INSERT INTO `wp_auth_group` VALUES (18, '产品管理', 1, '10,11,12,1,2,48');
INSERT INTO `wp_auth_group` VALUES (19, '客户管理', 1, '18,20,15,16,17,1,2,48');
INSERT INTO `wp_auth_group` VALUES (20, '经纪人管理', 1, '23,24,25,22,1,2,48');
INSERT INTO `wp_auth_group` VALUES (21, '会员单位管理', 1, '28,26,27,1,2,48');
INSERT INTO `wp_auth_group` VALUES (22, '系统管理员', 1, '30,31,29,1,2,48');
INSERT INTO `wp_auth_group` VALUES (23, '1111', 1, '7,8,9,3,4,5,6,1,2,48');
INSERT INTO `wp_auth_group` VALUES (24, '财务管理', 1, '1,48,41');

-- ----------------------------
-- Table structure for wp_auth_group_access
-- ----------------------------
DROP TABLE IF EXISTS `wp_auth_group_access`;
CREATE TABLE `wp_auth_group_access`  (
  `uid` mediumint(8) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL,
  UNIQUE INDEX `uid_group_id`(`uid`, `group_id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `group_id`(`group_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of wp_auth_group_access
-- ----------------------------
INSERT INTO `wp_auth_group_access` VALUES (1, 1);
INSERT INTO `wp_auth_group_access` VALUES (1978, 1);
INSERT INTO `wp_auth_group_access` VALUES (2192, 27);
INSERT INTO `wp_auth_group_access` VALUES (3006, 1);
INSERT INTO `wp_auth_group_access` VALUES (3006, 24);
INSERT INTO `wp_auth_group_access` VALUES (3029, 1);
INSERT INTO `wp_auth_group_access` VALUES (3685, 17);
INSERT INTO `wp_auth_group_access` VALUES (35450, 24);

-- ----------------------------
-- Table structure for wp_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `wp_auth_rule`;
CREATE TABLE `wp_auth_rule`  (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` char(80) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `title` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0是菜单栏，1不是菜单栏',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `condition` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `name`(`name`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 56 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of wp_auth_rule
-- ----------------------------
INSERT INTO `wp_auth_rule` VALUES (1, 'Admin/User/signin', '登录', 1, 1, '1');
INSERT INTO `wp_auth_rule` VALUES (2, 'Admin/Index/index', '系统首页', 1, 1, '1');
INSERT INTO `wp_auth_rule` VALUES (3, 'Admin/News/typelist', '栏目管理', 1, 1, '2');
INSERT INTO `wp_auth_rule` VALUES (4, 'Admin/News/typeadd', '添加栏目', 1, 1, '2');
INSERT INTO `wp_auth_rule` VALUES (5, 'Admin/News/tedit', '编辑栏目', 1, 1, '2');
INSERT INTO `wp_auth_rule` VALUES (6, 'Admin/News/newtypedel', '删除栏目', 1, 1, '2');
INSERT INTO `wp_auth_rule` VALUES (7, 'Admin/News/newslist', '文章管理', 1, 1, '2');
INSERT INTO `wp_auth_rule` VALUES (8, 'Admin/News/newsedit', '编辑文章', 1, 1, '2');
INSERT INTO `wp_auth_rule` VALUES (9, 'Admin/News/newsdel', '删除文章', 1, 1, '2');
INSERT INTO `wp_auth_rule` VALUES (10, 'Admin/Goods/glist', '产品列表', 1, 1, '3');
INSERT INTO `wp_auth_rule` VALUES (11, 'Admin/Goods/setflag', '休市状态', 1, 1, '3');
INSERT INTO `wp_auth_rule` VALUES (12, 'Admin/Goods/gedit', '编辑产品', 1, 1, '3');
INSERT INTO `wp_auth_rule` VALUES (13, 'Admin/Order/tlist', '交易流水', 1, 1, '4');
INSERT INTO `wp_auth_rule` VALUES (14, 'Admin/Order/ocontent', '查看交易流水', 1, 1, '4');
INSERT INTO `wp_auth_rule` VALUES (15, 'Admin/User/ulist', '客户列表', 1, 1, '5');
INSERT INTO `wp_auth_rule` VALUES (16, 'Admin/User/updateuser', '编辑客户信息', 1, 1, '5');
INSERT INTO `wp_auth_rule` VALUES (17, 'Admin/Menber/upstatus', '交易冻结', 1, 1, '4');
INSERT INTO `wp_auth_rule` VALUES (18, 'Admin/User/addmoney', '手动充值', 1, 1, '5');
INSERT INTO `wp_auth_rule` VALUES (22, 'Admin/User/agentlist', '经纪人申请列表', 1, 1, '6');
INSERT INTO `wp_auth_rule` VALUES (23, 'Admin/Agentlist/alist', '经纪人列表', 2, 1, '6');
INSERT INTO `wp_auth_rule` VALUES (24, 'Admin/Agentlist/mupdate', '编辑经纪人', 1, 1, '6');
INSERT INTO `wp_auth_rule` VALUES (25, 'Admin/Agentlist/upstatus', '经纪人冻结', 1, 1, '6');
INSERT INTO `wp_auth_rule` VALUES (26, 'Admin/Menber/mlist', '会员列表', 1, 1, '7');
INSERT INTO `wp_auth_rule` VALUES (27, 'Admin/Menber/mupdate', '编辑会员', 1, 1, '7');
INSERT INTO `wp_auth_rule` VALUES (28, 'Admin/Menber/madd', '添加会员单位', 1, 1, '7');
INSERT INTO `wp_auth_rule` VALUES (29, 'Admin/Super/sadd', '添加管理员', 1, 1, '8');
INSERT INTO `wp_auth_rule` VALUES (30, 'Admin/Super/slist', '管理员列表', 1, 1, '8');
INSERT INTO `wp_auth_rule` VALUES (31, 'Admin/Super/sedit', '修改管理员', 1, 1, '8');
INSERT INTO `wp_auth_rule` VALUES (32, 'Admin/Auth/addauth', '添加权限', 2, 1, '');
INSERT INTO `wp_auth_rule` VALUES (33, 'Admin/Auth/do_addgroup', '添加权限', 2, 1, '');
INSERT INTO `wp_auth_rule` VALUES (34, 'Admin/Auth/auth', '添加角色', 2, 1, '');
INSERT INTO `wp_auth_rule` VALUES (35, 'Admin/Auth/do_addauth', '添加角色', 2, 1, '');
INSERT INTO `wp_auth_rule` VALUES (36, 'Admin/Auth/authlist', '角色列表', 2, 1, '');
INSERT INTO `wp_auth_rule` VALUES (37, 'Admin/Auth/edit', '修改角色', 2, 1, '');
INSERT INTO `wp_auth_rule` VALUES (38, 'Admin/Auth/doedit', '修改角色', 2, 1, '');
INSERT INTO `wp_auth_rule` VALUES (39, 'Admin/Auth/adel', '删除角色', 2, 1, '');
INSERT INTO `wp_auth_rule` VALUES (40, 'Admin/User/recharge', '充值记录', 1, 1, '5');
INSERT INTO `wp_auth_rule` VALUES (41, 'Admin/User/upbalance', '财务管理', 1, 1, '9');
INSERT INTO `wp_auth_rule` VALUES (42, 'Admin/Super/esystem', '基本设置', 1, 1, '1');
INSERT INTO `wp_auth_rule` VALUES (43, 'Admin/Super/backupdb', '数据备份', 1, 1, '1');
INSERT INTO `wp_auth_rule` VALUES (44, 'Admin/Menber/wxinfo', '微信设置', 1, 1, '10');
INSERT INTO `wp_auth_rule` VALUES (45, 'Admin/Menber/wxlist', '微信用户', 1, 1, '10');
INSERT INTO `wp_auth_rule` VALUES (46, 'Admin/Menber/instruser', '更新微信用户', 1, 1, '10');
INSERT INTO `wp_auth_rule` VALUES (47, 'Admin/User/userlog', '日志信息', 1, 1, '11');
INSERT INTO `wp_auth_rule` VALUES (48, 'Admin/User/signinout', '退出', 1, 1, '1');
INSERT INTO `wp_auth_rule` VALUES (50, '菜单栏目', '菜单栏目', 0, 1, '3,10,13,15,23,26,31,32,40,42,44,47,51,55');
INSERT INTO `wp_auth_rule` VALUES (19, '/Admin/User/validate', '手动充值', 1, 1, '5');
INSERT INTO `wp_auth_rule` VALUES (51, 'Admin/Operation/mlist', '运营中心列表', 1, 1, '12');
INSERT INTO `wp_auth_rule` VALUES (52, 'Admin/Operation/madd', '添加运营中心', 1, 1, '12');
INSERT INTO `wp_auth_rule` VALUES (53, 'Admin/Operation/freeze', '运营中心列表', 1, 1, '12');
INSERT INTO `wp_auth_rule` VALUES (54, 'Admin/Operation/upstatus', '运营中心列表', 1, 1, '12');
INSERT INTO `wp_auth_rule` VALUES (55, 'Admin/authority/index', '权限列表', 1, 1, '13');

-- ----------------------------
-- Table structure for wp_balance
-- ----------------------------
DROP TABLE IF EXISTS `wp_balance`;
CREATE TABLE `wp_balance`  (
  `bpid` int(11) NOT NULL AUTO_INCREMENT,
  `b_type` tinyint(1) NOT NULL COMMENT '1 充值 2提现',
  `bptype` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '收支类型',
  `bptime` int(20) NULL DEFAULT NULL COMMENT '操作时间',
  `bpprice` decimal(10, 2) NULL DEFAULT NULL COMMENT '收支',
  `remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注',
  `uid` int(11) NULL DEFAULT NULL,
  `isverified` int(11) NULL DEFAULT NULL COMMENT '判断申请是否通过，0未通过，1通过2拒绝',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '当前记录是否完成，默认0未完成，1完成',
  `cltime` int(20) NULL DEFAULT NULL COMMENT '审核时间',
  `balanceno` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `pay_type` tinyint(1) NULL DEFAULT NULL COMMENT '支付类型',
  `shibpprice` double NOT NULL COMMENT '用户余额',
  `tempdate` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`bpid`) USING BTREE,
  INDEX `bptype`(`bptype`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 18 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_balance
-- ----------------------------
INSERT INTO `wp_balance` VALUES (1, 1, '充值', 1500263194, 5000.00, '账户加款', 2, 1, 0, 1500263194, 'SD1500263194', 0, 5000, '2017-07-17 11:46:34');
INSERT INTO `wp_balance` VALUES (2, 1, '充值', 1500263253, 5000.00, '手动充值', 3, 1, 0, 1500263253, '', 0, 5000, '2017-07-17 11:47:33');
INSERT INTO `wp_balance` VALUES (3, 0, '提现', 1500263967, 5000.00, '123', 3, 2, 0, 1500264018, '', NULL, 5000, '2025-01-07 15:32:28');
INSERT INTO `wp_balance` VALUES (4, 0, '充值', 1500277900, 100.00, '开始充值', 6, 0, 0, NULL, '6YY150027790073', NULL, 0, '2017-07-17 15:51:40');
INSERT INTO `wp_balance` VALUES (5, 1, '充值', 1500364065, 5000.00, '手动充值', 7, 1, 0, 1500364065, 'SD1500364065', 0, 5000, '2017-07-18 15:47:45');
INSERT INTO `wp_balance` VALUES (6, 1, '充值', 1500861189, 100.00, '手动充值', 6, 1, 0, 1500861189, 'SD1500861189', 0, 100, '2017-07-24 09:53:09');
INSERT INTO `wp_balance` VALUES (7, 1, '充值', 1500861207, 1000.00, '手动充值', 6, 1, 0, 1500861207, 'SD1500861207', 0, 1100, '2017-07-24 09:53:27');
INSERT INTO `wp_balance` VALUES (8, 1, '充值', 1501132661, 100000.00, '账户加款', 3, 1, 0, 1501132661, 'SD1501132661', 0, 105000, '2017-07-27 13:17:41');
INSERT INTO `wp_balance` VALUES (9, 0, '提现', 1501145575, 100.00, '123', 6, 2, 0, 1501145633, 'TX1501145575445842', NULL, 99.6, '2025-01-07 15:32:29');
INSERT INTO `wp_balance` VALUES (10, 0, '充值', 1501145799, 100.00, '开始充值', 6, 0, 0, NULL, '6YY150114579926', NULL, 0, '2017-07-27 16:56:39');
INSERT INTO `wp_balance` VALUES (11, 0, '充值', 1501145805, 100.00, '开始充值', 6, 0, 0, NULL, '6YY150114580530', NULL, 0, '2017-07-27 16:56:45');
INSERT INTO `wp_balance` VALUES (12, 0, '充值', 1501145829, 100.00, '开始充值', 6, 0, 0, NULL, '6YY150114582946', NULL, 0, '2017-07-27 16:57:09');
INSERT INTO `wp_balance` VALUES (13, 0, '充值', 1501145854, 100.00, '开始充值', 8, 0, 0, NULL, '8YY150114585454', NULL, 0, '2017-07-27 16:57:34');
INSERT INTO `wp_balance` VALUES (14, 0, '提现', 1501148856, 100.00, '123', 6, 2, 0, 1501148966, 'TX1501148856258879', NULL, 99.6, '2025-01-07 15:32:31');
INSERT INTO `wp_balance` VALUES (15, 0, '充值', 1501221780, 100.00, '开始充值', 6, 0, 0, NULL, '6YY150122178021', NULL, 0, '2017-07-28 14:03:00');
INSERT INTO `wp_balance` VALUES (16, 0, '充值', 1501221792, 100.00, '开始充值', 6, 0, 0, NULL, '6YY150122179252', NULL, 0, '2017-07-28 14:03:12');
INSERT INTO `wp_balance` VALUES (17, 0, '充值', 1501222482, 1000.00, '开始充值', 9, 0, 0, NULL, '9YY150122248220', NULL, 0, '2017-07-28 14:14:42');

-- ----------------------------
-- Table structure for wp_bankinfo
-- ----------------------------
DROP TABLE IF EXISTS `wp_bankinfo`;
CREATE TABLE `wp_bankinfo`  (
  `bid` int(20) NOT NULL AUTO_INCREMENT,
  `tempdate` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0),
  `uid` int(11) NOT NULL COMMENT '绑定',
  `bankname` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '所属银行',
  `province` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '省份',
  `city` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '城市',
  `branch` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '支行名',
  `banknumber` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '银行卡号',
  `busername` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '姓名',
  `card` varchar(22) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '身份证号',
  PRIMARY KEY (`bid`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_bankinfo
-- ----------------------------
INSERT INTO `wp_bankinfo` VALUES (1, '2025-01-07 15:31:04', 2, '中国建设银行', '浙江', '杭州', '', '555555555', '小李', NULL);
INSERT INTO `wp_bankinfo` VALUES (2, '2025-01-07 15:31:04', 3, '中国建设银行', '江苏', '', '', '555555555', '小李', NULL);
INSERT INTO `wp_bankinfo` VALUES (3, '2025-01-07 15:31:04', 4, '中国工商银行', '重庆', '渝中区', '', '555555555', '小李', NULL);
INSERT INTO `wp_bankinfo` VALUES (4, '2025-01-07 15:31:16', 6, '交通银行', '山西省', '太原市', '山西省', '555555555', '小李', '');

-- ----------------------------
-- Table structure for wp_bankrournal
-- ----------------------------
DROP TABLE IF EXISTS `wp_bankrournal`;
CREATE TABLE `wp_bankrournal`  (
  `bankno` varchar(255) CHARACTER SET gbk COLLATE gbk_chinese_ci NOT NULL COMMENT '日志编号',
  `bankname` varchar(255) CHARACTER SET gbk COLLATE gbk_chinese_ci NULL DEFAULT NULL COMMENT '银行名称',
  `address` varchar(255) CHARACTER SET gbk COLLATE gbk_chinese_ci NULL DEFAULT NULL COMMENT '地址',
  `

cardnumber` int(20) NULL DEFAULT NULL COMMENT '银行卡号',
  `cardholder` varchar(255) CHARACTER SET gbk COLLATE gbk_chinese_ci NULL DEFAULT NULL COMMENT '持卡人名称'
) ENGINE = MyISAM CHARACTER SET = gbk COLLATE = gbk_chinese_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_bankrournal
-- ----------------------------

-- ----------------------------
-- Table structure for wp_bournal
-- ----------------------------
DROP TABLE IF EXISTS `wp_bournal`;
CREATE TABLE `wp_bournal`  (
  `bno` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '提现/充值编号',
  `btype` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '银行名称',
  `btime` int(20) NULL DEFAULT NULL COMMENT '操作时间',
  `bprice` double(20, 2) NULL DEFAULT NULL COMMENT '提现/充值金额',
  `uid` int(20) NULL DEFAULT NULL COMMENT '持卡人名称',
  `username` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '用户名',
  `isverified` int(10) NULL DEFAULT NULL,
  `balance` double(20, 2) NULL DEFAULT 0.00 COMMENT '账户余额',
  `tempdate` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0)
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_bournal
-- ----------------------------
INSERT INTO `wp_bournal` VALUES ('1501145575559', '提现', 1501145575, 100.00, 6, '小李', 0, 536.00, '2025-01-07 15:37:59');
INSERT INTO `wp_bournal` VALUES ('1501148856569', '提现', 1501148856, 100.00, 6, '小李', 0, 536.00, '2025-01-07 15:38:01');

-- ----------------------------
-- Table structure for wp_city
-- ----------------------------
DROP TABLE IF EXISTS `wp_city`;
CREATE TABLE `wp_city`  (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `sn` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `joinname` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `parent_id` mediumint(8) UNSIGNED NOT NULL DEFAULT 0,
  `level` tinyint(1) NOT NULL DEFAULT 0 COMMENT '层级',
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '状态（0 未开通 1 已开通）',
  `coordinat` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '坐标',
  `baidu_code` smallint(6) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_name`(`name`) USING BTREE,
  INDEX `idx_parentid_vieworder`(`parent_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 910011 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_city
-- ----------------------------
INSERT INTO `wp_city` VALUES (110000, 'B-北京市', '', '北京市', 0, 1, 0, '', 131);
INSERT INTO `wp_city` VALUES (120000, 'T-天津市', '', '天津市', 0, 1, 0, '', 332);
INSERT INTO `wp_city` VALUES (130000, 'H-河北省', '', '河北省', 0, 1, 0, '', 25);
INSERT INTO `wp_city` VALUES (140000, 'S-山西省', '', '山西省', 0, 1, 0, '', 10);
INSERT INTO `wp_city` VALUES (150000, 'N-内蒙古自治区', '', '内蒙古自治区', 0, 1, 0, '', 0);
INSERT INTO `wp_city` VALUES (210000, 'L-辽宁省', '', '辽宁省', 0, 1, 0, '', 19);
INSERT INTO `wp_city` VALUES (220000, 'J-吉林省', '', '吉林省', 0, 1, 0, '', 0);
INSERT INTO `wp_city` VALUES (230000, 'H-黑龙江省', '', '黑龙江省', 0, 1, 0, '', 2);
INSERT INTO `wp_city` VALUES (310000, 'S-上海市', '', '上海市', 0, 1, 0, '', 289);
INSERT INTO `wp_city` VALUES (320000, 'J-江苏省', '', '江苏省', 0, 1, 0, '', 18);
INSERT INTO `wp_city` VALUES (330000, 'Z-浙江省', '', '浙江省', 0, 1, 0, '', 29);
INSERT INTO `wp_city` VALUES (340000, 'A-安徽省', '', '安徽省', 0, 1, 0, '', 23);
INSERT INTO `wp_city` VALUES (350000, 'F-福建省', '', '福建省', 0, 1, 0, '', 16);
INSERT INTO `wp_city` VALUES (360000, 'J-江西省', '', '江西省', 0, 1, 0, '', 31);
INSERT INTO `wp_city` VALUES (370000, 'S-山东省', '', '山东省', 0, 1, 1, '', 8);
INSERT INTO `wp_city` VALUES (410000, 'H-河南省', '', '河南省', 0, 1, 0, '', 30);
INSERT INTO `wp_city` VALUES (420000, 'H-湖北省', '', '湖北省', 0, 1, 0, '', 15);
INSERT INTO `wp_city` VALUES (430000, 'H-湖南省', '', '湖南省', 0, 1, 0, '', 26);
INSERT INTO `wp_city` VALUES (440000, 'G-广东省', '', '广东省', 0, 1, 0, '', 7);
INSERT INTO `wp_city` VALUES (450000, 'G-广西壮族自治区', '', '广西壮族自治区', 0, 1, 0, '', 0);
INSERT INTO `wp_city` VALUES (460000, 'H-海南省', '', '海南省', 0, 1, 0, '', 21);
INSERT INTO `wp_city` VALUES (500000, 'C-重庆市', '', '重庆市', 0, 1, 0, '', 132);
INSERT INTO `wp_city` VALUES (510000, 'S-四川省', '', '四川省', 0, 1, 0, '', 32);
INSERT INTO `wp_city` VALUES (520000, 'G-贵州省', '', '贵州省', 0, 1, 0, '', 24);
INSERT INTO `wp_city` VALUES (530000, 'Y-云南省', '', '云南省', 0, 1, 0, '', 28);
INSERT INTO `wp_city` VALUES (540000, 'X-西藏自治区', '', '西藏自治区', 0, 1, 0, '', 0);
INSERT INTO `wp_city` VALUES (610000, 'S-陕西省', '', '陕西省', 0, 1, 0, '', 27);
INSERT INTO `wp_city` VALUES (620000, 'G-甘肃省', '', '甘肃省', 0, 1, 0, '', 6);
INSERT INTO `wp_city` VALUES (630000, 'Q-青海省', '', '青海省', 0, 1, 0, '', 11);
INSERT INTO `wp_city` VALUES (640000, 'N-宁夏回族自治区', '', '宁夏回族自治区', 0, 1, 0, '', 0);
INSERT INTO `wp_city` VALUES (650000, 'X-新疆维吾尔自治区', '', '新疆维吾尔自治区', 0, 1, 0, '', 0);
INSERT INTO `wp_city` VALUES (710000, 'T-台湾省', '', '台湾省', 0, 1, 0, '', 0);
INSERT INTO `wp_city` VALUES (810000, 'X-香港特别行政区', '', '香港特别行政区', 0, 1, 0, '', 0);
INSERT INTO `wp_city` VALUES (820000, 'A-澳门特别行政区', '', '澳门特别行政区', 0, 1, 0, '', 0);
INSERT INTO `wp_city` VALUES (110100, '北京市', '', '北京市,北京市', 110000, 2, 0, '', 131);
INSERT INTO `wp_city` VALUES (110200, '县', '', '北京市,县', 110000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (120100, '市辖区', '', '天津市,市辖区', 120000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (120200, '县', '', '天津市,县', 120000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (130100, '石家庄市', '', '河北省,石家庄市', 130000, 2, 0, '', 150);
INSERT INTO `wp_city` VALUES (130200, '唐山市', '', '河北省,唐山市', 130000, 2, 0, '', 265);
INSERT INTO `wp_city` VALUES (130300, '秦皇岛市', '', '河北省,秦皇岛市', 130000, 2, 0, '', 148);
INSERT INTO `wp_city` VALUES (130400, '邯郸市', '', '河北省,邯郸市', 130000, 2, 0, '', 151);
INSERT INTO `wp_city` VALUES (130500, '邢台市', '', '河北省,邢台市', 130000, 2, 0, '', 266);
INSERT INTO `wp_city` VALUES (130600, '保定市', '', '河北省,保定市', 130000, 2, 0, '', 307);
INSERT INTO `wp_city` VALUES (130700, '张家口市', '', '河北省,张家口市', 130000, 2, 0, '', 264);
INSERT INTO `wp_city` VALUES (130800, '承德市', '', '河北省,承德市', 130000, 2, 0, '', 207);
INSERT INTO `wp_city` VALUES (130900, '沧州市', '', '河北省,沧州市', 130000, 2, 0, '', 149);
INSERT INTO `wp_city` VALUES (131000, '廊坊市', '', '河北省,廊坊市', 130000, 2, 0, '', 191);
INSERT INTO `wp_city` VALUES (131100, '衡水市', '', '河北省,衡水市', 130000, 2, 0, '', 208);
INSERT INTO `wp_city` VALUES (140100, '太原市', '', '山西省,太原市', 140000, 2, 0, '', 176);
INSERT INTO `wp_city` VALUES (140200, '大同市', '', '山西省,大同市', 140000, 2, 0, '', 355);
INSERT INTO `wp_city` VALUES (140300, '阳泉市', '', '山西省,阳泉市', 140000, 2, 0, '', 357);
INSERT INTO `wp_city` VALUES (140400, '长治市', '', '山西省,长治市', 140000, 2, 0, '', 356);
INSERT INTO `wp_city` VALUES (140500, '晋城市', '', '山西省,晋城市', 140000, 2, 0, '', 290);
INSERT INTO `wp_city` VALUES (140600, '朔州市', '', '山西省,朔州市', 140000, 2, 0, '', 237);
INSERT INTO `wp_city` VALUES (140700, '晋中市', '', '山西省,晋中市', 140000, 2, 0, '', 238);
INSERT INTO `wp_city` VALUES (140800, '运城市', '', '山西省,运城市', 140000, 2, 0, '', 328);
INSERT INTO `wp_city` VALUES (140900, '忻州市', '', '山西省,忻州市', 140000, 2, 0, '', 367);
INSERT INTO `wp_city` VALUES (141000, '临汾市', '', '山西省,临汾市', 140000, 2, 0, '', 368);
INSERT INTO `wp_city` VALUES (141100, '吕梁市', '', '山西省,吕梁市', 140000, 2, 0, '', 327);
INSERT INTO `wp_city` VALUES (150100, '呼和浩特市', '', '内蒙古自治区,呼和浩特市', 150000, 2, 0, '', 321);
INSERT INTO `wp_city` VALUES (150200, '包头市', '', '内蒙古自治区,包头市', 150000, 2, 0, '', 229);
INSERT INTO `wp_city` VALUES (150300, '乌海市', '', '内蒙古自治区,乌海市', 150000, 2, 0, '', 123);
INSERT INTO `wp_city` VALUES (150400, '赤峰市', '', '内蒙古自治区,赤峰市', 150000, 2, 0, '', 297);
INSERT INTO `wp_city` VALUES (150500, '通辽市', '', '内蒙古自治区,通辽市', 150000, 2, 0, '', 64);
INSERT INTO `wp_city` VALUES (150600, '鄂尔多斯市', '', '内蒙古自治区,鄂尔多斯市', 150000, 2, 0, '', 283);
INSERT INTO `wp_city` VALUES (150700, '呼伦贝尔市', '', '内蒙古自治区,呼伦贝尔市', 150000, 2, 0, '', 61);
INSERT INTO `wp_city` VALUES (150800, '巴彦淖尔市', '', '内蒙古自治区,巴彦淖尔市', 150000, 2, 0, '', 169);
INSERT INTO `wp_city` VALUES (150900, '乌兰察布市', '', '内蒙古自治区,乌兰察布市', 150000, 2, 0, '', 168);
INSERT INTO `wp_city` VALUES (152200, '兴安盟', '', '内蒙古自治区,兴安盟', 150000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (152500, '锡林郭勒盟', '', '内蒙古自治区,锡林郭勒盟', 150000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (152900, '阿拉善盟', '', '内蒙古自治区,阿拉善盟', 150000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (210100, '沈阳市', '', '辽宁省,沈阳市', 210000, 2, 0, '', 58);
INSERT INTO `wp_city` VALUES (210200, '大连市', '', '辽宁省,大连市', 210000, 2, 0, '', 167);
INSERT INTO `wp_city` VALUES (210300, '鞍山市', '', '辽宁省,鞍山市', 210000, 2, 0, '', 320);
INSERT INTO `wp_city` VALUES (210400, '抚顺市', '', '辽宁省,抚顺市', 210000, 2, 0, '', 184);
INSERT INTO `wp_city` VALUES (210500, '本溪市', '', '辽宁省,本溪市', 210000, 2, 0, '', 227);
INSERT INTO `wp_city` VALUES (210600, '丹东市', '', '辽宁省,丹东市', 210000, 2, 0, '', 282);
INSERT INTO `wp_city` VALUES (210700, '锦州市', '', '辽宁省,锦州市', 210000, 2, 0, '', 166);
INSERT INTO `wp_city` VALUES (210800, '营口市', '', '辽宁省,营口市', 210000, 2, 0, '', 281);
INSERT INTO `wp_city` VALUES (210900, '阜新市', '', '辽宁省,阜新市', 210000, 2, 0, '', 59);
INSERT INTO `wp_city` VALUES (211000, '辽阳市', '', '辽宁省,辽阳市', 210000, 2, 0, '', 351);
INSERT INTO `wp_city` VALUES (211100, '盘锦市', '', '辽宁省,盘锦市', 210000, 2, 0, '', 228);
INSERT INTO `wp_city` VALUES (211200, '铁岭市', '', '辽宁省,铁岭市', 210000, 2, 0, '', 60);
INSERT INTO `wp_city` VALUES (211300, '朝阳市', '', '辽宁省,朝阳市', 210000, 2, 0, '', 280);
INSERT INTO `wp_city` VALUES (211400, '葫芦岛市', '', '辽宁省,葫芦岛市', 210000, 2, 0, '', 319);
INSERT INTO `wp_city` VALUES (220100, '长春市', '', '吉林省,长春市', 220000, 2, 0, '', 53);
INSERT INTO `wp_city` VALUES (220200, '吉林市', '', '吉林省,吉林市', 220000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (220300, '四平市', '', '吉林省,四平市', 220000, 2, 0, '', 56);
INSERT INTO `wp_city` VALUES (220400, '辽源市', '', '吉林省,辽源市', 220000, 2, 0, '', 183);
INSERT INTO `wp_city` VALUES (220500, '通化市', '', '吉林省,通化市', 220000, 2, 0, '', 165);
INSERT INTO `wp_city` VALUES (220600, '白山市', '', '吉林省,白山市', 220000, 2, 0, '', 57);
INSERT INTO `wp_city` VALUES (220700, '松原市', '', '吉林省,松原市', 220000, 2, 0, '', 52);
INSERT INTO `wp_city` VALUES (220800, '白城市', '', '吉林省,白城市', 220000, 2, 0, '', 51);
INSERT INTO `wp_city` VALUES (222400, '延边朝鲜族自治州', '', '吉林省,延边朝鲜族自治州', 220000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (230100, '哈尔滨市', '', '黑龙江省,哈尔滨市', 230000, 2, 0, '', 48);
INSERT INTO `wp_city` VALUES (230200, '齐齐哈尔市', '', '黑龙江省,齐齐哈尔市', 230000, 2, 0, '', 41);
INSERT INTO `wp_city` VALUES (230300, '鸡西市', '', '黑龙江省,鸡西市', 230000, 2, 0, '', 46);
INSERT INTO `wp_city` VALUES (230400, '鹤岗市', '', '黑龙江省,鹤岗市', 230000, 2, 0, '', 43);
INSERT INTO `wp_city` VALUES (230500, '双鸭山市', '', '黑龙江省,双鸭山市', 230000, 2, 0, '', 45);
INSERT INTO `wp_city` VALUES (230600, '大庆市', '', '黑龙江省,大庆市', 230000, 2, 0, '', 50);
INSERT INTO `wp_city` VALUES (230700, '伊春市', '', '黑龙江省,伊春市', 230000, 2, 0, '', 40);
INSERT INTO `wp_city` VALUES (230800, '佳木斯市', '', '黑龙江省,佳木斯市', 230000, 2, 0, '', 42);
INSERT INTO `wp_city` VALUES (230900, '七台河市', '', '黑龙江省,七台河市', 230000, 2, 0, '', 47);
INSERT INTO `wp_city` VALUES (231000, '牡丹江市', '', '黑龙江省,牡丹江市', 230000, 2, 0, '', 49);
INSERT INTO `wp_city` VALUES (231100, '黑河市', '', '黑龙江省,黑河市', 230000, 2, 0, '', 39);
INSERT INTO `wp_city` VALUES (231200, '绥化市', '', '黑龙江省,绥化市', 230000, 2, 0, '', 44);
INSERT INTO `wp_city` VALUES (232700, '大兴安岭地区', '', '黑龙江省,大兴安岭地区', 230000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (310100, '市辖区', '', '上海市,市辖区', 310000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (310200, '县', '', '上海市,县', 310000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (320100, '南京市', '', '江苏省,南京市', 320000, 2, 0, '', 315);
INSERT INTO `wp_city` VALUES (320200, '无锡市', '', '江苏省,无锡市', 320000, 2, 0, '', 317);
INSERT INTO `wp_city` VALUES (320300, '徐州市', '', '江苏省,徐州市', 320000, 2, 0, '', 316);
INSERT INTO `wp_city` VALUES (320400, '常州市', '', '江苏省,常州市', 320000, 2, 0, '', 348);
INSERT INTO `wp_city` VALUES (320500, '苏州市', '', '江苏省,苏州市', 320000, 2, 0, '', 224);
INSERT INTO `wp_city` VALUES (320600, '南通市', '', '江苏省,南通市', 320000, 2, 0, '', 161);
INSERT INTO `wp_city` VALUES (320700, '连云港市', '', '江苏省,连云港市', 320000, 2, 0, '', 347);
INSERT INTO `wp_city` VALUES (320800, '淮安市', '', '江苏省,淮安市', 320000, 2, 0, '', 162);
INSERT INTO `wp_city` VALUES (320900, '盐城市', '', '江苏省,盐城市', 320000, 2, 0, '', 223);
INSERT INTO `wp_city` VALUES (321000, '扬州市', '', '江苏省,扬州市', 320000, 2, 0, '', 346);
INSERT INTO `wp_city` VALUES (321100, '镇江市', '', '江苏省,镇江市', 320000, 2, 0, '', 160);
INSERT INTO `wp_city` VALUES (321200, '泰州市', '', '江苏省,泰州市', 320000, 2, 0, '', 276);
INSERT INTO `wp_city` VALUES (321300, '宿迁市', '', '江苏省,宿迁市', 320000, 2, 0, '', 277);
INSERT INTO `wp_city` VALUES (330100, '杭州市', '', '浙江省,杭州市', 330000, 2, 0, '', 179);
INSERT INTO `wp_city` VALUES (330200, '宁波市', '', '浙江省,宁波市', 330000, 2, 0, '', 180);
INSERT INTO `wp_city` VALUES (330300, '温州市', '', '浙江省,温州市', 330000, 2, 0, '', 178);
INSERT INTO `wp_city` VALUES (330400, '嘉兴市', '', '浙江省,嘉兴市', 330000, 2, 0, '', 334);
INSERT INTO `wp_city` VALUES (330500, '湖州市', '', '浙江省,湖州市', 330000, 2, 0, '', 294);
INSERT INTO `wp_city` VALUES (330600, '绍兴市', '', '浙江省,绍兴市', 330000, 2, 0, '', 293);
INSERT INTO `wp_city` VALUES (330700, '金华市', '', '浙江省,金华市', 330000, 2, 0, '', 333);
INSERT INTO `wp_city` VALUES (330800, '衢州市', '', '浙江省,衢州市', 330000, 2, 0, '', 243);
INSERT INTO `wp_city` VALUES (330900, '舟山市', '', '浙江省,舟山市', 330000, 2, 0, '', 245);
INSERT INTO `wp_city` VALUES (331000, '台州市', '', '浙江省,台州市', 330000, 2, 0, '', 244);
INSERT INTO `wp_city` VALUES (331100, '丽水市', '', '浙江省,丽水市', 330000, 2, 0, '', 292);
INSERT INTO `wp_city` VALUES (340100, '合肥市', '', '安徽省,合肥市', 340000, 2, 0, '', 127);
INSERT INTO `wp_city` VALUES (340200, '芜湖市', '', '安徽省,芜湖市', 340000, 2, 0, '', 129);
INSERT INTO `wp_city` VALUES (340300, '蚌埠市', '', '安徽省,蚌埠市', 340000, 2, 0, '', 126);
INSERT INTO `wp_city` VALUES (340400, '淮南市', '', '安徽省,淮南市', 340000, 2, 0, '', 250);
INSERT INTO `wp_city` VALUES (340500, '马鞍山市', '', '安徽省,马鞍山市', 340000, 2, 0, '', 358);
INSERT INTO `wp_city` VALUES (340600, '淮北市', '', '安徽省,淮北市', 340000, 2, 0, '', 253);
INSERT INTO `wp_city` VALUES (340700, '铜陵市', '', '安徽省,铜陵市', 340000, 2, 0, '', 337);
INSERT INTO `wp_city` VALUES (340800, '安庆市', '', '安徽省,安庆市', 340000, 2, 0, '', 130);
INSERT INTO `wp_city` VALUES (341000, '黄山市', '', '安徽省,黄山市', 340000, 2, 0, '', 252);
INSERT INTO `wp_city` VALUES (341100, '滁州市', '', '安徽省,滁州市', 340000, 2, 0, '', 189);
INSERT INTO `wp_city` VALUES (341200, '阜阳市', '', '安徽省,阜阳市', 340000, 2, 0, '', 128);
INSERT INTO `wp_city` VALUES (341300, '宿州市', '', '安徽省,宿州市', 340000, 2, 0, '', 370);
INSERT INTO `wp_city` VALUES (341500, '六安市', '', '安徽省,六安市', 340000, 2, 0, '', 298);
INSERT INTO `wp_city` VALUES (341600, '亳州市', '', '安徽省,亳州市', 340000, 2, 0, '', 188);
INSERT INTO `wp_city` VALUES (341700, '池州市', '', '安徽省,池州市', 340000, 2, 0, '', 299);
INSERT INTO `wp_city` VALUES (341800, '宣城市', '', '安徽省,宣城市', 340000, 2, 0, '', 190);
INSERT INTO `wp_city` VALUES (350100, '福州市', '', '福建省,福州市', 350000, 2, 0, '', 300);
INSERT INTO `wp_city` VALUES (350200, '厦门市', '', '福建省,厦门市', 350000, 2, 0, '', 194);
INSERT INTO `wp_city` VALUES (350300, '莆田市', '', '福建省,莆田市', 350000, 2, 0, '', 195);
INSERT INTO `wp_city` VALUES (350400, '三明市', '', '福建省,三明市', 350000, 2, 0, '', 254);
INSERT INTO `wp_city` VALUES (350500, '泉州市', '', '福建省,泉州市', 350000, 2, 0, '', 134);
INSERT INTO `wp_city` VALUES (350600, '漳州市', '', '福建省,漳州市', 350000, 2, 0, '', 255);
INSERT INTO `wp_city` VALUES (350700, '南平市', '', '福建省,南平市', 350000, 2, 0, '', 133);
INSERT INTO `wp_city` VALUES (350800, '龙岩市', '', '福建省,龙岩市', 350000, 2, 0, '', 193);
INSERT INTO `wp_city` VALUES (350900, '宁德市', '', '福建省,宁德市', 350000, 2, 0, '', 192);
INSERT INTO `wp_city` VALUES (360100, '南昌市', '', '江西省,南昌市', 360000, 2, 0, '', 163);
INSERT INTO `wp_city` VALUES (360200, '景德镇市', '', '江西省,景德镇市', 360000, 2, 0, '', 225);
INSERT INTO `wp_city` VALUES (360300, '萍乡市', '', '江西省,萍乡市', 360000, 2, 0, '', 350);
INSERT INTO `wp_city` VALUES (360400, '九江市', '', '江西省,九江市', 360000, 2, 0, '', 349);
INSERT INTO `wp_city` VALUES (360500, '新余市', '', '江西省,新余市', 360000, 2, 0, '', 164);
INSERT INTO `wp_city` VALUES (360600, '鹰潭市', '', '江西省,鹰潭市', 360000, 2, 0, '', 279);
INSERT INTO `wp_city` VALUES (360700, '赣州市', '', '江西省,赣州市', 360000, 2, 0, '', 365);
INSERT INTO `wp_city` VALUES (360800, '吉安市', '', '江西省,吉安市', 360000, 2, 0, '', 318);
INSERT INTO `wp_city` VALUES (360900, '宜春市', '', '江西省,宜春市', 360000, 2, 0, '', 278);
INSERT INTO `wp_city` VALUES (361000, '抚州市', '', '江西省,抚州市', 360000, 2, 0, '', 226);
INSERT INTO `wp_city` VALUES (361100, '上饶市', '', '江西省,上饶市', 360000, 2, 0, '', 364);
INSERT INTO `wp_city` VALUES (370100, '济南市', 'jn', '山东省,济南市', 370000, 2, 1, '', 288);
INSERT INTO `wp_city` VALUES (370200, '青岛市', '', '山东省,青岛市', 370000, 2, 1, '', 236);
INSERT INTO `wp_city` VALUES (370300, '淄博市', '', '山东省,淄博市', 370000, 2, 1, '', 354);
INSERT INTO `wp_city` VALUES (370400, '枣庄市', '', '山东省,枣庄市', 370000, 2, 0, '', 172);
INSERT INTO `wp_city` VALUES (370500, '东营市', '', '山东省,东营市', 370000, 2, 0, '', 174);
INSERT INTO `wp_city` VALUES (370600, '烟台市', '', '山东省,烟台市', 370000, 2, 0, '', 326);
INSERT INTO `wp_city` VALUES (370700, '潍坊市', '', '山东省,潍坊市', 370000, 2, 0, '', 287);
INSERT INTO `wp_city` VALUES (370800, '济宁市', '', '山东省,济宁市', 370000, 2, 0, '', 286);
INSERT INTO `wp_city` VALUES (370900, '泰安市', '', '山东省,泰安市', 370000, 2, 0, '', 325);
INSERT INTO `wp_city` VALUES (371000, '威海市', '', '山东省,威海市', 370000, 2, 0, '', 175);
INSERT INTO `wp_city` VALUES (371100, '日照市', '', '山东省,日照市', 370000, 2, 0, '', 173);
INSERT INTO `wp_city` VALUES (371200, '莱芜市', '', '山东省,莱芜市', 370000, 2, 0, '', 124);
INSERT INTO `wp_city` VALUES (371300, '临沂市', '', '山东省,临沂市', 370000, 2, 0, '', 234);
INSERT INTO `wp_city` VALUES (371400, '德州市', '', '山东省,德州市', 370000, 2, 0, '', 372);
INSERT INTO `wp_city` VALUES (371500, '聊城市', '', '山东省,聊城市', 370000, 2, 0, '', 366);
INSERT INTO `wp_city` VALUES (371600, '滨州市', '', '山东省,滨州市', 370000, 2, 0, '', 235);
INSERT INTO `wp_city` VALUES (371700, '菏泽市', '', '山东省,菏泽市', 370000, 2, 0, '', 353);
INSERT INTO `wp_city` VALUES (410100, '郑州市', '', '河南省,郑州市', 410000, 2, 0, '', 268);
INSERT INTO `wp_city` VALUES (410200, '开封市', '', '河南省,开封市', 410000, 2, 0, '', 210);
INSERT INTO `wp_city` VALUES (410300, '洛阳市', '', '河南省,洛阳市', 410000, 2, 0, '', 153);
INSERT INTO `wp_city` VALUES (410400, '平顶山市', '', '河南省,平顶山市', 410000, 2, 0, '', 213);
INSERT INTO `wp_city` VALUES (410500, '安阳市', '', '河南省,安阳市', 410000, 2, 0, '', 267);
INSERT INTO `wp_city` VALUES (410600, '鹤壁市', '', '河南省,鹤壁市', 410000, 2, 0, '', 215);
INSERT INTO `wp_city` VALUES (410700, '新乡市', '', '河南省,新乡市', 410000, 2, 0, '', 152);
INSERT INTO `wp_city` VALUES (410800, '焦作市', '', '河南省,焦作市', 410000, 2, 0, '', 211);
INSERT INTO `wp_city` VALUES (410900, '濮阳市', '', '河南省,濮阳市', 410000, 2, 0, '', 209);
INSERT INTO `wp_city` VALUES (411000, '许昌市', '', '河南省,许昌市', 410000, 2, 0, '', 155);
INSERT INTO `wp_city` VALUES (411100, '漯河市', '', '河南省,漯河市', 410000, 2, 0, '', 344);
INSERT INTO `wp_city` VALUES (411200, '三门峡市', '', '河南省,三门峡市', 410000, 2, 0, '', 212);
INSERT INTO `wp_city` VALUES (411300, '南阳市', '', '河南省,南阳市', 410000, 2, 0, '', 309);
INSERT INTO `wp_city` VALUES (411400, '商丘市', '', '河南省,商丘市', 410000, 2, 0, '', 154);
INSERT INTO `wp_city` VALUES (411500, '信阳市', '', '河南省,信阳市', 410000, 2, 0, '', 214);
INSERT INTO `wp_city` VALUES (411600, '周口市', '', '河南省,周口市', 410000, 2, 0, '', 308);
INSERT INTO `wp_city` VALUES (411700, '驻马店市', '', '河南省,驻马店市', 410000, 2, 0, '', 269);
INSERT INTO `wp_city` VALUES (420100, '武汉市', '', '湖北省,武汉市', 420000, 2, 0, '', 218);
INSERT INTO `wp_city` VALUES (420200, '黄石市', '', '湖北省,黄石市', 420000, 2, 0, '', 311);
INSERT INTO `wp_city` VALUES (420300, '十堰市', '', '湖北省,十堰市', 420000, 2, 0, '', 216);
INSERT INTO `wp_city` VALUES (420500, '宜昌市', '', '湖北省,宜昌市', 420000, 2, 0, '', 270);
INSERT INTO `wp_city` VALUES (420600, '襄樊市', '', '湖北省,襄樊市', 420000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (420700, '鄂州市', '', '湖北省,鄂州市', 420000, 2, 0, '', 122);
INSERT INTO `wp_city` VALUES (420800, '荆门市', '', '湖北省,荆门市', 420000, 2, 0, '', 217);
INSERT INTO `wp_city` VALUES (420900, '孝感市', '', '湖北省,孝感市', 420000, 2, 0, '', 310);
INSERT INTO `wp_city` VALUES (421000, '荆州市', '', '湖北省,荆州市', 420000, 2, 0, '', 157);
INSERT INTO `wp_city` VALUES (421100, '黄冈市', '', '湖北省,黄冈市', 420000, 2, 0, '', 271);
INSERT INTO `wp_city` VALUES (421200, '咸宁市', '', '湖北省,咸宁市', 420000, 2, 0, '', 362);
INSERT INTO `wp_city` VALUES (421300, '随州市', '', '湖北省,随州市', 420000, 2, 0, '', 371);
INSERT INTO `wp_city` VALUES (422800, '恩施土家族苗族自治州', '', '湖北省,恩施土家族苗族自治州', 420000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (429000, '省直辖行政单位', '', '湖北省,省直辖行政单位', 420000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (430100, '长沙市', '', '湖南省,长沙市', 430000, 2, 0, '', 158);
INSERT INTO `wp_city` VALUES (430200, '株洲市', '', '湖南省,株洲市', 430000, 2, 0, '', 222);
INSERT INTO `wp_city` VALUES (430300, '湘潭市', '', '湖南省,湘潭市', 430000, 2, 0, '', 313);
INSERT INTO `wp_city` VALUES (430400, '衡阳市', '', '湖南省,衡阳市', 430000, 2, 0, '', 159);
INSERT INTO `wp_city` VALUES (430500, '邵阳市', '', '湖南省,邵阳市', 430000, 2, 0, '', 273);
INSERT INTO `wp_city` VALUES (430600, '岳阳市', '', '湖南省,岳阳市', 430000, 2, 0, '', 220);
INSERT INTO `wp_city` VALUES (430700, '常德市', '', '湖南省,常德市', 430000, 2, 0, '', 219);
INSERT INTO `wp_city` VALUES (430800, '张家界市', '', '湖南省,张家界市', 430000, 2, 0, '', 312);
INSERT INTO `wp_city` VALUES (430900, '益阳市', '', '湖南省,益阳市', 430000, 2, 0, '', 272);
INSERT INTO `wp_city` VALUES (431000, '郴州市', '', '湖南省,郴州市', 430000, 2, 0, '', 275);
INSERT INTO `wp_city` VALUES (431100, '永州市', '', '湖南省,永州市', 430000, 2, 0, '', 314);
INSERT INTO `wp_city` VALUES (431200, '怀化市', '', '湖南省,怀化市', 430000, 2, 0, '', 363);
INSERT INTO `wp_city` VALUES (431300, '娄底市', '', '湖南省,娄底市', 430000, 2, 0, '', 221);
INSERT INTO `wp_city` VALUES (433100, '湘西土家族苗族自治州', '', '湖南省,湘西土家族苗族自治州', 430000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (440100, '广州市', '', '广东省,广州市', 440000, 2, 0, '', 257);
INSERT INTO `wp_city` VALUES (440200, '韶关市', '', '广东省,韶关市', 440000, 2, 0, '', 137);
INSERT INTO `wp_city` VALUES (440300, '深圳市', '', '广东省,深圳市', 440000, 2, 0, '', 340);
INSERT INTO `wp_city` VALUES (440400, '珠海市', '', '广东省,珠海市', 440000, 2, 0, '', 140);
INSERT INTO `wp_city` VALUES (440500, '汕头市', '', '广东省,汕头市', 440000, 2, 0, '', 303);
INSERT INTO `wp_city` VALUES (440600, '佛山市', '', '广东省,佛山市', 440000, 2, 0, '', 138);
INSERT INTO `wp_city` VALUES (440700, '江门市', '', '广东省,江门市', 440000, 2, 0, '', 302);
INSERT INTO `wp_city` VALUES (440800, '湛江市', '', '广东省,湛江市', 440000, 2, 0, '', 198);
INSERT INTO `wp_city` VALUES (440900, '茂名市', '', '广东省,茂名市', 440000, 2, 0, '', 139);
INSERT INTO `wp_city` VALUES (441200, '肇庆市', '', '广东省,肇庆市', 440000, 2, 0, '', 338);
INSERT INTO `wp_city` VALUES (441300, '惠州市', '', '广东省,惠州市', 440000, 2, 0, '', 301);
INSERT INTO `wp_city` VALUES (441400, '梅州市', '', '广东省,梅州市', 440000, 2, 0, '', 141);
INSERT INTO `wp_city` VALUES (441500, '汕尾市', '', '广东省,汕尾市', 440000, 2, 0, '', 339);
INSERT INTO `wp_city` VALUES (441600, '河源市', '', '广东省,河源市', 440000, 2, 0, '', 200);
INSERT INTO `wp_city` VALUES (441700, '阳江市', '', '广东省,阳江市', 440000, 2, 0, '', 199);
INSERT INTO `wp_city` VALUES (441800, '清远市', '', '广东省,清远市', 440000, 2, 0, '', 197);
INSERT INTO `wp_city` VALUES (441900, '东莞市', '', '广东省,东莞市', 440000, 2, 0, '', 119);
INSERT INTO `wp_city` VALUES (442000, '中山市', '', '广东省,中山市', 440000, 2, 0, '', 187);
INSERT INTO `wp_city` VALUES (445100, '潮州市', '', '广东省,潮州市', 440000, 2, 0, '', 201);
INSERT INTO `wp_city` VALUES (445200, '揭阳市', '', '广东省,揭阳市', 440000, 2, 0, '', 259);
INSERT INTO `wp_city` VALUES (445300, '云浮市', '', '广东省,云浮市', 440000, 2, 0, '', 258);
INSERT INTO `wp_city` VALUES (450100, '南宁市', '', '广西壮族自治区,南宁市', 450000, 2, 0, '', 261);
INSERT INTO `wp_city` VALUES (450200, '柳州市', '', '广西壮族自治区,柳州市', 450000, 2, 0, '', 305);
INSERT INTO `wp_city` VALUES (450300, '桂林市', '', '广西壮族自治区,桂林市', 450000, 2, 0, '', 142);
INSERT INTO `wp_city` VALUES (450400, '梧州市', '', '广西壮族自治区,梧州市', 450000, 2, 0, '', 304);
INSERT INTO `wp_city` VALUES (450500, '北海市', '', '广西壮族自治区,北海市', 450000, 2, 0, '', 295);
INSERT INTO `wp_city` VALUES (450600, '防城港市', '', '广西壮族自治区,防城港市', 450000, 2, 0, '', 204);
INSERT INTO `wp_city` VALUES (450700, '钦州市', '', '广西壮族自治区,钦州市', 450000, 2, 0, '', 145);
INSERT INTO `wp_city` VALUES (450800, '贵港市', '', '广西壮族自治区,贵港市', 450000, 2, 0, '', 341);
INSERT INTO `wp_city` VALUES (450900, '玉林市', '', '广西壮族自治区,玉林市', 450000, 2, 0, '', 361);
INSERT INTO `wp_city` VALUES (451000, '百色市', '', '广西壮族自治区,百色市', 450000, 2, 0, '', 203);
INSERT INTO `wp_city` VALUES (451100, '贺州市', '', '广西壮族自治区,贺州市', 450000, 2, 0, '', 260);
INSERT INTO `wp_city` VALUES (451200, '河池市', '', '广西壮族自治区,河池市', 450000, 2, 0, '', 143);
INSERT INTO `wp_city` VALUES (451300, '来宾市', '', '广西壮族自治区,来宾市', 450000, 2, 0, '', 202);
INSERT INTO `wp_city` VALUES (451400, '崇左市', '', '广西壮族自治区,崇左市', 450000, 2, 0, '', 144);
INSERT INTO `wp_city` VALUES (460100, '海口市', '', '海南省,海口市', 460000, 2, 0, '', 125);
INSERT INTO `wp_city` VALUES (460200, '三亚市', '', '海南省,三亚市', 460000, 2, 0, '', 121);
INSERT INTO `wp_city` VALUES (469000, '省直辖县级行政单位', '', '海南省,省直辖县级行政单位', 460000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (500100, '市辖区', '', '重庆市,市辖区', 500000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (500200, '县', '', '重庆市,县', 500000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (500300, '市', '', '重庆市,市', 500000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (510100, '成都市', '', '四川省,成都市', 510000, 2, 0, '', 75);
INSERT INTO `wp_city` VALUES (510300, '自贡市', '', '四川省,自贡市', 510000, 2, 0, '', 78);
INSERT INTO `wp_city` VALUES (510400, '攀枝花市', '', '四川省,攀枝花市', 510000, 2, 0, '', 81);
INSERT INTO `wp_city` VALUES (510500, '泸州市', '', '四川省,泸州市', 510000, 2, 0, '', 331);
INSERT INTO `wp_city` VALUES (510600, '德阳市', '', '四川省,德阳市', 510000, 2, 0, '', 74);
INSERT INTO `wp_city` VALUES (510700, '绵阳市', '', '四川省,绵阳市', 510000, 2, 0, '', 240);
INSERT INTO `wp_city` VALUES (510800, '广元市', '', '四川省,广元市', 510000, 2, 0, '', 329);
INSERT INTO `wp_city` VALUES (510900, '遂宁市', '', '四川省,遂宁市', 510000, 2, 0, '', 330);
INSERT INTO `wp_city` VALUES (511000, '内江市', '', '四川省,内江市', 510000, 2, 0, '', 248);
INSERT INTO `wp_city` VALUES (511100, '乐山市', '', '四川省,乐山市', 510000, 2, 0, '', 79);
INSERT INTO `wp_city` VALUES (511300, '南充市', '', '四川省,南充市', 510000, 2, 0, '', 291);
INSERT INTO `wp_city` VALUES (511400, '眉山市', '', '四川省,眉山市', 510000, 2, 0, '', 77);
INSERT INTO `wp_city` VALUES (511500, '宜宾市', '', '四川省,宜宾市', 510000, 2, 0, '', 186);
INSERT INTO `wp_city` VALUES (511600, '广安市', '', '四川省,广安市', 510000, 2, 0, '', 241);
INSERT INTO `wp_city` VALUES (511700, '达州市', '', '四川省,达州市', 510000, 2, 0, '', 369);
INSERT INTO `wp_city` VALUES (511800, '雅安市', '', '四川省,雅安市', 510000, 2, 0, '', 76);
INSERT INTO `wp_city` VALUES (511900, '巴中市', '', '四川省,巴中市', 510000, 2, 0, '', 239);
INSERT INTO `wp_city` VALUES (512000, '资阳市', '', '四川省,资阳市', 510000, 2, 0, '', 242);
INSERT INTO `wp_city` VALUES (513200, '阿坝藏族羌族自治州', '', '四川省,阿坝藏族羌族自治州', 510000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (513300, '甘孜藏族自治州', '', '四川省,甘孜藏族自治州', 510000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (513400, '凉山彝族自治州', '', '四川省,凉山彝族自治州', 510000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (520100, '贵阳市', '', '贵州省,贵阳市', 520000, 2, 0, '', 146);
INSERT INTO `wp_city` VALUES (520200, '六盘水市', '', '贵州省,六盘水市', 520000, 2, 0, '', 147);
INSERT INTO `wp_city` VALUES (520300, '遵义市', '', '贵州省,遵义市', 520000, 2, 0, '', 262);
INSERT INTO `wp_city` VALUES (520400, '安顺市', '', '贵州省,安顺市', 520000, 2, 0, '', 263);
INSERT INTO `wp_city` VALUES (522200, '铜仁地区', '', '贵州省,铜仁地区', 520000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (522300, '黔西南布依族苗族自治州', '', '贵州省,黔西南布依族苗族自治州', 520000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (522400, '毕节地区', '', '贵州省,毕节地区', 520000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (522600, '黔东南苗族侗族自治州', '', '贵州省,黔东南苗族侗族自治州', 520000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (522700, '黔南布依族苗族自治州', '', '贵州省,黔南布依族苗族自治州', 520000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (530100, '昆明市', '', '云南省,昆明市', 530000, 2, 0, '', 104);
INSERT INTO `wp_city` VALUES (530300, '曲靖市', '', '云南省,曲靖市', 530000, 2, 0, '', 249);
INSERT INTO `wp_city` VALUES (530400, '玉溪市', '', '云南省,玉溪市', 530000, 2, 0, '', 106);
INSERT INTO `wp_city` VALUES (530500, '保山市', '', '云南省,保山市', 530000, 2, 0, '', 112);
INSERT INTO `wp_city` VALUES (530600, '昭通市', '', '云南省,昭通市', 530000, 2, 0, '', 336);
INSERT INTO `wp_city` VALUES (530700, '丽江市', '', '云南省,丽江市', 530000, 2, 0, '', 114);
INSERT INTO `wp_city` VALUES (530800, '思茅市', '', '云南省,思茅市', 530000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (530900, '临沧市', '', '云南省,临沧市', 530000, 2, 0, '', 110);
INSERT INTO `wp_city` VALUES (532300, '楚雄彝族自治州', '', '云南省,楚雄彝族自治州', 530000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (532500, '红河哈尼族彝族自治州', '', '云南省,红河哈尼族彝族自治州', 530000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (532600, '文山壮族苗族自治州', '', '云南省,文山壮族苗族自治州', 530000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (532800, '西双版纳傣族自治州', '', '云南省,西双版纳傣族自治州', 530000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (532900, '大理白族自治州', '', '云南省,大理白族自治州', 530000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (533100, '德宏傣族景颇族自治州', '', '云南省,德宏傣族景颇族自治州', 530000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (533300, '怒江傈僳族自治州', '', '云南省,怒江傈僳族自治州', 530000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (533400, '迪庆藏族自治州', '', '云南省,迪庆藏族自治州', 530000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (540100, '拉萨市', '', '西藏自治区,拉萨市', 540000, 2, 0, '', 100);
INSERT INTO `wp_city` VALUES (542100, '昌都地区', '', '西藏自治区,昌都地区', 540000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (542200, '山南地区', '', '西藏自治区,山南地区', 540000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (542300, '日喀则地区', '', '西藏自治区,日喀则地区', 540000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (542400, '那曲地区', '', '西藏自治区,那曲地区', 540000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (542500, '阿里地区', '', '西藏自治区,阿里地区', 540000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (542600, '林芝地区', '', '西藏自治区,林芝地区', 540000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (610100, '西安市', '', '陕西省,西安市', 610000, 2, 0, '', 233);
INSERT INTO `wp_city` VALUES (610200, '铜川市', '', '陕西省,铜川市', 610000, 2, 0, '', 232);
INSERT INTO `wp_city` VALUES (610300, '宝鸡市', '', '陕西省,宝鸡市', 610000, 2, 0, '', 171);
INSERT INTO `wp_city` VALUES (610400, '咸阳市', '', '陕西省,咸阳市', 610000, 2, 0, '', 323);
INSERT INTO `wp_city` VALUES (610500, '渭南市', '', '陕西省,渭南市', 610000, 2, 0, '', 170);
INSERT INTO `wp_city` VALUES (610600, '延安市', '', '陕西省,延安市', 610000, 2, 0, '', 284);
INSERT INTO `wp_city` VALUES (610700, '汉中市', '', '陕西省,汉中市', 610000, 2, 0, '', 352);
INSERT INTO `wp_city` VALUES (610800, '榆林市', '', '陕西省,榆林市', 610000, 2, 0, '', 231);
INSERT INTO `wp_city` VALUES (610900, '安康市', '', '陕西省,安康市', 610000, 2, 0, '', 324);
INSERT INTO `wp_city` VALUES (611000, '商洛市', '', '陕西省,商洛市', 610000, 2, 0, '', 285);
INSERT INTO `wp_city` VALUES (620100, '兰州市', '', '甘肃省,兰州市', 620000, 2, 0, '', 36);
INSERT INTO `wp_city` VALUES (620200, '嘉峪关市', '', '甘肃省,嘉峪关市', 620000, 2, 0, '', 33);
INSERT INTO `wp_city` VALUES (620300, '金昌市', '', '甘肃省,金昌市', 620000, 2, 0, '', 34);
INSERT INTO `wp_city` VALUES (620400, '白银市', '', '甘肃省,白银市', 620000, 2, 0, '', 35);
INSERT INTO `wp_city` VALUES (620500, '天水市', '', '甘肃省,天水市', 620000, 2, 0, '', 196);
INSERT INTO `wp_city` VALUES (620600, '武威市', '', '甘肃省,武威市', 620000, 2, 0, '', 118);
INSERT INTO `wp_city` VALUES (620700, '张掖市', '', '甘肃省,张掖市', 620000, 2, 0, '', 117);
INSERT INTO `wp_city` VALUES (620800, '平凉市', '', '甘肃省,平凉市', 620000, 2, 0, '', 359);
INSERT INTO `wp_city` VALUES (620900, '酒泉市', '', '甘肃省,酒泉市', 620000, 2, 0, '', 37);
INSERT INTO `wp_city` VALUES (621000, '庆阳市', '', '甘肃省,庆阳市', 620000, 2, 0, '', 135);
INSERT INTO `wp_city` VALUES (621100, '定西市', '', '甘肃省,定西市', 620000, 2, 0, '', 136);
INSERT INTO `wp_city` VALUES (621200, '陇南市', '', '甘肃省,陇南市', 620000, 2, 0, '', 256);
INSERT INTO `wp_city` VALUES (622900, '临夏回族自治州', '', '甘肃省,临夏回族自治州', 620000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (623000, '甘南藏族自治州', '', '甘肃省,甘南藏族自治州', 620000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (630100, '西宁市', '', '青海省,西宁市', 630000, 2, 0, '', 66);
INSERT INTO `wp_city` VALUES (632100, '海东地区', '', '青海省,海东地区', 630000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (632200, '海北藏族自治州', '', '青海省,海北藏族自治州', 630000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (632300, '黄南藏族自治州', '', '青海省,黄南藏族自治州', 630000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (632500, '海南藏族自治州', '', '青海省,海南藏族自治州', 630000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (632600, '果洛藏族自治州', '', '青海省,果洛藏族自治州', 630000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (632700, '玉树藏族自治州', '', '青海省,玉树藏族自治州', 630000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (632800, '海西蒙古族藏族自治州', '', '青海省,海西蒙古族藏族自治州', 630000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (640100, '银川市', '', '宁夏回族自治区,银川市', 640000, 2, 0, '', 360);
INSERT INTO `wp_city` VALUES (640200, '石嘴山市', '', '宁夏回族自治区,石嘴山市', 640000, 2, 0, '', 335);
INSERT INTO `wp_city` VALUES (640300, '吴忠市', '', '宁夏回族自治区,吴忠市', 640000, 2, 0, '', 322);
INSERT INTO `wp_city` VALUES (640400, '固原市', '', '宁夏回族自治区,固原市', 640000, 2, 0, '', 246);
INSERT INTO `wp_city` VALUES (640500, '中卫市', '', '宁夏回族自治区,中卫市', 640000, 2, 0, '', 181);
INSERT INTO `wp_city` VALUES (650100, '乌鲁木齐市', '', '新疆维吾尔自治区,乌鲁木齐市', 650000, 2, 0, '', 92);
INSERT INTO `wp_city` VALUES (650200, '克拉玛依市', '', '新疆维吾尔自治区,克拉玛依市', 650000, 2, 0, '', 95);
INSERT INTO `wp_city` VALUES (652100, '吐鲁番地区', '', '新疆维吾尔自治区,吐鲁番地区', 650000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (652200, '哈密地区', '', '新疆维吾尔自治区,哈密地区', 650000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (652300, '昌吉回族自治州', '', '新疆维吾尔自治区,昌吉回族自治州', 650000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (652700, '博尔塔拉蒙古自治州', '', '新疆维吾尔自治区,博尔塔拉蒙古自治州', 650000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (652800, '巴音郭楞蒙古自治州', '', '新疆维吾尔自治区,巴音郭楞蒙古自治州', 650000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (652900, '阿克苏地区', '', '新疆维吾尔自治区,阿克苏地区', 650000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (653000, '克孜勒苏柯尔克孜自治州', '', '新疆维吾尔自治区,克孜勒苏柯尔克孜自治州', 650000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (653100, '喀什地区', '', '新疆维吾尔自治区,喀什地区', 650000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (653200, '和田地区', '', '新疆维吾尔自治区,和田地区', 650000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (654000, '伊犁哈萨克自治州', '', '新疆维吾尔自治区,伊犁哈萨克自治州', 650000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (654200, '塔城地区', '', '新疆维吾尔自治区,塔城地区', 650000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (654300, '阿勒泰地区', '', '新疆维吾尔自治区,阿勒泰地区', 650000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (659000, '省直辖行政单位', '', '新疆维吾尔自治区,省直辖行政单位', 650000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (110101, '东城区', '', '北京市,北京市,东城区', 110100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (110102, '西城区', '', '北京市,北京市,西城区', 110100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (110103, '崇文区', '', '北京市,北京市,崇文区', 110100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (110104, '宣武区', '', '北京市,北京市,宣武区', 110100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (110105, '朝阳区', '', '北京市,北京市,朝阳区', 110100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (110106, '丰台区', '', '北京市,北京市,丰台区', 110100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (110107, '石景山区', '', '北京市,北京市,石景山区', 110100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (110108, '海淀区', '', '北京市,北京市,海淀区', 110100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (110109, '门头沟区', '', '北京市,北京市,门头沟区', 110100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (110111, '房山区', '', '北京市,北京市,房山区', 110100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (110112, '通州区', '', '北京市,北京市,通州区', 110100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (110113, '顺义区', '', '北京市,北京市,顺义区', 110100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (110114, '昌平区', '', '北京市,北京市,昌平区', 110100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (110115, '大兴区', '', '北京市,北京市,大兴区', 110100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (110116, '怀柔区', '', '北京市,北京市,怀柔区', 110100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (110117, '平谷区', '', '北京市,北京市,平谷区', 110100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (110228, '密云县', '', '北京市,县,密云县', 110200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (110229, '延庆县', '', '北京市,县,延庆县', 110200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (120101, '和平区', '', '天津市,市辖区,和平区', 120100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (120102, '河东区', '', '天津市,市辖区,河东区', 120100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (120103, '河西区', '', '天津市,市辖区,河西区', 120100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (120104, '南开区', '', '天津市,市辖区,南开区', 120100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (120105, '河北区', '', '天津市,市辖区,河北区', 120100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (120106, '红桥区', '', '天津市,市辖区,红桥区', 120100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (120107, '塘沽区', '', '天津市,市辖区,塘沽区', 120100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (120108, '汉沽区', '', '天津市,市辖区,汉沽区', 120100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (120109, '大港区', '', '天津市,市辖区,大港区', 120100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (120110, '东丽区', '', '天津市,市辖区,东丽区', 120100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (120111, '西青区', '', '天津市,市辖区,西青区', 120100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (120112, '津南区', '', '天津市,市辖区,津南区', 120100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (120113, '北辰区', '', '天津市,市辖区,北辰区', 120100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (120114, '武清区', '', '天津市,市辖区,武清区', 120100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (120115, '宝坻区', '', '天津市,市辖区,宝坻区', 120100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (120221, '宁河县', '', '天津市,县,宁河县', 120200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (120223, '静海县', '', '天津市,县,静海县', 120200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (120225, '蓟　县', '', '天津市,县,蓟　县', 120200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130101, '市辖区', '', '河北省,石家庄市,市辖区', 130100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130102, '长安区', '', '河北省,石家庄市,长安区', 130100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130103, '桥东区', '', '河北省,石家庄市,桥东区', 130100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130104, '桥西区', '', '河北省,石家庄市,桥西区', 130100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130105, '新华区', '', '河北省,石家庄市,新华区', 130100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130107, '井陉矿区', '', '河北省,石家庄市,井陉矿区', 130100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130108, '裕华区', '', '河北省,石家庄市,裕华区', 130100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130121, '井陉县', '', '河北省,石家庄市,井陉县', 130100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130123, '正定县', '', '河北省,石家庄市,正定县', 130100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130124, '栾城县', '', '河北省,石家庄市,栾城县', 130100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130125, '行唐县', '', '河北省,石家庄市,行唐县', 130100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130126, '灵寿县', '', '河北省,石家庄市,灵寿县', 130100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130127, '高邑县', '', '河北省,石家庄市,高邑县', 130100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130128, '深泽县', '', '河北省,石家庄市,深泽县', 130100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130129, '赞皇县', '', '河北省,石家庄市,赞皇县', 130100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130130, '无极县', '', '河北省,石家庄市,无极县', 130100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130131, '平山县', '', '河北省,石家庄市,平山县', 130100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130132, '元氏县', '', '河北省,石家庄市,元氏县', 130100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130133, '赵　县', '', '河北省,石家庄市,赵　县', 130100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130181, '辛集市', '', '河北省,石家庄市,辛集市', 130100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130182, '藁城市', '', '河北省,石家庄市,藁城市', 130100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130183, '晋州市', '', '河北省,石家庄市,晋州市', 130100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130184, '新乐市', '', '河北省,石家庄市,新乐市', 130100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130185, '鹿泉市', '', '河北省,石家庄市,鹿泉市', 130100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130201, '市辖区', '', '河北省,唐山市,市辖区', 130200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130202, '路南区', '', '河北省,唐山市,路南区', 130200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130203, '路北区', '', '河北省,唐山市,路北区', 130200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130204, '古冶区', '', '河北省,唐山市,古冶区', 130200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130205, '开平区', '', '河北省,唐山市,开平区', 130200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130207, '丰南区', '', '河北省,唐山市,丰南区', 130200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130208, '丰润区', '', '河北省,唐山市,丰润区', 130200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130223, '滦　县', '', '河北省,唐山市,滦　县', 130200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130224, '滦南县', '', '河北省,唐山市,滦南县', 130200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130225, '乐亭县', '', '河北省,唐山市,乐亭县', 130200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130227, '迁西县', '', '河北省,唐山市,迁西县', 130200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130229, '玉田县', '', '河北省,唐山市,玉田县', 130200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130230, '唐海县', '', '河北省,唐山市,唐海县', 130200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130281, '遵化市', '', '河北省,唐山市,遵化市', 130200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130283, '迁安市', '', '河北省,唐山市,迁安市', 130200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130301, '市辖区', '', '河北省,秦皇岛市,市辖区', 130300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130302, '海港区', '', '河北省,秦皇岛市,海港区', 130300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130303, '山海关区', '', '河北省,秦皇岛市,山海关区', 130300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130304, '北戴河区', '', '河北省,秦皇岛市,北戴河区', 130300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130321, '青龙满族自治县', '', '河北省,秦皇岛市,青龙满族自治县', 130300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130322, '昌黎县', '', '河北省,秦皇岛市,昌黎县', 130300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130323, '抚宁县', '', '河北省,秦皇岛市,抚宁县', 130300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130324, '卢龙县', '', '河北省,秦皇岛市,卢龙县', 130300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130401, '市辖区', '', '河北省,邯郸市,市辖区', 130400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130402, '邯山区', '', '河北省,邯郸市,邯山区', 130400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130403, '丛台区', '', '河北省,邯郸市,丛台区', 130400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130404, '复兴区', '', '河北省,邯郸市,复兴区', 130400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130406, '峰峰矿区', '', '河北省,邯郸市,峰峰矿区', 130400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130421, '邯郸县', '', '河北省,邯郸市,邯郸县', 130400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130423, '临漳县', '', '河北省,邯郸市,临漳县', 130400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130424, '成安县', '', '河北省,邯郸市,成安县', 130400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130425, '大名县', '', '河北省,邯郸市,大名县', 130400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130426, '涉　县', '', '河北省,邯郸市,涉　县', 130400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130427, '磁　县', '', '河北省,邯郸市,磁　县', 130400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130428, '肥乡县', '', '河北省,邯郸市,肥乡县', 130400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130429, '永年县', '', '河北省,邯郸市,永年县', 130400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130430, '邱　县', '', '河北省,邯郸市,邱　县', 130400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130431, '鸡泽县', '', '河北省,邯郸市,鸡泽县', 130400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130432, '广平县', '', '河北省,邯郸市,广平县', 130400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130433, '馆陶县', '', '河北省,邯郸市,馆陶县', 130400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130434, '魏　县', '', '河北省,邯郸市,魏　县', 130400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130435, '曲周县', '', '河北省,邯郸市,曲周县', 130400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130481, '武安市', '', '河北省,邯郸市,武安市', 130400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130501, '市辖区', '', '河北省,邢台市,市辖区', 130500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130502, '桥东区', '', '河北省,邢台市,桥东区', 130500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130503, '桥西区', '', '河北省,邢台市,桥西区', 130500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130521, '邢台县', '', '河北省,邢台市,邢台县', 130500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130522, '临城县', '', '河北省,邢台市,临城县', 130500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130523, '内丘县', '', '河北省,邢台市,内丘县', 130500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130524, '柏乡县', '', '河北省,邢台市,柏乡县', 130500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130525, '隆尧县', '', '河北省,邢台市,隆尧县', 130500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130526, '任　县', '', '河北省,邢台市,任　县', 130500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130527, '南和县', '', '河北省,邢台市,南和县', 130500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130528, '宁晋县', '', '河北省,邢台市,宁晋县', 130500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130529, '巨鹿县', '', '河北省,邢台市,巨鹿县', 130500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130530, '新河县', '', '河北省,邢台市,新河县', 130500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130531, '广宗县', '', '河北省,邢台市,广宗县', 130500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130532, '平乡县', '', '河北省,邢台市,平乡县', 130500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130533, '威　县', '', '河北省,邢台市,威　县', 130500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130534, '清河县', '', '河北省,邢台市,清河县', 130500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130535, '临西县', '', '河北省,邢台市,临西县', 130500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130581, '南宫市', '', '河北省,邢台市,南宫市', 130500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130582, '沙河市', '', '河北省,邢台市,沙河市', 130500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130601, '市辖区', '', '河北省,保定市,市辖区', 130600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130602, '新市区', '', '河北省,保定市,新市区', 130600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130603, '北市区', '', '河北省,保定市,北市区', 130600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130604, '南市区', '', '河北省,保定市,南市区', 130600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130621, '满城县', '', '河北省,保定市,满城县', 130600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130622, '清苑县', '', '河北省,保定市,清苑县', 130600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130623, '涞水县', '', '河北省,保定市,涞水县', 130600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130624, '阜平县', '', '河北省,保定市,阜平县', 130600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130625, '徐水县', '', '河北省,保定市,徐水县', 130600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130626, '定兴县', '', '河北省,保定市,定兴县', 130600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130627, '唐　县', '', '河北省,保定市,唐　县', 130600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130628, '高阳县', '', '河北省,保定市,高阳县', 130600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130629, '容城县', '', '河北省,保定市,容城县', 130600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130630, '涞源县', '', '河北省,保定市,涞源县', 130600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130631, '望都县', '', '河北省,保定市,望都县', 130600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130632, '安新县', '', '河北省,保定市,安新县', 130600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130633, '易　县', '', '河北省,保定市,易　县', 130600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130634, '曲阳县', '', '河北省,保定市,曲阳县', 130600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130635, '蠡　县', '', '河北省,保定市,蠡　县', 130600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130636, '顺平县', '', '河北省,保定市,顺平县', 130600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130637, '博野县', '', '河北省,保定市,博野县', 130600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130638, '雄　县', '', '河北省,保定市,雄　县', 130600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130681, '涿州市', '', '河北省,保定市,涿州市', 130600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130682, '定州市', '', '河北省,保定市,定州市', 130600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130683, '安国市', '', '河北省,保定市,安国市', 130600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130684, '高碑店市', '', '河北省,保定市,高碑店市', 130600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130701, '市辖区', '', '河北省,张家口市,市辖区', 130700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130702, '桥东区', '', '河北省,张家口市,桥东区', 130700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130703, '桥西区', '', '河北省,张家口市,桥西区', 130700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130705, '宣化区', '', '河北省,张家口市,宣化区', 130700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130706, '下花园区', '', '河北省,张家口市,下花园区', 130700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130721, '宣化县', '', '河北省,张家口市,宣化县', 130700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130722, '张北县', '', '河北省,张家口市,张北县', 130700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130723, '康保县', '', '河北省,张家口市,康保县', 130700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130724, '沽源县', '', '河北省,张家口市,沽源县', 130700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130725, '尚义县', '', '河北省,张家口市,尚义县', 130700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130726, '蔚　县', '', '河北省,张家口市,蔚　县', 130700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130727, '阳原县', '', '河北省,张家口市,阳原县', 130700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130728, '怀安县', '', '河北省,张家口市,怀安县', 130700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130729, '万全县', '', '河北省,张家口市,万全县', 130700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130730, '怀来县', '', '河北省,张家口市,怀来县', 130700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130731, '涿鹿县', '', '河北省,张家口市,涿鹿县', 130700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130732, '赤城县', '', '河北省,张家口市,赤城县', 130700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130733, '崇礼县', '', '河北省,张家口市,崇礼县', 130700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130801, '市辖区', '', '河北省,承德市,市辖区', 130800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130802, '双桥区', '', '河北省,承德市,双桥区', 130800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130803, '双滦区', '', '河北省,承德市,双滦区', 130800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130804, '鹰手营子矿区', '', '河北省,承德市,鹰手营子矿区', 130800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130821, '承德县', '', '河北省,承德市,承德县', 130800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130822, '兴隆县', '', '河北省,承德市,兴隆县', 130800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130823, '平泉县', '', '河北省,承德市,平泉县', 130800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130824, '滦平县', '', '河北省,承德市,滦平县', 130800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130825, '隆化县', '', '河北省,承德市,隆化县', 130800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130826, '丰宁满族自治县', '', '河北省,承德市,丰宁满族自治县', 130800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130827, '宽城满族自治县', '', '河北省,承德市,宽城满族自治县', 130800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130828, '围场满族蒙古族自治县', '', '河北省,承德市,围场满族蒙古族自治县', 130800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130901, '市辖区', '', '河北省,沧州市,市辖区', 130900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130902, '新华区', '', '河北省,沧州市,新华区', 130900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130903, '运河区', '', '河北省,沧州市,运河区', 130900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130921, '沧　县', '', '河北省,沧州市,沧　县', 130900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130922, '青　县', '', '河北省,沧州市,青　县', 130900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130923, '东光县', '', '河北省,沧州市,东光县', 130900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130924, '海兴县', '', '河北省,沧州市,海兴县', 130900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130925, '盐山县', '', '河北省,沧州市,盐山县', 130900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130926, '肃宁县', '', '河北省,沧州市,肃宁县', 130900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130927, '南皮县', '', '河北省,沧州市,南皮县', 130900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130928, '吴桥县', '', '河北省,沧州市,吴桥县', 130900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130929, '献　县', '', '河北省,沧州市,献　县', 130900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130930, '孟村回族自治县', '', '河北省,沧州市,孟村回族自治县', 130900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130981, '泊头市', '', '河北省,沧州市,泊头市', 130900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130982, '任丘市', '', '河北省,沧州市,任丘市', 130900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130983, '黄骅市', '', '河北省,沧州市,黄骅市', 130900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (130984, '河间市', '', '河北省,沧州市,河间市', 130900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (131001, '市辖区', '', '河北省,廊坊市,市辖区', 131000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (131002, '安次区', '', '河北省,廊坊市,安次区', 131000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (131003, '广阳区', '', '河北省,廊坊市,广阳区', 131000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (131022, '固安县', '', '河北省,廊坊市,固安县', 131000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (131023, '永清县', '', '河北省,廊坊市,永清县', 131000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (131024, '香河县', '', '河北省,廊坊市,香河县', 131000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (131025, '大城县', '', '河北省,廊坊市,大城县', 131000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (131026, '文安县', '', '河北省,廊坊市,文安县', 131000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (131028, '大厂回族自治县', '', '河北省,廊坊市,大厂回族自治县', 131000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (131081, '霸州市', '', '河北省,廊坊市,霸州市', 131000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (131082, '三河市', '', '河北省,廊坊市,三河市', 131000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (131101, '市辖区', '', '河北省,衡水市,市辖区', 131100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (131102, '桃城区', '', '河北省,衡水市,桃城区', 131100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (131121, '枣强县', '', '河北省,衡水市,枣强县', 131100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (131122, '武邑县', '', '河北省,衡水市,武邑县', 131100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (131123, '武强县', '', '河北省,衡水市,武强县', 131100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (131124, '饶阳县', '', '河北省,衡水市,饶阳县', 131100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (131125, '安平县', '', '河北省,衡水市,安平县', 131100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (131126, '故城县', '', '河北省,衡水市,故城县', 131100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (131127, '景　县', '', '河北省,衡水市,景　县', 131100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (131128, '阜城县', '', '河北省,衡水市,阜城县', 131100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (131181, '冀州市', '', '河北省,衡水市,冀州市', 131100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (131182, '深州市', '', '河北省,衡水市,深州市', 131100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140101, '市辖区', '', '山西省,太原市,市辖区', 140100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140105, '小店区', '', '山西省,太原市,小店区', 140100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140106, '迎泽区', '', '山西省,太原市,迎泽区', 140100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140107, '杏花岭区', '', '山西省,太原市,杏花岭区', 140100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140108, '尖草坪区', '', '山西省,太原市,尖草坪区', 140100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140109, '万柏林区', '', '山西省,太原市,万柏林区', 140100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140110, '晋源区', '', '山西省,太原市,晋源区', 140100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140121, '清徐县', '', '山西省,太原市,清徐县', 140100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140122, '阳曲县', '', '山西省,太原市,阳曲县', 140100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140123, '娄烦县', '', '山西省,太原市,娄烦县', 140100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140181, '古交市', '', '山西省,太原市,古交市', 140100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140201, '市辖区', '', '山西省,大同市,市辖区', 140200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140202, '城　区', '', '山西省,大同市,城　区', 140200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140203, '矿　区', '', '山西省,大同市,矿　区', 140200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140211, '南郊区', '', '山西省,大同市,南郊区', 140200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140212, '新荣区', '', '山西省,大同市,新荣区', 140200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140221, '阳高县', '', '山西省,大同市,阳高县', 140200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140222, '天镇县', '', '山西省,大同市,天镇县', 140200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140223, '广灵县', '', '山西省,大同市,广灵县', 140200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140224, '灵丘县', '', '山西省,大同市,灵丘县', 140200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140225, '浑源县', '', '山西省,大同市,浑源县', 140200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140226, '左云县', '', '山西省,大同市,左云县', 140200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140227, '大同县', '', '山西省,大同市,大同县', 140200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140301, '市辖区', '', '山西省,阳泉市,市辖区', 140300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140302, '城　区', '', '山西省,阳泉市,城　区', 140300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140303, '矿　区', '', '山西省,阳泉市,矿　区', 140300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140311, '郊　区', '', '山西省,阳泉市,郊　区', 140300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140321, '平定县', '', '山西省,阳泉市,平定县', 140300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140322, '盂　县', '', '山西省,阳泉市,盂　县', 140300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140401, '市辖区', '', '山西省,长治市,市辖区', 140400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140402, '城　区', '', '山西省,长治市,城　区', 140400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140411, '郊　区', '', '山西省,长治市,郊　区', 140400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140421, '长治县', '', '山西省,长治市,长治县', 140400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140423, '襄垣县', '', '山西省,长治市,襄垣县', 140400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140424, '屯留县', '', '山西省,长治市,屯留县', 140400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140425, '平顺县', '', '山西省,长治市,平顺县', 140400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140426, '黎城县', '', '山西省,长治市,黎城县', 140400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140427, '壶关县', '', '山西省,长治市,壶关县', 140400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140428, '长子县', '', '山西省,长治市,长子县', 140400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140429, '武乡县', '', '山西省,长治市,武乡县', 140400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140430, '沁　县', '', '山西省,长治市,沁　县', 140400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140431, '沁源县', '', '山西省,长治市,沁源县', 140400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140481, '潞城市', '', '山西省,长治市,潞城市', 140400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140501, '市辖区', '', '山西省,晋城市,市辖区', 140500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140502, '城　区', '', '山西省,晋城市,城　区', 140500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140521, '沁水县', '', '山西省,晋城市,沁水县', 140500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140522, '阳城县', '', '山西省,晋城市,阳城县', 140500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140524, '陵川县', '', '山西省,晋城市,陵川县', 140500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140525, '泽州县', '', '山西省,晋城市,泽州县', 140500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140581, '高平市', '', '山西省,晋城市,高平市', 140500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140601, '市辖区', '', '山西省,朔州市,市辖区', 140600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140602, '朔城区', '', '山西省,朔州市,朔城区', 140600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140603, '平鲁区', '', '山西省,朔州市,平鲁区', 140600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140621, '山阴县', '', '山西省,朔州市,山阴县', 140600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140622, '应　县', '', '山西省,朔州市,应　县', 140600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140623, '右玉县', '', '山西省,朔州市,右玉县', 140600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140624, '怀仁县', '', '山西省,朔州市,怀仁县', 140600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140701, '市辖区', '', '山西省,晋中市,市辖区', 140700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140702, '榆次区', '', '山西省,晋中市,榆次区', 140700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140721, '榆社县', '', '山西省,晋中市,榆社县', 140700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140722, '左权县', '', '山西省,晋中市,左权县', 140700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140723, '和顺县', '', '山西省,晋中市,和顺县', 140700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140724, '昔阳县', '', '山西省,晋中市,昔阳县', 140700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140725, '寿阳县', '', '山西省,晋中市,寿阳县', 140700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140726, '太谷县', '', '山西省,晋中市,太谷县', 140700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140727, '祁　县', '', '山西省,晋中市,祁　县', 140700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140728, '平遥县', '', '山西省,晋中市,平遥县', 140700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140729, '灵石县', '', '山西省,晋中市,灵石县', 140700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140781, '介休市', '', '山西省,晋中市,介休市', 140700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140801, '市辖区', '', '山西省,运城市,市辖区', 140800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140802, '盐湖区', '', '山西省,运城市,盐湖区', 140800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140821, '临猗县', '', '山西省,运城市,临猗县', 140800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140822, '万荣县', '', '山西省,运城市,万荣县', 140800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140823, '闻喜县', '', '山西省,运城市,闻喜县', 140800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140824, '稷山县', '', '山西省,运城市,稷山县', 140800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140825, '新绛县', '', '山西省,运城市,新绛县', 140800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140826, '绛　县', '', '山西省,运城市,绛　县', 140800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140827, '垣曲县', '', '山西省,运城市,垣曲县', 140800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140828, '夏　县', '', '山西省,运城市,夏　县', 140800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140829, '平陆县', '', '山西省,运城市,平陆县', 140800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140830, '芮城县', '', '山西省,运城市,芮城县', 140800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140881, '永济市', '', '山西省,运城市,永济市', 140800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140882, '河津市', '', '山西省,运城市,河津市', 140800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140901, '市辖区', '', '山西省,忻州市,市辖区', 140900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140902, '忻府区', '', '山西省,忻州市,忻府区', 140900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140921, '定襄县', '', '山西省,忻州市,定襄县', 140900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140922, '五台县', '', '山西省,忻州市,五台县', 140900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140923, '代　县', '', '山西省,忻州市,代　县', 140900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140924, '繁峙县', '', '山西省,忻州市,繁峙县', 140900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140925, '宁武县', '', '山西省,忻州市,宁武县', 140900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140926, '静乐县', '', '山西省,忻州市,静乐县', 140900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140927, '神池县', '', '山西省,忻州市,神池县', 140900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140928, '五寨县', '', '山西省,忻州市,五寨县', 140900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140929, '岢岚县', '', '山西省,忻州市,岢岚县', 140900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140930, '河曲县', '', '山西省,忻州市,河曲县', 140900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140931, '保德县', '', '山西省,忻州市,保德县', 140900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140932, '偏关县', '', '山西省,忻州市,偏关县', 140900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (140981, '原平市', '', '山西省,忻州市,原平市', 140900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141001, '市辖区', '', '山西省,临汾市,市辖区', 141000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141002, '尧都区', '', '山西省,临汾市,尧都区', 141000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141021, '曲沃县', '', '山西省,临汾市,曲沃县', 141000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141022, '翼城县', '', '山西省,临汾市,翼城县', 141000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141023, '襄汾县', '', '山西省,临汾市,襄汾县', 141000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141024, '洪洞县', '', '山西省,临汾市,洪洞县', 141000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141025, '古　县', '', '山西省,临汾市,古　县', 141000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141026, '安泽县', '', '山西省,临汾市,安泽县', 141000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141027, '浮山县', '', '山西省,临汾市,浮山县', 141000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141028, '吉　县', '', '山西省,临汾市,吉　县', 141000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141029, '乡宁县', '', '山西省,临汾市,乡宁县', 141000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141030, '大宁县', '', '山西省,临汾市,大宁县', 141000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141031, '隰　县', '', '山西省,临汾市,隰　县', 141000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141032, '永和县', '', '山西省,临汾市,永和县', 141000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141033, '蒲　县', '', '山西省,临汾市,蒲　县', 141000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141034, '汾西县', '', '山西省,临汾市,汾西县', 141000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141081, '侯马市', '', '山西省,临汾市,侯马市', 141000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141082, '霍州市', '', '山西省,临汾市,霍州市', 141000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141101, '市辖区', '', '山西省,吕梁市,市辖区', 141100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141102, '离石区', '', '山西省,吕梁市,离石区', 141100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141121, '文水县', '', '山西省,吕梁市,文水县', 141100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141122, '交城县', '', '山西省,吕梁市,交城县', 141100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141123, '兴　县', '', '山西省,吕梁市,兴　县', 141100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141124, '临　县', '', '山西省,吕梁市,临　县', 141100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141125, '柳林县', '', '山西省,吕梁市,柳林县', 141100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141126, '石楼县', '', '山西省,吕梁市,石楼县', 141100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141127, '岚　县', '', '山西省,吕梁市,岚　县', 141100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141128, '方山县', '', '山西省,吕梁市,方山县', 141100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141129, '中阳县', '', '山西省,吕梁市,中阳县', 141100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141130, '交口县', '', '山西省,吕梁市,交口县', 141100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141181, '孝义市', '', '山西省,吕梁市,孝义市', 141100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (141182, '汾阳市', '', '山西省,吕梁市,汾阳市', 141100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150101, '市辖区', '', '内蒙古自治区,呼和浩特市,市辖区', 150100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150102, '新城区', '', '内蒙古自治区,呼和浩特市,新城区', 150100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150103, '回民区', '', '内蒙古自治区,呼和浩特市,回民区', 150100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150104, '玉泉区', '', '内蒙古自治区,呼和浩特市,玉泉区', 150100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150105, '赛罕区', '', '内蒙古自治区,呼和浩特市,赛罕区', 150100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150121, '土默特左旗', '', '内蒙古自治区,呼和浩特市,土默特左旗', 150100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150122, '托克托县', '', '内蒙古自治区,呼和浩特市,托克托县', 150100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150123, '和林格尔县', '', '内蒙古自治区,呼和浩特市,和林格尔县', 150100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150124, '清水河县', '', '内蒙古自治区,呼和浩特市,清水河县', 150100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150125, '武川县', '', '内蒙古自治区,呼和浩特市,武川县', 150100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150201, '市辖区', '', '内蒙古自治区,包头市,市辖区', 150200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150202, '东河区', '', '内蒙古自治区,包头市,东河区', 150200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150203, '昆都仑区', '', '内蒙古自治区,包头市,昆都仑区', 150200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150204, '青山区', '', '内蒙古自治区,包头市,青山区', 150200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150205, '石拐区', '', '内蒙古自治区,包头市,石拐区', 150200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150206, '白云矿区', '', '内蒙古自治区,包头市,白云矿区', 150200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150207, '九原区', '', '内蒙古自治区,包头市,九原区', 150200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150221, '土默特右旗', '', '内蒙古自治区,包头市,土默特右旗', 150200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150222, '固阳县', '', '内蒙古自治区,包头市,固阳县', 150200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150223, '达尔罕茂明安联合旗', '', '内蒙古自治区,包头市,达尔罕茂明安联合旗', 150200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150301, '市辖区', '', '内蒙古自治区,乌海市,市辖区', 150300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150302, '海勃湾区', '', '内蒙古自治区,乌海市,海勃湾区', 150300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150303, '海南区', '', '内蒙古自治区,乌海市,海南区', 150300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150304, '乌达区', '', '内蒙古自治区,乌海市,乌达区', 150300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150401, '市辖区', '', '内蒙古自治区,赤峰市,市辖区', 150400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150402, '红山区', '', '内蒙古自治区,赤峰市,红山区', 150400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150403, '元宝山区', '', '内蒙古自治区,赤峰市,元宝山区', 150400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150404, '松山区', '', '内蒙古自治区,赤峰市,松山区', 150400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150421, '阿鲁科尔沁旗', '', '内蒙古自治区,赤峰市,阿鲁科尔沁旗', 150400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150422, '巴林左旗', '', '内蒙古自治区,赤峰市,巴林左旗', 150400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150423, '巴林右旗', '', '内蒙古自治区,赤峰市,巴林右旗', 150400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150424, '林西县', '', '内蒙古自治区,赤峰市,林西县', 150400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150425, '克什克腾旗', '', '内蒙古自治区,赤峰市,克什克腾旗', 150400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150426, '翁牛特旗', '', '内蒙古自治区,赤峰市,翁牛特旗', 150400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150428, '喀喇沁旗', '', '内蒙古自治区,赤峰市,喀喇沁旗', 150400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150429, '宁城县', '', '内蒙古自治区,赤峰市,宁城县', 150400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150430, '敖汉旗', '', '内蒙古自治区,赤峰市,敖汉旗', 150400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150501, '市辖区', '', '内蒙古自治区,通辽市,市辖区', 150500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150502, '科尔沁区', '', '内蒙古自治区,通辽市,科尔沁区', 150500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150521, '科尔沁左翼中旗', '', '内蒙古自治区,通辽市,科尔沁左翼中旗', 150500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150522, '科尔沁左翼后旗', '', '内蒙古自治区,通辽市,科尔沁左翼后旗', 150500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150523, '开鲁县', '', '内蒙古自治区,通辽市,开鲁县', 150500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150524, '库伦旗', '', '内蒙古自治区,通辽市,库伦旗', 150500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150525, '奈曼旗', '', '内蒙古自治区,通辽市,奈曼旗', 150500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150526, '扎鲁特旗', '', '内蒙古自治区,通辽市,扎鲁特旗', 150500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150581, '霍林郭勒市', '', '内蒙古自治区,通辽市,霍林郭勒市', 150500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150602, '东胜区', '', '内蒙古自治区,鄂尔多斯市,东胜区', 150600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150621, '达拉特旗', '', '内蒙古自治区,鄂尔多斯市,达拉特旗', 150600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150622, '准格尔旗', '', '内蒙古自治区,鄂尔多斯市,准格尔旗', 150600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150623, '鄂托克前旗', '', '内蒙古自治区,鄂尔多斯市,鄂托克前旗', 150600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150624, '鄂托克旗', '', '内蒙古自治区,鄂尔多斯市,鄂托克旗', 150600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150625, '杭锦旗', '', '内蒙古自治区,鄂尔多斯市,杭锦旗', 150600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150626, '乌审旗', '', '内蒙古自治区,鄂尔多斯市,乌审旗', 150600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150627, '伊金霍洛旗', '', '内蒙古自治区,鄂尔多斯市,伊金霍洛旗', 150600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150701, '市辖区', '', '内蒙古自治区,呼伦贝尔市,市辖区', 150700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150702, '海拉尔区', '', '内蒙古自治区,呼伦贝尔市,海拉尔区', 150700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150721, '阿荣旗', '', '内蒙古自治区,呼伦贝尔市,阿荣旗', 150700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150722, '莫力达瓦达斡尔族自治旗', '', '内蒙古自治区,呼伦贝尔市,莫力达瓦达斡尔族自治旗', 150700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150723, '鄂伦春自治旗', '', '内蒙古自治区,呼伦贝尔市,鄂伦春自治旗', 150700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150724, '鄂温克族自治旗', '', '内蒙古自治区,呼伦贝尔市,鄂温克族自治旗', 150700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150725, '陈巴尔虎旗', '', '内蒙古自治区,呼伦贝尔市,陈巴尔虎旗', 150700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150726, '新巴尔虎左旗', '', '内蒙古自治区,呼伦贝尔市,新巴尔虎左旗', 150700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150727, '新巴尔虎右旗', '', '内蒙古自治区,呼伦贝尔市,新巴尔虎右旗', 150700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150781, '满洲里市', '', '内蒙古自治区,呼伦贝尔市,满洲里市', 150700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150782, '牙克石市', '', '内蒙古自治区,呼伦贝尔市,牙克石市', 150700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150783, '扎兰屯市', '', '内蒙古自治区,呼伦贝尔市,扎兰屯市', 150700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150784, '额尔古纳市', '', '内蒙古自治区,呼伦贝尔市,额尔古纳市', 150700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150785, '根河市', '', '内蒙古自治区,呼伦贝尔市,根河市', 150700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150801, '市辖区', '', '内蒙古自治区,巴彦淖尔市,市辖区', 150800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150802, '临河区', '', '内蒙古自治区,巴彦淖尔市,临河区', 150800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150821, '五原县', '', '内蒙古自治区,巴彦淖尔市,五原县', 150800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150822, '磴口县', '', '内蒙古自治区,巴彦淖尔市,磴口县', 150800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150823, '乌拉特前旗', '', '内蒙古自治区,巴彦淖尔市,乌拉特前旗', 150800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150824, '乌拉特中旗', '', '内蒙古自治区,巴彦淖尔市,乌拉特中旗', 150800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150825, '乌拉特后旗', '', '内蒙古自治区,巴彦淖尔市,乌拉特后旗', 150800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150826, '杭锦后旗', '', '内蒙古自治区,巴彦淖尔市,杭锦后旗', 150800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150901, '市辖区', '', '内蒙古自治区,乌兰察布市,市辖区', 150900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150902, '集宁区', '', '内蒙古自治区,乌兰察布市,集宁区', 150900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150921, '卓资县', '', '内蒙古自治区,乌兰察布市,卓资县', 150900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150922, '化德县', '', '内蒙古自治区,乌兰察布市,化德县', 150900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150923, '商都县', '', '内蒙古自治区,乌兰察布市,商都县', 150900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150924, '兴和县', '', '内蒙古自治区,乌兰察布市,兴和县', 150900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150925, '凉城县', '', '内蒙古自治区,乌兰察布市,凉城县', 150900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150926, '察哈尔右翼前旗', '', '内蒙古自治区,乌兰察布市,察哈尔右翼前旗', 150900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150927, '察哈尔右翼中旗', '', '内蒙古自治区,乌兰察布市,察哈尔右翼中旗', 150900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150928, '察哈尔右翼后旗', '', '内蒙古自治区,乌兰察布市,察哈尔右翼后旗', 150900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150929, '四子王旗', '', '内蒙古自治区,乌兰察布市,四子王旗', 150900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (150981, '丰镇市', '', '内蒙古自治区,乌兰察布市,丰镇市', 150900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (152201, '乌兰浩特市', '', '内蒙古自治区,兴安盟,乌兰浩特市', 152200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (152202, '阿尔山市', '', '内蒙古自治区,兴安盟,阿尔山市', 152200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (152221, '科尔沁右翼前旗', '', '内蒙古自治区,兴安盟,科尔沁右翼前旗', 152200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (152222, '科尔沁右翼中旗', '', '内蒙古自治区,兴安盟,科尔沁右翼中旗', 152200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (152223, '扎赉特旗', '', '内蒙古自治区,兴安盟,扎赉特旗', 152200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (152224, '突泉县', '', '内蒙古自治区,兴安盟,突泉县', 152200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (152501, '二连浩特市', '', '内蒙古自治区,锡林郭勒盟,二连浩特市', 152500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (152502, '锡林浩特市', '', '内蒙古自治区,锡林郭勒盟,锡林浩特市', 152500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (152522, '阿巴嘎旗', '', '内蒙古自治区,锡林郭勒盟,阿巴嘎旗', 152500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (152523, '苏尼特左旗', '', '内蒙古自治区,锡林郭勒盟,苏尼特左旗', 152500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (152524, '苏尼特右旗', '', '内蒙古自治区,锡林郭勒盟,苏尼特右旗', 152500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (152525, '东乌珠穆沁旗', '', '内蒙古自治区,锡林郭勒盟,东乌珠穆沁旗', 152500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (152526, '西乌珠穆沁旗', '', '内蒙古自治区,锡林郭勒盟,西乌珠穆沁旗', 152500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (152527, '太仆寺旗', '', '内蒙古自治区,锡林郭勒盟,太仆寺旗', 152500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (152528, '镶黄旗', '', '内蒙古自治区,锡林郭勒盟,镶黄旗', 152500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (152529, '正镶白旗', '', '内蒙古自治区,锡林郭勒盟,正镶白旗', 152500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (152530, '正蓝旗', '', '内蒙古自治区,锡林郭勒盟,正蓝旗', 152500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (152531, '多伦县', '', '内蒙古自治区,锡林郭勒盟,多伦县', 152500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (152921, '阿拉善左旗', '', '内蒙古自治区,阿拉善盟,阿拉善左旗', 152900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (152922, '阿拉善右旗', '', '内蒙古自治区,阿拉善盟,阿拉善右旗', 152900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (152923, '额济纳旗', '', '内蒙古自治区,阿拉善盟,额济纳旗', 152900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210101, '市辖区', '', '辽宁省,沈阳市,市辖区', 210100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210102, '和平区', '', '辽宁省,沈阳市,和平区', 210100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210103, '沈河区', '', '辽宁省,沈阳市,沈河区', 210100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210104, '大东区', '', '辽宁省,沈阳市,大东区', 210100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210105, '皇姑区', '', '辽宁省,沈阳市,皇姑区', 210100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210106, '铁西区', '', '辽宁省,沈阳市,铁西区', 210100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210111, '苏家屯区', '', '辽宁省,沈阳市,苏家屯区', 210100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210112, '东陵区', '', '辽宁省,沈阳市,东陵区', 210100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210113, '新城子区', '', '辽宁省,沈阳市,新城子区', 210100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210114, '于洪区', '', '辽宁省,沈阳市,于洪区', 210100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210122, '辽中县', '', '辽宁省,沈阳市,辽中县', 210100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210123, '康平县', '', '辽宁省,沈阳市,康平县', 210100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210124, '法库县', '', '辽宁省,沈阳市,法库县', 210100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210181, '新民市', '', '辽宁省,沈阳市,新民市', 210100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210201, '市辖区', '', '辽宁省,大连市,市辖区', 210200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210202, '中山区', '', '辽宁省,大连市,中山区', 210200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210203, '西岗区', '', '辽宁省,大连市,西岗区', 210200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210204, '沙河口区', '', '辽宁省,大连市,沙河口区', 210200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210211, '甘井子区', '', '辽宁省,大连市,甘井子区', 210200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210212, '旅顺口区', '', '辽宁省,大连市,旅顺口区', 210200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210213, '金州区', '', '辽宁省,大连市,金州区', 210200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210224, '长海县', '', '辽宁省,大连市,长海县', 210200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210281, '瓦房店市', '', '辽宁省,大连市,瓦房店市', 210200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210282, '普兰店市', '', '辽宁省,大连市,普兰店市', 210200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210283, '庄河市', '', '辽宁省,大连市,庄河市', 210200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210301, '市辖区', '', '辽宁省,鞍山市,市辖区', 210300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210302, '铁东区', '', '辽宁省,鞍山市,铁东区', 210300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210303, '铁西区', '', '辽宁省,鞍山市,铁西区', 210300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210304, '立山区', '', '辽宁省,鞍山市,立山区', 210300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210311, '千山区', '', '辽宁省,鞍山市,千山区', 210300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210321, '台安县', '', '辽宁省,鞍山市,台安县', 210300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210323, '岫岩满族自治县', '', '辽宁省,鞍山市,岫岩满族自治县', 210300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210381, '海城市', '', '辽宁省,鞍山市,海城市', 210300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210401, '市辖区', '', '辽宁省,抚顺市,市辖区', 210400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210402, '新抚区', '', '辽宁省,抚顺市,新抚区', 210400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210403, '东洲区', '', '辽宁省,抚顺市,东洲区', 210400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210404, '望花区', '', '辽宁省,抚顺市,望花区', 210400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210411, '顺城区', '', '辽宁省,抚顺市,顺城区', 210400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210421, '抚顺县', '', '辽宁省,抚顺市,抚顺县', 210400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210422, '新宾满族自治县', '', '辽宁省,抚顺市,新宾满族自治县', 210400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210423, '清原满族自治县', '', '辽宁省,抚顺市,清原满族自治县', 210400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210501, '市辖区', '', '辽宁省,本溪市,市辖区', 210500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210502, '平山区', '', '辽宁省,本溪市,平山区', 210500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210503, '溪湖区', '', '辽宁省,本溪市,溪湖区', 210500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210504, '明山区', '', '辽宁省,本溪市,明山区', 210500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210505, '南芬区', '', '辽宁省,本溪市,南芬区', 210500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210521, '本溪满族自治县', '', '辽宁省,本溪市,本溪满族自治县', 210500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210522, '桓仁满族自治县', '', '辽宁省,本溪市,桓仁满族自治县', 210500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210601, '市辖区', '', '辽宁省,丹东市,市辖区', 210600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210602, '元宝区', '', '辽宁省,丹东市,元宝区', 210600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210603, '振兴区', '', '辽宁省,丹东市,振兴区', 210600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210604, '振安区', '', '辽宁省,丹东市,振安区', 210600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210624, '宽甸满族自治县', '', '辽宁省,丹东市,宽甸满族自治县', 210600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210681, '东港市', '', '辽宁省,丹东市,东港市', 210600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210682, '凤城市', '', '辽宁省,丹东市,凤城市', 210600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210701, '市辖区', '', '辽宁省,锦州市,市辖区', 210700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210702, '古塔区', '', '辽宁省,锦州市,古塔区', 210700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210703, '凌河区', '', '辽宁省,锦州市,凌河区', 210700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210711, '太和区', '', '辽宁省,锦州市,太和区', 210700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210726, '黑山县', '', '辽宁省,锦州市,黑山县', 210700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210727, '义　县', '', '辽宁省,锦州市,义　县', 210700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210781, '凌海市', '', '辽宁省,锦州市,凌海市', 210700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210782, '北宁市', '', '辽宁省,锦州市,北宁市', 210700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210801, '市辖区', '', '辽宁省,营口市,市辖区', 210800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210802, '站前区', '', '辽宁省,营口市,站前区', 210800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210803, '西市区', '', '辽宁省,营口市,西市区', 210800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210804, '鲅鱼圈区', '', '辽宁省,营口市,鲅鱼圈区', 210800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210811, '老边区', '', '辽宁省,营口市,老边区', 210800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210881, '盖州市', '', '辽宁省,营口市,盖州市', 210800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210882, '大石桥市', '', '辽宁省,营口市,大石桥市', 210800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210901, '市辖区', '', '辽宁省,阜新市,市辖区', 210900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210902, '海州区', '', '辽宁省,阜新市,海州区', 210900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210903, '新邱区', '', '辽宁省,阜新市,新邱区', 210900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210904, '太平区', '', '辽宁省,阜新市,太平区', 210900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210905, '清河门区', '', '辽宁省,阜新市,清河门区', 210900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210911, '细河区', '', '辽宁省,阜新市,细河区', 210900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210921, '阜新蒙古族自治县', '', '辽宁省,阜新市,阜新蒙古族自治县', 210900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (210922, '彰武县', '', '辽宁省,阜新市,彰武县', 210900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211001, '市辖区', '', '辽宁省,辽阳市,市辖区', 211000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211002, '白塔区', '', '辽宁省,辽阳市,白塔区', 211000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211003, '文圣区', '', '辽宁省,辽阳市,文圣区', 211000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211004, '宏伟区', '', '辽宁省,辽阳市,宏伟区', 211000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211005, '弓长岭区', '', '辽宁省,辽阳市,弓长岭区', 211000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211011, '太子河区', '', '辽宁省,辽阳市,太子河区', 211000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211021, '辽阳县', '', '辽宁省,辽阳市,辽阳县', 211000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211081, '灯塔市', '', '辽宁省,辽阳市,灯塔市', 211000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211101, '市辖区', '', '辽宁省,盘锦市,市辖区', 211100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211102, '双台子区', '', '辽宁省,盘锦市,双台子区', 211100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211103, '兴隆台区', '', '辽宁省,盘锦市,兴隆台区', 211100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211121, '大洼县', '', '辽宁省,盘锦市,大洼县', 211100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211122, '盘山县', '', '辽宁省,盘锦市,盘山县', 211100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211201, '市辖区', '', '辽宁省,铁岭市,市辖区', 211200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211202, '银州区', '', '辽宁省,铁岭市,银州区', 211200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211204, '清河区', '', '辽宁省,铁岭市,清河区', 211200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211221, '铁岭县', '', '辽宁省,铁岭市,铁岭县', 211200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211223, '西丰县', '', '辽宁省,铁岭市,西丰县', 211200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211224, '昌图县', '', '辽宁省,铁岭市,昌图县', 211200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211281, '调兵山市', '', '辽宁省,铁岭市,调兵山市', 211200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211282, '开原市', '', '辽宁省,铁岭市,开原市', 211200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211301, '市辖区', '', '辽宁省,朝阳市,市辖区', 211300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211302, '双塔区', '', '辽宁省,朝阳市,双塔区', 211300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211303, '龙城区', '', '辽宁省,朝阳市,龙城区', 211300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211321, '朝阳县', '', '辽宁省,朝阳市,朝阳县', 211300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211322, '建平县', '', '辽宁省,朝阳市,建平县', 211300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211324, '喀喇沁左翼蒙古族自治县', '', '辽宁省,朝阳市,喀喇沁左翼蒙古族自治县', 211300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211381, '北票市', '', '辽宁省,朝阳市,北票市', 211300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211382, '凌源市', '', '辽宁省,朝阳市,凌源市', 211300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211401, '市辖区', '', '市辖区', 211400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211402, '连山区', '', '连山区', 211400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211403, '龙港区', '', '龙港区', 211400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211404, '南票区', '', '南票区', 211400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211421, '绥中县', '', '绥中县', 211400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211422, '建昌县', '', '建昌县', 211400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (211481, '兴城市', '', '兴城市', 211400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220101, '市辖区', '', '吉林省,长春市,市辖区', 220100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220102, '南关区', '', '吉林省,长春市,南关区', 220100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220103, '宽城区', '', '吉林省,长春市,宽城区', 220100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220104, '朝阳区', '', '吉林省,长春市,朝阳区', 220100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220105, '二道区', '', '吉林省,长春市,二道区', 220100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220106, '绿园区', '', '吉林省,长春市,绿园区', 220100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220112, '双阳区', '', '吉林省,长春市,双阳区', 220100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220122, '农安县', '', '吉林省,长春市,农安县', 220100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220181, '九台市', '', '吉林省,长春市,九台市', 220100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220182, '榆树市', '', '吉林省,长春市,榆树市', 220100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220183, '德惠市', '', '吉林省,长春市,德惠市', 220100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220201, '市辖区', '', '吉林省,吉林市,市辖区', 220200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220202, '昌邑区', '', '吉林省,吉林市,昌邑区', 220200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220203, '龙潭区', '', '吉林省,吉林市,龙潭区', 220200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220204, '船营区', '', '吉林省,吉林市,船营区', 220200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220211, '丰满区', '', '吉林省,吉林市,丰满区', 220200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220221, '永吉县', '', '吉林省,吉林市,永吉县', 220200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220281, '蛟河市', '', '吉林省,吉林市,蛟河市', 220200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220282, '桦甸市', '', '吉林省,吉林市,桦甸市', 220200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220283, '舒兰市', '', '吉林省,吉林市,舒兰市', 220200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220284, '磐石市', '', '吉林省,吉林市,磐石市', 220200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220301, '市辖区', '', '吉林省,四平市,市辖区', 220300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220302, '铁西区', '', '吉林省,四平市,铁西区', 220300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220303, '铁东区', '', '吉林省,四平市,铁东区', 220300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220322, '梨树县', '', '吉林省,四平市,梨树县', 220300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220323, '伊通满族自治县', '', '吉林省,四平市,伊通满族自治县', 220300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220381, '公主岭市', '', '吉林省,四平市,公主岭市', 220300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220382, '双辽市', '', '吉林省,四平市,双辽市', 220300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220401, '市辖区', '', '吉林省,辽源市,市辖区', 220400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220402, '龙山区', '', '吉林省,辽源市,龙山区', 220400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220403, '西安区', '', '吉林省,辽源市,西安区', 220400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220421, '东丰县', '', '吉林省,辽源市,东丰县', 220400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220422, '东辽县', '', '吉林省,辽源市,东辽县', 220400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220501, '市辖区', '', '吉林省,通化市,市辖区', 220500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220502, '东昌区', '', '吉林省,通化市,东昌区', 220500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220503, '二道江区', '', '吉林省,通化市,二道江区', 220500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220521, '通化县', '', '吉林省,通化市,通化县', 220500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220523, '辉南县', '', '吉林省,通化市,辉南县', 220500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220524, '柳河县', '', '吉林省,通化市,柳河县', 220500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220581, '梅河口市', '', '吉林省,通化市,梅河口市', 220500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220582, '集安市', '', '吉林省,通化市,集安市', 220500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220601, '市辖区', '', '吉林省,白山市,市辖区', 220600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220602, '八道江区', '', '吉林省,白山市,八道江区', 220600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220621, '抚松县', '', '吉林省,白山市,抚松县', 220600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220622, '靖宇县', '', '吉林省,白山市,靖宇县', 220600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220623, '长白朝鲜族自治县', '', '吉林省,白山市,长白朝鲜族自治县', 220600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220625, '江源县', '', '吉林省,白山市,江源县', 220600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220681, '临江市', '', '吉林省,白山市,临江市', 220600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220701, '市辖区', '', '吉林省,松原市,市辖区', 220700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220702, '宁江区', '', '吉林省,松原市,宁江区', 220700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220721, '前郭尔罗斯蒙古族自治县', '', '吉林省,松原市,前郭尔罗斯蒙古族自治县', 220700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220722, '长岭县', '', '吉林省,松原市,长岭县', 220700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220723, '乾安县', '', '吉林省,松原市,乾安县', 220700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220724, '扶余县', '', '吉林省,松原市,扶余县', 220700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220801, '市辖区', '', '吉林省,白城市,市辖区', 220800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220802, '洮北区', '', '吉林省,白城市,洮北区', 220800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220821, '镇赉县', '', '吉林省,白城市,镇赉县', 220800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220822, '通榆县', '', '吉林省,白城市,通榆县', 220800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220881, '洮南市', '', '吉林省,白城市,洮南市', 220800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (220882, '大安市', '', '吉林省,白城市,大安市', 220800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (222401, '延吉市', '', '吉林省,延边朝鲜族自治州,延吉市', 222400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (222402, '图们市', '', '吉林省,延边朝鲜族自治州,图们市', 222400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (222403, '敦化市', '', '吉林省,延边朝鲜族自治州,敦化市', 222400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (222404, '珲春市', '', '吉林省,延边朝鲜族自治州,珲春市', 222400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (222405, '龙井市', '', '吉林省,延边朝鲜族自治州,龙井市', 222400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (222406, '和龙市', '', '吉林省,延边朝鲜族自治州,和龙市', 222400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (222424, '汪清县', '', '吉林省,延边朝鲜族自治州,汪清县', 222400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (222426, '安图县', '', '吉林省,延边朝鲜族自治州,安图县', 222400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230101, '市辖区', '', '黑龙江省,哈尔滨市,市辖区', 230100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230102, '道里区', '', '黑龙江省,哈尔滨市,道里区', 230100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230103, '南岗区', '', '黑龙江省,哈尔滨市,南岗区', 230100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230104, '道外区', '', '黑龙江省,哈尔滨市,道外区', 230100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230106, '香坊区', '', '黑龙江省,哈尔滨市,香坊区', 230100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230107, '动力区', '', '黑龙江省,哈尔滨市,动力区', 230100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230108, '平房区', '', '黑龙江省,哈尔滨市,平房区', 230100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230109, '松北区', '', '黑龙江省,哈尔滨市,松北区', 230100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230111, '呼兰区', '', '黑龙江省,哈尔滨市,呼兰区', 230100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230123, '依兰县', '', '黑龙江省,哈尔滨市,依兰县', 230100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230124, '方正县', '', '黑龙江省,哈尔滨市,方正县', 230100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230125, '宾　县', '', '黑龙江省,哈尔滨市,宾　县', 230100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230126, '巴彦县', '', '黑龙江省,哈尔滨市,巴彦县', 230100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230127, '木兰县', '', '黑龙江省,哈尔滨市,木兰县', 230100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230128, '通河县', '', '黑龙江省,哈尔滨市,通河县', 230100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230129, '延寿县', '', '黑龙江省,哈尔滨市,延寿县', 230100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230181, '阿城市', '', '黑龙江省,哈尔滨市,阿城市', 230100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230182, '双城市', '', '黑龙江省,哈尔滨市,双城市', 230100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230183, '尚志市', '', '黑龙江省,哈尔滨市,尚志市', 230100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230184, '五常市', '', '黑龙江省,哈尔滨市,五常市', 230100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230201, '市辖区', '', '黑龙江省,齐齐哈尔市,市辖区', 230200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230202, '龙沙区', '', '黑龙江省,齐齐哈尔市,龙沙区', 230200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230203, '建华区', '', '黑龙江省,齐齐哈尔市,建华区', 230200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230204, '铁锋区', '', '黑龙江省,齐齐哈尔市,铁锋区', 230200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230205, '昂昂溪区', '', '黑龙江省,齐齐哈尔市,昂昂溪区', 230200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230206, '富拉尔基区', '', '黑龙江省,齐齐哈尔市,富拉尔基区', 230200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230207, '碾子山区', '', '黑龙江省,齐齐哈尔市,碾子山区', 230200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230208, '梅里斯达斡尔族区', '', '黑龙江省,齐齐哈尔市,梅里斯达斡尔族区', 230200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230221, '龙江县', '', '黑龙江省,齐齐哈尔市,龙江县', 230200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230223, '依安县', '', '黑龙江省,齐齐哈尔市,依安县', 230200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230224, '泰来县', '', '黑龙江省,齐齐哈尔市,泰来县', 230200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230225, '甘南县', '', '黑龙江省,齐齐哈尔市,甘南县', 230200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230227, '富裕县', '', '黑龙江省,齐齐哈尔市,富裕县', 230200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230229, '克山县', '', '黑龙江省,齐齐哈尔市,克山县', 230200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230230, '克东县', '', '黑龙江省,齐齐哈尔市,克东县', 230200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230231, '拜泉县', '', '黑龙江省,齐齐哈尔市,拜泉县', 230200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230281, '讷河市', '', '黑龙江省,齐齐哈尔市,讷河市', 230200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230301, '市辖区', '', '黑龙江省,鸡西市,市辖区', 230300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230302, '鸡冠区', '', '黑龙江省,鸡西市,鸡冠区', 230300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230303, '恒山区', '', '黑龙江省,鸡西市,恒山区', 230300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230304, '滴道区', '', '黑龙江省,鸡西市,滴道区', 230300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230305, '梨树区', '', '黑龙江省,鸡西市,梨树区', 230300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230306, '城子河区', '', '黑龙江省,鸡西市,城子河区', 230300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230307, '麻山区', '', '黑龙江省,鸡西市,麻山区', 230300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230321, '鸡东县', '', '黑龙江省,鸡西市,鸡东县', 230300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230381, '虎林市', '', '黑龙江省,鸡西市,虎林市', 230300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230382, '密山市', '', '黑龙江省,鸡西市,密山市', 230300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230401, '市辖区', '', '黑龙江省,鹤岗市,市辖区', 230400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230402, '向阳区', '', '黑龙江省,鹤岗市,向阳区', 230400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230403, '工农区', '', '黑龙江省,鹤岗市,工农区', 230400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230404, '南山区', '', '黑龙江省,鹤岗市,南山区', 230400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230405, '兴安区', '', '黑龙江省,鹤岗市,兴安区', 230400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230406, '东山区', '', '黑龙江省,鹤岗市,东山区', 230400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230407, '兴山区', '', '黑龙江省,鹤岗市,兴山区', 230400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230421, '萝北县', '', '黑龙江省,鹤岗市,萝北县', 230400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230422, '绥滨县', '', '黑龙江省,鹤岗市,绥滨县', 230400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230501, '市辖区', '', '黑龙江省,双鸭山市,市辖区', 230500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230502, '尖山区', '', '黑龙江省,双鸭山市,尖山区', 230500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230503, '岭东区', '', '黑龙江省,双鸭山市,岭东区', 230500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230505, '四方台区', '', '黑龙江省,双鸭山市,四方台区', 230500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230506, '宝山区', '', '黑龙江省,双鸭山市,宝山区', 230500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230521, '集贤县', '', '黑龙江省,双鸭山市,集贤县', 230500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230522, '友谊县', '', '黑龙江省,双鸭山市,友谊县', 230500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230523, '宝清县', '', '黑龙江省,双鸭山市,宝清县', 230500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230524, '饶河县', '', '黑龙江省,双鸭山市,饶河县', 230500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230601, '市辖区', '', '黑龙江省,大庆市,市辖区', 230600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230602, '萨尔图区', '', '黑龙江省,大庆市,萨尔图区', 230600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230603, '龙凤区', '', '黑龙江省,大庆市,龙凤区', 230600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230604, '让胡路区', '', '黑龙江省,大庆市,让胡路区', 230600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230605, '红岗区', '', '黑龙江省,大庆市,红岗区', 230600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230606, '大同区', '', '黑龙江省,大庆市,大同区', 230600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230621, '肇州县', '', '黑龙江省,大庆市,肇州县', 230600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230622, '肇源县', '', '黑龙江省,大庆市,肇源县', 230600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230623, '林甸县', '', '黑龙江省,大庆市,林甸县', 230600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230624, '杜尔伯特蒙古族自治县', '', '黑龙江省,大庆市,杜尔伯特蒙古族自治县', 230600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230701, '市辖区', '', '黑龙江省,伊春市,市辖区', 230700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230702, '伊春区', '', '黑龙江省,伊春市,伊春区', 230700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230703, '南岔区', '', '黑龙江省,伊春市,南岔区', 230700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230704, '友好区', '', '黑龙江省,伊春市,友好区', 230700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230705, '西林区', '', '黑龙江省,伊春市,西林区', 230700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230706, '翠峦区', '', '黑龙江省,伊春市,翠峦区', 230700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230707, '新青区', '', '黑龙江省,伊春市,新青区', 230700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230708, '美溪区', '', '黑龙江省,伊春市,美溪区', 230700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230709, '金山屯区', '', '黑龙江省,伊春市,金山屯区', 230700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230710, '五营区', '', '黑龙江省,伊春市,五营区', 230700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230711, '乌马河区', '', '黑龙江省,伊春市,乌马河区', 230700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230712, '汤旺河区', '', '黑龙江省,伊春市,汤旺河区', 230700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230713, '带岭区', '', '黑龙江省,伊春市,带岭区', 230700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230714, '乌伊岭区', '', '黑龙江省,伊春市,乌伊岭区', 230700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230715, '红星区', '', '黑龙江省,伊春市,红星区', 230700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230716, '上甘岭区', '', '黑龙江省,伊春市,上甘岭区', 230700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230722, '嘉荫县', '', '黑龙江省,伊春市,嘉荫县', 230700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230781, '铁力市', '', '黑龙江省,伊春市,铁力市', 230700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230801, '市辖区', '', '黑龙江省,佳木斯市,市辖区', 230800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230802, '永红区', '', '黑龙江省,佳木斯市,永红区', 230800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230803, '向阳区', '', '黑龙江省,佳木斯市,向阳区', 230800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230804, '前进区', '', '黑龙江省,佳木斯市,前进区', 230800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230805, '东风区', '', '黑龙江省,佳木斯市,东风区', 230800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230811, '郊　区', '', '黑龙江省,佳木斯市,郊　区', 230800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230822, '桦南县', '', '黑龙江省,佳木斯市,桦南县', 230800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230826, '桦川县', '', '黑龙江省,佳木斯市,桦川县', 230800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230828, '汤原县', '', '黑龙江省,佳木斯市,汤原县', 230800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230833, '抚远县', '', '黑龙江省,佳木斯市,抚远县', 230800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230881, '同江市', '', '黑龙江省,佳木斯市,同江市', 230800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230882, '富锦市', '', '黑龙江省,佳木斯市,富锦市', 230800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230901, '市辖区', '', '黑龙江省,七台河市,市辖区', 230900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230902, '新兴区', '', '黑龙江省,七台河市,新兴区', 230900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230903, '桃山区', '', '黑龙江省,七台河市,桃山区', 230900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230904, '茄子河区', '', '黑龙江省,七台河市,茄子河区', 230900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (230921, '勃利县', '', '黑龙江省,七台河市,勃利县', 230900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231001, '市辖区', '', '黑龙江省,牡丹江市,市辖区', 231000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231002, '东安区', '', '黑龙江省,牡丹江市,东安区', 231000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231003, '阳明区', '', '黑龙江省,牡丹江市,阳明区', 231000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231004, '爱民区', '', '黑龙江省,牡丹江市,爱民区', 231000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231005, '西安区', '', '黑龙江省,牡丹江市,西安区', 231000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231024, '东宁县', '', '黑龙江省,牡丹江市,东宁县', 231000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231025, '林口县', '', '黑龙江省,牡丹江市,林口县', 231000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231081, '绥芬河市', '', '黑龙江省,牡丹江市,绥芬河市', 231000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231083, '海林市', '', '黑龙江省,牡丹江市,海林市', 231000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231084, '宁安市', '', '黑龙江省,牡丹江市,宁安市', 231000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231085, '穆棱市', '', '黑龙江省,牡丹江市,穆棱市', 231000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231101, '市辖区', '', '黑龙江省,黑河市,市辖区', 231100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231102, '爱辉区', '', '黑龙江省,黑河市,爱辉区', 231100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231121, '嫩江县', '', '黑龙江省,黑河市,嫩江县', 231100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231123, '逊克县', '', '黑龙江省,黑河市,逊克县', 231100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231124, '孙吴县', '', '黑龙江省,黑河市,孙吴县', 231100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231181, '北安市', '', '黑龙江省,黑河市,北安市', 231100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231182, '五大连池市', '', '黑龙江省,黑河市,五大连池市', 231100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231201, '市辖区', '', '黑龙江省,绥化市,市辖区', 231200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231202, '北林区', '', '黑龙江省,绥化市,北林区', 231200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231221, '望奎县', '', '黑龙江省,绥化市,望奎县', 231200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231222, '兰西县', '', '黑龙江省,绥化市,兰西县', 231200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231223, '青冈县', '', '黑龙江省,绥化市,青冈县', 231200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231224, '庆安县', '', '黑龙江省,绥化市,庆安县', 231200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231225, '明水县', '', '黑龙江省,绥化市,明水县', 231200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231226, '绥棱县', '', '黑龙江省,绥化市,绥棱县', 231200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231281, '安达市', '', '黑龙江省,绥化市,安达市', 231200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231282, '肇东市', '', '黑龙江省,绥化市,肇东市', 231200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (231283, '海伦市', '', '黑龙江省,绥化市,海伦市', 231200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (232721, '呼玛县', '', '黑龙江省,大兴安岭地区,呼玛县', 232700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (232722, '塔河县', '', '黑龙江省,大兴安岭地区,塔河县', 232700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (232723, '漠河县', '', '黑龙江省,大兴安岭地区,漠河县', 232700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (310101, '黄浦区', '', '上海市,市辖区,黄浦区', 310100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (310103, '卢湾区', '', '上海市,市辖区,卢湾区', 310100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (310104, '徐汇区', '', '上海市,市辖区,徐汇区', 310100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (310105, '长宁区', '', '上海市,市辖区,长宁区', 310100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (310106, '静安区', '', '上海市,市辖区,静安区', 310100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (310107, '普陀区', '', '上海市,市辖区,普陀区', 310100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (310108, '闸北区', '', '上海市,市辖区,闸北区', 310100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (310109, '虹口区', '', '上海市,市辖区,虹口区', 310100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (310110, '杨浦区', '', '上海市,市辖区,杨浦区', 310100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (310112, '闵行区', '', '上海市,市辖区,闵行区', 310100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (310113, '宝山区', '', '上海市,市辖区,宝山区', 310100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (310114, '嘉定区', '', '上海市,市辖区,嘉定区', 310100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (310115, '浦东新区', '', '上海市,市辖区,浦东新区', 310100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (310116, '金山区', '', '上海市,市辖区,金山区', 310100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (310117, '松江区', '', '上海市,市辖区,松江区', 310100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (310118, '青浦区', '', '上海市,市辖区,青浦区', 310100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (310119, '南汇区', '', '上海市,市辖区,南汇区', 310100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (310120, '奉贤区', '', '上海市,市辖区,奉贤区', 310100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (310230, '崇明县', '', '上海市,县,崇明县', 310200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320101, '市辖区', '', '江苏省,南京市,市辖区', 320100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320102, '玄武区', '', '江苏省,南京市,玄武区', 320100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320103, '白下区', '', '江苏省,南京市,白下区', 320100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320104, '秦淮区', '', '江苏省,南京市,秦淮区', 320100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320105, '建邺区', '', '江苏省,南京市,建邺区', 320100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320106, '鼓楼区', '', '江苏省,南京市,鼓楼区', 320100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320107, '下关区', '', '江苏省,南京市,下关区', 320100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320111, '浦口区', '', '江苏省,南京市,浦口区', 320100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320113, '栖霞区', '', '江苏省,南京市,栖霞区', 320100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320114, '雨花台区', '', '江苏省,南京市,雨花台区', 320100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320115, '江宁区', '', '江苏省,南京市,江宁区', 320100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320116, '六合区', '', '江苏省,南京市,六合区', 320100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320124, '溧水县', '', '江苏省,南京市,溧水县', 320100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320125, '高淳县', '', '江苏省,南京市,高淳县', 320100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320201, '市辖区', '', '江苏省,无锡市,市辖区', 320200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320202, '崇安区', '', '江苏省,无锡市,崇安区', 320200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320203, '南长区', '', '江苏省,无锡市,南长区', 320200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320204, '北塘区', '', '江苏省,无锡市,北塘区', 320200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320205, '锡山区', '', '江苏省,无锡市,锡山区', 320200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320206, '惠山区', '', '江苏省,无锡市,惠山区', 320200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320211, '滨湖区', '', '江苏省,无锡市,滨湖区', 320200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320281, '江阴市', '', '江苏省,无锡市,江阴市', 320200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320282, '宜兴市', '', '江苏省,无锡市,宜兴市', 320200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320301, '市辖区', '', '江苏省,徐州市,市辖区', 320300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320302, '鼓楼区', '', '江苏省,徐州市,鼓楼区', 320300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320303, '云龙区', '', '江苏省,徐州市,云龙区', 320300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320304, '九里区', '', '江苏省,徐州市,九里区', 320300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320305, '贾汪区', '', '江苏省,徐州市,贾汪区', 320300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320311, '泉山区', '', '江苏省,徐州市,泉山区', 320300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320321, '丰　县', '', '江苏省,徐州市,丰　县', 320300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320322, '沛　县', '', '江苏省,徐州市,沛　县', 320300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320323, '铜山县', '', '江苏省,徐州市,铜山县', 320300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320324, '睢宁县', '', '江苏省,徐州市,睢宁县', 320300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320381, '新沂市', '', '江苏省,徐州市,新沂市', 320300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320382, '邳州市', '', '江苏省,徐州市,邳州市', 320300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320401, '市辖区', '', '江苏省,常州市,市辖区', 320400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320402, '天宁区', '', '江苏省,常州市,天宁区', 320400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320404, '钟楼区', '', '江苏省,常州市,钟楼区', 320400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320405, '戚墅堰区', '', '江苏省,常州市,戚墅堰区', 320400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320411, '新北区', '', '江苏省,常州市,新北区', 320400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320412, '武进区', '', '江苏省,常州市,武进区', 320400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320481, '溧阳市', '', '江苏省,常州市,溧阳市', 320400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320482, '金坛市', '', '江苏省,常州市,金坛市', 320400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320501, '市辖区', '', '江苏省,苏州市,市辖区', 320500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320502, '沧浪区', '', '江苏省,苏州市,沧浪区', 320500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320503, '平江区', '', '江苏省,苏州市,平江区', 320500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320504, '金阊区', '', '江苏省,苏州市,金阊区', 320500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320505, '虎丘区', '', '江苏省,苏州市,虎丘区', 320500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320506, '吴中区', '', '江苏省,苏州市,吴中区', 320500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320507, '相城区', '', '江苏省,苏州市,相城区', 320500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320581, '常熟市', '', '江苏省,苏州市,常熟市', 320500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320582, '张家港市', '', '江苏省,苏州市,张家港市', 320500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320583, '昆山市', '', '江苏省,苏州市,昆山市', 320500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320584, '吴江市', '', '江苏省,苏州市,吴江市', 320500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320585, '太仓市', '', '江苏省,苏州市,太仓市', 320500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320601, '市辖区', '', '江苏省,南通市,市辖区', 320600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320602, '崇川区', '', '江苏省,南通市,崇川区', 320600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320611, '港闸区', '', '江苏省,南通市,港闸区', 320600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320621, '海安县', '', '江苏省,南通市,海安县', 320600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320623, '如东县', '', '江苏省,南通市,如东县', 320600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320681, '启东市', '', '江苏省,南通市,启东市', 320600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320682, '如皋市', '', '江苏省,南通市,如皋市', 320600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320683, '通州市', '', '江苏省,南通市,通州市', 320600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320684, '海门市', '', '江苏省,南通市,海门市', 320600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320701, '市辖区', '', '江苏省,连云港市,市辖区', 320700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320703, '连云区', '', '江苏省,连云港市,连云区', 320700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320705, '新浦区', '', '江苏省,连云港市,新浦区', 320700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320706, '海州区', '', '江苏省,连云港市,海州区', 320700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320721, '赣榆县', '', '江苏省,连云港市,赣榆县', 320700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320722, '东海县', '', '江苏省,连云港市,东海县', 320700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320723, '灌云县', '', '江苏省,连云港市,灌云县', 320700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320724, '灌南县', '', '江苏省,连云港市,灌南县', 320700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320801, '市辖区', '', '江苏省,淮安市,市辖区', 320800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320802, '清河区', '', '江苏省,淮安市,清河区', 320800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320803, '楚州区', '', '江苏省,淮安市,楚州区', 320800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320804, '淮阴区', '', '江苏省,淮安市,淮阴区', 320800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320811, '清浦区', '', '江苏省,淮安市,清浦区', 320800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320826, '涟水县', '', '江苏省,淮安市,涟水县', 320800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320829, '洪泽县', '', '江苏省,淮安市,洪泽县', 320800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320830, '盱眙县', '', '江苏省,淮安市,盱眙县', 320800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320831, '金湖县', '', '江苏省,淮安市,金湖县', 320800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320901, '市辖区', '', '江苏省,盐城市,市辖区', 320900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320902, '亭湖区', '', '江苏省,盐城市,亭湖区', 320900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320903, '盐都区', '', '江苏省,盐城市,盐都区', 320900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320921, '响水县', '', '江苏省,盐城市,响水县', 320900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320922, '滨海县', '', '江苏省,盐城市,滨海县', 320900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320923, '阜宁县', '', '江苏省,盐城市,阜宁县', 320900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320924, '射阳县', '', '江苏省,盐城市,射阳县', 320900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320925, '建湖县', '', '江苏省,盐城市,建湖县', 320900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320981, '东台市', '', '江苏省,盐城市,东台市', 320900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (320982, '大丰市', '', '江苏省,盐城市,大丰市', 320900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321001, '市辖区', '', '江苏省,扬州市,市辖区', 321000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321002, '广陵区', '', '江苏省,扬州市,广陵区', 321000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321003, '邗江区', '', '江苏省,扬州市,邗江区', 321000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321011, '郊　区', '', '江苏省,扬州市,郊　区', 321000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321023, '宝应县', '', '江苏省,扬州市,宝应县', 321000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321081, '仪征市', '', '江苏省,扬州市,仪征市', 321000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321084, '高邮市', '', '江苏省,扬州市,高邮市', 321000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321088, '江都市', '', '江苏省,扬州市,江都市', 321000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321101, '市辖区', '', '江苏省,镇江市,市辖区', 321100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321102, '京口区', '', '江苏省,镇江市,京口区', 321100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321111, '润州区', '', '江苏省,镇江市,润州区', 321100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321112, '丹徒区', '', '江苏省,镇江市,丹徒区', 321100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321181, '丹阳市', '', '江苏省,镇江市,丹阳市', 321100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321182, '扬中市', '', '江苏省,镇江市,扬中市', 321100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321183, '句容市', '', '江苏省,镇江市,句容市', 321100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321201, '市辖区', '', '江苏省,泰州市,市辖区', 321200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321202, '海陵区', '', '江苏省,泰州市,海陵区', 321200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321203, '高港区', '', '江苏省,泰州市,高港区', 321200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321281, '兴化市', '', '江苏省,泰州市,兴化市', 321200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321282, '靖江市', '', '江苏省,泰州市,靖江市', 321200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321283, '泰兴市', '', '江苏省,泰州市,泰兴市', 321200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321284, '姜堰市', '', '江苏省,泰州市,姜堰市', 321200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321301, '市辖区', '', '江苏省,宿迁市,市辖区', 321300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321302, '宿城区', '', '江苏省,宿迁市,宿城区', 321300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321311, '宿豫区', '', '江苏省,宿迁市,宿豫区', 321300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321322, '沭阳县', '', '江苏省,宿迁市,沭阳县', 321300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321323, '泗阳县', '', '江苏省,宿迁市,泗阳县', 321300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (321324, '泗洪县', '', '江苏省,宿迁市,泗洪县', 321300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330101, '市辖区', '', '浙江省,杭州市,市辖区', 330100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330102, '上城区', '', '浙江省,杭州市,上城区', 330100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330103, '下城区', '', '浙江省,杭州市,下城区', 330100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330104, '江干区', '', '浙江省,杭州市,江干区', 330100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330105, '拱墅区', '', '浙江省,杭州市,拱墅区', 330100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330106, '西湖区', '', '浙江省,杭州市,西湖区', 330100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330108, '滨江区', '', '浙江省,杭州市,滨江区', 330100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330109, '萧山区', '', '浙江省,杭州市,萧山区', 330100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330110, '余杭区', '', '浙江省,杭州市,余杭区', 330100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330122, '桐庐县', '', '浙江省,杭州市,桐庐县', 330100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330127, '淳安县', '', '浙江省,杭州市,淳安县', 330100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330182, '建德市', '', '浙江省,杭州市,建德市', 330100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330183, '富阳市', '', '浙江省,杭州市,富阳市', 330100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330185, '临安市', '', '浙江省,杭州市,临安市', 330100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330201, '市辖区', '', '浙江省,宁波市,市辖区', 330200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330203, '海曙区', '', '浙江省,宁波市,海曙区', 330200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330204, '江东区', '', '浙江省,宁波市,江东区', 330200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330205, '江北区', '', '浙江省,宁波市,江北区', 330200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330206, '北仑区', '', '浙江省,宁波市,北仑区', 330200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330211, '镇海区', '', '浙江省,宁波市,镇海区', 330200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330212, '鄞州区', '', '浙江省,宁波市,鄞州区', 330200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330225, '象山县', '', '浙江省,宁波市,象山县', 330200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330226, '宁海县', '', '浙江省,宁波市,宁海县', 330200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330281, '余姚市', '', '浙江省,宁波市,余姚市', 330200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330282, '慈溪市', '', '浙江省,宁波市,慈溪市', 330200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330283, '奉化市', '', '浙江省,宁波市,奉化市', 330200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330301, '市辖区', '', '浙江省,温州市,市辖区', 330300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330302, '鹿城区', '', '浙江省,温州市,鹿城区', 330300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330303, '龙湾区', '', '浙江省,温州市,龙湾区', 330300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330304, '瓯海区', '', '浙江省,温州市,瓯海区', 330300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330322, '洞头县', '', '浙江省,温州市,洞头县', 330300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330324, '永嘉县', '', '浙江省,温州市,永嘉县', 330300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330326, '平阳县', '', '浙江省,温州市,平阳县', 330300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330327, '苍南县', '', '浙江省,温州市,苍南县', 330300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330328, '文成县', '', '浙江省,温州市,文成县', 330300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330329, '泰顺县', '', '浙江省,温州市,泰顺县', 330300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330381, '瑞安市', '', '浙江省,温州市,瑞安市', 330300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330382, '乐清市', '', '浙江省,温州市,乐清市', 330300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330401, '市辖区', '', '浙江省,嘉兴市,市辖区', 330400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330402, '秀城区', '', '浙江省,嘉兴市,秀城区', 330400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330411, '秀洲区', '', '浙江省,嘉兴市,秀洲区', 330400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330421, '嘉善县', '', '浙江省,嘉兴市,嘉善县', 330400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330424, '海盐县', '', '浙江省,嘉兴市,海盐县', 330400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330481, '海宁市', '', '浙江省,嘉兴市,海宁市', 330400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330482, '平湖市', '', '浙江省,嘉兴市,平湖市', 330400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330483, '桐乡市', '', '浙江省,嘉兴市,桐乡市', 330400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330501, '市辖区', '', '浙江省,湖州市,市辖区', 330500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330502, '吴兴区', '', '浙江省,湖州市,吴兴区', 330500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330503, '南浔区', '', '浙江省,湖州市,南浔区', 330500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330521, '德清县', '', '浙江省,湖州市,德清县', 330500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330522, '长兴县', '', '浙江省,湖州市,长兴县', 330500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330523, '安吉县', '', '浙江省,湖州市,安吉县', 330500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330601, '市辖区', '', '浙江省,绍兴市,市辖区', 330600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330602, '越城区', '', '浙江省,绍兴市,越城区', 330600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330621, '绍兴县', '', '浙江省,绍兴市,绍兴县', 330600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330624, '新昌县', '', '浙江省,绍兴市,新昌县', 330600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330681, '诸暨市', '', '浙江省,绍兴市,诸暨市', 330600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330682, '上虞市', '', '浙江省,绍兴市,上虞市', 330600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330683, '嵊州市', '', '浙江省,绍兴市,嵊州市', 330600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330701, '市辖区', '', '浙江省,金华市,市辖区', 330700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330702, '婺城区', '', '浙江省,金华市,婺城区', 330700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330703, '金东区', '', '浙江省,金华市,金东区', 330700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330723, '武义县', '', '浙江省,金华市,武义县', 330700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330726, '浦江县', '', '浙江省,金华市,浦江县', 330700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330727, '磐安县', '', '浙江省,金华市,磐安县', 330700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330781, '兰溪市', '', '浙江省,金华市,兰溪市', 330700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330782, '义乌市', '', '浙江省,金华市,义乌市', 330700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330783, '东阳市', '', '浙江省,金华市,东阳市', 330700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330784, '永康市', '', '浙江省,金华市,永康市', 330700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330801, '市辖区', '', '浙江省,衢州市,市辖区', 330800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330802, '柯城区', '', '浙江省,衢州市,柯城区', 330800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330803, '衢江区', '', '浙江省,衢州市,衢江区', 330800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330822, '常山县', '', '浙江省,衢州市,常山县', 330800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330824, '开化县', '', '浙江省,衢州市,开化县', 330800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330825, '龙游县', '', '浙江省,衢州市,龙游县', 330800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330881, '江山市', '', '浙江省,衢州市,江山市', 330800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330901, '市辖区', '', '浙江省,舟山市,市辖区', 330900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330902, '定海区', '', '浙江省,舟山市,定海区', 330900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330903, '普陀区', '', '浙江省,舟山市,普陀区', 330900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330921, '岱山县', '', '浙江省,舟山市,岱山县', 330900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (330922, '嵊泗县', '', '浙江省,舟山市,嵊泗县', 330900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (331001, '市辖区', '', '浙江省,台州市,市辖区', 331000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (331002, '椒江区', '', '浙江省,台州市,椒江区', 331000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (331003, '黄岩区', '', '浙江省,台州市,黄岩区', 331000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (331004, '路桥区', '', '浙江省,台州市,路桥区', 331000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (331021, '玉环县', '', '浙江省,台州市,玉环县', 331000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (331022, '三门县', '', '浙江省,台州市,三门县', 331000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (331023, '天台县', '', '浙江省,台州市,天台县', 331000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (331024, '仙居县', '', '浙江省,台州市,仙居县', 331000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (331081, '温岭市', '', '浙江省,台州市,温岭市', 331000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (331082, '临海市', '', '浙江省,台州市,临海市', 331000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (331101, '市辖区', '', '浙江省,丽水市,市辖区', 331100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (331102, '莲都区', '', '浙江省,丽水市,莲都区', 331100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (331121, '青田县', '', '浙江省,丽水市,青田县', 331100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (331122, '缙云县', '', '浙江省,丽水市,缙云县', 331100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (331123, '遂昌县', '', '浙江省,丽水市,遂昌县', 331100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (331124, '松阳县', '', '浙江省,丽水市,松阳县', 331100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (331125, '云和县', '', '浙江省,丽水市,云和县', 331100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (331126, '庆元县', '', '浙江省,丽水市,庆元县', 331100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (331127, '景宁畲族自治县', '', '浙江省,丽水市,景宁畲族自治县', 331100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (331181, '龙泉市', '', '浙江省,丽水市,龙泉市', 331100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340101, '市辖区', '', '安徽省,合肥市,市辖区', 340100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340102, '瑶海区', '', '安徽省,合肥市,瑶海区', 340100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340103, '庐阳区', '', '安徽省,合肥市,庐阳区', 340100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340104, '蜀山区', '', '安徽省,合肥市,蜀山区', 340100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340111, '包河区', '', '安徽省,合肥市,包河区', 340100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340121, '长丰县', '', '安徽省,合肥市,长丰县', 340100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340122, '肥东县', '', '安徽省,合肥市,肥东县', 340100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340123, '肥西县', '', '安徽省,合肥市,肥西县', 340100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340201, '市辖区', '', '安徽省,芜湖市,市辖区', 340200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340202, '镜湖区', '', '安徽省,芜湖市,镜湖区', 340200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340203, '马塘区', '', '安徽省,芜湖市,马塘区', 340200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340204, '新芜区', '', '安徽省,芜湖市,新芜区', 340200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340207, '鸠江区', '', '安徽省,芜湖市,鸠江区', 340200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340221, '芜湖县', '', '安徽省,芜湖市,芜湖县', 340200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340222, '繁昌县', '', '安徽省,芜湖市,繁昌县', 340200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340223, '南陵县', '', '安徽省,芜湖市,南陵县', 340200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340301, '市辖区', '', '安徽省,蚌埠市,市辖区', 340300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340302, '龙子湖区', '', '安徽省,蚌埠市,龙子湖区', 340300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340303, '蚌山区', '', '安徽省,蚌埠市,蚌山区', 340300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340304, '禹会区', '', '安徽省,蚌埠市,禹会区', 340300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340311, '淮上区', '', '安徽省,蚌埠市,淮上区', 340300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340321, '怀远县', '', '安徽省,蚌埠市,怀远县', 340300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340322, '五河县', '', '安徽省,蚌埠市,五河县', 340300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340323, '固镇县', '', '安徽省,蚌埠市,固镇县', 340300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340401, '市辖区', '', '安徽省,淮南市,市辖区', 340400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340402, '大通区', '', '安徽省,淮南市,大通区', 340400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340403, '田家庵区', '', '安徽省,淮南市,田家庵区', 340400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340404, '谢家集区', '', '安徽省,淮南市,谢家集区', 340400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340405, '八公山区', '', '安徽省,淮南市,八公山区', 340400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340406, '潘集区', '', '安徽省,淮南市,潘集区', 340400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340421, '凤台县', '', '安徽省,淮南市,凤台县', 340400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340501, '市辖区', '', '安徽省,马鞍山市,市辖区', 340500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340502, '金家庄区', '', '安徽省,马鞍山市,金家庄区', 340500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340503, '花山区', '', '安徽省,马鞍山市,花山区', 340500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340504, '雨山区', '', '安徽省,马鞍山市,雨山区', 340500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340521, '当涂县', '', '安徽省,马鞍山市,当涂县', 340500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340601, '市辖区', '', '安徽省,淮北市,市辖区', 340600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340602, '杜集区', '', '安徽省,淮北市,杜集区', 340600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340603, '相山区', '', '安徽省,淮北市,相山区', 340600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340604, '烈山区', '', '安徽省,淮北市,烈山区', 340600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340621, '濉溪县', '', '安徽省,淮北市,濉溪县', 340600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340701, '市辖区', '', '安徽省,铜陵市,市辖区', 340700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340702, '铜官山区', '', '安徽省,铜陵市,铜官山区', 340700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340703, '狮子山区', '', '安徽省,铜陵市,狮子山区', 340700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340711, '郊　区', '', '安徽省,铜陵市,郊　区', 340700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340721, '铜陵县', '', '安徽省,铜陵市,铜陵县', 340700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340801, '市辖区', '', '安徽省,安庆市,市辖区', 340800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340802, '迎江区', '', '安徽省,安庆市,迎江区', 340800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340803, '大观区', '', '安徽省,安庆市,大观区', 340800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340811, '郊　区', '', '安徽省,安庆市,郊　区', 340800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340822, '怀宁县', '', '安徽省,安庆市,怀宁县', 340800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340823, '枞阳县', '', '安徽省,安庆市,枞阳县', 340800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340824, '潜山县', '', '安徽省,安庆市,潜山县', 340800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340825, '太湖县', '', '安徽省,安庆市,太湖县', 340800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340826, '宿松县', '', '安徽省,安庆市,宿松县', 340800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340827, '望江县', '', '安徽省,安庆市,望江县', 340800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340828, '岳西县', '', '安徽省,安庆市,岳西县', 340800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (340881, '桐城市', '', '安徽省,安庆市,桐城市', 340800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341001, '市辖区', '', '安徽省,黄山市,市辖区', 341000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341002, '屯溪区', '', '安徽省,黄山市,屯溪区', 341000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341003, '黄山区', '', '安徽省,黄山市,黄山区', 341000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341004, '徽州区', '', '安徽省,黄山市,徽州区', 341000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341021, '歙　县', '', '安徽省,黄山市,歙　县', 341000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341022, '休宁县', '', '安徽省,黄山市,休宁县', 341000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341023, '黟　县', '', '安徽省,黄山市,黟　县', 341000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341024, '祁门县', '', '安徽省,黄山市,祁门县', 341000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341101, '市辖区', '', '安徽省,滁州市,市辖区', 341100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341102, '琅琊区', '', '安徽省,滁州市,琅琊区', 341100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341103, '南谯区', '', '安徽省,滁州市,南谯区', 341100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341122, '来安县', '', '安徽省,滁州市,来安县', 341100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341124, '全椒县', '', '安徽省,滁州市,全椒县', 341100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341125, '定远县', '', '安徽省,滁州市,定远县', 341100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341126, '凤阳县', '', '安徽省,滁州市,凤阳县', 341100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341181, '天长市', '', '安徽省,滁州市,天长市', 341100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341182, '明光市', '', '安徽省,滁州市,明光市', 341100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341201, '市辖区', '', '安徽省,阜阳市,市辖区', 341200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341202, '颍州区', '', '安徽省,阜阳市,颍州区', 341200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341203, '颍东区', '', '安徽省,阜阳市,颍东区', 341200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341204, '颍泉区', '', '安徽省,阜阳市,颍泉区', 341200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341221, '临泉县', '', '安徽省,阜阳市,临泉县', 341200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341222, '太和县', '', '安徽省,阜阳市,太和县', 341200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341225, '阜南县', '', '安徽省,阜阳市,阜南县', 341200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341226, '颍上县', '', '安徽省,阜阳市,颍上县', 341200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341282, '界首市', '', '安徽省,阜阳市,界首市', 341200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341301, '市辖区', '', '安徽省,宿州市,市辖区', 341300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341302, '墉桥区', '', '安徽省,宿州市,墉桥区', 341300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341321, '砀山县', '', '安徽省,宿州市,砀山县', 341300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341322, '萧　县', '', '安徽省,宿州市,萧　县', 341300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341323, '灵璧县', '', '安徽省,宿州市,灵璧县', 341300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341324, '泗　县', '', '安徽省,宿州市,泗　县', 341300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341401, '庐江县', '', '安徽省,合肥市,庐江县', 340100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341402, '巢湖市', '', '安徽省,合肥市,巢湖市', 340100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341422, '无为县', '', '安徽省,芜湖市,无为县', 340200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341423, '含山县', '', '安徽省,马鞍山市,含山县', 340500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341424, '和　县', '', '安徽省,马鞍山市,和　县', 340500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341501, '市辖区', '', '安徽省,六安市,市辖区', 341500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341502, '金安区', '', '安徽省,六安市,金安区', 341500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341503, '裕安区', '', '安徽省,六安市,裕安区', 341500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341521, '寿　县', '', '安徽省,六安市,寿　县', 341500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341522, '霍邱县', '', '安徽省,六安市,霍邱县', 341500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341523, '舒城县', '', '安徽省,六安市,舒城县', 341500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341524, '金寨县', '', '安徽省,六安市,金寨县', 341500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341525, '霍山县', '', '安徽省,六安市,霍山县', 341500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341601, '市辖区', '', '安徽省,亳州市,市辖区', 341600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341602, '谯城区', '', '安徽省,亳州市,谯城区', 341600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341621, '涡阳县', '', '安徽省,亳州市,涡阳县', 341600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341622, '蒙城县', '', '安徽省,亳州市,蒙城县', 341600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341623, '利辛县', '', '安徽省,亳州市,利辛县', 341600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341701, '市辖区', '', '安徽省,池州市,市辖区', 341700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341702, '贵池区', '', '安徽省,池州市,贵池区', 341700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341721, '东至县', '', '安徽省,池州市,东至县', 341700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341722, '石台县', '', '安徽省,池州市,石台县', 341700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341723, '青阳县', '', '安徽省,池州市,青阳县', 341700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341801, '市辖区', '', '安徽省,宣城市,市辖区', 341800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341802, '宣州区', '', '安徽省,宣城市,宣州区', 341800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341821, '郎溪县', '', '安徽省,宣城市,郎溪县', 341800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341822, '广德县', '', '安徽省,宣城市,广德县', 341800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341823, '泾　县', '', '安徽省,宣城市,泾　县', 341800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341824, '绩溪县', '', '安徽省,宣城市,绩溪县', 341800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341825, '旌德县', '', '安徽省,宣城市,旌德县', 341800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (341881, '宁国市', '', '安徽省,宣城市,宁国市', 341800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350101, '市辖区', '', '福建省,福州市,市辖区', 350100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350102, '鼓楼区', '', '福建省,福州市,鼓楼区', 350100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350103, '台江区', '', '福建省,福州市,台江区', 350100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350104, '仓山区', '', '福建省,福州市,仓山区', 350100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350105, '马尾区', '', '福建省,福州市,马尾区', 350100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350111, '晋安区', '', '福建省,福州市,晋安区', 350100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350121, '闽侯县', '', '福建省,福州市,闽侯县', 350100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350122, '连江县', '', '福建省,福州市,连江县', 350100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350123, '罗源县', '', '福建省,福州市,罗源县', 350100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350124, '闽清县', '', '福建省,福州市,闽清县', 350100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350125, '永泰县', '', '福建省,福州市,永泰县', 350100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350128, '平潭县', '', '福建省,福州市,平潭县', 350100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350181, '福清市', '', '福建省,福州市,福清市', 350100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350182, '长乐市', '', '福建省,福州市,长乐市', 350100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350201, '市辖区', '', '福建省,厦门市,市辖区', 350200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350203, '思明区', '', '福建省,厦门市,思明区', 350200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350205, '海沧区', '', '福建省,厦门市,海沧区', 350200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350206, '湖里区', '', '福建省,厦门市,湖里区', 350200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350211, '集美区', '', '福建省,厦门市,集美区', 350200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350212, '同安区', '', '福建省,厦门市,同安区', 350200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350213, '翔安区', '', '福建省,厦门市,翔安区', 350200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350301, '市辖区', '', '福建省,莆田市,市辖区', 350300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350302, '城厢区', '', '福建省,莆田市,城厢区', 350300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350303, '涵江区', '', '福建省,莆田市,涵江区', 350300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350304, '荔城区', '', '福建省,莆田市,荔城区', 350300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350305, '秀屿区', '', '福建省,莆田市,秀屿区', 350300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350322, '仙游县', '', '福建省,莆田市,仙游县', 350300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350401, '市辖区', '', '福建省,三明市,市辖区', 350400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350402, '梅列区', '', '福建省,三明市,梅列区', 350400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350403, '三元区', '', '福建省,三明市,三元区', 350400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350421, '明溪县', '', '福建省,三明市,明溪县', 350400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350423, '清流县', '', '福建省,三明市,清流县', 350400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350424, '宁化县', '', '福建省,三明市,宁化县', 350400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350425, '大田县', '', '福建省,三明市,大田县', 350400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350426, '尤溪县', '', '福建省,三明市,尤溪县', 350400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350427, '沙　县', '', '福建省,三明市,沙　县', 350400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350428, '将乐县', '', '福建省,三明市,将乐县', 350400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350429, '泰宁县', '', '福建省,三明市,泰宁县', 350400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350430, '建宁县', '', '福建省,三明市,建宁县', 350400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350481, '永安市', '', '福建省,三明市,永安市', 350400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350501, '市辖区', '', '福建省,泉州市,市辖区', 350500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350502, '鲤城区', '', '福建省,泉州市,鲤城区', 350500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350503, '丰泽区', '', '福建省,泉州市,丰泽区', 350500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350504, '洛江区', '', '福建省,泉州市,洛江区', 350500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350505, '泉港区', '', '福建省,泉州市,泉港区', 350500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350521, '惠安县', '', '福建省,泉州市,惠安县', 350500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350524, '安溪县', '', '福建省,泉州市,安溪县', 350500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350525, '永春县', '', '福建省,泉州市,永春县', 350500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350526, '德化县', '', '福建省,泉州市,德化县', 350500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350527, '金门县', '', '福建省,泉州市,金门县', 350500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350581, '石狮市', '', '福建省,泉州市,石狮市', 350500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350582, '晋江市', '', '福建省,泉州市,晋江市', 350500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350583, '南安市', '', '福建省,泉州市,南安市', 350500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350601, '市辖区', '', '福建省,漳州市,市辖区', 350600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350602, '芗城区', '', '福建省,漳州市,芗城区', 350600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350603, '龙文区', '', '福建省,漳州市,龙文区', 350600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350622, '云霄县', '', '福建省,漳州市,云霄县', 350600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350623, '漳浦县', '', '福建省,漳州市,漳浦县', 350600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350624, '诏安县', '', '福建省,漳州市,诏安县', 350600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350625, '长泰县', '', '福建省,漳州市,长泰县', 350600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350626, '东山县', '', '福建省,漳州市,东山县', 350600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350627, '南靖县', '', '福建省,漳州市,南靖县', 350600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350628, '平和县', '', '福建省,漳州市,平和县', 350600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350629, '华安县', '', '福建省,漳州市,华安县', 350600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350681, '龙海市', '', '福建省,漳州市,龙海市', 350600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350701, '市辖区', '', '福建省,南平市,市辖区', 350700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350702, '延平区', '', '福建省,南平市,延平区', 350700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350721, '顺昌县', '', '福建省,南平市,顺昌县', 350700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350722, '浦城县', '', '福建省,南平市,浦城县', 350700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350723, '光泽县', '', '福建省,南平市,光泽县', 350700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350724, '松溪县', '', '福建省,南平市,松溪县', 350700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350725, '政和县', '', '福建省,南平市,政和县', 350700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350781, '邵武市', '', '福建省,南平市,邵武市', 350700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350782, '武夷山市', '', '福建省,南平市,武夷山市', 350700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350783, '建瓯市', '', '福建省,南平市,建瓯市', 350700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350784, '建阳市', '', '福建省,南平市,建阳市', 350700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350801, '市辖区', '', '福建省,龙岩市,市辖区', 350800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350802, '新罗区', '', '福建省,龙岩市,新罗区', 350800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350821, '长汀县', '', '福建省,龙岩市,长汀县', 350800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350822, '永定县', '', '福建省,龙岩市,永定县', 350800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350823, '上杭县', '', '福建省,龙岩市,上杭县', 350800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350824, '武平县', '', '福建省,龙岩市,武平县', 350800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350825, '连城县', '', '福建省,龙岩市,连城县', 350800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350881, '漳平市', '', '福建省,龙岩市,漳平市', 350800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350901, '市辖区', '', '福建省,宁德市,市辖区', 350900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350902, '蕉城区', '', '福建省,宁德市,蕉城区', 350900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350921, '霞浦县', '', '福建省,宁德市,霞浦县', 350900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350922, '古田县', '', '福建省,宁德市,古田县', 350900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350923, '屏南县', '', '福建省,宁德市,屏南县', 350900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350924, '寿宁县', '', '福建省,宁德市,寿宁县', 350900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350925, '周宁县', '', '福建省,宁德市,周宁县', 350900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350926, '柘荣县', '', '福建省,宁德市,柘荣县', 350900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350981, '福安市', '', '福建省,宁德市,福安市', 350900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (350982, '福鼎市', '', '福建省,宁德市,福鼎市', 350900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360101, '市辖区', '', '江西省,南昌市,市辖区', 360100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360102, '东湖区', '', '江西省,南昌市,东湖区', 360100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360103, '西湖区', '', '江西省,南昌市,西湖区', 360100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360104, '青云谱区', '', '江西省,南昌市,青云谱区', 360100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360105, '湾里区', '', '江西省,南昌市,湾里区', 360100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360111, '青山湖区', '', '江西省,南昌市,青山湖区', 360100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360121, '南昌县', '', '江西省,南昌市,南昌县', 360100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360122, '新建县', '', '江西省,南昌市,新建县', 360100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360123, '安义县', '', '江西省,南昌市,安义县', 360100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360124, '进贤县', '', '江西省,南昌市,进贤县', 360100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360201, '市辖区', '', '江西省,景德镇市,市辖区', 360200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360202, '昌江区', '', '江西省,景德镇市,昌江区', 360200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360203, '珠山区', '', '江西省,景德镇市,珠山区', 360200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360222, '浮梁县', '', '江西省,景德镇市,浮梁县', 360200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360281, '乐平市', '', '江西省,景德镇市,乐平市', 360200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360301, '市辖区', '', '江西省,萍乡市,市辖区', 360300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360302, '安源区', '', '江西省,萍乡市,安源区', 360300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360313, '湘东区', '', '江西省,萍乡市,湘东区', 360300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360321, '莲花县', '', '江西省,萍乡市,莲花县', 360300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360322, '上栗县', '', '江西省,萍乡市,上栗县', 360300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360323, '芦溪县', '', '江西省,萍乡市,芦溪县', 360300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360401, '市辖区', '', '江西省,九江市,市辖区', 360400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360402, '庐山区', '', '江西省,九江市,庐山区', 360400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360403, '浔阳区', '', '江西省,九江市,浔阳区', 360400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360421, '九江县', '', '江西省,九江市,九江县', 360400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360423, '武宁县', '', '江西省,九江市,武宁县', 360400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360424, '修水县', '', '江西省,九江市,修水县', 360400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360425, '永修县', '', '江西省,九江市,永修县', 360400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360426, '德安县', '', '江西省,九江市,德安县', 360400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360427, '星子县', '', '江西省,九江市,星子县', 360400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360428, '都昌县', '', '江西省,九江市,都昌县', 360400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360429, '湖口县', '', '江西省,九江市,湖口县', 360400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360430, '彭泽县', '', '江西省,九江市,彭泽县', 360400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360481, '瑞昌市', '', '江西省,九江市,瑞昌市', 360400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360501, '市辖区', '', '江西省,新余市,市辖区', 360500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360502, '渝水区', '', '江西省,新余市,渝水区', 360500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360521, '分宜县', '', '江西省,新余市,分宜县', 360500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360601, '市辖区', '', '江西省,鹰潭市,市辖区', 360600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360602, '月湖区', '', '江西省,鹰潭市,月湖区', 360600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360622, '余江县', '', '江西省,鹰潭市,余江县', 360600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360681, '贵溪市', '', '江西省,鹰潭市,贵溪市', 360600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360701, '市辖区', '', '江西省,赣州市,市辖区', 360700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360702, '章贡区', '', '江西省,赣州市,章贡区', 360700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360721, '赣　县', '', '江西省,赣州市,赣　县', 360700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360722, '信丰县', '', '江西省,赣州市,信丰县', 360700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360723, '大余县', '', '江西省,赣州市,大余县', 360700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360724, '上犹县', '', '江西省,赣州市,上犹县', 360700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360725, '崇义县', '', '江西省,赣州市,崇义县', 360700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360726, '安远县', '', '江西省,赣州市,安远县', 360700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360727, '龙南县', '', '江西省,赣州市,龙南县', 360700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360728, '定南县', '', '江西省,赣州市,定南县', 360700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360729, '全南县', '', '江西省,赣州市,全南县', 360700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360730, '宁都县', '', '江西省,赣州市,宁都县', 360700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360731, '于都县', '', '江西省,赣州市,于都县', 360700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360732, '兴国县', '', '江西省,赣州市,兴国县', 360700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360733, '会昌县', '', '江西省,赣州市,会昌县', 360700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360734, '寻乌县', '', '江西省,赣州市,寻乌县', 360700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360735, '石城县', '', '江西省,赣州市,石城县', 360700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360781, '瑞金市', '', '江西省,赣州市,瑞金市', 360700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360782, '南康市', '', '江西省,赣州市,南康市', 360700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360801, '市辖区', '', '江西省,吉安市,市辖区', 360800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360802, '吉州区', '', '江西省,吉安市,吉州区', 360800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360803, '青原区', '', '江西省,吉安市,青原区', 360800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360821, '吉安县', '', '江西省,吉安市,吉安县', 360800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360822, '吉水县', '', '江西省,吉安市,吉水县', 360800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360823, '峡江县', '', '江西省,吉安市,峡江县', 360800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360824, '新干县', '', '江西省,吉安市,新干县', 360800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360825, '永丰县', '', '江西省,吉安市,永丰县', 360800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360826, '泰和县', '', '江西省,吉安市,泰和县', 360800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360827, '遂川县', '', '江西省,吉安市,遂川县', 360800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360828, '万安县', '', '江西省,吉安市,万安县', 360800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360829, '安福县', '', '江西省,吉安市,安福县', 360800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360830, '永新县', '', '江西省,吉安市,永新县', 360800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360881, '井冈山市', '', '江西省,吉安市,井冈山市', 360800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360901, '市辖区', '', '江西省,宜春市,市辖区', 360900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360902, '袁州区', '', '江西省,宜春市,袁州区', 360900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360921, '奉新县', '', '江西省,宜春市,奉新县', 360900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360922, '万载县', '', '江西省,宜春市,万载县', 360900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360923, '上高县', '', '江西省,宜春市,上高县', 360900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360924, '宜丰县', '', '江西省,宜春市,宜丰县', 360900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360925, '靖安县', '', '江西省,宜春市,靖安县', 360900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360926, '铜鼓县', '', '江西省,宜春市,铜鼓县', 360900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360981, '丰城市', '', '江西省,宜春市,丰城市', 360900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360982, '樟树市', '', '江西省,宜春市,樟树市', 360900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (360983, '高安市', '', '江西省,宜春市,高安市', 360900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (361001, '市辖区', '', '江西省,抚州市,市辖区', 361000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (361002, '临川区', '', '江西省,抚州市,临川区', 361000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (361021, '南城县', '', '江西省,抚州市,南城县', 361000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (361022, '黎川县', '', '江西省,抚州市,黎川县', 361000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (361023, '南丰县', '', '江西省,抚州市,南丰县', 361000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (361024, '崇仁县', '', '江西省,抚州市,崇仁县', 361000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (361025, '乐安县', '', '江西省,抚州市,乐安县', 361000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (361026, '宜黄县', '', '江西省,抚州市,宜黄县', 361000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (361027, '金溪县', '', '江西省,抚州市,金溪县', 361000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (361028, '资溪县', '', '江西省,抚州市,资溪县', 361000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (361029, '东乡县', '', '江西省,抚州市,东乡县', 361000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (361030, '广昌县', '', '江西省,抚州市,广昌县', 361000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (361101, '市辖区', '', '江西省,上饶市,市辖区', 361100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (361102, '信州区', '', '江西省,上饶市,信州区', 361100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (361121, '上饶县', '', '江西省,上饶市,上饶县', 361100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (361122, '广丰县', '', '江西省,上饶市,广丰县', 361100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (361123, '玉山县', '', '江西省,上饶市,玉山县', 361100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (361124, '铅山县', '', '江西省,上饶市,铅山县', 361100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (361125, '横峰县', '', '江西省,上饶市,横峰县', 361100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (361126, '弋阳县', '', '江西省,上饶市,弋阳县', 361100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (361127, '余干县', '', '江西省,上饶市,余干县', 361100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (361128, '鄱阳县', '', '江西省,上饶市,鄱阳县', 361100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (361129, '万年县', '', '江西省,上饶市,万年县', 361100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (361130, '婺源县', '', '江西省,上饶市,婺源县', 361100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (361181, '德兴市', '', '江西省,上饶市,德兴市', 361100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (370102, '历下区', '', '山东省,济南市,历下区', 370100, 3, 1, '117.082976,36.672219', 0);
INSERT INTO `wp_city` VALUES (370103, '市中区', '', '山东省,济南市,市中区', 370100, 3, 1, '117.003839,36.65753', 0);
INSERT INTO `wp_city` VALUES (370104, '槐荫区', '', '山东省,济南市,槐荫区', 370100, 3, 1, '116.907297,36.657584', 0);
INSERT INTO `wp_city` VALUES (370105, '天桥区', '', '山东省,济南市,天桥区', 370100, 3, 1, '116.993768,36.684162', 0);
INSERT INTO `wp_city` VALUES (370112, '历城区', '', '山东省,济南市,历城区', 370100, 3, 1, '117.071919,36.685787', 0);
INSERT INTO `wp_city` VALUES (370113, '长清区', '', '山东省,济南市,长清区', 370100, 3, 1, '116.758377,36.559896', 0);
INSERT INTO `wp_city` VALUES (370124, '平阴县', '', '山东省,济南市,平阴县', 370100, 3, 0, '116.462607,36.295031', 0);
INSERT INTO `wp_city` VALUES (370125, '济阳县', '', '山东省,济南市,济阳县', 370100, 3, 0, '117.17995,36.984145', 0);
INSERT INTO `wp_city` VALUES (370126, '商河县', '', '山东省,济南市,商河县', 370100, 3, 0, '117.16363,37.314939', 0);
INSERT INTO `wp_city` VALUES (370181, '章丘市', '', '山东省,济南市,章丘市', 370100, 3, 1, '117.532344,36.685415', 0);
INSERT INTO `wp_city` VALUES (370106, '高新区', '', '山东省,济南市,高新区', 370100, 3, 1, '117.138596,36.680866', 0);
INSERT INTO `wp_city` VALUES (370202, '市南区', '', '山东省,青岛市,市南区', 370200, 3, 1, '120.419417,36.08081', 0);
INSERT INTO `wp_city` VALUES (370203, '市北区', '', '山东省,青岛市,市北区', 370200, 3, 1, '120.381194,36.093682', 0);
INSERT INTO `wp_city` VALUES (370205, '四方区', '', '山东省,青岛市,四方区', 370200, 3, 1, '120.376979,36.131582', 0);
INSERT INTO `wp_city` VALUES (370211, '黄岛区', '', '山东省,青岛市,黄岛区', 370200, 3, 1, '120.203083,35.965711', 0);
INSERT INTO `wp_city` VALUES (370212, '崂山区', '', '山东省,青岛市,崂山区', 370200, 3, 1, '120.474431,36.114399', 0);
INSERT INTO `wp_city` VALUES (370213, '李沧区', '', '山东省,青岛市,李沧区', 370200, 3, 1, '120.439543,36.150804', 0);
INSERT INTO `wp_city` VALUES (370214, '城阳区', '', '山东省,青岛市,城阳区', 370200, 3, 1, '120.402818,36.313321', 0);
INSERT INTO `wp_city` VALUES (370281, '胶州市', '', '山东省,青岛市,胶州市', 370200, 3, 1, '120.040078,36.270389', 0);
INSERT INTO `wp_city` VALUES (370282, '即墨市', '', '山东省,青岛市,即墨市', 370200, 3, 1, '120.453685,36.395272', 0);
INSERT INTO `wp_city` VALUES (370283, '平度市', '', '山东省,青岛市,平度市', 370200, 3, 1, '119.966489,36.792517', 0);
INSERT INTO `wp_city` VALUES (370284, '胶南市', '', '山东省,青岛市,胶南市', 370200, 3, 1, '119.85631,35.852858', 0);
INSERT INTO `wp_city` VALUES (370285, '莱西市', '', '山东省,青岛市,莱西市', 370200, 3, 1, '120.524325,36.89394', 0);
INSERT INTO `wp_city` VALUES (370301, '市辖区', '', '山东省,淄博市,市辖区', 370300, 3, 1, '112.855303,35.520559', 0);
INSERT INTO `wp_city` VALUES (370302, '淄川区', '', '山东省,淄博市,淄川区', 370300, 3, 1, '117.973141,36.649837', 0);
INSERT INTO `wp_city` VALUES (370303, '张店区', '', '山东省,淄博市,张店区', 370300, 3, 1, '118.024491,36.812252', 0);
INSERT INTO `wp_city` VALUES (370304, '博山区', '', '山东省,淄博市,博山区', 370300, 3, 1, '117.868187,36.500883', 0);
INSERT INTO `wp_city` VALUES (370305, '临淄区', '', '山东省,淄博市,临淄区', 370300, 3, 1, '118.316102,36.832231', 0);
INSERT INTO `wp_city` VALUES (370306, '周村区', '', '山东省,淄博市,周村区', 370300, 3, 1, '117.876221,36.808979', 0);
INSERT INTO `wp_city` VALUES (370321, '桓台县', '', '山东省,淄博市,桓台县', 370300, 3, 1, '118.104404,36.965538', 0);
INSERT INTO `wp_city` VALUES (370322, '高青县', '', '山东省,淄博市,高青县', 370300, 3, 1, '117.833145,37.177316', 0);
INSERT INTO `wp_city` VALUES (370323, '沂源县', '', '山东省,淄博市,沂源县', 370300, 3, 1, '118.177261,36.190893', 0);
INSERT INTO `wp_city` VALUES (370401, '市辖区', '', '山东省,枣庄市,市辖区', 370400, 3, 0, '112.855303,35.520559', 0);
INSERT INTO `wp_city` VALUES (370402, '市中区', '', '山东省,枣庄市,市中区', 370400, 3, 0, '117.562576,34.870023', 0);
INSERT INTO `wp_city` VALUES (370403, '薛城区', '', '山东省,枣庄市,薛城区', 370400, 3, 0, '117.269659,34.801141', 0);
INSERT INTO `wp_city` VALUES (370404, '峄城区', '', '山东省,枣庄市,峄城区', 370400, 3, 0, '117.596999,34.778585', 0);
INSERT INTO `wp_city` VALUES (370405, '台儿庄区', '', '山东省,枣庄市,台儿庄区', 370400, 3, 0, '117.740275,34.568875', 0);
INSERT INTO `wp_city` VALUES (370406, '山亭区', '', '山东省,枣庄市,山亭区', 370400, 3, 0, '117.467742,35.105827', 0);
INSERT INTO `wp_city` VALUES (370481, '滕州市', '', '山东省,枣庄市,滕州市', 370400, 3, 0, '117.172526,35.119115', 0);
INSERT INTO `wp_city` VALUES (370501, '市辖区', '', '山东省,东营市,市辖区', 370500, 3, 0, '112.855303,35.520559', 0);
INSERT INTO `wp_city` VALUES (370502, '东营区', '', '山东省,东营市,东营区', 370500, 3, 0, '118.588614,37.454925', 0);
INSERT INTO `wp_city` VALUES (370503, '河口区', '', '山东省,东营市,河口区', 370500, 3, 0, '118.531948,37.89215', 0);
INSERT INTO `wp_city` VALUES (370521, '垦利县', '', '山东省,东营市,垦利县', 370500, 3, 0, '118.554109,37.59377', 0);
INSERT INTO `wp_city` VALUES (370522, '利津县', '', '山东省,东营市,利津县', 370500, 3, 0, '118.261978,37.495939', 0);
INSERT INTO `wp_city` VALUES (370523, '广饶县', '', '山东省,东营市,广饶县', 370500, 3, 0, '118.413518,37.059529', 0);
INSERT INTO `wp_city` VALUES (370601, '市辖区', '', '山东省,烟台市,市辖区', 370600, 3, 0, '112.855303,35.520559', 0);
INSERT INTO `wp_city` VALUES (370602, '芝罘区', '', '山东省,烟台市,芝罘区', 370600, 3, 0, '121.406649,37.546425', 0);
INSERT INTO `wp_city` VALUES (370611, '福山区', '', '山东省,烟台市,福山区', 370600, 3, 0, '121.274176,37.503605', 0);
INSERT INTO `wp_city` VALUES (370612, '牟平区', '', '山东省,烟台市,牟平区', 370600, 3, 0, '121.606971,37.392639', 0);
INSERT INTO `wp_city` VALUES (370613, '莱山区', '', '山东省,烟台市,莱山区', 370600, 3, 0, '121.451852,37.517386', 0);
INSERT INTO `wp_city` VALUES (370634, '长岛县', '', '山东省,烟台市,长岛县', 370600, 3, 0, '120.742877,37.927586', 0);
INSERT INTO `wp_city` VALUES (370681, '龙口市', '', '山东省,烟台市,龙口市', 370600, 3, 0, '120.485089,37.649805', 0);
INSERT INTO `wp_city` VALUES (370682, '莱阳市', '', '山东省,烟台市,莱阳市', 370600, 3, 0, '120.718225,36.985114', 0);
INSERT INTO `wp_city` VALUES (370683, '莱州市', '', '山东省,烟台市,莱州市', 370600, 3, 0, '119.948763,37.182657', 0);
INSERT INTO `wp_city` VALUES (370684, '蓬莱市', '', '山东省,烟台市,蓬莱市', 370600, 3, 0, '120.765381,37.816562', 0);
INSERT INTO `wp_city` VALUES (370685, '招远市', '', '山东省,烟台市,招远市', 370600, 3, 0, '120.440811,37.36105', 0);
INSERT INTO `wp_city` VALUES (370686, '栖霞市', '', '山东省,烟台市,栖霞市', 370600, 3, 0, '120.856186,37.34137', 0);
INSERT INTO `wp_city` VALUES (370687, '海阳市', '', '山东省,烟台市,海阳市', 370600, 3, 0, '121.165026,36.782244', 0);
INSERT INTO `wp_city` VALUES (370701, '市辖区', '', '山东省,潍坊市,市辖区', 370700, 3, 0, '112.855303,35.520559', 0);
INSERT INTO `wp_city` VALUES (370702, '潍城区', '', '山东省,潍坊市,潍城区', 370700, 3, 0, '119.030323,36.732909', 0);
INSERT INTO `wp_city` VALUES (370703, '寒亭区', '', '山东省,潍坊市,寒亭区', 370700, 3, 0, '119.226555,36.780704', 0);
INSERT INTO `wp_city` VALUES (370704, '坊子区', '', '山东省,潍坊市,坊子区', 370700, 3, 0, '119.172471,36.660921', 0);
INSERT INTO `wp_city` VALUES (370705, '奎文区', '', '山东省,潍坊市,奎文区', 370700, 3, 0, '119.139263,36.714689', 0);
INSERT INTO `wp_city` VALUES (370724, '临朐县', '', '山东省,潍坊市,临朐县', 370700, 3, 0, '118.54945,36.51854', 0);
INSERT INTO `wp_city` VALUES (370725, '昌乐县', '', '山东省,潍坊市,昌乐县', 370700, 3, 0, '118.836327,36.713019', 0);
INSERT INTO `wp_city` VALUES (370781, '青州市', '', '山东省,潍坊市,青州市', 370700, 3, 0, '118.486195,36.690382', 0);
INSERT INTO `wp_city` VALUES (370782, '诸城市', '', '山东省,潍坊市,诸城市', 370700, 3, 0, '119.416232,36.00214', 0);
INSERT INTO `wp_city` VALUES (370783, '寿光市', '', '山东省,潍坊市,寿光市', 370700, 3, 0, '118.797395,36.861732', 0);
INSERT INTO `wp_city` VALUES (370784, '安丘市', '', '山东省,潍坊市,安丘市', 370700, 3, 0, '119.224447,36.484064', 0);
INSERT INTO `wp_city` VALUES (370785, '高密市', '', '山东省,潍坊市,高密市', 370700, 3, 0, '119.762091,36.388925', 0);
INSERT INTO `wp_city` VALUES (370786, '昌邑市', '', '山东省,潍坊市,昌邑市', 370700, 3, 0, '119.405026,36.865202', 0);
INSERT INTO `wp_city` VALUES (370801, '市辖区', '', '山东省,济宁市,市辖区', 370800, 3, 0, '112.855303,35.520559', 0);
INSERT INTO `wp_city` VALUES (370802, '市中区', '', '山东省,济宁市,市中区', 370800, 3, 0, '116.59834,35.410529', 0);
INSERT INTO `wp_city` VALUES (370811, '任城区', '', '山东省,济宁市,任城区', 370800, 3, 0, '116.603067,35.413975', 0);
INSERT INTO `wp_city` VALUES (370826, '微山县', '', '山东省,济宁市,微山县', 370800, 3, 0, '117.135274,34.813496', 0);
INSERT INTO `wp_city` VALUES (370827, '鱼台县', '', '山东省,济宁市,鱼台县', 370800, 3, 0, '116.656851,35.017903', 0);
INSERT INTO `wp_city` VALUES (370828, '金乡县', '', '山东省,济宁市,金乡县', 370800, 3, 0, '116.318007,35.072589', 0);
INSERT INTO `wp_city` VALUES (370829, '嘉祥县', '', '山东省,济宁市,嘉祥县', 370800, 3, 0, '116.349103,35.413156', 0);
INSERT INTO `wp_city` VALUES (370830, '汶上县', '', '山东省,济宁市,汶上县', 370800, 3, 0, '116.495656,35.738789', 0);
INSERT INTO `wp_city` VALUES (370831, '泗水县', '', '山东省,济宁市,泗水县', 370800, 3, 0, '117.258592,35.670998', 0);
INSERT INTO `wp_city` VALUES (370832, '梁山县', '', '山东省,济宁市,梁山县', 370800, 3, 0, '116.10246,35.808064', 0);
INSERT INTO `wp_city` VALUES (370881, '曲阜市', '', '山东省,济宁市,曲阜市', 370800, 3, 0, '116.992898,35.587086', 0);
INSERT INTO `wp_city` VALUES (370882, '兖州市', '', '山东省,济宁市,兖州市', 370800, 3, 0, '116.754139,35.574016', 0);
INSERT INTO `wp_city` VALUES (370883, '邹城市', '', '山东省,济宁市,邹城市', 370800, 3, 0, '117.010251,35.411565', 0);
INSERT INTO `wp_city` VALUES (370901, '市辖区', '', '山东省,泰安市,市辖区', 370900, 3, 0, '112.855303,35.520559', 0);
INSERT INTO `wp_city` VALUES (370902, '泰山区', '', '山东省,泰安市,泰山区', 370900, 3, 0, '117.141673,36.198221', 0);
INSERT INTO `wp_city` VALUES (370903, '岱岳区', '', '山东省,泰安市,岱岳区', 370900, 3, 0, '117.048356,36.193314', 0);
INSERT INTO `wp_city` VALUES (370921, '宁阳县', '', '山东省,泰安市,宁阳县', 370900, 3, 0, '116.813854,35.765334', 0);
INSERT INTO `wp_city` VALUES (370923, '东平县', '', '山东省,泰安市,东平县', 370900, 3, 0, '116.476836,35.94278', 0);
INSERT INTO `wp_city` VALUES (370982, '新泰市', '', '山东省,泰安市,新泰市', 370900, 3, 0, '117.774606,35.9145', 0);
INSERT INTO `wp_city` VALUES (370983, '肥城市', '', '山东省,泰安市,肥城市', 370900, 3, 0, '116.775571,36.18876', 0);
INSERT INTO `wp_city` VALUES (371001, '市辖区', '', '山东省,威海市,市辖区', 371000, 3, 0, '112.855303,35.520559', 0);
INSERT INTO `wp_city` VALUES (371002, '环翠区', '', '山东省,威海市,环翠区', 371000, 3, 0, '122.130016,37.507997', 0);
INSERT INTO `wp_city` VALUES (371081, '文登市', '', '山东省,威海市,文登市', 371000, 3, 0, '122.010782,37.15412', 0);
INSERT INTO `wp_city` VALUES (371082, '荣成市', '', '山东省,威海市,荣成市', 371000, 3, 0, '122.492783,37.171153', 0);
INSERT INTO `wp_city` VALUES (371083, '乳山市', '', '山东省,威海市,乳山市', 371000, 3, 0, '121.546627,36.92639', 0);
INSERT INTO `wp_city` VALUES (371101, '市辖区', '', '山东省,日照市,市辖区', 371100, 3, 0, '112.855303,35.520559', 0);
INSERT INTO `wp_city` VALUES (371102, '东港区', '', '山东省,日照市,东港区', 371100, 3, 0, '119.469044,35.4311', 0);
INSERT INTO `wp_city` VALUES (371103, '岚山区', '', '山东省,日照市,岚山区', 371100, 3, 0, '119.32544,35.127894', 0);
INSERT INTO `wp_city` VALUES (371121, '五莲县', '', '山东省,日照市,五莲县', 371100, 3, 0, '119.21533,35.75588', 0);
INSERT INTO `wp_city` VALUES (371122, '莒　县', '', '山东省,日照市,莒　县', 371100, 3, 0, '118.843408,35.585844', 0);
INSERT INTO `wp_city` VALUES (371201, '市辖区', '', '山东省,莱芜市,市辖区', 371200, 3, 0, '112.855303,35.520559', 0);
INSERT INTO `wp_city` VALUES (371202, '莱城区', '', '山东省,莱芜市,莱城区', 371200, 3, 0, '117.666511,36.208811', 0);
INSERT INTO `wp_city` VALUES (371203, '钢城区', '', '山东省,莱芜市,钢城区', 371200, 3, 0, '117.817565,36.06468', 0);
INSERT INTO `wp_city` VALUES (371301, '市辖区', '', '山东省,临沂市,市辖区', 371300, 3, 0, '112.855303,35.520559', 0);
INSERT INTO `wp_city` VALUES (371302, '兰山区', '', '山东省,临沂市,兰山区', 371300, 3, 0, '118.354369,35.057553', 0);
INSERT INTO `wp_city` VALUES (371311, '罗庄区', '', '山东省,临沂市,罗庄区', 371300, 3, 0, '118.290886,35.002253', 0);
INSERT INTO `wp_city` VALUES (371312, '河东区', '', '山东省,临沂市,河东区', 371300, 3, 0, '118.408395,35.093146', 0);
INSERT INTO `wp_city` VALUES (371321, '沂南县', '', '山东省,临沂市,沂南县', 371300, 3, 0, '118.472155,35.556096', 0);
INSERT INTO `wp_city` VALUES (371322, '郯城县', '', '山东省,临沂市,郯城县', 371300, 3, 0, '118.373758,34.619294', 0);
INSERT INTO `wp_city` VALUES (371323, '沂水县', '', '山东省,临沂市,沂水县', 371300, 3, 0, '118.634438,35.796019', 0);
INSERT INTO `wp_city` VALUES (371324, '苍山县', '', '山东省,临沂市,苍山县', 371300, 3, 0, '117.998342,34.865344', 0);
INSERT INTO `wp_city` VALUES (371325, '费　县', '', '山东省,临沂市,费　县', 371300, 3, 0, '117.983531,35.272807', 0);
INSERT INTO `wp_city` VALUES (371326, '平邑县', '', '山东省,临沂市,平邑县', 371300, 3, 0, '117.647023,35.511682', 0);
INSERT INTO `wp_city` VALUES (371327, '莒南县', '', '山东省,临沂市,莒南县', 371300, 3, 0, '118.841973,35.180764', 0);
INSERT INTO `wp_city` VALUES (371328, '蒙阴县', '', '山东省,临沂市,蒙阴县', 371300, 3, 0, '117.951355,35.716346', 0);
INSERT INTO `wp_city` VALUES (371329, '临沭县', '', '山东省,临沂市,临沭县', 371300, 3, 0, '118.657126,34.925862', 0);
INSERT INTO `wp_city` VALUES (371401, '市辖区', '', '山东省,德州市,市辖区', 371400, 3, 0, '112.855303,35.520559', 0);
INSERT INTO `wp_city` VALUES (371402, '德城区', '', '山东省,德州市,德城区', 371400, 3, 0, '116.305861,37.456977', 0);
INSERT INTO `wp_city` VALUES (371421, '陵　县', '', '山东省,德州市,陵　县', 371400, 3, 0, '116.66506,37.417105', 0);
INSERT INTO `wp_city` VALUES (371422, '宁津县', '', '山东省,德州市,宁津县', 371400, 3, 0, '116.806769,37.658025', 0);
INSERT INTO `wp_city` VALUES (371423, '庆云县', '', '山东省,德州市,庆云县', 371400, 3, 0, '117.391422,37.781366', 0);
INSERT INTO `wp_city` VALUES (371424, '临邑县', '', '山东省,德州市,临邑县', 371400, 3, 0, '116.873005,37.196245', 0);
INSERT INTO `wp_city` VALUES (371425, '齐河县', '', '山东省,德州市,齐河县', 371400, 3, 0, '116.766396,36.801266', 0);
INSERT INTO `wp_city` VALUES (371426, '平原县', '', '山东省,德州市,平原县', 371400, 3, 0, '116.440454,37.171302', 0);
INSERT INTO `wp_city` VALUES (371427, '夏津县', '', '山东省,德州市,夏津县', 371400, 3, 0, '116.008286,36.954411', 0);
INSERT INTO `wp_city` VALUES (371428, '武城县', '', '山东省,德州市,武城县', 371400, 3, 0, '116.075738,37.219188', 0);
INSERT INTO `wp_city` VALUES (371481, '乐陵市', '', '山东省,德州市,乐陵市', 371400, 3, 0, '117.238117,37.736112', 0);
INSERT INTO `wp_city` VALUES (371482, '禹城市', '', '山东省,德州市,禹城市', 371400, 3, 0, '116.644501,36.940282', 0);
INSERT INTO `wp_city` VALUES (371501, '市辖区', '', '山东省,聊城市,市辖区', 371500, 3, 0, '112.855303,35.520559', 0);
INSERT INTO `wp_city` VALUES (371502, '东昌府区', '', '山东省,聊城市,东昌府区', 371500, 3, 0, '115.995056,36.440201', 0);
INSERT INTO `wp_city` VALUES (371521, '阳谷县', '', '山东省,聊城市,阳谷县', 371500, 3, 0, '115.797707,36.12078', 0);
INSERT INTO `wp_city` VALUES (371522, '莘　县', '', '山东省,聊城市,莘　县', 371500, 3, 0, '115.677118,36.239915', 0);
INSERT INTO `wp_city` VALUES (371523, '茌平县', '', '山东省,聊城市,茌平县', 371500, 3, 0, '116.261674,36.586769', 0);
INSERT INTO `wp_city` VALUES (371524, '东阿县', '', '山东省,聊城市,东阿县', 371500, 3, 0, '116.254224,36.340983', 0);
INSERT INTO `wp_city` VALUES (371525, '冠　县', '', '山东省,聊城市,冠　县', 371500, 3, 0, '115.449025,36.489694', 0);
INSERT INTO `wp_city` VALUES (371526, '高唐县', '', '山东省,聊城市,高唐县', 371500, 3, 0, '116.237721,36.871735', 0);
INSERT INTO `wp_city` VALUES (371581, '临清市', '', '山东省,聊城市,临清市', 371500, 3, 0, '115.71151,36.844429', 0);
INSERT INTO `wp_city` VALUES (371601, '市辖区', '', '山东省,滨州市,市辖区', 371600, 3, 0, '112.855303,35.520559', 0);
INSERT INTO `wp_city` VALUES (371602, '滨城区', '', '山东省,滨州市,滨城区', 371600, 3, 0, '118.029389,37.432906', 0);
INSERT INTO `wp_city` VALUES (371621, '惠民县', '', '山东省,滨州市,惠民县', 371600, 3, 0, '117.515705,37.495838', 0);
INSERT INTO `wp_city` VALUES (371622, '阳信县', '', '山东省,滨州市,阳信县', 371600, 3, 0, '117.584636,37.647231', 0);
INSERT INTO `wp_city` VALUES (371623, '无棣县', '', '山东省,滨州市,无棣县', 371600, 3, 0, '117.632226,37.776001', 0);
INSERT INTO `wp_city` VALUES (371624, '沾化县', '', '山东省,滨州市,沾化县', 371600, 3, 0, '118.090098,37.787251', 0);
INSERT INTO `wp_city` VALUES (371625, '博兴县', '', '山东省,滨州市,博兴县', 371600, 3, 0, '118.117454,37.158968', 0);
INSERT INTO `wp_city` VALUES (371626, '邹平县', '', '山东省,滨州市,邹平县', 371600, 3, 0, '117.749569,36.869121', 0);
INSERT INTO `wp_city` VALUES (371701, '市辖区', '', '山东省,荷泽市,市辖区', 371700, 3, 0, '112.855303,35.520559', 0);
INSERT INTO `wp_city` VALUES (371702, '牡丹区', '', '山东省,荷泽市,牡丹区', 371700, 3, 0, '115.423105,35.257522', 0);
INSERT INTO `wp_city` VALUES (371721, '曹　县', '', '山东省,荷泽市,曹　县', 371700, 3, 0, '115.548597,34.831741', 0);
INSERT INTO `wp_city` VALUES (371722, '单　县', '', '山东省,荷泽市,单　县', 371700, 3, 0, '116.093816,34.800105', 0);
INSERT INTO `wp_city` VALUES (371723, '成武县', '', '山东省,荷泽市,成武县', 371700, 3, 0, '115.896161,34.958449', 0);
INSERT INTO `wp_city` VALUES (371724, '巨野县', '', '山东省,荷泽市,巨野县', 371700, 3, 0, '116.101549,35.401993', 0);
INSERT INTO `wp_city` VALUES (371725, '郓城县', '', '山东省,荷泽市,郓城县', 371700, 3, 0, '115.950089,35.605949', 0);
INSERT INTO `wp_city` VALUES (371726, '鄄城县', '', '山东省,荷泽市,鄄城县', 371700, 3, 0, '115.516657,35.569205', 0);
INSERT INTO `wp_city` VALUES (371727, '定陶县', '', '山东省,荷泽市,定陶县', 371700, 3, 0, '115.579417,35.077225', 0);
INSERT INTO `wp_city` VALUES (371728, '东明县', '', '山东省,荷泽市,东明县', 371700, 3, 0, '115.096578,35.29583', 0);
INSERT INTO `wp_city` VALUES (410101, '市辖区', '', '河南省,郑州市,市辖区', 410100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410102, '中原区', '', '河南省,郑州市,中原区', 410100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410103, '二七区', '', '河南省,郑州市,二七区', 410100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410104, '管城回族区', '', '河南省,郑州市,管城回族区', 410100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410105, '金水区', '', '河南省,郑州市,金水区', 410100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410106, '上街区', '', '河南省,郑州市,上街区', 410100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410108, '邙山区', '', '河南省,郑州市,邙山区', 410100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410122, '中牟县', '', '河南省,郑州市,中牟县', 410100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410181, '巩义市', '', '河南省,郑州市,巩义市', 410100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410182, '荥阳市', '', '河南省,郑州市,荥阳市', 410100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410183, '新密市', '', '河南省,郑州市,新密市', 410100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410184, '新郑市', '', '河南省,郑州市,新郑市', 410100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410185, '登封市', '', '河南省,郑州市,登封市', 410100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410201, '市辖区', '', '河南省,开封市,市辖区', 410200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410202, '龙亭区', '', '河南省,开封市,龙亭区', 410200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410203, '顺河回族区', '', '河南省,开封市,顺河回族区', 410200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410204, '鼓楼区', '', '河南省,开封市,鼓楼区', 410200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410205, '南关区', '', '河南省,开封市,南关区', 410200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410211, '郊　区', '', '河南省,开封市,郊　区', 410200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410221, '杞　县', '', '河南省,开封市,杞　县', 410200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410222, '通许县', '', '河南省,开封市,通许县', 410200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410223, '尉氏县', '', '河南省,开封市,尉氏县', 410200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410224, '开封县', '', '河南省,开封市,开封县', 410200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410225, '兰考县', '', '河南省,开封市,兰考县', 410200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410301, '市辖区', '', '河南省,洛阳市,市辖区', 410300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410302, '老城区', '', '河南省,洛阳市,老城区', 410300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410303, '西工区', '', '河南省,洛阳市,西工区', 410300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410304, '廛河回族区', '', '河南省,洛阳市,廛河回族区', 410300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410305, '涧西区', '', '河南省,洛阳市,涧西区', 410300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410306, '吉利区', '', '河南省,洛阳市,吉利区', 410300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410307, '洛龙区', '', '河南省,洛阳市,洛龙区', 410300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410322, '孟津县', '', '河南省,洛阳市,孟津县', 410300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410323, '新安县', '', '河南省,洛阳市,新安县', 410300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410324, '栾川县', '', '河南省,洛阳市,栾川县', 410300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410325, '嵩　县', '', '河南省,洛阳市,嵩　县', 410300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410326, '汝阳县', '', '河南省,洛阳市,汝阳县', 410300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410327, '宜阳县', '', '河南省,洛阳市,宜阳县', 410300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410328, '洛宁县', '', '河南省,洛阳市,洛宁县', 410300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410329, '伊川县', '', '河南省,洛阳市,伊川县', 410300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410381, '偃师市', '', '河南省,洛阳市,偃师市', 410300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410401, '市辖区', '', '河南省,平顶山市,市辖区', 410400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410402, '新华区', '', '河南省,平顶山市,新华区', 410400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410403, '卫东区', '', '河南省,平顶山市,卫东区', 410400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410404, '石龙区', '', '河南省,平顶山市,石龙区', 410400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410411, '湛河区', '', '河南省,平顶山市,湛河区', 410400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410421, '宝丰县', '', '河南省,平顶山市,宝丰县', 410400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410422, '叶　县', '', '河南省,平顶山市,叶　县', 410400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410423, '鲁山县', '', '河南省,平顶山市,鲁山县', 410400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410425, '郏　县', '', '河南省,平顶山市,郏　县', 410400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410481, '舞钢市', '', '河南省,平顶山市,舞钢市', 410400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410482, '汝州市', '', '河南省,平顶山市,汝州市', 410400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410501, '市辖区', '', '河南省,安阳市,市辖区', 410500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410502, '文峰区', '', '河南省,安阳市,文峰区', 410500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410503, '北关区', '', '河南省,安阳市,北关区', 410500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410505, '殷都区', '', '河南省,安阳市,殷都区', 410500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410506, '龙安区', '', '河南省,安阳市,龙安区', 410500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410522, '安阳县', '', '河南省,安阳市,安阳县', 410500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410523, '汤阴县', '', '河南省,安阳市,汤阴县', 410500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410526, '滑　县', '', '河南省,安阳市,滑　县', 410500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410527, '内黄县', '', '河南省,安阳市,内黄县', 410500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410581, '林州市', '', '河南省,安阳市,林州市', 410500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410601, '市辖区', '', '河南省,鹤壁市,市辖区', 410600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410602, '鹤山区', '', '河南省,鹤壁市,鹤山区', 410600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410603, '山城区', '', '河南省,鹤壁市,山城区', 410600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410611, '淇滨区', '', '河南省,鹤壁市,淇滨区', 410600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410621, '浚　县', '', '河南省,鹤壁市,浚　县', 410600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410622, '淇　县', '', '河南省,鹤壁市,淇　县', 410600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410701, '市辖区', '', '河南省,新乡市,市辖区', 410700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410702, '红旗区', '', '河南省,新乡市,红旗区', 410700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410703, '卫滨区', '', '河南省,新乡市,卫滨区', 410700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410704, '凤泉区', '', '河南省,新乡市,凤泉区', 410700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410711, '牧野区', '', '河南省,新乡市,牧野区', 410700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410721, '新乡县', '', '河南省,新乡市,新乡县', 410700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410724, '获嘉县', '', '河南省,新乡市,获嘉县', 410700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410725, '原阳县', '', '河南省,新乡市,原阳县', 410700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410726, '延津县', '', '河南省,新乡市,延津县', 410700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410727, '封丘县', '', '河南省,新乡市,封丘县', 410700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410728, '长垣县', '', '河南省,新乡市,长垣县', 410700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410781, '卫辉市', '', '河南省,新乡市,卫辉市', 410700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410782, '辉县市', '', '河南省,新乡市,辉县市', 410700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410801, '市辖区', '', '河南省,焦作市,市辖区', 410800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410802, '解放区', '', '河南省,焦作市,解放区', 410800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410803, '中站区', '', '河南省,焦作市,中站区', 410800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410804, '马村区', '', '河南省,焦作市,马村区', 410800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410811, '山阳区', '', '河南省,焦作市,山阳区', 410800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410821, '修武县', '', '河南省,焦作市,修武县', 410800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410822, '博爱县', '', '河南省,焦作市,博爱县', 410800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410823, '武陟县', '', '河南省,焦作市,武陟县', 410800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410825, '温　县', '', '河南省,焦作市,温　县', 410800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410881, '济源市', '', '河南省,焦作市,济源市', 410800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410882, '沁阳市', '', '河南省,焦作市,沁阳市', 410800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410883, '孟州市', '', '河南省,焦作市,孟州市', 410800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410901, '市辖区', '', '河南省,濮阳市,市辖区', 410900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410902, '华龙区', '', '河南省,濮阳市,华龙区', 410900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410922, '清丰县', '', '河南省,濮阳市,清丰县', 410900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410923, '南乐县', '', '河南省,濮阳市,南乐县', 410900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410926, '范　县', '', '河南省,濮阳市,范　县', 410900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410927, '台前县', '', '河南省,濮阳市,台前县', 410900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (410928, '濮阳县', '', '河南省,濮阳市,濮阳县', 410900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411001, '市辖区', '', '河南省,许昌市,市辖区', 411000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411002, '魏都区', '', '河南省,许昌市,魏都区', 411000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411023, '许昌县', '', '河南省,许昌市,许昌县', 411000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411024, '鄢陵县', '', '河南省,许昌市,鄢陵县', 411000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411025, '襄城县', '', '河南省,许昌市,襄城县', 411000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411081, '禹州市', '', '河南省,许昌市,禹州市', 411000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411082, '长葛市', '', '河南省,许昌市,长葛市', 411000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411101, '市辖区', '', '河南省,漯河市,市辖区', 411100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411102, '源汇区', '', '河南省,漯河市,源汇区', 411100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411103, '郾城区', '', '河南省,漯河市,郾城区', 411100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411104, '召陵区', '', '河南省,漯河市,召陵区', 411100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411121, '舞阳县', '', '河南省,漯河市,舞阳县', 411100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411122, '临颍县', '', '河南省,漯河市,临颍县', 411100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411201, '市辖区', '', '河南省,三门峡市,市辖区', 411200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411202, '湖滨区', '', '河南省,三门峡市,湖滨区', 411200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411221, '渑池县', '', '河南省,三门峡市,渑池县', 411200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411222, '陕　县', '', '河南省,三门峡市,陕　县', 411200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411224, '卢氏县', '', '河南省,三门峡市,卢氏县', 411200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411281, '义马市', '', '河南省,三门峡市,义马市', 411200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411282, '灵宝市', '', '河南省,三门峡市,灵宝市', 411200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411301, '市辖区', '', '河南省,南阳市,市辖区', 411300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411302, '宛城区', '', '河南省,南阳市,宛城区', 411300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411303, '卧龙区', '', '河南省,南阳市,卧龙区', 411300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411321, '南召县', '', '河南省,南阳市,南召县', 411300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411322, '方城县', '', '河南省,南阳市,方城县', 411300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411323, '西峡县', '', '河南省,南阳市,西峡县', 411300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411324, '镇平县', '', '河南省,南阳市,镇平县', 411300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411325, '内乡县', '', '河南省,南阳市,内乡县', 411300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411326, '淅川县', '', '河南省,南阳市,淅川县', 411300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411327, '社旗县', '', '河南省,南阳市,社旗县', 411300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411328, '唐河县', '', '河南省,南阳市,唐河县', 411300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411329, '新野县', '', '河南省,南阳市,新野县', 411300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411330, '桐柏县', '', '河南省,南阳市,桐柏县', 411300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411381, '邓州市', '', '河南省,南阳市,邓州市', 411300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411401, '市辖区', '', '河南省,商丘市,市辖区', 411400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411402, '梁园区', '', '河南省,商丘市,梁园区', 411400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411403, '睢阳区', '', '河南省,商丘市,睢阳区', 411400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411421, '民权县', '', '河南省,商丘市,民权县', 411400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411422, '睢　县', '', '河南省,商丘市,睢　县', 411400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411423, '宁陵县', '', '河南省,商丘市,宁陵县', 411400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411424, '柘城县', '', '河南省,商丘市,柘城县', 411400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411425, '虞城县', '', '河南省,商丘市,虞城县', 411400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411426, '夏邑县', '', '河南省,商丘市,夏邑县', 411400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411481, '永城市', '', '河南省,商丘市,永城市', 411400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411501, '市辖区', '', '河南省,信阳市,市辖区', 411500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411502, '师河区', '', '河南省,信阳市,师河区', 411500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411503, '平桥区', '', '河南省,信阳市,平桥区', 411500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411521, '罗山县', '', '河南省,信阳市,罗山县', 411500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411522, '光山县', '', '河南省,信阳市,光山县', 411500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411523, '新　县', '', '河南省,信阳市,新　县', 411500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411524, '商城县', '', '河南省,信阳市,商城县', 411500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411525, '固始县', '', '河南省,信阳市,固始县', 411500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411526, '潢川县', '', '河南省,信阳市,潢川县', 411500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411527, '淮滨县', '', '河南省,信阳市,淮滨县', 411500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411528, '息　县', '', '河南省,信阳市,息　县', 411500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411601, '市辖区', '', '河南省,周口市,市辖区', 411600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411602, '川汇区', '', '河南省,周口市,川汇区', 411600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411621, '扶沟县', '', '河南省,周口市,扶沟县', 411600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411622, '西华县', '', '河南省,周口市,西华县', 411600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411623, '商水县', '', '河南省,周口市,商水县', 411600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411624, '沈丘县', '', '河南省,周口市,沈丘县', 411600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411625, '郸城县', '', '河南省,周口市,郸城县', 411600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411626, '淮阳县', '', '河南省,周口市,淮阳县', 411600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411627, '太康县', '', '河南省,周口市,太康县', 411600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411628, '鹿邑县', '', '河南省,周口市,鹿邑县', 411600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411681, '项城市', '', '河南省,周口市,项城市', 411600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411701, '市辖区', '', '河南省,驻马店市,市辖区', 411700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411702, '驿城区', '', '河南省,驻马店市,驿城区', 411700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411721, '西平县', '', '河南省,驻马店市,西平县', 411700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411722, '上蔡县', '', '河南省,驻马店市,上蔡县', 411700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411723, '平舆县', '', '河南省,驻马店市,平舆县', 411700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411724, '正阳县', '', '河南省,驻马店市,正阳县', 411700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411725, '确山县', '', '河南省,驻马店市,确山县', 411700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411726, '泌阳县', '', '河南省,驻马店市,泌阳县', 411700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411727, '汝南县', '', '河南省,驻马店市,汝南县', 411700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411728, '遂平县', '', '河南省,驻马店市,遂平县', 411700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (411729, '新蔡县', '', '河南省,驻马店市,新蔡县', 411700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420101, '市辖区', '', '湖北省,武汉市,市辖区', 420100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420102, '江岸区', '', '湖北省,武汉市,江岸区', 420100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420103, '江汉区', '', '湖北省,武汉市,江汉区', 420100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420104, '乔口区', '', '湖北省,武汉市,乔口区', 420100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420105, '汉阳区', '', '湖北省,武汉市,汉阳区', 420100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420106, '武昌区', '', '湖北省,武汉市,武昌区', 420100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420107, '青山区', '', '湖北省,武汉市,青山区', 420100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420111, '洪山区', '', '湖北省,武汉市,洪山区', 420100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420112, '东西湖区', '', '湖北省,武汉市,东西湖区', 420100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420113, '汉南区', '', '湖北省,武汉市,汉南区', 420100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420114, '蔡甸区', '', '湖北省,武汉市,蔡甸区', 420100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420115, '江夏区', '', '湖北省,武汉市,江夏区', 420100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420116, '黄陂区', '', '湖北省,武汉市,黄陂区', 420100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420117, '新洲区', '', '湖北省,武汉市,新洲区', 420100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420201, '市辖区', '', '湖北省,黄石市,市辖区', 420200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420202, '黄石港区', '', '湖北省,黄石市,黄石港区', 420200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420203, '西塞山区', '', '湖北省,黄石市,西塞山区', 420200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420204, '下陆区', '', '湖北省,黄石市,下陆区', 420200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420205, '铁山区', '', '湖北省,黄石市,铁山区', 420200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420222, '阳新县', '', '湖北省,黄石市,阳新县', 420200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420281, '大冶市', '', '湖北省,黄石市,大冶市', 420200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420301, '市辖区', '', '湖北省,十堰市,市辖区', 420300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420302, '茅箭区', '', '湖北省,十堰市,茅箭区', 420300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420303, '张湾区', '', '湖北省,十堰市,张湾区', 420300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420321, '郧　县', '', '湖北省,十堰市,郧　县', 420300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420322, '郧西县', '', '湖北省,十堰市,郧西县', 420300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420323, '竹山县', '', '湖北省,十堰市,竹山县', 420300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420324, '竹溪县', '', '湖北省,十堰市,竹溪县', 420300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420325, '房　县', '', '湖北省,十堰市,房　县', 420300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420381, '丹江口市', '', '湖北省,十堰市,丹江口市', 420300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420501, '市辖区', '', '湖北省,宜昌市,市辖区', 420500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420502, '西陵区', '', '湖北省,宜昌市,西陵区', 420500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420503, '伍家岗区', '', '湖北省,宜昌市,伍家岗区', 420500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420504, '点军区', '', '湖北省,宜昌市,点军区', 420500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420505, '猇亭区', '', '湖北省,宜昌市,猇亭区', 420500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420506, '夷陵区', '', '湖北省,宜昌市,夷陵区', 420500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420525, '远安县', '', '湖北省,宜昌市,远安县', 420500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420526, '兴山县', '', '湖北省,宜昌市,兴山县', 420500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420527, '秭归县', '', '湖北省,宜昌市,秭归县', 420500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420528, '长阳土家族自治县', '', '湖北省,宜昌市,长阳土家族自治县', 420500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420529, '五峰土家族自治县', '', '湖北省,宜昌市,五峰土家族自治县', 420500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420581, '宜都市', '', '湖北省,宜昌市,宜都市', 420500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420582, '当阳市', '', '湖北省,宜昌市,当阳市', 420500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420583, '枝江市', '', '湖北省,宜昌市,枝江市', 420500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420601, '市辖区', '', '湖北省,襄樊市,市辖区', 420600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420602, '襄城区', '', '湖北省,襄樊市,襄城区', 420600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420606, '樊城区', '', '湖北省,襄樊市,樊城区', 420600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420607, '襄阳区', '', '湖北省,襄樊市,襄阳区', 420600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420624, '南漳县', '', '湖北省,襄樊市,南漳县', 420600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420625, '谷城县', '', '湖北省,襄樊市,谷城县', 420600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420626, '保康县', '', '湖北省,襄樊市,保康县', 420600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420682, '老河口市', '', '湖北省,襄樊市,老河口市', 420600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420683, '枣阳市', '', '湖北省,襄樊市,枣阳市', 420600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420684, '宜城市', '', '湖北省,襄樊市,宜城市', 420600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420701, '市辖区', '', '湖北省,鄂州市,市辖区', 420700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420702, '梁子湖区', '', '湖北省,鄂州市,梁子湖区', 420700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420703, '华容区', '', '湖北省,鄂州市,华容区', 420700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420704, '鄂城区', '', '湖北省,鄂州市,鄂城区', 420700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420801, '市辖区', '', '湖北省,荆门市,市辖区', 420800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420802, '东宝区', '', '湖北省,荆门市,东宝区', 420800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420804, '掇刀区', '', '湖北省,荆门市,掇刀区', 420800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420821, '京山县', '', '湖北省,荆门市,京山县', 420800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420822, '沙洋县', '', '湖北省,荆门市,沙洋县', 420800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420881, '钟祥市', '', '湖北省,荆门市,钟祥市', 420800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420901, '市辖区', '', '湖北省,孝感市,市辖区', 420900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420902, '孝南区', '', '湖北省,孝感市,孝南区', 420900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420921, '孝昌县', '', '湖北省,孝感市,孝昌县', 420900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420922, '大悟县', '', '湖北省,孝感市,大悟县', 420900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420923, '云梦县', '', '湖北省,孝感市,云梦县', 420900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420981, '应城市', '', '湖北省,孝感市,应城市', 420900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420982, '安陆市', '', '湖北省,孝感市,安陆市', 420900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (420984, '汉川市', '', '湖北省,孝感市,汉川市', 420900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421001, '市辖区', '', '湖北省,荆州市,市辖区', 421000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421002, '沙市区', '', '湖北省,荆州市,沙市区', 421000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421003, '荆州区', '', '湖北省,荆州市,荆州区', 421000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421022, '公安县', '', '湖北省,荆州市,公安县', 421000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421023, '监利县', '', '湖北省,荆州市,监利县', 421000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421024, '江陵县', '', '湖北省,荆州市,江陵县', 421000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421081, '石首市', '', '湖北省,荆州市,石首市', 421000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421083, '洪湖市', '', '湖北省,荆州市,洪湖市', 421000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421087, '松滋市', '', '湖北省,荆州市,松滋市', 421000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421101, '市辖区', '', '湖北省,黄冈市,市辖区', 421100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421102, '黄州区', '', '湖北省,黄冈市,黄州区', 421100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421121, '团风县', '', '湖北省,黄冈市,团风县', 421100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421122, '红安县', '', '湖北省,黄冈市,红安县', 421100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421123, '罗田县', '', '湖北省,黄冈市,罗田县', 421100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421124, '英山县', '', '湖北省,黄冈市,英山县', 421100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421125, '浠水县', '', '湖北省,黄冈市,浠水县', 421100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421126, '蕲春县', '', '湖北省,黄冈市,蕲春县', 421100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421127, '黄梅县', '', '湖北省,黄冈市,黄梅县', 421100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421181, '麻城市', '', '湖北省,黄冈市,麻城市', 421100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421182, '武穴市', '', '湖北省,黄冈市,武穴市', 421100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421201, '市辖区', '', '湖北省,咸宁市,市辖区', 421200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421202, '咸安区', '', '湖北省,咸宁市,咸安区', 421200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421221, '嘉鱼县', '', '湖北省,咸宁市,嘉鱼县', 421200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421222, '通城县', '', '湖北省,咸宁市,通城县', 421200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421223, '崇阳县', '', '湖北省,咸宁市,崇阳县', 421200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421224, '通山县', '', '湖北省,咸宁市,通山县', 421200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421281, '赤壁市', '', '湖北省,咸宁市,赤壁市', 421200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421301, '市辖区', '', '湖北省,随州市,市辖区', 421300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421302, '曾都区', '', '湖北省,随州市,曾都区', 421300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (421381, '广水市', '', '湖北省,随州市,广水市', 421300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (422801, '恩施市', '', '湖北省,恩施土家族苗族自治州,恩施市', 422800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (422802, '利川市', '', '湖北省,恩施土家族苗族自治州,利川市', 422800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (422822, '建始县', '', '湖北省,恩施土家族苗族自治州,建始县', 422800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (422823, '巴东县', '', '湖北省,恩施土家族苗族自治州,巴东县', 422800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (422825, '宣恩县', '', '湖北省,恩施土家族苗族自治州,宣恩县', 422800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (422826, '咸丰县', '', '湖北省,恩施土家族苗族自治州,咸丰县', 422800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (422827, '来凤县', '', '湖北省,恩施土家族苗族自治州,来凤县', 422800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (422828, '鹤峰县', '', '湖北省,恩施土家族苗族自治州,鹤峰县', 422800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (429004, '仙桃市', '', '湖北省,省直辖行政单位,仙桃市', 429000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (429005, '潜江市', '', '湖北省,省直辖行政单位,潜江市', 429000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (429006, '天门市', '', '湖北省,省直辖行政单位,天门市', 429000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (429021, '神农架林区', '', '湖北省,省直辖行政单位,神农架林区', 429000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430101, '市辖区', '', '湖南省,长沙市,市辖区', 430100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430102, '芙蓉区', '', '湖南省,长沙市,芙蓉区', 430100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430103, '天心区', '', '湖南省,长沙市,天心区', 430100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430104, '岳麓区', '', '湖南省,长沙市,岳麓区', 430100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430105, '开福区', '', '湖南省,长沙市,开福区', 430100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430111, '雨花区', '', '湖南省,长沙市,雨花区', 430100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430121, '长沙县', '', '湖南省,长沙市,长沙县', 430100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430122, '望城县', '', '湖南省,长沙市,望城县', 430100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430124, '宁乡县', '', '湖南省,长沙市,宁乡县', 430100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430181, '浏阳市', '', '湖南省,长沙市,浏阳市', 430100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430201, '市辖区', '', '湖南省,株洲市,市辖区', 430200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430202, '荷塘区', '', '湖南省,株洲市,荷塘区', 430200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430203, '芦淞区', '', '湖南省,株洲市,芦淞区', 430200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430204, '石峰区', '', '湖南省,株洲市,石峰区', 430200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430211, '天元区', '', '湖南省,株洲市,天元区', 430200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430221, '株洲县', '', '湖南省,株洲市,株洲县', 430200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430223, '攸　县', '', '湖南省,株洲市,攸　县', 430200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430224, '茶陵县', '', '湖南省,株洲市,茶陵县', 430200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430225, '炎陵县', '', '湖南省,株洲市,炎陵县', 430200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430281, '醴陵市', '', '湖南省,株洲市,醴陵市', 430200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430301, '市辖区', '', '湖南省,湘潭市,市辖区', 430300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430302, '雨湖区', '', '湖南省,湘潭市,雨湖区', 430300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430304, '岳塘区', '', '湖南省,湘潭市,岳塘区', 430300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430321, '湘潭县', '', '湖南省,湘潭市,湘潭县', 430300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430381, '湘乡市', '', '湖南省,湘潭市,湘乡市', 430300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430382, '韶山市', '', '湖南省,湘潭市,韶山市', 430300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430401, '市辖区', '', '湖南省,衡阳市,市辖区', 430400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430405, '珠晖区', '', '湖南省,衡阳市,珠晖区', 430400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430406, '雁峰区', '', '湖南省,衡阳市,雁峰区', 430400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430407, '石鼓区', '', '湖南省,衡阳市,石鼓区', 430400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430408, '蒸湘区', '', '湖南省,衡阳市,蒸湘区', 430400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430412, '南岳区', '', '湖南省,衡阳市,南岳区', 430400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430421, '衡阳县', '', '湖南省,衡阳市,衡阳县', 430400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430422, '衡南县', '', '湖南省,衡阳市,衡南县', 430400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430423, '衡山县', '', '湖南省,衡阳市,衡山县', 430400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430424, '衡东县', '', '湖南省,衡阳市,衡东县', 430400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430426, '祁东县', '', '湖南省,衡阳市,祁东县', 430400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430481, '耒阳市', '', '湖南省,衡阳市,耒阳市', 430400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430482, '常宁市', '', '湖南省,衡阳市,常宁市', 430400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430501, '市辖区', '', '湖南省,邵阳市,市辖区', 430500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430502, '双清区', '', '湖南省,邵阳市,双清区', 430500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430503, '大祥区', '', '湖南省,邵阳市,大祥区', 430500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430511, '北塔区', '', '湖南省,邵阳市,北塔区', 430500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430521, '邵东县', '', '湖南省,邵阳市,邵东县', 430500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430522, '新邵县', '', '湖南省,邵阳市,新邵县', 430500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430523, '邵阳县', '', '湖南省,邵阳市,邵阳县', 430500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430524, '隆回县', '', '湖南省,邵阳市,隆回县', 430500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430525, '洞口县', '', '湖南省,邵阳市,洞口县', 430500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430527, '绥宁县', '', '湖南省,邵阳市,绥宁县', 430500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430528, '新宁县', '', '湖南省,邵阳市,新宁县', 430500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430529, '城步苗族自治县', '', '湖南省,邵阳市,城步苗族自治县', 430500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430581, '武冈市', '', '湖南省,邵阳市,武冈市', 430500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430601, '市辖区', '', '湖南省,岳阳市,市辖区', 430600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430602, '岳阳楼区', '', '湖南省,岳阳市,岳阳楼区', 430600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430603, '云溪区', '', '湖南省,岳阳市,云溪区', 430600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430611, '君山区', '', '湖南省,岳阳市,君山区', 430600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430621, '岳阳县', '', '湖南省,岳阳市,岳阳县', 430600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430623, '华容县', '', '湖南省,岳阳市,华容县', 430600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430624, '湘阴县', '', '湖南省,岳阳市,湘阴县', 430600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430626, '平江县', '', '湖南省,岳阳市,平江县', 430600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430681, '汨罗市', '', '湖南省,岳阳市,汨罗市', 430600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430682, '临湘市', '', '湖南省,岳阳市,临湘市', 430600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430701, '市辖区', '', '湖南省,常德市,市辖区', 430700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430702, '武陵区', '', '湖南省,常德市,武陵区', 430700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430703, '鼎城区', '', '湖南省,常德市,鼎城区', 430700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430721, '安乡县', '', '湖南省,常德市,安乡县', 430700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430722, '汉寿县', '', '湖南省,常德市,汉寿县', 430700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430723, '澧　县', '', '湖南省,常德市,澧　县', 430700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430724, '临澧县', '', '湖南省,常德市,临澧县', 430700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430725, '桃源县', '', '湖南省,常德市,桃源县', 430700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430726, '石门县', '', '湖南省,常德市,石门县', 430700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430781, '津市市', '', '湖南省,常德市,津市市', 430700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430801, '市辖区', '', '湖南省,张家界市,市辖区', 430800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430802, '永定区', '', '湖南省,张家界市,永定区', 430800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430811, '武陵源区', '', '湖南省,张家界市,武陵源区', 430800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430821, '慈利县', '', '湖南省,张家界市,慈利县', 430800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430822, '桑植县', '', '湖南省,张家界市,桑植县', 430800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430901, '市辖区', '', '湖南省,益阳市,市辖区', 430900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430902, '资阳区', '', '湖南省,益阳市,资阳区', 430900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430903, '赫山区', '', '湖南省,益阳市,赫山区', 430900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430921, '南　县', '', '湖南省,益阳市,南　县', 430900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430922, '桃江县', '', '湖南省,益阳市,桃江县', 430900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430923, '安化县', '', '湖南省,益阳市,安化县', 430900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (430981, '沅江市', '', '湖南省,益阳市,沅江市', 430900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431001, '市辖区', '', '湖南省,郴州市,市辖区', 431000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431002, '北湖区', '', '湖南省,郴州市,北湖区', 431000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431003, '苏仙区', '', '湖南省,郴州市,苏仙区', 431000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431021, '桂阳县', '', '湖南省,郴州市,桂阳县', 431000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431022, '宜章县', '', '湖南省,郴州市,宜章县', 431000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431023, '永兴县', '', '湖南省,郴州市,永兴县', 431000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431024, '嘉禾县', '', '湖南省,郴州市,嘉禾县', 431000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431025, '临武县', '', '湖南省,郴州市,临武县', 431000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431026, '汝城县', '', '湖南省,郴州市,汝城县', 431000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431027, '桂东县', '', '湖南省,郴州市,桂东县', 431000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431028, '安仁县', '', '湖南省,郴州市,安仁县', 431000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431081, '资兴市', '', '湖南省,郴州市,资兴市', 431000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431101, '市辖区', '', '湖南省,永州市,市辖区', 431100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431102, '芝山区', '', '湖南省,永州市,芝山区', 431100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431103, '冷水滩区', '', '湖南省,永州市,冷水滩区', 431100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431121, '祁阳县', '', '湖南省,永州市,祁阳县', 431100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431122, '东安县', '', '湖南省,永州市,东安县', 431100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431123, '双牌县', '', '湖南省,永州市,双牌县', 431100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431124, '道　县', '', '湖南省,永州市,道　县', 431100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431125, '江永县', '', '湖南省,永州市,江永县', 431100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431126, '宁远县', '', '湖南省,永州市,宁远县', 431100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431127, '蓝山县', '', '湖南省,永州市,蓝山县', 431100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431128, '新田县', '', '湖南省,永州市,新田县', 431100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431129, '江华瑶族自治县', '', '湖南省,永州市,江华瑶族自治县', 431100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431201, '市辖区', '', '湖南省,怀化市,市辖区', 431200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431202, '鹤城区', '', '湖南省,怀化市,鹤城区', 431200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431221, '中方县', '', '湖南省,怀化市,中方县', 431200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431222, '沅陵县', '', '湖南省,怀化市,沅陵县', 431200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431223, '辰溪县', '', '湖南省,怀化市,辰溪县', 431200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431224, '溆浦县', '', '湖南省,怀化市,溆浦县', 431200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431225, '会同县', '', '湖南省,怀化市,会同县', 431200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431226, '麻阳苗族自治县', '', '湖南省,怀化市,麻阳苗族自治县', 431200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431227, '新晃侗族自治县', '', '湖南省,怀化市,新晃侗族自治县', 431200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431228, '芷江侗族自治县', '', '湖南省,怀化市,芷江侗族自治县', 431200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431229, '靖州苗族侗族自治县', '', '湖南省,怀化市,靖州苗族侗族自治县', 431200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431230, '通道侗族自治县', '', '湖南省,怀化市,通道侗族自治县', 431200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431281, '洪江市', '', '湖南省,怀化市,洪江市', 431200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431301, '市辖区', '', '湖南省,娄底市,市辖区', 431300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431302, '娄星区', '', '湖南省,娄底市,娄星区', 431300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431321, '双峰县', '', '湖南省,娄底市,双峰县', 431300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431322, '新化县', '', '湖南省,娄底市,新化县', 431300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431381, '冷水江市', '', '湖南省,娄底市,冷水江市', 431300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (431382, '涟源市', '', '湖南省,娄底市,涟源市', 431300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (433101, '吉首市', '', '湖南省,湘西土家族苗族自治州,吉首市', 433100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (433122, '泸溪县', '', '湖南省,湘西土家族苗族自治州,泸溪县', 433100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (433123, '凤凰县', '', '湖南省,湘西土家族苗族自治州,凤凰县', 433100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (433124, '花垣县', '', '湖南省,湘西土家族苗族自治州,花垣县', 433100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (433125, '保靖县', '', '湖南省,湘西土家族苗族自治州,保靖县', 433100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (433126, '古丈县', '', '湖南省,湘西土家族苗族自治州,古丈县', 433100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (433127, '永顺县', '', '湖南省,湘西土家族苗族自治州,永顺县', 433100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (433130, '龙山县', '', '湖南省,湘西土家族苗族自治州,龙山县', 433100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440101, '市辖区', '', '广东省,广州市,市辖区', 440100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440102, '东山区', '', '广东省,广州市,东山区', 440100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440103, '荔湾区', '', '广东省,广州市,荔湾区', 440100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440104, '越秀区', '', '广东省,广州市,越秀区', 440100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440105, '海珠区', '', '广东省,广州市,海珠区', 440100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440106, '天河区', '', '广东省,广州市,天河区', 440100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440107, '芳村区', '', '广东省,广州市,芳村区', 440100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440111, '白云区', '', '广东省,广州市,白云区', 440100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440112, '黄埔区', '', '广东省,广州市,黄埔区', 440100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440113, '番禺区', '', '广东省,广州市,番禺区', 440100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440114, '花都区', '', '广东省,广州市,花都区', 440100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440183, '增城市', '', '广东省,广州市,增城市', 440100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440184, '从化市', '', '广东省,广州市,从化市', 440100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440201, '市辖区', '', '广东省,韶关市,市辖区', 440200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440203, '武江区', '', '广东省,韶关市,武江区', 440200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440204, '浈江区', '', '广东省,韶关市,浈江区', 440200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440205, '曲江区', '', '广东省,韶关市,曲江区', 440200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440222, '始兴县', '', '广东省,韶关市,始兴县', 440200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440224, '仁化县', '', '广东省,韶关市,仁化县', 440200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440229, '翁源县', '', '广东省,韶关市,翁源县', 440200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440232, '乳源瑶族自治县', '', '广东省,韶关市,乳源瑶族自治县', 440200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440233, '新丰县', '', '广东省,韶关市,新丰县', 440200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440281, '乐昌市', '', '广东省,韶关市,乐昌市', 440200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440282, '南雄市', '', '广东省,韶关市,南雄市', 440200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440301, '市辖区', '', '广东省,深圳市,市辖区', 440300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440303, '罗湖区', '', '广东省,深圳市,罗湖区', 440300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440304, '福田区', '', '广东省,深圳市,福田区', 440300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440305, '南山区', '', '广东省,深圳市,南山区', 440300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440306, '宝安区', '', '广东省,深圳市,宝安区', 440300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440307, '龙岗区', '', '广东省,深圳市,龙岗区', 440300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440308, '盐田区', '', '广东省,深圳市,盐田区', 440300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440401, '市辖区', '', '广东省,珠海市,市辖区', 440400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440402, '香洲区', '', '广东省,珠海市,香洲区', 440400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440403, '斗门区', '', '广东省,珠海市,斗门区', 440400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440404, '金湾区', '', '广东省,珠海市,金湾区', 440400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440501, '市辖区', '', '广东省,汕头市,市辖区', 440500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440507, '龙湖区', '', '广东省,汕头市,龙湖区', 440500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440511, '金平区', '', '广东省,汕头市,金平区', 440500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440512, '濠江区', '', '广东省,汕头市,濠江区', 440500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440513, '潮阳区', '', '广东省,汕头市,潮阳区', 440500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440514, '潮南区', '', '广东省,汕头市,潮南区', 440500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440515, '澄海区', '', '广东省,汕头市,澄海区', 440500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440523, '南澳县', '', '广东省,汕头市,南澳县', 440500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440601, '市辖区', '', '广东省,佛山市,市辖区', 440600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440604, '禅城区', '', '广东省,佛山市,禅城区', 440600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440605, '南海区', '', '广东省,佛山市,南海区', 440600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440606, '顺德区', '', '广东省,佛山市,顺德区', 440600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440607, '三水区', '', '广东省,佛山市,三水区', 440600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440608, '高明区', '', '广东省,佛山市,高明区', 440600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440701, '市辖区', '', '广东省,江门市,市辖区', 440700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440703, '蓬江区', '', '广东省,江门市,蓬江区', 440700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440704, '江海区', '', '广东省,江门市,江海区', 440700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440705, '新会区', '', '广东省,江门市,新会区', 440700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440781, '台山市', '', '广东省,江门市,台山市', 440700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440783, '开平市', '', '广东省,江门市,开平市', 440700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440784, '鹤山市', '', '广东省,江门市,鹤山市', 440700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440785, '恩平市', '', '广东省,江门市,恩平市', 440700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440801, '市辖区', '', '广东省,湛江市,市辖区', 440800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440802, '赤坎区', '', '广东省,湛江市,赤坎区', 440800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440803, '霞山区', '', '广东省,湛江市,霞山区', 440800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440804, '坡头区', '', '广东省,湛江市,坡头区', 440800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440811, '麻章区', '', '广东省,湛江市,麻章区', 440800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440823, '遂溪县', '', '广东省,湛江市,遂溪县', 440800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440825, '徐闻县', '', '广东省,湛江市,徐闻县', 440800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440881, '廉江市', '', '广东省,湛江市,廉江市', 440800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440882, '雷州市', '', '广东省,湛江市,雷州市', 440800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440883, '吴川市', '', '广东省,湛江市,吴川市', 440800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440901, '市辖区', '', '广东省,茂名市,市辖区', 440900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440902, '茂南区', '', '广东省,茂名市,茂南区', 440900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440903, '茂港区', '', '广东省,茂名市,茂港区', 440900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440923, '电白县', '', '广东省,茂名市,电白县', 440900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440981, '高州市', '', '广东省,茂名市,高州市', 440900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440982, '化州市', '', '广东省,茂名市,化州市', 440900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (440983, '信宜市', '', '广东省,茂名市,信宜市', 440900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441201, '市辖区', '', '广东省,肇庆市,市辖区', 441200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441202, '端州区', '', '广东省,肇庆市,端州区', 441200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441203, '鼎湖区', '', '广东省,肇庆市,鼎湖区', 441200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441223, '广宁县', '', '广东省,肇庆市,广宁县', 441200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441224, '怀集县', '', '广东省,肇庆市,怀集县', 441200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441225, '封开县', '', '广东省,肇庆市,封开县', 441200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441226, '德庆县', '', '广东省,肇庆市,德庆县', 441200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441283, '高要市', '', '广东省,肇庆市,高要市', 441200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441284, '四会市', '', '广东省,肇庆市,四会市', 441200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441301, '市辖区', '', '广东省,惠州市,市辖区', 441300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441302, '惠城区', '', '广东省,惠州市,惠城区', 441300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441303, '惠阳区', '', '广东省,惠州市,惠阳区', 441300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441322, '博罗县', '', '广东省,惠州市,博罗县', 441300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441323, '惠东县', '', '广东省,惠州市,惠东县', 441300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441324, '龙门县', '', '广东省,惠州市,龙门县', 441300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441401, '市辖区', '', '广东省,梅州市,市辖区', 441400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441402, '梅江区', '', '广东省,梅州市,梅江区', 441400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441421, '梅　县', '', '广东省,梅州市,梅　县', 441400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441422, '大埔县', '', '广东省,梅州市,大埔县', 441400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441423, '丰顺县', '', '广东省,梅州市,丰顺县', 441400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441424, '五华县', '', '广东省,梅州市,五华县', 441400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441426, '平远县', '', '广东省,梅州市,平远县', 441400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441427, '蕉岭县', '', '广东省,梅州市,蕉岭县', 441400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441481, '兴宁市', '', '广东省,梅州市,兴宁市', 441400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441501, '市辖区', '', '广东省,汕尾市,市辖区', 441500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441502, '城　区', '', '广东省,汕尾市,城　区', 441500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441521, '海丰县', '', '广东省,汕尾市,海丰县', 441500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441523, '陆河县', '', '广东省,汕尾市,陆河县', 441500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441581, '陆丰市', '', '广东省,汕尾市,陆丰市', 441500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441601, '市辖区', '', '广东省,河源市,市辖区', 441600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441602, '源城区', '', '广东省,河源市,源城区', 441600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441621, '紫金县', '', '广东省,河源市,紫金县', 441600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441622, '龙川县', '', '广东省,河源市,龙川县', 441600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441623, '连平县', '', '广东省,河源市,连平县', 441600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441624, '和平县', '', '广东省,河源市,和平县', 441600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441625, '东源县', '', '广东省,河源市,东源县', 441600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441701, '市辖区', '', '广东省,阳江市,市辖区', 441700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441702, '江城区', '', '广东省,阳江市,江城区', 441700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441721, '阳西县', '', '广东省,阳江市,阳西县', 441700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441723, '阳东县', '', '广东省,阳江市,阳东县', 441700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441781, '阳春市', '', '广东省,阳江市,阳春市', 441700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441801, '市辖区', '', '广东省,清远市,市辖区', 441800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441802, '清城区', '', '广东省,清远市,清城区', 441800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441821, '佛冈县', '', '广东省,清远市,佛冈县', 441800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441823, '阳山县', '', '广东省,清远市,阳山县', 441800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441825, '连山壮族瑶族自治县', '', '广东省,清远市,连山壮族瑶族自治县', 441800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441826, '连南瑶族自治县', '', '广东省,清远市,连南瑶族自治县', 441800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441827, '清新县', '', '广东省,清远市,清新县', 441800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441881, '英德市', '', '广东省,清远市,英德市', 441800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (441882, '连州市', '', '广东省,清远市,连州市', 441800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (445101, '市辖区', '', '广东省,潮州市,市辖区', 445100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (445102, '湘桥区', '', '广东省,潮州市,湘桥区', 445100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (445121, '潮安县', '', '广东省,潮州市,潮安县', 445100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (445122, '饶平县', '', '广东省,潮州市,饶平县', 445100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (445201, '市辖区', '', '广东省,揭阳市,市辖区', 445200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (445202, '榕城区', '', '广东省,揭阳市,榕城区', 445200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (445221, '揭东县', '', '广东省,揭阳市,揭东县', 445200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (445222, '揭西县', '', '广东省,揭阳市,揭西县', 445200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (445224, '惠来县', '', '广东省,揭阳市,惠来县', 445200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (445281, '普宁市', '', '广东省,揭阳市,普宁市', 445200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (445301, '市辖区', '', '广东省,云浮市,市辖区', 445300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (445302, '云城区', '', '广东省,云浮市,云城区', 445300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (445321, '新兴县', '', '广东省,云浮市,新兴县', 445300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (445322, '郁南县', '', '广东省,云浮市,郁南县', 445300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (445323, '云安县', '', '广东省,云浮市,云安县', 445300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (445381, '罗定市', '', '广东省,云浮市,罗定市', 445300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450101, '市辖区', '', '广西壮族自治区,南宁市,市辖区', 450100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450102, '兴宁区', '', '广西壮族自治区,南宁市,兴宁区', 450100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450103, '青秀区', '', '广西壮族自治区,南宁市,青秀区', 450100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450105, '江南区', '', '广西壮族自治区,南宁市,江南区', 450100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450107, '西乡塘区', '', '广西壮族自治区,南宁市,西乡塘区', 450100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450108, '良庆区', '', '广西壮族自治区,南宁市,良庆区', 450100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450109, '邕宁区', '', '广西壮族自治区,南宁市,邕宁区', 450100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450122, '武鸣县', '', '广西壮族自治区,南宁市,武鸣县', 450100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450123, '隆安县', '', '广西壮族自治区,南宁市,隆安县', 450100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450124, '马山县', '', '广西壮族自治区,南宁市,马山县', 450100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450125, '上林县', '', '广西壮族自治区,南宁市,上林县', 450100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450126, '宾阳县', '', '广西壮族自治区,南宁市,宾阳县', 450100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450127, '横　县', '', '广西壮族自治区,南宁市,横　县', 450100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450201, '市辖区', '', '广西壮族自治区,柳州市,市辖区', 450200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450202, '城中区', '', '广西壮族自治区,柳州市,城中区', 450200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450203, '鱼峰区', '', '广西壮族自治区,柳州市,鱼峰区', 450200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450204, '柳南区', '', '广西壮族自治区,柳州市,柳南区', 450200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450205, '柳北区', '', '广西壮族自治区,柳州市,柳北区', 450200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450221, '柳江县', '', '广西壮族自治区,柳州市,柳江县', 450200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450222, '柳城县', '', '广西壮族自治区,柳州市,柳城县', 450200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450223, '鹿寨县', '', '广西壮族自治区,柳州市,鹿寨县', 450200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450224, '融安县', '', '广西壮族自治区,柳州市,融安县', 450200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450225, '融水苗族自治县', '', '广西壮族自治区,柳州市,融水苗族自治县', 450200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450226, '三江侗族自治县', '', '广西壮族自治区,柳州市,三江侗族自治县', 450200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450301, '市辖区', '', '广西壮族自治区,桂林市,市辖区', 450300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450302, '秀峰区', '', '广西壮族自治区,桂林市,秀峰区', 450300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450303, '叠彩区', '', '广西壮族自治区,桂林市,叠彩区', 450300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450304, '象山区', '', '广西壮族自治区,桂林市,象山区', 450300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450305, '七星区', '', '广西壮族自治区,桂林市,七星区', 450300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450311, '雁山区', '', '广西壮族自治区,桂林市,雁山区', 450300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450321, '阳朔县', '', '广西壮族自治区,桂林市,阳朔县', 450300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450322, '临桂县', '', '广西壮族自治区,桂林市,临桂县', 450300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450323, '灵川县', '', '广西壮族自治区,桂林市,灵川县', 450300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450324, '全州县', '', '广西壮族自治区,桂林市,全州县', 450300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450325, '兴安县', '', '广西壮族自治区,桂林市,兴安县', 450300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450326, '永福县', '', '广西壮族自治区,桂林市,永福县', 450300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450327, '灌阳县', '', '广西壮族自治区,桂林市,灌阳县', 450300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450328, '龙胜各族自治县', '', '广西壮族自治区,桂林市,龙胜各族自治县', 450300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450329, '资源县', '', '广西壮族自治区,桂林市,资源县', 450300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450330, '平乐县', '', '广西壮族自治区,桂林市,平乐县', 450300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450331, '荔蒲县', '', '广西壮族自治区,桂林市,荔蒲县', 450300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450332, '恭城瑶族自治县', '', '广西壮族自治区,桂林市,恭城瑶族自治县', 450300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450401, '市辖区', '', '广西壮族自治区,梧州市,市辖区', 450400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450403, '万秀区', '', '广西壮族自治区,梧州市,万秀区', 450400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450404, '蝶山区', '', '广西壮族自治区,梧州市,蝶山区', 450400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450405, '长洲区', '', '广西壮族自治区,梧州市,长洲区', 450400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450421, '苍梧县', '', '广西壮族自治区,梧州市,苍梧县', 450400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450422, '藤　县', '', '广西壮族自治区,梧州市,藤　县', 450400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450423, '蒙山县', '', '广西壮族自治区,梧州市,蒙山县', 450400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450481, '岑溪市', '', '广西壮族自治区,梧州市,岑溪市', 450400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450501, '市辖区', '', '广西壮族自治区,北海市,市辖区', 450500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450502, '海城区', '', '广西壮族自治区,北海市,海城区', 450500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450503, '银海区', '', '广西壮族自治区,北海市,银海区', 450500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450512, '铁山港区', '', '广西壮族自治区,北海市,铁山港区', 450500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450521, '合浦县', '', '广西壮族自治区,北海市,合浦县', 450500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450601, '市辖区', '', '广西壮族自治区,防城港市,市辖区', 450600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450602, '港口区', '', '广西壮族自治区,防城港市,港口区', 450600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450603, '防城区', '', '广西壮族自治区,防城港市,防城区', 450600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450621, '上思县', '', '广西壮族自治区,防城港市,上思县', 450600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450681, '东兴市', '', '广西壮族自治区,防城港市,东兴市', 450600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450701, '市辖区', '', '广西壮族自治区,钦州市,市辖区', 450700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450702, '钦南区', '', '广西壮族自治区,钦州市,钦南区', 450700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450703, '钦北区', '', '广西壮族自治区,钦州市,钦北区', 450700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450721, '灵山县', '', '广西壮族自治区,钦州市,灵山县', 450700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450722, '浦北县', '', '广西壮族自治区,钦州市,浦北县', 450700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450801, '市辖区', '', '广西壮族自治区,贵港市,市辖区', 450800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450802, '港北区', '', '广西壮族自治区,贵港市,港北区', 450800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450803, '港南区', '', '广西壮族自治区,贵港市,港南区', 450800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450804, '覃塘区', '', '广西壮族自治区,贵港市,覃塘区', 450800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450821, '平南县', '', '广西壮族自治区,贵港市,平南县', 450800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450881, '桂平市', '', '广西壮族自治区,贵港市,桂平市', 450800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450901, '市辖区', '', '广西壮族自治区,玉林市,市辖区', 450900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450902, '玉州区', '', '广西壮族自治区,玉林市,玉州区', 450900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450921, '容　县', '', '广西壮族自治区,玉林市,容　县', 450900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450922, '陆川县', '', '广西壮族自治区,玉林市,陆川县', 450900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450923, '博白县', '', '广西壮族自治区,玉林市,博白县', 450900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450924, '兴业县', '', '广西壮族自治区,玉林市,兴业县', 450900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (450981, '北流市', '', '广西壮族自治区,玉林市,北流市', 450900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451001, '市辖区', '', '广西壮族自治区,百色市,市辖区', 451000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451002, '右江区', '', '广西壮族自治区,百色市,右江区', 451000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451021, '田阳县', '', '广西壮族自治区,百色市,田阳县', 451000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451022, '田东县', '', '广西壮族自治区,百色市,田东县', 451000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451023, '平果县', '', '广西壮族自治区,百色市,平果县', 451000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451024, '德保县', '', '广西壮族自治区,百色市,德保县', 451000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451025, '靖西县', '', '广西壮族自治区,百色市,靖西县', 451000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451026, '那坡县', '', '广西壮族自治区,百色市,那坡县', 451000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451027, '凌云县', '', '广西壮族自治区,百色市,凌云县', 451000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451028, '乐业县', '', '广西壮族自治区,百色市,乐业县', 451000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451029, '田林县', '', '广西壮族自治区,百色市,田林县', 451000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451030, '西林县', '', '广西壮族自治区,百色市,西林县', 451000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451031, '隆林各族自治县', '', '广西壮族自治区,百色市,隆林各族自治县', 451000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451101, '市辖区', '', '广西壮族自治区,贺州市,市辖区', 451100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451102, '八步区', '', '广西壮族自治区,贺州市,八步区', 451100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451121, '昭平县', '', '广西壮族自治区,贺州市,昭平县', 451100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451122, '钟山县', '', '广西壮族自治区,贺州市,钟山县', 451100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451123, '富川瑶族自治县', '', '广西壮族自治区,贺州市,富川瑶族自治县', 451100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451201, '市辖区', '', '广西壮族自治区,河池市,市辖区', 451200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451202, '金城江区', '', '广西壮族自治区,河池市,金城江区', 451200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451221, '南丹县', '', '广西壮族自治区,河池市,南丹县', 451200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451222, '天峨县', '', '广西壮族自治区,河池市,天峨县', 451200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451223, '凤山县', '', '广西壮族自治区,河池市,凤山县', 451200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451224, '东兰县', '', '广西壮族自治区,河池市,东兰县', 451200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451225, '罗城仫佬族自治县', '', '广西壮族自治区,河池市,罗城仫佬族自治县', 451200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451226, '环江毛南族自治县', '', '广西壮族自治区,河池市,环江毛南族自治县', 451200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451227, '巴马瑶族自治县', '', '广西壮族自治区,河池市,巴马瑶族自治县', 451200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451228, '都安瑶族自治县', '', '广西壮族自治区,河池市,都安瑶族自治县', 451200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451229, '大化瑶族自治县', '', '广西壮族自治区,河池市,大化瑶族自治县', 451200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451281, '宜州市', '', '广西壮族自治区,河池市,宜州市', 451200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451301, '市辖区', '', '广西壮族自治区,来宾市,市辖区', 451300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451302, '兴宾区', '', '广西壮族自治区,来宾市,兴宾区', 451300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451321, '忻城县', '', '广西壮族自治区,来宾市,忻城县', 451300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451322, '象州县', '', '广西壮族自治区,来宾市,象州县', 451300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451323, '武宣县', '', '广西壮族自治区,来宾市,武宣县', 451300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451324, '金秀瑶族自治县', '', '广西壮族自治区,来宾市,金秀瑶族自治县', 451300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451381, '合山市', '', '广西壮族自治区,来宾市,合山市', 451300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451401, '市辖区', '', '广西壮族自治区,崇左市,市辖区', 451400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451402, '江洲区', '', '广西壮族自治区,崇左市,江洲区', 451400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451421, '扶绥县', '', '广西壮族自治区,崇左市,扶绥县', 451400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451422, '宁明县', '', '广西壮族自治区,崇左市,宁明县', 451400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451423, '龙州县', '', '广西壮族自治区,崇左市,龙州县', 451400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451424, '大新县', '', '广西壮族自治区,崇左市,大新县', 451400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451425, '天等县', '', '广西壮族自治区,崇左市,天等县', 451400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (451481, '凭祥市', '', '广西壮族自治区,崇左市,凭祥市', 451400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (460101, '市辖区', '', '海南省,海口市,市辖区', 460100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (460105, '秀英区', '', '海南省,海口市,秀英区', 460100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (460106, '龙华区', '', '海南省,海口市,龙华区', 460100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (460107, '琼山区', '', '海南省,海口市,琼山区', 460100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (460108, '美兰区', '', '海南省,海口市,美兰区', 460100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (460201, '市辖区', '', '海南省,三亚市,市辖区', 460200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (469001, '五指山市', '', '海南省,省直辖县级行政单位,五指山市', 469000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (469002, '琼海市', '', '海南省,省直辖县级行政单位,琼海市', 469000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (469003, '儋州市', '', '海南省,省直辖县级行政单位,儋州市', 469000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (469005, '文昌市', '', '海南省,省直辖县级行政单位,文昌市', 469000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (469006, '万宁市', '', '海南省,省直辖县级行政单位,万宁市', 469000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (469007, '东方市', '', '海南省,省直辖县级行政单位,东方市', 469000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (469025, '定安县', '', '海南省,省直辖县级行政单位,定安县', 469000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (469026, '屯昌县', '', '海南省,省直辖县级行政单位,屯昌县', 469000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (469027, '澄迈县', '', '海南省,省直辖县级行政单位,澄迈县', 469000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (469028, '临高县', '', '海南省,省直辖县级行政单位,临高县', 469000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (469030, '白沙黎族自治县', '', '海南省,省直辖县级行政单位,白沙黎族自治县', 469000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (469031, '昌江黎族自治县', '', '海南省,省直辖县级行政单位,昌江黎族自治县', 469000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (469033, '乐东黎族自治县', '', '海南省,省直辖县级行政单位,乐东黎族自治县', 469000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (469034, '陵水黎族自治县', '', '海南省,省直辖县级行政单位,陵水黎族自治县', 469000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (469035, '保亭黎族苗族自治县', '', '海南省,省直辖县级行政单位,保亭黎族苗族自治县', 469000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (469036, '琼中黎族苗族自治县', '', '海南省,省直辖县级行政单位,琼中黎族苗族自治县', 469000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (469037, '西沙群岛', '', '海南省,省直辖县级行政单位,西沙群岛', 469000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (469038, '南沙群岛', '', '海南省,省直辖县级行政单位,南沙群岛', 469000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (469039, '中沙群岛的岛礁及其海域', '', '海南省,省直辖县级行政单位,中沙群岛的岛礁及其海域', 469000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500101, '万州区', '', '重庆市,市辖区,万州区', 500100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500102, '涪陵区', '', '重庆市,市辖区,涪陵区', 500100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500103, '渝中区', '', '重庆市,市辖区,渝中区', 500100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500104, '大渡口区', '', '重庆市,市辖区,大渡口区', 500100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500105, '江北区', '', '重庆市,市辖区,江北区', 500100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500106, '沙坪坝区', '', '重庆市,市辖区,沙坪坝区', 500100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500107, '九龙坡区', '', '重庆市,市辖区,九龙坡区', 500100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500108, '南岸区', '', '重庆市,市辖区,南岸区', 500100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500109, '北碚区', '', '重庆市,市辖区,北碚区', 500100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500110, '万盛区', '', '重庆市,市辖区,万盛区', 500100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500111, '双桥区', '', '重庆市,市辖区,双桥区', 500100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500112, '渝北区', '', '重庆市,市辖区,渝北区', 500100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500113, '巴南区', '', '重庆市,市辖区,巴南区', 500100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500114, '黔江区', '', '重庆市,市辖区,黔江区', 500100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500115, '长寿区', '', '重庆市,市辖区,长寿区', 500100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500222, '綦江县', '', '重庆市,县,綦江县', 500200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500223, '潼南县', '', '重庆市,县,潼南县', 500200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500224, '铜梁县', '', '重庆市,县,铜梁县', 500200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500225, '大足县', '', '重庆市,县,大足县', 500200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500226, '荣昌县', '', '重庆市,县,荣昌县', 500200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500227, '璧山县', '', '重庆市,县,璧山县', 500200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500228, '梁平县', '', '重庆市,县,梁平县', 500200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500229, '城口县', '', '重庆市,县,城口县', 500200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500230, '丰都县', '', '重庆市,县,丰都县', 500200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500231, '垫江县', '', '重庆市,县,垫江县', 500200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500232, '武隆县', '', '重庆市,县,武隆县', 500200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500233, '忠　县', '', '重庆市,县,忠　县', 500200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500234, '开　县', '', '重庆市,县,开　县', 500200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500235, '云阳县', '', '重庆市,县,云阳县', 500200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500236, '奉节县', '', '重庆市,县,奉节县', 500200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500237, '巫山县', '', '重庆市,县,巫山县', 500200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500238, '巫溪县', '', '重庆市,县,巫溪县', 500200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500240, '石柱土家族自治县', '', '重庆市,县,石柱土家族自治县', 500200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500241, '秀山土家族苗族自治县', '', '重庆市,县,秀山土家族苗族自治县', 500200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500242, '酉阳土家族苗族自治县', '', '重庆市,县,酉阳土家族苗族自治县', 500200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500243, '彭水苗族土家族自治县', '', '重庆市,县,彭水苗族土家族自治县', 500200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500381, '江津市', '', '重庆市,市,江津市', 500300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500382, '合川市', '', '重庆市,市,合川市', 500300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500383, '永川市', '', '重庆市,市,永川市', 500300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (500384, '南川市', '', '重庆市,市,南川市', 500300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510101, '市辖区', '', '四川省,成都市,市辖区', 510100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510104, '锦江区', '', '四川省,成都市,锦江区', 510100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510105, '青羊区', '', '四川省,成都市,青羊区', 510100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510106, '金牛区', '', '四川省,成都市,金牛区', 510100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510107, '武侯区', '', '四川省,成都市,武侯区', 510100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510108, '成华区', '', '四川省,成都市,成华区', 510100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510112, '龙泉驿区', '', '四川省,成都市,龙泉驿区', 510100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510113, '青白江区', '', '四川省,成都市,青白江区', 510100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510114, '新都区', '', '四川省,成都市,新都区', 510100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510115, '温江区', '', '四川省,成都市,温江区', 510100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510121, '金堂县', '', '四川省,成都市,金堂县', 510100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510122, '双流县', '', '四川省,成都市,双流县', 510100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510124, '郫　县', '', '四川省,成都市,郫　县', 510100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510129, '大邑县', '', '四川省,成都市,大邑县', 510100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510131, '蒲江县', '', '四川省,成都市,蒲江县', 510100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510132, '新津县', '', '四川省,成都市,新津县', 510100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510181, '都江堰市', '', '四川省,成都市,都江堰市', 510100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510182, '彭州市', '', '四川省,成都市,彭州市', 510100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510183, '邛崃市', '', '四川省,成都市,邛崃市', 510100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510184, '崇州市', '', '四川省,成都市,崇州市', 510100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510301, '市辖区', '', '四川省,自贡市,市辖区', 510300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510302, '自流井区', '', '四川省,自贡市,自流井区', 510300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510303, '贡井区', '', '四川省,自贡市,贡井区', 510300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510304, '大安区', '', '四川省,自贡市,大安区', 510300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510311, '沿滩区', '', '四川省,自贡市,沿滩区', 510300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510321, '荣　县', '', '四川省,自贡市,荣　县', 510300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510322, '富顺县', '', '四川省,自贡市,富顺县', 510300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510401, '市辖区', '', '四川省,攀枝花市,市辖区', 510400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510402, '东　区', '', '四川省,攀枝花市,东　区', 510400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510403, '西　区', '', '四川省,攀枝花市,西　区', 510400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510411, '仁和区', '', '四川省,攀枝花市,仁和区', 510400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510421, '米易县', '', '四川省,攀枝花市,米易县', 510400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510422, '盐边县', '', '四川省,攀枝花市,盐边县', 510400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510501, '市辖区', '', '四川省,泸州市,市辖区', 510500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510502, '江阳区', '', '四川省,泸州市,江阳区', 510500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510503, '纳溪区', '', '四川省,泸州市,纳溪区', 510500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510504, '龙马潭区', '', '四川省,泸州市,龙马潭区', 510500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510521, '泸　县', '', '四川省,泸州市,泸　县', 510500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510522, '合江县', '', '四川省,泸州市,合江县', 510500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510524, '叙永县', '', '四川省,泸州市,叙永县', 510500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510525, '古蔺县', '', '四川省,泸州市,古蔺县', 510500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510601, '市辖区', '', '四川省,德阳市,市辖区', 510600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510603, '旌阳区', '', '四川省,德阳市,旌阳区', 510600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510623, '中江县', '', '四川省,德阳市,中江县', 510600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510626, '罗江县', '', '四川省,德阳市,罗江县', 510600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510681, '广汉市', '', '四川省,德阳市,广汉市', 510600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510682, '什邡市', '', '四川省,德阳市,什邡市', 510600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510683, '绵竹市', '', '四川省,德阳市,绵竹市', 510600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510701, '市辖区', '', '四川省,绵阳市,市辖区', 510700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510703, '涪城区', '', '四川省,绵阳市,涪城区', 510700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510704, '游仙区', '', '四川省,绵阳市,游仙区', 510700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510722, '三台县', '', '四川省,绵阳市,三台县', 510700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510723, '盐亭县', '', '四川省,绵阳市,盐亭县', 510700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510724, '安　县', '', '四川省,绵阳市,安　县', 510700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510725, '梓潼县', '', '四川省,绵阳市,梓潼县', 510700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510726, '北川羌族自治县', '', '四川省,绵阳市,北川羌族自治县', 510700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510727, '平武县', '', '四川省,绵阳市,平武县', 510700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510781, '江油市', '', '四川省,绵阳市,江油市', 510700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510801, '市辖区', '', '四川省,广元市,市辖区', 510800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510802, '市中区', '', '四川省,广元市,市中区', 510800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510811, '元坝区', '', '四川省,广元市,元坝区', 510800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510812, '朝天区', '', '四川省,广元市,朝天区', 510800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510821, '旺苍县', '', '四川省,广元市,旺苍县', 510800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510822, '青川县', '', '四川省,广元市,青川县', 510800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510823, '剑阁县', '', '四川省,广元市,剑阁县', 510800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510824, '苍溪县', '', '四川省,广元市,苍溪县', 510800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510901, '市辖区', '', '四川省,遂宁市,市辖区', 510900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510903, '船山区', '', '四川省,遂宁市,船山区', 510900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510904, '安居区', '', '四川省,遂宁市,安居区', 510900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510921, '蓬溪县', '', '四川省,遂宁市,蓬溪县', 510900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510922, '射洪县', '', '四川省,遂宁市,射洪县', 510900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (510923, '大英县', '', '四川省,遂宁市,大英县', 510900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511001, '市辖区', '', '四川省,内江市,市辖区', 511000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511002, '市中区', '', '四川省,内江市,市中区', 511000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511011, '东兴区', '', '四川省,内江市,东兴区', 511000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511024, '威远县', '', '四川省,内江市,威远县', 511000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511025, '资中县', '', '四川省,内江市,资中县', 511000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511028, '隆昌县', '', '四川省,内江市,隆昌县', 511000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511101, '市辖区', '', '四川省,乐山市,市辖区', 511100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511102, '市中区', '', '四川省,乐山市,市中区', 511100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511111, '沙湾区', '', '四川省,乐山市,沙湾区', 511100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511112, '五通桥区', '', '四川省,乐山市,五通桥区', 511100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511113, '金口河区', '', '四川省,乐山市,金口河区', 511100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511123, '犍为县', '', '四川省,乐山市,犍为县', 511100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511124, '井研县', '', '四川省,乐山市,井研县', 511100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511126, '夹江县', '', '四川省,乐山市,夹江县', 511100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511129, '沐川县', '', '四川省,乐山市,沐川县', 511100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511132, '峨边彝族自治县', '', '四川省,乐山市,峨边彝族自治县', 511100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511133, '马边彝族自治县', '', '四川省,乐山市,马边彝族自治县', 511100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511181, '峨眉山市', '', '四川省,乐山市,峨眉山市', 511100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511301, '市辖区', '', '四川省,南充市,市辖区', 511300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511302, '顺庆区', '', '四川省,南充市,顺庆区', 511300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511303, '高坪区', '', '四川省,南充市,高坪区', 511300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511304, '嘉陵区', '', '四川省,南充市,嘉陵区', 511300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511321, '南部县', '', '四川省,南充市,南部县', 511300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511322, '营山县', '', '四川省,南充市,营山县', 511300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511323, '蓬安县', '', '四川省,南充市,蓬安县', 511300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511324, '仪陇县', '', '四川省,南充市,仪陇县', 511300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511325, '西充县', '', '四川省,南充市,西充县', 511300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511381, '阆中市', '', '四川省,南充市,阆中市', 511300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511401, '市辖区', '', '四川省,眉山市,市辖区', 511400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511402, '东坡区', '', '四川省,眉山市,东坡区', 511400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511421, '仁寿县', '', '四川省,眉山市,仁寿县', 511400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511422, '彭山县', '', '四川省,眉山市,彭山县', 511400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511423, '洪雅县', '', '四川省,眉山市,洪雅县', 511400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511424, '丹棱县', '', '四川省,眉山市,丹棱县', 511400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511425, '青神县', '', '四川省,眉山市,青神县', 511400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511501, '市辖区', '', '四川省,宜宾市,市辖区', 511500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511502, '翠屏区', '', '四川省,宜宾市,翠屏区', 511500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511521, '宜宾县', '', '四川省,宜宾市,宜宾县', 511500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511522, '南溪县', '', '四川省,宜宾市,南溪县', 511500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511523, '江安县', '', '四川省,宜宾市,江安县', 511500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511524, '长宁县', '', '四川省,宜宾市,长宁县', 511500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511525, '高　县', '', '四川省,宜宾市,高　县', 511500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511526, '珙　县', '', '四川省,宜宾市,珙　县', 511500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511527, '筠连县', '', '四川省,宜宾市,筠连县', 511500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511528, '兴文县', '', '四川省,宜宾市,兴文县', 511500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511529, '屏山县', '', '四川省,宜宾市,屏山县', 511500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511601, '市辖区', '', '四川省,广安市,市辖区', 511600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511602, '广安区', '', '四川省,广安市,广安区', 511600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511621, '岳池县', '', '四川省,广安市,岳池县', 511600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511622, '武胜县', '', '四川省,广安市,武胜县', 511600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511623, '邻水县', '', '四川省,广安市,邻水县', 511600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511681, '华莹市', '', '四川省,广安市,华莹市', 511600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511701, '市辖区', '', '四川省,达州市,市辖区', 511700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511702, '通川区', '', '四川省,达州市,通川区', 511700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511721, '达　县', '', '四川省,达州市,达　县', 511700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511722, '宣汉县', '', '四川省,达州市,宣汉县', 511700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511723, '开江县', '', '四川省,达州市,开江县', 511700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511724, '大竹县', '', '四川省,达州市,大竹县', 511700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511725, '渠　县', '', '四川省,达州市,渠　县', 511700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511781, '万源市', '', '四川省,达州市,万源市', 511700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511801, '市辖区', '', '四川省,雅安市,市辖区', 511800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511802, '雨城区', '', '四川省,雅安市,雨城区', 511800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511821, '名山县', '', '四川省,雅安市,名山县', 511800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511822, '荥经县', '', '四川省,雅安市,荥经县', 511800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511823, '汉源县', '', '四川省,雅安市,汉源县', 511800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511824, '石棉县', '', '四川省,雅安市,石棉县', 511800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511825, '天全县', '', '四川省,雅安市,天全县', 511800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511826, '芦山县', '', '四川省,雅安市,芦山县', 511800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511827, '宝兴县', '', '四川省,雅安市,宝兴县', 511800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511901, '市辖区', '', '四川省,巴中市,市辖区', 511900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511902, '巴州区', '', '四川省,巴中市,巴州区', 511900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511921, '通江县', '', '四川省,巴中市,通江县', 511900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511922, '南江县', '', '四川省,巴中市,南江县', 511900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (511923, '平昌县', '', '四川省,巴中市,平昌县', 511900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (512001, '市辖区', '', '四川省,资阳市,市辖区', 512000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (512002, '雁江区', '', '四川省,资阳市,雁江区', 512000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (512021, '安岳县', '', '四川省,资阳市,安岳县', 512000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (512022, '乐至县', '', '四川省,资阳市,乐至县', 512000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (512081, '简阳市', '', '四川省,资阳市,简阳市', 512000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513221, '汶川县', '', '四川省,阿坝藏族羌族自治州,汶川县', 513200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513222, '理　县', '', '四川省,阿坝藏族羌族自治州,理　县', 513200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513223, '茂　县', '', '四川省,阿坝藏族羌族自治州,茂　县', 513200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513224, '松潘县', '', '四川省,阿坝藏族羌族自治州,松潘县', 513200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513225, '九寨沟县', '', '四川省,阿坝藏族羌族自治州,九寨沟县', 513200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513226, '金川县', '', '四川省,阿坝藏族羌族自治州,金川县', 513200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513227, '小金县', '', '四川省,阿坝藏族羌族自治州,小金县', 513200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513228, '黑水县', '', '四川省,阿坝藏族羌族自治州,黑水县', 513200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513229, '马尔康县', '', '四川省,阿坝藏族羌族自治州,马尔康县', 513200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513230, '壤塘县', '', '四川省,阿坝藏族羌族自治州,壤塘县', 513200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513231, '阿坝县', '', '四川省,阿坝藏族羌族自治州,阿坝县', 513200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513232, '若尔盖县', '', '四川省,阿坝藏族羌族自治州,若尔盖县', 513200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513233, '红原县', '', '四川省,阿坝藏族羌族自治州,红原县', 513200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513321, '康定县', '', '四川省,甘孜藏族自治州,康定县', 513300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513322, '泸定县', '', '四川省,甘孜藏族自治州,泸定县', 513300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513323, '丹巴县', '', '四川省,甘孜藏族自治州,丹巴县', 513300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513324, '九龙县', '', '四川省,甘孜藏族自治州,九龙县', 513300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513325, '雅江县', '', '四川省,甘孜藏族自治州,雅江县', 513300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513326, '道孚县', '', '四川省,甘孜藏族自治州,道孚县', 513300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513327, '炉霍县', '', '四川省,甘孜藏族自治州,炉霍县', 513300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513328, '甘孜县', '', '四川省,甘孜藏族自治州,甘孜县', 513300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513329, '新龙县', '', '四川省,甘孜藏族自治州,新龙县', 513300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513330, '德格县', '', '四川省,甘孜藏族自治州,德格县', 513300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513331, '白玉县', '', '四川省,甘孜藏族自治州,白玉县', 513300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513332, '石渠县', '', '四川省,甘孜藏族自治州,石渠县', 513300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513333, '色达县', '', '四川省,甘孜藏族自治州,色达县', 513300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513334, '理塘县', '', '四川省,甘孜藏族自治州,理塘县', 513300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513335, '巴塘县', '', '四川省,甘孜藏族自治州,巴塘县', 513300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513336, '乡城县', '', '四川省,甘孜藏族自治州,乡城县', 513300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513337, '稻城县', '', '四川省,甘孜藏族自治州,稻城县', 513300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513338, '得荣县', '', '四川省,甘孜藏族自治州,得荣县', 513300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513401, '西昌市', '', '四川省,凉山彝族自治州,西昌市', 513400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513422, '木里藏族自治县', '', '四川省,凉山彝族自治州,木里藏族自治县', 513400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513423, '盐源县', '', '四川省,凉山彝族自治州,盐源县', 513400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513424, '德昌县', '', '四川省,凉山彝族自治州,德昌县', 513400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513425, '会理县', '', '四川省,凉山彝族自治州,会理县', 513400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513426, '会东县', '', '四川省,凉山彝族自治州,会东县', 513400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513427, '宁南县', '', '四川省,凉山彝族自治州,宁南县', 513400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513428, '普格县', '', '四川省,凉山彝族自治州,普格县', 513400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513429, '布拖县', '', '四川省,凉山彝族自治州,布拖县', 513400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513430, '金阳县', '', '四川省,凉山彝族自治州,金阳县', 513400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513431, '昭觉县', '', '四川省,凉山彝族自治州,昭觉县', 513400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513432, '喜德县', '', '四川省,凉山彝族自治州,喜德县', 513400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513433, '冕宁县', '', '四川省,凉山彝族自治州,冕宁县', 513400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513434, '越西县', '', '四川省,凉山彝族自治州,越西县', 513400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513435, '甘洛县', '', '四川省,凉山彝族自治州,甘洛县', 513400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513436, '美姑县', '', '四川省,凉山彝族自治州,美姑县', 513400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (513437, '雷波县', '', '四川省,凉山彝族自治州,雷波县', 513400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520101, '市辖区', '', '贵州省,贵阳市,市辖区', 520100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520102, '南明区', '', '贵州省,贵阳市,南明区', 520100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520103, '云岩区', '', '贵州省,贵阳市,云岩区', 520100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520111, '花溪区', '', '贵州省,贵阳市,花溪区', 520100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520112, '乌当区', '', '贵州省,贵阳市,乌当区', 520100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520113, '白云区', '', '贵州省,贵阳市,白云区', 520100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520114, '小河区', '', '贵州省,贵阳市,小河区', 520100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520121, '开阳县', '', '贵州省,贵阳市,开阳县', 520100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520122, '息烽县', '', '贵州省,贵阳市,息烽县', 520100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520123, '修文县', '', '贵州省,贵阳市,修文县', 520100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520181, '清镇市', '', '贵州省,贵阳市,清镇市', 520100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520201, '钟山区', '', '贵州省,六盘水市,钟山区', 520200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520203, '六枝特区', '', '贵州省,六盘水市,六枝特区', 520200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520221, '水城县', '', '贵州省,六盘水市,水城县', 520200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520222, '盘　县', '', '贵州省,六盘水市,盘　县', 520200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520301, '市辖区', '', '贵州省,遵义市,市辖区', 520300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520302, '红花岗区', '', '贵州省,遵义市,红花岗区', 520300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520303, '汇川区', '', '贵州省,遵义市,汇川区', 520300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520321, '遵义县', '', '贵州省,遵义市,遵义县', 520300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520322, '桐梓县', '', '贵州省,遵义市,桐梓县', 520300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520323, '绥阳县', '', '贵州省,遵义市,绥阳县', 520300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520324, '正安县', '', '贵州省,遵义市,正安县', 520300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520325, '道真仡佬族苗族自治县', '', '贵州省,遵义市,道真仡佬族苗族自治县', 520300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520326, '务川仡佬族苗族自治县', '', '贵州省,遵义市,务川仡佬族苗族自治县', 520300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520327, '凤冈县', '', '贵州省,遵义市,凤冈县', 520300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520328, '湄潭县', '', '贵州省,遵义市,湄潭县', 520300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520329, '余庆县', '', '贵州省,遵义市,余庆县', 520300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520330, '习水县', '', '贵州省,遵义市,习水县', 520300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520381, '赤水市', '', '贵州省,遵义市,赤水市', 520300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520382, '仁怀市', '', '贵州省,遵义市,仁怀市', 520300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520401, '市辖区', '', '贵州省,安顺市,市辖区', 520400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520402, '西秀区', '', '贵州省,安顺市,西秀区', 520400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520421, '平坝县', '', '贵州省,安顺市,平坝县', 520400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520422, '普定县', '', '贵州省,安顺市,普定县', 520400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520423, '镇宁布依族苗族自治县', '', '贵州省,安顺市,镇宁布依族苗族自治县', 520400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520424, '关岭布依族苗族自治县', '', '贵州省,安顺市,关岭布依族苗族自治县', 520400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (520425, '紫云苗族布依族自治县', '', '贵州省,安顺市,紫云苗族布依族自治县', 520400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522201, '铜仁市', '', '贵州省,铜仁地区,铜仁市', 522200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522222, '江口县', '', '贵州省,铜仁地区,江口县', 522200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522223, '玉屏侗族自治县', '', '贵州省,铜仁地区,玉屏侗族自治县', 522200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522224, '石阡县', '', '贵州省,铜仁地区,石阡县', 522200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522225, '思南县', '', '贵州省,铜仁地区,思南县', 522200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522226, '印江土家族苗族自治县', '', '贵州省,铜仁地区,印江土家族苗族自治县', 522200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522227, '德江县', '', '贵州省,铜仁地区,德江县', 522200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522228, '沿河土家族自治县', '', '贵州省,铜仁地区,沿河土家族自治县', 522200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522229, '松桃苗族自治县', '', '贵州省,铜仁地区,松桃苗族自治县', 522200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522230, '万山特区', '', '贵州省,铜仁地区,万山特区', 522200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522301, '兴义市', '', '贵州省,黔西南布依族苗族自治州,兴义市', 522300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522322, '兴仁县', '', '贵州省,黔西南布依族苗族自治州,兴仁县', 522300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522323, '普安县', '', '贵州省,黔西南布依族苗族自治州,普安县', 522300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522324, '晴隆县', '', '贵州省,黔西南布依族苗族自治州,晴隆县', 522300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522325, '贞丰县', '', '贵州省,黔西南布依族苗族自治州,贞丰县', 522300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522326, '望谟县', '', '贵州省,黔西南布依族苗族自治州,望谟县', 522300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522327, '册亨县', '', '贵州省,黔西南布依族苗族自治州,册亨县', 522300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522328, '安龙县', '', '贵州省,黔西南布依族苗族自治州,安龙县', 522300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522401, '毕节市', '', '贵州省,毕节地区,毕节市', 522400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522422, '大方县', '', '贵州省,毕节地区,大方县', 522400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522423, '黔西县', '', '贵州省,毕节地区,黔西县', 522400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522424, '金沙县', '', '贵州省,毕节地区,金沙县', 522400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522425, '织金县', '', '贵州省,毕节地区,织金县', 522400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522426, '纳雍县', '', '贵州省,毕节地区,纳雍县', 522400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522427, '威宁彝族回族苗族自治县', '', '贵州省,毕节地区,威宁彝族回族苗族自治县', 522400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522428, '赫章县', '', '贵州省,毕节地区,赫章县', 522400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522601, '凯里市', '', '贵州省,黔东南苗族侗族自治州,凯里市', 522600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522622, '黄平县', '', '贵州省,黔东南苗族侗族自治州,黄平县', 522600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522623, '施秉县', '', '贵州省,黔东南苗族侗族自治州,施秉县', 522600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522624, '三穗县', '', '贵州省,黔东南苗族侗族自治州,三穗县', 522600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522625, '镇远县', '', '贵州省,黔东南苗族侗族自治州,镇远县', 522600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522626, '岑巩县', '', '贵州省,黔东南苗族侗族自治州,岑巩县', 522600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522627, '天柱县', '', '贵州省,黔东南苗族侗族自治州,天柱县', 522600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522628, '锦屏县', '', '贵州省,黔东南苗族侗族自治州,锦屏县', 522600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522629, '剑河县', '', '贵州省,黔东南苗族侗族自治州,剑河县', 522600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522630, '台江县', '', '贵州省,黔东南苗族侗族自治州,台江县', 522600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522631, '黎平县', '', '贵州省,黔东南苗族侗族自治州,黎平县', 522600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522632, '榕江县', '', '贵州省,黔东南苗族侗族自治州,榕江县', 522600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522633, '从江县', '', '贵州省,黔东南苗族侗族自治州,从江县', 522600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522634, '雷山县', '', '贵州省,黔东南苗族侗族自治州,雷山县', 522600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522635, '麻江县', '', '贵州省,黔东南苗族侗族自治州,麻江县', 522600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522636, '丹寨县', '', '贵州省,黔东南苗族侗族自治州,丹寨县', 522600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522701, '都匀市', '', '贵州省,黔南布依族苗族自治州,都匀市', 522700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522702, '福泉市', '', '贵州省,黔南布依族苗族自治州,福泉市', 522700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522722, '荔波县', '', '贵州省,黔南布依族苗族自治州,荔波县', 522700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522723, '贵定县', '', '贵州省,黔南布依族苗族自治州,贵定县', 522700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522725, '瓮安县', '', '贵州省,黔南布依族苗族自治州,瓮安县', 522700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522726, '独山县', '', '贵州省,黔南布依族苗族自治州,独山县', 522700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522727, '平塘县', '', '贵州省,黔南布依族苗族自治州,平塘县', 522700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522728, '罗甸县', '', '贵州省,黔南布依族苗族自治州,罗甸县', 522700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522729, '长顺县', '', '贵州省,黔南布依族苗族自治州,长顺县', 522700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522730, '龙里县', '', '贵州省,黔南布依族苗族自治州,龙里县', 522700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522731, '惠水县', '', '贵州省,黔南布依族苗族自治州,惠水县', 522700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (522732, '三都水族自治县', '', '贵州省,黔南布依族苗族自治州,三都水族自治县', 522700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530101, '市辖区', '', '云南省,昆明市,市辖区', 530100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530102, '五华区', '', '云南省,昆明市,五华区', 530100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530103, '盘龙区', '', '云南省,昆明市,盘龙区', 530100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530111, '官渡区', '', '云南省,昆明市,官渡区', 530100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530112, '西山区', '', '云南省,昆明市,西山区', 530100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530113, '东川区', '', '云南省,昆明市,东川区', 530100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530121, '呈贡县', '', '云南省,昆明市,呈贡县', 530100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530122, '晋宁县', '', '云南省,昆明市,晋宁县', 530100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530124, '富民县', '', '云南省,昆明市,富民县', 530100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530125, '宜良县', '', '云南省,昆明市,宜良县', 530100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530126, '石林彝族自治县', '', '云南省,昆明市,石林彝族自治县', 530100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530127, '嵩明县', '', '云南省,昆明市,嵩明县', 530100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530128, '禄劝彝族苗族自治县', '', '云南省,昆明市,禄劝彝族苗族自治县', 530100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530129, '寻甸回族彝族自治县', '', '云南省,昆明市,寻甸回族彝族自治县', 530100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530181, '安宁市', '', '云南省,昆明市,安宁市', 530100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530301, '市辖区', '', '云南省,曲靖市,市辖区', 530300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530302, '麒麟区', '', '云南省,曲靖市,麒麟区', 530300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530321, '马龙县', '', '云南省,曲靖市,马龙县', 530300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530322, '陆良县', '', '云南省,曲靖市,陆良县', 530300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530323, '师宗县', '', '云南省,曲靖市,师宗县', 530300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530324, '罗平县', '', '云南省,曲靖市,罗平县', 530300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530325, '富源县', '', '云南省,曲靖市,富源县', 530300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530326, '会泽县', '', '云南省,曲靖市,会泽县', 530300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530328, '沾益县', '', '云南省,曲靖市,沾益县', 530300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530381, '宣威市', '', '云南省,曲靖市,宣威市', 530300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530401, '市辖区', '', '云南省,玉溪市,市辖区', 530400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530402, '红塔区', '', '云南省,玉溪市,红塔区', 530400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530421, '江川县', '', '云南省,玉溪市,江川县', 530400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530422, '澄江县', '', '云南省,玉溪市,澄江县', 530400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530423, '通海县', '', '云南省,玉溪市,通海县', 530400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530424, '华宁县', '', '云南省,玉溪市,华宁县', 530400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530425, '易门县', '', '云南省,玉溪市,易门县', 530400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530426, '峨山彝族自治县', '', '云南省,玉溪市,峨山彝族自治县', 530400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530427, '新平彝族傣族自治县', '', '云南省,玉溪市,新平彝族傣族自治县', 530400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530428, '元江哈尼族彝族傣族自治县', '', '云南省,玉溪市,元江哈尼族彝族傣族自治县', 530400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530501, '市辖区', '', '云南省,保山市,市辖区', 530500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530502, '隆阳区', '', '云南省,保山市,隆阳区', 530500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530521, '施甸县', '', '云南省,保山市,施甸县', 530500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530522, '腾冲县', '', '云南省,保山市,腾冲县', 530500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530523, '龙陵县', '', '云南省,保山市,龙陵县', 530500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530524, '昌宁县', '', '云南省,保山市,昌宁县', 530500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530601, '市辖区', '', '云南省,昭通市,市辖区', 530600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530602, '昭阳区', '', '云南省,昭通市,昭阳区', 530600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530621, '鲁甸县', '', '云南省,昭通市,鲁甸县', 530600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530622, '巧家县', '', '云南省,昭通市,巧家县', 530600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530623, '盐津县', '', '云南省,昭通市,盐津县', 530600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530624, '大关县', '', '云南省,昭通市,大关县', 530600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530625, '永善县', '', '云南省,昭通市,永善县', 530600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530626, '绥江县', '', '云南省,昭通市,绥江县', 530600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530627, '镇雄县', '', '云南省,昭通市,镇雄县', 530600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530628, '彝良县', '', '云南省,昭通市,彝良县', 530600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530629, '威信县', '', '云南省,昭通市,威信县', 530600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530630, '水富县', '', '云南省,昭通市,水富县', 530600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530701, '市辖区', '', '云南省,丽江市,市辖区', 530700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530702, '古城区', '', '云南省,丽江市,古城区', 530700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530721, '玉龙纳西族自治县', '', '云南省,丽江市,玉龙纳西族自治县', 530700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530722, '永胜县', '', '云南省,丽江市,永胜县', 530700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530723, '华坪县', '', '云南省,丽江市,华坪县', 530700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530724, '宁蒗彝族自治县', '', '云南省,丽江市,宁蒗彝族自治县', 530700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530801, '市辖区', '', '云南省,思茅市,市辖区', 530800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530802, '翠云区', '', '云南省,思茅市,翠云区', 530800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530821, '普洱哈尼族彝族自治县', '', '云南省,思茅市,普洱哈尼族彝族自治县', 530800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530822, '墨江哈尼族自治县', '', '云南省,思茅市,墨江哈尼族自治县', 530800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530823, '景东彝族自治县', '', '云南省,思茅市,景东彝族自治县', 530800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530824, '景谷傣族彝族自治县', '', '云南省,思茅市,景谷傣族彝族自治县', 530800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530825, '镇沅彝族哈尼族拉祜族自治县', '', '云南省,思茅市,镇沅彝族哈尼族拉祜族自治县', 530800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530826, '江城哈尼族彝族自治县', '', '云南省,思茅市,江城哈尼族彝族自治县', 530800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530827, '孟连傣族拉祜族佤族自治县', '', '云南省,思茅市,孟连傣族拉祜族佤族自治县', 530800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530828, '澜沧拉祜族自治县', '', '云南省,思茅市,澜沧拉祜族自治县', 530800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530829, '西盟佤族自治县', '', '云南省,思茅市,西盟佤族自治县', 530800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530901, '市辖区', '', '云南省,临沧市,市辖区', 530900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530902, '临翔区', '', '云南省,临沧市,临翔区', 530900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530921, '凤庆县', '', '云南省,临沧市,凤庆县', 530900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530922, '云　县', '', '云南省,临沧市,云　县', 530900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530923, '永德县', '', '云南省,临沧市,永德县', 530900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530924, '镇康县', '', '云南省,临沧市,镇康县', 530900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530925, '双江拉祜族佤族布朗族傣族自治县', '', '云南省,临沧市,双江拉祜族佤族布朗族傣族自治县', 530900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530926, '耿马傣族佤族自治县', '', '云南省,临沧市,耿马傣族佤族自治县', 530900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (530927, '沧源佤族自治县', '', '云南省,临沧市,沧源佤族自治县', 530900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532301, '楚雄市', '', '云南省,楚雄彝族自治州,楚雄市', 532300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532322, '双柏县', '', '云南省,楚雄彝族自治州,双柏县', 532300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532323, '牟定县', '', '云南省,楚雄彝族自治州,牟定县', 532300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532324, '南华县', '', '云南省,楚雄彝族自治州,南华县', 532300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532325, '姚安县', '', '云南省,楚雄彝族自治州,姚安县', 532300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532326, '大姚县', '', '云南省,楚雄彝族自治州,大姚县', 532300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532327, '永仁县', '', '云南省,楚雄彝族自治州,永仁县', 532300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532328, '元谋县', '', '云南省,楚雄彝族自治州,元谋县', 532300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532329, '武定县', '', '云南省,楚雄彝族自治州,武定县', 532300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532331, '禄丰县', '', '云南省,楚雄彝族自治州,禄丰县', 532300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532501, '个旧市', '', '云南省,红河哈尼族彝族自治州,个旧市', 532500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532502, '开远市', '', '云南省,红河哈尼族彝族自治州,开远市', 532500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532522, '蒙自县', '', '云南省,红河哈尼族彝族自治州,蒙自县', 532500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532523, '屏边苗族自治县', '', '云南省,红河哈尼族彝族自治州,屏边苗族自治县', 532500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532524, '建水县', '', '云南省,红河哈尼族彝族自治州,建水县', 532500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532525, '石屏县', '', '云南省,红河哈尼族彝族自治州,石屏县', 532500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532526, '弥勒县', '', '云南省,红河哈尼族彝族自治州,弥勒县', 532500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532527, '泸西县', '', '云南省,红河哈尼族彝族自治州,泸西县', 532500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532528, '元阳县', '', '云南省,红河哈尼族彝族自治州,元阳县', 532500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532529, '红河县', '', '云南省,红河哈尼族彝族自治州,红河县', 532500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532530, '金平苗族瑶族傣族自治县', '', '云南省,红河哈尼族彝族自治州,金平苗族瑶族傣族自治县', 532500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532531, '绿春县', '', '云南省,红河哈尼族彝族自治州,绿春县', 532500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532532, '河口瑶族自治县', '', '云南省,红河哈尼族彝族自治州,河口瑶族自治县', 532500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532621, '文山县', '', '云南省,文山壮族苗族自治州,文山县', 532600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532622, '砚山县', '', '云南省,文山壮族苗族自治州,砚山县', 532600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532623, '西畴县', '', '云南省,文山壮族苗族自治州,西畴县', 532600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532624, '麻栗坡县', '', '云南省,文山壮族苗族自治州,麻栗坡县', 532600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532625, '马关县', '', '云南省,文山壮族苗族自治州,马关县', 532600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532626, '丘北县', '', '云南省,文山壮族苗族自治州,丘北县', 532600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532627, '广南县', '', '云南省,文山壮族苗族自治州,广南县', 532600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532628, '富宁县', '', '云南省,文山壮族苗族自治州,富宁县', 532600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532801, '景洪市', '', '云南省,西双版纳傣族自治州,景洪市', 532800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532822, '勐海县', '', '云南省,西双版纳傣族自治州,勐海县', 532800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532823, '勐腊县', '', '云南省,西双版纳傣族自治州,勐腊县', 532800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532901, '大理市', '', '云南省,大理白族自治州,大理市', 532900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532922, '漾濞彝族自治县', '', '云南省,大理白族自治州,漾濞彝族自治县', 532900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532923, '祥云县', '', '云南省,大理白族自治州,祥云县', 532900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532924, '宾川县', '', '云南省,大理白族自治州,宾川县', 532900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532925, '弥渡县', '', '云南省,大理白族自治州,弥渡县', 532900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532926, '南涧彝族自治县', '', '云南省,大理白族自治州,南涧彝族自治县', 532900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532927, '巍山彝族回族自治县', '', '云南省,大理白族自治州,巍山彝族回族自治县', 532900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532928, '永平县', '', '云南省,大理白族自治州,永平县', 532900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532929, '云龙县', '', '云南省,大理白族自治州,云龙县', 532900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532930, '洱源县', '', '云南省,大理白族自治州,洱源县', 532900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532931, '剑川县', '', '云南省,大理白族自治州,剑川县', 532900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (532932, '鹤庆县', '', '云南省,大理白族自治州,鹤庆县', 532900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (533102, '瑞丽市', '', '云南省,德宏傣族景颇族自治州,瑞丽市', 533100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (533103, '潞西市', '', '云南省,德宏傣族景颇族自治州,潞西市', 533100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (533122, '梁河县', '', '云南省,德宏傣族景颇族自治州,梁河县', 533100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (533123, '盈江县', '', '云南省,德宏傣族景颇族自治州,盈江县', 533100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (533124, '陇川县', '', '云南省,德宏傣族景颇族自治州,陇川县', 533100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (533321, '泸水县', '', '云南省,怒江傈僳族自治州,泸水县', 533300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (533323, '福贡县', '', '云南省,怒江傈僳族自治州,福贡县', 533300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (533324, '贡山独龙族怒族自治县', '', '云南省,怒江傈僳族自治州,贡山独龙族怒族自治县', 533300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (533325, '兰坪白族普米族自治县', '', '云南省,怒江傈僳族自治州,兰坪白族普米族自治县', 533300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (533421, '香格里拉县', '', '云南省,迪庆藏族自治州,香格里拉县', 533400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (533422, '德钦县', '', '云南省,迪庆藏族自治州,德钦县', 533400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (533423, '维西傈僳族自治县', '', '云南省,迪庆藏族自治州,维西傈僳族自治县', 533400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (540101, '市辖区', '', '西藏自治区,拉萨市,市辖区', 540100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (540102, '城关区', '', '西藏自治区,拉萨市,城关区', 540100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (540121, '林周县', '', '西藏自治区,拉萨市,林周县', 540100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (540122, '当雄县', '', '西藏自治区,拉萨市,当雄县', 540100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (540123, '尼木县', '', '西藏自治区,拉萨市,尼木县', 540100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (540124, '曲水县', '', '西藏自治区,拉萨市,曲水县', 540100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (540125, '堆龙德庆县', '', '西藏自治区,拉萨市,堆龙德庆县', 540100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (540126, '达孜县', '', '西藏自治区,拉萨市,达孜县', 540100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (540127, '墨竹工卡县', '', '西藏自治区,拉萨市,墨竹工卡县', 540100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542121, '昌都县', '', '西藏自治区,昌都地区,昌都县', 542100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542122, '江达县', '', '西藏自治区,昌都地区,江达县', 542100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542123, '贡觉县', '', '西藏自治区,昌都地区,贡觉县', 542100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542124, '类乌齐县', '', '西藏自治区,昌都地区,类乌齐县', 542100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542125, '丁青县', '', '西藏自治区,昌都地区,丁青县', 542100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542126, '察雅县', '', '西藏自治区,昌都地区,察雅县', 542100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542127, '八宿县', '', '西藏自治区,昌都地区,八宿县', 542100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542128, '左贡县', '', '西藏自治区,昌都地区,左贡县', 542100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542129, '芒康县', '', '西藏自治区,昌都地区,芒康县', 542100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542132, '洛隆县', '', '西藏自治区,昌都地区,洛隆县', 542100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542133, '边坝县', '', '西藏自治区,昌都地区,边坝县', 542100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542221, '乃东县', '', '西藏自治区,山南地区,乃东县', 542200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542222, '扎囊县', '', '西藏自治区,山南地区,扎囊县', 542200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542223, '贡嘎县', '', '西藏自治区,山南地区,贡嘎县', 542200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542224, '桑日县', '', '西藏自治区,山南地区,桑日县', 542200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542225, '琼结县', '', '西藏自治区,山南地区,琼结县', 542200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542226, '曲松县', '', '西藏自治区,山南地区,曲松县', 542200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542227, '措美县', '', '西藏自治区,山南地区,措美县', 542200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542228, '洛扎县', '', '西藏自治区,山南地区,洛扎县', 542200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542229, '加查县', '', '西藏自治区,山南地区,加查县', 542200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542231, '隆子县', '', '西藏自治区,山南地区,隆子县', 542200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542232, '错那县', '', '西藏自治区,山南地区,错那县', 542200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542233, '浪卡子县', '', '西藏自治区,山南地区,浪卡子县', 542200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542301, '日喀则市', '', '西藏自治区,日喀则地区,日喀则市', 542300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542322, '南木林县', '', '西藏自治区,日喀则地区,南木林县', 542300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542323, '江孜县', '', '西藏自治区,日喀则地区,江孜县', 542300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542324, '定日县', '', '西藏自治区,日喀则地区,定日县', 542300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542325, '萨迦县', '', '西藏自治区,日喀则地区,萨迦县', 542300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542326, '拉孜县', '', '西藏自治区,日喀则地区,拉孜县', 542300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542327, '昂仁县', '', '西藏自治区,日喀则地区,昂仁县', 542300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542328, '谢通门县', '', '西藏自治区,日喀则地区,谢通门县', 542300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542329, '白朗县', '', '西藏自治区,日喀则地区,白朗县', 542300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542330, '仁布县', '', '西藏自治区,日喀则地区,仁布县', 542300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542331, '康马县', '', '西藏自治区,日喀则地区,康马县', 542300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542332, '定结县', '', '西藏自治区,日喀则地区,定结县', 542300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542333, '仲巴县', '', '西藏自治区,日喀则地区,仲巴县', 542300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542334, '亚东县', '', '西藏自治区,日喀则地区,亚东县', 542300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542335, '吉隆县', '', '西藏自治区,日喀则地区,吉隆县', 542300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542336, '聂拉木县', '', '西藏自治区,日喀则地区,聂拉木县', 542300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542337, '萨嘎县', '', '西藏自治区,日喀则地区,萨嘎县', 542300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542338, '岗巴县', '', '西藏自治区,日喀则地区,岗巴县', 542300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542421, '那曲县', '', '西藏自治区,那曲地区,那曲县', 542400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542422, '嘉黎县', '', '西藏自治区,那曲地区,嘉黎县', 542400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542423, '比如县', '', '西藏自治区,那曲地区,比如县', 542400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542424, '聂荣县', '', '西藏自治区,那曲地区,聂荣县', 542400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542425, '安多县', '', '西藏自治区,那曲地区,安多县', 542400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542426, '申扎县', '', '西藏自治区,那曲地区,申扎县', 542400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542427, '索　县', '', '西藏自治区,那曲地区,索　县', 542400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542428, '班戈县', '', '西藏自治区,那曲地区,班戈县', 542400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542429, '巴青县', '', '西藏自治区,那曲地区,巴青县', 542400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542430, '尼玛县', '', '西藏自治区,那曲地区,尼玛县', 542400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542521, '普兰县', '', '西藏自治区,阿里地区,普兰县', 542500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542522, '札达县', '', '西藏自治区,阿里地区,札达县', 542500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542523, '噶尔县', '', '西藏自治区,阿里地区,噶尔县', 542500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542524, '日土县', '', '西藏自治区,阿里地区,日土县', 542500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542525, '革吉县', '', '西藏自治区,阿里地区,革吉县', 542500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542526, '改则县', '', '西藏自治区,阿里地区,改则县', 542500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542527, '措勤县', '', '西藏自治区,阿里地区,措勤县', 542500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542621, '林芝县', '', '西藏自治区,林芝地区,林芝县', 542600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542622, '工布江达县', '', '西藏自治区,林芝地区,工布江达县', 542600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542623, '米林县', '', '西藏自治区,林芝地区,米林县', 542600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542624, '墨脱县', '', '西藏自治区,林芝地区,墨脱县', 542600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542625, '波密县', '', '西藏自治区,林芝地区,波密县', 542600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542626, '察隅县', '', '西藏自治区,林芝地区,察隅县', 542600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (542627, '朗　县', '', '西藏自治区,林芝地区,朗　县', 542600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610101, '市辖区', '', '陕西省,西安市,市辖区', 610100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610102, '新城区', '', '陕西省,西安市,新城区', 610100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610103, '碑林区', '', '陕西省,西安市,碑林区', 610100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610104, '莲湖区', '', '陕西省,西安市,莲湖区', 610100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610111, '灞桥区', '', '陕西省,西安市,灞桥区', 610100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610112, '未央区', '', '陕西省,西安市,未央区', 610100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610113, '雁塔区', '', '陕西省,西安市,雁塔区', 610100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610114, '阎良区', '', '陕西省,西安市,阎良区', 610100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610115, '临潼区', '', '陕西省,西安市,临潼区', 610100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610116, '长安区', '', '陕西省,西安市,长安区', 610100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610122, '蓝田县', '', '陕西省,西安市,蓝田县', 610100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610124, '周至县', '', '陕西省,西安市,周至县', 610100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610125, '户　县', '', '陕西省,西安市,户　县', 610100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610126, '高陵县', '', '陕西省,西安市,高陵县', 610100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610201, '市辖区', '', '陕西省,铜川市,市辖区', 610200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610202, '王益区', '', '陕西省,铜川市,王益区', 610200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610203, '印台区', '', '陕西省,铜川市,印台区', 610200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610204, '耀州区', '', '陕西省,铜川市,耀州区', 610200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610222, '宜君县', '', '陕西省,铜川市,宜君县', 610200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610301, '市辖区', '', '陕西省,宝鸡市,市辖区', 610300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610302, '渭滨区', '', '陕西省,宝鸡市,渭滨区', 610300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610303, '金台区', '', '陕西省,宝鸡市,金台区', 610300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610304, '陈仓区', '', '陕西省,宝鸡市,陈仓区', 610300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610322, '凤翔县', '', '陕西省,宝鸡市,凤翔县', 610300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610323, '岐山县', '', '陕西省,宝鸡市,岐山县', 610300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610324, '扶风县', '', '陕西省,宝鸡市,扶风县', 610300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610326, '眉　县', '', '陕西省,宝鸡市,眉　县', 610300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610327, '陇　县', '', '陕西省,宝鸡市,陇　县', 610300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610328, '千阳县', '', '陕西省,宝鸡市,千阳县', 610300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610329, '麟游县', '', '陕西省,宝鸡市,麟游县', 610300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610330, '凤　县', '', '陕西省,宝鸡市,凤　县', 610300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610331, '太白县', '', '陕西省,宝鸡市,太白县', 610300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610401, '市辖区', '', '陕西省,咸阳市,市辖区', 610400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610402, '秦都区', '', '陕西省,咸阳市,秦都区', 610400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610403, '杨凌区', '', '陕西省,咸阳市,杨凌区', 610400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610404, '渭城区', '', '陕西省,咸阳市,渭城区', 610400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610422, '三原县', '', '陕西省,咸阳市,三原县', 610400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610423, '泾阳县', '', '陕西省,咸阳市,泾阳县', 610400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610424, '乾　县', '', '陕西省,咸阳市,乾　县', 610400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610425, '礼泉县', '', '陕西省,咸阳市,礼泉县', 610400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610426, '永寿县', '', '陕西省,咸阳市,永寿县', 610400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610427, '彬　县', '', '陕西省,咸阳市,彬　县', 610400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610428, '长武县', '', '陕西省,咸阳市,长武县', 610400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610429, '旬邑县', '', '陕西省,咸阳市,旬邑县', 610400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610430, '淳化县', '', '陕西省,咸阳市,淳化县', 610400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610431, '武功县', '', '陕西省,咸阳市,武功县', 610400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610481, '兴平市', '', '陕西省,咸阳市,兴平市', 610400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610501, '市辖区', '', '陕西省,渭南市,市辖区', 610500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610502, '临渭区', '', '陕西省,渭南市,临渭区', 610500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610521, '华　县', '', '陕西省,渭南市,华　县', 610500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610522, '潼关县', '', '陕西省,渭南市,潼关县', 610500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610523, '大荔县', '', '陕西省,渭南市,大荔县', 610500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610524, '合阳县', '', '陕西省,渭南市,合阳县', 610500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610525, '澄城县', '', '陕西省,渭南市,澄城县', 610500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610526, '蒲城县', '', '陕西省,渭南市,蒲城县', 610500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610527, '白水县', '', '陕西省,渭南市,白水县', 610500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610528, '富平县', '', '陕西省,渭南市,富平县', 610500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610581, '韩城市', '', '陕西省,渭南市,韩城市', 610500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610582, '华阴市', '', '陕西省,渭南市,华阴市', 610500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610601, '市辖区', '', '陕西省,延安市,市辖区', 610600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610602, '宝塔区', '', '陕西省,延安市,宝塔区', 610600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610621, '延长县', '', '陕西省,延安市,延长县', 610600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610622, '延川县', '', '陕西省,延安市,延川县', 610600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610623, '子长县', '', '陕西省,延安市,子长县', 610600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610624, '安塞县', '', '陕西省,延安市,安塞县', 610600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610625, '志丹县', '', '陕西省,延安市,志丹县', 610600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610626, '吴旗县', '', '陕西省,延安市,吴旗县', 610600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610627, '甘泉县', '', '陕西省,延安市,甘泉县', 610600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610628, '富　县', '', '陕西省,延安市,富　县', 610600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610629, '洛川县', '', '陕西省,延安市,洛川县', 610600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610630, '宜川县', '', '陕西省,延安市,宜川县', 610600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610631, '黄龙县', '', '陕西省,延安市,黄龙县', 610600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610632, '黄陵县', '', '陕西省,延安市,黄陵县', 610600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610701, '市辖区', '', '陕西省,汉中市,市辖区', 610700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610702, '汉台区', '', '陕西省,汉中市,汉台区', 610700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610721, '南郑县', '', '陕西省,汉中市,南郑县', 610700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610722, '城固县', '', '陕西省,汉中市,城固县', 610700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610723, '洋　县', '', '陕西省,汉中市,洋　县', 610700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610724, '西乡县', '', '陕西省,汉中市,西乡县', 610700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610725, '勉　县', '', '陕西省,汉中市,勉　县', 610700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610726, '宁强县', '', '陕西省,汉中市,宁强县', 610700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610727, '略阳县', '', '陕西省,汉中市,略阳县', 610700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610728, '镇巴县', '', '陕西省,汉中市,镇巴县', 610700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610729, '留坝县', '', '陕西省,汉中市,留坝县', 610700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610730, '佛坪县', '', '陕西省,汉中市,佛坪县', 610700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610801, '市辖区', '', '陕西省,榆林市,市辖区', 610800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610802, '榆阳区', '', '陕西省,榆林市,榆阳区', 610800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610821, '神木县', '', '陕西省,榆林市,神木县', 610800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610822, '府谷县', '', '陕西省,榆林市,府谷县', 610800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610823, '横山县', '', '陕西省,榆林市,横山县', 610800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610824, '靖边县', '', '陕西省,榆林市,靖边县', 610800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610825, '定边县', '', '陕西省,榆林市,定边县', 610800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610826, '绥德县', '', '陕西省,榆林市,绥德县', 610800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610827, '米脂县', '', '陕西省,榆林市,米脂县', 610800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610828, '佳　县', '', '陕西省,榆林市,佳　县', 610800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610829, '吴堡县', '', '陕西省,榆林市,吴堡县', 610800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610830, '清涧县', '', '陕西省,榆林市,清涧县', 610800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610831, '子洲县', '', '陕西省,榆林市,子洲县', 610800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610901, '市辖区', '', '陕西省,安康市,市辖区', 610900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610902, '汉滨区', '', '陕西省,安康市,汉滨区', 610900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610921, '汉阴县', '', '陕西省,安康市,汉阴县', 610900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610922, '石泉县', '', '陕西省,安康市,石泉县', 610900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610923, '宁陕县', '', '陕西省,安康市,宁陕县', 610900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610924, '紫阳县', '', '陕西省,安康市,紫阳县', 610900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610925, '岚皋县', '', '陕西省,安康市,岚皋县', 610900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610926, '平利县', '', '陕西省,安康市,平利县', 610900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610927, '镇坪县', '', '陕西省,安康市,镇坪县', 610900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610928, '旬阳县', '', '陕西省,安康市,旬阳县', 610900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (610929, '白河县', '', '陕西省,安康市,白河县', 610900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (611001, '市辖区', '', '陕西省,商洛市,市辖区', 611000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (611002, '商州区', '', '陕西省,商洛市,商州区', 611000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (611021, '洛南县', '', '陕西省,商洛市,洛南县', 611000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (611022, '丹凤县', '', '陕西省,商洛市,丹凤县', 611000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (611023, '商南县', '', '陕西省,商洛市,商南县', 611000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (611024, '山阳县', '', '陕西省,商洛市,山阳县', 611000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (611025, '镇安县', '', '陕西省,商洛市,镇安县', 611000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (611026, '柞水县', '', '陕西省,商洛市,柞水县', 611000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620101, '市辖区', '', '甘肃省,兰州市,市辖区', 620100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620102, '城关区', '', '甘肃省,兰州市,城关区', 620100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620103, '七里河区', '', '甘肃省,兰州市,七里河区', 620100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620104, '西固区', '', '甘肃省,兰州市,西固区', 620100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620105, '安宁区', '', '甘肃省,兰州市,安宁区', 620100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620111, '红古区', '', '甘肃省,兰州市,红古区', 620100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620121, '永登县', '', '甘肃省,兰州市,永登县', 620100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620122, '皋兰县', '', '甘肃省,兰州市,皋兰县', 620100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620123, '榆中县', '', '甘肃省,兰州市,榆中县', 620100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620201, '市辖区', '', '甘肃省,嘉峪关市,市辖区', 620200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620301, '市辖区', '', '甘肃省,金昌市,市辖区', 620300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620302, '金川区', '', '甘肃省,金昌市,金川区', 620300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620321, '永昌县', '', '甘肃省,金昌市,永昌县', 620300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620401, '市辖区', '', '甘肃省,白银市,市辖区', 620400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620402, '白银区', '', '甘肃省,白银市,白银区', 620400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620403, '平川区', '', '甘肃省,白银市,平川区', 620400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620421, '靖远县', '', '甘肃省,白银市,靖远县', 620400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620422, '会宁县', '', '甘肃省,白银市,会宁县', 620400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620423, '景泰县', '', '甘肃省,白银市,景泰县', 620400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620501, '市辖区', '', '甘肃省,天水市,市辖区', 620500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620502, '秦城区', '', '甘肃省,天水市,秦城区', 620500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620503, '北道区', '', '甘肃省,天水市,北道区', 620500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620521, '清水县', '', '甘肃省,天水市,清水县', 620500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620522, '秦安县', '', '甘肃省,天水市,秦安县', 620500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620523, '甘谷县', '', '甘肃省,天水市,甘谷县', 620500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620524, '武山县', '', '甘肃省,天水市,武山县', 620500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620525, '张家川回族自治县', '', '甘肃省,天水市,张家川回族自治县', 620500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620601, '市辖区', '', '甘肃省,武威市,市辖区', 620600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620602, '凉州区', '', '甘肃省,武威市,凉州区', 620600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620621, '民勤县', '', '甘肃省,武威市,民勤县', 620600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620622, '古浪县', '', '甘肃省,武威市,古浪县', 620600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620623, '天祝藏族自治县', '', '甘肃省,武威市,天祝藏族自治县', 620600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620701, '市辖区', '', '甘肃省,张掖市,市辖区', 620700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620702, '甘州区', '', '甘肃省,张掖市,甘州区', 620700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620721, '肃南裕固族自治县', '', '甘肃省,张掖市,肃南裕固族自治县', 620700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620722, '民乐县', '', '甘肃省,张掖市,民乐县', 620700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620723, '临泽县', '', '甘肃省,张掖市,临泽县', 620700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620724, '高台县', '', '甘肃省,张掖市,高台县', 620700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620725, '山丹县', '', '甘肃省,张掖市,山丹县', 620700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620801, '市辖区', '', '甘肃省,平凉市,市辖区', 620800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620802, '崆峒区', '', '甘肃省,平凉市,崆峒区', 620800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620821, '泾川县', '', '甘肃省,平凉市,泾川县', 620800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620822, '灵台县', '', '甘肃省,平凉市,灵台县', 620800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620823, '崇信县', '', '甘肃省,平凉市,崇信县', 620800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620824, '华亭县', '', '甘肃省,平凉市,华亭县', 620800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620825, '庄浪县', '', '甘肃省,平凉市,庄浪县', 620800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620826, '静宁县', '', '甘肃省,平凉市,静宁县', 620800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620901, '市辖区', '', '甘肃省,酒泉市,市辖区', 620900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620902, '肃州区', '', '甘肃省,酒泉市,肃州区', 620900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620921, '金塔县', '', '甘肃省,酒泉市,金塔县', 620900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620922, '安西县', '', '甘肃省,酒泉市,安西县', 620900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620923, '肃北蒙古族自治县', '', '甘肃省,酒泉市,肃北蒙古族自治县', 620900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620924, '阿克塞哈萨克族自治县', '', '甘肃省,酒泉市,阿克塞哈萨克族自治县', 620900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620981, '玉门市', '', '甘肃省,酒泉市,玉门市', 620900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (620982, '敦煌市', '', '甘肃省,酒泉市,敦煌市', 620900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621001, '市辖区', '', '甘肃省,庆阳市,市辖区', 621000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621002, '西峰区', '', '甘肃省,庆阳市,西峰区', 621000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621021, '庆城县', '', '甘肃省,庆阳市,庆城县', 621000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621022, '环　县', '', '甘肃省,庆阳市,环　县', 621000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621023, '华池县', '', '甘肃省,庆阳市,华池县', 621000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621024, '合水县', '', '甘肃省,庆阳市,合水县', 621000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621025, '正宁县', '', '甘肃省,庆阳市,正宁县', 621000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621026, '宁　县', '', '甘肃省,庆阳市,宁　县', 621000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621027, '镇原县', '', '甘肃省,庆阳市,镇原县', 621000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621101, '市辖区', '', '甘肃省,定西市,市辖区', 621100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621102, '安定区', '', '甘肃省,定西市,安定区', 621100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621121, '通渭县', '', '甘肃省,定西市,通渭县', 621100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621122, '陇西县', '', '甘肃省,定西市,陇西县', 621100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621123, '渭源县', '', '甘肃省,定西市,渭源县', 621100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621124, '临洮县', '', '甘肃省,定西市,临洮县', 621100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621125, '漳　县', '', '甘肃省,定西市,漳　县', 621100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621126, '岷　县', '', '甘肃省,定西市,岷　县', 621100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621201, '市辖区', '', '甘肃省,陇南市,市辖区', 621200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621202, '武都区', '', '甘肃省,陇南市,武都区', 621200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621221, '成　县', '', '甘肃省,陇南市,成　县', 621200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621222, '文　县', '', '甘肃省,陇南市,文　县', 621200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621223, '宕昌县', '', '甘肃省,陇南市,宕昌县', 621200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621224, '康　县', '', '甘肃省,陇南市,康　县', 621200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621225, '西和县', '', '甘肃省,陇南市,西和县', 621200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621226, '礼　县', '', '甘肃省,陇南市,礼　县', 621200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621227, '徽　县', '', '甘肃省,陇南市,徽　县', 621200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (621228, '两当县', '', '甘肃省,陇南市,两当县', 621200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (622901, '临夏市', '', '甘肃省,临夏回族自治州,临夏市', 622900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (622921, '临夏县', '', '甘肃省,临夏回族自治州,临夏县', 622900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (622922, '康乐县', '', '甘肃省,临夏回族自治州,康乐县', 622900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (622923, '永靖县', '', '甘肃省,临夏回族自治州,永靖县', 622900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (622924, '广河县', '', '甘肃省,临夏回族自治州,广河县', 622900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (622925, '和政县', '', '甘肃省,临夏回族自治州,和政县', 622900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (622926, '东乡族自治县', '', '甘肃省,临夏回族自治州,东乡族自治县', 622900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (622927, '积石山保安族东乡族撒拉族自治县', '', '甘肃省,临夏回族自治州,积石山保安族东乡族撒拉族自治县', 622900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (623001, '合作市', '', '甘肃省,甘南藏族自治州,合作市', 623000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (623021, '临潭县', '', '甘肃省,甘南藏族自治州,临潭县', 623000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (623022, '卓尼县', '', '甘肃省,甘南藏族自治州,卓尼县', 623000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (623023, '舟曲县', '', '甘肃省,甘南藏族自治州,舟曲县', 623000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (623024, '迭部县', '', '甘肃省,甘南藏族自治州,迭部县', 623000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (623025, '玛曲县', '', '甘肃省,甘南藏族自治州,玛曲县', 623000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (623026, '碌曲县', '', '甘肃省,甘南藏族自治州,碌曲县', 623000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (623027, '夏河县', '', '甘肃省,甘南藏族自治州,夏河县', 623000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (630101, '市辖区', '', '青海省,西宁市,市辖区', 630100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (630102, '城东区', '', '青海省,西宁市,城东区', 630100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (630103, '城中区', '', '青海省,西宁市,城中区', 630100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (630104, '城西区', '', '青海省,西宁市,城西区', 630100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (630105, '城北区', '', '青海省,西宁市,城北区', 630100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (630121, '大通回族土族自治县', '', '青海省,西宁市,大通回族土族自治县', 630100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (630122, '湟中县', '', '青海省,西宁市,湟中县', 630100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (630123, '湟源县', '', '青海省,西宁市,湟源县', 630100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632121, '平安县', '', '青海省,海东地区,平安县', 632100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632122, '民和回族土族自治县', '', '青海省,海东地区,民和回族土族自治县', 632100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632123, '乐都县', '', '青海省,海东地区,乐都县', 632100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632126, '互助土族自治县', '', '青海省,海东地区,互助土族自治县', 632100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632127, '化隆回族自治县', '', '青海省,海东地区,化隆回族自治县', 632100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632128, '循化撒拉族自治县', '', '青海省,海东地区,循化撒拉族自治县', 632100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632221, '门源回族自治县', '', '青海省,海北藏族自治州,门源回族自治县', 632200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632222, '祁连县', '', '青海省,海北藏族自治州,祁连县', 632200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632223, '海晏县', '', '青海省,海北藏族自治州,海晏县', 632200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632224, '刚察县', '', '青海省,海北藏族自治州,刚察县', 632200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632321, '同仁县', '', '青海省,黄南藏族自治州,同仁县', 632300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632322, '尖扎县', '', '青海省,黄南藏族自治州,尖扎县', 632300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632323, '泽库县', '', '青海省,黄南藏族自治州,泽库县', 632300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632324, '河南蒙古族自治县', '', '青海省,黄南藏族自治州,河南蒙古族自治县', 632300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632521, '共和县', '', '青海省,海南藏族自治州,共和县', 632500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632522, '同德县', '', '青海省,海南藏族自治州,同德县', 632500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632523, '贵德县', '', '青海省,海南藏族自治州,贵德县', 632500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632524, '兴海县', '', '青海省,海南藏族自治州,兴海县', 632500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632525, '贵南县', '', '青海省,海南藏族自治州,贵南县', 632500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632621, '玛沁县', '', '青海省,果洛藏族自治州,玛沁县', 632600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632622, '班玛县', '', '青海省,果洛藏族自治州,班玛县', 632600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632623, '甘德县', '', '青海省,果洛藏族自治州,甘德县', 632600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632624, '达日县', '', '青海省,果洛藏族自治州,达日县', 632600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632625, '久治县', '', '青海省,果洛藏族自治州,久治县', 632600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632626, '玛多县', '', '青海省,果洛藏族自治州,玛多县', 632600, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632721, '玉树县', '', '青海省,玉树藏族自治州,玉树县', 632700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632722, '杂多县', '', '青海省,玉树藏族自治州,杂多县', 632700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632723, '称多县', '', '青海省,玉树藏族自治州,称多县', 632700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632724, '治多县', '', '青海省,玉树藏族自治州,治多县', 632700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632725, '囊谦县', '', '青海省,玉树藏族自治州,囊谦县', 632700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632726, '曲麻莱县', '', '青海省,玉树藏族自治州,曲麻莱县', 632700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632801, '格尔木市', '', '青海省,海西蒙古族藏族自治州,格尔木市', 632800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632802, '德令哈市', '', '青海省,海西蒙古族藏族自治州,德令哈市', 632800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632821, '乌兰县', '', '青海省,海西蒙古族藏族自治州,乌兰县', 632800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632822, '都兰县', '', '青海省,海西蒙古族藏族自治州,都兰县', 632800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (632823, '天峻县', '', '青海省,海西蒙古族藏族自治州,天峻县', 632800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (640101, '市辖区', '', '宁夏回族自治区,银川市,市辖区', 640100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (640104, '兴庆区', '', '宁夏回族自治区,银川市,兴庆区', 640100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (640105, '西夏区', '', '宁夏回族自治区,银川市,西夏区', 640100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (640106, '金凤区', '', '宁夏回族自治区,银川市,金凤区', 640100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (640121, '永宁县', '', '宁夏回族自治区,银川市,永宁县', 640100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (640122, '贺兰县', '', '宁夏回族自治区,银川市,贺兰县', 640100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (640181, '灵武市', '', '宁夏回族自治区,银川市,灵武市', 640100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (640201, '市辖区', '', '宁夏回族自治区,石嘴山市,市辖区', 640200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (640202, '大武口区', '', '宁夏回族自治区,石嘴山市,大武口区', 640200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (640205, '惠农区', '', '宁夏回族自治区,石嘴山市,惠农区', 640200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (640221, '平罗县', '', '宁夏回族自治区,石嘴山市,平罗县', 640200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (640301, '市辖区', '', '宁夏回族自治区,吴忠市,市辖区', 640300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (640302, '利通区', '', '宁夏回族自治区,吴忠市,利通区', 640300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (640323, '盐池县', '', '宁夏回族自治区,吴忠市,盐池县', 640300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (640324, '同心县', '', '宁夏回族自治区,吴忠市,同心县', 640300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (640381, '青铜峡市', '', '宁夏回族自治区,吴忠市,青铜峡市', 640300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (640401, '市辖区', '', '宁夏回族自治区,固原市,市辖区', 640400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (640402, '原州区', '', '宁夏回族自治区,固原市,原州区', 640400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (640422, '西吉县', '', '宁夏回族自治区,固原市,西吉县', 640400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (640423, '隆德县', '', '宁夏回族自治区,固原市,隆德县', 640400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (640424, '泾源县', '', '宁夏回族自治区,固原市,泾源县', 640400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (640425, '彭阳县', '', '宁夏回族自治区,固原市,彭阳县', 640400, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (640501, '市辖区', '', '宁夏回族自治区,中卫市,市辖区', 640500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (640502, '沙坡头区', '', '宁夏回族自治区,中卫市,沙坡头区', 640500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (640521, '中宁县', '', '宁夏回族自治区,中卫市,中宁县', 640500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (640522, '海原县', '', '宁夏回族自治区,中卫市,海原县', 640500, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (650101, '市辖区', '', '新疆维吾尔自治区,乌鲁木齐市,市辖区', 650100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (650102, '天山区', '', '新疆维吾尔自治区,乌鲁木齐市,天山区', 650100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (650103, '沙依巴克区', '', '新疆维吾尔自治区,乌鲁木齐市,沙依巴克区', 650100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (650104, '新市区', '', '新疆维吾尔自治区,乌鲁木齐市,新市区', 650100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (650105, '水磨沟区', '', '新疆维吾尔自治区,乌鲁木齐市,水磨沟区', 650100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (650106, '头屯河区', '', '新疆维吾尔自治区,乌鲁木齐市,头屯河区', 650100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (650107, '达坂城区', '', '新疆维吾尔自治区,乌鲁木齐市,达坂城区', 650100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (650108, '东山区', '', '新疆维吾尔自治区,乌鲁木齐市,东山区', 650100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (650121, '乌鲁木齐县', '', '新疆维吾尔自治区,乌鲁木齐市,乌鲁木齐县', 650100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (650201, '市辖区', '', '新疆维吾尔自治区,克拉玛依市,市辖区', 650200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (650202, '独山子区', '', '新疆维吾尔自治区,克拉玛依市,独山子区', 650200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (650203, '克拉玛依区', '', '新疆维吾尔自治区,克拉玛依市,克拉玛依区', 650200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (650204, '白碱滩区', '', '新疆维吾尔自治区,克拉玛依市,白碱滩区', 650200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (650205, '乌尔禾区', '', '新疆维吾尔自治区,克拉玛依市,乌尔禾区', 650200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652101, '吐鲁番市', '', '新疆维吾尔自治区,吐鲁番地区,吐鲁番市', 652100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652122, '鄯善县', '', '新疆维吾尔自治区,吐鲁番地区,鄯善县', 652100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652123, '托克逊县', '', '新疆维吾尔自治区,吐鲁番地区,托克逊县', 652100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652201, '哈密市', '', '新疆维吾尔自治区,哈密地区,哈密市', 652200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652222, '巴里坤哈萨克自治县', '', '新疆维吾尔自治区,哈密地区,巴里坤哈萨克自治县', 652200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652223, '伊吾县', '', '新疆维吾尔自治区,哈密地区,伊吾县', 652200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652301, '昌吉市', '', '新疆维吾尔自治区,昌吉回族自治州,昌吉市', 652300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652302, '阜康市', '', '新疆维吾尔自治区,昌吉回族自治州,阜康市', 652300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652303, '米泉市', '', '新疆维吾尔自治区,昌吉回族自治州,米泉市', 652300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652323, '呼图壁县', '', '新疆维吾尔自治区,昌吉回族自治州,呼图壁县', 652300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652324, '玛纳斯县', '', '新疆维吾尔自治区,昌吉回族自治州,玛纳斯县', 652300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652325, '奇台县', '', '新疆维吾尔自治区,昌吉回族自治州,奇台县', 652300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652327, '吉木萨尔县', '', '新疆维吾尔自治区,昌吉回族自治州,吉木萨尔县', 652300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652328, '木垒哈萨克自治县', '', '新疆维吾尔自治区,昌吉回族自治州,木垒哈萨克自治县', 652300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652701, '博乐市', '', '新疆维吾尔自治区,博尔塔拉蒙古自治州,博乐市', 652700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652722, '精河县', '', '新疆维吾尔自治区,博尔塔拉蒙古自治州,精河县', 652700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652723, '温泉县', '', '新疆维吾尔自治区,博尔塔拉蒙古自治州,温泉县', 652700, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652801, '库尔勒市', '', '新疆维吾尔自治区,巴音郭楞蒙古自治州,库尔勒市', 652800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652822, '轮台县', '', '新疆维吾尔自治区,巴音郭楞蒙古自治州,轮台县', 652800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652823, '尉犁县', '', '新疆维吾尔自治区,巴音郭楞蒙古自治州,尉犁县', 652800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652824, '若羌县', '', '新疆维吾尔自治区,巴音郭楞蒙古自治州,若羌县', 652800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652825, '且末县', '', '新疆维吾尔自治区,巴音郭楞蒙古自治州,且末县', 652800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652826, '焉耆回族自治县', '', '新疆维吾尔自治区,巴音郭楞蒙古自治州,焉耆回族自治县', 652800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652827, '和静县', '', '新疆维吾尔自治区,巴音郭楞蒙古自治州,和静县', 652800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652828, '和硕县', '', '新疆维吾尔自治区,巴音郭楞蒙古自治州,和硕县', 652800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652829, '博湖县', '', '新疆维吾尔自治区,巴音郭楞蒙古自治州,博湖县', 652800, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652901, '阿克苏市', '', '新疆维吾尔自治区,阿克苏地区,阿克苏市', 652900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652922, '温宿县', '', '新疆维吾尔自治区,阿克苏地区,温宿县', 652900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652923, '库车县', '', '新疆维吾尔自治区,阿克苏地区,库车县', 652900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652924, '沙雅县', '', '新疆维吾尔自治区,阿克苏地区,沙雅县', 652900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652925, '新和县', '', '新疆维吾尔自治区,阿克苏地区,新和县', 652900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652926, '拜城县', '', '新疆维吾尔自治区,阿克苏地区,拜城县', 652900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652927, '乌什县', '', '新疆维吾尔自治区,阿克苏地区,乌什县', 652900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652928, '阿瓦提县', '', '新疆维吾尔自治区,阿克苏地区,阿瓦提县', 652900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (652929, '柯坪县', '', '新疆维吾尔自治区,阿克苏地区,柯坪县', 652900, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (653001, '阿图什市', '', '新疆维吾尔自治区,克孜勒苏柯尔克孜自治州,阿图什市', 653000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (653022, '阿克陶县', '', '新疆维吾尔自治区,克孜勒苏柯尔克孜自治州,阿克陶县', 653000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (653023, '阿合奇县', '', '新疆维吾尔自治区,克孜勒苏柯尔克孜自治州,阿合奇县', 653000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (653024, '乌恰县', '', '新疆维吾尔自治区,克孜勒苏柯尔克孜自治州,乌恰县', 653000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (653101, '喀什市', '', '新疆维吾尔自治区,喀什地区,喀什市', 653100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (653121, '疏附县', '', '新疆维吾尔自治区,喀什地区,疏附县', 653100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (653122, '疏勒县', '', '新疆维吾尔自治区,喀什地区,疏勒县', 653100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (653123, '英吉沙县', '', '新疆维吾尔自治区,喀什地区,英吉沙县', 653100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (653124, '泽普县', '', '新疆维吾尔自治区,喀什地区,泽普县', 653100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (653125, '莎车县', '', '新疆维吾尔自治区,喀什地区,莎车县', 653100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (653126, '叶城县', '', '新疆维吾尔自治区,喀什地区,叶城县', 653100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (653127, '麦盖提县', '', '新疆维吾尔自治区,喀什地区,麦盖提县', 653100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (653128, '岳普湖县', '', '新疆维吾尔自治区,喀什地区,岳普湖县', 653100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (653129, '伽师县', '', '新疆维吾尔自治区,喀什地区,伽师县', 653100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (653130, '巴楚县', '', '新疆维吾尔自治区,喀什地区,巴楚县', 653100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (653131, '塔什库尔干塔吉克自治县', '', '新疆维吾尔自治区,喀什地区,塔什库尔干塔吉克自治县', 653100, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (653201, '和田市', '', '新疆维吾尔自治区,和田地区,和田市', 653200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (653221, '和田县', '', '新疆维吾尔自治区,和田地区,和田县', 653200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (653222, '墨玉县', '', '新疆维吾尔自治区,和田地区,墨玉县', 653200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (653223, '皮山县', '', '新疆维吾尔自治区,和田地区,皮山县', 653200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (653224, '洛浦县', '', '新疆维吾尔自治区,和田地区,洛浦县', 653200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (653225, '策勒县', '', '新疆维吾尔自治区,和田地区,策勒县', 653200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (653226, '于田县', '', '新疆维吾尔自治区,和田地区,于田县', 653200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (653227, '民丰县', '', '新疆维吾尔自治区,和田地区,民丰县', 653200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (654002, '伊宁市', '', '新疆维吾尔自治区,伊犁哈萨克自治州,伊宁市', 654000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (654003, '奎屯市', '', '新疆维吾尔自治区,伊犁哈萨克自治州,奎屯市', 654000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (654021, '伊宁县', '', '新疆维吾尔自治区,伊犁哈萨克自治州,伊宁县', 654000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (654022, '察布查尔锡伯自治县', '', '新疆维吾尔自治区,伊犁哈萨克自治州,察布查尔锡伯自治县', 654000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (654023, '霍城县', '', '新疆维吾尔自治区,伊犁哈萨克自治州,霍城县', 654000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (654024, '巩留县', '', '新疆维吾尔自治区,伊犁哈萨克自治州,巩留县', 654000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (654025, '新源县', '', '新疆维吾尔自治区,伊犁哈萨克自治州,新源县', 654000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (654026, '昭苏县', '', '新疆维吾尔自治区,伊犁哈萨克自治州,昭苏县', 654000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (654027, '特克斯县', '', '新疆维吾尔自治区,伊犁哈萨克自治州,特克斯县', 654000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (654028, '尼勒克县', '', '新疆维吾尔自治区,伊犁哈萨克自治州,尼勒克县', 654000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (654201, '塔城市', '', '新疆维吾尔自治区,塔城地区,塔城市', 654200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (654202, '乌苏市', '', '新疆维吾尔自治区,塔城地区,乌苏市', 654200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (654221, '额敏县', '', '新疆维吾尔自治区,塔城地区,额敏县', 654200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (654223, '沙湾县', '', '新疆维吾尔自治区,塔城地区,沙湾县', 654200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (654224, '托里县', '', '新疆维吾尔自治区,塔城地区,托里县', 654200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (654225, '裕民县', '', '新疆维吾尔自治区,塔城地区,裕民县', 654200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (654226, '和布克赛尔蒙古自治县', '', '新疆维吾尔自治区,塔城地区,和布克赛尔蒙古自治县', 654200, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (654301, '阿勒泰市', '', '新疆维吾尔自治区,阿勒泰地区,阿勒泰市', 654300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (654321, '布尔津县', '', '新疆维吾尔自治区,阿勒泰地区,布尔津县', 654300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (654322, '富蕴县', '', '新疆维吾尔自治区,阿勒泰地区,富蕴县', 654300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (654323, '福海县', '', '新疆维吾尔自治区,阿勒泰地区,福海县', 654300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (654324, '哈巴河县', '', '新疆维吾尔自治区,阿勒泰地区,哈巴河县', 654300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (654325, '青河县', '', '新疆维吾尔自治区,阿勒泰地区,青河县', 654300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (654326, '吉木乃县', '', '新疆维吾尔自治区,阿勒泰地区,吉木乃县', 654300, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (659001, '石河子市', '', '新疆维吾尔自治区,省直辖行政单位,石河子市', 659000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (659002, '阿拉尔市', '', '新疆维吾尔自治区,省直辖行政单位,阿拉尔市', 659000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (659003, '图木舒克市', '', '新疆维吾尔自治区,省直辖行政单位,图木舒克市', 659000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (659004, '五家渠市', '', '新疆维吾尔自治区,省直辖行政单位,五家渠市', 659000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (810001, '香港', '', '香港特别行政区,香港', 810000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (810002, '中西区', '', '香港特别行政区,香港,中西区', 810001, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (810003, '九龙城区', '', '香港特别行政区,香港,九龙城区', 810001, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (810004, '南区', '', '香港特别行政区,香港,南区', 810001, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (810005, '黄大仙区', '', '香港特别行政区,香港,黄大仙区', 810001, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (810006, '油尖旺区', '', '香港特别行政区,香港,油尖旺区', 810001, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (810007, '葵青区', '', '香港特别行政区,香港,葵青区', 810001, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (810008, '西贡区', '', '香港特别行政区,香港,西贡区', 810001, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (810009, '屯门区', '', '香港特别行政区,香港,屯门区', 810001, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (810010, '荃湾区', '', '香港特别行政区,香港,荃湾区', 810001, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (810011, '东区', '', '香港特别行政区,香港,东区', 810001, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (810012, '观塘区', '', '香港特别行政区,香港,观塘区', 810001, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (810013, '深水步区', '', '香港特别行政区,香港,深水步区', 810001, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (810014, '湾仔区', '', '香港特别行政区,香港,湾仔区', 810001, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (810015, '离岛区', '', '香港特别行政区,香港,离岛区', 810001, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (810016, '北区', '', '香港特别行政区,香港,北区', 810001, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (810017, '沙田区', '', '香港特别行政区,香港,沙田区', 810001, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (810018, '大埔区', '', '香港特别行政区,香港,大埔区', 810001, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (810019, '元朗区', '', '香港特别行政区,香港,元朗区', 810001, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (820001, '澳门', '', '澳门特别行政区,澳门', 820000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (820002, '澳门特别行政区', '', '澳门特别行政区,澳门,澳门', 820001, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (710001, '台北市', '', '台湾省,台北市', 710000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (710002, '台北县', '', '台湾省,台北市,台北县', 710001, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (710003, '基隆市', '', '台湾省,基隆市', 710000, 2, 0, '', 0);
INSERT INTO `wp_city` VALUES (910005, '中山市', '', '广东省,中山市,中山市', 442000, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (710004, '花莲县', '', '台湾省,基隆市,花莲县', 710003, 3, 0, '', 0);
INSERT INTO `wp_city` VALUES (910006, '东莞市', '', '广东省,东莞市,东莞市', 441900, 3, 0, '', 0);

-- ----------------------------
-- Table structure for wp_commission
-- ----------------------------
DROP TABLE IF EXISTS `wp_commission`;
CREATE TABLE `wp_commission`  (
  `comid` int(11) NOT NULL AUTO_INCREMENT,
  `ustyle` int(11) NULL DEFAULT 0 COMMENT '状态，0显示，1是不显示',
  `rebate` double(11, 2) NULL DEFAULT NULL COMMENT '佣金',
  `cotime` int(20) NULL DEFAULT NULL COMMENT '提现时间',
  `uid` int(11) NULL DEFAULT NULL COMMENT '提线人id',
  PRIMARY KEY (`comid`) USING BTREE,
  INDEX `ustyle`(`ustyle`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of wp_commission
-- ----------------------------

-- ----------------------------
-- Table structure for wp_coupon
-- ----------------------------
DROP TABLE IF EXISTS `wp_coupon`;
CREATE TABLE `wp_coupon`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `title` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '代金券' COMMENT '标题',
  `value` decimal(10, 2) UNSIGNED NOT NULL COMMENT '金额，单位元',
  `begin_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '有效起始时间，时间戳',
  `end_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '有效结束时间，时间戳',
  `type` tinyint(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '类型，1发放会员，2验证码验证',
  `verify_code` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '验证码',
  `status` tinyint(2) UNSIGNED NOT NULL DEFAULT 1 COMMENT '手动更改状态，1有效，0无效，优先于时间状态',
  `total` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '个数，只有类型为2时有效。当类型为1时无效。',
  `modified` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '修改时间，时间戳',
  `createtime` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间，时间戳',
  `limit` int(10) NULL DEFAULT NULL COMMENT 'type =1 充值满多少送券 type=2优惠券数量',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 27 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '代金券信息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_coupon
-- ----------------------------
INSERT INTO `wp_coupon` VALUES (25, '优惠券', 10.00, 0, 0, 1, '', 1, 0, 1488534563, 1488534563, 10);
INSERT INTO `wp_coupon` VALUES (26, '注册返券', 100.00, 0, 0, 2, '', 1, 16, 1488887204, 1488887204, -4);

-- ----------------------------
-- Table structure for wp_coupon_user
-- ----------------------------
DROP TABLE IF EXISTS `wp_coupon_user`;
CREATE TABLE `wp_coupon_user`  (
  `cid` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '代金券id',
  `uid` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '用户uid',
  `status` smallint(2) UNSIGNED NOT NULL DEFAULT 1 COMMENT '状态，1未使用，2已使用',
  `modified` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '领券时间或使用时间，时间戳'
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户的代金券表' ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of wp_coupon_user
-- ----------------------------

-- ----------------------------
-- Table structure for wp_data_now
-- ----------------------------
DROP TABLE IF EXISTS `wp_data_now`;
CREATE TABLE `wp_data_now`  (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `code` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `open` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `lastClose` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `high` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `low` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `quoteTime` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `time` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `flag` int(1) NULL DEFAULT NULL,
  `pid` smallint(6) NULL DEFAULT NULL COMMENT '父级分类',
  `length` smallint(5) NOT NULL COMMENT '产品价格长度',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `code`(`code`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1885 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_data_now
-- ----------------------------
INSERT INTO `wp_data_now` VALUES (1870, 'fx_seurusd', '欧元/美元', '1.04145', '1.03879', '1.03879', '1.04151', '1.03758', '25-01-07 15:24:26', '1499059835', 1, 1, 5);
INSERT INTO `wp_data_now` VALUES (1869, 'fx_sgbpusd', '英镑/美元', '1.25534', '1.25166', '1.25166', '1.25556', '1.25035', '25-01-07 15:24:26', '1499059835', 1, 1, 5);
INSERT INTO `wp_data_now` VALUES (1871, 'fx_saudusd', '澳元/美元', '0.62744', '0.6243', '0.62432', '0.62752', '0.62369', '25-01-07 15:24:26', '1499059835', 1, 1, 5);
INSERT INTO `wp_data_now` VALUES (1872, 'fx_susdjpy', '美元/日元', '157.584', '157.584', '157.584', '158.416', '157.546', '25-01-07 15:24:26', '1499059835', 1, 1, 3);
INSERT INTO `wp_data_now` VALUES (1873, 'fx_seurjpy', '欧元/日元', '164.116', '163.709', '163.719', '164.395', '163.606', '25-01-07 15:24:26', '1499059835', 1, 1, 3);
INSERT INTO `wp_data_now` VALUES (1874, 'btcusdt', '比特币', '101798.55', '102119.51', '101798.55', '102733.19', '98712.7', '25-01-07 15:24:29', '1499059835', 1, 1, 2);
INSERT INTO `wp_data_now` VALUES (1875, 'ethusdt', '以太坊', '3675.74', '3713.95', '3675.74', '3743.98', '3622.48', '25-01-07 15:24:32', '1499059835', 1, 1, 2);
INSERT INTO `wp_data_now` VALUES (1876, 'xrpusdt', '瑞波币', '2.43498', '2.4365', '2.43498', '2.45791', '2.36802', '25-01-07 15:24:32', '1499059835', 1, 1, 4);
INSERT INTO `wp_data_now` VALUES (1877, 'T_XAU', '伦敦金', '2640.14', '2636.07', '2639.62', '2646.65', '2632.83', '25-01-07 15:24:32', '1499059835', 1, 2, 2);
INSERT INTO `wp_data_now` VALUES (1878, 'T_XAG', '伦敦银', '30.11', '29.91', '29.94', '30.19', '29.857', '25-01-07 15:24:18', '1499059835', 1, 2, 2);
INSERT INTO `wp_data_now` VALUES (1879, 'HX_HSI', '恒指', '19460', '19739', '19737', '20179', '19270', '25-01-07 15:24:31', '1499059835', 1, 2, 0);
INSERT INTO `wp_data_now` VALUES (1880, 'HX_MHI', '小恒指', '19461', '19739', '19737', '20179', '19270', '25-01-07 15:24:31', '1499059835', 1, 2, 0);
INSERT INTO `wp_data_now` VALUES (1881, 'HX_NQ', '小纳指', '21726', '21869.5', '21744.5', '21896.75', '21647.75', '25-01-07 15:24:32', '1499059835', 1, 2, 2);
INSERT INTO `wp_data_now` VALUES (1882, 'ZY_YM', '小道指', '42964', '43262', '43031', '43409', '42886', '25-01-07 15:24:32', '1499059835', 1, 2, 0);
INSERT INTO `wp_data_now` VALUES (1883, 'HX_ES', '小标普', '6016.5', '6059.5', '6020.5', '6068.25', '6004', '25-01-07 15:24:32', '1499059835', 1, 2, 2);
INSERT INTO `wp_data_now` VALUES (1884, 'ZY_DAX', '德指', '20283', '20335', '20271', '20387', '20244', '25-01-07 15:24:32', '1499059835', 1, 2, 0);

-- ----------------------------
-- Table structure for wp_experience
-- ----------------------------
DROP TABLE IF EXISTS `wp_experience`;
CREATE TABLE `wp_experience`  (
  `eid` int(11) NOT NULL AUTO_INCREMENT,
  `eprice` int(11) NULL DEFAULT NULL,
  `endtime` int(20) NULL DEFAULT NULL COMMENT '到期时间',
  `gettime` int(20) NULL DEFAULT NULL,
  PRIMARY KEY (`eid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of wp_experience
-- ----------------------------
INSERT INTO `wp_experience` VALUES (1, 200, 1550089903, 1450089903);
INSERT INTO `wp_experience` VALUES (7, 20, 1475164800, 1473609600);
INSERT INTO `wp_experience` VALUES (8, 2, 1488470400, 1488470400);

-- ----------------------------
-- Table structure for wp_experienceinfo
-- ----------------------------
DROP TABLE IF EXISTS `wp_experienceinfo`;
CREATE TABLE `wp_experienceinfo`  (
  `exid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `eid` int(11) NULL DEFAULT NULL,
  `exgtime` int(20) NULL DEFAULT NULL COMMENT '领卷时间',
  `getstyle` int(11) NULL DEFAULT NULL,
  `number` int(11) NOT NULL,
  PRIMARY KEY (`exid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 14 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of wp_experienceinfo
-- ----------------------------
INSERT INTO `wp_experienceinfo` VALUES (2, 1978, 2, 1450089888, 0, 0);
INSERT INTO `wp_experienceinfo` VALUES (6, 1977, NULL, NULL, NULL, 3);
INSERT INTO `wp_experienceinfo` VALUES (7, 1980, NULL, NULL, NULL, 0);
INSERT INTO `wp_experienceinfo` VALUES (8, 1971, NULL, NULL, NULL, 7);
INSERT INTO `wp_experienceinfo` VALUES (9, 2086, NULL, NULL, NULL, 1);
INSERT INTO `wp_experienceinfo` VALUES (10, 2087, NULL, NULL, NULL, 1);
INSERT INTO `wp_experienceinfo` VALUES (11, 2088, NULL, NULL, NULL, 1);
INSERT INTO `wp_experienceinfo` VALUES (12, 2089, NULL, NULL, NULL, 1);
INSERT INTO `wp_experienceinfo` VALUES (13, 2090, NULL, NULL, NULL, 1);

-- ----------------------------
-- Table structure for wp_financial_setting
-- ----------------------------
DROP TABLE IF EXISTS `wp_financial_setting`;
CREATE TABLE `wp_financial_setting`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` tinyint(2) NOT NULL DEFAULT 1 COMMENT '出入金设置 1 入金设置 2 出金设置',
  `max_monery` int(10) NOT NULL COMMENT '最大金额',
  `min_monery` int(10) NOT NULL COMMENT '最小金额',
  `poundage` double(255, 1) NOT NULL DEFAULT 0.0 COMMENT '手续费',
  `starttime` char(4) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0000' COMMENT '开始时间',
  `endtime` char(4) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0000' COMMENT '结束时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_financial_setting
-- ----------------------------
INSERT INTO `wp_financial_setting` VALUES (2, 2, 20000, 100, 0.4, '0900', '1700');
INSERT INTO `wp_financial_setting` VALUES (6, 1, 10000, 100, 0.0, '0000', '2400');

-- ----------------------------
-- Table structure for wp_gift
-- ----------------------------
DROP TABLE IF EXISTS `wp_gift`;
CREATE TABLE `wp_gift`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `addtime` int(11) NULL DEFAULT NULL,
  `pimg` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `intmoney` int(255) NULL DEFAULT NULL COMMENT '积分',
  `isshow` tinyint(1) NULL DEFAULT 1 COMMENT '是否上架1是2否',
  `outmoney` int(10) NULL DEFAULT NULL,
  `counts` int(10) NULL DEFAULT 100,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_gift
-- ----------------------------

-- ----------------------------
-- Table structure for wp_integral
-- ----------------------------
DROP TABLE IF EXISTS `wp_integral`;
CREATE TABLE `wp_integral`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(200) NULL DEFAULT NULL,
  `remark` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `number` int(255) NULL DEFAULT NULL,
  `addtime` datetime(0) NULL DEFAULT NULL,
  `giftid` int(10) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_integral
-- ----------------------------

-- ----------------------------
-- Table structure for wp_journal
-- ----------------------------
DROP TABLE IF EXISTS `wp_journal`;
CREATE TABLE `wp_journal`  (
  `jno` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '日志编号',
  `tempdate` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0),
  `uid` int(11) NULL DEFAULT NULL,
  `jtype` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '平仓' COMMENT '操作类型，建仓，平仓',
  `jtime` int(20) NULL DEFAULT NULL COMMENT '操作时间',
  `jincome` double(255, 2) NULL DEFAULT NULL COMMENT '收支金额',
  `number` int(11) NULL DEFAULT NULL COMMENT '手数',
  `remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注：',
  `balance` double(255, 2) NULL DEFAULT NULL COMMENT '记录当时用户余额',
  `jstate` int(11) NULL DEFAULT NULL COMMENT '0亏损，1盈利；2平局',
  `jusername` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '用户名',
  `jostyle` int(11) NULL DEFAULT NULL COMMENT '0涨，1跌',
  `juprice` double(11, 2) NULL DEFAULT NULL COMMENT '产品单价',
  `jfee` double(11, 1) NULL DEFAULT NULL COMMENT '手续费',
  `jbuyprice` double(11, 3) NULL DEFAULT NULL COMMENT '进仓价',
  `jsellprice` double(11, 3) NULL DEFAULT NULL COMMENT '平仓价',
  `jaccess` double(11, 2) NULL DEFAULT NULL COMMENT '出入金额',
  `jploss` double(11, 2) NULL DEFAULT NULL COMMENT '盈亏金额',
  `oid` int(10) NULL DEFAULT NULL COMMENT '订单id',
  `gefee` double(11, 2) NULL DEFAULT NULL,
  `th_uid` int(11) NULL DEFAULT NULL COMMENT '特会用户id',
  INDEX `jno`(`jno`) USING BTREE,
  INDEX `jtype`(`jtype`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE,
  INDEX `jtime`(`jtime`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_journal
-- ----------------------------
INSERT INTO `wp_journal` VALUES ('1736236238101', '2025-01-07 15:50:38', 6, '建仓', 1736236238, 102.00, NULL, '美元/日元-1M', 330.20, 0, '小李', 1, NULL, 0.0, 157.584, NULL, -102.00, NULL, 24, NULL, NULL);

-- ----------------------------
-- Table structure for wp_managerinfo
-- ----------------------------
DROP TABLE IF EXISTS `wp_managerinfo`;
CREATE TABLE `wp_managerinfo`  (
  `mid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `poid` int(11) NULL DEFAULT NULL COMMENT '持仓人',
  `coid` int(11) NULL DEFAULT NULL COMMENT '平仓人',
  `mname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '法人名字',
  `brokerid` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '法人代表身份证',
  `photoid` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '会员资质',
  PRIMARY KEY (`mid`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `poid`(`poid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 11 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_managerinfo
-- ----------------------------
INSERT INTO `wp_managerinfo` VALUES (1, 2, NULL, NULL, NULL, '', NULL);
INSERT INTO `wp_managerinfo` VALUES (2, 3, NULL, NULL, NULL, '', NULL);
INSERT INTO `wp_managerinfo` VALUES (3, 4, NULL, NULL, NULL, '372901199612042810', NULL);
INSERT INTO `wp_managerinfo` VALUES (4, 5, NULL, NULL, NULL, '372901199612042810', NULL);
INSERT INTO `wp_managerinfo` VALUES (5, 6, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `wp_managerinfo` VALUES (6, 7, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `wp_managerinfo` VALUES (7, 8, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `wp_managerinfo` VALUES (8, 9, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `wp_managerinfo` VALUES (9, 10, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `wp_managerinfo` VALUES (10, 11, NULL, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for wp_money_flow
-- ----------------------------
DROP TABLE IF EXISTS `wp_money_flow`;
CREATE TABLE `wp_money_flow`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL DEFAULT 0 COMMENT '用户id',
  `type` smallint(2) NOT NULL DEFAULT 1 COMMENT '1持仓，2平仓，3提现，4充值，5佣金',
  `oid` bigint(20) UNSIGNED NOT NULL DEFAULT 0 COMMENT '关联的id号',
  `note` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '事件备注',
  `op_id` int(10) NOT NULL DEFAULT 0 COMMENT '操作人uid号,或管理员id',
  `user_type` tinyint(1) NULL DEFAULT NULL COMMENT '会员类型 0用户 1代理(2)  4代理(1) 2会员单位 5运营中心  6特会 7交易所分部',
  `change_money` decimal(10, 2) NULL DEFAULT NULL COMMENT '变动金额',
  `balance` decimal(10, 2) NOT NULL COMMENT '用户余额剩余',
  `dateline` int(10) NOT NULL DEFAULT 0 COMMENT '操作时间，时间戳格式',
  `tempdate` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 131 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_money_flow
-- ----------------------------
INSERT INTO `wp_money_flow` VALUES (130, 6, 1, 24, '用户购买美元/日元-1M扣除[102]元', 6, 0, 102.00, 330.20, 1736236238, '2025-01-07 15:50:38');

-- ----------------------------
-- Table structure for wp_ms_out_pay
-- ----------------------------
DROP TABLE IF EXISTS `wp_ms_out_pay`;
CREATE TABLE `wp_ms_out_pay`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `out_trade` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `uid` int(11) NULL DEFAULT NULL,
  `money` double(11, 2) NULL DEFAULT NULL,
  `stats` int(1) NULL DEFAULT 0,
  `time` int(11) NULL DEFAULT NULL,
  `bankan` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `bankcn` int(64) NULL DEFAULT NULL,
  `brancnbn` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `message` text CHARACTER SET utf8 COLLATE utf8_bin NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_ms_out_pay
-- ----------------------------

-- ----------------------------
-- Table structure for wp_newsclass
-- ----------------------------
DROP TABLE IF EXISTS `wp_newsclass`;
CREATE TABLE `wp_newsclass`  (
  `fid` int(11) NOT NULL AUTO_INCREMENT,
  `fclass` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `type` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '分类类型，0系统分类，1默认-普通分类',
  PRIMARY KEY (`fid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_newsclass
-- ----------------------------
INSERT INTO `wp_newsclass` VALUES (5, '公告栏目', 0);

-- ----------------------------
-- Table structure for wp_newsinfo
-- ----------------------------
DROP TABLE IF EXISTS `wp_newsinfo`;
CREATE TABLE `wp_newsinfo`  (
  `nid` int(11) NOT NULL AUTO_INCREMENT,
  `ntitle` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '标题',
  `ncontent` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '内容',
  `ncover` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '缩略图',
  `ncategory` int(11) NULL DEFAULT NULL COMMENT '新闻分类id',
  `ntime` int(20) NULL DEFAULT NULL COMMENT '发布时间',
  PRIMARY KEY (`nid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 13 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_newsinfo
-- ----------------------------
INSERT INTO `wp_newsinfo` VALUES (1, '公告标题', '2017-01-17/587db047830c8.jpg时代大厦', '2017-01-17/587db047830c8.jpg', 4, 1484582400);
INSERT INTO `wp_newsinfo` VALUES (5, '测试公告', '测试公告', '2017-03-07/58be524ba0699.png', 4, 1488816000);

-- ----------------------------
-- Table structure for wp_operate
-- ----------------------------
DROP TABLE IF EXISTS `wp_operate`;
CREATE TABLE `wp_operate`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NULL DEFAULT NULL,
  `oid` int(11) NULL DEFAULT NULL COMMENT '上级id',
  `addmoney` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ratio` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `unit_id` int(11) NULL DEFAULT NULL COMMENT '所属会员单位ID',
  `leaguer_id` int(11) NULL DEFAULT NULL COMMENT '所属普会ID',
  `agent_id` int(11) NULL DEFAULT NULL COMMENT '所属经纪人ID',
  `operate_id` int(11) NULL DEFAULT NULL COMMENT '运营中心id',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `oid`(`oid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 715 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_operate
-- ----------------------------
INSERT INTO `wp_operate` VALUES (697, 2889, 285, '1', '0.5', 2409, 2413, 2414, 2408);
INSERT INTO `wp_operate` VALUES (698, 2889, 2409, '50', '0.5', 2409, 2413, 2414, 2408);
INSERT INTO `wp_operate` VALUES (699, 2889, 2413, '25', '0.5', 2409, 2413, 2414, 2408);
INSERT INTO `wp_operate` VALUES (700, 2889, 285, '1', '0.5', 2409, 2413, 2414, 2408);
INSERT INTO `wp_operate` VALUES (701, 2889, 2409, '50', '0.5', 2409, 2413, 2414, 2408);
INSERT INTO `wp_operate` VALUES (702, 2889, 2413, '25', '0.5', 2409, 2413, 2414, 2408);
INSERT INTO `wp_operate` VALUES (703, 2889, 285, '1', '0.5', 2409, 2413, 2414, 2408);
INSERT INTO `wp_operate` VALUES (704, 2889, 2409, '50', '0.5', 2409, 2413, 2414, 2408);
INSERT INTO `wp_operate` VALUES (705, 2889, 2413, '25', '0.5', 2409, 2413, 2414, 2408);
INSERT INTO `wp_operate` VALUES (706, 2889, 285, '1', '0.5', 2409, 2413, 2414, 2408);
INSERT INTO `wp_operate` VALUES (707, 2889, 2409, '50', '0.5', 2409, 2413, 2414, 2408);
INSERT INTO `wp_operate` VALUES (708, 2889, 2413, '25', '0.5', 2409, 2413, 2414, 2408);
INSERT INTO `wp_operate` VALUES (709, 3471, 285, '1', '0.5', 2409, 2413, 2936, 2408);
INSERT INTO `wp_operate` VALUES (710, 3471, 2409, '5', '0.05', 2409, 2413, 2936, 2408);
INSERT INTO `wp_operate` VALUES (711, 3471, 2413, '0.1', '0.02', 2409, 2413, 2936, 2408);
INSERT INTO `wp_operate` VALUES (712, 3471, 285, '0.04', '0.02', 2409, 2413, 2936, 2408);
INSERT INTO `wp_operate` VALUES (713, 3471, 2409, '5', '0.05', 2409, 2413, 2936, 2408);
INSERT INTO `wp_operate` VALUES (714, 3471, 2413, '0.1', '0.02', 2409, 2413, 2936, 2408);

-- ----------------------------
-- Table structure for wp_option_classify
-- ----------------------------
DROP TABLE IF EXISTS `wp_option_classify`;
CREATE TABLE `wp_option_classify`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '分类名称',
  `create_time` int(12) NULL DEFAULT NULL COMMENT '添加时间',
  `temptime` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_option_classify
-- ----------------------------
INSERT INTO `wp_option_classify` VALUES (1, '按需', 1480312861, '2017-07-03 15:05:12');
INSERT INTO `wp_option_classify` VALUES (2, '多空', 1480312875, '2017-07-03 15:05:15');

-- ----------------------------
-- Table structure for wp_option_deal_time
-- ----------------------------
DROP TABLE IF EXISTS `wp_option_deal_time`;
CREATE TABLE `wp_option_deal_time`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `option_id` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '商品id，对应option表id',
  `deal_time_start` char(4) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0000' COMMENT '交易开始时间',
  `deal_time_end` char(4) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0000' COMMENT '交易结束时间',
  `deal_time_type` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '当前时间段，是否隔天默认1，不隔天，2隔天',
  `temptime` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `option_id`(`option_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 308 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_option_deal_time
-- ----------------------------
INSERT INTO `wp_option_deal_time` VALUES (206, 4, '0000', '2359', 1, '2017-07-12 17:06:27');
INSERT INTO `wp_option_deal_time` VALUES (207, 5, '0000', '2359', 1, '2017-07-12 17:06:41');
INSERT INTO `wp_option_deal_time` VALUES (209, 6, '0000', '2359', 1, '2017-07-12 17:06:53');
INSERT INTO `wp_option_deal_time` VALUES (210, 12, '0000', '2359', 1, '2017-07-12 17:07:03');
INSERT INTO `wp_option_deal_time` VALUES (211, 13, '0000', '2359', 1, '2017-07-12 17:07:13');
INSERT INTO `wp_option_deal_time` VALUES (212, 1, '0000', '2359', 1, '2017-07-12 17:07:22');
INSERT INTO `wp_option_deal_time` VALUES (213, 2, '0000', '2359', 1, '2017-07-12 17:07:32');
INSERT INTO `wp_option_deal_time` VALUES (214, 11, '0000', '2359', 1, '2017-07-12 17:07:47');
INSERT INTO `wp_option_deal_time` VALUES (215, 7, '0000', '2359', 1, '2017-07-12 17:08:12');
INSERT INTO `wp_option_deal_time` VALUES (216, 3, '0000', '2359', 1, '2017-07-12 17:08:33');
INSERT INTO `wp_option_deal_time` VALUES (217, 10, '0000', '2359', 1, '2017-07-12 17:08:51');
INSERT INTO `wp_option_deal_time` VALUES (218, 8, '0000', '2359', 1, '2017-07-12 17:09:19');
INSERT INTO `wp_option_deal_time` VALUES (219, 9, '0000', '2359', 1, '2017-07-12 17:09:33');
INSERT INTO `wp_option_deal_time` VALUES (220, 14, '0000', '2359', 1, '2017-07-12 17:09:49');
INSERT INTO `wp_option_deal_time` VALUES (222, 15, '0000', '2359', 1, '2017-07-12 17:10:05');
INSERT INTO `wp_option_deal_time` VALUES (223, 26, '0000', '2359', 1, '2017-07-17 14:20:04');
INSERT INTO `wp_option_deal_time` VALUES (224, 27, '0000', '2359', 1, '2017-07-17 14:20:20');
INSERT INTO `wp_option_deal_time` VALUES (225, 28, '0000', '2359', 1, '2017-07-17 14:20:27');
INSERT INTO `wp_option_deal_time` VALUES (226, 29, '0000', '2359', 1, '2017-07-17 14:20:34');
INSERT INTO `wp_option_deal_time` VALUES (227, 30, '0000', '2359', 1, '2017-07-17 14:20:44');
INSERT INTO `wp_option_deal_time` VALUES (228, 21, '0000', '2359', 1, '2017-07-17 14:20:51');
INSERT INTO `wp_option_deal_time` VALUES (229, 22, '0000', '2359', 1, '2017-07-17 14:21:01');
INSERT INTO `wp_option_deal_time` VALUES (230, 23, '0000', '2359', 1, '2017-07-17 14:21:10');
INSERT INTO `wp_option_deal_time` VALUES (231, 24, '0000', '2359', 1, '2017-07-17 14:21:18');
INSERT INTO `wp_option_deal_time` VALUES (232, 25, '0000', '2359', 1, '2017-07-17 14:21:27');
INSERT INTO `wp_option_deal_time` VALUES (233, 16, '0000', '2359', 1, '2017-07-17 14:21:35');
INSERT INTO `wp_option_deal_time` VALUES (234, 17, '0000', '2359', 1, '2017-07-17 14:21:48');
INSERT INTO `wp_option_deal_time` VALUES (235, 18, '0000', '2359', 1, '2017-07-17 14:21:56');
INSERT INTO `wp_option_deal_time` VALUES (236, 19, '0000', '2359', 1, '2017-07-17 14:22:02');
INSERT INTO `wp_option_deal_time` VALUES (237, 20, '0000', '2359', 1, '2017-07-17 14:22:08');
INSERT INTO `wp_option_deal_time` VALUES (238, 31, '0000', '2359', 1, '2017-07-17 14:20:04');
INSERT INTO `wp_option_deal_time` VALUES (239, 32, '0000', '2359', 1, '2017-07-17 14:20:20');
INSERT INTO `wp_option_deal_time` VALUES (240, 33, '0000', '2359', 1, '2017-07-17 14:20:27');
INSERT INTO `wp_option_deal_time` VALUES (241, 34, '0000', '2359', 1, '2017-07-17 14:20:34');
INSERT INTO `wp_option_deal_time` VALUES (242, 35, '0000', '2359', 1, '2017-07-17 14:20:44');
INSERT INTO `wp_option_deal_time` VALUES (243, 36, '0000', '2359', 1, '2017-07-17 14:20:04');
INSERT INTO `wp_option_deal_time` VALUES (244, 37, '0000', '2359', 1, '2017-07-17 14:20:20');
INSERT INTO `wp_option_deal_time` VALUES (245, 38, '0000', '2359', 1, '2017-07-17 14:20:27');
INSERT INTO `wp_option_deal_time` VALUES (246, 39, '0000', '2359', 1, '2017-07-17 14:20:34');
INSERT INTO `wp_option_deal_time` VALUES (247, 40, '0000', '2359', 1, '2017-07-17 14:20:44');
INSERT INTO `wp_option_deal_time` VALUES (248, 41, '0600', '0500', 2, '2025-01-07 14:30:20');
INSERT INTO `wp_option_deal_time` VALUES (249, 42, '0600', '0500', 2, '2025-01-07 14:30:38');
INSERT INTO `wp_option_deal_time` VALUES (250, 43, '0600', '0500', 2, '2025-01-07 14:30:38');
INSERT INTO `wp_option_deal_time` VALUES (251, 44, '0600', '0500', 2, '2025-01-07 14:30:38');
INSERT INTO `wp_option_deal_time` VALUES (252, 45, '0600', '0500', 2, '2025-01-07 14:30:38');
INSERT INTO `wp_option_deal_time` VALUES (253, 46, '0600', '0500', 2, '2025-01-07 14:30:38');
INSERT INTO `wp_option_deal_time` VALUES (254, 47, '0600', '0500', 2, '2025-01-07 14:30:38');
INSERT INTO `wp_option_deal_time` VALUES (255, 48, '0600', '0500', 2, '2025-01-07 14:30:38');
INSERT INTO `wp_option_deal_time` VALUES (256, 49, '0600', '0500', 2, '2025-01-07 14:30:38');
INSERT INTO `wp_option_deal_time` VALUES (257, 50, '0600', '0500', 2, '2025-01-07 14:30:38');
INSERT INTO `wp_option_deal_time` VALUES (258, 51, '0915', '1200', 1, '2025-01-07 14:33:42');
INSERT INTO `wp_option_deal_time` VALUES (259, 51, '1300', '1630', 1, '2025-01-07 14:33:45');
INSERT INTO `wp_option_deal_time` VALUES (260, 51, '1715', '0300', 2, '2025-01-07 14:33:48');
INSERT INTO `wp_option_deal_time` VALUES (261, 52, '0915', '1200', 1, '2025-01-07 14:33:42');
INSERT INTO `wp_option_deal_time` VALUES (262, 52, '1300', '1630', 1, '2025-01-07 14:33:45');
INSERT INTO `wp_option_deal_time` VALUES (263, 52, '1715', '0300', 2, '2025-01-07 14:33:48');
INSERT INTO `wp_option_deal_time` VALUES (264, 53, '0915', '1200', 1, '2025-01-07 14:33:42');
INSERT INTO `wp_option_deal_time` VALUES (265, 53, '1300', '1630', 1, '2025-01-07 14:33:45');
INSERT INTO `wp_option_deal_time` VALUES (266, 53, '1715', '0300', 2, '2025-01-07 14:33:48');
INSERT INTO `wp_option_deal_time` VALUES (267, 54, '0915', '1200', 1, '2025-01-07 14:33:42');
INSERT INTO `wp_option_deal_time` VALUES (268, 54, '1300', '1630', 1, '2025-01-07 14:33:45');
INSERT INTO `wp_option_deal_time` VALUES (269, 54, '1715', '0300', 2, '2025-01-07 14:33:48');
INSERT INTO `wp_option_deal_time` VALUES (270, 55, '0915', '1200', 1, '2025-01-07 14:33:42');
INSERT INTO `wp_option_deal_time` VALUES (271, 55, '1300', '1630', 1, '2025-01-07 14:33:45');
INSERT INTO `wp_option_deal_time` VALUES (272, 55, '1715', '0300', 2, '2025-01-07 14:33:48');
INSERT INTO `wp_option_deal_time` VALUES (273, 56, '0915', '1200', 1, '2025-01-07 14:33:42');
INSERT INTO `wp_option_deal_time` VALUES (274, 56, '1300', '1630', 1, '2025-01-07 14:33:45');
INSERT INTO `wp_option_deal_time` VALUES (275, 56, '1715', '0300', 2, '2025-01-07 14:33:48');
INSERT INTO `wp_option_deal_time` VALUES (276, 57, '0915', '1200', 1, '2025-01-07 14:33:42');
INSERT INTO `wp_option_deal_time` VALUES (277, 57, '1300', '1630', 1, '2025-01-07 14:33:45');
INSERT INTO `wp_option_deal_time` VALUES (278, 57, '1715', '0300', 2, '2025-01-07 14:33:48');
INSERT INTO `wp_option_deal_time` VALUES (279, 58, '0915', '1200', 1, '2025-01-07 14:33:42');
INSERT INTO `wp_option_deal_time` VALUES (280, 58, '1300', '1630', 1, '2025-01-07 14:33:45');
INSERT INTO `wp_option_deal_time` VALUES (281, 58, '1715', '0300', 2, '2025-01-07 14:33:48');
INSERT INTO `wp_option_deal_time` VALUES (282, 59, '0915', '1200', 1, '2025-01-07 14:33:42');
INSERT INTO `wp_option_deal_time` VALUES (283, 59, '1300', '1630', 1, '2025-01-07 14:33:45');
INSERT INTO `wp_option_deal_time` VALUES (284, 59, '1715', '0300', 2, '2025-01-07 14:33:48');
INSERT INTO `wp_option_deal_time` VALUES (285, 60, '0915', '1200', 1, '2025-01-07 14:33:42');
INSERT INTO `wp_option_deal_time` VALUES (286, 60, '1300', '1630', 1, '2025-01-07 14:33:45');
INSERT INTO `wp_option_deal_time` VALUES (287, 60, '1715', '0300', 2, '2025-01-07 14:33:48');
INSERT INTO `wp_option_deal_time` VALUES (288, 61, '0600', '0500', 2, '2025-01-07 14:30:38');
INSERT INTO `wp_option_deal_time` VALUES (289, 62, '0600', '0500', 2, '2025-01-07 14:30:38');
INSERT INTO `wp_option_deal_time` VALUES (290, 63, '0600', '0500', 2, '2025-01-07 14:30:38');
INSERT INTO `wp_option_deal_time` VALUES (291, 64, '0600', '0500', 2, '2025-01-07 14:30:38');
INSERT INTO `wp_option_deal_time` VALUES (292, 65, '0600', '0500', 2, '2025-01-07 14:30:38');
INSERT INTO `wp_option_deal_time` VALUES (293, 66, '0600', '0500', 2, '2025-01-07 14:30:38');
INSERT INTO `wp_option_deal_time` VALUES (294, 67, '0600', '0500', 2, '2025-01-07 14:30:38');
INSERT INTO `wp_option_deal_time` VALUES (295, 68, '0600', '0500', 2, '2025-01-07 14:30:38');
INSERT INTO `wp_option_deal_time` VALUES (296, 69, '0600', '0500', 2, '2025-01-07 14:30:38');
INSERT INTO `wp_option_deal_time` VALUES (297, 70, '0600', '0500', 2, '2025-01-07 14:30:38');
INSERT INTO `wp_option_deal_time` VALUES (298, 71, '0600', '0500', 2, '2025-01-07 14:30:38');
INSERT INTO `wp_option_deal_time` VALUES (299, 72, '0600', '0500', 2, '2025-01-07 14:30:38');
INSERT INTO `wp_option_deal_time` VALUES (300, 73, '0600', '0500', 2, '2025-01-07 14:30:38');
INSERT INTO `wp_option_deal_time` VALUES (301, 74, '0600', '0500', 2, '2025-01-07 14:30:38');
INSERT INTO `wp_option_deal_time` VALUES (302, 75, '0600', '0500', 2, '2025-01-07 14:30:38');
INSERT INTO `wp_option_deal_time` VALUES (303, 76, '0815', '0400', 2, '2025-01-07 14:30:38');
INSERT INTO `wp_option_deal_time` VALUES (304, 77, '0815', '0400', 2, '2025-01-07 14:30:38');
INSERT INTO `wp_option_deal_time` VALUES (305, 78, '0815', '0400', 2, '2025-01-07 14:30:38');
INSERT INTO `wp_option_deal_time` VALUES (306, 79, '0815', '0400', 2, '2025-01-07 14:30:38');
INSERT INTO `wp_option_deal_time` VALUES (307, 80, '0815', '0400', 2, '2025-01-07 14:30:38');

-- ----------------------------
-- Table structure for wp_order
-- ----------------------------
DROP TABLE IF EXISTS `wp_order`;
CREATE TABLE `wp_order`  (
  `oid` int(20) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '用户ID',
  `pid` int(11) NOT NULL COMMENT '产品ID',
  `ostyle` int(12) NOT NULL DEFAULT 0 COMMENT '0涨 1跌，',
  `buytime` int(20) NULL DEFAULT NULL COMMENT '建仓',
  `onumber` int(20) NULL DEFAULT NULL COMMENT '手数',
  `selltime` datetime(0) NULL DEFAULT '0000-00-00 00:00:00' COMMENT '平仓',
  `ostaus` int(11) NULL DEFAULT NULL COMMENT '0交易，1平仓',
  `buyprice` decimal(10, 3) NULL DEFAULT NULL COMMENT '入仓价 下单点位',
  `sellprice` decimal(10, 3) NULL DEFAULT NULL COMMENT '平仓价',
  `endprofit` int(11) NULL DEFAULT 0 COMMENT '止盈',
  `endloss` int(11) NULL DEFAULT 0 COMMENT '止亏',
  `fee` double(11, 1) NULL DEFAULT NULL COMMENT '手续费',
  `eid` int(11) NOT NULL COMMENT '体验卷状态',
  `orderno` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单编号',
  `ptitle` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '商品名称',
  `commission` double(255, 1) NULL DEFAULT 0.0 COMMENT '佣金',
  `ploss` double(255, 1) NULL DEFAULT 0.0 COMMENT '盈亏',
  `display` int(11) NULL DEFAULT 0 COMMENT '0,可查询，1不可查询',
  `is_hide` int(11) NOT NULL,
  `gefee` double(11, 2) NULL DEFAULT NULL COMMENT '隔夜手续费',
  `overday` int(11) NULL DEFAULT NULL COMMENT '过期天数',
  `finirm_time` datetime(0) NULL DEFAULT NULL COMMENT '结束时间',
  `is_settle` tinyint(1) NULL DEFAULT NULL COMMENT '0--未结算  1--已结算',
  `settle_time` datetime(0) NULL DEFAULT NULL COMMENT '结算时间',
  `is_win` tinyint(1) NULL DEFAULT NULL COMMENT '盈利情况（0-亏损  1--盈利 2--平局）',
  `minute` int(11) NULL DEFAULT NULL COMMENT '清仓时间,等待分钟/点',
  `odds` float NULL DEFAULT NULL COMMENT '收益率',
  `order_type` int(1) NULL DEFAULT NULL COMMENT '时间下单：2；点位下单：1',
  `trade_time` datetime(0) NULL DEFAULT NULL COMMENT '下单时间',
  `trade_amount` decimal(10, 0) NULL DEFAULT NULL COMMENT '交易金额',
  `data_now_id` int(5) NULL DEFAULT NULL COMMENT '产品表ID ',
  `profit` decimal(10, 2) NULL DEFAULT NULL COMMENT '结算金额',
  `sell_time` int(24) NULL DEFAULT NULL,
  `th_uid` int(11) NULL DEFAULT NULL COMMENT '特会uid',
  PRIMARY KEY (`oid`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `ostyle`(`ostyle`) USING BTREE,
  INDEX `is_settle`(`is_settle`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 25 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_order
-- ----------------------------
INSERT INTO `wp_order` VALUES (24, 6, 0, 1, 1736236238, NULL, '0000-00-00 00:00:00', 0, 157.584, NULL, 0, 0, 2.0, 0, '17362362386', '美元/日元-1M', 330.2, 0.0, 0, 0, NULL, NULL, '2025-01-07 15:51:38', 0, NULL, NULL, 1, 0.82, 2, '2025-01-07 15:50:38', 100, 1872, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for wp_productinfo
-- ----------------------------
DROP TABLE IF EXISTS `wp_productinfo`;
CREATE TABLE `wp_productinfo`  (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(1) NULL DEFAULT NULL,
  `ptitle` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '标题',
  `protle` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '产品类型名',
  `feeprice` double NULL DEFAULT NULL,
  `maxhands` int(100) NULL DEFAULT 0 COMMENT '最大持仓手数',
  `maxcounts` int(100) NULL DEFAULT 0 COMMENT '每日最大建仓次数',
  `odds` double NULL DEFAULT NULL COMMENT '收益率',
  `minute` int(11) NULL DEFAULT NULL COMMENT '订单时长',
  PRIMARY KEY (`pid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 81 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_productinfo
-- ----------------------------
INSERT INTO `wp_productinfo` VALUES (1, 1870, '欧元/美元5M', '欧元/美元', 2, 50, 0, 0.81, 5);
INSERT INTO `wp_productinfo` VALUES (2, 1870, '欧元/美元1M', '欧元/美元', 2, 50, 0, 0.75, 1);
INSERT INTO `wp_productinfo` VALUES (3, 1870, '欧元/美元3M', '欧元/美元', 2, 30, 0, 0.78, 3);
INSERT INTO `wp_productinfo` VALUES (4, 1871, '澳元/美元5M', '澳元/美元', 2, 50, 0, 0.8, 5);
INSERT INTO `wp_productinfo` VALUES (5, 1871, '澳元/美元30M', '澳元/美元', 2, 50, 0, 0.85, 30);
INSERT INTO `wp_productinfo` VALUES (6, 1871, '澳元/美元15M', '澳元/美元', 2, 30, 0, 0.82, 15);
INSERT INTO `wp_productinfo` VALUES (7, 1869, '英镑/美元1M', '英镑/美元', 2, 50, 0, 0.75, 1);
INSERT INTO `wp_productinfo` VALUES (8, 1869, '英镑/美元3M', '英镑/美元', 2, 30, 0, 0.78, 3);
INSERT INTO `wp_productinfo` VALUES (9, 1869, '英镑/美元5M', '英镑/美元', 2, 50, 0, 0.8, 5);
INSERT INTO `wp_productinfo` VALUES (10, 1870, '欧元/美元30M', '欧元/美元', 2, 50, 0, 0.85, 30);
INSERT INTO `wp_productinfo` VALUES (12, 1871, '澳元/美元1M', '澳元/美元', 2, 50, 0, 0.75, 1);
INSERT INTO `wp_productinfo` VALUES (13, 1871, '澳元/美元3M', '澳元/美元', 2, 50, 0, 0.77, 3);
INSERT INTO `wp_productinfo` VALUES (14, 1869, '英镑/美元15M', '英镑/美元', 2, 50, 0, 0.82, 15);
INSERT INTO `wp_productinfo` VALUES (15, 1869, '英镑/美元30M', '英镑/美元', 2, 50, 0, 0.85, 30);
INSERT INTO `wp_productinfo` VALUES (11, 1870, '欧元/美元15M', '欧元/美元', 2, 50, 0, 0.82, 15);
INSERT INTO `wp_productinfo` VALUES (16, 1872, '美元/日元1M', '美元/日元', 2, 50, 0, 0.82, 1);
INSERT INTO `wp_productinfo` VALUES (17, 1872, '美元/日元3M', '美元/日元', 2, 50, 0, 0.82, 3);
INSERT INTO `wp_productinfo` VALUES (18, 1872, '美元/日元5M', '美元/日元', 2, 50, 0, 0.82, 5);
INSERT INTO `wp_productinfo` VALUES (19, 1872, '美元/日元15M', '美元/日元', 2, 50, 0, 0.82, 15);
INSERT INTO `wp_productinfo` VALUES (20, 1872, '美元/日元30M', '美元/日元', 2, 50, 0, 0.82, 30);
INSERT INTO `wp_productinfo` VALUES (21, 1873, '欧元/日元1M', '欧元/日元', 2, 50, 0, 0.82, 1);
INSERT INTO `wp_productinfo` VALUES (22, 1873, '欧元/日元3M', '欧元/日元', 2, 50, 0, 0.82, 3);
INSERT INTO `wp_productinfo` VALUES (23, 1873, '欧元/日元5M', '欧元/日元', 2, 50, 0, 0.82, 5);
INSERT INTO `wp_productinfo` VALUES (24, 1873, '欧元/日元15M', '欧元/日元', 2, 50, 0, 0.82, 15);
INSERT INTO `wp_productinfo` VALUES (25, 1873, '欧元/日元30M', '欧元/日元', 2, 50, 0, 0.82, 30);
INSERT INTO `wp_productinfo` VALUES (26, 1874, '比特币1M', '比特币', 2, 50, 0, 0.82, 1);
INSERT INTO `wp_productinfo` VALUES (27, 1874, '比特币3M', '比特币', 2, 50, 0, 0.82, 3);
INSERT INTO `wp_productinfo` VALUES (28, 1874, '比特币5M', '比特币', 2, 50, 0, 0.82, 5);
INSERT INTO `wp_productinfo` VALUES (29, 1874, '比特币15M', '比特币', 2, 50, 0, 0.82, 15);
INSERT INTO `wp_productinfo` VALUES (30, 1874, '比特币30M', '比特币', 2, 50, 0, 0.82, 30);
INSERT INTO `wp_productinfo` VALUES (31, 1875, '以太坊1M', '以太坊', 2, 50, 0, 0.82, 1);
INSERT INTO `wp_productinfo` VALUES (32, 1875, '以太坊3M', '以太坊', 2, 50, 0, 0.82, 3);
INSERT INTO `wp_productinfo` VALUES (33, 1875, '以太坊5M', '以太坊', 2, 50, 0, 0.82, 5);
INSERT INTO `wp_productinfo` VALUES (34, 1875, '以太坊15M', '以太坊', 2, 50, 0, 0.82, 15);
INSERT INTO `wp_productinfo` VALUES (35, 1875, '以太坊30M', '以太坊', 2, 50, 0, 0.82, 30);
INSERT INTO `wp_productinfo` VALUES (36, 1876, '瑞波币1M', '瑞波币', 2, 50, 0, 0.82, 1);
INSERT INTO `wp_productinfo` VALUES (37, 1876, '瑞波币3M', '瑞波币', 2, 50, 0, 0.82, 3);
INSERT INTO `wp_productinfo` VALUES (38, 1876, '瑞波币5M', '瑞波币', 2, 50, 0, 0.82, 5);
INSERT INTO `wp_productinfo` VALUES (39, 1876, '瑞波币15M', '瑞波币', 2, 50, 0, 0.82, 15);
INSERT INTO `wp_productinfo` VALUES (40, 1876, '瑞波币30M', '瑞波币', 2, 50, 0, 0.82, 30);
INSERT INTO `wp_productinfo` VALUES (41, 1877, '伦敦金1M', '伦敦金', 2, 50, 0, 0.82, 1);
INSERT INTO `wp_productinfo` VALUES (42, 1877, '伦敦金3M', '伦敦金', 2, 50, 0, 0.82, 3);
INSERT INTO `wp_productinfo` VALUES (43, 1877, '伦敦金5M', '伦敦金', 2, 50, 0, 0.82, 5);
INSERT INTO `wp_productinfo` VALUES (44, 1877, '伦敦金15M', '伦敦金', 2, 50, 0, 0.82, 15);
INSERT INTO `wp_productinfo` VALUES (45, 1877, '伦敦金30M', '伦敦金', 2, 50, 0, 0.82, 30);
INSERT INTO `wp_productinfo` VALUES (46, 1878, '伦敦银1M', '伦敦银', 2, 50, 0, 0.82, 1);
INSERT INTO `wp_productinfo` VALUES (47, 1878, '伦敦银3M', '伦敦银', 2, 50, 0, 0.82, 3);
INSERT INTO `wp_productinfo` VALUES (48, 1878, '伦敦银5M', '伦敦银', 2, 50, 0, 0.82, 5);
INSERT INTO `wp_productinfo` VALUES (49, 1878, '伦敦银15M', '伦敦银', 2, 50, 0, 0.82, 15);
INSERT INTO `wp_productinfo` VALUES (50, 1878, '伦敦银30M', '伦敦银', 2, 50, 0, 0.82, 30);
INSERT INTO `wp_productinfo` VALUES (51, 1879, '恒指1M', '恒指', 2, 50, 0, 0.82, 1);
INSERT INTO `wp_productinfo` VALUES (52, 1879, '恒指3M', '恒指', 2, 50, 0, 0.82, 3);
INSERT INTO `wp_productinfo` VALUES (53, 1879, '恒指5M', '恒指', 2, 50, 0, 0.82, 5);
INSERT INTO `wp_productinfo` VALUES (54, 1879, '恒指15M', '恒指', 2, 50, 0, 0.82, 15);
INSERT INTO `wp_productinfo` VALUES (55, 1879, '恒指30M', '恒指', 2, 50, 0, 0.82, 30);
INSERT INTO `wp_productinfo` VALUES (56, 1880, '小恒指1M', '小恒指', 2, 50, 0, 0.82, 1);
INSERT INTO `wp_productinfo` VALUES (57, 1880, '小恒指3M', '小恒指', 2, 50, 0, 0.82, 3);
INSERT INTO `wp_productinfo` VALUES (58, 1880, '小恒指5M', '小恒指', 2, 50, 0, 0.82, 5);
INSERT INTO `wp_productinfo` VALUES (59, 1880, '小恒指15M', '小恒指', 2, 50, 0, 0.82, 15);
INSERT INTO `wp_productinfo` VALUES (60, 1880, '小恒指30M', '小恒指', 2, 50, 0, 0.82, 30);
INSERT INTO `wp_productinfo` VALUES (61, 1881, '小纳指1M', '小纳指', 2, 50, 0, 0.82, 1);
INSERT INTO `wp_productinfo` VALUES (62, 1881, '小纳指3M', '小纳指', 2, 50, 0, 0.82, 3);
INSERT INTO `wp_productinfo` VALUES (63, 1881, '小纳指5M', '小纳指', 2, 50, 0, 0.82, 5);
INSERT INTO `wp_productinfo` VALUES (64, 1881, '小纳指15M', '小纳指', 2, 50, 0, 0.82, 15);
INSERT INTO `wp_productinfo` VALUES (65, 1881, '小纳指30M', '小纳指', 2, 50, 0, 0.82, 30);
INSERT INTO `wp_productinfo` VALUES (66, 1882, '小道指1M', '小道指', 2, 50, 0, 0.82, 1);
INSERT INTO `wp_productinfo` VALUES (67, 1882, '小道指3M', '小道指', 2, 50, 0, 0.82, 3);
INSERT INTO `wp_productinfo` VALUES (68, 1882, '小道指5M', '小道指', 2, 50, 0, 0.82, 5);
INSERT INTO `wp_productinfo` VALUES (69, 1882, '小道指15M', '小道指', 2, 50, 0, 0.82, 15);
INSERT INTO `wp_productinfo` VALUES (70, 1882, '小道指30M', '小道指', 2, 50, 0, 0.82, 30);
INSERT INTO `wp_productinfo` VALUES (71, 1883, '小标普1M', '小标普', 2, 50, 0, 0.82, 1);
INSERT INTO `wp_productinfo` VALUES (72, 1883, '小标普3M', '小标普', 2, 50, 0, 0.82, 3);
INSERT INTO `wp_productinfo` VALUES (73, 1883, '小标普5M', '小标普', 2, 50, 0, 0.82, 5);
INSERT INTO `wp_productinfo` VALUES (74, 1883, '小标普15M', '小标普', 2, 50, 0, 0.82, 15);
INSERT INTO `wp_productinfo` VALUES (75, 1883, '小标普30M', '小标普', 2, 50, 0, 0.82, 30);
INSERT INTO `wp_productinfo` VALUES (76, 1884, '德指1M', '德指', 2, 50, 0, 0.82, 1);
INSERT INTO `wp_productinfo` VALUES (77, 1884, '德指3M', '德指', 2, 50, 0, 0.82, 3);
INSERT INTO `wp_productinfo` VALUES (78, 1884, '德指5M', '德指', 2, 50, 0, 0.82, 5);
INSERT INTO `wp_productinfo` VALUES (79, 1884, '德指15M', '德指', 2, 50, 0, 0.82, 15);
INSERT INTO `wp_productinfo` VALUES (80, 1884, '德指30M', '德指', 2, 50, 0, 0.82, 30);

-- ----------------------------
-- Table structure for wp_rebate
-- ----------------------------
DROP TABLE IF EXISTS `wp_rebate`;
CREATE TABLE `wp_rebate`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_id` int(11) NOT NULL COMMENT '会员单位id',
  `rate` decimal(10, 2) NOT NULL COMMENT '佣金比例',
  `type` tinyint(1) NOT NULL DEFAULT 1 COMMENT '层级类型 1：一级 2：二级 3：三级',
  `dateline` int(11) NULL DEFAULT NULL COMMENT '创建时间',
  `tempdate` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `unit_id`(`unit_id`) USING BTREE,
  INDEX `type`(`type`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_rebate
-- ----------------------------
INSERT INTO `wp_rebate` VALUES (1, 3, 10.00, 1, 1500264510, '2017-07-17 12:08:30');
INSERT INTO `wp_rebate` VALUES (2, 3, 5.00, 2, 1500264510, '2017-07-17 12:08:30');
INSERT INTO `wp_rebate` VALUES (3, 3, 2.00, 3, 1500264510, '2017-07-17 12:08:30');

-- ----------------------------
-- Table structure for wp_role
-- ----------------------------
DROP TABLE IF EXISTS `wp_role`;
CREATE TABLE `wp_role`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `name` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '名称',
  `rules` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '权限信息，逗号隔开',
  `status` smallint(4) UNSIGNED NOT NULL DEFAULT 1 COMMENT '状态1正常，0冻结',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '权限组表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_role
-- ----------------------------
INSERT INTO `wp_role` VALUES (1, '超级管理员', '1,2,3,4,5,6,7,10,9,8,11,12,13,14,15,16,17,19,18,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58', 1);
INSERT INTO `wp_role` VALUES (2, '管理员', '2,3,5,7,11,14,17,1,1,4,6,10,13,16', 1);
INSERT INTO `wp_role` VALUES (3, '财务', '1,2', 1);
INSERT INTO `wp_role` VALUES (4, '销售经理', '1,2', 1);

-- ----------------------------
-- Table structure for wp_special_log
-- ----------------------------
DROP TABLE IF EXISTS `wp_special_log`;
CREATE TABLE `wp_special_log`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `unit_id` int(11) UNSIGNED NOT NULL COMMENT '会员单位',
  `note` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '描述',
  `create_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_special_log
-- ----------------------------
INSERT INTO `wp_special_log` VALUES (1, 3, '会员单位资金不足更改为特会对赌模式', 1500364138);
INSERT INTO `wp_special_log` VALUES (2, 3, '会员单位资金充足更改为对赌模式', 1501132730);

-- ----------------------------
-- Table structure for wp_temp_order
-- ----------------------------
DROP TABLE IF EXISTS `wp_temp_order`;
CREATE TABLE `wp_temp_order`  (
  `order_id` int(10) NOT NULL,
  `orderno` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '订单号',
  `code` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '产品代码',
  `status` tinyint(10) NOT NULL DEFAULT 0 COMMENT '0未处理  1已处理',
  UNIQUE INDEX `Unique`(`order_id`, `orderno`) USING BTREE,
  INDEX `status`(`status`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_temp_order
-- ----------------------------

-- ----------------------------
-- Table structure for wp_userinfo
-- ----------------------------
DROP TABLE IF EXISTS `wp_userinfo`;
CREATE TABLE `wp_userinfo`  (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `tempdate` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0),
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `upwd` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `utel` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `utime` int(20) NULL DEFAULT NULL COMMENT '注册时间',
  `agenttype` int(20) NULL DEFAULT 0 COMMENT '0普通客户，1申请经纪人中，2经纪人',
  `otype` int(11) NOT NULL DEFAULT 0 COMMENT '0客户，2会员单位，1经纪人,3超级管理员，4普通会员,5运营中中心,6特会,7交易所分部',
  `ustatus` int(11) NOT NULL DEFAULT 0 COMMENT '0正常状态，1交易冻结状态，2出金冻结',
  `oid` int(11) NULL DEFAULT NULL COMMENT '上线字段',
  `rel_id` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '上级推荐人用户的uid，（普通用户id）',
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '地址',
  `portrait` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '头像',
  `lastlog` int(20) NULL DEFAULT NULL COMMENT '最后登录时间',
  `managername` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '上线用户名',
  `comname` varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '公司名称',
  `comqua` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '公司资质',
  `rebate` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '交易返点',
  `feerebate` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '手续费返点',
  `gefeebate` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '隔夜利息返点',
  `usertype` int(11) NULL DEFAULT 0 COMMENT '0不是微信用户。1是微信用户',
  `wxtype` int(11) NULL DEFAULT 0 COMMENT '1表示微信还没注册，0微信已注册成会员。',
  `openid` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '存微信用户的id',
  `nickname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '用户昵称',
  `vertus` int(1) NULL DEFAULT 1,
  `upip` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `integrals` int(255) NULL DEFAULT 0 COMMENT '积分',
  `days` int(10) NULL DEFAULT 0 COMMENT '第几次积分',
  `assure` varchar(24) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0' COMMENT '保证金',
  `branch_id` int(11) NULL DEFAULT NULL COMMENT '交易所分部id',
  `operate_id` int(11) NULL DEFAULT NULL COMMENT '运营中心',
  `unit_id` int(11) NULL DEFAULT NULL COMMENT '会员单位id',
  `leaguer_id` int(11) NULL DEFAULT NULL COMMENT '代理1id',
  `agent_id` int(11) NULL DEFAULT NULL COMMENT '代理2id',
  `manage` int(5) NOT NULL DEFAULT 0 COMMENT '风控状态：0是正常 1是必输 2是必赢 3自动必输 4 自动必赢',
  `point` int(11) NULL DEFAULT 0 COMMENT '风控的点数',
  `q` int(255) NULL DEFAULT NULL COMMENT '管理员权限',
  `uip` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '用户注册ip',
  `th_uid` int(11) NULL DEFAULT NULL COMMENT '特会uid',
  `th_status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1对赌模式 2特会对赌',
  `bc_config` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '会员单位成为特会条件',
  `linkman` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '联系人',
  PRIMARY KEY (`uid`) USING BTREE,
  UNIQUE INDEX `uid`(`uid`) USING BTREE,
  INDEX `agent_id`(`agent_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_userinfo
-- ----------------------------
INSERT INTO `wp_userinfo` VALUES (1, '2025-01-07 15:35:59', 'admin', 'e10adc3949ba59abbe56e057f20f883e', '123', 1452494000, 0, 3, 0, 0, 0, '中国陕西西安', '1', 1736230340, '1', '科技公司', '回忆瞬间', '1', '', NULL, 0, 0, '', NULL, 1, NULL, 0, 0, '0', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, NULL, NULL, 1, NULL, NULL);
INSERT INTO `wp_userinfo` VALUES (2, '2025-01-07 15:34:57', '001', 'e10adc3949ba59abbe56e057f20f883e', '456', 1500263160, 0, 5, 0, 1, 0, '山东省', NULL, 1736212956, 'admin', '科技公司', '', '', '2', '', 0, 0, '', NULL, 1, 'b0c0595efad542c3a9229cc656321e91', 0, 0, '', NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, 1, NULL, '小张');
INSERT INTO `wp_userinfo` VALUES (3, '2025-01-07 15:34:18', '002', 'e10adc3949ba59abbe56e057f20f883e', '789', 1500263253, 0, 2, 0, 2, 0, '山东省', NULL, 1501143567, 'admin', '科技公司', '', '', '', '', 0, 0, '', NULL, 1, NULL, 0, 0, '', NULL, 2, NULL, NULL, NULL, 0, 0, NULL, NULL, 5, 1, '', NULL);
INSERT INTO `wp_userinfo` VALUES (4, '2025-01-07 15:35:00', '003', 'e10adc3949ba59abbe56e057f20f883e', '222', 1500263392, 0, 4, 0, 3, 0, '山东省', NULL, 1501142335, 'admin', '科技公司', NULL, '', '2', '', 0, 0, '', NULL, 1, NULL, 0, 0, '', NULL, 2, 3, NULL, NULL, 0, 0, NULL, NULL, NULL, 1, NULL, '小李');
INSERT INTO `wp_userinfo` VALUES (5, '2025-01-07 15:34:19', '004', 'e10adc3949ba59abbe56e057f20f883e', '333', 1500263762, 0, 6, 0, 1, 0, '山东省', NULL, 1500359059, 'admin', '科技公司', '123', '', '', '', 0, 0, '', NULL, 1, NULL, 0, 0, '', NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, 1, NULL, NULL);
INSERT INTO `wp_userinfo` VALUES (6, '2025-01-07 15:49:17', '小李', '96e79218965eb72c92a549dd5a330112', '111', 1500264452, 2, 0, 0, 4, 0, NULL, NULL, 1736236157, '003', NULL, NULL, NULL, NULL, NULL, 1, 0, '', '小李', 1, '4c70cd70bfb18145ca33523dbafe4f3a', 10, 0, '0', NULL, 2, 3, 4, NULL, 0, 0, NULL, '', NULL, 1, NULL, NULL);
INSERT INTO `wp_userinfo` VALUES (10, '2025-01-07 15:35:13', '张小五', 'e10adc3949ba59abbe56e057f20f883e', '444', 1501222103, 2, 0, 0, 4, 6, NULL, NULL, 1501222112, '003', NULL, NULL, NULL, NULL, NULL, 1, 0, '', '张小五', 1, '9662a22d2e85af55a4a431e4e20b8599', 10, 0, '0', NULL, 2, 3, 4, NULL, 0, 0, NULL, '', NULL, 1, NULL, NULL);

-- ----------------------------
-- Table structure for wp_userlog
-- ----------------------------
DROP TABLE IF EXISTS `wp_userlog`;
CREATE TABLE `wp_userlog`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `uid` int(11) NOT NULL,
  `info` varchar(55) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '操作信息',
  `type` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0客户登录1管理员登录 2操作',
  `ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `time` int(11) NOT NULL COMMENT '操作时间',
  `otype` int(11) NULL DEFAULT NULL,
  `tempdate` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 80 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_userlog
-- ----------------------------

-- ----------------------------
-- Table structure for wp_webconfig
-- ----------------------------
DROP TABLE IF EXISTS `wp_webconfig`;
CREATE TABLE `wp_webconfig`  (
  `id` int(11) NOT NULL,
  `isopen` int(11) NOT NULL DEFAULT 0 COMMENT '0开启，1关闭',
  `webname` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '网站名称',
  `notice` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '公告',
  `isnotice` int(10) NULL DEFAULT 0 COMMENT '0开启，1关闭',
  `blowratio` int(10) NOT NULL DEFAULT 80 COMMENT '爆仓比例',
  `isovernight` int(1) NOT NULL COMMENT '是否开启隔夜利息1开启2关闭',
  `protocol` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '注册协议',
  `integral` int(5) NULL DEFAULT 10 COMMENT '赠送积分',
  `is_experience` int(11) NULL DEFAULT 1,
  `is_type` int(11) NULL DEFAULT NULL COMMENT '1时间模式2点位模式',
  `warn` int(11) NULL DEFAULT NULL COMMENT '会员单位预警',
  `limit` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '下单最大金额',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_webconfig
-- ----------------------------
INSERT INTO `wp_webconfig` VALUES (1, 1, '微交易系统', '微交易系统', 0, 50, 1, '尊敬的客户：\n本揭示书旨在向客户充分揭示交易风险,并且帮助客户评估和确定自身的风险承受能力。本揭示书披露了交易过程中可能发生的各种风险因素，但是并没有完全包括所有关于交易的风险。鉴于交易风险的存在，在签订本协议及进行交易前，客户应该仔细阅读本风险揭示书，必须确保已理解有关交易的性质、规则；并依据自身的交易经验、目标、财务状况、承担风险的能力等自行决定是否参与此交易。\n对于本揭示书有不理解或不清晰的地方应该及时咨询相关机构，对揭示书不存在异议时方可亲笔签字或盖章以示确认。\n一、温馨提示\n（一）交易所分销业务具有较高风险性，不适合利用养老基金、债务资金（如银行贷款）等资金开展或参与分销业务。\n（二）交易所分销业务只适合于同时满足以下全部条件的客户：\n1.年满 18 周岁并具有完全民事行为能力的中国公民，或依法在中华人民共和国境内注册成立且合法存续的企业法人或其他经济组织。\n2.能够充分理解有关分销业务的一切风险，并且具有一定的风险承受能力。\n3.因分销业务造成其交易资金部分或全部亏损，仍不会改变或影响其正常生活方式及生产经营状况。\n二、相关的风险揭示\n1.政策风险\n由于国家法律、法规、政策的变化，紧急措施的出台，相关监管部门监管措施的实施，交易所规则制度的修改等原因，均可能会对客户的分销业务产生影响，客户必须承担由此导致的亏损。\n2.价格波动的风险\n在分销业务中，商品价格受多种因素的影响（如相关市场走势、供求关系、政治局势、能源价格、国际经济形势、外汇汇率等），这些因素对商品价格的影响机制非常复杂，客户在实际操作中难以全面把握，因而存在出现分销业务决策失误的可能性，如果不能有效控制风险，则可能遭受较大的亏损，客户必须独自承担由此导致的一切亏损。\n3.交易成本风险\n分销业务过程中，交易所、经纪会员可能会因市场风险的转变而调整费率的风险控制策略，可能会影响到客户交易成本的预算。客户应充分了解并承担由此造成的全部亏损。\n4.技术风险\n此业务通过电子通讯技术和互联网技术来实现。有关通讯服务及软、硬件服务由不同的供应商提供，可能会存在品质和稳定性方面的风险；交易所、经纪会员不能控制电讯信号的强弱，也不能保证网上终端的设备配置或连接的稳定性以及互联网传播和接收的实时性。故由以上通讯或网络故障导致的某些服务中断或延时可能会对客户的交易产生影响。另外，客户的电脑系统有可能被病毒和/或网络黑客攻击，从而使客户的交易决策无法正确和/或及时执行。对于上述不确定因素的出现也存在着一定的风险，有可能会对客户的交易产生影响，客户应该充分了解并承担由此造成的全部亏损。\n5.交易风险\n（1）交易所综合国际商品现货市场价格和国内其他商品现货市场价格以及市场供求关系等，连续发布商品现货价格行情，交易所并不能保证该行情与其他市场保持完全一致。\n（2）客户在交易系统内通过网上终端所提交的市价单一经成交即不可撤销，客户必须接受这种方式可能带来的风险。\n（3）客户使用交易系统指价建仓，但是由于电脑设备运行速度、网络传输速度等原因，可能会导致在行情触及或穿越指定价格时，交易系统不能为客户成交订立合同，交易没有达成。因此，特别提示客户在使用交易系统指价建仓功能时，应充分考虑上述风险。如果客户无法理解或承受上述风险，建议应不要使用该功能进行交易。如果客户坚持使用该功能，将视为客户已经完全理解并愿意承担使用该功能的全部风险以及带来的一切后果。\n（5）交易所、经纪会员及其工作人员不会对客户作出获利保证，并且不会与客户分享收益或共担风险。客户应知晓针对交易所分销业务的任何获利或者不会发生亏损的承诺均为不可能或者没有根据的。\n（6）客户的交易必须是建立在自己的自主决定之上。交易所、经纪会员及其工作人员提供的任何关于市场的分析和信息，仅供客户参考，同时也不构成任何要约或承诺。由此而造成的交易风险由客户自行承担。\n（7）交易所采用准备金第三方存管，根据不同银行存管业务签约及出入金需求，可能需要使用银行密码、交易密码或资金密码，通过他人或他人主体进行准备金第三方存管业务签约、出入金或登录交易系统参与交易、出入金中可能存在密码被盗风险，请审慎选择资金存管银行和签约、出入金方式，并亲自办理。拟通过他人或他人主体协助办理签约、交易、出入金，或通过交易系统办理第三方存管业务签约的客户，将被视为已经完全理解并愿意承担使用该方式的全部风险，并愿意承担由此带来的一切后果。客户应当妥善保管银行密码、交易密码、资金密码，不要把密码提供给他人，办理完相应手续后应立即更改相关密码，以防止密码被盗的相关风险。\n三、特别提示\n（一）客户在参与交易之前务必详尽的了解交易所交易商品的基本知识和相关风险以及交易所有关的规则制度等，以依法合规地从事分销业务。\n（二）交易所为了确保市场“公开、公平、公正”和健康稳定地发展，将采取严格的措施，强化市场监管。客户务必密切的关注交易所、经纪会员的公告、风险提醒等信息，及时了解市场风险状况，做到理性交易，切忌盲目跟风。\n（三）客户在开通交易之前，须完整、如实地提供开户所需要的信息，不得采取弄虚作假等手段规避有关的要求，否则交易所、经纪会员可以拒绝为其开通交易服务。\n（四）本风险揭示书上述风险揭示事项仅为列举性质，未能详尽的列明有关该分销业务的所有风险因素，客户在参与交易之前，还应认真的对其他可能存在的风险因素有所了解和掌握。\n（五）客户应对自身的经济承受能力、风险控制能力、身体及心理承受能力、理解能力做出客观判断，对交易系统作仔细的、全面的研究，审慎地决定是否参与该交易所的交易，合理的配置自己的金融资产。\n\n以上风险揭示书的各项内容和交易所分销业务相关规则制度，本人/ 本单位已认真阅读并完全理解和同意，自愿承担由此造成的风险，以及由此带来的一切可能的亏损。', 12, 1, 3, 5000, '30|5000');

-- ----------------------------
-- Table structure for wp_wechat
-- ----------------------------
DROP TABLE IF EXISTS `wp_wechat`;
CREATE TABLE `wp_wechat`  (
  `wcid` int(11) NOT NULL AUTO_INCREMENT,
  `appid` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'AppID(应用ID)',
  `appsecret` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'AppSecret(应用密钥)',
  `wxname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '公众号名称',
  `wxlogin` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '微信原始账号',
  `wxurl` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'url服务器地址',
  `token` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '令牌',
  `encodingaeskey` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '消息加密解密秘钥',
  `parterid` int(11) NULL DEFAULT NULL COMMENT '微信商户账号',
  `parterkey` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '32位密码',
  PRIMARY KEY (`wcid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = gbk COLLATE = gbk_chinese_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_wechat
-- ----------------------------

-- ----------------------------
-- Table structure for wp_wft_weixin
-- ----------------------------
DROP TABLE IF EXISTS `wp_wft_weixin`;
CREATE TABLE `wp_wft_weixin`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `out_trade` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `stats` int(1) NULL DEFAULT NULL,
  `money` float(11, 2) NULL DEFAULT NULL,
  `uid` int(11) NULL DEFAULT NULL,
  `time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_wft_weixin
-- ----------------------------

-- ----------------------------
-- Table structure for wp_wx_user12
-- ----------------------------
DROP TABLE IF EXISTS `wp_wx_user12`;
CREATE TABLE `wp_wx_user12`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `bpid` int(200) NULL DEFAULT NULL,
  `openid` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `score` int(10) NULL DEFAULT NULL,
  `nickname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sex` int(2) NULL DEFAULT NULL,
  `city` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `province` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `headimgurl` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `privilege` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `unionid` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wp_wx_user12
-- ----------------------------

SET FOREIGN_KEY_CHECKS = 1;
