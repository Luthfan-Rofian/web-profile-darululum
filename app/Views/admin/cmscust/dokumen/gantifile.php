<div class="modal fade" id="modalupload" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="card-header mt-0">
                <h6 class="modal-title m-0"><?= $title ?>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h6>
            </div>
            <?= form_open_multipart('', ['class' => 'formupload']) ?>
            <?= csrf_field(); ?>
            <input type="hidden" value="<?= $id ?>" name="id_dokumenupl">
            <div class="modal-body">
                <div class="col-lg-12">
                     <div class="card m-b-10 text-white bg-primary">
                        <div class="card-body">
                            <blockquote class="card-blockquote mb-0">
                                PERHATIAN :
                                <footer class="blockquote-footer text-white font-12">
                                    File yang diupload Maksimal <cite title="Source Title">2096 KB </cite>

                                </footer>
                                <footer class="blockquote-footer text-white font-12">
                                    Format file : <cite title="Source Title">.jpg, .jpeg, .gif, .png, pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt</cite>
                                </footer>
                            </blockquote>

                        </div>

                    </div> -->
                    <div class="form-group">
                        <?php if ($file_dok != '') { ?>

                            <label> <i class="mdi mdi-cloud-upload"></i>
                                Ganti File
                            </label>
                        <?php } else { ?>
                            <label> <i class="mdi mdi-file"></i>
                                Upload File
                            </label>
                        <?php } ?>

                        <input type="file" id="file_dok" name="file_dok" class="form-control">
                        <div class="invalid-feedback errorfile_dok"></div>
                    </div>
                    <?php if ($file_dok != '') { ?>

                        <div class="form-group">
                            <label> <i class="mdi mdi-file-cloud"></i>
                                File saat ini :
                            </label>
                            <label><a target='_BLANK' href="<?= base_url('public/unduh/dokumen/'  . $file_dok) ?>"><?= $file_dok ?></a></label>
                        </div>

                    <?php } ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btnupload"><i class="mdi mdi-content-save-all"></i> Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="ion-close"></i> Batal</button>
            </div>

            <?= form_close() ?>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('.btnupload').click(function(e) {
            e.preventDefault();
            let form = $('.formupload')[0];
            let data = new FormData(form);

            $.ajax({
                type: "post",
                url: '<?= site_url('dokumen/douploaddokumen') ?>',
                data: data,
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,
                dataType: "json",
                beforeSend: function() {
                    $('.btnupload').attr('disable', 'disable');
                    $('.btnupload').html('<span class="spinner-border spinner-grow-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>');
                },
                complete: function() {
                    $('.btnupload').removeAttr('disable', 'disable');
                    $('.btnupload').html('<i class="mdi mdi-content-save-all"></i>  Simpan');
                },
                success: function(response) {
                    if (response.error) {
                        if (response.error.file_dok) {
                            $('#file_dok').addClass('is-invalid');
                            $('.errorfile_dok').html(response.error.file_dok);
                        }
                    } else {
                        Swal.fire({
                            title: "Berhasil!",
                            text: response.sukses,
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function() {
                            $('#modalupload').modal('hide');
                            listdokumen();
                            // window.location = '';
                        })
                    }
                },
                error: function(xhr, ajaxOptions, thrownerror) {
                    Swal.fire({
                        title: "Maaf gagal update file!",
                        html: `Silahkan Cek kembali Kode Error: <strong>${(xhr.status + "\n")}</strong> `,
                        icon: "error",
                        showConfirmButton: false,
                        timer: 3100
                    }).then(function() {
                        $('#modalupload').modal('hide');
                        window.location = '';
                    })
                }
            });

        });
    });
</script>