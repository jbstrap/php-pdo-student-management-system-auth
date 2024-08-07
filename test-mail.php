<?php
$to = 'test@example.com';
$subject = 'Test Mail';
$message = 'This is a test email.';
$headers = 'From: kotlikarabo84@gmail.com' . "\r\n" .
    'Reply-To: kotlikarabo84@gmail.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

if (mail($to, $subject, $message, $headers)) {
    echo 'Email sent successfully!';
} else {
    echo 'Email sending failed.';
}
