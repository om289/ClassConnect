<?php
session_start();
?>
<?php
$_SESSION["fidx"] = ""; // Correct way to clear a specific session variable
session_unset();         // Clears all session variables
session_destroy();       // Recommended for complete session termination
header('Location: index.php'); // Redirects to the index page
exit();                  // Ensures script stops after the redirect
?>
