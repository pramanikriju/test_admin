<!-- page head start-->
<div class="page-head">
    <h2><?php echo $l_sTitle ?></h2>
</div>
<!-- page head end-->

<!--body wrapper start-->
<div class="wrapper">

	<div class="col-md-6">
		<form method="post" action="/admin/users/edit/<?php echo $l_xUser['id'] ?>">
			<input type="hidden" name="id" value="<?php echo $l_xUser['id'] ?>">
			<input type="hidden" name="status" value="1">
			<input type="hidden" name="subdomain" value="<?php echo $l_xUser['subdomain'] ?>">
			
			<section class="panel">
				<header class="panel-heading">
					User Information - <a href="https://<?php echo $l_xUser['subdomain'] ?>.vipmembervault.com/adminapi/admin_login/?apikey=testapikey" target="_BLANK">Login</a>
				</header>
				<div class="panel-body">

					<div class="form-group">
						<table class="table table-striped" >
							<tbody>
								<tr>
									<td><b>Step:</b></td>
									<td><?php echo number_format( $l_xUser['step'] ) ?></td>
									<td><b>EP:</b></td>
									<td><?php echo number_format( $l_xUser['ep'] ) ?></td>
									<td><b>Email Tool:</b></td>
									<td>
										<?php
											if ( $l_xUser['email_company'] == 1 ) {
													echo "ActiveCampaign";
											} else if ( $l_xUser['email_company'] == 2 ) {
													echo "Drip";
											} else if ( $l_xUser['email_company'] == 3 ) {
													echo "ConvertKit";
											} else if ( $l_xUser['email_company'] == 4 ) {
												echo "Ontraport";
											} else if ( $l_xUser['email_company'] == 5 ) {
												echo "MailerLite";
											} else if ( $l_xUser['email_company'] == 6 ) {
												echo "Mailchimp";
											} else if ( $l_xUser['email_company'] == 7 ) {
												echo "Infusionsoft";
											} else if ( $l_xUser['email_company'] == 8 ) {
												echo "AWeber";
											}
											
										?>
									</td>
								</tr>
								<tr>
									<td><b>Products:</b></td>
									<td><?php echo number_format( $l_xUser['products'] ) ?></td>
									<td><b>Users:</b></td>
									<td><?php echo number_format( $l_xUser['users'] ) ?></td>
									<td><b>Email Subscribers:</b></td>
									<td><?php echo number_format( $l_xUser['email_subs'] ) ?></td>
								</tr>
								<tr>
									<td><b>User Boost:</b></td>
									<td><?php echo number_format( $l_xUser['bonus'] ) ?></td>
									<td><b>Affiliate:</b></td>
									<td><?php echo $l_xUser['affiliate'] ?></td>
									<td><b>Last Active:</b></td>
									<td><?php echo displayDate( $l_xUser['admin_activity'], true ) ?></td>
								</tr>
							</tbody>
						</table>

					</div>

					<div class="form-group">
						<label>Subdomain</label>
						<input disabled="disabled" type="text" name="subdomain" placeholder="Subdomain" class="form-control" value="<?php echo htmlentities( $l_xUser['subdomain'] ) ?>">
					</div>

					<?php
						if ( $l_xUser['url'] ) {
					?>
							<div class="form-group">
								<label>Custom Domain</label>
								<input disabled="disabled" type="text" name="url" placeholder="url" class="form-control" value="<?php echo htmlentities( $l_xUser['url'] ) ?>">
							</div>
					<?php
						}
					?>


					<div class="form-group">
						<label>Type</label>
						<select name="type" class="form-control">
							<option value="Free">Free</option>
							<option value="">-------------</option>
							<option value="Starter: Monthly" <?php if ( $l_xUser['type'] == 'Starter: Monthly' ) { echo "selected=\"selected\"";} ?>>Starter: Monthly</option>
							<option value="Starter: Annual" <?php if ( $l_xUser['type'] == 'Starter: Annual' ) { echo "selected=\"selected\"";} ?>>Starter: Annual</option>
							<option value="">-------------</option>
							<option value="Base: Monthly" <?php if ( $l_xUser['type'] == 'Base: Monthly' ) { echo "selected=\"selected\"";} ?>>Base: Monthly</option>
							<option value="Base: Annual" <?php if ( $l_xUser['type'] == 'Base: Annual' ) { echo "selected=\"selected\"";} ?>>Base: Annual</option>
							<option value="">-------------</option>
							<option value="Pro: Monthly" <?php if ( $l_xUser['type'] == 'Pro: Monthly' ) { echo "selected=\"selected\"";} ?>>Pro: Monthly</option>
							<option value="Pro: Annual" <?php if ( $l_xUser['type'] == 'Pro: Annual' ) { echo "selected=\"selected\"";} ?>>Pro: Annual</option>
							<option value="">-------------</option>
							<option value="Pro+: Monthly" <?php if ( $l_xUser['type'] == 'Pro+: Monthly' ) { echo "selected=\"selected\"";} ?>>Pro+: Monthly</option>
							<option value="Pro+: Annual" <?php if ( $l_xUser['type'] == 'Pro+: Annual' ) { echo "selected=\"selected\"";} ?>>Pro+: Annual</option>
							<option value="">-------------</option>
							<option value="Lifetime: Starter" <?php if ( $l_xUser['type'] == 'Lifetime: Starter' ) { echo "selected=\"selected\"";} ?>>Lifetime: Starter</option>
							<option value="Lifetime: Lite" <?php if ( $l_xUser['type'] == 'Lifetime: Lite' ) { echo "selected=\"selected\"";} ?>>Lifetime: Lite</option>
							<option value="Lifetime: Pro" <?php if ( $l_xUser['type'] == 'Lifetime: Pro' ) { echo "selected=\"selected\"";} ?>>Lifetime: Pro</option>

							<option value="">-------------</option>
							<option value="Promo: Promo" <?php if ( $l_xUser['type'] == 'Promo: Promo' ) { echo "selected=\"selected\"";} ?>>Promo: Promo</option>
							<option value="Lifetime: Founding 100" <?php if ( $l_xUser['type'] == 'Lifetime: Founding 100' ) { echo "selected=\"selected\"";} ?>>Lifetime: Founding 100</option>
						</select>					
					</div>

					<div class="form-group">
						<label>Email</label>
						<input type="text" name="email" placeholder="Email" class="form-control" value="<?php echo htmlentities($l_xUser['email']) ?>">
					</div>
					<div class="form-group">
						<label>First Name</label>
						<input type="text" name="first_name" placeholder="First Name" class="form-control" value="<?php echo htmlentities($l_xUser['first_name']) ?>">
					</div>
					<div class="form-group">
						<label>Last Name</label>
						<input type="text" name="last_name" placeholder="Last Name" class="form-control" value="<?php echo htmlentities($l_xUser['last_name']) ?>">
					</div>

					<div class="form-group">
						<label>Date Signed Up</label>
						<input type="text" name="created" class="form-control js_datepicker" value="<?php echo displayDate( $l_xUser['created'] ); ?>">
					</div>

					<div class="form-group">
						<label>Upgraded</label>
						<input type="text" name="upgraded" class="form-control js_datepicker" value="<?php echo displayDate( $l_xUser['upgraded'] ); ?>">
					</div>

					<div class="form-group">
						<label>Cancelled</label>
						<input type="text" name="cancelled" class="form-control js_datepicker" value="<?php echo displayDate( $l_xUser['cancelled'] ); ?>">
					</div>

					<div class="form-group">
						<label>User Boost</label>
						<input type="text" name="bonus" placeholder="" class="form-control" value="<?php echo htmlentities($l_xUser['bonus']) ?>">
					</div>

					<div class="form-group">
						<label>Listed On Leaderboard</label>
						<select name="on_leaderboard" class="form-control">
							<option value="1">Yes</option>
							<option value="0" <?php if ( $l_xUser['on_leaderboard'] == 0 ) { echo "selected=\"selected\"";} ?>>No</option>
						</select>					
					</div>

					<button type="submit" class="btn btn-success">Save User</button>
				</div>
			</section>
					
		</form>
	</div>
	<div class="col-md-6">

		<section class="panel">
			<header class="panel-heading">
					Errors (<?php echo number_format( count( $l_axErrors ) ) ?>)
					<span class="tools pull-right">
						<a class="t-collapse fa fa-chevron-up" href="javascript:;"></a>
					</span>				
			</header>
			<div class="panel-body" style="display:none">
			<p><i>* only showing newest 1,000</i></p>

			<table class="table table-striped">
					<thead>
						<tr>
							<th>Time</th>
							<th>Error</th>
							<th>Data</th>
						</tr>
					</thead>
					<tbody>
						<?php
							foreach( $l_axErrors as $l_xError ) {
						?>
								<tr>
									<td><?php echo date( 'm/d/Y - h:i A', $l_xError['time'] ) ?></td>
									<td><?php echo $l_xError['event'] ?></td>
									<td><?php echo $l_xError['data'] ?></td>
								</tr>
						<?php
							}
						?>
					</tbody>
				</table>

			</div>
		</section>

		<section class="panel">
			<header class="panel-heading">
					Account Actions (<?php echo number_format( $l_nActivityTotal ) ?>)
					<span class="tools pull-right">
						<a class="t-collapse fa fa-chevron-up" href="javascript:;"></a>
					</span>				
			</header>
			<div class="panel-body" style="display:none">

				<h4>All Actions By Event</h4>
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Event</th>
							<th>Total</th>
							<th>Dates</th>
						</tr>
					</thead>
					<tbody>
						<?php
							foreach( $l_axActivityTotals as $l_xActivityTotal ) {
						?>
								<tr>
									<td><?php echo $l_xActivityTotal['event'] ?></td>
									<td><?php echo $l_xActivityTotal['the_count'] ?></td>
									<td>
										<a href="javascript:void(0)" onclick="viewDates('<?php echo $l_xActivityTotal['event'] ?>')">(view)</a>
										<div id="event_<?php echo $l_xActivityTotal['event'] ?>" style="display:none;"></div>
									</td>
								</tr>
						<?php
							}
						?>
					</tbody>
				</table>

				<h4>Latest 500 Actions</h4>
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Date</th>
							<th>Event</th>
							<th>Data</th>
						</tr>
					</thead>
					<tbody>
						<?php
							foreach( $l_axActivityLatest as $l_xActivityLatest ) {
						?>
								<tr>
									<td><?php echo date( 'm/d/Y - h:i A', $l_xActivityLatest['time'] ) ?></td>
									<td><?php echo $l_xActivityLatest['event'] ?></td>
									<td><?php echo $l_xActivityLatest['data'] ?></td>
								</tr>
						<?php
							}
						?>
					</tbody>
				</table>


			</div>
		</section>

		<?php
			if ( $l_xUser['url'] ) {
		?>
				<section class="panel">
					<header class="panel-heading">
						Reset Custom Domain
						<span class="tools pull-right">
							<a class="t-collapse fa fa-chevron-up" href="javascript:;"></a>
						</span>

					</header>
					<div class="panel-body" style="display:none">
						<div class="form-group">
							<label>Type Custom Domain to confirm</label>
							<input type="text" id="reset_custom" name="reset_custom" placeholder="" class="form-control" value="">
						</div>

						<a href="javascript:reset_custom()" class="btn btn-danger">Reset Custom Domain</a>
					</div>
				</section>
		<?php
			} else {
		?>
				<section class="panel">
					<header class="panel-heading">
						Move Account To New Subdomain
						<span class="tools pull-right">
							<a class="t-collapse fa fa-chevron-up" href="javascript:;"></a>
						</span>

					</header>
					<div class="panel-body" style="display:none">
						<div class="form-group">
							<label>New Subdomain</label>
							<input type="text" id="new_subdomain" name="new_subdomain" placeholder="" class="form-control" value="">
						</div>

						<a href="javascript:validate()" class="btn btn-success">Move Account</a>
					</div>
				</section>

				<section class="panel">
					<header class="panel-heading">
						Delete Account
						<span class="tools pull-right">
							<a class="t-collapse fa fa-chevron-up" href="javascript:;"></a>
						</span>

					</header>
					<div class="panel-body" style="display:none">
						<div class="form-group">
							<label>Type subdomain to confirm</label>
							<input type="text" id="delete_subdomain" name="delete_subdomain" placeholder="" class="form-control" value="">
						</div>

						<a href="javascript:delete_account()" class="btn btn-danger">DELETE Account</a>
					</div>
				</section>

				<section class="panel">
					<header class="panel-heading">
						<i>Reset Pending Custom Domain</i>
						<span class="tools pull-right">
							<a class="t-collapse fa fa-chevron-up" href="javascript:;"></a>
						</span>

					</header>
					<div class="panel-body" style="display:none">
						<div class="form-group">
							<label>Type subdomain to confirm</label>
							<input type="text" id="reset_custom" name="reset_custom" placeholder="" class="form-control" value="">
						</div>

						<a href="javascript:reset_pending_custom()" class="btn btn-danger">Reset Pending Custom Domain</a>
					</div>
				</section>
		<?php
			}
		?>

	</div>

