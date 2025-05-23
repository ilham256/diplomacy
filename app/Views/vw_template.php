<!DOCTYPE html>
<html lang="en">
<head> 
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta name="description" content="">
	<meta name="author" content=""> 
	<title>Home - Sistem Asesmen OBE PS TIN</title> 
	<link rel="icon" href="<?= base_url('assets/icons/favicon.ico'); ?>" type="image/x-icon">

	<!-- Themify Icon -->
	<link rel="stylesheet" href="<?= base_url('fonts/themify-icons/themify-icons.css') ?>">

	<!-- mCustomScrollbar -->
	<link rel="stylesheet" href="<?= base_url('plugin/mCustomScrollbar/jquery.mCustomScrollbar.min.css') ?>">

	<!-- Waves Effect -->
	<link rel="stylesheet" href="<?= base_url('plugin/waves/waves.min.css') ?>">

	<!-- Jquery UI -->
	<link rel="stylesheet" href="<?= base_url('plugin/jquery-ui/jquery-ui.min.css') ?>">
	<link rel="stylesheet" href="<?= base_url('plugin/jquery-ui/jquery-ui.structure.min.css') ?>">
	<link rel="stylesheet" href="<?= base_url('plugin/jquery-ui/jquery-ui.theme.min.css') ?>">

	<!-- Data Tables --> 
	<link rel="stylesheet" href="<?= base_url('plugin/datatables/media/css/jquery.dataTables.min.css') ?>">

	<!-- Dropify -->
	<link rel="stylesheet" href="<?= base_url('plugin/dropify/css/dropify.min.css') ?>">

	<!-- Main Styles -->
    <link rel="stylesheet" href="<?= base_url('plugin/bootstrap-5.0.1/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('fonts/font-awesome-4.7.0/css/font-awesome.min.css') ?>">

	<link rel="stylesheet" href="<?= base_url('styles/style.min.css') ?>">

		  <!-- Adminlte -->
	<link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
	<link rel="stylesheet" href="<?= base_url('Adminlte/plugins/fontawesome-free/css/all.min.css') ?>">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<!-- overlayScrollbars -->
	<link rel="stylesheet" href="../../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
	<link rel="stylesheet" href="<?= base_url('Adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') ?>">
	<!-- Theme style -->
	<link rel="stylesheet" href="../../dist/css/adminlte.min.css">
	<link rel="stylesheet" href="<?= base_url('Adminlte/dist/css/adminlte.min.css') ?>">
	<!-- Google Font: Source Sans Pro -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="script/html5shiv.min.js"></script>
		<script src="script/respond.min.js"></script>
	<![endif]--> 
	<!-- 
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="<?= base_url('scripts/jquery2.min.js') ?>"></script>
	<script src="<?= base_url('scripts/modernizr.min.js') ?>"></script>
	<script src="<?= base_url('plugin/bootstrap-5.0.1/js/popper.min.js') ?>"></script>
	<script src="<?= base_url('plugin/bootstrap-5.0.1/js/bootstrap.min.js') ?>"></script>
	<script src="<?= base_url('plugin/mCustomScrollbar/jquery.mCustomScrollbar.concat.min.js') ?>"></script>
	<script src="<?= base_url('plugin/nprogress/nprogress.js') ?>"></script>
	<script src="<?= base_url('plugin/waves/waves.min.js') ?>"></script>

	<!-- Jquery UI -->
	<script src="<?= base_url('plugin/jquery-ui/jquery-ui.min.js') ?>"></script>
	<script src="<?= base_url('plugin/jquery-ui/jquery.ui.touch-punch.min.js') ?>"></script>

	<!-- Sparkline Chart -->
	<script src="<?= base_url('plugin/chart/sparkline/jquery.sparkline.min.js') ?>"></script>
	<script src="<?= base_url('scripts/chart.sparkline.init.min.js') ?>"></script>

	<!-- Data Tables -->
	<script src="<?= base_url('plugin/datatables/media/datatables/jquery.dataTables.js') ?>"></script>
	<script src="<?= base_url('plugin/datatables/media/js/dataTables.bootstrap.min.js') ?>"></script>
	<script src="<?= base_url('plugin/editable-table/mindmup-editabletable.js') ?>"></script>
	<script src="<?= base_url('scripts/datatables.demo.min.js') ?>"></script>

	<!-- Dropify -->
	<script src="<?= base_url('plugin/dropify/js/dropify.min.js') ?>"></script>
	<script src="<?= base_url('scripts/fileUpload.demo.min.js') ?>"></script>

    <!-- Select2 -->
  <link rel="stylesheet" href="<?= base_url('Adminlte/plugins/select2/css/select2.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('Adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">



