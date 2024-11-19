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
    <title>Dashboard</title>
    <!-- font Awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body>

<!-- Header section starts here -->
<?php include '../components/admin_header.php'?>
<!-- Header section ends here -->

<!-- Dashboard Section starts here -->
<section class="dashboard">
    <h1 class="heading">Dashboard</h1>
    <div class="box-container">
        <div class="box">
            <h3>Welcome</h3>
            <p><?= $fetch_profile['name'];?></p>
            <a href="update_profile.php" class="btn">update Profile</a>
        </div>
    <div class="box">
        <?php
        $select_post = $conn->prepare("SELECT * FROM `posts` WHERE admin_id = ?");
        $select_post->execute([$admin_id]);
        $number_of_post = $select_post->rowCount();
        ?>
        <h3><?=$number_of_post;?></h3>
        <p>post added</p>
        <a href="add_post.php" class="btn">add new post</a>
    </div>
    <div class="box">
        <?php
        $select_active_post = $conn->prepare("SELECT * FROM `posts` WHERE admin_id = ? AND status = ?");
        $select_active_post->execute([$admin_id, 'active']);
        $number_of_active_post = $select_active_post->rowCount();
        ?>
        <h3><?=$number_of_active_post;?></h3>
        <p> Active post </p>
        <a href="view_post.php" class="btn">View post</a>
    </div>
    <div class="box">
        <?php
        $select_active_post = $conn->prepare("SELECT * FROM `posts` WHERE admin_id = ? AND status = ?");
        $select_active_post->execute([$admin_id, 'active']);
        $number_of_active_post = $select_active_post->rowCount();
        ?>
        <h3><?=$number_of_active_post;?></h3>
        <p> Deactive post </p>
        <a href="view_post.php" class="btn">View post</a>
    </div>
    <div class="box">
        <?php
        $select_users = $conn->prepare("SELECT * FROM `users`");
        $select_users->execute();
        $number_of_users = $select_users->rowCount();
        ?>
        <h3><?=$number_of_users;?></h3>
        <p>total users </p>
        <a href="user_accounts.php" class="btn">View users</a>
    </div>

    <div class="box">
        <?php
        $select_admins = $conn->prepare("SELECT * FROM `admin`");
        $select_admins->execute();
        $number_of_admins = $select_admins->rowCount();
        ?>
        <h3><?=$number_of_admins;?></h3>
        <p>total admins</p>
        <a href="admin_accounts.php" class="btn">View admins</a>
    </div>

    <div class="box">
        <?php
        $select_comments = $conn->prepare("SELECT * FROM `comments` WHERE admin_id = ?");
        $select_comments->execute([$admin_id]);
        $number_of_comments = $select_comments->rowCount();
        ?>
        <h3><?=$number_of_comments;?></h3>
        <p>Comments </p>
        <a href="comments.php" class="btn">View comments</a>
    </div>

    <div class="box">
        <?php
        $select_likes = $conn->prepare("SELECT * FROM `likes` WHERE admin_id = ?");
        $select_likes->execute([$admin_id]);
        $number_of_likes = $select_likes->rowCount();
        ?>
        <h3><?=$number_of_likes;?></h3>
        <p>likes </p>
        <a href="view_post.php" class="btn">View posts</a>
    </div>

    </div>
</section>

<!-- Dashboard Section ends here -->


<!-- Custom js file links -->
<script src='../js/admin_script.js'></script>
</body>
</html>