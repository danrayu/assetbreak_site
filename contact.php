<?php
require_once __DIR__ . '/config/secrets.php';
header('Content-Type: application/json');
// Enable error reporting (remove in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



// Check if request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $data = json_decode(file_get_contents('php://input'), true);
    $email = filter_var($data['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars($data['message'] ?? '');
    $phone = htmlspecialchars($data["phone"]);
    $name = htmlspecialchars($data["name"]);
    $pickup = htmlspecialchars($data["pickup"]);
    $destination = htmlspecialchars($data["destination"]);
    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Invalid email address.";
        exit;
    }

    if (empty($message)) {
        http_response_code(400);
        echo "Message is required.";
        exit;
    }

    
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
    $mail->SMTPAuth = true;
    $mail->Username = 'dan.rayu@gmail.com'; // Your Gmail address
    $mail->Password = $gmail_pwd;  // Your Gmail app password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    //Recipients
    $mail->setFrom('dan.rayu@gmail.com', 'AssetBreak');
    $mail->addAddress('dan.rayu@gmail.com'); // Add recipient
    $mail->addAddress('danilant10@gmail.com '); // Add recipient
    $mail->addReplyTo($email); // Add reply-to

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'New Message to AssetBreak';
    $mail->Body    = "Sender Name: $name<br>Sender Email: $email<br>Phone: $phone<br><br>Pickup Address: $pickup<br>Destination Address: $destination<br><br>Message:<br>$message";

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
} else {
    http_response_code(405);
    echo "Only POST requests are allowed.";
}
?>


<?php


?>
