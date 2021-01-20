<?php
	include $_SERVER['DOCUMENT_ROOT'] . '/fe/aws/aws-autoloader.php';
	use Aws\S3;
	use Aws\S3\S3Client;
	
	function displayDate( $p_sDate, $p_bTimestamp = false ) {
		if ( $p_sDate ) {
			if ( $p_bTimestamp ) {
				return date( 'm/d/Y', $p_sDate );
			} else {
				return date( 'm/d/Y', strtotime( $p_sDate ) );
			}
		} else {
			return '';
		}
	}

	function displayDateSortable( $p_sDate, $p_bTimestamp = false ) {
		if ( $p_sDate ) {
			if ( $p_bTimestamp ) {
				return date( 'Ymd', $p_sDate );
			} else {
				return date( 'Ymd', strtotime( $p_sDate ) );
			}
		} else {
			return '';
		}
	}

	function sqlDate( $p_sDate ) {
		if ( $p_sDate ) {
			return date( 'Y-m-d', strtotime( $p_sDate ) );
		} else {
			return null;
		}
	}



	function slugify( $text ) {
	  // replace non letter or digits by -
	  $text = preg_replace('~[^\pL\d]+~u', '', $text);
	
	  // transliterate
	  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
	
	  // remove unwanted characters
	  $text = preg_replace('~[^-\w]+~', '', $text);
	
	  // trim
	  $text = trim($text, '-');
	
	  // remove duplicate -
	  $text = preg_replace('~-+~', '-', $text);
	
	  // lowercase
	  $text = strtolower($text);
	
	  if (empty($text)) {
		return 'n-a';
	  }
	
	  return $text;
	}

	function get_account_type_by_id( $l_sType ) {
		if ( $l_sType == 0 ) {
			$l_sReturn = 'Free';
		} else if ( $l_sType == 2 ) {
			$l_sReturn = 'Base: Monthly';			
		} else if ( $l_sType == 3 ) {
			$l_sReturn = 'Pro: Monthly';			
		} else if ( $l_sType == 1 ) {
			$l_sReturn = 'Pro+: Monthly';			
		} else if ( $l_sType == 8 ) {
			$l_sReturn = 'Lifetime: Lifetime';
		} else if ( $l_sType == 9 ) {
			$l_sReturn  = 'Promo: Promo';
		} else {
		}

		return $l_sReturn;

	}

	function sortByEpCount( $a, $b ){
		if ( $a['ep_count'] == $b['ep_count'] ) {
			return 0;
		}
		return ( $a['ep_count'] > $b['ep_count'] ) ? -1 : 1;
	}

	function mv_encrypt( $p_sString ) {
		$encrypt_method = "AES-256-CBC";
		$secret_key = 'testkey';
		$secret_iv = 'testsecret';
		$key = hash('sha256', $secret_key);
		$iv = substr(hash('sha256', $secret_iv), 0, 16);
		$output = openssl_encrypt($p_sString, $encrypt_method, $key, 0, $iv);
		$output = base64_encode($output);
		return $output;
	}
	
	function mv_decrypt( $p_sString ) {
		$encrypt_method = "AES-256-CBC";
		$secret_key = 'testkey';
		$secret_iv = 'testsecret';
		$key = hash('sha256', $secret_key);
		$iv = substr(hash('sha256', $secret_iv), 0, 16);
		$output = openssl_decrypt(base64_decode($p_sString), $encrypt_method, $key, 0, $iv);
		return $output;
	}

?>