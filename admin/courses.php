<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: login.php');
    exit();
}

$action = $_GET['action'] ?? 'list';
$message = '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                $message = addCourse($_POST, $_FILES);
                break;
            case 'update':
                // Debug: Log the update attempt
                error_log("Update course attempt - POST data: " . print_r($_POST, true));
                $message = updateCourse($_POST, $_FILES);
                error_log("Update course result: " . $message);
                break;
            case 'delete':
                $message = deleteCourse($_POST['course_id']);
                break;
        }
    }
}

// Get courses for listing
$courses = getAllCourses();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Courses - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="assets/css/admin.css" rel="stylesheet">
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <?php include 'includes/sidebar.php'; ?>

        <!-- Main Content -->
        <main class="admin-main">
            <div class="admin-header">
                <h1>Manage Courses</h1>
                <a href="?action=add" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add New Course
                </a>
            </div>

            <?php if ($message): ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>

            <?php if ($action == 'add' || $action == 'edit'): ?>
                <!-- Add/Edit Course Form -->
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-<?php echo $action == 'add' ? 'plus' : 'edit'; ?>"></i> 
                            <?php echo $action == 'add' ? 'Add New Course' : 'Edit Course'; ?>
                        </h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="<?php echo $action; ?>">
                            <?php if ($action == 'edit'): ?>
                                <input type="hidden" name="course_id" value="<?php echo $_GET['id']; ?>">
                            <?php endif; ?>
                            
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Course Title *</label>
                                        <input type="text" class="form-control" id="title" name="title" 
                                               value="<?php echo isset($_GET['id']) ? getCourseById($_GET['id'])['title'] : ''; ?>" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="3"><?php echo isset($_GET['id']) ? getCourseById($_GET['id'])['description'] : ''; ?></textarea>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="content" class="form-label">Content</label>
                                        <textarea class="form-control" id="content" name="content" rows="6"><?php echo isset($_GET['id']) ? getCourseById($_GET['id'])['content'] : ''; ?></textarea>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="difficulty" class="form-label">Difficulty Level</label>
                                                <select class="form-select" id="difficulty" name="difficulty">
                                                    <option value="beginner" <?php echo (isset($_GET['id']) && getCourseById($_GET['id'])['difficulty'] == 'beginner') ? 'selected' : ''; ?>>Beginner</option>
                                                    <option value="intermediate" <?php echo (isset($_GET['id']) && getCourseById($_GET['id'])['difficulty'] == 'intermediate') ? 'selected' : ''; ?>>Intermediate</option>
                                                    <option value="advanced" <?php echo (isset($_GET['id']) && getCourseById($_GET['id'])['difficulty'] == 'advanced') ? 'selected' : ''; ?>>Advanced</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="order_num" class="form-label">Order Number</label>
                                                <input type="number" class="form-control" id="order_num" name="order_num" 
                                                       value="<?php echo isset($_GET['id']) ? getCourseById($_GET['id'])['order_num'] : '0'; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <?php 
                                    $currentVideoType = 'file';
                                    $currentYoutubeUrl = '';
                                    if ($action == 'edit' && isset($_GET['id'])) {
                                        $course = getCourseById($_GET['id']);
                                        if (isset($course['youtube_url']) && $course['youtube_url']) {
                                            $currentVideoType = 'youtube';
                                            $currentYoutubeUrl = $course['youtube_url'];
                                        }
                                    }
                                    ?>
                                    <div class="mb-3">
                                        <label class="form-label">Video Source</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="video_type" id="video_file_radio" value="file" 
                                                   <?php echo $currentVideoType == 'file' ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="video_file_radio">
                                                Upload Video File
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="video_type" id="youtube_radio" value="youtube"
                                                   <?php echo $currentVideoType == 'youtube' ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="youtube_radio">
                                                YouTube Link
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3" id="video_file_section" style="display: <?php echo $currentVideoType == 'file' ? 'block' : 'none'; ?>;">
                                        <label for="video_file" class="form-label">Video File</label>
                                        <input type="file" class="form-control" id="video_file" name="video_file" 
                                               accept="video/*">
                                        <small class="form-text text-muted">
                                            Supported formats: MP4, AVI, MOV, WMV (Max 100MB)
                                        </small>
                                    </div>
                                    
                                    <div class="mb-3" id="youtube_section" style="display: <?php echo $currentVideoType == 'youtube' ? 'block' : 'none'; ?>;">
                                        <label for="youtube_url" class="form-label">YouTube URL</label>
                                        <input type="url" class="form-control" id="youtube_url" name="youtube_url" 
                                               value="<?php echo htmlspecialchars($currentYoutubeUrl); ?>"
                                               placeholder="https://www.youtube.com/watch?v=...">
                                        <small class="form-text text-muted">
                                            Paste the full YouTube video URL
                                        </small>
                                    </div>
                                    
                                    <?php if ($action == 'edit' && isset($_GET['id'])): ?>
                                        <?php $course = getCourseById($_GET['id']); ?>
                                        <?php if ((isset($course['video_url']) && $course['video_url']) || (isset($course['youtube_url']) && $course['youtube_url'])): ?>
                                        <div class="mb-3">
                                            <label class="form-label">Current Video</label>
                                            <div class="current-video">
                                                <?php if (isset($course['youtube_url']) && $course['youtube_url']): ?>
                                                    <iframe width="100%" height="200" 
                                                            src="<?php echo getYouTubeEmbedUrl($course['youtube_url']); ?>" 
                                                            frameborder="0" allowfullscreen>
                                                    </iframe>
                                                <?php elseif (isset($course['video_url']) && $course['video_url']): ?>
                                                    <video width="100%" controls>
                                                        <source src="../uploads/videos/<?php echo $course['video_url']; ?>" type="video/mp4">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    
                                    <div class="mb-3">
                                        <label for="thumbnail" class="form-label">Thumbnail Image</label>
                                        <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*">
                                        <small class="form-text text-muted">
                                            Recommended size: 400x300px (Max 5MB)
                                        </small>
                                    </div>
                                    
                                    <?php if ($action == 'edit' && isset($_GET['id']) && isset($course['thumbnail']) && $course['thumbnail']): ?>
                                    <div class="mb-3">
                                        <label class="form-label">Current Thumbnail</label>
                                        <img src="../uploads/thumbnails/<?php echo $course['thumbnail']; ?>" 
                                             class="img-thumbnail" style="max-width: 200px;">
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <a href="courses.php" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Back to List
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> 
                                    <?php echo $action == 'add' ? 'Add Course' : 'Update Course'; ?>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <!-- Course List -->
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-video"></i> All Courses (<?php echo count($courses); ?>)</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Thumbnail</th>
                                        <th>Title</th>
                                        <th>Difficulty</th>
                                        <th>Order</th>
                                        <th>Video Type</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($courses as $course): ?>
                                    <tr>
                                        <td><?php echo $course['id']; ?></td>
                                        <td>
                                            <?php if (isset($course['thumbnail']) && $course['thumbnail']): ?>
                                                <img src="../uploads/thumbnails/<?php echo $course['thumbnail']; ?>" 
                                                     class="img-thumbnail" style="width: 50px; height: 40px; object-fit: cover;">
                                            <?php else: ?>
                                                <div class="bg-light text-center" style="width: 50px; height: 40px; line-height: 40px;">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <strong><?php echo htmlspecialchars($course['title']); ?></strong>
                                            <br><small class="text-muted"><?php echo htmlspecialchars(substr($course['description'], 0, 50)); ?>...</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-<?php echo getDifficultyColor($course['difficulty']); ?>">
                                                <?php echo ucfirst($course['difficulty']); ?>
                                            </span>
                                        </td>
                                        <td><?php echo $course['order_num']; ?></td>
                                        <td>
                                            <?php if (isset($course['youtube_url']) && $course['youtube_url']): ?>
                                                <span class="badge bg-danger">
                                                    <i class="fab fa-youtube"></i> YouTube
                                                </span>
                                            <?php elseif (isset($course['video_url']) && $course['video_url']): ?>
                                                <span class="badge bg-primary">
                                                    <i class="fas fa-video"></i> Uploaded
                                                </span>
                                            <?php else: ?>
                                                <span class="text-muted">No video</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="?action=edit&id=<?php echo $course['id']; ?>" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-danger" 
                                                        onclick="deleteCourse(<?php echo $course['id']; ?>)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this course? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="course_id" id="deleteCourseId">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/admin.js"></script>
    <script>
        function deleteCourse(courseId) {
            document.getElementById('deleteCourseId').value = courseId;
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        }
        
        // Handle video type toggle
        document.addEventListener('DOMContentLoaded', function() {
            const videoFileRadio = document.getElementById('video_file_radio');
            const youtubeRadio = document.getElementById('youtube_radio');
            const videoFileSection = document.getElementById('video_file_section');
            const youtubeSection = document.getElementById('youtube_section');
            const videoFileInput = document.getElementById('video_file');
            const youtubeUrlInput = document.getElementById('youtube_url');
            
            if (videoFileRadio && youtubeRadio) {
                videoFileRadio.addEventListener('change', function() {
                    videoFileSection.style.display = 'block';
                    youtubeSection.style.display = 'none';
                    youtubeUrlInput.removeAttribute('required');
                    // Only set required if this is a new course (no existing video)
                    if (!document.querySelector('input[name="course_id"]')) {
                        videoFileInput.setAttribute('required', 'required');
                    }
                });
                
                youtubeRadio.addEventListener('change', function() {
                    videoFileSection.style.display = 'none';
                    youtubeSection.style.display = 'block';
                    videoFileInput.removeAttribute('required');
                    // Only set required if this is a new course (no existing video)
                    if (!document.querySelector('input[name="course_id"]')) {
                        youtubeUrlInput.setAttribute('required', 'required');
                    }
                });
            }
        });
    </script>
</body>
</html>
