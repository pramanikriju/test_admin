<?php
	class api_users_model extends CI_Model {
		public function __construct(){
         	$this->load->database();
        }

        public function get_all(){
		 	$query = $this->db->order_by('id','DESC')->get('api_users');
		    return $query->result_array();
        }

        public function get_batch(){
		 	$query = $this->db->limit(500)->order_by('id','ASC')->get_where('api_users', array('status' => 0 ) );
		    return $query->result_array();
        }

        public function delete_outdated(){
			$l_nOutdated = date( 'Y-m-d', strtotime( '-15 days' ));
			
			$this->db->where('time_done <', $l_nOutdated );
			$this->db->delete('api_users');

			return true;
		}
		
    }
?>