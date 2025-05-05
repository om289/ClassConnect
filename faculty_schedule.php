<?php
session_start();

// Check if faculty is logged in
if (!isset($_SESSION["fidx"]) || empty($_SESSION["fidx"])) {
    header('Location: facultylogin.php');
    exit();
}

$faculty_id = $_SESSION["fidx"];
$faculty_name = $_SESSION["fname"] ?? 'Faculty';

$conn = mysqli_connect("localhost", "root", "", "cc_db");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle all form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_schedule'])) {
        // Add new schedule
        $day = $_POST['day'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        $activity = $_POST['activity'];
        $year = $_POST['year'];
        $division = $_POST['division'];

        $stmt = $conn->prepare("INSERT INTO schedules (faculty_id, day, start_time, end_time, activity, year, division) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssss", $faculty_id, $day, $start_time, $end_time, $activity, $year, $division);
        $stmt->execute();
        $stmt->close();
    } 
    elseif (isset($_POST['delete_id'])) {
        // Delete schedule
        $delete_id = $_POST['delete_id'];
        $stmt = $conn->prepare("DELETE FROM schedules WHERE id = ? AND faculty_id = ?");
        $stmt->bind_param("ii", $delete_id, $faculty_id);
        $stmt->execute();
        $stmt->close();
    }
    elseif (isset($_POST['edit_id'])) {
        // Update schedule
        $edit_id = $_POST['edit_id'];
        $day = $_POST['edit_day'];
        $start_time = $_POST['edit_start_time'];
        $end_time = $_POST['edit_end_time'];
        $activity = $_POST['edit_activity'];
        $year = $_POST['edit_year'];
        $division = $_POST['edit_division'];

        $stmt = $conn->prepare("UPDATE schedules SET day=?, start_time=?, end_time=?, activity=?, year=?, division=? WHERE id=? AND faculty_id=?");
        $stmt->bind_param("ssssssii", $day, $start_time, $end_time, $activity, $year, $division, $edit_id, $faculty_id);
        $stmt->execute();
        $stmt->close();
    }
}

// Get filter values
$filter_year = $_GET['year'] ?? '';
$filter_division = $_GET['division'] ?? '';

// Build query with filters using prepared statement
$sql = "SELECT * FROM schedules WHERE faculty_id = ?";
$params = [$faculty_id];
$types = "i";

if (!empty($filter_year)) {
    $sql .= " AND year = ?";
    $params[] = $filter_year;
    $types .= "s";
}

if (!empty($filter_division)) {
    $sql .= " AND division = ?";
    $params[] = $filter_division;
    $types .= "s";
}

$sql .= " ORDER BY year, division, day, start_time";

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

