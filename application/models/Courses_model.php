<?php
	class courses_model extends CI_Model {

		public function __construct(){
         	$this->load->database();
        }

        public function get_count(){
		 	$query = $this->db->get('courses');
		    return $query->num_rows();
        }
        
        public function get_all(){
		 	$query = $this->db->order_by('order','ASC')->get('courses');
		    return $query->result_array();
        }
		
        public function get_active(){
		 	$query = $this->db->order_by('order','ASC')->get_where('courses', array('status' => 1));
		    return $query->result_array();
        }
        
        public function get_by_id($p_nId){
	        $query = $this->db->get_where('courses', array('id' => $p_nId));
	        return $query->row_array();
        }

        public function get_by_button($p_nId){
	        $l_axReturn = array();
			$l_axCourses = $this->db->order_by('order','ASC')->get('courses');
			$l_axCourses = $l_axCourses->result_array();
						
			foreach($l_axCourses as $l_xCourse){
				$l_asNames = explode(',', $l_xCourse['button_name']);
				foreach($l_asNames as $l_sName){
					if($p_nId == trim($l_sName)){
						$l_axReturn[] = $l_xCourse;
					}
				}
			}
			
			return $l_axReturn;
        }
        
        public function add($p_asPayload){
			$this->db->insert('courses', $p_asPayload);
			return $this->db->insert_id();
        }
        
        public function save($p_asPayload){
			return $this->db->replace('courses', $p_asPayload);
        }

        public function delete($p_nId){
	        return $this->db->delete('courses', array('id' => $p_nId));
        }

        public function reorder(){
		 	$query = $this->db->order_by('order','ASC')->get('courses');
		 	$l_axCourses =  $query->result_array();
		 	
		 	$l_nOrder = 1;
		 	foreach($l_axCourses as $l_xCourse){
			 	$l_xCourse['order'] = $l_nOrder;
			 	$this->db->replace('courses', $l_xCourse);
			 	$l_nOrder++;
		 	}
		    return true;
        }


    }
?>