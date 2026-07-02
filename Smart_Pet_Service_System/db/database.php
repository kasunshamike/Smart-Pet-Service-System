<?php
/**
 * Database connection using PDO.
 * Update DB_* constants to match your MySQL setup before running the site.
 *
 * On first connection: creates the database if it is missing (errno 1049) and
 * ensures core tables exist so registration works even if schema.sql was not imported.
 */
define('DB_HOST', 'localhost');
define('DB_NAME', 'pet_sitting_db');
define('DB_CHARSET', 'utf8mb4');
define('DB_USER', 'root');
define('DB_PASS', '');

/**
 * Creates tables when missing (matches db/schema.sql). Safe to run every request; uses IF NOT EXISTS.
 */
function pet_sitting_bootstrap_schema(PDO $pdo): void
{
    $pdo->exec(
        'CREATE TABLE IF NOT EXISTS users (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(120) NOT NULL,
            email VARCHAR(190) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci'
    );

    $pdo->exec(
        'CREATE TABLE IF NOT EXISTS admins (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(80) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci'
    );

    $pdo->exec(
        'CREATE TABLE IF NOT EXISTS pets (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id INT UNSIGNED NOT NULL,
            name VARCHAR(100) NOT NULL,
            type ENUM(\'Dog\', \'Cat\', \'Other\') NOT NULL,
            breed VARCHAR(100) DEFAULT NULL,
            age INT UNSIGNED DEFAULT NULL,
            notes TEXT DEFAULT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci'
    );

    $pdo->exec(
        'CREATE TABLE IF NOT EXISTS bookings (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id INT UNSIGNED NOT NULL,
            owner_name VARCHAR(120) NOT NULL,
            phone VARCHAR(40) NOT NULL,
            pet_name VARCHAR(120) NOT NULL,
            pet_type VARCHAR(80) NOT NULL,
            service VARCHAR(120) NOT NULL,
            booking_date DATE NOT NULL,
            message TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci'
    );

    $pdo->exec(
        'CREATE TABLE IF NOT EXISTS contacts (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(120) NOT NULL,
            email VARCHAR(190) NOT NULL,
            message TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci'
    );

    // Demo admin: username admin / password password (same hash as db/schema.sql)
    $stmt = $pdo->prepare('INSERT IGNORE INTO admins (username, password) VALUES (:u, :p)');
    $stmt->execute([
        ':u' => 'admin',
        ':p' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    ]);
}

/**
 * Returns a shared PDO instance (singleton-style).
 *
 * @return PDO
 */
function get_db(): PDO
{
    static $pdo = null;
    if ($pdo !== null) {
        return $pdo;
    }

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    $dsnWithDb = sprintf(
        'mysql:host=%s;dbname=%s;charset=%s',
        DB_HOST,
        DB_NAME,
        DB_CHARSET
    );

    try {
        $pdo = new PDO($dsnWithDb, DB_USER, DB_PASS, $options);
    } catch (PDOException $e) {
        $errno = isset($e->errorInfo[1]) ? (int) $e->errorInfo[1] : 0;
        // Unknown database — create it if MySQL user has privilege
        if ($errno === 1049) {
            $serverDsn = sprintf('mysql:host=%s;charset=%s', DB_HOST, DB_CHARSET);
            $server = new PDO($serverDsn, DB_USER, DB_PASS, $options);
            $safeDb = '`' . str_replace('`', '``', DB_NAME) . '`';
            $server->exec(
                'CREATE DATABASE IF NOT EXISTS ' . $safeDb . ' CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci'
            );
            $pdo = new PDO($dsnWithDb, DB_USER, DB_PASS, $options);
        } else {
            throw $e;
        }
    }

    pet_sitting_bootstrap_schema($pdo);

    return $pdo;
}