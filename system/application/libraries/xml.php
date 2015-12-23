<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Xml {
  function Xml () {
  }

  private $document;
  private $filename;

  public function load ($file) {
    /***
     * @public
     * Load an file for parsing
     */
   // $bad  = array('|//+|', '|\.\./|');
    //$good = array('/', '');
    $file = $file.'.xml';

    if (! file_exists ($file)) {
      return false;
    }

    $this->document = utf8_encode (file_get_contents($file));
    $this->filename = $file;

    return true;
  } 

  public function parse () {
  
    $xml = $this->document;
    if ($xml == '') {
      return false;
    }

    $doc = new DOMDocument ();
    $doc->preserveWhiteSpace = false;
    if ($doc->loadXML ($xml)) {
      $array = $this->flatten_node ($doc);
      if (count ($array) > 0) {
        return $array;
      }
    }

    return false;
  }
  private function flatten_node ($node) {
   
    $array = array();

    foreach ($node->childNodes as $child) {
      if ($child->hasChildNodes ()) {
        if ($node->firstChild->nodeName == $node->lastChild->nodeName && $node->childNodes->length > 1) {
          $array[$child->nodeName][] = $this->flatten_node ($child);
        }
        else {
          $array[$child->nodeName][] = $this->flatten_node($child);

          if ($child->hasAttributes ()) {
            $index = count($array[$child->nodeName])-1;
            $attrs =& $array[$child->nodeName][$index]['__attrs'];
            foreach ($child->attributes as $attribute) {
              $attrs[$attribute->name] = $attribute->value;
            }
          }
        }
      }
      else {
        return $child->nodeValue;
      }
    }

    return $array;
  } 
}
