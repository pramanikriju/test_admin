<?php
$data['l_sTitle'] = 'Account Activity';
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

$l_axEvents = $this->user_logs_model->get_count_by_type( $l_nStartTime, $l_nEndTime );
foreach( $l_axEvents as $l_nKey => $l_xEvent ) {
    $l_xUser = $this->users_model->get_by_subdomain( $l_xEvent['subdomain'] );

    $l_axEvents[$l_nKey]['account_id'] = $l_xUser['id'];
    $l_axEvents[$l_nKey]['type'] = $l_xUser['type'];
    $l_axEvents[$l_nKey]['users_count'] = $l_xUser['users'];
    $l_axEvents[$l_nKey]['products_count'] = $l_xUser['products'];
    $l_axEvents[$l_nKey]['created'] = $l_xUser['created'];
    $l_axEvents[$l_nKey]['bonus'] = $l_xUser['bonus'];

    if ( $_GET['type'] && $_GET['type'] != $l_xUser['type'] ) {
        unset( $l_axEvents[$l_nKey] );
    }
}

$l_axHotLeads = $this->user_logs_model->get_event_totals( $l_nStartTime, $l_nEndTime, 'account_plans_view' );
foreach( $l_axHotLeads as $l_nKey => $l_xEvent ) {
    $l_xUser = $this->users_model->get_by_subdomain( $l_xEvent['subdomain'] );

    $l_axHotLeads[$l_nKey]['account_id'] = $l_xUser['id'];
    $l_axHotLeads[$l_nKey]['type'] = $l_xUser['type'];
    $l_axHotLeads[$l_nKey]['users_count'] = $l_xUser['users'];
    $l_axHotLeads[$l_nKey]['products_count'] = $l_xUser['products'];
    $l_axHotLeads[$l_nKey]['created'] = $l_xUser['created'];
    $l_axHotLeads[$l_nKey]['bonus'] = $l_xUser['bonus'];

    if ( $l_xUser['type'] != 'Free' && $l_xUser['type'] != 'Promo: Promo' ) {
        unset( $l_axHotLeads[$l_nKey] );
    }
}



$data['l_axEvents'] = $l_axEvents;
$data['l_axHotLeads'] = $l_axHotLeads;

$data['l_sStartDate'] = $l_sStartDate;
$data['l_sEndDate'] = $l_sEndDate;
$data['l_asAccountTypes'] = $this->users_model->get_account_types();





$this->load->view('admin/header', $data);
$this->load->view('admin/activity', $data);
$this->load->view('admin/footer', $data);

?>