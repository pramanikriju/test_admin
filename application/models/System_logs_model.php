<?php
	class system_logs_model extends CI_Model {

		public function __construct(){
         	$this->load->database();
        }
        
        public function get_all(){
		 	$query = $this->db->order_by('date','DESC')->get('system_logs');
		    return $query->result_array();
        }

        public function get_latest($p_nId){
		 	$query = $this->db->order_by('date','DESC')->limit($p_nId)->get('system_logs');
		    return $query->result_array();
        }


        public function get_signups($p_nYear){
	        $l_anReturn = array();
	        
	        for($i = 1; $i <= 12; $i++ ){
		        $l_nMonth = str_pad($i, 2, "0", STR_PAD_LEFT); 
	        
			 	$query = $this->db->order_by('date','DESC')->where('date >=', $p_nYear.'-'.$l_nMonth.'-01')->where('date <=', $p_nYear.'-'.$l_nMonth.'-31')->get_where('system_logs', array('event' => 'add_course'));
			    $l_anReturn[$i] = $query->num_rows();
		    
		    }
		    
		    return $l_anReturn;
        }

        public function get_by_event($p_nId){
		 	$query = $this->db->order_by('date','DESC')->get_where('system_logs', array('event' => $p_nId));
		    return $query->result_array();
        }
        
        public function get_by_id($p_nId){
	        $query = $this->db->get_where('system_logs', array('id' => $p_nId));
	        return $query->row_array();
        }
        
        public function add($p_asPayload){
			$this->db->insert('system_logs', $p_asPayload);
			return $this->db->insert_id();
        }

        public function add_by_event_data( $p_nEvent, $p_sData, $p_sDate ) {
            $this->db->delete('system_logs', array('event'=> $p_nEvent, 'data'=> $p_sData));

            $l_xSystemLog = array();
            $l_xSystemLog['date'] = sqlDate( $p_sDate );
            $l_xSystemLog['event'] = $p_nEvent;
            $l_xSystemLog['data'] = $p_sData;

            $this->db->insert('system_logs', $l_xSystemLog);
			return $this->db->insert_id();
        }


        public function save($p_asPayload){
			return $this->db->replace('system_logs', $p_asPayload);
        }

        public function delete($p_nId){
	        return $this->db->delete('system_logs', array('id' => $p_nId));
        }

        
    }
?>