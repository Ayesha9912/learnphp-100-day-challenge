<?php
include '../components/connect.php';
session_start();
$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
   header('location:admin_login.php');
}
if(isset($_POST['publish'])){
    $name = $_POST['name'];
    $name = filter_var($name , FILTER_SANITIZE_STRING);
    $title = $_POST['title'];
    $title = filter_var($title , FILTER_SANITIZE_STRING);
    $category = $_POST['category'];
    $category = filter_var($category , FILTER_SANITIZE_STRING);
    $content = $_POST['content'];
    $content = filter_var($content , FILTER_SANITIZE_STRING);
    $status = 'active';
    $image = $_FILES['image']['name'];
    $image = filter_var($image , FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_img/' .$image;
    $select_image = $conn->prepare("SELECT * FROM `posts` WHERE image = ? AND admin_id = ?");
    $select_image->execute([$image, $admin_id]);
    if(isset($image)){
       if($select_image->rowCount() > 0 AND $image != ""){
        $message[] = 'Image name repeated';
       } 
       elseif($image_size > 2000000){
        $message[] ='image size is too large';
       }else{
         move_uploaded_file($image_tmp_name, $image_folder);
       }
    }else{
        $image = '';

    }
    if($select_image-> rowCount() > 0 AND $image != ''){
        $message[] = 'please rename your image';
    }else{
        $insert_post = $conn->prepare("INSERT INTO `posts` (admin_id, name, title, content, category, image, status) VALUES(?,?,?,?,?,?,?)");
        $insert_post->execute([$admin_id,$name, $title, $content, $category, $image, $status]);
        $message[] = 'post published';
    }
}
if(isset($_POST['draft'])){
    $name = $_POST['name'];
    $name = filter_var($name , FILTER_SANITIZE_STRING);
    $title = $_POST['title'];
    $title = filter_var($title , FILTER_SANITIZE_STRING);
    $category = $_POST['category'];
    $category = filter_var($category , FILTER_SANITIZE_STRING);
    $content = $_POST['content'];
    $content = filter_var($content , FILTER_SANITIZE_STRING);
    $status = 'deactive';
    $image = $_FILES['image']['name'];
    $image = filter_var($image , FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_img'.$image;
    $select_image = $conn->prepare("SELECT * FROM `posts` WHERE image = ? AND admin_id = ?");
    $select_image->execute([$image, $admin_id]);
    if(isset($image)){
       if($select_image->rowCount() > 0 AND $image != ""){
        $message[] = 'Image name repeated';
       } 
       elseif($image_size > 2000000){
        $message[] ='image size is too large';
       }else{
         move_uploaded_file($image_tmp_name, $image_folder);
       }
    }else{
        $image = '';
    }
    if($select_image-> rowCount() > 0 AND $image != ''){
        $message[] = 'please rename your image';
    }else{
        $insert_post = $conn->prepare("INSERT INTO `posts` (admin_id, name, title, content, category, image, status) VALUES(?,?,?,?,?,?,?)");
        $insert_post->execute([$admin_id,$name, $title, $content, $category, $image, $status]);
        $message[] = 'Draft post';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin_style.css">
    <title>add posix_times</title>
    <!-- font Awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body>

<!-- Header section starts here -->
<?php include '../components/admin_header.php'?>
<!-- Header section ends here -->

<section class="post-editor">
    <h1 class="heading">Add Post</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" value="<?= $fetch_profile['name'];?>" name="name">
        <p>Post Title <span>*</span></p>
        <input type="text" name="title" required  placeholder="Add post title here" maxlength="100" class="box">
        <p>Post Content <span>*</span></p>
        <textarea name="content" class="box" id="" cols="30" rows="10"  maxlength="1000" placeholder="Add post content here...."></textarea>
        <p>Post Category <span>*</span></p>
        <select name="category" class="box" id="" required>
          <option value="" disabled selected>-- select post category</option>  
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
        <div class="flex-btn">
            <input type="submit" value="publish post" name="publish" class="btn">
            <input type="submit" value="save draft" name="draft" class="option-btn">
        </div>
         

    </form>


</section>


<!-- Custom js file links -->
<script src='../js/admin_script.js'></script>
</body>
</html>