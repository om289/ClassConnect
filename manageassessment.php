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
			
			<?php
		include( "database.php" );
		if ( isset( $_REQUEST[ 'deleteid' ] ) ) {

			//getting data from another page
			$deleteid = $_GET[ 'deleteid' ];
			$sql = "DELETE FROM `examdetails` WHERE ExamID = $deleteid";
			if ( mysqli_query( $connect, $sql ) ) {
				echo "
						<br><br>
						<div class='alert alert-success fade in'>
						<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
						<strong>Success!</strong> Assessment details deleted.
						</div>
						";
			} else {
				//error message if SQL query fails
				echo "<br><Strong>Assessment Details Updation Faliure. Try Again</strong><br> Error Details: " . $sql . "<br>" . mysqli_error( $connect );
			}
		}
		//close the connection
		mysqli_close( $connect );
		?>
			
			<?php 
				
				include('database.php');
				$sql="SELECT * FROM examdetails";
				$rs=mysqli_query($connect,$sql);
				echo "<h2 class='page-header'>Assessment Details</h2>";
				echo "<table class='table table-striped' style='width:100%'>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Q1</th>
					<th>Q2</th>
					<th>Q3</th>
					<th>Q4</th>
					<th>Q5</th>
					<th>Delete</th>		
					<th>Edit</th>		
				</tr>";
				while($row=mysqli_fetch_array($rs))
				{
				?>
			<tr>
				<td>
					<?PHP echo $row['ExamID'];?>
				</td>
				<td>
					<?PHP echo $row['ExamName'];?>
				</td>
				<td>
					<?PHP echo $row['Q1'];?>
				</td>
				<td>
					<?PHP echo $row['Q2'];?>
				</td>
				<td>
					<?PHP echo $row['Q3'];?>
				</td>
				<td>
					<?PHP echo $row['Q4'];?>
				</td>
				<td>
					<?PHP echo $row['Q5'];?>
				</td>
				
				<td><a href="manageassessment.php?deleteid=<?php echo $row['ExamID']; ?>"> <input type="button" Value="Delete"  class="btn btn-info btn-sm"  data-toggle="modal" data-target="#myModal"></a>
				<td><a href="manageassessment2.php?editassid=<?php echo $row['ExamID']; ?>"> <input type="button" Value="Edit"  class="btn btn-info btn-sm"  data-toggle="modal" data-target="#myModal"></a>
				</td>
				</td>
			</tr>
			<?php
			}
			?>	
			</table>
			
			<?php
			// Fetch submitted answers for a specific assessment
			if (!isset($_GET['assessment_id']) || empty($_GET['assessment_id'])) {
				echo "<p>Error: Missing assessment identifier. Please try again later.</p>";
				exit();
			}
			$assessmentID = $_GET['assessment_id'];
			$sql = "SELECT sa.*, st.FName, st.LName FROM submitted_answers sa JOIN studenttable st ON sa.RollNumber = st.RollNumber WHERE sa.AssessmentID = $assessmentID";
			$result = mysqli_query($connect, $sql);

			if (!$result) {
				echo "<p>Error: Unable to fetch submitted answers. Please try again later.</p>";
				exit;
			}

			if (mysqli_num_rows($result) > 0) {
				echo "<h3>Submitted Answers</h3><table class='table table-striped'>";
				echo "<tr><th>Student Name</th><th>Answer</th><th>Marks</th><th>Assign Marks</th></tr>";
				while ($row = mysqli_fetch_assoc($result)) {
					echo "<tr>";
					echo "<td>" . $row['FName'] . " " . $row['LName'] . "</td>";
					echo "<td>" . $row['Answer'] . "</td>";
					echo "<td>" . ($row['Marks'] ?? 'Not Assigned') . "</td>";
					echo "<td><form method='POST' action=''>";
					echo "<input type='hidden' name='submission_id' value='" . $row['SubmissionID'] . "'>";
					echo "<input type='number' name='marks' min='0' max='100' required>";
					echo "<button type='submit' name='assign_marks' class='btn btn-primary'>Assign</button>";
					echo "</form></td>";
					echo "</tr>";
				}
				echo "</table>";
			} else {
				echo "<p>No answers submitted for this assessment.</p>";
			}

			// Handle marks assignment
			if (isset($_POST['assign_marks'])) {
				$submissionID = $_POST['submission_id'];
				$marks = $_POST['marks'];

				$updateSql = "UPDATE submitted_answers SET Marks = $marks WHERE SubmissionID = $submissionID";
				if (mysqli_query($connect, $updateSql)) {
					echo "<p>Marks assigned successfully.</p>";
				} else {
					echo "<p>Error: Unable to assign marks. Please try again later.</p>";
				}
			}
			?>
			
			<?php
			// Fetch submitted text answers for a specific assessment
			if (isset($_GET['assessment_id'])) {
				$assessmentID = $_GET['assessment_id'];
				$sql = "SELECT ta.*, st.FName, st.LName FROM text_answers ta JOIN studenttable st ON ta.RollNumber = st.RollNumber WHERE ta.AssessmentID = $assessmentID";
				$result = mysqli_query($connect, $sql);

				if (!$result) {
					echo "<p>Error: Unable to fetch submitted answers. Please try again later.</p>";
					exit;
				}

				if (mysqli_num_rows($result) > 0) {
					echo "<h3>Submitted Text Answers</h3><table class='table table-striped'>";
					echo "<tr><th>Student Name</th><th>Answer</th><th>Marks</th><th>Assign Marks</th></tr>";
					while ($row = mysqli_fetch_assoc($result)) {
						echo "<tr>";
						echo "<td>" . $row['FName'] . " " . $row['LName'] . "</td>";
						echo "<td>" . $row['Answer'] . "</td>";
						echo "<td>" . ($row['Marks'] ?? 'Not Assigned') . "</td>";
						echo "<td><form method='POST' action=''>";
						echo "<input type='hidden' name='answer_id' value='" . $row['AnswerID'] . "'>";
						echo "<input type='number' name='marks' min='0' max='100' required>";
						echo "<button type='submit' name='assign_marks' class='btn btn-primary'>Assign</button>";
						echo "</form></td>";
						echo "</tr>";
					}
					echo "</table>";
				} else {
					echo "<p>No text answers submitted for this assessment.</p>";
				}
			}

			// Handle marks assignment for text answers
			if (isset($_POST['assign_marks'])) {
				$answerID = $_POST['answer_id'];
				$marks = $_POST['marks'];

				$updateSql = "UPDATE text_answers SET Marks = $marks WHERE AnswerID = $answerID";
				if (mysqli_query($connect, $updateSql)) {
					echo "<p>Marks assigned successfully.</p>";
				} else {
					echo "<p>Error: Unable to assign marks. Please try again later.</p>";
				}
			}
			?>
			
		</div>
	</div>
	<?php include('allfoot.php');  ?>