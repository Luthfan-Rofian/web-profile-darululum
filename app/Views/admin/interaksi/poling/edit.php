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
            <?= form_open('poling/updatepoling', ['class' => 'formedit']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <input type="hidden" class="form-control" id="poling_id" value="<?= $poling_id ?>" name="poling_id">


                <div class="form-group">
                    <?php if ($jenis == "Jawaban") { ?>
                        <label> <i class="mdi mdi-check-circle-outline"></i>
                            Jawaban
                        </label>
                    <?php } else { ?>
                        <label> <i class="mdi mdi-text-shadow"></i>
                            Pertanyaan
                        </label>
                    <?php    } ?>
                    <input type="text" id="pilihan" name="pilihan" value="<?= $pilihan ?>" class="form-control">
                    <div class="invalid-feedback errorpilihan"></div>
                </div>


                <div class="form-group">
                    <?php if ($jenis == "Jawaban") { ?>
                        <label> <i class="mdi mdi-check-circle-outline"></i>
                            Jumlah Rating
                        </label>
                        <input type="number" id="rating" name="rating" value="<?= $rating ?>" class="form-control">

                    <?php } ?>

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
                url: '<?= site_url('poling/updatepoling') ?>',
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


                        if (response.error.errorpilihan) {
                            $('#errorpilihan').addClass('is-invalid');
                            $('.errorpilihan').html(response.error.errorpilihan);
                        } else {
                            $('#errorpilihan').removeClass('is-invalid');
                            $('.errorpilihan').html('');
                        }

                        // if ($jenis == "Jawaban") {
                        //     if (response.error.errorrating) {
                        //         $('#errorrating').addClass('is-invalid');
                        //         $('.errorrating').html(response.error.errorrating);
                        //     } else {
                        //         $('#errorrating').removeClass('is-invalid');
                        //         $('.errorrating').html('');
                        //     }
                        // }
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
                        listpoling();
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