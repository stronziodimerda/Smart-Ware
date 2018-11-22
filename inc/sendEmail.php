<?php

// Replace this with your own email address
$siteOwnersEmail = 'ieee.usil@gmail.com';


if($_POST) {

    $name = trim(stripslashes($_POST['contactName']));
    $email = trim(stripslashes($_POST['contactEmail']));
    $subject = trim(stripslashes($_POST['contactSubject']));
    $contact_message = trim(stripslashes($_POST['contactMessage']));

    // Check Name
    if (strlen($name) < 2) {
        $error['name'] = "Por favor, coloca tu nombre.";
    }
    // Check Email
    if (!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $email)) {
        $error['email'] = "Por favor, escribe una dirección de correo válida.";
    }
    // Check Message
    if (strlen($contact_message) < 15) {
        $error['message'] = "Por favor, esribe un mensaje. Este debe contener como mínimo 15 caracteres.";
    }
    // Subject
    if ($subject == '') { $subject = "Inscripción de Nuevo Miembro"; }


    // Set Message
    $message .= "Email from: " . $name . "<br />";
    $message .= "Email address: " . $email . "<br />";
    $message .= "Message: <br />";
    $message .= $contact_message;
    $message .= "<br /> ----- <br /> Correo enviado a través del formulario de contacto de la landing page. <br />";

    // Set From: header
    $from =  $name . " <" . $email . ">";

    // Email Headers
    $headers = "From: " . $from . "\r\n";
    $headers .= "Reply-To: ". $email . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";


    if (!$error) {

        ini_set("sendmail_from", $siteOwnersEmail); // for windows server
        $mail = mail($siteOwnersEmail, $subject, $message, $headers);

        if ($mail) { echo "OK"; }
        else { echo "Algo salió mal. Por favor, intenta otra vez."; }
        
    } # end if - no validation error

    else {

        $response = (isset($error['name'])) ? $error['name'] . "<br /> \n" : null;
        $response .= (isset($error['email'])) ? $error['email'] . "<br /> \n" : null;
        $response .= (isset($error['message'])) ? $error['message'] . "<br />" : null;
        
        echo $response;

    } # end if - there was a validation error

}

?>