<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load PHPMailer classes
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

function sendSMSLikeEmail($email, $name, $book_name, $borrow_id, $return_date) {
    $mail = new PHPMailer(true);

    try {
        // SMTP settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'yourgmail@gmail.com';        // 🔒 Your Gmail
        $mail->Password = 'your_app_password';          // 🔒 App Password (not Gmail password)
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Sender and recipient
        $mail->setFrom('yourgmail@gmail.com', 'Library System');
        $mail->addAddress($email, $name);

        // SMS-style message (Plain Text)
        $mail->isHTML(false);
        $mail->Subject = '📚 Borrow Confirmed';
        $mail->Body = "Book: $book_name\nBorrow ID: $borrow_id\nReturn by: $return_date\nThank you!";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mailer Error: " . $mail->ErrorInfo);
        return false;
    }
}
?>
