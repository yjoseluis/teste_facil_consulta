/*
 Navicat Premium Data Transfer

 Source Server         : Localhost
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : localhost:3306
 Source Schema         : teste_fc

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 25/11/2020 13:31:23
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for horario
-- ----------------------------
DROP TABLE IF EXISTS `horario`;
CREATE TABLE `horario`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_medico` int(11) NULL DEFAULT NULL,
  `data_horario` datetime(0) NULL DEFAULT NULL,
  `horario_agendado` int(1) NOT NULL,
  `data_criacao` timestamp(0) NULL DEFAULT NULL,
  `data_alteracao` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of horario
-- ----------------------------
INSERT INTO `horario` VALUES (1, 1, '2020-11-26 10:00:00', 0, '2020-11-25 12:49:50', NULL);
INSERT INTO `horario` VALUES (2, 1, '2020-11-26 11:00:00', 0, '2020-11-25 12:49:56', NULL);
INSERT INTO `horario` VALUES (3, 1, '2020-11-26 12:00:00', 1, '2020-11-25 12:50:05', NULL);
INSERT INTO `horario` VALUES (4, 2, '2020-11-27 11:00:00', 0, '2020-11-25 12:50:25', NULL);
INSERT INTO `horario` VALUES (5, 2, '2020-11-27 12:00:00', 1, '2020-11-25 12:50:31', NULL);
INSERT INTO `horario` VALUES (6, 2, '2020-11-28 13:00:00', 0, '2020-11-25 12:50:38', NULL);
INSERT INTO `horario` VALUES (7, 2, '2020-11-25 15:00:00', 0, '2020-11-25 13:40:58', NULL);

-- ----------------------------
-- Table structure for medico
-- ----------------------------
DROP TABLE IF EXISTS `medico`;
CREATE TABLE `medico`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `nome` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `senha` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `data_criacao` timestamp(0) NULL DEFAULT NULL,
  `data_alteracao` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of medico
-- ----------------------------
INSERT INTO `medico` VALUES (1, 'joseluis.ald@hotmail.com', 'Dr. José', 'ZjEyMmRiMDA3ZWQ2NTU5MjFmOTgxODRlNDMwMmJiYTg0OTkwZmY2OA==', '2020-11-25 12:49:15', NULL);
INSERT INTO `medico` VALUES (2, 'jaldrighi@gmail.com', 'Dr. Luis', 'ZjEyMmRiMDA3ZWQ2NTU5MjFmOTgxODRlNDMwMmJiYTg0OTkwZmY2OA==', '2020-11-25 12:49:29', NULL);

SET FOREIGN_KEY_CHECKS = 1;
