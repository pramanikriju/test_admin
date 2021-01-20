<?php
	class budget_model extends CI_Model {
		public function __construct(){
         	$this->load->database();
        }

        public function get_by_id( $p_nId ) {
	        $query = $this->db->get_where('budget', array('id' => $p_nId));
	        return $query->row_array();
        }

        public function get_all(){
		 	$query = $this->db->order_by('day','ASC')->get('budget');
		    return $query->result_array();
        }

        public function add($p_asPayload){
			$this->db->insert('budget', $p_asPayload);
			return $this->db->insert_id();
        }
        
        public function save($p_asPayload){
			$this->db->where( 'id', $p_asPayload['id'] );
			return $this->db->update( 'budget', $p_asPayload );
        }
        
    }
?>