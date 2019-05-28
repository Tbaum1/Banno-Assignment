<?php 
  /*
    This program gathers the html from the Banno website then pulls out information to determine
      ● A count of the number of products offered. 
      ● The top 3 occuring alphanumeric characters contained in the HTML, and how many times each occurs. 
      ● The top 3 occuring alphabetic character contained in the HTML, and how many times each occurs. 
      ● The number of .png images in the HTML. 
      ● BannoJHA’s Twitter handle: this should work if the Twitter name were to change. 
      ● The number of times the term “financial institution” occurs in text.
      ● The number of times the word “Banno” occurs in text.
  */

  $bannoHTML = file_get_contents("https://banno.com/index.html");  //gets the HTML for the Banno site
  $productsHTML = file_get_contents("https://banno.com/features/index.html");  //gets the HTML for the Products page
  $strings = preg_split('/$\R?^/m', $bannoHTML); //splits using regex
  $twitterHandle;  //twitter handle variable

  //Counts the number of png images in the array
  function countPNGImage($strings){
    $imgCount = 0;
    //iterates through the $strings variable and looks for .png files then adds 1 to the $imgCount for each
    foreach ($strings as $image) {
      if (preg_match('/.png/', $image)) {
        $imgCount += 1;
      }
    }

  echo "\nThe number of .png images on the website is " . $imgCount . ".";  //display in terminal how many .png images found
  }

  //counts the number of products Banno offers
  function countProducts($productsHTML){
    $numberOfProducts = 0; 
    $products = preg_split('/$\R?^/m', $productsHTML);  //splits using regex    
     
    //iterates through the $products_array and then adds 1 to the $numberOfProducts for each &trade found
    foreach ($products as $product) {
      if (preg_match('/&trade;/', $product)) {
        $numberOfProducts += 1;
      }
    }    
    echo "Banno has " . $numberOfProducts  . " different products.";  //display how many products Banno offers
  }  

  //counts the 3 most common letters
  function countLetters($bannoHTML){    
    $letters = array(); //array to hold the top 3 characters
    $stringlength = strlen($bannoHTML);  //find string length
    
    for ($i = 0; $i < $stringlength; $i++) {
      $letter = $bannoHTML[$i];
      //check for alphabetic character(s)
      if (ctype_alpha($letter)) {       
        if (array_key_exists($letter, $letters)) {
          $letters[$letter] += 1; //if true add one to the count
        }
        else {
          $letters[$letter] = 1; //if false add to the array
        }
      }
    }

    arsort($letters);  //sort an array and maintain index association

    for ($i = 0; $i < 3; $i++){
      echo "\nThe top " . ($i+1) . " letter " . array_keys($letters)[$i] . " appears " . array_values($letters)[$i] . " times.";  //displays top 3 letters on the website
    }
  }  

  //counts the 3 most common alphanumeric characters
  function countAlphanumericChars($bannoHTML){    
    $characters = array(); //array to hold the top 3 characters
    $stringlen = strlen($bannoHTML);  //gets the string length of the $bannoHTML

    for ($i = 0; $i < $stringlen; $i++) {
      $char = $bannoHTML[$i];  //adds alphanumeric chars to $char

      //check for alphanumeric character(s)
      if (ctype_alnum($char)) {    
        //checks to see if the character is in the characters array   
        if (array_key_exists($char, $characters)) {
          $characters[$char] += 1; //if true add one to the count
        }
        else {
          $characters[$char] = 1; //if false add to the array
        }
      }
    }
    
    arsort($characters);  //sort an array and maintain index association
    for ($i = 0; $i < 3; $i++){
      echo "\nThe top " . ($i+1) . " alphanumeric character " . array_keys($characters)[$i] . 
      " appears " . array_values($characters)[$i] . " times.";  //displays top 3 alphanumeric chars on website
    }
  }

  //finds the twitter handle for Banno
  function FindTwitterHandle($strings){
    //iterates through $strings array looking for twitter handle
    foreach ($strings as $line) {
      if (preg_match('/twitter.*@/', $line)) {
        $twitterHandle = substr($line, strpos($line, '@'));
        $twitterHandle = substr($twitterHandle, 0, strpos($twitterHandle, '"'));
        echo "\nBanno's twitter handle is " . $twitterHandle . ".\n";    //display the twitter handle for Banno
      }
    }
  }
  
  //uses funtion preg_match_all to find the words "finanical institution"
  function countFinancialInstitution($bannoHTML){    
    $termCount = preg_match_all("/financial institution/", $bannoHTML);
    echo "\nThe words financial institution appears " . $termCount . ' times.';  //display how many times the words "finicial institution" shows up on website
  }

  //uses funtion preg_match_all to find the words "finanical institution"
  function countBanno($bannoHTML){    
    $termCount = preg_match_all("/Banno.*/", $bannoHTML);
    echo "\nThe word Banno appears " . $termCount . ' times.';  //display how many times the words "finicial institution" shows up on website
  }

  countProducts($productsHTML);  //calls countProduct function
  countLetters($bannoHTML);  //calls countLetters function
  countAlphanumericChars($bannoHTML);  //calls countAlphanumericChars function
  countPNGImage($strings);  //calls countPNGImage function
  countFinancialInstitution($bannoHTML);  //calls countFinancialInstitution function
  countBanno($bannoHTML);  //calls countBanno function
  FindTwitterHandle($strings);  //calls FindTwitterHandle fucntion
  
 ?>
