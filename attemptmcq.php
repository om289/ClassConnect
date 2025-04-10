<?php
session_start();
if (!isset($_SESSION["sidx"]) || $_SESSION["sidx"] == "") {
    header("Location: studentlogin.php");
    exit();
}

$roll = $_SESSION["rollno"];
$sname = $_SESSION["sname"];
$conn = new mysqli("localhost", "root", "", "cc_db");

// Check if exam is selected
$exam_id = isset($_GET["exam_id"]) ? $_GET["exam_id"] : null;

// Prevent multiple attempts
$already_attempted = false;
if ($exam_id) {
    $check = $conn->prepare("SELECT * FROM mcq_results WHERE rollno = ? AND exam_id = ?");
    $check->bind_param("si", $roll, $exam_id);
    $check->execute();
    $res = $check->get_result();
    if ($res->num_rows > 0) {
        $already_attempted = true;
    }
}

// Handle MCQ submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_mcq"])) {
    $exam_id = $_POST["exam_id"];
    $score = 0;
    $total = count($_POST["answers"]);

    foreach ($_POST["answers"] as $question_id => $selected_option) {
        $res = $conn->query("SELECT correct_option FROM mcq_questions WHERE id=$question_id");
        $row = $res->fetch_assoc();
        if (strtoupper($selected_option) == strtoupper($row['correct_option'])) {
            $score++;
        }
    }


    // Store result
    $conn->query("INSERT INTO mcq_results (rollno, exam_id, score, total) VALUES ('$roll', '$exam_id', $score, $total)");

    $enrollment = $_SESSION["enrollment"];
    $conn->query("INSERT INTO result (Eno, Ex_ID, Marks, RollNumber) 
                VALUES ('$enrollment', '$exam_id', '$score', '$roll')");


    echo "<div style='color:green;'>You scored $score out of $total</div><hr>";
    $already_attempted = true; // So questions don’t show again
}
?>

<?php include("shead.php"); ?>
<div class="container">
    <h3>Welcome <?php echo $sname; ?> (Roll No: <?php echo $roll; ?>)</h3>
    <form method="GET" action="">
        <label><strong>Select Exam:</strong></label>
        <select name="exam_id" required>
            <option value="">Select an exam</option>
            <?php
            $result = $conn->query("SELECT ExamID, ExamName FROM examdetails");
            while ($row = $result->fetch_assoc()) {
                $selected = ($exam_id == $row["ExamID"]) ? "selected" : "";
                echo "<option value='" . $row["ExamID"] . "' $selected>" . $row["ExamName"] . "</option>";
            }
            ?>
        </select>
        <button type="submit" class="btn btn-info">Load MCQ</button>
    </form>

    <?php
    if ($exam_id) {
        if ($already_attempted) {
            echo "<p style='color:red; margin-top:20px;'><strong>You have already attempted this assessment.</strong></p>";
        } else {
            $questions = $conn->query("SELECT * FROM mcq_questions WHERE exam_id=$exam_id");

            if ($questions->num_rows > 0) {
                echo "<form method='POST'>";
                echo "<input type='hidden' name='exam_id' value='$exam_id'>";
                echo "<hr>";
                $qno = 1;
                while ($q = $questions->fetch_assoc()) {
                    echo "<p><strong>Q$qno. " . $q["question"] . "</strong></p>";
                    echo "<label><input type='radio' name='answers[" . $q["id"] . "]' value='A' required> A. " . $q["option_a"] . "</label><br>";
                    echo "<label><input type='radio' name='answers[" . $q["id"] . "]' value='B'> B. " . $q["option_b"] . "</label><br>";
                    echo "<label><input type='radio' name='answers[" . $q["id"] . "]' value='C'> C. " . $q["option_c"] . "</label><br>";
                    echo "<label><input type='radio' name='answers[" . $q["id"] . "]' value='D'> D. " . $q["option_d"] . "</label><br><hr>";
                    $qno++;
                }
                echo "<button type='submit' name='submit_mcq' class='btn btn-success'>Submit Answers</button>";
                echo "</form>";
            } else {
                echo "<p style='color:red;'>No MCQs found for this exam.</p>";
            }
        }
    }
    ?>
</div>
<?php include("allfoot.php"); ?>
