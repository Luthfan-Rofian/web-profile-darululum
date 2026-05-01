<?php
$db = \Config\Database::connect();
$konfigurasi = $db->table('tbl_setaplikasi')->where('id_setaplikasi', '1')->get()->getRowArray();
?>
<div class="modal fade" id="modalview" tabindex="-1" aria-labelledby="modalviewLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="card-header p-1">
                <h6 class="modal-title mt-1"><?= $title  ?>
                    <!-- <?php if ($konfigurasi['verbost'] == 0) { ?>
                        <button type="button" class="btn btn-sm btn-danger float-right btn-modal-close" data-dismiss="modal" aria-label="Close"><span>X</span></button>
                    <?php } else { ?>
                        <button type="button" class="btn btn-sm btn-danger float-right btn-modal-close" data-bs-dismiss="modal" aria-label="Close"><span>X</span></button>
                    <?php } ?> -->
                </h6>
            </div>
            <div class="modal-body">
                <!-- <div class=""> -->
                <table class="table table-hover p-0">
                    <tbody>
                        <?php foreach ($poljawab as $p) :
                            $prosentase = sprintf("%2.1f", (($p['rating'] / $jumpol) * 100));
                        ?>
                            <tr>
                                <td width="200"><?= $p['pilihan'] ?> <a class="text-danger">(<code><?= $p['rating'] ?></code>)</td>
                                <td>
                                    <div class="progress  p-0" style="height: 20px;">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated p-0" role="progressbar" style="width: <?= $prosentase ?>%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"><?= $prosentase ?>%</div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="2"> <b>Jumlah Responden :</b> <a class="text-danger"> <?= $jumpol ?></a> </b></td>
                        </tr>
                    </tbody>
                </table>
                <!-- </div> -->
            </div>
            <div class="modal-footer p-1">

                <?php if ($konfigurasi['verbost'] == 0) { ?>
                    <a class="d-inline float-left btn btn-danger" data-dismiss="modal">Tutup</a>
                <?php } else { ?>
                    <a class="float-left btn btn-danger" data-bs-dismiss="modal">Tutup</a>
                <?php } ?>
            </div>
        </div>
    </div>
</div>