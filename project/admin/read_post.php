<?php
include '../components/connect.php';
session_start();
$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
   header('location:admin_login.php');
}
if(!isset($_GET['post_id'])){
    header('location:view_post.php');
}else{
    $get_id = $_GET['post_id'];
}
if(isset($_POST['delete'])){
    $delete_post_id =$_POST['post_id'];
    $delete_id = filter_var($delete_post_id , FILTER_SANITIZE_STRING);
    $select_image = $conn->prepare('SELECT * FROM `posts` WHERE id = ?');
    $fetch_image = $select_image->execute([$delete_id]);
    $fetch_image = $select_image->fetch(PDO::FETCH_ASSOC);
    if($fetch_image['image'] != ''){
        unlink('../uploaded_img/'.$fetch_image['image']);
    }
    $delete_comments = $conn->prepare("DELETE FROM `comments` WHERE post_id = ?");
    $delete_comments->execute([$delete_id]);
    $delete_likes = $conn->prepare("DELETE FROM `likes` WHERE post_id = ?");
    $delete_likes->execute([$delete_id]);
    $delete_post = $conn->prepare("DELETE FROM `posts` WHERE id = ?");
    $delete_post->execute([$delete_id]);
    $message[] = 'Post Deleted Successfully!';
}
if(isset($_POST['delete_comment'])){

    $comment_id = $_POST['comment_id'];
    $comment_id = filter_var($comment_id , FILTER_SANITIZE_STRING);
    $delete_comments = $conn->prepare("DELETE FROM `comments` WHERE id = ?");
    $delete_comments->execute([$comment_id]);
    $message[] = 'Comment deleted!';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin_style.css">
    <title>Read Post</title>
    <!-- font Awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body>

<!-- Header section starts here -->
<?php include '../components/admin_header.php'?>
<!-- Header section ends here -->


<section class="read-post">
    <h1 class="heading">Read Post</h1>
    <div class="box-container">
    <?php
        $select_posts = $conn->prepare('SELECT * FROM `posts` WHERE id = ? AND admin_id = ?');
        $select_posts->execute([$get_id , $admin_id]);
        if($select_posts->rowCount() > 0){
          while($fetch_post = $select_posts->fetch(PDO::FETCH_ASSOC)){
            $post_id = $fetch_post['id'];
            $count_post_comments = $conn->prepare("SELECT * FROM `comments` WHERE post_id = ?");
            $count_post_comments->execute([$post_id]);
            $total_post_comments = $count_post_comments->rowCount();
            $count_post_likes = $conn->prepare("SELECT * FROM `likes` WHERE post_id = ?");
            $count_post_likes->execute([$post_id]);
            $total_post_likes = $count_post_likes->rowCount();
        ?>
        <form action="" method='POST' class="box">
            <div class="status" style="background: <?php if($fetch_post['status']
             == 'active'){echo'limegreen';}else{echo 'coral';}?>;"><?=$fetch_post['status'];?></div>
            <?php  
            if($fetch_post['image'] != ''){
             ?>
             <img class="image" src="../uploaded_img/<?= $fetch_post['image'];?>" alt="">
             <?php
            }
             ?>
             <div class="post-title"><?= $fetch_post['title'];?></div>
             <div class="post-content"><?= $fetch_post['content'];?></div>
             <div class="icons">
                <div><i class="fas fa-comment"></i><span><?=$total_post_comments;?></span></div>
                <div><i class="fas fa-heart"></i><span><?=$total_post_likes;?></span></div>
             </div>
             <div class="flex-btn">
                <a href="edit_post.php?post_id=<?= $post_id;?>" class="option-btn">Edit</a>
                <a href="view_post.php?post_id=<?= $post_id;?>" class="option-btn">Go Back</a>
                <button type="submit" name="delete" onclick="return confirm('delete this post?');" class="delete-btn">Delete</button>
            </div>
            <div class="post-category"><i class="fas fa-tag"><span><?= $fetch_post['category'];?></span></i></div>
        </form>
        <?php 
        } 

    }else{
        echo ' <p class="empty">not post added yet!</p>';
    }
        ?>
    </div>

</section>


<section class="comments">
    <p class="comment-title">Post Comments</p>
    <div class="box-container">
        <?php   
        $select_comments = $conn->prepare('SELECT * FROM `comments` WHERE post_id = ?');
        $select_comments->execute([$get_id]);
        if($select_comments->rowCount() > 0){
            while($fetch_comments = $select_comments->fetch(PDO :: FETCH_ASSOC))
            {
         ?>
         <div class="box">
            <div class="user">
                <i class="fas fa-user"></i>
                <div class="user-info">
                    <span><?=$fetch_comments['user_name'];?></span>
                    <div><?=$fetch_comments['date'];?></div>
                </div>
            </div>
            <div class="text"><?=$fetch_comments['comment'];?></div>
            <form action="" class="icons" method="POST">
                <input type="hidden" name="comment_id" value="<?=$fetch_comments['id'];?>">
                <button type="submit" name="delete_comment" onclick="return confirm('delete this comment?');" class="inline-delete-btn">Delete coment</button>
            </form>
         </div>
     <?php
      }

    }else{
       echo '<p class="empty">No comment has been added</p>' ;
    }
     ?>
    </div>
</section>



<!-- Custom js file links -->
<script src='../js/admin_script.js'></script>
</body>
</html>