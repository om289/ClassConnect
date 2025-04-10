<?php
session_start();

if ( $_SESSION[ "fidx" ] == "" || $_SESSION[ "fidx" ] == NULL ) {
	header( 'Location:facultylogin' );
}

$userid = $_SESSION[ "fidx" ];
$fname = $_SESSION[ "fname" ];
?>
<?php include('fhead.php');  ?>
<div class="container">
	<div class="row">
		<div class="col-md-8">

			<h3> Welcome Faculty : <a href="welcomefaculty.php" ><span style="color:#FF0004"> <?php echo $fname; ?></span></a> </h3>
			<?PHP
		include( "database.php" );
		if ( isset( $_POST[ 'submit' ] ) ) {
			$title = $_POST[ 'videotitle' ];
			$v_url = $_POST[ 'VideoURL' ];
			$v_info = $_POST[ 'Videoinfo' ];
			
			// Fetch course and year from the form
			$course = $_POST['course'];
			$year = $_POST['year'];

			$done = "
					<center>
					<div class='alert alert-success fade in __web-inspector-hide-shortcut__'' style='margin-top:10px;'>
					<a href='#' class='close' data-dismiss='alert' aria-label='close' title='close'>&times;</a>
					<strong><h3 style='margin-top: 10px;
					margin-bottom: 10px;'> Video added Sucessfully.</h3>
					</strong>
					</div>
					</center>
					";

			 // Ensure the video details are inserted into the `video` table
			$sql = "INSERT INTO video (VideoTitle, VideoURL, Description, Course, Year) VALUES ('$title', '$v_url', '$v_info', '$course', '$year')";
			if (mysqli_query($connect, $sql)) {
				echo "<div class='alert alert-success'>Video added successfully.</div>";
			} else {
				echo "<div class='alert alert-danger'>Error: " . mysqli_error($connect) . "</div>";
			}
		}

		?>
		
			<fieldset>
				<legend>Add Videos</legend>
				<form action="" method="POST" name="AddAssessment">
					<table class="table table-hover">

						<tr>
							<td><strong>Video Title  </strong>
							</td>
							<td>
								<input type="text" name="videotitle">
							</td>

						</tr>
						<tr>
							<td><strong>Video URL</strong> </td>
							<td>
								<textarea name="VideoURL" rows="1" cols="150"></textarea>
							</td>
						</tr>
						<tr>
							<td><strong>Video Description</strong> </td>
							<td>
								<textarea name="Videoinfo" rows="5" cols="150"></textarea>
							</td>
						</tr>
						<tr>
							<td><strong>Course</strong> </td>
							<td>
								<div class="form-group">
									<label for="course">Course:</label>
									<select class="form-control" id="course" name="course" required>
										<option value="Computer Engineering">Computer Engineering</option>
										<option value="Information Technology">Information Technology</option>
										<option value="Electronics & Telecommunication">Electronics & Telecommunication</option>
										<option value="AI/DS">AI/DS</option>
										<option value="BS&H">BS&H</option>
									</select>
								</div>
							</td>
						</tr>
						<tr>
							<td><strong>Year</strong> </td>
							<td>
								<div class="form-group">
									<label for="year">Year:</label>
									<select class="form-control" id="year" name="year" required>
										<option value="First Year">First Year</option>
										<option value="Second Year">Second Year</option>
										<option value="Third Year">Third Year</option>
										<option value="Fourth Year">Fourth Year</option>
									</select>
								</div>
							</td>
						</tr>
						<td><button type="submit" name="submit" class="btn btn-primary">Add Video</button>
						</td>
						
					</table>
				</form>
			</fieldset>
		</div>
	</div>
	<?php include('allfoot.php');  ?>