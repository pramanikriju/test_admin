<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class admin extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('session');			
		$this->load->library('form_validation');

		$this->load->helper('url_helper');
		$this->load->helper('form');

		$this->load->model('admins_model');
		$this->load->model('users_model');
		$this->load->model('system_logs_model');
		$this->load->model('user_logs_model');
		$this->load->model('user_actions_model');
		$this->load->model('settings_model');
		$this->load->model('system_model');
		$this->load->model('api_jobs_model');
		$this->load->model('budget_model');
		$this->load->model('consent_model');

		$g_sApiKey = $this->system_model->get_api_key();
		if ( empty( $g_sApiKey['value'] ) ) {
			$this->system_model->generate_api_key();
		}

		$l_xCurrentUser = $this->admins_model->get_by_username( $_COOKIE['username'] );
		if ( ! $l_xCurrentUser ) {
			redirect('/login/?error=logged-out', 'refresh');				
		}
		if ( mv_decrypt( $_COOKIE['admin_password'] ) != $l_xCurrentUser['password']  ) {
			redirect('/login/?error=logged-out', 'refresh');				
		}
	}
		
	public function profile($p_sPage = null, $p_sArgument = null){
		include 'Admin/profile.php';
	}

	public function settings($p_sPage = null, $p_sArgument = null){
		include 'Admin/settings.php';
	}
	
	public function api_jobs($p_sPage = null, $p_sArgument = null){
		include 'Admin/api_jobs.php';
	}

	public function activity($p_sPage = null, $p_sArgument = null){
		include 'Admin/activity.php';
	}

	public function ep($p_sPage = null, $p_sArgument = null){
		include 'Admin/ep.php';
	}

	public function reports($p_sPage = null, $p_sArgument = null){
		include 'Admin/reports.php';
	}

	public function errors($p_sPage = null, $p_sArgument = null){
		include 'Admin/errors.php';
	}

	public function users($p_sPage = null, $p_sArgument = null){
		include 'Admin/users.php';
	}

	public function search($p_sPage = null, $p_sArgument = null){
		include 'Admin/search.php';
	}

	public function consent($p_sPage = null, $p_sArgument = null){
		include 'Admin/consent.php';
	}

}
