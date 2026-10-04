<?php

function install_schema(PDO $pdo): void
{
    $driver = $pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
    $id = $driver === 'mysql' ? 'INT AUTO_INCREMENT PRIMARY KEY' : 'INTEGER PRIMARY KEY AUTOINCREMENT';
    $dt = $driver === 'mysql' ? 'DATETIME DEFAULT CURRENT_TIMESTAMP' : "TEXT DEFAULT (datetime('now'))";

    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id $id,
        anon_code VARCHAR(20) NOT NULL UNIQUE,
        role VARCHAR(20) NOT NULL DEFAULT 'consumer',
        display_name VARCHAR(120) NULL,
        email VARCHAR(160) NULL UNIQUE,
        password_hash VARCHAR(255) NULL,
        pin_hash VARCHAR(255) NULL,
        district VARCHAR(80) NULL,
        phone VARCHAR(30) NULL,
        share_contact INTEGER NOT NULL DEFAULT 0,
        created_at $dt
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS counsellors (
        id $id,
        user_id INTEGER NOT NULL,
        category VARCHAR(20) NOT NULL,
        facility_name VARCHAR(160) NULL,
        certificate_file VARCHAR(255) NULL,
        verified INTEGER NOT NULL DEFAULT 0,
        verified_at VARCHAR(40) NULL,
        reject_reason TEXT NULL,
        active INTEGER NOT NULL DEFAULT 1,
        district VARCHAR(80) NOT NULL,
        bio TEXT NULL,
        session_fee DECIMAL(10,2) NOT NULL DEFAULT 0,
        created_at $dt
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS screenings (
        id $id,
        user_id INTEGER NOT NULL,
        answers TEXT NOT NULL,
        score INTEGER NOT NULL,
        risk_zone VARCHAR(20) NOT NULL,
        created_at $dt
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS content (
        id $id,
        title VARCHAR(200) NOT NULL,
        body TEXT NOT NULL,
        type VARCHAR(20) NOT NULL,
        published INTEGER NOT NULL DEFAULT 1,
        created_at $dt
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS referrals (
        id $id,
        consumer_id INTEGER NOT NULL,
        counsellor_id INTEGER NOT NULL,
        screening_id INTEGER NULL,
        risk_zone VARCHAR(20) NOT NULL,
        status VARCHAR(20) NOT NULL DEFAULT 'submitted',
        share_contact INTEGER NOT NULL DEFAULT 0,
        payment_status VARCHAR(20) NULL,
        payment_amount DECIMAL(10,2) NULL,
        notes TEXT NULL,
        created_at $dt,
        updated_at $dt
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS messages (
        id $id,
        referral_id INTEGER NOT NULL,
        sender_id INTEGER NOT NULL,
        sender_role VARCHAR(20) NOT NULL,
        body TEXT NOT NULL,
        created_at $dt
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS stories (
        id $id,
        user_id INTEGER NOT NULL,
        title VARCHAR(200) NOT NULL,
        body TEXT NOT NULL,
        approved INTEGER NOT NULL DEFAULT 0,
        show_counsellor_prompt INTEGER NOT NULL DEFAULT 1,
        created_at $dt
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS videos (
        id $id,
        counsellor_id INTEGER NOT NULL,
        title VARCHAR(200) NOT NULL,
        description TEXT NULL,
        file_path VARCHAR(255) NOT NULL,
        is_public INTEGER NOT NULL DEFAULT 0,
        created_at $dt
    )");
}
