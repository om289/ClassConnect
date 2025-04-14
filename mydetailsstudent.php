<?php
session_start();

if (empty($_SESSION["sidx"])) {
    header('Location: studentlogin.php');
    exit();
}

$userid = $_SESSION["sidx"];
$userfname = $_SESSION["fname"] ?? '';
$userlname = $_SESSION["lname"] ?? '';
?>
<?php include('studenthead.php'); ?>

<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h3>Welcome <a href="welcomestudent"><?php echo "<span style='color:red'>".htmlspecialchars($userfname)." ".htmlspecialchars($userlname)."</span>";?></a></h3>
            
            <?php
            include('database.php');
            
            // Using session ID instead of request parameter
            $sql = "SELECT * FROM studenttable WHERE Eid = ?";
            $stmt = mysqli_prepare($connect, $sql);
            
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "s", $userid);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                
                if ($row = mysqli_fetch_array($result)) {
                    ?>
                    <fieldset>
                        <legend>My Details</legend>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tr>
                                    <td><strong>Enrolment number:</strong></td>
                                    <td><?php echo htmlspecialchars($row['Eno']); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>First Name:</strong></td>
                                    <td><?php echo htmlspecialchars($row['FName']); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Last Name:</strong></td>
                                    <td><?php echo htmlspecialchars($row['LName']); ?></td>
                                </tr>
                                <!-- Added Year Field -->
                                <tr>
                                    <td><strong>Year:</strong></td>
                                    <td><?php echo htmlspecialchars($row['Year']); ?></td>
                                </tr>
                                <!-- Added Division Field -->
                                <tr>
                                    <td><strong>Division:</strong></td>
                                    <td><?php echo htmlspecialchars($row['Division']); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Father Name:</strong></td>
                                    <td><?php echo htmlspecialchars($row['FaName']); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Address:</strong></td>
                                    <td><?php echo htmlspecialchars($row['Addrs']); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Gender:</strong></td>
                                    <td><?php echo htmlspecialchars($row['Gender']); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Course:</strong></td>
                                    <td><?php echo htmlspecialchars($row['Course']); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>D.O.B.:</strong></td>
                                    <td><?php echo htmlspecialchars($row['DOB']); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Phone Number:</strong></td>
                                    <td><?php echo htmlspecialchars($row['PhNo']); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td><?php echo htmlspecialchars($row['Eid']); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <a href="updatedetailsfromstudent.php?eno=<?php echo urlencode($row['Eno']); ?>" class="btn btn-info">
                                            Edit Details
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </fieldset>
                    <?php
                } else {
                    echo "<div class='alert alert-danger'>No student record found!</div>";
                }
                mysqli_stmt_close($stmt);
            } else {
                echo "<div class='alert alert-danger'>Database query error: ".mysqli_error($connect)."</div>";
            }
            mysqli_close($connect);
            ?>
        </div>
    </div>
</div>

<?php include('allfoot.php'); ?>