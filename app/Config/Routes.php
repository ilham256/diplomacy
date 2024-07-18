<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::Login');
$routes->get('/coba/(:any)/(:num)', 'Coba::Index/$1/$2');

// Routes untuk Auth controller
$routes->get('Auth', 'Auth::index');
$routes->get('Auth/login', 'Auth::login');
$routes->post('Auth/login', 'Auth::login'); // Jika menggunakan metode POST untuk login
$routes->get('Auth/logout', 'Auth::logout');

// Routes untuk Dashboard controller
$routes->get('Dashboard', 'Dashboard::index');

$routes->get('DashboardDosen', 'DashboardDosen::index');
$routes->get('DashboardDosen/infumum', 'DashboardDosen::infumum');

$routes->get('DashboardGuest', 'DashboardGuest::index');
$routes->get('DashboardGuest/infumum', 'DashboardGuest::infumum');
$routes->get('DashboardGuest/kinumum', 'DashboardGuest::kinumum');
$routes->get('DashboardGuest/kincpmk', 'DashboardGuest::kincpmk');
$routes->get('DashboardGuest/kincpl', 'DashboardGuest::kincpl');

$routes->get('DashboardMahasiswa', 'DashboardMahasiswa::index');
$routes->get('DashboardMahasiswa/akun', 'DashboardMahasiswa::akun');
$routes->get('DashboardMahasiswa/edit_password', 'DashboardMahasiswa::edit_password');

$routes->get('DashboardOperator', 'Dashboard::index');

// Routes untuk Akun controller
$routes->get('akun', 'Akun::index');
$routes->get('akun/ganti_password', 'Akun::ganti_password');
$routes->post('akun/submit_ganti_password', 'Akun::submit_ganti_password');

// Routes untuk AkunDosen controller
$routes->get('akundosen', 'AkunDosen::index');
$routes->get('akundosen/ganti_password', 'AkunDosen::ganti_password');
$routes->post('akundosen/submit_ganti_password', 'AkunDosen::submit_ganti_password');

// Routes untuk AkunMahasiswa controller
$routes->get('akunmahasiswa', 'AkunMahasiswa::index');
$routes->get('akunmahasiswa/ganti_password', 'AkunMahasiswa::ganti_password');
$routes->post('akunmahasiswa/submit_ganti_password', 'AkunMahasiswa::submit_ganti_password');

// Routes untuk AkunOperator controller
$routes->get('akunoperator', 'AkunOperator::index');
$routes->get('akunoperator/ganti_password', 'AkunOperator::ganti_password');
$routes->post('akunoperator/submit_ganti_password', 'AkunOperator::submit_ganti_password');

// Routes untuk AnalisisEvaluasiGuest controller
$routes->get('analisisevaluasiguest/evaluasi_l', 'AnalisisEvaluasiGuest::evaluasi_l');
$routes->post('analisisevaluasiguest/evaluasi_l', 'AnalisisEvaluasiGuest::evaluasi_l'); // jika ada input form
$routes->get('analisisevaluasiguest/evaluasi_kinerja_cpl', 'AnalisisEvaluasiGuest::evaluasi_kinerja_cpl');
$routes->post('analisisevaluasiguest/evaluasi_kinerja_cpl', 'AnalisisEvaluasiGuest::evaluasi_kinerja_cpl'); // jika ada input form

$routes->get('cpltersimpan', 'CplTersimpan::index');
$routes->post('cpltersimpan', 'CplTersimpan::index');
$routes->get('cpltersimpan/tambah', 'CplTersimpan::tambah');
$routes->post('cpltersimpan/tambah', 'CplTersimpan::tambah');
$routes->post('cpltersimpan/simpan', 'CplTersimpan::simpan');
$routes->post('cpltersimpan/import', 'CplTersimpan::import');

$routes->get('cpltlang', 'Cpltlang::index');
$routes->post('cpltlang/import', 'Cpltlang::import');

