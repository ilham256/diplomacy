<div class="row small-spacing">
	<div class="col-lg-12 col-xs-12">
		<div class="box-content bordered primary">
			<h4 class="box-title">Tambah User Mahasiswa</h4>
			<form role="form" method="post" action="<?= base_url("user/submit_tambah_mahasiswa")  ?>">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Username</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Masukan Username" name="username" maxlength="50" minlength="2" required >
                  </div>
                  <br>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Masukan Email" name="email" maxlength="50" minlength="2" required >
                  </div>
                  <br>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Password</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Masukan Password" name="password" maxlength="50" minlength="2" required >
                  </div>
                  <br>

                  <button type="submit" class="btn btn-primary" name="simpan" value="simpan">Simpan</button>
                </div>
            </form> 
			<br>

		</div>
		<!-- /.box-content -->
	</div>

</div> 
