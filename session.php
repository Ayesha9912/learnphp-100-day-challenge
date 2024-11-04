<!-- what is session
when user login to our website so we store it's data in server temporary
later when he logout the info get lost
the session atore has been i created in the sever -->

<!-- Steps to set $ get Session Value -->
<!-- three steps -->



<!-- 1=> session_start()
2=> $_SESSION[name] = Value //this name represents the session id
3=> echo $_SESSION[name];

//DELETE Session
step 1 => session_unset();
step 1 => session_destroy(); -->


<?php
   session_start();
   $_SESSION["favcolor"] = "orange";
   echo "session variable is set";

 ?>

 <!-- //project login  -->







