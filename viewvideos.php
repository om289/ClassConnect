<?php
session_start();

if ( $_SESSION[ "sidx" ] == "" || $_SESSION[ "sidx" ] == NULL ) {
	header( 'Location:studentlogin' );
}

// Ensure session variables are set
if (!isset($_SESSION['fname']) || !isset($_SESSION['lname'])) {
    $userfname = "Student";
    $userlname = "";
} else {
    $userfname = $_SESSION['fname'];
    $userlname = $_SESSION['lname'];
}
?>

<?php include('studenthead.php'); ?>

<div class="container">
	<div class="row">
		<div class="col-md-8">
				<h3> Welcome <a href="welcomestudent.php" <?php echo "<span style='color:red'>".				$userfname." ".$userlname."</span>";?> </a></h3>
				
			<?php 
				
				include('database.php');
				
				 // Ensure session variables for course and year are set
				if (!isset($_SESSION['course']) || !isset($_SESSION['year'])) {
				    echo "<p>Error: Course or Year information is missing. Please contact the administrator.</p>";
				    exit;
				}

				$course = $_SESSION['course'];
				$year = $_SESSION['year'];

				// Fetch videos for the student's course and year
				$sql = "SELECT * FROM video WHERE Course = '$course' AND Year = '$year'";
				$rs = mysqli_query($connect, $sql);

				if (!$rs) {
				    echo "<p>Error: Unable to fetch videos. Please try again later.</p>";
				    exit;
				}

				echo "<h2 class='page-header'>Videos Details</h2>";
				echo "<table class='table table-striped' style='width:100%'>
				<tr>
					<th>Video Title</th>
					<th>Description</th>
					<th>View</th>		
				</tr>";
				
				 // Update the column names to match the database schema
				while ($row = mysqli_fetch_array($rs)) {
				?>
			<tr>
				<td>
					<?php echo isset($row['VideoTitle']) ? $row['VideoTitle'] : "N/A"; ?>
				</td>
				<td>
					<?php echo isset($row['Description']) ? $row['Description'] : "N/A"; ?>
				</td>
				<td><a href="viewvideos2.php?viewid=<?php echo $row['ID']; ?>"> <input type="button" Value="View"  class="btn btn-info btn-sm"  data-toggle="modal" data-target="#myModal"></a>
				</td>
			</tr>
			<?php
			}
			?>	
			</table>
			
		</div>
	</div>
	<?php include('allfoot.php');  ?>
</div>
</body>
</html>