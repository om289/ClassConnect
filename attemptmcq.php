<?php
session_start();
if (!isset($_SESSION["sidx"]) || $_SESSION["sidx"] == "") {
    header("Location: studentlogin.php");
    exit();
}

$roll = $_SESSION["rollno"];
$sname = $_SESSION["sname"];
$conn = new mysqli("localhost", "root", "", "cc_db");

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

    echo "<div style='color:green;'>You scored $score out of $total</div><hr>";
}

// Show MCQ form
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
                $selected = (isset($_GET["exam_id"]) && $_GET["exam_id"] == $row["ExamID"]) ? "selected" : "";
                echo "<option value='" . $row["ExamID"] . "' $selected>" . $row["ExamName"] . "</option>";
            }
            ?>
        </select>
        <button type="submit" class="btn btn-info">Load MCQ</button>
    </form>

    <?php
    if (isset($_GET["exam_id"])) {
        $exam_id = $_GET["exam_id"];
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
    ?>
</div>
<?php include("allfoot.php"); ?>
