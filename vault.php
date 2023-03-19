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
    <!-- Bootstrap Icon Lib-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css"
    />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css" />

    <!-- reCaptcha script -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  </head>

  <body>
    <section>
      <nav class="navbar navbar-light bg-bitwarden">
        <div class="container-fluid ms-navbar-left">
          <a class="navbar-brand" href="#">
            <img
              src="img/logo-icon.svg"
              width="45"
              height="45"
              alt="logo-icon"
            />
          </a>

          <ul class="nav me-auto">
            <li class="nav-item">
              <a class="nav-link link-light fw-bold" href="#">My Vault</a>
            </li>
            <li class="nav-item">
              <a class="nav-link link-light fw-bold text-white-50" href="#"
                >Tools</a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link link-light fw-bold text-white-50" href="logout.php"
                >Log Out</a
              >
            </li>
          </ul>
        </div>
      </nav>
    </section>
    <section>
      <div class="container">
        <div class="row mt-3">
          <div class="col-1"></div>
          <div class="col-3">
            <div class="card">
              <div class="card-header">
                <p class="fs-6 fw-bold">
                  FILTERS
                  <button
                    type="submit"
                    class="btn btn-primary btn-sm float-end"
                  >
                    Search
                  </button>
                </p>
              </div>
              <div class="card-body">
                <p class="fs-6 fw-semibold">Items Category</p>
                <hr />
                <?php
                  $query = "SELECT * FROM category";
                  $data = mysqli_query($conn, $query);
                  
                  if(mysqli_num_rows($data) > 0){
                    foreach($data as $category_list){
                      ?>
                        <div>
                          <input type="checkbox" name="categories[]" value="<? = $category_list['category_id']; ?>">
                          <?= $category_list['category_icon']; ?>
                          <?= $category_list['category_name']; ?>
                        </div>
                      <?php
                    }
                  }
                  else{

                  }

                ?>
              </div>
            </div>
          </div>
          <div class="col-3">All Vaults</div>
          <div class="col-5">Empty Space</div>
        </div>
      </div>
    </section>
  </body>
</html>
