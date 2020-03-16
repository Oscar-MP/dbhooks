<?php
  /**
  * Librería encargada de cargar y gestionar los conectores
  */

  // CONSTANTS

  define('CONNECTORS_PATH', './connectors');

  // FUNCTIONS

  function loadAllConnectors( $connectorsPath = null ) {
    // This functions loads all connectors and return an array with them.
    $connectorsPath = $connectorsPath === null ? CONNECTORS_PATH : $connectorsPath;
    $connectorsPaths = getFolderFilePaths($connectorsPath);
    $connectors = array();

    foreach ($connectorsPaths as $index => $path) {
      $connector = loadConnector($path);

      if ($connector) array_push($connectors, $connector);
    }

    return $connectors;
  }

  function getConnector($name, $path = null ) {
      // Devuelve un objeto connector unico en base al nombre o al path
  }

  function loadConnector ($path) {
    // Obtiene la información de un connector y devuelve un objeto conector con ella.
    $full_path = CONNECTORS_PATH . '/' . $path;

    if ( file_exists($full_path)) {
      return new Connector(json_decode(file_get_contents($full_path), true)['connector']);
    }
    return false;
  }
  function saveConnector () {

  }

  function updateConnector () {

  }

  function removeConnetor () {

  }


?>