$routes->get('cpmkcpl', 'CpmkCpl::index');
$routes->get('cpmkcpl/tambahcpl', 'CpmkCpl::tambahCpl');
$routes->post('cpmkcpl/tambahcpl', 'CpmkCpl::submitTambahCpl');
$routes->get('cpmkcpl/editcpl/(:num)', 'CpmkCpl::editCpl/$1');
$routes->post('cpmkcpl/editcpl', 'CpmkCpl::submitEditCpl');
$routes->get('cpmkcpl/hapuscpl/(:num)', 'CpmkCpl::hapusCpl/$1');

$routes->get('cpmkcpl/tambahcpmk', 'CpmkCpl::tambahCpmk');
$routes->post('cpmkcpl/tambahcpmk', 'CpmkCpl::submitTambahCpmk');
$routes->get('cpmkcpl/editcpmk/(:num)', 'CpmkCpl::editCpmk/$1');
$routes->post('cpmkcpl/editcpmk', 'CpmkCpl::submitEditCpmk');
$routes->get('cpmkcpl/hapuscpmk/(:num)', 'CpmkCpl::hapusCpmk/$1');

$routes->get('cpmkcpl/tambahdeskriptor/(:num)', 'CpmkCpl::tambahDeskriptor/$1');

// Custom routes for Cpmklang controller
$routes->get('/cpmklang', 'Cpmklang::index');
$routes->post('/cpmklang/import', 'Cpmklang::import');
$routes->get('/cpmklang/data_tersimpan', 'Cpmklang::data_tersimpan');

$routes->get('cpmktlang', 'Cpmktlang::index');
$routes->post('cpmktlang', 'Cpmktlang::index');
$routes->post('cpmktlang/import', 'Cpmktlang::import');

$routes->get('data', 'Data::index');
$routes->get('data/export_excel', 'Data::export_excel');
$routes->get('data/data_cpmk', 'Data::data_cpmk');

$routes->post('data/export_excel', 'Data::export_excel');
$routes->post('data', 'Data::index');
$routes->post('data/data_cpmk', 'Data::data_cpmk');

$routes->get('dosen', 'Dosen::index');
$routes->get('dosen/tambah', 'Dosen::tambah');
$routes->post('dosen/submit_tambah', 'Dosen::submit_tambah');
$routes->get('dosen/export_excel', 'Dosen::export_excel');
$routes->get('dosen/suksesSimpan', 'Dosen::suksesSimpan');

$routes->get('efektivitascpl', 'EfektivitasCpl::index');
$routes->post('efektivitascpl/import', 'EfektivitasCpl::import');

$routes->get('epbm', 'Epbm::index');
$routes->post('epbm/upload', 'Epbm::upload');
$routes->post('epbm/import', 'Epbm::import');

$routes->group('evaluasil', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('/', 'EvaluasiL::index');
    $routes->post('/', 'EvaluasiL::index');
    $routes->get('index2', 'EvaluasiL::index2');
    $routes->post('index2', 'EvaluasiL::index2');
    $routes->get('evaluasi_ketercapaian', 'EvaluasiL::evaluasi_ketercapaian');
    $routes->post('evaluasi_ketercapaian', 'EvaluasiL::evaluasi_ketercapaian');
    $routes->get('evaluasi_trend', 'EvaluasiL::evaluasi_trend');
    $routes->post('evaluasi_trend', 'EvaluasiL::evaluasi_trend');
    $routes->get('identifikasi/(:segment)', 'EvaluasiL::identifikasi/$1');
    $routes->get('evaluasikinerjacpl', 'EvaluasiL::evaluasikinerjacpl');
    $routes->post('evaluasikinerjacpl', 'EvaluasiL::evaluasikinerjacpl');
});

$routes->group('evaluasildosen', function ($routes) {
    $routes->get('/', 'EvaluasiLDosen::index');
    $routes->post('/', 'EvaluasiLDosen::index');
    $routes->get('evaluasi_kinerja_cpl', 'EvaluasiLDosen::evaluasiKinerjaCpl');
    $routes->post('evaluasi_kinerja_cpl', 'EvaluasiLDosen::evaluasiKinerjaCpl');
    $routes->get('evaluasi_kinerja_cpmk', 'EvaluasiLDosen::evaluasiKinerjaCpmk');
    $routes->post('evaluasi_kinerja_cpmk', 'EvaluasiLDosen::evaluasiKinerjaCpmk');
});

