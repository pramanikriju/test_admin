<?php
	class consent_model extends CI_Model {
		public function __construct(){
         	$this->load->database();
        }

        public function get_all(){
		 	$query = $this->db->limit(100)->order_by('timestamp','DESC')->get('consent_log');
		    return $query->result_array();
        }
       
        public function add( $p_asPayload ) {
            $this->db->insert('consent_log', $p_asPayload);
            return $this->db->insert_id();
        }
    
        public function save( $p_asPayload ) {
            $this->db->where( 'id', $p_asPayload['id'] );
            return $this->db->update( 'consent_log', $p_asPayload );
        }
    }
?>