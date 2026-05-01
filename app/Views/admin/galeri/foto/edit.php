<link href="<?= base_url() ?>/public/template/temp-backend/assets/css/bootstrap-datepicker.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?= base_url() ?>/public/template/temp-backend/assets/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?= base_url() ?>/public/template/temp-backend/assets/js/date-picker.js"></script>

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

            <?= form_open_multipart('', ['class' => 'formedit']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <input type="hidden" class="form-control" id="kategorifoto_id" value="<?= $kategorifoto_id ?>" name="kategorifoto_id" readonly>
                <div class="form-group">
                    <label>Kategori</label>
                    <input type="text" class="form-control" id="nama_kategori_foto" value="<?= $nama_kategori_foto ?>" name="nama_kategori_foto">
                    <div class="invalid-feedback errorNamakategori"></div>

                </div>
                <div class="form-group">
                    <label>
                        Deskripsi
                    </label>
                    <textarea type="text" rows="3" id="ket" name="ket" class="form-control"><?= esc($ket) ?></textarea>

                </div>

                <div class="form-group ">

                    <label> Tanggal Album </label>

                    <input type="text" id="tgl_album" name="tgl_album" value="<?= shortdate_indo($tgl_album) ?>" class="form-control date-picker">
                    <div class="invalid-feedback errortgl_album"></div>

                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btnupdate"><i class="mdi mdi-content-save-all"></i> Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="ion-close"></i> Batal</button>
            </div>

            <?= form_close() ?>
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
                url: '<?= site_url('foto/updatekategori') ?>',
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

                        if (response.error.nama_kategori_foto) {
                            $('#nama_kategori_foto').addClass('is-invalid');
                            $('.errorNamakategori').html(response.error.nama_kategori_foto);
                        } else {
                            $('#nama_kategori_foto').removeClass('is-invalid');
                            $('.errorNamakategori').html('');
                        }

                        if (response.error.tgl_album) {
                            $('#tgl_album').addClass('is-invalid');
                            $('.errortgl_album').html(response.error.tgl_album);
                        } else {
                            $('#tgl_album').removeClass('is-invalid');
                            $('.errortgl_album').html('');
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
                        listkategorifoto();
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