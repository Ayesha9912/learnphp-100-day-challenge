<?php
include 'components/connect.php';
include 'components/like_post.php';


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authors</title>
    <!-- font Awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<!-- Header section starts here -->
<?php include 'components/user_header.php';?>
<!-- Header section ends here -->

<section class="authors">
    <h1 class="heading">Authors</h1>
    <div class="box-container">

    <?php
    $select_authors = $conn->prepare("SELECT * FROM `admin`");
    $select_authors->execute();
    if($select_authors->rowCount() > 0){
      while($fetch_author = $select_authors->fetch(PDO::FETCH_ASSOC)){
    $count_admin_posts = $conn->prepare("SELECT * FROM `posts` WHERE admin_id = ? AND status = ?");
    $author_id = $fetch_author['id'];
    $count_admin_posts->execute([$author_id, 'active']);
    $total_admin_posts = $count_admin_posts->rowCount();

    $count_admin_likes = $conn->prepare("SELECT * FROM `likes` WHERE admin_id = ?");
    $author_id = $fetch_author['id'];
    $count_admin_likes->execute([$author_id]);
    $total_admin_likes = $count_admin_likes->rowCount();

    $count_admin_comments = $conn->prepare("SELECT * FROM `comments` WHERE admin_id = ?");
    $author_id = $fetch_author['id'];
    $count_admin_comments->execute([$author_id]);
    $total_admin_comments = $count_admin_comments->rowCount();
     ?>
     <div class="box">
        <p>Author: <span><?= $fetch_author['name'];?></span></p>
        <p>Total Posts: <span><?= $total_admin_posts?></span></p>
        <p>Total Likes: <span><?= $total_admin_likes?></span></p>
        <p>Total Comments: <span><?= $total_admin_comments?></span></p>
        <a href="author_posts.php?author=<?= $fetch_author['name']?>" class="btn">View Posts</a>
     </div>
     <?php
      }
    }else{
        echo '<p>No authors found!.</p>';
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