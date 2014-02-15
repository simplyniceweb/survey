<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ban extends CI_Controller {

	public function __construct() {
		parent::__construct();
    }

	public function index() {
		$mysession = $this->session->userdata('logged');
		if (!$mysession) redirect('index');
		
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
			'session' => $mysession,
			'student' => $student->result(),
			'department'   => $department->result()
		);
		
		$this->load->view('ban_page', $data);
	}
	
	public function get_students() {
		$department_id = $this->input->post('department_id');
		$action = $this->input->post('action');
		if(!is_numeric($department_id) || !is_numeric($action)) return false;

		$this->db->select('*');
		$this->db->from('users');
		$this->db->join('student_id', 'student_id.unique = users.user_std_id');
		$this->db->where('users.user_status', $action);
		$this->db->where('student_id.department_id', $department_id);
		$student = $this->db->get();

		$data = array(
			'student_count' => $student->num_rows(),
			'student'       => $student->result()
		);
		$this->load->view('includes/students', $data);
	}
	
	public function process() {
		$user_id = $this->input->post("student_id");
		$action = $this->input->post("action");
		$unban_date = $this->input->post("unban_date");
		if(!is_numeric($user_id) || !is_numeric($action)){
			return false;
		}
		
		if($action == 1) {
			$today = date("Y-m-d");
			if($unban_date < $today) {
				redirect("ban?date=less");
			} else if($today == $unban_date) {
				redirect("ban?date=equal");
			}
			$data['ban_date'] = $unban_date;
		} else {
			$data['ban_date'] = "0000-00-00";
		}

		$data['user_status'] = $action;
		
		$this->db->where('user_id', $user_id);
		$this->db->update('users', $data);
		
		if($action == 1) {
			redirect("ban?action=1");
		} else {
			redirect("ban?action=0");
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */