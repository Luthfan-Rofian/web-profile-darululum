<div class="modal fade" id="modallihat">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="card-header mt-0">
                <h6 class="modal-title m-0">View Partisipan

                </h6>
            </div>
            <?= form_open_multipart('', ['class' => 'formedit']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">

                <div class="row">
                    <div class="form-group col-md-4 col-12">
                        <label> <i class="mdi mdi-account"></i>
                            Nama
                        </label>
                        <input type="text" id="nama" name="nama" value="<?= $nama ?>" class="form-control form-control-sm bg-light" readonly>

                    </div>
                    <div class="form-group col-md-4 col-12">
                        <label> <i class="mdi mdi-account-key"></i>
                            NIK
                        </label>
                        <input type="text" id="nik" name="nik" value="<?= $nik ?>" class=" form-control form-control-sm bg-light" readonly>

                    </div>
                    <div class="form-group col-md-4 col-12">
                        <label> <i class="mdi mdi-text-shadow"></i>
                            Tempat Lahir
                        </label>
                        <input type="text" id="tempat_lahir" name="tempat_lahir" value="<?= $tempat_lahir ?>" class="form-control form-control-sm bg-light" readonly>

                    </div>
                </div>
                <div class="row">

                    <div class="form-group col-md-4 col-12">
                        <label> <i class="mdi mdi-calendar-range"></i>
                            Tanggal Lahir
                        </label>
                        <input type="text" id="tgl_lahir" name="tgl_lahir" value="<?= date_indo($tgl_lahir) ?>" class="form-control form-control-sm bg-light" readonly>

                    </div>
                    <div class="form-group col-md-4 col-12">
                        <label> <i class="mdi mdi-gender-male-female"></i>
                            Jenis Kelamin
                        </label>
                        <?php if ($jk == 'L') {
                            $jnskel = 'Laki-laki';
                        } else {
                            $jnskel = 'Perempuan';
                        } ?>
                        <input type="text" id="jk" name="jk" value="<?= $jnskel ?>" class="form-control form-control-sm bg-light" readonly>


                    </div>
                    <div class="form-group col-md-4 col-12">
                        <label> <i class="fas fa-tty"></i>
                            No HP
                        </label>
                        <input type="text" id="no_hp" name="no_hp" value="<?= $no_hp ?>" class=" form-control form-control-sm bg-light" readonly>

                    </div>
                </div>
                <div class="row">

                    <div class="form-group col-md-4 col-12">
                        <label> <i class="mdi mdi-text-shadow"></i>
                            RT/RW
                        </label>
                        <input type="text" id="rtrw" name="rtrw" value="<?= $rtrw ?>" class="form-control form-control-sm bg-light" readonly>

                    </div>
                    <div class="form-group col-md-4 col-12">
                        <label> <i class="mdi mdi-text-shadow"></i>
                            Provinsi
                        </label>
                        <input type="text" id="provinsi" name="provinsi" value="<?= $provinsi ?>" class="form-control form-control-sm bg-light" readonly>

                    </div>
                    <div class="form-group col-md-4 col-12">
                        <label> <i class="mdi mdi-text-shadow"></i>
                            Kabupaten
                        </label>
                        <input type="text" id="kab" name="kab" value="<?= $kab ?>" class=" form-control form-control-sm bg-light" readonly>

                    </div>
                </div>

                <div class="row">

                    <div class="form-group col-md-4 col-12">
                        <label> <i class="mdi mdi-text-shadow"></i>
                            Kecamatan
                        </label>
                        <input type="text" id="kec" name="kec" value="<?= $kec ?>" class="form-control form-control-sm bg-light" readonly>

                    </div>
                    <div class="form-group col-md-4 col-12">
                        <label> <i class="mdi mdi-text-shadow"></i>
                            Kelurahan
                        </label>
                        <input type="text" id="kel" name="kel" value="<?= $kel ?>" class=" form-control form-control-sm bg-light" readonly>

                    </div>
                    <div class="form-group col-md-4 col-12">
                        <label> <i class="mdi mdi-text-shadow"></i>
                            Pekerjaan
                        </label>
                        <input type="text" id="pekerjaan" name="pekerjaan" value="<?= $pekerjaan ?>" class="form-control form-control-sm bg-light" readonly>

                    </div>
                </div>

                <div class="row">

                    <div class="form-group col-md-6 col-12">
                        <label> <i class="mdi mdi-text-shadow"></i>
                            Pendidikan
                        </label>
                        <input type="text" id="pendidikan" name="pendidikan" value="<?= $pendidikan ?>" class=" form-control form-control-sm bg-light" readonly>

                    </div>
                    <div class="form-group col-md-6 col-12">
                        <label> <i class="mdi mdi-file-plus"></i>
                            File KTP
                        </label>
                        <?php if ($dok_ktp != '') { ?>
                            <label title="Untuk Ubah File ini klik di samping Nama di List Data Partisipan" class="form-control form-control-sm bg-light"><a target='_BLANK' href="<?= base_url('public/file/dokumen/'  . $dok_ktp) ?>"><?= $dok_ktp ?></a></label>
                        <?php } else { ?>
                            <label title="Untuk upload File KTP klik di samping Nama di List Data Partisipan" class="form-control form-control-sm bg-light"><a class="text-danger">File KTP Belum diupload</a></label>
                        <?php } ?>

                    </div>
                </div>


                <div class="form-group">
                    <label> <i class="mdi mdi-map-marker-multiple"></i>
                        Alamat
                    </label>
                    <textarea type="text" class="form-control form-control-sm bg-light " id="alamat" name="alamat" readonly><?= $alamat ?></textarea>

                </div>

                <div class="modal-footer p-0">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="ion-close"></i> Tutup</button>
                </div>
                <?php echo form_close() ?>

            </div>
        </div>
    </div>