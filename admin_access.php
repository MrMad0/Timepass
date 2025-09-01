<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

// Create admin user if not exists
createAdminUser();

// Redirect to admin panel
header('Location: admin/');
exit();
?>
