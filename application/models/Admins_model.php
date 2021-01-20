<?php
	class admins_model extends CI_Model {
		public function __construct(){
         	$this->load->database();
        }
        
        public function get_login($p_sUsername, $p_sPassword){
	        $l_sPasswordHash = md5($p_sPassword);
	        
	        $query = $this->db->get_where('admins', array('username' => $p_sUsername, 'password' => $l_sPasswordHash));
	        return $query->row_array();
        }

        public function get_by_username($p_sUsername){
	        $query = $this->db->get_where('admins', array('username' => $p_sUsername));
	        return $query->row_array();
        }

        public function get_by_email($p_sEmail){
	        $query = $this->db->get_where('admins', array('email' => $p_sEmail));
	        return $query->row_array();
        }

        public function add($p_asPayload){
			$this->db->insert('admins', $p_asPayload);
			return $this->db->insert_id();
        }
        
        public function save($p_asPayload){
			return $this->db->replace('admins', $p_asPayload);
        }
        
    }
?>