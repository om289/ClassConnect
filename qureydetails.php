<?php
session_start();

if (empty($_SESSION["fidx"])) {
	header('Location:facultylogin.php');
	exit();
}
$userid = $_SESSION["fidx"];
$fname = $_SESSION["fname"];
?>
<?php include('fhead.php'); ?>
<div class="container">
	<div class="row">
		<?php
		if (isset($_REQUEST['deleteid'])) {
			include("database.php");
			$deleteid = mysqli_real_escape_string($connect, $_GET['deleteid']);
			$sql = "DELETE FROM `query` WHERE Qid = '$deleteid'";

			if (mysqli_query($connect, $sql)) {
				echo "
					<br><br>
					<div class='alert alert-success fade in'>
					<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
					<strong>Success!</strong> Query Details has been deleted.
					</div>";
			} else {
				echo "<br><Strong>Query Details Deletion Failure. Try Again</strong><br> Error Details: " . mysqli_error($connect);
			}
			mysqli_close($connect);
		}
		?>
	</div>
	<div class="row">
		<div class="col-md-8">
			<h3> Welcome Faculty : <a href="welcomefaculty.php"><span style="color:#FF0004"> <?php echo htmlspecialchars($fname); ?></span></a> </h3>
			<?php
			include("database.php");

			if (!$connect) {
				echo "
					<div class='alert alert-danger'>
						<strong>Error!</strong> Failed to connect to the database. Please try again later.
					</div>";
				error_log("Database Connection Error: " . mysqli_connect_error());
				exit();
			}

			$facultyID = mysqli_real_escape_string($connect, $_SESSION["fidx"]);
			$querySql = "SELECT q.Qid, q.Query, s.FName AS StudentName, q.Answer 
				FROM query q 
				JOIN studenttable s ON q.StudentID = s.RollNumber 
				WHERE q.FacultyID = '$facultyID'";

			$queryResult = mysqli_query($connect, $querySql);

			if (!$queryResult) {
				echo "
					<div class='alert alert-danger'>
						<strong>Error!</strong> Failed to fetch queries. Please try again later.
					</div>";
				error_log("SQL Error: " . mysqli_error($connect));
			} else {
				?>
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Query ID</th>
							<th>Student Name</th>
							<th>Query</th>
							<th>Answer</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						if (mysqli_num_rows($queryResult) > 0) {
							while ($row = mysqli_fetch_assoc($queryResult)) { ?>
								<tr>
									<td><?php echo htmlspecialchars($row['Qid']); ?></td>
									<td><?php echo htmlspecialchars($row['StudentName']); ?></td>
									<td><?php echo htmlspecialchars($row['Query']); ?></td>
									<td><?php echo $row['Answer'] ? htmlspecialchars($row['Answer']) : 'Not answered yet'; ?></td>
									<td>
										<?php if (!$row['Answer']) { ?>
											<form method="POST" action="qureydetails.php">
												<input type="hidden" name="queryID" value="<?php echo htmlspecialchars($row['Qid']); ?>">
												<textarea name="answer" class="form-control" required></textarea>
												<button type="submit" class="btn btn-primary">Submit Answer</button>
											</form>
										<?php } ?>
									</td>
								</tr>
							<?php } 
						} else {
							echo "
								<tr>
									<td colspan='5' class='text-center'>No queries found.</td>
								</tr>";
						} ?>
					</tbody>
				</table>
				<?php
			}
			?>
		</div>
	</div>
	<?php include('allfoot.php'); ?>
</div>
</body>
</html>

<?php
if (isset($_POST['queryID']) && isset($_POST['answer'])) {
	include("database.php");
	$queryID = mysqli_real_escape_string($connect, $_POST['queryID']);
	$answer = mysqli_real_escape_string($connect, $_POST['answer']);

	$sql = "UPDATE `query` SET `Answer` = '$answer' WHERE `Qid` = '$queryID';";
	if (mysqli_query($connect, $sql)) {
		// Redirect to avoid form resubmission
		header('Location: qureydetails.php?success=1');
		exit();
	} else {
		echo "
			<div class='alert alert-danger'>
				<strong>Error!</strong> Failed to submit the answer. Please try again.
			</div>";
		error_log("SQL Update Error: " . mysqli_error($connect));
	}
	mysqli_close($connect);
}
?>