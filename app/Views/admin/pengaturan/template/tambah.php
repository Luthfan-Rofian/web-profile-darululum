<!-- Modal -->
<div class="modal fade" id="modaltambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="card-header mt-0">
                <h6 class="modal-title m-0"><?= $title ?>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h6>
            </div>
            <?= form_open_multipart('', ['class' => 'formtambah']) ?>

            <?= csrf_field(); ?>
            <div class="modal-body">


                <div class="form-group">
                    <label> <i class="mdi mdi-text-shadow"></i>
                        Nama Template
                    </label>
                    <input type="text" class="form-control" id="nama" name="nama">
                    <div class="invalid-feedback errornama"></div>
                </div>

                <div class="form-group">
                    <label> <i class="fas fa-donate"></i>
                        Harga
                    </label>
                    <input type="text" class="form-control" id="pembuat" name="pembuat">
                    <div class="invalid-feedback errorpembuat"></div>
                </div>
                <div class="form-group">
                    <label> <i class="ion-ios7-settings-strong"></i>
                        Keterangan
                    </label>
                    <input type="text" class="form-control" id="ket" name="ket">
                    <div class="invalid-feedback errorket"></div>
                </div>

                <div class="form-group">
                    <label> <i class="far fa-folder"></i>
                        Folder
                    </label>
                    <input type="text" class="form-control" id="folder" name="folder" placeholder="Isi dengan nama folder yang sama dengan di Public dan Views">
                    <div class="invalid-feedback errorfolder"></div>
                    <!-- <small> <strong class="text-warning"><i> Pastikan nama folder di public dan views sama..!</i></strong></small> -->

                </div>
                <div class="form-group ">
                    <label>Foto Template</label>

                    <input type="file" class="form-control form-control-sm" id="img" name="img">
                    <div class="invalid-feedback errorimg"></div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btnsimpan"><i class="mdi mdi-content-save-all"></i> Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="ion-close"></i> Tutup</button>
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
                url: '<?= site_url('template/simpantemplate') ?>',
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


                        if (response.error.nama) {
                            $('#nama').addClass('is-invalid');
                            $('.errornama').html(response.error.nama);
                        } else {
                            $('#nama').removeClass('is-invalid');
                            $('.errornama').html('');
                        }

                        if (response.error.pembuat) {
                            $('#pembuat').addClass('is-invalid');
                            $('.errorpembuat').html(response.error.pembuat);
                        } else {
                            $('#pembuat').removeClass('is-invalid');
                            $('.errorpembuat').html('');
                        }

                        if (response.error.folder) {
                            $('#folder').addClass('is-invalid');
                            $('.errorfolder').html(response.error.folder);
                        } else {
                            $('#folder').removeClass('is-invalid');
                            $('.errorfolder').html('');
                        }
                        if (response.error.img) {
                            $('#img').addClass('is-invalid');
                            $('.errorimg').html(response.error.img);
                        } else {
                            $('#img').removeClass('is-invalid');
                            $('.errorimg').html('');
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
                        listtemplate();
                    }
                },
                error: function(xhr, ajaxOptions, thrownerror) {

                    toastr["error"]("Maaf gagal proses Kode Error:  " + (xhr.status + "\n"), )
                    $('#modaltambah').modal('hide');

                }
            });
        });
    });
</script>