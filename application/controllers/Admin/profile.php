<?php

$l_xCurrentUser = $this->admins_model->get_by_username($this->session->userdata('username'));
$data['g_aaSettings'] = $this->settings_model->get_all_by_name();

if(!$p_sPage){
	$data['l_sTitle'] = 'Profile';
	$data['l_xUser'] = $l_xCurrentUser;
	
	$this->load->view('admin/header', $data);
	$this->load->view('admin/profile', $data);
	$this->load->view('admin/footer', $data);
}
if($p_sPage == "edit"){
	if( $_POST ) {
		$l_xCurrentUser['email'] = $_POST['email'];
		if( trim( $l_xCurrentUser['email'] ) == '' ) {
			redirect( '/admin/profile/?status=email', 'refresh' );					
		}
		
		if($_POST['password']){
			$l_xCurrentUser['password'] = md5( $_POST['password'] );
		}
		$this->admins_model->save($l_xCurrentUser);
		redirect( '/admin/profile/?status=saved', 'refresh' );
	} else {
		redirect( '/admin/profile/', 'refresh' );
	}
	
}

?>