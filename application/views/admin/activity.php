<!-- page head start-->
<div class="page-head">
    <h2><?php echo $l_sTitle ?></h2>
</div>
<!-- page head end-->

<!--body wrapper start-->
<div class="wrapper">

<div class="row">
	<div class="col-md-12">
	
	    <section class="panel">
	        <header class="panel-heading">
	            Search
				<span class="tools pull-right">
					<a class="t-collapse fa fa-chevron-down" href="javascript:;"></a>
				</span>
	        </header>
	        <div class="panel-body">
				<form class="form-inline" role="form" action="/admin/activity/" method="get">
					<div class="form-group">
						<input type="text" class="form-control js_datepicker" id="date_start" name="date_start" value="<?php echo displayDate( $l_sStartDate ) ?>">
					</div>
					<div class="form-group">
						<input type="text" class="form-control js_datepicker" id="date_end" name="date_end" value="<?php echo displayDate( $l_sEndDate ) ?>">
					</div>

					<div class="form-group">
						<select class="form-control" id="type" name="type">
							<option value=''>(all types)</option>
							<?php
                        		foreach( $l_asAccountTypes as $l_sAccountType ) {
                        	?>
									<option value='<?php echo $l_sAccountType['type'] ?>' <?php if ( $_GET['type'] == $l_sAccountType['type'] ) { echo 'selected="selected"';} ?>><?php echo $l_sAccountType['type'] ?></option>
							<?php
								}
							?>

						</select>						
					</div>



					<button type="submit" class="btn btn-success pull-right">Run</button>
				</form>
			</div>
		</section>

	</div>
</div>


	<section class="panel">
		<header class="panel-heading">
			<?php echo count( $l_axHotLeads ) ?> Hot Leads

			<span class="tools pull-right">
				<a class="t-collapse fa fa-chevron-up" href="javascript:;"></a>
			</span>

        </header>
        <div class="panel-body" style="display:none;">

			<table class="table table-striped">
				<thead>
			    	<tr>
			    	    <th>Account</th>
			    	    <th>Number</th>
			    	    <th>People</th>
			    	    <th>Prodcuts</th>
			    	    <th>Created</th>
			    	    <th>Bonus</th>
			    	    <th>Type</th>
			    	</tr>
			    </thead>
			    <tbody>
			        <?php
				        foreach( $l_axHotLeads as $l_xEvent ) {
				    ?>
				        	<tr>
				        	    <td>
									<a href="/admin/users/edit/<?php echo $l_xEvent['account_id'] ?>" target="_BLANK">
										<?php echo $l_xEvent['subdomain'] ?>
									</a>
								</td>
				        	    <td><?php echo number_format( $l_xEvent['the_count'] ) ?></td>
				        	    <td><?php echo number_format( $l_xEvent['users_count'] ) ?></td>
				        	    <td><?php echo number_format( $l_xEvent['products_count'] ) ?></td>
				        	    <td><?php echo displayDate( $l_xEvent['created'] ) ?></td>
				        	    <td><?php echo number_format( $l_xEvent['bonus'] ) ?></td>
				        	    <td><?php echo $l_xEvent['type'] ?></td>
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
			<?php echo count( $l_axEvents ) ?> Active Accounts
	
			<span class="tools pull-right">
				<a class="t-collapse fa fa-chevron-down" href="javascript:;"></a>
			</span>

        </header>
        <div class="panel-body">

			<table class="table table-striped">
				<thead>
			    	<tr>
			    	    <th>Account</th>
			    	    <th>Actions</th>
			    	    <th>People</th>
			    	    <th>Prodcuts</th>
			    	    <th>Created</th>
			    	    <th>Bonus</th>
			    	    <th>Type</th>
			    	</tr>
			    </thead>
			    <tbody>
			        <?php
				        foreach( $l_axEvents as $l_xEvent ) {
				    ?>
				        	<tr>
				        	    <td>
									<a href="/admin/users/edit/<?php echo $l_xEvent['account_id'] ?>" target="_BLANK">
										<?php echo $l_xEvent['subdomain'] ?>
									</a>
								</td>
				        	    <td><?php echo number_format( $l_xEvent['the_count'] ) ?></td>
				        	    <td><?php echo number_format( $l_xEvent['users_count'] ) ?></td>
				        	    <td><?php echo number_format( $l_xEvent['products_count'] ) ?></td>
				        	    <td><?php echo displayDate( $l_xEvent['created'] ) ?></td>
				        	    <td><?php echo number_format( $l_xEvent['bonus'] ) ?></td>
				        	    <td><?php echo $l_xEvent['type'] ?></td>
				        	</tr>
			    	<?php
			        	}
			        ?>
			    </tbody>
			</table>
			
        </div>
	</section>


</div>
<!--body wrapper end-->
