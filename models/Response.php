<?php

  class Response {
    public $message = '';
    public $status;

    function __construct() {
      $this->message = 'Something went wrong';
      $this->status  = 500;
    }

    function send( $status = null, $msg = null ) {
      if ( $status != null ) $this->status = $status;
      if ( $msg != null ) $this->message = $msg;

      echo json_encode(array(
        "status"  => $this->status,
        "message" => $this->message
      ));
    }
  }
?>
