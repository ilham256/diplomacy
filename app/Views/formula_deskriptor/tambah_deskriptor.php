<div class="row small-spacing">
	<div class="col-lg-12 col-xs-12">
		<div class="box-content">


			            <div class="card card-primary">
              <div class="card-header" >
                <h3 class="card-title" >Tambah Deskriptor</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" method="post" action="<?php echo site_url('formuladeskriptor/submit_tambah_deskriptor') ?>" enctype="multipart/form-data">
	                <div class="card-body">

	                		<div class="form-group">
			                    <label for="exampleInputEmail1">Kode CPL</label>
			                    <input type="text" class="form-control" id="exampleInputEmail1" value="<?= $data[0]->id_cpl_langsung ?>" disabled >
			                    <input type="hidden" name="id_cpl" value="<?= $data[0]->id_cpl_langsung ?>">
			                </div>
			                  <br>
			                <div class="form-group">
			                    <label for="exampleInputEmail1">Nama CPL</label>
			                    <input type="text" class="form-control" id="exampleInputEmail1"  name="nama_cpl" value="<?= $data[0]->nama ?>" disabled>
			                </div>
			                  <br>
			                <div class="form-group">
			                    <label for="exampleInputEmail1">Nama Deskriptor</label>
			                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Masukkan Nama Deskriptor" name="nama">
			                </div>
			                  <br>
			                <div class="form-group"> 
			                    <label for="exampleInputEmail1">Deskripsi</label>
			                    
			                    <textarea class="form-control" rows="3" id="text" placeholder="Enter ..." name="deskripsi"></textarea>
			                </div>			                  
			                  <br>			                  
			                <div class="form-group">
			                    <label for="exampleInputEmail1">Persentasi/Bobot</label>

			                    <input type="number" class="form-control" name="persentasi" placeholder="0.00" required name="price" min="0" value="0" step="0.01" title="Currency" pattern="^\d+(?:\.\d{1,2})?$" onblur="this.parentNode.parentNode.style.backgroundColor=/^\d+(?:\.\d{1,2})?$/.test(this.value)?'inherit':'red'">
			                </div>
			                  <br>


                  </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" name="simpan" value="simpan" onclick="return confirm('simpan data ?')">Simpan</button>
                </div>
              </form>


            </div>

		</div>
		
	</div>

</div> 
