<?php
	class api_jobs_model extends CI_Model {
		public function __construct(){
         	$this->load->database();
        }

        public function get_all(){
		 	$query = $this->db->limit(100)->order_by('id','DESC')->get('api_jobs');
		    return $query->result_array();
        }

        public function get_pending(){
		 	$query = $this->db->limit(150)->order_by('priority','ASC')->order_by('id','ASC')->get_where('api_jobs', array('status' => 0 ) );
		    return $query->result_array();
        }

		public function search_old( $p_sSearch ) {
			$this->db->select('*');
			$this->db->limit(500);
			$this->db->from('api_jobs');
			$this->db->like('url', $p_sSearch );
			$this->db->where('status', 1);
			$this->db->order_by( 'id','ASC' );
			$query = $this->db->get();
			
			return $query->result_array();
	   }

	   	public function search_old_count( $p_sSearch ) {
			$this->db->select('id');
			$this->db->from('api_jobs');
			$this->db->like('url', $p_sSearch );
			$this->db->where('status', 1);
			$query = $this->db->get();
			
			return $query->num_rows();
	   }

		public function get_pending_count(){
		 	$query = $this->db->get_where('api_jobs', array('status' => 0 ) );
		    return $query->num_rows();
        }

        public function get_batch(){
		 	$query = $this->db->limit(400)->order_by('priority','ASC')->order_by('id','ASC')->get_where('api_jobs', array('status' => 0 ) );
		    return $query->result_array();
        }

        public function delete_outdated(){
			$l_nOutdated = date( 'Y-m-d', strtotime( '-14 days' ));
			
			$this->db->where('time_done <', $l_nOutdated );
			$this->db->delete('api_jobs');

			return true;
		}
		
        
		public function add_call( $p_sUrl, $p_bSkipOutput = false, $p_nPriority = 5 ){
			$l_asPayload = array();
			$l_asPayload['status'] = 0;
			$l_asPayload['url'] = $p_sUrl;
			$l_asPayload['time_in'] = date("Y-m-d H:i:s");
			$l_asPayload['priority'] = $p_nPriority;
			if ( $p_bSkipOutput ) {
				$l_asPayload['response'] = 'skipped';
			}
			
			return $this->add( $l_asPayload );
		}

        public function add($p_asPayload){
			$this->db->insert('api_jobs', $p_asPayload);
			return $this->db->insert_id();
        }
        
        public function save($p_asPayload){
			$this->db->where( 'id', $p_asPayload['id'] );
			return $this->db->update( 'api_jobs', $p_asPayload );
        }
        
    }
?>