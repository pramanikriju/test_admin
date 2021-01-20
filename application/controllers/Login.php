<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class login extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->library('email');
		$this->load->helper('url_helper');
		$this->load->model('admins_model');
		$this->load->model('settings_model');
		$this->load->model('system_model');
	}

	public function index(){
		$data['g_aaSettings'] = $this->settings_model->get_all_by_name();

		if ( $_POST ) {
			$l_xAdminLogin = $this->admins_model->get_login( $this->input->post('username'), $this->input->post('password') );
			
			if ( $l_xAdminLogin ) {
				setcookie( 'username', '', time() - 3600, '/' );
				setcookie( 'username', $l_xAdminLogin['username'], time() + ( 3600 * 24 * 30 ), '/' );
				$_COOKIE['username'] = $l_xAdminLogin['username'];

				setcookie( 'admin_password', '', time() - 3600, '/' );
				setcookie( 'admin_password', mv_encrypt( $l_xAdminLogin['password'] ), time() + ( 3600 * 24 * 30 ), '/' );
				$_COOKIE['admin_password'] = mv_encrypt( $l_xAdminLogin['password'] );
				
				redirect( '/admin/', 'refresh' );
			} else {
				redirect( '/login/?error=password', 'refresh' );				
			}
		} else {
			$this->load->view( 'login/login', $data );
		}
	}


}
