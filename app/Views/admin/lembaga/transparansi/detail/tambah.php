<!-- Modal -->
<div class="modal fade" id="modaltambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="card-header mt-0">
                <h6 class="modal-title m-0"><?= $title  ?>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h6>
            </div>

            <?= form_open_multipart('', ['class' => 'formtambah']) ?>
            <?= csrf_field(); ?>

            <div class="modal-body">


                <div class="form-group">
                    <label>Judul Item</label>
                    <input type="hidden" id="transparan_id" name="transparan_id" value="<?= $transparan_id ?>" class="form-control">

                    <input type="text" id="transparan_nama" name="transparan_nama" class="form-control">
                    <div class="invalid-feedback errortransparan_nama"></div>
                </div>

                <div class="form-group">
                    <label>Jumlah Item <small class="text-danger">*Nilai Asli dikonversi ke ribuan</small></label>

                    <input type="number" id="transparan_jumlah" name="transparan_jumlah" class="form-control">
                    <div class="invalid-feedback errortransparan_jumlah"></div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btnsimpan"><i class="fa fa-share-square"></i> Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"> Batal</button>
            </div>

            <?= form_close() ?>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {

        $('.btnsimpan').click(function(e) {
            e.preventDefault();
            let form = $('.formtambah')[0];
            let data = new FormData(form);
            $.ajax({
                type: "post",
                url: '<?= site_url('transparansi/simpanDetail') ?>',
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
                        $('#modaltambah').modal('hide');
                        listdetailtransparansi();
                    }
                },
                error: function(xhr, ajaxOptions, thrownerror) {
                    toastr["error"]("Maaf gagal proses Kode Error:  " + (xhr.status + "\n"), );
                    $('#modaltambah').modal('hide');
                }
            });
        });
    });
</script>