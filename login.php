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
    <!-- Bootstrap Icon Lib-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css"
    />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css" />
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
          <div class="col-12 col-sm-8 col-md-4 m-auto">
            <div class="card border-1 rounded-3">
              <div class="card-body">
                <form id="loginForm" name="loginForm" action="login-action.php" method="POST">
                  <p class="fw-semibold reg-title">Email Address</p>
                  <input
                    type="email"
                    name="email"
                    id="email"
                    class="form-control my-4 py-2"
                    required
                  />
                  <p class="fw-semibold reg-title">Master Password</p>
                  <input
                    type="password"
                    name="mpassword"
                    id="mpassword"
                    class="form-control my-4 py-2"
                    required
                  />
                  <div class="d-grid gap-2">
                    <div
                      class="g-recaptcha"
                      data-sitekey="6LfuT50fAAAAAPkUxAYUgDIV_SXZo5AQEmNkPwDL"
                    ></div>
                    <hr />
                    <input class="btn btn-primary" type="button" onclick="verifyForm()" value="Login"></input>
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
  </body>
</html>
