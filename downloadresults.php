<?php
include('database.php');

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=assessment_results.csv');

if (!isset($_GET['assessment_id']) || empty($_GET['assessment_id'])) {
    echo "<p>Error: Missing assessment identifier. Please try again later.</p>";
    exit();
}

$output = fopen('php://output', 'w');
fputcsv($output, array('Student Name', 'Roll Number', 'Assessment Name', 'Marks'));

$assessmentID = $_GET['assessment_id'];
$sql = "SELECT st.FName, st.LName, st.RollNumber, a.AssessmentName, sa.Marks FROM submitted_answers sa JOIN studenttable st ON sa.RollNumber = st.RollNumber JOIN assessment a ON sa.AssessmentID = a.AssessmentID WHERE sa.AssessmentID = $assessmentID";
$result = mysqli_query($connect, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, array($row['FName'] . ' ' . $row['LName'], $row['RollNumber'], $row['AssessmentName'], $row['Marks']));
    }
}

fclose($output);
?>