</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
<aside class="main-sidebar sidebar-light-primary elevation-4">
<div class="main-menu">
	<header class="header">
		<a href="<?php echo site_url() ?>" class="logo"><img src="<?php echo base_url() ?>images/Logo_web.png" width="170" /></a>
		<button type="button" class="button-close fa fa-times js__menu_close"></button>
	</header>
	<!-- /.header -->
	<div class="sidebar">
		<!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-1 mb-1 d-flex">
        <div class="info">
          <a href="<?= base_url('akun') ?>" class="d-block"><h5 class="title">Admin</h5></a>
        </div>
      </div>
			<!-- /.title -->

			<!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item <?php if (in_array($breadcrumbs, ['infumum', 'kinumum', 'kincpmk', 'kincpl'])) {echo "menu-open";}?>">
            <a href="#" class="nav-link <?php if (in_array($breadcrumbs, ['infumum', 'kinumum', 'kincpmk', 'kincpl'])) {echo "active";}?>">
              <i class="nav-icon menu-icon ti-dashboard"></i>
              <p>
                Dashboard
                <i class="right menu-arrow fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url('infumum') ?>" class="nav-link <?php if ($breadcrumbs == 'infumum') {echo "active";}?>">
                  <i class="far ti-arrow-circle-right nav-icon"></i>
                  <p>Informasi Umum</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('kinumum') ?>" class="nav-link <?php if ($breadcrumbs == 'kinumum') {echo "active";}?>">
                  <i class="far ti-arrow-circle-right nav-icon"></i>
                  <p>Kinerja CPL</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('kincpmk') ?>" class="nav-link <?php if ($breadcrumbs == 'kincpmk') {echo "active";}?>">
                  <i class="far ti-arrow-circle-right nav-icon"></i>
                  <p>Kinerja CPMK</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('kincpl') ?>" class="nav-link <?php if ($breadcrumbs == 'kincpl') {echo "active";}?>">
                  <i class="far ti-arrow-circle-right nav-icon"></i>
                  <p>Status Pencapaian CPL</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item <?php if (in_array($breadcrumbs, ['kurikulum','cpmk_cpl','matakuliah','profil_matakuliah','formula','katkin','cpmklang','cpmktlang','cpltlang','efektivitas_cpl','relevansi_ppm','epbm' ])) {echo "menu-open";}?>">
            <a href="#" class="nav-link <?php if (in_array($breadcrumbs, ['kurikulum','cpmk_cpl','matakuliah','profil_matakuliah','formula','katkin','cpmklang','cpmktlang','cpltlang','efektivitas_cpl','relevansi_ppm','epbm' ])) {echo "active";}?>">
              <i class="nav-icon menu-icon ti-layers-alt"></i>
              <p>
                Input Asesmen
                <i class="right menu-arrow fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url('kurikulum') ?>" class="nav-link <?php if ($breadcrumbs == 'kurikulum') {echo "active";}?>"> 
                <i class="far ti-arrow-circle-right nav-icon"></i> 
                <p>Kurikulum</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('cpmkcpl') ?>" class="nav-link <?php if ($breadcrumbs == 'cpmk_cpl') {echo "active";}?>"> 
                <i class="far ti-arrow-circle-right nav-icon"></i> 
                <p>CPL dan Deskriptor</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('matakuliah') ?>" class="nav-link <?php if ($breadcrumbs == 'matakuliah') {echo "active";}?>"> 
                <i class="far ti-arrow-circle-right nav-icon"></i> 
                <p>MK menurut Semester</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('profilmatakuliah') ?>" class="nav-link <?php if ($breadcrumbs == 'profil_matakuliah') {echo "active";}?>"> 
                <i class="far ti-arrow-circle-right nav-icon"></i> 
                <p>Profil MK & CPMK</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('formula') ?>" class="nav-link <?php if ($breadcrumbs == 'formula') {echo "active";}?>"> 
                <i class="far ti-arrow-circle-right nav-icon"></i> 
                <p>Formula CPL</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('katkin') ?>" class="nav-link <?php if ($breadcrumbs == 'katkin') {echo "active";}?>"> 
                <i class="far ti-arrow-circle-right nav-icon"></i> 
                <p>Kategori Kinerja</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('cpmklang') ?>" class="nav-link <?php if ($breadcrumbs == 'cpmklang') {echo "active";}?>"> 
                <i class="far ti-arrow-circle-right nav-icon"></i> 
                <p>Nilai CPMK Langsung</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('cpmktlang') ?>" class="nav-link <?php if ($breadcrumbs == 'cpmktlang') {echo "active";}?>"> 
                <i class="far ti-arrow-circle-right nav-icon"></i> 
                <p>Nilai CPMK Tak Langsung</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('cpltlang') ?>" class="nav-link <?php if ($breadcrumbs == 'cpltlang') {echo "active";}?>"> 
                <i class="far ti-arrow-circle-right nav-icon"></i> 
                <p>Nilai CPL Tak Langsung</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('efektivitascpl') ?>" class="nav-link <?php if ($breadcrumbs == 'efektivitas_cpl') {echo "active";}?>"> 
                <i class="far ti-arrow-circle-right nav-icon"></i> 
                <p>Evaluasi Efektivitas CPL</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('relevansippm') ?>" class="nav-link <?php if ($breadcrumbs == 'relevansi_ppm') {echo "active";}?>"> 
                <i class="far ti-arrow-circle-right nav-icon"></i> 
                <p>Evaluasi Relevansi PPM</p>
                </a>
              </li>
              <li class="nav-item">
					<a href="<?= base_url('epbm') ?>" class="nav-link <?php if ($breadcrumbs == 'epbm') {echo "active";}?>">
					<i class="far ti-arrow-circle-right nav-icon"></i>
					<p>Rekap EPBM</p>
					</a>
				</li>
            </ul>
          </li>

          <li class="nav-item <?php if (in_array($breadcrumbs, ['dosen'])) {echo "active";}?>">
            <a href="<?= base_url('dosen') ?>" class="nav-link <?php if (in_array($breadcrumbs, ['dosen'])) {echo "active";}?>">
            <i class="nav-icon menu-icon ti-user"></i>
            <p>  
              Dosen
            </p>
            </a>
          </li>

          <li class="nav-item has-treeview">
            <a href="<?= base_url('mahasiswa') ?>" class="nav-link <?php if (in_array($breadcrumbs, ['mahasiswa'])) {echo "active";}?>">
            <i class="nav-icon menu-icon ti-user"></i>
            <p>
              Mahasiswa
            </p>
            </a>
          </li>

          <li class="nav-item has-treeview">
				<a href="<?= base_url('cpltersimpan') ?>" class="nav-link <?php if (in_array($breadcrumbs, ['cpl_tersimpan'])) {echo "active";}?>">
				<p> <i class="nav-icon menu-icon ti-files"></i>
					Hasil Pengukuran
				</p>
				</a>
			</li>

          <li class="nav-item <?php if (in_array($breadcrumbs, ['evaluasi_l', 'evaluasi_tl'])) {echo "menu-open";}?>">
            <a href="#" class="nav-link <?php if (in_array($breadcrumbs, ['evaluasi_l', 'evaluasi_tl'])) {echo "active";}?>">
            <i class="nav-icon menu-icon ti-dashboard"></i>
            <p>
              Analisis & Evaluasi
              <i class="right menu-arrow fa fa-angle-left"></i>
            </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url('evaluasil') ?>" class="nav-link <?php if ($breadcrumbs == 'evaluasi_l') {echo "active";}?>">
                <i class="far ti-arrow-circle-right nav-icon"></i> 
                <p>P Langsung</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('evaluasitl') ?>" class="nav-link <?php if ($breadcrumbs == 'evaluasi_tl') {echo "active";}?>">
                <i class="far ti-arrow-circle-right nav-icon"></i> 
                <p>P Tak Langsung</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item <?php if (in_array($breadcrumbs, ['report', 'report_epbm','report_kinerja_cpmk_mahasiswa','report_mahasiswa','report_mata_kuliah','report_relevansi_ppm','report_efektivitas_cpl'])) {echo "menu-open";}?>">
            <a href="report" class="nav-link <?php if (in_array($breadcrumbs, ['report', 'report_epbm','report_kinerja_cpmk_mahasiswa','report_mahasiswa','report_mata_kuliah','report_relevansi_ppm','report_efektivitas_cpl'])) {echo "active";}?>">
            <i class="nav-icon menu-icon ti-layers"></i>
            <p>
              Laporan
              <i class="right menu-arrow fa fa-angle-left"></i>
            </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url('report') ?>" class="nav-link <?php if ($breadcrumbs == 'report') {echo "active";}?>">
                <i class="far ti-arrow-circle-right nav-icon"></i> 
                <p>Kinerja CPL Mahasiswa</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('report/kinerja_cpmk_mahasiswa') ?>" class="nav-link <?php if ($breadcrumbs == 'report_kinerja_cpmk_mahasiswa') {echo "active";}?>">
                <i class="far ti-arrow-circle-right nav-icon"></i> 
                <p>Kinerja CPMK Mahasiswa</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('report/mahasiswa') ?>" class="nav-link <?php if ($breadcrumbs == 'report_mahasiswa') {echo "active";}?>">
                <i class="far ti-arrow-circle-right nav-icon"></i> 
                <p>Report Mahasiswa</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('report/mata_kuliah') ?>" class="nav-link <?php if ($breadcrumbs == 'report_mata_kuliah') {echo "active";}?>">
                <i class="far ti-arrow-circle-right nav-icon"></i> 
                <p>Report Matakuliah</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('report/relevansi_ppm') ?>" class="nav-link <?php if ($breadcrumbs == 'report_relevansi_ppm') {echo "active";}?>"> 
                <i class="far ti-arrow-circle-right nav-icon"></i> 
                <p>Relevansi PPM</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('report/efektivitas_cpl') ?>" class="nav-link <?php if ($breadcrumbs == 'report_efektivitas_cpl') {echo "active";}?>"> 
                <i class="far ti-arrow-circle-right nav-icon"></i> 
                <p>Efektifitas CPL</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('report/report_epbm') ?>" class="nav-link <?php if ($breadcrumbs == 'report_epbm') {echo "active";}?>">
                <i class="far ti-arrow-circle-right nav-icon"></i> 
                <p>Report EPBM</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item has-treeview">
            <a href="<?= base_url('perbaikanmatakuliah') ?>" class="nav-link <?php if (in_array($breadcrumbs, ['perbaikan'])) {echo "active";}?>">
            <i class="nav-icon menu-icon ti-files"></i>
            <p>
              Asesmen dan Tindak
            </p><br>
            &ensp;&ensp;&ensp;
            <p>Lanjut Perbaikan</p><br>
            &ensp;&ensp;&ensp;
            <p>Matakuliah</p>
            </a>
          </li>

          <li class="nav-item <?php if (in_array($breadcrumbs, ['data', 'data_cpmk'])) {echo "menu-open";}?>">
            <a href="#" class="nav-link <?php if (in_array($breadcrumbs, ['data', 'data_cpmk'])) {echo "active";}?>">
            <i class="nav-icon menu-icon ti-layers"></i>
            <p>
              Data
              <i class="right menu-arrow fa fa-angle-left"></i>
            </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url('data') ?>" class="nav-link <?php if ($breadcrumbs == 'data') {echo "active";}?>"> 
                <i class="far ti-arrow-circle-right nav-icon"></i> 
                <p>Data CPL</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('data/data_cpmk') ?>" class="nav-link <?php if ($breadcrumbs == 'data_cpmk') {echo "active";}?>"> 
                <i class="far ti-arrow-circle-right nav-icon"></i> 
                <p>Data CPMK Mahasiswa</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item has-treeview">
            <a href="<?= base_url('akun') ?>" class="nav-link <?php if (in_array($breadcrumbs, ['akun'])) {echo "active";}?>">
            <i class="nav-icon menu-icon ti-user"></i>
            <p>
              Akun Setting
            </p>
            </a>
          </li>

          <li class="nav-item has-treeview">
            <a href="<?= base_url('Auth/logout') ?>" class="nav-link" onclick="return confirm('apakah anda ingin Keluar ?')">
            <i class="nav-icon menu-icon ti-shift-left"></i>
            <p>
              Logout
            </p>
            </a>
          </li>

        </ul>
      </nav>


		<!-- /.navigation -->
	</div>
	<!-- /.content -->
