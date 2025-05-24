<?php
session_start();
unset($_SESSION['cart']);
header("Location: cart.php"); // Or wherever your cart page is
exit;
?>
