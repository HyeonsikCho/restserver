<?php
require(APPPATH . 'libraries/REST_Controller.php');

class Books extends REST_Controller
{
  public function index_get()
  {
    // Display all books
	$data = array('returned: '. $this->get('name'));	
	$this->response($data);
  }

  public function index_post()
  {
    // Create a new book
	$data = array('returned: '. $this->post('name'));	
	$this->response($data);
  }
}

?>
