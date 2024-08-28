<div class="row small-spacing">
	<div class="col-lg-12 col-xs-12">
		<div class="box-content">
			<h4 class="box-title">Laporan</h4> 
			<ul class="nav nav-tabs" id="myTabs" role="tablist">
				<li class="nav-item" role="presentation">
					<a href="<?php echo site_url('report')?>" ><button class="nav-link">Kinerja CPL Mahasiswa</button></a>
				</li>
				<li class="nav-item" role="presentation">
					<a href="<?php echo site_url('report/kinerja_cpmk_mahasiswa')?>" ><button class="nav-link">Kinerja CPMK Mahasiswa</button></a>
				</li> 
				<li class="nav-item" role="presentation">
					<a href="<?php echo site_url('report/mahasiswa')?>" ><button class="nav-link active" id="cpl-tab" data-bs-toggle="tab" data-bs-target="#cpl" type="button" role="tab" aria-controls="cpl" aria-selected="true">Rapor Mahasiswa</button></a>
				</li>
				<li class="nav-item" role="presentation">
					<a href="<?php echo site_url('report/mata_kuliah')?>" ><button class="nav-link">Rapor Mata Kuliah</button></a>
				</li>
				<li class="nav-item" role="presentation">
					<a href="<?php echo site_url('report/relevansi_ppm')?>" ><button class="nav-link">Relevansi PPM</button></a>
				</li>
				<li class="nav-item" role="presentation">
					<a href="<?php echo site_url('report/efektivitas_cpl')?>" ><button class="nav-link">Efektivitas CPL</button></a>
				</li>
				<li class="nav-item" role="presentation">
					<a href="<?php echo site_url('report/report_epbm')?>" ><button class="nav-link">Rekap EPBM</button></a>
				</li> 
			</ul>
			<div class="tab-content" id="myTabContent">
				<div class="row mb-3">
							<form role="form" id="contactform" action="<?php echo site_url('report/mahasiswa')?>" method="post">
							<div class="input-group">
								<label for="mata_kuliah" class="col-sm-3 col-form-label">Silahkan Masukkan NIM</label>
								<div class="col-sm-6">
									<select id="nim_2" class="form-control select2" name="nim_2" required>
										<option value="" style="background: lightblue;" selected disabled>- Mahasiswa -</option>
										<?php $i = 1; foreach($dt_mahasiswa_2 as $d) { ?>
										<option value="<?php echo $d['Nim']; ?>"><?php echo $d['Nim'].' - '.$d['Nama'].' - smt('.$d['SemesterMahasiswa'].') - stat('.$d['StatusAkademik'].')'; ?></option>
										<?php $i++; } ?>
									</select>				
								</div>
								<button type="submit" class="btn btn-primary" name="pilih_2" value="pilih_2">Pilih</button>
							</div> 
							</form>
							<div>

							</div>
						
					</div>
					<div class="row small-spacing">
						<div class="col-xs-12">
							<div class="invoice-box" style="font-style: 'calibri'; ">
								<a href="<?php echo base_url('images/logo_raport_ipb.JPG')?>" class="lightview" data-lightview-group="group">
										<img src="<?php echo base_url('images/logo_raport_ipb.JPG')?>" alt="">
								</a>
								<div class="row">
									<div class="col-md-12 col-xs-12" style="color: darkblue; font-size: 24px;">
										<p><strong>INSTITUT PERTANIAN BOGOR<br>
										DEPARTEMEN TEKNOLOGI INDUSTRI PERTANIAN<br>
										P.S. TEKNIK INDUSTRI PERTANIAN
										<br><br>
										</strong>
										</p>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6 col-xs-12" style='font-weight: bold; color: darkblue;'>
										Nama Lengkap
									</div>
									<div class="col-md-6 col-xs-12" style='font-weight: bold; color: darkblue;'>
										Tempat, Tanggal Lahir
									</div>
								</div>
								<div class="row">
									<div class="col-md-6 col-xs-12" style='font-weight: bold; color: grey;'>
										<?php echo $nama_rapor_mahasiswa; ?>
									</div>
									<div class="col-md-6 col-xs-12" style='font-weight: bold; color: grey;'>
										-
									</div>
								</div>
								<br>
								<div class="row">
									<div class="col-md-6 col-xs-12" style='font-weight: bold; color: darkblue;'>
										Nomor Induk Mahasiswa
									</div>
									<div class="col-md-6 col-xs-12" style='font-weight: bold; color: darkblue;'>
										Tahun Masuk
									</div>
									
								</div>
								<div class="row">
									<div class="col-md-6 col-xs-12" style='font-weight: bold; color: grey;'>
										<?php echo $nim_rapor_mahasiswa; ?>
									</div>
									<div class="col-md-6 col-xs-12" style='font-weight: bold; color: grey;'>
										-
									</div>
								</div> 
								<br>
								<table class="table"> 
									<thead style="background-color: darkblue; color: white; vertical-align: middle; ">
										<tr>
											<th style='font-weight: normal;'>Capaian Pembelajaran Lulusan</th>
											<th style='font-weight: normal;'>Deskripsi</th> 
											<th style='font-weight: normal; width : 100px; text-align: center;'>Nilai</th> 
											<th style='font-weight: normal;'>Pencapaian</th> 
										</tr> 
									</thead>  
									<tbody > 

										<?php for ($i=0; $i < count($data_cpl); $i++) { ?>
										<tr> 
											<th scope="row"><?php  echo substr($data_cpl[$i]->nama,-1); ?></th> 
											<td style="text-align: justify; "><p><?php  echo ($data_cpl[$i]->deskripsi); ?></p></td> 
											<td style="text-align: center; "><?php echo ($nilai_cpl_mahasiswa[$i]); ?></td> 
											<td><?php echo $status_nilai_cpl_mahasiswa[$i]; ?></td> 
										</tr> 
										<?php } ?>
									</tbody>  
								</table>
								<div class="float-end margin-top-50">

									<form role="form" id="contactform" action="<?php echo site_url('report/download_report_mahasiswa')?>" method="post" target="_blank">

										<input type="hidden" name="nim_2" value="<?php echo $nim_rapor_mahasiswa; ?>">

										<button onclick="return confirm('Apakah anda ingin mencetak report ?')" type="submit" class="btn btn-default waves-effect waves-light" name="download" value="download"><i class='fa fa-download'></i> Download</button>

									</form>

									
								</div>
							</div>
							<!-- /.invoice-box -->
							<p><?php  //echo '<pre>';  var_dump($data_cpl); echo '</pre>';?></p>
						</div>
						<!-- /.col-xs-12 -->
					</div>
				
				
			</div>
		<!-- /.box-content -->
	</div>
	<!-- /.col-lg-9 col-xs-12 -->
</div>

<!-- chart.js Chart -->


 


<?php  //echo '<pre>';  var_dump($mk_cpmk[0]); echo '</pre>';?>