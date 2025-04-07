<?php
session_start();

if ($_SESSION["fidx"] == "" || $_SESSION["fidx"] == NULL) {
    header('Location:facultylogin.php');
}

$userid = $_SESSION["fidx"];
$fname = $_SESSION["fname"];
?>
<?php include('fhead.php'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h3> Welcome Faculty : <a href="welcomefaculty.php"><span style="color:#FF0004"> <?php echo $fname; ?></span></a> </h3>
            <h2 class="page-header">Result Details</h2>
            <!-- Button to download results in Excel format -->
            <a href="downloadresults.php" class="btn btn-success">Download Results in Excel</a>
            <br><br>
            <?php
            include("database.php");
            // Query to fetch result details
            $sql = "SELECT result.RsID, studenttable.RollNumber, CONCAT(studenttable.FName, ' ', studenttable.LName) AS StudentName, result.Marks 
                    FROM result 
                    INNER JOIN studenttable ON result.RollNumber = studenttable.RollNumber";
            $rs = mysqli_query($connect, $sql);
            echo "<table class='table table-striped' style='width:100%'>
            <tr>
                <th>Result ID</th>
                <th>Roll Number</th>
                <th>Student Name</th>
                <th>Marks</th>
            </tr>";
            while ($row = mysqli_fetch_array($rs)) {
                ?>
                <tr>
                    <td><?PHP echo $row['RsID']; ?></td>
                    <td><?PHP echo $row['RollNumber']; ?></td>
                    <td><?PHP echo $row['StudentName']; ?></td>
                    <td><?PHP echo $row['Marks']; ?></td>
                </tr>
                <?php
            }
            ?>
            </table>
        </div>
    </div>
    <?php include('allfoot.php'); ?>
</div>