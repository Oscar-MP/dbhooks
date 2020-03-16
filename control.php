<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


  include_once('./models/Connector.php');
  include_once('./models/Hook.php');
  include_once('./models/Response.php');
  include_once('./lib/connector-lib.php');
  include_once('./lib/utils.php');

  // Obtenemos toda la configuración (conectores y dbhooks)
  // Y todos los parametros que requiere la api
  $_CONNECTORS_ = loadAllConnectors();
  $_DBHOOKS_    = [];

  // Dependiendo del dbhook usaremos un connector u otro

  $res = new Response();


  if ( filter_has_var(INPUT_GET, 'hook')) {
    if ( filter_has_var(INPUT_GET, 'action')) {

      /**
        * TODO:
        * Must first identify the hook, then laod the connector
        * Watch for permissions and stablish mysql connection. Then
        * we preform the action.
        */
        $hook = Hook::getHook('default');

    } else {
      $res->send(400, "Could not proceed. Missing action");
    }
  } else {
    $res->send(400, "Not enough parameters");
  }


?>
