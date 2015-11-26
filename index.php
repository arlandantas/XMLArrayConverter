<?php

include "XMLArrayConverter.php";                // Include the class file.
$converter = new XMLArrayConverter();           // Create a instance of the class.
print_r($converter->readFile('file.xml'));      // Print the content of the file.xml into an Array.

?>
