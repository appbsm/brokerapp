<?php
include('includes/config_path.php');
// Get the filename from the query string
if(isset($_GET['filename'])) {
    $filename = $_GET['filename'];
    $imagePath = $sourceFilePath.$filename;

    // Check if the file exists
    if(file_exists($imagePath)) {
        // Set the appropriate header for the image
        header('Content-Type: image/jpeg'); // Adjust MIME type if needed

        // Output the image
        readfile($imagePath);
        exit;
    } else {
        // Image not found, return a 404 error
        http_response_code(404);
        exit('Image not found.');
    }
} else {
    // No filename provided, return a 400 error
    http_response_code(400);
    exit('No filename provided.');
}
?>
