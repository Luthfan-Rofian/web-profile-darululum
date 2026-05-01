<div class="modal fade" id="modalview">
    <div class="modal-dialog modal-lg box-shadow modal-dialog-scrollable">
        <div class="modal-content">

            <div class="card-header p-2">
                <h5 class="modal-title m-0"><?= $konfigurasi['judultawaran'] ?>
                    <button type="button" class="btn btn-sm btn-danger float-right btn-modal-close" data-dismiss="modal" aria-label="Close"><span>X</span></button>
                </h5>
            </div>

            <div class="modal-body">

                <img class="img-fluid" src="<?= base_url('public/img/konfigurasi/pimpinan/' . $konfigurasi['gbrtawaran']) ?>" alt="">
                <div class="p-3 text-justify">
                    <p>
                        <?= $konfigurasi['isitawaran'] ?>
                    </p>
                </div>
            </div>
            <div class="modal-footer p-1">
                <?php if ($konfigurasi['sts_tombol'] != 0) { ?>
                    <a href="<?= $konfigurasi['linktawaran'] ?>" class="btn btn-primary"><?= $konfigurasi['namatombol'] ?></a>
                <?php  } ?>

                <button type="button" class="btn btn-danger" data-dismiss="modal">Jangan tampilkan lagi</button>

            </div>
        </div>
    </div>
</div>