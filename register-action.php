<?php
  include ("config.php");
  session_start();

  // Processing form data when form is submitted
  if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $email = $_POST["email"];
    $name = $_POST["name"];
    $password = md5($_POST["password"]);
    $repassword = $_POST["repassword"];

    $query = "INSERT INTO user VALUES ('', '$email', '$name', '$password')";

    $data = mysqli_query($conn, $query);

    if($data){
      echo "Data stored in a database successfully.";
    } 
    else{
      echo "ERROR: Hush! Sorry $query. "
          . mysqli_error($conn);
    }
  // Close connection
  mysqli_close($conn);

  header("Location: login.php");

  }
?>