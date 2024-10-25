<?php
echo "Welcome to the world of foreach loops <br>";
$arr = array("Bananas", "Apples", "Harpic", "Bread", "Butter");

for ($i=0; $i < count($arr); $i++) {  //here the count is the built-in function in the php which is used to calculate the number of elements in the array
    echo $arr[$i];
    echo "<br>";
}

// Better way to do this - foreach loops
foreach ($arr as  $value) {
    echo "$value <br>";
}

?>
