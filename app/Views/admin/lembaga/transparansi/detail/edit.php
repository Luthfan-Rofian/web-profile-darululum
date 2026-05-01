<div class="modal fade" id="modaledit">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
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
                <input type="hidden" value="<?= $transparandetail_id ?>" name="transparandetail_id">


                <div class="form-group">
                    <label>Judul Item</label>

                    <input type="text" id="transparan_nama" name="transparan_nama" value="<?= $transparan_nama ?>" class="form-control">
                    <div class="invalid-feedback errortransparan_nama"></div>
                </div>

                <div class="form-group">
                    <label>Jumlah Item <small class="text-danger">*Nilai Asli dikonversi ke ribuan</small></label>


                    <input type="number" id="transparan_jumlah" name="transparan_jumlah" value="<?= $transparan_jumlah ?>" class="form-control">
                    <div class="invalid-feedback errortransparan_jumlah"></div>
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
                url: '<?= site_url('transparansi/updatedetail') ?>',
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

                        if (response.error.transparan_nama) {
                            $('#transparan_nama').addClass('is-invalid');
                            $('.errortransparan_nama').html(response.error.transparan_nama);
                        } else {
                            $('#transparan_nama').removeClass('is-invalid');
                            $('.errortransparan_nama').html('');
                        }

                        if (response.error.transparan_jumlah) {
                            $('#transparan_jumlah').addClass('is-invalid');
                            $('.errortransparan_jumlah').html(response.error.transparan_jumlah);
                        } else {
                            $('#transparan_jumlah').removeClass('is-invalid');
                            $('.errortransparan_jumlah').html('');
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
                        listdetailtransparansi();
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