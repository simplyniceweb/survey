<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pagination_model extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
	}

	public function get_list( $category, $start, $max )
	{
		$this->db->select('*');
		$this->db->from('activity');
		$this->db->join('survey', 'survey.activity_id = activity.activity_id', 'inner');
		$this->db->where('activity.activity_category', $category);
		$query = $this->db->get();
		//var_dump($query->result()); return false;
		//$this->db->where('activity_category', $category);
		//$this->db->order_by('activity_id', 'DESC');
		//$this->db->limit($max, $start);

		//$query = $this->db->get('activity');
		
		if( $query->num_rows() >= 1) {
			return $query->result();
		}
	}
	
	public function total($category)
	{
		$this->db->where('activity_category', $category);
		return $this->db->count_all_results('activity');
	}
}
