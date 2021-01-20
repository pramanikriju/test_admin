<!-- page head start-->
<div class="page-head">
    <h2><?php echo $l_sTitle ?></h2>
</div>
<!-- page head end-->

<!--body wrapper start-->
<div class="wrapper">
	<?php
		if( $_GET['status'] == 'saved' ) {
	?>
			<div class="alert alert-success alert-block fade in">
		    	<button data-dismiss="alert" class="close close-sm" type="button">
		    	    <i class="fa fa-times"></i>
		    	</button>
		    	<p>Profile Saved</p>
		    </div>
	<?php
		} elseif( $_GET['status'] == 'email' ) {
	?>
			<div class="alert alert-danger alert-block fade in">
		    	<button data-dismiss="alert" class="close close-sm" type="button">
		    	    <i class="fa fa-times"></i>
		    	</button>
		    	<p>Email Cannot Be Blank</p>
		    </div>	
	<?php
		}
	?>
	
	
	<section class="panel">
		<header class="panel-heading">
        	Edit Profile
        </header>
        <div class="panel-body">
			<form method="post" action="/admin/profile/edit" enctype="multipart/form-data" onsubmit="return validate()">

				<div class="form-group">
					<label>Email</label>
					<input type="text" name="email" placeholder="Email" class="form-control" value="<?php echo htmlentities($l_xUser['email']) ?>">
				</div>
				
				<hr>

				<div class="form-group">
					<label>New Password</label>
					<input type="password" name="password" id="password" class="form-control" autocomplete="new-password">
				</div>

				<div class="form-group">
					<label>Confirm New Password</label>
					<input type="password" name="password2" id="password2" class="form-control" autocomplete="new-password">
				</div>
				
				<button type="submit" class="btn btn-success">Save Profile</button>
			</form>
        </div>

	</section>

</div>

<script>
	function validate(){
		if( $('#password').val() != $('#password2').val() ) {
			alert( 'New Passwords Must Match!' );
			return false;
		} else {
			return true;
		}
	}
</script>
