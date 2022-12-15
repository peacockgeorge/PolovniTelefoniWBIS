/*
 Navicat Premium Data Transfer

 Source Server         : localhost_3306
 Source Server Type    : MySQL
 Source Server Version : 100421
 Source Host           : localhost:3306
 Source Schema         : smartphone_market

 Target Server Type    : MySQL
 Target Server Version : 100421
 File Encoding         : 65001

 Date: 02/12/2021 21:45:57
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;


-- ----------------------------
-- Table structure for ad
-- ----------------------------
CREATE DATABASE IF NOT EXISTS smartphone_market;
USE smartphone_market;
DROP TABLE IF EXISTS `ad`;
CREATE TABLE `ad`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `brand_id` int UNSIGNED NOT NULL,
  `price` decimal(10, 2) UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `user_created_id` int UNSIGNED NOT NULL,
  `user_updated_id` int UNSIGNED NOT NULL,
  `active` tinyint(1) UNSIGNED NOT NULL,
  `expires_at` datetime NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_smartphone_market_ad_brand_id`(`brand_id`) USING BTREE,
  INDEX `fk_smartphone_market_ad_user_created_id`(`user_created_id`) USING BTREE,
  CONSTRAINT `fk_smartphone_market_ad_brand_id` FOREIGN KEY (`brand_id`) REFERENCES `brand` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_smartphone_market_ad_user_created_id` FOREIGN KEY (`user_created_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 39 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ad
-- ----------------------------
INSERT INTO `ad` VALUES (26, 1, 100.00, 'c100', 'extra', 'images/26.jpg', '2021-11-28 21:45:27', '2021-11-28 21:45:27', 34, 34, 1, '2021-12-28 21:45:27');
INSERT INTO `ad` VALUES (28, 1, 500.00, 'redmi note 9', 'omg so good xiaomi best', 'images/28.jpg', '2021-11-28 22:07:22', '2021-11-28 22:07:23', 34, 34, 1, '2021-12-28 22:07:22');
INSERT INTO `ad` VALUES (29, 3, 123.00, 'r400', 'very good', 'images/29.jpg', '2021-11-29 09:47:56', '2021-11-29 09:47:56', 34, 34, 1, '2021-12-29 09:47:56');
INSERT INTO `ad` VALUES (30, 2, 800.00, '123', '123', 'images/30.jpg', '2021-11-29 09:48:39', '2021-11-29 09:48:39', 34, 34, 1, '2021-12-29 09:48:39');
INSERT INTO `ad` VALUES (32, 2, 400.00, 'e200', 'mega cool', 'images/32.jpg', '2021-10-01 11:56:11', '2021-11-29 11:56:19', 34, 34, 1, '2022-01-27 11:56:33');
INSERT INTO `ad` VALUES (36, 2, 200.00, 's200', 'nice', 'images/33.jpg', '2021-08-01 07:57:38', '2021-11-01 07:57:45', 34, 34, 1, '2022-03-19 07:58:07');

-- ----------------------------
-- Table structure for brand
-- ----------------------------
DROP TABLE IF EXISTS `brand`;
CREATE TABLE `brand`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `user_created_id` int UNSIGNED NOT NULL,
  `user_updated_id` int UNSIGNED NOT NULL,
  `active` tinyint(1) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uq_brand_name`(`name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of brand
-- ----------------------------
INSERT INTO `brand` VALUES (1, 'Samsung', '2021-11-14 21:17:59', '2021-11-14 21:18:02', 1, 1, 1);
INSERT INTO `brand` VALUES (2, 'Sony', '2021-11-28 11:34:52', '2021-11-28 11:34:55', 1, 1, 1);
INSERT INTO `brand` VALUES (3, 'Motorola', '2021-11-28 11:35:08', '2021-11-28 11:35:11', 1, 1, 1);

-- ----------------------------
-- Table structure for role
-- ----------------------------
DROP TABLE IF EXISTS `role`;
CREATE TABLE `role`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `user_created_id` int UNSIGNED NOT NULL,
  `user_updated_id` int UNSIGNED NOT NULL,
  `active` tinyint(1) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uq_role_name`(`name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of role
-- ----------------------------
INSERT INTO `role` VALUES (1, 'admin', '2021-11-14 21:15:32', '2021-11-14 21:15:34', 1, 1, 1);
INSERT INTO `role` VALUES (2, 'user', '2021-11-14 21:17:05', '2021-11-14 21:17:09', 1, 1, 1);

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `forename` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `surname` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `phone_number` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `user_created_id` int UNSIGNED NOT NULL,
  `user_updated_id` int UNSIGNED NOT NULL,
  `active` tinyint(1) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uq_user_email`(`email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 49 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (1, 'Nikola', 'Pokimica', 'np@np.com', '123456789', '12412343215231xd3412x', '2021-11-14 21:14:04', '2021-11-14 21:14:08', 1, 1, 1);
INSERT INTO `user` VALUES (8, 'Pera', 'Peric', 'test2@test.com', '+381412412341241', '$2y$10$ZZAOVKwVqo6SqSkM1swnmek4VQGlUVhdtyPVQqeBcdpnCIIBIakfy', '2021-11-14 22:40:41', '2021-11-14 22:40:41', 1, 1, 1);
INSERT INTO `user` VALUES (9, 'Pera', 'Peric', '12312312@adAFDsfsa.com', '123123123123', '$2y$10$5gR6XsdeFUDL.xUr1bA4Puay8AycktTm8S6xJ7cM93iqhPu3Vx7uG', '2021-11-15 14:01:34', '2021-11-15 14:01:34', 1, 1, 1);
INSERT INTO `user` VALUES (10, 'Pera', 'Peric', 'test5@test.com', '+23124121124', '$2y$10$MfS/jxR396vGSe2ky6mYoOIQaBvYJBovjvS2UgkynCQiTeftrDjkm', '2021-11-15 21:21:34', '2021-11-15 21:21:34', 1, 1, 1);
INSERT INTO `user` VALUES (11, 'Pera', 'Peric', 'test6@test.com', '+23124121124', '$2y$10$NDAlmOmnwaqmpluMV4WeSOHbbcPD8kkfLfYFhmPeldaHDjazbASeG', '2021-11-15 21:25:45', '2021-11-15 21:25:45', 1, 1, 1);
INSERT INTO `user` VALUES (12, 'Pera', 'Peric', 'test7@test.com', '+23124121124', '$2y$10$Wk0kvH2M8kLES3akq3LGCO2wpHLR2CWj/NdrDa6pp0pawrvHDAu9m', '2021-11-15 21:28:43', '2021-11-15 21:28:43', 1, 1, 1);
INSERT INTO `user` VALUES (13, 'Pera', 'Peric', 'test8@test.com', '+325312523523', '$2y$10$zS9xC/fnYZZXLsERx2uGveBUkVeBaqqo3mWZ/ctj3YDdQa2l6Qz5q', '2021-11-15 21:32:16', '2021-11-15 21:32:16', 1, 1, 1);
INSERT INTO `user` VALUES (14, 'Pera', 'Peric', 'test9@test.com', '+23124121124', '$2y$10$XlGlOrAXckNB0ySbtbe0xuufKfOv3nY/09OYmb6kv/ZvvWfXO3WAO', '2021-11-15 21:35:40', '2021-11-15 21:35:40', 1, 1, 1);
INSERT INTO `user` VALUES (15, 'Pera', 'Peric', 'test11@test.com', '+23124121124', '$2y$10$/YZnMfPWwJtoXPaytoBAsucSbinKWUGZKQm0YHlyHZ4aUJsoa4pQe', '2021-11-15 21:40:34', '2021-11-15 21:40:34', 1, 1, 1);
INSERT INTO `user` VALUES (16, 'Pera', 'Peric', '12312312@afasfasf.com', '1231231231', '$2y$10$plDhgIdjz8KDK4sW3SAqpuKQ5JFhgfGi0/toLaJKisGFAmAKh1xpC', '2021-11-15 21:40:53', '2021-11-15 21:40:53', 1, 1, 1);
INSERT INTO `user` VALUES (17, 'Pera', 'Peric', 'test10000@test.com', '+3811111111111', '$2y$10$2v.BufKvPNg1rGfV2x40bO6xmScGuejFhZn8fKRbhP3SzlRlIh/yy', '2021-11-15 21:41:16', '2021-11-15 21:41:16', 1, 1, 1);
INSERT INTO `user` VALUES (18, 'Pera', 'Peric', 'test11@assdasda.com', '3252523524', '$2y$10$6aj4wH3PjbXnSuu2zjPnA.yre5qc574e8NpKeu0aPEtQ/B6GePlUW', '2021-11-15 21:43:00', '2021-11-15 21:43:00', 1, 1, 1);
INSERT INTO `user` VALUES (19, 'Pera', 'Peric', 'asdasda@adasdsa.com', '9876543221', '$2y$10$pfOffblIGNXusIKUw.4Gpex5ypahsA/Lx1Ogj8btUfVS5Lf98BVZW', '2021-11-15 21:50:22', '2021-11-15 21:50:22', 1, 1, 1);
INSERT INTO `user` VALUES (20, 'Pera', 'Peric', 'test9000@test.com', '754634564', '$2y$10$SicUQj8vC00aXIS6CvQo0eHObWVuAx2IVLgrF3e051Zqm2VyIBPAq', '2021-11-15 22:23:11', '2021-11-15 22:23:11', 1, 1, 1);
INSERT INTO `user` VALUES (21, 'Pera', 'Peric', 'test33@test.com', '+23124121124', '$2y$10$FSaqG0ZLLla2IGY9RTk1gONkkJqskppOZ5vxrbQb3a0UMIiR2Q1Ly', '2021-11-15 22:39:40', '2021-11-15 22:39:40', 1, 1, 1);
INSERT INTO `user` VALUES (22, 'Pera', 'Peric', 'test300@test.com', '+23124121124', '$2y$10$tCCRbZdvwryLhBZ7PEfGtO2xM/Smg406W2ekgZG7EoxFLaNV7cTY2', '2021-11-17 19:56:32', '2021-11-17 19:56:32', 1, 1, 1);
INSERT INTO `user` VALUES (24, 'Pera', 'Peric', 'test400@test.com', '+23124121124', '$2y$10$ngsoD5mEjzNb7.N.nQTMD.i4qcJ0EN9GOWYyAEbdHi1bcl0ITuMMe', '2021-11-17 19:58:23', '2021-11-17 19:58:23', 1, 1, 1);
INSERT INTO `user` VALUES (25, 'Pera', 'Peric', 'test4001@test.com', '+23124121124', '$2y$10$syd8A8MEoEax3026t9bB2OGJkhV4yG6JW8vvKLM2k1Lf4jfdR8vyS', '2021-11-17 19:59:47', '2021-11-17 19:59:47', 1, 1, 1);
INSERT INTO `user` VALUES (26, 'Pera', 'Peric', 'test40021231@test.com', '+23124121124', '$2y$10$dizZoKjn/5mKRmqMOGlubeiVrfnbjcpNYeOMxQioX0fL3xo65wxDa', '2021-11-17 20:07:57', '2021-11-17 20:07:57', 1, 1, 1);
INSERT INTO `user` VALUES (27, 'Pera', 'Peric', 'test200@test.com', '+3811111111111', '$2y$10$cLD1TdMffzyGS2JIPWNN5OaAlYgd63nu68iwXJy12LvGstrvDdI2W', '2021-11-17 20:09:32', '2021-11-17 20:09:32', 1, 1, 1);
INSERT INTO `user` VALUES (28, 'Pera', 'Peric', 'test201@test.com', '+3811111111111', '$2y$10$AhGTz0mOCHsYs66wYXZtPec1wAWhLbBP/4rK0BnA6TGYTSyhUDLMa', '2021-11-17 20:13:18', '2021-11-17 20:13:18', 1, 1, 1);
INSERT INTO `user` VALUES (29, 'Pera', 'Peric', 'test202@test.com', '+3811111111111', '$2y$10$rLIeomW7boXLqcG2xcj2s.v15G2ArNCVBW/hfpfq8sf7OYmly3Aai', '2021-11-17 20:13:53', '2021-11-17 20:13:53', 1, 1, 1);
INSERT INTO `user` VALUES (30, 'Pera', 'Peric', 'test207@test.com', '+3811111111111', '$2y$10$Om8VQ.9ErAPlQ8sCtcIs9Otk4DCSA0nrNi3kOuqIExx3zkwiOVmOq', '2021-11-17 20:41:32', '2021-11-17 20:41:32', 1, 1, 1);
INSERT INTO `user` VALUES (31, 'Pera', 'Peric', 'test10000@gmail.com', '12312412413251251241', '$2y$10$OT8QDc2ya2YRFUxpW7E/ZOyVWk8EJAKrMF8xlww3Ye6CjzE0sCfue', '2021-11-25 18:24:46', '2021-11-25 18:24:46', 1, 1, 1);
INSERT INTO `user` VALUES (32, 'Pera', 'Peric', 't1@t.com', '1', '$2y$10$Mu7IiyoaDbICOC84eD7b..DzD0PxYQG2bgHQJtMmvdc73CJMdJvc.', '2021-11-25 20:02:49', '2021-11-25 20:02:49', 1, 1, 1);
INSERT INTO `user` VALUES (33, 'Pera', 'Peric', 't2@t.com', '1', '$2y$10$wV9e9wirRTeE.fSVZFZe5ucaaEWXNtMvYwyMqi9NHyZDFa9yoL1NC', '2021-11-25 20:03:43', '2021-11-25 20:03:43', 1, 1, 1);
INSERT INTO `user` VALUES (34, 'Pera', 'Peric', 'test@test.com', '1', '$2y$10$HPSR1DLro2t.yc54EegFUejnnncYqkSY56CNnUqW4EHc.Or3.KHGC', '2021-11-25 20:24:23', '2021-11-25 20:24:23', 1, 1, 1);
INSERT INTO `user` VALUES (36, 'Pera', 'Peric', 'test11000000@test.com', '213123', '$2y$10$1PDEsoMtTfycsFdB.Xy8He54Dlcm6hIv2/5TGRHQ9Vj08wfyLIofe', '2021-11-25 20:52:39', '2021-11-25 20:52:39', 1, 1, 1);
INSERT INTO `user` VALUES (37, 'Pera', 'Peric', 'test20000000@test.com', '', '$2y$10$/ISCPAP.KJImAPSNEbwzsOt25uI8Kyyna1gjbBfAREFgWOtCDvhFu', '2021-11-25 20:53:23', '2021-11-25 20:53:23', 1, 1, 1);
INSERT INTO `user` VALUES (38, 'Pera', 'Peric', 'test34534579374@afgag.vcom', '', '$2y$10$owfPuSfds6tPtEN1CKMmB.54B5tVMr/TWg3eunwm03wKw7LtaT3qK', '2021-11-26 10:29:17', '2021-11-26 10:29:17', 34, 34, 1);
INSERT INTO `user` VALUES (39, 'Pera', 'Peric', 'test@gmail.com', '', '$2y$10$tLUxkU.nWJgKM0g5it37qO6ipLZgSTmx6OaB2Sst0bKVKpDBmAEdG', '2021-11-26 10:29:53', '2021-11-26 10:29:53', 34, 34, 1);
INSERT INTO `user` VALUES (40, 'Pera', 'Peric', 'tttt@tttt.com', '', '$2y$10$MXCzmdwEzEGgo1rYc17xOu4ZqaATwDzgWScjvxmudknntNgr5GJMi', '2021-11-26 10:31:48', '2021-11-26 10:31:48', 34, 34, 1);
INSERT INTO `user` VALUES (41, 'Pera', 'Peric', 'tyzy@gmail.com', '', '$2y$10$/96GMKXRkBD5LjnSF8eOgOevMOYcYvINS/4Bw6JDrO/eXkyxtg.Du', '2021-11-26 11:51:47', '2021-11-26 11:51:47', 1, 1, 1);
INSERT INTO `user` VALUES (43, 'Pera', 'Peric', 'tyzy1@gmail.com', '', '$2y$10$kK13.8trZoR4VXNQuzfGfeFWD556Ygzd.msCVzXxkxvhKNH3fXTGK', '2021-11-26 11:52:15', '2021-11-26 11:52:15', 1, 1, 1);
INSERT INTO `user` VALUES (44, 'Pera', 'Peric', 'egg@egg.com', '', '$2y$10$4yyg3pOUcrCSOL5rc5SxkOJFEN//cyvkD4T7.rSRomyoVqAHlqigS', '2021-11-26 20:11:27', '2021-11-26 20:11:27', 1, 1, 1);
INSERT INTO `user` VALUES (46, 'Pera', 'Peric', 'test1@test.com', '', '$2y$10$TekdADNzGV92Ils2.vHx/O1IJ1a.Y7U0yqZn1HU0RISV1GigQe5HO', '2021-11-28 13:37:40', '2021-11-28 13:37:40', 34, 34, 1);
INSERT INTO `user` VALUES (48, 'Admin', 'Adminic', 'admin@admin.com', '+38106123456', '$2y$10$ZXwr3InGs45NHpZH7fxUtuo.LFvWgjJQQqvnxz0.wqAUsmAzChHbS', '2021-12-02 20:58:13', '2021-12-02 20:58:13', 1, 1, 1);

-- ----------------------------
-- Table structure for users_roles
-- ----------------------------
DROP TABLE IF EXISTS `users_roles`;
CREATE TABLE `users_roles`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int UNSIGNED NOT NULL,
  `role_id` int UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `user_created_id` int UNSIGNED NOT NULL,
  `user_updated_id` int UNSIGNED NOT NULL,
  `active` tinyint(1) UNSIGNED NOT NULL,
  `valid_from` datetime NOT NULL,
  `valid_to` datetime NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_smartphone_market_users_roles_user_id`(`user_id`) USING BTREE,
  INDEX `fk_smartphone_market_users_roles_role_id`(`role_id`) USING BTREE,
  CONSTRAINT `fk_smartphone_market_users_roles_role_id` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_smartphone_market_users_roles_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 38 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users_roles
-- ----------------------------
INSERT INTO `users_roles` VALUES (1, 1, 1, '2021-11-14 21:15:52', '2021-11-14 21:15:56', 1, 1, 1, '2021-11-14 21:59:23', '2027-03-01 21:59:26');
INSERT INTO `users_roles` VALUES (3, 1, 2, '2021-11-14 21:17:28', '2021-11-14 21:17:31', 1, 1, 1, '2021-11-14 21:59:29', '2023-07-01 21:59:31');
INSERT INTO `users_roles` VALUES (5, 8, 2, '2021-11-14 22:40:41', '2021-11-14 22:40:41', 1, 1, 1, '2021-11-14 22:40:41', '2025-01-01 12:00:00');
INSERT INTO `users_roles` VALUES (6, 9, 2, '2021-11-15 14:01:34', '2021-11-15 14:01:34', 1, 1, 1, '2021-11-15 14:01:34', '2025-01-01 12:00:00');
INSERT INTO `users_roles` VALUES (7, 10, 2, '2021-11-15 21:21:34', '2021-11-15 21:21:34', 1, 1, 1, '2021-11-15 21:21:34', '2025-01-01 12:00:00');
INSERT INTO `users_roles` VALUES (8, 11, 2, '2021-11-15 21:25:45', '2021-11-15 21:25:45', 1, 1, 1, '2021-11-15 21:25:45', '2025-01-01 12:00:00');
INSERT INTO `users_roles` VALUES (9, 12, 2, '2021-11-15 21:28:43', '2021-11-15 21:28:43', 1, 1, 1, '2021-11-15 21:28:43', '2025-01-01 12:00:00');
INSERT INTO `users_roles` VALUES (10, 13, 2, '2021-11-15 21:32:16', '2021-11-15 21:32:16', 1, 1, 1, '2021-11-15 21:32:16', '2025-01-01 12:00:00');
INSERT INTO `users_roles` VALUES (11, 14, 2, '2021-11-15 21:35:40', '2021-11-15 21:35:40', 1, 1, 1, '2021-11-15 21:35:40', '2025-01-01 12:00:00');
INSERT INTO `users_roles` VALUES (12, 15, 2, '2021-11-15 21:40:34', '2021-11-15 21:40:34', 1, 1, 1, '2021-11-15 21:40:34', '2025-01-01 12:00:00');
INSERT INTO `users_roles` VALUES (13, 16, 2, '2021-11-15 21:40:53', '2021-11-15 21:40:53', 1, 1, 1, '2021-11-15 21:40:53', '2025-01-01 12:00:00');
INSERT INTO `users_roles` VALUES (14, 17, 2, '2021-11-15 21:41:16', '2021-11-15 21:41:16', 1, 1, 1, '2021-11-15 21:41:16', '2025-01-01 12:00:00');
INSERT INTO `users_roles` VALUES (15, 18, 2, '2021-11-15 21:43:00', '2021-11-15 21:43:00', 1, 1, 1, '2021-11-15 21:43:00', '2025-01-01 12:00:00');
INSERT INTO `users_roles` VALUES (16, 19, 2, '2021-11-15 21:50:22', '2021-11-15 21:50:22', 1, 1, 1, '2021-11-15 21:50:22', '2025-01-01 12:00:00');
INSERT INTO `users_roles` VALUES (17, 20, 2, '2021-11-15 22:23:11', '2021-11-15 22:23:11', 1, 1, 1, '2021-11-15 22:23:11', '2025-01-01 12:00:00');
INSERT INTO `users_roles` VALUES (18, 21, 2, '2021-11-15 22:39:40', '2021-11-15 22:39:40', 1, 1, 1, '2021-11-15 22:39:40', '2025-01-01 12:00:00');
INSERT INTO `users_roles` VALUES (19, 25, 2, '2021-11-17 19:59:47', '2021-11-17 19:59:47', 1, 1, 1, '2021-11-17 19:59:47', '2025-01-01 12:00:00');
INSERT INTO `users_roles` VALUES (20, 26, 2, '2021-11-17 20:07:57', '2021-11-17 20:07:57', 1, 1, 1, '2021-11-17 20:07:57', '2025-01-01 12:00:00');
INSERT INTO `users_roles` VALUES (21, 27, 2, '2021-11-17 20:09:32', '2021-11-17 20:09:32', 1, 1, 1, '2021-11-17 20:09:32', '2025-01-01 12:00:00');
INSERT INTO `users_roles` VALUES (22, 28, 2, '2021-11-17 20:13:18', '2021-11-17 20:13:18', 1, 1, 1, '2021-11-17 20:13:18', '2025-01-01 12:00:00');
INSERT INTO `users_roles` VALUES (23, 29, 2, '2021-11-17 20:13:53', '2021-11-17 20:13:53', 1, 1, 1, '2021-11-17 20:13:53', '2025-01-01 12:00:00');
INSERT INTO `users_roles` VALUES (24, 30, 2, '2021-11-17 20:41:32', '2021-11-17 20:41:32', 1, 1, 1, '2021-11-17 20:41:32', '2025-01-01 12:00:00');
INSERT INTO `users_roles` VALUES (25, 32, 2, '2021-11-25 20:02:49', '2021-11-25 20:02:49', 1, 1, 1, '2021-11-25 20:02:49', '2025-01-01 12:00:00');
INSERT INTO `users_roles` VALUES (26, 33, 2, '2021-11-25 20:03:43', '2021-11-25 20:03:43', 1, 1, 1, '2021-11-25 20:03:43', '2025-01-01 12:00:00');
INSERT INTO `users_roles` VALUES (27, 34, 2, '2021-11-25 20:24:23', '2021-11-25 20:24:23', 1, 1, 1, '2021-11-25 20:24:23', '2025-01-01 12:00:00');
INSERT INTO `users_roles` VALUES (28, 37, 2, '2021-11-25 20:53:23', '2021-11-25 20:53:23', 1, 1, 1, '2021-11-25 20:53:23', '2025-01-01 12:00:00');
INSERT INTO `users_roles` VALUES (29, 38, 2, '2021-11-26 10:29:17', '2021-11-26 10:29:17', 1, 1, 1, '2021-11-26 10:29:17', '2025-01-01 12:00:00');
INSERT INTO `users_roles` VALUES (30, 39, 2, '2021-11-26 10:29:53', '2021-11-26 10:29:53', 1, 1, 1, '2021-11-26 10:29:53', '2025-01-01 12:00:00');
INSERT INTO `users_roles` VALUES (31, 40, 2, '2021-11-26 10:31:48', '2021-11-26 10:31:48', 1, 1, 1, '2021-11-26 10:31:48', '2025-01-01 12:00:00');
INSERT INTO `users_roles` VALUES (32, 41, 2, '2021-11-26 11:51:47', '2021-11-26 11:51:47', 1, 1, 1, '2021-11-26 11:51:47', '2025-01-01 12:00:00');
INSERT INTO `users_roles` VALUES (33, 43, 2, '2021-11-26 11:52:15', '2021-11-26 11:52:15', 1, 1, 1, '2021-11-26 11:52:15', '2025-01-01 12:00:00');
INSERT INTO `users_roles` VALUES (34, 44, 2, '2021-11-26 20:11:27', '2021-11-26 20:11:27', 1, 1, 1, '2021-11-26 20:11:27', '2025-01-01 12:00:00');
INSERT INTO `users_roles` VALUES (35, 46, 2, '2021-11-28 13:37:40', '2021-11-28 13:37:40', 1, 1, 1, '2021-11-28 13:37:40', '2025-01-01 12:00:00');
INSERT INTO `users_roles` VALUES (36, 34, 1, '2021-11-25 20:24:23', '2021-11-25 20:24:23', 1, 1, 1, '2021-11-25 20:24:23', '2025-01-01 12:00:00');
INSERT INTO `users_roles` VALUES (37, 48, 1, '2021-12-02 20:58:13', '2021-12-02 20:58:13', 1, 1, 1, '2021-12-02 20:58:13', '2025-01-01 12:00:00');

SET FOREIGN_KEY_CHECKS = 1;
