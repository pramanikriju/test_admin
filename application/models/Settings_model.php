<?php
	class settings_model extends CI_Model {

		public function __construct(){
         	$this->load->database();
        }
        
        public function get_all(){
		 	$query = $this->db->order_by('id','ASC')->get('settings');
		    return $query->result_array();
        }

        public function get_all_by_name(){
			$l_axReturn = array();
			$query = $this->db->order_by('id','ASC')->get('settings');
			$l_axQueries = $query->result_array();
			foreach( $l_axQueries as $l_xQuery ) {
				$l_axReturn[$l_xQuery['name']] = $l_xQuery;
			}

		    return $l_axReturn;
        }
        
        public function get_by_id($p_nId){
	        $query = $this->db->get_where('settings', array('id' => $p_nId));
	        return $query->row_array();
        }
        
        public function get_by_name($p_sName){
	        $query = $this->db->get_where('settings', array('name' => $p_sName));
	        return $query->row_array();
        }
        
        public function save($p_asPayload){
			return $this->db->replace('settings', $p_asPayload);
        }
        
    }
?>