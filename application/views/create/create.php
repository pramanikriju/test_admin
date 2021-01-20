<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="slick, flat, dashboard, bootstrap, admin, template, theme, responsive, fluid, retina">

    <title>Admin</title>

    <link href="/fe/js/switchery/switchery.min.css" rel="stylesheet" type="text/fe/css" media="screen" />
    <link href="/fe/css/jquery-ui.min.css" rel="stylesheet" type="text/fe/css" media="screen" />
    <link href="/fe/css/style.css" rel="stylesheet">
    <link href="/fe/css/style-responsive.css" rel="stylesheet">

	<script src="/fe/js/jquery-1.11.1.min.js"></script>

	<style>
		body, .dark-logo-bg{
			background: <?php echo $g_aaSettings['color_side_bg']['value'] ?>;
		}
		.sidebar-left .nav > li > a:hover, .sidebar-left .nav > li > a:focus, .side-navigation > li.active > a, .side-navigation > li.active > a:hover, .side-navigation > li.active > a:focus, .side-navigation > li.menu-list > a:hover, .side-navigation > li.nav-active > a, .side-navigation .child-list, .sidebar-collapsed .side-navigation > li.nav-hover > a, .sidebar-collapsed .side-navigation > li.nav-hover.active > a, .sidebar-collapsed .side-navigation li.nav-hover.active a span, .sidebar-collapsed .side-navigation li a span, .sidebar-collapsed .side-navigation li.nav-hover ul {
			background: <?php echo $g_aaSettings['color_side_bg_highlight']['value'] ?>;
			color: <?php echo $g_aaSettings['color_side_text_highlight']['value'] ?>;
		}
		.side-navigation > li > a {
			color: <?php echo $g_aaSettings['color_side_text']['value'] ?>;
		}
		.btn-success, .input-group-btn>.btn.btn-success, .btn-success:hover {
			background-color: <?php echo $g_aaSettings['color_button_primary']['value'] ?>;
			border-color: <?php echo $g_aaSettings['color_button_primary']['value'] ?>;
		}
		.btn-danger, .input-group-btn>.btn.btn-danger, .btn-danger:hover {
			background-color: <?php echo $g_aaSettings['color_button_danger']['value'] ?>;
			border-color: <?php echo $g_aaSettings['color_button_danger']['value'] ?>;
		}
	</style>
</head>

<body class="sticky-header">

    <section>
        <!-- sidebar left start-->
        <div class="sidebar-left sticky-sidebar">
            <!--responsive view logo start-->
            <div class="logo dark-logo-bg visible-xs-* visible-sm-*">
                <a href="#">
					Create Account
                </a>
            </div>
            <!--responsive view logo end-->

            <div class="sidebar-left-info">
                <!-- visible small devices start-->
                <div class=" search-field">  </div>
                <!-- visible small devices end-->

            </div>
        </div>
        <!-- sidebar left end-->

        <!-- body content start-->
        <div class="body-content" style="min-height: 100vh;">

            <!-- header section start-->
            <div class="header-section">

                <!--logo and logo icon start-->
                <div class="logo dark-logo-bg hidden-xs hidden-sm">
                    <a href="#">
						Create Account
                    </a>
                </div>

                <div class="icon-logo dark-logo-bg hidden-xs hidden-sm">
                    <a href="#">
                        <i class="fa fa-home" aria-hidden="true"></i>
                    </a>
                </div>
                <!--logo and logo icon end-->
                
                <a class="toggle-btn"><i class="fa fa-outdent"></i></a>

            </div>
            <!-- header section end-->

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
					Account Information
				</header>
				<div class="panel-body">
					<div class="form-group">
						<label>Email</label>
						<input type="text" name="email" placeholder="Email" id="email" class="form-control" value="<?php echo $email ?>" disabled="disabled">
					</div>
					<div class="form-group">
						<label>First Name</label>
						<input type="text" name="first_name" placeholder="First Name" id="first_name" class="form-control">
					</div>
					<div class="form-group">
						<label>Last Name</label>
						<input type="text" name="last_name" placeholder="Last Name" id="last_name" class="form-control">
					</div>

					<div class="form-group">
						<label>Your Account URL</label>
						<div class="form-control">
							https://<input type="text" name="subdomain" placeholder="" id="subdomain" >.vipmembervault.com
						</div>
					</div>

					<div class="form-group">
						<label>Confirm Your Account URL <i style="font-size:11px;">(this cannot be easily changed later)</i></label>
						<div class="form-control">
							https://<input type="text" name="subdomain2" placeholder="" id="subdomain2" >.vipmembervault.com
						</div>
					</div>

					<a href="javascript:validate()" class="btn btn-success">Submit</a>
				</div>
			</section>


	</div>
</div>

</div>
<!--body wrapper end-->

            <!--footer section start-->
            <footer>
                &copy; <?php echo date('Y') ?> - <?php echo $g_aaSettings['title']['value']; ?>
            </footer>
            <!--footer section end-->

        </div>
        <!-- body content end-->
    </section>

<form method="post" action="/create/add/?id=<?php echo $_GET['id'] ?>" id="hidden_form" style="display:none;">
	<input type="text" name="email" id="hidden_email">
	<input type="text" name="first_name" id="hidden_first_name">
	<input type="text" name="last_name" id="hidden_last_name">
	<input type="text" name="subdomain" id="hidden_subdomain">
</form>
<!-- Placed js at the end of the document so the pages load faster -->
<script src="/fe/js/bootstrap.min.js"></script>
<script src="/fe/js/modernizr.min.js"></script>

<!--jquery-ui-->
<script src="/fe/js/jquery-ui.min.js" type="text/javascript"></script>

<!--Nice Scroll-->
<script src="/fe/js/jquery.nicescroll.js" type="text/javascript"></script>

<!--switchery-->
<script src="/fe/js/switchery/switchery.min.js"></script>
<script src="/fe/js/switchery/switchery-init.js"></script>

<!--Chart JS-->
<script src="/fe/js/chart-js/chart.js"></script>

<!--tinymce-->
<script src="/fe/js/tinymce/tinymce.min.js"></script>

<!--color picker-->
<script src="/fe/js/jqColorPicker.min.js"></script>

<!--common scripts for all pages-->
<script src="/fe/js/scripts.js"></script>

<script>

	$('#subdomain, #subdomain2').keypress(function (e) {
		var regex = new RegExp("^[a-zA-Z0-9]+$");
		var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
		if (regex.test(str)) {
			return true;
		}

		e.preventDefault();
		return false;
	});

	function validate(){
		if ( $('#subdomain').val() == '' ) {
			alert( 'Subdomain cannot be blank' );
			$('#subdomain').focus();
			return false;
		} else if ( $('#subdomain').val() != $('#subdomain2').val() ) {
			alert( 'Subdomains must match' );
			$('#subdomain2').focus();
			return false;
		} else {
			var l_bAlready = false;
			var l_xPromise = $.Deferred();

			$.ajax( {
  				method: 'GET',
  				url: '/api/check_subdomain/',
  				data: { apikey: 'testapikey', subdomain: $('#subdomain').val() }
			} )
  			.done (function( data ) {
				if ( data == '1' ) {
					alert( 'Subdomain Already In Use. Please Choose another.' );
					return false;
				} else {
					$('#hidden_email').val( $('#email').val() );
					$('#hidden_first_name').val( $('#first_name').val() );
					$('#hidden_last_name').val( $('#last_name').val() );
					$('#hidden_subdomain').val( $('#subdomain').val() );
					$('#hidden_form').submit();
				}
  			} );			
		}
	}

</script>


</body>
</html>
