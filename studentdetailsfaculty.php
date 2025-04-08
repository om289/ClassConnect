<?php
session_start();

if ($_SESSION["umail"] == "" || $_SESSION["umail"] == NULL) {
    header('Location:FacultyLogin.php'); // Change if you have a different login page
    exit();
}

$userid = $_SESSION["umail"];
include("adminhead.php");
include("database.php");
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3 class="page-header">Welcome Faculty</h3>
            <h2 class="page-header">Student Details</h2>

            <!-- Download Button -->
            <form method="post" action="download_students_excel.php">
                <button type="submit" class="btn btn-success" style="margin-bottom: 15px;">Download as Excel</button>
            </form>

            <!-- Student Table -->
            <table class='table table-bordered'>
                <tr>
                    <th>Roll Number</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Course</th>
                    <th>DOB</th>
                    <th>Email</th>
                </tr>
                <?php
                $query = "SELECT RollNumber, FName, LName, Course, DOB, Email FROM studenttable";
                $result = mysqli_query($connect, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>{$row['RollNumber']}</td>
                            <td>{$row['FName']}</td>
                            <td>{$row['LName']}</td>
                            <td>{$row['Course']}</td>
                            <td>{$row['DOB']}</td>
                            <td>{$row['Email']}</td>
                          </tr>";
                }
                ?>
            </table>
        </div>
    </div>
</div>

<?php include("allfoot.php"); ?>
</body>
</html>
