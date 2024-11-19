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
    $delete_id =$_POST['post_id'];
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
if(isset($_POST['save'])){
    $post_id = $get_id;
    $title = $_POST['title'];
    $title = filter_var($title , FILTER_SANITIZE_STRING);
    $category = $_POST['category'];
    $category = filter_var($category , FILTER_SANITIZE_STRING);
    $content = $_POST['content'];
    $content = filter_var($content , FILTER_SANITIZE_STRING);
    $status =  $_POST['status'];
    $status = filter_var($status , FILTER_SANITIZE_STRING);

  $update_post = $conn->prepare("UPDATE `posts` SET title = ? , content = ? , category = ?, status = ? WHERE id = ? ");
  $update_post->execute([$title , $content, $category, $status, $post_id]);
  $message[] = 'Post updated!';

  $old_image = $_POST['old_image'];
  $old_image = filter_var($old_image , FILTER_SANITIZE_STRING);


    $image = $_FILES['image']['name'];
    $image = filter_var($image , FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_img/'.$image;
    $select_image = $conn->prepare("SELECT * FROM `posts` WHERE image = ? AND admin_id = ?");
    $select_image->execute([$image, $admin_id]);
    if(!empty($image)){
       if($select_image->rowCount() > 0 AND $image != ""){
        $message[] = 'Please rename your Image!';
       } 
       elseif($image_size > 2000000){
        $message[] ='image size is too large';
       }else{
        $update_image = $conn->prepare("UPDATE `posts` SET image = ? WHERE id = ?");
        $update_image->execute([$image , $get_id]);
        move_uploaded_file($image_tmp_name, $image_folder);
        $message[] = 'Image updated!';
        if($old_image != $image AND $old_image != ''){
           unlink('../uploaded_img/'.$old_image);
        }
       }
    }else{
        $image = '';
    }
}
if(isset($_POST['delete_image'])){
    $empty_image = "";
    $select_image = $conn->prepare('SELECT * FROM `posts` WHERE id = ?');
    $select_image->execute([$get_id]);
    $fetch_image = $select_image->fetch(PDO::FETCH_ASSOC);
    if($fetch_image['image'] != ''){
        unlink('../uploaded_img/' .$fetch_image['image']);
    }
    $unset_image = $conn->prepare("UPDATE `posts` SET image = ? WHERE id = ?");
    $unset_image->execute([$empty_image, $get_id]);
    $message[] = 'Image Deleted!';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin_style.css">
    <title> Edit Post</title>
    <!-- font Awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body>
<!-- Header section starts here -->
<?php include '../components/admin_header.php'?>
<!-- Header section ends here -->
<section class="post-editor">
    <h1 class="heading">Edit Post</h1>
    <?php
        $select_posts = $conn->prepare('SELECT * FROM `posts` WHERE  id = ? AND admin_id = ?');
        $select_posts->execute([$get_id , $admin_id]);
        if($select_posts->rowCount() > 0){
          while($fetch_post = $select_posts->fetch(PDO::FETCH_ASSOC)){
        ?>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="post_id" value="<?=$fetch_post['id'];?>">
        <input type="hidden" name="old_image" value="<?=$fetch_post['image'];?>">
        <input type="hidden" value="<?= $fetch_profile['name'];?>" name="name">
        <p>Post Status <span>*</span></p>
        <select name="status" required class="box">
            <option value="<?= $fetch_post['status'];?>"selected><?= $fetch_post['status'];?></option>
            <option value="active">active</option>
            <option value="deactive">deactive</option>
        </select>
        <p>Post Title <span>*</span></p>
        <input type="text" name="title" required  placeholder="Add post title here" maxlength="100" class="box" value="<?= $fetch_post['title'];?>">
        <p>Post Content <span>*</span></p>
        <textarea name="content" class="box" id="" cols="30" rows="10"  maxlength="1000" placeholder="Add post content here...."><?= $fetch_post['content'];?></textarea>
        <p>Post Category <span>*</span></p>
        <select name="category" required class="box" id="">
          <option value=""  selected><?= $fetch_post['category'];?></option>  
          <option value="nature">Nature</option>
          <option value="Music">Music</option>
          <option value="Islam">Islam</option>
          <option value="Books">Books</option>
          <option value="Bitcion">Bitcion</option>
          <option value="development">development</option>
          <option value="cyber security">cyber security</option>
        </select>
        <p>Post Image <span>*</span></p>
        <input type="file" name="image" accept="image/jpg , image/jpeg , image/png" class="box">
        <?php
         if($fetch_post['image'] != ''){

         ?>
         <img src="../uploaded_img/<?=$fetch_post['image'];?>" alt="" class='image'>
         <input type="submit" value="delete image" name="delete_image" class="delete-btn">
         <?php
         }

          ?>
        <div class="flex-btn">
            <input type="submit" value="save post" name="save" class="btn">
            <a href="view_post.php" class="option-btn">Go Home</a>
            <button type="submit" name="delete" onclick="return confirm('delete this post?');" class="delete-btn">Delete</button>
        </div>
    </form>
    <?php 
        } 
    }else{
        echo ' <p class="empty">not post added yet!</p>';
    }
        ?>


</section>



<!-- Custom js file links -->
<script src='../js/admin_script.js'></script>
</body>
</html>