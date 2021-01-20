<?php
    function ac_get_url(){
        return 'https://membervault.api-us1.com';
    }
    function ac_get_key(){
        return 'd43265a3b821267e8dcc7ff2c544e8dd229f4cd4e31a76e204508e0e786c50e02af91b88';
    }
    
    function ac_add_update_contact( $p_sEmail, $p_sFirstName = null, $p_sLastName = null ) {
        $json = '{
            "contact": {
                "email": "' . trim( $p_sEmail ) . '",
                "firstName": "' . trim( $p_sFirstName ) . '",
                "lastName": "' . trim( $p_sLastName ) . '"
            }
        }';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Api-Token: ' . ac_get_key()
        ));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_URL, ac_get_url() . '/api/3/contact/sync' );
        $l_sReturn = curl_exec($ch);
        curl_close($ch);

        $l_xReturn = json_decode( $l_sReturn, true );       
        return $l_xReturn;
    }

    function ac_add_to_list( $p_nContact, $p_nList ) {
        $json = '{
            "contactList": {
                "contact": ' . $p_nContact . ',
                "list": ' . $p_nList . ',
                "status": 1
            }
        }';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Api-Token: ' . ac_get_key()
        ));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_URL, ac_get_url() . '/api/3/contactLists' );
        $l_sReturn = curl_exec($ch);
        curl_close($ch);

        $l_xReturn = json_decode( $l_sReturn, true );       
        return $l_xReturn;
    }

    function ac_get_custom_fields() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Api-Token: ' . ac_get_key()
        ));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_URL, ac_get_url() . '/api/3/fields' );
        $l_sReturn = curl_exec($ch);
        curl_close($ch);

        $l_xReturn = json_decode( $l_sReturn, true );       
        return $l_xReturn;
    }

    function ac_set_custom_field( $p_nContact, $p_nField, $p_sValue ) {
        $json = '{
            "fieldValue": {
                "contact": ' . $p_nContact . ',
                "field": ' . $p_nField . ',
                "value": "' . trim( $p_sValue ) . '"
            }
        }';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Api-Token: ' . ac_get_key()
        ));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_URL, ac_get_url() . '/api/3/fieldValues' );
        $l_sReturn = curl_exec($ch);
        curl_close($ch);

        $l_xReturn = json_decode( $l_sReturn, true );       
        return $l_xReturn;
    }

    function ac_add_tag( $p_nContact, $p_sTag ) {

        // Look up the tag
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Api-Token: ' . ac_get_key()
        ));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_URL, ac_get_url() . '/api/3/tags?search=' . urlencode( $p_sTag ) );
        $l_sReturn = curl_exec($ch);
        curl_close($ch);

        $l_xTagLookup = json_decode( $l_sReturn, true );

        if ( $l_xTagLookup[tags][0][id] ) {
            $l_nTagId = $l_xTagLookup[tags][0][id];
        } else {
            // Create tag if not found
            $json = '{
                "tag": {
                    "tag": "' . trim( $p_sTag ) . '",
                    "tagType": "contact",
                    "description": "' . trim( $p_sTag ) . '"
                }
            }';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Api-Token: ' . ac_get_key()
            ));
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            curl_setopt($ch, CURLOPT_URL, ac_get_url() . '/api/3/tags' );
            $l_sReturn = curl_exec($ch);
            curl_close($ch);
    
            $l_xAddedTag = json_decode( $l_sReturn, true );
            print_r( $l_xAddedTag );
            exit;
        }

        // Assign the tag to the contact
        $json = '{
            "contactTag": {
                "contact": "' . $p_nContact . '",
                "tag": "' . $l_nTagId . '"
            }
        }';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Api-Token: ' . ac_get_key()
        ));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_URL, ac_get_url() . '/api/3/contactTags' );
        $l_sReturn = curl_exec($ch);
        curl_close($ch);

        $l_xReturn = json_decode( $l_sReturn, true );

        return $l_xReturn;
    }

?>