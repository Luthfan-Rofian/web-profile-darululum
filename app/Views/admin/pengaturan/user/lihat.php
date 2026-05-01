<div class="modal fade" id="modallihat">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="card-header mt-0">
                <h6 class="modal-title m-0">Postingan <?= $fullname ?>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h6>
            </div>
            <?= form_open_multipart('', ['class' => 'formfoto']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <input type="hidden" value="<?= $id ?>" name="id">


                <div class="table-responsive p-0">
                    <table class="table table-striped table-hover tabel-rincian" id="listkel">
                        <tbody>
                            <tr>
                                <td class="p-1" width="50%">Jumlah Berita/Artikel</td>
                                <td class="p-1" width="2%">:</td>
                                <td class="p-1"><?= $berita ?></td>
                            </tr>
                            <tr>
                                <td class="p-1">Jumlah Layanan</td>
                                <td class="p-1">:</td>
                                <td class="p-1"><?= $totlayanan ?></td>
                            </tr>
                            <?php if ($bankdata) {
                                $bankdata = $bankdata['bankdata_id'];
                            } else {
                                $bankdata = 0;
                            } ?>
                            <tr>
                                <td class="p-1">Jumlah Bank Data</td>
                                <td class="p-1">:</td>
                                <td class="p-1"><?= $bankdata ?></td>
                            </tr>
                            <tr>
                                <td class="p-1">Jumlah Pengumuman</td>
                                <td class="p-1">:</td>
                                <td class="p-1"><?= $totpengumuman ?></td>
                            </tr>
                            <tr>
                                <?php if ($foto) {
                                    $foto = $foto['foto_id'];
                                } else {
                                    $foto = 0;
                                } ?>
                                <td class="p-1">Jumlah Foto</td>
                                <td class="p-1">:</td>
                                <td class="p-1"><?= $foto ?></td>
                            </tr>
                            <tr>
                                <?php if ($video) {
                                    $video = $video['video_id'];
                                } else {
                                    $video = 0;
                                } ?>
                                <td class="p-1">Jumlah Video</td>
                                <td class="p-1">:</td>
                                <td class="p-1"><?= $video ?></td>
                            </tr>
                            <tr>
                                <?php if ($ebook) {
                                    $ebook = $ebook['ebook_id'];
                                } else {
                                    $ebook = 0;
                                } ?>
                                <td class="p-1">Jumlah E-Book</td>
                                <td class="p-1">:</td>
                                <td class="p-1"><?= $ebook ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer p-1">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="ion-close"></i> Tutup</button>
            </div>
            <?php echo form_close() ?>

        </div>

    </div>

</div>