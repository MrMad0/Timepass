<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    die("Not authorized");
}

echo "<h2>Debug Update Course</h2>";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo "<h3>POST Data Received:</h3>";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    
    echo "<h3>FILES Data Received:</h3>";
    echo "<pre>";
    print_r($_FILES);
    echo "</pre>";
    
    // Test the update function
    $result = updateCourse($_POST, $_FILES);
    echo "<h3>Update Result:</h3>";
    echo "<p>$result</p>";
    
    // Check if the course was actually updated
    if (isset($_POST['course_id'])) {
        $course = getCourseById($_POST['course_id']);
        echo "<h3>Updated Course Data:</h3>";
        echo "<pre>";
        print_r($course);
        echo "</pre>";
    }
} else {
    echo "<p>No POST data received. This page is for debugging the update functionality.</p>";
}
?>
