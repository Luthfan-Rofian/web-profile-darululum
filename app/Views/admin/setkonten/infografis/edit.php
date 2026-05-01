<div class="modal fade" id="modaledit">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="card-header mt-0">
                <h6 class="modal-title m-0"><?= $title  ?>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h6>
            </div>

            <?= form_open_multipart('', ['class' => 'formfoto']) ?>
            <?= csrf_field(); ?>

            <div class="modal-body">

                <input type="hidden" value="<?= $id_banner ?>" name="id_banner">

                <div class="form-group">
                    <label> <i class="mdi mdi-text-shadow"></i>
                        Keterangan
                    </label>
                    <input type="text" id="ket" name="ket" value="<?= $ket ?>" class="form-control">
                    <div class="invalid-feedback errorKeterangan"></div>
                </div>
                <div class="form-group">
                    <label> <i class="mdi mdi-file-image"></i>
                        Ganti Gambar
                    </label>
                    <input type="file" class="form-control" id="banner_image" name="banner_image">
                    <div class="invalid-feedback errorFoto"></div>
                    <a class="text-info">
                        <code>Ukuran ideal 1200 X 720px </code>
                    </a>
                </div>

                <div class="form-group">
                    <label> <i class="mdi mdi-image"></i>
                        Gambar Infografis
                    </label>
                    <img id='img_load' width='100%' src='<?= base_url('public/img/informasi/infografis/' . $banner) ?>'>

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
    function bacaGambar(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#img_load').attr('src', e.target.result)
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $('#banner_image').change(function() {
        bacaGambar(this);
    });

    $(document).ready(function() {
        $('.btnupload').click(function(e) {
            e.preventDefault();
            let form = $('.formfoto')[0];
            let data = new FormData(form);
            $.ajax({
                type: "post",
                url: '<?= site_url('infografis/updateinfografis') ?>',
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
                        if (response.error.ket) {
                            $('#ket').addClass('is-invalid');
                            $('.errorKeterangan').html(response.error.ket);
                        } else {
                            $('#ket').removeClass('is-invalid');
                            $('.errorKeterangan').html('');
                        }

                        if (response.error.banner_image) {
                            $('#banner_image').addClass('is-invalid');
                            $('.errorFoto').html(response.error.banner_image);
                        } else {
                            $('#banner_image').removeClass('is-invalid');
                            $('.errorFoto').html('');
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
                        listinfografis();
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