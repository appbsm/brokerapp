<?php

// Show PHP errors (Disable in production)
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// Include library PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// require_once 'vendor/autoload.php';

// Start
$mail = new PHPMailer(true);

try {

// $mail->isSMTP();// Set mailer to use SMTP
// $mail->CharSet = "utf-8";// set charset to utf8
// $mail->SMTPAuth = true;// Enable SMTP authentication
// $mail->SMTPSecure = 'tls';// Enable TLS encryption, `ssl` also accepted

// $mail->Host = 'potekknd14@gmail.com';// Specify main and backup SMTP servers
// $mail->Port = 587;// TCP port to connect to
// $mail->SMTPOptions = array(
//     'ssl' => array(
//         'verify_peer' => false,
//         'verify_peer_name' => false,
//         'allow_self_signed' => true
//     )
// );
// $mail->isHTML(true);// Set email format to HTML

// $mail->Username = 'sms.booking@hotmail.com';// SMTP username
// $mail->Password = 'Kk028781450';// SMTP password

// $mail->setFrom('love_pote14@hotmail.co.th', 'John Smith');//Your application NAME and EMAIL
// $mail->Subject = 'Test';//Message subject
// $mail->MsgHTML('HTML code');// Message body
// $mail->addAddress('User Email', 'User Name');// Target email

// $mail->send();

$smtp_user = 'smbooking@smresorts.asia';
$smtp_pass = 'Bsm@2023';

// $smtp_user = 'love_pote14@hotmail.com';
// $smtp_pass = 'Kk028781450z';


$mail = new PHPMailer(true); 
$mail->CharSet = 'UTF-8';  //not important
$mail->isSMTP(); //important
$mail->Host = 'smtp-legacy.office365.com'; //important
$mail->Port       = 587; //important
$mail->SMTPSecure = 'tls'; //important
$mail->SMTPAuth   = true; //important, your IP get banned if not using this

//Auth
$mail->Username = $smtp_user;
$mail->Password = $smtp_pass;//Steps mentioned in last are to create App password

// //Set who the message is to be sent from, you need permission to that email as 'send as'
$mail->SetFrom($smtp_user, 'Hosting Group Inc.'); //you need "send to" permission on that account, if dont use yourname@mail.org

// //Set an alternative reply-to address
// $mail->addReplyTo('love_pote14@hotmail.com', 'First Last');

// //Set who the message is to be sent to
$mail->addAddress('thanawat@buildersmart.com', 'SIMON MÜLLER');
// //Set the subject line
$mail->Subject = 'PHPMailer SMTP test';
$mail->Body = "My Body test sent mail new"; 
$mail->AltBody = 'This is a plain-text message body';
if (!$mail->send()) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Successfully sent mail ';
}

} catch (Exception $e) {
    echo "Message has not been sent. Mailer Error: {$mail->ErrorInfo}";
}

?>