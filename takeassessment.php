<?php
session_start();

// Check if the session variable "seno" is set
if (!isset($_SESSION["seno"]) || $_SESSION["seno"] == "") {
    // Redirect to the login page if "seno" is not set
    header('Location:studentlogin.php');
    exit();
}

// Retrieve session variables
$userid = $_SESSION["sidx"];
$userfname = isset($_SESSION["fname"]) ? $_SESSION["fname"] : "Student";
$userlname = isset($_SESSION["lname"]) ? $_SESSION["lname"] : "";
$sEno = $_SESSION["seno"]; // Ensure "seno" is properly retrieved

include('studenthead.php');
?>

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h3>Welcome <a href="welcomestudent.php" style="text-decoration: none; color: red;">
                <?php echo htmlspecialchars($userfname . " " . $userlname); ?></a></h3>

            <?php
            include('database.php');

            // Fetch assessments for the student's course, year, and division
            $course = $_SESSION['course'];
            $year = $_SESSION['year'];
            $division = isset($_SESSION['division']) ? $_SESSION['division'] : '';

            if (empty($division)) {
                echo "<p>Error: Division information is missing. Please update your profile or contact the administrator.</p>";
                exit;
            }

            $sql = "SELECT * FROM assessment WHERE Course = '$course' AND Year = '$year' AND Division = '$division'";
            $result = mysqli_query($connect, $sql);

            if (!$result) {
                echo "<p>Error: Unable to fetch assessments. Please try again later.</p>";
                exit;
            }

            if (mysqli_num_rows($result) > 0) {
                echo "<h3>Available Assessments</h3><ul>";
                while ($row = mysqli_fetch_assoc($result)) {
                    $link = $row['AssessmentType'] === 'MCQ' ? 'attemptmcq.php' : 'attempttext.php';
                    echo "<li><a href='$link?assessment_id=" . $row['AssessmentID'] . "'>" . $row['AssessmentName'] . "</a></li>";
                }
                echo "</ul>";
            } else {
                echo "<p>No assessments available for your course, year, and division.</p>";
            }
            ?>
        </div>
    </div>
</div>

<?php include('allfoot.php'); ?>