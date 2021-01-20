<!-- page head start-->
<div class="page-head">
    <h2>
		<?php echo $l_sTitle ?>
		( <?php echo count( $l_asErrors ) ?> )
	</h2>
</div>
<!-- page head end-->

<!--body wrapper start-->
<div class="wrapper">

<div class="row">
	<div class="col-md-12">
	
	    <section class="panel">
	        <header class="panel-heading">
	            Error Search
				<span class="tools pull-right">
					<a class="t-collapse fa fa-chevron-down" href="javascript:;"></a>
				</span>
	        </header>
	        <div class="panel-body">
				<form class="form-inline" role="form" action="/admin/errors/" method="get">
					<div class="form-group">
						<input type="text" class="form-control js_datepicker" id="date_start" name="date_start" value="<?php echo displayDate( $l_sStartDate ) ?>">
					</div>
					<div class="form-group">
						<input type="text" class="form-control js_datepicker" id="date_end" name="date_end" value="<?php echo displayDate( $l_sEndDate ) ?>">
					</div>

					<div class="form-group">
						<select class="form-control" id="type" name="type">
							<option value=''>(all events)</option>
							<?php
                        		foreach( $l_asErrorTypes as $l_sErrorType ) {
                        	?>
									<option value='<?php echo $l_sErrorType['event'] ?>' <?php if ( $_GET['type'] == $l_sErrorType['event'] ) { echo 'selected="selected"';} ?>><?php echo $l_sErrorType['event'] ?></option>
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

	<div class="row">
		<div class="col-md-12">
			<section class="panel">
				<header class="panel-heading">
					<?php echo number_format( count( $l_asErrors ) ) ?> Errors
				</header>
				<div class="panel-body">


                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Total</th>
                            <th>Event</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach( $l_asErrorCount as $l_sErrorCount ) {
                        ?>
                                <tr>
                                    <td><?php echo number_format( $l_sErrorCount['the_count'] ); ?></td>
                                    <td><?php echo $l_sErrorCount['event'] ?></td>
                                </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
				

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>Account</th>
                            <th>Events</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach( $l_asErrors as $l_sError ) {
                        ?>
                                <tr>
                                    <td><?php echo date( 'm/d', $l_sError['time'] ); ?></td>
                                    <td><?php echo $l_sError['subdomain'] ?></td>
                                    <td><?php echo $l_sError['event'] ?></td>
                                    <td style="word-break: break-all;"><?php echo $l_sError['data'] ?></td>
                                </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
                </div>
            </section>          


        </div>
	</div>

</div>


<!--body wrapper end-->
