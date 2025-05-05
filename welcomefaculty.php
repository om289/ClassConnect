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
        <div class="col-md-8">
            <!--Welcome page for faculty-->
            <h3> Welcome Faculty : <a href="welcomefaculty.php"><span style="color:#FF0004"> <?php echo $fname; ?></span></h3></a> 
            <a href="mydetailsfaculty.php?myfid=<?php echo $userid ?>"><button type="submit" class="btn btn-primary">My Details</button></a>
            <a href="viewstudentdetails.php"><button type="submit" class="btn btn-primary">Student Details</button></a>
            <a href="assessment.php"><button type="submit" class="btn btn-primary">Assessment</button></a>
            <a href="examDetails.php"><button type="submit" class="btn btn-primary">Make Result</button></a>
            <a href="resultdetails.php"><button type="submit" class="btn btn-primary">Edit Result</button></a>
            <a href="qureydetails.php"><button type="submit" class="btn btn-primary">Query</button></a>
            <a href="videos.php"><button type="submit" class="btn btn-primary">Videos</button></a>
            <!-- New Schedule Management Button -->
            <a href="faculty_schedule.php"><button type="button" class="btn btn-primary">Manage Schedule</button></a>
            <a href="uploadmaterials.php"><button type="submit" class="btn btn-primary">Upload Class Notes</button></a>
            <button onclick="location.href='createclassroom.php'" class="btn btn-primary mt-3">Manage Classrooms</button>
            <a href="uploadclassroommaterials.php" class="btn btn-primary mt-3">Manage Classroom Content</a>
            <a href="logoutfaculty"><button type="submit" class="btn btn-danger">Logout</button></a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h3>Assigned Queries</h3>
            <?php
            include('database.php');
            $querySql = "SELECT Qid, Query, CreatedAt FROM query WHERE FacultyID='$userid'";
            $queryResult = mysqli_query($connect, $querySql);

            if (mysqli_num_rows($queryResult) > 0) {
                echo "<table class='table table-striped'>
                        <tr>
                            <th>Query ID</th>
                            <th>Query</th>
                            <th>Created At</th>
                        </tr>";
                while ($row = mysqli_fetch_assoc($queryResult)) {
                    echo "<tr>
                            <td>" . $row['Qid'] . "</td>
                            <td>" . $row['Query'] . "</td>
                            <td>" . $row['CreatedAt'] . "</td>
                          </tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No queries assigned to you.</p>";
            }
            ?>
        </div>
    </div>
</div>
<?php include('allfoot.php'); ?>