</div>

<script>
var l_sSubdomain = '<?php echo $l_xUser['subdomain'] ?>';

$('#new_subdomain').keypress(function (e) {
	var regex = new RegExp("^[a-zA-Z0-9]+$");
	var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
	if (regex.test(str)) {
		return true;
	}

	e.preventDefault();
	return false;
});


function validate(){
	if ( ! confirm('Are you SURE you want to move this account?') ) {
		return false;
	} else if ( $('#new_subdomain').val() == '' ) {
		alert( 'Subdomain cannot be blank' );
		$('#new_subdomain').focus();
		return false;
	} else {		
		$.ajax( {
			  method: 'GET',
			  url: '/api/check_subdomain/',
			  data: { apikey: 'testapikey', subdomain: $('#new_subdomain').val() }
		} )
		  .done (function( data ) {
			if ( data == '1' ) {
				alert( 'Subdomain Already In Use. Please Choose another.' );
				return false;
			} else {
				window.location = '/admin/users/move_account/?id=<?php echo $l_xUser['id'] ?>&new=' + $('#new_subdomain').val();
			}
		  } );			
	}
}

function viewDates( p_sEvent ) {

	$.ajax( {
		method: 'POST',
		url: '/admin/users/activity_dates',
		data: { subdomain: l_sSubdomain, event: p_sEvent }
	} )
	.done (function( data ) {
		$( '#event_' + p_sEvent ).toggle();
		$( '#event_' + p_sEvent ).html( 'loading...' );
		$( '#event_' + p_sEvent ).html( data );
	} );			

}