// Get unique years and divisions from studenttable
$years = [];
$divisions = [];
$filter_query = mysqli_query($conn, "SELECT DISTINCT Year, Division FROM studenttable");
while ($row = mysqli_fetch_assoc($filter_query)) {
    $years[$row['Year']] = $row['Year'];
    $divisions[$row['Division']] = $row['Division'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Faculty Schedule Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .timetable {
            width: 100%;
            margin-top: 20px;
        }
        .timetable th {
            background-color: #f8f9fa;
            text-align: center;
            vertical-align: middle;
        }
        .timetable td {
            vertical-align: middle;
        }
        .time-col {
            width: 100px;
        }
        .day-col {
            width: 120px;
        }
        .schedule-card {
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 8px;
            margin-bottom: 5px;
            background-color: #e9f7fe;
        }
        .filter-section {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .year-division-badge {
            font-size: 0.9rem;
            margin-left: 5px;
        }
        .edit-form {
            display: none;
            margin-top: 10px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h2 class="mb-4">Manage Class Schedule</h2>
        
        <!-- Filter Section -->
        <div class="filter-section">
            <form method="get" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Year</label>
                    <select name="year" class="form-select">
                        <option value="">All Years</option>
                        <?php foreach ($years as $year): ?>
                            <option value="<?= $year ?>" <?= $filter_year == $year ? 'selected' : '' ?>><?= $year ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Division</label>
                    <select name="division" class="form-select">
                        <option value="">All Divisions</option>
                        <?php foreach ($divisions as $division): ?>
                            <option value="<?= $division ?>" <?= $filter_division == $division ? 'selected' : '' ?>><?= $division ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="faculty_schedule.php" class="btn btn-outline-secondary ms-2">Reset</a>
                </div>
            </form>
        </div>

        <!-- Add New Schedule Form -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Add New Schedule Entry</h5>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Day</label>
                            <select name="day" class="form-select" required>
                                <option value="Monday">Monday</option>
                                <option value="Tuesday">Tuesday</option>
                                <option value="Wednesday">Wednesday</option>
                                <option value="Thursday">Thursday</option>
                                <option value="Friday">Friday</option>
                                <option value="Saturday">Saturday</option>
                                <option value="Sunday">Sunday</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Start Time</label>
                            <input type="time" name="start_time" class="form-control" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">End Time</label>
                            <input type="time" name="end_time" class="form-control" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Year</label>
                            <select name="year" class="form-select" required>
                                <option value="">Select Year</option>
                                <?php foreach ($years as $year): ?>
                                    <option value="<?= $year ?>"><?= $year ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Division</label>
                            <select name="division" class="form-select" required>
                                <option value="">Select Division</option>
                                <?php foreach ($divisions as $division): ?>
                                    <option value="<?= $division ?>"><?= $division ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Course</label>
                            <select name="course" class="form-select" required>
                                <option value="">Select Course</option>
                                <option value="Computer">Computer</option>
                                <option value="IT">IT</option>
                                <option value="EXTC">EXTC</option>
                                <option value="AIDS">AIDS</option>
                                <option value="BS&H">BS&H</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Activity</label>
                            <input type="text" name="activity" class="form-control" placeholder="Class/Lab name" required>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" name="add_schedule" class="btn btn-success">Add Entry</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Timetable View -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Class Schedule Timetable</h5>
            </div>
            <div class="card-body">
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php
                    // Group schedules by year and division
                    $grouped_schedules = [];
                    while ($row = mysqli_fetch_assoc($result)) {
                        $grouped_schedules[$row['year']][$row['division']][] = $row;
                    }
                    ?>

                    <?php foreach ($grouped_schedules as $year => $divisions): ?>
                        <?php foreach ($divisions as $division => $schedules): ?>
                            <h4 class="mt-4">
                                Year: <?= $year ?> - Division: <?= $division ?>
                                <span class="badge bg-primary">
                                    <?php 
                                    $student_count = mysqli_fetch_assoc(mysqli_query($conn, 
                                        "SELECT COUNT(*) as count FROM studenttable 
                                         WHERE Year = '$year' AND Division = '$division'"))['count'];
                                    echo $student_count . " students";
                                    ?>
                                </span>
                            </h4>
                            <div class="table-responsive">
                                <table class="table table-bordered timetable">
                                    <thead>
                                        <tr>
                                            <th class="time-col">Time</th>
                                            <th class="day-col">Monday</th>
                                            <th class="day-col">Tuesday</th>
                                            <th class="day-col">Wednesday</th>
                                            <th class="day-col">Thursday</th>
                                            <th class="day-col">Friday</th>
                                            <th class="day-col">Saturday</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Generate time slots from 8:30 AM to 4:10 PM in 1-hour increments
                                        $start_time = strtotime('08:40');
                                        $end_time = strtotime('16:10');
                                        $current_time = $start_time;
                                        
                                        while ($current_time <= $end_time) {
                                            $time_slot = date('H:i', $current_time);
                                            $next_slot = date('H:i', strtotime('+1 hour', $current_time));
                                            echo '<tr>';
                                            echo '<td>' . date('h:i A', $current_time) . ' - ' . date('h:i A', strtotime('+1 hour', $current_time)) . '</td>';
                                            
                                            // For each day of the week (Monday to Saturday)
                                            $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                                            foreach ($days as $day) {
                                                echo '<td>';
                                                foreach ($schedules as $schedule) {
                                                    if ($schedule['day'] == $day) {
                                                        $schedule_start = strtotime($schedule['start_time']);
                                                        $schedule_end = strtotime($schedule['end_time']);
                                                        
                                                        if ($schedule_start >= $current_time && $schedule_start < strtotime('+1 hour', $current_time)) {
                                                            echo '<div class="schedule-card">';
                                                            echo '<strong>' . htmlspecialchars($schedule['activity']) . '</strong><br>';
                                                            echo date('h:i A', $schedule_start) . ' - ' . date('h:i A', $schedule_end);
                                                            
                                                            // Display buttons
                                                            echo '<div class="d-flex gap-2 mt-2">';
                                                            echo '<button class="btn btn-sm btn-danger delete-btn" data-id="' . $schedule['id'] . '">Delete</button>';
                                                            echo '<button class="btn btn-sm btn-primary edit-btn" data-id="' . $schedule['id'] . '">Edit</button>';
                                                            echo '</div>';
                                                            
                                                            // Edit form (hidden by default)
                                                            echo '<div class="edit-form" id="edit-form-' . $schedule['id'] . '">';
                                                            echo '<form method="POST">';
                                                            echo '<input type="hidden" name="edit_id" value="' . $schedule['id'] . '">';
                                                            
                                                            echo '<div class="mb-2">';
                                                            echo '<label>Day</label>';
                                                            echo '<select name="edit_day" class="form-select form-select-sm">';
                                                            foreach (['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'] as $d) {
                                                                $selected = $d == $schedule['day'] ? 'selected' : '';
                                                                echo '<option value="' . $d . '" ' . $selected . '>' . $d . '</option>';
                                                            }
                                                            echo '</select>';
                                                            echo '</div>';
                                                            
                                                            echo '<div class="row g-2 mb-2">';
                                                            echo '<div class="col-6">';
                                                            echo '<label>Start Time</label>';
                                                            echo '<input type="time" name="edit_start_time" class="form-control form-control-sm" value="' . $schedule['start_time'] . '">';
                                                            echo '</div>';
                                                            echo '<div class="col-6">';
                                                            echo '<label>End Time</label>';
                                                            echo '<input type="time" name="edit_end_time" class="form-control form-control-sm" value="' . $schedule['end_time'] . '">';
                                                            echo '</div>';
                                                            echo '</div>';
                                                            
                                                            echo '<div class="mb-2">';
                                                            echo '<label>Activity</label>';
                                                            echo '<input type="text" name="edit_activity" class="form-control form-control-sm" value="' . htmlspecialchars($schedule['activity']) . '">';
                                                            echo '</div>';
                                                            
                                                            echo '<div class="row g-2 mb-2">';
                                                            echo '<div class="col-6">';
                                                            echo '<label>Year</label>';
                                                            echo '<select name="edit_year" class="form-select form-select-sm">';
                                                            foreach ($years as $y) {
                                                                $selected = $y == $schedule['year'] ? 'selected' : '';
                                                                echo '<option value="' . $y . '" ' . $selected . '>' . $y . '</option>';
                                                            }
                                                            echo '</select>';
                                                            echo '</div>';
                                                            echo '<div class="col-6">';
                                                            echo '<label>Division</label>';
                                                            echo '<select name="edit_division" class="form-select form-select-sm">';
                                                            foreach ($divisions as $d) {
                                                                $selected = $d == $schedule['division'] ? 'selected' : '';
                                                                echo '<option value="' . $d . '" ' . $selected . '>' . $d . '</option>';
                                                            }
                                                            echo '</select>';
                                                            echo '</div>';
                                                            echo '</div>';
                                                            
                                                            echo '<div class="d-flex justify-content-between">';
                                                            echo '<button type="submit" class="btn btn-sm btn-success">Save</button>';
                                                            echo '<button type="button" class="btn btn-sm btn-outline-secondary cancel-edit">Cancel</button>';
                                                            echo '</div>';
                                                            echo '</form>';
                                                            echo '</div>';
                                                            
                                                            echo '</div>';
                                                        }
                                                    }
                                                }
                                                echo '</td>';
                                            }
                                            
                                            echo '</tr>';
                                            $current_time = strtotime('+1 hour', $current_time);
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="alert alert-info">No schedule entries found.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // JavaScript for edit functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Handle edit button clicks
            document.querySelectorAll('.edit-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const scheduleId = this.getAttribute('data-id');
                    const editForm = document.getElementById('edit-form-' + scheduleId);
                    
                    // Hide all other edit forms first
                    document.querySelectorAll('.edit-form').forEach(form => {
                        form.style.display = 'none';
                    });
                    
                    // Show this edit form
                    editForm.style.display = 'block';
                    
                    // Scroll to the form if needed
                    editForm.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                });
            });
            
            // Handle cancel button clicks
            document.querySelectorAll('.cancel-edit').forEach(button => {
                button.addEventListener('click', function() {
                    this.closest('.edit-form').style.display = 'none';
                });
            });
            
            // Handle delete button clicks
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    if (confirm('Are you sure you want to delete this schedule entry?')) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.innerHTML = '<input type="hidden" name="delete_id" value="' + this.getAttribute('data-id') + '">';
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
        });
    </script>
</body>
</html>