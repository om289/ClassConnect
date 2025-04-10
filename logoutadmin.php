<?php
session_start();
?>
<?php
$_SESSION["umail"] = ""; // Correct way to unset a specific session variable
session_unset();         // Clears all session variables
session_destroy();       // Recommended to fully destroy the session
header('Location: index.php'); // Ensure there's a proper file extension
exit();                  // Stops further script execution after redirect
?>
