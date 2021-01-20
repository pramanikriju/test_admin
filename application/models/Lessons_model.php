<?php
	class lessons_model extends CI_Model {

		public function __construct(){
         	$this->load->database();
        }

        public function get_count(){
		 	$query = $this->db->get('lessons');
		    return $query->num_rows();
        }
        
        public function get_all(){
		 	$query = $this->db->order_by('title','ASC')->get('lessons');
		    return $query->result_array();
        }

        public function get_by_unit($p_nId){
		 	$query = $this->db->order_by('order','ASC')->get_where('lessons', array('unit_id' => $p_nId));
		    return $query->result_array();
        }
        
        public function get_by_id($p_nId){
	        $query = $this->db->get_where('lessons', array('id' => $p_nId));
	        return $query->row_array();
        }
        
        public function add($p_asPayload){
			$this->db->insert('lessons', $p_asPayload);
			return $this->db->insert_id();
        }
        
        public function save($p_asPayload){
			return $this->db->replace('lessons', $p_asPayload);
        }

        public function delete($p_nId){
	        return $this->db->delete('lessons', array('id' => $p_nId));
        }

        public function reorder($p_nId){
		 	$query = $this->db->order_by('order','ASC')->get_where('lessons', array('unit_id' => $p_nId));
		 	$l_axLessons =  $query->result_array();
		 	
		 	$l_nOrder = 1;
		 	foreach($l_axLessons as $l_xLesson){
			 	$l_xLesson['order'] = $l_nOrder;
			 	$this->db->replace('lessons', $l_xLesson);
			 	$l_nOrder++;
		 	}
		    return true;
        }
        
        public function add_file($p_asPayload){
			$this->db->insert('lessons_files', $p_asPayload);
			return $this->db->insert_id();
        }

        public function get_files($p_nId){
		 	$query = $this->db->order_by('id','ASC')->get_where('lessons_files', array('lesson_id' => $p_nId));
		    return $query->result_array();
        }
        public function delete_file($p_nId){
	        return $this->db->delete('lessons_files', array('id' => $p_nId));
        }
        
        
    }
?>