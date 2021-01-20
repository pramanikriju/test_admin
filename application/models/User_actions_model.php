<?php
	class user_actions_model extends CI_Model {

		public function __construct(){
         	$this->load->database();
        }
        
        public function get_all(){
		 	$query = $this->db->order_by('date','DESC')->get('user_actions');
		    return $query->result_array();
        }

        public function add( $p_asPayload ) {
			$this->db->insert('user_actions', $p_asPayload);
			return $this->db->insert_id();
        }



   
    }
