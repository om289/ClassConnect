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
    $subject = $_POST['subject'];
    $unique_code = substr(md5(uniqid(mt_rand(), true)), 0, 10);

    // Debugging: Log subject and unique code
    error_log("Creating classroom with subject: $subject, unique code: $unique_code");

    $sql = "INSERT INTO classrooms (faculty_id, subject, unique_code) VALUES (?, ?, ?)";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("iss", $faculty_id, $subject, $unique_code);

    if ($stmt->execute()) {
        $message = "Classroom created successfully. Unique Code: " . $unique_code;
        error_log("Classroom created successfully.");
    } else {
        $message = "Error creating classroom: " . $stmt->error;
        error_log("Error creating classroom: " . $stmt->error);
    }
}

$sql = "SELECT * FROM classrooms WHERE faculty_id = ? ORDER BY created_at DESC";
$stmt = $connect->prepare($sql);
$stmt->bind_param("i", $faculty_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Classroom</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Create Classroom</h2>
    <?php if ($message) { echo "<div class='alert alert-info'>$message</div>"; } ?>

    <form action="" method="POST">
        <div class="form-group">
            <label for="subject">Subject</label>
            <input type="text" name="subject" id="subject" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Create Classroom</button>
    </form>

    <h3 class="mt-5">Your Classrooms</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Subject</th>
                <th>Unique Code</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['subject']); ?></td>
                    <td><?php echo htmlspecialchars($row['unique_code']); ?></td>
                    <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>