<div class="modal fade" id="modaltambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="card-header mt-0">
                <h6 class="modal-title m-0">Tambah Data
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h6>
            </div>
            <?= form_open('berita/simpantag', ['class' => 'formtambah']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">

                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Tag</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="nama_tag" name="nama_tag">
                        <div class="invalid-feedback errorNamatag">

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btnsimpan"><i class="mdi mdi-content-save-all"></i> Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="ion-close"></i> Tutup</button>
            </div>

            <?= form_close() ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.formtambah').submit(function(e) {
            e.preventDefault();
            let title = $('input#nama_tag').val()
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: {
                    [csrfToken]: csrfHash,
                    nama_tag: $('input#nama_tag').val(),
                    slug_tag: title.replace(/[^a-z0-9]/gi, '-').replace(/-+/g, '-').replace(/^-|-$/g, '')
                },
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


                        if (response.error.nama_tag) {
                            $('#nama_tag').addClass('is-invalid');
                            $('.errorNamatag').html(response.error.nama_tag);
                        } else {
                            $('#nama_tag').removeClass('is-invalid');
                            $('.errorNamatag').html('');
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
                        $('#modaltambah').modal('hide');
                        listtag();
                    }
                },
                error: function(xhr, ajaxOptions, thrownerror) {

                    toastr["error"]("Maaf gagal proses Kode Error:  " + (xhr.status + "\n"), );
                    $('#modaltambah').modal('hide');

                }
            });
        })
    });
</script>