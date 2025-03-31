<?php
session_start();
?>
<?php
$_SESSION["sidx"] = "";  // If you want to reset this specific variable
session_unset();         // Clears all session variables
session_destroy();       // Destroys the session entirely
header('Location: index'); // Ensure there's a proper file extension like 'index.php'
exit();                  // Recommended to ensure the script stops after redirect
?>
