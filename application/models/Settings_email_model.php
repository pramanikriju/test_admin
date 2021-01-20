<?php
	class settings_email_model extends CI_Model {

		public function __construct(){
         	$this->load->database();
        }
        
        public function get_all(){
		 	$query = $this->db->order_by('id','ASC')->get('settings_email');
		    return $query->result_array();
        }
        
        public function get_by_id($p_nId){
	        $query = $this->db->get_where('settings_email', array('id' => $p_nId));
	        return $query->row_array();
        }
        
        public function get_by_name($p_sName){
	        $query = $this->db->get_where('settings_email', array('name' => $p_sName));
	        return $query->row_array();
        }
        
        public function save($p_asPayload){
			return $this->db->replace('settings_email', $p_asPayload);
        }
        
    }
?>