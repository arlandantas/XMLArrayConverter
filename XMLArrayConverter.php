<?php

/**
 * Convert an XML file into Array.
 *
 *  @author: Arlan Dantas <lanfsa@hotmail.com>
 */
class XMLArrayConverter
{
    /**
    * Read the file value and returns their content in an array.
    * @param string $path is the path (local or remote) of the file to read
    * @return Array
    */
    function readFile($path) {
        $Reader = new XMLReader;                                    // Create the object that reads the XML file.
        $Reader->open($path);                                       // Open the XML file.
        $return = array();                                          // Create the array to return the Array.

        $Reader->read();                                            // Read the first line of the XML.
        $return[$Reader->localName] = $this->readNode($Reader);     // Create the root item of the XML on Array and read their value.

        return $return;
    }

    /**
    * Read the node value and return it in an array or string.
    * @param XMLReader $reader is the XMLReader that is reading the file
    * @return Array
    */
    function readNode(&$reader) {
        $ret = NULL;                                                // Create the return as null

        $count[] = Array();                                         // This array is used to know the repeated indexes
        $commonName = NULL;                                         // It's used to don't repeat the same name in indexes.

        while ($reader->read()) {                                   // Read the next line.
            if($reader->nodeType == 1) {                            // It's the line that opens the node.
                if($ret == NULL) {
                    $ret = array();                                 // Set the return as array.
                }
                $name = $reader->localName;
                if ($commonName == $name) {                         // BLOCK start.
                    $name = count($ret);                            // This BLOCK is used to know if the name of this node
                } else if (isset($count[$name])) {                  // is used before, if it is true, we just add the array
                    $commonName = $name;                            // to the parent object without named indexes
                    $ret[count($ret)-1] = $ret[$name];
                    unset($ret[$name]);
                    $name = count($ret);
                } else {
                    $count[$name] = 1;
                }                                                   // BLOCK end.
                $ret[$name] = $this->readNode($reader);
            } else if($reader->nodeType == 3) {                     // It's the line with the node text value,
                $ret = $reader->value;                              // so, set the return as this line value.
            } else if($reader->nodeType == 15) {                    // It's the line that closes the node
                break;                                              // so, break this loop, and return.
            } else {                                                // Any other type of node
                //echo "Unknown type: ".$reader->nodeType.'</br>';    // Print a error text.
            }
        }
        return $ret;
    }
}


?>
