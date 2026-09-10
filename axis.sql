/*
 Navicat Premium Dump SQL

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100432 (10.4.32-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : axis

 Target Server Type    : MySQL
 Target Server Version : 100432 (10.4.32-MariaDB)
 File Encoding         : 65001

 Date: 10/09/2026 02:15:54
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for cache
-- ----------------------------
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache`  (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`) USING BTREE,
  INDEX `cache_expiration_index`(`expiration` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cache
-- ----------------------------

-- ----------------------------
-- Table structure for cache_locks
-- ----------------------------
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks`  (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`) USING BTREE,
  INDEX `cache_locks_expiration_index`(`expiration` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cache_locks
-- ----------------------------

-- ----------------------------
-- Table structure for evaluation_ritual_scores
-- ----------------------------
DROP TABLE IF EXISTS `evaluation_ritual_scores`;
CREATE TABLE `evaluation_ritual_scores`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `evaluation_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ritual_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `score` tinyint UNSIGNED NOT NULL COMMENT 'Calificación del 1 al 10',
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT 'Notas a mejorar por ritual',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `evaluation_ritual_scores_evaluation_id_ritual_id_unique`(`evaluation_id` ASC, `ritual_id` ASC) USING BTREE,
  INDEX `evaluation_ritual_scores_ritual_id_foreign`(`ritual_id` ASC) USING BTREE,
  CONSTRAINT `evaluation_ritual_scores_evaluation_id_foreign` FOREIGN KEY (`evaluation_id`) REFERENCES `evaluations` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `evaluation_ritual_scores_ritual_id_foreign` FOREIGN KEY (`ritual_id`) REFERENCES `rituals` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of evaluation_ritual_scores
-- ----------------------------

-- ----------------------------
-- Table structure for evaluations
-- ----------------------------
DROP TABLE IF EXISTS `evaluations`;
CREATE TABLE `evaluations`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `program_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `weekly_tracking_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `coach_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `instrument` enum('I1','I2','I3','I4','I5','I6') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ritual_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `evidence_status` enum('active','partial','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `frequency_level` enum('high','moderate','low','non_existent') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `frequency_pct` decimal(5, 2) NULL DEFAULT NULL,
  `quality_level` int NULL DEFAULT NULL,
  `field_observed` tinyint(1) NOT NULL DEFAULT 0,
  `field_notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `strengths` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `gaps` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `improvement_action` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `overall_score` decimal(5, 2) NULL DEFAULT NULL,
  `next_cycle_focus` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `advance_to_next` tinyint(1) NOT NULL DEFAULT 0,
  `dimension_focus` enum('volume','time','quality','cost') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `evaluated_at` timestamp NULL DEFAULT NULL,
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `evaluations_weekly_tracking_id_foreign`(`weekly_tracking_id` ASC) USING BTREE,
  INDEX `evaluations_coach_id_foreign`(`coach_id` ASC) USING BTREE,
  INDEX `evaluations_ritual_id_foreign`(`ritual_id` ASC) USING BTREE,
  INDEX `evaluations_program_id_instrument_index`(`program_id` ASC, `instrument` ASC) USING BTREE,
  CONSTRAINT `evaluations_coach_id_foreign` FOREIGN KEY (`coach_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `evaluations_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `training_programs` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `evaluations_ritual_id_foreign` FOREIGN KEY (`ritual_id`) REFERENCES `rituals` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `evaluations_weekly_tracking_id_foreign` FOREIGN KEY (`weekly_tracking_id`) REFERENCES `weekly_tracking` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of evaluations
-- ----------------------------
INSERT INTO `evaluations` VALUES ('019fc647-5529-7144-8b97-f86b404afda0', '9cca74b3-a240-43d4-88a7-2fefde9e71c7', NULL, '24c5511b-f26a-4fec-9489-f461608ee116', 'I1', '8638fc75-e435-4406-875c-824b3b52c163', 'active', 'high', 10.00, 1, 1, 'test', 'test', 'test', 'test', 10.00, 'test', 1, 'volume', '2026-08-03 06:19:28', 'test', '2026-08-03 06:19:51', '2026-08-03 06:19:51');

-- ----------------------------
-- Table structure for evidences
-- ----------------------------
DROP TABLE IF EXISTS `evidences`;
CREATE TABLE `evidences`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `program_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `weekly_tracking_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ritual_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `uploaded_by` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `evidence_type` enum('document','image','url','audio','video','form') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `file_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `external_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `file_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `file_mime` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `file_size_kb` int NULL DEFAULT NULL,
  `status` enum('pending_review','approved','needs_revision','rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending_review',
  `coach_notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `self_assessment_score` tinyint UNSIGNED NULL DEFAULT NULL COMMENT 'Auto-evaluación del Trainee del 1 al 10',
  `reviewed_by` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `evidences_ritual_id_foreign`(`ritual_id` ASC) USING BTREE,
  INDEX `evidences_uploaded_by_foreign`(`uploaded_by` ASC) USING BTREE,
  INDEX `evidences_reviewed_by_foreign`(`reviewed_by` ASC) USING BTREE,
  INDEX `evidences_program_id_status_index`(`program_id` ASC, `status` ASC) USING BTREE,
  INDEX `evidences_weekly_tracking_id_index`(`weekly_tracking_id` ASC) USING BTREE,
  CONSTRAINT `evidences_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `training_programs` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `evidences_reviewed_by_foreign` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `evidences_ritual_id_foreign` FOREIGN KEY (`ritual_id`) REFERENCES `rituals` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `evidences_uploaded_by_foreign` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `evidences_weekly_tracking_id_foreign` FOREIGN KEY (`weekly_tracking_id`) REFERENCES `weekly_tracking` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of evidences
-- ----------------------------
INSERT INTO `evidences` VALUES ('019fc5fd-bbcc-7190-9a0b-01eda09de83f', 'd1058562-cff7-4c8d-bf40-4938e508e8de', '5e9b13a7-c470-427f-a429-d4e1250a80d6', '8638fc75-e435-4406-875c-824b3b52c163', '4ae960da-c497-4b54-8a94-f0c5c3ce3edf', 'tes', 'test', 'document', NULL, 'https://www.youtube.com/watch?v=aFhtyISNbYc', NULL, NULL, NULL, NULL, 'pending_review', 'esto es un test de revision', NULL, NULL, NULL, '2026-08-03 04:59:28', '2026-08-03 06:32:59', NULL);
INSERT INTO `evidences` VALUES ('019fcda9-1f27-71b2-b44f-bc59ba032e3a', 'd1058562-cff7-4c8d-bf40-4938e508e8de', '5e9b13a7-c470-427f-a429-d4e1250a80d6', '006ba94d-b2a7-4185-b966-5d32ab337b04', '4ae960da-c497-4b54-8a94-f0c5c3ce3edf', 'vista advamce', 'primera vista ', 'document', NULL, 'https://docs.google.com/document/d/1ExdY28Ezxh-Ke4sJZKU-EmqcXRfRgDvXuwQ3bthERwY/edit?tab=t.0', NULL, NULL, NULL, NULL, 'approved', NULL, NULL, NULL, NULL, '2026-08-04 16:44:00', '2026-08-25 17:24:00', NULL);
INSERT INTO `evidences` VALUES ('01a02c34-ced0-726e-9f1a-1b7e5ef96823', 'd1058562-cff7-4c8d-bf40-4938e508e8de', 'e6b826a9-ab78-4b1e-9b30-6ceca6030917', '8638fc75-e435-4406-875c-824b3b52c163', '4ae960da-c497-4b54-8a94-f0c5c3ce3edf', 'Análisis de la matriz de planificación', 'Lo visite y me dijeron que estaba lindo', 'url', NULL, 'https://www.youtube.com/watch?v=aFhtyISNbYc', NULL, NULL, NULL, NULL, 'pending_review', NULL, NULL, NULL, NULL, '2026-08-23 01:20:53', '2026-08-23 01:20:53', NULL);
INSERT INTO `evidences` VALUES ('01a03912-4efd-708d-a59f-c27849ca625c', 'd1058562-cff7-4c8d-bf40-4938e508e8de', 'e6b826a9-ab78-4b1e-9b30-6ceca6030917', '8638fc75-e435-4406-875c-824b3b52c163', '4ae960da-c497-4b54-8a94-f0c5c3ce3edf', 'completar el curso de autogestionable', 'hice el curso de micro', 'url', NULL, 'https://mail.google.com/mail/u/0/?tab=rm&ogbl#inbox', NULL, NULL, NULL, NULL, 'approved', NULL, NULL, NULL, NULL, '2026-08-25 13:18:16', '2026-08-26 14:50:13', NULL);

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for feedback_sessions
-- ----------------------------
DROP TABLE IF EXISTS `feedback_sessions`;
CREATE TABLE `feedback_sessions`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `program_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `coach_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `session_type` enum('weekly_plan','risk_management','wins_losses','quarterly_growth','field_coaching') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `session_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE CURRENT_TIMESTAMP,
  `strengths` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gaps` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `single_action` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ritual_focus` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `next_steps` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL,
  `trainee_ack` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `feedback_sessions_coach_id_foreign`(`coach_id` ASC) USING BTREE,
  INDEX `feedback_sessions_ritual_focus_foreign`(`ritual_focus` ASC) USING BTREE,
  INDEX `feedback_sessions_program_id_trainee_ack_index`(`program_id` ASC, `trainee_ack` ASC) USING BTREE,
  CONSTRAINT `feedback_sessions_coach_id_foreign` FOREIGN KEY (`coach_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `feedback_sessions_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `training_programs` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `feedback_sessions_ritual_focus_foreign` FOREIGN KEY (`ritual_focus`) REFERENCES `rituals` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of feedback_sessions
-- ----------------------------
INSERT INTO `feedback_sessions` VALUES ('019fc60d-182b-709f-9983-e3246f96ab09', 'd1058562-cff7-4c8d-bf40-4938e508e8de', '24c5511b-f26a-4fec-9489-f461608ee116', 'weekly_plan', '2026-08-03 01:17:44', 'Fortalezas observadas*Fortalezas observadas*Fortalezas observadas*', 'Brechas identificadas*Brechas identificadas*Brechas identificadas*', 'Accion de mejora prioritaria*Accion de mejora prioritaria*Accion de mejora prioritaria*', '8638fc75-e435-4406-875c-824b3b52c163', NULL, 1, '2026-08-03 05:16:14', '2026-08-03 05:17:44');

-- ----------------------------
-- Table structure for field_interactions
-- ----------------------------
DROP TABLE IF EXISTS `field_interactions`;
CREATE TABLE `field_interactions`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `program_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `weekly_tracking_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_account` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `opportunity_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `leader_approval` tinyint(1) NOT NULL DEFAULT 0,
  `visit_date` date NOT NULL,
  `visit_type` enum('prospecting','discovery','proposal','negotiation','closing') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_in_matrix` tinyint(1) NOT NULL DEFAULT 0,
  `is_scheduled` tinyint(1) NOT NULL DEFAULT 0,
  `is_presential` tinyint(1) NOT NULL DEFAULT 0,
  `crm_registered` tinyint(1) NOT NULL DEFAULT 0,
  `has_artifacts` tinyint(1) NOT NULL DEFAULT 0,
  `is_valid` tinyint(1) NOT NULL DEFAULT 0,
  `spiced_doc_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `field_interactions_weekly_tracking_id_foreign`(`weekly_tracking_id` ASC) USING BTREE,
  INDEX `field_interactions_program_id_is_valid_index`(`program_id` ASC, `is_valid` ASC) USING BTREE,
  INDEX `field_interactions_visit_date_index`(`visit_date` ASC) USING BTREE,
  CONSTRAINT `field_interactions_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `training_programs` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `field_interactions_weekly_tracking_id_foreign` FOREIGN KEY (`weekly_tracking_id`) REFERENCES `weekly_tracking` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of field_interactions
-- ----------------------------
INSERT INTO `field_interactions` VALUES ('019fc601-a333-71ff-af86-06fe374c923a', 'd1058562-cff7-4c8d-bf40-4938e508e8de', '5e9b13a7-c470-427f-a429-d4e1250a80d6', 'Rosa Navas Inc', 'Rosa Navas Inc', NULL, 0, '2026-08-03', 'prospecting', 1, 1, 1, 1, 1, 1, 'https://www.youtube.com/watch?v=aFhtyISNbYc', 'Test', '2026-08-03 05:03:43', '2026-08-03 05:03:43', NULL);
INSERT INTO `field_interactions` VALUES ('019fc64a-4d87-739e-8c1e-a9eff117d879', '9cca74b3-a240-43d4-88a7-2fefde9e71c7', '684ded29-2b45-47b6-8c19-33ab310691e6', 'test', 'test', NULL, 0, '2026-06-19', 'prospecting', 1, 1, 1, 1, 1, 1, 'https://somosadvance.com/', 'https://somosadvance.com/', '2026-08-03 06:23:06', '2026-08-03 06:23:06', NULL);
INSERT INTO `field_interactions` VALUES ('01a03a23-d78e-7132-85dd-4fc8362ee63b', 'd1058562-cff7-4c8d-bf40-4938e508e8de', '5e9b13a7-c470-427f-a429-d4e1250a80d6', 'JUAN CORP', 'VICTORIA', NULL, 0, '2026-08-19', 'negotiation', 1, 1, 1, 1, 1, 1, 'https://script.google.com/a/macros/somosadvance.com/s/AKfycbxShNq2WY3thPlDs5_C08HLlTHihVnGzE2NobT4YKI8EQpIFP-DY7JSt_RLmGhdYYR4/exec', NULL, '2026-08-25 18:17:02', '2026-08-25 18:17:02', NULL);

-- ----------------------------
-- Table structure for job_batches
-- ----------------------------
DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches`  (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `cancelled_at` int NULL DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of job_batches
-- ----------------------------

-- ----------------------------
-- Table structure for jobs
-- ----------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED NULL DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `jobs_queue_index`(`queue` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of jobs
-- ----------------------------

-- ----------------------------
-- Table structure for kpi_snapshots
-- ----------------------------
DROP TABLE IF EXISTS `kpi_snapshots`;
CREATE TABLE `kpi_snapshots`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `program_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `snapshot_date` date NOT NULL,
  `week_number` int NOT NULL,
  `weekly_interactions` int NOT NULL,
  `total_interactions` int NOT NULL,
  `spiced_opportunities` int NOT NULL,
  `mutual_agreements` int NOT NULL,
  `win_rate` decimal(5, 2) NULL DEFAULT NULL,
  `arr_consumables` decimal(12, 2) NULL DEFAULT NULL,
  `current_dimension` enum('volume','time','quality','cost') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `current_phase` enum('A','B','C','D','E') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `advancement_recommendation` enum('continue','reinforce','review','graduate') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `kpi_snapshots_program_id_snapshot_date_index`(`program_id` ASC, `snapshot_date` ASC) USING BTREE,
  CONSTRAINT `kpi_snapshots_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `training_programs` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of kpi_snapshots
-- ----------------------------

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '0001_01_01_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '0001_01_01_000001_create_cache_table', 1);
INSERT INTO `migrations` VALUES (3, '0001_01_01_000002_create_jobs_table', 1);
INSERT INTO `migrations` VALUES (4, '2026_07_30_234253_modify_users_table', 1);
INSERT INTO `migrations` VALUES (5, '2026_07_30_234347_create_program_phases_table', 1);
INSERT INTO `migrations` VALUES (6, '2026_07_30_234420_create_rituals_table', 1);
INSERT INTO `migrations` VALUES (7, '2026_07_30_234455_create_training_programs_table', 1);
INSERT INTO `migrations` VALUES (8, '2026_07_30_234536_create_weekly_tracking_table', 1);
INSERT INTO `migrations` VALUES (9, '2026_07_30_234603_create_evidences_table', 1);
INSERT INTO `migrations` VALUES (10, '2026_07_30_234633_create_field_interactions_table', 1);
INSERT INTO `migrations` VALUES (11, '2026_07_30_234703_create_evaluations_table', 1);
INSERT INTO `migrations` VALUES (12, '2026_07_30_234732_create_feedback_sessions_table', 1);
INSERT INTO `migrations` VALUES (13, '2026_07_30_234809_create_subrole_achievements_table', 1);
INSERT INTO `migrations` VALUES (14, '2026_07_30_234838_create_kpi_snapshots_table', 1);
INSERT INTO `migrations` VALUES (15, '2026_07_30_234918_create_notifications_table', 1);
INSERT INTO `migrations` VALUES (16, '2026_08_03_010603_add_client_classification_to_field_interactions_table', 2);
INSERT INTO `migrations` VALUES (17, '2026_08_03_051921_add_promotion_fields_to_training_programs', 3);
INSERT INTO `migrations` VALUES (18, '2026_09_10_051653_modify_field_interactions_for_v2', 4);
INSERT INTO `migrations` VALUES (19, '2026_09_10_051654_add_self_assessment_score_to_evidences', 4);
INSERT INTO `migrations` VALUES (20, '2026_09_10_051655_create_evaluation_ritual_scores_table', 4);

-- ----------------------------
-- Table structure for notifications
-- ----------------------------
DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('evidence_due','feedback_ready','meeting_reminder','ritual_alert','subrole_achieved','kpi_alert') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `action_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `notifications_user_id_is_read_index`(`user_id` ASC, `is_read` ASC) USING BTREE,
  CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of notifications
-- ----------------------------
INSERT INTO `notifications` VALUES ('019fc620-2691-728d-a324-c6a220c36d2d', '24c5511b-f26a-4fec-9489-f461608ee116', 'ritual_alert', 'María López tiene interacciones insuficientes', 'Lleva 2 de 5 interacciones validas requeridas esta semana. Considera contactarlo antes del cierre.', 0, '/coach/field-interactions', '2026-08-03 05:37:03', '2026-08-03 05:37:03');

-- ----------------------------
-- Table structure for password_reset_tokens
-- ----------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of password_reset_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for program_phases
-- ----------------------------
DROP TABLE IF EXISTS `program_phases`;
CREATE TABLE `program_phases`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` enum('A','B','C','D','E') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `week_start` int NOT NULL,
  `week_end` int NOT NULL,
  `main_tool` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `program_phases_code_unique`(`code` ASC) USING BTREE,
  INDEX `program_phases_code_index`(`code` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of program_phases
-- ----------------------------
INSERT INTO `program_phases` VALUES ('373e29c9-ad35-458f-a895-feae0f397d5d', 'A', 'Concientización', 1, 4, 'Go-To-Market', 'El trainee construye su mapa de mercado y ejecuta sus primeras visitas. Foco en volumen y presencia. Herramientas activas: GTM y Matriz de Planificación.', '2026-08-02 23:31:39', '2026-08-02 23:31:39');
INSERT INTO `program_phases` VALUES ('61acade5-181b-4829-b0a9-f8a6760a61d6', 'E', 'Mejora Continua', 25, 51, 'PHVA Completo', 'El trainee opera como Asesor Comercial. Optimiza cobertura, tiempo, conversión y costo. Ciclo PHVA completo en cada trimestre.', '2026-08-02 23:31:39', '2026-08-02 23:31:39');
INSERT INTO `program_phases` VALUES ('a2df99a4-42e3-4d10-b8c6-5f8ec07d0218', 'B', 'Educación', 5, 9, 'SPICED', 'El trainee aprende a descubrir el problema del cliente con profundidad. Incorpora el framework SPICED en cada cita de descubrimiento.', '2026-08-02 23:31:39', '2026-08-02 23:31:39');
INSERT INTO `program_phases` VALUES ('bee654c5-9780-4aaf-acf4-49d394df1a70', 'D', 'Desarrollo', 17, 24, 'Cotizaciones', 'El trainee convierte oportunidades en ingresos. Cotiza, negocia y cierra con consistencia. Gestiona el embudo con disciplina.', '2026-08-02 23:31:39', '2026-08-02 23:31:39');
INSERT INTO `program_phases` VALUES ('d1d51f15-c74f-4735-ab0d-9e1fcb448bf8', 'C', 'Priorización y Selección', 10, 16, 'Presentación ATAR', 'El trainee articula la propuesta de valor de Advance en el lenguaje del cliente. Domina la presentación ATAR personalizada por cuenta.', '2026-08-02 23:31:39', '2026-08-02 23:31:39');

-- ----------------------------
-- Table structure for rituals
-- ----------------------------
DROP TABLE IF EXISTS `rituals`;
CREATE TABLE `rituals`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `number` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `phase_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tool` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `frequency` enum('daily','weekly','per_visit','monthly') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `evidence_type` enum('document','form','url','image','audio','video') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `rituals_number_unique`(`number` ASC) USING BTREE,
  INDEX `rituals_phase_id_index`(`phase_id` ASC) USING BTREE,
  INDEX `rituals_is_active_index`(`is_active` ASC) USING BTREE,
  INDEX `rituals_number_index`(`number` ASC) USING BTREE,
  CONSTRAINT `rituals_phase_id_foreign` FOREIGN KEY (`phase_id`) REFERENCES `program_phases` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of rituals
-- ----------------------------
INSERT INTO `rituals` VALUES ('006ba94d-b2a7-4185-b966-5d32ab337b04', 2, 'Revisar Tríadas de Acceso', 'Identificar en el GTM las tríadas de acceso (Técnico, Económico, Usuario) para cada cuenta objetivo y documentar el estado de cada contacto.', '373e29c9-ad35-458f-a895-feae0f397d5d', 'Go-To-Market', 'weekly', 'document', 1, '2026-08-02 23:31:39', '2026-08-02 23:31:39');
INSERT INTO `rituals` VALUES ('05734649-c026-46f6-95a2-8c33c90e7623', 6, 'Plan de Batalla Semanal', 'Cada viernes revisar la Matriz de la semana siguiente. Identificar cuentas sin cita agendada y definir acciones para cubrirlas.', '373e29c9-ad35-458f-a895-feae0f397d5d', 'Matriz de Planificación', 'weekly', 'document', 1, '2026-08-02 23:31:39', '2026-08-02 23:31:39');
INSERT INTO `rituals` VALUES ('0f2d0ac6-ce97-414b-a237-749dd6bfec80', 19, 'Actualizar Plan de Cuentas', 'Cada mes revisar y actualizar el Plan de Cuentas con el avance real vs objetivo, ajustar estrategia según cambios en el cliente.', 'd1d51f15-c74f-4735-ab0d-9e1fcb448bf8', 'Presentación ATAR', 'monthly', 'document', 1, '2026-08-02 23:31:39', '2026-08-02 23:31:39');
INSERT INTO `rituals` VALUES ('1224d996-ddef-49fd-add7-176f1997c547', 14, 'Entender Criterios de Decisión', 'En cada cita de descubrimiento, identificar los criterios de evaluación del cliente (técnicos, económicos, políticos). Documentar prioridad de cada criterio.', 'a2df99a4-42e3-4d10-b8c6-5f8ec07d0218', 'SPICED', 'per_visit', 'document', 1, '2026-08-02 23:31:39', '2026-08-02 23:31:39');
INSERT INTO `rituals` VALUES ('1bbc6c48-c36e-4e6c-bfdf-22840831958c', 21, 'Elaborar Cotización Estratégica', 'Construir la cotización basada en el SPICED y el Plan de Cuentas. Incluir propuesta de valor cuantificada. Requiere aprobación del líder para cuentas A y B.', 'bee654c5-9780-4aaf-acf4-49d394df1a70', 'Cotizaciones', 'per_visit', 'document', 1, '2026-08-02 23:31:39', '2026-08-02 23:31:39');
INSERT INTO `rituals` VALUES ('3911824d-0e5c-4148-9235-5fb813aa2417', 28, 'Revisión de ARR de Consumibles', 'Cada mes calcular el ARR de consumibles generado por la Matriz de Planificación. Comparar contra meta y ajustar estrategia de cuentas.', '61acade5-181b-4829-b0a9-f8a6760a61d6', 'PHVA Completo', 'monthly', 'document', 1, '2026-08-02 23:31:39', '2026-08-02 23:31:39');
INSERT INTO `rituals` VALUES ('3b0abae0-1a0f-4e08-92e8-a5cab1a4c77e', 13, 'Mapear Proceso de Decisión', 'Identificar todos los roles en la decisión del cliente: decisor, influenciador, usuario, comprador, bloqueador. Documentar en sección D del SPICED.', 'a2df99a4-42e3-4d10-b8c6-5f8ec07d0218', 'SPICED', 'per_visit', 'document', 1, '2026-08-02 23:31:39', '2026-08-02 23:31:39');
INSERT INTO `rituals` VALUES ('3b300fdb-1f1f-4903-8f22-4e3f7e1c52dd', 25, 'Revisión de Ganadas y Perdidas', 'Al cierre de cada oportunidad (ganada o perdida), documentar los factores determinantes. Analizar patrones para mejorar el proceso.', '61acade5-181b-4829-b0a9-f8a6760a61d6', 'PHVA Completo', 'per_visit', 'document', 1, '2026-08-02 23:31:39', '2026-08-02 23:31:39');
INSERT INTO `rituals` VALUES ('3f58347b-868c-45e8-8e03-ac6826f18b24', 3, 'Clasificar Cuentas por Potencial', 'Clasificar las cuentas del territorio en A, B y C según potencial de consumo, usando los criterios del GTM.', '373e29c9-ad35-458f-a895-feae0f397d5d', 'Go-To-Market', 'monthly', 'document', 1, '2026-08-02 23:31:39', '2026-08-02 23:31:39');
INSERT INTO `rituals` VALUES ('63e512d9-8786-483a-8ceb-2049e238fe2a', 20, 'Gestionar Objeciones con Aikido', 'Ante cada objeción del cliente, aplicar la técnica de Aikido Comercial: escuchar, validar, redirigir. No confrontar ni ceder sin contrapartida.', 'd1d51f15-c74f-4735-ab0d-9e1fcb448bf8', 'Presentación ATAR', 'per_visit', 'audio', 1, '2026-08-02 23:31:39', '2026-08-02 23:31:39');
INSERT INTO `rituals` VALUES ('6a994d1f-f0d3-401b-8d82-2307835a0549', 15, 'Tomar Notas y Parafrasear', 'Durante cada cita, tomar notas directamente en el formato SPICED. Parafrasear al cliente al cierre de cada bloque para validar comprensión.', 'a2df99a4-42e3-4d10-b8c6-5f8ec07d0218', 'SPICED', 'per_visit', 'audio', 1, '2026-08-02 23:31:39', '2026-08-02 23:31:39');
INSERT INTO `rituals` VALUES ('7edb2b0d-a8b9-4fba-80f7-2d94f3c30d05', 17, 'Presentar Productos', 'Seleccionar máximo 2-3 soluciones vinculadas al SPICED. Preparar ficha de 3 minutos por producto: problema que resuelve, resultado que genera, por qué Advance.', 'd1d51f15-c74f-4735-ab0d-9e1fcb448bf8', 'Presentación ATAR', 'per_visit', 'document', 1, '2026-08-02 23:31:39', '2026-08-02 23:31:39');
INSERT INTO `rituals` VALUES ('8638fc75-e435-4406-875c-824b3b52c163', 1, 'Activar el Go-To-Market', 'Consultar el GTM al inicio de cada semana para identificar cuentas prioritarias y definir el foco de la semana.', '373e29c9-ad35-458f-a895-feae0f397d5d', 'Go-To-Market', 'weekly', 'document', 1, '2026-08-02 23:31:39', '2026-08-02 23:31:39');
INSERT INTO `rituals` VALUES ('912bda95-c201-4539-931a-c290003070cf', 24, 'Cerrar con Mutuo Acuerdo', 'Al cierre de cada oportunidad, documentar el Mutuo Acuerdo: qué se acordó, quién es responsable, fechas comprometidas. Registrar en CRM.', 'bee654c5-9780-4aaf-acf4-49d394df1a70', 'Cotizaciones', 'per_visit', 'document', 1, '2026-08-02 23:31:39', '2026-08-02 23:31:39');
INSERT INTO `rituals` VALUES ('99f26a1a-a515-4bdd-b71c-2ef2696601ac', 23, 'Seguimiento Post-Propuesta', 'En las 48 horas siguientes a presentar una propuesta, ejecutar seguimiento estructurado: confirmar recepción, resolver dudas, proponer siguiente paso.', 'bee654c5-9780-4aaf-acf4-49d394df1a70', 'Cotizaciones', 'per_visit', 'document', 1, '2026-08-02 23:31:39', '2026-08-02 23:31:39');
INSERT INTO `rituals` VALUES ('a6e13cea-a239-491b-9721-0949c941163e', 4, 'Construir la Matriz Semanal', 'Completar la Matriz de Planificación cada lunes con las citas agendadas para las próximas dos semanas. Incluir cliente, objetivo, tipo de visita y material necesario.', '373e29c9-ad35-458f-a895-feae0f397d5d', 'Matriz de Planificación', 'weekly', 'document', 1, '2026-08-02 23:31:39', '2026-08-02 23:31:39');
INSERT INTO `rituals` VALUES ('a9befc64-d096-4477-89c4-8f7b9ae93bb2', 16, 'Presentar la Empresa (ATAR a Medida)', 'Antes de cada cita de presentación, adaptar la estructura ATAR al contexto del cliente usando el SPICED. Nunca usar la versión genérica sin adaptación.', 'd1d51f15-c74f-4735-ab0d-9e1fcb448bf8', 'Presentación ATAR', 'per_visit', 'document', 1, '2026-08-02 23:31:39', '2026-08-02 23:31:39');
INSERT INTO `rituals` VALUES ('af6172b9-cd33-4134-a721-e64bd95f2174', 12, 'Identificar Evento Decisivo', 'En cada cita de descubrimiento, identificar el evento o fecha límite que hace urgente la decisión del cliente. Documentar en sección E del SPICED.', 'a2df99a4-42e3-4d10-b8c6-5f8ec07d0218', 'SPICED', 'per_visit', 'document', 1, '2026-08-02 23:31:39', '2026-08-02 23:31:39');
INSERT INTO `rituals` VALUES ('b10fa44e-f554-4ffb-8170-48415a8101c7', 18, 'Construir Plan de Cuentas', 'Para cada cuenta clave, construir un Plan de Cuentas con objetivo trimestral, oportunidades identificadas, estrategia y plan de acción.', 'd1d51f15-c74f-4735-ab0d-9e1fcb448bf8', 'Presentación ATAR', 'monthly', 'document', 1, '2026-08-02 23:31:39', '2026-08-02 23:31:39');
INSERT INTO `rituals` VALUES ('b142e149-1559-4623-ba1b-220a11851e3e', 9, 'Preparar Pre-Cita SPICED', 'Antes de cada cita de descubrimiento, completar las secciones S y P del SPICED con información conocida del cliente.', 'a2df99a4-42e3-4d10-b8c6-5f8ec07d0218', 'SPICED', 'per_visit', 'document', 1, '2026-08-02 23:31:39', '2026-08-02 23:31:39');
INSERT INTO `rituals` VALUES ('bf34fd2e-d074-4be8-b04d-1b204f1ce3ec', 7, 'Registrar Resultado de Cada Visita', 'Al terminar cada visita, actualizar la Matriz con el resultado obtenido y el siguiente paso acordado con el cliente.', '373e29c9-ad35-458f-a895-feae0f397d5d', 'Matriz de Planificación', 'per_visit', 'form', 1, '2026-08-02 23:31:39', '2026-08-02 23:31:39');
INSERT INTO `rituals` VALUES ('c6be1fbd-cb94-4176-8a76-03cd786f4cb0', 27, 'Optimizar Cobertura de Territorio', 'Revisar mensualmente el GTM para identificar cuentas no visitadas, cuentas de alto potencial desatendidas y oportunidades de expansión.', '61acade5-181b-4829-b0a9-f8a6760a61d6', 'PHVA Completo', 'monthly', 'document', 1, '2026-08-02 23:31:39', '2026-08-02 23:31:39');
INSERT INTO `rituals` VALUES ('c82324cf-4559-404e-8059-3aeda3443999', 26, 'Autoevaluación Trimestral', 'Al cierre de cada trimestre, completar la guía de autoevaluación: rituales consistentes, habilidades desarrolladas, brechas identificadas, plan para el siguiente trimestre.', '61acade5-181b-4829-b0a9-f8a6760a61d6', 'PHVA Completo', 'monthly', 'document', 1, '2026-08-02 23:31:39', '2026-08-02 23:31:39');
INSERT INTO `rituals` VALUES ('cf9ec76c-f62b-4976-ab97-b6d1fd0dfaab', 8, 'Confirmación 48 Horas', 'Enviar mensaje de confirmación de cita 48 horas antes. Incluir agenda propuesta y objetivos de la reunión.', '373e29c9-ad35-458f-a895-feae0f397d5d', 'Matriz de Planificación', 'per_visit', 'document', 1, '2026-08-02 23:31:39', '2026-08-02 23:31:39');
INSERT INTO `rituals` VALUES ('e40c24af-f699-43d2-8a4e-917063990de3', 22, 'Radiografía del Embudo', 'Cada viernes revisar el embudo completo: oportunidades activas, etapa de cada una, próximo paso, probabilidad de cierre. Actualizar en CRM.', 'bee654c5-9780-4aaf-acf4-49d394df1a70', 'Cotizaciones', 'weekly', 'form', 1, '2026-08-02 23:31:39', '2026-08-02 23:31:39');
INSERT INTO `rituals` VALUES ('f261a233-07d3-4693-a7a5-b8ed54c94e96', 5, 'Confirmar Citas 48 Horas Antes', 'Confirmar por escrito cada cita de la Matriz con 48 horas de anticipación. Registrar confirmación como evidencia.', '373e29c9-ad35-458f-a895-feae0f397d5d', 'Matriz de Planificación', 'per_visit', 'document', 1, '2026-08-02 23:31:39', '2026-08-02 23:31:39');
INSERT INTO `rituals` VALUES ('fc8f8690-dfbb-4dee-8cbd-c5d43c741573', 10, 'Ejecutar Descubrimiento SPICED', 'Conducir la cita siguiendo la estructura SPICED. Hacer preguntas de impacto y criticidad. No presentar soluciones hasta completar el descubrimiento.', 'a2df99a4-42e3-4d10-b8c6-5f8ec07d0218', 'SPICED', 'per_visit', 'document', 1, '2026-08-02 23:31:39', '2026-08-02 23:31:39');
INSERT INTO `rituals` VALUES ('ff567143-e1c2-4f9e-b041-ef6ba7f06426', 11, 'Documentar SPICED Post-Cita', 'En las 2 horas siguientes a cada cita, completar y digitalizar el SPICED completo. Archivar en el CRM.', 'a2df99a4-42e3-4d10-b8c6-5f8ec07d0218', 'SPICED', 'per_visit', 'document', 1, '2026-08-02 23:31:39', '2026-08-02 23:31:39');

-- ----------------------------
-- Table structure for sessions
-- ----------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions`  (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NULL DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `sessions_user_id_index`(`user_id` ASC) USING BTREE,
  INDEX `sessions_last_activity_index`(`last_activity` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sessions
-- ----------------------------
INSERT INTO `sessions` VALUES ('CJBJqGtThSLPUEF5rXyt9Tpx2DH4xPWWJpCXInG4', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoid3ExV2NrazUwaXA0R0h6NER0OE0wVmJmQ2wzRm41cjdDdGlBckdheCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo1MDoiaHR0cDovL2xvY2FsaG9zdC9heGlzL3B1YmxpYy9taS1wcm9ncmFtYS9kYXNoYm9hcmQiO31zOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czozNDoiaHR0cDovL2xvY2FsaG9zdC9heGlzL3B1YmxpYy9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1785714594);
INSERT INTO `sessions` VALUES ('Kh7wuqvDmlCRL24bIFRwQmLBAHzaD1JaE2OBUNxh', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZGozSURINzJhRnZWNUhKckxTMzVPcVZnTHRKODl0dVhEa0Q3akdGZiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL21pLXByb2dyYW1hL2Rhc2hib2FyZCI7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjI3OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvbG9naW4iO3M6NToicm91dGUiO3M6NToibG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1785714928);

-- ----------------------------
-- Table structure for subrole_achievements
-- ----------------------------
DROP TABLE IF EXISTS `subrole_achievements`;
CREATE TABLE `subrole_achievements`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `program_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subrole` enum('visitador','prospectador','descubridor','articulador','negociador','asesor_comercial') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `accredited_date` date NOT NULL,
  `accredited_by` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `evidence_summary` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `kpis_at_accreditation` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `subrole_achievements_accredited_by_foreign`(`accredited_by` ASC) USING BTREE,
  INDEX `subrole_achievements_program_id_index`(`program_id` ASC) USING BTREE,
  CONSTRAINT `subrole_achievements_accredited_by_foreign` FOREIGN KEY (`accredited_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `subrole_achievements_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `training_programs` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of subrole_achievements
-- ----------------------------

-- ----------------------------
-- Table structure for training_programs
-- ----------------------------
DROP TABLE IF EXISTS `training_programs`;
CREATE TABLE `training_programs`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `trainee_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `coach_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `current_week` int NOT NULL DEFAULT 1,
  `current_stage` enum('A','B','C','D','E') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'A',
  `current_subrole` enum('visitador','prospectador','descubridor','articulador','negociador','asesor_comercial') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'visitador',
  `status` enum('active','on_hold','graduated','discontinued') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `promotion_recommended_at` timestamp NULL DEFAULT NULL,
  `promotion_recommended_by` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `promotion_recommendation_notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `training_programs_trainee_id_foreign`(`trainee_id` ASC) USING BTREE,
  INDEX `training_programs_coach_id_index`(`coach_id` ASC) USING BTREE,
  INDEX `training_programs_status_index`(`status` ASC) USING BTREE,
  INDEX `training_programs_current_stage_index`(`current_stage` ASC) USING BTREE,
  INDEX `training_programs_promotion_recommended_by_foreign`(`promotion_recommended_by` ASC) USING BTREE,
  CONSTRAINT `training_programs_coach_id_foreign` FOREIGN KEY (`coach_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `training_programs_promotion_recommended_by_foreign` FOREIGN KEY (`promotion_recommended_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `training_programs_trainee_id_foreign` FOREIGN KEY (`trainee_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of training_programs
-- ----------------------------
INSERT INTO `training_programs` VALUES ('9cca74b3-a240-43d4-88a7-2fefde9e71c7', '789ffc6d-3e68-4c26-b97b-851c9f7790d0', '24c5511b-f26a-4fec-9489-f461608ee116', '2026-05-17', 12, 'C', 'articulador', 'active', NULL, NULL, NULL, 'RECHAZADO: rechazo de asenco porque sirechazo de asenco porque sirechazo de asenco porque sirechazo de asenco porque sirechazo de asenco porque sirechazo de asenco porque sirechazo de asenco porque sirechazo de asenco porque si', '2026-08-02 23:31:41', '2026-08-03 13:45:24', NULL);
INSERT INTO `training_programs` VALUES ('d1058562-cff7-4c8d-bf40-4938e508e8de', '4ae960da-c497-4b54-8a94-f0c5c3ce3edf', '24c5511b-f26a-4fec-9489-f461608ee116', '2026-06-21', 7, 'B', 'descubridor', 'graduated', NULL, NULL, NULL, NULL, '2026-08-02 23:31:41', '2026-08-03 05:29:06', NULL);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('trainee','coach','manager','biz_dev','admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'trainee',
  `region` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `avatar_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email` ASC) USING BTREE,
  INDEX `users_role_index`(`role` ASC) USING BTREE,
  INDEX `users_region_index`(`region` ASC) USING BTREE,
  INDEX `users_is_active_index`(`is_active` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('24c5511b-f26a-4fec-9489-f461608ee116', 'Coach Demo', 'coach@axis.test', '2026-08-02 23:31:41', '$2y$12$Wl4F72zobnyNiSuLv31J/uS.u0teq3snNRIInwTEcs2QFbQlSNE7a', 'coach', 'Caracas', NULL, NULL, 1, NULL, '2026-08-02 23:31:41', '2026-08-02 23:31:41', NULL);
INSERT INTO `users` VALUES ('2fd6b796-9a64-44bb-81cd-894286166953', 'Admin AXIS', 'admin@axis.test', '2026-08-02 23:31:41', '$2y$12$Wl4F72zobnyNiSuLv31J/uS.u0teq3snNRIInwTEcs2QFbQlSNE7a', 'admin', 'Nacional', NULL, NULL, 1, NULL, '2026-08-02 23:31:41', '2026-08-02 23:31:41', NULL);
INSERT INTO `users` VALUES ('4ae960da-c497-4b54-8a94-f0c5c3ce3edf', 'Juan Pérez', 'trainee1@axis.test', '2026-08-02 23:31:41', '$2y$12$Wl4F72zobnyNiSuLv31J/uS.u0teq3snNRIInwTEcs2QFbQlSNE7a', 'trainee', 'Caracas', NULL, NULL, 1, NULL, '2026-08-02 23:31:41', '2026-08-02 23:31:41', NULL);
INSERT INTO `users` VALUES ('789ffc6d-3e68-4c26-b97b-851c9f7790d0', 'María López', 'trainee2@axis.test', '2026-08-02 23:31:41', '$2y$12$Wl4F72zobnyNiSuLv31J/uS.u0teq3snNRIInwTEcs2QFbQlSNE7a', 'trainee', 'Caracas', NULL, NULL, 1, NULL, '2026-08-02 23:31:41', '2026-08-02 23:31:41', NULL);
INSERT INTO `users` VALUES ('b44eeeb2-9289-4fa6-a61f-e590849dd18c', 'Gerente Demo', 'gerente@axis.test', '2026-08-02 23:31:41', '$2y$12$Wl4F72zobnyNiSuLv31J/uS.u0teq3snNRIInwTEcs2QFbQlSNE7a', 'manager', 'Nacional', NULL, NULL, 1, NULL, '2026-08-02 23:31:41', '2026-08-02 23:31:41', NULL);

-- ----------------------------
-- Table structure for weekly_tracking
-- ----------------------------
DROP TABLE IF EXISTS `weekly_tracking`;
CREATE TABLE `weekly_tracking`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `program_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `week_number` int NOT NULL,
  `week_start_date` date NOT NULL,
  `week_end_date` date NOT NULL,
  `target_interactions` int NOT NULL DEFAULT 0,
  `actual_interactions` int NOT NULL DEFAULT 0,
  `rituals_target` int NOT NULL DEFAULT 0,
  `rituals_completed` int NOT NULL DEFAULT 0,
  `evidences_target` int NOT NULL DEFAULT 0,
  `evidences_uploaded` int NOT NULL DEFAULT 0,
  `status` enum('pending','in_progress','completed','overdue') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `coach_reviewed` tinyint(1) NOT NULL DEFAULT 0,
  `coach_reviewed_at` timestamp NULL DEFAULT NULL,
  `coach_reviewed_by` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `stage_at_start` enum('A','B','C','D','E') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subrole_at_start` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dimension_at_start` enum('volume','time','quality','cost') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'volume',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `weekly_tracking_program_id_week_number_unique`(`program_id` ASC, `week_number` ASC) USING BTREE,
  INDEX `weekly_tracking_coach_reviewed_by_foreign`(`coach_reviewed_by` ASC) USING BTREE,
  INDEX `weekly_tracking_status_index`(`status` ASC) USING BTREE,
  INDEX `weekly_tracking_week_start_date_index`(`week_start_date` ASC) USING BTREE,
  CONSTRAINT `weekly_tracking_coach_reviewed_by_foreign` FOREIGN KEY (`coach_reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  CONSTRAINT `weekly_tracking_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `training_programs` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of weekly_tracking
-- ----------------------------
INSERT INTO `weekly_tracking` VALUES ('07bfa7d3-77dc-490c-9dec-b058a2ec5227', '9cca74b3-a240-43d4-88a7-2fefde9e71c7', 6, '2026-06-15', '2026-06-21', 3, 3, 14, 14, 0, 0, 'completed', 1, NULL, NULL, 'A', '', 'volume', '2026-06-15 00:00:00', '2026-08-02 23:31:41');
INSERT INTO `weekly_tracking` VALUES ('0e5878e0-d655-4f21-b8ac-eaa7c04a9dd1', '9cca74b3-a240-43d4-88a7-2fefde9e71c7', 3, '2026-05-25', '2026-05-31', 1, 1, 14, 14, 0, 0, 'completed', 1, NULL, NULL, 'A', '', 'volume', '2026-05-25 00:00:00', '2026-08-02 23:31:41');
INSERT INTO `weekly_tracking` VALUES ('19212f1d-ab2a-4577-9d97-0f8eb4f91952', '9cca74b3-a240-43d4-88a7-2fefde9e71c7', 10, '2026-07-13', '2026-07-19', 5, 5, 14, 12, 0, 0, 'completed', 1, NULL, NULL, 'A', '', 'volume', '2026-07-13 00:00:00', '2026-08-02 23:31:41');
INSERT INTO `weekly_tracking` VALUES ('2668339b-b986-4586-88d0-9de86d3d28d1', 'd1058562-cff7-4c8d-bf40-4938e508e8de', 5, '2026-07-13', '2026-07-19', 3, 3, 14, 11, 0, 0, 'completed', 1, NULL, NULL, 'A', '', 'volume', '2026-07-13 00:00:00', '2026-08-02 23:31:41');
INSERT INTO `weekly_tracking` VALUES ('3417c94c-86b2-42d4-b1ee-118c0d6ddd64', '9cca74b3-a240-43d4-88a7-2fefde9e71c7', 8, '2026-06-29', '2026-07-05', 3, 3, 14, 12, 0, 0, 'completed', 1, NULL, NULL, 'A', '', 'volume', '2026-06-29 00:00:00', '2026-08-02 23:31:41');
INSERT INTO `weekly_tracking` VALUES ('3420149b-43f5-4684-9d86-9acbb73b12b3', '9cca74b3-a240-43d4-88a7-2fefde9e71c7', 1, '2026-05-11', '2026-05-17', 1, 0, 14, 14, 0, 0, 'completed', 1, NULL, NULL, 'A', '', 'volume', '2026-05-11 00:00:00', '2026-08-02 23:31:41');
INSERT INTO `weekly_tracking` VALUES ('5e9b13a7-c470-427f-a429-d4e1250a80d6', 'd1058562-cff7-4c8d-bf40-4938e508e8de', 7, '2026-07-27', '2026-08-02', 3, 2, 14, 6, 0, 2, 'in_progress', 0, NULL, NULL, 'A', '', 'volume', '2026-07-27 00:00:00', '2026-08-25 18:17:02');
INSERT INTO `weekly_tracking` VALUES ('684ded29-2b45-47b6-8c19-33ab310691e6', '9cca74b3-a240-43d4-88a7-2fefde9e71c7', 12, '2026-07-27', '2026-08-02', 5, 1, 14, 13, 0, 0, 'in_progress', 0, NULL, NULL, 'A', '', 'volume', '2026-07-27 00:00:00', '2026-08-03 06:23:06');
INSERT INTO `weekly_tracking` VALUES ('69720c43-9abe-4563-af15-7685580b27ad', '9cca74b3-a240-43d4-88a7-2fefde9e71c7', 7, '2026-06-22', '2026-06-28', 3, 1, 14, 14, 0, 0, 'completed', 1, NULL, NULL, 'A', '', 'volume', '2026-06-22 00:00:00', '2026-08-02 23:31:41');
INSERT INTO `weekly_tracking` VALUES ('75d0582a-358c-463b-99ec-8acccb424031', '9cca74b3-a240-43d4-88a7-2fefde9e71c7', 4, '2026-06-01', '2026-06-07', 1, 1, 14, 10, 0, 0, 'completed', 1, NULL, NULL, 'A', '', 'volume', '2026-06-01 00:00:00', '2026-08-02 23:31:41');
INSERT INTO `weekly_tracking` VALUES ('7ab73c6a-25ff-4e8a-9ebd-9dc7d37672fc', '9cca74b3-a240-43d4-88a7-2fefde9e71c7', 5, '2026-06-08', '2026-06-14', 3, 2, 14, 14, 0, 0, 'completed', 1, NULL, NULL, 'A', '', 'volume', '2026-06-08 00:00:00', '2026-08-02 23:31:41');
INSERT INTO `weekly_tracking` VALUES ('7fda1eb5-eb31-4335-a4a4-5bc3c5552cd2', '9cca74b3-a240-43d4-88a7-2fefde9e71c7', 11, '2026-07-20', '2026-07-26', 5, 5, 14, 13, 0, 0, 'completed', 1, NULL, NULL, 'A', '', 'volume', '2026-07-20 00:00:00', '2026-08-02 23:31:41');
INSERT INTO `weekly_tracking` VALUES ('a01a072b-d0ae-4bfc-98cb-c2385aaa7405', '9cca74b3-a240-43d4-88a7-2fefde9e71c7', 9, '2026-07-06', '2026-07-12', 3, 3, 14, 11, 0, 0, 'completed', 1, NULL, NULL, 'A', '', 'volume', '2026-07-06 00:00:00', '2026-08-02 23:31:41');
INSERT INTO `weekly_tracking` VALUES ('b1ebd455-1d4e-40a4-8436-a82f162d5ffa', 'd1058562-cff7-4c8d-bf40-4938e508e8de', 2, '2026-06-22', '2026-06-28', 1, 0, 14, 13, 0, 0, 'completed', 1, NULL, NULL, 'A', '', 'volume', '2026-06-22 00:00:00', '2026-08-02 23:31:41');
INSERT INTO `weekly_tracking` VALUES ('b29ad4c7-17e4-4f5d-87e4-f90b094dc149', '9cca74b3-a240-43d4-88a7-2fefde9e71c7', 2, '2026-05-18', '2026-05-24', 1, 0, 14, 14, 0, 0, 'completed', 1, NULL, NULL, 'A', '', 'volume', '2026-05-18 00:00:00', '2026-08-02 23:31:41');
INSERT INTO `weekly_tracking` VALUES ('cc763221-2f4d-4b5f-9b62-6748818062d1', 'd1058562-cff7-4c8d-bf40-4938e508e8de', 4, '2026-07-06', '2026-07-12', 1, 0, 14, 12, 0, 0, 'completed', 1, NULL, NULL, 'A', '', 'volume', '2026-07-06 00:00:00', '2026-08-02 23:31:41');
INSERT INTO `weekly_tracking` VALUES ('e6b826a9-ab78-4b1e-9b30-6ceca6030917', 'd1058562-cff7-4c8d-bf40-4938e508e8de', 1, '2026-06-15', '2026-06-21', 1, 0, 14, 12, 0, 2, 'completed', 1, NULL, NULL, 'A', '', 'volume', '2026-06-15 00:00:00', '2026-08-25 13:18:16');
INSERT INTO `weekly_tracking` VALUES ('e990a481-1014-4233-9fd4-56e75d3ffadf', 'd1058562-cff7-4c8d-bf40-4938e508e8de', 3, '2026-06-29', '2026-07-05', 1, 0, 14, 12, 0, 0, 'completed', 1, NULL, NULL, 'A', '', 'volume', '2026-06-29 00:00:00', '2026-08-02 23:31:41');
INSERT INTO `weekly_tracking` VALUES ('f36f3c78-a58c-44f4-a9f7-4dc2f9e1eb80', 'd1058562-cff7-4c8d-bf40-4938e508e8de', 6, '2026-07-20', '2026-07-26', 3, 1, 14, 14, 0, 0, 'completed', 1, NULL, NULL, 'A', '', 'volume', '2026-07-20 00:00:00', '2026-08-02 23:31:41');

SET FOREIGN_KEY_CHECKS = 1;
