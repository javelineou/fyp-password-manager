<?php
    // Include config file to start db
    include_once("config.php");

    // Initialize the session
    session_start();

    function steganize($file, $message, $conn) {
        // Encode the message into a binary string.
        $binaryMessage = '';
        for ($i = 0; $i < mb_strlen($message); ++$i) {
          $character = ord($message[$i]);
          $binaryMessage .= str_pad(decbin($character), 8, '0', STR_PAD_LEFT);
        }
      
        // Inject the 'end of text' character into the string.
        $binaryMessage .= '00000011';
      
        // Load the image into memory.
        $img = imagecreatefromjpeg($file);
      
        // Get image dimensions.
        $width = imagesx($img);
        $height = imagesy($img);
      
        $messagePosition = 0;
      
        for ($y = 0; $y < $height; $y++) {
          for ($x = 0; $x < $width; $x++) {
      
            if (!isset($binaryMessage[$messagePosition])) {
              // No need to keep processing beyond the end of the message.
              break 2;
            }
      
            // Extract the colour.
            $rgb = imagecolorat($img, $x, $y);
            $colors = imagecolorsforindex($img, $rgb);
      
            $red = $colors['red'];
            $green = $colors['green'];
            $blue = $colors['blue'];
            $alpha = $colors['alpha'];
      
            // Convert the blue to binary.
            $binaryBlue = str_pad(decbin($blue), 8, '0', STR_PAD_LEFT);
      
            // Replace the final bit of the blue colour with our message.
            $binaryBlue[strlen($binaryBlue) - 1] = $binaryMessage[$messagePosition];
            $newBlue = bindec($binaryBlue);
      
            // Inject that new colour back into the image.
            $newColor = imagecolorallocatealpha($img, $red, $green, $newBlue, $alpha);
            imagesetpixel($img, $x, $y, $newColor);
      
            // Advance message position.
            $messagePosition++;
          }
        }
      
        // Save the image to a file.
        $query = "SELECT * FROM counter";
        $data = mysqli_query($conn, $query);

        if(mysqli_num_rows($data) > 0){
          $row = mysqli_fetch_assoc($data);
          $num = $row['counter_num'];

          $newImage = 'stego' . $num . '.png';
          imagepng($img, $newImage, 9);

          $image_data = file_get_contents('stego' . $num . '.png');
          $image_data = mysqli_real_escape_string($conn, $image_data);
          
          //Store to DB
          if($num % 2 == 1){
            $query2 = "INSERT INTO img_one (img) VALUE ('$image_data')";
            if (mysqli_query($conn, $query2)) {
              //echo "Image inserted successfully";
              unlink("stego" . $num . ".png");
            } else {
              echo "Error: " . mysqli_error($conn);
            }
            
          }
          else{
            $query3 = "INSERT INTO img_two (img) VALUE ('$image_data')";
            if (mysqli_query($conn, $query3)) {
              //echo "Image inserted successfully";
              unlink("stego" . $num . ".png");
            } else {
              echo "Error: " . mysqli_error($conn);
            }
          }
      
          // Destroy the image handler.
          imagedestroy($img);

          $query4 = "UPDATE counter SET counter_num = counter_num + 1";
          mysqli_query($conn, $query4);

      }
      else{
        echo "ERROR: DB Error! Sorry $query. "
          . mysqli_error($conn);
      }
    }

        
?>