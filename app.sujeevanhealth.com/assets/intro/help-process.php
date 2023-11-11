<?php
$fullname = $_POST["fullname"];
$email = $_POST["email"];
$topic = $_POST["topic"];
$message = $_POST["message"];

$EmailTo = "themepixels@gmail.com";
$Subject = "Bracket Plus Help Request: ".$topic;
$Body = "";

// prepare email body text
$Body .= "Full Name: ";
$Body .= $fullname;
$Body .= "\n\n";

$Body .= "Email: ";
$Body .= $email;
$Body .= "\n\n";

$Body .= $message;
$Body .= "\n\n";

// send email
$request = mail($EmailTo, $Subject, $Body, 'From: '.$fullname.'<'.$email.'>');

// redirect to success page
if ($request) {

  $responder = "Hi ".$fullname.",\n\n";
  $responder .= "This is an automated response to let you know that we have received your request.\n\n";
  $responder .= "One of our team will asess your request shortly and assign it to the right team so they can assist you.\n\n";
  $responder .= "Please do not submit multiple same request, as this does not result in a faster response time.\n\n";
  $responder .= "Kind Regards,\n";
  $responder .= "ThemePixels Help Department";

  $success = mail($email, "Request Received: ".$topic, $responder, 'From: Bracket Plus Help <themepixels@gmail.com>');

  if($success) {
    echo "success";
  } else {
    echo "invalid 2";
  }

} else {
  echo "invalid";
}

?>
