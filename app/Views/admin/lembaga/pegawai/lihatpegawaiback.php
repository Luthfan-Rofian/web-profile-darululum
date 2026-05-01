<div class="modal fade" id="modallihat">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="card-header mt-0">
                <h6 class="modal-title m-0"><?= $title  ?>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h6>
            </div>

            <?= form_open_multipart('', ['class' => 'formedit']) ?>
            <?= csrf_field(); ?>

            <div class="modal-body">
                <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#profil" role="tab">Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#lainlain" role="tab">Lain-lain</a>
                    </li>

                </ul>
                <div class="tab-content">

                    <div class="tab-pane active" id="profil" role="tabpanel">
                        <p></p>
                        <table class="table table-sm table-hover table-striped p-1">

                            <tr>
                                <th width="160" rowspan="8">

                                    <center>
                                        <img src="<?= base_url('/public/img/informasi/pegawai/' . $gambar) ?>" alt="Profil" class="img-fluid p-0">
                                    </center>

                                    <div class="p-1 text-secondary text-center">
                                        <?php if ($filetupoksi != '') { ?>
                                            <a href="<?= base_url('/public/img/informasi/pegawai/' . $filetupoksi) ?>" target="_blank">
                                                <span class="badge badge-success" title="Klik untuk lihat" style="font-size:13px"> Lihat Tupoksi &raquo;
                                                </span>
                                            </a>
                                        <?php } ?>

                                    </div>
                                </th>
                            </tr>
                            <tr>
                                <td class="p-1"><b>Nama</b></td>
                                <td class="p-1"><b>:</b></td>
                                <td class="p-1"><b><?= $nama ?></b></td>
                            </tr>
                            <tr>
                                <td class="p-1">NIP</td>
                                <td class="p-1">:</td>
                                <td class="p-1"><?= $nip ?></td>
                            </tr>
                            <tr>
                                <td class="p-1" width="22%">Tempat Tanggal Lahir</td>
                                <td class="p-1" width="2%">:</td>
                                <td class="p-1"><?= $tempat_lahir ?>, <?= date_indo($tgl_lahir) ?></td>
                            </tr>
                            <tr>
                                <td class="p-1">Jenis Kelamin</td>
                                <td class="p-1">:</td>
                                <td class="p-1"><?= $jk ==  'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                            </tr>
                            <tr>
                                <td class="p-1">Agama</td>
                                <td class="p-1">:</td>
                                <td class="p-1"><?= $agama ?></td>
                            </tr>
                            <tr>
                                <td class="p-1">Pangkat Golongan</td>
                                <td class="p-1">:</td>
                                <td class="p-1"><?= $pangkat ?></td>
                            </tr>
                            <tr>
                                <td class="p-1">Jabatan</td>
                                <td class="p-1" width="2">:</td>
                                <td class="p-1" width="50%"><?= $jabatan ?></td>
                            </tr>

                        </table>

                    </div>

                    <div class="tab-pane" id="lainlain" role="tabpanel">
                        <p></p>

                        <div class="row">
                            <div class="form-group col-md-6 col-12">
                                <label> <i class="mdi mdi-home-map-marker"></i>
                                    Asal S1
                                </label>
                                <input type="text" id="asal_s1" name="asal_s1" value="<?= $asal_s1 ?>" class="form-control" readonly>

                            </div>

                            <div class="form-group col-md-6 col-12">
                                <label> <i class="mdi mdi-home-map-marker"></i>
                                    Asal S2
                                </label>
                                <input type="text" id="asal_s2" name="asal_s2" value="<?= $asal_s2 ?>" class=" form-control" readonly>

                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 col-12">
                                <label> <i class="mdi mdi-home-map-marker"></i>
                                    Asal S3
                                </label>
                                <input type="text" id="asal_s3" name="asal_s3" value="<?= $asal_s3 ?>" class="form-control" readonly>

                            </div>

                            <div class="form-group col-md-6 col-12">
                                <label> <i class="mdi mdi-book-multiple-variant"></i>
                                    Bidang Kepakaran
                                </label>
                                <input type="text" id="bidang_pakar" name="bidang_pakar" value="<?= $bidang_pakar ?>" class=" form-control" readonly>

                            </div>
                        </div>

                        <div class="form-group">
                            <label> <i class="mdi mdi-account"></i>
                                Biodata Singkat
                            </label>
                            <textarea type="text" class="form-control form-control-sm" id="bio_singkat" name="bio_singkat" readonly><?= esc($bio_singkat) ?></textarea>
                        </div>
                    </div>

                </div>

            </div>

            <div class="modal-footer p-0">

                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="ion-close"></i> Tutup</button>
            </div>
            <?php echo form_close() ?>

        </div>

    </div>

</div>