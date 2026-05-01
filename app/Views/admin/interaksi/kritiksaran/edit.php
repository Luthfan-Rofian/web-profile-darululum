<div class="modal fade" id="modaledit">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="card-header mt-0">
                <h6 class="modal-title m-0">Pesan dari <?= $nama  ?>

                </h6>
            </div>
            <?= form_open_multipart('', ['class' => 'formkritiksaran']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <input type="hidden" value="<?= $kritiksaran_id ?>" name="kritiksaran_id">
                <input type="hidden" value="<?= $status ?>" name="status">
                <div class="row">
                    <div class="form-group col-md-6 col-12">
                        <label> <i class="mdi mdi-account"></i>
                            Nama
                        </label>
                        <input type="text" id="nama" name="nama" value="<?= $nama ?>" class="form-control" readonly>

                    </div>
                    <div class="form-group col-md-6 col-12">
                        <label> <i class="mdi mdi-email-variant"></i>
                            Email
                        </label>
                        <input type="text" id="email" name="email" value="<?= $email ?>" class=" form-control" readonly>

                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6 col-12">
                        <label> <i class="mdi mdi-account"></i>
                            Topik
                        </label>
                        <input type="text" id="judul" name="judul" value="<?= $judul ?>" class="form-control" readonly>

                    </div>
                    <div class="form-group col-md-6 col-12">
                        <label> <i class="fas fa-tty"></i>
                            No HP
                        </label>
                        <input type="text" id="nohp_usr" name="nohp_usr" value="<?= $no_hpusr ?>" class=" form-control" readonly>

                    </div>
                </div>

                <div class="form-group">
                    <label> <i class="mdi mdi-message-processing"></i>
                        Isi Kritik / Saran
                    </label>
                    <textarea type="text" class="form-control bg-light" id="isi_kritik" name="isi_kritik" readonly><?= $isi_kritik ?></textarea>

                </div>

                <div class="form-group">
                    <label> <i class="far fa-comments text-primary"></i>
                        Balas Kritik / Saran
                    </label>
                    <textarea type="text" class="form-control" id="balas" name="balas"><?= $balas ?></textarea>
                    <div class="invalid-feedback errorbalas"></div>

                    <code><a class="text-secondary"> Format default ke email user:</a><a class="text-danger"> Terima Kasih telah menghubungi kami..! </a><a class="text-secondary">Selanjutnya silahkan isi balasan diatas.</a></code>

                </div>

                <div class="modal-footer p-0">
                    <?php if ($akses == 1) { ?>
                        <div class="float-right">
                            <button class="btn btn-primary btnupload"><i class="fas fa-paper-plane"></i> Kirim Balasan</button>
                        </div>
                    <?php } ?>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="ion-close"></i> Tutup</button>

                </div>
                <?php echo form_close() ?>

            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            $('textarea#balas').summernote({
                height: 200,
                minHeight: null,
                maxHeight: null,
                focus: true
            });


            $('.btnupload').click(function(e) {
                e.preventDefault();
                let form = $('.formkritiksaran')[0];
                let data = new FormData(form);
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
                    $.ajax({
                        type: "post",
                        url: '<?= site_url('kritiksaran/updatestatus') ?>',
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

                            if (response.noakses) {
                                toastr["error"](response.noakses)
                                Swal.fire({
                                    title: "Gagal Akses!",
                                    html: `Anda tidak berhak mengakses <strong>Modul ini</strong> `,
                                    icon: "error",
                                    showConfirmButton: false,
                                    timer: 3100
                                }).then(function() {
                                    window.location = '../';
                                })
                            }

                            if (response.blmakses) {

                                Swal.fire({
                                    title: "Maaf gagal load Modul!",
                                    html: `Modul ini belum atau tidak didaftarkan `,
                                    icon: "error",
                                    showConfirmButton: false,
                                    timer: 3100
                                }).then(function() {
                                    window.location = '../admin';
                                })
                            }

                            if (response.error) {

                                if (response.error.balas) {
                                    $('#balas').addClass('is-invalid');
                                    $('.errorbalas').html(response.error.balas);
                                } else {
                                    $('#balas').removeClass('is-invalid');
                                    $('.errorbalas').html('');
                                }

                            } else {

                                toastr["success"](response.sukses)

                                $('#modaledit').modal('hide');
                                listkritiksaran();
                                listkritiksaran2();
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