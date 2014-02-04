<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller {

	public function __construct() {
		parent::__construct();
    }

	public function index() {
		$mysession = $this->session->userdata('logged');
		if($mysession) redirect('main');

		$unban = $this->db->query("SELECT * FROM users WHERE ban_date < NOW()");
		$status = array(
			'user_status' => 0,
			'ban_date'    => "0000-00-00"
		);
		
		if($unban->num_rows() > 0) {
			foreach($unban->result() as $unb) {
				$this->db->where('user_id', $unb->user_id);
				$this->db->update('users', $status);
			}
		}

		$this->load->view('login');
	}
	
	public function register() {
		$mysession = $this->session->userdata('logged');
		if($mysession) redirect('main');

		$this->load->view('register');
	}

	public function verify() {
		$mysession = $this->session->userdata('logged');
		if($mysession) redirect('main');
		
		$data = array(
			'user_email'    => $this->input->post('user_email'),
			'user_password' => sha1($this->input->post('user_password'))
		);

		$this->db->from('users');
		$this->db->where('user_email', $data['user_email']);
		$this->db->where('user_password', $data['user_password']);
		$this->db->limit(1);
		$login = $this->db->get();

		if($login->num_rows() == 0) redirect('index/?login=false');
		
		foreach($login->result() as $row) {

			if($row->user_status == 1) redirect('index/?ban=true');

			$department = NULL;
			$sess_array = array(
				'logged'          => true,
				'user_id'         => $row->user_id,
				'user_name'       => $row->user_name,
				'user_email'      => $row->user_email,
				'user_std_id'     => $row->user_std_id,
				'user_level'      => $row->user_level,
				'profile_picture' => $row->profile_picture,
			);
			
			$this->db->from('student_id');
			$this->db->where('unique', $sess_array['user_std_id']);
			$department = $this->db->get();
			
			if($department->num_rows > 0) {
				foreach($department->result() as $dept) {
					$department = $dept->department_id;
				}
			}
			
			$sess_array['department'] = $department;
		}

		$this->session->set_userdata('logged', $sess_array);
		
		if($row->user_level == 0) {
			redirect('main');
		} else {
			redirect('admin');
		}
	}
	
	public function process() {

		$mysession = $this->session->userdata('logged');
		if($mysession) redirect('main');

		$data = array(
			'user_name'     => $this->input->post('user_name'),
			'user_email'    => $this->input->post('user_email'),
			'user_password' => sha1($this->input->post('user_password')),
			'user_birthday' => $this->input->post('user_birthday'),
			'user_std_id'   => $this->input->post('user_std_id'),
		);
		
		$this->db->from('student_id');
		$this->db->where('unique', $data['user_std_id']);
		$validStudentId = $this->db->get();
		if(!$validStudentId->result()) redirect('index/register/?std_id=invalid');
		
		$this->db->from('users');
		$this->db->where('user_std_id', $data['user_std_id']);
		$usedStudentId = $this->db->get();
		if($usedStudentId->result()) redirect('index/register/?used_id=true');

		$this->db->insert('users', $data);

		redirect('index/register/?add=true');
	}
	
	public function update() {
		$mysession = $this->session->userdata('logged');
		if(!$mysession) redirect('');
		
		$profile_picture = NULL;
		$original_image = $this->input->post('original_photo');	

		$config = array(
			'upload_path'   => 'assets/images/',
			'allowed_types' => 'gif|jpg|png',
			'is_image'      => 1,
			'encrypt_name'  => TRUE,
			'xss_clean'     => TRUE
		);
		
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if ( $this->upload->do_upload() ) {
			$upload_data = $this->upload->data();
			$profile_picture = $upload_data['file_name'];
			
			if($original_image != "") {
				$link = 'assets/images/'.$original_image;
				if(file_exists($link)) {
					unlink($link);
				}
			}
		} else if(! $this->upload->do_upload() && $original_image != "") {
			$profile_picture = $original_image;
		}

		$user_id = $this->input->post("user_id");

		$this->db->from('users');
		$this->db->where('user_id', $user_id);
		$is_user = $this->db->get();
		
		if($is_user->num_rows > 0) {
			$data = array(
				'profile_picture'      => $profile_picture,
				'user_name'            => $this->input->post('student_username'),
				'user_email'           => $this->input->post('student_email'),
				'civil_status'         => $this->input->post('civil_status'),
				'student_address'      => $this->input->post('student_address'),
				'student_phone_number' => $this->input->post('student_phone_number'),
				'user_birthday'        => $this->input->post('student_birthday'),
			);
			
			$password = $this->input->post("student_password");
			
			if(!empty($password)) {
				$data['user_password'] = sha1($password);
			}
			
			$this->db->where('user_id', $user_id);
			$this->db->update('users', $data);
			
			if($mysession['user_id'] == $user_id) {
				redirect('settings/?update=true');
			} else {
				redirect('settings/'. $user_id .'?update=true');
			}
			
		} else {
			return FALSE;
		}
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
