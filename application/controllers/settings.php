<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Controller {

	public function __construct() {
		parent::__construct();
    }

	public function index() {
		$mysession = $this->session->userdata('logged');
		if (!$mysession) redirect('index');
		$student_id = $this->uri->segment(2);
		if(!empty($student_id) && is_numeric($student_id) && $mysession['user_level'] == 99) {
			$user_id = $student_id;
			$action = 1;
		} else {
			$user_id = $mysession['user_id'];
			$action = 0;
		}

		$this->db->from('users');
		$this->db->where('user_id', $user_id);
		$info = $this->db->get();

		$data = array(
			'session' => $mysession,
			'action'  => $action,
			'info'    => $info->result()
		);
		
		$this->load->view('settings', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
