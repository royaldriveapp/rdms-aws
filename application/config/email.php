<?php

/*
$config['protocol'] = 'smtp';
$config['smtp_host'] = 'smtp.gmail.com';
$config['smtp_port'] = '587'; // Change to TLS port
$config['smtp_crypto'] = 'tls'; // Enable TLS encryption
$config['smtp_user'] = 'talktoroyaldriveit@gmail.com';
$config['smtp_pass'] = 'tfac kyur gxbh rpxt';
$config['charset'] = 'utf-8';
$config['newline'] = "\r\n";
$config['mailtype'] = 'html';
$config['validation'] = TRUE; // Enable email validation
*/

//////


// $config['protocol'] = 'smtp';
// $config['smtp_host'] = 'smtp.office365.com';
// $config['smtp_port'] = '587';
// $config['smtp_crypto'] = 'STARTTLS'; // Enable TLS encryption
// $config['smtp_user'] = 'it@royaldrive.in'; // Your Microsoft 365 email address
// $config['smtp_pass'] = 'Luk47123'; // Your Microsoft 365 password
// $config['charset'] = 'utf-8';
// $config['newline'] = "\r\n";
// $config['mailtype'] = 'html';
// $config['validation'] = TRUE; // Enable email validation

$config['protocol'] = 'smtp';
$config['smtp_host'] = 'smtp.office365.com';
$config['smtp_port'] = '587';
$config['smtp_crypto'] = 'STARTTLS'; // Use 'tls' instead of 'STARTTLS'
$config['smtp_user'] = 'it@royaldrive.in'; // Your Microsoft 365 email address
$config['smtp_pass'] = 'Luk47123'; // Your Microsoft 365 password
$config['charset'] = 'utf-8';
$config['newline'] = "\r\n";
$config['mailtype'] = 'html';
$config['validation'] = TRUE; // Enable email validation
$config['smtp_auth'] = TRUE; // Enable SMTP authentication



?>