<?php
include 'desteganize.php';
include 'config.php';

$query1 = "SELECT * FROM img_one where img_one_id=2"; //wherenya nanti dipass dari table passwords
$query2 = "SELECT * FROM img_two where img_two_id=2";

$data1 = mysqli_query($conn, $query1);
if(mysqli_num_rows($data1) > 0){
    $row = mysqli_fetch_assoc($data1);
    $src1 = $row['img'];
}

$data2 = mysqli_query($conn, $query2);
if(mysqli_num_rows($data2) > 0){
    $row = mysqli_fetch_assoc($data2);
    $src2 = $row['img'];
}

$ciphertext1 = desteganize($src1);
$ciphertext2 = desteganize($src2);

$ciphertext = $ciphertext2 . $ciphertext1;

$cipher = "AES-256-CBC";
$option = 0;

//get secret key from session mpassword and hashed
$key = $_SESSION["mpassword"];
$secret_key = ('sha256', $key);
$iv = "0000000000000000";

$plaintext = openssl_decrypt($ciphertext, $cipher, $secret_key, $option, $iv);
echo $plaintext;

?>