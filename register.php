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
    <title>Create Account | VaultMate</title>
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
    <!-- Custom CSS/JS -->
    <link rel="stylesheet" href="style.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- reCaptcha script -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  </head>

  <body>
  <script>
      function verifyPassword() {
        //Validating form requirements
        var pw1 = document.forms["registerForm"]["password"].value;
        var pw2 = document.forms["registerForm"]["repassword"].value;
        var length = pw1.length;
                
        if(length < 12){
          Swal.fire({
            icon: 'error',
            title: 'Invalid',
            text: 'Password must be at least 12 characters',
            confirmButtonText: 'Ok',
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = "register.php";
            }
          })
        }

        if (pw1 != pw2) {
          Swal.fire({
            icon: 'error',
            title: 'Invalid',
            text: 'Password did not match',
            confirmButtonText: 'Ok',
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = "register.php";
            }
          })
        }
        
        //bikin kalo nama/email ga diisi

        if(pw1 == pw2 && length >= 12){
          document.getElementById("registerForm").submit();
        }
        
      }
    </script>
    <section>
      <div class="container mt-2 pt-3 text-center">
        <p class="fs-4 fw-light">Create Account</p>
      </div>
    </section>
    <section>
      <div class="container mt-2 pt-3">
        <div class="row">
          <div class="col-12 col-sm-7 col-md-5 m-auto">
            <div class="card border-1 rounded-3">
              <div class="card-body">
                <form id="registerForm" name="registerForm" action="register-action.php" method="POST">
                  <p class="fw-semibold reg-title">Email Address</p>
                  <input
                    type="email"
                    name="email"
                    id="email"
                    class="form-control my-4 py-2"
                    placeholder="You'll use your email address to log in."
                    required
                  />
                  <p class="fw-semibold reg-title">Name</p>
                  <input
                    type="text"
                    name="name"
                    id="name"
                    class="form-control my-4 py-2"
                    placeholder="What should we call you?"
                    required
                  />
                  <p class="fw-semibold reg-title">Master Password</p>
                  <input
                    type="password"
                    name="password"
                    id="password"
                    class="form-control my-4 py-2"
                    required
                  />
                  <p class="text-muted fs-14px reg-note">
                    <b>Important:</b> Master passwords cannot be recovered if
                    you forget it!
                  </p>
                  <p class="fw-semibold reg-title">Re-type Master Password</p>
                  <input
                    type="password"
                    name="repassword"
                    id="repassword"
                    class="form-control my-4 py-2"
                    required
                  />
                  <input type="checkbox" id="tnc" name="tnc" value="tnc" />
                  <label class="fs-14px" for="tnc"
                    >By checking this box you agree the
                    <a class="text-decoration-none" href="#"
                      >Terms of Service & Privacy Policy</a
                    ></label
                  >
                  <hr />
                  <div class="d-grid gap-2">
                    <input class="btn btn-primary" type="button" onclick="verifyPassword()" value="Create account"></input>
                    <a href="login.html" class="btn btn-secondary" type="button">
                      <i class="bi bi-box-arrow-in-right"></i> Log In 
                    </a>
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
  </body>
</html>
