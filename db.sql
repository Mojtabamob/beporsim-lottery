-- ----------------------------
-- Table structure for participants
-- ----------------------------
DROP TABLE IF EXISTS `participants`;
CREATE TABLE `participants`  (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `uid` int(8) NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `mobile` bigint(20) NULL DEFAULT NULL,
  `contest` int(4) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for winners
-- ----------------------------
DROP TABLE IF EXISTS `winners`;
CREATE TABLE `winners`  (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL DEFAULT NULL,
  `contest` int(4) NULL DEFAULT NULL,
  `winner` int(8) NULL DEFAULT NULL,
  `status` int(1) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
