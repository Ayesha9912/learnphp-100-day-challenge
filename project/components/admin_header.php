<?php 
if(isset($message)){
    foreach($message as $message){
        echo '
    <div class="message">
    <span>'.$message.'</span>
    <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
    </div>
        ';
    }
}
?>
<header class="header">
    <a href="dashboard.php" class="logo">Admin <span>Panel</span></a>
    <div class="profile">
        <?php
        $select_profile = $conn->prepare("SELECT * FROM `admin` WHERE id = ?");
        $success = $select_profile->execute([$admin_id]);
        $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);

    ?>
    <p style="color:black;"><?= $fetch_profile['name']; ?></p>
    <a href="update_profile.php" class="btn">Update Profile</a>
    </div>
    <nav class="navbar">
        <a href="dashboard.php"><i class="fas fa-home"><span>Home</span></i></a>
        <a href="add_post.php"><i class="fas fa-pen"><span>Add post</span></i></a>
        <a href="view_post.php"><i class="fas fa-eye"><span>View post</span></i></a>
        <a href="admin_accounts.php"><i class="fas fa-user"><span>Accounts</span></i></a>
        <a onclick="return confirm ('logout from the website');" href="../components/admin_logout.php"><i class="fas fa-right-from-bracket"><span style="color:var(--red);">logout</span></i></a>
    </nav>
    <div class="flex-btn">
        <a href="admin_login.php" class="option-btn">Login</a>
        <a href="register_admin.php" class="option-btn">register</a>
    </div>
</header>

<div id="menu-btn" class="fas fa-bars"></div>