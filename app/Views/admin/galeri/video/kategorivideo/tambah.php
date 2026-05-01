<!-- Modal -->
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
            <?= form_open('video/simpankategori', ['class' => 'formtambah']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">

                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Kategori</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="nama_kategori_video" name="nama_kategori_video">
                        <div class="invalid-feedback errorNamakategori">

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
            let title = $('input#nama_kategori_video').val()
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: {
                    [csrfToken]: csrfHash,
                    nama_kategori_video: $('input#nama_kategori_video').val(),
                    slug_kategori_video: title.replace(/[^a-z0-9]/gi, '-').replace(/-+/g, '-').replace(/^-|-$/g, '')
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


                        if (response.error.nama_kategori_video) {
                            $('#nama_kategori_video').addClass('is-invalid');
                            $('.errorNamakategori').html(response.error.nama_kategori_video);
                        } else {
                            $('#nama_kategori_video').removeClass('is-invalid');
                            $('.errorNamakategori').html('');
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
                        listkategorivideo();
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