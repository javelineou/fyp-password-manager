<?php
include 'desteganize.php';

$src = 'C:/xampp/htdocs/fyp-password-manager/prototype/stego.png';
$ciphertext = desteganize($src);
//echo $ciphertext;

$cipher = "AES-256-CBC";
$option = 0;

//get from database
$secret_key = "1d68f4aec119872e9ea5c9d884d38802989d5234d8be162e16340292694a943d";
$iv = "0000000000000000";

$plaintext = openssl_decrypt($ciphertext, $cipher, $secret_key, $option, $iv);
echo $plaintext;

?>