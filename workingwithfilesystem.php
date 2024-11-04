<!-- ///Super Global Variable -->

<!-- $_FILES -->
<!-- to store it in server and in specific folder  -->

<?php

if(isset($_FILES['fileToUpload'])){
    echo "<pre>";
    print_r($_FILES);
    echo "</pre>";

    $file_name = $_FILES['fileToUpload']['name'];
    $file_size = $_FILES['fileToUpload']['size'];
    $file_temp = $_FILES['fileToUpload']['tmp_name'];
    $file_type = $_FILES['fileToUpload']['type'];
    // this function takes two paramaters one is file tmp name and second is where you want to save this file
    if($file_type === "image/png"){
        if(move_uploaded_file($file_temp, "upload-images/" . $file_name)){
            echo "File uploaded successfully";
        }
        else{
            echo "Failed to upload file";
        }
    }
    else{
        echo "File is not a PNG";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>File Upload</title>
</head>
<body>
    <form action="" method="POST" enctype="multipart/form-data"> 
        <!-- ///enctype=> we use it when you mention file -->
        Select image to upload:
        <input type="file" name="fileToUpload"> <br>
        <input type="submit">
    </form>
</body>
</html>
