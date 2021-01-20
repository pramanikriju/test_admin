<?php
if ( ! $p_sPage ) {

    $data['l_sTitle'] = 'Reports';
    $data['g_aaSettings'] = $this->settings_model->get_all_by_name();

    $l_xCachedDaily = $this->system_model->get_from_cache( 'daily_active_accounts' );
    $data['l_axDailyActive'] = json_decode( $l_xCachedDaily['data'], true );

    $l_axUsers = $this->users_model->get_all('created', 'ASC');
    $l_nCount = 1;
    $l_nFreeCount = 1;
    $l_nBaseCount = 1;
    $l_nProCount = 1;
    $l_nProPlusCount = 1;
    $l_nBaseAnnualCount = 1;
    $l_nProAnnualCount = 1;
    $l_nProPlusAnnualCount = 1;
    $l_axDays = array();

    $l_axAll = array();
    $l_axFree = array();
    $l_axBase = array();
    $l_axPro = array();
    $l_axProPlus = array();

    $l_anEmail = array();

    foreach( $l_axUsers as $l_xUser ) {
        $l_sMonth = date( 'My', strtotime( $l_xUser['created'] ) );

        if ( ! $l_axFree[$l_sMonth] ) {
            $l_axFree[$l_sMonth] = 0;
        }
        if ( ! $l_axBase[$l_sMonth] ) {
            $l_axBase[$l_sMonth] = 0;
        }
        if ( ! $l_axPro[$l_sMonth] ) {
            $l_axPro[$l_sMonth] = 0;
        }


        $l_axDays[$l_sMonth] = $l_nCount;
        $l_nCount++;

        if ( $l_xUser['type'] == 'Free' ) {
            $l_axFree[$l_sMonth]++;
            $l_axAll[$l_sMonth]++;
            $l_nFreeCount++;
        }
        if ( $l_xUser['type'] == 'Base: Annual' || $l_xUser['type'] == 'Base: Monthly' ) {
            $l_axBase[$l_sMonth]++;
            $l_axAll[$l_sMonth]++;
            $l_nBaseCount++;
            if ( $l_xUser['type'] == 'Base: Annual' ) {
                $l_nBaseAnnualCount++;
            }
        }
        if ( $l_xUser['type'] == 'Pro: Annual' || $l_xUser['type'] == 'Pro: Monthly' ) {
            $l_axPro[$l_sMonth]++;
            $l_axAll[$l_sMonth]++;
            $l_nProCount++;
            if ( $l_xUser['type'] == 'Pro: Annual' ) {
                $l_nProAnnualCount++;
            }
        }

        if ( $l_xUser['type'] == 'Pro+: Annual' || $l_xUser['type'] == 'Pro+: Monthly' ) {
            $l_axProPlus[$l_sMonth]++;
            $l_axAll[$l_sMonth]++;
            $l_nProPlusCount++;
            if ( $l_xUser['type'] == 'Pro+: Annual' ) {
                $l_nProPlusAnnualCount++;
            }
        }

        if ( $l_xUser['email_company'] > 0 ) {
            $l_anEmail[$l_xUser['email_company']]++;
        }

    }

    $data['l_axDays'] = $l_axDays;
    $data['l_axAll'] = $l_axAll;
    $data['l_axFree'] = $l_axFree;
    $data['l_axBase'] = $l_axBase;
    $data['l_axPro'] = $l_axPro;
    $data['l_axProPlus'] = $l_axProPlus;

    $data['l_nFreeCount'] = $l_nFreeCount;
    $data['l_nBaseCount'] = $l_nBaseCount;
    $data['l_nProCount'] = $l_nProCount;
    $data['l_nProPlusCount'] = $l_nProPlusCount;
    $data['l_nBaseAnnualCount'] = $l_nBaseAnnualCount;
    $data['l_nProAnnualCount'] = $l_nProAnnualCount;
    $data['l_nProPlusAnnualCount'] = $l_nProAnnualCount;

    $data['l_anEmail'] = $l_anEmail;

    $this->load->view('admin/header', $data);
    $this->load->view('admin/reports', $data);
    $this->load->view('admin/footer', $data);
}



?>