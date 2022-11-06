<?php
include 'steganize.php';

function toBin($str){
    $str = (string)$str;
    $l = strlen($str);
    $result = '';
    while($l--){
      $result = str_pad(decbin(ord($str[$l])),8,"0",STR_PAD_LEFT).$result;
    }
    return $result;
  }

  function toString($binary){
    return pack('H*',base_convert($binary,2,16));
  }

    //GET data from html
    $plain =  $_GET['plain'];
    $key =  $_GET['key'];
    $cipher = "AES-256-CBC";
    $option = 0;

    //Hash the master password
    $secret_key = hash('sha256', $key);

    $iv = str_repeat("0",openssl_cipher_iv_length($cipher));
    echo $iv;

    $ciphertext = openssl_encrypt($plain, $cipher, $secret_key, $option, $iv);
    //echo "Encrypted text:  " . $ciphertext;

    $src = 'C:/xampp1/htdocs/fyp-password-manager/prototype/Red_vineyards.jpg';
    steganize($src, $ciphertext);
?>