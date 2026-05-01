<?php
$db = \Config\Database::connect();
$konfigurasi = $db->table('tbl_setaplikasi')->where('id_setaplikasi', '1')->get()->getRowArray();
?>
<div class="modal fade" id="modalview">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">

        <div class="modal-content">
            <div class="card-header p-1">
                <h6 class="modal-title mt-1"><?= $title  ?>

                </h6>
            </div>
            <div class="modal-body">
                <!-- <div class="form-group row"> -->
                <img id='img_load' width='100%' src='<?= base_url('public/img/informasi/pengumuman/' . $gambar) ?>'>
                <!-- </div> -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <tbody>
                            <tr>
                                <td colspan="2"><strong><?= $nama ?></strong></td>
                            </tr>
                            <tr>
                                <td colspan="2"><?= $isi_informasi ?></td>
                            </tr>
                            <?php if ($fileunduh != '') { ?>
                                <tr>
                                    <td colspan="2" class="text-center">
                                        <a href="<?= base_url('public/unduh/pengumuman/'  . $fileunduh) ?>" target="_blank" class="ml-3 btn btn-success" type="button">Download File</a>
                                        <!-- <a href="<?= base_url('public/unduh/pengumuman/'  . $fileunduh) ?>" target="_blank"><button class="btn btn-success btn-sm"><i class="fas fa-download"></i> Unduh File</button></a> -->
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

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