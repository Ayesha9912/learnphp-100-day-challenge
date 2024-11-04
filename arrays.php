///there are three types of array
1- Index array => let $arr = ("red", "orange", "blue")
2-Associative Array => let $arr = ("red=> 14" , "orange=> 34", "blue=> 35") ///It gives both index and value or we can say key and array_values
3- Multi-dimensional=> it is the mixer of both index and associative array

///the diff between unset and array_splice
unset=> remove index and value and leave the space of that index
array_splice=>  after removinf start a new Index

sort() - sort arrays in ascending order
rsort() - sort arrays in descending order
asort() - sort associative arrays in ascending order, according to the value
ksort() - sort associative arrays in ascending order, according to the key
arsort() - sort associative arrays in descending order, according to the value
krsort() - sort associative arrays in descending order, according to the key

$cars = array (
  array("Volvo",22,18),
  array("BMW",15,13),
  array("Saab",5,2),
  array("Land Rover",17,15)
);