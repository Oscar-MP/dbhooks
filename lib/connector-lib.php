<?php
  /**
  * Librería encargada de cargar y gestionar los conectores
  */

  // CONSTANTS

  define('CONNECTORS_PATH', '../connectors');

  // FUNCTIONS

  function loadAllConnectors( $connectorsPath = null ) {
    // This functions loads all connectors and return an array with them.
    $connectorsPath = $connectorsPath === null ? CONNECTORS_PATH : $connectorsPath;
  }

  function getConnector($name, $path = null ) {

  }

  function saveConnector () {
    
  }

  function updateConnector () {

  }

  function removeConnetor () {

  }


?>
