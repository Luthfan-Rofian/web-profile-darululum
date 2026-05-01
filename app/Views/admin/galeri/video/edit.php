<div class="modal fade" id="modaledit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="card-header mt-0">
                <h6 class="modal-title m-0"><?= $title  ?>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h6>
            </div>
            <?= form_open_multipart('', ['class' => 'formvideo']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <input type="hidden" value="<?= $video_id ?>" name="video_id">
                <div class="form-group">
                    <label> <i class="mdi mdi-text-shadow"></i>
                        Judul Video
                    </label>
                    <input type="text" id="judul" name="judul" value="<?= $judul ?>" class="form-control">
                    <div class="invalid-feedback errorjudul"></div>
                </div>
                <div class="form-group">
                    <label> <i class="mdi mdi-image-filter"></i>
                        Kategori Video
                    </label>
                    <select class="form-control" name="kategorivideo_id" id="kategorivideo_id">
                        <option Disabled=true Selected=true>-- Pilih Kategori --</option>
                        <?php foreach ($kategorivideo as $key => $value) { ?>
                            <option value="<?= $value['kategorivideo_id'] ?>" <?= $kategorivideo_id ==  $value['kategorivideo_id'] ? 'selected' : '' ?>><?= $value['nama_kategori_video'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label> <i class="ion-ios7-settings-strong"></i>
                        Deskripsi
                    </label>
                    <textarea type="text" rows="2" id="ket_video" name="ket_video" class="form-control"><?= esc($ket_video) ?></textarea>

                </div>
                <div class="form-group">
                    <label> <i class="mdi mdi-text-shadow"></i>
                        Link Youtube
                    </label>
                    <input type="text" id="video_link" name="video_link" value="<?= $video_link ?>" class="form-control">
                    <div class="invalid-feedback errorvideo_link"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btnupload"><i class="mdi mdi-content-save-all"></i> Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="ion-close"></i> Batal</button>
            </div>
            <?php echo form_close() ?>

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.btnupload').click(function(e) {
            e.preventDefault();
            let form = $('.formvideo')[0];
            let data = new FormData(form);
            $.ajax({
                type: "post",
                url: '<?= site_url('video/updatevideo') ?>',
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
                    $('.btnupload').html('<i class="mdi mdi-content-save-all"></i> Simpan');
                },
                success: function(response) {
                    if (response.error) {
                        if (response.error.judul) {
                            $('#judul').addClass('is-invalid');
                            $('.errorjudul').html(response.error.judul);
                        } else {
                            $('#judul').removeClass('is-invalid');
                            $('.errorjudul').html('');
                        }

                        if (response.error.video_link) {
                            $('#video_link').addClass('is-invalid');
                            $('.errorvideo_link').html(response.error.video_link);
                        } else {
                            $('#video_link').removeClass('is-invalid');
                            $('.errorvideo_link').html('');
                        }


                    } else {
                        toastr.options = {
                                "closeButton": true,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": true,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            },
                            toastr["success"](response.sukses)
                        $('#modaledit').modal('hide');
                        listvideo();
                    }
                },
                error: function(xhr, ajaxOptions, thrownerror) {
                    toastr["error"]("Maaf gagal proses Kode Error:  " + (xhr.status + "\n"), );
                    $('#modaledit').modal('hide');
                }
            });
        });
    });
</script>