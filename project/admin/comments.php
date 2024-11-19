<?php
include '../components/connect.php';
session_start();
$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
   header('location:admin_login.php');
//    $admin_id = 1;
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
    <title>user comments</title>
    <!-- font Awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body>

<!-- Header section starts here -->
<?php include '../components/admin_header.php'?>
<!-- Header section ends here -->

<section class="comments">
    <h1 class="heading">All Comments</h1>
    <p class="comment-title">Post Comments</p>
    <div class="box-container">
        <?php   
        $select_comments = $conn->prepare('SELECT * FROM `comments` WHERE admin_id = ?');
        $select_comments->execute([$admin_id]);
        if($select_comments->rowCount() > 0){
            while($fetch_comments = $select_comments->fetch(PDO :: FETCH_ASSOC))
            {
         ?>
         <div class="box">
            <?php  
             $select_posts = $conn->prepare("SELECT * FROM `posts` WHERE id=?");
             $select_posts->execute([$fetch_comments['post_id']]);
             while($fetch_post = $select_posts->fetch(PDO::FETCH_ASSOC)){
             ?>
             <div class="post-title"><span>from: </span><?=$fetch_post['title'];?><a href="read_post.php?post_id=<?=$fetch_post['id'];?>">Read Post</a></div>
             <?php 
             }

             ?>
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