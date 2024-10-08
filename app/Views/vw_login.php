<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>Login | Sistem Asesmen OBE PS TIN</title>
    <link href="<?php echo base_url() ?>assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/styles/style.min.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/plugin/waves/waves.min.css">

</head>

<body>

<div id="single-wrapper">
	<form role="form" method="post" action="<?php echo site_url('Auth/login') ?>" enctype="multipart/form-data"> 
		<div class="inside">
			<div class="title">Sistem Asesmen <strong>OBE PS TIN</strong></div> 
			<!-- /.title -->
			<div class="frm-title">Login</div>
			<!-- /.frm-title -->
			<div class="frm-input"><input type="text" placeholder="Username" class="frm-inp"><i class="fa fa-user frm-ico" maxlength="50" minlength="2" required ></i></div>
			<!-- /.frm-input -->
			<div class="frm-input"><input type="text" placeholder="Password" class="frm-inp"><i class="fa fa-lock frm-ico" maxlength="50" minlength="2" required ></i></div>
			<!-- /.frm-input -->
			<button type="submit" class="frm-submit">Login<i class="fa fa-arrow-circle-right"></i></button>
		</div>
		<!-- .inside -->
	</form> 
	<!-- /.frm-single -->
</div><!--/#single-wrapper -->

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="assets/script/html5shiv.min.js"></script>
		<script src="assets/script/respond.min.js"></script>
	<![endif]-->
	<!-- 
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="<?php echo base_url() ?>assets/scripts/jquery.min.js"></script>
	<script src="<?php echo base_url() ?>assets/scripts/modernizr.min.js"></script>
	<script src="<?php echo base_url() ?>assets/plugin/bootstrap-5.0.1/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url() ?>assets/plugin/nprogress/nprogress.js"></script>
	<script src="<?php echo base_url() ?>assets/plugin/waves/waves.min.js"></script>

</body>
</html>