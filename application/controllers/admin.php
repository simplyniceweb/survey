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
	
	public function edit_user() {
		$mysession = $this->session->userdata('logged');
		if(!$mysession) redirect('index');
		if($mysession['user_level'] == 0) redirect('index');
		
		$this->db->from('users');
		$this->db->where('user_status', 0);
		$this->db->where('user_level', 0);
		$this->db->order_by("user_id", "desc"); 
		$student = $this->db->get();
		
		$this->db->from('department');
		$this->db->where('department_status', 0);
		$this->db->order_by("department_id", "desc"); 
		$department = $this->db->get();
		
		$data = array(
			'title'   => 'Admin',
			'session' => $mysession,
			'student' => $student->result(),
			'department'   => $department->result()
		);

		$this->load->view('users', $data);
	}

	public function user_list() {
		$mysession = $this->session->userdata('logged');
		if(!$mysession) redirect('index');
		if($mysession['user_level'] == 0) redirect('index');
		
		$department_id = $this->input->post("department_id");
		
		$this->db->select('*');
		$this->db->from('student_id');
		$this->db->join('users', 'users.user_std_id = student_id.unique', 'inner');
		$this->db->join('department', 'department.department_id = student_id.department_id', 'inner');
		$this->db->where('student_id.department_id', $department_id);
		$this->db->where("student_id.id_status", 0);
		$this->db->where("users.user_status", 0);
		$this->db->where("department.department_status", 0);
		$students = $this->db->get();
		
		$data = array(
			'students' => $students->result()
		);
		
		$this->load->view('user_info', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
