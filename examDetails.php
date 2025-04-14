<?php
session_start();
if ($_SESSION["fidx"] == "" || $_SESSION["fidx"] == NULL) {
    header('Location: facultylogin');
}
$userid = $_SESSION["fidx"];
$fname = $_SESSION["fname"];
?>
<?php include('fhead.php'); ?>

<div class="container">
    <div class="row">
        <?php /* Delete functionality remains same */ ?>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <h3>Welcome Faculty: <a href="welcomefaculty.php"><span style="color:#FF0004"><?php echo $fname; ?></span></a></h3>

            <?php
            include('database.php');
            $sql = "SELECT * FROM examans";
            $rs = mysqli_query($connect, $sql);
            echo "<h2 class='page-header'>Exam Submissions</h2>";
            echo "<table class='table table-striped' style='width:100%'>
                <tr>
                    <th>Exam ID</th>
                    <th>Enrolment Number</th>
                    <th>Delete</th>
                    <th>Make Result</th>
                </tr>";

            while($row = mysqli_fetch_array($rs)) {
                echo "<tr>
                    <td>{$row['ExamID']}</td>
                    <td>{$row['Senrl']}</td>
                    <td>
                        <a href='examDetails.php?deleteid={$row['ExamID']}' class='btn btn-danger btn-sm'>Delete</a>
                    </td>
                    <td>
                        <a href='makeresult.php?examid={$row['ExamID']}&enrl={$row['Senrl']}' class='btn btn-primary btn-sm'>
                            Evaluate Answers
                        </a>
                    </td>
                </tr>";
            }
            ?>
            </table>
        </div>
    </div>
</div>
<?php include('allfoot.php'); ?>