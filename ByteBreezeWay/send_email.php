<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Include PHPMailer autoload file

if(isset($_POST['create_account'])) {
    // Generate OTP
    $otp = mt_rand(100000, 999999);

    // Send Email
    $to = $_POST['email'];
    $subject = 'Your OTP for Account Verification';
    $message = 'Your OTP is: ' . $otp;

    // PHPMailer settings
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.bytebreezeway.com'; // Hostinger SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'admin@bytebreezeway.com'; // Your email address
    $mail->Password = 'ByteBreezeWay@website_123'; // Your email password
    $mail->SMTPSecure = 'tls'; // Enable TLS encryption
    $mail->Port = 465; // TCP port to connect to

    // Sender
    $mail->setFrom('admin@bytebreezeway.com', 'Your Name');

    // Recipient
    $mail->addAddress($to);

    // Email content
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $message;

    // Send email
    if($mail->send()) {
        echo 'OTP sent successfully!';
    } else {
        echo 'Failed to send OTP! Error: ' . $mail->ErrorInfo;
    }
}
?>
