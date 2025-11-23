<?php
// Initialization file to handle proper path resolution for all page files
$root_path = dirname(__DIR__);

// Include required files using absolute paths
require_once $root_path . '/config.php';
require_once $root_path . '/includes/functions.php';
require_once $root_path . '/includes/db_connect.php';
require_once $root_path . '/includes/auth_check.php';
?>