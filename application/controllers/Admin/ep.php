<?php
$data['l_sTitle'] = 'EP Activity';
$data['g_aaSettings'] = $this->settings_model->get_all_by_name();

if ( $_GET['date_start'] ) {
    $l_sStartDate = sqlDate( $_GET['date_start'] );
    $l_nStartTime = strtotime( $_GET['date_start'] );		
} else {
    $l_sStartDate = date( 'Y-m-d' );
    $l_nStartTime = strtotime( $l_sStartDate );
}
if ( $_GET['date_end'] ) {
    $l_sEndDate = sqlDate( $_GET['date_end'] );
    $l_nEndTime = strtotime( '+1 day', strtotime( $_GET['date_end'] ) );
} else {
    $l_sEndDate = date( 'Y-m-d' );
    $l_nEndTime = time();
}    

$l_axUsers = $this->users_model->get_user_active( $l_nStartTime );
foreach( $l_axUsers as $l_nKey => $l_xUser ) {
    $l_axDatabase = $this->system_model->get_client_database( $l_xUser );
    $l_nEP = $this->system_model->get_account_ep_count( $l_axDatabase['db'], $l_axDatabase['client_id'], $l_sStartDate, $l_sEndDate );

    if ( $l_nEP == 0 ) {
        unset( $l_axUsers[$l_nKey] );
    } else {
        $l_axUsers[$l_nKey]['ep_count'] = $l_nEP;
    }
}



$data['l_sStartDate'] = $l_sStartDate;
$data['l_sEndDate'] = $l_sEndDate;

usort( $l_axUsers, "sortByEpCount" );
$data['l_axUsers'] = $l_axUsers;


$this->load->view('admin/header', $data);
$this->load->view('admin/ep', $data);
$this->load->view('admin/footer', $data);

?>