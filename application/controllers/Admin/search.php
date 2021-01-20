<?php
$data['l_sTitle'] = 'Search';
$data['g_aaSettings'] = $this->settings_model->get_all_by_name();

if ( $_GET['email'] ) {
    $l_axUsers = $this->users_model->search_emails( $_GET['email'] );
    $data['l_axUsers'] =  $l_axUsers;
}


$this->load->view('admin/header', $data);
$this->load->view('admin/search', $data);
$this->load->view('admin/footer', $data);

?>