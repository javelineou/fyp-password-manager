<?php
    // Include config file to start db
    include ("config.php");

    // Initialize the session
    session_start();

    // Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        
        //Check if captcha is filled or not
        if(empty($_POST['g-recaptcha-response'])){
            ?>
            <script type="text/javascript">
            alert("Please solve the captcha!");
            window.location.href = "login.php";
            </script>
            <?php
        }
        else{
            $secretKey = "6LfuT50fAAAAALg2I-F_8f7B3i4BbrLpJ5gTVNGo";
            $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secretKey . '&response=' . $_POST['g-recaptcha-response']);
            $responseData = json_decode($verifyResponse);

            if ($responseData->success){
                $studentId = $_POST["studentId"];
                $studentId = mysqli_real_escape_string($conn, $studentId);
                $password = md5($_POST["password"]); //Password input converted into md5

                //Validate credentials using prepared statement
                $sql = "SELECT student_id, admin_status, vote_status from student where student_id=? and password=?"; 
                $userStatement = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($userStatement, 'ss', $studentId, $password);
                mysqli_stmt_execute($userStatement);
                $result = mysqli_stmt_get_result($userStatement);


                    if (mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        $_SESSION["student_id"] = $row['student_id'];
                        $_SESSION["admin_status"] = $row['admin_status'];
                        $_SESSION["vote_status"] = $row['vote_status'];
                        $_SESSION["loggedin"] = true;
                            
                        
                        if($_SESSION["admin_status"] == 1){
                            header("Location: admin-homepage.php");
                        }
                        else{
                            header("Location: logged-homepage.php");
                        }
                    }
                    else{
                        ?>
                        <script type="text/javascript">
                        alert("Wrong Student ID and password!");
                        window.location.href = "login.php";
                        </script>
                    <?php
                    }
            }
        } 
    }
?>