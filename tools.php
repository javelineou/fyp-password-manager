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
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css"
    />
    <!-- Custom CSS/JS -->
    <link rel="stylesheet" href="style.css" />

    <!-- reCaptcha script -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  </head>

  <body>
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
                  <div class="result__viewbox" id="result">
                    oI9nU1gA2hR2oU7y
                  </div>
                </div>
              </div>
            </div>
            <div class="settings">
              <p class="fw-semibold">Length</p>
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

            <button class="btn btn-primary fw-semibold" id="generate">
              Generate
            </button>
            <button class="btn btn-outline-secondary fw-semibold" id="copy">
              Copy password
            </button>
            <script src="js/passgen.js"></script>
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
          </div>
        </div>
      </div>
    </section>
  </body>
</html>
