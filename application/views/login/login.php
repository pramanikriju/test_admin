<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/img/ico/favicon.png">
    <title>Login</title>

    <!-- Base Styles -->
    <link href="/fe/css/style.css" rel="stylesheet">
    <link href="/fe/css/style-responsive.css" rel="stylesheet">

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

  <body class="login-body">

      <div class="login-logo" style="font-size: 40px;">
	  	<?php
	  		if( $g_aaSettings['logo']['value'] ) {
	  			echo '<img class="logo_inside" src="/uploads/'.$g_aaSettings['logo']['value'].'" />';
	  		} else {
	  			echo $g_aaSettings['title']['value'];
	  		}
	  	?>
      </div>

      <h2 class="form-heading">
	      <?php echo $g_aaSettings['sub_title']['value'] ?>
	  </h2>
      
      <div class="container log-row">
	      <?php
		      if($_GET['error'] == 'password'){
		  ?>
			      <p style="text-align: center; color: #fff;"><br>Incorrect Username/Password</p>
	      <?php
		      }
		  ?>
	      
	      
          <form method="post" class="form-signin" action="/login">
              <div class="login-wrap">
                  <input type="text" class="form-control" name="username" placeholder="Username / Email" autofocus>
                  <input type="password" class="form-control" placeholder="Password" name="password">
                  <button class="btn btn-lg btn-success btn-block" type="submit">LOGIN</button>

              </div>
              
          </form>
      </div>

    <!--jquery-1.10.2.min-->
    <script src="/fe/js/jquery-1.11.1.min.js"></script>
    <!--Bootstrap Js-->
	<script src="/fe/js/bootstrap.min.js"></script>

	<script>
		function submitForgot(){
			var forgotEmail = $('#forgot_email').val();

			$.ajax({
				method: "POST",
				url: "/login/forgot",
				data: { email: forgotEmail }
			})
			.done(function( msg ) {
			 	$('#forgot_response').html(msg);
			 	$('#forgot_before').hide();
			 	$('#forgot_after').show();
			});
		}
		
		function resetForgot(){
			$('#forgot_before').show();
			$('#forgot_after').hide();			
		}
		  
	  </script>

  </body>
</html>
