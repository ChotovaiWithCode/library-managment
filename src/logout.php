<?php
session_start();
session_destroy();
header("Location: Seassionstart.php"); // Redirect to login or homepage
exit();
?>
