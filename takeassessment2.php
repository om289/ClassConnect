<?php
session_start();

// Debugging session data
echo "<pre>";
print_r($_SESSION);  // View all session data for debugging
echo "</pre>";

// Session validation
if (!isset($_SESSION["seno"]) || $_SESSION["seno"] == "") {
    echo "Session value for 'seno' is missing!";
    exit();
}

$userid = $_SESSION["seno"];  // Correct reference for student ID
$userfname = $_SESSION["fname"];
$userlname = $_SESSION["lname"];
$sEno = $_SESSION["seno"];  // Ensure this matches `Eno` in `studenttable`

include('studenthead.php');
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">

            <h3> Welcome <a href="welcomestudent"><?php echo "<span style='color:red'>" . $userfname . " " . $userlname . "</span>"; ?></a></h3>

            <?php
            $exid = $_GET['exid'];
            include('database.php');

            // Fetch Student and Exam Details
            $sql = "SELECT * FROM studenttable WHERE Eno='$sEno'";
            $sql2 = "SELECT * FROM examdetails WHERE ExamID='$exid'";

            $result = mysqli_query($connect, $sql);
            $result2 = mysqli_query($connect, $sql2);

            if ($row = mysqli_fetch_array($result)) { ?>
            
            <fieldset>
                <legend>Assessment Details</legend>
                <form action="" method="POST" name="update">
                    <div class="col-md-4">
                        <table>
                            <tr>
                                <td><strong>Enrolment number :</strong></td>
                                <td><?php echo $row['Eno']; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Name :</strong></td>
                                <td><?php echo $row['FName'] . " " . $row['LName']; ?></td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-4">
                        <table>
                            <tr>
                                <td><strong>Course :</strong></td>
                                <td><?php echo $row['Course']; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Applied For :</strong></td>
                                <td><?php echo $exid; ?><br></td>
                            </tr>
                        </table>
                    </div>

                    <br><br>
                    <hr>

                    <?php while ($row2 = mysqli_fetch_array($result2)) { ?>
                        <div class="col-md-12">
                            <span style="color: red;"><h3>Answer The Following Questions..</h3></span>

                            <div>
                                <h4> <strong>Q1. <?php echo $row2['Q1']; ?></strong></h4>
                                <div><textarea name="Q1" rows="5" cols="150" required></textarea></div>
                            </div>

                            <div>
                                <h4> <strong>Q2. <?php echo $row2['Q2']; ?></strong></h4>
                                <div><textarea name="Q2" rows="5" cols="150" required></textarea></div>
                            </div>

                            <div>
                                <h4> <strong>Q3. <?php echo $row2['Q3']; ?></strong></h4>
                                <div><textarea name="Q3" rows="5" cols="150" required></textarea></div>
                            </div>

                            <div>
                                <h4> <strong>Q4. <?php echo $row2['Q4']; ?></strong></h4>
                                <div><textarea name="Q4" rows="5" cols="150" required></textarea></div>
                            </div>

                            <div>
                                <h4> <strong>Q5. <?php echo $row2['Q5']; ?></strong></h4>
                                <div><textarea name="Q5" rows="5" cols="150" required></textarea></div>
                            </div>
                        </div>
                    <?php } ?>

                    <br><br>
                    <button type="submit" name="done" class="btn btn-primary">I am Done!</button>
                </form>
            </fieldset>

            <?php
            }

            if (isset($_POST['done'])) {
                $Ex_id = $exid;
                $tempsname = $userfname . " " . $userlname;
                $tempq1 = mysqli_real_escape_string($connect, $_POST['Q1']);
                $tempq2 = mysqli_real_escape_string($connect, $_POST['Q2']);
                $tempq3 = mysqli_real_escape_string($connect, $_POST['Q3']);
                $tempq4 = mysqli_real_escape_string($connect, $_POST['Q4']);
                $tempq5 = mysqli_real_escape_string($connect, $_POST['Q5']);

                // Insert Assessment Answers
                $sql = "INSERT INTO `examans` (ExamID, Senrl, Sname, Ans1, Ans2, Ans3, Ans4, Ans5)
                        VALUES ('$Ex_id','$sEno','$tempsname','$tempq1','$tempq2','$tempq3','$tempq4','$tempq5')";

                if (mysqli_query($connect, $sql)) {
                    // Insert Progress Tracking for Last 20 Days
                    $testName = "Sample Test";  // Replace dynamically if needed
                    $progressSql = "INSERT INTO `student_progress` (student_id, activity, activity_date)
                                    VALUES ('$userid', 'Assessment Completed: $testName', CURDATE())";

                    if (mysqli_query($connect, $progressSql)) {
                        echo "<br><br>
                        <div class='alert alert-success fade in'>
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                            <strong>Success!</strong> Assessment has been submitted and recorded.
                        </div>";
                    } else {
                        echo "<br><strong>Progress Recording Failed.</strong> Error: " . mysqli_error($connect);
                    }
                } else {
                    echo "<br><strong>Assessment Submission Failed.</strong> Error: " . mysqli_error($connect);
                }

                mysqli_close($connect);
            }
            ?>
        </div>
    </div>
    <?php include('allfoot.php'); ?>
</div>
