<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["pass"];

    include("database.php");

    // Correct SQL query to match the database structure
    $sql = "SELECT * FROM studenttable WHERE Email = '$email' AND Pass = '$password'";
    $result = mysqli_query($connect, $sql);

    // Ensure session variables for first name and last name are set
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['fname'] = $row['FName']; // Set first name
        $_SESSION['lname'] = $row['LName']; // Set last name
        $_SESSION['sidx'] = $row['RollNumber'];
        $_SESSION['seno'] = $row['RollNumber'];
        $_SESSION['course'] = $row['Course'];
        $_SESSION['year'] = $row['Year'];
        $_SESSION['studentID'] = $row['RollNumber']; // Set StudentID for session validation
        $_SESSION['division'] = $row['Division']; // Set division in session
        
        // Debugging: Log session variables after login
        error_log("Session Variables after login: " . print_r($_SESSION, true));
        error_log("Division for student: " . (isset($row['Division']) ? $row['Division'] : 'Not Set'));
        
        header('Location:welcomestudent.php');
    } else {
        echo "<script>alert('Invalid Email or Password');</script>";
        echo "<script>window.location.href='studentlogin.php';</script>";
    }
} else {
    // Error message if form data is missing
    echo "<h3><span style='color:red;'>Please enter Email and Password. Redirecting to Login Page...</span></h3>";
    header("refresh:3;url=studentlogin.php");
}

// Close the database connection
mysqli_close($connect);
?>