<?php
session_start();
include('database.php');

if ($_SESSION["fidx"] == "" || $_SESSION["fidx"] == NULL) {
    header('Location: facultylogin');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $examid = mysqli_real_escape_string($connect, $_POST['examid']);
    $enrl = mysqli_real_escape_string($connect, $_POST['enrl']);
    $total = mysqli_real_escape_string($connect, $_POST['total']);
    $marks = $_POST['marks'];

    // Store individual question marks (if needed)
    // You might want to create a separate table for question-wise marks
    
    // Store/Update total marks
    $check_sql = "SELECT * FROM result WHERE Ex_ID = '$examid' AND Eno = '$enrl'";
    $check_result = mysqli_query($connect, $check_sql);

    if(mysqli_num_rows($check_result) > 0) {
        $sql = "UPDATE result SET Marks = '$total' 
                WHERE Ex_ID = '$examid' AND Eno = '$enrl'";
    } else {
        $sql = "INSERT INTO result (Eno, Ex_ID, Marks) 
                VALUES ('$enrl', '$examid', '$total')";
    }

    if(mysqli_query($connect, $sql)) {
        header("Location: examDetails.php?success=1");
    } else {
        header("Location: examDetails.php?error=".urlencode(mysqli_error($connect)));
    }
}
mysqli_close($connect);
?>