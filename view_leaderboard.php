<?php
$conn = new mysqli("localhost", "root", "", "cc_db");
$exam_id = $_GET['exam_id'];

$sql = "SELECT student_roll, SUM(is_correct) as total_correct 
        FROM mcq_answers 
        WHERE exam_id = $exam_id 
        GROUP BY student_roll 
        ORDER BY total_correct DESC";

$result = $conn->query($sql);
echo "<h3>Score Leaderboard</h3><table border='1'><tr><th>Roll No</th><th>Score</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr><td>{$row['student_roll']}</td><td>{$row['total_correct']}</td></tr>";
}
echo "</table>";
?>
