<?php

  class Hook {

    public $alias;
    private $permission;
    private $connector;
    private $action;


    function __construct($arrayObject = null) {
      if ($arrayObject) {
        $this->setParamsFromArray($arrayObject);
      }
    }

    function setParamsFromJSON( $input ) {

    }

    function setParamsFromArray( $input ) {

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
      $hook = self::filterHookByParam(getAllFileContentInFolder('hooks'), 'alias', $alias);

    }

    static function filterHookByParam( $hooks, $key, $param ) {
      // This is used to filter all hooks to identify one by the alias
      return array_filter($hooks, function ($hook) use ($key, $param){
        return $hook[$key] == $param;
      });
    }
  }
?>
