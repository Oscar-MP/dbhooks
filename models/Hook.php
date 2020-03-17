<?php

  class Hook {

    public $alias;
    private $permission;
    private $connector;
    public $connectorAlias;
    private $action;
    public $mysql = array();
    public $messages = array();


    function __construct($arrayObject = null) {
      if ($arrayObject) {
        $this->setParamsFromArray($arrayObject);
      }
    }

    function setParamsFromJSON( $input ) {

    }

    function setParamsFromArray( $input ) {
        // This function must fill the object with data from an array.
        if (is_array($input)) {
          foreach ($input as $element => $value) {
            if ( property_exists('Hook', $element)) {
              $this->$element = $value;
            }
          }
        }
    }

    function getActions() {
      return $this->action;
    }

    function setActions( $actions = array()) {
      if ($this->checkAllowedActions($actions)) {
        $this->action = $actions;
        return true;
      }

      return false;
    }

    function getConnector() { return $this->connector; }
    function setConnector( $connector = null ) {
      // Check if the connector is an instance of a connector object
      // if not we check if there is a reference to the connector and we search for it
      if ( $connector !== null && ( $connector instanceof Connector || $connector instanceOf MySQLConnector) ) {


      } else {
        // We use the conector in the hook. We must search by ID or alias ( ID is better )
        $_CONNECTORS_ = loadAllConnectors();

        if (!empty($this->connector)) {
          // Searching by the connector ID
          $connector = filterObjectsByParam($_CONNECTORS_, 'id', $this->connector);
        } else {
          if (!empty($this->connectorAlias)) {
            // We search by the alias
            $connector = filterObjectsByParam($_CONNECTORS_, 'alias', $this->connector);
          }
        }
        if ($connector !== false) {
          $this->connector = $connector;
        }
      }

    }

    function setPermissionLevel ( $level = 0 ) {
      if ( $level >= 0 && $level <= 5 ) {
        $this->permission = $level;
        return true;
      }

      return false;
    }

    function getPermissionLevel () {
      return $this->permission;
    }


    // Utility methods

    function checkAllowedActions( $actions = null ) {
      $allowedActions = ['get', 'put', 'update', 'remove'];
      if ($actions == null) $actions = $this->action;

      foreach ($actions as $action) {
        if (!in_array($action, $allowedActions)) return false;
      }

      return true;
    }

    // STATIC methods

    static function getHook($alias) {
      // This method gets the information from a json file and generates a hook object
      // if everything is ok the method will return a Hook object.

      // WARNING This method is insecure, someone could see files from direcctories changing
      // the hook alias for a path like: hook = ../<some rute from the app folder>

      $hook = self::filterHookByParam(scan_folder('hooks'), 'alias', $alias);
      return new Hook($hook[0]);

      // WARNING ESTE METODO PUEDE LLEVAR A LA LECTURA NO PERMITIDA DE OTROS FICHEROS JSON
    }

    static function filterHookByParam( $hooks, $key, $param ) {
      // This is used to filter all hooks to identify one by the alias
      return array_filter($hooks, function ($hook) use ($key, $param){
        return $hook[$key] == $param;
      });
    }

    static function saveHook($hook) {}

    static function updateHook($hook) {}

    static function removeHook($hook) {}
  }
?>
