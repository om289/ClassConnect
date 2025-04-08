<?php
session_start();

if ($_SESSION["fidx"] == "" || $_SESSION["fidx"] == NULL) {
    header('Location:facultylogin');
}

$userid = $_SESSION["fidx"];
$fname = $_SESSION["fname"];
?>

<?php include('fhead.php'); ?>
<div class="container">
    <div class="row">
        <?php
        include("database.php");
        if (isset($_REQUEST['deleteid'])) {
            $deleteid = $_GET['deleteid'];
            $sql = "DELETE FROM `result` WHERE RsID = $deleteid";
            if (mysqli_query($connect, $sql)) {
                echo "
                <br><br>
                <div class='alert alert-success fade in'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>Success!</strong> Result details deleted.
                </div>
                ";
            } else {
                echo "<br><Strong>Result Details Deletion Failure. Try Again</strong><br> Error Details: " . $sql . "<br>" . mysqli_error($connect);
            }
        }
        mysqli_close($connect);
        ?>
    </div>

    <div class="row">
        <div class="col-md-8">
            <h3> Welcome Faculty : <a href="welcomefaculty.php"><span style="color:#FF0004"><?php echo $fname; ?></span></a></h3>

            <?php
            include('database.php');
            $sql = "SELECT * FROM result";
            $rs = mysqli_query($connect, $sql);
            echo "<h2 class='page-header'>Result Details</h2>";
            echo "<table class='table table-striped' style='width:100%'>";
            echo "<tr>
                <th>Result ID</th>
                <th>Enrolment Number</th>
                <th>Marks</th>
                <th>Edit</th>
                <th>Delete</th>
                </tr>";

            while ($row = mysqli_fetch_array($rs)) {
                echo "<tr>
                    <td>{$row['RsID']}</td>
                    <td>{$row['Eno']}</td>
                    <td>{$row['Marks']}</td>
                    <td><a href='updateresultdetails.php?editid={$row['RsID']}'><input type='button' value='Edit' class='btn btn-info btn-sm'></a></td>
                    <td><a href='resultdetails.php?deleteid={$row['RsID']}'><input type='button' value='Delete' class='btn btn-danger btn-sm'></a></td>
                    </tr>";
            }

            echo "</table>";
            ?>

            <!-- 📥 Download Button -->
            <a href="download_results_excel.php" class="btn btn-success btn-sm" target="_blank">Download Results</a>


        </div>
    </div>
</div>

<?php include('allfoot.php'); ?>
