<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class api extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('session');			
		$this->load->helper('url_helper');
		$this->load->model('admins_model');
		$this->load->model('users_model');
		$this->load->model('user_logs_model');
		$this->load->model('user_actions_model');
		$this->load->model('system_logs_model');
		$this->load->model('system_model');
		$this->load->model('api_jobs_model');
		$this->load->model('settings_model');
		$this->load->model('consent_model');

		$g_sVersion = $this->system_model->get_version();
		if ( $g_sVersion['value'] !== VIP_VERSION ) {
			echo "Updating Datbase to " . VIP_VERSION . ", Please Wait ...<br><br>";
			$this->system_model->update_database( $g_sVersion['value'], VIP_VERSION );
			echo "Upgrade Complete, please refresh this page.";
			header('Location: /');
		}

		$l_sKey = trim( $_GET['apikey'] );
		if ( empty( $l_sKey ) ) {
			echo "No API Key Provided";
			$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$this->system_logs_model->add_by_event_data( "error_no_api_key", $actual_link, date("Y-m-d") );
			exit;
		}

		$g_sApiKey = $this->system_model->get_api_key();
		if ( $g_sApiKey['value'] != $l_sKey ){
			echo "API Key Not Valid";
			$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$this->system_logs_model->add_by_event_data( "error_bad_api_key", $actual_link, date("Y-m-d") );
			exit;
		}
	}

	public function auth_test(){
		echo '{"status": "ok"}';
	}

	public function ac_add_new_user() {
		$l_sEmail = strip_tags( $_GET['email'] );
		$l_sFirstName = strip_tags( $_GET['first_name'] );
		$l_sLastName = strip_tags( $_GET['last_name'] );
		$l_sSubdomain = strip_tags( $_GET['subdomain'] );
		$l_sConsent = strip_tags( $_GET['consent'] );

		$this->load->helper('ac');

		$l_xAcUser = ac_add_update_contact( $l_sEmail, $l_sFirstName, $l_sLastName );
		$l_nContactId = $l_xAcUser[contact][id];

		$l_xAcUserTag = ac_add_tag( $l_nContactId, '[admin] new user' );
		$l_xAcUserTag2 = ac_add_tag( $l_nContactId, '[admin] omit from consent webhook' );
		$l_xAcUserTag3 = ac_add_tag( $l_nContactId, 'mv_admin_subdomain' );

		$l_axFields = ac_get_custom_fields();

		$l_xFields = ac_set_custom_field( $l_nContactId, 4, $l_sSubdomain );
		$l_xFields = ac_set_custom_field( $l_nContactId, 10, $_POST['company'] );

		$l_xTag = ac_add_tag( $l_nContactId, '[client] free account' );

		if ( $l_sConsent == 1 ) {
			$l_xTag = ac_add_tag( $l_nContactId, '[admin] consent received' );
		} else {
			$l_xTag = ac_add_tag( $l_nContactId, '[admin] consent not given' );
		}

	}

	public function add_api_job(){
		$l_sUrl = $_GET['url'];
		$this->api_jobs_model->add_call( $l_sUrl );
		echo "Job Added";
	}

	public function check_subdomain(){
		$l_sSubdomain = trim( $_GET['subdomain'] );
		$l_xUser = $this->users_model->get_by_subdomain( $l_sSubdomain );
		if ( $l_xUser ) {
			echo 1;
		} else {
			echo 0;
		}
	}

	public function add_subdomain(){
		echo "Adding " . $_GET['subdomain'];
		shell_exec( 'sudo /var/www/html/_CORE/create.sh ' . $_GET['subdomain'] );

		//$l_sLink = 'https://admin.vipmembervault.com/api/update_all_emails/?apikey=testapikey';
		//$this->add_api_job( $l_sLink );
	}

	public function create_backup(){
		echo "Backing Up " . $_GET['subdomain'];
		shell_exec( 'sudo /var/www/html/_CORE/backup.sh ' . $_GET['subdomain'] );		
	}

	public function process_backups(){
		$l_axUsers = $this->users_model->get_all();
		foreach( $l_axUsers as $l_xUser ) {
			$l_sLink = 'https://admin.vipmembervault.com/api/create_backup/?apikey=testapikey&subdomain=' . $l_xUser['subdomain'];
			$this->api_jobs_model->add_call( $l_sLink, true );
		}		
	}
	
	public function process_api_jobs(){
		$l_axJobs = $this->api_jobs_model->get_batch();
		foreach( $l_axJobs as $l_xJob ) {

			if ( $l_xJob['response'] == 'skipped' ) {
				$l_xJob['time_done'] = date("Y-m-d H:i:s");
				$l_xJob['status'] = 1;
				$this->api_jobs_model->save( $l_xJob );

				$ch = curl_init();
				curl_setopt( $ch, CURLOPT_URL, $l_xJob['url'] );
				curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
				$l_sTemp = curl_exec($ch);
				curl_close($ch);

			} else {
				$ch = curl_init();
				curl_setopt( $ch, CURLOPT_URL, $l_xJob['url'] );
				curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
				$l_xJob['response'] = curl_exec($ch);
				curl_close($ch);

				$l_xJob['time_done'] = date("Y-m-d H:i:s");
				$l_xJob['status'] = 1;

				$this->api_jobs_model->save( $l_xJob );
			}
		}
		
		//$this->api_jobs_model->delete_outdated();

		echo "done";
	}
	
	public function process_slackers_and_ghosts(){
		if ( $_GET['date'] ) {
			$l_sDate = $_GET['date'];
		} else {
			$l_sDate = date('Y-m-d');			
		}

		$l_axUsers = $this->users_model->get_all();
		foreach( $l_axUsers as $l_xUser ) {
			if ( $l_xUser['subdomain'] == 'admin' || $l_xUser['subdomain'] == 'beta' ) { continue; }
			$l_sLink = 'https://' . $l_xUser['subdomain'] . '.vipmembervault.com/adminapi/tag_slackers/?apikey=testapikey&date=' . $l_sDate;
			//$this->api_jobs_model->add_call( $l_sLink );

			$l_sLink = 'https://' . $l_xUser['subdomain'] . '.vipmembervault.com/adminapi/tag_ghosts/?apikey=testapikey&date=' . $l_sDate;
			$this->api_jobs_model->add_call( $l_sLink );
		}
	}

	public function process_intercom_tags(){
		$l_axUsers = $this->users_model->get_all();
		foreach( $l_axUsers as $l_xUser ) {
			if ( $l_xUser['subdomain'] == 'admin' || $l_xUser['subdomain'] == 'beta' ) { continue; }
			$l_sLink = 'https://' . $l_xUser['subdomain'] . '.vipmembervault.com/adminapi/tag_intercom_events/?apikey=testapikey';
			$this->api_jobs_model->add_call( $l_sLink );
		}		
	}

	public function check_all_payments(){
		$l_axUsers = $this->users_model->get_all( 'ep' );
		foreach( $l_axUsers as $l_xUser ) {
			if ( $l_xUser['subdomain'] == 'admin' || $l_xUser['subdomain'] == 'beta' ) { continue; }
			$l_sLink = 'https://' . $l_xUser['subdomain'] . '.vipmembervault.com/adminapi/stripe_payment_stops/?apikey=testapikey';
			$this->api_jobs_model->add_call( $l_sLink );
		}		
	}

	public function update_all_emails(){
		$l_axUsers = $this->users_model->get_all( 'ASC' );
		foreach( $l_axUsers as $l_xUser ) {
			if ( $l_xUser['subdomain'] == 'admin' || $l_xUser['subdomain'] == 'beta' ) { continue; }
			$l_sLink = 'https://' . $l_xUser['subdomain'] . '.vipmembervault.com/adminapi/set_admin_email/?apikey=testapikey&email=' . $l_xUser['email'];
			$this->api_jobs_model->add_call( $l_sLink );
		}		
	}

	public function update_account_email(){
		$l_sSubdomain = trim( $_GET['subdomain'] );
		$l_xUser = $this->users_model->get_by_subdomain( $l_sSubdomain );

		if ( $l_xUser['email'] ) {
			$l_sLink = 'https://' . $l_sSubdomain . '.vipmembervault.com/adminapi/set_admin_email/?apikey=testapikey&email=' . $l_xUser['email'];
			$this->system_model->call_webhook( $l_sLink );
		}
	}
	
	public function lock_account(){
		$l_sEmail = trim( $_GET['email'] );
		$l_xUser = $this->users_model->get_by_email( $l_sEmail );
		if ( ! $l_xUser ) {
			$l_xSend = sendMailGun( 'mike@membervault.co', 'Orphaned Lock', $l_sEmail . ' has been locked, but there is no account for them.' );
			exit;
		}

		$l_sLink = 'https://' . $l_xUser['subdomain'] . '.vipmembervault.com/adminapi/lock_account?apikey=testapikey';
		$this->api_jobs_model->add_call( $l_sLink );
	}

	public function bonus_limit(){
		$l_sEmail = trim( $_GET['email'] );
		$l_xUser = $this->users_model->get_by_email( $l_sEmail );
		if ( ! $l_xUser ) {
			$actual_link = SITE_URL . $_SERVER['REQUEST_URI'];
			$l_xSend = sendMailGun( 'mike@membervault.co', 'Orphaned Bonus', $l_sEmail . ' has earned a bonus, but there is no account for them. URL: ' . $actual_link );
			exit;
		}

		$l_sLink = 'https://' . $l_xUser['subdomain'] . '.vipmembervault.com/adminapi/bonus_limit?apikey=testapikey&limit=' . $_GET['limit'];
		$this->system_model->call_webhook( $l_sLink );
	}

	public function bonus_add(){
		$l_sEmail = trim( $_GET['email'] );
		$l_xUser = $this->users_model->get_by_email( $l_sEmail );
		if ( ! $l_xUser ) {
			$actual_link = SITE_URL . $_SERVER['REQUEST_URI'];
			$l_xSend = sendMailGun( 'mike@membervault.co', 'Orphaned Bonus Add', $l_sEmail . ' has earned a bonus add, but there is no account for them. URL: ' . $actual_link );
			exit;
		}

		$l_sLink = 'https://' . $l_xUser['subdomain'] . '.vipmembervault.com/adminapi/bonus_add?apikey=testapikey&limit=' . $_GET['limit'];
		$this->system_model->call_webhook( $l_sLink );
	}


	public function update_billing(){
		$l_sEmail = trim( $_GET['email'] );
		$l_nType = trim( $_GET['type'] );
		$l_sBillingPeriod = trim( $_GET['billing_period'] );
		if ( ! $l_sBillingPeriod ) {
			$l_sBillingPeriod = 'Monthly';
		}
		
		$l_xUser = $this->users_model->get_by_email( $l_sEmail );
		if ( ! $l_xUser ) {
			$l_sMessage = 'We recently had a request for a MemberVault plan upgrade at the email address ' . $l_sEmail . ', however we don\'t have any records of an account associated with this email.  ';
			$l_sMessage .= 'Our team has been notified of this as well, so simply reach out to support by chat or emailing hello@membervault.co to let us know which account should be upgraded.  We\'ll be able to manually upgrade it for you then!';

			$l_xSend = sendMailGun( 'hello@membervault.co', 'Orphaned Upgrade', $l_sEmail . ' has upgraded, but there is no account for them.  They have been sent an email as well.' );
			//$l_xSend1 = sendMailGun( 'mike@membervault.co', 'Orphaned Upgrade', $l_sEmail . ' has upgraded, but there is no account for them.  They have been sent an email as well.' );

			$l_xSend2 = sendMailGun( $l_sEmail, 'Your recent MemberVault upgrade', $l_sMessage );
			//$l_xSend3 = sendMailGun( 'mike@membervault.co', 'Your recent MemberVault Plan change', $l_sMessage );
			exit;
		}

		$l_sLink = 'https://' . $l_xUser['subdomain'] . '.vipmembervault.com/adminapi/update_billing?apikey=testapikey&type=' . $l_nType . '&billing_period=' . $l_sBillingPeriod;
		$this->api_jobs_model->add_call( $l_sLink );

		if ( $l_nType > 0 ) {
			$l_sRemoveLink = 'https://admin.vipmembervault.com/api/remove_tag_user?subdomain=' . $l_xUser['subdomain'] . '&tag=mv_over_limit_free&apikey=testapikey';
			$this->api_jobs_model->add_call( $l_sRemoveLink );
			$l_sRemoveLink = 'https://admin.vipmembervault.com/api/remove_tag_user?subdomain=' . $l_xUser['subdomain'] . '&tag=mv_over_limit_starter&apikey=testapikey';
			$this->api_jobs_model->add_call( $l_sRemoveLink );
			$l_sRemoveLink = 'https://admin.vipmembervault.com/api/remove_tag_user?subdomain=' . $l_xUser['subdomain'] . '&tag=mv_over_limit_base&apikey=testapikey';
			$this->api_jobs_model->add_call( $l_sRemoveLink );
			$l_sRemoveLink = 'https://admin.vipmembervault.com/api/remove_tag_user?subdomain=' . $l_xUser['subdomain'] . '&tag=mv_over_limit_pro&apikey=testapikey';
			$this->api_jobs_model->add_call( $l_sRemoveLink );
		}


		// Free
		if ( $l_nType == 0 ) {
			$l_xUser['type'] = 'Free';
		}

		// Pro Unlimited (old)
		if ( $l_nType == 1 ) {
			$l_xUser['type'] = 'Pro+: ' . $l_sBillingPeriod;
		}

		// Base
		if ( $l_nType == 2 ) {
			$l_xUser['type'] = 'Base: ' . $l_sBillingPeriod;
		}

		// Pro
		if ( $l_nType == 3 ) {
			$l_xUser['type'] = 'Pro: ' . $l_sBillingPeriod;
		}

		// Pro Plus
		if ( $l_nType == 4 ) {
			$l_xUser['type'] = 'Pro+: ' . $l_sBillingPeriod;
		}

		// Starter Lifetime
		if ( $l_nType == 5 ) {
			$l_xUser['type'] = 'Lifetime: Starter';
		}

		// Lifetime Lite
		if ( $l_nType == 6 ) {
			$l_xUser['type'] = 'Lifetime: Lite';
		}

		// Lifetime Pro
		if ( $l_nType == 7 ) {
			$l_xUser['type'] = 'Lifetime: Pro';
		}

		// Founding 100
		if ( $l_nType == 8 ) {
			$l_xUser['type'] = 'Lifetime: Founding 100';
		}

		// Trial Plan
		if ( $l_nType == 9 ) {
			$l_xUser['type'] = 'Promo: Promo';
		}

		// Starter Plan
		if ( $l_nType == 10 ) {
			$l_xUser['type'] = 'Starter: ' . $l_sBillingPeriod;
		}

		$this->users_model->save( $l_xUser );

		$l_asPayload = array();
		$l_asPayload['user_id'] = $l_xUser['id'];
		$l_asPayload['date'] = date();

		if ( $l_nType == 0 ) {
			$l_asPayload['action'] = 'downgrade';
		} else {
			$l_asPayload['action'] = 'upgrade';
		}
		$l_asPayload['notes'] = $l_nType;

		$this->user_actions_model->add( $l_asPayload );
	}

	public function trial_end(){
		$l_sEmail = trim( $_GET['email'] );
		
		$l_xUser = $this->users_model->get_by_email( $l_sEmail );
		if ( ! $l_xUser ) {
			$l_xSend = sendMailGun( 'mike@membervault.co', 'Orphaned Trial End', $l_sEmail . ' has ended a trial, but there is no account for them.' );
			exit;
		}

		$l_axClientDB = $this->system_model->get_client_database( $l_xUser );
		$l_aaSystem = $this->system_model->get_account_system( $l_axClientDB['db'], $l_axClientDB['client_id'] );



		if ( $l_aaSystem['type']['value'] == 9 ) {

			$l_nRevert = 0;
			if ( $l_aaSystem['before_trial']['value'] ) {
				$l_nRevert = $l_aaSystem['before_trial']['value'];
			}

			$l_axClientDB['db']->query("UPDATE `system` SET `value` = '" . $l_nRevert . "' WHERE (`client_id` = '" . $l_axClientDB['client_id'] . "') AND (`name` = 'type')");

			$l_xUser['type'] = get_account_type_by_id( $l_nRevert );
			$this->users_model->save( $l_xUser );
		}

	}
	
	public function update_consent(){
		$l_sEmail = trim( $_GET['email'] );
		$l_sName = trim( $_GET['name'] );
		$l_sConsent = trim( $_GET['consent'] );
		$l_sHow = trim( $_GET['how'] );

		if ( $l_sEmail ) {
			$l_asConsentLog = array();
			$l_asConsentLog['timestamp'] = time();
			$l_asConsentLog['email'] = $l_sEmail;
			$l_asConsentLog['name'] = $l_sName;
			$l_asConsentLog['consent'] = $l_sConsent;
			if ( $l_sHow ) {
				$l_asConsentLog['how'] = $l_sHow;
			} else {
				$l_asConsentLog['how'] = 'Webhook Called';				
			}
	
			$this->consent_model->add( $l_asConsentLog );
		} else {
			echo "Missing information";
		}
	}



}
