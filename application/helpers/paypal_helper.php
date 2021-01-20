<?php
    function paypal_get_subscription( $p_sPaypalUser, $p_sPaypalPassword, $p_sPaypalSignature, $p_sId ) {        
        $data = array(
            'USER' => $p_sPaypalUser,
            'PWD' => $p_sPaypalPassword,
            'SIGNATURE' => $p_sPaypalSignature,
            'METHOD' => 'GetRecurringPaymentsProfileDetails',
            'VERSION' => 93,
            'PROFILEID' => $p_sId
         );
        
        $handle = curl_init('https://api-3t.' . PAYPAL_ENV . 'paypal.com/nvp');
        curl_setopt( $handle, CURLOPT_POST, true );
        curl_setopt( $handle, CURLOPT_POSTFIELDS, http_build_query( $data ) );
        curl_setopt( $handle, CURLOPT_RETURNTRANSFER, true );
        $resp = curl_exec( $handle );
        
        $l_asResponse = array();
        parse_str( $resp, $l_asResponse );

        return $l_asResponse;
    }
?>
