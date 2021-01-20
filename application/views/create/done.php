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
					Account Created
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
						Account Created
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
				<div class="panel-body">
					Congrats <?php echo htmlspecialchars( $l_xUser['first_name'], ENT_QUOTES ) ?>,

					<br><br>Your MemberVault account will be created at <b><a target="_BLANK" href="https://<?php echo $l_xUser['subdomain'] ?>.vipmembervault.com/">https://<?php echo $l_xUser['subdomain'] ?>.vipmembervault.com/</a></b> in the next few minutes.

					<br><br>The username/password will be "admin/admin" and you’ll be prompted to change that to something else when you log in.

					<br><br>Once you log in, everything you need to get going is on the left hand side, including help documentation and videos.  If you run into any issues, please don’t hesitate to reach out.  We’re excited that you are part of the MemberVault family now and look forward to seeing your courses succeed and engage your students!
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


</body>
</html>
