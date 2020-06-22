
<?php

require 'public/vendors/php/sendgrid/sendgrid-php.php';
require 'config/functions.php';
require 'php/apikey.php';

class SendEmail
{
 public static function SendMail($fromName, $fromEmail, $subject, $content)
 {
  $email = new SendGrid\Mail\Mail();
  $email->setFrom("tarilevente599@citromail.hu", "Mezes oldal");
  $email->setSubject($subject);
  $email->addTo("taril88@gmail.com", "Kaiser Rezső"); //kaiserr79@gmail.com
  $email->setTemplateId(getTemplateID());
  $email->addDynamicTemplateData('fromName', $fromName);
  $email->addDynamicTemplateData('fromEmail', $fromEmail);
  $email->addDynamicTemplateData('subject', $subject);
  $email->addDynamicTemplateData('content', $content);
  $email->addContent(
   "text/html", "content"
  );
  $sendgrid = new SendGrid(getApikey());

  try {
   $response = $sendgrid->send($email);
   return $response;
  } catch (Exception $e) {
   return 'exception';
  }
 } //endof function sendemail
} //endof sendemail class

//initialize the response
$response             = array();
$response['error']    = false;
$response['html']     = ''; //used for everything is ok->message
$response['errorMsg'] = "";

if (
 isset($_POST['fromName']) && !empty($_POST['fromName']) &&
 isset($_POST['fromEmail']) && !empty($_POST['fromEmail']) &&
 isset($_POST['subject']) && !empty($_POST['subject']) &&
 isset($_POST['content']) && !empty($_POST['content'])
) {
 $fromName  = testInput($_POST['fromName']);
 $fromEmail = testInput($_POST['fromEmail']);
 $subject   = testInput($_POST['subject']);
 $content   = testInput($_POST['content']);

 //validáció
 if (strlen($fromName) < 3) {
  http_response_code(404);
  $response['errorMsg'] .= "A Név túl rövid, vagy sok a szóköz! (min. 3 karakter)php<br>" . $fromName;
  $response['errorCode'] = "65521";
 }
 if (!emailIsValid($fromEmail)) {
  http_response_code(404);
  $response['errorMsg'] .= "Az e-mail cím helytelen formátumú! php<br>" . $fromEmail;
  $response['errorCode'] = "65522";
 }
 if (strlen($subject) < 3) {
  http_response_code(404);
  $response['errorMsg'] .= "A Tárgy mező túl rövid, vagy sok a szóköz! (min. 3 karakter)php<br>" . $subject;
  $response['errorCode'] = "65523";
 }
 if (strlen($content) < 6) {
  http_response_code(404);
  $response['errorMsg'] .= "Az üzenet túl rövid, vagy sok a szóköz! (min. 5 karakter)php <br>" . $content;
  $response['errorCode'] = "65524";
 }
 //spec karakter, stb..
 //esetleg üres post-ra is visszajelzést adni

 $respEmail        = SendEmail::SendMail($fromName, $fromEmail, $subject, $content);
 $response['html'] = $respEmail->statusCode();
 foreach ($respEmail->headers() as $headers) {
  $response['html'] .= "headers: " . $headers;
 }
 $response['html'] .= "Body:" . $respEmail->body();

 if ($respEmail->statusCode() > 299) {
  http_response_code(404);
  $response['error']     = "true";
  $response['errorMsg']  = "Valami hiba történt. error code: 65524";
  $response['errorCode'] = "65524";
 }
} //endof emailRequest
else {
 //no post
 http_response_code(404);
 $response['error']     = "true";
 $response['errorMsg']  = "Hiba a küldésben, error code: 65520";
 $response['errorCode'] = "65520";
}

// echo $html;
echo json_encode($response, JSON_UNESCAPED_UNICODE);
