<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Survey extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('MY_Upload');
    }

	public function index() {
		$mysession = $this->session->userdata('logged');
		if (!$mysession) redirect('');
		if($mysession['user_level'] == 0) redirect('index');
		
		$this->db->from('department');
		$this->db->where('department_status', 0);
		$this->db->order_by("department_id", "desc"); 
		$department = $this->db->get();

		$data = array(
			'session' => $mysession,
			'department'   => $department->result()
		);

		$this->load->view('survey', $data);
	}
	
	
	public function add() {
		$mysession = $this->session->userdata('logged');
		if(!$mysession) redirect('index');
		if($mysession['user_level'] == 0) redirect('index');
		
		$is_survey = $this->input->post('has_survey');
		$only_survey = $this->input->post('has_activity');

		if(!$only_survey) {
			// Activity database insertion
			$activity = array(
				'activity_category'    => $this->input->post('activity_category'),
				'activity_title'       => $this->input->post('activity_title'),
				'activity_description' => $this->input->post('activity_description'),
				'activity_dated'       => date('Y-m-d H:i:s'),
				'only_survey'          => 0,
				'has_survey'           => $is_survey
			);
		} else {
			$activity = array(
				'activity_category'    => $this->input->post('activity_category'),
				'activity_title'       => "- Survey -",
				'activity_dated'       => date('Y-m-d H:i:s'),
				'only_survey'          => 1,
				'has_survey'           => $is_survey
			);
		}

		$this->db->insert('activity', $activity);

		// Get the id of the activity
		$activity_id = $this->db->insert_id();
		
		// Image configuration, upload and database insertion
		$this->upload->initialize(array(
			"upload_path" => "assets/activity/",
			"allowed_types" => 'gif|jpg|png|jpeg',
			"max_size" => '2000',
			"encrypt_name" => 'TRUE',
			"remove_spaces" => 'TRUE',
			"is_image" => '1'
		));

		if($this->upload->do_multi_upload("activity_photos")){
			$activity_img = $this->upload->get_multi_upload_data();
			foreach($activity_img as $img_array) {
				$upload = array(
					'image_name'  => $img_array['file_name'],
					'activity_id' => $activity_id
				);
				
				$this->db->insert('activity_image', $upload);
			}
		}

		// Check if the activity has a survey
		if($is_survey == 1) {
			// Survey database insertion
			$data = array(
				'user_id'            => $mysession['user_id'],
				'survey_title'       => $this->input->post('survey_title'),
				'survey_description' => $this->input->post('survey_description'),
				'survey_dated'       => date('Y-m-d H:i:s'),
				'activity_id'        => $activity_id,
				'survey_end'         => $this->input->post('survey_end')
			);
			$this->db->insert('survey', $data);
			
			// Get the id of survey
			$survey_id = $this->db->insert_id();
			
			// Survey questions database insertion
			$questions = $this->input->post('questions');
			for($i=0; $i<count($questions); $i++) {
				$query = array(
					'survey_id'       => $survey_id,
					'survey_question' => $questions[$i],
					'question_status' => 0
				);
				$this->db->insert('questions', $query);
			}
		}
		redirect('survey?add=true');
	}

	public function lists() {
		$mysession = $this->session->userdata('logged');
		if(!$mysession) redirect('index');
		
		$survey_id = $this->uri->segment(3);
		if(!is_numeric($survey_id)) return false;

		$this->db->from('survey');
		$this->db->where('survey_id', $survey_id);
		$survey = $this->db->get();
		
		$this->db->from('questions');
		$this->db->where('survey_id', $survey_id);
		$questions = $this->db->get();
		
		$this->db->select_sum('question_choose');
		$this->db->where('survey_id', $survey_id);
		$sum = $this->db->get('questions');
		
		$data = array(
			'session'   => $mysession,
			'survey'    => $survey->result(),
			'questions' => $questions->result(),
			'sum'       => $sum->result()
		);
		
		$this->load->view('lists', $data);
	}

	public function edit() {
		$mysession = $this->session->userdata('logged');
		if(!$mysession) redirect('index');
		if($mysession['user_level'] == 0) redirect('index');
		
		if(isset($_GET['id']) && is_numeric($_GET['id'])){
			$id = $_GET['id'];
		} else {
			redirect('activity/activity_edit/'.$id.'/?edit=false');
		}
		$has_activity = $this->input->post("has_activity");
		if($has_activity == 0) {
				$activity = array(
					'activity_category'    => $this->input->post('activity_category'),
					'activity_title'       => $this->input->post('activity_title'),
					'activity_description' => $this->input->post('activity_description')
				);

				$this->db->where('activity_id', $id);
				$this->db->update('activity', $activity);
		} else {
				$activity = array(
					'activity_category'    => $this->input->post('activity_category')
				);

				$this->db->where('activity_id', $id);
				$this->db->update('activity', $activity);
		}
		
		$survey = array(
			'survey_title'       => $this->input->post('survey_title'),
			'survey_description' => $this->input->post('survey_description'),
			'survey_end'         => $this->input->post('survey_end')
		);
		
		$this->db->where('activity_id', $id);
		$this->db->update('survey', $survey);

		// Image configuration, upload and database insertion
		$this->upload->initialize(array(
			"upload_path" => "assets/activity/",
			"allowed_types" => 'gif|jpg|png|jpeg',
			"max_size" => '2000',
			"encrypt_name" => 'TRUE',
			"remove_spaces" => 'TRUE',
			"is_image" => '1'
		));
		
		if($this->upload->do_multi_upload("activity_photos")){
			$activity_img = $this->upload->get_multi_upload_data();
			foreach($activity_img as $img_array) {
				$upload = array(
					'image_name'  => $img_array['file_name'],
					'activity_id' => $id
				);
				
				$this->db->insert('activity_image', $upload);
			}
		}
		redirect('activity/activity_edit/'.$id.'/?edit=true');
	}

	public function survey_delete() {
		$mysession = $this->session->userdata('logged');
		if(!$mysession) redirect('index');
		if($mysession['user_level'] == 0) redirect('index');
		
		$id = $this->uri->segment(3);
		$this->db->from('survey');
		$this->db->where('survey_id', $id);
		$survey = $this->db->get();
		
		if($survey->num_rows() > 0) {
			foreach($survey->result() as $row) {}
			
			$activity_id = $row->activity_id;
		}
		
		$this->db->delete('survey', array('survey_id' => $id));
		$this->db->delete('activity', array('activity_id' => $activity_id));
		redirect('');
	}
	
	public function survey_question() {
		$question_id = $this->input->post('question_id');
		$question = array(
			'survey_question' => $this->input->post('survey_question')
		);
		
		$this->db->where('question_id', $question_id);
		$this->db->update('questions', $question);
		
		return $question['survey_question'];
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
