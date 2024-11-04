<?php
session_start();

// print_r($_SESSION);
echo  'view cookies anywhere'. $_COOKIE["user"];
setcookie("user" , "" , time() - (60 * 60 * 24 * 30) , "/");





 ?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
 </head>
 <body>

 <?php
 if(isset($_SESSION["favcolor"])){

     echo "Favourite color: " .$_SESSION["favcolor"];
 }
 else{
    echo "No favourite color";
 }

  ?>
    
 </body>
 </html>