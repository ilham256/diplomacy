<div class="row small-spacing">
	<div class="col-lg-12 col-xs-12">
		<div class="box-content">
  
 
			            <div class="card card-primary">
              <div class="card-header" >
                <h3 class="card-title" >Edit Dosen</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" method="post" action="<?php echo site_url('dosen/submit_edit') ?>" enctype="multipart/form-data">
	            <div class="card-body">
	                		<input type="hidden" name="nip" value="<?= $data[0]['NIP']; ?>">
	                		  <div class="form-group">
			                    <label for="exampleInputEmail1">NIP</label>
			                    <input type="text" class="form-control" id="exampleInputEmail1" disabled value="<?= $data[0]['NIP']; ?>">
			                  </div>
		                    <div class="form-group">
		                      <label for="exampleInputEmail1">Nama Dosen</label>
		                      <input type="text" class="form-control" id="exampleInputEmail1" name="nama" value="<?= $data[0]['nama_dosen']; ?>" maxlength="64" minlength="2" required>
		                    </div>
                  </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" name="simpan" value="simpan">Simpan</button>
                </div>
              </form>


            </div>

		</div>
		
	</div>

</div>
