<?php
$db = \Config\Database::connect();
$konfigurasi = $db->table('tbl_setaplikasi')->where('id_setaplikasi', '1')->get()->getRowArray();
?>
<div class="modal fade" id="modalview">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="card-header mt-0">
                <h6 class="modal-title m-0"><?= $ket ?>
                </h6>
            </div>


            <div class="modal-body">
                <!-- <div class="form-group row"> -->
                <img width='100%' src='<?= base_url('public/img/informasi/infografis/' . $banner) ?>'>
                <!-- </div> -->
                <!-- <table class="table table-bordered table-hover table-striped">
                    <tbody>
                        <tr>
                            <td colspan="2"><strong><?= $ket ?></strong></td>
                        </tr>
                    </tbody>
                </table> -->


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