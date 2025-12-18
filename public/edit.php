<?php
/**
 * Edit Movie Page - Update Existing Movie Review (UPDATE Operation)
 * Pre-filled form with validation to update movie reviews
 * 
 * @author Senior PHP Developer
 * @date December 17, 2025
 */

// Set page title
$pageTitle = 'Edit Movie Review';

// Include database configuration
require_once '../config/database.php';

// Initialize variables
$errors = [];
$movie = null;
$movieId = null;

// Check if ID is provided in URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php?error=no_id');
    exit;
}

$movieId = filter_var($_GET['id'], FILTER_VALIDATE_INT);

if ($movieId === false || $movieId <= 0) {
    header('Location: index.php?error=invalid_id');
    exit;
}

// Fetch movie data from database
try {
    $stmt = $pdo->prepare("SELECT * FROM movies WHERE id = :id");
    $stmt->bindParam(':id', $movieId, PDO::PARAM_INT);
    $stmt->execute();
    $movie = $stmt->fetch();
    
    // Check if movie exists
    if (!$movie) {
        header('Location: index.php?error=not_found');
        exit;
    }
    
} catch (PDOException $e) {
    error_log("Database Fetch Error: " . $e->getMessage());
    header('Location: index.php?error=database');
    exit;
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and retrieve form inputs
    $formData = [
        'movie_name' => trim($_POST['movie_name'] ?? ''),
        'genre' => trim($_POST['genre'] ?? ''),
        'rating' => trim($_POST['rating'] ?? ''),
        'review' => trim($_POST['review'] ?? ''),
        'reviewer' => trim($_POST['reviewer'] ?? '')
    ];
    
    // Server-side validation
    if (empty($formData['movie_name'])) {
        $errors[] = 'Movie name is required.';
    } elseif (strlen($formData['movie_name']) > 255) {
        $errors[] = 'Movie name must not exceed 255 characters.';
    }
    
    if (empty($formData['genre'])) {
        $errors[] = 'Genre is required.';
    } elseif (strlen($formData['genre']) > 100) {
        $errors[] = 'Genre must not exceed 100 characters.';
    }
    
    if (empty($formData['rating'])) {
        $errors[] = 'Rating is required.';
    } elseif (!is_numeric($formData['rating']) || $formData['rating'] < 1 || $formData['rating'] > 5) {
        $errors[] = 'Rating must be between 1 and 5.';
    }
    
    if (empty($formData['review'])) {
        $errors[] = 'Review is required.';
    } elseif (strlen($formData['review']) < 10) {
        $errors[] = 'Review must be at least 10 characters long.';
    }
    
    if (empty($formData['reviewer'])) {
        $errors[] = 'Reviewer name is required.';
    } elseif (strlen($formData['reviewer']) > 255) {
        $errors[] = 'Reviewer name must not exceed 255 characters.';
    }
    
    // If no validation errors, update database
    if (empty($errors)) {
        try {
            // Prepare UPDATE statement with PDO
            $sql = "UPDATE movies 
                    SET movie_name = :movie_name, 
                        genre = :genre, 
                        rating = :rating, 
                        review = :review, 
                        reviewer = :reviewer 
                    WHERE id = :id";
            
            $stmt = $pdo->prepare($sql);
            
            // Bind parameters to prevent SQL injection
            $stmt->bindParam(':movie_name', $formData['movie_name'], PDO::PARAM_STR);
            $stmt->bindParam(':genre', $formData['genre'], PDO::PARAM_STR);
            $stmt->bindParam(':rating', $formData['rating'], PDO::PARAM_INT);
            $stmt->bindParam(':review', $formData['review'], PDO::PARAM_STR);
            $stmt->bindParam(':reviewer', $formData['reviewer'], PDO::PARAM_STR);
            $stmt->bindParam(':id', $movieId, PDO::PARAM_INT);
            
            // Execute the statement
            if ($stmt->execute()) {
                // Redirect to index page with success message
                header('Location: index.php?success=updated');
                exit;
            } else {
                $errors[] = 'Failed to update movie review. Please try again.';
            }
            
        } catch (PDOException $e) {
            error_log("Database Update Error: " . $e->getMessage());
            $errors[] = 'Database error occurred. Please try again later.';
        }
    } else {
        // Update movie array with form data to preserve user input
        $movie['movie_name'] = $formData['movie_name'];
        $movie['genre'] = $formData['genre'];
        $movie['rating'] = $formData['rating'];
        $movie['review'] = $formData['review'];
        $movie['reviewer'] = $formData['reviewer'];
    }
}

// Include header template
include '../templates/header.php';
?>

