<?php
session_start();

if (empty($_SESSION["sidx"])) {
    header('Location: studentlogin');
    exit();
}

$userid = $_SESSION["sidx"];
$userfname = $_SESSION["fname"];
$userlname = $_SESSION["lname"];
$sEno = $_SESSION["seno"];

include('studenthead.php');
?>

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h3>Welcome <a href="welcomestudent.php" style="text-decoration: none; color: red;">
                <?php echo htmlspecialchars($userfname . " " . $userlname); ?></a></h3>

            <?php
            include('database.php');

            // Display available assessments
            $sql = "SELECT * FROM examdetails";
            $rs = mysqli_query($connect, $sql);

            echo "<h2 class='page-header'>Take Assessment</h2>";
            echo "<table class='table table-striped' style='width:100%'>
                    <tr>
                    <th>Exam ID</th>
                    <th>Exam Name</th>
                    <th>Take</th> 
                    </tr>";

            while ($row = mysqli_fetch_array($rs)) {
                echo "<tr>
                        <td>{$row['ExamID']}</td>
                        <td>{$row['ExamName']}</td>
                        <td>
                            <a href='takeassessment2.php?exid={$row['ExamID']}' style='text-decoration: none;'>
                                <button type='submit' class='btn btn-primary'>Take</button>
                            </a>
                        </td>
                      </tr>";
            }
            echo "</table>";
            ?>
        </div>
    </div>

    <!-- Progress Section for Last 20 Days -->
    <div class="progress">
        <h3>Last 20 Days</h3>
        <?php
        $sql = "SELECT activity, activity_date FROM student_progress 
                WHERE student_id = '$userid' 
                AND activity_date >= DATE_SUB(CURDATE(), INTERVAL 20 DAY)
                ORDER BY activity_date DESC";

        $result = mysqli_query($connect, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='progress-item'>
                        <strong>{$row['activity']}</strong>
                        <span>({$row['activity_date']})</span>
                      </div>";
            }
        } else {
            echo "<p>No recent activities recorded.</p>";
        }
        ?>
    </div>

    <?php include('allfoot.php'); ?>