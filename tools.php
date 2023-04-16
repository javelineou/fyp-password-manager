<?php
  // Include config file to start db
  include ("config.php");
  // Initialize the session
  session_start();

  // Check if the user is logged in, otherwise redirect to login page
  if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Tools | VaultMate</title>
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <!-- Custom CSS/JS -->
    <link rel="stylesheet" href="style.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="
      https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.js
      "></script>
      <link href="
      https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css
      " rel="stylesheet">


    <!-- reCaptcha script -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  </head>

  <body>
    <script>
      function copied() {
        toastr.options = {
          "closeButton": false,
          "debug": false,
          "newestOnTop": false,
          "progressBar": true,
          "positionClass": "toast-bottom-right",
          "preventDuplicates": false,
          "onclick": null,
          "showDuration": "200",
          "hideDuration": "500",
          "timeOut": "1500",
          "extendedTimeOut": "1000",
          "showEasing": "swing",
          "hideEasing": "swing",
          "showMethod": "fadeIn",
          "hideMethod": "fadeOut"
        };

        toastr.success("", "Copied");
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
              <a class="nav-link link-light fw-bold text-white-50" href="vault.php">My Vault</a>
            </li>
            <li class="nav-item">
              <a class="nav-link link-light fw-bold" href="tools.php">Tools</a>
            </li>
            <li class="nav-item">
              <a class="nav-link link-light fw-bold text-white-50" href="logout.php">Log Out</a>
            </li>
          </ul>
        </div>
      </nav>
    </section>
    <section>
      <div class="container">
        <div class="row mt-3">
          <div class="col-1"></div>
          <div class="col-7">
            <p class="fs-4">Password Generator</p>
            <hr />
            <div class="card">
              <div class="card-body text-center">
                <div class="result">
                  <div id="result">
                    oI9nU1gA2hR2oU7y
                  </div>
                </div>
              </div>
            </div>
            <div class="settings mt-3">
              <label class="fw-semibold">Length:</label>
              <input
                class="mb-3"
                type="number"
                id="length"
                name="length"
                min="12"
                max="128"
                value="16"
              />
              <p class="fw-semibold">Options</p>
              <input type="checkbox" id="uppercase" checked />
              <label for="uppercase">Include Uppercase</label><br />
              <input type="checkbox" id="lowercase" checked />
              <label for="lowercase">Include Lowercase</label><br />
              <input type="checkbox" id="number" checked />
              <label for="number">Include Numbers</label><br />
              <input type="checkbox" id="symbol" />
              <label for="symbol">Include Symbols</label><br /><br />
            </div>

            <button class="btn btn-primary fw-semibold" id="btn-generatePw" onclick="passGen()">Generate New Password</button>
            <input type="button" class="btn btn-outline-secondary fw-semibold" id="copy" value="Copy password" onclick="copied()">           
            </input>
          </div>
        </div>
      </div>
    </section>
    <section>
      <div class="container mt-5">
        <div class="row mt-3">
          <div class="col-1"></div>
          <div class="col-7">
            <p class="fs-4">Passphrase Generator</p>
            <hr />
            <div class="card">
              <div class="card-body text-center">
                <div>
                  <div id="passphrase">
                    Loading..
                  </div>
                  <p class="crack-time-label fs-13px mt-3"><b>Approximate Crack Time:</b> <span class="crack-time">0 seconds</span></p>
                  </div>
                </div>
            </div>
            <div class="passphrase-options text-center">
              <select class="form-select mt-3" id="passphrase_select">
                <option value="4" selected>Four-word passphrase, with spaces</option>
                <option value="5">Five-word passphrase, with spaces</option>
                <option value="12">Twelve-word passphrase, with spaces</option>
              </select>
              <button class="btn btn-primary mt-3 fw-semibold" id="btn-generatePp" onclick="passphraseGen()">Generate New Passphrase</button>
              <input type="button" class="btn btn-outline-secondary fw-semibold mt-3" id="copy2" value="Copy passphrase">
            </div>
          </div>
        </div>
      </div>
    </section>
    <section>
      <div class="pt-3 mt-5">
        <p class="text-center text-muted fs-6">© 2023 VaultMate Inc.</p>
      </div>
    </section>
    <script src="js/zxcvbn.js"></script>
    <script src="js/wordlist.js"></script>
    <script src="js/passphrase.js"></script>
    <script src="js/passgen.js"></script>
  </body>
</html>
