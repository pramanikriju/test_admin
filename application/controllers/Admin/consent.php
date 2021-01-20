<?php
if ( ! $p_sPage ) {
    $data['l_sTitle'] = 'GDPR Consent Log';
    $data['g_aaSettings'] = $this->settings_model->get_all_by_name();
    $data['l_axLogs'] = $this->consent_model->get_all();

    $this->load->view('admin/header', $data);
    $this->load->view('admin/consent', $data);
    $this->load->view('admin/footer', $data);
}

if ( $p_sPage == "csv" ) {

    $l_axLogs = $this->consent_model->get_all();

	$l_sFileName = "mv-consent-" . date("Y-m-d") . ".csv";

	header("Content-type: text/csv");
	header("Content-Disposition: attachment; filename=" . $l_sFileName);
	header("Pragma: no-cache");
	header("Expires: 0");

	echo '"Date","Email","Name","Consent","How"' . "\n";

	foreach( $l_axLogs as $l_xLog ){
		echo '"' . date( 'm/d/Y - g:ia', $l_xLog['timestamp'] ). '",';
		echo '"' . $l_xLog['email'] . '",';
        echo '"' . $l_xLog['name'] . '",';
        if ( $l_xLog['consent'] == 1 ) {
            echo '"Yes",';
        } else {
            echo '"No",';
        }
		echo '"' . $l_xLog['how'] . '"';
		echo "\n";
	}

}

?>