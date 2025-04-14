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
            
            <a href="logoutfaculty"><button type="submit" class="btn btn-danger">Logout</button></a>
        </div>
    </div>
    <?php include('allfoot.php'); ?>