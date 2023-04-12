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
    <title>Add New Item | VaultMate</title>
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
        var title = document.forms["newitemForm"]["title"].value;
        var username = document.forms["newitemForm"]["username"].value;
        var password = document.forms["newitemForm"]["password"].value;
        var notes = document.forms["newitemForm"]["notes"].value;
        
        if (title == "" || username == "" || password == ""){
          Swal.fire({
            icon: 'error',
            title: 'Invalid',
            text: 'Please input your data completely',
            confirmButtonText: 'Ok',
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = "newitem.php";
            }
          })
        }
        else{
          document.getElementById("newitemForm").submit();
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
              <a class="nav-link link-light fw-bold text-white-50" href="vault.php">My Vault</a>
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
            <p class="fs-4 fw-light">Add New Item</p>
        </div>
    </section>
    <section>
      <div class="container mt-2 pt-3">
        <div class="row">
          <div class="col-12 col-sm-6 col-md-6 m-auto">
            <div class="card border-1 rounded-3">
              <div class="card-body">
                <form id="newitemForm" name="newitemForm" action="newitem-action.php" method="POST">
                  <label for="categories" class="fw-semibold reg-title">What type of item is this?</label>
                  <select class="form-select mb-4 mt-2" aria-label="Default select example" name="categories" id="categories">
                    <option value="1" selected>Email</option>
                    <option value="2">Social Media</option>
                    <option value="3">Game & Entertainment</option>
                    <option value="4">Finance</option>
                  </select>

                  <p class="fw-semibold reg-title">Title</p>
                  <input
                    type="text"
                    name="title"
                    id="title"
                    class="form-control my-4 py-2"
                    required
                  />
                  <p class="fw-semibold reg-title">Username</p>
                  <input
                    type="text"
                    name="username"
                    id="username"
                    class="form-control my-4 py-2"
                    required
                  />
                  <p class="fw-semibold reg-title">Password</p>
                  <input
                    type="password"
                    name="password"
                    id="password"
                    class="form-control my-4 py-2"
                    required
                  />
                  <label for="notes" class="fw-semibold reg-title"> Notes</label>
                  <textarea class="form-control" placeholder="Leave an additional notes here" name="notes" id="notes" style="height: 100px"></textarea>
                  
                  <hr />
                  <div class="d-grid gap-2">
                    <input class="btn btn-primary" type="button" onclick="verifyForm()" value="Save"></input>
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