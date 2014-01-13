<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('pagination');
		$this->load->model('pagination_model');
    }

	public function index() {
		$mysession = $this->session->userdata('logged');
		if(!$mysession) redirect('index');
		// echo $mysession['department']; return false;
		
		$this->db->from('department');
		$this->db->where('department_status', 0);
		if($mysession['user_level'] != 99) {
			$this->db->where('department_id', $mysession['department']);
		}
		$department = $this->db->get();
		
		// Department activity counter
		$this->db->from('activity');
		$this->db->where('activity_category', $mysession['department']);
		$count_dept = $this->db->get();
		
		// General activity counter
		$this->db->from('activity');
		$this->db->where('activity_category', 0);
		$count_gen = $this->db->get();

		// Pagination
		$category = $mysession['department'];
		$start = $this->uri->segment(3);
		if(!$start) $start = 0;
		$config = array(
			'base_url'    => 'main/index',
			'uri_segment' => 3,
			'total_rows'  => $this->pagination_model->total($category),
			'per_page'    => 15
		);

		$getter = $this->pagination_model->get_list( $category, $start, $config['per_page'] );
		$this->pagination->initialize($config);

		$data = array(
			'title'         => 'Homepage',
			'session'       => $mysession,
			'activity'      => $getter,
			'general'       => $count_gen->num_rows(),
			'counter'       => $count_dept->num_rows(),
			'department'    => $department->result(),
			'pagination'    => $this->pagination->create_links()
		);
		
		$this->load->view('main', $data);
	}
	
	public function switch_tab() {
		if( !$this->input->is_ajax_request() ) return false;
		$mysession = $this->session->userdata('logged');
		if(!$mysession) redirect('index');
		
		$category = $this->input->post('tab_id');
		$start = $this->uri->segment(3);
		if(!$start) $start = 0;
		$config = array(
			'base_url'    => 'main/index',
			'uri_segment' => 3,
			'total_rows'  => $this->pagination_model->total($category),
			'per_page'    => 15
		);
		$getter = $this->pagination_model->get_list( $category, $start, $config['per_page'] );
		$this->pagination->initialize($config);
		
		$data = array(
			'activity'  => $getter,
			'pagination'    => $this->pagination->create_links()
		);
		
		$this->load->view('includes/tab', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */