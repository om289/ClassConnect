<?php
session_start();

// Database connection
$conn = mysqli_connect("localhost", "root", "", "cc_db");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Redirect if not logged in
if (empty($_SESSION["sidx"])) {
    header('Location: studentlogin.php');
    exit();
}

$userid = $_SESSION["sidx"];
$userfname = $_SESSION["fname"];
$userlname = $_SESSION["lname"];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $qid = mysqli_real_escape_string($conn, $_POST['qid']);
    $answer = mysqli_real_escape_string($conn, $_POST['answer']);
    
    // Insert answer into query table
    $sql = "INSERT INTO `query` (Qid, Eid, Ans) 
            VALUES ('$qid', '$userid', '$answer')";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: viewquery.php");
        exit();
    } else {
        $error = "Error submitting answer: " . mysqli_error($conn);
    }
}

// Get all questions
$questions_sql = "SELECT q.*, s.FName, s.LName 
                FROM `query` q
                JOIN studenttable s ON q.Eid = s.Eid
                WHERE q.Query != ''
                ORDER BY q.CreatedAt DESC";
$questions_result = mysqli_query($conn, $questions_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Answer Questions</title>
    <link rel="stylesheet" href="DAASHBOARD.CSS">
    <style>
        .answer-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
        }
        .question-card {
            background: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .answer-form textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            min-height: 100px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <!-- Same sidebar as dashboard -->
        <div class="logo">Happy Learning!!!</div>
        <ul>
            <li><a href="welcomestudent.php">Dashboard</a></li>
            <li><a href="viewquery.php">View Queries</a></li>
            <li class="active"><a href="ansquery.php">Answer Queries</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="answer-container">
            <h2>Answer Questions</h2>
            
            <?php if(isset($error)): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>

            <?php while($question = mysqli_fetch_assoc($questions_result)): ?>
                <div class="question-card">
                    <div class="question-header">
                        <h3><?php echo htmlspecialchars($question['FName']." ".$question['LName']); ?></h3>
                        <span class="timestamp"><?php echo $question['CreatedAt']; ?></span>
                    </div>
                    <p><?php echo htmlspecialchars($question['Query']); ?></p>
                    
                    <form class="answer-form" method="POST">
                        <input type="hidden" name="qid" value="<?php echo $question['Qid']; ?>">
                        <textarea name="answer" placeholder="Write your answer..." required></textarea>
                        <button type="submit" class="btn">Submit Answer</button>
                    </form>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>