$routes->group('evaluasitl', function ($routes) {
    $routes->get('/', 'EvaluasiTl::index');
    $routes->post('/', 'EvaluasiTl::index');
});

$routes->group('evaluasitldosen', function ($routes) {
    $routes->get('/', 'EvaluasiTlDosen::index');
    $routes->post('/', 'EvaluasiTlDosen::index');
});

$routes->group('formula', function ($routes) {
    $routes->get('/', 'Formula::index');
    $routes->get('tambah', 'Formula::tambah');
    $routes->get('tambah_rumus_deskriptor/(:segment)', 'Formula::tambah_rumus_deskriptor/$1');
    $routes->post('submit_tambah', 'Formula::submit_tambah');
    $routes->get('edit/(:segment)', 'Formula::edit/$1');
    $routes->post('submit_edit', 'Formula::submit_edit');
    $routes->get('detail', 'Formula::detail');
    $routes->get('deskriptor', 'Formula::deskriptor');
    $routes->get('deskriptorn', 'Formula::deskriptorn');
    $routes->get('edit_rumus_deskriptor/(:segment)', 'Formula::edit_rumus_deskriptor/$1');
    $routes->post('submit_tambah_rumus_deskriptor', 'Formula::submit_tambah_rumus_deskriptor');
    $routes->post('submit_edit_rumus_deskriptor', 'Formula::submit_edit_rumus_deskriptor');
    $routes->get('hapus_rumus_deskriptor/(:segment)', 'Formula::hapus_rumus_deskriptor/$1');
    $routes->get('hapus_cpl/(:segment)', 'Formula::hapus_cpl/$1');
});

$routes->group('formula_deskriptor', function ($routes) {
    $routes->get('/', 'FormulaDeskriptor::index');
    $routes->get('tambah_formula_deskriptor/(:segment)', 'FormulaDeskriptor::tambah_formula_deskriptor/$1');
    $routes->post('submit_tambah_deskriptor', 'FormulaDeskriptor::submit_tambah_deskriptor');
    $routes->get('edit_deskriptor/(:segment)', 'FormulaDeskriptor::edit_deskriptor/$1');
    $routes->post('submit_edit_deskriptor', 'FormulaDeskriptor::submit_edit_deskriptor');
    $routes->get('detail', 'FormulaDeskriptor::detail');
    $routes->get('deskriptor', 'FormulaDeskriptor::deskriptor');
    $routes->get('deskriptorn', 'FormulaDeskriptor::deskriptorn');
    $routes->get('edit_formula_deskriptor/(:segment)', 'FormulaDeskriptor::edit_formula_deskriptor/$1');
    $routes->post('submit_tambah_formula', 'FormulaDeskriptor::submit_tambah_formula');
    $routes->post('submit_edit_formula_deskriptor', 'FormulaDeskriptor::submit_edit_formula_deskriptor');
    $routes->get('hapus_formula_deskriptor/(:segment)', 'FormulaDeskriptor::hapus_formula_deskriptor/$1');
    $routes->get('hapus_deskriptor/(:segment)', 'FormulaDeskriptor::hapus_deskriptor/$1');
});

$routes->group('infumum', function ($routes) {
    $routes->get('/', 'Infumum::index');
});

$routes->group('inputasesmenguest', function($routes) {
    $routes->get('kurikulum', 'InputAsesmenGuest::kurikulum');
    $routes->get('cpmk_cpl', 'InputAsesmenGuest::cpmkCpl');
    $routes->get('matakuliah', 'InputAsesmenGuest::matakuliah');
    $routes->get('profil_matakuliah', 'InputAsesmenGuest::profilMatakuliah');
    $routes->get('katkin', 'InputAsesmenGuest::katkin');
    $routes->get('formula', 'InputAsesmenGuest::formula');
    $routes->get('cpmklang', 'InputAsesmenGuest::cpmklang');
    $routes->get('cpmktlang', 'InputAsesmenGuest::cpmktlang');
    $routes->get('cpltlang', 'InputAsesmenGuest::cpltlang');
    $routes->get('efektivitas_cpl', 'InputAsesmenGuest::efektivitas_cpl');
    $routes->get('relevansi_ppm', 'InputAsesmenGuest::relevansi_ppm');
    $routes->get('epbm', 'InputAsesmenGuest::epbm');
});

