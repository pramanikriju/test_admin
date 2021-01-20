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
    <link href="/fe/css/style.css?id=2" rel="stylesheet">
    <link href="/fe/css/style-responsive.css" rel="stylesheet">

	<script src="/fe/js/jquery-1.11.1.min.js"></script>

    <link rel="stylesheet" type="text/css" href="/fe/js/DataTables/datatables.min.css"/>
    <script type="text/javascript" src="/fe/js/DataTables/datatables.min.js"></script>

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
                <a href="/admin">
					<?php
						if( $g_aaSettings['logo']['value'] ) {
							echo '<img class="logo_inside" src="/uploads/'.$g_aaSettings['logo']['value'].'" />';
						} else {
							echo $g_aaSettings['title']['value'];
						}
					?>
                </a>
            </div>
            <!--responsive view logo end-->

            <div class="sidebar-left-info">
                <!-- visible small devices start-->
                <div class=" search-field">  </div>
                <!-- visible small devices end-->

                <!--sidebar nav start-->
                <ul class="nav nav-pills nav-stacked side-navigation">
                    <li>
                        <h3 class="navigation-title">Navigation</h3>
                    </li>
                    <li <?php if(preg_match("/admin\/users/",$_SERVER['REQUEST_URI'])){echo "class=\"active\"";}?>>
                    	<a href="/admin/users"><i class="fa fa-users"></i> <span>Users</span></a>
                    </li>
                    <li <?php if(preg_match("/admin\/search/",$_SERVER['REQUEST_URI'])){echo "class=\"active\"";}?>>
                    	<a href="/admin/search"><i class="fa fa-search"></i> <span>Search</span></a>
                    </li>
                    <li <?php if(preg_match("/admin\/api_jobs/",$_SERVER['REQUEST_URI'])){echo "class=\"active\"";}?>>
                    	<a href="/admin/api_jobs"><i class="fa fa-stack-overflow"></i> <span>API Jobs</span></a>
                    </li>
                    <li <?php if(preg_match("/admin\/reports/",$_SERVER['REQUEST_URI'])){echo "class=\"active\"";}?>>
                        <a href="/admin/reports"><i class="fa fa-line-chart"></i> <span>Reports</span></a>
                    </li>
                    <li <?php if(preg_match("/admin\/activity/",$_SERVER['REQUEST_URI'])){echo "class=\"active\"";}?>>
                        <a href="/admin/activity"><i class="fa fa-heartbeat"></i> <span>Activity</span></a>
                    </li>
                    <li <?php if(preg_match("/admin\/ep/",$_SERVER['REQUEST_URI'])){echo "class=\"active\"";}?>>
                        <a href="/admin/ep"><i class="fa fa-fire"></i> <span>EP</span></a>
                    </li>
                    <li <?php if(preg_match("/admin\/errors/",$_SERVER['REQUEST_URI'])){echo "class=\"active\"";}?>>
                        <a href="/admin/errors"><i class="fa fa-exclamation-triangle"></i> <span>Errors</span></a>
                    </li>
                    <li <?php if(preg_match("/admin\/consent/",$_SERVER['REQUEST_URI'])){echo "class=\"active\"";}?>>
                        <a href="/admin/consent"><i class="fa fa-check-circle-o" aria-hidden="true"></i> <span>Consent Log</span></a>
                    </li>

                </ul>
                <!--sidebar nav end-->

            </div>
        </div>
        <!-- sidebar left end-->

        <!-- body content start-->
        <div class="body-content" style="min-height: 100vh;" >

            <!-- header section start-->
            <div class="header-section">

                <!--logo and logo icon start-->
                <div class="logo dark-logo-bg hidden-xs hidden-sm">
                    <a href="/admin">
						<?php
							if( $g_aaSettings['logo']['value'] ) {
								echo '<img class="logo_inside" src="/uploads/'.$g_aaSettings['logo']['value'].'" />';
							} else {
								echo $g_aaSettings['title']['value'];
							}
						?>
                    </a>
                </div>

                <div class="icon-logo dark-logo-bg hidden-xs hidden-sm">
                    <a href="/admin">
                        <i class="fa fa-home" aria-hidden="true"></i>
                    </a>
                </div>
                <!--logo and logo icon end-->
                
                <a class="toggle-btn"><i class="fa fa-outdent"></i></a>

                <!--right notification start-->
                <div class="right-notification">
                    <ul class="notification-menu">

                        <li>
                            <a href="javascript:;" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                <?php echo $this->session->userdata('username') ?>
                                <span class=" fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu purple pull-right">
                                <li>
                                	<a href="/admin/profile"><i class="fa fa-user pull-right"></i> Profile</a>
                                </li>
                                <li>
                                	<a href="/logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </div>
                <!--right notification end-->

            </div>
            <!-- header section end-->