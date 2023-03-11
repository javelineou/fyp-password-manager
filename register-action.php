<?php
  include ("config.php");
  session_start();

  // Processing form data when form is submitted
  if($_SERVER["REQUEST_METHOD"] == "POST"){

    echo "Submitted";
    
    $email = $_POST["email"];
    $name = $_POST["name"];
    $password = $_POST["password"];
    $repassword = $_POST["repassword"];

    if($password != $repassword){
        echo"not match";
    }

    }
?>