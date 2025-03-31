<?php
session_start();

// Database connection
$conn = mysqli_connect("localhost", "root", "", "cc_db");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Redirect if session is invalid
if (empty($_SESSION["sidx"])) {
    header('Location:studentlogin');
    exit();
}

// Correcting the User ID assignment
$userid = $_SESSION["seno"];
$userfname = $_SESSION["fname"];
$sEno = $_SESSION["seno"];
$userlname = $_SESSION["lname"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome Student</title>
    <link rel="stylesheet" href="DAASHBOARD.CSS">
    <style>
        a { text-decoration: none; color: inherit; }
        .dashboard-sections {
            display: flex;
            justify-content: space-between;
        }
        .schedule, .progress {
            max-height: 300px; /* Adjust height as needed */
            overflow-y: auto; /* Enable scrolling */
            flex: 1; /* Allow sections to grow equally */
            margin-right: 20px; /* Space between sections */
        }
        .leaderboard {
            margin-top: 20px; /* Space above leaderboard */
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="logo">Happy Learning!!!</div>
        <ul>
            <li class="active">Overview</li>
            <li><a href="mydetailsstudent.php?myds=<?php echo $userid; ?>">Profile</a></li>
            <li><a href="takeassessment.php?seno=<?php echo $sEno; ?>">Take Assessment</a></li>
            <li><a href="viewresult.php?seno=<?php echo $sEno; ?>">Result</a></li>
            <li><a href="viewquery.php?eid=<?php echo $userid; ?>">My Query</a></li>
            <li><a href="askquery.php?eid=<?php echo $userid; ?>">Ask Query</a></li>
            <li><a href="viewvideos.php?eid=<?php echo $userid; ?>">Videos (E-Learn)</a></li>
        </ul>
    </div>

    <div class="main-content">
        <header>
            <input type="text" placeholder="Search for courses">
            <button class="add-btn">Add New +</button>
        </header>

        <section class="welcome-banner">
            <h2>Welcome Back, <br> <strong><?php echo htmlspecialchars($userfname . " " . $userlname); ?></strong></h2>
            <p>Go back to the course &rarr;</p>
        </section>

        <section class="dashboard">
            <div class="dashboard-sections">
                <div class="schedule">
                    <h3>Today's Schedule</h3>
                    <div class="schedule-item">
                        <span>09 am</span>
                        <div class="course-card">
                            <p>Information Techno</p>
                            <small>Advanced Technology</small>
                            <button>Invite</button>
                        </div>
                    </div>
                    <div class="schedule-item">
                        <span>11 am</span>
                        <div class="course-card">
                            <p>Landing Page</p>
                            <button>Dashboard</button>
                        </div>
                    </div>
                </div>

                <div class="progress">
                    <h3>Last 20 Days</h3>
                    <?php
                    $sql = "SELECT sp.activity, sp.activity_date, ed.ExamName
                            FROM student_progress sp
                            LEFT JOIN examdetails ed 
                            ON sp.activity LIKE CONCAT('%', ed.ExamName, '%')
                            WHERE sp.student_id = '$userid'
                            AND DATE(sp.activity_date) >= DATE_SUB(CURDATE(), INTERVAL 20 DAY)
                            ORDER BY sp.activity_date DESC";

                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<div class='progress-item'>
                                    <strong>{$row['ExamName']} - {$row['activity']}</strong> 
                                    <span>({$row['activity_date']})</span>
                                  </div>";
                        }
                    } else {
                        echo "<p>No recent activities recorded.</p>";
                    }
                    ?>
                </div>
            </div>

            <section class="leaderboard">
    <h3>Leaderboard</h3>
    <table>
        <tr>
            <th>Rank</th>
            <th>Name</th>
            <th>Total Assessments</th>
            <th>Latest Activity</th>
        </tr>
        <?php
        $sql = "SELECT 
                    ROW_NUMBER() OVER (ORDER BY total_assessments DESC) AS rank,
                    student_name,
                    total_assessments,
                    latest_activity
                FROM leaderboard";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($entry = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$entry['rank']}</td>
                        <td>{$entry['student_name']}</td>
                        <td>{$entry['total_assessments']}</td>
                        <td>{$entry['latest_activity']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No leaderboard data found.</td></tr>";
        }
        ?>
    </table>
</section>

        </section>
    </div>

    <aside class="profile">
        <div class="profile-card">
            <img src="profile.jpg" alt="Profile">
            <h4><?php echo htmlspecialchars($userfname . " " . $userlname); ?></h4>
            <p>Student</p>
        </div>
    </aside>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="SCRIPT.JS"></script>
</body>
</html>
