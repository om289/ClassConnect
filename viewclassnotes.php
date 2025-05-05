<?php
session_start();

if (!isset($_SESSION['sidx'])) {
    header('Location: studentlogin.php');
    exit();
}

// Debugging session variables
error_log("Session course: " . (isset($_SESSION['course']) ? $_SESSION['course'] : 'Not set'));
error_log("Session year: " . (isset($_SESSION['year']) ? $_SESSION['year'] : 'Not set'));
error_log("Session division: " . (isset($_SESSION['division']) ? $_SESSION['division'] : 'Not set'));

if (!isset($_SESSION['course']) || !isset($_SESSION['year']) || !isset($_SESSION['division'])) {
    echo "<p>Error: Course, Year, or Division information is missing. Please update your profile or contact the administrator.</p>";
    echo "<a href='updatedetailsfromstudent.php?eno={$_SESSION['seno']}' class='btn btn-primary'>Update Profile</a>";
    exit;
}

include('database.php');

$course = $_SESSION['course'];
$year = $_SESSION['year'];
$division = $_SESSION['division'];

$sql = "SELECT * FROM class_notes WHERE course = ? AND year = ? AND division = ? ORDER BY uploaded_at DESC";
$stmt = $connect->prepare($sql);
$stmt->bind_param("sss", $course, $year, $division);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Class Notes</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Class Notes & Materials</h2>
    <p>Below are the class notes uploaded by your faculty for your course, year, and division.</p>
    <?php if ($result && $result->num_rows > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Course</th>
                    <th>Year</th>
                    <th>Division</th>
                    <th>File Name</th>
                    <th>Download</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['course']); ?></td>
                        <td><?php echo htmlspecialchars($row['year']); ?></td>
                        <td><?php echo htmlspecialchars($row['division']); ?></td>
                        <td><?php echo htmlspecialchars($row['file_name']); ?></td>
                        <td><a href="<?php echo htmlspecialchars($row['file_path']); ?>" class="btn btn-primary btn-sm" target="_blank">Download</a></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No class notes or materials available for your course, year, and division.</p>
    <?php endif; ?>
</div>
</body>
</html>