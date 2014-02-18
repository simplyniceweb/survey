<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Department extends CI_Controller {

	public function __construct() {
		parent::__construct();
    }

	public function index() {
		$mysession = $this->session->userdata('logged');
		if(!$mysession) redirect('login');

		//if($mysession['user_level'] == 0) redirect('index');

		$this->db->from('department');
		$this->db->where('department_status', 0);
		$this->db->order_by("department_id", "desc"); 
		$department = $this->db->get();
		
		$data = array(
			'session' => $mysession,
			'department' => $department->result()
		);
		
		$this->load->view('department', $data);
	}
	
	public function department_add() {
		$mysession = $this->session->userdata('logged');
		if(!$mysession) redirect('login');
		
		$data = array(
			'department_name'    => $this->input->post('department_name'),
			'department_status' => 0
		);

		// Check for duplicate student id
		$this->db->from('department');
		$this->db->where('department_name', $data['department_name']);
		$duplicate = $this->db->get();
		
		if($duplicate->num_rows() > 0) {
			foreach($duplicate->result() as $dup) {
				if($dup->department_status == 0) {
					redirect('department?exist=true');
					return false;
				} else {
					$status = array(
						'department_status' => 0
					);
				
					$this->db->where('department_name', $data['department_name']);
					$this->db->update('department', $status);
				}
			}
		} else {
			$this->db->insert('department', $data);
		}
		
		redirect('department?add=true');
	}
	
	public function department_edit() {
		$mysession = $this->session->userdata('logged');
		if(!$mysession) redirect('login');

		$data = array(
			'department_name' => $this->input->post('new_department_name')
		);
		
		$old = $this->input->post('department_name');
		
		$this->db->from('department');
		$this->db->where('department_name', $data['department_name']);
		$exist = $this->db->get();
		
		if($exist->num_rows() > 0) {
			redirect('department?exist=true');
			return false;
		}
		
		$this->db->where('department_id', $old);
		$this->db->update('department', $data);
		
		redirect('department?edit=true');
	}

	public function department_delete() {
		$mysession = $this->session->userdata('logged');
		if(!$mysession) redirect('login');

		$delete = array(
			'department_status' => 1
		);

		$old = $this->input->post('department_name');

		$this->db->where('department_id', $old);
		$this->db->update('department', $delete);
		
		redirect('department?delete=true');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */