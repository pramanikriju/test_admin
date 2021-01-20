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
				<form class="form-inline" role="form" action="/admin/ep/" method="get">
					<div class="form-group">
						<input type="text" class="form-control js_datepicker" id="date_start" name="date_start" value="<?php echo displayDate( $l_sStartDate ) ?>">
					</div>
					<div class="form-group">
						<input type="text" class="form-control js_datepicker" id="date_end" name="date_end" value="<?php echo displayDate( $l_sEndDate ) ?>">
					</div>

					<button type="submit" class="btn btn-success pull-right">Run</button>
				</form>
			</div>
		</section>

	</div>
</div>



<section class="panel">
    <header class="panel-heading">
        <?php echo count( $l_axUsers ) ?> Active EP Accounts

        <span class="tools pull-right">
            <a class="t-collapse fa fa-chevron-down" href="javascript:;"></a>
        </span>

    </header>
    <div class="panel-body">

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Account</th>
                    <th>EP</th>
                    <th>People</th>
                    <th>Prodcuts</th>
                    <th>Created</th>
                    <th>Type</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach( $l_axUsers as $l_xUser ) {
                ?>
                        <tr>
                            <td>
                                <a href="/admin/users/edit/<?php echo $l_xUser['id'] ?>" target="_BLANK">
                                    <?php echo $l_xUser['subdomain'] ?>
                                </a>
                            </td>
                            <td><?php echo number_format( $l_xUser['ep_count'] ) ?></td>
                            <td><?php echo number_format( $l_xUser['users'] ) ?></td>
                            <td><?php echo number_format( $l_xUser['products'] ) ?></td>
                            <td><?php echo displayDate( $l_xUser['created'] ) ?></td>
                            <td><?php echo $l_xUser['type'] ?></td>
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
