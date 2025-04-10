<?php
session_start();

if ( $_SESSION[ "sidx" ] == "" || $_SESSION[ "sidx" ] == NULL ) {
	header( 'Location:studentlogin' );
}

$userid = $_SESSION[ "sidx" ];
$userfname = $_SESSION[ "fname" ];
$userlname = $_SESSION[ "lname" ];
?>
<?php include('studenthead.php'); ?>



<div class="container">
	<div class="row">
		<div class="col-md-5">

			<h3> Welcome <a href="welcomestudent"><?php echo "<span style='color:red'>".$userfname." ".$userlname."</span>";?></a></h3>
			<?php
			include( 'database.php' );
			$varid = isset($_REQUEST['myds']) ? $_REQUEST['myds'] : null;
			if ($varid === null) {
				echo "<p>Error: Missing 'myds' parameter. Please try again.</p>";
				exit;
			}
			//selecting data from assessment table
			$sql = "select * from studenttable where RollNumber='$varid'";
			// Execute the query
			$result = mysqli_query($connect, $sql);

			// Check if the query was successful
			if ($result) {
				while ($row = mysqli_fetch_array($result)) {
					?>
					<fieldset>
						<legend>My Details</legend>
						<form action="" method="POST" name="update">
							<table class="table table-hover">

								<tr>
									<td><strong>Roll Number : </strong></td>
									<td>
										<?php 
										if (isset($row['RollNumber'])) {
											echo $row['RollNumber'];
										} else {
											echo "N/A"; // Display a default value if 'RollNumber' is not set
										}
										?>
									</td>
								</tr>
								<tr>
									<td><strong>First Name :</strong> </td>
									<td>
										<?php echo $row['FName']; ?>
									</td>
								</tr>
								<tr>
									<td><strong>Last Name :</strong> </td>
									<td>
										<?php echo $row['LName']; ?>
									</td>
								</tr>
								<tr>
									<td><strong>Father Name :</strong> </td>
									<td>
										<?PHP echo $row['FaName'];?>
									</td>
								</tr>
								<tr>
									<td><strong>Address : </strong>
									</td>
									<td>
										<?PHP echo $row['Addrs'];?> </td>
								</tr>
								<tr>
									<td><strong>Gender :</strong>
									</td>
									<td>
										<?PHP echo $row['Gender'];?>
									</td>
								</tr>
								<tr>
									<td><strong>Course : </strong>
									</td>
									<td>
										<?PHP echo $row['Course'];?>
									</td>
								</tr>
								<tr>
									<td><strong>D.O.B. : </strong> </td>
									<td>
										<?PHP echo $row['DOB'];?>
									</td>
								</tr>
								<tr>
									<td><strong>Phone Number :</strong>
									</td>
									<td>
										<?PHP echo $row['PhNo'];?> </td>
								</tr>
								<tr>
									<td><strong>Email : </strong>
									</td>
									<td>
											<?php 
											// Check if the 'Email' key exists in the $row array before accessing it
											if (isset($row['Email'])) {
												echo $row['Email'];
											} else {
												echo "N/A"; // Display a default value if 'Email' is not set
											}
											?>
									</td>
								</tr>
								<tr>
									<td><strong>Password :</strong> </td>
									<td>
										<?PHP echo $row['Pass'];?>
									</td>
								</tr>
								<tr>
									<td><strong>Year :</strong></td>
									<td>
										<?php echo $row['Year']; ?>
									</td>
								</tr>
								<tr>
									<?php
									// Check if the 'Eno' key exists in the $row array before using it in the URL parameter
									if (isset($row['Eno'])) {
										$enoValue = $row['Eno'];
									} else {
										$enoValue = "N/A"; // Default value if 'Eno' is not set
									}
									?>
									<td><a href="updatedetailsfromstudent.php?eno=<?php echo $enoValue; ?>"><input type="button" Value="Edit" class="btn btn-info btn-sm"></a></td>
								</tr>
							</table>
						</form>
					</fieldset>
					<?php
				}
			} else {
				// Display an error message if the query fails
				echo "Error: " . mysqli_error($connect);
			}
			?>
		</div>
	</div>
	<?php include('allfoot.php'); ?>
</div>
</body>
</html>