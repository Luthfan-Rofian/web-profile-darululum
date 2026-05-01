<div class="modal fade" id="modalview">
    <div class="modal-dialog modal-lg box-shadow modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header p-2">
                <h5 class="modal-title" id="exampleModalLabel"><?= $title  ?></h5>
                <button type="button" class="btn btn-sm btn-danger float-right btn-modal-close" data-bs-dismiss="modal" aria-label="Close"><span>X</span></button>

                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <img id='img_load' width='100%' src='<?= base_url('public/img/informasi/layanan/' . $gambar) ?>'>
                    <img width='100%' src='<?= ('https://dinaspendidikan.surakarta.go.id/web/public/img/informasi/layanan/' . $gambar) ?>'>
                </div>
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
                                    <td colspan="2" class="text-center"><a href="<?= ('https://dinaspendidikan.surakarta.go.id/web/public/unduh/layanan/'  . $fileunduh) ?>" target="_blank"><button class="btn btn-success btn-sm"><i class="fas fa-download"></i> Unduh File</button></a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>