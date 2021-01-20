<?php
if ( ! $p_sPage ) {

    $data['l_sTitle'] = 'Errors';
    $data['g_aaSettings'] = $this->settings_model->get_all_by_name();

    if ( $_GET['date_start'] ) {
        $l_sStartDate = sqlDate( $_GET['date_start'] );
        $l_nStartTime = strtotime( $_GET['date_start'] );		
    } else {
        $l_sStartDate = date( 'Y-m-d', strtotime( '-1 day' ) );
        $l_nStartTime = strtotime( $l_sStartDate );
    }
    if ( $_GET['date_end'] ) {
        $l_sEndDate = sqlDate( $_GET['date_end'] );
        $l_nEndTime = strtotime( '+1 day', strtotime( $_GET['date_end'] ) );
    } else {
        $l_sEndDate = date( 'Y-m-d' );
        $l_nEndTime = time();
    }    

    $data['l_asErrors'] = $this->system_model->get_errors( $l_nStartTime, $l_nEndTime, $_GET['type'] );
    $data['l_asErrorCount'] = $this->system_model->get_error_totals( $l_nStartTime, $l_nEndTime );
    $data['l_asErrorTypes'] = $this->system_model->get_error_types();



    $data['l_sStartDate'] = $l_sStartDate;
    $data['l_sEndDate'] = $l_sEndDate;

    $this->load->view('admin/header', $data);
    $this->load->view('admin/errors', $data);
    $this->load->view('admin/footer', $data);
}



?>