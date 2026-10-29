-- =====================================================
-- database.sql : Struktur database + data contoh
-- Import lewat phpMyAdmin (tab Import) atau CLI MySQL
-- =====================================================

CREATE DATABASE IF NOT EXISTS db_mahasiswa
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE db_mahasiswa;

-- Hapus tabel lama (agar import ulang tidak error)
DROP TABLE IF EXISTS mahasiswa;
DROP TABLE IF EXISTS users;

-- -----------------------------------------------------
-- Tabel users (untuk login)
-- -----------------------------------------------------
CREATE TABLE users (
    id         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    username   VARCHAR(50)  NOT NULL,
    password   VARCHAR(255) NOT NULL,           -- hasil password_hash()
    created_at TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_users_username (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------
-- Tabel mahasiswa
-- -----------------------------------------------------
CREATE TABLE mahasiswa (
    id         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    nim        VARCHAR(20)  NOT NULL,
    nama       VARCHAR(100) NOT NULL,
    email      VARCHAR(100) NOT NULL,
    jurusan    VARCHAR(100) NOT NULL,
    no_hp      VARCHAR(15)  NOT NULL,
    created_at TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_mahasiswa_nim (nim)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------
-- User admin  (username: admin | password: admin123)
-- -----------------------------------------------------
INSERT INTO users (username, password) VALUES
('admin', '$2y$10$4tkcPcoCfR3Nw2ZijCf1N.Qtd6peSLf24/DdPJEZF.W5g.9mcKRsm');

-- -----------------------------------------------------
-- 5 data contoh mahasiswa
-- -----------------------------------------------------
INSERT INTO mahasiswa (nim, nama, email, jurusan, no_hp) VALUES
('2210511001', 'Budi Santoso',   'budi.santoso@example.com',   'Teknik Informatika', '081234567801'),
('2210511002', 'Siti Nurhaliza', 'siti.nurhaliza@example.com', 'Sistem Informasi',   '081234567802'),
('2210511003', 'Andi Pratama',   'andi.pratama@example.com',   'Teknik Elektro',     '081234567803'),
('2210511004', 'Dewi Lestari',   'dewi.lestari@example.com',   'Manajemen',          '081234567804'),
('2210511005', 'Rizky Ramadhan', 'rizky.ramadhan@example.com', 'Akuntansi',          '081234567805');
