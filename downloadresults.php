<?php
include("database.php");

// Set headers to force download of the Excel file
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=results.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Fetch results from the database
$sql = "SELECT studenttable.RollNumber, CONCAT(studenttable.FName, ' ', studenttable.LName) AS StudentName, result.Marks 
        FROM result 
        INNER JOIN studenttable ON result.RollNumber = studenttable.RollNumber";
$result = mysqli_query($connect, $sql);

// Start outputting the Excel file
echo "Roll Number\tStudent Name\tMarks\n";

while ($row = mysqli_fetch_assoc($result)) {
    echo $row['RollNumber'] . "\t" . $row['StudentName'] . "\t" . $row['Marks'] . "\n";
}

mysqli_close($connect);
?>