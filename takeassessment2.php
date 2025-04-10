<?php
session_start();

// Debugging session data
if (!isset($_SESSION["seno"]) || $_SESSION["seno"] == "") {
    echo "Session value for 'seno' is missing!";
    exit();
}

$userid = $_SESSION["seno"];  // Correct reference for student ID
$userfname = $_SESSION["fname"];
$userlname = $_SESSION["lname"];
$sEno = $_SESSION["seno"];  // Ensure this matches `RollNumber` in `studenttable`

// Include the database connection
include('database.php'); // Ensure this file defines the `$conn` variable

// Check if the database connection is established
if (!isset($conn) || !$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

include('studenthead.php');
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">

            <h3> Welcome <a href="welcomestudent"><?php echo "<span style='color:red'>" . $userfname . " " . $userlname . "</span>"; ?></a></h3>

            <?php
            $exid = $_GET['exid'];

            // Fetch Student and Exam Details
            $sql = "SELECT * FROM studenttable WHERE RollNumber='$sEno'";
            $sql2 = "SELECT * FROM examdetails WHERE ExamID='$exid'";

            $result = mysqli_query($conn, $sql);
            $result2 = mysqli_query($conn, $sql2);

            if ($row = mysqli_fetch_array($result)) { ?>
            
            <fieldset>
                <legend>Assessment Details</legend>
                <form action="" method="POST" name="update">
                    <div class="col-md-4">
                        <table>
                            <tr>
                                <td><strong>Enrolment number :</strong></td>
                                <td><?php echo $row['RollNumber']; ?></td>
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

            // Store each answer as a separate row in the examans table
            if (isset($_POST['done'])) {
                $Ex_id = $exid;
                $answers = [$_POST['Q1'], $_POST['Q2'], $_POST['Q3'], $_POST['Q4'], $_POST['Q5']];

                foreach ($answers as $index => $answer) {
                    $questionNumber = $index + 1;
                    $sanitizedAnswer = mysqli_real_escape_string($conn, $answer);
                    $sql = "INSERT INTO examans (ExamID, RollNumber, Answer, MarksObtained) VALUES ('$Ex_id', '$sEno', '$sanitizedAnswer', 0)";

                    if (!mysqli_query($conn, $sql)) {
                        echo "<br><strong>Failed to save answer for Question $questionNumber.</strong> Error: " . mysqli_error($conn);
                    }
                }

                // Insert Progress Tracking
                $progressSql = "INSERT INTO student_progress (RollNumber, activity, activity_date) VALUES ('$userid', 'Assessment Completed: $Ex_id', CURDATE())";

                if (mysqli_query($conn, $progressSql)) {
                    echo "<br><br><div class='alert alert-success fade in'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong>Success!</strong> Assessment has been submitted and recorded.
                    </div>";
                } else {
                    echo "<br><strong>Progress Recording Failed.</strong> Error: " . mysqli_error($conn);
                }

                mysqli_close($conn);
            }
            ?>
        </div>
    </div>
    <?php include('allfoot.php'); ?>
</div>