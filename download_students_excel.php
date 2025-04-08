<?php
include("database.php");

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=student_details.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "Roll Number\tFirst Name\tLast Name\tFather's Name\tAddress\tGender\tCourse\tDOB\tPhone Number\tEmail\n";

$query = "SELECT RollNumber, FName, LName, FaName, Addrs, Gender, Course, DOB, PhNo, Eid FROM studenttable";
$result = mysqli_query($connect, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $dobFormatted = date("d-m-Y", strtotime($row['DOB'])); // Format DOB here

    echo "{$row['RollNumber']}\t{$row['FName']}\t{$row['LName']}\t{$row['FaName']}\t{$row['Addrs']}\t{$row['Gender']}\t{$row['Course']}\t{$dobFormatted}\t{$row['PhNo']}\t{$row['Eid']}\n";
}

?>
