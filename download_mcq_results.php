<?php
$conn = new mysqli("localhost", "root", "", "your_db_name");

if (!isset($_GET['exam_id'])) {
    die("Exam ID missing.");
}

$exam_id = $_GET['exam_id'];

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=exam_{$exam_id}_results.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "Exam Name\tRoll Number\tMarks (%)\tStatus\n";

$query = $conn->query("SELECT r.RollNumber, r.Marks, r.Status, e.ExamName 
    FROM result r 
    JOIN examdetails e ON r.Ex_ID = e.ExamID 
    WHERE r.Ex_ID = $exam_id");

while ($row = $query->fetch_assoc()) {
    echo "{$row['ExamName']}\t{$row['RollNumber']}\t{$row['Marks']}\t{$row['Status']}\n";
}
?>
