<div class="row small-spacing">
    <div class="col-lg-12 col-xs-12">
        <div class="box-content">
            <h4 class="box-title">Mata Kuliah</h4>
            <div class="form-group">
                <div class="text-right">
                    <a class="btn btn-info waves-effect waves-light" href="<?= base_url('matakuliah/tambah') ?>"> + Mata Kuliah</a>
                </div>
                <br>
            </div>
            <div class="row mb-3">
                <label for="semester" class="col-sm-3 col-form-label">Silahkan Pilih Semester</label>
                <div class="col-sm-3">
                    <form role="form" id="contactform" action="<?= base_url('matakuliah') ?>" method="post">
                        <div class="input-group">
                            <select class="form-control select" name="semester">
                                <option value="1">- Pilih Semester - </option>
                                <?php foreach ($data_semester as $d) { ?>
                                    <option value="<?= $d->id_semester; ?>"><?= $d->id_semester; ?></option>
                                <?php } ?>
                            </select>
                            <button type="submit" class="btn btn-primary" name="pilih" value="pilih">Pilih</button>
                        </div>
                    </form>
                </div>
            </div>
            <br>
            <table id="example-edit" class="display" style="width: 100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode TM-2018</th>
                        <th>Kode TM-2019</th> 
                        <th>Kode K-2020</th> 
                        <th>Mata Kuliah</th> 
                        <th>SKS</th> 
                        <th>Semester</th> 
                        <th>RPS</th> 
                        <th></th> 
                    </tr>  
                </thead> 
                <tfoot> 
                    <tr>
                        <th>#</th>
                        <th>Kode TM-2018</th>
                        <th>Kode TM-2019</th> 
                        <th>Kode K-2020</th> 
                        <th>Mata Kuliah</th> 
                        <th>SKS</th> 
                        <th>Semester</th>
                        <th>RPS</th> 
                        <th></th> 
                    </tr>  
                </tfoot>
                <tbody> 
                    <?php $i = 1; foreach ($datas as $r) { ?>
                        <tr>
                            <td scope="row"><?= $i; ?></td>
                            <td><span class="label label-success"><?= $r->nama_kode; ?></span></td>
                            <td><span class="label label-success"><?= $r->nama_kode_2; ?></span></td>
                            <td><span class="label label-success"><?= $r->nama_kode_3; ?></span></td>
                            <td><a href="<?= base_url('matakuliah/edit/' . $r->kode_mk); ?>"><i class="fa " title="Edit Mata Kuliah"> <?= $r->nama_mata_kuliah; ?> </i></a></td>
                            <td><?= $r->sks; ?></td>
                            <td><?= $r->id_semester; ?></td>
                            <td><a href="<?= base_url('uploads/' . $r->rps) ?>" target="_blank">Lihat</a></td>
                            <td>
                                <a onclick="return confirm('apakah anda ingin menghapus data')" href="<?= base_url('matakuliah/hapus/' . $r->kode_mk); ?>"><i class="fa fa-trash" title="Hapus Data produk"></i></a>
                            </td>
                        </tr>
                    <?php $i++; } ?>
                </tbody> 
            </table>
        </div>
    </div>
</div>