</div>
</aside>
</div>


<!-- /.main-menu -->

<div class="fixed-navbar" <?php if ($breadcrumbs == 'kurikulum'){echo 'style="width: 3500px;"';} ?>>
	<div class="pull-left">
		<!-- <button type="button" class="menu-mobile-button glyphicon glyphicon-menu-hamburger js__menu_mobile"></button> -->
		<h1 class="page-title">DIPLOMACY: Sistem Asesmen OBE PS TIN</h1>
		<!-- /.page-title -->
	</div>
	<!-- /.pull-left -->
	<!-- /.pull-right -->
</div>
<!-- /.fixed-navbar -->

<!-- /#message-popup -->
<div >
	<div class="main-content" <?php if ($breadcrumbs == 'kurikulum'){echo 'style="width: 3500px;"';} ?>>
		<?= view($content); ?>

		<footer class="footer">
			<div class="row">
				<div class="col-lg-5 mb-3">
					<ul class="list-unstyled">
						<li class="mb-2">2021 © Departemen Teknologi Industri Pertanian</li>
					</ul>
				</div>
				<div class="col-6 col-lg-1 mb-3">
					<ul class="list-unstyled">
						<li class="mb-2"><a href="#">Privacy</a></li>
					</ul>
				</div>
				<div class="col-6 col-lg-1 mb-3">
					<ul class="list-unstyled">
						<li class="mb-2"><a href="#">Terms</a></li>
					</ul>
				</div>
				<div class="col-6 col-lg-1 mb-3">
					<ul class="list-unstyled">
						<li class="mb-2"><a href="#">Help</a></li>
					</ul>
				</div>
			</div>
		</footer>
	</div>
	<!-- /.main-content -->
