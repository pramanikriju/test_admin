<?php

$data['g_aaSettings'] = $this->settings_model->get_all_by_name();

if ( ! $p_sPage ) {
	$data['l_sTitle'] = 'Users';
	$data['l_axUsers'] = $this->users_model->get_all( 'id', 'DESC', $_GET['type'] );
				
	$this->load->view('admin/header', $data);
	$this->load->view('admin/users', $data);
	$this->load->view('admin/footer', $data);
}

if ($p_sPage == "edit") {
	if ( ! $_POST ) {
		$data['l_xUser'] = $this->users_model->get_by_id( $p_sArgument );
		$data['l_sTitle'] = '<a href="/admin/users">Users</a> - '. htmlspecialchars( $data['l_xUser']['first_name'], ENT_QUOTES ) .' ' . htmlspecialchars( $data['l_xUser']['last_name'], ENT_QUOTES );
		$data['l_axErrors'] = $this->system_model->get_errors_by_account( $data['l_xUser']['subdomain'], 1000 );

		$data['l_nActivityTotal'] = $this->user_logs_model->get_total_by_subdomain( $data['l_xUser']['subdomain'] );
		$data['l_axActivityTotals'] = $this->user_logs_model->get_totals_by_subdomain( $data['l_xUser']['subdomain'] );

		$data['l_axActivityLatest'] = $this->user_logs_model->get_by_subdomain( $data['l_xUser']['subdomain'], 500 );
		
		
		$this->load->view('admin/header', $data);
		$this->load->view('admin/users_edit', $data);
		$this->load->view('admin/footer', $data);
	} else {
		$l_xUser = $this->users_model->get_by_id( $_POST['id'] );
		$l_asPayload = $_POST;
		$l_asPayload['created'] = sqlDate( $l_asPayload['created'] );
		$l_asPayload['upgraded'] = sqlDate( $l_asPayload['upgraded'] );
		$l_asPayload['cancelled'] = sqlDate( $l_asPayload['cancelled'] );

		$this->users_model->save( $l_asPayload );

		if ( $l_xUser['bonus'] != $l_asPayload['bonus'] ) {
			$l_sLink = 'https://' . $l_xUser['subdomain'] . '.vipmembervault.com/adminapi/bonus_limit?apikey=testapikey&limit=' . $l_asPayload['bonus'];
			$this->system_model->call_webhook( $l_sLink );
		}

		if ( $l_xUser['type'] != $l_asPayload['type'] ) {

			if ( $l_asPayload['type'] == 'Free' ) {
				$l_sLink = 'https://' . $l_xUser['subdomain'] . '.vipmembervault.com/adminapi/update_billing?apikey=testapikey&type=0';
				$this->system_model->call_webhook( $l_sLink );
			} else if ( $l_asPayload['type'] == 'Lifetime: Starter' ) {
				$l_sLink = 'https://' . $l_xUser['subdomain'] . '.vipmembervault.com/adminapi/update_billing?apikey=testapikey&type=5';
				$this->system_model->call_webhook( $l_sLink );
			} else if ( $l_asPayload['type'] == 'Lifetime: Pro' ) {
				$l_sLink = 'https://' . $l_xUser['subdomain'] . '.vipmembervault.com/adminapi/update_billing?apikey=testapikey&type=7';
				$this->system_model->call_webhook( $l_sLink );
			} else if ( $l_asPayload['type'] == 'Lifetime: Lite' ) {
				$l_sLink = 'https://' . $l_xUser['subdomain'] . '.vipmembervault.com/adminapi/update_billing?apikey=testapikey&type=6';
				$this->system_model->call_webhook( $l_sLink );
			} else if ( $l_asPayload['type'] == 'Lifetime: Founding 100' ) {
				$l_sLink = 'https://' . $l_xUser['subdomain'] . '.vipmembervault.com/adminapi/update_billing?apikey=testapikey&type=8';
				$this->system_model->call_webhook( $l_sLink );
			} else if ( $l_asPayload['type'] == 'Promo: Promo' ) {
				$l_sLink = 'https://' . $l_xUser['subdomain'] . '.vipmembervault.com/adminapi/update_billing?apikey=testapikey&type=9';
				$this->system_model->call_webhook( $l_sLink );
			} else {
				$l_asPaidOptions = explode( ':', $l_asPayload['type'] );
				if ( trim( $l_asPaidOptions[0] == 'Base' ) ) {
					$l_sLink = 'https://' . $l_xUser['subdomain'] . '.vipmembervault.com/adminapi/update_billing?apikey=testapikey&type=2&billing_period=' . trim( $l_asPaidOptions[1] );
					$this->system_model->call_webhook( $l_sLink );
				} else if ( trim( $l_asPaidOptions[0] == 'Pro+' ) ) {		
					$l_sLink = 'https://' . $l_xUser['subdomain'] . '.vipmembervault.com/adminapi/update_billing?apikey=testapikey&type=4&billing_period=' . trim( $l_asPaidOptions[1] );
					$this->system_model->call_webhook( $l_sLink );
				} else if ( trim( $l_asPaidOptions[0] == 'Pro' ) ) {
					$l_sLink = 'https://' . $l_xUser['subdomain'] . '.vipmembervault.com/adminapi/update_billing?apikey=testapikey&type=3&billing_period=' . trim( $l_asPaidOptions[1] );
					$this->system_model->call_webhook( $l_sLink );
				} else if ( trim( $l_asPaidOptions[0] == 'Starter' ) ) {
					$l_sLink = 'https://' . $l_xUser['subdomain'] . '.vipmembervault.com/adminapi/update_billing?apikey=testapikey&type=10&billing_period=' . trim( $l_asPaidOptions[1] );
					$this->system_model->call_webhook( $l_sLink );
				} else {}
			}
				
		}

		if ( $l_xUser['email'] != $l_asPayload['email'] ) {
			$l_sLink = 'https://' . $l_xUser['subdomain'] . '.vipmembervault.com/adminapi/set_admin_email?apikey=testapikey&email=' . trim( urlencode( $l_asPayload['email'] ) );
			$this->system_model->call_webhook( $l_sLink );
		}

		redirect('/admin/users/edit/' . $_POST['id'], 'refresh');				
	}
}
if ( $p_sPage == "move_account" ) {

	$l_nId = $_GET['id'];
	$l_sNew = slugify( trim( $_GET['new'] ) );

	$l_xUser = $this->users_model->get_by_id( $l_nId );
	$l_sOld = $l_xUser['subdomain'];

	if ( $l_sOld && $l_sNew && ( $l_sOld != $l_sNew ) ) {
		echo "1";
		copy_s3_folder( $l_sOld, $l_sNew );
		echo "2";
		if ( $l_xUser['master_db'] == 0 ) {
			shell_exec( 'sudo /var/www/html/_CORE/create_copy.sh ' . $l_sNew . ' ' . $l_sOld . ' &> /dev/null &' );
		} else {
			shell_exec( 'sudo /var/www/html/_CORE/create_copy_new.sh ' . $l_sNew . ' ' . $l_sOld . ' ' . $l_nId . ' &> /dev/null &' );
		}
		echo "3";
		
		$l_xUser['subdomain'] = $l_sNew;
		$this->users_model->save( $l_xUser );
		//$l_xSend = sendMailGun( 'mike@membervault.co', 'Domain Change', $l_sOld . ' has been renamed ' . $l_sNew  );

	}
	redirect( '/admin/users/edit/' . $l_nId, 'refresh' );
}
if ( $p_sPage == "move_empty_accounts" ) {
	$l_axUsers = $this->users_model->get_dead();
	foreach ( $l_axUsers as $l_xUser ) {
		$l_nClientId = $l_xUser['id'];
		$l_sSubdomain = $l_xUser['subdomain'];


		print_r( $l_nClientId );
		print_r( $l_sSubdomain );
		echo "<hr>";

		exit;
	}
	
}

