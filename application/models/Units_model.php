<?php
	class units_model extends CI_Model {

		public function __construct(){
         	$this->load->database();
        }

        public function get_count(){
		 	$query = $this->db->get('units');
		    return $query->num_rows();
        }
        
        public function get_all(){
		 	$query = $this->db->order_by('title','ASC')->get('units');
		    return $query->result_array();
        }

        public function get_by_course($p_nId){
		 	$query = $this->db->order_by('order','ASC')->get_where('units', array('course_id' => $p_nId));
		    return $query->result_array();
        }
        
        public function get_by_id($p_nId){
	        $query = $this->db->get_where('units', array('id' => $p_nId));
	        return $query->row_array();
        }

        public function get_by_order( $p_nCourseId, $p_nOrder ){
	        $query = $this->db->get_where('units', array('course_id' => $p_nCourseId, 'order' => $p_nOrder));
	        return $query->row_array();
        }
        
        public function add($p_asPayload){
			$this->db->insert('units', $p_asPayload);
			return $this->db->insert_id();
        }
        
        public function save($p_asPayload){
			return $this->db->replace('units', $p_asPayload);
        }

        public function delete($p_nId){
	        return $this->db->delete('units', array('id' => $p_nId));
        }
        
        public function reorder($p_nId){
		 	$query = $this->db->order_by('order','ASC')->get_where('units', array('course_id' => $p_nId));
		 	$l_axUnits =  $query->result_array();
		 	
		 	$l_nOrder = 1;
		 	foreach($l_axUnits as $l_xUnit){
			 	$l_xUnit['order'] = $l_nOrder;
			 	$this->db->replace('units', $l_xUnit);
			 	$l_nOrder++;
		 	}
		    return true;
        }
        
    }
?>