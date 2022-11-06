<?php
include 'desteganize.php';

$src = 'C:/xampp1/htdocs/fyp-password-manager/prototype/stego.png';
$ciphertext = desteganize($src);
//echo $ciphertext;

$cipher = "AES-256-CBC";
$option = 0;

//get from database
$secret_key = "c60a5ba50dfe75d58800ff7e32b53c2f8e57cd4884a85c594d3141f2eeda9116";
$iv = "0000000000000000";

$plaintext = openssl_decrypt($ciphertext, $cipher, $secret_key, $option, $iv);
echo $plaintext;

?>