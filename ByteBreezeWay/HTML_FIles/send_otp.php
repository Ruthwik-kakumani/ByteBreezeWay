<?php
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    exit(0);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header('Content-Type: application/json'); // Set content type to JSON

    $email = $_POST['email'];

    // Generate a random OTP
    $otp = rand(100000, 999999);

    // Create a new PHPMailer instance
    $mail = new PHPMailer;
    try {
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Host = 'smtp.hostinger.com';
        $mail->Port = 465;
        $mail->SMTPAuth = true;
        $mail->Username = 'admin@bytebreezeway.com';
        $mail->Password = 'ByteBreezeWay@website_123';
        $mail->setFrom('admin@bytebreezeway.com', 'Your Name');
        $mail->addReplyTo('admin@bytebreezeway.com', 'Your Name');
        $mail->addAddress($email);
        $mail->Subject = 'Your OTP Code';
        $mail->Body = "Your OTP code is: $otp";

        if ($mail->send()) {
            echo json_encode(['status' => 'success', 'message' => 'The email message was sent.']);
        } else {
            throw new Exception('Mailer Error: ' . $mail->ErrorInfo);
        }
    } catch (Exception $e) {
        error_log("Error occurred while sending email: " . $e->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'An error occurred while sending the email.']);
    }
}
?>
