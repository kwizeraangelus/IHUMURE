-- Ihumure — Smart Alcohol Abuse Prevention & Rehabilitation Support System
-- Import this in phpMyAdmin (Import tab) or MySQL Workbench.
-- Database: ihumure

CREATE DATABASE IF NOT EXISTS ihumure
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE ihumure;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS videos;
DROP TABLE IF EXISTS stories;
DROP TABLE IF EXISTS messages;
DROP TABLE IF EXISTS referrals;
DROP TABLE IF EXISTS content;
DROP TABLE IF EXISTS screenings;
DROP TABLE IF EXISTS counsellors;
DROP TABLE IF EXISTS users;
SET FOREIGN_KEY_CHECKS = 1;

-- People using the system: anonymous consumers, counsellors, admin
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  anon_code VARCHAR(20) NOT NULL UNIQUE COMMENT 'Private ID e.g. IH-4F8K2A',
  role ENUM('consumer','counsellor','admin') NOT NULL DEFAULT 'consumer',
  display_name VARCHAR(120) NULL,
  email VARCHAR(160) NULL UNIQUE,
  password_hash VARCHAR(255) NULL,
  pin_hash VARCHAR(255) NULL COMMENT '4-digit PIN for anonymous return',
  district VARCHAR(80) NULL,
  phone VARCHAR(30) NULL,
  share_contact TINYINT(1) NOT NULL DEFAULT 0,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Counsellor profile (one row per counsellor user)
CREATE TABLE counsellors (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  category ENUM('public','private','personal') NOT NULL,
  facility_name VARCHAR(160) NULL,
  certificate_file VARCHAR(255) NULL,
  verified TINYINT(1) NOT NULL DEFAULT 0,
  verified_at DATETIME NULL,
  reject_reason TEXT NULL,
  active TINYINT(1) NOT NULL DEFAULT 1,
  district VARCHAR(80) NOT NULL,
  bio TEXT NULL,
  session_fee DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_counsellors_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- WHO AUDIT results stored against the private user ID
CREATE TABLE screenings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  answers TEXT NOT NULL COMMENT 'JSON of 10 question scores',
  score INT NOT NULL,
  risk_zone ENUM('low','hazardous','harmful','dependence') NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_screenings_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Awareness, FAQ and self-help tips (managed by admin)
CREATE TABLE content (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(200) NOT NULL,
  body TEXT NOT NULL,
  type ENUM('faq','awareness','tip') NOT NULL,
  published TINYINT(1) NOT NULL DEFAULT 1,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Private consumer → counsellor support requests
CREATE TABLE referrals (
  id INT AUTO_INCREMENT PRIMARY KEY,
  consumer_id INT NOT NULL,
  counsellor_id INT NOT NULL,
  screening_id INT NULL,
  risk_zone VARCHAR(20) NOT NULL,
  status ENUM('submitted','acknowledged','contacted','ongoing','closed','declined') NOT NULL DEFAULT 'submitted',
  share_contact TINYINT(1) NOT NULL DEFAULT 0,
  payment_status VARCHAR(20) NULL,
  payment_amount DECIMAL(10,2) NULL,
  notes TEXT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_referrals_consumer FOREIGN KEY (consumer_id) REFERENCES users(id) ON DELETE CASCADE,
  CONSTRAINT fk_referrals_counsellor FOREIGN KEY (counsellor_id) REFERENCES counsellors(id) ON DELETE CASCADE,
  CONSTRAINT fk_referrals_screening FOREIGN KEY (screening_id) REFERENCES screenings(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 1:1 chat on an accepted referral
CREATE TABLE messages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  referral_id INT NOT NULL,
  sender_id INT NOT NULL,
  sender_role ENUM('consumer','counsellor') NOT NULL,
  body TEXT NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_messages_referral FOREIGN KEY (referral_id) REFERENCES referrals(id) ON DELETE CASCADE,
  CONSTRAINT fk_messages_sender FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Recovery stories (public only after admin approval)
CREATE TABLE stories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  title VARCHAR(200) NOT NULL,
  body TEXT NOT NULL,
  approved TINYINT(1) NOT NULL DEFAULT 0,
  show_counsellor_prompt TINYINT(1) NOT NULL DEFAULT 1,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_stories_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Counsellor guidance videos
CREATE TABLE videos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  counsellor_id INT NOT NULL,
  title VARCHAR(200) NOT NULL,
  description TEXT NULL,
  file_path VARCHAR(255) NOT NULL,
  is_public TINYINT(1) NOT NULL DEFAULT 0,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_videos_counsellor FOREIGN KEY (counsellor_id) REFERENCES counsellors(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
