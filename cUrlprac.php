<?php

// $curl = curl_init();
// curl_setopt($curl,CURLOPT_URL,'http://www.google.com');
// curl_exec($curl);
// curl_close($curl);


///if the website is secure and safe then we use this line
// $curla = curl_init();
// curl_setopt($curla,CURLOPT_URL,'https://www.amazon.com/');
// curl_setopt($curla,CURLOPT_SSL_VERIFYPEER, false);
// curl_setopt($curla, CURLOPT_RETURNTRANSFER, true);
// $response =curl_exec($curla);

// if(curl_errno($curla)){
//     echo 'Curl error: ' . curl_error($curla);
// }
// else{
//     // echo "Hello I am Ayesha Mehmood from Php";
//     $http_code = curl_getinfo($curla, CURLINFO_HTTP_CODE);
//     echo "HTTP Code: " . $http_code . "<br>";
//     echo htmlspecialchars($response);
// }
// curl_close($curla);  
// we will resolve it later





///now to access all the images from the specific keyword
$string_name = 'php books';
$url = "http://amazon.com/s/field-keywords=$string_name";
$curl = curl_init();
curl_setopt($curl,CURLOPT_URL, $url);
curl_setopt($curla,CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curla,CURLOPT_RETURNTRANSFER, TRUE);

$result = curl_exec($curl);

preg_match_all("!https://image-eu.ssl-image-amazon.com/image/I/[^\s]*._AC_US218_.jpg!",
$result , $match);
print_r($images);
for($i; $i< count($images); $i++){

    echo "<img src='$images[i]'></br>";
}
$images =array_values(array_unique($match[0]));
curl_close($curl);
?>

