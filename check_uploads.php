<?php
// Check upload directories
$uploadDirs = [
    'uploads/videos',
    'uploads/thumbnails',
    '../uploads/videos',
    '../uploads/thumbnails'
];

echo "<h2>Upload Directory Check</h2>";

foreach ($uploadDirs as $dir) {
    echo "<h3>Checking: $dir</h3>";
    
    if (file_exists($dir)) {
        echo "<p style='color: green;'>✓ Directory exists</p>";
        
        if (is_writable($dir)) {
            echo "<p style='color: green;'>✓ Directory is writable</p>";
        } else {
            echo "<p style='color: red;'>✗ Directory is NOT writable</p>";
        }
    } else {
        echo "<p style='color: red;'>✗ Directory does NOT exist</p>";
        
        // Try to create it
        if (mkdir($dir, 0755, true)) {
            echo "<p style='color: green;'>✓ Directory created successfully</p>";
        } else {
            echo "<p style='color: red;'>✗ Failed to create directory</p>";
        }
    }
    
    echo "<hr>";
}
?>
