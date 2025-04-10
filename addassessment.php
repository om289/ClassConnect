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

		// Debug: Check database connection
		if (!$connect) {
			die("<div class='alert alert-danger'>Database connection failed: " . mysqli_connect_error() . "</div>");
		} else {
			echo "<div class='alert alert-info'>Database connection successful.</div>";
		}

		// Debug: Log form submission
		if (isset($_POST['submit'])) {
			echo "<div class='alert alert-info'>Form submitted. Processing...</div>";
			// Add a debug message to confirm form submission
			if (isset($_POST['submit'])) {
				echo "<div class='alert alert-info'>Form submitted successfully. Processing...</div>";
				// Ensure form fields are set before accessing them
				$Aname = isset($_POST['assessmentName']) ? $_POST['assessmentName'] : '';
				$q1 = isset($_POST['Q1']) ? $_POST['Q1'] : '';
				$q2 = isset($_POST['Q2']) ? $_POST['Q2'] : '';
				$q3 = isset($_POST['Q3']) ? $_POST['Q3'] : '';
				$q4 = isset($_POST['Q4']) ? $_POST['Q4'] : '';
				$q5 = isset($_POST['Q5']) ? $_POST['Q5'] : '';

				$done = "
						<center>
						<div class='alert alert-success fade in __web-inspector-hide-shortcut__'' style='margin-top:10px;'>
						<a href='#' class='close' data-dismiss='alert' aria-label='close' title='close'>&times;</a>
						<strong><h3 style='margin-top: 10px;
						margin-bottom: 10px;'> Assessment added Sucessfully.</h3>
						</strong>
						</div>
						</center>
						";

				$sql = "INSERT INTO `ExamDetails` (`ExamName`, `Q1`, `Q2`, `Q3`, `Q4`, `Q5`) VALUES ('$Aname','$q1','$q2','$q3','$q4','$q5')";
				// Add error handling for the SQL query
				if (mysqli_query($connect, $sql)) {
					if ($_POST['assessmentType'] === 'MCQ') {
						$questions = $_POST['questions'];
						$optionA = $_POST['optionA'];
						$optionB = $_POST['optionB'];
						$optionC = $_POST['optionC'];
						$optionD = $_POST['optionD'];
						$correctOptions = $_POST['correctOption'];

						$assessmentID = mysqli_insert_id($connect); // Get the last inserted assessment ID

						for ($i = 0; $i < count($questions); $i++) {
							$q = mysqli_real_escape_string($connect, $questions[$i]);
							$a = mysqli_real_escape_string($connect, $optionA[$i]);
							$b = mysqli_real_escape_string($connect, $optionB[$i]);
							$c = mysqli_real_escape_string($connect, $optionC[$i]);
							$d = mysqli_real_escape_string($connect, $optionD[$i]);
							$correct = mysqli_real_escape_string($connect, $correctOptions[$i]);

							$mcqSql = "INSERT INTO mcq_questions (AssessmentID, Question, OptionA, OptionB, OptionC, OptionD, CorrectOption) 
									VALUES ('$assessmentID', '$q', '$a', '$b', '$c', '$d', '$correct')";
							if (!mysqli_query($connect, $mcqSql)) {
								echo "<div class='alert alert-danger'>Error: " . mysqli_error($connect) . "</div>";
							}
						}
						echo $done;
					} else {
						echo $done;
					}
				} else {
					echo "<div class='alert alert-danger'>Error: " . mysqli_error($connect) . "</div>";
				}
			}
		}

		?>
		
			<fieldset>
				<legend><a href="addassessment.php">Add Assessment</a></legend>

					<form method="POST" action="">
						<div class="form-group">
							<label for="assessmentName">Assessment Name:</label>
							<input type="text" class="form-control" id="assessmentName" name="assessmentName" required>
						</div>
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
						<div class="form-group">
							<label for="year">Year:</label>
							<select class="form-control" id="year" name="year" required>
								<option value="First Year">First Year</option>
								<option value="Second Year">Second Year</option>
								<option value="Third Year">Third Year</option>
								<option value="Fourth Year">Fourth Year</option>
							</select>
						</div>
						<div class="form-group">
							<label for="division">Division:</label>
							<select class="form-control" id="division" name="division" required>
								<option value="A">A</option>
								<option value="B">B</option>
								<option value="C">C</option>
								<option value="D">D</option>
								<option value="E">E</option>
								<option value="F">F</option>
							</select>
						</div>
							<div class="form-group">
								<label for="assessmentType">Assessment Type:</label>
								<select class="form-control" id="assessmentType" name="assessmentType" required>
									<option value="MCQ">MCQ</option>
									<option value="Text">Text</option>
								</select>
							</div>

							<div id="text-assessment-section" style="display: none;">
								<h4>Text-Based Questions</h4>
								<div class="text-question">
									<label>Question:</label>
									<input type="text" class="form-control" name="textQuestions[]" required>
								</div>
								<button type="button" id="add-text-question" class="btn btn-secondary">Add Another Question</button>
							</div>
						<div id="mcq-section">
							<h4>MCQs</h4>
							<div class="mcq">
								<label>Question:</label>
								<input type="text" class="form-control" name="questions[]" required>
								<label>Option A:</label>
								<input type="text" class="form-control" name="optionA[]" required>
								<label>Option B:</label>
								<input type="text" class="form-control" name="optionB[]" required>
								<label>Option C:</label>
								<input type="text" class="form-control" name="optionC[]" required>
								<label>Option D:</label>
								<input type="text" class="form-control" name="optionD[]" required>
								<label>Correct Option:</label>
								<select class="form-control" name="correctOption[]" required>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
								</select>
							</div>
						</div>
						<button type="button" id="add-mcq" class="btn btn-secondary">Add Another MCQ</button>
						<button type="submit" name="submit" class="btn btn-primary">Create Assessment</button>
					</form>

					<script>
						document.getElementById('add-mcq').addEventListener('click', function() {
							const mcqSection = document.getElementById('mcq-section');
							const newMcq = document.querySelector('.mcq').cloneNode(true);
							mcqSection.appendChild(newMcq);
						});

						document.getElementById('assessmentType').addEventListener('change', function() {
							const type = this.value;
							document.getElementById('mcq-section').style.display = type === 'MCQ' ? 'block' : 'none';
							document.getElementById('text-assessment-section').style.display = type === 'Text' ? 'block' : 'none';
						});

						document.getElementById('add-text-question').addEventListener('click', function() {
							const textSection = document.getElementById('text-assessment-section');
							const newQuestion = document.querySelector('.text-question').cloneNode(true);
							textSection.appendChild(newQuestion);
						});
					</script>
			</fieldset>
		</div>
	</div>
	<?php include('allfoot.php');  ?>
</div>
</body>
</html>