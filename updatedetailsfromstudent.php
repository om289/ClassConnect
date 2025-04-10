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
		<div class="col-md-12">
			<h3> Welcome <a href="welcomestudent"><?php echo "<span style='color:red'>".$userfname." ".$userlname."</span>";?></a></h3>
			<?php
			include( "database.php" );

			 // Updated the error message and replaced 'Eno' with 'RollNumber'
			if (!isset($_GET['eno']) || empty($_GET['eno'])) {
				echo "Error: Missing or invalid Roll Number.";
				exit;
			}

			$new3 = $_GET['eno'];

			 // Debugging: Log the value of the 'eno' parameter
			error_log("Received Roll Number: " . $new3);

			// Execute the query
			$sql = "select * from studenttable where RollNumber='$new3'";

			// Debugging: Log the SQL query
			error_log("Executing SQL: " . $sql);

			$result = mysqli_query($connect, $sql);

			// Check if the query was successful
			if ($result && mysqli_num_rows($result) > 0) {
				while ($row = mysqli_fetch_array($result)) {
					?>
				<form action="" method="POST" name="update">
					
					<div class="form-group">
						Roll Number : <?php echo $row['RollNumber']; ?>
					</div>
					<div class="form-group">
						First Name : <input type="text" name="fname" value="<?php echo $row['FName']; ?>">
					</div>
					<div class="form-group">
						Last Name : <input type="text" name="lname" value="<?php echo $row['LName']; ?>"><br>
					</div>
					<div class="form-group">
						Father Name : <input type="text" name="faname" value="<?PHP echo $row['FaName'];?>"><br>
					</div>
					<div class="form-group">
						Address : <input type="text" name="addrs" value="<?PHP echo $row['Addrs'];?>"><br>
					</div>
					<div class="form-group">
						Gender : <input type="text" name="gender" value="<?PHP echo $row['Gender'];?>"><br>
					</div>
					<div class="form-group">
						Course : <input type="text" name="course" value="<?PHP echo $row['Course'];?>"><br>
					</div>
					<div class="form-group">
						D.O.B. : <input type="text" name="DOB" value="<?PHP echo $row['DOB'];?>" readonly><br>
					</div>
					<div class="form-group">
						Phone Number : <input type="text" name="phno" value="<?PHP echo $row['PhNo'];?>" maxlength="10"><br>
					</div>
					<div class="form-group">
						<?php
						// Check if the 'Email' key exists in the $row array before accessing it
						if (isset($row['Email'])) {
							$emailValue = $row['Email'];
						} else {
							$emailValue = "N/A"; // Default value if 'Email' is not set
						}
						?>
						Email : <input type="text" name="email" value="<?php echo $emailValue; ?>" readonly><br>
					</div>
					<div class="form-group">
						Password : <input type="text" name="pass" value="<?PHP echo $row['Pass'];?>"><br>
					</div>
					<div class="form-group">
						<tr>
							<td><strong>Year :</strong></td>
							<td>
								<select name="year" class="form-control" required>
									<option value="First Year" <?php if ($row['Year'] == 'First Year') echo 'selected'; ?>>First Year</option>
									<option value="Second Year" <?php if ($row['Year'] == 'Second Year') echo 'selected'; ?>>Second Year</option>
									<option value="Third Year" <?php if ($row['Year'] == 'Third Year') echo 'selected'; ?>>Third Year</option>
									<option value="Fourth Year" <?php if ($row['Year'] == 'Fourth Year') echo 'selected'; ?>>Fourth Year</option>
								</select>
							</td>
						</tr>
					</div><br>
					<div class="form-group">

						<input type="submit" value="Update!" name="update" class="btn btn-primary">
					</div>
				</form>
				<?php
				}
			} else {
				// Debugging: Log any SQL errors
				error_log("SQL Error: " . mysqli_error($connect));
				echo "Error: No student found with the given Roll Number.";
			}
			?>

			<?php

			if ( isset( $_POST[ 'update' ] ) ) {
				
				$tempfname = $_POST[ 'fname' ];
				$templname = $_POST[ 'lname' ];
				$tempfaname = $_POST[ 'faname' ];
				$tempaddrs = $_POST[ 'addrs' ];
				$tempgender = $_POST[ 'gender' ];
				$tempcourse = $_POST[ 'course' ];
				$tempphno = $_POST[ 'phno' ];
				$tempeid = $_POST[ 'email' ];
				$temppass = $_POST[ 'pass' ];
				$tempyear = $_POST[ 'year' ];
				//below query will update the existing record of student
				$sql = "UPDATE `studenttable` SET FName='$tempfname', LName='$templname', FaName='$tempfaname', Gender='$tempgender', Course='$tempcourse', Addrs='$tempaddrs', PhNo=$tempphno, Eid='$tempeid', Pass='$temppass', Year='$tempyear'  WHERE Eno=$new3";


				if ( mysqli_query( $connect, $sql ) ) {
					echo "

<br><br>
<div class='alert alert-success fade in'>
<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
<strong>Success!</strong> Student Details has been updated.
</div>

";
				} else {
					//below statement will print error if SQL query fail.
					echo "<br><Strong>Student Updation Faliure. Try Again</strong><br> Error Details: " . $sql . "<br>" . mysqli_error( $connect );
				}
				//for close connection
				mysqli_close( $connect );

			}
			?>
		</div>
	</div>
	<?php include('allfoot.php'); ?>