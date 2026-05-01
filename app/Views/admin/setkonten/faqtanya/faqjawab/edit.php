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
                <input type="hidden" value="<?= $faq_jawabid ?>" name="faq_jawabid">


                <div class="form-group">
                    <label> <i class="mdi mdi-text-shadow"></i>
                        Jawaban
                    </label>
                    <textarea type="text" class="form-control" id="faq_jawaban" name="faq_jawaban"> <?= esc($faq_jawaban) ?></textarea>
                    <!-- <input type="text" id="faq_jawaban" name="faq_jawaban" value="<?= $faq_jawaban ?>" class="form-control"> -->
                    <div class="invalid-feedback errorfaq_jawaban"></div>
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

        $('textarea#faq_jawaban').summernote({
            height: 250,
            minHeight: null,
            maxHeight: null,
            focus: true
        });

        $('.btnupdate').click(function(e) {
            e.preventDefault();
            let form = $('.formedit')[0];
            let data = new FormData(form);
            $.ajax({
                type: "post",
                url: '<?= site_url('tanyajawab/updatejawaban') ?>',
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

                        if (response.error.faq_jawaban) {
                            $('#faq_jawaban').addClass('is-invalid');
                            $('.errorfaq_jawaban').html(response.error.faq_jawaban);
                        } else {
                            $('#faq_jawaban').removeClass('is-invalid');
                            $('.errorfaq_jawaban').html('');
                        }

                        if (response.error.nilai) {
                            $('#nilai').addClass('is-invalid');
                            $('.errornilai').html(response.error.nilai);
                        } else {
                            $('#nilai').removeClass('is-invalid');
                            $('.errornilai').html('');
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
                        listjawaban();
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