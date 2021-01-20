<?php
	class user_logs_model extends CI_Model {

		public function __construct(){
         	$this->load->database();
        }
        
        public function get_all(){
		 	$query = $this->db->order_by('time','DESC')->get('user_logs');
		    return $query->result_array();
        }

        public function get_latest( $p_nId ) {
		 	$query = $this->db->order_by('time','DESC')->limit($p_nId)->get('user_logs');
		    return $query->result_array();
        }

        public function get_by_subdomain( $p_sSubdomain, $p_nLimit = 1000 ) {
		 	$query = $this->db->order_by('time','DESC')->limit($p_nLimit)->get_where( 'user_logs', array( 'subdomain' => $p_sSubdomain ) );
		    return $query->result_array();
		}

        public function get_by_subdomain_event( $p_sSubdomain, $p_sEvent ) {
			$query = $this->db->order_by('time','DESC')->get_where( 'user_logs', array( 'subdomain' => $p_sSubdomain, 'event' => $p_sEvent ) );
		   return $query->result_array();
		}

		public function get_totals_by_subdomain( $p_sSubdomain ) {
			$l_asArgs = array();
			$l_asArgs['subdomain'] = $p_sSubdomain;

			$query = $this->db->order_by('event','ASC')->group_by( 'event' )->select('event, count(*) as the_count')->get_where( 'user_logs', $l_asArgs );
			return $query->result_array();
		}

		public function get_total_by_subdomain( $p_sSubdomain ){
			$query = $this->db->get_where('user_logs', array('subdomain' => $p_sSubdomain ) );
		   return $query->num_rows();
	   }

		public function get_count_by_type( $p_nStartTime, $p_nEndTime ) {
			$l_asArgs = array();
			$l_asArgs['time >='] = $p_nStartTime;
			$l_asArgs['time <='] = $p_nEndTime;


			$query = $this->db->order_by('the_count','DESC')->group_by( 'subdomain' )->select('subdomain, count(*) as the_count')->get_where( 'user_logs', $l_asArgs );
			return $query->result_array();
		}

		public function get_event_totals( $p_nStartTime, $p_nEndTime, $p_sEvent ) {
			$l_asArgs = array();
			$l_asArgs['time >='] = $p_nStartTime;
			$l_asArgs['time <='] = $p_nEndTime;
			$l_asArgs['event'] = $p_sEvent;

			$query = $this->db->order_by('the_count','DESC')->group_by( 'subdomain' )->select('subdomain, count(*) as the_count')->get_where( 'user_logs', $l_asArgs );

			return $query->result_array();
		}
		
		public function get_daily_active_accounts() {
			$query = $this->db->query('SELECT x.ForDate, COUNT(*) as ActiveUsers FROM
			( SELECT subdomain, DATE(FROM_UNIXTIME(time)) AS ForDate,
					COUNT(*) AS NumPosts
			 FROM user_logs
			 GROUP BY subdomain, DATE(FROM_UNIXTIME(time))
			 ORDER BY ForDate ) as x GROUP BY x.fordate ORDER BY x.fordate');
		    return $query->result_array();
		}



		public function delete_outdated(){
			$l_nOutdated = strtotime( '-6 months' );
			
			$this->db->where('time <', $l_nOutdated );
			$this->db->delete('user_logs');

			$this->db->where('time <', $l_nOutdated );
			$this->db->delete('error_log');

			return true;
		}


   
    }
