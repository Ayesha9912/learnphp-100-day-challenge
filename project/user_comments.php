<?php
include 'components/connect.php';
include 'components/like_post.php';
session_start();
if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:home.php');
};


if(isset($_POST['edit_comment'])){
    $edit_comment_id = $_POST['edit_comment_id'];
    $edit_comment_id = filter_var($edit_comment_id , FILTER_SANITIZE_STRING);
    $edit_comment_box = $_POST['edit_comment_box'];
    $edit_comment_box = filter_var($edit_comment_box , FILTER_SANITIZE_STRING);
    $verify_edit_comment = $conn->prepare("SELECT * FROM `comments` WHERE id = ? AND comment = ?");
    $verify_edit_comment->execute([$edit_comment_id, $edit_comment_box]);

    if($verify_edit_comment->rowCount() > 0){
       $message[] = 'comment Already added' ;
    }else{
      $update_comment = $conn-> prepare("UPDATE `comments` SET comment = ? WHERE id = ?"); 
      $update_comment->execute([$edit_comment_box,$edit_comment_id]);
      $message[] = 'Comment Edited Successfully';
    }
}
if(isset($_POST['delete_comment'])){
    $delete_comment_id = $_POST['comment_id'];
    $delete_comment_id = filter_var($delete_comment_id, FILTER_SANITIZE_STRING);
    $delete_comment = $conn->prepare("DELETE FROM `comments` WHERE id=?");
    $delete_comment->execute([$delete_comment_id]);
    $message[] = 'Comment successfully Deleted';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Read Post</title>
    <!-- font Awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<!-- Header section starts here -->
<?php include 'components/user_header.php';?>
<!-- Header section ends here -->

<?php  
if(isset($_POST['open_edit_box'])){
    $comment_id = $_POST['comment_id'];
    $comment_id = filter_var($comment_id , FILTER_SANITIZE_STRING);

?>
<section class="edit-comment-box" style="padding-bottom:0;">
  <?php 
  $select_edit_comment = $conn->prepare("SELECT * FROM `comments` WHERE id=?");
  $select_edit_comment->execute([$comment_id]);
  $fetch_edit_comment = $select_edit_comment->fetch(PDO::FETCH_ASSOC);
?>
<form action="" method="POST">
    <p>Edit your comment</p>
    <input type="hidden" name="edit_comment_id" value="<?= $fetch_edit_comment['id'];?>">
    <textarea name="edit_comment_box" class="comment-box" id="" cols="30" rows="10" placeholder="Enter your comment"><?= $fetch_edit_comment['comment'];?></textarea>
    <input type="submit" value="edit comment" class="inline-btn" name="edit_comment">
    <a href="view_post.php?post_id=<?=$get_id;?>" class="inline-option-btn">Cancal</a>
</form>
</section>
<?php
} 
?>



<section class="comments">
    <p class="comment-title">User Comments</p>
    <div class="show-comments">
    <?php 
    $select_comments = $conn->prepare('SELECT * FROM `comments` WHERE user_id = ?');
    $select_comments->execute([$user_id]);
    if($select_comments->rowCount() > 0){
    while($fetch_comment = $select_comments->fetch(PDO::FETCH_ASSOC)){

       
    ?>
     <div class="user-comments" style="<?php if($fetch_comments['user_id'] == $user_id){echo 'order:-1;'; } ?>">
        <?php 
        $select_post = $conn->prepare("SELECT * FROM `posts` WHERE id = ?");
        $select_post->execute([$fetch_comment['post_id']]);
        while($fetch_posts = $select_post->fetch(PDO::FETCH_ASSOC)){
        ?>
        <div class="post-title"><span>From:</span><?=$fetch_posts['title']?><p  href="view_post.php?post_id=<?=$fetch_posts['id'];?>">View Post</p></div>
        <?php
        }
        ?>
        <div class="user">
            <i class="fas fa-user"></i>
            <div class="user-info">
                <p><?=$fetch_comment['user_name'];?></p>
                <p><?=$fetch_comment['date'];?></p>
            </div>
        </div>
        <div class="comment-box" style="<?php if($fetch_comment['user_id'] == $user_id){echo 'color:var(--black);'; } ?>"><?= $fetch_comment['comment']; ?></div>
        <?php if($fetch_comment['user_id'] == $user_id){
        ?>
        <form action="" method="POST" class="flex-btn">
            <input type="hidden" name="comment_id" value="<?= $fetch_comment['id'];?>">
            <input type="submit" value="edit comment" class="inline-option-btn" name="open_edit_box">
            <input type="submit" value="delete comment" class="inline-delete-btn" name="delete_comment" onclick="return confirm('delete this comment?')">
        </form>
        <?php 
        }  
        ?>
     </div>
    <?php
     }
        
    }else{
     echo '<p class="empty">No comments added</p>';  
    }
    
    ?>
    </div>
</section>
<!-- Footer section starts here -->
<?php include 'components/footer.php';?>
<!-- Footer section ends here -->

<!-- Custom js file link -->
<script src="js/script.js"></script>
    
</body>
</html>