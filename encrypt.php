<?php
include ("steganize.php");
include_once("config.php");

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

  function mainEncrypt($plain, $key, $conn){

    $cipher = "AES-256-CBC";
    $option = 0;

    //Hash the master password
    $secret_key = hash('sha256', $key);

    $iv = str_repeat("0",openssl_cipher_iv_length($cipher));
    //echo $iv;

    $ciphertext = openssl_encrypt($plain, $cipher, $secret_key, $option, $iv);
    //echo "Encrypted text:  " . $ciphertext;

    $middle = (strlen($ciphertext)) / 2; 

    $ciphertext1 = substr($ciphertext, 0, $middle);
    $ciphertext2 = substr($ciphertext, $middle);

    file_put_contents("houseori1.jpg", fopen("https://api.lorem.space/image/house?w=150&h=150", 'r'));
    file_put_contents("houseori2.jpg", fopen("https://api.lorem.space/image/house?w=150&h=150", 'r'));
    $src1 = 'C:/xampp/htdocs/fyp-password-manager/houseori1.jpg';
    $src2 = 'C:/xampp/htdocs/fyp-password-manager/houseori2.jpg';
    steganize($src1, $ciphertext1, $conn);
    steganize($src2, $ciphertext2, $conn);

  }
?>