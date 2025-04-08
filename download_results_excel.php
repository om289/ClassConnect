<?php
include("database.php");

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=student_results.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "Result ID\tEnrolment Number\tMarks\n";

$query = "SELECT RsID, Eno, Marks FROM result";
$result = mysqli_query($connect, $query);

while ($row = mysqli_fetch_assoc($result)) {
    echo "{$row['RsID']}\t{$row['Eno']}\t{$row['Marks']}\n";
}
?>
