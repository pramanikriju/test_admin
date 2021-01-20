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
	            Search old API Jobs
				<span class="tools pull-right">
					<a class="t-collapse fa fa-chevron-down" href="javascript:;"></a>
				</span>
	        </header>
	        <div class="panel-body">
				<form class="form-inline" role="form" action="/admin/api_jobs/" method="get">
					<div class="form-group">
						<input type="text" class="form-control" id="search" name="search" value="<?php echo $_GET['search']?>">
					</div>

					<button type="submit" class="btn btn-success">Run</button>
				</form>
			</div>
		</section>

	</div>
</div>

<?php
	if ( $l_axOldJobs ) {
?>

	<section class="panel">
		<header class="panel-heading">
        	OLD API SEARCH RESULTS (<?php echo number_format( $l_nOldJobsCount ) ?> found)
        </header>
        <div class="panel-body">

			<table class="table table-striped">
				<thead>
			    	<tr>
			    	    <th>URL</th>
			    	    <th>Time In</th>
			    	    <th>Time Done</th>
			    	    <th>Response</th>
			    	    <th>Priority</th>
			    	</tr>
			    </thead>
			    <tbody>
			        <?php
				        foreach( $l_axOldJobs as $l_xJob ) {
				    ?>
				        	<tr>
				        	    <td><?php echo $l_xJob['url'] ?></td>
				        	    <td><?php echo $l_xJob['time_in'] ?></td>
				        	    <td><?php echo $l_xJob['time_done'] ?></td>
				        	    <td><?php echo htmlentities( $l_xJob['response'] ) ?></td>
				        	    <td><?php echo $l_xJob['priority'] ?></td>
				        	</tr>
			    	<?php
			        	}
			        ?>
			    </tbody>
			</table>
			
        </div>
	</section>

<?php
	}
?>


	<section class="panel">
		<header class="panel-heading">
        	API JOBS (<?php echo number_format( $l_nPending ) ?> pending)
        </header>
        <div class="panel-body">

			<table class="table table-striped">
				<thead>
			    	<tr>
			    	    <th>URL</th>
			    	    <th>Time In</th>
			    	    <th>Time Done</th>
			    	    <th>Response</th>
			    	    <th>Priority</th>
			    	</tr>
			    </thead>
			    <tbody>
			        <?php
				        foreach( $l_axJobs as $l_xJob ) {
				    ?>
				        	<tr>
				        	    <td><?php echo $l_xJob['url'] ?></td>
				        	    <td><?php echo $l_xJob['time_in'] ?></td>
				        	    <td><?php echo $l_xJob['time_done'] ?></td>
				        	    <td><?php echo htmlentities( $l_xJob['response'] ) ?></td>
				        	    <td><?php echo $l_xJob['priority'] ?></td>
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
