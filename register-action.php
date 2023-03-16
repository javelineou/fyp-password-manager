<?php
  include ("config.php");
  session_start();

  ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>.
    <link rel="icon" href="img/logo-icon.svg" />
    </head>
  <?php

  // Processing form data when form is submitted
  if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $email = $_POST["email"];
    $name = $_POST["name"];
    $mpassword = md5($_POST["password"]);

    $query = "INSERT INTO user VALUES ('', '$email', '$name', '$mpassword')";

    $data = mysqli_query($conn, $query);

    if($data){
      ?>
          <script>
          Swal.fire({
              icon: 'success',
              title: 'User Registered',
              text: 'You will be redirected to the login page',
              showConfirmButton: false,
              timer: 3000
          }).then((result) => {
    if (result.dismiss === Swal.DismissReason.timer) {
      window.location.href = "login.php";                            
    }
});
          </script>
      <?php
    } 
    else{
      echo "ERROR: Hush! Sorry $query. "
          . mysqli_error($conn);
    }
  // Close connection
  mysqli_close($conn);


  }
?>