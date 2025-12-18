<?php
/**
 * Index Page - Display All Movie Reviews (READ Operation)
 * Shows all movies in a Bootstrap table with charts
 * 
 * @author Senior PHP Developer
 * @date December 17, 2025
 */

// Set page title
$pageTitle = 'Home - All Movies';

// Include database configuration
require_once '../config/database.php';

// Initialize variables
$movies = [];
$ratingData = [];
$genreData = [];
$errorMessage = '';
$successMessage = '';

// Check for success/error messages from redirects
if (isset($_GET['success'])) {
    switch ($_GET['success']) {
        case 'added':
            $successMessage = 'Movie review added successfully!';
            break;
        case 'updated':
            $successMessage = 'Movie review updated successfully!';
            break;
        case 'deleted':
            $successMessage = 'Movie review deleted successfully!';
            break;
    }
}

if (isset($_GET['error'])) {
    $errorMessage = 'An error occurred. Please try again.';
}

try {
    // Fetch all movies ordered by latest first
    $stmt = $pdo->prepare("SELECT * FROM movies ORDER BY created_at DESC");
    $stmt->execute();
    $movies = $stmt->fetchAll();
    
    // Fetch rating distribution for Chart.js
    $stmtRating = $pdo->prepare("
        SELECT rating, COUNT(*) as count 
        FROM movies 
        GROUP BY rating 
        ORDER BY rating
    ");
    $stmtRating->execute();
    $ratingData = $stmtRating->fetchAll();
    
    // Fetch genre distribution for Chart.js
    $stmtGenre = $pdo->prepare("
        SELECT genre, COUNT(*) as count 
        FROM movies 
        GROUP BY genre 
        ORDER BY count DESC
    ");
    $stmtGenre->execute();
    $genreData = $stmtGenre->fetchAll();
    
} catch (PDOException $e) {
    error_log("Database Query Error: " . $e->getMessage());
    $errorMessage = 'Failed to fetch movie data. Please try again later.';
}

// Include header template
include '../templates/header.php';
?>

<!-- Page Header -->
<div class="row mb-4">
    <div class="col-md-12">
        <h1 class="display-4 text-center mb-3">
            <i class="bi bi-film"></i> Movie Rating & Review System
        </h1>
        <p class="lead text-center text-muted">
            Discover, Review, and Rate Your Favorite Movies
        </p>
    </div>
</div>

<!-- Alert Messages -->
<?php if ($successMessage): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill"></i> <?php echo htmlspecialchars($successMessage); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if ($errorMessage): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill"></i> <?php echo htmlspecialchars($errorMessage); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Add New Movie Button -->
<div class="row mb-4">
    <div class="col-md-12">
        <a href="add.php" class="btn btn-primary btn-lg">
            <i class="bi bi-plus-circle"></i> Add New Movie Review
        </a>
        <?php if (!empty($ratingData) || !empty($genreData)): ?>
        <button type="button" class="btn btn-success btn-lg ms-2" data-bs-toggle="modal" data-bs-target="#chartsModal">
            <i class="bi bi-bar-chart-fill"></i> View Statistics
        </button>
        <?php endif; ?>
        <span class="badge bg-secondary ms-2 fs-6">
            Total Reviews: <?php echo count($movies); ?>
        </span>
    </div>
</div>

<!-- Movies Table -->
<div class="row">
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header bg-dark text-white">
                <h4 class="mb-0"><i class="bi bi-list-ul"></i> All Movie Reviews</h4>
            </div>
            <div class="card-body">
                <?php if (count($movies) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Movie Name</th>
                                    <th>Genre</th>
                                    <th>Rating</th>
                                    <th>Review</th>
                                    <th>Reviewer</th>
                                    <th>Date Added</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($movies as $index => $movie): ?>
                                <tr>
                                    <td><?php echo $index + 1; ?></td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($movie['movie_name']); ?></strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">
                                            <?php echo htmlspecialchars($movie['genre']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php 
                                        // Display stars based on rating
                                        for ($i = 1; $i <= 5; $i++) {
                                            if ($i <= $movie['rating']) {
                                                echo '<i class="bi bi-star-fill text-warning"></i>';
                                            } else {
                                                echo '<i class="bi bi-star text-muted"></i>';
                                            }
                                        }
                                        ?>
                                        <span class="badge bg-warning text-dark ms-1">
                                            <?php echo $movie['rating']; ?>/5
                                        </span>
                                    </td>
                                    <td>
                                        <?php 
                                        // Truncate long reviews
                                        $review = htmlspecialchars($movie['review']);
                                        echo strlen($review) > 100 ? substr($review, 0, 100) . '...' : $review;
                                        ?>
                                    </td>
                                    <td>
                                        <i class="bi bi-person-fill"></i> 
                                        <?php echo htmlspecialchars($movie['reviewer']); ?>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <?php echo date('M d, Y', strtotime($movie['created_at'])); ?>
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="edit.php?id=<?php echo $movie['id']; ?>" 
                                               class="btn btn-warning" 
                                               title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <a href="delete.php?id=<?php echo $movie['id']; ?>" 
                                               class="btn btn-danger" 
                                               title="Delete"
                                               onclick="return confirm('Are you sure you want to delete this movie review?');">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info text-center">
                        <i class="bi bi-info-circle"></i> No movie reviews found. 
                        <a href="add.php" class="alert-link">Add your first review!</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Charts Modal -->
<div class="modal fade" id="chartsModal" tabindex="-1" aria-labelledby="chartsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="chartsModalLabel">
                    <i class="bi bi-graph-up"></i> Movie Statistics
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Rating Distribution Chart -->
                    <div class="col-md-6 mb-4">
                        <div class="card shadow">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="bi bi-star-fill"></i> Rating Distribution</h5>
                            </div>
                            <div class="card-body" style="height: 400px;">
                                <canvas id="ratingChart" width="500" height="400"></canvas>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Genre Distribution Chart -->
                    <div class="col-md-6 mb-4">
                        <div class="card shadow">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0"><i class="bi bi-collection-fill"></i> Genre Distribution</h5>
                            </div>
                            <div class="card-body" style="height: 400px;">
                                <canvas id="genreChart" width="500" height="400"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Pass data to JavaScript for charts -->
<script>
    // Rating distribution data
    const ratingLabels = <?php echo json_encode(array_column($ratingData, 'rating')); ?>;
    const ratingCounts = <?php echo json_encode(array_column($ratingData, 'count')); ?>;
    
    // Genre distribution data
    const genreLabels = <?php echo json_encode(array_column($genreData, 'genre')); ?>;
    const genreCounts = <?php echo json_encode(array_column($genreData, 'count')); ?>;
</script>

<?php
// Include footer template
include '../templates/footer.php';
?>
