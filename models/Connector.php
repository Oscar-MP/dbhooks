<?php

  class Connector {

    public $alias;
    public $type;
    public $endpoint; // Could be an IP or a path.
    public $port;

    public const VALID_TYPES = [
      'mysql',
      'fs'
    ];

    function __construct( $objct ) {

    }

    function fillClass ( $obj ) {
      // This function fills the variables of the clase getting the data from an object

    }

    function isValidType($type = null) {
      // Returns bool depending on the type
      $type = $type == null ? $this->type : $type;

      return array_key_exists($type, VALID_TYPES);
    }

    function json () {
      // Codifica el objeto connector en un json para guardarlo en un fichero.
    }
  }

?>
