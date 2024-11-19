<?php
include 'components/connect.php';
include 'components/like_post.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Category</title>
    <!-- font Awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<!-- Header section starts here -->
<?php include 'components/user_header.php';?>
<!-- Header section ends here -->

<section class="categories">
    <h1 class="heading">All Categories</h1>
    <div class="box-container">
        <div class="box"><span>01</span><a href="category.php?category=Nature">Nature</a></div>
    </div>
    <div class="box-container">
        <div class="box"><span>02</span><a href="category.php?category=Music">Music</a></div>
    </div>
    <div class="box-container">
        <div class="box"><span>03</span><a href="category.php?category=Islam">Islam</a></div>
    </div>
    <div class="box-container">
        <div class="box"><span>04</span><a href="category.php?category=Books">Books</a></div>
    </div>
    <div class="box-container">
        <div class="box"><span>05</span><a href="category.php?category=Bitcoin">Bitcoin</a></div>
    </div>
    <div class="box-container">
        <div class="box"><span>06</span><a href="category.php?category=Development">Development</a></div>
    </div>
    <div class="box-container">
        <div class="box"><span>07</span><a href="category.php?category=cybersecurity">cyber Security</a></div>
    </div>
</section>

<!-- Footer section starts here -->
<?php include 'components/footer.php';?>
<!-- Footer section ends here -->

<!-- Custom js file link -->
<script src="js/script.js"></script>
    
</body>
</html>