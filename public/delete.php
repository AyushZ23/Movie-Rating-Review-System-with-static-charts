<?php
/**
 * Delete Movie Page - Remove Movie Review (DELETE Operation)
 * Securely delete movie reviews by ID
 * 
 * @author Senior PHP Developer
 * @date December 17, 2025
 */

// Include database configuration
require_once '../config/database.php';

// Check if ID is provided in URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php?error=no_id');
    exit;
}

// Validate and sanitize the ID
$movieId = filter_var($_GET['id'], FILTER_VALIDATE_INT);

if ($movieId === false || $movieId <= 0) {
    header('Location: index.php?error=invalid_id');
    exit;
}

try {
    // First, check if the movie exists
    $checkStmt = $pdo->prepare("SELECT id FROM movies WHERE id = :id");
    $checkStmt->bindParam(':id', $movieId, PDO::PARAM_INT);
    $checkStmt->execute();
    
    if ($checkStmt->rowCount() === 0) {
        // Movie not found
        header('Location: index.php?error=not_found');
        exit;
    }
    
    // Prepare DELETE statement with PDO
    $stmt = $pdo->prepare("DELETE FROM movies WHERE id = :id");
    $stmt->bindParam(':id', $movieId, PDO::PARAM_INT);
    
    // Execute the delete operation
    if ($stmt->execute()) {
        // Redirect to index page with success message
        header('Location: index.php?success=deleted');
        exit;
    } else {
        // Delete failed
        header('Location: index.php?error=delete_failed');
        exit;
    }
    
} catch (PDOException $e) {
    // Log the error and redirect with error message
    error_log("Database Delete Error: " . $e->getMessage());
    header('Location: index.php?error=database');
    exit;
}
?>
