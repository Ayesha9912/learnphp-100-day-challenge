<?php
include '../components/connect.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
    exit; // Exit after redirect to prevent further code execution
}

if (isset($_POST['submit'])) {
    // Retrieve and sanitize input values
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $cpass = sha1($_POST['cpass']);
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

    // Check if the username already exists
    $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE name = ?");
    $select_admin->execute([$name]);

    if ($select_admin->rowCount() > 0) {
        $message[] = 'Username already exists!';
    } else {
        if ($pass != $cpass) {
            $message[] = 'Confirm password does not match!';
        } else {
            // Insert the new admin user into the database
            $insert_admin = $conn->prepare("INSERT INTO `admin` (name, password) VALUES (?, ?)");
            $insert_admin->execute([$name, $cpass]);
            $message[] = 'New admin registered!';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin_style.css">
    <title>Register admin</title>
    <!-- font Awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body>

<!-- Header section starts here -->
<?php include '../components/admin_header.php'?>
<!-- Header section ends here -->

<!-- admin register section starts here -->
<section class="form-container">
    <form action="" method="POST">
        <h3>Register Now</h3>
        <input type="text" required class="box" placeholder="Enter your username passowrd" maxlength="20" name="name" oninput="this.value = this.value.replace(/\s/g, '')">
        <input type="password" required class="box" placeholder="Enter your userpass" maxlength="20" name="pass" oninput="this.value = this.value.replace(/\s/g, '')">
        <input type="password" required class="box" placeholder="Enter your confirm userpass" maxlength="20" name="cpass" oninput="this.value = this.value.replace(/\s/g, '')">
        <input type="submit" name="submit" class="btn" value="register now">
    </form>
</section>
<!-- admin register section ends here -->



<!-- Custom js file links -->
<script src='../js/admin_script.js'></script>
</body>
</html>