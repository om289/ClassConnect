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
        <div class="col-md-8">
            <h3> Welcome Faculty : <a href="welcomefaculty.php"><span style="color:#FF0004"> <?php echo $fname; ?></span></a> </h3>
            <h2 class="page-header">Exam Details</h2>
            <?php
            include("database.php");

            // Fetch exam details
            $sql = "SELECT * FROM examans";
            $rs = mysqli_query($connect, $sql);

            if (mysqli_num_rows($rs) > 0) {
                echo "<table class='table table-striped' style='width:100%'>
                <tr>
                    <th>Exam ID</th>
                    <th>Enrolment Number</th>
                    <th>Answer</th>
                    <th>Marks Obtained</th>
                    <th>Make Result</th>
                </tr>";

                while ($row = mysqli_fetch_array($rs)) {
                    $examID = isset($row['ExamID']) ? $row['ExamID'] : 'N/A';
                    $rollNumber = isset($row['RollNumber']) ? $row['RollNumber'] : 'N/A';
                    $answer = isset($row['Answer']) ? $row['Answer'] : 'N/A';
                    $marksObtained = isset($row['MarksObtained']) ? $row['MarksObtained'] : 'N/A';

                    echo "<tr>
                        <td>{$examID}</td>
                        <td>{$rollNumber}</td>
                        <td>{$answer}</td>
                        <td>{$marksObtained}</td>
                        <td>
                            <a href='makeresult.php?makeid={$examID}' class='btn btn-primary'>Make Result</a>
                        </td>
                    </tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No exam details found.</p>";
            }

            mysqli_close($connect);
            ?>
        </div>
    </div>
    <?php include('allfoot.php'); ?>
</div>