<?php
session_start();

if (!isset($_SESSION['sidx'])) {
    header('Location: studentlogin.php');
    exit();
}

include('database.php');

$student_id = $_SESSION['seno'];

// Debugging: Log student ID
error_log("Student ID: " . $student_id);

$sql = "SELECT cm.classroom_id, c.subject, c.unique_code, m.file_name, m.file_path
        FROM classroom_members cm
        JOIN classrooms c ON cm.classroom_id = c.id
        JOIN classroom_materials m ON cm.classroom_id = m.classroom_id
        WHERE cm.student_id = ? ORDER BY m.uploaded_at DESC";
$stmt = $connect->prepare($sql);
$stmt->bind_param("i", $student_id);

// Debugging: Log SQL query
error_log("Executing query: $sql with student ID: $student_id");

$stmt->execute();
$materials = $stmt->get_result();

// Debugging: Log number of materials found
error_log("Number of materials found: " . $materials->num_rows);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Classroom Materials</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Classroom Materials</h2>
    <p>Below are the materials uploaded to the classrooms you have joined.</p>
    <?php if ($materials->num_rows > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Classroom</th>
                    <th>File Name</th>
                    <th>View</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $materials->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['subject']); ?> (Code: <?php echo htmlspecialchars($row['unique_code']); ?>)</td>
                        <td><?php echo htmlspecialchars($row['file_name']); ?></td>
                        <td>
                            <a href="<?php echo htmlspecialchars($row['file_path']); ?>" target="_blank" class="btn btn-primary btn-sm">View</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No materials available for the classrooms you have joined.</p>
    <?php endif; ?>

    <h3>Announcements</h3>
    <?php
    $classroom_id = $_GET['classroom_id'];
    $sql_announcements = "SELECT * FROM classroom_announcements WHERE classroom_id = ? ORDER BY created_at DESC";
    $stmt_announcements = $connect->prepare($sql_announcements);
    $stmt_announcements->bind_param("i", $classroom_id);
    $stmt_announcements->execute();
    $announcements = $stmt_announcements->get_result();

    if ($announcements->num_rows > 0): ?>
        <ul class="list-group">
            <?php while ($announcement = $announcements->fetch_assoc()): ?>
                <li class="list-group-item">
                    <strong><?php echo htmlspecialchars($announcement['title']); ?></strong>
                    <p><?php echo htmlspecialchars($announcement['content']); ?></p>
                    <small>Posted on: <?php echo htmlspecialchars($announcement['created_at']); ?></small>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>No announcements available for this classroom.</p>
    <?php endif; ?>
</div>
</body>
</html>