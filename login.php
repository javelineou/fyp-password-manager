<?php
session_start();

// Check if the user is already logged in, then go dashboard
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  header("location: vault.php");
  exit;
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Login | VaultMate</title>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 

    <!-- reCaptcha script -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  </head>

  <body>
  <script>
      function verifyForm() {
        //Validating form requirements
        var email = document.forms["loginForm"]["email"].value;
        var mpassword = document.forms["loginForm"]["mpassword"].value;
        var gresponse = grecaptcha.getResponse();
                
        if(email == "" || mpassword == ""){
          Swal.fire({
            icon: 'error',
            title: 'Invalid',
            text: 'Email or password can not be blank',
            confirmButtonText: 'Ok',
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = "login.php";
            }
          })
        }

        if(gresponse == ""){
          Swal.fire({
            icon: 'error',
            title: 'Invalid',
            text: 'Please solve reCAPTCHA',
            confirmButtonText: 'Ok',
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = "login.php";
            }
          })
        }


        if(email != "" && mpassword != "" && gresponse != ""){
          document.getElementById("loginForm").submit();
        }
        
      }
    </script>
    <section>
      <div class="container mt-4 pt-3 text-center">
        <img src="img/logovault.png" />
        <p class="fs-4 fw-light">
          Log in or create a new account to access your secure vault
        </p>
      </div>
    </section>
    <section>
      <div class="container mt-2 pt-5">
        <div class="row">
          <div class="col-6 col-sm-8 col-md-4 m-auto">
          <img src="img/login_img.webp" class="img-fluid" alt="Login image">
          </div>
          <div class="col-6 col-sm-8 col-md-4 m-auto">
            <div class="card border-1 rounded-3">
              <div class="card-body">
                <form id="loginForm" name="loginForm" action="login-action.php" method="POST">

                  <label for="email" class="form-label fw-semibold">Email Address</label>
                  <div class="input-group mb-3">
                    <span class="input-group-text"><i class="bi bi-person-circle"></i></span>
                    <input
                      type="email"
                      name="email"
                      id="email"
                      class="form-control py-2"
                    />
                  </div>

                  <label for="mpassword" class="form-label fw-semibold">Master Password</label>
                  <div class="input-group mb-3">
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                    <input
                      type="password"
                      name="mpassword"
                      id="mpassword"
                      class="form-control py-2"
                    />
                    <span onmouseover="highlight(this)" onmouseout="unhighlight(this)" class="input-group-text" onclick="password_show_hide();">
                        <i class="bi bi-eye" id="show_eye"></i>
                        <i class="bi bi-eye-slash d-none" id="hide_eye"></i>
                    </span>
                  </div>

                  <div class="d-grid gap-2">
                    <div
                      class="g-recaptcha"
                      data-sitekey="6LfuT50fAAAAAPkUxAYUgDIV_SXZo5AQEmNkPwDL"
                    ></div>
                    <hr />
                    <input class="btn btn-primary shadow-sm" type="button" onclick="verifyForm()" value="Login"></input>
                    <p class="fs-14px">
                      New around here?
                      <a href="register.php" class="text-decoration-none"
                        >Create account</a
                      >
                    </p>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section>
      <div class="pt-5 mt-4">
        <p class="text-center text-muted fs-6">© 2023 VaultMate Inc.</p>
      </div>
    </section>
    <script>
      function password_show_hide() {
        var x = document.getElementById("mpassword");
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
