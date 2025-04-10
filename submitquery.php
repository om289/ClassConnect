<?php
session_start();
include('database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $query = mysqli_real_escape_string($connect, $_POST['query']);
    $facultyID = mysqli_real_escape_string($connect, $_POST['faculty']);
    $studentID = $_SESSION['sidx']; // Assuming student ID is stored in session
    $studentName = $_SESSION['fname'] . ' ' . $_SESSION['lname'];

    if (!$studentID) {
        echo "<div class='alert alert-danger'>Enrollment ID is missing. Please log in again.</div>";
        header('Location: studentlogin.php');
        exit();
    }

    $sql = "INSERT INTO `query` (`Query`, `FacultyID`, `StudentID`, `StudentName`) VALUES ('$query', '$facultyID', '$studentID', '$studentName')";

    if (mysqli_query($connect, $sql)) {
        echo "<div class='alert alert-success'>Query submitted successfully!</div>";
        header('Location: askquery.php'); // Redirect back to the query page
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($connect) . "</div>";
    }

    mysqli_close($connect);
} else {
    echo "<div class='alert alert-danger'>Invalid request method.</div>";
}
?>