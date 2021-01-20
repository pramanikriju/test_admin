<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class create extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('session');			
		$this->load->library('form_validation');

		$this->load->helper('url_helper');
		$this->load->helper('form');

		$this->load->model('users_model');
		$this->load->model('user_actions_model');
		$this->load->model('system_logs_model');
		$this->load->model('settings_model');
		$this->load->model('system_model');
		$this->load->model('api_jobs_model');
		$this->load->model('consent_model');
	}
		
	public function account() {
		$data['l_sTitle'] = 'New MemberVault Account';
		$data['g_aaSettings'] = $this->settings_model->get_all_by_name();

		$fields = array(
			'api_key' => urlencode( 'd43265a3b821267e8dcc7ff2c544e8dd229f4cd4e31a76e204508e0e786c50e02af91b88' ),
			'api_output' => urlencode( 'json' ),
			'id' => urlencode( $_GET['id'] )
		);
		foreach( $fields as $key=>$value ) { $fields_string .= $key.'='.$value.'&'; }
		rtrim( $fields_string, '&' );

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://membervault.api-us1.com/admin/api.php?api_action=contact_view");
		curl_setopt($ch,CURLOPT_POST, count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		curl_close($ch);

		$l_xContact = json_decode( $result );
		if( ! $l_xContact->email ) {
			echo "Bad Contact ID";
			exit;
		}
		$l_xUser = $this->users_model->get_by_email( $l_xContact->email );
		if( $l_xUser ) {
			echo "Account Already Created";
			exit;
		}

		$data['email'] = $l_xContact->email;

		$this->load->view('create/create', $data);
	}

	public function add() {
		$l_asPayload = $_POST;

		$l_asPayload['subdomain'] = strtolower( $l_asPayload['subdomain'] );

		$fields = array(
			'api_key' => urlencode( 'd43265a3b821267e8dcc7ff2c544e8dd229f4cd4e31a76e204508e0e786c50e02af91b88' ),
			'api_output' => urlencode( 'json' ),
			'id' => urlencode( $_GET['id'] )
		);
		foreach( $fields as $key=>$value ) { $fields_string .= $key.'='.$value.'&'; }
		rtrim( $fields_string, '&' );

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://membervault.api-us1.com/admin/api.php?api_action=contact_view");
		curl_setopt($ch,CURLOPT_POST, count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		curl_close($ch);

		$l_xContact = json_decode( $result );
		if( ! $l_xContact->email ) {
			redirect( '/create/account/?id=' . $_GET['id'] . '&error=contact', 'refresh' );
		} else {
			$l_xTestUser = $this->users_model->get_by_email( $l_xContact->email );
			if( $l_xTestUser ) {
				redirect( '/create/account/?id=' . $_GET['id'] . '&error=user', 'refresh' );
			} else {
				$l_xAlreadyAccount = $this->users_model->get_by_subdomain( $l_asPayload['subdomain'] );
				if ( $l_xAlreadyAccount ) {
					redirect( '/create/account/?id=' . $_GET['id'] . '&error=subdomain', 'refresh' );
				} else {
					$l_asPayload['status'] = 1;
					$l_asPayload['type'] = 'Free';
					$l_asPayload['created'] = date('m/d/Y');				

					$l_nId = $this->users_model->add( $l_asPayload );

					$l_sLink = 'https://admin.vipmembervault.com/api/tag_user?subdomain=' . $l_asPayload['subdomain'] . '&tag=mv_admin_subdomain&apikey=testapikey';
					$this->api_jobs_model->add_call( $l_sLink );
					
					$l_sLink = 'https://admin.vipmembervault.com/api/add_subdomain/?apikey=testapikey&subdomain=' . $l_asPayload['subdomain'];
					$this->api_jobs_model->add_call( $l_sLink, true, 1 );

					$l_sEmail = "Your MemberVault account will be created at https://" . $l_asPayload['subdomain'] . ".vipmembervault.com/ in the next few minutes.\n\n";
					$l_sEmail .= "The username/password will be 'admin/admin' and you'll be prompted to change that to something else when you log in.\n\n";
					$l_sEmail .= "Once you log in, everything you need to get going is on the left hand side, including help documentation and videos.  If you run into any issues, please don't hesitate to reach out.  We’re excited that you are part of the Member Vault family now and look forward to seeing your courses succeed and engage your students!";

					//$l_xSend = sendMailGun( 'mike@membervault.co', 'New Member Vault Account', $l_sEmail );
					//$l_xSend = sendMailGun( $l_xContact->email, 'New Member Vault Account', $l_sEmail );
					
					redirect( '/create/done/' . $l_nId, 'refresh' );
				}
			}
		}
		
	}

	public function done( $p_nID ) {
		$data['l_sTitle'] = 'Account Created';
		$data['g_aaSettings'] = $this->settings_model->get_all_by_name();

		$data['l_xUser'] = $this->users_model->get_by_id( $p_nID );

		$this->load->view('create/done', $data);
	}

	public function new(){
		$this->load->view('create/new_header', $data);
		$this->load->view('create/new', $data);
		$this->load->view('create/new_footer', $data);
	}

	public function new_process(){
		$this->load->view('create/new_header', $data);

		$l_sEmail = trim( strip_tags( $_POST['email'] ) );
		$l_sFirstName = trim( strip_tags( $_POST['first_name'] ) );
		$l_sLastName = trim( strip_tags( $_POST['last_name'] ) );
		$l_sCompany = trim( strip_tags( $_POST['company'] ) );
		$l_sSubdomain = slugify( $l_sCompany );
		$l_sTag = trim( strip_tags( $_POST['tag'] ) );


		$l_sEmail = trim( strip_tags( $_POST['email'] ) );


		echo "Loading....<br><br>";
		if ( ( $l_sEmail == '' ) || ( $l_sCompany == '' ) || ( $l_sFirstName == '' ) ) {
			echo "Please fill out all fields";
			echo "<br><br><a href='/create/new'><- Back</a>";
			$this->load->view('create/new_footer', $data);
		} else {
			$l_xAlreadyUser = $this->users_model->get_by_email( $l_sEmail );

			if ( $l_xAlreadyUser ) {
				echo "It seems you already have an account!<br><br>Log in here:<br><br>";
				echo "<a href='https://" . $l_xAlreadyUser['subdomain'] . ".vipmembervault.com' target='_BLANK'>https://" . $l_xAlreadyUser['subdomain'] . ".vipmembervault.com</a>";
				echo "<br><br><a href='/create/new'><- Back</a>";
				$this->load->view('create/new_footer', $data);
			} else {
				
				$l_nCounter = 2;
				while( $this->users_model->get_by_subdomain( $l_sSubdomain ) ) {
					$l_sSubdomain = slugify( $l_sCompany . $l_nCounter );
					$l_nCounter++;
				}

				$l_asPayload = array();
				$l_asPayload['status'] = 1;
				$l_asPayload['type'] = 'Free';
				$l_asPayload['subdomain'] = $l_sSubdomain;
				$l_asPayload['email'] = $l_sEmail;
				$l_asPayload['first_name'] = $l_sFirstName;
				$l_asPayload['last_name'] = $l_sLastName;
				$l_asPayload['created'] = date('m/d/Y');				
				$l_asPayload['master_db'] = 1;				
				if ( $l_sTag != '' ) {
					$l_asPayload['affiliate'] = $l_sTag;
				}

				/************* GDPR STUFF ******************/

				if ( $_POST['market'] ){
					$l_sConsent = 1;
				} else {
					$l_sConsent = 0;
				}
		
				if ( $l_sEmail ) {
					$l_asConsentLog = array();
					$l_asConsentLog['timestamp'] = time();
					$l_asConsentLog['email'] = $l_sEmail;
					$l_asConsentLog['name'] = $l_sFirstName;
					$l_asConsentLog['consent'] = $l_sConsent;
					$l_asConsentLog['how'] = 'New Account Created';
			
					$this->consent_model->add( $l_asConsentLog );
				}
				
				$l_sLink = 'https://admin.vipmembervault.com/api/ac_add_new_user?apikey=testapikey&email=' . urlencode( $l_sEmail ) . '&first_name=' . urlencode( $l_sFirstName ) . '&last_name=' . urlencode( $l_sLastName ) . '&subdomain=' . urlencode( $l_sSubdomain ) . '&consent=' . $l_sConsent;
				$this->api_jobs_model->add_call( $l_sLink );
								
				if ( DB_HOST != 'localhost' ) {
					// Proof Webhook
					$l_asJson = array(
						'type' => 'custom',
						'email' => $l_sEmail,
						'first_name' => $l_sFirstName
					);
					$l_sUrl = 'https://webhook.proofapi.com/cw/25mmq26eqgQRjr0wr6aXdwz8znr2/-LDlhgtH22wuUEBDp3PP';
					$l_sRequest = json_encode( $l_asJson );
	
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
					curl_setopt($ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json' ) ); 
					curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
					curl_setopt($ch, CURLOPT_URL, $l_sUrl );
					curl_setopt($ch, CURLOPT_POST, 1 );
					curl_setopt($ch, CURLOPT_POSTFIELDS, $l_sRequest ); 
	
					$l_sReturn = curl_exec($ch);
					curl_close($ch);
				}

				$l_nId = $this->users_model->add( $l_asPayload );
				if ( $l_nId ) {
					$this->users_model->create_account( $l_nId );					
					shell_exec( 'sudo /var/www/html/_CORE/create_new.sh ' . $l_sSubdomain . ' ' . $l_nId . ' &> /dev/null &' );
					redirect( '/create/new_done/' . $l_nId, 'refresh' );
				}
			}
		}
	}

	public function new_process_2(  $p_nID ){
		$l_xUser = $this->users_model->get_by_id( $p_nID );
		$data['l_xUser'] = $l_xUser;

		$this->load->view('create/new_header', $data);

		echo "Loading....<br><br>";

		$this->load->helper('ac');

		$l_xAcUser = ac_add_update_contact( $l_xUser['email'], $l_xUser['first_name'], $l_xUser['last_name']  );
		$l_nContactId = $l_xAcUser[contact][id];

		$l_xFields = ac_set_custom_field( $l_nContactId, 8, $_POST['email_service'] );
		$l_xFields = ac_set_custom_field( $l_nContactId, 9, $_POST['sales_source'] );

		if ( $_GET['status'] == 'info' ) {
			redirect( '/create/new_done_info/' . $p_nID, 'refresh' );
		} else {
			redirect( '/create/new_done/' . $p_nID, 'refresh' );
		}
		
	}

	public function new_info( $p_nID ) {
		$data['l_xUser'] = $this->users_model->get_by_id( $p_nID );

		$this->load->view('create/new_header', $data);
		$this->load->view('create/new_info', $data);
		$this->load->view('create/new_footer', $data);
	}

	public function new_info_update() {
		$data['l_xUser'] = $this->users_model->get_by_email( $_GET['email'] );
		$data['l_sStatus'] = 'info';

		$this->load->view('create/new_header', $data);
		$this->load->view('create/new_info', $data);
		$this->load->view('create/new_footer', $data);
	}


	public function new_done( $p_nID ) {
		$data['l_xUser'] = $this->users_model->get_by_id( $p_nID );

		$this->load->view('create/new_header', $data);
		$this->load->view('create/new_done', $data);
		$this->load->view('create/new_footer', $data);
	}

	public function new_done_info( $p_nID ) {
		$data['l_xUser'] = $this->users_model->get_by_id( $p_nID );

		$this->load->view('create/new_header', $data);
		$this->load->view('create/new_done_info', $data);
		$this->load->view('create/new_footer', $data);
	}

	public function lookup(){
		$this->load->view('create/new_header', $data);
		$this->load->view('create/lookup', $data);
		$this->load->view('create/new_footer', $data);
	}

	public function lookup_process(){
		if ( trim( $_POST['email'] ) != '' ) {
			$l_xUser = $this->users_model->get_by_email( $_POST['email'] );
		}
		$data['l_xUser'] = $l_xUser;

		$this->load->view('create/new_header', $data);
		$this->load->view('create/lookup_done', $data);
		$this->load->view('create/new_footer', $data);
	}

	public function show_ep_leaders(){
		$data['l_axUsers'] = $this->users_model->get_by_ep();

		$this->load->view('create/new_header', $data);
		$this->load->view('create/ep_leaders', $data);
		$this->load->view('create/new_footer', $data);


	}

	public function show_ep_daily() {

		$l_xCached = $this->system_model->get_from_cache( 'daily_hourly_ep' );

		$l_nTimeSince = floor( abs( time() - $l_xCached['time'] ) / 60 );

		$l_axUsers = json_decode( $l_xCached['data'], true );

		header("Access-Control-Allow-Origin: *");
?>
			<p>Want some inspiration?  These are the top EP earning accounts today!</p>
			<table class="table table-striped">
				<tbody>
					<tr>
						<th>Account</th>
						<th>EP</th>
						<th>&nbsp;</th>
					</tr>
					<?php
						$l_nCount = 1;
						foreach( $l_axUsers as $l_xUser ) {
					?>
							<tr>
								<td><?php echo $l_nCount ?>. <a href="https://<?php echo $l_xUser['subdomain'] ?>.vipmembervault.com/" target="_BLANK"><?php echo $l_xUser['subdomain'] ?></a></td>
								<td><?php echo number_format( $l_xUser['ep_count'] ) ?></td>
								<td><a href="https://<?php echo $l_xUser['subdomain'] ?>.vipmembervault.com/" target="_BLANK">(view marketplace)</a></td>
							</tr>
					<?php
							$l_nCount++;
						}
					?>
				</tbody>
			</table>
			<p><i>(updated <?php echo $l_nTimeSince ?> minutes ago )</i></p>
			<p style="font-style:italic;">* Don't want to be listed here?  Just let us know by chat or email!</p>
<?php



	}


}
?>