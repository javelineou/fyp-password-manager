<?php
    // Include config file to start db
    include ("config.php");
    include ("decrypt.php");
    
    // Check if the user is logged in, otherwise redirect to login page
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
    }  

    // Check if the password_id parameter is set in the URL
    if (isset($_GET['password_id'])) {
      $password_id = $_GET['password_id'];

      $query = "SELECT * FROM passwords WHERE password_id = " . $password_id;
      $data = mysqli_query($conn, $query);

      if(mysqli_num_rows($data) > 0){
        $row = mysqli_fetch_assoc($data);
      }

      $query_img1 = "SELECT img FROM img_one WHERE img_one_id = " . $row['img_one_id'];
      $query_img2 = "SELECT img FROM img_two WHERE img_two_id = " . $row['img_two_id'];

      $data_img1 = mysqli_query($conn, $query_img1);
      if(mysqli_num_rows($data_img1) > 0){
          $row1 = mysqli_fetch_assoc($data_img1);
          $src1_blob = $row1['img'];
          $src1 = "data:image/png;base64," . base64_encode($src1_blob);
      }

      $data_img2 = mysqli_query($conn, $query_img2);
      if(mysqli_num_rows($data_img2) > 0){
          $row2 = mysqli_fetch_assoc($data_img2);
          $src2_blob = $row2['img'];
          $src2 = "data:image/png;base64," . base64_encode($src2_blob);
      }

      $password = mainDecrypt($src1, $src2);

    } 
    else {
    // If the password_id parameter is not set in the URL, display an error message
    echo "Error: password_id parameter is missing in the URL.";
    }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Vault | VaultMate</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="img/logo-icon.svg" />
    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD"
      crossorigin="anonymous"
    />
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
      crossorigin="anonymous"
    ></script>
    
    <!-- Custom CSS/JS -->
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- reCaptcha script -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  </head>

    <body>
    <script>
      function verifyForm() {
        //Validating form requirements
        var title = document.forms["edititemForm"]["title"].value;
        var username = document.forms["edititemForm"]["username"].value;
        var password = document.forms["edititemForm"]["password"].value;
        var notes = document.forms["edititemForm"]["notes"].value;
        
        if (title == "" || username == "" || password == ""){
          Swal.fire({
            icon: 'error',
            title: 'Invalid',
            text: 'Please input your data completely',
            confirmButtonText: 'Ok',
          }).then((result) => {
            if (result.isConfirmed) {
              location.reload();
            }
          })
        }
        else{
          document.getElementById("edititemForm").submit();
        }
      }
    </script>
        <section>
        <nav class="navbar navbar-light bg-bitwarden">
            <div class="container-fluid ms-navbar-left">
            <a class="navbar-brand" href="vault.php">
                <img
                src="img/logo-icon.svg"
                width="45"
                height="45"
                alt="logo-icon"
                />
            </a>

            <ul class="nav me-auto">
                <li class="nav-item">
                <a class="nav-link link-light fw-bold" href="vault.php">My Vault</a>
                </li>
                <li class="nav-item">
                <a class="nav-link link-light fw-bold text-white-50" href="tools.php">Tools</a>
                </li>
                <li class="nav-item">
                <a class="nav-link link-light fw-bold text-white-50" href="logout.php">Log Out</a>
                </li>
            </ul>
            </div>
        </nav>
        </section>
        <section>
        <div class="container mt-2 pt-3 text-center">
            <p class="fs-4 fw-light">Edit Item</p>
        </div>
    </section>
    <section>
      <div class="container mt-2 pt-3">
        <div class="row">
          <div class="col-12 col-sm-6 col-md-6 m-auto">
            <div class="card border-1 rounded-3">
              <div class="card-body">
                <form id="edititemForm" name="edititemForm" action="edititem-action.php" method="POST">

                  <input type="hidden" name="password_id" value="<?php echo $password_id; ?>">

                  <label for="categories" class="fw-semibold reg-title">What type of item is this?</label>
                  <select class="form-select mb-4 mt-2" aria-label="Default select example" name="categories" id="categories">
                    <option value="1" <?php if($row['category_id'] == 1) echo "selected"; ?>>Email</option>
                    <option value="2" <?php if($row['category_id'] == 2) echo "selected"; ?>>Social Media</option>
                    <option value="3" <?php if($row['category_id'] == 3) echo "selected"; ?>>Game & Entertainment</option>
                    <option value="4" <?php if($row['category_id'] == 4) echo "selected"; ?>>Finance</option>
                  </select>

                  <label for="title" class="form-label fw-semibold">Title</label>
                  <div class="input-group mb-3">
                    <input
                      type="text"
                      name="title"
                      id="title"
                      class="form-control py-2"
                      value="<?php echo $row['title']; ?>"
                    />
                  </div>

                  <p class="fw-semibold reg-title">Username</p>
                  <input
                    type="text"
                    name="username"
                    id="username"
                    class="form-control my-4 py-2"
                    value="<?php echo $row['username']; ?>"
                  />

                  <label for="password" class="form-label fw-semibold">Password</label>
                  <div class="input-group mb-3">
                    <input
                      type="password"
                      name="password"
                      id="password"
                      class="form-control py-2"
                      value="<?php echo $password; ?>"
                    />
                    <span onmouseover="highlight(this)" onmouseout="unhighlight(this)" class="input-group-text" onclick="password_show_hide();">
                        <i class="bi bi-eye" id="show_eye"></i>
                        <i class="bi bi-eye-slash d-none" id="hide_eye"></i>
                    </span>
                  </div>

                  <label for="notes" class="fw-semibold reg-title"> Notes</label>
                  <textarea class="form-control" placeholder="Leave a comment here" name="notes" id="notes" style="height: 100px"><?php echo $row['notes']; ?></textarea>
                  
                  <hr />
                  <div class="d-grid gap-2">
                    <input class="btn btn-primary" type="button" onclick="verifyForm()" value="Save"></input>
                    <input class="btn btn-outline-secondary" type="button" onclick="location.href='vault.php';" value="Cancel"></input>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section>
      <div class="pt-3 mt-3">
        <p class="text-center text-muted fs-6">© 2023 VaultMate Inc.</p>
      </div>
    </section>
    <script>
      function password_show_hide() {
        var x = document.getElementById("password");
        var show_eye = document.getElementById("show_eye");
        var hide_eye = document.getElementById("hide_eye");
        hide_eye.classList.remove("d-none");
        if (x.type === "password") {
          x.type = "text";
          show_eye.style.display = "none";
          hide_eye.style.display = "block";
        } else {
          x.type = "password";
          show_eye.style.display = "block";
          hide_eye.style.display = "none";
        }
      }
      function unhighlight(x) {
        x.style.backgroundColor = "transparent";
      }

      function highlight(x) {
        x.style.backgroundColor = "#eeeee4";
      }
    </script>
    </body>
</html>
