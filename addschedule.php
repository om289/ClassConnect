<?php
session_start();

if (!isset($_SESSION['fidx']) || empty($_SESSION['fidx'])) {
    header('Location: facultylogin.php');
    exit;
}

include('database.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $course = $_POST['course'];
    $year = $_POST['year'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $description = $_POST['description'];

    $sql = "INSERT INTO schedule (Course, Year, Date, Time, Description) VALUES ('$course', '$year', '$date', '$time', '$description')";

    if (mysqli_query($connect, $sql)) {
        $message = "Schedule added successfully.";
    } else {
        $message = "Error: " . mysqli_error($connect);
    }
}
?>

<?php include('fhead.php'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h3>Add Schedule</h3>
            <?php if (isset($message)) { echo "<div class='alert alert-info'>$message</div>"; } ?>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="course">Course:</label>
                    <select class="form-control" id="course" name="course" required>
                        <option value="Computer Engineering">Computer Engineering</option>
                        <option value="Information Technology">Information Technology</option>
                        <option value="Electronics & Telecommunication">Electronics & Telecommunication</option>
                        <option value="AI/DS">AI/DS</option>
                        <option value="BS&H">BS&H</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="year">Year:</label>
                    <select class="form-control" id="year" name="year" required>
                        <option value="First Year">First Year</option>
                        <option value="Second Year">Second Year</option>
                        <option value="Third Year">Third Year</option>
                        <option value="Fourth Year">Fourth Year</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="date">Date:</label>
                    <input type="date" class="form-control" id="date" name="date" required>
                </div>
                <div class="form-group">
                    <label for="time">Time:</label>
                    <input type="time" class="form-control" id="time" name="time" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Add Schedule</button>
            </form>
        </div>
    </div>
</div>
<?php include('allfoot.php'); ?>