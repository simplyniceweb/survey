<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {

	public function __construct() {
		parent::__construct();
    }

	public function index() {
		$mysession = $this->session->userdata('logged');
		if (!$mysession) redirect('index');
		
		$this->session->unset_userdata('logged');
		redirect('index');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */