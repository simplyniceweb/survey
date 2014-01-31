<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Activity extends CI_Controller {

	public function __construct() {
		parent::__construct();
    }

	public function index() {
		$mysession = $this->session->userdata('logged');
		if (!$mysession) redirect('');
		
		$activity_id = $this->uri->segment(2);
		
		$this->db->from('comment');
		$this->db->where('activity_id', $activity_id);
		$this->db->order_by('comment_id', 'desc');
		$comm = $this->db->get();

		$this->db->from('activity');
		$this->db->where('activity_id', $activity_id);
		$activity = $this->db->get();

		$this->db->from('activity_image');
		$this->db->where('activity_id', $activity_id);
		$activity_image = $this->db->get();
		
		$this->db->from('survey');
		$this->db->where('activity_id', $activity_id);
		$survey = $this->db->get();

		if($survey->num_rows() >= 1){
			foreach( $survey->result() as $row ) {
				$survey_id = $row->survey_id;
			}
			$survey = $survey->result();

			$this->db->from('questions');
			$this->db->where('survey_id', $survey_id);
			$questions = $this->db->get();
			$questions = $questions->result();
			
			$this->db->select_sum('question_choose');
			$this->db->where('survey_id', $survey_id);
			$sum = $this->db->get('questions');
			$sum = $sum->result();
			
			$this->db->from('choose_log');
			$this->db->where('user_id', $mysession['user_id']);
			$this->db->where('survey_id', $survey_id);
			$voted = $this->db->get();
			if($voted->num_rows() >= 1) {
				$voted = $voted->result();
			} else {
				$voted = null;
			}

		} else {
			$survey    = null;
			$questions = null;
			$survey_id = null;
			$sum       = null;
			$voted     = null;
		}

		$data = array(
			'title'          => 'Activity',
			'session'        => $mysession,
			'activity'       => $activity->result(),
			'activity_image' => $activity_image->result(),
			'survey'         => $survey,
			'questions'      => $questions,
			'sum'            => $sum,
			'voted'			 => $voted,
			'comments'       => $comm
		);

		$this->load->view('survey/lists', $data);
	}
	
	public function choosen() {
		if( !$this->input->is_ajax_request() ) return false;
		$mysession = $this->session->userdata('logged');
		if (!$mysession) redirect('');

		$survey_id   = $this->input->post('survey_id');
		$question_id = $this->input->post('question_id');
		$activity_id = $this->input->post('activity_id');
		
		// Check if this person voted for this question
		$this->db->from('choose_log');
		$this->db->where('user_id', $mysession['user_id']);
		$this->db->where('survey_id', $survey_id);
		$record = $this->db->get();
		
		// If person does voted deduct 1 vote for the question
		if($record->num_rows() > 0) {
			foreach($record->result() as $record) {
				$this->db->from('questions');
				$this->db->where('question_id', $record->question_id);
				$this->db->limit(1);
				$question = $this->db->get();
				
				if($question->num_rows() > 0) {
					foreach($question->result() as $quest) {
						$quantity = $quest->question_choose;
						$total = $quantity-1;
						if($total < 0) $total = 0;
						
						$data = array(
							'question_choose' => $total
						);
						$this->db->where('question_id', $record->question_id);
						$this->db->update('questions', $data);
					}
				}
			}
			
			// Update the log
			$log_update = array(
				'question_id' => $question_id,
			);
			
			$this->db->where('survey_id', $survey_id);
			$this->db->update('choose_log', $log_update);

		} else {

			$vote = array(
				'user_id'     => $mysession['user_id'],
				'survey_id'   => $survey_id,
				'question_id' => $question_id
			);
			$this->db->insert('choose_log', $vote);
		}
		
		// Check if the question exist
		$this->db->from('questions');
		$this->db->where('question_id', $question_id);
		$this->db->limit(1);
		$question = $this->db->get();
		
		// Add 1 to the total of person vote for this specific question
		if($question->num_rows() > 0) {
			foreach($question->result() as $quest) {
				$quantity = $quest->question_choose;
				$total = $quantity+1;
				
				$data = array(
					'question_choose' => $total
				);
				$this->db->where('question_id', $quest->question_id);
				$this->db->update('questions', $data);
			}
		}

		$view = self::surveyList($survey_id, $question_id, $activity_id, $mysession);
		return $view;
	}
	
	public function surveyList($survey_id, $question_id, $activity_id, $mysession) {

		$this->db->from('survey');
		$this->db->where('activity_id', $activity_id);
		$survey = $this->db->get();
		
		if($survey->num_rows() >= 1){
			foreach( $survey->result() as $row ) {
				$survey_id = $row->survey_id;
			}
			$survey = $survey->result();
		
			$this->db->from('questions');
			$this->db->where('survey_id', $survey_id);
			$questions = $this->db->get();
			$questions = $questions->result();
			
			$this->db->select_sum('question_choose');
			$this->db->where('survey_id', $survey_id);
			$sum = $this->db->get('questions');
			$sum = $sum->result();
			
			$this->db->from('choose_log');
			$this->db->where('user_id', $mysession['user_id']);
			$this->db->where('survey_id', $survey_id);
			$voted = $this->db->get();
			if($voted->num_rows() >= 1) {
				$voted = $voted->result();
			} else {
				$voted = null;
			}
		} else {
			$survey    = null;
			$questions = null;
			$survey_id = null;
			$sum       = null;
			$voted     = null;
		}
		
		$data = array(
			'survey'         => $survey,
			'session'        => $mysession,
			'questions'      => $questions,
			'sum'            => $sum,
			'voted'			 => $voted,
			'activity_id'    => $activity_id
		);
		
		$this->load->view('survey/includes/survey', $data);
	}
	
	public function commentDel() {
		if( !$this->input->is_ajax_request() ) return false;
		$mysession = $this->session->userdata('logged');
		if (!$mysession) redirect('');

		$comment_id = $this->input->post('comment_id');
		$this->db->delete('comment', array('comment_id' => $comment_id));
	}
	
	public function commentUpdate() {
		if( !$this->input->is_ajax_request() ) return false;
		$mysession = $this->session->userdata('logged');
		if (!$mysession) redirect('');
		
		$comment_id = $this->input->post('comment_id');
		$comment = $this->input->post('comment');
		
		$data = array(
			'comment_message' => $comment
		);
		
		$this->db->where('comment_id', $comment_id);
		$this->db->update('comment', $data);
	}
	
	public function image_delete() {
		if( !$this->input->is_ajax_request() ) return false;
		$mysession = $this->session->userdata('logged');
		if (!$mysession) redirect('');
		
		$image_id = $this->input->post('image_id');
		if($this->db->delete('activity_image', array('activity_image_id' => $image_id))) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function activity_delete() {
		$id = $this->uri->segment(3);
		$this->db->delete('activity', array('activity_id' => $id));
		redirect('');
	}
	
	public function activity_edit() {	
		$mysession = $this->session->userdata('logged');
		if (!$mysession) redirect('');
		$id = $this->uri->segment(3);
		
		$this->db->from('department');
		$this->db->where('department_status', 0);
		$this->db->order_by("department_id", "desc"); 
		$department = $this->db->get();

		$this->db->from('activity');
		$this->db->where('activity_id', $id);
		$activity = $this->db->get();
		
		$this->db->from('survey');
		$this->db->where('activity_id', $id);
		$survey = $this->db->get();

		if($survey->num_rows() > 0) {
			$survey = $survey->result();
		} else {
			$survey = NULL;
		}

		$view = array(
			'session'  => $mysession,
			'activity' => $activity,
			'survey'   => $survey,
			'act_id'   => $id,
			'department' => $department->result()
		);

		$this->load->view('survey/edit', $view);
	}
	
	public function comment() {
		if( !$this->input->is_ajax_request() ) return false;
		$mysession = $this->session->userdata('logged');
		if (!$mysession) redirect('');

		$comment     = $this->input->post('comment');
		$activity_id = $this->input->post('activity_id');
		$user_id     = $mysession['user_id'];
		$date        = date('Y-m-d H:i:s');
		
		$data = array(
			'user_id'         => $user_id,
			'comment_message' => $comment,
			'comment_date'    => $date,
			'activity_id'     => $activity_id
		);
		
		$this->db->insert('comment', $data);
		
		$comment_id = $this->db->insert_id();
		$this->db->from('comment');
		$this->db->where('comment_id', $comment_id);
		$comm = $this->db->get();
		
		$comments = array(
			'session'     => $mysession,
			'comments' => $comm->result()
		);
		
		$this->load->view('survey/includes/comments', $comments);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
