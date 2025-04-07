<?php
session_start();

// Check if the session variable "seno" is set
if (!isset($_SESSION["seno"]) || $_SESSION["seno"] == "") {
    // Redirect to the login page if "seno" is not set
    header('Location:studentlogin.php');
    exit();
}

// Retrieve session variables
$userid = $_SESSION["sidx"];
$userfname = isset($_SESSION["fname"]) ? $_SESSION["fname"] : "Student";
$userlname = isset($_SESSION["lname"]) ? $_SESSION["lname"] : "";
$sEno = $_SESSION["seno"]; // Ensure "seno" is properly retrieved

include('studenthead.php');
?>

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h3>Welcome <a href="welcomestudent.php" style="text-decoration: none; color: red;">
                <?php echo htmlspecialchars($userfname . " " . $userlname); ?></a></h3>

            <?php
            include('database.php');

            // Display available assessments
            $sql = "SELECT * FROM examdetails";
            $rs = mysqli_query($connect, $sql);

            echo "<h2 class='page-header'>Take Assessment</h2>";
            echo "<table class='table table-striped' style='width:100%'>
                    <tr>
                    <th>Exam ID</th>
                    <th>Exam Name</th>
                    <th>Take</th> 
                    </tr>";

            while ($row = mysqli_fetch_array($rs)) {
                echo "<tr>
                        <td>{$row['ExamID']}</td>
                        <td>{$row['ExamName']}</td>
                        <td>
                            <a href='takeassessment2.php?exid={$row['ExamID']}' style='text-decoration: none;'>
                                <button type='submit' class='btn btn-primary'>Take</button>
                            </a>
                        </td>
                      </tr>";
            }
            echo "</table>";
            ?>
        </div>
    </div>
</div>

<?php include('allfoot.php'); ?>