<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Log in</title>
  <link rel="icon" href="<?= base_url('assets/icons/internet.ico'); ?>" type="image/x-icon">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url('Adminlte/plugins/fontawesome-free/css/all.min.css'); ?>">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?= base_url('Adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css'); ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('Adminlte/dist/css/adminlte.min.css'); ?>">
  <!-- Theme style -->

  <!-- Google Font: Source Sans Pro -->
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a ><b> <strong>DIPLOMACY .1.8</strong> </b></a>
    <p style="font-size: 30px;"> Sistem Assesmen OBE PSTIN</p>

  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <?php if (session()->getFlashdata('message_login_error')) : ?>
			<div style="color: red;">
					<?php echo 'Login Gagal, pastikan username dan password benar!'; ?>

			</div>
      <?php endif; ?>

		<?php //echo password_hash("admin", PASSWORD_DEFAULT) ?>
      <br>
      <form role="form" method="post" action="<?php echo site_url('Auth/login') ?>" enctype="multipart/form-data">
        <div class="input-group mb-4">
          <input type="text" name="username" class="form-control" placeholder="Username" class="<?= session('errors.username') ? 'is-invalid' : '' ?>" value="<?= old('username') ?>" maxlength="30" minlength="2" required />
				<div class="invalid-feedback">
					<?= session('errors.username') ?>
				</div>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password" class="<?= session('errors.password') ? 'is-invalid' : '' ?>" value="<?= old('password') ?>" maxlength="12" minlength="2" required />
				<div class="invalid-feedback">
					<?= session('errors.password') ?>
				</div> 
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-4">

            <button type="submit" class="btn btn-primary btn-block" value="Login">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    <!-- /.login-card-body -->
  </div>
</div>
    <footer class="footer">
      <div class="row">
        <div class="col-lg-5 mb-3">
          <br>
          <br>
          <ul class="list-unstyled">
            <li class="mb-2">v.1.8</li>
          </ul>
        </div>
      </div>
    </footer>
</body>

</html>
