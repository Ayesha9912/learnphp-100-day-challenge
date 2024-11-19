<!-- autoloading is a way to automatically include class files of a project in your code -->
<?php
function __autoload($class){
require "classes/" . $class . ".php";

}
$test = new second() ////this is the class name whose file you want to get

?>