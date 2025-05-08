<?php

require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$servername = "localhost";

$username = "root";

$password = "";

$dbname = "farmempower";



// Create connection

$conn = new mysqli(
    $_ENV['DB_HOST'],
    $_ENV['DB_USER'],
    $_ENV['DB_PASSWORD'],
    $_ENV['DB_NAME']
);



// Check connection

if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);

}



// Sanitize input

$name = $conn->real_escape_string($_POST['name']);

$email = $conn->real_escape_string($_POST['email']);

$subject = $conn->real_escape_string($_POST['subject']);

$message = $conn->real_escape_string($_POST['message']);



// Insert into database

$sql = "INSERT INTO feedback (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";



if ($conn->query($sql) === TRUE) {



    // --- Send Thank-You Email ---

    $to = $email;

    $email_subject = "Thank you for your feedback!";

    $email_message = "

    <html>

    <head>

      <title>Thank you for your feedback</title>

    </head>

    <body>

      <p>Hi $name,</p>

      <p>Thank you for your feedback on <strong>$subject</strong>.</p>

      <p>We truly appreciate your input and will get back to you if needed.</p>

      <br>

      <p>Best regards,<br>FarmEmpower Team</p>

    </body>

    </html>

    ";



    // Set headers

    $headers = "From: FarmEmpower <" . $_ENV['EMAIL_FEEDBACK_FROM'] . ">\r\n";

    $headers .= "Reply-To: " . $_ENV['EMAIL_FEEDBACK_REPLY_TO'] . "\r\n";

    $headers .= "MIME-Version: 1.0\r\n";

    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    $headers .= "X-Mailer: PHP/" . phpversion();



    // Send email

    mail($to, $email_subject, $email_message, $headers);



    // Redirect to thank-you page

    header("Location: pages/thank-you.html");

    exit();

} else {

    echo "Error: " . $sql . "<br>" . $conn->error;

}



$conn->close();

?>