<?php
$db = \Config\Database::connect();
$konfigurasi = $db->table('tbl_setaplikasi')->where('id_setaplikasi', '1')->get()->getRowArray();
?>
<div class="modal fade" id="modalview">
    <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="card-header mt-0">
                <h6 class="modal-title"><?= $title  ?>
                </h6>
            </div>

            <div class="modal-body">
                <!-- <div class="form-group row"> -->
                <img id='img_load' width='100%' src='<?= base_url('public/img/informasi/agenda/' . $gambar) ?>'>
                <!-- </div> -->
                <!-- <div class="table-responsivex"> -->
                <table class="table table-bordered table-hover table-striped">
                    <tbody>
                        <tr>
                            <td colspan="2"><strong><?= $tema ?></strong></td>
                        </tr>
                        <tr>
                            <td colspan="2"><?= $isi ?></td>
                        </tr>
                        <tr>
                            <td>Tanggal</td>
                            <td>Mulai <b><?= date_indo($tgl_mulai) ?></b> sampai dengan <b><?= date_indo($tgl_selesai) ?></b></td>
                        </tr>
                        <tr>
                            <td>Tempat</td>
                            <td><strong><?= $tempat ?></strong></td>
                        </tr>
                        <tr>
                            <td>Jam</td>
                            <td><strong><?= $jam ?></strong></td>
                        </tr>
                        <tr>
                            <td>Pengirim / Penyelenggara</td>
                            <td><strong><?= $pengirim ?></strong></td>
                        </tr>

                    </tbody>
                </table>
                <!-- </div> -->

            </div>

            <p class="p-1 mb-1 mt-1">
                <?php if ($konfigurasi['verbost'] == 0) { ?>
                    <a class="ml-3 btn btn-danger" type="button" data-dismiss="modal">Tutup</a>
                <?php } else { ?>
                    <a class="ml-3 btn btn-danger" data-bs-dismiss="modal">Tutup</a>
                <?php } ?>
            </p>

            <!-- <a class="float-left btn btn-danger" type="button" data-dismiss="modal">Tutupkan</a> -->



        </div>

    </div>
</div>