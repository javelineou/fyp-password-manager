<?php
  include ("config.php");

  ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="img/logo-icon.svg" />
    </head>

<?php
if (isset($_POST['password_id'])) {
    $password_id = $_POST['password_id'];
    $delete_query = "DELETE FROM passwords WHERE password_id = $password_id";
    $result = mysqli_query($conn, $delete_query);
    if (!$result) {
        echo "Error deleting item: " . mysqli_error($conn);
    }
}
?>
