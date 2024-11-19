<?php
include '../components/connect.php';
session_start();
$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
   header('location:admin_login.php');
//    $admin_id = 1;
}
if(isset($_POST['delete'])){
    $select_image = $conn->prepare('SELECT * FROM `posts` WHERE admin_id = ?');
    $fetch_image = $select_image->execute([$admin_id]);
    $fetch_image = $select_image->fetch(PDO::FETCH_ASSOC);
    if($fetch_image['image'] != ''){
        unlink('../uploaded_img/'.$fetch_image['image']);
    }
    $delete_posts = $conn->prepare("DELETE FROM `posts` WHERE admin_id = ?");
    $delete_posts->execute([$admin_id]);
    $delete_comments = $conn->prepare("DELETE FROM `comments` WHERE admin_id = ?");
    $delete_comments->execute([$admin_id]);
    $delete_likes = $conn->prepare("DELETE FROM `likes` WHERE admin_id = ?");
    $delete_likes->execute([$admin_id]);
    $delete_admin = $conn->prepare("DELETE FROM `admin` WHERE id = ?");
    $delete_admin->execute([$admin_id]);
   header('location:../components/admin_logout.php');

   

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin_style.css">
    <title>Admin Account</title>
    <!-- font Awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body>

<!-- Header section starts here -->
<?php include '../components/admin_header.php'?>
<!-- Header section ends here -->

<section class="accounts">
    <h1 class="heading">Admin Accounts</h1>
    <div class="box-container">
        <div class="box" style="order: -2;">
            <p>Register new Admin</p>
            <a href="register_admin.php" class="option-btn">Register Now</a>
        </div>
        <?php 
        $select_account = $conn->prepare("SELECT * FROM `admin`");
        $select_account->execute();
        if($select_account->rowCount() > 0){
            while($fetch_account = $select_account->fetch(PDO::FETCH_ASSOC)){
                $count_admin_post = $conn->prepare("SELECT * FROM `posts` WHERE admin_id = ? ");
                $count_admin_post->execute([$fetch_account['id']]);
                $total_admin_posts = $count_admin_post->rowCount();
        ?>
        <div class="box" style="<?php if($fetch_account['id'] == $admin_id){echo
            'order:-1';}?>">
        <p>id: <span><?=$fetch_account['id'];?></span></p>
        <p>Username: <span><?=$fetch_account['name'];?></span></p>
        <p>Posts: <span><?=$total_admin_posts;?></span></p>
        <?php 
        if($fetch_account['id'] == $admin_id){
        ?>
        <?php 
        }
        ?>
        <div class="flex-btn">
        <a href="update_profile.php" class="option-btn">Update</a>
        <form action="" method="post">
            <button type="submit" class="delete-btn" onclick="return confirm('delete the account');" name='delete'>Delete</button>
        </form>
        </div>
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