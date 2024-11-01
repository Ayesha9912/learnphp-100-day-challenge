<?php
if(isset($_POST['download'])){
    $imgUrl = $_POST['imgurl'];
    $ch = curl_init($imgUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $download = curl_exec($ch);
    curl_close($ch);
    header('Content-type: image/jpg');
    header('Content-Disposition: attachment; filename="image.jpg"');
    echo $download;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youtube Video Thumbnail</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<style>
    *{
        margin:0px;
        padding: 0px;
        box-sizing: border-box;
        font-family: cursive;

    }
    body{
        display:flex;
        align-items:center;
        justify-content: center;
        min-height: 100vh;
        background: #7d2ae8;
    }
    form{
        background: #ffff;
        width: 450px;
        padding:30px;
        border-radius:5px;
    }
    form header{
        text-align: center;
        font-size: 28px;
        font-weight:500;
        text-align: center;
        margin-top: 10px;
        color: #7d2ae8;
    }
    form .url-input{
        margin: 30px 0;
    }
    .url-input .title{
        font-size:18px;
        color:#373737;
    }
    .url-input .field{
        height: 50px;
        width: 100%;
        margin-top: 5px;
        position:relative;
    }
    .url-input input{
        height:100%;
        border:none;
        background:#f1f1f7;
        padding: 0px 15px;
        outline: none;
        width:100%;
        border-bottom: 2px solid gray;
    }
    .url-input .field .bottom-line{
        height: 2px;
        width:100%;
        background: #7d2ae8;
        bottom: 0;
        position: absolute;
        left:0;
        transform: scale(0);
        transition: transform 0.5s ease;
    }
    .url-input .field input:focus ~.bottom-line ,
    .url-input .field input:valid ~.bottom-line{
        transform: scale(1);
    }
    form .preview-area{
        height: 220px;
        border-radius: 5px;
        border: 2px dashed #7d2ae8;
        display:flex;
        align-items:center;
        justify-content: center;
        flex-direction: column;
    }
    form .preview-area .icon{
       color: #7d2ae8;
       font-size: 80px;
       /* display:none;  */
    }
    form .preview-area span{
        margin-top: 20px;
        color: #7d2ae8;
        font-family: cursive;
        /* display:none; */
    }
    form .preview-area .thumbnail{
        width: 100%;
        border-radius: 5px;
        display:none;
    }
    form .download-btn{
        width: 100%;
        background: #7d2ae8;
        font-size: 18px;
        font-weight: 500;
        height: 53px;
        border: none;
        outline: none;
        margin-top: 30px;
        border-radius: 5px;
        color: white;
    }
    .hidden-input{
        display: none;
    }
    .preview-area.active{
        border: none;
    }
    .preview-area.active .thumbnail{
  display: block;
}
.preview-area.active .icon,
.preview-area.active span
{
  display: none;
}
</style>
<body>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
    <header>Download Thumbnail</header>
    <div class="url-input">
        <span class="title">Paste Video Url:</span>
        <div class="field">
            <input type="text" placeholder = "https://youtu.be/FucPPCPDd2Y" required>
            <input type="text" class="hidden-input" name="imgurl">
            <div class="bottom-line"></div>
        </div>
    </div>
    <div class="preview-area">
        <img class="thumbnail" src="" alt="Thumbnail image">
        <i class="icon fas fa-cloud-download-alt"></i>
        <span>Paste Video url to see preview</span>
    </div>
    <button name= "download" type="submit" class="download-btn">Download Thumbnail</button>
</form>
<script>
    let urlField = document.querySelector(".field input"),
    hiddenInput = document.querySelector(".hidden-input"),
    previewArea = document.querySelector(".preview-area"),
    imgTag = document.querySelector(".thumbnail"),
    downloadBtn = document.querySelector(".download-btn")
    urlField.onkeyup = ()=>{
        let imgUrl = urlField.value;
        downloadBtn.style.pointerEvents = "auto"
        console.log(imgUrl);
        previewArea.classList.add("active")
        if(imgUrl.indexOf("https://www.youtube.com/watch?v=") != -1){
         let vidID = imgUrl.split('v=')[1].substring(0 , 11);
         let finalUrl = `https://img.youtube.com/vi/${vidID}/maxresdefault.jpg`;
         console.log(finalUrl , "finalurl");
         imgTag.src = finalUrl
        }
        else if(imgUrl.indexOf("https://youtu.be/") !=-1){
            let vidID = imgUrl.split("be/")[1].substring(0, 11)
            let finalUrl = `https://img.youtube.com/vi/${vidID}/maxresdefault.jpg`
            imgTag.src = finalUrl
        }
        else if(imgUrl.match(/\.(jpe?g|png|gif|bmp|webp)$/i)){
            imgTag.src = imgUrl
        }
        else{
            imgTag.src = ""
            previewArea.classList.remove("active")
        downloadBtn.style.pointerEvents = "none";

        }
        hiddenInput.value = imgTag.src
        console.log(hiddenInput.value , "thumbnail url");
    }
</script>

</body>
</html>