$routes->group('katkin', function($routes) {
    $routes->get('/', 'Katkin::index');
    $routes->get('edit', 'Katkin::editKatkin');
    $routes->post('simpan', 'Katkin::simpanData');
    $routes->get('suksessimpan', 'Katkin::suksesSimpan');
});

$routes->group('kincpl', function($routes) {
    $routes->get('/', 'Kincpl::index');
});

$routes->group('kincpmk', function($routes) {
    $routes->get('/', 'Kincpmk::index');
});

$routes->group('kinumum', function($routes) {
    $routes->get('/', 'Kinumum::index');
});

$routes->group('kurikulum', function($routes) {
    $routes->get('/', 'Kurikulum::index');
});

$routes->group('mahasiswa', function($routes) {
    $routes->get('/', 'Mahasiswa::index');
    $routes->get('tambah', 'Mahasiswa::tambah');
    $routes->post('submitTambah', 'Mahasiswa::submitTambah');
    $routes->get('exportExcel', 'Mahasiswa::exportExcel');
    $routes->post('upload', 'Mahasiswa::upload');
    $routes->post('import', 'Mahasiswa::import');
    $routes->get('resetPassword', 'Mahasiswa::resetPassword');
    $routes->post('submitResetPassword', 'Mahasiswa::submitResetPassword');
});

$routes->group('matakuliah', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->get('/', 'Matakuliah::index');
    $routes->get('tambah', 'Matakuliah::tambah');
    $routes->post('submit_tambah', 'Matakuliah::submit_tambah');
    $routes->post('submit_edit', 'Matakuliah::submit_edit');
    $routes->get('detail', 'Matakuliah::detail');
    $routes->get('edit/(:segment)', 'Matakuliah::edit/$1');
    $routes->get('cetak_edit/(:segment)', 'Matakuliah::cetak_edit/$1');
    $routes->get('edit_matakuliah_has_cpmk/(:segment)', 'Matakuliah::edit_matakuliah_has_cpmk/$1');
    $routes->get('hapus/(:segment)', 'Matakuliah::hapus/$1');
    $routes->get('lihat_rps/(:segment)', 'Matakuliah::lihat_rps/$1');
    $routes->get('tambah_matakuliah_has_cpmk/(:segment)', 'Matakuliah::tambah_matakuliah_has_cpmk/$1');
    $routes->post('submit_tambah_matakuliah_has_cpmk', 'Matakuliah::submit_tambah_matakuliah_has_cpmk');
    $routes->post('submit_edit_matakuliah_has_cpmk', 'Matakuliah::submit_edit_matakuliah_has_cpmk');
    $routes->get('hapus_matakuliah_has_cpmk/(:segment)', 'Matakuliah::hapus_matakuliah_has_cpmk/$1');
});

$routes->group('perbaikanmatakuliah', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->get('/', 'PerbaikanMatakuliah::index');
    $routes->get('tambah', 'PerbaikanMatakuliah::tambah');
    $routes->post('submit_tambah', 'PerbaikanMatakuliah::submit_tambah');
    $routes->post('submit_edit', 'PerbaikanMatakuliah::submit_edit');
    $routes->get('edit/(:any)', 'PerbaikanMatakuliah::edit/$1');
    $routes->get('download/(:any)', 'PerbaikanMatakuliah::download/$1');
    $routes->get('hapus/(:any)', 'PerbaikanMatakuliah::hapus/$1');
    $routes->get('export_excel', 'PerbaikanMatakuliah::export_excel');
});

$routes->group('profilmatakuliah', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->get('/', 'ProfilMatakuliah::index');
});

