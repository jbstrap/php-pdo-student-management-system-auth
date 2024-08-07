<?php

use PHPMailer\PHPMailer\PHPMailer;

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Database configuration
$DB_HOST = $_ENV['DB_HOST'];
$DB_PORT = $_ENV['DB_PORT'];
$DB_USERNAME = $_ENV['DB_USERNAME'];
$DB_PASSWORD = $_ENV['DB_PASSWORD'];
$DB_DATABASE = $_ENV['DB_DATABASE'];

// SMTP configuration for Sendmail
$SMTP_HOST = $_ENV['EMAIL_HOST'];
$SMTP_PORT = $_ENV['EMAIL_PORT'];
$SMTP_USERNAME = $_ENV['EMAIL_USER'];
$SMTP_PASSWORD = $_ENV['EMAIL_PASS'];

function connect_db()
{
    global $DB_HOST, $DB_PORT, $DB_USERNAME, $DB_PASSWORD, $DB_DATABASE;
    try {
        $pdo = new PDO("mysql:host=$DB_HOST;port=$DB_PORT;dbname=$DB_DATABASE", $DB_USERNAME, $DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        exit;
    }
}

function sendEmail($email, $username): PHPMailer
{
    global $SMTP_HOST, $SMTP_PORT, $SMTP_USERNAME, $SMTP_PASSWORD;
    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    //Server settings
    $mail->isSMTP();                                // Send using SMTP
    $mail->Host = $SMTP_HOST;                 // Set the SMTP server to send through
    $mail->Port = $SMTP_PORT;                              // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
    $mail->SMTPAuth = true;                         // Enable SMTP authentication
    $mail->Username = $SMTP_USERNAME;       // SMTP username
    $mail->Password = $SMTP_PASSWORD;           // SMTP password
    $mail->SMTPSecure = 'tls';                      // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    //Recipients
    $mail->setFrom("from@example.com", "Edulearn");
    $mail->addAddress($email, $username);           // Add a recipient
    $mail->addReplyTo('noreply@example.com', 'Edulearn');

    // Content
    $mail->isHTML(true);                            // Set email format to HTML
    $mail->Subject = 'Welcome to Edulearn';

    $template = file_get_contents(__DIR__ . '/email-template.html');
    $template = str_replace('{{username}}', htmlspecialchars($username), $template);

    $mail->msgHTML($template, __DIR__);
    $mail->AltBody = 'Thank you for registering at EduLearn.';

    return $mail;
}
