<?php
// Centralized Database Connection
// Compatible with both Local XAMPP and Cloud Deployment (via Environment Variables)

$servername = getenv('DB_HOST') ?: 'localhost';
$username   = getenv('DB_USER') ?: 'root';
$password   = getenv('DB_PASSWORD') !== false ? getenv('DB_PASSWORD') : '';
$database   = getenv('DB_NAME') ?: 'nationalpark';
$port       = getenv('DB_PORT') ? (int)getenv('DB_PORT') : 3306;

// Determine if SSL is required (for cloud MySQL providers like TiDB Serverless / Aiven)
$use_ssl = (getenv('DB_SSL') === 'true' || $port === 4000);

if (!isset($conn) || !($conn instanceof mysqli)) {
    $conn = mysqli_init();
    if (!$conn) {
        die("mysqli_init failed");
    }

    $conn->options(MYSQLI_OPT_CONNECT_TIMEOUT, 10);

    if ($use_ssl) {
        mysqli_ssl_set($conn, NULL, NULL, NULL, NULL, NULL);
        $connected = @$conn->real_connect($servername, $username, $password, $database, $port, NULL, MYSQLI_CLIENT_SSL);
    } else {
        $connected = @$conn->real_connect($servername, $username, $password, $database, $port);
    }

    if (!$connected) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    $conn->set_charset("utf8mb4");

    // Expose $db as well for scripts expecting $db
    $db = $conn;

    // Self-healing database initialization: ensure all tables and seed records exist
    static $schema_verified = false;
    if (!$schema_verified) {
        $schema_verified = true;
        $needs_init = false;
        try {
            $test_query = @$conn->query("SELECT COUNT(*) FROM animals");
            if (!$test_query || (int)($test_query->fetch_row()[0] ?? 0) === 0) {
                $needs_init = true;
            }
        } catch (Throwable $e) {
            $needs_init = true;
        }

        if ($needs_init && file_exists(__DIR__ . '/database.sql')) {
            $sql_content = file_get_contents(__DIR__ . '/database.sql');
            $lines = explode("\n", $sql_content);
            $clean_sql = '';
            foreach ($lines as $line) {
                $trimmed = trim($line);
                if ($trimmed !== '' && strpos($trimmed, '--') !== 0) {
                    $clean_sql .= $line . "\n";
                }
            }
            $queries = explode(';', $clean_sql);
            foreach ($queries as $q) {
                $q = trim($q);
                if (!empty($q)) {
                    try {
                        @$conn->query($q);
                    } catch (Throwable $e) {
                        // ignore individual errors
                    }
                }
            }
        }

        // Ensure Description and animal_type exist if table was already created earlier
        try {
            @$conn->query("ALTER TABLE `animals` ADD COLUMN IF NOT EXISTS `Description` TEXT");
            @$conn->query("ALTER TABLE `animals` ADD COLUMN IF NOT EXISTS `animal_type` VARCHAR(50) DEFAULT 'Mammal'");
            @$conn->query("ALTER TABLE `animals` ADD COLUMN IF NOT EXISTS `category` VARCHAR(50) DEFAULT 'Carnivore'");
            @$conn->query("ALTER TABLE `animals` MODIFY COLUMN `Status` VARCHAR(50) DEFAULT 'Present'");
        } catch (Throwable $e) {
            // ignore if unsupported
        }
    }
}

// Expose $pdo for scripts using PDO
if (!isset($pdo) || !($pdo instanceof PDO)) {
    try {
        $dsn = "mysql:host={$servername};port={$port};dbname={$database};charset=utf8mb4";
        $pdo_options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];
        if ($use_ssl) {
            $pdo_options[PDO::MYSQL_ATTR_SSL_CA] = true;
            $pdo_options[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = false;
        }
        $pdo = new PDO($dsn, $username, $password, $pdo_options);
    } catch (PDOException $e) {
        $pdo = null;
    }
}
?>
