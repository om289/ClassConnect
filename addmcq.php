<?php
session_start();
if (!isset($_SESSION["fidx"]) || $_SESSION["fidx"] == "") {
    header("Location: facultylogin.php");
    exit();
}
$fname = $_SESSION["fname"];
$conn = new mysqli("localhost", "root", "", "cc_db");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['questions'])) {
    $exam_id = $_POST['exam_id'];
    $questions = $_POST['questions'];
    $option_as = $_POST['option_a'];
    $option_bs = $_POST['option_b'];
    $option_cs = $_POST['option_c'];
    $option_ds = $_POST['option_d'];
    $correct_options = $_POST['correct_option'];

    $stmt = $conn->prepare("INSERT INTO mcq_questions (exam_id, question, option_a, option_b, option_c, option_d, correct_option) VALUES (?, ?, ?, ?, ?, ?, ?)");
    
    for ($i = 0; $i < count($questions); $i++) {
        $stmt->bind_param(
            "issssss",
            $exam_id,
            $questions[$i],
            $option_as[$i],
            $option_bs[$i],
            $option_cs[$i],
            $option_ds[$i],
            $correct_options[$i]
        );
        $stmt->execute();
    }
    echo "<div style='color: green;'>MCQs added successfully!</div>";
}
?>

<?php include('fhead.php'); ?>

<div class="container">
    <h3>Welcome Faculty: <span style="color:#FF0004;"><?php echo $fname; ?></span></h3>
    <h4>Create Multiple MCQs for an Exam</h4>

    <form method="POST" id="mcqForm">
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

        <label><strong>Number of Questions:</strong></label>
        <input type="number" id="numQuestions" min="1" max="20" required>
        <button type="button" onclick="generateQuestions()">Generate</button><br><br>

        <div id="questionContainer"></div>

        <button type="submit" class="btn btn-primary" style="display:none;" id="submitBtn">Submit All MCQs</button>
    </form>
</div>

<script>
function generateQuestions() {
    const num = document.getElementById("numQuestions").value;
    const container = document.getElementById("questionContainer");
    container.innerHTML = "";

    for (let i = 0; i < num; i++) {
        const block = `
            <div style="border: 1px solid #ccc; padding: 15px; margin-bottom: 20px;">
                <h5>Question ${i + 1}</h5>
                <label>Question:</label><br>
                <textarea name="questions[]" rows="2" cols="100" required></textarea><br><br>

                <label>Option A:</label><br>
                <input type="text" name="option_a[]" required><br>

                <label>Option B:</label><br>
                <input type="text" name="option_b[]" required><br>

                <label>Option C:</label><br>
                <input type="text" name="option_c[]" required><br>

                <label>Option D:</label><br>
                <input type="text" name="option_d[]" required><br>

                <label>Correct Option:</label>
                <select name="correct_option[]" required>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                </select>
            </div>
        `;
        container.innerHTML += block;
    }

    document.getElementById("submitBtn").style.display = "inline-block";
}
</script>

<?php include('allfoot.php'); ?>
