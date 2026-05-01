<link href="<?= base_url() ?>/public/template/temp-backend/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url() ?>/public/template/temp-backend/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<script src="<?= base_url() ?>/public/template/temp-backend/assets/pages/form-advanced.js"></script>

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
                <input type="hidden" class="form-control" id="id_counter" value="<?= $id_counter ?>" name="id_counter" readonly>
                <div class="row">
                    <div class="form-group col-md-6 col-12">
                        <label>Nama</label>
                        <input type="text" class="form-control form-control-sm" id="nm" name="nm" value="<?= $nm ?>">
                        <div class="invalid-feedback errornm"></div>
                    </div>
                    <div class="form-group col-md-3 col-12">
                        <label>Jumlah</label>
                        <input type="number" class="form-control form-control-sm" id="jm" name="jm" value="<?= $jm ?>">
                        <div class="invalid-feedback errorjm"></div>
                    </div>
                    <div class="form-group col-md-3 col-12">
                        <label>Warna</label>
                        <input type="text" class="colorpicker-default form-control form-control-sm" id="bgc" name="bgc" value="<?= $bgc ?>">

                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6 col-12">
                        <label>Sumber Data</label>
                        <input type="text" class="form-control form-control-sm" id="sumber" name="sumber" value="<?= $sumber ?>">
                        <div class="invalid-feedback errorsumber"></div>
                    </div>

                    <div class="form-group col-md-6 col-12">
                        <label>Link</label>
                        <input type="text" class="form-control form-control-sm" id="link" name="link" value="<?= $link ?>">

                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6 col-12">
                        <label>Icon</label>
                        <input type="text" class="form-control form-control-sm" id="ic" name="ic" value="<?= $ic ?>">
                    </div>
                    <div class="form-group col-md-6 col-12">
                        <label>Lihat Icon</label>
                        <div class="button-items">
                            <button type="button" class="btn btn-outline-secondary waves-effect waves-light btn-sm " data-toggle="modal" data-target=".fontawesome">Icon Font Awesome</button>
                        </div>
                    </div>
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
                url: '<?= site_url('counter/updatedata') ?>',
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

                        if (response.error.nm) {
                            $('#nm').addClass('is-invalid');
                            $('.errornm').html(response.error.nm);
                        } else {
                            $('#nm').removeClass('is-invalid');
                            $('.errornm').html('');
                        }

                        if (response.error.jm) {
                            $('#jm').addClass('is-invalid');
                            $('.errorjm').html(response.error.jm);
                        } else {
                            $('#jm').removeClass('is-invalid');
                            $('.errorjm').html('');
                        }

                        if (response.error.ic) {
                            $('#ic').addClass('is-invalid');
                            $('.erroric').html(response.error.ic);
                        } else {
                            $('#ic').removeClass('is-invalid');
                            $('.erroric').html('');
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
                        listcount();
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