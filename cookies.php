<!-- //Actually is the method to save the user info in it;s laptop like browser info , screen size, location or etc and later on you can retrieve it later 
it is the way to identify the user => like you have seen that when we click on the remember me check box , the info go to session then it generate the id and store it in the  cookie even , you can also store the actions taken by user
 1) create cookies
 setcookie(name , value, expire, path(retrieve on this page) , domian , secure(true / false) , httponly());
 name => cookie name
 expire => when cookies expire
 path => websites pages path where you can retrieve data
 domain => domain or sub domain
 secure => true (secure) , false ( both seciure and not secure)
 httponly => server side access only like python , php  or client side like js

 2) View Cooie Value
 $_COOKIE[name]; -->
 <?php
 $cookie_name = "user";
 $cookie_value = "Ayesha";

 setcookie($cookie_name , $cookie_value , time() + (60 * 60 * 24 * 30) , "/");
 
 
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
    if(!isset($_COOKIE[$cookie_name])){
        echo "cookie is not set";
    }
    else{
        
        echo $_COOKIE[$cookie_name];
    }
    ?>;
    
 </body>
 </html>


                                  