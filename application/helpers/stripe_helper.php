<?php
    function stripe_cancel_subscription( $p_sAccount, $p_sId ) {
        $data = array();

        $handle = curl_init('https://api.stripe.com/v1/subscriptions/' . $p_sId );
        curl_setopt( $handle, CURLOPT_CUSTOMREQUEST, 'DELETE' );
        curl_setopt( $handle, CURLOPT_HTTPHEADER, array( 'Stripe-Account: ' . $p_sAccount, 'Content-type: application/x-www-form-urlencoded' ) );
        curl_setopt( $handle, CURLOPT_POST, true );
        curl_setopt( $handle, CURLOPT_POSTFIELDS, http_build_query( $data ) );
        curl_setopt( $handle, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
        curl_setopt( $handle, CURLOPT_USERPWD, STRIPE_SECRET );
        curl_setopt( $handle, CURLOPT_RETURNTRANSFER, true );
        $resp = curl_exec( $handle );

        $l_xCustomer = json_decode( $resp );
        return $l_xCustomer;
    }

    function stripe_get_subscription( $p_sAccount, $p_sId ) {

        $handle = curl_init('https://api.stripe.com/v1/subscriptions/' . $p_sId );
        curl_setopt( $handle, CURLOPT_HTTPHEADER, array( 'Stripe-Account: ' . $p_sAccount, 'Content-type: application/x-www-form-urlencoded' ) );
        curl_setopt( $handle, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
        curl_setopt( $handle, CURLOPT_USERPWD, STRIPE_SECRET );
        curl_setopt( $handle, CURLOPT_RETURNTRANSFER, true );
        $resp = curl_exec( $handle );

        $l_xCustomer = json_decode( $resp );
        return $l_xCustomer;
    }

    function stripe_get_invoices_for_subscription( $p_sAccount, $p_sSubscription ) {

        $handle = curl_init('https://api.stripe.com/v1/invoices?limit=100&subscription=' . $p_sSubscription );
        curl_setopt( $handle, CURLOPT_HTTPHEADER, array( 'Stripe-Account: ' . $p_sAccount, 'Content-type: application/x-www-form-urlencoded' ) );
        curl_setopt( $handle, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
        curl_setopt( $handle, CURLOPT_USERPWD, STRIPE_SECRET );
        curl_setopt( $handle, CURLOPT_RETURNTRANSFER, true );
        $resp = curl_exec( $handle );

        $l_axInvoices = json_decode( $resp );
        return $l_axInvoices;
    }
?>