$routes->group('relevansippm', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->get('/', 'RelevansiPpm::index');
    $routes->post('import', 'RelevansiPpm::import');
});

$routes->get('/report', 'Report::index');
$routes->get('/report/mahasiswa', 'Report::mahasiswa');
$routes->get('/report/kinerja_cpmk_mahasiswa', 'Report::kinerja_cpmk_mahasiswa');
$routes->post('/report/mahasiswa', 'Report::mahasiswa');
$routes->post('/report/kinerja_cpmk_mahasiswa', 'Report::kinerja_cpmk_mahasiswa');
$routes->post('/report/download_report_mahasiswa', 'Report::download_report_mahasiswa');

$routes->post('/report/download_report_mata_kuliah', 'Report::download_report_mata_kuliah');
$routes->get('/report/relevansi_ppm', 'Report::relevansi_ppm');
$routes->get('/report/efektivitas_cpl', 'Report::efektivitas_cpl');
$routes->get('/report/report_epbm', 'Report::report_epbm');

$routes->group('reportdosen', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->get('/', 'ReportDosen::index');
    $routes->get('mahasiswa', 'ReportDosen::mahasiswa');
    $routes->get('kinerja_cpmk_mahasiswa', 'ReportDosen::kinerja_cpmk_mahasiswa');
    $routes->get('download_report_mahasiswa', 'ReportDosen::download_report_mahasiswa');
    $routes->get('mata_kuliah', 'ReportDosen::mata_kuliah');
    $routes->get('download_report_mata_kuliah', 'ReportDosen::download_report_mata_kuliah');
    $routes->get('relevansi_ppm', 'ReportDosen::relevansi_ppm');
    $routes->get('efektivitas_cpl', 'ReportDosen::efektivitas_cpl');
    $routes->get('report_epbm_copy', 'ReportDosen::report_epbm_copy');
    $routes->get('report_epbm', 'ReportDosen::report_epbm');
});

$routes->group('reportguest', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->get('/', 'ReportDosen::index');
    $routes->get('mahasiswa', 'ReportDosen::mahasiswa');
    $routes->get('kinerja_cpmk_mahasiswa', 'ReportDosen::kinerja_cpmk_mahasiswa');
    $routes->get('download_report_mahasiswa', 'ReportDosen::download_report_mahasiswa');
    $routes->get('mata_kuliah', 'ReportDosen::mata_kuliah');
    $routes->get('download_report_mata_kuliah', 'ReportDosen::download_report_mata_kuliah');
    $routes->get('relevansi_ppm', 'ReportDosen::relevansi_ppm');
    $routes->get('efektivitas_cpl', 'ReportDosen::efektivitas_cpl');
    $routes->get('report_epbm_copy', 'ReportDosen::report_epbm_copy');
    $routes->get('report_epbm', 'ReportDosen::report_epbm');
});

$routes->group('reportmahasiswa', ['namespace' => 'App\Controllers'], function($routes) {
    // Route untuk method index
    $routes->get('/', 'ReportMahasiswa::index');

    // Route untuk method download_report_mahasiswa
    $routes->get('download', 'ReportMahasiswa::download_report_mahasiswa');
});

$routes->get('/user/admin', 'User::admin');
$routes->get('/user/admin/tambah', 'User::tambah_admin');
$routes->post('/user/admin/submit', 'User::submit_tambah_admin');
$routes->get('/user/admin/hapus/(:segment)', 'User::hapus_admin/$1');

$routes->get('/user/dosen', 'User::dosen');
$routes->get('/user/dosen/tambah', 'User::tambah_dosen');
$routes->post('/user/dosen/submit', 'User::submit_tambah_dosen');
$routes->get('/user/dosen/hapus/(:segment)', 'User::hapus_dosen/$1');

$routes->get('/user/mahasiswa', 'User::mahasiswa');
$routes->get('/user/mahasiswa/tambah', 'User::tambah_mahasiswa');
$routes->post('/user/mahasiswa/submit', 'User::submit_tambah_mahasiswa');
$routes->get('/user/mahasiswa/hapus/(:segment)', 'User::hapus_mahasiswa/$1');
