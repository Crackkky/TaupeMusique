<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);
$email = 'drakox211@gmail.com';
$name = 'julain';
$email_from = 'taupmusiqueinfo@gmail.com';
$name_from = 'info';
//Send mail using gmail

    $mail->IsSMTP(); // telling the class to use SMTP
    $mail->SMTPAuth = true; // enable SMTP authentication
    $mail->SMTPSecure = "ssl"; // sets the prefix to the servier
    $mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server
    $mail->Port = 465; // set the SMTP port for the GMAIL server
    $mail->Username = "taupemusique2@gmail.com"; // GMAIL username
    $mail->Password = "TaupeMusique!"; // GMAIL password


//Typical mail data
$mail->AddAddress($email, $name);
$mail->SetFrom($email_from, $name_from);
$mail->Subject = "Achat efféctué";
$mail->Body = "Votre achat a été finalisé avec succès ! Vous n'allez cependant recevoir aucun article ! Merci à vous !";

try {
    $mail->Send();
    echo "Success!";
} catch (Exception $e) {
    //Something went bad
    echo "Fail - " . $mail->ErrorInfo;
}

?>
