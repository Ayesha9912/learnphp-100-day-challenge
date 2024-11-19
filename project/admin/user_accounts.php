<?php
include '../components/connect.php';
session_start();
$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
   header('location:admin_login.php');
//    $admin_id = 1;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin_style.css">
    <title>User account</title>
    <!-- font Awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body>

<!-- Header section starts here -->
<?php include '../components/admin_header.php'?>
<!-- Header section ends here -->


<section class="accounts">
    <h1 class="heading">Users Accounts</h1>
    <div class="box-container">
        <?php 
        $select_account = $conn->prepare("SELECT * FROM `users`");
        $select_account->execute();
        if($select_account->rowCount() > 0){
            while($fetch_account = $select_account->fetch(PDO::FETCH_ASSOC)){
        ?>
        <div class="box">
        <p>id: <span><?=$fetch_account['id'];?></span></p>
        <p>Username: <span><?=$fetch_account['name'];?></span></p>
        <p>User email: <span><?=$fetch_account['email'];?></span></p>
        </div>
        <?php
        }
    }
    else{
        echo '<p class="no-accounts">No accounts found.</p>';
    }
        
        ?>
    </div>
</section>
<!-- Custom js file links -->
<script src='../js/admin_script.js'></script>
</body>
</html>