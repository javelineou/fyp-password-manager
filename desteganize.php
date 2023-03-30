<?php

    function desteganize($file) {
        // Read the file into memory.
        $img = imagecreatefrompng($file);
      
        // Read the message dimensions.
        $width = imagesx($img);
        $height = imagesy($img);
      
        // Set the message.
        $binaryMessage = '';
      
        // Initialise message buffer.
        $binaryMessageCharacterParts = [];
      
        for ($y = 0; $y < $height; $y++) {
          for ($x = 0; $x < $width; $x++) {
      
            // Extract the colour.
            $rgb = imagecolorat($img, $x, $y);
            $colors = imagecolorsforindex($img, $rgb);
      
            $blue = $colors['blue'];
      
            // Convert the blue to binary.
            $binaryBlue = decbin($blue);
      
            // Extract the least significant bit into out message buffer..
            $binaryMessageCharacterParts[] = $binaryBlue[strlen($binaryBlue) - 1];
      
            if (count($binaryMessageCharacterParts) == 8) {
              // If we have 8 parts to the message buffer we can update the message string.
              $binaryCharacter = implode('', $binaryMessageCharacterParts);
              $binaryMessageCharacterParts = [];
              if ($binaryCharacter == '00000011') {
                // If the 'end of text' character is found then stop looking for the message.
                break 2;
              }
              else {
                // Append the character we found into the message.
                $binaryMessage .= $binaryCharacter;
              }
            }
          }
        }
      
        // Convert the binary message we have found into text.
        $message = '';
        for ($i = 0; $i < strlen($binaryMessage); $i += 8) {
          $character = mb_substr($binaryMessage, $i, 8);
          $message .= chr(bindec($character));
        }
      
        return $message;
      }
?>