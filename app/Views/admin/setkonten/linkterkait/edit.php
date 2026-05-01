<div class="modal fade" id="modaledit">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-lg">
            <div class="card-header mt-0">
                <h6 class="modal-title m-0"><?= $title  ?>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h6>
            </div>

            <?= form_open_multipart('', ['class' => 'formedit']) ?>
            <?= csrf_field(); ?>

            <div class="modal-body">
                <input type="hidden" value="<?= $id_link ?>" name="id_link">
                <div class="form-group">
                    <label>Nama Link</label>
                    <input type="text" class="form-control" id="nama_link" name="nama_link" value="<?= $nama_link ?>">
                    <div class=" invalid-feedback errornamalink">
                    </div>
                </div>
                <div class="form-group">
                    <label>Alamat URL</label>
                    <input type="url" class="form-control" id="url" name="url" value="<?= $url ?>">
                    <div class=" invalid-feedback errorurl">
                    </div>
                </div>
            </div>

            <div class="modal-footer">

                <button type="submit" class="btn btn-primary btnupdate"><i class="mdi mdi-content-save-all"></i> Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="ion-close"></i> Batal</button>
            </div>
            <?php echo form_close() ?>

        </div>

    </div>

</div>

<script>
    $(document).ready(function() {

        $('.btnupdate').click(function(e) {
            e.preventDefault();
            let form = $('.formedit')[0];
            let data = new FormData(form);
            $.ajax({
                type: "post",
                url: '<?= site_url('linkterkait/updatelinkterkait') ?>',
                data: data,
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,
                dataType: "json",
                beforeSend: function() {
                    $('.btnupdate').attr('disable', 'disable');
                    $('.btnupdate').html('<span class="spinner-border spinner-grow-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>');
                },
                complete: function() {
                    $('.btnupdate').removeAttr('disable', 'disable');
                    $('.btnupdate').html('<i class="mdi mdi-content-save-all"></i> Simpan');
                },
                success: function(response) {
                    if (response.error) {

                        if (response.error.nama_link) {
                            $('#nama_link').addClass('is-invalid');
                            $('.errornamalink').html(response.error.nama_link);
                        } else {
                            $('#nama_link').removeClass('is-invalid');
                            $('.errornamalink').html('');
                        }

                        if (response.error.url) {
                            $('#url').addClass('is-invalid');
                            $('.errorurl').html(response.error.url);
                        } else {
                            $('#url').removeClass('is-invalid');
                            $('.errorurl').html('');
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
                        listlinkterkait();
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