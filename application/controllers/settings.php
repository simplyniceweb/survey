<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Controller {

	public function __construct() {
		parent::__construct();
    }

	public function index() {
		$mysession = $this->session->userdata('logged');
		if (!$mysession) redirect('index');

		$this->db->from('users');
		$this->db->where('user_id', $mysession['user_id']);
		$info = $this->db->get();

		$data = array(
			'session' => $mysession,
			'info'    => $info->result()
		);
		
		$this->load->view('settings', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */