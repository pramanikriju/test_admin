<!-- page head start-->
<div class="page-head">
    <h2>
		<?php echo $l_sTitle ?>
	</h2>
</div>
<!-- page head end-->

<!--body wrapper start-->
<div class="wrapper">

<div class="row">
	<div class="col-md-12">
	
	    <section class="panel">
	        <header class="panel-heading">
	            User Search
				<span class="tools pull-right">
					<a class="t-collapse fa fa-chevron-down" href="javascript:;"></a>
				</span>
	        </header>
	        <div class="panel-body">
				<form class="form-inline" role="form" action="/admin/search/" method="get">
					<div class="form-group">
                        <label>Email: </label>
						<input type="text" class="form-control" id="email" name="email" value="<?php echo $_GET['email'] ?>">
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
					<?php echo number_format( count( $l_axUsers ) ) ?> Users
				</header>
				<div class="panel-body">				

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Account</th>
                            <th>Email</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach( $l_axUsers as $l_xUser ) {
                        ?>
                                <tr>
                                    <td>
                                        <a href="/admin/users/edit/<?php echo $l_xUser['admin_id'] ?>" target="_BLANK">
                                            <?php echo $l_xUser['subdomain'] ?>
                                        </a>
                                    </td>
                                    <td><?php echo htmlspecialchars( $l_xUser['email'], ENT_QUOTES ) ?></td>
                                    <td><?php echo htmlspecialchars( $l_xUser['first_name'], ENT_QUOTES ) ?></td>
                                    <td><?php echo htmlspecialchars( $l_xUser['last_name'], ENT_QUOTES ) ?></td>
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
