<?php
/**
 * Example configuration file.
 * 
 * Copy this file to `config.php` and insert your own database credentials.
 */

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'YOUR_DB_USERNAME');
define('DB_PASSWORD', 'YOUR_DB_PASSWORD');
define('DB_NAME', 'mindflix');

// Database connection
$db_conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($db_conn === false) {
    die("Database connection failed: " . mysqli_connect_error());
}
