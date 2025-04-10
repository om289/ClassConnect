<?php
session_start();

// Redirect if not logged in as faculty
if (!isset($_SESSION["fidx"]) || $_SESSION["fidx"] == "") {
    header("Location: facultylogin.php");
    exit();
}

$fname = $_SESSION["fname"];
$conn = new mysqli("localhost", "root", "", "cc_db"); // Adjust DB credentials if needed

// Handle MCQ submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $exam_id = $_POST['exam_id'];
    $question = $_POST['question'];
    $option_a = $_POST['option_a'];
    $option_b = $_POST['option_b'];
    $option_c = $_POST['option_c'];
    $option_d = $_POST['option_d'];
    $correct_option = $_POST['correct_option'];

    $stmt = $conn->prepare("INSERT INTO mcq_questions (exam_id, question, option_a, option_b, option_c, option_d, correct_option) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssss", $exam_id, $question, $option_a, $option_b, $option_c, $option_d, $correct_option);

    // Log errors for debugging purposes
    if ($stmt->execute()) {
        echo "<div style='color: green;'>MCQ added successfully!</div>";
    } else {
        error_log("Error adding MCQ: " . $stmt->error, 3, "error_log");
        echo "<div style='color: red;'>Error: " . $stmt->error . "</div>";
    }
}
?>

<?php include('fhead.php'); ?>

<div class="container">
    <h3>Welcome Faculty: <span style="color:#FF0004;"><?php echo $fname; ?></span></h3>
    <h4>Create MCQ for an Exam</h4>

    <form method="POST" action="">
        <label><strong>Select Exam:</strong></label>
        <select name="exam_id" required>
            <option value="">Select an exam</option>
            <?php
            $result = $conn->query("SELECT ExamID, ExamName FROM examdetails");
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['ExamID'] . "'>" . $row['ExamName'] . "</option>";
            }
            ?>
        </select><br><br>

        <label><strong>Question:</strong></label><br>
        <textarea name="question" rows="4" cols="100" required></textarea><br><br>

        <label><strong>Option A:</strong></label><br>
        <input type="text" name="option_a" required><br>

        <label><strong>Option B:</strong></label><br>
        <input type="text" name="option_b" required><br>

        <label><strong>Option C:</strong></label><br>
        <input type="text" name="option_c" required><br>

        <label><strong>Option D:</strong></label><br>
        <input type="text" name="option_d" required><br><br>

        <label><strong>Correct Option:</strong></label>
        <select name="correct_option" required>
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="C">C</option>
            <option value="D">D</option>
        </select><br><br>

        <button type="submit" class="btn btn-primary">Add MCQ</button>
    </form>
</div>

<?php include('allfoot.php'); ?>
