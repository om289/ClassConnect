<?php
session_start();

if ($_SESSION["fidx"] == "" || $_SESSION["fidx"] == NULL) {
    header('Location:facultylogin.php');
}

$userid = $_SESSION["fidx"];
$fname = $_SESSION["fname"];

include("database.php");

?>
<?php include('fhead.php'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-8">

            <h3> Welcome Faculty : <a href="welcomefaculty.php"><span style="color:#FF0004"> <?php echo $fname; ?></span></a> </h3>

            <?php
            if (isset($_GET['makeid'])) {
                $makeid = $_GET['makeid']; // Retrieve the `makeid` parameter from the URL

                // Validate `makeid`
                if (!empty($makeid)) {
                    // Fetch data from the `examans` table
                    $sql = "SELECT * FROM examans WHERE ExamID = $makeid";
                    $rs = mysqli_query($connect, $sql);

                    if ($rs && mysqli_num_rows($rs) > 0) {
                        while ($row = mysqli_fetch_array($rs)) {
                            $rollNumber = isset($row['RollNumber']) ? $row['RollNumber'] : null;
                            $examID = isset($row['ExamID']) ? $row['ExamID'] : null;

                            if ($rollNumber && $examID) {
                                ?>
                                <fieldset>
                                    <legend>Make Result</legend>
                                    <form action="" method="POST" name="makeresult">
                                        <table class="table table-hover">
                                            <tr>
                                                <td><strong>Enrolment Number:</strong></td>
                                                <td><?php echo $rollNumber; ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Exam ID:</strong></td>
                                                <td><?php echo $examID; ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Marks:</strong></td>
                                                <td>
                                                    <input type="number" name="marks" class="form-control" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Status:</strong></td>
                                                <td>
                                                    <select name="status" class="form-control" required>
                                                        <option value="Pass">Pass</option>
                                                        <option value="Fail">Fail</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <button type="submit" name="submit" class="btn btn-primary">Submit Result</button>
                                                </td>
                                            </tr>
                                        </table>
                                        <input type="hidden" name="rollnumber" value="<?php echo $rollNumber; ?>">
                                        <input type="hidden" name="examid" value="<?php echo $examID; ?>">
                                    </form>
                                </fieldset>
                                <?php
                            } else {
                                echo "<div class='alert alert-danger'>Invalid data for the selected exam.</div>";
                            }
                        }
                    } else {
                        echo "<div class='alert alert-danger'>No records found for the given Exam ID.</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger'>Invalid Exam ID.</div>";
                }
            }

            // Handle form submission
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
                $rollnumber = $_POST['rollnumber'];
                $examid = $_POST['examid'];
                $marks = $_POST['marks'];
                $status = $_POST['status'];

                // Insert result into the `result` table
                $sql = "INSERT INTO `result` (`RollNumber`, `Ex_ID`, `Marks`, `Status`) 
                        VALUES ('$rollnumber', '$examid', '$marks', '$status')";

                if (mysqli_query($connect, $sql)) {
                    echo "<div class='alert alert-success'>Result added successfully!</div>";
                } else {
                    echo "<div class='alert alert-danger'>Error: " . mysqli_error($connect) . "</div>";
                }
            }

            mysqli_close($connect);
            ?>
        </div>
    </div>
    <?php include('allfoot.php'); ?>
</div>
</body>
</html>
