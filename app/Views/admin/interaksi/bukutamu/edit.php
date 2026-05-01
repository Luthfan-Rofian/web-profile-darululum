<div class="modal fade" id="modaledit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="card-header mt-0">
                <h6 class="modal-title m-0">Pesan dari <?= $nama  ?>

                </h6>
            </div>
            <?= form_open_multipart('', ['class' => 'formvbt']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <input type="hidden" value="<?= $bukutamu_id ?>" name="bukutamu_id">
                <input type="hidden" value="<?= $status ?>" name="status">
                <div class="row">
                    <div class="form-group col-md-6 col-12">
                        <label> <i class="mdi mdi-account"></i>
                            Nama
                        </label>
                        <input type="text" id="nama" name="nama" value="<?= $nama ?>" class="form-control" readonly>

                    </div>
                    <div class="form-group col-md-6 col-12">
                        <label> <i class="fas fa-tty"></i>
                            Telp/Hp
                        </label>
                        <input type="text" id="telp" name="telp" value="<?= $telp ?>" class=" form-control" readonly>

                    </div>
                </div>

                <!-- <div class="row"> -->
                <div class="form-group ">
                    <label> <i class="mdi mdi-account"></i>
                        Instansi
                    </label>
                    <input type="text" id="instansi" name="instansi" value="<?= $instansi ?>" class="form-control" readonly>

                </div>
                <div class="form-group">
                    <label> <i class="fas fa-tty"></i>
                        Bidang
                    </label>
                    <input type="text" id="bidang" name="bidang" value="<?= $bidang ?>" class=" form-control" readonly>

                </div>
                <!-- </div> -->

                <div class="form-group">
                    <label> <i class="mdi mdi-message-processing"></i>
                        Keperluan
                    </label>
                    <textarea type="text" class="form-control bg-light" id="keperluan" name="keperluan" readonly><?= $keperluan ?></textarea>

                </div>

                <div class="modal-footer p-0">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="ion-close"></i> Tutup</button>

                </div>
                <?php echo form_close() ?>

            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            $('.btnupload').click(function(e) {
                e.preventDefault();
                let form = $('.formvbt')[0];
                let data = new FormData(form);
                $.ajax({
                    type: "post",
                    url: '<?= site_url('bukutamu/updatestatus') ?>',
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
                        $('.btnupload').html('<i class="fas fa-paper-plane"></i> Kirim Balasan');
                    },
                    success: function(response) {
                        if (response.error) {

                            if (response.error.balas) {
                                $('#balas').addClass('is-invalid');
                                $('.errorbalas').html(response.error.balas);
                            } else {
                                $('#balas').removeClass('is-invalid');
                                $('.errorbalas').html('');
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
                            listbukutamu();
                            // listkritiksaran2();
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