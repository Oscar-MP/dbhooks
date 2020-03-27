<?php

  class Response {
    public $message = '';
    public $status;
    public $data;

    function __construct() {
      $this->message = 'Something went wrong';
      $this->status  = 500;
      $this->data = array();
    }

    function send( $status = null, $msg = null ) {
      if ( $status != null ) $this->status = $status;
      if ( $msg != null ) $this->message = $msg;

      $response = array(
        "status"  => $this->status,
        "message" => $this->message
      );

      if (!empty($this->data)) $response['data'] = $this->data;

      echo json_encode($response);
    }
  }
?>
