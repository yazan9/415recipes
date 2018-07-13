<?php
function send_activation_email($email_address, $activation_code){
require("vendor/phpmailer/phpmailer/src/PHPMailer.php");
require("vendor/phpmailer/phpmailer/src/SMTP.php");
require "includes/config.inc.php";

$body = "<p>Thank you for registering with 415 Recipes! Please click on the link below to activate your account:</p><br>".
"<a href='".constant("BASE_URL")."activate.php?email=".urlencode($email_address)."&x=".$activation_code."'>Activate Account</a>";

    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->IsSMTP(); // enable SMTP
    $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true; // authentication enabled
    $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 465; // or 587
    $mail->IsHTML(true);
    $mail->Username = "415recipes@gmail.com";
    $mail->Password = "letmein415";
    $mail->SetFrom("415recipes@gmail.com");
    $mail->Subject = "415Recipes Activation Code";
    $mail->Body = $body;
    
    $mail->AddAddress($email_address);

     if(!$mail->Send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
     } else {
        echo "S040";
     }
}

function send_password_email($email_address, $password){
require("vendor/phpmailer/phpmailer/src/PHPMailer.php");
require("vendor/phpmailer/phpmailer/src/SMTP.php");

$body = "<p>Your temporary password is:</p><br><strong>{$password}</strong><br>Please change it as soon as you login";

    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->IsSMTP(); // enable SMTP
    //$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true; // authentication enabled
    $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 465; // or 587
    $mail->IsHTML(true);
    $mail->Username = "415recipes@gmail.com";
    $mail->Password = "letmein415";
    $mail->SetFrom("415recipes@gmail.com");
    $mail->Subject = "415Recipes Password Reset";
    $mail->Body = $body;
    
    $mail->AddAddress($email_address);

     if(!$mail->Send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
     } else {
        echo "S040";
     }
}
?>
