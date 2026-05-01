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
                <input type="hidden" value="<?= $foto_id ?>" name="foto_id">
                <div class="form-group">
                    <label> <i class="mdi mdi-text-shadow"></i>
                        Keterangan
                    </label>
                    <input type="text" id="judul" name="judul" value="<?= $judul ?>" class="form-control">
                    <div class="invalid-feedback errorjudul"></div>
                </div>
                <div class="form-group">
                    <label> <i class="mdi mdi-image-filter"></i>
                        Kategori Foto
                    </label>
                    <select class="form-control" name="kategorifoto_id" id="kategorifoto_id">
                        <option Disabled=true Selected=true>-- Pilih Kategori --</option>
                        <?php foreach ($kategorifoto as $key => $value) { ?>
                            <option value="<?= $value['kategorifoto_id'] ?>" <?= $kategorifoto_id ==  $value['kategorifoto_id'] ? 'selected' : '' ?>><?= $value['nama_kategori_foto'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label> <i class="mdi mdi-file-image"></i>
                        Ganti Gambar
                    </label>

                    <input type="file" class="form-control" id="gambar" name="gambar">

                    <div class="invalid-feedback errorgambar"></div>
                    <a class="text-danger">
                        <!-- <code>Ukuran ideal 1200 X 720px </code> -->
                    </a>

                </div>

                <div class="form-group">
                    <label> <i class="mdi mdi-image"></i>
                        Gambar
                    </label>
                    <img id='img_load' width='100%' src='<?= base_url('public/img/galeri/foto/' . $gambar) ?>'>

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
    $('#gambar').change(function() {
        bacaGambar(this);
    });

    $(document).ready(function() {
        $('.btnupload').click(function(e) {
            e.preventDefault();
            let form = $('.formfoto')[0];
            let data = new FormData(form);
            $.ajax({
                type: "post",
                url: '<?= site_url('foto/updatefoto') ?>',
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

                        if (response.error.kategorifoto_id) {
                            $('#kategorifoto_id').addClass('is-invalid');
                            $('.errorkategorifoto_id').html(response.error.kategorifoto_id);
                        } else {
                            $('#kategorifoto_id').removeClass('is-invalid');
                            $('.errorkategorifoto_id').html('');
                        }

                        if (response.error.gambar) {
                            $('#gambar').addClass('is-invalid');
                            $('.errorgambar').html(response.error.gambar);
                        } else {
                            $('#gambar').removeClass('is-invalid');
                            $('.errorgambar').html('');
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
                        listfoto();
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