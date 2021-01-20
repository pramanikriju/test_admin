<!-- page head start-->
<div class="page-head">
    <h2><?php echo $l_sTitle ?> (<?php echo number_format( count( $l_axUsers ) ); ?>)</h2>
</div>
<!-- page head end-->

<!--body wrapper start-->
<div class="wrapper">

	<section class="panel">
		<header class="panel-heading">
			<input type="checkbox" class="js_toggle" data-column="1" checked="checked"> Name
			&nbsp; &nbsp; &nbsp; &nbsp;
			<input type="checkbox" class="js_toggle" data-column="2" checked="checked"> Email
			&nbsp; &nbsp; &nbsp; &nbsp;
			<input type="checkbox" class="js_toggle" data-column="4"> Signed Up
			&nbsp; &nbsp; &nbsp; &nbsp;
			<input type="checkbox" class="js_toggle" data-column="6"> Users
			&nbsp; &nbsp; &nbsp; &nbsp;
			<input type="checkbox" class="js_toggle" data-column="7"> Boost
			&nbsp; &nbsp; &nbsp; &nbsp;
			<input type="checkbox" class="js_toggle" data-column="8"> EP
			&nbsp; &nbsp; &nbsp; &nbsp;
			<select name="type" id="type">
				<option value="">All</option>
				<option value="Free" <?php if ( $_GET['type'] == 'Free' ) { echo 'selected="selected"'; } ?>>Free</option>
				<option value="">---------------</option>
				<option value="Starter: Monthly" <?php if ( $_GET['type'] == 'Starter: Monthly' ) { echo 'selected="selected"'; } ?>>Starter: Monthly</option>
				<option value="Starter: Annual" <?php if ( $_GET['type'] == 'Starter: Annual' ) { echo 'selected="selected"'; } ?>>Starter: Annual</option>
				<option value="">---------------</option>
				<option value="Base: Monthly" <?php if ( $_GET['type'] == 'Base: Monthly' ) { echo 'selected="selected"'; } ?>>Base: Monthly</option>
				<option value="Base: Annual" <?php if ( $_GET['type'] == 'Base: Annual' ) { echo 'selected="selected"'; } ?>>Base: Annual</option>
				<option value="">---------------</option>
				<option value="Pro: Monthly" <?php if ( $_GET['type'] == 'Pro: Monthly' ) { echo 'selected="selected"'; } ?>>Pro: Monthly</option>
				<option value="Pro: Annual" <?php if ( $_GET['type'] == 'Pro: Annual' ) { echo 'selected="selected"'; } ?>>Pro: Annual</option>
				<option value="">---------------</option>
				<option value="Pro+: Monthly" <?php if ( $_GET['type'] == 'Pro : Monthly' ) { echo 'selected="selected"'; } ?>>Pro+: Monthly</option>
				<option value="Pro+: Annual" <?php if ( $_GET['type'] == 'Pro : Annual' ) { echo 'selected="selected"'; } ?>>Pro+: Annual</option>
				<option value="">---------------</option>
				<option value="Lifetime: Starter" <?php if ( $_GET['type'] == 'Lifetime: Starter' ) { echo 'selected="selected"'; } ?>>Lifetime: Starter</option>
				<option value="Lifetime: Lite" <?php if ( $_GET['type'] == 'Lifetime: Lite' ) { echo 'selected="selected"'; } ?>>Lifetime: Lite</option>
				<option value="Lifetime: Pro" <?php if ( $_GET['type'] == 'Lifetime: Pro' ) { echo 'selected="selected"'; } ?>>Lifetime: Pro</option>
				<option value="">---------------</option>
				<option value="Promo: Promo" <?php if ( $_GET['type'] == 'Promo: Promo' ) { echo 'selected="selected"'; } ?>>Promo: Promo</option>
				<option value="Lifetime: Founding 100" <?php if ( $_GET['type'] == 'Lifetime: Founding 100' ) { echo 'selected="selected"'; } ?>>Lifetime: Founding 100</option>
			</select>
        </header>
        <div class="panel-body">
			<div id="users_table_loading">Loading....</div>
			<table id="users_table" class="table table-striped table-bordered" style="width:100%; display:none;">
				<thead>
			    	<tr>
			    	    <th>URL</th>
			    	    <th>Name</th>
			    	    <th>Email</th>
			    	    <th>Type</th>
			    	    <th>Signed Up</th>
			    	    <th>Last Active</th>
			    	    <th>Users</th>
			    	    <th>Boost</th>
			    	    <th>EP</th>
			    	    <th>Action</th>
			    	</tr>
			    </thead>
			    <tbody>
			        <?php
						$l_nTotalProducts = 0;
						$l_nTotalUsers = 0;
				        foreach( $l_axUsers as $l_xUser ) {
							$l_nTotalProducts = $l_nTotalProducts + $l_xUser['products'];
							$l_nTotalUsers = $l_nTotalUsers + $l_xUser['users'];
							$l_sExtraClass = '';

							if ( $l_xUser['type'] == 'Free' && $l_xUser['users'] > LIMIT_FREE ) {
								$l_sExtraClass = 'alert-danger';
							}
							if ( $l_xUser['type'] == 'Lifetime: Starter' && $l_xUser['users'] > LIMIT_STARTER ) {
								$l_sExtraClass = 'alert-danger';
							}
							if ( ( $l_xUser['type'] == 'Base: Annual' || $l_xUser['type'] == 'Base: Monthly' ) && ( $l_xUser['users'] > 10000 && $l_xUser['users'] > $l_xUser['bonus'] ) ) {
								$l_sExtraClass = 'alert-danger';
							}
							if ( ( $l_xUser['type'] == 'Pro: Annual' || $l_xUser['type'] == 'Pro: Monthly' ) && ( $l_xUser['users'] > 100000 && $l_xUser['users'] > $l_xUser['bonus'] ) ) {
								$l_sExtraClass = 'alert-danger';
							}
?>
				        	<tr>
				        	    <td class="<?php echo $l_sExtraClass ?>">
									<?php
										if ( $l_xUser['url'] ) {
											echo $l_xUser['url'];
										} else {
											echo $l_xUser['subdomain'];
										}
									?>
								</td>
				        	    <td class="<?php echo $l_sExtraClass ?>"><?php echo htmlspecialchars( $l_xUser['first_name'], ENT_QUOTES ) ?> <?php echo htmlspecialchars( $l_xUser['last_name'], ENT_QUOTES ) ?></td>
				        	    <td class="<?php echo $l_sExtraClass ?>"><?php echo htmlspecialchars( $l_xUser['email'], ENT_QUOTES ) ?></td>
				        	    <td class="<?php echo $l_sExtraClass ?>"><?php echo $l_xUser['type'] ?></td>
				        	    <td class="<?php echo $l_sExtraClass ?>">
									<span style="display:none"><?php echo displayDateSortable( $l_xUser['created'], false ) ?></span>
									<?php echo displayDate( $l_xUser['created'] ) ?>
								</td>
				        	    <td class="<?php echo $l_sExtraClass ?>">
									<span style="display:none"><?php echo displayDateSortable( $l_xUser['admin_activity'], true ) ?></span>
									<?php echo displayDate( $l_xUser['admin_activity'], true ) ?>
								</td>
				        	    <td class="<?php echo $l_sExtraClass ?>"><?php echo number_format( $l_xUser['users'] ) ?></td>
				        	    <td class="<?php echo $l_sExtraClass ?>"><?php echo number_format( $l_xUser['bonus'] ) ?></td>
				        	    <td class="<?php echo $l_sExtraClass ?>"><?php echo number_format( $l_xUser['ep'] ) ?></td>
				        	    <td class="<?php echo $l_sExtraClass ?>">
									<a href="/admin/users/edit/<?php echo $l_xUser['id'] ?>">Edit</a> / 

									<?php
										if ( $l_xUser['url'] ) {
									?>
											<a href="https://<?php echo $l_xUser['url'] ?>/" target="_BLANK">View</a> / 
											<a href="https://<?php echo $l_xUser['url'] ?>/adminapi/admin_login/?apikey=testapikey" target="_BLANK">Login</a>
									<?php
										} else {
									?>
											<a href="https://<?php echo $l_xUser['subdomain'] ?>.vipmembervault.com/" target="_BLANK">View</a> / 
											<a href="https://<?php echo $l_xUser['subdomain'] ?>.vipmembervault.com/adminapi/admin_login/?apikey=testapikey" target="_BLANK">Login</a>
									<?php
										}
									?>
								</td>
				        	</tr>
			    	<?php
			        	}
			        ?>
			    </tbody>
			</table>

			<b>Total Products: </b> <?php echo number_format( $l_nTotalProducts ) ?><br>
			<b>Total Users: </b> <?php echo number_format( $l_nTotalUsers ) ?>
			
        </div>
	</section>

