<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load PHPMailer classes manually
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';
require './PHPMailer/src/Exception.php';

function sendMail($marksheet,$receiver,$marksheetOwner){

$mail = new PHPMailer(true);

try {
    // SMTP Configuration
    $mail->isSMTP();
    $mail->Host       = 'sandbox.smtp.mailtrap.io';
    // $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = '74b4d6fae0226c';
    $mail->Password   = 'da187ab9edb6a7'; 
    $mail->Port       = 587;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    // $mail->Port       = 465;

    // Sender & Recipient
    $mail->setFrom('kwlshrestha@gmail.com', 'Kewal');
    $mail->addAddress($receiver, 'Person');

    // Email Content
    $mail->isHTML(true);
    $mail->Subject = 'Here is the marksheet of .$marksheetOwner';
    $mail->Body    = $marksheet;
    $mail->AltBody = 'Best Regards.';

    $mail->send();
    echo 'Email sent successfully!';
} catch (Exception $e) {
    echo "Email could not be sent. Error: {$mail->ErrorInfo}";
}
}
?>
