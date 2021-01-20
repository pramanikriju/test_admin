<?php

$l_axSettings = $this->settings_model->get_all();
$data['g_aaSettings'] = $this->settings_model->get_all_by_name();

if(!$p_sPage){
	$data['l_sTitle'] = 'Settings';
	$data['l_axSettings'] = $l_axSettings;
	$data['l_xApiKey'] = $this->system_model->get_api_key();

	$this->load->view('admin/header', $data);
	$this->load->view('admin/settings', $data);
	$this->load->view('admin/footer', $data);
}
if($p_sPage == "edit"){
	if( $_POST ) {
		foreach( $_POST as $l_sKey => $l_sValue ) {
			if( $l_sKey == 'image_delete' ) { continue; }
			$l_xSetting = $this->settings_model->get_by_name( $l_sKey );
			$l_xSetting['value'] = $l_sValue;
			$this->settings_model->save($l_xSetting);
		}

		if($_POST['image_delete'] == "on"){
			$config['upload_path'] = './uploads/';
			$config['file_name'] = 'course_'.$_POST['id'].".jpg";

			$l_xLogo = $this->settings_model->get_by_name( 'logo' );
			if( $l_xLogo['value'] ){
				if( !unlink( $config['upload_path'] . $l_xLogo['value'] ) ) {
					echo "Error Deleting Old Logo";
					exit;
				}
				$l_xLogo['value'] = '';
				$this->settings_model->save($l_xLogo);
			}

			unset($_POST['image_delete']);
		}
		
		if( $_FILES['userfile']['size'] > 0 ) {
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png';

			$l_xLogo = $this->settings_model->get_by_name( 'logo' );
			if( $l_xLogo['value'] ){
				if( !unlink( $config['upload_path'] . $l_xLogo['value'] ) ) {
					echo "Error Deleting Old Logo";
					exit;
				}
			}

			$this->load->library('upload',$config);
			$this->upload->do_upload('userfile');

			$l_xLogo['value'] = $this->upload->data('file_name');
			$this->settings_model->save($l_xLogo);
		}
		redirect( '/admin/settings/?status=saved', 'refresh' );
	} else {
		redirect( '/admin/settings/', 'refresh' );
	}
	
}

?>