</div><!--/#wrapper -->

<!-- Modal -->

<!-- jQuery -->
<script src="<?= base_url('Adminlte/plugins/jquery/jquery.min.js') ?>"></script>
<!-- Select2 -->
<script src="<?= base_url('Adminlte/plugins/select2/js/select2.full.min.js') ?>"></script>

<!-- Placed at the end of the document so the pages load faster -->
<script src="<?= base_url('scripts/template.min.js') ?>"></script>

<script src="<?= base_url('Adminlte/dist/js/adminlte.js') ?>"></script>


<script src="<?= base_url('Adminlte/dist/js/adminlte.js') ?>"></script>


<!-- Bootstrap 4 -->
<script src="<?= base_url('Adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<!-- overlayScrollbars -->
<script src="<?= base_url('Adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') ?>"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('Adminlte/dist/js/adminlte.min.js') ?>"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= base_url('Adminlte/dist/js/demo.js') ?>"></script>


<!-- DataTables -->
<script src="<?= base_url('Adminlte/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
<script src="<?= base_url('Adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js'); ?>"></script>

<!-- Page specific script -->
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

  })

  // DropzoneJS Demo Code End
</script>


<script>
        $(document).ready(function() {
            <?php if(session()->getFlashdata('success')): ?>
                toastr.success("<?= session()->getFlashdata('success'); ?>");
            <?php endif; ?>

            <?php if(session()->getFlashdata('error')): ?>
                toastr.error("<?= session()->getFlashdata('error'); ?>");
            <?php endif; ?>

            <?php if(session()->getFlashdata('warning')): ?>
                toastr.warning("<?= session()->getFlashdata('warning'); ?>");
            <?php endif; ?>

            <?php if(session()->getFlashdata('info')): ?>
                toastr.info("<?= session()->getFlashdata('info'); ?>");
            <?php endif; ?>
        });
</script>

	<script>

		
			
		function saveDeskriptor() {
			$("#formDeskriptor").submit();
		}

	$(document).ready(function() {
    if ($.fn.DataTable.isDataTable('#example2')) {
      $('#example2').DataTable().clear().destroy();
    }

    $('#example2').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
    });
  });

  $(document).ready(function() {
    if ($.fn.DataTable.isDataTable('#example3')) {
      $('#example3').DataTable().clear().destroy();
    }

    $('#example3').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
    });
  });
	</script>

<script>



  $(function () {

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })
    
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    });

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

  })
</script>

</body>
</html>
