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

    function disconnect() {
      $this->conexion = null;
    }
    // MAIN METHODS

    function get ( $hook ) {
      // Select records from a table

      $table = $hook->mysql['table'];
      $query = 'SELECT * FROM ' . $table;
      
      return $this->query($query);

    }

    function put () {}

    function update () {}

    function remove () {}


    // UTILITY METHODS
    function query( $query ) {
      // Executes a query
      $stmt = $this->conexion->prepare($query);

      if ($stmt && ($query_response = $stmt->execute())) {
        $data = $stmt->fetch();
        $stmt = null;

        return $data;

      }
    }

    function setCondition() {}

    function setSelect () {}

    function setTable () {}

    function setOrderBy () {}



  }
?>
