<?php
session_start();

if (!isset($_SESSION['sidx']) || empty($_SESSION['sidx'])) {
    header('Location:studentlogin.php');
    exit();
}

include('database.php');

$assessmentID = $_GET['assessment_id'];
$sql = "SELECT * FROM text_assessments WHERE AssessmentID = $assessmentID";
$result = mysqli_query($connect, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "<p>Error: Unable to fetch questions for this assessment. Please try again later.</p>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $answers = $_POST['answers'];
    $rollNumber = $_SESSION['sidx'];

    foreach ($answers as $questionID => $answer) {
        $answer = mysqli_real_escape_string($connect, $answer);
        $insertSql = "INSERT INTO text_answers (AssessmentID, RollNumber, Answer) VALUES ($assessmentID, $rollNumber, '$answer')";
        mysqli_query($connect, $insertSql);
    }

    echo "<p>Assessment submitted successfully!</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attempt Text Assessment</title>
    <link rel="stylesheet" href="css/bootstrap.css">
</head>
<body>
<div class="container">
    <h3>Text-Based Assessment</h3>
    <form method="POST" action="">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="form-group">
                <label><?php echo $row['Question']; ?></label>
                <textarea class="form-control" name="answers[<?php echo $row['QuestionID']; ?>]" required></textarea>
            </div>
        <?php endwhile; ?>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</body>
</html>