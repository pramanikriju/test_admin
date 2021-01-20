<?php
	class system_model extends CI_Model {

		public function __construct(){
         	$this->load->database();
        }
                
        public function get_version(){
	        $query = $this->db->get_where('system', array('name' => 'version'));
	        return $query->row_array();
        }

        public function get_api_key(){
	        $query = $this->db->get_where('system', array('name' => 'api_key'));
	        return $query->row_array();
        }

        public function generate_api_key(){
	        $query = $this->db->get_where('system', array('name' => 'api_key'));
	        $results = $query->row_array();
			$results['value'] = md5( uniqid( rand(), true ) );			
			$this->db->replace('system', $results);
	        return true;
        }
        
        public function save($p_asPayload){
			return $this->db->replace('system', $p_asPayload);
        }

        public function get_errors( $p_nStartTime, $p_nEndTime, $p_sEvent = null ) {
			$l_asArgs = array();
			$l_asArgs['time >='] = $p_nStartTime;
			$l_asArgs['time <='] = $p_nEndTime;
			if ( $p_sEvent ) {
				$l_asArgs['event'] = $p_sEvent;
			}

			$query = $this->db->order_by('time','DESC')->get_where( 'error_log', $l_asArgs );
			return $query->result_array();
	   	}

	   	public function get_errors_by_account( $p_sAccount, $p_nLimit = 1000 ) {
			$query = $this->db->limit(10000)->order_by( 'time', 'DESC' )->limit($p_nLimit)->get_where( 'error_log', array( 'subdomain' => $p_sAccount ) );
	   		return $query->result_array();
   		}

	   	public function get_error_types() {
			$query = $this->db->group_by( 'event' )->select('event')->get( 'error_log' );
	   		return $query->result_array();
   		}

        public function get_error_totals( $p_nStartTime, $p_nEndTime ) {
			$l_asArgs = array();
			$l_asArgs['time >='] = $p_nStartTime;
			$l_asArgs['time <='] = $p_nEndTime;

			$query = $this->db->order_by('the_count','DESC')->group_by( 'event' )->select('event, count(*) as the_count')->get_where( 'error_log', $l_asArgs );

			return $query->result_array();
	   	}

		   
		public function log_error_by_account( $p_sAccount, $p_nEvent, $p_sData ) {
			$l_asPayload = array();
			$l_asPayload['time'] = time();
			$l_asPayload['subdomain'] = $p_sAccount;
			$l_asPayload['event'] = $p_nEvent;
			$l_asPayload['data'] = $p_sData;

			$this->db->insert('error_log', $l_asPayload);
			return true;
		}

		public function get_client_database( $l_xUser ) {
			if ( $l_xUser['master_db'] == 0 ) {
				$l_asCurrentDatabase = array(
					'dsn'	=> 'mysql:host=' . DB_HOST . '; dbname=' . $l_xUser['subdomain'] . '; charset=utf8mb4;',
					'hostname' => '',
					'username' => DB_USER,
					'password' => DB_PASSWORD,
					'database' => $l_xUser['subdomain'],
					'dbdriver' => 'pdo',
					'dbprefix' => '',
					'pconnect' => FALSE,
					'db_debug' => FALSE,
					'cache_on' => FALSE,
					'cachedir' => '',
					'char_set' => 'utf8mb4',
					'dbcollat' => 'utf8mb4_unicode_ci',
					'swap_pre' => '',
					'encrypt' => FALSE,
					'compress' => FALSE,
					'stricton' => FALSE,
					'failover' => array(),
					'save_queries' => FALSE
				);
				$l_xCurrentDatabase = $this->load->database( $l_asCurrentDatabase, TRUE );
				$l_nCurrentClient = 0;
			} else {
				$l_asCurrentDatabase = array(
					'dsn'	=> 'mysql:host=' . DB_HOST . '; dbname=membervault_master; charset=utf8mb4;',
					'hostname' => '',
					'username' => DB_USER,
					'password' => DB_PASSWORD,
					'database' => 'membervault_master',
					'dbdriver' => 'pdo',
					'dbprefix' => '',
					'pconnect' => FALSE,
					'db_debug' => FALSE,
					'cache_on' => FALSE,
					'cachedir' => '',
					'char_set' => 'utf8mb4',
					'dbcollat' => 'utf8mb4_unicode_ci',
					'swap_pre' => '',
					'encrypt' => FALSE,
					'compress' => FALSE,
					'stricton' => FALSE,
					'failover' => array(),
					'save_queries' => FALSE
				);
				$l_xCurrentDatabase = $this->load->database( $l_asCurrentDatabase, TRUE );
				$l_nCurrentClient = $l_xUser['id'];
			}

			return array( 'db' => $l_xCurrentDatabase, 'client_id' => $l_nCurrentClient );
		}
		
		public function get_account_system( $p_xDatabase, $p_nClientId ) {
			$l_axReturn = array();
			$query = $p_xDatabase->order_by( 'id','DESC' )->get_where( 'system', array( 'client_id' => $p_nClientId ) );
			if ( $query ) {
				$l_axQueries = $query->result_array();
				foreach( $l_axQueries as $l_xQuery ) {
					$l_axReturn[$l_xQuery['name']] = $l_xQuery;
				}
			}
			return $l_axReturn;
		}

		public function get_account_ep_count( $p_xDatabase, $p_nClientId, $p_sStart, $p_sEnd ) {
			$l_axReturn = array();
			//$query = $p_xDatabase->get_where( 'user_logs', array( 'client_id' => $p_nClientId, 'date >=' => $p_sStart, 'date <=' => $p_sEnd, 'event !=' => 'course_add', 'event !=' => 'signup' ) );
			$query = $p_xDatabase->query("SELECT `id` FROM `user_logs` WHERE (`date` >= '" . $p_sStart . "' AND `date` <= '" . $p_sEnd . "' AND `client_id` = " . $p_nClientId . " AND `event` != 'signup' AND `event` != 'course_add')");
		   	return $query->num_rows();
		}

		public function save_to_cache( $p_sName, $p_sData ) {
			$l_asPayload = array();
			$l_asPayload['time'] = time();
			$l_asPayload['name'] = $p_sName;
			$l_asPayload['data'] = $p_sData;

			$this->db->replace('cached', $l_asPayload);
			return true;
		}

        public function get_from_cache( $p_sName ) {
			$l_asArgs = array();
			$l_asArgs['name'] = $p_sName;

			$query = $this->db->get_where( 'cached', $l_asArgs );
			return $query->row_array();
	   	}

		public function call_webhook( $p_sUrl ) {
			$ch = curl_init();
			curl_setopt( $ch, CURLOPT_URL, $p_sUrl );
			curl_setopt( $ch, CURLOPT_HEADER, true );
			curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
			curl_setopt( $ch, CURLOPT_MAXREDIRS, 4 );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
			$l_sTemp = curl_exec($ch);
			curl_close($ch);
			return $l_sTemp;
		}
	}
?>