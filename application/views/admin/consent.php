<!-- page head start-->
<div class="page-head">
    <h2><?php echo $l_sTitle ?></h2>
</div>
<!-- page head end-->

<!--body wrapper start-->
<div class="wrapper">

	<section class="panel">
		<header class="panel-heading">
        	Consent Log (<?php echo number_format( count( $l_axLogs ) ) ?>)

            <span class="pull-right">
				<a href="/admin/consent/csv" target="_BLANK">
					<i class="fa fa-table"></i> CSV
				</a>&nbsp;&nbsp;&nbsp;
		    </span>
        </header>
        <div class="panel-body">

            <div id="users_table_loading">Loading....</div>
			<table id="users_table" class="table table-striped table-bordered" style="width:100%; display:none;">
				<thead>
			    	<tr>
			    	    <th>Time</th>
			    	    <th>Email</th>
			    	    <th>Name</th>
			    	    <th>Consent?</th>
			    	    <th>How</th>
			    	</tr>
			    </thead>
			    <tbody>
			        <?php
				        foreach( $l_axLogs as $l_xLog ) {
				    ?>
				        	<tr>
				        	    <td>
                                    <?php echo date( 'm/d/Y - H:i', $l_xLog['timestamp'] ) ?>


                                </td>
				        	    <td><?php echo $l_xLog['email'] ?></td>
				        	    <td><?php echo $l_xLog['name'] ?></td>
				        	    <td>
                                    <?php
                                        if ( $l_xLog['consent'] == 1 ) {
                                            echo "Yes";
                                        } else {
                                            echo "No";
                                        }
                                    ?>
                                </td>
				        	    <td><?php echo htmlentities( $l_xLog['how'] ) ?></td>
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

<script>
$(document).ready( function () {
    var table = $('#users_table').DataTable({
		"paging":   true,
		"pageLength": 50,
		"info":     false,
		"order": [[ 0, "desc" ]],
		"initComplete": function(settings, json) {
    		$('#users_table').show();
			$('#users_table_loading').hide();
  		},
    });
});
</script>
