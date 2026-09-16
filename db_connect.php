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
