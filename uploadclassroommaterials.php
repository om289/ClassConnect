<?php
session_start();

if (!isset($_SESSION['fidx'])) {
    header('Location: facultylogin.php');
    exit();
}

include('database.php');

$faculty_id = $_SESSION['fidx'];
$message = "";

// Debugging: Log faculty ID
error_log("Faculty ID: " . $faculty_id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $classroom_id = $_POST['classroom_id'];

    // Debugging: Log classroom ID
    error_log("Uploading material to classroom ID: $classroom_id");

    if (isset($_FILES['material']) && $_FILES['material']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['material']['tmp_name'];
        $fileName = $_FILES['material']['name'];
        $uploadFileDir = 'uploads/';
        $dest_path = $uploadFileDir . $fileName;

        // Debugging: Log file name and destination path
        error_log("Uploading file: $fileName to $dest_path");

        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $sql = "INSERT INTO classroom_materials (classroom_id, file_name, file_path) VALUES (?, ?, ?)";
            $stmt = $connect->prepare($sql);
            $stmt->bind_param("iss", $classroom_id, $fileName, $dest_path);

            if ($stmt->execute()) {
                $message = "Material uploaded successfully.";
                error_log("Material uploaded successfully.");
            } else {
                $message = "Database error: " . $stmt->error;
                error_log("Database error: " . $stmt->error);
            }
        } else {
            $message = "File upload failed. Check directory permissions or file size limits.";
            error_log("File upload failed. Temp path: $fileTmpPath, Destination: $dest_path");
            error_log("File upload error code: " . $_FILES['material']['error']);
        }
    } else {
        $message = "No file uploaded or upload error.";
        error_log("No file uploaded or upload error.");
    }

    if (isset($_POST['post_announcement'])) {
        $title = $_POST['announcement_title'];
        $content = $_POST['announcement_content'];

        $sql_announcement = "INSERT INTO classroom_announcements (classroom_id, title, content) VALUES (?, ?, ?)";
        $stmt_announcement = $connect->prepare($sql_announcement);
        $stmt_announcement->bind_param("iss", $classroom_id, $title, $content);

        if ($stmt_announcement->execute()) {
            echo "<div class='alert alert-success'>Announcement posted successfully.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error posting announcement: " . $stmt_announcement->error . "</div>";
        }
    }
}

$sql = "SELECT * FROM classrooms WHERE faculty_id = ? ORDER BY created_at DESC";
$stmt = $connect->prepare($sql);
$stmt->bind_param("i", $faculty_id);
$stmt->execute();
$classrooms = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Classroom Materials</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Manage Classroom Content</h2>
    <?php if ($message) { echo "<div class='alert alert-info'>$message</div>"; } ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="classroom_id">Select Classroom</label>
            <select name="classroom_id" id="classroom_id" class="form-control" required>
                <option value="">-- Select Classroom --</option>
                <?php while ($row = $classrooms->fetch_assoc()): ?>
                    <option value="<?php echo $row['id']; ?>">
                        <?php echo htmlspecialchars($row['subject']); ?> (Code: <?php echo htmlspecialchars($row['unique_code']); ?>)
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <h3>Upload Notes</h3>
        <div class="form-group">
            <label for="material">Material (PDF, DOC, PPT, etc.)</label>
            <input type="file" name="material" id="material" class="form-control" accept=".pdf,.doc,.docx,.ppt,.pptx,.txt">
        </div>
        <button type="submit" name="upload_material" class="btn btn-primary mt-3">Upload Notes</button>

        <h3 class="mt-5">Post Announcement</h3>
        <div class="form-group">
            <label for="announcement_title">Announcement Title</label>
            <input type="text" name="announcement_title" id="announcement_title" class="form-control">
        </div>
        <div class="form-group">
            <label for="announcement_content">Announcement Content</label>
            <textarea name="announcement_content" id="announcement_content" class="form-control"></textarea>
        </div>
        <button type="submit" name="post_announcement" class="btn btn-secondary mt-3">Post Announcement</button>
    </form>
</div>

<?php
if (isset($_POST['upload_material'])) {
    $classroom_id = $_POST['classroom_id'];
    if (isset($_FILES['material']) && $_FILES['material']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['material']['tmp_name'];
        $fileName = $_FILES['material']['name'];
        $uploadFileDir = 'uploads/';
        $dest_path = $uploadFileDir . $fileName;

        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $sql = "INSERT INTO classroom_materials (classroom_id, file_name, file_path) VALUES (?, ?, ?)";
            $stmt = $connect->prepare($sql);
            $stmt->bind_param("iss", $classroom_id, $fileName, $dest_path);

            if ($stmt->execute()) {
                echo "<div class='alert alert-success'>Material uploaded successfully.</div>";
            } else {
                echo "<div class='alert alert-danger'>Database error: " . $stmt->error . "</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>File upload failed. Check directory permissions or file size limits.</div>";
            error_log("File upload failed. Temp path: $fileTmpPath, Destination: $dest_path");
            error_log("File upload error code: " . $_FILES['material']['error']);
        }
    } else {
        echo "<div class='alert alert-danger'>No file uploaded or upload error.</div>";
    }
}

if (isset($_POST['post_announcement'])) {
    $classroom_id = $_POST['classroom_id'];
    $title = $_POST['announcement_title'];
    $content = $_POST['announcement_content'];

    $sql_announcement = "INSERT INTO classroom_announcements (classroom_id, title, content) VALUES (?, ?, ?)";
    $stmt_announcement = $connect->prepare($sql_announcement);
    $stmt_announcement->bind_param("iss", $classroom_id, $title, $content);

    if ($stmt_announcement->execute()) {
        echo "<div class='alert alert-success'>Announcement posted successfully.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error posting announcement: " . $stmt_announcement->error . "</div>";
    }
}
?>
</body>
</html>