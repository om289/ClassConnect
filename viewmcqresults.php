<?php
$conn = new mysqli("localhost", "root", "", "your_db_name");
?>

<h2>MCQ Assessment Results</h2>

<form method="POST">
    <label>Select Exam:</label>
    <select name="exam_id" required>
        <?php
        $res = $conn->query("SELECT ExamID, ExamName FROM examdetails");
        while ($row = $res->fetch_assoc()) {
            echo "<option value='{$row['ExamID']}'>{$row['ExamName']}</option>";
        }
        ?>
    </select>
    <button type="submit">View</button>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $exam_id = $_POST['exam_id'];
    
    $query = $conn->query("SELECT r.RollNumber, r.Marks, r.Status, e.ExamName 
        FROM result r 
        JOIN examdetails e ON r.Ex_ID = e.ExamID 
        WHERE r.Ex_ID = $exam_id");

    if ($query->num_rows > 0) {
        echo "<table border='1' cellpadding='8'>";
        echo "<tr><th>Exam</th><th>Roll Number</th><th>Marks (%)</th><th>Status</th></tr>";

        while ($row = $query->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['ExamName']}</td>
                    <td>{$row['RollNumber']}</td>
                    <td>{$row['Marks']}%</td>
                    <td>{$row['Status']}</td>
                  </tr>";
        }
        echo "</table>";

        echo "<br><a href='download_mcq_results.php?exam_id=$exam_id' target='_blank'>📥 Download as Excel</a>";
    } else {
        echo "<p>No results found for this exam.</p>";
    }
}
?>
