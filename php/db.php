<?php
$host = getenv("DB_HOST");
$username = getenv("DB_USER");
$password = getenv("DB_PASSWORD");
$database = getenv("DB_NAME");
$port = (int) (getenv("DB_PORT") ?: 3306);

$conn = mysqli_init();

mysqli_ssl_set($conn, null, null, null, null, null);

if (!mysqli_real_connect(
    $conn,
    $host,
    $username,
    $password,
    $database,
    $port,
    null,
    MYSQLI_CLIENT_SSL
)) {
    error_log("Database connection failed: " . mysqli_connect_error());
    http_response_code(500);
    die("Database connection failed.");
}

?>