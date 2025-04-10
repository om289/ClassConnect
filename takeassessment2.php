<?php
session_start();

// Debug session
// echo "<pre>"; print_r($_SESSION); echo "</pre>";

if (!isset($_SESSION["rollno"]) || $_SESSION["rollno"] == "") {
    echo "Session value for 'rollno' is missing!";
    exit();
}

$userid = $_SESSION["rollno"];
$userfname = $_SESSION["fname"];
$userlname = $_SESSION["lname"];
$sEno = $_SESSION["rollno"]; // RollNumber is being used

include('studenthead.php');
include('database.php');

$exid = $_GET['exid'];

// Fetch student info
$sql = "SELECT * FROM studenttable WHERE RollNumber='$sEno'";
$result = mysqli_query($connect, $sql);

// Fetch theory questions
$theory_sql = "SELECT * FROM examdetails WHERE ExamID='$exid'";
$theory_result = mysqli_query($connect, $theory_sql);

// Fetch MCQ questions
$mcq_sql = "SELECT * FROM mcq_questions WHERE exam_id='$exid'";
$mcq_result = mysqli_query($connect, $mcq_sql);
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">

            <h3> Welcome <a href="welcomestudent"><?php echo "<span style='color:red'>" . $userfname . " " . $userlname . "</span>"; ?></a></h3>

            <?php if ($row = mysqli_fetch_array($result)) { ?>
                <fieldset>
                    <legend>Assessment Details</legend>
                    <form action="" method="POST">
                        <div class="col-md-6">
                            <table>
                                <tr>
                                    <td><strong>Roll Number :</strong></td>
                                    <td><?php echo $row['RollNumber']; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Name :</strong></td>
                                    <td><?php echo $row['FName'] . " " . $row['LName']; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Course :</strong></td>
                                    <td><?php echo $row['Course']; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Applied For :</strong></td>
                                    <td><?php echo $exid; ?></td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-12">
                            <hr>
                            <h3 style="color:red;">Theory Questions</h3>
                            <?php if ($trow = mysqli_fetch_array($theory_result)) { ?>
                                <?php for ($i = 1; $i <= 5; $i++) {
                                    $q = $trow["Q$i"];
                                    if (!empty($q)) { ?>
                                        <div>
                                            <h4><strong>Q<?php echo $i; ?>. <?php echo $q; ?></strong></h4>
                                            <textarea name="Q<?php echo $i; ?>" rows="4" cols="100" required></textarea>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        </div>

                        <div class="col-md-12">
                            <hr>
                            <h3 style="color:red;">MCQ Questions</h3>
                            <?php
                            $mcqIndex = 1;
                            while ($mcq = mysqli_fetch_array($mcq_result)) { ?>
                                <div>
                                    <h4><strong>Q<?php echo $mcqIndex; ?>. <?php echo $mcq['question']; ?></strong></h4>
                                    <?php foreach (['A', 'B', 'C', 'D'] as $opt) {
                                        $optVal = strtolower("option_" . $opt); ?>
                                        <label>
                                            <input type="radio" name="mcq_<?php echo $mcq['id']; ?>" value="<?php echo $opt; ?>" required>
                                            <?php echo $opt . ". " . $mcq[$optVal]; ?>
                                        </label><br>
                                    <?php } ?>
                                </div>
                                <br>
                                <?php $mcqIndex++;
                            } ?>
                        </div>

                        <br>
                        <button type="submit" name="done" class="btn btn-primary">I am Done!</button>
                    </form>
                </fieldset>
            <?php } ?>

            <?php
            if (isset($_POST['done'])) {
                $Ex_id = $exid;
                $sname = $userfname . " " . $userlname;

                // Save theory answers
                $answers = [];
                for ($i = 1; $i <= 5; $i++) {
                    $key = "Q$i";
                    $answers[$key] = isset($_POST[$key]) ? mysqli_real_escape_string($connect, $_POST[$key]) : "";
                }

                $insertTheory = "INSERT INTO examans (ExamID, Senrl, Sname, Ans1, Ans2, Ans3, Ans4, Ans5)
                                 VALUES ('$Ex_id', '$sEno', '$sname', '{$answers['Q1']}', '{$answers['Q2']}', '{$answers['Q3']}', '{$answers['Q4']}', '{$answers['Q5']}')";
                mysqli_query($connect, $insertTheory);

                // Save MCQ answers
                $mcq_result = mysqli_query($connect, $mcq_sql); // re-fetch
                while ($mcq = mysqli_fetch_array($mcq_result)) {
                    $mcq_id = $mcq['id'];
                    $selected = isset($_POST["mcq_$mcq_id"]) ? $_POST["mcq_$mcq_id"] : null;
                    if ($selected) {
                        $stmt = $connect->prepare("INSERT INTO mcq_answers (exam_id, question_id, student_rollno, selected_option) VALUES (?, ?, ?, ?)");
                        $stmt->bind_param("iiis", $Ex_id, $mcq_id, $sEno, $selected);
                        $stmt->execute();
                    }
                }

                // Track Progress
                $testName = "Assessment for Exam ID $exid";
                $progressSql = "INSERT INTO student_progress (student_id, activity, activity_date)
                                VALUES ('$userid', 'Assessment Completed: $testName', CURDATE())";
                mysqli_query($connect, $progressSql);

                echo "<br><div class='alert alert-success'>Assessment has been submitted successfully!</div>";
            }
            ?>

        </div>
    </div>
    <?php include('allfoot.php'); ?>
</div>
