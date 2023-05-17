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
        var pw1 = document.forms["registerForm"]["password"].value;
        var pw2 = document.forms["registerForm"]["repassword"].value;
        var email = document.forms["registerForm"]["email"].value;
        var name = document.forms["registerForm"]["name"].value;
        const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=[\]{};':"\\|,.<>/?]).{15,}$/;
                
        if (pw1.length <= 15 || !regex.test(pw1)){
          Swal.fire({
            icon: 'error',
            title: 'Invalid',
            text: 'Password is too weak! Password must be at least 15 characters and include uppercase, lowercase, numeric, special characters.',
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
        
        if (email == "" || name == "" || pw1 == "" || pw2 == ""){
          Swal.fire({
            icon: 'error',
            title: 'Invalid',
            text: 'Please input your data completely',
            confirmButtonText: 'Ok',
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = "register.php";
            }
          })
        }

        if (pw1 == pw2 && pw1.length > 15 && email != "" && name != "" && regex.test(pw1)){
          document.getElementById("registerForm").submit();
        }
      }
    </script>
    <section>
      <div class="container mt-1 pt-5 text-center">
      </div>
    </section>
    <section>
      <div class="container mt-2 pt-3">
        <div class="row">
          <div class="col-6 col-sm-7 col-md-5 m-auto">
            <img src="img/vault_icon.png" class="img-fluid" alt="Register image">
            <div class="ps-5">
              <p class="fs-2 fw-semibold">Join Us</p>
              <p class="fs-5">Password Manager Application with Multi-layer Security</p>
              <p class="fs-6">Developed by Adrianus Tristan</p>
              <button type="button" class="btn btn-outline-dark rounded-3">About us</button>
            </div>
          </div>
          <div class="col-6 col-sm-7 col-md-5 m-auto">
            <div class="card border-1 rounded-3">
              <div class="card-body">
                <form id="registerForm" name="registerForm" action="register-action.php" method="POST">
                  <label for="email" class="form-label fw-semibold">Email Address</label>
                  <div class="input-group mb-3">
                    <input
                      type="email"
                      name="email"
                      id="email"
                      class="form-control py-2"
                      placeholder="You'll use your email address to log in."
                      required
                    />
                  </div>

                  <label for="name" class="form-label fw-semibold">Name</label>
                  <div class="input-group mb-3">
                    <input
                      type="text"
                      name="name"
                      id="name"
                      class="form-control py-2"
                      placeholder="What should we call you?"
                      required
                    />
                  </div>

                  <label for="password" class="form-label fw-semibold">Master Password</label>
                  <div class="input-group mb-4">
                    <input
                      type="password"
                      name="password"
                      id="password"
                      class="form-control py-2"
                      required
                    />
                    <span onmouseover="highlight(this)" onmouseout="unhighlight(this)" class="input-group-text" onclick="password_show_hide_pass();">
                        <i class="bi bi-eye" id="show_eye"></i>
                        <i class="bi bi-eye-slash d-none" id="hide_eye"></i>
                    </span>
                  </div>
                  <div class="reg-note">
                    <p class="text-muted fs-14px"><b>Important:</b> Master passwords cannot be recovered if you forget it!</p>
                  </div>
                  <div class="password-meter-wrap mb-2">
                    <div class="password-meter-bar"></div>
                  </div>
                  
                  <label for="repassword" class="form-label fw-semibold">Re-type Master Password</label>
                  <div class="input-group mb-3">
                    <input
                      type="password"
                      name="repassword"
                      id="repassword"
                      class="form-control py-2"
                      required
                    />
                    <span onmouseover="highlight(this)" onmouseout="unhighlight(this)" class="input-group-text" onclick="password_show_hide_repass();">
                        <i class="bi bi-eye" id="show_eye_repass"></i>
                        <i class="bi bi-eye-slash d-none" id="hide_eye_repass"></i>
                    </span>
                  </div>

                  <input type="checkbox" id="tnc" name="tnc" value="tnc" />
                  <label class="fs-14px" for="tnc">
                    By checking this box you agree the
                    <a class="text-decoration-none" href="#">Terms of Service & Privacy Policy</a>
                  </label>
                  <hr />
                  <div class="d-grid gap-2">
                    <input class="btn btn-primary" type="button" onclick="verifyForm()" value="Create account"></input>
                    <a href="login.php" class="btn btn-secondary" type="button">
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
    <script>
      function password_show_hide_pass() {
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

      function password_show_hide_repass() {
        var y = document.getElementById("repassword");
        var show_eye_repass = document.getElementById("show_eye_repass");
        var hide_eye_repass = document.getElementById("hide_eye_repass");
        hide_eye_repass.classList.remove("d-none");
        if (y.type === "password") {
          y.type = "text";
          show_eye_repass.style.display = "none";
          hide_eye_repass.style.display = "block";
        } else {
          y.type = "password";
          show_eye_repass.style.display = "block";
          hide_eye_repass.style.display = "none";
        }
      }

      function unhighlight(x) {
        x.style.backgroundColor = "transparent";
      }

      function highlight(x) {
        x.style.backgroundColor = "#eeeee4";
      }
    </script>
    <script src="js/zxcvbn.js"></script>
    <script src="js/passBar.js"></script>
  </body>
</html>
