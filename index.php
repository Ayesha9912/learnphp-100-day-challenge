<?php
require "connection.php";
if(isset($_POST["submit"])){
    $name = $_POST["name"];
    $age = $_POST["age"];
    $country = $_POST["country"];
    $gender = $_POST["gender"];
    $languages = $_POST["languages"];
    $language = "" ;
    foreach($languages as $row){
        $language .= $row . ",";
    }
    $query ="INSERT INTO user VALUES('' , '$name', '$age' , '$country', '$gender' , '$language')";
    mysqli_query($conn, $query);
    echo"
    <script>
    alert('Data Inserted');
    </script>
    ";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Php data form</title>
</head>
<style>
    input{
        margin-top: 20px;
    }
    select{
        margin-top: 20px;
    }
    button{
        margin-top: 20pqs   xewex;
    }
</style>
<body>

<form class="" action="" method="post" autocomplete="">
<label for="">Name</label>
 <input type="text"  name="name" required>
 <br>
 <input type="text"  name="age" required> 
 <br>
 <label for="">country</label>
 <select name="country" id="">
    <option value="">Select a country</option>
    <option value="USA">USA</option>
    <option value="UK">UK</option>
    <option value="Spain">Spain</option>
 </select>
 <br>
 <label for="">Gender</label>
 <input type="radio"   name="gender" value="Male" required>Male
 <input type="radio"  name="gender" value="Female" required>Female
 <br>
 <label for="">Languages</label>
 <input type="checkbox" name="languages[]" value="English" >English
 <input type="checkbox" name="languages[]" value="Spanish" >Spanish
 <input type="checkbox" name="languages[]" value="Chinees" >Chinees
 <br>
 <button name="submit" type="suubmit">Submit</button>
</form> 
</body>
</html>