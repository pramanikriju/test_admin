<!-- page head start-->
<div class="page-head">
    <h2><?php echo $l_sTitle ?></h2>
</div>
<!-- page head end-->

<!--body wrapper start-->
<div class="wrapper">

	<form method="post" action="/admin/users/add">
	
	<section class="panel">
		<header class="panel-heading">
        	User Information
        </header>
        <div class="panel-body">
			<div class="form-group">
				<label>Status</label>
				<select name="status" class="form-control">
					<option value="1">Active</option>
					<option value="0">Inactive</option>
				</select>
			</div>

			<div class="form-group">
				<label>Subdomain</label>
				<input type="text" name="subdomain" placeholder="Subdomain" class="form-control">
			</div>

			<div class="form-group">
				<label>Type</label>
				<select name="type" class="form-control">
					<option value="Free">FREE</option>
					<option value="Paid:50">Paid:50</option>
					<option value="Paid:50:AF">Paid:50:AF</option>
					<option value="Paid:25">Paid:25</option>
				</select>					
			</div>

			<div class="form-group">
				<label>Email</label>
				<input type="text" name="email" placeholder="Email" class="form-control">
			</div>
			<div class="form-group">
				<label>First Name</label>
				<input type="text" name="first_name" placeholder="First Name" class="form-control">
			</div>
			<div class="form-group">
				<label>Last Name</label>
				<input type="text" name="last_name" placeholder="Last Name" class="form-control">
			</div>

			<div class="form-group">
				<label>Date Signed Up</label>
				<input type="text" name="created" class="form-control js_datepicker" value="<?php echo date('m/d/Y'); ?>">
			</div>

			<button type="submit" class="btn btn-success">Submit</button>
        </div>
	</section>

				
	</form>


</div>