<!-- Page Header -->
<div class="row mb-4">
    <div class="col-md-12">
        <h2 class="mb-3">
            <i class="bi bi-pencil-square"></i> Edit Movie Review
        </h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Edit Movie</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Display Validation Errors -->
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <h5 class="alert-heading"><i class="bi bi-exclamation-triangle-fill"></i> Validation Errors:</h5>
        <ul class="mb-0">
            <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Edit Movie Form -->
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card shadow">
            <div class="card-header bg-warning">
                <h4 class="mb-0"><i class="bi bi-film"></i> Update Movie Review</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="edit.php?id=<?php echo $movieId; ?>" class="needs-validation" novalidate>
                    
                    <!-- Movie Name -->
                    <div class="mb-3">
                        <label for="movie_name" class="form-label">
                            <i class="bi bi-camera-reels"></i> Movie Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control <?php echo isset($errors[0]) && strpos($errors[0], 'Movie name') !== false ? 'is-invalid' : ''; ?>" 
                               id="movie_name" 
                               name="movie_name" 
                               value="<?php echo htmlspecialchars($movie['movie_name']); ?>" 
                               placeholder="Enter movie name" 
                               maxlength="255"
                               required>
                        <div class="form-text">Enter the full name of the movie</div>
                    </div>
                    
                    <!-- Genre -->
                    <div class="mb-3">
                        <label for="genre" class="form-label">
                            <i class="bi bi-tags"></i> Genre <span class="text-danger">*</span>
                        </label>
                        <select class="form-select <?php echo isset($errors[0]) && strpos($errors[0], 'Genre') !== false ? 'is-invalid' : ''; ?>" 
                                id="genre" 
                                name="genre" 
                                required>
                            <option value="">-- Select Genre --</option>
                            <option value="Action" <?php echo $movie['genre'] === 'Action' ? 'selected' : ''; ?>>Action</option>
                            <option value="Adventure" <?php echo $movie['genre'] === 'Adventure' ? 'selected' : ''; ?>>Adventure</option>
                            <option value="Animation" <?php echo $movie['genre'] === 'Animation' ? 'selected' : ''; ?>>Animation</option>
                            <option value="Comedy" <?php echo $movie['genre'] === 'Comedy' ? 'selected' : ''; ?>>Comedy</option>
                            <option value="Crime" <?php echo $movie['genre'] === 'Crime' ? 'selected' : ''; ?>>Crime</option>
                            <option value="Drama" <?php echo $movie['genre'] === 'Drama' ? 'selected' : ''; ?>>Drama</option>
                            <option value="Fantasy" <?php echo $movie['genre'] === 'Fantasy' ? 'selected' : ''; ?>>Fantasy</option>
                            <option value="Horror" <?php echo $movie['genre'] === 'Horror' ? 'selected' : ''; ?>>Horror</option>
                            <option value="Mystery" <?php echo $movie['genre'] === 'Mystery' ? 'selected' : ''; ?>>Mystery</option>
                            <option value="Romance" <?php echo $movie['genre'] === 'Romance' ? 'selected' : ''; ?>>Romance</option>
                            <option value="Sci-Fi" <?php echo $movie['genre'] === 'Sci-Fi' ? 'selected' : ''; ?>>Sci-Fi</option>
                            <option value="Thriller" <?php echo $movie['genre'] === 'Thriller' ? 'selected' : ''; ?>>Thriller</option>
                        </select>
                        <div class="form-text">Select the movie genre</div>
                    </div>
                    
                    <!-- Rating -->
                    <div class="mb-3">
                        <label for="rating" class="form-label">
                            <i class="bi bi-star-fill"></i> Rating <span class="text-danger">*</span>
                        </label>
                        <div class="rating-input">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" 
                                           type="radio" 
                                           name="rating" 
                                           id="rating<?php echo $i; ?>" 
                                           value="<?php echo $i; ?>"
                                           <?php echo $movie['rating'] == $i ? 'checked' : ''; ?>
                                           required>
                                    <label class="form-check-label" for="rating<?php echo $i; ?>">
                                        <?php echo $i; ?> <i class="bi bi-star-fill text-warning"></i>
                                    </label>
                                </div>
                            <?php endfor; ?>
                        </div>
                        <div class="form-text">Rate the movie from 1 (poor) to 5 (excellent)</div>
                    </div>
                    
                    <!-- Review -->
                    <div class="mb-3">
                        <label for="review" class="form-label">
                            <i class="bi bi-chat-left-text"></i> Review <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control <?php echo isset($errors[0]) && strpos($errors[0], 'Review') !== false ? 'is-invalid' : ''; ?>" 
                                  id="review" 
                                  name="review" 
                                  rows="5" 
                                  placeholder="Write your review here..." 
                                  minlength="10"
                                  required><?php echo htmlspecialchars($movie['review']); ?></textarea>
                        <div class="form-text">Share your thoughts about the movie (minimum 10 characters)</div>
                    </div>
                    
                    <!-- Reviewer Name -->
                    <div class="mb-3">
                        <label for="reviewer" class="form-label">
                            <i class="bi bi-person"></i> Your Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control <?php echo isset($errors[0]) && strpos($errors[0], 'Reviewer') !== false ? 'is-invalid' : ''; ?>" 
                               id="reviewer" 
                               name="reviewer" 
                               value="<?php echo htmlspecialchars($movie['reviewer']); ?>" 
                               placeholder="Enter your name" 
                               maxlength="255"
                               required>
                        <div class="form-text">Your name as the reviewer</div>
                    </div>
                    
                    <!-- Form Buttons -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="index.php" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-save"></i> Update Review
                        </button>
                    </div>
                    
                </form>
            </div>
            <div class="card-footer text-muted">
                <small>
                    <i class="bi bi-clock"></i> Created: <?php echo date('M d, Y H:i', strtotime($movie['created_at'])); ?>
                    <?php if ($movie['updated_at'] != $movie['created_at']): ?>
                        | Updated: <?php echo date('M d, Y H:i', strtotime($movie['updated_at'])); ?>
                    <?php endif; ?>
                </small>
            </div>
        </div>
    </div>
</div>

<!-- Client-side Form Validation Script -->
<script>
    // Bootstrap form validation
    (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>

<?php
// Include footer template
include '../templates/footer.php';
?>
