<?php
if (!isset($_GET['exam_id'])) {
    die("Exam ID missing.");
}

$exam_id = intval($_GET['exam_id']);
$conn = new mysqli("localhost", "root", "", "cc_db");

header('Content-Type: text/csv');
header("Content-Disposition: attachment; filename=leaderboard_exam_$exam_id.csv");

$output = fopen("php://output", "w");
fputcsv($output, ["Rank", "Roll Number", "Score", "Total"]);

$query = "SELECT rollno, score, total FROM mcq_results WHERE exam_id = $exam_id ORDER BY score DESC";
$result = $conn->query($query);

$rank = 1;
while ($row = $result->fetch_assoc()) {
    fputcsv($output, [$rank++, $row['rollno'], $row['score'], $row['total']]);
}

fclose($output);
$conn->close();
?>
