<?php

$data['l_sTitle'] = 'API Jobs';
$data['g_aaSettings'] = $this->settings_model->get_all_by_name();

$data['l_axJobs'] = $this->api_jobs_model->get_pending();
$data['l_nPending'] = $this->api_jobs_model->get_pending_count();

if ( $_GET['search'] ) {
    $data['l_axOldJobs'] = $this->api_jobs_model->search_old( $_GET['search'] );
    $data['l_nOldJobsCount'] = $this->api_jobs_model->search_old_count( $_GET['search'] );
}

$this->load->view('admin/header', $data);
$this->load->view('admin/api_jobs', $data);
$this->load->view('admin/footer', $data);

?>