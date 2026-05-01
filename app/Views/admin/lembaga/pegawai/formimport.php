<div class="modal fade" id="modalimport">
    <div class="modal-dialog modal-dialog-centered " role="document">
        <div class="modal-content">
            <div class="card-header mt-0">
                <h6 class="modal-title m-0"><?= $title  ?>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h6>
            </div>

            <div class="modal-body">
                <?= form_open_multipart('', ['class' => 'formimport']) ?>
                <?= csrf_field(); ?>

                <div class="form-group">
                    <label>
                        Pilih File Excel :
                    </label>
                    <input type="file" name="fileexcel" class="form-control" id="fileexcel" required accept=".xls, .xlsx" /></p>

                    <small>#. Pengisian data dimulai dari baris kedua (lihat contoh di format excel).
                        <br> #. Untuk Format excelnya dapat diunduh <a target='_BLANK' href="<?= base_url('public/file/Format Data Pegawai.xlsx') ?>"><i class="far fa-file-excel text-success"></i><label class="text-info"></label> Disini</a>
                    </small>
                </div>

            </div>


            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btnsimpan"><i class=" fas fa-sync-alt"></i> Proses Impord</button>

                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="ion-close"></i> Batal</button>
            </div>
            <?php echo form_close() ?>

        </div>

    </div>

</div>

<script>
    $('.btnsimpan').click(function(e) {
        e.preventDefault();
        let form = $('.formimport')[0];
        let data = new FormData(form);
        $.ajax({
            type: "post",
            url: '<?= site_url('pegawai/prosesExcel') ?>',
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
                $('.btnsimpan').html('<i class="mdi mdi-content-save-all"></i>  Proses Import');
            },
            success: function(response) {
                if (response.error) {

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
                        toastr["error"](response.gagal)
                    $('#modalimport').modal('hide');
                } else if (response.kosong) {
                    toastr["error"](response.kosong)

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
                    $('#modalimport').modal('hide');
                    listpegawai();
                }
            },
            error: function(xhr, ajaxOptions, thrownerror) {
                toastr["error"]("Maaf gagal proses Kode Error:  " + (xhr.status + "\n"), );
                $('#modalimport').modal('hide');
            }
        });
    });
</script>