</div>
<!--body wrapper end-->
<script>
$( "#type" ).change(function() {
	window.location = '/admin/users/?type=' + encodeURI( $( "#type" ).val() );
});

$(document).ready( function () {
    var table = $('#users_table').DataTable({
		"paging":   true,
		"pageLength": 50,
		"info":     false,
		"order": [[ 4, "desc" ]],
		"initComplete": function(settings, json) {
    		$('#users_table').show();
			$('#users_table_loading').hide();
  		},
        "columnDefs": [
            {
                "targets": [ 1 ],
                "visible": true,
            },
            {
                "targets": [ 3 ],
                "visible": true,
                "searchable": false,
				"sortable": false,
            },
            {
                "targets": [ 4 ],
                "visible": false,
                "searchable": false
            },
            {
                "targets": [ 6 ],
                "visible": false,
                "searchable": false
            },
            {
                "targets": [ 7 ],
                "visible": false,
                "searchable": false
            },
            {
                "targets": [ 8 ],
                "visible": false,
                "searchable": false
            },
            {
                "targets": [ 9 ],
                "visible": true,
                "searchable": false,
				"sortable": false,
            },
        ]
    });

	$('.js_toggle').on( 'click', function (e) {
        var column = table.column( $(this).attr('data-column') );
        column.visible( ! column.visible() );
    } );

});
</script>