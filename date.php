<?php
// Assuming today is March 10th, 2001, 5:16:18 pm, and that we are in the
// Mountain Standard Time (MST) Time Zone

$today = date("F j, Y, g:i a");                 // March 10, 2001, 5:16 pm
$today = date("m.d.y");                         // 03.10.01
$today = date("j, n, Y");                       // 10, 3, 2001
$today = date("Ymd");                           // 20010310
$today = date('h-i-s, j-m-y, it is w Day');     // 05-16-18, 10-03-01, 1631 1618 6 Satpm01
$today = date('\i\t \i\s \t\h\e jS \d\a\y.');   // it is the 10th day.
$today = date("D M j G:i:s T Y");               // Sat Mar 10 17:16:18 MST 2001
$today = date('H:m:s \m \i\s\ \m\o\n\t\h');     // 17:03:18 m is month
$today = date("H:i:s");                         // 17:16:18
$today = date("Y-m-d H:i:s");                   // 2001-03-10 17:16:18 (the MySQL DATETIME format)
?>

<!-- //learning Dates -->


<!-- Character
Description
Sample Output
d
Day of the month, 2 digits with leading zeros
01 to 31

D
A textual representation of a day, three letters  
Mon through Sun

j
Day of the month without leading zeros
1 to 31

l
A full textual representation of the day of the week               
Sunday through Saturday

s
Seconds with leading zeros         
00 through 59

S
English ordinal suffix for the day of the month, 2 characters          
st, nd, rd or th. Works well with j

H
24-hour format of an hour with leading zeros     
00 through 23

i
Minutes with leading zeros         
00 to 59

F
A full textual representation of a month, such as January or March            
January through December

m
Numeric representation of a month, with leading zeros    
01 through 12

M
A short textual representation of a month, three letters  
Jan through Dec

n
Numeric representation of a month, without leading zeros    
1 through 12

t
Number of days in the given month        
28 through 31

G
24-hour format of an hour without leading zeros
0 through 23

h
12-hour format of an hour with leading zeros     
01 through 12

y
A full numeric representation of a year, 4 digits 
Examples: 1999 or 2003

Y
A two-digit representation of a year       
Examples: 99 or 03

a
Lowercase Ante meridiem and Post meridiem    
am or pm

A
Uppercase Ante meridiem and Post meridiem    
AM or PM
 -->
