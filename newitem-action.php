<?php
  include ("config.php");
  include ("encrypt.php");

  ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="img/logo-icon.svg" />
    </head>
  <?php

  // Processing form data when form is submitted
  if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $category_id = $_POST["categories"];
    $title = $_POST["title"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $notes = $_POST["notes"];

    $key = $_SESSION["mpassword"];
    $user_id = $_SESSION["user_id"];
    
    mainEncrypt($password, $key, $conn);

    $query1 = "SELECT img_one_id FROM img_one ORDER BY img_one_id DESC LIMIT 1";
    $query2 = "SELECT img_two_id FROM img_two ORDER BY img_two_id DESC LIMIT 1";

    $data1 = mysqli_query($conn, $query1);
    if(mysqli_num_rows($data1) > 0){
      $row = mysqli_fetch_assoc($data1);
      $img_one_id = $row['img_one_id'];
    }
      
    $data2 = mysqli_query($conn, $query2);
    if(mysqli_num_rows($data2) > 0){
      $row = mysqli_fetch_assoc($data2);
      $img_two_id = $row['img_two_id'];
    }

    $query3 = "INSERT INTO passwords VALUES ('','$user_id', '$category_id', '$title', '$username', '$img_one_id', '$img_two_id', '$notes')";
    $data = mysqli_query($conn, $query3);

    if($data){
      ?>
        <body>
          <script>
          Swal.fire({
              icon: 'success',
              title: 'Item Saved',
              text: 'You will be redirected to your vault',
              showConfirmButton: false,
              timer: 3000
          }).then((result) => {
                if (result.dismiss === Swal.DismissReason.timer) {
                window.location.href = "vault.php";                            
                }
            });
          </script>
        </body>
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