  <?php

  class Connector {

    public $id;
    public $alias;
    public $type;
    public $endpoint; // Could be an IP or a path.
    public $port;

    public const VALID_TYPES = [
      'mysql',
      'fs'
    ];

    function __construct( $objct ) {
      $this->fillClass($objct);
    }

    function fillClass ( $obj ) {
      // This function fills the variables of the clase getting the data from an object
      if (array_key_exists('id', $obj)) {
        $this->id = $obj['id'];
      }

      if (array_key_exists('alias', $obj)) {
        $this->alias = $obj['alias'];
      }

      if (array_key_exists('type', $obj)) {
        $this->type = $obj['type'];
      }

      if (array_key_exists('endpoint', $obj)) {
        $this->endpoint = $obj['endpoint'];
      }

      if (array_key_exists('port', $obj)) {
        $this->port = $obj['port'];
      }

    }

    function isValidType($type = null) {
      // Returns bool depending on the type
      $type = $type == null ? $this->type : $type;

      return array_key_exists($type, VALID_TYPES);
    }

    function json () {
      // Codifica el objeto connector en un json para guardarlo en un fichero.
    }

    static function filterConnectorsByAlias() {}

    static function getConnectorByAlias() {}

    static function getConnectorByID() {}
  }


  class MySQLConnector extends Connector {

    private $db;
    private $user;
    private $pass;
    public $charset = 'utf8';
    public $options = [
      PDO::ATTR_ERRMODE             => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE  => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES    => false
    ];

    function __construct (){

    }

    function getDSN () {
      return 'mysql:host=' . $this->endpoint . ';dbname=' . $this->db . ';charset=' . $this->charset;
    }

    function getUser()            { return $this->user;   }
    function setUser($user)       { $this->user = $user;  }
    function getPassword()        { return $this->pass;   }
    function setPassword($pass)   { $this->pass = $pass;  }

  }
?>
