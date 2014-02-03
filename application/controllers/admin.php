<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct() {
		parent::__construct();
    }

	public function index() {
		$mysession = $this->session->userdata('logged');
		if(!$mysession) redirect('index');
		if($mysession['user_level'] == 0) redirect('index');

		$data = array(
			'title'   => 'Admin',
			'session' => $mysession
		);
		
		$this->load->view('admin', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */