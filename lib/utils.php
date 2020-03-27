<?php


  function getFolderFilePaths( $folder ) {
    // Obtiene todos los paths a ficheros dentro de una carpeta

    if (is_dir($folder)) {
      return array_diff(scandir($folder), array('.', '..'));
    }

    return false;
  }

  function getFileContent( $path ) {
    // This function returns the content of a file
    // if succed the function will return the raw info, if not it will return a false.

    if (file_exists($path)) {
      $content = file_get_contents($path);

      if ($content !== false) return $content;
    }

    return false;

  }

  function scan_folder ( $folderPath ) {
    // This function returns an array where every element
    // represents the content of every file inside a specific folder.
    // If the function cannot retrieve the info it will return a false.

    // WARNING THIS FUNCTIONS MUST BE REMOVED
    $output = array();

    if (is_dir($folderPath)) {
      foreach (getFolderFilePaths($folderPath) as $fileName) {
        $file = json_decode(getFileContent($folderPath . '/' . $fileName), true);

        if ($file) {
          array_push($output, $file);
        }
      }

      return $output;
    }

    return false;
  }


  function filterArrayByParam($array, $param, $key) {
    // Returns an array that matches the specified key in a param
    return array_filter($array, function ( $item ) use ($param, $key){
      return $item[$key] == $param;
    });
  }

  function filterObjectsByParam($array, $param, $key) {
    // Needs an array of objects and returns a single object matching the provided param -> key

    foreach ( $array as $object ) {
      if (is_object($object)) {
        if (property_exists( get_class($object) , $param )) {
          if ( $object->{$param} == $key ) return $object;
        }
      }
    }
    return false;


  }

  function generateRandomChars( $len = 5 ) {
    if ($len <= 0 ) $len = 1; 

    if (function_exists('openssl_random_pseudo_bytes')) {
      return base64_encode(openssl_random_pseudo_bytes($len));
    }
  }


  // Security functions

  function filterInvalidPath($path, $options) {
    // This function filters a given string to remove all potentiall attacks to cross directory.
    // If we need to get a path and the client is able to manipulate it then we must ensure the user hasn't changed it
    // in order to get access to an unallowed place.
    // For example: Desired path: /connectors/<input>
    //              Malformed path: /connectors/../../../../../etc/shadow

    $default_options = array();

    if (!$options['ALLOW_CHANGE_DIRECTORY']) {
      // Removes all dots and slashes from the path

    }

    if (!$options['ALLOW_EXTENSIONS']) {
      // Removes the extensión if it is in the path
    }

    return $path;
  }
?>
