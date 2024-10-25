<?php
echo "I am testing my Functions";

function totalmarks($array){
    $sum = 0;
    foreach($array as $values){
    $sum += $values;
}
return $sum;
}

$array = [89, 78, 69, 96, 30];
$finalMarks = totalmarks($array);
echo " the total marks out of 100 is $finalMarks";
?>



<!-- //////////// -->

 <?php
echo "Welcome to php tutorial on functions <br>";

function processMarks($marksArr){
    $sum = 0;
    foreach ($marksArr as $value) {
        $sum += $value;
    }
    return $sum;
}
function avgMarks($marksArr){
    $sum = 0;
    $i = 1;
    foreach ($marksArr as $value) {
        $sum += $value;
        $i++;
    }
    return $sum/$i;
}
$rohanDas = [34, 98, 45, 12, 98, 93];
// $sumMarks = processMarks($rohanDas);
$sumMarks = avgMarks($rohanDas);
$harry = [99, 98, 93, 94, 17, 100];
// $sumMarksHarry = processMarks($harry);
$sumMarksHarry = avgMarks($harry);
echo "Total marks scored by Rohan out of 600 is $sumMarks <br>";
echo "Total marks scored by Harry out of 600 is $sumMarksHarry";
?>

<!-- /////////// -->

<?php
function parcentage($arr){
    $sum = 0;
    foreach($arr as $values){
     $sum += $values;
    }
    return ($sum/300) * 100;
}
$marks = [30, 50,60];
$finalMarks = parcentage($marks);
echo "The total Marks with parcentage are $finalMarks";
?>
