<?php

// configure
$from = 'Konference mladých nadějí formulář <webform@mladenadeje.com>';
$sendTo = 'Kontaktní formulář <ceskenadeje@gmail.com>'; // Add Your Email
$subject = 'New message from contact form';
$fields = array('name' => 'Jméno', 'subject' => 'Předmět', 'email' => 'Email', 'message' => 'Zpráva'); // array variable name => //Text to appear in the email
$okMessage = 'Kontaktní formulář byl úspěšně odeslán. Brzy Vám odpovíme. :)';
$errorMessage = 'Při odesílání nastala chyba. Prosím, zkuste to znovu později.';

// let's do the sending

try
{
    $emailText = "Kontaktním formulářem byla odeslána nová zpráva\n=============================\n";

    foreach ($_POST as $key => $value) {

        if (isset($fields[$key])) {
            $emailText .= "$fields[$key]: $value\n";
        }
    }

    $headers = array('Content-Type: text/plain; charset="UTF-8";',
        'From: ' . $from,
        'Reply-To: ' . $from,
        'Return-Path: ' . $from,
    );
    
    mail($sendTo, $subject, $emailText, implode("\n", $headers));

    $responseArray = array('type' => 'success', 'message' => $okMessage);
}
catch (\Exception $e)
{
    $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);

    header('Content-Type: application/json');

    echo $encoded;
}
else {
    echo $responseArray['message'];
}
