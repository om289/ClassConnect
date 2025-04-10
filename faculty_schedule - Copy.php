<?php
session_start();
if(empty($_SESSION["fid"])) {
    header('Location: facultylogin.php');
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "cc_db");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$faculty_id = $_SESSION["fid"];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $day = $_POST['day'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $activity = $_POST['activity'];
    
    $sql = "INSERT INTO schedules (faculty_id, day, start_time, end_time, activity)
            VALUES ('$faculty_id', '$day', '$start_time', '$end_time', '$activity')";
    mysqli_query($conn, $sql);
}

// Get existing schedules
$sql = "SELECT * FROM schedules WHERE faculty_id = '$faculty_id' ORDER BY day, start_time";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Faculty Schedule Management</title>
    <style>
        .container { max-width: 800px; margin: 20px auto; padding: 20px; }
        form { margin-bottom: 30px; background: #f5f5f5; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Manage Class Schedule</h1>
        
        <form method="POST">
            <div class="form-group">
                <label>Day:</label>
                <select name="day" required>
                    <option value="Monday">Monday</option>
                    <option value="Tuesday">Tuesday</option>
                    <option value="Wednesday">Wednesday</option>
                    <option value="Thursday">Thursday</option>
                    <option value="Friday">Friday</option>
                    <option value="Saturday">Saturday</option>
                    <option value="Sunday">Sunday</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Start Time:</label>
                <input type="time" name="start_time" required>
            </div>
            
            <div class="form-group">
                <label>End Time:</label>
                <input type="time" name="end_time" required>
            </div>
            
            <div class="form-group">
                <label>Activity:</label>
                <input type="text" name="activity" required style="width: 300px;">
            </div>
            
            <button type="submit">Add Schedule Entry</button>
        </form>

        <h2>Existing Schedule Entries</h2>
        <table>
            <tr>
                <th>Day</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Activity</th>
            </tr>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $row['day'] ?></td>
                <td><?= date("h:i A", strtotime($row['start_time'])) ?></td>
                <td><?= date("h:i A", strtotime($row['end_time'])) ?></td>
                <td><?= htmlspecialchars($row['activity']) ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>