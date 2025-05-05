<?php
session_start();

if (!isset($_SESSION['sidx'])) {
    header('Location: studentlogin.php');
    exit();
}

include('database.php');

$student_id = $_SESSION['seno'];
$message = "";

// Debugging: Log student ID
error_log("Student ID: " . $student_id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $unique_code = $_POST['unique_code'];

    // Debugging: Log unique code
    error_log("Joining classroom with code: $unique_code");

    $sql = "SELECT id FROM classrooms WHERE unique_code = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("s", $unique_code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $classroom = $result->fetch_assoc();
        $classroom_id = $classroom['id'];

        // Debugging: Log classroom ID
        error_log("Classroom ID: $classroom_id");

        $sql = "INSERT INTO classroom_members (classroom_id, student_id) VALUES (?, ?)";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("ii", $classroom_id, $student_id);

        if ($stmt->execute()) {
            $message = "Successfully joined the classroom.";
            error_log("Successfully joined the classroom.");
        } else {
            $message = "Error joining classroom: " . $stmt->error;
            error_log("Error joining classroom: " . $stmt->error);
        }
    } else {
        $message = "Invalid classroom code.";
        error_log("Invalid classroom code: $unique_code");
    }
}

$sql = "SELECT c.id, c.subject, c.unique_code, c.created_at FROM classrooms c
        JOIN classroom_members cm ON c.id = cm.classroom_id
        WHERE cm.student_id = ? ORDER BY c.created_at DESC";
$stmt = $connect->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Classroom</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Join Classroom</h2>
    <?php if ($message) { echo "<div class='alert alert-info'>$message</div>"; } ?>

    <form action="" method="POST">
        <div class="form-group">
            <label for="unique_code">Classroom Code</label>
            <input type="text" name="unique_code" id="unique_code" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Join Classroom</button>
    </form>

    <h3 class="mt-5">Your Classrooms</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Subject</th>
                <th>Unique Code</th>
                <th>Joined At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['subject']); ?></td>
                    <td><?php echo htmlspecialchars($row['unique_code']); ?></td>
                    <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                    <td>
                        <a href="viewclassroommaterials.php?classroom_id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Open Classroom</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>