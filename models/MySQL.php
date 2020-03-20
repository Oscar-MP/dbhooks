<?php

  class MySQL {

    private $conexion; // Here is saved the MySQL conexion
    protected $hook;

    function __construct() {}

    function connect( $mysql_connector ) {
      // This function sets the conection. A mysql connector is required thru parameter.
      if (!$mysql_connector instanceof MySQLConnector) {
        // The input is not a MySQL Connector
        return false;
      }

      try {
        $this->conexion = new PDO(
          $mysql_connector->getDSN(),
          $mysql_connector->getUser(),
          $mysql_connector->getPassword(),
          $mysql_connector->options
        );

        return true;

      } catch ( PDOException $err ) {
        // An error with the DB conexion has occur. We may want to log this into a file.
        return false;
      }
    }

    // MAIN METHODS

    function get ( $hook ) {
      // Select records from a table
    }

    function put () {}

    function update () {}

    function remove () {}


    // UTILITY METHODS
    function prepare( $query ) {
      // Probably we don't need this.
    }
    function execute() {
      // Executes a query
    }

    function setCondition() {}

    function setSelect () {}

    function setTable () {}

    function setOrderBy () {}



  }
?>
