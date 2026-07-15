<?php

header('Content-Type: application/json');

// Only allow POST requests

if ($_SERVER["REQUEST_METHOD"] != "POST") {

    echo json_encode([

        "success" => false,

        "message" => "Invalid request."

    ]);

    exit;

}

// Function to clean input

function clean($data) {

    return trim(strip_tags($data));

}

// Get form data

$name      = clean($_POST['name'] ?? '');

$linkedin  = clean($_POST['linkedin'] ?? '');

$phone     = clean($_POST['phone'] ?? '');

$email     = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);

$company   = clean($_POST['company'] ?? '');

$budget    = clean($_POST['budget'] ?? '');

$brief     = clean($_POST['brief'] ?? '');

// Validate required fields

if (!$name || !$email) {

    echo json_encode([

        "success" => false,

        "message" => "Please fill the required fields."

    ]);

    exit;

}

// Recipient

$to = "arun@orangy.design";

$subject = "New Contact Form Submission";

// Email Headers

$headers  = "MIME-Version: 1.0\r\n";

$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

$headers .= "From: Orangy Design <no-reply@orangy.design>\r\n";

$headers .= "Reply-To: $email\r\n";

// Email Body

$message = "

New Contact Form Submission

--------------------------------------

Full Name      : $name

LinkedIn       : $linkedin

Phone          : $phone

Email          : $email

Company        : $company

Design Budget  : $budget

Project Brief

--------------------------------------

$brief

--------------------------------------

Submitted On : " . date("d-M-Y h:i A");

// Send Mail

if (mail($to, $subject, $message, $headers)) {

    echo json_encode([

        "success" => true,

        "message" => "Thank you! We will contact you soon."

    ]);

} else {

    echo json_encode([

        "success" => false,

        "message" => "Unable to send email."

    ]);

}

?>