function delete_account(){
	if ( ! confirm('Are you SURE you want to DELETE this account?') ) {
		return false;
	} else if ( $('#delete_subdomain').val() != '<?php echo $l_xUser['subdomain'] ?>' ) {
		alert( 'Enter correct subdomain' );
		$('#delete_subdomain').focus();
		return false;
	} else {
		window.location = '/admin/users/delete_account/?id=<?php echo $l_xUser['id'] ?>';
	}
}

function reset_custom(){
	if ( ! confirm('Are you SURE you want to RESET this custom domain?') ) {
		return false;
	} else if ( $('#reset_custom').val() != '<?php echo $l_xUser['url'] ?>' ) {
		alert( 'Enter correct custom domain' );
		$('#reset_custom').focus();
		return false;
	} else {
		window.location = '/admin/users/reset_custom/?id=<?php echo $l_xUser['id'] ?>';
	}
}

function reset_pending_custom(){
	if ( ! confirm('Are you SURE you want to RESET this pending custom domain?') ) {
		return false;
	} else if ( $('#reset_custom').val() != '<?php echo $l_xUser['subdomain'] ?>' ) {
		alert( 'Enter correct account name' );
		$('#reset_custom').focus();
		return false;
	} else {
		window.location = '/admin/users/reset_custom/?id=<?php echo $l_xUser['id'] ?>';
	}
}

</script>