if ( $p_sPage == "delete_account" ) {

	$l_nId = $_GET['id'];
	$l_xUser = $this->users_model->get_by_id( $l_nId );

	if ( $l_xUser['subdomain'] == 'membervault_master' || $l_xUser['subdomain'] == 'admin' || $l_xUser['subdomain'] == '' ) {
		exit;
	}

	if ( $l_xUser ) {
		$this->users_model->delete( $l_xUser['id'] );
		//$l_xSend = sendMailGun( 'mike@membervault.co', 'Account Deleted', $l_xUser['subdomain'] . ' has been deleted'  );

		if ( $l_xUser['master_db'] == 0 ) {
			shell_exec( 'sudo /var/www/html/_CORE/remove.sh ' . $l_xUser['subdomain'] . ' &> /dev/null &' );
			redirect( '/admin/users', 'refresh' );
		} else {
			shell_exec( 'sudo /var/www/html/_CORE/remove_new.sh ' . $l_xUser['subdomain'] . ' &> /dev/null &' );
			redirect( '/admin/users', 'refresh' );
		}
	}
}

if ( $p_sPage == 'activity_dates' ) {
	$l_sSubdomain = $_POST['subdomain'];
	$l_sEvent = $_POST['event'];

	$l_axDates = $this->user_logs_model->get_by_subdomain_event( $l_sSubdomain, $l_sEvent );
	foreach ( $l_axDates as $l_xDate ) {
		echo date( 'm/d/Y - h:i A', $l_xDate['time'] );
		if ( $l_xDate['data'] ) {
			echo ' (<b>' . $l_xDate['data'] . '</b>)';
		}
		echo '<br>';
	}

}

if ( $p_sPage == 'reset_custom' ) {
	$l_nId = $_GET['id'];
	$l_xUser = $this->users_model->get_by_id( $l_nId );

	if ( $l_xUser['subdomain'] == 'membervault_master' || $l_xUser['subdomain'] == 'admin' || $l_xUser['subdomain'] == '' ) {
		exit;
	}

	$l_sLink = 'https://' . $l_xUser['subdomain'] . '.vipmembervault.com/adminapi/reset_custom_domain?apikey=testapikey';
	$this->api_jobs_model->add_call( $l_sLink );

	$l_sLink = 'https://' . $l_xUser['subdomain'] . '.vipmembervault.com/adminapi/cleanup_custom_domain?apikey=testapikey';
	$this->api_jobs_model->add_call( $l_sLink );

	$l_xUser['url'] = '';
	$this->users_model->save( $l_xUser );		
	
	redirect( '/admin/users/edit/' . $l_nId, 'refresh' );

}

?>