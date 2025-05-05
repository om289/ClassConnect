<?php
session_start();

if (!isset($_SESSION["fidx"])) {
    header('Location: facultylogin.php');
    exit();
}

$faculty_id = $_SESSION["fidx"];
include('database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course = $_POST['course'];
    $year = $_POST['year'];
    $division = $_POST['division'];

    if (isset($_FILES['classnotes']) && $_FILES['classnotes']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['classnotes']['tmp_name'];
        $fileName = $_FILES['classnotes']['name'];
        $uploadFileDir = 'uploads/';
        $dest_path = $uploadFileDir . $fileName;

        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $sql = "INSERT INTO class_notes (faculty_id, course, year, division, file_name, file_path) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $connect->prepare($sql);
            $stmt->bind_param("isssss", $faculty_id, $course, $year, $division, $fileName, $dest_path);

            if ($stmt->execute()) {
                $message = "Class notes uploaded successfully.";
            } else {
                $message = "Database error: " . $stmt->error;
            }
        } else {
            $message = "File upload failed.";
        }
    } else {
        $message = "No file uploaded or upload error.";
    }
}

// Fetch existing class notes for management
$sql = "SELECT * FROM class_notes WHERE faculty_id = ? ORDER BY uploaded_at DESC";
$stmt = $connect->prepare($sql);
$stmt->bind_param("i", $faculty_id);
$stmt->execute();
$notes_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Class Notes</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Manage Class Notes</h2>
    <?php if (isset($message)) { echo "<div class='alert alert-info'>$message</div>"; } ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="course">Course</label>
            <select name="course" id="course" class="form-control" required>
                <option value="">-- Select Course --</option>
                <option value="Computer">Computer</option>
                <option value="IT">IT</option>
                <option value="EXTC">EXTC</option>
                <option value="AIDS">AIDS</option>
                <option value="BS&H">BS&H</option>
            </select>
        </div>
        <div class="form-group">
            <label for="year">Year</label>
            <select name="year" id="year" class="form-control" required>
                <option value="">-- Select Year --</option>
                <option value="FY">First Year (FY)</option>
                <option value="SY">Second Year (SY)</option>
                <option value="TY">Third Year (TY)</option>
                <option value="LY">Final Year (LY)</option>
            </select>
        </div>
        <div class="form-group">
            <label for="division">Division</label>
            <select name="division" id="division" class="form-control" required>
                <option value="">-- Select Division --</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
                <option value="E">E</option>
                <option value="F">F</option>
            </select>
        </div>
        <div class="form-group">
            <label for="classnotes">Class Notes (PDF, DOC, PPT, etc.)</label>
            <input type="file" name="classnotes" id="classnotes" class="form-control" accept=".pdf,.doc,.docx,.ppt,.pptx,.txt" required>
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>

    <h3 class="mt-5">Uploaded Class Notes</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Course</th>
                <th>Year</th>
                <th>Division</th>
                <th>File Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $notes_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['course']); ?></td>
                    <td><?php echo htmlspecialchars($row['year']); ?></td>
                    <td><?php echo htmlspecialchars($row['division']); ?></td>
                    <td><a href="<?php echo htmlspecialchars($row['file_path']); ?>" target="_blank"><?php echo htmlspecialchars($row['file_name']); ?></a></td>
                    <td>
                        <form action="delete_note.php" method="POST" style="display:inline;">
                            <input type="hidden" name="note_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>