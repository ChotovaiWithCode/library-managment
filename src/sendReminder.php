<?php
include('database.php');

// Get today's date
$today = date("Y-m-d");

// Get all overdue transactions where email hasn't been sent yet
$sql = "SELECT * FROM transactions WHERE return_date < '$today'";
$result = $conn->query($sql);

// Load PHPMailer (use Composer or manual)
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $email = $row['email'];
        $product = $row['product_name'];
        $return_date = $row['return_date'];
        $borrow_date = $row['borrow_date'];

        // Setup Mail
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'yourgmail@gmail.com';
            $mail->Password   = 'your_app_password'; // Use App Password
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom('yourgmail@gmail.com', 'Library System');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = "📢 Return Due for '$product'";
            $mail->Body    = "Hi,<br><br>
                You borrowed <b>$product</b> on <b>$borrow_date</b>, which was due back on <b>$return_date</b>.<br>
                Please return the item ASAP to avoid penalties.<br><br>
                Thank you,<br>Library System";

            $mail->send();
            echo "📨 Reminder sent to $email for $product<br>";
        } catch (Exception $e) {
            echo "❌ Email Error: {$mail->ErrorInfo}";
        }
    }
} else {
    echo "✅ No overdue items.";
}
?>
