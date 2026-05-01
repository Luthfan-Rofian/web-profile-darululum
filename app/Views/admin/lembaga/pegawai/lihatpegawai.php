<div class="modal fade" id="modallihat">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="card-header mt-0">
                <h6 class="modal-title m-0"><?= $title ?> </h6>
            </div>

            <div class="modal-body">
                <table class="table table-sm table-hover table-striped p-0">

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

            <p class="p-1 mb-1">
                <?php if ($konfigurasi['verbost'] == 0) { ?>
                    <a class="ml-3 btn btn-danger" type="button" data-dismiss="modal">Tutup</a>
                <?php } else { ?>
                    <a class="ml-3 btn btn-danger" data-bs-dismiss="modal">Tutup</a>
                <?php } ?>
            </p>
        </div>

    </div>

</div>