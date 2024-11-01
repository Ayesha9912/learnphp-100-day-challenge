////Client url  the php libraray ;;; which help to recieve the get the proper responses through Api"s
/* " and ends with " */
cURL (Client URL) is a PHP library for transferring data across various protocols (HTTP, HTTPS, FTP, etc.).
Primarily used for making HTTP requests in PHP, like interacting with REST APIs or downloading files from URLs.

Basic function in cUrl libraray
1- curl_init() => it initialize the process
2- curl_setopt() => it set option for a url
3- curl_exec() => it excecutes the url
4- curl_close()=> it closes the url session

<!-- //////////////////Live examples //////////////////// -->

//it is used to create the http requests
1- create cURL resource
$curl = curl_init()


2-Set curl option
curl_setopt($curl , CURLOPT_URL , 'http://www.google.com')


3-Run cURL (executes http request)
curl_exec($curl)


4-Close the cUrl
curl_close($curl);









