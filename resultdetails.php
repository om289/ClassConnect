<?php
session_start();

if ($_SESSION["fidx"] == "" || $_SESSION["fidx"] == NULL) {
    header('Location:facultylogin.php');
}

$userid = $_SESSION["fidx"];
$fname = $_SESSION["fname"];
?>

<?php include('fhead.php'); ?>

<div class="container">
    <div class="row">
        <?php
        include("database.php");

        if (isset($_REQUEST['deleteid'])) {
            $deleteid = $_GET['deleteid'];
            $sql = "DELETE FROM `result` WHERE RsID = $deleteid";
            if (mysqli_query($connect, $sql)) {
                echo "<br><br><div class='alert alert-success fade in'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <strong>Success!</strong> Result details deleted.
                    </div>";
            } else {
                echo "<br><strong>Result Deletion Failed. Try Again</strong><br> Error: " . mysqli_error($connect);
            }
        }
        ?>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h3>Welcome Faculty: <a href="welcomefaculty.php"><span style="color:#FF0004"><?php echo $fname; ?></span></a></h3>
            <h2 class='page-header'>Result Details (Grouped by Assessment)</h2>

            <?php
            $examQuery = "SELECT DISTINCT Ex_ID FROM result ORDER BY Ex_ID DESC";
            $examResult = mysqli_query($connect, $examQuery);

            while ($exam = mysqli_fetch_assoc($examResult)) {
                $exam_id = $exam['Ex_ID'];

                // Get subject name from examdetails table
                $subjectQuery = mysqli_query($connect, "SELECT ExamName FROM examdetails WHERE ExamID = $exam_id");
                $subjectRow = mysqli_fetch_assoc($subjectQuery);
                $subject = $subjectRow ? $subjectRow['ExamName'] : "Unknown Subject";

                // Count total MCQs for this exam
                $mcqTotalQuery = mysqli_query($connect, "SELECT COUNT(*) as total FROM mcq_questions WHERE exam_id = $exam_id");
                $mcqTotalRow = mysqli_fetch_assoc($mcqTotalQuery);
                $total_mcqs = $mcqTotalRow['total'];

                echo "<div class='panel panel-default'>";
                echo "<div class='panel-heading'><strong>Assessment ID: $exam_id &nbsp;&nbsp; | &nbsp;&nbsp; Subject: $subject</strong></div>";
                echo "<div class='panel-body'>";

                $studentQuery = "SELECT * FROM result WHERE Ex_ID = $exam_id";
                $studentResult = mysqli_query($connect, $studentQuery);

                echo "<table class='table table-striped'>";
                echo "<tr>
                        <th>Result ID</th>
                        <th>Enrollment No</th>
                        <th>Student Name</th>
                        <th>Theory Marks</th>
                        <th>MCQ Marks</th>
                        <th>Total</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>";

                while ($row = mysqli_fetch_assoc($studentResult)) {
                    $rsid = $row['RsID'];
                    $enroll = $row['Eno'];
                    $theory_marks = $row['Marks'];

                    // Fix: If enrollment is empty, use roll number (legacy)
                    if (empty($enroll)) {
                        $enroll = $row['RollNumber'];
                    }

                    // Get student name from examans
                    $nameQuery = mysqli_query($connect, "SELECT Sname FROM examans WHERE Senrl = '$enroll' AND ExamID = $exam_id LIMIT 1");
                    $nameRow = mysqli_fetch_assoc($nameQuery);
                    $student_name = $nameRow ? $nameRow['Sname'] : "Unknown";

                    // MCQ score
                    $mcqCorrectQuery = mysqli_query($connect, "SELECT COUNT(*) as correct FROM mcq_answers WHERE student_roll = '$enroll' AND exam_id = $exam_id AND is_correct = 1");
                    $mcqCorrectRow = mysqli_fetch_assoc($mcqCorrectQuery);
                    $mcq_correct = $mcqCorrectRow['correct'];

                    $mcq_score_display = $total_mcqs > 0 ? "$mcq_correct / $total_mcqs" : "N/A";
                    $total_display = $total_mcqs > 0 ? ($theory_marks . $mcq_correct) : $theory_marks;

                    echo "<tr>
                            <td>$rsid</td>
                            <td>$enroll</td>
                            <td>$student_name</td>
                            <td>$theory_marks</td>
                            <td>$mcq_score_display</td>
                            <td>$total_display</td>
                            <td><a href='updateresultdetails.php?editid=$rsid'><button class='btn btn-info btn-sm'>Edit</button></a></td>
                            <td><a href='resultdetails.php?deleteid=$rsid'><button class='btn btn-danger btn-sm'>Delete</button></a></td>
                        </tr>";
                        
                }

                echo "</table>";
                echo "<a href='download_results_excel.php?exam_id=$exam_id' class='btn btn-success btn-sm' target='_blank'>📥 Download Results</a> ";
                echo "<a href='leaderboard.php?exam_id=$exam_id' class='btn btn-primary btn-sm' target='_blank'>🏆 View Leaderboard</a>";
                echo "</div></div>";
            }

            mysqli_close($connect);
            ?>
        </div>
    </div>
</div>

<?php include('allfoot.php'); ?>
