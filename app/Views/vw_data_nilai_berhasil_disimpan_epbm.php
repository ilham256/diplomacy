<div class="row small-spacing">
	<div class="col-lg-12 col-xs-12">
		<div class="box-content">

        <div class="row mb-3">
          <div class="col-md-6 col-sm-12">
            <div> 
              <hr>
               Data Evaluasi Proses Belajar Mengajar (EPBM) Dosen Berhasil Tersimpan
              <hr>

              <table id="example2" class="table table-bordered table-striped" style="width:100%">
                <thead>
                  <tr>
                    <th>Kode Mk_NIP</th>
                    <th>Tahun</th>
                    <th>Semester</th>
                    <th>Kode PSD</th>
                    <th>Nilai</th>
                    
                  </tr>
                </thead>
                <tbody>
                            <?php $i = 1; foreach($datas_epbm_dosen as $r) { ?>
                            <?php if($r['kode_epbm_mk_has_dosen'] != 0) { ?>
                            <tr>                                
                                <td><?php echo $r['kode_epbm_mk_has_dosen'] ; ?></td>
                                <td><?php echo $r['tahun'] ; ?></td>
                                <td><?php echo $r['semester'] ; ?></td>
                                <td><?php echo $r['kode_psd'] ; ?></td>
                                <td><?php echo $r['nilai'] ; ?></td>                                
                            </tr>
                            <?php } ?>
                            <?php $i++; } ?>

                </tbody>
              </table>

            </div>

          </div> 
          <div class="col-md-6 col-sm-12">
            <div> 
              <hr>
               Data Evaluasi Proses Belajar Mengajar (EPBM) MK Berhasil Tersimpan
              <hr>

              <table id="example3" class="table table-bordered table-striped" style="width:100%">
                <thead>
                  <tr>
                    <th>Kode Mk</th>
                    <th>Tahun</th>
                    <th>Semester</th>
                    <th>Kode PSD</th>
                    <th>Nilai</th>
                    
                  </tr>
                </thead>
                <tbody>
                            <?php $i = 1; foreach($datas_epbm_mk as $r) { ?>
                            <tr>
                                <td><?php echo $r['kode_epbm_mk'] ; ?></td>
                                <td><?php echo $r['tahun'] ; ?></td>
                                <td><?php echo $r['semester'] ; ?></td>
                                <td><?php echo $r['kode_psd'] ; ?></td>
                                <td><?php echo $r['nilai'] ; ?></td>


                                
                            </tr>
                            <?php $i++; } ?>

                </tbody>
              </table>

            </div>

          </div>

        </div>

		
		</div>
		<!-- /.box-content -->
	</div>
	<!-- /.col-lg-9 col-xs-12 -->
</div>
 