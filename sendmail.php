<?php
// Edit the below fields
$admin = 'jlesl09@gmail.com' ; // Change to your admin email 'from' address
$replymsg = 'Thank you for your email. I will get back to you as soon as possible.' ; // Reply message to send
$formurl = 'https://james-leslie.github.io/E-Portfolio/#contact' ; // the URL where the form code is - default: form.php
// Security code to prevent addition of extra emails by spambots
function remove_headers($string) {
$headers = array(
"/to\:/i",
"/from\:/i",
"/bcc\:/i",
"/cc\:/i",
"/Content\-Transfer\-Encoding\:/i",
"/Content\-Type\:/i",
"/Mime\-Version\:/i"
);
if (preg_replace($headers, '', $string) == $string) {
return $string;
} else {
die('You are not completing the form correctly.');
}
}
$uself = 0;
$headersep = (!isset( $uself ) || ($uself == 0)) ? "\r\n" : "\n" ;
// Variables
$email = remove_headers($_POST['email']) ;
$name = remove_headers($_POST['name']) ;
$subject = remove_headers($_POST['subject']) ;
$message = remove_headers($_POST['message']) ;
$wordcount = str_word_count($message);
// Code to prevent addition of / before ' in text entered by viewer
if (get_magic_quotes_gpc()) {
$name = stripslashes( $name );
$subject = stripslashes( $subject );
$message = stripslashes( $message );
}
// If email is filled out, proceed, if not, display the form
if (!isset($_POST['email'])) {
header( "Location: $formurl" ); //
}
// Code to check for empty input boxes
elseif (empty($email) || empty($name) || empty($subject)) {
header( "Location: $formurl" );
}
// Security code to check that email address is probably valid and only contains one address
elseif
(!preg_match("/^[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,6}$/i",$email)) {
header( "Location: $formurl" );
exit ;
}
// Security code to prevent addition of new lines entered into the $name and $email fields by spambots
//WORDCOUNT ADDED but . in a word like formemail.php causes extra word; echo will show in plain text in a new window with default browser background color (an alternative to header( "Location: $errorurl" ); which shows a complete html page)
else {
mail( $admin, "Feedback: $subject", "$name\r\n$email\r\n$message", "From: $name <$admin>" );
mail( $email, "Feedback: $subject",	$replymsg , "From: $admin" );
header( "Location: $formurl" );
}
?>
