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

  $res    = new Response();
  $client = array(
    "permissionLevel" => 0
  );


  if ( filter_has_var(INPUT_GET, 'hook')) {
    if ( filter_has_var(INPUT_GET, 'action')) {

      /**
        * TODO:
        * Must first identify the hook, then laod the connector
        * Watch for permissions and stablish mysql connection. Then
        * we preform the action.
        *
        * Quizá sería mejor añadir un nivel de permisos para cada acción dentro del
        * hook, en vez de un nivel de permisos para todo el hook
        */
        $hook = Hook::getHook($_GET['hook']);

        // Check if we have enough permissions for accessing this hook
        // Gestión temporal, esto cambiará cuando se añada la autenticación y los módulos de seguridad.

        if ($client['permissionLevel'] < $hook->getPermissionLevel()) {
          $res->send(400, 'You have not enough permissions.');
          exit();
        }

        // Getting the right connector
        // .. code for getting the connector.
        var_dump($_CONNECTORS_);


        // Stablish the mysql connection

        // .. mysql stuff in here

        // EVALUATE THE ACTION AND PREFORM IT
        // IF EVERYTHING IS OK
        

    } else {
      $res->send(400, "Could not proceed. Missing action");
    }
  } else {
    $res->send(400, "Not enough parameters");
  }


?>
