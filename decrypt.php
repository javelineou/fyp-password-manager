<?php
include 'desteganize.php';

session_start();


function mainDecrypt($src1, $src2){

    $ciphertext1 = desteganize($src1);
    $ciphertext2 = desteganize($src2);

    $ciphertext = $ciphertext2 . $ciphertext1;

    $cipher = "AES-256-CBC";
    $option = 0;

    //Get secret key from session mpassword and hashed
    $key = $_SESSION["mpassword"];
    $secret_key = hash('sha256', $key);
    $iv = "0000000000000000";

    $plaintext = openssl_decrypt($ciphertext, $cipher, $secret_key, $option, $iv);
    
    return $plaintext;
}
?>