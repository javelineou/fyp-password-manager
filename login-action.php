<?php
    // Include config file to start db
    include ("config.php");

    // Initialize the session
    session_start();
    
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
    <link rel="icon" href="img/logo-icon.svg" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <?php

    // Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        
        
            $secretKey = "6LfuT50fAAAAALg2I-F_8f7B3i4BbrLpJ5gTVNGo";
            $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secretKey . '&response=' . $_POST['g-recaptcha-response']);
            $responseData = json_decode($verifyResponse);

            if ($responseData->success){
                $email = $_POST["email"];
                $mpassword = md5($_POST["mpassword"]); //Password input converted into md5

                //Validate credentials using prepared statement
                $sql = "SELECT email, name, mpassword from user where email=? and mpassword=?"; 
                $userStatement = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($userStatement, 'ss', $email, $mpassword);
                mysqli_stmt_execute($userStatement);
                $result = mysqli_stmt_get_result($userStatement);


                    if (mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        $_SESSION["email"] = $row['email'];
                        $_SESSION["name"] = $row['name'];
                        $_SESSION["loggedin"] = true;

                        header("Location: vault.php");
                    }
                    else{
                        ?>
                        <script type="text/javascript">
                        Swal.fire({
                            icon: 'error',
                            title: 'Invalid',
                            text: 'Username or password is incorrect. Try again.',
                            confirmButtonText: 'Ok',
                        }).then((result) => {
                            if (result.isConfirmed) {
                            window.location.href = "login.php";
                            }
                        })
                        </script>
                    <?php
                    }
            }
        } 
?>