<!-- Modal -->
<div class="modal fade" id="modaledit" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="card-header mt-0">
                <h6 class="modal-title m-0">Edit Data
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h6>
            </div>
            <?= form_open('', ['class' => 'formedit']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <input type="hidden" class="form-control" id="id_modpublic" value="<?= $id_modpublic ?>" name="id_modpublic" readonly>
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Modul</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="modpublic" value="<?= $modpublic ?>" name="modpublic">
                        <div class="invalid-feedback errormodpublic"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Link</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="link" value="<?= $link ?>" name="link">
                        <div class="invalid-feedback errorlink"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btnsimpan"><i class="mdi mdi-content-save-all"></i> Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="ion-close"></i> Batal</button>
            </div>

            <?= form_close() ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.btnsimpan').click(function(e) {
            e.preventDefault();
            let form = $('.formedit')[0];
            let data = new FormData(form);
            $.ajax({
                type: "post",
                url: '<?= site_url('modul/updatepublik') ?>',
                data: data,
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,
                dataType: "json",
                beforeSend: function() {
                    $('.btnsimpan').attr('disable', 'disable');
                    $('.btnsimpan').html('<span class="spinner-border spinner-grow-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>');
                },
                complete: function() {
                    $('.btnsimpan').removeAttr('disable', 'disable');
                    $('.btnsimpan').html('<i class="mdi mdi-content-save-all"></i>  Simpan');
                },
                success: function(response) {
                    if (response.error) {

                        if (response.error.modpublic) {
                            $('#modpublic').addClass('is-invalid');
                            $('.errormodpublic').html(response.error.modpublic);
                        } else {
                            $('#modpublic').removeClass('is-invalid');
                            $('.errormodpublic').html('');
                        }

                        if (response.error.link) {
                            $('#link').addClass('is-invalid');
                            $('.errorlink').html(response.error.link);
                        } else {
                            $('#link').removeClass('is-invalid');
                            $('.errorlink').html('');
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
                        listpublik();
                    }
                },
                error: function(xhr, ajaxOptions, thrownerror) {

                    toastr["error"]("Maaf gagal proses Kode Error:  " + (xhr.status + "\n"), )
                    $('#modaledit').modal('hide');

                }
            });
        });
    });
</script>