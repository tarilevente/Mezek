
<?php
require 'vendor/autoload.php';
// require 'public/vendors/php/sendgrid/sendgrid-php.php';
class SendEmail
{
 public static function SendMail($fromName, $fromEmail, $subject, $content)
 {
  $keyFreemail     = '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';
  $keyGmail        = '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';
  $Mezek_Template2 = 'd-083c5482339b401f8c5392dc8ca2fe42';

  $email = new SendGrid\Mail\Mail();
  $email->setFrom("tarilevente599@freemail.hu", "Mezes oldal");
  $email->setSubject("testSubject");
  $email->addTo("taril88@gmail.com", "Tari Levente");
  $email->addContent("text/plain", "test content"); //or text/html
  $email->setTemplateId($Mezek_Template2);
  $email->addDynamicTemplateData('fromEmail', $fromEmail);
  $email->addContent(
   "text/html", "<strong>and easy to do anywhere, even with PHP</strong>"
  );
  $sendgrid = new SendGrid($keyGmail);

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

if (isset($_POST['fromName']) && !empty($_POST['fromName'])
 && isset($_POST['fromEmail']) && !empty($_POST['fromEmail'])
 && isset($_POST['subject']) && !empty($_POST['subject'])
 && isset($_POST['content']) && !empty($_POST['content'])
) {
 $fromName  = $_POST['fromName'];
 $fromEmail = $_POST['fromEmail'];
 $subject   = $_POST['subject'];
 $content   = $_POST['content'];

 //validáció
 //spec karakter, stb..
 //esetleg üres post-ra is visszajelzést adni

 $respEmail = SendEmail::SendMail($fromName, $fromEmail, $subject, $content);
 $html      = "\n" . $respEmail->statusCode();
 foreach ($respEmail->headers() as $headers) {
  $html .= "\nheaders: " . $headers . "\n";
 }
 $html .= "\n Body:" . $respEmail->body();

} //endof emailRequest

echo json_encode($response, JSON);