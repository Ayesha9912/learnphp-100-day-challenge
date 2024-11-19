<?php
include 'components/connect.php';
session_start();
if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};
if(isset($_POST['submit'])){

    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass =  sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);


    $select_users = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
    $select_users->execute([$email , $pass]);
    $row = $select_users->fetch(PDO::FETCH_ASSOC);

    if( $select_users->rowCount() > 0){
        $_SESSION['user_id']  = $row['id'];
        header('location:home.php');
    }else{
        $message[] = 'Invalid email and password';
    }   
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- font Awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
   <!-- Header section starts here -->
<?php include 'components/user_header.php';?>
<!-- Header section ends here -->

<section class="form-container">
    <form action="" method="POST">
        <h3>Login Now!</h3>
        <input type="email" name="email" placeholder="Enter your email" required maxlength="50" class="box">
        <input type="password" name="pass" placeholder="Enter your password" required maxlength="50" class="box">
        <input type="submit" value="Login now" name="submit" class="btn">
        <p>don't have an account? <a href="register.php">register now</a></p>
    </form>
</section>

<!-- Footer section starts here -->
<?php include 'components/footer.php';?>
<!-- Footer section ends here -->

<!-- Custom js file link -->
<script src="js/script.js"></script>
    
</body>
</html>