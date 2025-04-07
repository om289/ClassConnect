<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rollnumber = $_POST["rollnumber"];
    $password = $_POST["pass"];

    include("database.php");

    // Correct SQL query to match the database structure
    $sql = "SELECT * FROM studenttable WHERE RollNumber = '$rollnumber' AND Pass = '$password'";
    $result = mysqli_query($connect, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        // Set session variables
        $row = mysqli_fetch_assoc($result);
        $_SESSION["sidx"] = $row["RollNumber"];
        $_SESSION["fname"] = $row["FName"];
        $_SESSION["lname"] = $row["LName"];
        $_SESSION["seno"] = $row["RollNumber"]; // Set "seno" for use in other pages

        // Redirect to the welcome student page
        header('Location:welcomestudent.php');
    } else {
        // Error message if login fails
        echo "<h3><span style='color:red;'>Invalid Roll Number or Password. Redirecting to Login Page...</span></h3>";
        header("refresh:3;url=studentlogin.php");
    }
} else {
    // Error message if form data is missing
    echo "<h3><span style='color:red;'>Please enter Roll Number and Password. Redirecting to Login Page...</span></h3>";
    header("refresh:3;url=studentlogin.php");
}

// Close the database connection
mysqli_close($connect);
?>