<?php
include 'components/connect.php';
include 'components/like_post.php';
session_start();
if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};
if(isset($_GET['post_id'])){
    $get_id = $_GET['post_id'];
}else{
    $get_id = '';
}
if(isset($_POST['add_comment'])){
    $admin_id = $_POST['admin_id'];
    $admin_id = filter_var($admin_id, FILTER_SANITIZE_STRING);
    $user_name = $_POST['user_name'];
    $user_name = filter_var($user_name, FILTER_SANITIZE_STRING);
    $comment = $_POST['comment'];
    $comment = filter_var($comment, FILTER_SANITIZE_STRING);
    $verify_comment = $conn->prepare("SELECT * FROM `comments` WHERE post_id = ? AND admin_id = ? AND user_id = ? AND user_name = ? AND comment = ?");
    $verify_comment->execute([$get_id,$admin_id, $user_id , $user_name, $comment]);

    if($verify_comment->rowCount() > 0){
        $message[] = 'comment already added';
    }else{
        $insert_comment = $conn->prepare("INSERT INTO `comments` (post_id, admin_id , user_id , user_name, comment) VALUES (?,?,?,?,?)");
        $insert_comment->execute([$get_id, $admin_id, $user_id, $user_name, $comment]);
        // $message[] = 'new comment added';
        if ($insert_comment) {
            echo '
        <p class="empty">Comment added successfully</p>
            ';
        } else {
            echo "Failed to add comment";
        }
    }
}

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
<section class="read-post">
    <h1 class="heading">Read Post</h1>
        <?php  
    
        $select_posts = $conn->prepare("SELECT * FROM `posts` WHERE  id = ? AND status = ?");
        $select_posts->execute([$get_id , 'active']);
        if($select_posts->rowCount() > 0){
         while($fetch_posts = $select_posts->fetch(PDO::FETCH_ASSOC)){
            $post_id = $fetch_posts['id'];
            $count_user_comments=$conn->prepare("SELECT * FROM `comments` WHERE post_id = ?");
            $count_user_comments->execute([$post_id]);
            $total_user_comments = $count_user_comments->rowCount();

            $count_user_likes=$conn->prepare("SELECT * FROM `likes` WHERE post_id = ?");
            $count_user_likes->execute([$post_id]);
            $total_user_likes = $count_user_likes->rowCount(); 
            
            $confirm_likes = $conn->prepare("SELECT * FROM `likes` WHERE user_id = ? AND post_id = ?");
            $confirm_likes->execute([$user_id, $post_id]);
        ?>
        <form action="" method="POST" class="box">
            <input type="hidden" name="post_id" value="<?=$post_id;?>">
            <input type="hidden" name="admin_id" value="<?=$fetch_posts['admin_id'];?>">
            <div class="admin">
               <i class="fas fa-user"></i>
               <div class="admin-info">
                <a href="author_posts.php?author=<?=$fetch_posts['name']; ?>"><?=$fetch_posts['name'];?></a>
                <div><?=$fetch_posts['date'];?></div>
            </div>
            </div>
            <?php 
            if($fetch_posts['image'] != ''){
             ?>
             <img class="image" src="uploaded_img/<?=$fetch_posts['image']?>" alt="">
             <?php 
            } 
             ?>
            <div class="title"><?= $fetch_posts['title']?></div>
            <div class="content"><?= $fetch_posts['content']?></div>
            <div class="icons">
            <div><i class="fas fa-comment"></i><span><?=$total_user_comments;?></span></div>
            <a href="view_post.php?post_id=<?=$post_id;?>"></a>
            <button type="submit" name="like_post"><i class="fas fa-heart" style="<?php if($confirm_likes->rowCount() > 0) {echo 'color:var(--red)';};?>"></i><span><?=$total_user_likes?></span></button>
            </div>
            <a class="category" href="category.php?category=<?=$fetch_posts['category']?>"><i class="fas fa-tag"></i><span><?=$fetch_posts['category']?></span></a>
        </form>
        <?php
         }
        }
        else{
            echo '<p class="empty">No Post Found</p>' ;
        }
         ?>
</section>


<section class="comments" style="padding-top:0;">
    <p class="comment-title">Add comment</p>
    <?php
    if($user_id != ''){
       $select_admin_id =  $conn->prepare("SELECT * FROM `posts` WHERE id = ? AND status = ?");
       $select_admin_id->execute([$get_id , 'active']);
       $fetch_admin_id = $select_admin_id->fetch(PDO::FETCH_ASSOC);
     
    ?>
    <form action="" method="POST" class="add-comments">
        <input type="hidden" name="admin_id" value="<?=$fetch_admin_id['admin_id'];?>">
        <input type="hidden" name="user_name" value="<?=$fetch_admin_id['name'];?>">
        <p><i class="fas fa-user"><a href="update.php"><?=$fetch_admin_id['name'];?></a></i></p>
        <textarea name="comment" class="comment_box" placeholder="Enter your comment here..." required maxlength = "1000" id="" cols="30" rows="10"></textarea>
        <input type="submit" value="Add comment" name="add_comment" class="inline-btn">
    </form>
    <?php
    }else{
    ?>
    <div class="add-comments">
        <p>Login to add comments</p>
        <div class="flex-btn">
            <a href="login.php" class="inline-option-btn">Login</a>
            <a href="register.php" class="inline-option-btn">Register</a>
        </div>
    </div>
    <?php 
    }
    ?>
    <p class="comment-title">User Comments</p>
    <div class="show-comments">
    <?php 
    $select_comments = $conn->prepare('SELECT * FROM `comments` WHERE post_id = ?');
    $select_comments->execute([$get_id]);
    if($select_comments->rowCount() > 0){
    while($fetch_comment = $select_comments->fetch(PDO::FETCH_ASSOC)){

       
    ?>
     <div class="user-comments" style="<?php if($fetch_comments['user_id'] == $user_id){echo 'order:-1;'; } ?>">
        <div class="user">
            <i class="fas fa-user"></i>
            <div class="user-info">
                <p><?=$fetch_comment['user_name'];?></p>
                <p><?=$fetch_comment['date'];?></p>
            </div>
        </div>
        <div class="comment-box" style="<?php if($fetch_comment['user_id'] == $user_id){echo 'color:var(--white); background-color: var(--black)'; } ?>"><?= $fetch_comment['comment']; ?></div>
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