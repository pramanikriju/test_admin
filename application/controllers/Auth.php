<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class auth extends CI_Controller {

    public function authorize_ifs(){
		if ( $_GET['code'] ) {
			$l_sAuthCode = $_GET['code'];
			$data = array(
				'client_id' => IFS_CLIENT,
				'client_secret' => IFS_SECRET,
				'code' => $_GET['code'],
				'grant_type' => 'authorization_code',
				'redirect_uri' => 'https://admin.vipmembervault.com/auth/authorize_ifs',
			);
	
			$handle = curl_init('https://api.infusionsoft.com/token');
			curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($handle, CURLOPT_POST, true);
			curl_setopt($handle, CURLOPT_POSTFIELDS, http_build_query( $data ) );
			$resp = curl_exec($handle);
	
			$l_asResponse = json_decode( $resp, true );


			// Set Account Info
			$data = array(
				'email_url' => $l_asResult[entries][0][id],
				'email_key' => $l_asResponse['access_token'],
				'email_app' => $l_asResponse['refresh_token'],
				'email_company' => 7,
			);

			if ( $_GET['state'] == 'vipmembervault' ) {
				echo "SUCCESS: ";
				print_r( $data );
			} else {
				$handle = curl_init('https://' . $_GET['state'] . '.vipmembervault.com/adminapi/set_email_token/?apikey=testapikey');
				curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($handle, CURLOPT_POST, true);
				curl_setopt($handle, CURLOPT_POSTFIELDS, http_build_query( $data ) );
				$resp = curl_exec($handle);
		
				if ( $resp == 1 ) {
					header('Location: https://' . $_GET['state'] . '.vipmembervault.com/admin/settings/tagging/?status=saved');
				} else {
					echo $resp;
				}
			}
		}		
    }

    public function authorize_aweber(){
		if ( $_GET['code'] ) {
			$l_sAuthCode = $_GET['code'];
			$data = array(
				'client_id' => AWEBER_CLIENT,
				'client_secret' => AWEBER_SECRET,
				'code' => $_GET['code'],
				'grant_type' => 'authorization_code',
				'redirect_uri' => 'https://admin.vipmembervault.com/auth/authorize_aweber',
			);
	
			$handle = curl_init('https://auth.aweber.com/oauth2/token');
			curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($handle, CURLOPT_POST, true);
			curl_setopt($handle, CURLOPT_POSTFIELDS, http_build_query( $data ) );
			$resp = curl_exec($handle);
	
			$l_asResponse = json_decode( $resp, true );

			if ( $l_asResponse['error'] ) {
				echo "Error: ";
				echo $l_asResponse['error_description'];
			} else {
	
				// Get Account
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
				curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'Authorization: Bearer ' . $l_asResponse['access_token'],
				));
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
				curl_setopt($ch, CURLOPT_URL, 'https://api.aweber.com/1.0/accounts' );
				$result = curl_exec($ch);
				curl_close($ch);
				
				$l_asResult = json_decode( $result, true );	

				// Set Account Info
				$data = array(
					'email_url' => $l_asResult[entries][0][id],
					'email_key' => $l_asResponse['access_token'],
					'email_app' => $l_asResponse['refresh_token'],
					'email_company' => 8,
				);
	
				if ( $_GET['state'] == 'vipmembervault' ) {
					echo "SUCCESS: ";
					print_r( $data );
				} else {
					$handle = curl_init('https://' . $_GET['state'] . '.vipmembervault.com/adminapi/set_email_token/?apikey=testapikey');
					curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($handle, CURLOPT_POST, true);
					curl_setopt($handle, CURLOPT_POSTFIELDS, http_build_query( $data ) );
					$resp = curl_exec($handle);
			
					if ( $resp == 1 ) {
						header('Location: https://' . $_GET['state'] . '.vipmembervault.com/admin/settings/tagging/?status=saved');
					} else {
						echo $resp;
					}
				}
			}			

		}		
    }

}