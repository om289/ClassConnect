<?php
session_start();

// Database connection
$conn = mysqli_connect("localhost", "root", "", "cc_db");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Redirect if session is invalid
if (!isset($_SESSION["sidx"]) || empty($_SESSION["sidx"])) {
    header('Location: studentlogin.php');
    exit();
}

// Ensure session variables for first name and last name are set
$userfname = isset($_SESSION['fname']) ? $_SESSION['fname'] : "Student";
$userlname = isset($_SESSION['lname']) ? $_SESSION['lname'] : "";
$sEno = isset($_SESSION["seno"]) ? $_SESSION["seno"] : "Unknown";

// Ensure session variable for student ID is set
$userid = isset($_SESSION['sidx']) ? $_SESSION['sidx'] : '';

if (empty($userid)) {
    echo "<p>Error: Student ID is missing. Please log in again.</p>";
    echo "<a href='studentlogin.php' class='btn btn-primary'>Login</a>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        body {
            background-color: #FFFFFF; /* White */
            color: #231F20; /* Pantone Dark Gray */
        }
        .navbar {
            background-color: #B7202E; /* InPower Red */
        }
        .navbar a {
            color: #FFFFFF; /* White */
        }
        .header-image {
            width: 100%;
            max-height: 150px;
            object-fit: contain;
        }
        .footer {
            background-color: #58595B; /* Pantone Cool Gray */
            color: #FFFFFF; /* White */
            text-align: center;
            padding: 10px 0;
        }
        a { text-decoration: none; color: inherit; }
        .dashboard-container {
            display: flex;
            background-color: #f8f9fb; /* Matches the sidebar background */
        }
        .sidebar {
            background-color: #B7202E; /* InPower Red */
            color: #FFFFFF; /* White */
            padding: 10px;
            width: 250px; /* Restored to previous dimensions */
            height: 100vh;
        }
        .sidebar button {
            background-color: #ED1C24; /* Vitality Red */
            color: #FFFFFF; /* White */
            border: none;
            padding: 12px 20px; /* Increased padding for better visibility */
            margin: 8px 0; /* Adjusted margin for spacing */
            width: 100%;
            text-align: center; /* Centered text */
            font-size: 16px; /* Increased font size */
            font-weight: bold; /* Bold text for better readability */
            border-radius: 8px; /* Rounded corners */
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Added shadow for depth */
            transition: background-color 0.3s ease, transform 0.2s ease; /* Smooth hover effect */
        }
        .sidebar button:hover {
            background-color: #B7202E; /* InPower Red */
            transform: scale(1.05); /* Slight zoom effect on hover */
        }
        .sidebar .logo {
            font-size: 18px; /* Adjusted font size */
            font-weight: bold;
            margin-bottom: 15px;
        }
        .main-content {
            flex: 1;
            padding: 20px;
            background-color: #ffffff; /* Ensures a clean white background */
        }
        .profile {
            width: 300px;
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-left: 20px;
        }
        .dashboard-sections {
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }
        .schedule, .progress {
            background: #fff;
            padding: 15px;
            border-radius: 10px;
            flex: 1;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .leaderboard {
            margin-top: 20px;
            background: #fff;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .add-btn {
            background: #ff6600;
            border: none;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }
        .add-btn:hover {
            background: #e65c00;
        }
        .course-card button {
            background: #1a3b5d;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .course-card button:hover {
            background: #14324a;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="#">K.J Somaiya Institute Of Technology</a>
    </nav>

    <div class="container mt-4">
        <img src="images/somaiyalogo.png" alt="Somaiya Vidyavihar" style="width: auto; height: 80px; display: block; margin: 0 auto;">

        <div class="dashboard-container">
            <!-- Sidebar -->
            <div class="sidebar">
                <div class="logo">Happy Learning!!!</div>
                <button onclick="location.href='welcomestudent.php'">Overview</button>
                <button onclick="location.href='mydetailsstudent.php?myds=<?php echo $_SESSION['sidx']; ?>'">Profile</button>
                <button onclick="location.href='takeassessment.php'">Take Assessment</button>
                <button onclick="location.href='viewresult.php'">Result</button>
                <button onclick="location.href='viewquery.php'">My Query</button>
                <button onclick="location.href='askquery.php'">Ask Query</button>
                <button onclick="location.href='viewvideos.php'">Videos (E-Learn)</button>
            </div>

            <!-- Main Content -->
            <div class="main-content">
                <header>
                    <input type="text" placeholder="Search for courses" class="form-control" style="width: 70%; display: inline-block;">
                    <button class="add-btn">Add New +</button>
                </header>

                <section class="welcome-banner">
                    <h2>Welcome Back, <br> <strong><?php echo htmlspecialchars($userfname . " " . $userlname); ?></strong></h2>
                    <p>Go back to the course &rarr;</p>
                </section>

                <section class="dashboard">
                    <div class="dashboard-sections">
                        <!-- Schedule Section -->
                        <?php
                        // Include the database connection
                        include('database.php');

                        // Ensure session variables are set
                        if (!isset($_SESSION['course']) || !isset($_SESSION['year'])) {
                            echo "<p>Error: Course or Year information is missing. Please update your profile or contact the administrator.</p>";
                            echo "<a href='mydetailsstudent.php?myds={$_SESSION['sidx']}' class='btn btn-primary'>Update Profile</a>";
                            exit;
                        }

                        $course = $_SESSION['course'];
                        $year = $_SESSION['year'];
                        $today = date('Y-m-d');

                        // Fetch today's schedule
                        $sql = "SELECT * FROM schedule WHERE Course = '$course' AND Year = '$year' AND Date = '$today'";
                        $result = mysqli_query($connect, $sql);

                        if (!$result) {
                            echo "<p>Error: Unable to fetch schedule. Please try again later.</p>";
                            exit;
                        }
                        ?>
                        <div class="schedule">
                            <h3>Today's Schedule</h3>
                            <?php if (mysqli_num_rows($result) > 0): ?>
                                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                    <div class="schedule-item">
                                        <span><?php echo date('h:i a', strtotime($row['Time'])); ?></span>
                                        <div class="course-card">
                                            <p><?php echo $row['Course']; ?></p>
                                            <small><?php echo $row['Description']; ?></small>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <p>No schedule for today.</p>
                            <?php endif; ?>
                        </div>

                        <!-- Progress Section -->
                        <div class="progress">
                            <h3>Last 20 Days</h3>
                            <?php
                            $sql = "SELECT sp.activity, sp.activity_date, ed.ExamName
                                    FROM student_progress sp
                                    LEFT JOIN examdetails ed 
                                    ON sp.activity LIKE CONCAT('%', ed.ExamName, '%')
                                    WHERE sp.RollNumber = '$userid'
                                    AND DATE(sp.activity_date) >= DATE_SUB(CURDATE(), INTERVAL 20 DAY)
                                    ORDER BY sp.activity_date DESC";

                            $result = mysqli_query($conn, $sql);

                            if ($result && mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $examName = $row['ExamName'] ?? "General Activity";
                                    echo "<div class='progress-item'>
                                            <strong>{$examName} - {$row['activity']}</strong> 
                                            <span>({$row['activity_date']})</span>";
                                }
                            } else {
                                echo "<p>No recent activities recorded.</p>";
                            }
                            ?>
                        </div>
                    </div>

                    <!-- Leaderboard Section -->
                    <?php
                    // Fetch leaderboard data
                    $leaderboardSql = "SELECT ROW_NUMBER() OVER (ORDER BY total_assessments DESC) AS rank, student_name, total_assessments, latest_activity FROM leaderboard";
                    $leaderboardResult = mysqli_query($connect, $leaderboardSql);

                    if (!$leaderboardResult) {
                        echo "<p>Error: Unable to fetch leaderboard data. Please try again later.</p>";
                        exit;
                    }

                    // Display leaderboard data
                    ?>
                    <section class="leaderboard">
                        <h3>Leaderboard</h3>
                        <table class="table table-striped">
                            <tr>
                                <th>Rank</th>
                                <th>Name</th>
                                <th>Total Assessments</th>
                                <th>Latest Activity</th>
                            </tr>
                            <?php if (mysqli_num_rows($leaderboardResult) > 0): ?>
                                <?php while ($entry = mysqli_fetch_assoc($leaderboardResult)): ?>
                                    <tr>
                                        <td><?php echo $entry['rank']; ?></td>
                                        <td><?php echo $entry['student_name']; ?></td>
                                        <td><?php echo $entry['total_assessments']; ?></td>
                                        <td><?php echo $entry['latest_activity']; ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="4">No leaderboard data found.</td></tr>
                            <?php endif; ?>
                        </table>
                    </section>
                </section>
            </div>

            <!-- Profile Section -->
            <aside class="profile">
                <div class="profile-card">
                    <h4><?php echo htmlspecialchars($userfname . " " . $userlname); ?></h4>
                    <p>Student</p>
                </div>
            </aside>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2025 Somaiya Vidyavihar. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="SCRIPT.JS"></script>
</body>
</html>