<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class logout extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('session');			
		$this->load->helper('url_helper');
		$this->load->model('admins_model');
		$this->load->model('system_model');
	}

	public function index() {
		setcookie( 'username', '', time() - 3600, '/' );
		$_COOKIE['username'] = null;

		setcookie( 'admin_password', '', time() - 3600, '/' );
		$_COOKIE['admin_password'] = null;

		redirect('/login/?error=logged-out', 'refresh');
	}
}
