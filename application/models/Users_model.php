<?php
	class users_model extends CI_Model {
		public function __construct(){
         	$this->load->database();
        }
        
        public function get_by_email($p_sEmail){
	        $query = $this->db->get_where('users', array('email' => $p_sEmail));
	        return $query->row_array();
        }

		public function get_all_email_tokens() {
			$query = $this->db->query('SELECT * FROM `users` WHERE (`email_company` = 8 OR `email_company` = 7)');
			return $query->result_array();
        }


		public function get_by_subdomain( $p_sSubdomain ) {
	        $query = $this->db->get_where('users', array('subdomain' => $p_sSubdomain));
	        return $query->row_array();
        }

        public function get_by_id($p_nId){
	        $query = $this->db->get_where('users', array('id' => $p_nId));
	        return $query->row_array();
		}
		
		public function get_all_raw(){
			$query = $this->db->get('users');
			return $query->result_array();
		}

        public function get_all_old_db(){
	        $query = $this->db->get_where('users', array('master_db' => 0));
	        return $query->result_array();
		}

        public function get_all( $p_sSort = 'id', $p_sOrder = 'DESC', $p_sType = null, $p_sSearch = null ) {
			$l_axReturn = array();
			$this->db->select('*');
			$this->db->from('users');
			if ( ! empty( $p_sSearch ) ) {
				$this->db->group_start();
				$this->db->like('subdomain', $p_sSearch );
				$this->db->group_end();
			}
			if ( $p_sType ) {
                $p_sType = str_replace( "Pro :", "Pro+:", $p_sType);
				$this->db->where('type', $p_sType);
			}
			$this->db->order_by( $p_sSort . ' ' . $p_sOrder );
			$query = $this->db->get();
			foreach( $query->result_array() as $l_xUser ) {
				$l_axReturn[ $l_xUser['id'] ] = $l_xUser;
			}
		    return $l_axReturn;
        }

		public function get_active() {
			$l_nYesterday = strtotime( '-1 day' );
			$query = $this->db->query('SELECT * FROM `users` WHERE (`admin_activity` > ' . $l_nYesterday . ' OR `user_activity` > ' . $l_nYesterday . ') ORDER BY `ep` DESC');
			return $query->result_array();
		}

		public function get_user_active( $p_nStart ) {
			$query = $this->db->query('SELECT * FROM `users` WHERE ( `user_activity` > ' . $p_nStart . ')');
			return $query->result_array();
		}

		public function get_user_active_leaderboard( $p_nStart ) {
			$query = $this->db->query('SELECT * FROM `users` WHERE ( `user_activity` > ' . $p_nStart . ' AND `on_leaderboard` = 1 )');
			return $query->result_array();
		}

		public function get_inactive( $p_sDays ) {
			$l_nOld = strtotime( '- ' . $p_sDays . ' days' );
			$query = $this->db->query('SELECT * FROM `users` WHERE (`admin_activity` < ' . $l_nOld . ') ORDER BY `admin_activity` DESC');
			return $query->result_array();
		}

	   public function get_by_ep(){
		 	$query = $this->db->order_by( 'ep', 'DESC' )->get_where('users', 'ep > 10' );
		    return $query->result_array();
        }

        public function add( $p_asPayload ) {
			$p_asPayload['created'] = sqlDate( $p_asPayload['created'] );
			$this->db->insert('users', $p_asPayload);
			return $this->db->insert_id();
        }
        
        public function save($p_asPayload){
			$this->db->where( 'id', $p_asPayload['id'] );
			$this->db->update( 'users', $p_asPayload );
			$l_asError = $this->db->error();
			if ( $l_asError['message'] ) {
				print_r( $l_asError );
				exit;
			}
			return true;
        }

        public function delete($p_nId){
	        return $this->db->delete('users', array('id' => $p_nId));
		}
		
		public function create_account ( $p_nId ) {
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
			
			$l_xCurrentDatabase->query("INSERT INTO `admins` (`username`, `password`, `email`, `client_id`) 
				VALUES ('admin', '21232f297a57a5a743894a0e4a801fc3', NULL, " . $p_nId . ");");

			$l_xCurrentDatabase->query("INSERT INTO `courses` (`title`, `description`, `buy_link`, `button_name`, `welcome_owned`, `welcome_buy`, `status`, `order`, `type`, `image`, `buy_button`, `icon`, `ep`, `signup_type`, `opt_in_checkbox`, `button_position`, `client_id`) 
				VALUES ('Subscriber Hub', '<p>Quick description of what kind of free content you have here.</p>', '', NULL, '<p>A message welcoming people who own and are looking at your Subscriber Hub.</p>', '<p>Quick message of why they should sign up for the subscriber hub.</p>', '1', '1', '1', NULL, '', NULL, '0', '2', '<p>I agree to the Terms of Service and Privacy Policy</p>', '1', " . $p_nId . ");");

			$l_xCurrentDatabase->query("INSERT INTO `settings` (`name`, `display`, `value`, `group`, `client_id`) 
				VALUES ('title', 'Site Title', 'MemberVault', 'appearance', " . $p_nId . "),
					('sub_title', 'Site Sub Title', 'Log In', 'appearance', " . $p_nId . "),
					('logo', 'na', '', 'appearance', " . $p_nId . "),
					('design', 'na', '1', '', " . $p_nId . "),
					('color_side_bg', 'Sidebar Background Color', '#32323A', 'appearance', " . $p_nId . "),
					('color_side_bg_highlight', 'Sidebar Background Color Highlight', '#29282e', 'appearance', " . $p_nId . "),
					('color_side_text', 'Sidebar Text Color', '#FFFFFF', 'appearance', " . $p_nId . "),
					('color_side_text_highlight', 'Sidebar Text Color Highlight', '#7CD8A9', 'appearance', " . $p_nId . "),
					('color_button_primary', 'Primary Button Background Color', '#5CC691', 'appearance', " . $p_nId . "),
					('color_button_danger', 'Danger Button Background Color', '#E55957', 'appearance', " . $p_nId . "),
					('email_company', 'Company', '', 'email', " . $p_nId . "),
					('email_url', 'API URL', '', 'email', " . $p_nId . "),
					('email_key', 'API Key', '', 'email', " . $p_nId . "),
					('email_app', 'API App ID', '', 'email', " . $p_nId . "),
					('leader_board', 'Show Leader Board', '1', 'social', " . $p_nId . "),
					('public_teaser', 'Enable Binge and Buy Marketplace', '1', 'social', " . $p_nId . "),
					('custom_css', 'Custom CSS', '', 'advanced', " . $p_nId . "),
					('custom_js', 'Custom Javascript', '', 'advanced', " . $p_nId . "),
					('footer_links', 'na', '', 'appearance', " . $p_nId . "),
					('color_primary_message_text', 'Primary Message Text Color', '#3c763d', 'appearance', " . $p_nId . "),
					('color_primary_message_background', 'Primary Message Background Color', '#dff0d8', 'appearance', " . $p_nId . "),
					('color_info_message_text', 'Info Message Text Color', '#31708f', 'appearance', " . $p_nId . "),
					('color_info_message_background', 'Info Message Background Color', '#d9edf7', 'appearance', " . $p_nId . "),
					('color_active_message_text', 'Active Message Text Color', '#8a6d3b', 'appearance', " . $p_nId . "),
					('color_active_message_background', 'Active Message Background Color', '#fcf8e3', 'appearance', " . $p_nId . "),
					('wizard', 'Enable Admin Wizard', '1', 'social', " . $p_nId . "),
					('stripe_id', 'Stripe Account ID', '', 'payment', " . $p_nId . "),
					('paypal_user', 'PayPal User', '', 'payment', " . $p_nId . "),
					('paypal_password', 'PayPal Password', '', 'payment', " . $p_nId . "),
					('paypal_signature', 'PayPal Signature', '', 'payment', " . $p_nId . "),
					('time_zone', 'na', 'America/Los_Angeles', 'appearance', " . $p_nId . "),
					('custom_admin_css', 'Custom Admin CSS', '', 'advanced', " . $p_nId . ");");

			$l_xCurrentDatabase->query("INSERT INTO `system` (`name`, `value`, `client_id`) 
				VALUES ('api_key', '', " . $p_nId . "),
					('type', '0', " . $p_nId . "),
					('billing_period', '', " . $p_nId . "),
					('billing_start', '', " . $p_nId . "),
					('version', '1.3.12', " . $p_nId . ");");
			
			return true;
		}

		public function get_dead() {
        	$query = $this->db->query('SELECT * FROM `users` WHERE `admin_activity` = 0 AND `user_activity` AND `master_db` = 0');
           	return $query->result_array();
       }

		public function get_account_types() {
			$query = $this->db->select('type')->group_by( 'type' )->get( 'users' );
			return $query->result_array();
		}


		public function search_emails( $p_sSearch ) {
			$l_axUsers = $this->users_model->get_active();

			$l_axReturn = array();
	
			foreach( $l_axUsers as $l_xUser ) {
				if ( $l_xUser['subdomain'] == 'admin' || $l_xUser['subdomain'] == 'beta' || $l_xUser['subdomain'] == 'course' ) { continue; }
	
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
		
				$l_xUsersTotal = $l_xCurrentDatabase->query( "SELECT * FROM users WHERE email LIKE '%" . $p_sSearch . "%' AND client_id = " . $l_nCurrentClient );
				$l_axFoundUsers = $l_xUsersTotal->result_array();
	
				foreach( $l_axFoundUsers as $l_xFoundUser ) {
					$l_xFoundUser['subdomain'] = $l_xUser['subdomain'];
					$l_xFoundUser['admin_id'] = $l_xUser['id'];
					$l_axReturn[] = $l_xFoundUser;	
				}

				$l_xCurrentDatabase->close();
			}

			return $l_axReturn;
		}


    }
?>