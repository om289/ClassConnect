<?php
session_start();
if ($_SESSION["fidx"] == "" || $_SESSION["fidx"] == NULL) {
    header('Location:facultylogin');
}
$userid = $_SESSION["fidx"];
$fname = $_SESSION["fname"];
?>
<?php include('fhead.php');  ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3> Welcome Faculty : <a href="welcomefaculty.php"><span style="color:#FF0004"> <?php echo $fname; ?></span></a></h3>
            
            <!-- Class Filter Form -->
            <form action="" method="get" class="form-inline">
                <div class="form-group">
                    <label>Year:</label>
                    <select name="year" class="form-control" style="margin:10px">
                        <option value="">All Years</option>
                        <option value="FY" <?php if(isset($_GET['year']) && $_GET['year'] == 'FY') echo 'selected'; ?>>First Year</option>
                        <option value="SY" <?php if(isset($_GET['year']) && $_GET['year'] == 'SY') echo 'selected'; ?>>Second Year</option>
                        <option value="TY" <?php if(isset($_GET['year']) && $_GET['year'] == 'TY') echo 'selected'; ?>>Third Year</option>
                        <option value="LY" <?php if(isset($_GET['year']) && $_GET['year'] == 'LY') echo 'selected'; ?>>Final Year</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Division:</label>
                    <select name="division" class="form-control" style="margin:10px">
                        <option value="">All Divisions</option>
                        <option value="A" <?php if(isset($_GET['division']) && $_GET['division'] == 'A') echo 'selected'; ?>>A</option>
                        <option value="B" <?php if(isset($_GET['division']) && $_GET['division'] == 'B') echo 'selected'; ?>>B</option>
                        <option value="C" <?php if(isset($_GET['division']) && $_GET['division'] == 'C') echo 'selected'; ?>>C</option>
                        <option value="D" <?php if(isset($_GET['division']) && $_GET['division'] == 'D') echo 'selected'; ?>>D</option>
                        <option value="E" <?php if(isset($_GET['division']) && $_GET['division'] == 'E') echo 'selected'; ?>>E</option>
                        <option value="F" <?php if(isset($_GET['division']) && $_GET['division'] == 'F') echo 'selected'; ?>>F</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Filter</button>
            </form>

            <?php
            include("database.php");
            
            // Build query based on filters
            $sql = "SELECT * FROM studenttable WHERE 1";
            
            if (isset($_GET['year']) && !empty($_GET['year'])) {
                $year = mysqli_real_escape_string($connect, $_GET['year']);
                $sql .= " AND Year = '$year'";
            }
            
            if (isset($_GET['division']) && !empty($_GET['division'])) {
                $division = mysqli_real_escape_string($connect, $_GET['division']);
                $sql .= " AND Division = '$division'";
            }
            
            $result = mysqli_query($connect, $sql);
            
            echo "<h2 class='page-header'>Student Details</h2>";
            
            if (mysqli_num_rows($result) > 0) {
                echo "<table class='table table-striped' style='width:100%'>
                        <tr>
                            <th>Enrolment</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Year</th>
                            <th>Division</th>
                            <th>Course</th>
                            <th>Phone</th>
                            <th>Email</th>
                        </tr>";
                
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>
                            <td>{$row['Eno']}</td>
                            <td>{$row['FName']}</td>
                            <td>{$row['LName']}</td>
                            <td>{$row['Year']}</td>
                            <td>{$row['Division']}</td>
                            <td>{$row['Course']}</td>
                            <td>{$row['PhNo']}</td>
                            <td>{$row['Eid']}</td>
                          </tr>";
                }
                echo "</table>";
            } else {
                echo "<div class='alert alert-info'>No students found for the selected class.</div>";
            }
            ?>
        </div>
    </div>
</div>
<?php include('allfoot.php'); ?>