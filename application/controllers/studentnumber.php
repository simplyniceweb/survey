<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Studentnumber extends CI_Controller {

	public function __construct() {
		parent::__construct();
    }

	public function index() {
		$mysession = $this->session->userdata('logged');
		if(!$mysession) redirect('index');

		if($mysession['user_level'] == 0) redirect('index');

		$this->db->from('student_id');
		$this->db->where('id_status', 0);
		$this->db->order_by("student_id", "desc"); 
		$student = $this->db->get();
		
		$this->db->from('department');
		$this->db->where('department_status', 0);
		$this->db->order_by("department_id", "desc"); 
		$department = $this->db->get();
		
		$data = array(
			'session' => $mysession,
			'student_id' => $student->result(),
			'department'   => $department->result()
		);
		
		$this->load->view('studentNumber', $data);
	}
	
	public function student_no_add() {
		$mysession = $this->session->userdata('logged');
		if(!$mysession) redirect('index');
		
		$data = array(
			'unique'        => $this->input->post('student_id'),
			'department_id' => $this->input->post('department_id')
		);
		
		// Check for duplicate student id
		$this->db->from('student_id');
		$this->db->where('unique', $data['unique']);
		$duplicate = $this->db->get();
		
		if($duplicate->num_rows() > 0) {
			foreach($duplicate->result() as $dup) {
				if($dup->id_status == 0) {
					redirect('studentnumber?exist=true');
					return false;
				} else {
					$status = array(
						'id_status' => 0
					);
				
					$this->db->where('unique', $data['unique']);
					$this->db->update('student_id', $status);
				}
			}
		} else {
			$this->db->insert('student_id', $data);
		}
		
		redirect('studentnumber');
	}
	
	public function student_no_edit() {
		$mysession = $this->session->userdata('logged');
		if(!$mysession) redirect('index');

		$data = array(
			'unique' => $this->input->post('new_student_id'),
			'department_id' => $this->input->post('department_id')
		);
		$unique = $this->input->post('student_id');

		$this->db->where('unique', $unique);
		$this->db->update('student_id', $data);
		
		redirect('studentnumber');
	}

	public function student_no_delete() {
		$mysession = $this->session->userdata('logged');
		if(!$mysession) redirect('index');

		$delete = array(
			'id_status' => 1
		);

		$student_id = $this->input->post('student_id');

		$this->db->where('student_id', $student_id);
		$this->db->update('student_id', $delete);
		
		redirect('studentnumber');
	}
	
	public function get_student_no() {
		$department_id = $this->input->post('department_id');

		$this->db->from('student_id');
		$this->db->where('id_status', 0);
		$this->db->where('department_id', $department_id);
		$this->db->order_by("student_id", "DESC"); 
		$student = $this->db->get();
		
		$data = array(
			'student_count' => $student->num_rows(),
			'student_id'    => $student->result()
		);

		$this->load->view('includes/studentnumber', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
