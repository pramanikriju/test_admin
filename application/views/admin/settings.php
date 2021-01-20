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
		    	<p>Settings Saved</p>
		    </div>
	<?php
		} elseif( $_GET['status'] == 'error' ) {
	?>
			<div class="alert alert-danger alert-block fade in">
		    	<button data-dismiss="alert" class="close close-sm" type="button">
		    	    <i class="fa fa-times"></i>
		    	</button>
		    	<p>Error</p>
		    </div>	
	<?php
		}
	?>

	<section class="panel">
		<header class="panel-heading">
        	API Key
        </header>
        <div class="panel-body">
			<input type="text" disabled="disabled" class="form-control" value="<?php echo $l_xApiKey['value'] ?>">
		</div>
	</section>


	<section class="panel">
		<header class="panel-heading">
        	Customize Appearance
        </header>
        <div class="panel-body">
			<form method="post" action="/admin/settings/edit" enctype="multipart/form-data" onsubmit="return validate()">

				<?php
					foreach( $l_axSettings as $l_xSetting ) {
						if( $l_xSetting['name'] == 'logo' ) { $l_sLogo = $l_xSetting['value']; }
						if( $l_xSetting['display'] == 'na' ) { continue; }
				?>
						<div class="form-group">
							<label for="<?php echo htmlentities( $l_xSetting['name'] ) ?>"><?php echo htmlentities( $l_xSetting['display'] ) ?></label>
							<input type="text" name="<?php echo htmlentities( $l_xSetting['name'] ) ?>" id="<?php echo htmlentities( $l_xSetting['name'] ) ?>" class="form-control" value="<?php echo htmlentities( $l_xSetting['value'] ) ?>">
						</div>
				<?php
					}
				?>

				<hr>

				<div class="form-group">	
					<label>Logo</label>
					<br>
					<?php
						if ( $l_sLogo ) {
					?>
							<img src="/uploads/<?php echo htmlentities( $l_sLogo ) ?>" />
					<?php
						} else {
					?>
							<p class="help-block">(no logo uploaded)</p>
					<?php
						}
					?>
				</div>
				<div class="form-group">	
					<label>Change Logo</label>
					<p class="help-block">(JPG,PNG,GIF,SVG) Max height 100px.  SVG preferred.</p>

					<input type="file" name="userfile" size="20" />
					<br>
					<input type="checkbox" name="image_delete"> Delete Logo
				</div>

				<hr>
								
				<button type="submit" class="btn btn-success">Save Apperance Settings</button>
			</form>
        </div>

	</section>

</div>

<script>
	$(document).ready(function(){
		$('[id^=color_]').colorPicker();
	});
</script>