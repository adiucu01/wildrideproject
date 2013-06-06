<?php

class Request {

	public function getParam($param) {
    if(isset($_REQUEST[$param]) && $_REQUEST[$param]) {
      return $_REQUEST[$param];
    }
    return null;
  }

}
