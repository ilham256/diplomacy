<div class="row small-spacing">
	<div class="col-lg-12 col-xs-12">
		<div class="box-content">




          <div class="card card-success">

              <div class="card-header">
                  <h3 class="card-title">
                      Update Data Mahasiswa dari Excel
                  </h3>
              </div>

              <div class="card-body">

                  <p class="mb-3">
                      Download format Excel terlebih dahulu, isi data mahasiswa,
                      lalu upload kembali file yang sudah diisi.
                  </p>

                  <form action="<?= base_url('mahasiswa/submitTambahExcel') ?>"
                        method="post" 
                        enctype="multipart/form-data">

                      <?= csrf_field(); ?>

                      <div class="form-group">

                          <a href="<?php echo site_url('mahasiswa/downloadTemplateTambah') ?>"
                             class="btn btn-success mb-3">

                              <i class="fas fa-download"></i>
                              Download Format Excel

                          </a>

                      </div>

                      <div class="form-group">

                          <label>Upload File Excel</label>

                          <input type="file"
                                 name="file"
                                 id="input-file-to-destroy"
                                 class="form-control"
                                 accept=".xls,.xlsx"
                                 required>

                      </div>

                      <button type="submit"
                              class="btn btn-primary">

                          <i class="fas fa-upload"></i>
                          Upload Data

                      </button>

                  </form>

              </div> 

          </div>

          <div class="card card-primary">
              <div class="card-header" >
                <h3 class="card-title" >Update Data Mahasiswa dari Data Pusat</h3>
              </div> 
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" method="post" action="<?php echo site_url('mahasiswa/submitTambah') ?>" enctype="multipart/form-data">
                  <div class="card-body">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Tahun Angkatan</label>
                      <input type="number" class="form-control" id="exampleInputEmail1" placeholder="Masukan Tahun angkatan yang ingin di update" name="tahun">
                    </div>

                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" name="simpan" value="simpan" onclick="return confirm('apakah anda ingin update data ?')" >Update</button>
                </div>
              </form>


            </div>

		</div>
		
	</div>

</div>
 