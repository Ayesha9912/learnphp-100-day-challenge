<?php
require "connection.php";
if(isset($_POST["submit"])){
    $name = $_POST["name"];
    $query =    "INSERT INTO form VALUES ('' , '$name')";
    mysqli_query($conn , $query);
    // header("Location: ".$_SERVER['PHP_SELF']);
    // exit();
};  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Project 1</title>
    <style>
        *{
            display: "flex";
            justify-content: center;
            align-items: center;
        }
        h1{
            padding-top: 30px;
        }
        input{
            width: 400px !important;
        }
        button{
            margin-top: 20px;
        }
        p{
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 id="username"></h1>
        <form action="" method="post" autocomplete>
        <input type="text" name="name" class="form-control" id="exampleFormControlInput1" placeholder="name">
        <button type="submit" name="submit" class="btn btn-primary" id="btn">Submit</button>
        <p id="para"></p>
        </form>
    </div>
<script>
    document.addEventListener("DOMContentLoaded", function(){
        var name = "<?php echo $name ?>";
        if(name !== ""){
        document.getElementById("username").innerHTML = `The User name is ${name} 🚀🚀🚀`
        document.getElementById("para").innerHTML = `Data is Successfully Added 🚀🚀`
        }
        console.log(name);
    })
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>