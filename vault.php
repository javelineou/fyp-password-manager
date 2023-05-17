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
    <title>Vaults | VaultMate</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="img/logo-icon.svg" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    
    <!-- Custom CSS/JS -->
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
      <div class="container">
        <div class="row mt-3">
          <div class="col-1"></div>
          <!-- Category List -->
          <div class="col-3">
            <form action="" method="GET" id="filter-form">
              <div class="card">
                <div class="card-header">     
                    <h5 class="card-title mb-0">Filters</h5>
                </div>
                <div class="card-body">
                  <p class="fs-6 fw-semibold">Items Category</p>
                  <?php
                    $category_query = "SELECT * FROM category";
                    $category_data = mysqli_query($conn, $category_query);

                    if(mysqli_num_rows($category_data) > 0){
                        foreach($category_data as $category_list){

                            $checked = [];
                            if(isset($_GET['categories'])){
                                $checked = ($_GET['categories']);
                            }

                            ?>
                            <div>
                                <input type="radio" id="category<?= $category_list['category_id']; ?>" name="categories[]" value="<?= $category_list['category_id']; ?>"
                                  <?php if(in_array($category_list['category_id'], $checked)){echo "checked";} ?>
                                  class="filter-radio"
                                />
                                <label for="category<?= $category_list['category_id']; ?>" class="filter-label"><?= $category_list['category_name']; ?></label>
                            </div>
                            <?php
                        }
                        ?>
                        <input type="button" href="vault.php" class="btn btn-primary btn-sm float-start fw-medium mt-3" value="Clear Filters" onclick="location.href='vault.php';"></input>
                        <?php
                    }
                    else{
                        echo "<p>No categories found</p>";
                    }
                  ?>
                </div>
              </div>
            </form>
          </div>
          <!-- Item List -->
          <div class="col-5">
            <p class="fs-3 fw-normal">All Vaults  
              <a href="newitem.php" class="btn btn-primary btn-sm float-end fw-medium">+ New Item</a>
            </p>
                      
            <?php
            if(isset($_GET['categories'])){
              $category_checked = [];
              $category_checked = $_GET['categories'];
              foreach($category_checked as $rowcategory){
                $item_query = "SELECT * FROM passwords WHERE user_id = " . $_SESSION["user_id"] . " AND category_id IN ($rowcategory)";
                $item_data = mysqli_query($conn, $item_query);

                if(mysqli_num_rows($item_data) > 0){
                  foreach($item_data as $item_list) :
                    ?>
                      <div class="row">
                        <div class="col-1">
                          <?php
                          $icon_query = "SELECT category_icon FROM category WHERE category_id = " . $item_list['category_id'];
                          $icon_data = mysqli_query($conn, $icon_query);
                          $row = mysqli_fetch_assoc($icon_data);
                          echo $row['category_icon'];
                          ?>
                                            
                        </div>
                        <div class="col-10">
                        <a href="password-info.php?password_id=<?php echo $item_list['password_id']; ?>" class="item-link text-decoration-none fw-semibold"><?php echo $item_list['title']; ?></a>
                        <p class="text-muted fs-14px"><?= $item_list['username']; ?></p>
                        </div>
                        <div class="col-1">
                        <?php
                          if (isset($_POST['delete_btn_filter'])) {
                            $password_id = $_POST['password_id'];
                            $delete_query = "DELETE FROM passwords WHERE password_id = $password_id";
                            
                            if (true) {
                              ?>
                                <script>
                                    Swal.fire({
                                        title: 'Are you sure?',
                                        text: "You won't be able to revert this!",
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#d33',
                                        cancelButtonColor: '#3085d6',
                                        confirmButtonText: 'Yes, delete it!'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            $.ajax({
                                                url: 'delete-password.php',
                                                type: 'POST',
                                                data: {password_id: <?php echo $password_id ?>},
                                                success: function() {
                                                    Swal.fire({
                                                        icon: 'success',
                                                        title: 'Item Deleted',
                                                        text: 'Your item has been deleted',
                                                        showConfirmButton: false,
                                                        timer: 2000
                                                    }).then((timer) => {
                                                        if (timer.dismiss === Swal.DismissReason.timer) {
                                                            window.location.href = "vault.php";
                                                        }
                                                    });
                                                },
                                                error: function(xhr, status, error) {
                                                    console.error(xhr.responseText);
                                                    Swal.fire({
                                                        icon: 'error',
                                                        title: 'Error deleting item',
                                                        text: xhr.responseText,
                                                        showConfirmButton: false,
                                                        timer: 3000
                                                    });
                                                }
                                            });
                                        }
                                    });
                                </script>
                                <?php
                            }
                          }
                        ?>
                        <form action="" method="POST">
                          <input type="hidden" name="password_id" value="<?php echo $item_list['password_id']; ?>">
                          <button type="submit" name="delete_btn_filter" class="btn btn-outline-danger btn-sm opacity-75">
                            <i class="bi bi-trash3"></i>
                          </button>
                        </form>
                      </div>
                        <hr>
                      </div>
                    <?php
                  endforeach;
                }
                
                else{
                  echo "No item found";
                }
              }
            }
            else{
              $item_query = "SELECT * FROM passwords WHERE user_id = " . $_SESSION["user_id"];
              $item_data = mysqli_query($conn, $item_query);

              if(mysqli_num_rows($item_data) > 0){
                foreach($item_data as $item_list) :
                  ?>
                    <div class="row">
                      <div class="col-1">
                        <?php
                        $icon_query = "SELECT category_icon FROM category WHERE category_id = " . $item_list['category_id'];
                        $icon_data = mysqli_query($conn, $icon_query);
                        $row = mysqli_fetch_assoc($icon_data);
                        echo $row['category_icon'];
                        ?>
                                          
                      </div>
                      <div class="col-10">
                        <a href="password-info.php?password_id=<?php echo $item_list['password_id']; ?>" class="item-link text-decoration-none fw-semibold"><?php echo $item_list['title']; ?></a>
                        <p class="text-muted fs-14px"><?= $item_list['username']; ?></p>
                      </div>
                      <div class="col-1">
                        <?php
                          if (isset($_POST['delete_btn'])) {
                            $password_id = $_POST['password_id'];
                            $delete_query = "DELETE FROM passwords WHERE password_id = $password_id";
                            
                            if (true) {
                              ?>
                                <script>
                                    Swal.fire({
                                        title: 'Are you sure?',
                                        text: "You won't be able to revert this!",
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#d33',
                                        cancelButtonColor: '#3085d6',
                                        confirmButtonText: 'Yes, delete it!'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            $.ajax({
                                                url: 'delete-password.php',
                                                type: 'POST',
                                                data: {password_id: <?php echo $password_id ?>},
                                                success: function() {
                                                    Swal.fire({
                                                        icon: 'success',
                                                        title: 'Item Deleted',
                                                        text: 'Your item has been deleted',
                                                        showConfirmButton: false,
                                                        timer: 2000
                                                    }).then((timer) => {
                                                        if (timer.dismiss === Swal.DismissReason.timer) {
                                                            window.location.href = "vault.php";
                                                        }
                                                    });
                                                },
                                                error: function(xhr, status, error) {
                                                    console.error(xhr.responseText);
                                                    Swal.fire({
                                                        icon: 'error',
                                                        title: 'Error deleting item',
                                                        text: xhr.responseText,
                                                        showConfirmButton: false,
                                                        timer: 3000
                                                    });
                                                }
                                            });
                                        }
                                    });
                                </script>
                                <?php
                            }
                          }
                        ?>
                        <form action="" method="POST">
                          <input type="hidden" name="password_id" value="<?php echo $item_list['password_id']; ?>">
                          <button type="submit" name="delete_btn" class="btn btn-outline-danger btn-sm opacity-75">
                            <i class="bi bi-trash3"></i>
                          </button>
                        </form>
                      </div>
                      <hr>
                    </div>
                  <?php
                endforeach;
              }
              
              else{
                echo "No item found";
              }
            }
            ?>
          </div>
          <div class="col-3"></div>
        </div>
      </div>
    </section>
    <script>
      $(document).ready(function() {
        $('.filter-radio').change(function() {
          $('#filter-form').submit();
        });
      });
    </script>
  </body>
</html>
